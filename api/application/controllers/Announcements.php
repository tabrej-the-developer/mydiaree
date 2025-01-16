<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Announcements extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('AnnouncementsModel');
		$this->load->model('LoginModel');
		$this->load->model('UtilModel');
		$this->load->model('ChildrenModel');

		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") { die(); }
	}

	public function index()
	{
		$data = $this->AnnouncementsModel->getPermission(1);
		foreach ($data as $key => $value) {
			echo $value->centerid;
		}
	}

	public function createAnnouncement(){
		# api to create an announcement
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$userArr = $this->LoginModel->getUserFromId($json->userid);
				$role = $userArr->userType;
				if ($role == "Superadmin") {
					$run = 1;
					$json->status = "Sent";
				} elseif($role == "Staff") {
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
					if (empty($permission)) {
						$run = 0;
					} else {
						if ($permission->addAnnouncement == 1) {
							$run = 1;
						} else {
							$run = 0;
						}
						if($permission->approveAnnouncement==1) {
							$json->status = "Sent";
						} else{
							$json->status = "Pending";
						}
					}
				} else {
					$run = 0;
				}
				
				
			    $perms = $this->UtilModel->getPermissions($json->userid,$json->centerid);

			    if($run == 1){

					$id = $this->AnnouncementsModel->createAnnouncement($json);
					foreach ($json->childId as $childId) {
						$addedToChild = $this->AnnouncementsModel->addAnnouncementChild($childId,$id);
					}					
					http_response_code(200);
					$data['Status']='SUCCESS';
					$data['id']=$id;
				}else{
					http_response_code(401);
					$data['Status'] = 'ERROR';
					$data['Message'] = "Permission Error!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = 'SUCCESS';
				$datap['Message'] = "Invalid Data Passed";
			}
		}
		else{
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function announcementsList()
	{	
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$user_id =$json->userid;
				$centerid = $json->centerid;
				$type = $this->AnnouncementsModel->getUserType($user_id);
				$data["Status"] = "SUCCESS";
				$annmnts = [];
				$permission = NULL;

				if ($type == "Staff") {

					$annmnts = $this->AnnouncementsModel->getAnnouncements($user_id,$centerid);
					$permission = $this->UtilModel->getPermissions($user_id,$centerid);

				} elseif ($type == "Superadmin") {

					$annmnts = $this->AnnouncementsModel->getAnnouncements(NULL,$centerid);

				} else {

					$childs = $this->AnnouncementsModel->getUserChilds($json->userid);
					foreach ($childs as $keyChild => $cobj) {
						$ann = $this->AnnouncementsModel->getChildAnnouncements($cobj->childid);
						$annmnts = array_merge($annmnts,$ann);
					}
				}
				
				if ($annmnts!="") {
					foreach ($annmnts as $key => $obj) {
						$arr = $this->AnnouncementsModel->getCreatedByName($obj->createdBy);
						if (empty($arr->name) || $arr->name == NULL) {
							$obj->createdBy = "Not Available";
						} else {
							$obj->createdBy = $arr->name;
						}
					}
					$data['records'] = $annmnts;
				}else{
					$data['records'] = "";
				}	

				$data['permissions'] = $permission;

				
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Data Passed!";
				
			}
		}else{
			http_response_code(401);
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			
		}
		echo json_encode($data);
	}
	
	public function childGroupsList()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('ObservationModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$records = $this->AnnouncementsModel->childGroupsList();
				$data=array();
				$groups=$this->ObservationModel->getChildGroups();
				foreach($groups as $group)
				{
					$data[$group->group_name][]=$group;
				}
				$data["Status"] = "SUCCESS";
				echo json_encode($data);
			}else{
				$data['Status'] = "";
				$data['Message'] = "";
			}
		}else{
			$data['Status'] = "";
			$data['Message'] = "";
		}
	}

	public function getAnnouncement($userid,$announcementId){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $res->userid == $userid){
				if ($announcementId) {
					$permission = NULL;
					$announcementInfo = $this->AnnouncementsModel->getAnnouncement($announcementId);
					//For permissions
					$type = $this->AnnouncementsModel->getUserType($userid);
					if ($type == "Superadmin") {
						$permission = NULL;
						$check = 1;
					}elseif($type == "Staff"){
						$permission = $this->UtilModel->getPermissions($userid,$announcementInfo->centerid);
						$check = 1;
					}

					//print_r($announcementInfo); exit;
					if ($announcementInfo) {
						$usersData = $this->AnnouncementsModel->getUserDetails($announcementInfo->createdBy);
						$announcementInfo->username = $usersData->name;
						$data['Status'] = 'SUCCESS';
						$data['Info'] = $announcementInfo;
						$data['Permissions'] = $permission;
						$data['centerid'] = $announcementInfo->centerid;
					} else {
						http_response_code(401);						
						$data['Status'] = 'ERROR';
						$data['Message'] = 'Announcement record doesn\'t exist!';
					}
				} else {
					http_response_code(401);
					$data['Status'] =  'ERROR';
					$data['Message'] = 'Invalid announcementid!';
				}				
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = 'Invalid userid!';
			}
		}else{
			http_response_code(401);
			$data['Status'] = 'ERROR';
			$data['Message'] = 'Invalid headers!';
		}
		echo json_encode($data);
	}

	public function updateAnnouncement(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
				$json = json_decode(file_get_contents('php://input'));
				if($json!= null && $res != null && $res->userid == $json->userid){
					$announcementId = isset($json->announcementId) ? $json->announcementId : null;
					if($announcementId != null){
						$title = isset($json->title) ? $json->title : null;
						$description = isset($json->description) ? $json->description : null;
						$date = isset($json->date) ? $json->date : '0000-00-00';
						$children = isset($json->children) ? $json->children : [];
						$status = 'Sent';
						$this->AnnouncementsModel->updateAnnouncements($announcementId,$title,$description,$date,$children,$status);
						$announcementInfo = $this->AnnouncementsModel->getAnnouncement($announcementId);
						http_response_code(200);
						$data["Status"] = "SUCCESS";
						$data['centerid'] = empty($announcementInfo)?NULL:$announcementInfo->centerid;
					}else{
						http_response_code(401);
						$data['Status'] = 'ERROR';
						$data['Message'] = 'Invalid announcement id';
					}
				}else{
					$data['Status'] = 'ERROR';
					$data['Message'] = 'Invalid data passed';
				}
			}else{
					$data['Status'] = 'ERROR';
					$data['Message'] = 'Invalid Request Method';
			}
		}else{
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Invalid headers';
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
					if (isset($json->annId)) {
						$check = $this->AnnouncementsModel->checkChildInAnmnt($json->annId,$childobj->childid);
						if ($check) {
							$ch['checked'] = "checked"; 
						}else{
							$ch['checked'] = ""; 
						}
					} else {
						$ch['checked'] = ""; 
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
						if (isset($json->annId)) {
							$check = $this->AnnouncementsModel->checkChildInAnmnt($json->annId,$childobj->id);
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
						if (isset($json->annId)) {
							$check = $this->AnnouncementsModel->checkChildInAnmnt($json->annId,$childobj->childid);
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

	public function save(){
		# api to create an announcement
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){

				if (isset($json->annId) && !empty($json->annId)) {
					$announcementInfo = $this->AnnouncementsModel->getAnnouncement($json->annId);
				}			

				$userArr = $this->LoginModel->getUserFromId($json->userid);
				
				$role = $userArr->userType;
				if ($role == "Superadmin") {
					$run = 1;
					$json->status = "Sent";
				} elseif($role == "Staff") {
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
					if (empty($permission)) {
						$run = 0;
					} else {
						if ($permission->addAnnouncement == 1) {
							$run = 1;
						} else {
							$run = 0;
						}
						
						if($permission->approveAnnouncement==1) {
							$json->status = "Sent";
						} else{
							$json->status = "Pending";
						}

						if($permission->updateAnnouncement==1) {
							$run = 1;
						} else{
							$run = 0;
						}
					}
				} else {
					$run = 0;
				}
				
			    $perms = $this->UtilModel->getPermissions($json->userid,$json->centerid);

			    if($run == 1){
			    	if (isset($json->annId) && !empty($json->annId)) {
			    		$this->AnnouncementsModel->saveAnnouncement($json);
			    		$this->AnnouncementsModel->removeAnnouncementChilds($json->annId);
			    		$id = $json->annId;
			    	} else {
			    		$id = $this->AnnouncementsModel->createAnnouncement($json);
			    	}
			    	
					foreach ($json->childId as $childId) {
						$addedToChild = $this->AnnouncementsModel->addAnnouncementChild($childId,$id);
					}	

					http_response_code(200);
					$data['Status'] = 'SUCCESS';
					$data['id'] = $id;
					$data['Message'] = "Data saved successfully!";
				}else{
					http_response_code(401);
					$data['Status'] = 'ERROR';
					$data['Message'] = "Permission Error!";
				}

			}else{
				http_response_code(401);
				$data['Status'] = 'SUCCESS';
				$data['Message'] = "Invalid Data Passed";
			}
		}
		else{
			http_response_code(401);
			$data['Status'] = 'SUCCESS';
			$data['Message'] = "Invalid headers passed";
		}
		echo json_encode($data);
	}

	public function delete(){
		# api to create an announcement
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$announcementId = $json->annId;
				$announcementInfo = $this->AnnouncementsModel->getAnnouncement($announcementId);
				if ($announcementInfo) {
					$json->centerid = $announcementInfo->centerid;

					$userArr = $this->LoginModel->getUserFromId($json->userid);
					$role = $userArr->userType;
					if ($role == "Superadmin") {
						$run = 1;
						$json->status = "Sent";
					} elseif($role == "Staff") {
						$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
						if (empty($permission)) {
							$run = 0;
						} else {
							if ($permission->deleteAnnouncement == 1) {
								$run = 1;
							} else {
								$run = 0;
							}
						}
					} else {
						$run = 0;
					}

					if($run == 1){
				    	if (isset($json->annId) && !empty($json->annId)) {
			    			$this->AnnouncementsModel->removeAnnouncement($json->annId);
				    		$this->AnnouncementsModel->removeAnnouncementChilds($json->annId);
				    		http_response_code(200);
							$data['Status'] = 'SUCCESS';
							$data['Message'] = "Data deleted successfully!";
							$data['centerid'] = empty($announcementInfo)?NULL:$announcementInfo->centerid;
				    	} else {
				    		http_response_code(401);
							$data['Status'] = 'ERROR';
							$data['Message'] = "Announcement Id is required!";
				    	}
					}else{
						http_response_code(401);
						$data['Status'] = 'ERROR';
						$data['Message'] = "Permission Error!";
					}
				}else{
					http_response_code(401);
					$data['Status'] = 'ERROR';
					$data['Message'] = "Announcement doesn't exist!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = 'ERROR';
				$data['Message'] = "Invalid Data Passed";
			}
		}
		else{
			http_response_code(401);
			$data['Status'] = 'ERROR';
			$data['Message'] = "Invalid headers passed";
		}
		echo json_encode($data);
	}

}

/* End of file announcements.php */
/* Location: ./application/controllers/announcements.php */