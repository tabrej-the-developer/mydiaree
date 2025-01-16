<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reflections extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LoginModel');
		$this->load->model('ChildrenModel');
		$this->load->model('UtilModel');
		$this->load->model('ReflectionsModel','refmodel');
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") { die(); }
	}

	public function index()
	{
		//nothing here
	}

	public function getUserReflections()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$usertype = $this->LoginModel->getUserType($json->userid);
				$error_num = 0;
				if ($usertype == "Superadmin") {
					$error_num = 0;
					$permission = NULL;
					$view_others = 1;
				}else if($usertype == "Staff"){
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
					if ($permission) {
						$view_others = $permission->viewAllReflection;
					}else{
						$view_others = 0;
					}
				}else{
					$error_num = 2;
				}

				if ($error_num == 0) {

					if ($view_others == 1) {
						$resultArr = $this->refmodel->getCenterReflections($json->centerid);
					} else {
						$resultArr = $this->refmodel->getUserReflections($json->userid);
					}

					foreach ($resultArr as $resKey => $resObj) {
						//Fetch Reflection Media and Media Tags
						$resObj->media = $this->refmodel->getReflectionMedias($resObj->id);

						//Fetch Reflection Childs
						$resObj->childs = $this->refmodel->getReflectionChilds($resObj->id);

						//Fetch Reflection Staffs
						$resObj->staffs = $this->refmodel->getReflectionStaffs($resObj->id);
					}

					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Reflections'] = $resultArr;
					$data['permission'] = $permission;
				}else{
					if ($error_num == 2) {
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "Invalid User Type!";
					}
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			http_response_code(401);
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getCenterReflections()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if ($json->centerid) {

					$resultArr = $this->refmodel->getCenterReflections($json->centerid);

					foreach ($resultArr as $resKey => $resObj) {
						//Fetch Reflection Media and Media Tags
						$resObj->refMedia = $this->refmodel->getReflectionMedias($resObj->id);

						//Fetch Reflection Childs
						$resObj->childs = $this->refmodel->getReflectionChilds($resObj->id);

						//Fetch Reflection Staffs
						$resObj->staffs = $this->refmodel->getReflectionStaffs($resObj->id);
					}

					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Reflections'] = $resultArr;
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Centerid is required!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			http_response_code(401);
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getReflection()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if ($json->reflectionid) {

					$reflectionid = $json->reflectionid;
					$resultArr = $this->refmodel->getReflection($reflectionid);

					//Fetch Reflection Media and Media Tags
					$resultArr->refMedia = $this->refmodel->getReflectionMedias($reflectionid);
					
					//Fetch Reflection Childs
					$resultArr->childs = $this->refmodel->getReflectionChilds($reflectionid);

					//Fetch Reflection Staffs
					$resultArr->staffs = $this->refmodel->getReflectionStaffs($reflectionid);

					//Get all childs from center
					$childsArr = $this->ChildrenModel->getChildsFromCenter($json->centerid);

					//Get all Educators from  center staff
					$educatorsArr = $this->refmodel->getCenterStaffs($json->centerid);

					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Reflections'] = $resultArr;
					$data['Childs'] = $childsArr;
					$data['Educators'] = $educatorsArr;
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Centerid is required!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			http_response_code(401);
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function createReflection()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_POST!= null && $res != null && $res->userid == $_POST['userid']){

				$reflectionid = $this->refmodel->createReflection($_POST);

				if (isset($_POST['childs'])) {
					$childs = json_decode($_POST['childs']);
					foreach ($childs as $childkey => $childobj) {
						$this->refmodel->insertReflectionChild($reflectionid,$childobj);
					}
				}

				if (isset($_POST['educators'])) {
					$educators = json_decode($_POST['educators']);
					foreach ($educators as $edukey => $eduobj) {
						$this->refmodel->insertReflectionEducators($reflectionid,$eduobj);
					}
				}

				if($reflectionid){

					if ($_FILES) {
						$target_dir = "assets/media/";
						foreach ($_FILES as $files => $file) {
							$newName = uniqid();
			  				$target_file = $target_dir . basename($file['name']);
			  				$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));		  				
			  				$newTarget = $target_dir . $newName . ".".$file_type;
		  					if ($file_type == "mp4" || $file_type == "jpg" || $file_type == "png" || $file_type == "jpeg") {

			  					if ($file_type == "mp4") {
				  					$type = "Video";
				  				} else {
				  					$type = "Image";
				  				}

			  					if(move_uploaded_file($file["tmp_name"], $newTarget)){
			  						$mediaObj = new stdClass();
				  					$mediaObj->reflectionId = $reflectionid;
						  			$mediaObj->mediaUrl = $newName . "." . $file_type;
						  			$mediaObj->mediaType = $type;
						  			$mediaid = $this->refmodel->insertReflectionMedia($mediaObj);
			  					}else{
			  						$data['FILE_ERROR'][] = "Somefiles are not uploaded!";
			  					}
			  				}else{
			  					$data['FILE_ERROR'][] = "Somefiles are not supported!";
			  				}
						}
					}

					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Reflection Created Successfully";
				}else{
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Reflection Not Created!";
				}

			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid user account!";
			}
		}else{
			http_response_code(401);
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers sent!";
		}
		echo json_encode($data);
	}

	public function deleteReflection()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$usertype = $this->LoginModel->getUserType($json->userid);
				$error_num = 0;
				if ($usertype == "Superadmin") {
					$permission = NULL;
					$deleteReflections = 1;
				}else if($usertype == "Staff"){
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
					if ($permission) {
						$deleteReflections = $permission->approveReflection;
					}else{
						$deleteReflections = 0;
					}
				}else{
					$error_num = 2;
				}

				$reflectionid = $json->reflectionid;

				if($reflectionid){
					if ($error_num == 0) {
						if ($deleteReflections == 0) {
							http_response_code(401);
							$data['Status'] = "SUCCESS";
							$data['Message'] = "Insufficient Permission!";
						} else {
							$res = $this->refmodel->deleteReflection($reflectionid);
							if($res){
								http_response_code(200);
								$data['Status'] = "SUCCESS";
								$data['Message'] = "Reflection Deleted Successfully";
							}else{
								http_response_code(401);
								$data['Status'] = "SUCCESS";
								$data['Message'] = "Something went wrong!";
							}
						}
					} else {
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "Invalid User Type!";
					}					
				}else{
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Reflection id is required!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid user account!";
			}
		}else{
			http_response_code(401);
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers sent!";
		}
		echo json_encode($data);
	}

	public function updateReflection()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			// $json = json_decode(file_get_contents('php://input'));
			if($_POST!= null && $res != null && $res->userid == $_POST['userid']){
				if ($_POST['reflectionid']) {

					$reflectionid = $_POST['reflectionid'];

					$this->refmodel->updateReflection($_POST);

					$this->refmodel->removeChildsAndStaffs($reflectionid);

					if (isset($_POST['childs'])) {
						$childs = json_decode($_POST['childs']);
						foreach ($childs as $childkey => $childobj) {
							$this->refmodel->insertReflectionChild($reflectionid,$childobj);
						}
					}

					if (isset($_POST['educators'])) {
						$educators = json_decode($_POST['educators']);
						foreach ($educators as $edukey => $eduobj) {
							$this->refmodel->insertReflectionEducators($reflectionid,$eduobj);
						}
					}

					if($reflectionid){
						if ($_FILES) {
							$target_dir = "assets/media/";
							foreach ($_FILES as $files => $file) {
								$newName = uniqid();
				  				$target_file = $target_dir . basename($file['name']);
				  				$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));		  				
				  				$newTarget = $target_dir . $newName . ".".$file_type;
			  					if ($file_type == "mp4" || $file_type == "jpg" || $file_type == "png" || $file_type == "jpeg") {

				  					if ($file_type == "mp4") {
					  					$type = "Video";
					  				} else {
					  					$type = "Image";
					  				}

				  					if(move_uploaded_file($file["tmp_name"], $newTarget)){
				  						$mediaObj = new stdClass();
					  					$mediaObj->reflectionId = $reflectionid;
							  			$mediaObj->mediaUrl = $newName . "." . $file_type;
							  			$mediaObj->mediaType = $type;
							  			$mediaid = $this->refmodel->insertReflectionMedia($mediaObj);
				  					}else{
				  						$data['FILE_ERROR'][] = "Somefiles are not uploaded!";
				  					}
				  				}else{
				  					$data['FILE_ERROR'][] = "Somefiles are not supported!";
				  				}
							}
						}
						http_response_code(200);
						$data['Status'] = "SUCCESS";
						$data['Message'] = "Reflection Updated Successfully";
					}else{
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "Reflection Not Updated!";
					}
				}else{
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Reflection id is required!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid user account!";
			}
		}else{
			http_response_code(401);
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers sent!";
		}
		echo json_encode($data);
	}

	public function getReflectionDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if ($json->centerid) {
					$childsArr = $this->ChildrenModel->getChildsFromCenter($json->centerid);
					$educatorsArr = $this->refmodel->getCenterStaffs($json->centerid);
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Childs'] = empty($childsArr)?NULL:$childsArr;
					$data['Educators'] = empty($educatorsArr)?NULL:$educatorsArr;
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Centerid is required!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			http_response_code(401);
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

    public function getChildRecords(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				//Children List
				$childrenList = [];
				$childs = $this->ChildrenModel->getChildsFromCenter($json->centerid);
				foreach ($childs as $childkey => $childobj) {
					$ch['childid'] = $childobj->childid;
					$ch['name'] = $childobj->name ." ". $childobj->lastname;
					$ch['imageUrl'] = $childobj->imageUrl;
					$ch['dob'] = date('d-m-Y',strtotime($childobj->dob));
					$bday = new DateTime($childobj->dob);
					$today = new Datetime(date('Y-m-d'));
					$diff = $today->diff($bday);
					$ch['age'] = $diff->y . 'years ' . $diff->m . 'months';
					$ch['gender'] = $childobj->gender;
					if (isset($json->refid) && $json->refid != NULL) {
                        $check = $this->refmodel->checkChildInRefl($json->refid, $childobj->childid);
						if (empty($check)) {
							$ch['checked'] = "";
						}else{
                            $ch['checked'] = "checked"; 
						}
					} else {
						$ch['checked'] = "no"; 
					}
					
					array_push($childrenList, $ch);
				}

				//Groups with children List
				$groupsList = [];
				$childgroups = $this->ChildrenModel->getChildGroups($json->centerid);	
				foreach ($childgroups as $groupkey => $groupobj) {
					$gp['groupid'] = $groupobj->id;
					$gp['name'] = $groupobj->name;
					$childList = [];
					$ch = [];
					$childs = $this->ChildrenModel->getChildsFromGroups($groupobj->id);
					foreach ($childs as $childkey => $childobj) {
						$ch['childid'] = $childobj->id;
						$ch['name'] = $childobj->name ." ". $childobj->lastname;
						$ch['imageUrl'] = $childobj->imageUrl;
						$ch['dob'] = date('d-m-Y',strtotime($childobj->dob));
						$bday = new DateTime($childobj->dob);
						$today = new Datetime(date('Y-m-d'));
						$diff = $today->diff($bday);
						$ch['age'] = $diff->y . 'years ' . $diff->m . 'months';
						$ch['gender'] = $childobj->gender;
						if (isset($json->refid) && $json->refid != NULL) {
							$check = $this->refmodel->checkChildInRefl($json->refid, $childobj->id);
							if ($check) {
								$ch['checked'] = "checked"; 
							}else{
								$ch['checked'] = ""; 
							}
						} else {
							$ch['checked'] = ""; 
						}						
						array_push($childList, $ch);
					}
					$gp['childrens'] = $childList;
					array_push($groupsList,$gp);
				}	

				//Rooms With Children List
				$roomsList = [];
				$gp = [];
				$childrooms = $this->ChildrenModel->getCenterRooms($json->centerid);	
				foreach ($childrooms as $roomkey => $roomobj) {
					$gp['roomid'] = $roomobj->id;
					$gp['name'] = $roomobj->name;
					$childList = [];
					$ch = [];
					$childs = $this->ChildrenModel->getChildsFromRooms($roomobj->id);
					foreach ($childs as $childkey => $childobj) {
						$ch['childid'] = $childobj->childid;
						$ch['name'] = $childobj->name ." ". $childobj->lastname;
						$ch['imageUrl'] = $childobj->imageUrl;
						$ch['dob'] = date('d-m-Y',strtotime($childobj->dob));
						$bday = new DateTime($childobj->dob);
						$today = new Datetime(date('Y-m-d'));
						$diff = $today->diff($bday);
						$ch['age'] = $diff->y . 'years ' . $diff->m . 'months';
						$ch['gender'] = $childobj->gender;
						if (isset($json->refid) && $json->refid != NULL) {
							$check = $this->refmodel->checkChildInRefl($json->refid,$childobj->childid);
							if ($check) {
								$ch['checked'] = "checked"; 
							}else{
								$ch['checked'] = ""; 
							}
						} else {
							$ch['checked'] = ""; 
						}						
						array_push($childList, $ch);
					}
					$gp['childrens'] = $childList;
					array_push($roomsList,$gp);
				}

				http_response_code(200);
				$data["Status"] = "SUCCESS";
				$data["Childrens"] = $childrenList;			
				$data["Groups"] = $groupsList;			
				$data["Rooms"] = $roomsList;			
			}else{
				http_response_code(401);
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Invalid data passed';
			}
		}else{
			http_response_code(401);
			$data['Status'] = 'ERROR';
			$data['Message'] = 'Invalid headers';
		}
		echo json_encode($data);
	}
}

/* End of file Reflection.php */
/* Location: ./application/controllers/Reflection.php */