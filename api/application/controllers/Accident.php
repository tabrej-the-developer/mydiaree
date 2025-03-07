<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accident extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LoginModel');
		$this->load->model('AccidentsModel','acm');
		$this->load->model('ChildrenModel','cm');
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

	public function getPageData()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){

				$_childsArray = $this->cm->getChildsFromRooms($json->roomid);

				foreach ($_childsArray as $childkey => $childobj) {
					$childobj->details = $childobj->name . " - " .date_diff(date_create($childobj->dob), date_create('today'))->y . " Years";
				}

				$data["Status"] = "SUCCESS";
				$data["Childs"] = $_childsArray;

			}else{
				http_response_code(401);
				$data["Status"] =  "ERROR";
				$data["Message"] = "Userid didn't match";
			}
		}else{
			$data["Status"] =  "ERROR";
			$data["Message"] = "Invalid headers sent";
		}
		echo json_encode($data);
	}

	public function getAccidents()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));

			//print_r($json); exit;
			if($json!= null && $res != null && $res->userid == $json->userid){
				$userid = $json->userid;
				$UserType = $json->UserType;

				// $user = $this->acm->getUserDetails($userid);

				if(empty($json->centerid)) {
					$userCentersArr = $this->acm->getUserCenters($userid);
					$centerid = $userCentersArr[0]->id;
					
				} else {
					$centerid = $json->centerid;
				}

				if (empty($json->roomid)) {
					$getCenterRoomsArr = $this->acm->getRooms($centerid);
					$roomid = $getCenterRoomsArr[0]->id;
					$roomname = $getCenterRoomsArr[0]->name;
					$roomcolor = $getCenterRoomsArr[0]->color;
					
				} else {
					$roomid = $json->roomid;
					$getRoom = $this->acm->getRooms(NULL,$roomid);
					$roomname = $getRoom[0]->name;
					$roomcolor = $getRoom[0]->color;
					$getCenterRoomsArr = $this->acm->getRooms($centerid);
					
				}

				if (empty($json->date)) {
					$date = date("Y-m-d");
				} else {
					$date = date("Y-m-d",strtotime($json->date));
				}


				if($UserType == "Parent"){
					$accArr = $this->acm->getChildAccidents($userid);
				}else{
					$accArr = $this->acm->getAccidents($roomid);
				}
				// print_r($accArr); exit;
                // foreach($accArr as $accidents => $accObj){
                //     $userArr = $this->acm->getUserDetails($accObj->added_by);
                //     $accObj->username = $userArr->name;
                // }


				foreach ($accArr as $accidents => $accObj) {
					
					if ($accObj && is_object($accObj)) {
						$userArr = $this->acm->getUserDetails($accObj->added_by);
						
						if ($userArr) {
							$accObj->username = $userArr->name;
						} else {
							$accObj->username = 'Unknown'; 
						}
					} 
				}
				

				
				$data['Status'] = "SUCCESS";
				$data['centerid'] = $centerid;
				$data['date'] = $date;
				$data['roomid'] = $roomid;
				$data['roomname'] = $roomname;
				$data['roomcolor'] = $roomcolor;
				$data['rooms'] = $getCenterRoomsArr;
				$data['childs'] = $this->acm->getChilds($roomid);
				$data['accidents'] = $accArr;
                
                
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = 'Userid didn\'t match';
			}
		}else{
			$data['Status'] =  'ERROR';
			$data['Message'] = 'Invalid headers sent.';
		}
		echo json_encode($data);
	}

	public function saveAccident()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){

				#first save the record in the table and fetch record id
				if (isset($json->accidentid)) {
					$res = $this->acm->updateAccident($json);
					$accidentid = $json->accidentid;
				}else{
					// echo "<pre>";
					// print_r($json);
					// exit;
					$res = $this->acm->insertAccident($json);
					$accidentid =  $res;

					if (!$this->db->affected_rows()) {
						echo "DB Error: " . $this->db->error()['message'];
						exit;
					}
					// print_r($res);
					// exit;
				}

				#update the signatures and accident mark image 
				$target = "assets/media/";
				$person_sign = "personSign-".$accidentid.".png";
				$witness_sign = "witnessSign-".$accidentid.".png";
				$injury_image = "injuryImage-".$accidentid.".png";
				$person_inc_sign = "personInchargeSign-".$accidentid.".png";
				$res_supervisor_sign = "supervisorSign-".$accidentid.".png";

				if (isset($json->person_sign) && !empty($json->person_sign)) {
					$ps = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $json->person_sign));
					file_put_contents($target.$person_sign, $ps);
					$this->acm->updatePersonSign($accidentid,$person_sign);
				}

				if (isset($json->witness_sign) && !empty($json->witness_sign)) {
					$ws = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $json->witness_sign));
					file_put_contents($target.$witness_sign, $ws);
					$this->acm->updateWitnessSign($accidentid,$witness_sign);
				}

				if (isset($json->injury_image) && !empty($json->injury_image)) {
					$injimg = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $json->injury_image));
					file_put_contents($target.$injury_image, $injimg);
					$this->acm->updateInjuryImage($accidentid,$injury_image);
				}

				if (isset($json->responsible_person_sign) && !empty($json->responsible_person_sign)) {
					$pinc = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $json->responsible_person_sign));
					file_put_contents($target.$person_inc_sign, $pinc);
					$this->acm->updatePersonIncSign($accidentid,$person_inc_sign);
				}

				if (isset($json->nominated_supervisor_sign) && !empty($json->nominated_supervisor_sign)) {
					$nsv = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $json->nominated_supervisor_sign));
					file_put_contents($target.$res_supervisor_sign, $nsv);
					$this->acm->updateNomSupervisor($accidentid,$res_supervisor_sign);
				}

				// print_r($accidentid);
				// exit;

				#update all the illness
				if ($accidentid == NULL) {
					http_response_code(401);					
					$data['Status'] = "ERROR";
					$data['Message'] = "Something went wrong!";
				}else{
					$json->accidentid = $accidentid;
					$last_id = $this->acm->updateIllness($json);
					if ($last_id) {
						http_response_code(200);						
						$data['Status'] = "SUCCESS";
						$data['Message'] = "Accident record saved!";
					} else {
						http_response_code(401);						
						$data['Status'] = "ERROR";
						$data['Message'] = "Can't update illness!";
					}					
				}
			}else{
				http_response_code(401);
				$data['Status'] =  "ERROR";
				$data['Message'] = "Userid didn't match";
			}
		}else{
			http_response_code(401);
			$data['Status'] =  "ERROR";
			$data['Message'] = "Invalid headers sent";
		}
		echo json_encode($data);
	}

	public function getChildDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if ($json->childid) {
					$res = $this->acm->getChildDetails($json->childid);
					if ($res) {						
						$res->age = date_diff(date_create($res->dob), date_create('today'))->y . " Years";						
						http_response_code(200);
						$data["Status"] =  "SUCCESS";
						$data["Child"] = $res;
					} else {
						http_response_code(401);
						$data["Status"] =  "ERROR";
						$data["Message"] = "Childid doesn't exists!";
					}
					
				} else {
					http_response_code(401);
					$data["Status"] =  "ERROR";
					$data["Message"] = "Childid is missing!";
				}
				
			}else{
				http_response_code(401);
				$data["Status"] =  "ERROR";
				$data["Message"] = "Userid didn't match";
			}
		}else{
			$data["Status"] =  "ERROR";
			$data["Message"] = "Invalid headers sent";
		}
		echo json_encode($data);
	}


	public function getCenterRooms()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if ($json->centerid) {
					$res = $this->acm->getCenterRooms($json->centerid);
					if ($res) {					
						http_response_code(200);
						$data["Status"] =  "SUCCESS";
						$data["Rooms"] = $res;
					} else {
						http_response_code(401);
						$data["Status"] =  "ERROR";
						$data["Message"] = "Centerid don't have any room!";
					}					
				} else {
					http_response_code(401);
					$data["Status"] =  "ERROR";
					$data["Message"] = "Centerid is missing!";
				}				
			}else{
				http_response_code(401);
				$data["Status"] =  "ERROR";
				$data["Message"] = "Userid didn't match";
			}
		}else{
			$data["Status"] =  "ERROR";
			$data["Message"] = "Invalid headers sent";
		}
		echo json_encode($data);
	}

	public function getAccidentDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if ($json->accidentid) {
					$res = $this->acm->getAccidentDetails($json->accidentid);
					if ($res) {					
						http_response_code(200);
						$data["Status"] =  "SUCCESS";
						$data["AccidentInfo"] = $res;
					} else {
						http_response_code(401);
						$data["Status"] =  "ERROR";
						$data["Message"] = "Accident ID does not exist!";
					}					
				} else {
					http_response_code(401);
					$data["Status"] =  "ERROR";
					$data["Message"] = "Accidentid is missing!";
				}				
			}else{
				http_response_code(401);
				$data["Status"] =  "ERROR";
				$data["Message"] = "Userid didn't match";
			}
		}else{
			$data["Status"] =  "ERROR";
			$data["Message"] = "Invalid headers sent";
		}
		echo json_encode($data);
	}
}

/* End of file HeadChecks.php */
/* Location: ./application/controllers/HeadChecks.php */