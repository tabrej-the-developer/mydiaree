<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Observation extends CI_Controller {

	protected $base_url = "http://localhost/Mykronicle/";

	function __construct() {
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") { die(); }
		parent::__construct();
		$this->load->model('LoginModel');
		$this->load->model('ObservationModel');
		$this->load->model('ChildrenModel');
		$this->load->model('UtilModel');
		$this->load->model('MediaModel');
	}

	public function index(){
		echo $this->base_url;
	}

	public function createObservation()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_POST!= null && $res != null && $res->userid == $_POST['userid']){
				$data = $_POST;
				$userArr = $this->LoginModel->getUserFromId($data['userid']);
                if ($userArr->userType == "Superadmin") {
                    $loadProg = 1;
                    $data['status'] = "Draft";
                    $data['approver'] = $data['userid'];
                }else{
                    if ($userArr->userType == "Staff") {
                        $permission = $this->UtilModel->getPermissions($data['userid'],$data['centerid']);
                        if (!empty($permission) && $permission->addObservation==1) {
                            $loadProg = 1;
                            // if ($permission->approveObservation==1) {
                            // 	$data['status'] = "Published";
                            // 	$data['approver'] = $data['userid'];
                            // } else {
                            	$data['status'] = "Draft";
                            	$data['approver'] = "";
                            // }
                        } else {
                            $loadProg = 0;
                        }
                    }else{
                        $loadProg = 1;
                        $data['status'] = isset($_POST['status'])?$_POST['status']:'Published';
                        $data['approver'] = "";
                    }
                }
				
				if ($loadProg == 1) {

					$tagsArr = [];

					//Process title for saving into db
					if (!empty($data['title'])) {
						$data['title'] = str_replace("a href=","a link='#link' href=",$data['title']);
						$childLink = [];
						$data['title'] = html_entity_decode($data['title']);
						preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i',html_entity_decode($data['title']),$titleMatch);
						foreach ($titleMatch['href'] as $key => $obj) {
						    if (!in_array($obj, $childLink)) {
						        array_push($childLink, $obj);
						        array_push($tagsArr, $obj);
						    }
						}
						$child_url = $this->base_url.'observation/viewChild'."?childid="; 
						$data['title'] = str_replace("user_Child_",$child_url,$data['title']);
						$data['title'] = str_replace("&nbsp;"," ",$data['title']);
						$linkDom = new DOMDocument;
						$linkDom->loadHTML($data['title']);
						$allLinks = $linkDom->getElementsByTagName('a');
						$i = 0;
						foreach ($allLinks as $rawLink) {
						    $longLink = $rawLink->getAttribute('link');
					        $shortURL = $childLink[$i];
					        $rawLink->setAttribute('link', $shortURL);
					        $i++;
						}
						$data['title'] = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">','',$linkDom->saveHTML());
						$data['title'] = str_replace('<html><body>','',$data['title']);
						$data['title'] = str_replace('</body></html>','',$data['title']);
						$data['title'] = htmlspecialchars($data['title']);
					}

					//Process Notes for saving into db
					if (!empty($data['notes'])) {
						$data['notes'] = str_replace("a href=","a link='#link' href=",$data['notes']);
						$childLink = [];
						$data['notes'] = html_entity_decode($data['notes']);
						preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i',html_entity_decode($data['notes']),$notesMatch);
						foreach ($notesMatch['href'] as $key => $obj) {
						    if (!in_array($obj, $childLink)) {
						        array_push($childLink, $obj);
						        array_push($tagsArr, $obj);
						    }
						}

						$child_url = $this->base_url.'observation/viewChild'."?childid="; 
						$data['notes'] = str_replace("user_Child_",$child_url,$data['notes']);
						$data['notes'] = str_replace("&nbsp;"," ",$data['notes']);
						$linkDom = new DOMDocument;
						$linkDom->loadHTML($data['notes']);
						$allLinks = $linkDom->getElementsByTagName('a');
						$i = 0;
						foreach ($allLinks as $rawLink) {
						    $longLink = $rawLink->getAttribute('link');
					        $shortURL = $childLink[$i];
					        $rawLink->setAttribute('link', $shortURL);
					        $i++;
						}
						$data['notes'] = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">','',$linkDom->saveHTML());
						$data['notes'] = str_replace('<html><body>','',$data['notes']);
						$data['notes'] = str_replace('</body></html>','',$data['notes']);
						$data['notes'] = htmlspecialchars($data['notes']);
					}

					//Process Reflections for saving into db
					if (!empty($data['reflection'])) {
						$data['reflection'] = str_replace("a href=","a link='#link' href=",$data['reflection']);
						$childLink = [];
						$data['reflection'] = html_entity_decode($data['reflection']);
						preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i',html_entity_decode($data['reflection']),$reflectionMatch);
						foreach ($reflectionMatch['href'] as $key => $obj) {
						    if (!in_array($obj, $childLink)) {
						        array_push($childLink, $obj);
						        array_push($tagsArr, $obj);
						    }
						}

						$child_url = $this->base_url.'observation/viewChild'."?childid="; 
						$data['reflection'] = str_replace("user_Child_",$child_url,$data['reflection']);
						$data['reflection'] = str_replace("&nbsp;"," ",$data['reflection']);
						$linkDom = new DOMDocument;
						$linkDom->loadHTML($data['reflection']);
						$allLinks = $linkDom->getElementsByTagName('a');
						$i = 0;
						foreach ($allLinks as $rawLink) {
						    $longLink = $rawLink->getAttribute('link');
					        $shortURL = $childLink[$i];
					        $rawLink->setAttribute('link', $shortURL);
					        $i++;
						}
						$data['reflection'] = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">','',$linkDom->saveHTML());
						$data['reflection'] = str_replace('<html><body>','',$data['reflection']);
						$data['reflection'] = str_replace('</body></html>','',$data['reflection']);
						$data['reflection'] = htmlspecialchars($data['reflection']);
					}

					$data['childrens'] = json_decode($data['childrens']);
				  	$id = $this->ObservationModel->createObs($data);
				  	$obsId = $id;
				  	if (isset($data['origin'])) {
				  		$origin = json_decode($data['origin']);
				  		$countOrigin = count($origin);
				  	}

				  	if (isset($data['priority'])) {
				  		$priority = json_decode($data['priority']);
				  	}
				  	
				  	if (isset($countOrigin)) {
				  		for ($i=0; $i < $countOrigin ; $i++) { 
					  		if ($origin[$i]=="UPLOADED") {
					  			$getMediaInfo = $this->ObservationModel->getMediaInfo($priority[$i]);
					  			$mediaObj = new stdClass();
					  			$mediaObj->observationId = $id;
					  			$mediaObj->mediaUrl = $getMediaInfo->filename;
					  			$mediaObj->mediaType = $getMediaInfo->type;
					  			$mediaObj->caption = $getMediaInfo->caption;
					  			$mediaObj->priority = $i + 1;
					  			$mediaid = $this->ObservationModel->insertUploadedMedia($mediaObj);
					  			$childArrName = 'upl-media-tags-child'.$priority[$i];
					  			if (isset($data[$childArrName])) {
					  				$childArr = json_decode($data[$childArrName]);
						  			foreach ($childArr as $child => $childObj) {
						  				$this->ObservationModel->insertUploadedMediaChildTags($mediaid,$childObj);
						  			}
					  			}

					  			$educatorArrName = 'upl-media-tags-educator'.$priority[$i];
					  			if(isset($data[$educatorArrName])){
					  				$educatorArr = json_decode($data[$educatorArrName]);
						  			foreach ($educatorArr as $educator => $educatorObj) {
						  				$this->ObservationModel->insertUploadedMediaEducatorTags($mediaid,$educatorObj);
						  			}
					  			}
					  			
					  		}elseif($origin[$i]=="NEW"){
					  			$obsMediaName = 'obsMedia'.$priority[$i];
					  			if (isset($_FILES[$obsMediaName])) {
					  				$target_dir = "assets/media/";
					  				$newName = uniqid();
					  				$target_file = $target_dir . basename($_FILES[$obsMediaName]["name"]);
					  				$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					  				$newTarget = $target_dir . $newName . ".".$file_type;
					  				if ($file_type == "mp4" || $file_type == "jpg" || $file_type == "png" || $file_type == "jpeg") {
					  					if ($file_type == "mp4") {
						  					$type = "Video";
						  				} else {
						  					$type = "Image";
						  				}
					  					move_uploaded_file($_FILES[$obsMediaName]["tmp_name"], $newTarget);
					  					$mediaObj = new stdClass();
					  					$mediaObj->observationId = $id;
							  			$mediaObj->mediaUrl = $newName . "." . $file_type;
							  			$mediaObj->mediaType = $type;
							  			$caption = 'obsCaption_'.$priority[$i];
							  			$mediaObj->caption = isset($data[$caption])?$data[$caption]:NULL;
							  			$mediaObj->priority = $i + 1;
							  			$mediaid = $this->ObservationModel->insertUploadedMedia($mediaObj);

							  			$childArrName = 'obsImage_'.$priority[$i];
							  			if (isset($data[$childArrName])) {
							  				$childArr = json_decode($data[$childArrName]);
								  			foreach ($childArr as $child => $childObj) {
								  				$this->ObservationModel->insertUploadedMediaChildTags($mediaid,$childObj);
								  			}
							  			}

							  			$educatorArrName = 'obsEducator_'.$priority[$i];
							  			if (isset($data[$educatorArrName])) {
								  			$educatorArr = json_decode($data[$educatorArrName]);
								  			foreach ($educatorArr as $educator => $educatorObj) {
								  				$this->ObservationModel->insertUploadedMediaEducatorTags($mediaid,$educatorObj);
								  			}
								  		}
					  				}
					  			}
					  		}
					  	}
				  	}

				  	//inserting montessori subactivity taken from notes,title & reflection
				  	$tags = [];

					if (!empty($tagsArr)) {
					  	foreach ($tagsArr as $key => $obj) {
							if (preg_match("/tags_/i", $obj)) {
								$var = substr($obj,5);
								array_push($tags,$var);
							}
						}
					}

				  	if (!empty($tags)) {
				  		foreach($tags as $monObj){
				  			$this->ObservationModel->insertMonSubActFromTags($obsId,$monObj);
				  		}
				  	}
				  	
					http_response_code(200);
					$data = [];
					$data['Status']='SUCCESS';
					$data['id']=$id;
				} else {
					$data['Status']='ERROR';
					$data['Message']="Permission Error!";
				}
			}else{
				http_response_code(401);
				$data['Status']='ERROR';
				$data['Message']="Invalid Userid!";
			}
		} else {
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function editObservation()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$data = $this->input->post();
				if($res != null && $res->userid == $data['userid']){

					$tagsArr = [];

					//Process title for saving into db
					if (!empty($data['title'])) {
						$data['title'] = str_replace("a href=","a link='#link' href=",$data['title']);
						$childLink = [];
						$data['title'] = html_entity_decode($data['title']);
						preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i',html_entity_decode($data['title']),$titleMatch);
						foreach ($titleMatch['href'] as $key => $obj) {							
						    if (!in_array($obj, $childLink)) {
						        array_push($childLink, $obj);
						        array_push($tagsArr, $obj);
						    }
						}
						$child_url = 'href="http://localhost/Mykronicle/observation/viewChild?childid='; 
						$data['title'] = str_replace('href="user_Child_',$child_url,$data['title']);
						$data['title'] = str_replace("&nbsp;"," ",$data['title']);
						$linkDom = new DOMDocument;
						$linkDom->loadHTML($data['title']);
						$allLinks = $linkDom->getElementsByTagName('a');
						$i = 0;
						foreach ($allLinks as $rawLink) {
						    $longLink = $rawLink->getAttribute('link');
					        $shortURL = $childLink[$i];
					        $rawLink->setAttribute('link', $shortURL);
					        $i++;
						}
						$data['title'] = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">','',$linkDom->saveHTML());
						$data['title'] = str_replace('<html><body>','',$data['title']);
						$data['title'] = str_replace('</body></html>','',$data['title']);
						$data['title'] = htmlspecialchars($data['title']);
					}

					//Process Notes for saving into db
					if (!empty($data['notes'])) {
						$data['notes'] = str_replace("a href=","a link='#link' href=",$data['notes']);
						$childLink = [];
						$data['notes'] = html_entity_decode($data['notes']);
						preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i',html_entity_decode($data['notes']),$notesMatch);
						foreach ($notesMatch['href'] as $key => $obj) {
						    if (!in_array($obj, $childLink)) {
						        array_push($childLink, $obj);
						        array_push($tagsArr, $obj);
						    }
						}

						$child_url = 'href="http://localhost/Mykronicle/observation/viewChild?childid='; 
						$data['notes'] = str_replace('href="user_Child_',$child_url,$data['notes']);
						$data['notes'] = str_replace("&nbsp;"," ",$data['notes']);
						$linkDom = new DOMDocument;
						$linkDom->loadHTML($data['notes']);
						$allLinks = $linkDom->getElementsByTagName('a');
						$i = 0;
						foreach ($allLinks as $rawLink) {
						    $longLink = $rawLink->getAttribute('link');
					        $shortURL = $childLink[$i];
					        $rawLink->setAttribute('link', $shortURL);
					        $i++;
						}
						$data['notes'] = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">','',$linkDom->saveHTML());
						$data['notes'] = str_replace('<html><body>','',$data['notes']);
						$data['notes'] = str_replace('</body></html>','',$data['notes']);
						$data['notes'] = htmlspecialchars($data['notes']);
					}

					//Process Reflections for saving into db
					if (!empty($data['reflection'])) {
						$data['reflection'] = str_replace("a href=","a link='#link' href=",$data['reflection']);
						$childLink = [];
						$data['reflection'] = html_entity_decode($data['reflection']);
						preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i',html_entity_decode($data['reflection']),$reflectionMatch);
						foreach ($reflectionMatch['href'] as $key => $obj) {
						    if (!in_array($obj, $childLink)) {
						        array_push($childLink, $obj);
						        array_push($tagsArr, $obj);
						    }
						}

						$child_url = 'href="http://localhost/Mykronicle/observation/viewChild?childid='; 
						$data['reflection'] = str_replace('href="user_Child_',$child_url,$data['reflection']);
						$data['reflection'] = str_replace("&nbsp;"," ",$data['reflection']);
						$linkDom = new DOMDocument;
						$linkDom->loadHTML($data['reflection']);
						$allLinks = $linkDom->getElementsByTagName('a');
						$i = 0;
						foreach ($allLinks as $rawLink) {
						    $longLink = $rawLink->getAttribute('link');
					        $shortURL = $childLink[$i];
					        $rawLink->setAttribute('link', $shortURL);
					        $i++;
						}
						$data['reflection'] = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">','',$linkDom->saveHTML());
						$data['reflection'] = str_replace('<html><body>','',$data['reflection']);
						$data['reflection'] = str_replace('</body></html>','',$data['reflection']);
						$data['reflection'] = htmlspecialchars($data['reflection']);
					}

					$data['childrens'] = json_decode($data['childrens']);

 					$this->ObservationModel->editObs($data);

 					$id = $data['observationId'];

 					$obsId = $id;

 					if (isset($data['origin'])) {
				  		$origin = json_decode($data['origin']);
				  		$countOrigin = count($origin);
				  	}

				  	if (isset($data['priority'])) {
				  		$priority = json_decode($data['priority']);
				  	}
				  	
				  	if (isset($countOrigin)) {
				  		for ($i=0; $i < $countOrigin ; $i++) { 
					  		if ($origin[$i]=="UPLOADED") {
					  			$getMediaInfo = $this->ObservationModel->getMediaInfo($priority[$i]);
					  			$mediaObj = new stdClass();
					  			$mediaObj->observationId = $id;
					  			$mediaObj->mediaUrl = $getMediaInfo->filename;
					  			$mediaObj->mediaType = $getMediaInfo->type;
					  			$mediaObj->caption = $getMediaInfo->caption;
					  			$mediaObj->priority = $i + 1;
					  			$mediaid = $this->ObservationModel->insertUploadedMedia($mediaObj);
					  			$childArrName = 'upl-media-tags-child'.$priority[$i];
					  			$childArr = json_decode($data[$childArrName]);
					  			foreach ($childArr as $child => $childObj) {
					  				$this->ObservationModel->insertUploadedMediaChildTags($mediaid,$childObj);
					  			}

					  			$educatorArrName = 'upl-media-tags-educator'.$priority[$i];
					  			$educatorArr = json_decode($data[$educatorArrName]);
					  			foreach ($educatorArr as $educator => $educatorObj) {
					  				$this->ObservationModel->insertUploadedMediaEducatorTags($mediaid,$educatorObj);
					  			}
					  		}elseif($origin[$i]=="NEW"){
					  			$obsMediaName = 'obsMedia'.$priority[$i];
					  			if (isset($_FILES[$obsMediaName])) {
					  				$target_dir = "assets/media/";
					  				$newName = uniqid();
					  				$target_file = $target_dir . basename($_FILES[$obsMediaName]["name"]);
					  				$file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					  				$newTarget = $target_dir . $newName . ".".$file_type;
					  				if ($file_type == "mp4" || $file_type == "jpg" || $file_type == "png" || $file_type == "jpeg") {
					  					if ($file_type == "mp4") {
						  					$type = "Video";
						  				} else {
						  					$type = "Image";
						  				}
					  					move_uploaded_file($_FILES[$obsMediaName]["tmp_name"], $newTarget);
					  					$mediaObj = new stdClass();
					  					$mediaObj->observationId = $id;
							  			$mediaObj->mediaUrl = $newName . "." . $file_type;
							  			$mediaObj->mediaType = $type;
							  			$caption = 'obsCaption_'.$priority[$i];
							  			$mediaObj->caption = isset($data[$caption])?$data[$caption]:NULL;
							  			$mediaObj->priority = $i + 1;
							  			$mediaid = $this->ObservationModel->insertUploadedMedia($mediaObj);

							  			$childArrName = 'obsImage_'.$priority[$i];
							  			if (isset($data[$childArrName])) {
							  				$childArr = json_decode($data[$childArrName]);
								  			foreach ($childArr as $child => $childObj) {
								  				$this->ObservationModel->insertUploadedMediaChildTags($mediaid,$childObj);
								  			}
							  			}

							  			$educatorArrName = 'obsEducator_'.$priority[$i];
							  			if (isset($data[$educatorArrName])) {
								  			$educatorArr = json_decode($data[$educatorArrName]);
								  			foreach ($educatorArr as $educator => $educatorObj) {
								  				$this->ObservationModel->insertUploadedMediaEducatorTags($mediaid,$educatorObj);
								  			}
								  		}
					  				}
					  			}
					  		}elseif($origin[$i]=="OBSERVED"){

					  			$mediaid = $data['obsMediaId_' . $i];
					  			$childArrName = 'obsImage_' . $i;
					  			if (isset($data[$childArrName])) {
					  				$childArr = json_decode($data[$childArrName]);
						  			foreach ($childArr as $child => $childObj) {
						  				$this->ObservationModel->insertUploadedMediaChildTags($mediaid,$childObj);
						  			}
					  			}

					  			$educatorArrName = 'obsEducator_' . $i;
					  			if (isset($data[$educatorArrName])) {
						  			$educatorArr = json_decode($data[$educatorArrName]);
						  			foreach ($educatorArr as $educator => $educatorObj) {
						  				$this->ObservationModel->insertUploadedMediaEducatorTags($mediaid,$educatorObj);
						  			}
						  		}
						  		
					  			$priority2 = $i + 1;
					  			$this->ObservationModel->updateObservedImagePriority($priority[$i],$priority2);
					  		}
					  	}
				  	}

				  	//inserting montessori subactivity taken from notes,title & reflection
				  	$tags = [];
				  	if (!empty($tagsArr)) {
					  	foreach ($tagsArr as $key => $obj) {
							if (preg_match("/tags_/i", $obj)) {
								$var = substr($obj,5);
								array_push($tags,$var);
							}
						}
					}

				  	if (!empty($tags)) {
				  		foreach($tags as $monObj){
				  			$this->ObservationModel->insertMonSubActFromTags($obsId,$monObj);
				  		}
				  	}

					http_response_code(200);
					$exportData['Status']='SUCCESS';
					$exportData['id'] = $data['observationId'];
				} else {
					http_response_code(401);
					$exportData['Status'] = "ERROR";
					$exportData['Message'] = "Invalid";
				}
			}else{
				http_response_code(401);
				$exportData['Status'] = "ERROR";
				$exportData['Message'] = "Invalid Request Method";
			}
		}else{
			$exportData['Status'] = "ERROR";
			$exportData['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($exportData);
	}

	public function getMediaTags()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){
					$media = $this->ObservationModel->getObsMediaById($json->mediaid);
					$childs = $this->ObservationModel->getObsMediaChildTags($json->mediaid);
					$educators = $this->ObservationModel->getObsMediaEducatorTags($json->mediaid);
					$data['Status'] = "SUCCESS";
					$data['MediaInfo'] = $media;
					$data['ChildTags'] = $childs;
					$data['EducatorTags'] = $educators;
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

	public function createComment()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$this->load->model('ObservationModel');
				if($json->id != null && $json->id != ""){
			    $this->ObservationModel->createComment($json);
					http_response_code(200);
					$data['Status']='SUCCESS';
				}
				else{
					http_response_code(401);
					$data['Status']='ERROR';
					$data['Message']='Observation Id cannot be empty';
				}
				echo json_encode($data);
			}
		}
		else{
			http_response_code(401);
		}
	}

	public function createMontessori(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if($json->observationId != null && $json->observationId != ""){
			    	if ($json->montessori != "") {
			    		$intCount = 1;
			    		foreach ($json->montessori as $key => $mon) {
			    			$mon->observationId = $json->observationId;
			    			$exist = $this->ObservationModel->montessoriExists($mon);
			    			if ($exist == 0) {
			    				$monId = $this->ObservationModel->createMontessori($mon);
			    				if (isset($mon->extras) && !empty($mon->extras)) {
			    					$count = count($mon->extras);
			    					$extVar = $mon->extras;
			    					for ($i=0; $i < $count; $i++) { 
			    						$ext = new stdClass();
			    						$ext->monId = $monId;
				    					$ext->extra = $extVar[$i];
			    						$existExtra = $this->ObservationModel->montessoriExtraExists($ext);
			    						if ($existExtra==0) {
			    							$array = ["monId"=>$monId,"idextra"=>$extVar[$i]];
			    							$this->ObservationModel->createMontessoriExtra($array);
			    						}
				    				}
			    				}
			    			}else{
			    				$monId = $this->ObservationModel->getMontId($mon);
			    				$this->ObservationModel->updateMontessori($mon);
			    				if (isset($mon->extras) && !empty($mon->extras)) {
			    					$count = count($mon->extras);
			    					$extVar = $mon->extras;
			    					for ($i=0; $i < $count; $i++) { 
			    						$ext = new stdClass();
			    						$ext->monId = $monId;
				    					$ext->idextra = $extVar[$i];
				    					$this->ObservationModel->deleteMontessoriExtra($ext);
				    					$array = ["monId"=>$monId,"idextra"=>$extVar[$i]];
		    							$this->ObservationModel->createMontessoriExtra($array);
			    					}
			    				}
			    			}

			    			$linkRecords = $this->ObservationModel->fetchSubactivityLinks($mon->idSubActivity);
			    			foreach ($linkRecords as $linkKey => $linkObj) {			    				
			    				$eylf_sub_act = $this->ObservationModel->getEylfSubActsInfo($linkObj->eylf_sub_act);
			    				$dummyObj = new stdClass();
			    				$dummyObj->obsid = $json->observationId;
			    				$dummyObj->eylfActId = $eylf_sub_act->activityid;
			    				$dummyObj->eylfSubActId = $linkObj->eylf_sub_act;
			    				if ($intCount == 1) {
			    					$res = $this->ObservationModel->removeObservationEYLF($dummyObj);
			    					$this->ObservationModel->insertObservationEYLF($dummyObj);
			    					echo $res;
				    				$intCount++;
			    				}else{
			    					$res = $this->ObservationModel->insertObservationEYLF($dummyObj);
				    				$intCount++;
			    				}
			    			}
			    		}

			    		//get childrens of observation
		    			$obsChildArr = $this->ObservationModel->getObservationChildrens($json->observationId);

		    			$records = [];
		    			$rec = [];

		 				#Build arr to check existing records in db userprogressplan table 
		 				foreach ($obsChildArr as $childArr => $childObj) {
		 					foreach ($json->montessori as $key => $mon) {
		 						$monSubArr = $this->ObservationModel->getMonSubActs($mon->idSubActivity);
	    						$rec['child_id'] = $childObj->child_id;
	    						$rec['child_name'] = $childObj->child_name;
	    						$rec['sub_activity_id'] = $mon->idSubActivity;
	    						$rec['activity_id'] = $monSubArr->idActivity;
	    						$rec['assessment'] = $mon->assessment;
	    						$rec['userid'] = $json->userid;
	    						array_push($records,$rec);
		    				}
		 				}
	    				#check if record exists in db
	    				foreach ($records as $reco => $obj) {
	    					$assessRecord = $this->ObservationModel->checkMonAssessRecord($obj);
	    					if (empty($assessRecord)) {
	    						//insert new record
	    						$this->ObservationModel->insertMonProgPlan($obj);	    						
	    					}else{
	    						//update the existing record
	    						$obj['id'] = $assessRecord->id;
	    						$this->ObservationModel->updateMonProgPlan($obj);	    						
	    					}
	    				}
			    	}
			    	$data['Status']='SUCCESS';
					$data['Message']='Montessori saved successfully.';
				}else{
					http_response_code(401);
					$data['Status']='ERROR';
					$data['Message']='Observation Id cannot be empty';
				}
			}
		}
		else{
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function editMontessori(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){
					$this->ObservationModel->createMontessori($json);
					http_response_code(200);
					$data['Status'] = "SUCCESS";
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

	public function createMilstones()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$this->load->model('ObservationModel');
				if($json->observationId != null && $json->observationId != ""){
			    	$this->ObservationModel->createMilstones($json);
					http_response_code(200);
					$data['Status']='SUCCESS';
					$data['id']=$json->observationId;
				}
				else{
					http_response_code(401);
					$data['Status']='ERROR';
					$data['Message'] = 'Observation Id cannot be empty';
				}
			}else{
				http_response_code(401);
				$data['Status']='ERROR';
				$data['Message'] = 'Invalid Data Passed';
			}
				echo json_encode($data);
		}
		else{
			http_response_code(401);
		}
	}

	public function editMilestones()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$this->load->model('ObservationModel');
				if($json->observationId != null && $json->observationId != ""){

					$milestonesId = $this->ObservationModel->getAllObsMilestones($json->observationId);

					$this->ObservationModel->deleteMilestone($json->observationId);

					foreach ($milestonesId as $miles => $mil) {
						$this->ObservationModel->deleteMilestoneExtras($mil->id);
					}
					foreach ($json->milestones as $milestonez => $milest) {
						$milest->observationId = $json->observationId;
					}

			    	$this->ObservationModel->insertDevMilestone($json);

					http_response_code(200);
					$data['Status']='SUCCESS';
					$data['id']=$json->observationId;
				}else{
					http_response_code(401);
					$data['Status']='ERROR';
					$data['Message'] = 'Observation Id cannot be empty';
				}
			}else{
				http_response_code(401);
				$data['Status']='ERROR';
				$data['Message'] = 'Invalid Data Passed';
			}
				echo json_encode($data);
		}
		else{
			http_response_code(401);
		}
	}

	public function createLinks(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				// $Data = json_decode($json);
			    $this->ObservationModel->createLinks($json);
				http_response_code(200);
				$data['Status']='SUCCESS';
				$data['id']=$json->observationId;
			} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid";
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Headers Sent!";
				http_response_code(401);
		}
		echo json_encode($data);
	}

	public function editLinks(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
				$this->load->model('LoginModel');
				$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
				// $json = json_decode(file_get_contents('php://input'));
				if($_POST!= null && $res != null && $res->userid == $_POST['userid']){
					$this->load->model('ObservationModel');
					$Data = $_POST;
					$Data['link'] = json_decode($_POST['link']);
				    $this->ObservationModel->createLinks($Data);
					http_response_code(200);
					$data['Status']='SUCCESS';
					$data['id']=$_POST['observationId'];
				}
				 else {
							http_response_code(401);
							$data['Status'] = "ERROR";
							$data['Message'] = "Invalid";
					}
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid Headers Sent!";
					http_response_code(401);
						echo json_encode($data);
		}
	}

	public function createEylf()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$this->load->model('ObservationModel');
		    $this->ObservationModel->createEylf($json);
				http_response_code(200);
				$data['status']='Success';
				$data['id']=$json->observationId;
				echo json_encode($data);
			}
		}
		else{
			http_response_code(401);
		}
	}

	public function editEylf()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){
					$this->ObservationModel->createEylf($json);
					http_response_code(200);
					$data['Status'] = "SUCCESS";
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

	public function getChildren()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$user_id = $_GET['userid'];
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$child = [];
				if(isset($_GET['centerId'])){
					$roomsArr = $this->ObservationModel->getCenterRooms($_GET['centerId']);
					foreach ($roomsArr as $key => $rm) {
						$childArr = $this->ObservationModel->getChildsFromRoom($rm->id);
						foreach ($childArr as $key => $value) {
							array_push($child, $value);
						}
					}
				} else if(isset($_GET['parentId'])) {
					$child = $this->ObservationModel->getChildsOfParent($_GET['parentId']);
				} else {
					// $child=$this->ObservationModel->getChilds();
					$child = [];
				}
				$data['child']=$child;
				$data['Status'] = "SUCCESS";
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid didn't match!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers sent!";
		}
		echo json_encode($data);
	}

	public function getFilterObservations($user_id,$id)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$json = json_decode(file_get_contents('php://input'));
				$data=array();
				$filter_data=array(
					'userid'=>$user_id,
				   	'id'=>$id,
				   	'filter_children'=>isset($json->childs) ? $json->childs : null,
				   	'filter_authors'=>isset($json->authors) ? $json->authors : null,
				   	'filter_assessments'=>isset($json->assessments) ? $json->assessments : null
				);
			    $observations=$this->ObservationModel->getFilterObservations($filter_data);
				foreach($observations as $observation)
				{
					$childs=$this->ObservationModel->getObservationChildrens($observation->id);
					$media=$this->ObservationModel->getMedia($observation->id);
					$obs=$this->ObservationModel->getObservationUser($observation->id);
					$montessoryCount=$this->ObservationModel->getObservationMontessoriCount($observation->id);
					$eylfCount=$this->ObservationModel->getObservationEylfCount($observation->id);
					$milestoneCount=$this->ObservationModel->getObservationMilestoneCount($observation->id);
					// $data['Status'] = "SUCCESS";
					$data['observations'][$observation->id]=array(
						'title'=>$obs->title,
						'userName'=>$obs->user_name,
						'status'=>$obs->status,
						'approverName'=>$obs->approverName,
						'childs'=>$childs,
						'montessoryCount'=>$montessoryCount,
						'eylfCount'=>$eylfCount,
						'milestoneCount'=>$milestoneCount,
						'media'=>isset($media[0]->mediaUrl)?$media[0]->mediaUrl:'');
				}
				http_response_code(200);
				echo json_encode($data);
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid data passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function getListFilterObservations($user_id=NULL)
	{

		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if ($user_id==NULL) { $user_id = $json->userid; }

			if ($json!= null && $res != null && $res->userid == $user_id) {
				$data=array();

				$data['Status']="SUCCESS";

				$filter_data = array(
					'userid'=>$user_id,
					'filter_children'=>isset($json->childs) ? $json->childs : null,
					'filter_authors'=>isset($json->authors) ? $json->authors : null ,
					'filter_observationss'=>isset($json->observations) ? $json->observations : null ,
					'filter_added'=>isset($json->added) ? $json->added : null ,
					'filter_comments'=>isset($json->comments) ? $json->comments : null ,
					'filter_links'=>isset($json->links) ? $json->links : null ,
					'filter_media'=>isset($json->media) ? $json->media : null ,
					'filter_assessments'=>isset($json->assessments) ? $json->assessments : null 
				);

			    $observations = $this->ObservationModel->getListFilterObservations($filter_data);

			    if (empty($observations)) {
			    	$data['observations'] = [];
			    } else {
					foreach($observations as $observation){
						$childs=$this->ObservationModel->getObservationChildrens($observation->id);
						$media=$this->ObservationModel->getMedia($observation->id);
						$obs=$this->ObservationModel->getObservationUser($observation->id);
						$montessoryCount=$this->ObservationModel->getObservationMontessoriCount($observation->id);
						$eylfCount=$this->ObservationModel->getObservationEylfCount($observation->id);
						$milestoneCount=$this->ObservationModel->getObservationMilestoneCount($observation->id);
						$data['observations'][] = array(
							'id'=>$observation->id,
							'date_added'=>date('d.m.Y',strtotime($observation->date_added)),
							'title'=>strip_tags(html_entity_decode($obs->title)),
							'userName'=>$obs->user_name,
							'status'=>$obs->status,
							'approverName'=>$obs->approverName,
							'childs'=>$childs,
							'montessoryCount'=>$montessoryCount,
							'eylfCount'=>$eylfCount,
							'milestoneCount'=>$milestoneCount,
							'media'=>isset($media[0]->mediaUrl)?$media[0]->mediaUrl:''
						);
					}
				}
				
			}else{
				http_response_code(401);
				$data['Status'] = "SUCCESS";
				$data['Message'] = "Userid didn't match!";
			}
		}else{
			http_response_code(401);
			$data['Status'] = "SUCCESS";
			$data['Message'] = "Invalid headers used!";
		}
		echo json_encode($data);
	}

	public function getObservation($user_id,$id)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$data['Status']="SUCCESS";
				$obsList = $this->ObservationModel->getObservationUser($id);
				$obsList->title = trim(stripslashes(html_entity_decode($obsList->title)));
				$obsList->notes = trim(stripslashes(html_entity_decode($obsList->notes)));
				$obsList->reflection = trim(stripslashes(html_entity_decode($obsList->reflection)));
			    $data['observation']=$obsList;
			    
				$data['observationChildrens']=$this->ObservationModel->getObservationChildrens($id);

				$data['observationMedia']=$this->ObservationModel->getobservationMedia($id);
				foreach ($data['observationMedia'] as $obsMedia => $om) {
					$om->childs = $this->ObservationModel->getObsMediaChildTags($om->id);
					$om->educators = $this->ObservationModel->getObsMediaEducatorTags($om->id);
				}

				$data['observationComments']=$this->ObservationModel->getobservationComments($id);

				$data['observationMontessori']=$this->ObservationModel->getobservationMontessori($id);
				$data['obsMontessori'] = $this->ObservationModel->getobsMontessori($id);
				foreach ($data['obsMontessori'] as $obs) {
					$obs->idExtra = [];
					$extra = $this->ObservationModel->getObservationMontessoriExtras($obs->id);
					foreach ($extra as $key => $value) {
						array_push($obs->idExtra,$value->idextra);
					}
				}

				

				$data['observationEylf']=$this->ObservationModel->getobservationEylf($id);
				$observationEylfDetails=$this->ObservationModel->getobservationEylfDetails($id);
				$data['observationEylfDetails']=array(); 
				$data['outcomes']=array(); 
				$data['eylfActivites']=array();
				foreach($observationEylfDetails as $observationEylfDetail)
				{
					$data['observationEylfDetails'][$observationEylfDetail->outcomeId][$observationEylfDetail->activityId][]=$observationEylfDetail->subactivityName;
				    $data['outcomes'][$observationEylfDetail->outcomeId]=$observationEylfDetail->name;
					$data['eylfActivites'][$observationEylfDetail->activityId]=$observationEylfDetail->activityName;
				}

				$observationMontessoriDetails=$this->ObservationModel->getobservationMontessoriDetails($id);
				$data['observationMontessoriDetails']=array(); 
				$data['subjects']=array(); 
				$data['montessoriActivites']=array();
				foreach($observationMontessoriDetails as $observationMontessoriDetail)
				{
					$data['observationMontessoriDetails'][$observationMontessoriDetail->idSubject][$observationMontessoriDetail->idActivity][]=	
					array('extra'=>$observationMontessoriDetail->extraName,	
						  'subactivityName'=>$observationMontessoriDetail->subactivityName,	
						  'subject'=>$observationMontessoriDetail->subject);	
				    $data['subjects'][$observationMontessoriDetail->idSubject]=$observationMontessoriDetail->name;	
					$data['montessoriActivites'][$observationMontessoriDetail->idActivity]=$observationMontessoriDetail->title;
				}
				$observationMilestoneDetails=$this->ObservationModel->getobservationMilestoneDetails($id);
				$data['observationMilestoneDetails']=array(); 
				$data['milestonesubjects']=array(); 
				$data['milestoneActivites']=array();
				foreach($observationMilestoneDetails as $observationMilestoneDetail)
				{
					$data['observationMilestoneDetails'][$observationMilestoneDetail->id][$observationMilestoneDetail->idActivity][]=
					array(
						// 'extra'=>$observationMilestoneDetail->extraName,
						  'subactivityName'=>$observationMilestoneDetail->subactivityName,
						  'subject'=>$observationMilestoneDetail->subject
						  );
				    $data['milestonesubjects'][$observationMilestoneDetail->id]=$observationMilestoneDetail->ageGroup;
					$data['milestoneActivites'][$observationMilestoneDetail->idActivity]=$observationMilestoneDetail->title;
				}

				$data['observationMilestones']=$this->ObservationModel->getobservationMilestones($id);
				foreach($data['observationMilestones'] as $ob){
					$ar = $this->ObservationModel->getObservationMilestoneExtras($ob->id);
					$array = [];
					foreach($ar as $a){
						array_push($array,$a->idExtra);
					}
					$ob->idExtras = $array;
				}


				$linksArr = $this->ObservationModel->getAllObservationLinks($id);
				$allLinks = [];

				foreach ($linksArr as $linksKey => $linksObj) {

					$demoLinks = [];
					$demoLinks['id'] = $linksObj->id;
					$demoLinks['linkedId'] = $linksObj->linkid;

					if($linksObj->linktype == "OBSERVATION"){

						$obsInfo = $this->ObservationModel->getObservationInfo($linksObj->linkid);
						$obsMedia = $this->ObservationModel->getobservationMedia($linksObj->linkid);

						$demoLinks['type'] = $linksObj->linktype;
						$demoLinks['title'] = $obsInfo->title;
						$demoLinks['status'] = $obsInfo->status;
						$demoLinks['media'] = isset($media[0]->mediaUrl)?$media[0]->mediaUrl:'no-image.png';
						$demoLinks['childrens'] = $this->ObservationModel->getObservationChildrens($linksObj->linkid);
						$demoLinks['author'] = $obsInfo->approver;
						$demoLinks['createdAt'] = date('d.m.Y h:i:s', strtotime($obsInfo->date_added));
						$demoLinks['montessoryCount'] = $this->ObservationModel->getObservationMontessoriCount($linksObj->linkid);
						$demoLinks['eylfCount'] = $this->ObservationModel->getObservationEylfCount($linksObj->linkid);
						$demoLinks['milestoneCount'] = $this->ObservationModel->getObservationMilestoneCount($linksObj->linkid);

					} else if ($linksObj->linktype == "REFLECTION"){

						$ref = $this->ObservationModel->getReflectionInfo($linksObj->linkid);
						$refMedia = $this->ObservationModel->getReflectionMedia($linksObj->linkid);
						if(empty($ref)){
							$demoLinks['type'] = $linksObj->linktype;
							$demoLinks['title'] = NULL;
							$demoLinks['status'] = NULL;
							$demoLinks['author'] = NULL;
							$demoLinks['media'] = NULL;
							$demoLinks['childrens'] = NULL;
							$demoLinks['createdAt'] = NULL;
						}else{
							$demoLinks['type'] = $linksObj->linktype;
							$demoLinks['title'] = $ref->title;
							$demoLinks['status'] = $ref->status;
							$demoLinks['author'] = $ref->approver;
							$demoLinks['media'] = isset($refMedia[0]->mediaUrl)?$refMedia[0]->mediaUrl:'no-image.png';
							$demoLinks['childrens'] = $this->ObservationModel->getReflectionChildrens($linksObj->linkid);
							$demoLinks['createdAt'] = date('d.m.Y h:i:s', strtotime($ref->date_added));
						}
						

					} else if ($linksObj->linktype == "QIP"){

						$qipObj = $this->ObservationModel->fetchQipInfo($linksObj->linkid);
					
						$demoLinks['type'] = $linksObj->linktype;
						$demoLinks['title'] = $qipObj->name;
						$demoLinks['author'] = $qipObj->approver;
						$demoLinks['createdAt'] = date('d.m.Y h:i:s', strtotime($qipObj->date_added));

					} else if ($linksObj->linktype == "PROGRAMPLAN"){

						$ppObj = $this->ObservationModel->fetchProgramPlanInfo($linksObj->linkid);
						$demoLinks['title'] = date('d-m-Y',strtotime($ppObj->startdate)) . "/" . date('d-m-Y',strtotime($ppObj->enddate));
						$demoLinks['author'] = $ppObj->approver;
						$demoLinks['createdAt'] = date('d.m.Y h:i:s', strtotime($ppObj->date_added));
						$demoLinks['type'] = $linksObj->linktype;
					}

					$allLinks[] = $demoLinks;
				}
				
				http_response_code(200);
				$data['Status'] = "SUCCESS";
				$data['links'] = $allLinks;
				$data['permissions'] = $this->UtilModel->getPermissions($user_id,$obsList->centerid);
			}
			echo json_encode($data);
		}else{
			http_response_code(401);
		}
	}

	public function getUploadedMediaFiles($user_id='')
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$uploadedMediaList = $this->ObservationModel->getUploadedMedia($user_id);
				$data['Status'] = 'SUCCESS';
				$data['uploadedMediaList'] = $uploadedMediaList;
				http_response_code(200);
				echo json_encode($data);
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message']="Invalid Headers Sent!";
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function getListObservations($user_id,$centerid,$page=1)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$permission = $this->UtilModel->getPermissions($user_id,$centerid);
				$filter_data=array(
					'start' => ($page - 1) * 10,
                	'limit' => 10,
               		'centerid' => $centerid
               	);
               	$userArr = $this->LoginModel->getUserFromId($user_id);
				 //echo $userArr->userType; exit;
                if ($userArr->userType == "Parent") {
					$observations = $this->ObservationModel->getParentObsIds($user_id,$centerid);
                }else{
					$observations = $this->ObservationModel->getObservationsList($filter_data);
                }

				$observationTotal = $this->ObservationModel->getObservationsTotal($filter_data);
				$data['childs'] = $this->ObservationModel->getChilds();
				$data['observationsTotal'] = $observationTotal->total;
				$data['observations'] = array();
				foreach($observations as $observation)
				{
					// $observation->title = trim(stripslashes(strip_tags(html_entity_decode($observation->title))));
					$observationsMedia=$this->ObservationModel->getMedia($observation->id);
					if(!empty($observationsMedia))
					{
						$observation->observationsMedia=$observationsMedia[0]->mediaUrl;
						$observation->observationsMediaType=$observationsMedia[0]->mediaType;
					}
					$observation->observationChildrens=$this->ObservationModel->getObservationChildrens($observation->id);
					$observation->montessoricount=$this->ObservationModel->getObservationMontessoriCount($observation->id);
					$observation->eylfcount=$this->ObservationModel->getObservationEylfCount($observation->id);
					$observation->milestonecount=$this->ObservationModel->getObservationMilestoneCount($observation->id);
				}
				$data['Status'] = 'SUCCESS';
				$data['observations']=$observations;
				$data['centerid'] = $centerid;
				$data['permissions'] = $permission;
				http_response_code(200);
				echo json_encode($data);
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message']="Invalid Headers Sent!";
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}
	
	public function getObservations($user_id,$id='')
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
			    $data['observations']=$this->ObservationModel->getObservations($id);
				$observationsMedia=$this->ObservationModel->getObservationsMedia($id);
				$data['observationsMedia']=array();
				foreach($observationsMedia as $obmedia)
				{
					$data['observationsMedia'][$obmedia->observationId]=$obmedia->mediaUrl;
				}
				$childrens=$this->ObservationModel->getObservationsChildrens($id);
				$montessoriescount=$this->ObservationModel->getMontessoriCount($id);
				foreach($montessoriescount as $montessory)
				{
					$data['montessoryCount'][$montessory->observationId]=$montessory->total;
				}
				$eylfcount=$this->ObservationModel->getEylfCount($id);
				foreach($eylfcount as $montessory)
				{
					$data['eylfCount'][$montessory->observationId]=$montessory->total;
				}
				$milestonescount=$this->ObservationModel->getMileCount($id);
				foreach($milestonescount as $montessory)
				{
					$data['milestoneCount'][$montessory->observationId]=$montessory->total;
				}
				foreach($childrens as $child)
				{
					$data['childrens'][$child->observationId][]=$child;
				}
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function getPublishedObsAndRef($user_id,$id)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id != null && $res != null && $res->userid == $user_id){
			  	$observations = $this->ObservationModel->getPublishedObservations($id);
				foreach($observations as $observation)
				{
					$media=$this->ObservationModel->getMedia($observation->id);
					$observation->media=isset($media[0]->mediaUrl)?$media[0]->mediaUrl:'';
					$observationsMedia=$this->ObservationModel->getMedia($observation->id);
					$observation->observationsMedia=isset($observationsMedia[0]->mediaUrl)?$observationsMedia[0]->mediaUrl:'';
					$observation->observationsMediaType=isset($observationsMedia[0]->mediaType)?$observationsMedia[0]->mediaType:'';
					$childs=$this->ObservationModel->getObservationChildrens($observation->id);
					$observation->childs=$childs;
					$montessoryCount=$this->ObservationModel->getObservationMontessoriCount($observation->id);
					$observation->montessoryCount=$montessoryCount;
					$eylfCount=$this->ObservationModel->getObservationEylfCount($observation->id);
					$observation->eylfCount=$eylfCount;
					$milestoneCount=$this->ObservationModel->getObservationMilestoneCount($observation->id);
					$observation->milestoneCount=$milestoneCount;
				}
				$data['Status'] = "SUCCESS";
				$data['observations']=$observations;
				$data['reflections'] = $this->ObservationModel->getPublishedReflections();
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function getPublishedObservations($user_id,$id)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
			    $observations = $this->ObservationModel->getPublishedObservations($id);
				$data['observations']=array();
				foreach($observations as $observation)
				{
					$observation->title = strip_tags(html_entity_decode($observation->title));
					$media=$this->ObservationModel->getMedia($observation->id);
					$observation->media=isset($media[0]->mediaUrl)?$media[0]->mediaUrl:'';
					$observationsMedia=$this->ObservationModel->getMedia($observation->id);
					$observation->observationsMedia=isset($observationsMedia[0]->mediaUrl)?$observationsMedia[0]->mediaUrl:'';
					$observation->observationsMediaType=isset($observationsMedia[0]->mediaType)?$observationsMedia[0]->mediaType:'';
					$childs=$this->ObservationModel->getObservationChildrens($observation->id);
					$observation->childs=$childs;
					$montessoryCount=$this->ObservationModel->getObservationMontessoriCount($observation->id);
					$observation->montessoryCount=$montessoryCount;
					$eylfCount=$this->ObservationModel->getObservationEylfCount($observation->id);
					$observation->eylfCount=$eylfCount;
					$milestoneCount=$this->ObservationModel->getObservationMilestoneCount($observation->id);
					$observation->milestoneCount=$milestoneCount;
					$data['Status'] = "SUCCESS";
					$data['observations'][]=$observation;
				}
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getAllPublishedObservations($user_id="",$centerid="")
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
			    $observations = $this->ObservationModel->getPublishedObservationsFromCenter($centerid);
				$data['observations']=array();
				foreach($observations as $observation)
				{
					$observation->title = strip_tags(html_entity_decode($observation->title));					
					$media=$this->ObservationModel->getMedia($observation->id);
					$observation->media=isset($media[0]->mediaUrl)?$media[0]->mediaUrl:'';
					$observationsMedia=$this->ObservationModel->getMedia($observation->id);
					$observation->observationsMedia=isset($observationsMedia[0]->mediaUrl)?$observationsMedia[0]->mediaUrl:'';
					$observation->observationsMediaType=isset($observationsMedia[0]->mediaType)?$observationsMedia[0]->mediaType:'';
					$childs=$this->ObservationModel->getObservationChildrens($observation->id);
					$observation->childs=$childs;
					$montessoryCount=$this->ObservationModel->getObservationMontessoriCount($observation->id);
					$observation->montessoryCount=$montessoryCount;
					$eylfCount=$this->ObservationModel->getObservationEylfCount($observation->id);
					$observation->eylfCount=$eylfCount;
					$milestoneCount=$this->ObservationModel->getObservationMilestoneCount($observation->id);
					$observation->milestoneCount = $milestoneCount;
					$observation->date_added = date('d-m-Y',strtotime($observation->date_added));
					$data['Status'] = "SUCCESS";
					$data['observations'][]=$observation;
				}
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function getPublishedReflections($userid,$centerid = "")
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $res->userid == $userid){
				http_response_code(200);
				$data['Status'] = "SUCCESS";
				$data['reflections'] = $this->ObservationModel->getPublishedReflections($centerid);
			}else{
				http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="User Id doesn't match";
			}
		}else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getEducators($userid,$centerid=NULL)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $res->userid == $userid){

				if ($centerid==NULL) {
					$educators = $this->ObservationModel->getEducators();
				} else {
					$educators = $this->ObservationModel->getEducators($centerid);
				}

				http_response_code(200);
				$data['Status'] = "SUCCESS";
				$data['Educators'] = $educators;
				
			}else{
				http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="User Id doesn't match";
			}
		}else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function  getPublishedObservations2($user_id,$id)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
			    $observations=$this->ObservationModel->getPublishedObservations($id);
				$data['observations']=array();
				foreach($observations as $observation)
				{
					$observationsMedia=$this->ObservationModel->getMedia($observation->id);
					$observation->observationsMedia=isset($observationsMedia[0]->mediaUrl)?$observationsMedia[0]->mediaUrl:'';
					$observation->observationsMediaType=isset($observationsMedia[0]->mediaType)?$observationsMedia[0]->mediaType:'';
					$childs=$this->ObservationModel->getObservationChildrens($observation->id);
					$observation->childs=$childs;
					$montessoryCount=$this->ObservationModel->getObservationMontessoriCount($observation->id);
					$observation->montessoricount=$montessoryCount;
					$eylfCount=$this->ObservationModel->getObservationEylfCount($observation->id);
					$observation->eylfcount=$eylfCount;
					$milestoneCount=$this->ObservationModel->getObservationMilestoneCount($observation->id);
					$observation->milestonecount=$milestoneCount;
					$data['Status'] = "SUCCESS";
					$data['observations'][]=$observation;
				}
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  deleteLink($user_id,$id,$linkId)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
			    $this->ObservationModel->deleteLink($id,$linkId);
				$data['status']='SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  deleteLinkbyId($user_id,$linkId)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
			    $this->ObservationModel->deleteLinkbyId($linkId);
				$data['status']='SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function getChildrenGroups($user_id)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$userArr = $this->LoginModel->getUserFromId($user_id);
                
                if ($userArr->userType == "Parent") {
                	$data=array();
					$groups=$this->ObservationModel->getParentChildGroups($user_id);
					foreach($groups as $group)
					{
						$data[$group->group_name][]=$group;
					}
                }else{
                	$data=array();
					$groups=$this->ObservationModel->getChildGroups();
					foreach($groups as $group)
					{
						$data[$group->group_name][]=$group;
					}
                }

				
				http_response_code(200);
				$data['Status'] = "SUCCESS";
				echo json_encode($data);
			}else{
				http_response_code(401);
				$data['Status'] ="ERROR";
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getMontessoriActivites($user_id,$centerid='')
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
				$data = $this->ObservationModel->getCenterMontessoriActivities($centerid);
				// $data['Status'] = "SUCCESS";
				http_response_code(200);
				echo json_encode($data);
			}else{
				// $data['Status'] = "ERROR";
				// $data['Message'] = "Invalid Data Passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getMontessoriSubjects($user_id)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
				$data = $this->ObservationModel->getMontessoriSubjects();
				// $data['Status'] = "SUCCESS";
				http_response_code(200);
				echo json_encode($data);
			}else{
				// $data['Status'] = "ERROR";
				// $data['Message'] = "Invalid Data Passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getMontessoriSubActivites($user_id,$centerid='')
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
				$data=$this->ObservationModel->getMontessoriSubActivites($centerid);
				// $data['Status'] = 'SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}else{
				// $data['Status'] = "ERROR";
				// $data['Message'] = "Invalid Data Passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getMontessoriExtras($user_id,$centerid='')
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
				$data=$this->ObservationModel->getMontessoriExtras($centerid);
				// $data['Status'] = 'SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}else{
				// $data['Status'] = "ERROR";
				// $data['Message'] = "Invalid Data Passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getEylfOutcomes($user_id)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
				$data=$this->ObservationModel->getEylfOutcomes();
				// $data['Status'] = 'SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}else{
				// $data['Status'] = "ERROR";
				// $data['Message'] = "Invalid Data Passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getEylfActivites($user_id,$centerid='')
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
				$data=$this->ObservationModel->getEylfActivites($centerid);
				// $data['Status'] = 'SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}else{
				// $data['Status'] = "ERROR";
				// $data['Message'] = "Invalid Data Passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getEylfSubActivites($user_id,$centerid="")
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
				$data=$this->ObservationModel->getEylfSubActivites($centerid);
				// $data['Status'] = 'SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}else{
				// $data['Status'] = "ERROR";
				// $data['Message'] = "Invalid Data Passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getDevelopmentalMilestone($user_id,$centerid="")
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
				$data=$this->ObservationModel->getDevelopmentalMilestone($centerid);
				// $data['Status'] = 'SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}else{
				// $data['Status'] = "ERROR";
				// $data['Message'] = "Invalid Data Passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getDevelopmentalMilestoneActivites($user_id,$centerid="")
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
				$data=$this->ObservationModel->getDevelopmentalMilestoneActivites($centerid);
				// $data['Status'] = 'SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}else{
				// $data['Status'] = "ERROR";
				// $data['Message'] = "Invalid Data Passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getDevelopmentalMilestoneExtras($user_id)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
				$data=$this->ObservationModel->getDevelopmentalMilestoneExtras();
				// $data['Status'] = 'SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}else{
				// $data['Status'] = "ERROR";
				// $data['Message'] = "Invalid Data Passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getDevelopmentalMilestoneSubActivites($user_id,$centerid="")
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('ObservationModel');
				$data=$this->ObservationModel->getDevelopmentalMilestoneSubActivites($centerid);
				// $data['Status'] = 'SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}else{
				// $data['Status'] = "ERROR";
				// $data['Message'] = "Invalid Data Passed";
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	//Sagar Coded from this onward

	public function getAssessments()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$data=array();
				$data['Status']='SUCCESS';
				$data['Montessori']=[];
				$data['Montessori']['Subjects']=$this->ObservationModel->getMontessoriSubjects();
				foreach ($data['Montessori']['Subjects'] as $subject => $sub) {
					$subId = $sub->idSubject;
					$sub->activity = $this->ObservationModel->getMontessoriActivities($subId);
					foreach ($sub->activity as $activity) {
						$activityId = $activity->idActivity;
						$activity->SubActivity = $this->ObservationModel->getMontessoriSubActivities($activityId);
						foreach ($activity->SubActivity as $subActivity) {
							$subActivityId = $subActivity->idSubActivity;
							$subActivity->extras = $this->ObservationModel->getMontSubActExtras($subActivityId);
						}
					}
				}
				
				$data['EYLF']=[];
				$data['EYLF']['outcome'] = $this->ObservationModel->getEylfOutcomes();
				foreach ($data['EYLF']['outcome'] as $outcome) {
					$outcomeId = $outcome->id;
					$outcome->activity = $this->ObservationModel->getEylfActivities($outcomeId);
					foreach ($outcome->activity as $activity) {
						$activityId = $activity->id;
						$activity->subActivity = $this->ObservationModel->getEylfSubActivities($activityId);
					}
				}
				$data['DevelopmentalMilestones']=[];
				$data['DevelopmentalMilestones']['ageGroups'] = $this->ObservationModel->getDevelopmentalMilestones();
				foreach ($data['DevelopmentalMilestones']['ageGroups'] as $ageGroup) {
					$ageGroupId = $ageGroup->id;
					$ageGroup->subname = $this->ObservationModel->getDevMileMain($ageGroupId);
					foreach ($ageGroup->subname as $subName) {
						$subId = $subName->id;

						$subName->title = $this->ObservationModel->getDevMileSub($subId);
						foreach ($subName->title as $title) {
							$titleId = $title->id;
							$title->options = $this->ObservationModel->getDevMileExtra($titleId);
						}
					}
				}
				http_response_code(200);
				echo json_encode($data);
			}else{
				http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="User Id doesn't match";
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
			echo json_encode($data);
		}
	}

	public function getAssessment($obsId=NULL)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$data=array();
				$data['Status']='SUCCESS';
				$data['Montessori']=[];
				$data['Montessori']['Subjects']=$this->ObservationModel->getMontessoriSubjects();
				foreach ($data['Montessori']['Subjects'] as $subject => $sub) {
					$subId = $sub->idSubject;
					$sub->activity = $this->ObservationModel->getMontessoriActivities($subId);
					foreach ($sub->activity as $activity) {
						$activityId = $activity->idActivity;
						$activity->SubActivity = $this->ObservationModel->getMontessoriSubActivities($activityId);
						foreach ($activity->SubActivity as $subActivity) {
							$subActivityId = $subActivity->idSubActivity;
							$subActivity->extras = $this->ObservationModel->getMontSubActExtras($subActivityId);
						}
					}
				}
				
				$data['EYLF']=[];
				$data['EYLF']['outcome'] = $this->ObservationModel->getEylfOutcomes();
				foreach ($data['EYLF']['outcome'] as $outcome) {
					$outcomeId = $outcome->id;
					$outcome->activity = $this->ObservationModel->getEylfActivities($outcomeId);
					foreach ($outcome->activity as $activity) {
						$activityId = $activity->id;
						$activity->subActivity = $this->ObservationModel->getEylfSubActivities($activityId);
					}
				}
				$data['DevelopmentalMilestones']=[];
				$data['DevelopmentalMilestones']['ageGroups'] = $this->ObservationModel->getDevelopmentalMilestones();
				foreach ($data['DevelopmentalMilestones']['ageGroups'] as $ageGroup) {
					$ageGroupId = $ageGroup->id;
					$ageGroup->subname = $this->ObservationModel->getDevMileMain($ageGroupId);
					foreach ($ageGroup->subname as $subName) {
						$subId = $subName->id;

						$subName->title = $this->ObservationModel->getDevMileSub($subId);
						foreach ($subName->title as $title) {
							$titleId = $title->id;
							$title->options = $this->ObservationModel->getDevMileExtra($titleId);
						}
					}
				}
				http_response_code(200);
				echo json_encode($data);
			}else{
				http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="User Id doesn't match";
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
			echo json_encode($data);
		}
	}

	public function deleteMedia($userid,$mediaId)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				if($res != null && $res->userid == $userid){
						$this->ObservationModel->deleteMedia($mediaId);
					http_response_code(200);
					$data['Status'] = "SUCCESS";
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

	public function createObsLinks()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
				$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
				// $json = json_decode(file_get_contents('php://input'));
				if($_POST!= null && $res != null && $res->userid == $_POST['userid']){
					$Data = $_POST;
					$Data['link'] = json_decode($_POST['link']);
				  $this->ObservationModel->createObsLinks($Data);
					http_response_code(200);
					$data['Status']='SUCCESS';
					$data['id']=$_POST['observationId'];
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid";
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
				$this->ObservationModel->updateImageCaption($json);
				$this->ObservationModel->updateImageTags($json);
				$this->ObservationModel->updateEducatorTags($json);
				$data['Status']='SUCCESS';
				$data['Message']="Tags saved successfully!";
			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid userid!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}
	
	public function updateImagePriority()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				foreach ($json->priority as $priority => $pr) {
					$this->ObservationModel->updateImagePriority($pr);
				}
				$data['Status'] = "SUCCESS";
				$data['Message'] = "Image priority updated";
			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid userid!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	//Specially designed for viewing observation page

	public function getObsView()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){

				//common variables
				$userid = $json->userid;
				$obsId = $json->observationId;
				if (empty($obsId)) {
					$data['Status'] = "ERROR";
					$data['Message'] = "Please send observation id!";
				} else {
					// if we have observation id, then check permission 
					$obs = $this->ObservationModel->getObservationRow($obsId);
					$obsList = $this->ObservationModel->getObservationUser($obsId);
					$obsList->title = trim(stripslashes(strip_tags($obsList->title)));
					$obsList->reflection = trim(stripslashes(strip_tags($obsList->reflection)));
					$obsList->notes = trim(stripslashes(strip_tags($obsList->notes)));

					// $obsList->title = trim(stripslashes(html_entity_decode($obsList->title)));
					// $obsList->reflection = trim(stripslashes(html_entity_decode($obsList->reflection)));
					// $obsList->notes = trim(stripslashes(html_entity_decode($obsList->notes)));
			    	$centerid = $obs->centerid;
					// permission section
					$userArr = $this->LoginModel->getUserFromId($userid);
	                if ($userArr->userType == "Superadmin") {
	                   	$permission = NULL;
	                   	$getObsIds = $this->ObservationModel->getAdminObsIds($centerid);
	                }else{
	                    if ($userArr->userType == "Staff") {
	                        $permission = $this->UtilModel->getPermissions($userid,$obs->centerid);
	                        $getObsIds = $this->ObservationModel->getStaffObsIds($userid,$centerid);
	                    }else{
	                    	//for parents
	                        $permission = $this->UtilModel->getPermissions(0,1);
	                        $getObsIds = $this->ObservationModel->getParentObsIds($userid,$centerid);
	                    }
	                }

	                $obsIds = [];
	                foreach($getObsIds as $obsArr => $obsObj){
	                	$obsIds[] = $obsObj->id;
	                }
	                $key = array_search($obsId, $obsIds);
	                $nextKey = $key+1;
	                $prevKey = $key-1;
	                if (isset($obsIds[$nextKey])) {
	                	$next = $obsIds[$nextKey];
	                }else{
	                	$next = NULL;
	                }
		            if($prevKey < 1){
		            	$prev = 0;
		            }else{
		            	$prev = $obsIds[$prevKey];
		            }
		            
	                // EYLF Section
	                $outcomes = [];

	                //Get Distinct Observation EYLF Activity/SubActivity and Outcomes Id for a particular observation Id
	                $obsEylfArr = [];
	                $obsEylfAct = $this->ObservationModel->getDistObsEylfActId($obsId);	
	                foreach ($obsEylfAct as $obsEylf => $oea) {
	                	$obsEylfArr[]=$oea->eylfActivityId;
	                }

	                
	                $obsEylfSubActArr = [];
	                $obsEylfSubAct = $this->ObservationModel->getDistObsEylfSubActId($obsId);
	                foreach ($obsEylfSubAct as $obsEylfSuAct => $oesa) {
	                	$obsEylfSubActArr[] = $oesa->eylfSubactivityId;
	                }                

	                if (!empty($obsEylfAct)) {
	                	$tempArr = [];
	                	foreach ($obsEylfAct as $obsEylfActs => $goe) {
	                		$d = [];
	                		$getEylfOc = $this->ObservationModel->getObsEylfOutcomes($goe->eylfActivityId);
                			foreach ($getEylfOc as $geoc => $geo) {
                				if(!in_array($geo->outcomeId, $tempArr)) {
			                		$d['outcomeId'] = $geo->outcomeId;
			                		$d['title'] = $geo->title;
			                		 $d['Activity'] = [];
			                		$outcomes[] = $d;
			                		$tempArr[] = $geo->outcomeId;
			                	}
		                	}
	                	}
	                }

	                $outcomez = [];
	                if (empty($outcomes)) {
	                	$data['outcomes'] = NULL;
	                }else{
	                	foreach($outcomes as $outcome => $oc){
	                		$getAllActivity = $this->ObservationModel->getEylfActs($oc['outcomeId']);
	                		foreach ($getAllActivity as $getAllAct => $gaact) {
	                			if (in_array($gaact->id, $obsEylfArr)) {
	                				$getAllSubActivity = $this->ObservationModel->getEylfSubActs($gaact->id);
	                				foreach($getAllSubActivity as $getAllSubActivit => $gasact){
	                					if(in_array($gasact->id, $obsEylfSubActArr)){
	                						$gaact->subActivity[] = $gasact;
	                					}
	                				}
	                				$oc['Activity'][] = $gaact;
	                			}
	                		}
	                		$outcomez[] = $oc;
	                	}
	                }

	                //Montessori section
	                #get montessori idSubActivity from observationmontessori
	                $obsMonSubActArr = [];
	                $obsMonActArr = [];
	                $obsMonSubArr = [];

	                $demoArr = $this->ObservationModel->getObsMonSubActvts($obsId);
	                foreach ($demoArr as $demo => $obj) {
	                	$obsMonSubActArr[] = $obj->idSubActivity;
	                }

	                $demoArr2 = $this->ObservationModel->getDistObsMonActvts($obsId);
                	foreach ($demoArr2 as $demo2 => $obj2) {
                		$obsMonActArr[] = $obj2->idActivity;
                	}

                	$demoArr3 = $this->ObservationModel->getDistObsMonSubs($obsId);
                	foreach ($demoArr3 as $demo3 => $obj3) {
                		$obsMonSubArr[] = $obj3->idSubject;
                	}
                	//$setMonSubs = [];
                	// $getAllMonSubInDb = $this->ObservationModel->getMontessoriSubjects();
                	// foreach ($obsMonSubArr as $monSubjects => $monsubject) {
                	// 	$getMonSubs = $this->ObservationModel->getMonSubRow($monsubject);
                	// 	$getAllMonActArr = $this->ObservationModel->getMonActvts($getMonSubs->idSubject);
                	// 	foreach ($getAllMonActArr as $activities => $act) {
                	// 		if(in_array($act->idActivity,$obsMonActArr)){
                	// 			$sub->Activity[] = $act;
                	// 			$getAllMonSubActArr = $this->ObservationModel->getMonSubActvts($act->idActivity);
                	// 			foreach($getAllMonSubActArr as $gamsaarr => $gamsaa){
                	// 				if (in_array($gamsaa->idSubActivity,$obsMonSubActArr)) {
	                // 					$act->subActivity[] = $gamsaa;
	                // 					//Extras for a observation
	                // 					$getMonObsExtras = [];
                	// 					$demoArr4 = $this->ObservationModel->getObsMonSubActvtsExtras($obsId);
                	// 					foreach($demoArr4 as $demo4 => $obj4){
                	// 						$getMonObsExtras[] = $obj4->idExtra;
                	// 					}
                	// 					//All extras for a particular subactivity
                	// 					$getAllExtras = $this->ObservationModel->getSubActivityExtras($gamsaa->idSubActivity);
                	// 					foreach ($getAllExtras as $getAllExtr => $getAllExtObj) {
                	// 						if(in_array($getAllExtObj->idExtra,$getMonObsExtras)){
		            //     						$gamsaa->extras[] = $getAllExtObj;
	                // 						}
                	// 					}
	                // 				} 
                	// 			}        				
                	// 		}
                	// 	}
                	// 	$getMonSubs->Activity = $getAllMonActArr;
                	// 	$setMonSubs[] = $getMonSubs;
                	// }

					$setMonSubs = [];
foreach ($obsMonSubArr as $monSubjects => $monsubject) {
    $getMonSubs = $this->ObservationModel->getMonSubRow($monsubject);
    $getAllMonActArr = $this->ObservationModel->getMonActvts($getMonSubs->idSubject);
    
    // Initialize the $sub object and its Activity property
    $sub = new stdClass();
    $sub->Activity = []; // Ensure Activity is an array

    foreach ($getAllMonActArr as $activities => $act) {
        if (in_array($act->idActivity, $obsMonActArr)) {
            $sub->Activity[] = $act; // Safely add activity to $sub

            // Get all subactivities for the current activity
            $getAllMonSubActArr = $this->ObservationModel->getMonSubActvts($act->idActivity);
            foreach ($getAllMonSubActArr as $gamsaarr => $gamsaa) {
                if (in_array($gamsaa->idSubActivity, $obsMonSubActArr)) {
                    $act->subActivity = []; // Initialize subActivity as an array if it doesn't exist
                    $act->subActivity[] = $gamsaa; // Add subActivity

                    // Extras for an observation
                    $getMonObsExtras = [];
                    $demoArr4 = $this->ObservationModel->getObsMonSubActvtsExtras($obsId);
                    foreach ($demoArr4 as $demo4 => $obj4) {
                        $getMonObsExtras[] = $obj4->idExtra;
                    }

                    // All extras for a particular subactivity
                    $getAllExtras = $this->ObservationModel->getSubActivityExtras($gamsaa->idSubActivity);
                    foreach ($getAllExtras as $getAllExtr => $getAllExtObj) {
                        if (in_array($getAllExtObj->idExtra, $getMonObsExtras)) {
                            $gamsaa->extras = []; // Initialize extras if not already set
                            $gamsaa->extras[] = $getAllExtObj; // Add extra
                        }
                    }
                }
            }
        }
    }

    $getMonSubs->Activity = $sub->Activity; // Assign the activities to $getMonSubs
    $setMonSubs[] = $getMonSubs; // Collect all subjects
}
                	
                	#Developmental Milestone
                	$devMilestone = [];
                	$devMilestoneMain = [];
                	$devMilestoneSub = [];
                	$devMilestoneExtras = [];

                	$devArr1 = $this->ObservationModel->getObsMilestone($obsId);
                	foreach ($devArr1 as $dvArr1 => $dvObj1) {
                		$devMilestone[] = $dvObj1->id;
                	}

                	$devArr2 = $this->ObservationModel->getObsMilestoneMain($obsId);
                	foreach ($devArr2 as $dvArr2 => $dvObj2) {
                		$devMilestoneMain[] = $dvObj2->id;
                	}
                	$devArr3 = $this->ObservationModel->getObsMilestoneSub($obsId);
                	foreach ($devArr3 as $dvArr3 => $dvObj3){
                		$devMilestoneSub[] = $dvObj3->id;
                	}

                	$devArr4 = $this->ObservationModel->getObsMilestoneExtras($obsId);
                	foreach ($devArr4 as $dvArr4 => $dvObj4){
                		$devMilestoneExtras[] = $dvObj4->id;
                	}
                	$devlMilestone=[];
                	foreach ($devMilestone as $key => $dmobj) {
                		$getObsMileStone = $this->ObservationModel->getMileStone($dmobj);
                		foreach ($getObsMileStone as $milestone => $mist) {
                			$getObsMileStoneMain = $this->ObservationModel->getMileStoneMain($mist->id);
                			foreach ($getObsMileStoneMain as $milestoneMain => $mistmn) {
                				if (in_array($mistmn->id,$devMilestoneMain)) {
                					$getObsMileStoneSubs = $this->ObservationModel->getMileStoneSubs($mistmn->id);
                					foreach ($getObsMileStoneSubs as $milestoneSubs => $mistsub) {
                						if (in_array($mistsub->id, $devMilestoneSub)) {
                							$getObsMileStoneExtras = $this->ObservationModel->getMileStoneExtras($mistsub->id);
                							foreach ($getObsMileStoneExtras as $milestoneExtras => $mistextra) {
                								if(in_array($mistextra->id, $devMilestoneExtras)){
                									$mistsub->extras[] = $mistextra;
                								}
                							}
                							$mistmn->Subjects[] = $mistsub;
                						}
                					}
                					$mist->Main[] = $mistmn;
                				}
                			}
                			$devlMilestone[] = $mist;
                		}
                	}

                	$childrens = $this->ObservationModel->getObservationChildrens($obsId);

					$media = $this->ObservationModel->getobservationMedia($obsId);
					foreach ($media as $obsMedia => $om) {
						$om->childs = $this->ObservationModel->getObsMediaChildTags($om->id);
						$om->educators = $this->ObservationModel->getObsMediaEducatorTags($om->id);
					}

					$comments =$this->ObservationModel->getobservationComments($obsId);
                    // echo "<pre>";
					// print_r($comments);
					// exit;

	                $data['Status'] = "SUCCESS";
	                $data['observation']=isset($obsList)?$obsList:NULL;
	                $data['childrens'] = isset($childrens)?$childrens:NULL;
	                $data['Media'] = isset($media)?$media:NULL;
	                $data['outcomes'] = isset($outcomez)?$outcomez:NULL;
	                $data['montessoriSubjects'] = isset($setMonSubs)?$setMonSubs:NULL;
	                $data['devMilestone'] = isset($devlMilestone)?$devlMilestone:NULL;
	                $data['Comments'] = isset($comments)?$comments:NULL;
	                $data['nextObsId'] = $next;
	                $data['prevObsId'] = $prev;
	                $data['permission'] = $permission;
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid don't match!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function createMilestones()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('LoginModel');
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if($json->observationId != null && $json->observationId != ""){
					$obsId = $json->observationId;

					//Select all id of existing milestone records for an observation
					$allDevMilIds = $this->ObservationModel->getAllObsMilestones($obsId);
					foreach ($allDevMilIds as $devMile => $devMilObj) {
						$this->ObservationModel->deleteMilestoneExtras($devMilObj->id);
					}

					//Delete all the previous existing records
			    	$this->ObservationModel->deleteMilestone($obsId);
			    	
			    	//Insert new records
			    	if (!empty($json->milestones)) {
			    		foreach ($json->milestones as $milestones => $msObj) {
				    		$msObj->observationId = $obsId;
				    	}
				    	$this->ObservationModel->insertDevMilestone($json->milestones);  
			    	}
					http_response_code(200);
					$data['Status']='SUCCESS';
					$data['id']=$json->observationId;
				}
				else{
					http_response_code(401);
					$data['Status']='ERROR';
					$data['Message'] = 'Observation Id cannot be empty';
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid don't match!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getPublishedQip($userid='',$centerid='')
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $res->userid == $userid){
				$qip = $this->ObservationModel->getPublishedQip($centerid);
				$data['Status'] = "SUCCESS";
				$data['qip'] = $qip;
			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid userid!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getPublishedProgPlan($userid='',$centerid='')
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $res->userid == $userid){
				$pp = $this->ObservationModel->getPublishedProgPlan($centerid);
				$data['Status'] = "SUCCESS";
				$data['ProgramPlan'] = $pp;
			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid userid!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}


	// Specially for previewing observation in bootstrap modal
	public function getAssessmentPreview()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				
				if(empty($json->eylfSubActivities)){
					$EylfOutcome = NULL;
				}else{
	                // EYLF Section
	                $d = new stdClass();                
	                $EylfSubActArr = $json->eylfSubActivities;
					$EylfAct = [];
					$EylfOutcome = [];

	                $prvEylfAct = $this->ObservationModel->getDistEylfActIdFromEylfSubActvt($EylfSubActArr);
	                foreach ($prvEylfAct as $prveylfAct => $pea) {
	                	$EylfAct[] = $pea->id;
	                }

	                $prvEylfOutcome = $this->ObservationModel->getDistEylfOutcomesFromActvts($EylfAct);
	                foreach ($prvEylfOutcome as $prvEylfOC => $peoc) {
	                	$EylfOutcome[] = $peoc;
	                }

	                if (empty($EylfOutcome)) {
	                	$data['outcomes'] = NULL;
	                }else{
	                	foreach($EylfOutcome as $outcome => $oc){
	                		$getAllActivity = $this->ObservationModel->getEylfActs($oc->id);
	                		foreach ($getAllActivity as $getAllAct => $gaact) {
	                			if (in_array($gaact->id, $EylfAct)) {
	                				$oc->Activity[] = $gaact;
	                				$getAllSubActivity = $this->ObservationModel->getEylfSubActs($gaact->id);
	                				foreach($getAllSubActivity as $getAllSubActivit => $gasact){
	                					if(in_array($gasact->id,$EylfSubActArr)){
	                						$gaact->subActivity[]=$gasact;
	                					}
	                				}
	                			}
	                		}
	                	}
	                }
                }

                if(empty($json->monSubactivity)){
                	$getMonSubsArr = NULL;
                }else{
	                //Montessori section
	                $obsMonSubActArr = [];
	                $obsMonActArr = [];
	                $obsMonSubArr = [];
	                $demoArr = $json->monSubactivity;
	                foreach ($demoArr as $demo => $obj) {
	                	$obsMonSubActArr[] = $obj;
	                }

	                $demoArr2 = $this->ObservationModel->getIdActivityOfMonSubActivity($obsMonSubActArr);
	            	foreach ($demoArr2 as $demo2 => $obj2) {
	            		$obsMonActArr[] = $obj2->idActivity;
	            	}

	            	$demoArr3 = $this->ObservationModel->getIdSubjectOfMonActivity($obsMonActArr);
	            	foreach ($demoArr3 as $demo3 => $obj3) {
	            		$obsMonSubArr[] = $obj3->idSubject;
	            	}

	            	$monObs = [];
	            	foreach ($obsMonSubArr as $monSubjects => $monsubject) {
	            		$getMonSubs = $this->ObservationModel->getMonSubRec($monsubject);
                		$getAllMonActArr = $this->ObservationModel->getMonActvts($getMonSubs->idSubject);
                		foreach ($getAllMonActArr as $activities => $act) {
                			if(in_array($act->idActivity,$obsMonActArr)){
                				$sub->Activity[] = $act;
                				$getAllMonSubActArr = $this->ObservationModel->getMonSubActvts($act->idActivity);
                				foreach($getAllMonSubActArr as $gamsaarr => $gamsaa){
                					if (in_array($gamsaa->idSubActivity,$obsMonSubActArr)) {
	                					$act->subActivity[] = $gamsaa;
	                					//Extras for a observation
	                					$getMonObsExtras = $json->monSubActExtras;
                						//All extras for a particular subactivity
                						$getAllExtras = $this->ObservationModel->getSubActivityExtras($gamsaa->idSubActivity);
                						foreach ($getAllExtras as $getAllExtr => $getAllExtObj) {
                							if(in_array($getAllExtObj->idExtra,$getMonObsExtras)){
		                						$gamsaa->extras[] = $getAllExtObj;
	                						}
                						}
	                				} 
                				}        				
                			}
                		}
                		$getMonSubs->Activity = $getAllMonActArr;
                		$monObs[] = $getMonSubs;
	            	}
	            }

	            if(empty($json->devMileSub)){
	            	$getObsMileStone = NULL;
	            } else {
	            	#Developmental Milestone
	            	$devMilestone = [];
	            	$devMilestoneMain = [];
	            	$devMilestoneSub = $json->devMileSub;
	            	$devMilestoneExtras = $json->devMileExtras;

	            	$devArr2 = $this->ObservationModel->getDevMainFromSubAct($devMilestoneSub);
	            	foreach ($devArr2 as $dvArr2 => $dvObj2) {
	            		$devMilestoneMain[] = $dvObj2->id;
	            	}

	            	$devArr1 = $this->ObservationModel->getDevMileFromMain($devMilestoneMain);
	            	foreach ($devArr1 as $dvArr1 => $dvObj1) {
	            		$devMilestone[] = $dvObj1->id;
	            	}
            	}

            	
            	// $devArr4 = $this->ObservationModel->getObsMilestoneExtras($obsId);
            	// foreach ($json->devMileExtras as $dvArr4 => $dvObj4){
            	// 	$devMilestoneExtras[] = $json->devMileExtras
            	// }
            	
            	foreach ($devMilestone as $key => $dmobj) {
            		$getObsMileStone = $this->ObservationModel->getMileStone($dmobj);
            		foreach ($getObsMileStone as $milestone => $mist) {
            			$getObsMileStoneMain = $this->ObservationModel->getMileStoneMain($mist->id);
            			foreach ($getObsMileStoneMain as $milestoneMain => $mistmn) {
            				if (in_array($mistmn->id,$devMilestoneMain)) {
            					$getObsMileStoneSubs = $this->ObservationModel->getMileStoneSubs($mistmn->id);
            					foreach ($getObsMileStoneSubs as $milestoneSubs => $mistsub) {
            						if (in_array($mistsub->id, $devMilestoneSub)) {
            							$getObsMileStoneExtras = $this->ObservationModel->getMileStoneExtras($mistsub->id);
            							foreach ($getObsMileStoneExtras as $milestoneExtras => $mistextra) {
            								if(in_array($mistextra->id, $devMilestoneExtras)){
            									$mistsub->extras[] = $mistextra;
            								}
            							}
            							$mistmn->Subjects[] = $mistsub;
            						}
            					}
            					$mist->Main[] = $mistmn;
            				}
            			}
            		}
            	}

                $data['Status'] = "SUCCESS";
                $data['outcomes'] = isset($EylfOutcome)?$EylfOutcome:NULL;
                $data['montessoriSubjects'] = isset($monObs)?$monObs:NULL;
                $data['devMilestone'] = isset($getObsMileStone)?$getObsMileStone:NULL;				
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Userid don't match!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}


	//Specially for child details page
	public function getChildDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if(isset($json->childid)){
					$childid = $json->childid;
					$userid = $json->userid;
					$childInfo = $this->ChildrenModel->getChildRecord($childid);

					if (empty($childInfo) || $childInfo == NULL) {
						$centerid = NULL;
					}else{
						$centerid = $childInfo->centerid;
					}

					$userArr = $this->LoginModel->getUserFromId($userid);

	                if ($userArr->userType == "Parent") {
	                	$childsArr = $this->ChildrenModel->getChildsOfParent($userid);
	                }else{
	                	$childsArr = $this->ChildrenModel->getChildsOfCenter($centerid);
	                }



	                $relatives = $this->ChildrenModel->getChildRelatives($childid);
	                foreach ($relatives as $relativess => $rel) {
	                	$rel->relation = $this->ChildrenModel->getParentRelation($rel->userid);
	                }

	                $mediaFiles = $this->MediaModel->getMediaOfChildren($childid);

	                if (isset($json->sort)) {
	                	if (empty($json->sort)) {
	                		$sort = "DESC";
	                	} else {
	                		$sort = $json->sort;
	                	}	                	
	                }else{
	                	$sort = "DESC";
	                }

	                if (isset($json->page) && is_numeric($json->page)) {
	                	$page = (int)$json->page; 
	                }else{
	                	$page = 1;
	                }
	                	
	                $childObsArr = $this->ObservationModel->getChildObservations($childid,$page,$sort);

	                $totalObs = count($childObsArr);
					if (!empty($childObsArr)) {
						foreach($childObsArr AS $childObs => $chObs){							
		                	$chObs->id = $chObs->observationId;
		                	$getObs = $this->ObservationModel->getObservation($chObs->id);
                            if(empty($getObs)){

                            }else{
                                $observationsMedia=$this->ObservationModel->getMedia($chObs->id);
                                if(!empty($observationsMedia))
                                {
                                    $chObs->observationsMedia=$observationsMedia[0]->mediaUrl;
                                    $chObs->observationsMediaType=$observationsMedia[0]->mediaType;
                                }
                                $chObs->status = $getObs->status;
                                $chObs->title = trim(strip_tags(stripslashes(html_entity_decode($getObs->title))));
                                $chObs->date_added = $getObs->date_added;
                                $username = $this->ObservationModel->getUserName($getObs->userId);
                                if (empty($username)) {
                                    $chObs->user_name = "Not Available";
                                }else{
                                    $chObs->user_name = $username->name;
                                }
                                
                                $approver = $this->ObservationModel->getUserName($getObs->approver);
                                if (empty($approver)) {
                                    $chObs->approverName = "Not Available";
                                } else {
                                    $chObs->approverName = $approver->name;
                                }

                                $chObs->observationChildrens=$this->ObservationModel->getObservationChildrens($chObs->id);
                                $chObs->montessoricount=$this->ObservationModel->getObservationMontessoriCount($chObs->id);
                                $chObs->eylfcount=$this->ObservationModel->getObservationEylfCount($chObs->id);
                                $chObs->milestonecount=$this->ObservationModel->getObservationMilestoneCount($chObs->id);
                            }
						}
	               	}

					$data['Status'] = "SUCCESS";
					$data['TotalObs'] = $totalObs;
					$data['Children'] = $childInfo;
					$data['Media'] = $mediaFiles;
					$data['Relatives'] = $relatives;
					$data['Observations'] = $childObsArr;
					$data['ChildrenList'] = $childsArr;

				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Child id is empty!";
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getChildFromCenter()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if(isset($json->centerid)){
					$centerid = $json->centerid;					
					$childList = $this->ChildrenModel->getChildsFromCenter($centerid);
					$data['Status'] = "SUCCESS";
					$data['ChildList'] = $childList;
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Center id is empty!";
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getAllMontSubAct()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$tagsList = [];
				$d = [];	
				$int = 0;

				$montessoriList = $this->ObservationModel->getMonSubActs(NULL,$json->userid);
				foreach ($montessoriList as $monkey => $monobj) {
					$d['id'] = $int + 1;
					$d['rid'] = $monobj->id;					
					$d['title'] = $monobj->title;
					$d['type'] = "Montessori";
					array_push($tagsList,$d);
					$int++;
				}

				$d = [];
				$eylfsubactivityList = $this->ObservationModel->getEylfSubActivites(NULL,$json->userid);
				foreach ($eylfsubactivityList as $eylfkey => $eylfobj) {
					$d['id'] = $int + 1;
					$d['rid'] = $eylfobj->id;
					$d['title'] = $eylfobj->title;
					$d['type'] = "Eylf";
					array_push($tagsList,$d);
					$int++;
				}

				$dmsubactivityList = $this->ObservationModel->getDevMileSubActs(NULL,$json->userid);
				foreach ($dmsubactivityList as $dmkey => $dmobj) {
					$d['id'] = $int + 1;
					$d['rid'] = $dmobj->id;
					$d['title'] = $dmobj->name;
					$d['type'] = "DevMile";
					array_push($tagsList,$d);
					$int++;
				}

				$data['Status'] = "SUCCESS";
				$data['TagsList'] = $tagsList;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getAllChildsAndStaffs()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){				
				$staffList = $this->ObservationModel->getAllStaffs();
				$childList = $this->ObservationModel->getAllChilds();
				$usersList = array_merge($staffList,$childList);
				$data['Status'] = "SUCCESS";
				$data['UsersList'] = $usersList;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	# Write By Dinesh on 02-09-2021

	public function child_table_details(){
		$headers = $this->input->request_headers();	
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){				
				
				$get_childtable = $this->ObservationModel->getTable();
				
				$data['Status'] = "Success";
				$data['Child_table'] = $get_childtable;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getAllMonSubActs()
	{
		$headers = $this->input->request_headers();	
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$result = $this->ObservationModel->getMontessoriSubActivites();	
				$data['Status'] = "SUCCESS";	
				$data['Records'] = $result;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getAllDevMiles()
	{
		$headers = $this->input->request_headers();	
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$result = $this->ObservationModel->getDevelopmentalMilestoneSubActivites();
				$data['Status'] = "SUCCESS";
				$data['Records'] = $result;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getAllEylf()
	{
		$headers = $this->input->request_headers();	
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$result = $this->ObservationModel->getEylfSubActivites();
				$data['Status'] = "SUCCESS";
				$data['Records'] = $result;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function changeObsStatus()
	{
		$headers = $this->input->request_headers();	
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$result = $this->ObservationModel->changeObsStatus($json);
				if ($result) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Status updated successfully";
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Something went wrong!";
					http_response_code(401);
				}				
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
				http_response_code(401);				
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getActTagInfo()
	{
		$headers = $this->input->request_headers();	
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$result = $this->ObservationModel->getActTagInfo($json);
				// print_r($result);
				if ($result) {
					$data['Status'] = "SUCCESS";
					$data['Tag'] = $result;
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Something went wrong!";
					http_response_code(401);
				}				
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
				http_response_code(401);				
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getAssessmentSettings()
	{
		$headers = $this->input->request_headers();	
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$result = $this->ObservationModel->getAssessmentSettings($json->centerid);
				if ($result) {
					$data['Status'] = "SUCCESS";
					$data['Settings'] = $result;
					http_response_code(200);
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Record doesn't exists!";
					http_response_code(401);
				}				
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
				http_response_code(401);				
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}
}
?>
