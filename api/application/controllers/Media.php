<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ChildrenModel');
		$this->load->model('MediaModel');
		$this->load->model('LoginModel');
		$this->load->model('UtilModel');
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") { die(); }
	}

	public function index()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){

				$userArr = $this->LoginModel->getUserFromId($json->userid);
				$json->today = date('Y-m-d');
				$json->weekDate = date('Y-m-d', strtotime('-7 days'));
				if($userArr->userType == "Superadmin"){
					$childArr = $this->ChildrenModel->getChildsFromCenter($json->centerid);
					$recentRecs = $this->MediaModel->getRecentMedias($json);
					$thisWeekRecs = $this->MediaModel->getThisWeekMedias($json);
					$earlierRecs = $this->MediaModel->getEarlierMedias($json);
				}elseif($userArr->userType == "Staff"){
					$childArr = $this->ChildrenModel->getChildsFromCenter($json->centerid);
					$recentRecs = $this->MediaModel->getRecentMedias($json);
					$thisWeekRecs = $this->MediaModel->getThisWeekMedias($json);
					$earlierRecs = $this->MediaModel->getEarlierMedias($json);
				}else{
					$childArr = $this->ChildrenModel->getChildOfParent($json->userid);
					$child_arr = [];
					foreach ($childArr as $key => $cobj) {
						$child_arr[] = $cobj->childid;
					}

					$childstr = implode(",", $child_arr);
					$json->childstr = $childstr;

					$getRecentChildMediaList = $this->MediaModel->getRecentChildMediaId($json);
					$getThisWeekChildMediaList = $this->MediaModel->getThisWeekChildMediaId($json);
					$getEarlierChildMediaList = $this->MediaModel->getEarlierChildMediaId($json);

					$getRecentParentMediaList = $this->MediaModel->getRecentMedias($json);
					$getThisWeekParentMediaList = $this->MediaModel->getThisWeekMedias($json);
					$getEarlierParentMediaList = $this->MediaModel->getEarlierMedias($json);

					$recentRecs = array_merge($getRecentChildMediaList,$getRecentParentMediaList);
					$thisWeekRecs = array_merge($getThisWeekChildMediaList,$getThisWeekParentMediaList);
					$earlierRecs = array_merge($getEarlierChildMediaList,$getEarlierParentMediaList);

				}

				$staffsArr = $this->UtilModel->getAllStaffs();
              //  print_r($childArr); exit;
				$data['Status'] = "SUCCESS";
				$data['Children'] = $childArr;
				$data['Users'] = $staffsArr;
				$data['Recent'] = $recentRecs;
				$data['ThisWeek'] = $thisWeekRecs;
				$data['Earlier'] = $earlierRecs;

			}else{
				$data['Status'] =  "ERROR";
				$data['Message'] = "Userid didn't match";
			}
		}else{
			$data['Status'] =  "ERROR";
			$data['Message'] = "Invalid headers sent.";
		}
		echo json_encode($data);
	}

	public function getTagsArr()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$mediaArr = [];
				$childTags = [];
				$staffTags = [];
				if(empty($json->mediaid) || !isset($json->mediaid)){
					$data['Status'] =  "ERROR";
					$data['Message'] = "Invalid Media Id given";
				}else{
					$mediaArr = $this->MediaModel->getMediaInfo($json->mediaid);
					if(empty($mediaArr)){
						$data['Status'] =  "ERROR";
						$data['Message'] = "MediaId doesn't exists!";
					}else{
						$childTags = $this->MediaModel->getMediaChildTags($json->mediaid);
						$staffTags = $this->MediaModel->getMediaStaffTags($json->mediaid);
					}
					$data['Status'] = "SUCCESS";
					$data['Media'] = $mediaArr;
					$data['ChildTags'] = $childTags;
					$data['StaffTags'] = $staffTags;
				}
			}else{
				$data['Status'] =  "ERROR";
				$data['Message'] = "Userid didn't match";
			}
		}else{
			$data['Status'] =  "ERROR";
			$data['Message'] = "Invalid headers sent.";
		}
		echo json_encode($data);
	}

	public function uploadFiles()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_POST!= null && $res != null && $res->userid == $_POST['userid']){
				$target_dir = "assets/media/";
				$data['errmsgs'] = [];
				$totalFiles = count($_FILES);
				$data['obsMedias'] = array();
				for ($j=0; $j < $totalFiles ; $j++) {
					$newName = uniqid();
					$target_file = $target_dir . basename($_FILES['media'.$j]["name"]);
					$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					$newTarget = $target_dir . $newName . ".".$file_type;
					$check = getimagesize($_FILES['media'.$j]["tmp_name"]);
					if ($file_type == "jpg" || $file_type == "png" || $file_type == "jpeg") {
						move_uploaded_file($_FILES['media'.$j]["tmp_name"], $newTarget);
						$data['medias']['userid'][] = $_POST['userid'];
						$data['medias']['centerid'][] = $_POST['centerid'];
						$data['medias']['name'][] = $newName . ".".$file_type;
						$data['medias']['type'][] = "Image";
						$data['medias']['caption'][] = isset($_POST['caption'.$j])?$_POST['caption'.$j]:NULL;
					}elseif($file_type == "mp4"){
						move_uploaded_file($_FILES['media'.$j]["tmp_name"], $newTarget);
						$data['medias']['userid'][] = $_POST['userid'];
						$data['medias']['centerid'][] = $_POST['centerid'];
						$data['medias']['name'][] = $newName . ".".$file_type;
						$data['medias']['type'][] = "Video";
						$data['medias']['caption'][] = isset($_POST['caption'.$j])?$_POST['caption'.$j]:NULL;
					} else {
						$data['errmsgs'.$j] = $_FILES['media'.$j]["name"]." is not uploaded!";
					}
				}
				$tagsRecord = [];
				for($i=0;$i<count($data['medias']['name']);$i++){
					$mediaData['name'] = $data['medias']['name'][$i];
					$mediaData['type'] = $data['medias']['type'][$i];
					$mediaData['caption'] = $data['medias']['caption'][$i];
					$mediaData['userid'] = $data['medias']['userid'][$i];
					$mediaData['centerid'] = $data['medias']['centerid'][$i];
					$last_id = $this->MediaModel->insertMedia($mediaData);

					if (isset($_POST['childTags'.$i])) {
						$_POST['childTags'.$i] = json_decode($_POST['childTags'.$i]);
						foreach ($_POST['childTags'.$i] as $childtags => $chtag) {
							$d['mediaId'] = $last_id;
							$d['userid'] = $chtag;
							$d['usertype'] = "child";
							array_push($tagsRecord,$d);
						}
					}
					
					if(isset($_POST['eduTags'.$i])){
						$_POST['eduTags'.$i] = json_decode($_POST['eduTags'.$i]);
						foreach ($_POST['eduTags'.$i] as $edutags => $edtag) {
							$d['mediaId'] = $last_id;
							$d['userid'] = $edtag;
							$d['usertype'] = "staff";
							array_push($tagsRecord,$d);
						}
					}
					
				}

				foreach($tagsRecord as $keys => $tags){
					$this->MediaModel->insertMediaTags($tags);
				}

				$data = [];
				$data['Status']='SUCCESS';
				$data['Message']="Media uploaded successfully";

			}else{
				http_response_code(401);
				$data['Status']='ERROR';
				$data['Message']="Invalid Userid!";
			}
		}
		else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function deleteMedia()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$mediaArr = $this->MediaModel->getMediaInfo($json->mediaid);
				if (empty($mediaArr)) {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Media not found!";
				}else{
					unlink('assets/media/'.$mediaArr->filename);
					$this->MediaModel->deleteMedia($json->mediaid);
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Media deleted successfully!";
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Userid Used!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveImageTags()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$this->MediaModel->updateMediaInfo($json);
				$this->MediaModel->updateMediaTagsInfo($json);
				$data['Status'] =  "SUCCESS";
				$data['Message'] = "Media information updated";
			}else{
				$data['Status'] =  "ERROR";
				$data['Message'] = "Userid didn't match";
			}
		}else{
			$data['Status'] =  "ERROR";
			$data['Message'] = "Invalid headers sent.";
		}
		echo json_encode($data);
	}

	public function uploadFile()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_POST!= null && $res != null && $res->userid == $_POST['userid']){
				if (empty($_FILES['media'])) {
					http_response_code(401);
					$data['Status']='ERROR';
					$data['Message']="Empty files!";
				}else{
					//upload files here
					$target_dir = "assets/media/";
					$newName = uniqid();
					$target_file = $target_dir . basename($_FILES['media']["name"]);
					$file = pathinfo($target_file);
					$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					$filename = $file['filename'] . "-" . $newName . ".".$file_type;
					$newTarget = $target_dir . $filename;
					if ($file_type == "jpg" || $file_type == "png" || $file_type == "jpeg") {
						move_uploaded_file($_FILES['media']["tmp_name"], $newTarget);
						$mediaData['userid'] = $_POST['userid'];
						$mediaData['centerid'] = $_POST['centerid'];
						$mediaData['name'] = $filename;
						$mediaData['type'] = "Image";
						$mediaData['caption']= isset($_POST['caption'])?$_POST['caption']:NULL;
						$last_id = $this->MediaModel->insertMedia($mediaData);
					} else if ($file_type == "mp4"){
						move_uploaded_file($_FILES['media']["tmp_name"], $newTarget);
						$mediaData['userid'] = $_POST['userid'];
						$mediaData['centerid'] = $_POST['centerid'];
						$mediaData['name'] = $filename;
						$mediaData['type'] = "Video";
						$mediaData['caption'] = isset($_POST['caption'])?$_POST['caption']:NULL;
						$last_id = $this->MediaModel->insertMedia($mediaData);
					} else {
						$errmsgs = $_FILES['media']["name"]." is not supported!";
					}

					if(isset($last_id)){
						http_response_code(200);
						$data['Status'] = "SUCCESS";
						$data['Message'] = "File uploaded successfully!";
						$data['recordid'] = $last_id;
						$data['type'] = $mediaData['type'];
					}else{
						http_response_code(400);
						$data['Status']='ERROR';
						$data['Message']=empty($errmsgs)?"Something went wrong!":$errmsgs;
					}
				}
			}else{
				http_response_code(400);
				$data['Status']='ERROR';
				$data['Message']="Invalid Userid!";
			}
		}
		else{
			http_response_code(400);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getMediaInfo()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$mediaArr = $this->MediaModel->getMediaInfo($json->mediaid);
				$mediaArr->tags = [];
				if (!empty($mediaArr)) {
					//get media tags
					$childtags = $this->MediaModel->getMediaChildTags($json->mediaid);
					$stafftags = $this->MediaModel->getMediaStaffTags($json->mediaid);

					//process tags
					if (!empty($childtags)) {
						foreach ($childtags as $childkey => $childobj) {
							$tags = $this->MediaModel->getChildInfo($childobj->userid);
							$tags->type = "child";
							$mediaArr->tags[] = $tags;
						}
					}

					if (!empty($stafftags)) {
						foreach ($stafftags as $staffkey => $staffobj) {
							$tags = $this->MediaModel->getStaffInfo($staffobj->userid);
							$tags->type = "staff";
							$mediaArr->tags[] = $tags;
						}
					}

					$data['Status'] =  "SUCCESS";
					$data['Media'] = $mediaArr;
				}else{
					http_response_code(401);
					$data['Status'] =  "ERROR";
					$data['Message'] = "Media file doesn't exists!";
				}
			}else{
				http_response_code(401);
				$data['Status'] =  "ERROR";
				$data['Message'] = "Userid didn't match";
			}
		}else{
			http_response_code(401);
			$data['Status'] =  "ERROR";
			$data['Message'] = "Invalid headers sent.";
		}
		echo json_encode($data);
	}

}

/* End of file Media.php */
/* Location: ./application/controllers/Media.php */