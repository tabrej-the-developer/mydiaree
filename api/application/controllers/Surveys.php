<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surveys extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") { die(); }
		$this->load->model('SurveyModel');
		$this->load->model('LoginModel');
		$this->load->model('ChildrenModel');
		$this->load->model('SettingsModel');
	}

	public function index()
	{
	}

	public function createSurvey()
	{
		# code for creating survey
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if( $res != null && $res->userid == $_POST['userid']){

				#Pushing survey title,desc,createdBY,createdAt in survey table
				$survey_id = $this->SurveyModel->insertSurvey($_POST);

				#Pushing children
				$this->SurveyModel->insSurveyChild($survey_id,json_decode($_POST['childs']));

				#Pushing Questions with Survey in surveyquestion table
				$keys = array_keys($_POST);
				$matches = preg_grep("/^qstn/",$keys);

				for ($i=1; $i < count($matches)+1; $i++) {
					$qs = "qstn".$i;
					$qt = "qtype".$i;
					$qm = "mandatory".$i;
					$qro = "ropt".$i;
					$qco = "copt".$i;
					$qdo = "dopt".$i;
					$qlilower = "lilower".$i;
					$qlihigher = "lihigher".$i;
					$imgQstn = "fileImg".$i;
					$vidQstn = "fileVid".$i;

					if (isset($_POST[$qs]) && !empty($_POST[$qs]) && $_POST[$qs] != NULL){
						$qtext = $_POST[$qs];

						if (isset($_POST[$qt]) && !empty($_POST[$qt]) && $_POST[$qt] != NULL) {
								$qtype = $_POST[$qt];

								switch ($qtype) {
									case 1:
										$qtypetext = "RADIO";
										break;
									case 2:
										$qtypetext = "CHECKBOX";

										break;
									case 3:
										$qtypetext = "DROPDOWN";

										break;
									case 4:
										$qtypetext = "SCALE";

										break;
									default:
										$qtypetext = "TEXT";

										break;
								}

								if (!empty($_POST[$qm]) && $_POST[$qm]!=NULL && isset($_POST[$qm])){
									$qstnId = $this->SurveyModel->insQstn($survey_id,$qtype,$qtext,1);

								} else {
									$qstnId = $this->SurveyModel->insQstn($survey_id,$qtype,$qtext,0);

								}

								//storing options of the questions
								if ($qtype == 1) {
									$this->SurveyModel->insQstnOpts($qstnId,json_decode($_POST[$qro]));
								}elseif ($qtype == 2) {
									$this->SurveyModel->insQstnOpts($qstnId,json_decode($_POST[$qco]));
								}elseif ($qtype == 3) {
									$this->SurveyModel->insQstnOpts($qstnId,json_decode($_POST[$qdo]));
								}elseif ($qtype == 4) {
									$linearAns = array(
										$_POST[$qlilower], $_POST[$qlihigher]
									);
									$this->SurveyModel->insQstnOpts($qstnId,$linearAns);
								} else {

								}

								//storing medias of the questions

								if (isset($_FILES[$imgQstn]['name'])) {
									$newName = uniqid()/*$_FILES[$imgQstn]['name']*/;
									$extension = explode('/', $_FILES[$imgQstn]['type'])[1];
									$target_dir = "assets/media/".$newName.".".$extension;
									$file = $newName.".".$extension;
									move_uploaded_file($_FILES[$imgQstn]['tmp_name'], $target_dir);
									$this->SurveyModel->insQstnMedia($qstnId,$file,'Image');
								}

								if(!empty($_FILES[$vidQstn]['name'])){
									$newName = uniqid()/*$_FILES[$vidQstn]['name']*/;
									$extension = explode('/', $_FILES[$vidQstn]['type'])[1];
									$target_dir = "assets/media/".$newName.".".$extension;
									$file = $newName.".".$extension;
									move_uploaded_file($_FILES[$vidQstn]['tmp_name'], $target_dir);
									$this->SurveyModel->insQstnMedia($qstnId,$file,'Video');
								}
							}
						}
					}

				$data['Status'] = 'SUCCESS';
				$data['Message'] = 'Survey Created Successfully';
				echo json_encode($data);

			}else{
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Invalid Data';
				http_response_code(401);
				json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	//new version survey add/edit 
	public function saveSurvey()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$json = json_decode(file_get_contents("php://input"));
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $_POST != null && $res->userid == $_POST['userid'] ){
				if (isset($_POST['surveyid'])) {
					$surveyid = $_POST['surveyid'];
					//delete survey, question, media, option
					$this->SurveyModel->deleteSurveyWOM($surveyid);

					//create a new survey with same id
					$this->SurveyModel->updateSurvey($_POST);

					//Pushing children
					if (isset($_POST['childs'])) {
						$this->SurveyModel->insSurveyChild($surveyid,json_decode($_POST['childs']));
					}
				}else{
					//Pushing survey title,desc,createdBY,createdAt in survey table
					$surveyid = $this->SurveyModel->insertSurvey($_POST);

					//Pushing children
					if (isset($_POST['childs'])) {
						$this->SurveyModel->insSurveyChild($surveyid,json_decode($_POST['childs']));
					}
				}

				#Pushing Questions with Survey in surveyquestion table
				$keys = array_keys($_POST);
				$matches = preg_grep("/^qstn/",$keys);

				for ($i=1; $i < count($matches)+1; $i++) {
					$qs = "qstn".$i;
					$qt = "qtype".$i;
					$qm = "mandatory".$i;
					$qro = "ropt".$i;
					$qco = "copt".$i;
					$qdo = "dopt".$i;
					$qlilower = "lilower".$i;
					$qlihigher = "lihigher".$i;
					$fileQstn = "fileQstn".$i;

					if (isset($_POST[$qs]) && !empty($_POST[$qs]) && $_POST[$qs] != NULL){
						$qtext = $_POST[$qs];

						if (isset($_POST[$qt]) && !empty($_POST[$qt]) && $_POST[$qt] != NULL) {
							$qtype = $_POST[$qt];
							switch ($qtype) {
								case 1:
									$qtypetext = "RADIO";
									break;
								case 2:
									$qtypetext = "CHECKBOX";
									break;
								case 3:
									$qtypetext = "DROPDOWN";
									break;
								case 4:
									$qtypetext = "SCALE";
									break;
								default:
									$qtypetext = "TEXT";
									break;
							}

							if (!empty($_POST[$qm]) && $_POST[$qm]!=NULL && isset($_POST[$qm])){
								$qstnId = $this->SurveyModel->insQstn($surveyid,$qtype,$qtext,1);
							} else {
								$qstnId = $this->SurveyModel->insQstn($surveyid,$qtype,$qtext,0);
							}

							if (isset($_POST['uploaded_file_'.$i])) {
								$this->SurveyModel->updateMediaQstnId($_POST['uploaded_file_'.$i],$qstnId);
							}

							//storing options of the questions
							if ($qtype == 1) {
								$this->SurveyModel->insQstnOpts($qstnId,json_decode($_POST[$qro]));
							}elseif ($qtype == 2) {
								$this->SurveyModel->insQstnOpts($qstnId,json_decode($_POST[$qco]));
							}elseif ($qtype == 3) {
								$this->SurveyModel->insQstnOpts($qstnId,json_decode($_POST[$qdo]));
							}elseif ($qtype == 4) {
								$linearAns = array( $_POST[$qlilower], $_POST[$qlihigher] );
								$this->SurveyModel->insQstnOpts($qstnId,$linearAns);
							} else {

							}

							//storing medias of the questions
							if (isset($_FILES[$fileQstn]['name'])) {
								$newName = pathinfo($_FILES[$fileQstn]['name'], PATHINFO_FILENAME) . "-" . uniqid();
								$extension = explode('/', $_FILES[$fileQstn]['type'])[1];
								$target_dir = "assets/media/".$newName.".".$extension;
								$file = $newName.".".$extension;
								$type = explode('/', $_FILES[$fileQstn]['type'])[0];
								move_uploaded_file($_FILES[$fileQstn]['tmp_name'], $target_dir);
								$this->SurveyModel->insQstnMedia($qstnId,$file,$type);
							}
						}
					}
				}

				$surveyInfo = $this->SurveyModel->getSurvey($surveyid);

				http_response_code(200);
				$data['Status'] = 'SUCCESS';
				$data['Message'] = 'Survey saved successfully!';
				$data['centerid'] = empty($surveyInfo->centerid)?NULL:$surveyInfo->centerid;
			}else{
				http_response_code(401);
				$data['Status'] = 'ERROR';
				$data['Message'] = 'User id is not matching!';
			}
		}else{
			http_response_code(401);
			$data['Status'] = 'ERROR';
			$data['Message'] = 'Invalid Headers Sent!';
		}
		echo json_encode($data);
	}

	public function surveysList()
	{
		$headers = $this->input->request_headers();

		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				#code to grab survey records
				$user = $this->LoginModel->getUserFromId($json->userid);

				if ($user->userType=="Parent") {
					$surveys = $this->SurveyModel->parentSurveysList($json->userid);
				} else {
					if ($user->userType=="Superadmin") {
						$surveys = $this->SurveyModel->surveysList($json->centerid);
					}else{
						$jsonInput = new stdClass();
						$jsonInput->user = $json->userid;
						$jsonInput->center = $json->centerid;
						$getPrmsn = $this->SettingsModel->getPermissions($jsonInput);
						if ($getPrmsn->viewAllSurvey == 1) {
							$surveys = $this->SurveyModel->surveysList($json->centerid);
						}else{
							$permsnMsg = "You need permission to view all surveys!";
						}
						$add = $getPrmsn->addSurvey;
						$edit = $getPrmsn->updateSurvey;
						$delete = $getPrmsn->deleteSurvey;
					}
				}

				if (!empty($surveys)) {					
					foreach ($surveys as $suv) {
						$suv_id = $suv->id;
						$resp = $this->SurveyModel->countResponse($suv_id);
						$suv->response=$resp;
					}
				}

				$data['Status'] = "SUCCESS";
				$data['records'] = $surveys;
				if($user->userType=="Staff"){
					if (isset($permsnMsg)) {
						$data['errormsg'] = $permsnMsg;
					}
					$data['permissions']['add'] = $add;
					$data['permissions']['edit'] = $edit;
					$data['permissions']['delete'] = $delete;
					
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid user credentials given.";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers sent.";
		}
		echo json_encode($data);
	}

	public function getPermission()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				#code to grab survey records
				$user = $this->LoginModel->getUserFromId($json->user);

				if ($user->userType=="Parent") {
					$data['Status'] = "ERROR";
					$data['Message'] = "Parent account provided!";
				} else {
					if ($user->userType=="Superadmin") {
						$data['Status'] = "ERROR";
						$data['Message'] = "Admin account provided!";
					}else{
						$jsonInput = new stdClass();
						$jsonInput->user = $json->user;
						$jsonInput->center = $json->center;
						$getPrmsn = $this->SettingsModel->getPermissions($jsonInput);
						$data['Status'] = "SUCCESS";
						$data['Permissions'] = $getPrmsn;
					}
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid user credentials given.";
			}
		}else{
			http_response_code(401);
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid headers sent.";
		}
		echo json_encode($data);
	}

	public function DeleteSurvey($userid,$surveyid)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET' && $res->userid == $userid){
				$check = $this->SurveyModel->getSurvey($surveyid);
				if($check != null){
					$q = $this->SurveyModel->deleteSurvey($surveyid);
					$data['Status'] = 'SUCCESS';
					$data['centerid'] = $check->centerid;
					$data['Message'] = "Survey Deleted Successfully.";
				}else{
					$data['Status'] = 'ERROR';
					$data['Message'] = "Survey doesnot exist";
				}
			}else{
				$data['Status'] = 'ERROR';
				$data['Message'] = "Invalid";
			}
		}else{
			$data['Status'] = 'ERROR';
			$data['Message'] = "Invalid headers sent";
		}
		echo json_encode($data);
	}

	public function getSurveyDetails()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!=NULL && $res!=NULL && $res->userid == $json->userid){
				if (empty($json->surveyid)) {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Survey id is invalid!";
				} else {
					$surveyid = $json->surveyid;
					$surveyArr = new stdClass();
					$surveyArr = $this->SurveyModel->getSurvey($surveyid);
					$surveyArr->childs = $this->SurveyModel->getSurveyChilds($surveyid);
					$surveyArr->questions = $this->SurveyModel->getSurveyQuestions($surveyid);
					foreach ($surveyArr->questions as $questKey => $questObj) {
						$questObj->options = $this->SurveyModel->getQuestionOptions($questObj->id);
						$questObj->medias = $this->SurveyModel->getQuestionMedias($questObj->id);
					}
					$data['Status'] = "SUCCESS";
					$data['Survey'] = $surveyArr;
				}
			} else {
				$data['Status'] = "ERROR";
				$data['Message'] = "User Id Doesn't Match";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getSurveyData(){
		$data = "";
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$json = json_decode(file_get_contents("php://input"));
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $json != null && $res->userid == $json->userid ){
				$surveyId = $json->surveyid;
				$data = [];
				$res = $this->SurveyModel->getResponseStatus($surveyId,$json->userid);
				$data['Surveys'] = $this->SurveyModel->getSurveyData($surveyId);
				$data['Responsed'] = $res->count;
				http_response_code(200);
				$data['Status'] = 'SUCCESS';
			}else{
				http_response_code(401);
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Invalid Data Passed';
			}
		}else{
				http_response_code(401);
				$data['Status'] = 'Error';
				$data['Message'] = 'Invalid Headers';
		}
		echo json_encode($data);
	}

	public function updateSurvey(){
		$data = "";
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$json = json_decode(file_get_contents("php://input"));
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $_POST != null && $res->userid == $_POST['userid'] ){
				$this->load->model('SurveyModel');
				$surveyId = $_POST['surveyid'];
				$title = $_POST['title'];
				$description = $_POST['description'];
				$data = [];
				// update survey table
				$this->SurveyModel->updateSurveyTable($surveyId,$title,$description);
				## update survey child
					## / Delete survey child is different / ##
				## $this->surveyModel->updateSurveyChildTable();

				// update survey question
					## / Delete survey question is different / ##
				$questions = isset($_POST['question']) ? $_POST['question'] : [];
				foreach($questions as $question){
					if(isset($question->qId)){
						// $questionId
						$this->SurveyModel->updateSurveyQuestionTable($question->qId,$question->qType,$question->qText,$question->isMandatory);
						if($_FILES['question_image_'.$question->qId]){
							$newName = $_FILES['question_image_'.$question->qId]['name'];
							$target_dir = "assets/media/$newName";
							move_uploaded_file($_FILES['question_image_'.$question->qId]['tmp_name'], $target_dir);
							$this->SurveyModel->surveyQuestionMediaTable($question->qId,$newName,'IMAGE');
						}
						if($_FILES['question_video_'.$question->qId]){
							$newName = $_FILES['question_video_'.$question->qId]['name'];
							$target_dir = "assets/media/$newName";
							move_uploaded_file($_FILES['question_video_'.$question->qId]['tmp_name'], $target_dir);
							$this->SurveyModel->surveyQuestionMediaTable($question->qId,$newName,'VIDEO');
						}
						foreach($question['options'] as $row){
							$this->SurveyModel->surveyQuestionOptionTable($row->id,$row->optionText);
						}
					}else{
						$qid = $this->SurveyModel->insQstn($surveyId,$question->qType,$question->qText,$question->isMandatory);
					}
				}
				// update survey question media
					## / Delete survey question media is different / ##
				// $files = isset($_POST['files']) ? $_POST['files'] : [];
				$files = isset($_FILES) ? $_FILES : [];
				$counter = 0;
				foreach($files as $media){
					// video_id_
					// image_id_
					if(isset($media)){
						$id = null;
						if(strpos($media['name'],'__image__') >= 0){
							$newName = $_FILES[$imgQstn]['name'];
							$target_dir = "assets/media/$newName";
							$id = explode('__image__',$media);
							move_uploaded_file($media['tmp_name'], $target_dir);
							if($id[0] != "" && $id[0] != null){
								$rowId = $id[1];
								$this->SurveyModel->deleteMedia($rowId);
								$this->SurveyModel->surveyQuestionMediaTable($rowId,$newName,'IMAGE');
							}else{
								$qid = $id[1];
								$this->surveyModel->insQstnMedia($qid,$newName,'IMAGE');
							}
						}
						if(strpos($media['name'],'__video__') >= 0){
							$newName = $media['name']['name'];
							$target_dir = "assets/media/$newName";
							$id = explode('__video__',$media);
							move_uploaded_file($media['tmp_name'], $target_dir);
							if($id[0] != "" && $id[0] != null){
								$rowId = $id[1];
								$this->SurveyModel->deleteMedia($rowId);
								$this->SurveyModel->surveyQuestionMediaTable($rowId,$newName,'VIDEO');
							}else{
								$qid = $id[1];
								$this->SurveyModel->insQstnMedia($qid,$newName,'VIDEO');
							}
						}
					}
					$counter++;
				}
				// update survey question option
					## / Delete survey question option is different / ##
				$options = isset($_POST['options']) ? $_POST['options'] : [];
				foreach($options as $option){
					if(isset($option->optionId)){
					$this->SurveyModel->surveyQuestionOptionTable($option->optionId,$option->optionText);
					}
				}
				http_response_code(200);
				$data['Status'] = 'SUCCESS';
			}else{
				http_response_code(401);
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Invalid Data Passed';
			}
		}else{
			http_response_code(401);
			$data['Status'] = 'Error';
			$data['Message'] = 'Invalid Headers';
		}
		echo json_encode($data);
	}

	public function deleteSurveyElement($userid,$elementType,$rowId){
		$headers = $this->input->request_headers();
		$this->load->model('LoginModel');
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				$this->load->model('SurveyModel');
				if($res != null && $res->userid == $userid){
					if($elementType == 'OPTION')
						$this->SurveyModel->deleteOption($rowId);
					if($elementType == 'QUESTION')
						$this->SurveyModel->deleteQuestion($rowId);
					if($elementType == 'MEDIA')
						$this->SurveyModel->deleteMedia($rowId);
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

	public function surveyResponse(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){
					$surveyid = $json->surveyid;
					$userid = $json->userid;
					$responses = $json->responses;
					// check existing responses
					$checkRes = $this->SurveyModel->countSurveyResponse($userid,$surveyid);
					if($checkRes == 0){
						//Insert into survey response
						$responseId = $this->SurveyModel->insertSurveyResponse($userid,$surveyid);
						// Insert into survey response question
						foreach($responses as $res){
							$questionId = $res->questionId;
							foreach($res->responses as $r){
								$this->SurveyModel->insertSurveyResponseQuestion($responseId,$questionId,$r);
							}
						}
						$data['Status'] = "SUCCESS";
					}else{
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "Already attempted the survey!";
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

	public function getPublishedSurveys(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$json = json_decode(file_get_contents("php://input"));
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $json != null && $res->userid == $json->userid ){
				$surveysArr = $this->SurveyModel->getPublishedSurveys($json->centerid);
				$data['Status'] = "SUCCESS";
				$data['Surveys'] = $surveysArr;
			}else{
				http_response_code(401);
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Invalid User Account!';
			}
		}else{
			http_response_code(401);
			$data['Status'] = 'Error';
			$data['Message'] = 'Invalid Headers Sent!';
		}
		echo json_encode($data);
	}

	public function updateSurveyRecord()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if( $res != null && $res->userid == $_POST['userid']){
				//set the survey id
				$surveyid = $_POST['surveyid'];
				$survey_id = $surveyid;
				//delete survey, question, media, option
				$this->SurveyModel->deleteSurveyWOM($surveyid);

				//create a new survey with same id
				$this->SurveyModel->updateSurvey($_POST);

				#Pushing children
				$this->SurveyModel->insSurveyChild($survey_id,json_decode($_POST['childs']));

				#Pushing Questions with Survey in surveyquestion table
				$keys = array_keys($_POST);
				$matches = preg_grep("/^qstn/",$keys);

				for ($i=1; $i < count($matches)+1; $i++) {
					$qs = "qstn".$i;
					$qt = "qtype".$i;
					$qm = "mandatory".$i;
					$qro = "ropt".$i;
					$qco = "copt".$i;
					$qdo = "dopt".$i;
					$qlilower = "lilower".$i;
					$qlihigher = "lihigher".$i;
					$imgQstn = "fileImg".$i;
					$vidQstn = "fileVid".$i;

				if (isset($_POST[$qs]) && !empty($_POST[$qs]) && $_POST[$qs] != NULL){
					$qtext = $_POST[$qs];

					if (isset($_POST[$qt]) && !empty($_POST[$qt]) && $_POST[$qt] != NULL) {
							$qtype = $_POST[$qt];

							switch ($qtype) {
								case 1:
									$qtypetext = "RADIO";
									break;
								case 2:
									$qtypetext = "CHECKBOX";
									break;
								case 3:
									$qtypetext = "DROPDOWN";
									break;
								case 4:
									$qtypetext = "SCALE";
									break;
								default:
									$qtypetext = "TEXT";
									break;
							}

							if (!empty($_POST[$qm]) && $_POST[$qm]!=NULL && isset($_POST[$qm])){
								$qstnId = $this->SurveyModel->insQstn($survey_id,$qtype,$qtext,1);

							} else {
								$qstnId = $this->SurveyModel->insQstn($survey_id,$qtype,$qtext,0);

							}

							//storing options of the questions
							if ($qtype == 1) {
								$this->SurveyModel->insQstnOpts($qstnId,json_decode($_POST[$qro]));
							}elseif ($qtype == 2) {
								$this->SurveyModel->insQstnOpts($qstnId,json_decode($_POST[$qco]));
							}elseif ($qtype == 3) {
								$this->SurveyModel->insQstnOpts($qstnId,json_decode($_POST[$qdo]));
							}elseif ($qtype == 4) {
								$linearAns = array($_POST[$qlilower], $_POST[$qlihigher]);
								$this->SurveyModel->insQstnOpts($qstnId,$linearAns);
							} else {

							}

							//storing medias of the questions
							if (isset($_FILES[$imgQstn]['name'])) {
								$newName = uniqid()/*$_FILES[$imgQstn]['name']*/;
								$extension = explode('/', $_FILES[$imgQstn]['type'])[1];
								$target_dir = "assets/media/".$newName.".".$extension;
								$file = $newName.".".$extension;
								move_uploaded_file($_FILES[$imgQstn]['tmp_name'], $target_dir);
								$this->SurveyModel->insQstnMedia($qstnId,$file,'Image');
							}

							if(!empty($_FILES[$vidQstn]['name'])){
								$newName = uniqid()/*$_FILES[$vidQstn]['name']*/;
								$extension = explode('/', $_FILES[$vidQstn]['type'])[1];
								$target_dir = "assets/media/".$newName.".".$extension;
								$file = $newName.".".$extension;
								move_uploaded_file($_FILES[$vidQstn]['tmp_name'], $target_dir);
								$this->SurveyModel->insQstnMedia($qstnId,$file,'Video');
							}
						}
					}
				}

				$data['Status'] = 'SUCCESS';
				$data['Message'] = 'Survey Updated Successfully';
			}else{
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Invalid user account';
				http_response_code(401);
			}
		}else{
			$data['Status'] = 'ERROR';
			$data['Message'] = 'Invalid headers sent!';
			http_response_code(401);
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
					if (isset($json->surveyId)) {
						$check = $this->SurveyModel->checkChildInSurvey($json->surveyId,$childobj->childid);
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
						if (isset($json->surveyId)) {
							$check = $this->SurveyModel->checkChildInSurvey($json->surveyId,$childobj->id);
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
						if (isset($json->surveyId)) {
							$check = $this->SurveyModel->checkChildInSurvey($json->surveyId,$childobj->childid);
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

	public function delete()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$check = $this->SurveyModel->getSurvey($json->surveyid);
				if (empty($check)) {
					http_response_code(401);
					$data['Status'] = 'ERROR';
					$data['Message'] = 'Invalid survey id passed';
				} else {
					$this->SurveyModel->deleteSurvey($json->surveyid);
					http_response_code(200);
					$data['Status'] = 'SUCCESS';
					$data['Message'] = 'Survey deleted successfully';
					$data['centerid'] = $check->centerid;
				}
			}else{
				http_response_code(401);
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Invalid userid passed';
			}
		}else{
			http_response_code(401);
			$data['Status'] = 'ERROR';
			$data['Message'] = 'Invalid headers passed';
		}
		echo json_encode($data);
	}
}

/* End of file Surveys.php */
/* Location: ./application/controllers/Surveys.php */
