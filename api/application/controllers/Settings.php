<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	function __construct() {
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$this->load->model('SettingsModel');
		$this->load->model('ObservationModel');
		$this->load->model('LoginModel');
		$this->load->model('UtilModel');
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") { die(); }
	}

	public function index(){
		echo "Holly molly!";
	}
	
	public function changePin(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			// print_r($json);
			// exit;
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){
					$userid = $json->userid;
					$pin = $json->pin;
					$confirmPin = $json->confirmPin;
					$currentPin = $json->currentPin;

					$run = 1;

					if(empty($confirmPin)){
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "Please send confirm pin!";
						$run = 0;
					}

					if(empty($pin)){
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "Please send pin!";
						$run = 0;
					}

					if(empty($currentPin)){
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "Please send current pin!";
						$run = 0;
					}

					if($run == 1){
						if($confirmPin != $pin){
							http_response_code(401);
							$data['Status'] = "ERROR";
							$data['Message'] = "Password don't match!";
						}else{
							$getPIN = $this->SettingsModel->getPIN($userid);
							if($getPIN->password == sha1($currentPin)){
								$this->SettingsModel->changePassword($pin,$userid);
								$data['Status'] = "SUCCESS";
								$data['Message'] = "Pin changed successfully";
							}else{
								http_response_code(401);
								$data['Status'] = "ERROR";
								$data['Message'] = "Current pin is incorrect";
							}
						}
					}
					
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "User Id Doesn't Match";
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

	public function changePassword(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){
					$userid = $json->userid;
					$currentPassword = sha1($json->currentPassword);
					$password = $json->password;
					$getPassword = $this->SettingsModel->getPassword($userid);
					if($getPassword->password == $currentPassword){
						$this->SettingsModel->changePassword($password,$userid);
						$data['Status'] = "SUCCESS";
						$data['Message'] = "Password changed successfully";
					}else{
						$data['Status'] = "ERROR";
						$data['Message'] = "Incorrect Password";
						// Error Email
					}
				} else {
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "User Id Doesn't Match";
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

	public function changeEmail(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){
					$userid = $json->userid;
					$currentEmail = $json->currentEmail;
					$email = $json->email;
					$getEmail = $this->LoginModel->getUserFromEmail($currentEmail);
					if($getEmail==NULL){
						$data['Status'] = "ERROR";
						$data['Message'] = "Current Email is incorrect";
					}else{
						if($getEmail->emailid == $currentEmail){
							if ($getEmail->userType == "Staff") {
								$this->SettingsModel->changeEmail($email,$userid);
							}else{
								$this->SettingsModel->changeUsernameEmail($email,$userid);
							}
							$data['Status'] = "SUCCESS";
							$data['Message'] = "Email changed successfully";
						}else{
							$data['Status'] = "ERROR";
							$data['Message'] = "Current Email is incorrect";
						}
					}
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "User Id Doesn't Match";
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

	public function getModuleSettings(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				$userid = $json->userid;
				$centerid = $json->centerid;

				//check usertype for permissions
				$role = $this->LoginModel->getUserType($userid);

				if ($role == "Superadmin") {
					$permission = NULL;
				} elseif ($role == "Staff") {
					$permission = $this->UtilModel->getPermissions($userid,$centerid);
				} else {
					$permission = $this->UtilModel->getPermissions(0,0);
				}

				$getModulesObj = $this->SettingsModel->getModuleSettings($centerid);
				$getModules = json_decode(json_encode($getModulesObj), true);
				$data['Status'] = "SUCCESS";
				$data['permissions'] = $permission;
				$data['modules'] = $getModules;
			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid don't match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}	

	public function addModuleSettings(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				$addModule = $this->SettingsModel->addModuleSettings($json);
				$data['Status'] = "SUCCESS";
				$data['Message'] = "Modules updated successfully";
			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getUsersSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				$userStats = $this->SettingsModel->getUserStats($json->centerid);
				$users = $this->SettingsModel->getCenterUsers($json->centerid,NULL,$json->order);

				$data['Status'] = "SUCCESS";
				$data['userStats'] = $userStats;
				$data['users'] = $users;
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}
	
	public function saveUsersDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			// $json = json_decode(file_get_contents('php://input'));
			// echo "<pre>";
			// print_r($_POST);
			// exit;


			if($_POST!= null && $res != null && $res->userid == $_POST['userid']){

				$checkEmpCode = $this->SettingsModel->checkEmpCodeAvl($_POST['username']);
				if($checkEmpCode == 0 || isset($_POST['recordId'])){
					if (isset($_POST['recordId'])) {

						if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name']) ) {
							$target_dir = 'assets/media/';
							$newName = uniqid();
							$target_file = $target_dir . basename($_FILES['image']["name"]);
							$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
							$newTarget = $target_dir . $newName . ".".$file_type;
							if ($file_type == "gif" || $file_type == "jpg" || $file_type == "png" || $file_type == "jpeg") {
								move_uploaded_file($_FILES['image']["tmp_name"], $newTarget);
								$_POST['image_name'] = $newName . "." . $file_type;
							} else {
								$data['errmsgs'] = $_FILES['image']["name"]." is not uploaded!";
							}
						}else{
							$userArr = $this->SettingsModel->getUsersDetails($_POST['recordId']);
							$_POST['image_name'] = $userArr->imageUrl;
						}

						$this->SettingsModel->removeUserCenterRecords($_POST['recordId']);
						
					}else{

						if (isset($_FILES['image']['name'])) {
							$target_dir = 'assets/media/';
							$newName = uniqid();
							$target_file = $target_dir . basename($_FILES['image']["name"]);
							$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
							$newTarget = $target_dir . $newName . ".".$file_type;
							if ($file_type == "gif" || $file_type == "jpg" || $file_type == "png" || $file_type == "jpeg") {
								move_uploaded_file($_FILES['image']["tmp_name"], $newTarget);
								$_POST['image_name'] = $newName . "." . $file_type;
							} else {
								$data['errmsgs'] = $_FILES['image']["name"]." is not uploaded!";
							}
						} else {
							$_POST['image_name'] = "AMIGA-Montessori.jpg";
						}

						$password = $_POST['password'];
						$hashedPassword = sha1($password);
						$_POST['password'] = $hashedPassword;
					}

					$resultset = $this->SettingsModel->saveUsersDetails($_POST);

					if (gettype($_POST['centerIds'])=="string") {
						$_POST['centerIds'] = json_decode($_POST['centerIds']);
					}


					
					foreach ($_POST['centerIds'] as $key => $obj) {
						$idata['centerid']= $obj;
						$idata['userid'] = $resultset;
						$this->SettingsModel->addUsersToCenter($idata);
					}
					
					if (empty($resultset)) {
						http_response_code(401);						
						$data['Status'] = "ERROR";
						$data['Message'] = "Something went wrong!";
					} else {
						$data['Status'] = "SUCCESS";
						$data['Message'] = "User data saved successfully";
					}
				}else{
					http_response_code(401);						
					$data['Status'] = "ERROR";
					$data['Message'] = "Employee code already exists!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getUsersDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			// print_r($json);
			// exit;
			if($json != null && $res != null && $res->userid == $json->userid){
				$recordId = $json->recordId;				
				$userData = $this->SettingsModel->getUsersDetails($recordId);
				// $allcenters = $this->SettingsModel->getAllCenters();
				$userAssignedCenters = $this->SettingsModel->getUserAssignedCenters($json->userid);

				$allcenters = $this->SettingsModel->getAllCentersByUserCenters($userAssignedCenters);

				foreach ($allcenters as $key => $obj) {
					$check = $this->SettingsModel->checkUserCenter($recordId,$obj->id);
					if ($check) {
						$obj->selected = "selected";
					}else{
						$obj->selected = "";
					}
				}
                
				// print_r($allcenters);
				// exit;
				$data['Status'] = "SUCCESS";
				$data['userdata'] = $userData;
				$data['centers']= $allcenters;

			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function fetchEmpCodeAvl()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			
			if($json != null && $res != null && $res->userid == $json->userid){
				if(empty($json->empCode)){
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Employee code is required!";
				}else{
					$empcode = $json->empCode;
					$checkEmpCode = $this->SettingsModel->checkEmpCodeAvl($empcode);
					if ($checkEmpCode) {
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "This $empcode code has been taken!";
						$data['count'] = $checkEmpCode;
					}else{
						$data['Status'] = "SUCCESS";
						$data['Message'] = "This $empcode is available!";
						$data['count'] = $checkEmpCode;
					}
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			http_response_code(401);
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getCentersSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				$centers = $this->SettingsModel->getCenters($json);
				$data['Status'] = "SUCCESS";
				$data['centers'] = $centers;
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getCenterDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				
				if (isset($json->centerId)) {
					$centerId = $json->centerId;
					$userCenter = $this->SettingsModel->getCenterDetails($centerId);
					$rooms = $this->SettingsModel->getRoomsDetails($centerId);
					$data = $userCenter;

				}
				$data->Status = "SUCCESS";
				$data->Rooms = $rooms;
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveCenterDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				$centerId = $this->SettingsModel->saveCenterDetails($json);		
				$this->SettingsModel->removeCenterRooms($centerId);		
				foreach ($json->rooms as $rooms => $rm) {
					if (empty($rm->roomid)) {
						$addRoom = $this->SettingsModel->addRoom($rm->roomName,$rm->roomCapacity,$rm->roomStatus,$rm->roomColor,$centerId,$json->userid);
					} else {
						$updRoom = $this->SettingsModel->updRoom($rm->roomid,$rm->roomName,$rm->roomCapacity,$rm->roomStatus,$rm->roomColor,$centerId,$json->userid);
					}
				}
				$data['Status'] = "SUCCESS";
				$data['Message'] = "Center saved successfully";
			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getParentSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				$parentStats = $this->SettingsModel->getUserStatsParent($json->centerid);
				$parents = $this->SettingsModel->getCenterUsersParent($json->centerid,NULL,NULL);
				$data['Status'] = "SUCCESS";
				$data['parentStats'] = $parentStats;
				$data['parents'] = $parents;
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getParentDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){

				if (isset($json->recordId)) {
					$recordId = $json->recordId;
					$parentData = $this->SettingsModel->getParentDetails($recordId);
					$parentData->children = $this->SettingsModel->getParentChild($recordId);
				}
				// $children = $this->SettingsModel->getChildren();
				if($json->superadmin == 1){
					$children = $this->SettingsModel->getChildren2($json->userid);
				}else{
					$children = $this->SettingsModel->getChildren3($json->userid);
				}
				
				$data['Status'] = "SUCCESS";
				$data['children'] = $children;
				if (isset($parentData)) {
					$data['parents'] = $parentData;
				}

			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveParentDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){

				if(isset($json->recordId)){
					$this->SettingsModel->updateParent($json);
					$recordId = $json->recordId;
					$this->SettingsModel->removeParentRelations($json->recordId);
					$this->SettingsModel->removeUserCenterMapping($recordId);
				}else{
					$recordId = $this->SettingsModel->saveParent($json);
				}

				$this->SettingsModel->addUserCenterMapping($recordId, $json->centerid);


				foreach ($json->relation as $relation => $rel) {
					$this->SettingsModel->addRelation($rel->childid,$recordId,$rel->relation);
				}

				$data['Status'] = "SUCCESS";
				$data['Message'] = "Parent details saved successfully";
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getChildGroupDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				if (isset($json->groupId)) {
					$groupId = $json->groupId;
					$groupData = $this->SettingsModel->getGroupDetails($groupId);
					$groupData->children = $this->SettingsModel->getGroupChilds($groupId);
				}

				$children = $this->SettingsModel->getChildren();

				$data['Status'] = "SUCCESS";
				$data['children'] = $children;
				if (isset($groupData)) {
					$data['groupData'] = $groupData;
				}

			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}
	
	public function saveChildGroup()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				
				if(isset($json->groupId)){
					$this->SettingsModel->updateChildGroup($json);
					$groupId = $json->groupId;
				}else{
					$groupId = $this->SettingsModel->saveChildGroup($json);
				}
				$this->SettingsModel->deleteChildFromGroup($groupId);
				foreach ($json->children as $childrenss => $rel) {
					$this->SettingsModel->insertChildRecord($rel,$groupId);
				}
				$data['Status'] = "SUCCESS";
				$data['Message'] = "Child Group saved successfully";
			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getChildGroups()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				
				$groups = $this->SettingsModel->getChildGroups();
				foreach ($groups as $key => $grp) {
					$grp->children = $this->SettingsModel->getGroupChildrens($grp->id);
				}
				
				$data['Status'] = "SUCCESS";
				$data['groups'] = $groups;
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getPermissions()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				if (empty($json->user)) { $json->user = 0; }
				if (empty($json->center)) { $json->center = 0; }
				$users = $this->SettingsModel->getAllUsers("Staff");
				$centers = $this->SettingsModel->getCenters();
				$permissions = $this->SettingsModel->getPermissions($json);
				$data['Status'] = "SUCCESS";
				$data['users'] = $users;
				$data['centers'] = $centers;
				$data['permissions'] = $permissions;
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getUsersPermissions()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){

				//check if centerid is present or not
				$centersArr = $this->SettingsModel->getUserCenters($json->userid);
				if (isset($json->centerid)) {
					$centerid = $json->centerid;
				}else{
					$centerid = $centersArr[0]->id;
				}
				
				//send list of users for manage permission page
				$userArr = $this->LoginModel->getUserFromId($json->userid);
				$role = $userArr->userType;
				if ($role == "Superadmin") {
					$usersArr = $this->SettingsModel->getCenterUsers($centerid);
					$save = NULL;
				} elseif($role == "Staff") {
					$usersArr = $this->SettingsModel->getCenterUsers($centerid,$json->userid);
					$savePermission = $this->SettingsModel->checkPermission($json->userid,"updatePermission",$centerid);
					if (empty($savePermission)) {
						$save = NULL;
					}else{
						$save = $savePermission->updatePermission;
					}
					
				} else {
					$usersArr = NULL;
					$save = NULL;
				}

				//check if users are present or not
				$users = [];
				if (isset($json->users) && !empty($json->users)) {
					$users = $json->users;
				} else {
					$users[] = (empty($usersArr))?NULL:$usersArr[0]->userid;
				}

				foreach ($usersArr as $usersKey => $usersObj) {
					if (in_array($usersObj->userid, $users)) {
						$usersObj->checked = "selected";
					}else{
						$usersObj->checked = "";
					}
				}

				$columns=[];
				$columnsArr = $this->SettingsModel->getPermissionColumns();
				$i = 0;
				foreach ($columnsArr as $column) {
					if ($i>=3) {
						$columns[] = $column->columns;
					}
					$i++;
				}
				$permissions = [];
				foreach ($columns as $key => $obj) {
					$temp_var = 0;
					foreach ($users as $userkey => $userobj) {
						$record = $this->SettingsModel->checkPermission($userobj,$obj,$centerid);
						if (!empty($record)) {
							$temp_var = $temp_var + $record->$obj;
						}						
					}
					if($temp_var == count($users)){
						$permissions[$obj] = 1;
					}else{
						$permissions[$obj] = 0;
					}
				}

				$data['Status'] = "SUCCESS";
				$data['users'] = $usersArr;
				$data['centers'] = $centersArr;
				$data['permissions'] = $permissions;
				$data['savePermission'] = $save;
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getCenterUsers()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){

				//check if centerid is present or not
				if (isset($json->centerid)) {
					$centerid = $json->centerid;
					$userArr = $this->LoginModel->getUserFromId($json->userid);
					$role = $userArr->userType;
					if ($role == "Superadmin") {
						$usersArr = $this->SettingsModel->getCenterUsers($centerid);
					} elseif($role == "Staff") {
						$usersArr = $this->SettingsModel->getCenterUsers($centerid,$json->userid);
					} else {
						$usersArr = NULL;
					}
					$data['Status'] = "SUCCESS";
					$data['users'] = $usersArr;
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Center id is required!";
				}

			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function savePermissions()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				if (empty($json->users) || empty($json->centerid)){
					$data['Status'] = "ERROR";
					$data['Message'] = "User or Center is invalid";
				}else{
					$last_rec=[];
					foreach ($json->users as $key => $obj) {
						$json->indvuser = $obj;
						$json->center = $json->centerid;
						$last_rec[] = $this->SettingsModel->savePermissions($json);
					}
					$data['Status'] = "SUCCESS";
					$data['Message'] = "permission saved successfully.";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function dailyJournalTabs()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				if (empty($json->centerid)){
					$data['Status'] = "ERROR";
					$data['Message'] = "Center id is empty!";
				}else{
					$tabs = $this->SettingsModel->getCenterJournalTabs($json->centerid);
					$centers = $this->SettingsModel->getAllCenters();
					$data['Status'] = "SUCCESS";
					$data['Centers'] = $centers;
					$data['JournalTabs'] = empty($tabs)?NULL:$tabs;
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveApplicationSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				if (empty($json->centerid)){
					$data['Status'] = "ERROR";
					$data['Message'] = "Center id is empty!";
				}else{
					$record = $this->SettingsModel->getCenterJournalTabs($json->centerid);

					if (empty($record)) {
						$this->SettingsModel->insertCenterJournalTabs($json);
					}else{
						$this->SettingsModel->updateCenterJournalTabs($json);
					}
					
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Record saved successfully!";
					http_response_code(200);
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function noticePeriodSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				if (empty($json->centerid)){
					$data['Status'] = "ERROR";
					$data['Message'] = "Center id is empty!";
				}else{
					$tabs = $this->SettingsModel->getCenterNoticeSettings($json->centerid);
					$centers = $this->SettingsModel->getAllCenters();
					$data['Status'] = "SUCCESS";
					$data['Centers'] = $centers;
					$data['Notice'] = empty($tabs)?NULL:$tabs;
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveNoticeSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				if (empty($json->centerid)){
					$data['Status'] = "ERROR";
					$data['Message'] = "Center id is empty!";
				}else{
					$record = $this->SettingsModel->getCenterNoticeSettings($json->centerid);

					if (empty($record)) {
						$this->SettingsModel->insertCenterNoticeSettings($json);
					}else{
						$this->SettingsModel->updateCenterNoticeSettings($json);
					}
					
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Record saved successfully!";
					http_response_code(200);
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function export_excel()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			
			if($json != null && $res != null && $res->userid == $json->userid){

				$export_data=$this->SettingsModel->get_export();
				
				$data['Status'] = "SUCCESS";
				$data['export']=$export_data;
				http_response_code(200);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Excel Not Export!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function themeSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				$getUserInfo = $this->SettingsModel->getUserInfo($json->userid);
				$themeList = $this->SettingsModel->getAllThemes();
				foreach ($themeList as $key => $obj) {
					if ($obj->id == $getUserInfo->theme) {
						$obj->selected = "checked";
					} else {
						$obj->selected = "";
					}					
				}				
				$data['Status'] = "SUCCESS";
				$data['themeList'] = $themeList;
				http_response_code(200);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Excel Not Export!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveThemeSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				$response = $this->SettingsModel->applyTheme($json);
				if($response){
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Theme applied successfully!";
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Theme not applied!";
					http_response_code(401);
				}
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Excel Not Export!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getAssessmentSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				//check usertype for permissions
				$role = $this->LoginModel->getUserType($json->userid);

				if ($role == "Superadmin") {
					$permission = NULL;
				} elseif ($role == "Staff") {
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
				} else {
					$permission = $this->UtilModel->getPermissions(0,0);
				}

				$response = $this->SettingsModel->getAssessmentSettings($json->centerid);
				if($response){
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Settings'] = $response;
					$data['Permissions'] = $permission;
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "No record found!";
					http_response_code(401);
				}
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Excel Not Export!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveAsmntSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				$userid = $json->userid;
				$role = $this->LoginModel->getUserType($userid);
				$centerid = $json->centerid;
				if ($role == "Superadmin") {
					$p = 1;
				} elseif ($role == "Staff") {
					$permission = $this->UtilModel->getPermissions($userid,$centerid);
					$p = $permission->assessment;
				} else {
					$p = 0;
				}

				if($p == 1){
					$record = $this->SettingsModel->getAssessmentSettings($centerid);
					if ($record) {
						$response = $this->SettingsModel->saveAsmntSettings($json);
					}else{
						$response = $this->SettingsModel->addAsmntSettings($json);
					}
					
					if($response){
						http_response_code(200);
						$data['Status'] = "SUCCESS";
						$data['Message'] = "Assessment settings saved!";
					}else{
						$data['Status'] = "ERROR";
						$data['Message'] = "Something went wrong!";
						http_response_code(401);
					}
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Insufficient Permission!";
					http_response_code(401);
				}
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers used!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getMontessoriSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				//Fetch all subjects
				$subjects = $this->ObservationModel->getMontessoriSubjects();
				foreach ($subjects as $skey => $sobj) {

					//fetch all activities 
					$activities = $this->ObservationModel->getMontessoriActivities($sobj->idSubject);
					foreach ($activities as $akey => $aobj) {

						$subactivities = $this->ObservationModel->getMontessoriSubActivities($aobj->idActivity);
						foreach ($subactivities as $sakey => $saobj) {
							$saobj->extras = $this->ObservationModel->getMontSubActExtras($saobj->idSubActivity);
							foreach ($saobj->extras as $extrakey => $extraobj) {
								//Check if activity checked or not
								$subcheck = $this->ObservationModel->checkMonSubActExtraAccess($json->centerid,$extraobj->idExtra);
								if ($subcheck) {
									$extraobj->checked = "checked";
								} else {
									$extraobj->checked="";
								}
							}

							//Check if activity checked or not
							$subcheck = $this->ObservationModel->checkMonSubActAccess($json->centerid,$saobj->idSubActivity);
							if ($subcheck) {
								$saobj->checked = "checked";
							} else {
								$saobj->checked="";
							}
						}

						$aobj->subactivity = $subactivities;

						//Check if activity checked or not
						$check = $this->ObservationModel->checkMonActAccess($json->centerid,$aobj->idActivity);
						if ($check) {
							$aobj->checked = "checked";
						} else {
							$aobj->checked="";
						}
						
					}
					$sobj->activities = $activities;
				}

				//check usertype for permissions
				$role = $this->LoginModel->getUserType($json->userid);

				if ($role == "Superadmin") {
					$permission = NULL;
				} elseif ($role == "Staff") {
					$obj = new stdClass();
					$obj->user = $json->userid;
					$obj->center = $json->centerid;
					$permission = $this->SettingsModel->getPermissions($obj);
				} else {
					$permission = $this->UtilModel->getPermissions(0,0);
				}
				
				http_response_code(200);
				$data['Status'] = "SUCCESS";
				$data['Subjects'] = $subjects;
				$data['CenterId'] = $json->centerid;
				$data['Permissions'] = $permission;
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){							
				if ($json->activity) {
					//update existing
					$response = $this->SettingsModel->updateMonActivity($json);
				}else{
					//create new 
					$response = $this->SettingsModel->insertMonActivity($json);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Activity saved successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveSubActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->subactivity) {
					//update existing
					$response = $this->SettingsModel->updateMonSubActivity($json);
				}else{
					//create new 
					$response = $this->SettingsModel->insertMonSubActivity($json);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "SubActivity saved successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getSubActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){							
				if ($json->subactivity) {
					$response = $this->SettingsModel->getSubActivity($json->subactivity);
				} else {
					$response = NULL;
				}
				
				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Result'] = $response;
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Please send subactivity id!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveExtras()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->extra) {
					//update existing
					$response = $this->SettingsModel->updateMonSubActivityExtra($json);
				}else{
					//create new 
					$response = $this->SettingsModel->insertMonSubActivityExtra($json);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Extra saved successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function deleteMonActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->id) {
					//delete existing
					$response = $this->SettingsModel->deleteMonActivity($json->id);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Delete record doesn't exists!";
					http_response_code(401);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Record deleted successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function deleteMonSubActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->id) {
					//delete existing
					$response = $this->SettingsModel->deleteMonSubActivity($json->id);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Delete record doesn't exists!";
					http_response_code(401);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Record deleted successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function deleteMonSubActivityExtras()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->id) {
					//delete existing
					$response = $this->SettingsModel->deleteMonSubActivityExtras($json->id);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Delete record doesn't exists!";
					http_response_code(401);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Record deleted successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveMontessoriList()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				
				$this->SettingsModel->clearMonActvtAccess($json->centerid);

				foreach ($json->activity as $actyvt => $actvt) {
					$tempdata = new stdClass;
					$tempdata->activity = $actvt;
					$tempdata->centerid = $json->centerid;
					$tempdata->userid = $json->userid;
					$this->SettingsModel->insertMonActivityAccess($tempdata);
				}

				$this->SettingsModel->clearMonSubActvtAccess($json->centerid);

				foreach ($json->subactivity as $subactyvt => $subactvt) {
					$tempdata = new stdClass;
					$tempdata->subactivity = $subactvt;
					$tempdata->centerid = $json->centerid;
					$tempdata->userid = $json->userid;
					$this->SettingsModel->insertMonSubActivityAccess($tempdata);
				}

				$this->SettingsModel->clearMonSubActvtExtrasAccess($json->centerid);

				foreach ($json->extras as $extraactyvt => $extra) {
					$tempdata = new stdClass;
					$tempdata->extra = $extra;
					$tempdata->centerid = $json->centerid;
					$tempdata->userid = $json->userid;
					$this->SettingsModel->insertMonSubActivityExtraAccess($tempdata);
				}

				$data['Status'] = "SUCCESS";
				$data['Message'] = "Record saved successfully!";
				http_response_code(200);
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getEylfSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){

				//check usertype for permissions
				$role = $this->LoginModel->getUserType($json->userid);

				if ($role == "Superadmin") {
					$permission = NULL;
				} elseif ($role == "Staff") {
					$obj = new stdClass();
					$obj->user = $json->userid;
					$obj->center = $json->centerid;
					$permission = $this->SettingsModel->getPermissions($obj);
				} else {
					$permission = $this->UtilModel->getPermissions(0,0);
				}

				//Fetch all subjects
				$Outcomes = $this->ObservationModel->getEylfOutcomes();
				foreach ($Outcomes as $outcomekey => $ocobj) {
					//fetch all activities 
					$activities = $this->ObservationModel->getEylfActivities($ocobj->id);
					foreach ($activities as $akey => $aobj) {
						$subactivities = $this->ObservationModel->getEylfSubActivities($aobj->id);
						foreach ($subactivities as $sakey => $saobj) {
							//Check if activity checked or not
							$subcheck = $this->ObservationModel->checkEylfSubActAccess($json->centerid,$saobj->id);
							if ($subcheck) {
								$saobj->checked = "checked";
							} else {
								$saobj->checked="";
							}
						}
						$aobj->subactivity = $subactivities;
						//Check if activity checked or not
						$check = $this->ObservationModel->checkActAccess($json->centerid,$aobj->id);
						if ($check) {
							$aobj->checked = "checked";
						} else {
							$aobj->checked="";
						}
					}
					$ocobj->activities = $activities;
				}	

				if (empty($Outcomes)) 
				{
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "No outcomes exists in table!";
					$data['Outcomes'] = NULL;
					$data['CenterId'] = $json->centerid;
					$data['Permissions'] = $permission;
				}else{
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Outcomes'] = $Outcomes;
					$data['CenterId'] = $json->centerid;
					$data['Permissions'] = $permission;
				}					
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveEylfActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){							
				if ($json->activity) {
					//update existing
					$response = $this->SettingsModel->updateEylfActivity($json);
				}else{
					//create new 
					$response = $this->SettingsModel->insertEylfActivity($json);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Activity saved successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveEylfSubActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->subactivity) {
					//update existing
					$response = $this->SettingsModel->updateEylfSubActivity($json);
				}else{
					//create new 
					$response = $this->SettingsModel->insertEylfSubActivity($json);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "SubActivity saved successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getEylfSubActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){	

				if ($json->subactivity) {
					$response = $this->SettingsModel->getEylfSubActivity($json->subactivity);
				} else {
					$response = NULL;
				}
				
				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Result'] = $response;
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Please send subactivity id!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function deleteEylfActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->id) {
					//delete existing
					$response = $this->SettingsModel->deleteEylfActivity($json->id);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Delete record doesn't exists!";
					http_response_code(401);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Record deleted successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function deleteEylfSubActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->id) {
					//delete existing
					$response = $this->SettingsModel->deleteEylfSubActivity($json->id);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Delete record doesn't exists!";
					http_response_code(401);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Record deleted successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveEylfList()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				
				$this->SettingsModel->clearEylfActvtAccess($json->centerid);

				foreach ($json->activity as $actyvt => $actvt) {
					$tempdata = new stdClass;
					$tempdata->activity = $actvt;
					$tempdata->centerid = $json->centerid;
					$tempdata->userid = $json->userid;
					$this->SettingsModel->insertEylfActivityAccess($tempdata);
				}

				$this->SettingsModel->clearEylfSubActvtAccess($json->centerid);

				foreach ($json->subactivity as $subactyvt => $subactvt) {
					$tempdata = new stdClass;
					$tempdata->subactivity = $subactvt;
					$tempdata->centerid = $json->centerid;
					$tempdata->userid = $json->userid;
					$this->SettingsModel->insertEylfSubActivityAccess($tempdata);
				}

				$data['Status'] = "SUCCESS";
				$data['Message'] = "Record saved successfully!";
				http_response_code(200);
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getDevMileSettings()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){

				//check usertype for permissions
				$role = $this->LoginModel->getUserType($json->userid);

				if ($role == "Superadmin") {
					$permission = NULL;
				} elseif ($role == "Staff") {
					$obj = new stdClass();
					$obj->user = $json->userid;
					$obj->center = $json->centerid;
					$permission = $this->SettingsModel->getPermissions($obj);
				} else {
					$permission = $this->UtilModel->getPermissions(0,0);
				}

				//Fetch all subjects
				$agegroups = $this->ObservationModel->getDevelopmentalMilestones();
				foreach ($agegroups as $agekey => $ageobj) {
					//fetch all main 
					$mainsubjects = $this->ObservationModel->getDevMileMain($ageobj->id);
					foreach ($mainsubjects as $mainkey => $mainobj) {
						$subactivities = $this->ObservationModel->getDevMileSub($mainobj->id);
						foreach ($subactivities as $sakey => $saobj) {
							$saobj->extras = $this->ObservationModel->getDevMileExtra($saobj->id);
							foreach ($saobj->extras as $extrakey => $extraobj) {
								//Check if activity checked or not
								$subcheck = $this->ObservationModel->checkDevMileSubExtraAccess($json->centerid,$extraobj->id);
								if ($subcheck) {
									$extraobj->checked = "checked";
								} else {
									$extraobj->checked="";
								}
							}

							//Check if activity checked or not
							$subcheck = $this->ObservationModel->checkDevMileSubAccess($json->centerid,$saobj->id);
							if ($subcheck) {
								$saobj->checked = "checked";
							} else {
								$saobj->checked="";
							}
						}

						$mainobj->subactivity = $subactivities;

						//Check if activity checked or not
						$check = $this->ObservationModel->checkDevMileMainAccess($json->centerid,$mainobj->id);
						if ($check) {
							$mainobj->checked = "checked";
						} else {
							$mainobj->checked="";
						}	
					}
					$ageobj->activities = $mainsubjects;
				}
				http_response_code(200);
				$data['Status'] = "SUCCESS";
				$data['Milestones'] = $agegroups;
				$data['CenterId'] = $json->centerid;
				$data['Permissions'] = $permission;
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveDevMileActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){							
				if ($json->activity) {
					//update existing
					$response = $this->SettingsModel->updateDevMileActivity($json);
				}else{
					//create new 
					$response = $this->SettingsModel->insertDevMileActivity($json);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Activity saved successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveDevMileSubActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->subactivity) {
					//update existing
					$response = $this->SettingsModel->updateDevMileSubActivity($json);
				}else{
					//create new 
					$response = $this->SettingsModel->insertDevMileSubActivity($json);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "SubActivity saved successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getDevMileSubActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){							
				if ($json->subactivity) {
					$response = $this->SettingsModel->getDevMileSubActivity($json->subactivity);
				} else {
					$response = NULL;
				}
				
				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Result'] = $response;
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Please send subactivity id!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveDevMileExtras()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->extra) {
					//update existing
					$response = $this->SettingsModel->updateDevMileSubActivityExtra($json);
				}else{
					//create new 
					$response = $this->SettingsModel->insertDevMileSubActivityExtra($json);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Extra saved successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function deleteMileMain()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->id) {
					//delete existing
					$response = $this->SettingsModel->deleteDevMileActivity($json->id);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Delete record doesn't exists!";
					http_response_code(401);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Record deleted successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function deleteMileSubActivity()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->id) {
					//delete existing
					$response = $this->SettingsModel->deleteMileSubActivity($json->id);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Delete record doesn't exists!";
					http_response_code(401);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Record deleted successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function deleteMileSubActExtras()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){										
				if ($json->id) {
					//delete existing
					$response = $this->SettingsModel->deleteMileSubActExtras($json->id);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Delete record doesn't exists!";
					http_response_code(401);
				}

				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Record deleted successfully!";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Some technical error occured!";
					http_response_code(401);
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveDevMileList()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json != null && $res != null && $res->userid == $json->userid){
				
				$this->SettingsModel->clearMileActvtAccess($json->centerid);

				foreach ($json->activity as $actyvt => $actvt) {
					$tempdata = new stdClass;
					$tempdata->activity = $actvt;
					$tempdata->centerid = $json->centerid;
					$tempdata->userid = $json->userid;
					$this->SettingsModel->insertMileActivityAccess($tempdata);
				}

				$this->SettingsModel->clearMileSubActvtAccess($json->centerid);

				foreach ($json->subactivity as $subactyvt => $subactvt) {
					$tempdata = new stdClass;
					$tempdata->subactivity = $subactvt;
					$tempdata->centerid = $json->centerid;
					$tempdata->userid = $json->userid;
					$this->SettingsModel->insertMileSubActivityAccess($tempdata);
				}

				$this->SettingsModel->clearMileSubActvtExtrasAccess($json->centerid);

				foreach ($json->extras as $extraactyvt => $extra) {
					$tempdata = new stdClass;
					$tempdata->extra = $extra;
					$tempdata->centerid = $json->centerid;
					$tempdata->userid = $json->userid;
					$this->SettingsModel->insertMileSubActivityExtraAccess($tempdata);
				}

				$data['Status'] = "SUCCESS";
				$data['Message'] = "Record saved successfully!";
				http_response_code(200);
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers!";
			http_response_code(401);
		}
		echo json_encode($data);
	}
}