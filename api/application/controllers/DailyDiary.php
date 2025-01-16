<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DailyDiary extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LoginModel');
		$this->load->model('DailyDiaryModel','ddm');
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
	}

	public function index()
	{		
	}

	public function getDailyDiary()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$userid = $json->userid;
				$userArr = $this->LoginModel->getUserFromId($json->userid);

				if(empty($json->centerid)) {
					$userCentersArr = $this->ddm->getUserCenters($userid);
					$centerid = $userCentersArr[0]->centerid;
				} else {
					$centerid = $json->centerid;
				}
				// print_r($json);
				// exit;
				if (empty($json->roomid)) {
					$getCenterRoomsArr = $this->ddm->getRooms($centerid);
					$roomid = empty($getCenterRoomsArr[0]->id)?NULL:$getCenterRoomsArr[0]->id;
					$roomname = empty($getCenterRoomsArr[0]->name)?NULL:$getCenterRoomsArr[0]->name;
					$roomcolor = empty($getCenterRoomsArr[0]->color)?NULL:$getCenterRoomsArr[0]->color;
					// print_r($getCenterRoomsArr);
					//  exit;
				} else {
					$roomid = $json->roomid;
					$getRoom = $this->ddm->getRooms(NULL,$roomid);
					$roomname = $getRoom[0]->name;
					$roomcolor = $getRoom[0]->color;
					$getCenterRoomsArr = $this->ddm->getRooms($centerid);
					// print_r($getCenterRoomsArr);
					//  exit;
				}

				if (empty($json->date)) {
					$date = date("Y-m-d");
				} else {
					$date = date("Y-m-d",strtotime($json->date));
				}
				$data['Status'] = "SUCCESS";
				$data['centerid'] = $centerid;
				$data['date'] = $date;
				$data['roomid'] = $roomid;
				$data['roomname'] = $roomname;
				$data['roomcolor'] = $roomcolor;
				$data['rooms'] = $getCenterRoomsArr;
				if ($userArr->userType == "Parent") {
					$childsArr = $this->ddm->getChildsFromRoomOfParent($roomid,$userid);
				} else {
					$childsArr = $this->ddm->getChildsFromRoom($roomid);
				}				
				
				// get column details from db daily diary settings

				$getSettings = $this->ddm->getCenterDDSettings($centerid);
				if(empty($getSettings)){
					$getSettings->breakfast = 1;
					$getSettings->morningtea = 1;
					$getSettings->lunch = 1;
					$getSettings->sleep = 1;
					$getSettings->afternoontea = 1;
					$getSettings->latesnacks = 1;
					$getSettings->sunscreen = 1;
					$getSettings->toileting = 1;
				}
				$data['childs'] = $childsArr;
				foreach ($childsArr as $child => $cobj) {
					$childId = $cobj->id;
					if ($getSettings->breakfast == 1) {
						$bfObj = $this->ddm->getBreakfast($childId,$date);
						$cobj->breakfast = $bfObj;
					}
					
					if ($getSettings->morningtea == 1) {
						$mtObj = $this->ddm->getMorningTea($childId,$date);
						$cobj->morningtea = $mtObj;
					}

					if ($getSettings->lunch == 1) {
						$lnObj = $this->ddm->getLunch($childId,$date);
						$cobj->lunch = $lnObj;
					}
					if ($getSettings->sleep == 1) {
						$slObj = $this->ddm->getSleep($childId,$date);
						$cobj->sleep = $slObj;
					}
					if ($getSettings->afternoontea == 1) {
						$atObj = $this->ddm->getAfternoonTea($childId,$date);
						$cobj->afternoontea = $atObj;
					}
					if ($getSettings->latesnacks == 1) {
						$snObj = $this->ddm->getSnacks($childId,$date);
						$cobj->snacks = $snObj;
					}
					if ($getSettings->sunscreen == 1) {
						$ssObj = $this->ddm->getSunscreen($childId,$date);
						$cobj->sunscreen = $ssObj;
					}
					if ($getSettings->toileting == 1) {
						$ttObj = $this->ddm->getToileting($childId,$date);
						$cobj->toileting = $ttObj;
					}
				}

				$data['columns'] = $getSettings;
				
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = 'Userid doesn\'t match';
			}
		}else{
			$data['Status'] =  'ERROR';
			$data['Message'] = 'Invalid headers sent.';
		}
		echo json_encode($data);
	}

	public function getItems()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json!= null && $res != null && $res->userid == $json->userid){

					$search = isset($json->searchTerm) ? $json->searchTerm : null;
					$type = isset($json->type) ? $json->type : null;

					if (strtoupper($type)=="BREAKFAST") {
						$table = "dailydiarybreakfast";
					} elseif (strtoupper($type)=="MORNINGTEA") {
						$table = "dailydiarymorningtea";
					} elseif (strtoupper($type)=="LUNCH") {
						$table = "dailydiarylunch";
					} elseif (strtoupper($type)=="AFTERNOONTEA") {
						$table = "dailydiaryafternoontea";
					} else{
						$table = "dailydiarysnacks";
					}

					
					$data['items'] = $this->ddm->getItems($search,$type);
					
					http_response_code(200);
					$data['Status'] = "SUCCESS";
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid user!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Request Method";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function addFoodRecord()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json!= null && $res != null && $res->userid == $json->userid){
					if (strtoupper($json->type)=="BREAKFAST") {
						$table = "dailydiarybreakfast";
					} elseif (strtoupper($json->type)=="MORNINGTEA") {
						$table = "dailydiarymorningtea";
					} elseif (strtoupper($json->type)=="LUNCH") {
						$table = "dailydiarylunch";
					} elseif (strtoupper($json->type)=="AFTERNOONTEA") {
						$table = "dailydiaryafternoontea";
					} else if(strtoupper($json->type)=="SNACKS") {
						$table = "dailydiarysnacks";
					}else{
						$error = 1;
					}

					if(isset($error)){
						$data['Status'] = "ERROR";
						$data['Message'] = "Please send food type";
					}else{
						$data['last_rec_ids'] = [];
						foreach ($json->childids as $key=>$childid) {
							$json->childid = $childid;
							$last_rec_id = $this->ddm->addFoodRecord($json,$table);
							array_push($data['last_rec_ids'], $last_rec_id);
						}
						$data['Status'] = "SUCCESS";
						$data['Message'] = "Food Record Added Successfully";
					}
					
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Request Method";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function addSleepRecord()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json!= null && $res != null && $res->userid == $json->userid){
					$data['last_rec_ids'] = [];
					foreach ($json->childids as $key=>$childid) {
						$json->childid = $childid;
						$last_rec_id = $this->ddm->addSleepRecord($json);
						array_push($data['last_rec_ids'], $last_rec_id);
					}
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Sleep Record Added Successfully";
					
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Request Method";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function addMultiSleepRecord()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json!= null && $res != null && $res->userid == $json->userid){
					$data['last_rec_ids'] = [];
					$i = 0;
					foreach ($json->sleep as $slp) {
						if ($i==0) {
							$last_rec_id = $this->ddm->addSleepRecord($slp);
						} else {
							$last_rec_id = $this->ddm->addSleepRecord($slp,1);
						}
						$i++;
					}
					array_push($data['last_rec_ids'], $last_rec_id);
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Sleep Record Added Successfully";
					
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Request Method";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function addToiletingRecord()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json!= null && $res != null && $res->userid == $json->userid){
					$data['last_rec_ids'] = [];
					foreach ($json->childids as $key=>$childid) {
						$json->childid = $childid;
						$last_rec_id = $this->ddm->addToiletingRecord($json);
						array_push($data['last_rec_ids'], $last_rec_id);
					}
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Toileting Record Added Successfully";
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Request Method";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function addSunscreenRecord()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json!= null && $res != null && $res->userid == $json->userid){
					$data['last_rec_ids'] = [];
					foreach ($json->childids as $key=>$childid) {
						$json->childid = $childid;
						$last_rec_id = $this->ddm->addSunscreenRecord($json);
						array_push($data['last_rec_ids'], $last_rec_id);
					}
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Sunscreen Record Added Successfully";
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Required data not sent!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Request Method";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function addMultiSunscreenRecord()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json!= null && $res != null && $res->userid == $json->userid){
					$data['last_rec_ids'] = [];
					$j = 0;
					foreach ($json->sunscreen as $ss) {
						if ($j==0) {
							$last_rec_id = $this->ddm->addSunscreenRecord($ss);
							array_push($data['last_rec_ids'], $last_rec_id);
						} else {
							$last_rec_id = $this->ddm->addSunscreenRecord($ss,1);
							array_push($data['last_rec_ids'], $last_rec_id);
						}
						$j++;
					}
					
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Sunscreen Record Added Successfully";
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Required data not sent!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Request Method";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function viewChildDiary()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$json->date = empty($json->date)?date('Y-m-d'):$json->date;
				$child = $this->ddm->getChildInfo($json->childid);
				foreach ($child as $key => $childObj) {
					$bfObj = $this->ddm->getBreakfast($childObj->id,$json->date);
					$mtObj = $this->ddm->getMorningTea($childObj->id,$json->date);
					$lnObj = $this->ddm->getLunch($childObj->id,$json->date);
					$slObj = $this->ddm->getSleep($childObj->id,$json->date);
					$atObj = $this->ddm->getAfternoonTea($childObj->id,$json->date);
					$snObj = $this->ddm->getSnacks($childObj->id,$json->date);
					$ssObj = $this->ddm->getSunscreen($childObj->id,$json->date);
					$ttObj = $this->ddm->getToileting($childObj->id,$json->date);
					$childObj->breakfast = empty($bfObj)?null:$bfObj;
					$childObj->morningtea = empty($mtObj)?null:$mtObj;
					$childObj->lunch = empty($lnObj)?null:$lnObj;
					$childObj->sleep = empty($slObj)?null:$slObj;
					$childObj->afternoontea = empty($atObj)?null:$atObj;
					$childObj->snack = empty($snObj)?null:$snObj;
					$childObj->sunscreen = empty($ssObj)?null:$ssObj;
					$childObj->toileting = empty($ttObj)?null:$ttObj;
				}	
				$data['Status'] = "SUCCESS";
				$data['child'] = $child;
				$data['breakfast'] = $this->ddm->getRecipes("breakfast");
				$data['tea'] = $this->ddm->getRecipes("tea");
				$data['lunch'] = $this->ddm->getRecipes("lunch");
				$data['snack'] = $this->ddm->getRecipes("snacks");
			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Required data not sent!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function updateChildDailyDiary()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){

				$bfRecords = $this->ddm->addFoodRecord($json->breakfast,"dailydiarybreakfast");
				$mtRecords = $this->ddm->addFoodRecord($json->morningtea,"dailydiarymorningtea");
				$lnRecords = $this->ddm->addFoodRecord($json->lunch,"dailydiarylunch");
				$atRecords = $this->ddm->addFoodRecord($json->afternoontea,"dailydiaryafternoontea");
				$snRecords = $this->ddm->addFoodRecord($json->snack,"dailydiarysnacks");
				$ttRecords = $this->ddm->addToiletingRecord($json->toileting);

				$i = 0;
				foreach ($json->sleep as $slp) {
					if ($i==0) {
						$slRecords = $this->ddm->addSleepRecord($slp);
					} else {
						$slRecords = $this->ddm->addSleepRecord($slp,1);
					}
					$i++;
				}
				
				$j = 0;
				foreach ($json->sunscreen as $ss) {
					if ($j==0) {
						$ssRecords = $this->ddm->addSunscreenRecord($ss);
					} else {
						$ssRecords = $this->ddm->addSunscreenRecord($ss,1);
					}
					$j++;
				}
				$data['Status'] = "SUCCESS";
				$data['Message'] = "Saved Successfully";

			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Required data not sent!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getCenterRooms()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$roomsArr = $this->ddm->getCenterRooms($json->centerId);
				$data['Status'] = "SUCCESS";
				$data['Rooms'] = $roomsArr;
			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Required data not sent!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}
}

/* End of file dailyDiary.php */
/* Location: ./application/controllers/dailyDiary.php */