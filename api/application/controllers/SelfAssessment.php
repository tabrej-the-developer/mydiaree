<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SelfAssessment extends CI_Controller {

	function __construct() {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == 'OPTIONS') {
			die();
		}
		parent::__construct();
		$this->load->model('SelfAssessmentModel','sam');
		$this->load->model('LoginModel');
		$this->load->model('QipModel');
		$this->load->model('SettingsModel','sm');
	}

	public function index()
	{
		
	}

	public function addNewSelfAssessment()
	{
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$last_rec = $this->sam->getLastSelfAssessment();
				if (empty($last_rec)) {
					$json->name = "Improvement 1";
				}else{
					$json->name = "Improvement ".((int)$last_rec->id + 1);
				}

				$userArr = $this->LoginModel->getUserFromId($json->userid);
				if ($userArr->userType == "Superadmin") {
                    $response = $this->sam->addNewSelfAssessment($json);
                } else if ($userArr->userType == "Staff") {
                	$result = $this->sm->checkPermission($json->userid,'addSelfAssessment',$json->centerid);
                	if(!empty($result) && $result->addSelfAssessment == 1){
                		$response = $this->sam->addNewSelfAssessment($json);
	                	$data = [];
	                	$data['userid'] = $json->userid;
	                	$data['self_assess_id'] = $response;
	                	$data['added_by'] = $json->userid;
	                	$this->sam->addSelfAssessmStaffs($data);
                	}else{
                		$response = NULL;
                	}
                	
                } else {
                	$response = NULL;
                }
				
				if ($response) {
					http_response_code(200);
					$data['id'] = $response;
					$data['center_id'] = $json->centerid;
					$data['Status'] = "SUCCESS";
					$data['Message'] = "New self assessment is created!";
				}else{
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Something went wrong!";
				}				
			}else{
				http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
			}
		}else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
		}
		echo json_encode($data);
	}

	public function getAllSelfAssessments()
	{
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$permission = new stdClass();
				if (empty($json->centerid)) {
					http_response_code(401);
					$data['Status']="ERROR";
					$data['Message']="Can't fetch records for parents!";
				}else{
					$userArr = $this->LoginModel->getUserFromId($json->userid);
					if ($userArr->userType == "Superadmin") {
	                    $res = $this->sam->getAllAssessments($json->centerid);
	                    if (empty($res)) {
		                	$res = NULL;
		                }else{                	
		                	foreach ($res as $key => $obj) {
		                		$obj->educators = $this->sam->getAssessmentEducators($obj->id);
		                	}
		                }
		                $data['Status']="SUCCESS";
						$data['Records'] = $res;	
						$data['Permissions'] = $permission;	
	                } else if ($userArr->userType == "Staff") {
	                    $res = $this->sam->getUserAssessments($json->userid,$json->centerid);
	                    $columns = "addSelfAssessment AS 'add', editSelfAssessment AS 'edit', deleteSelfAssessment AS 'delete', viewSelfAssessment AS 'view'";
	                    $perArr = $this->sm->checkMultiplePermission($json->userid,$columns,$json->centerid);
	                    if(!empty($perArr)){
	                    	$permission->add = $perArr->add;
	                    	$permission->edit = $perArr->edit;
	                    	$permission->delete = $perArr->delete;
	                    	$permission->view = $perArr->view;
	                    }
	                    if (empty($res)) {
		                	$res = NULL;
		                }else{                	
		                	foreach ($res as $key => $obj) {
		                		$obj->educators = $this->sam->getAssessmentEducators($obj->id);
		                	}
		                }
		                $data['Status']="SUCCESS";
						$data['Records'] = $res;	
						$data['Permissions'] = $permission;	
	                } else {
	                	$res = NULL;
	                	http_response_code(401);
						$data['Status']="ERROR";
						$data['Message']="Can't fetch records for parents!";
	                }
				}	
			}else{
                http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
			}
		}else{
            http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
		}
		echo json_encode($data);
	}

	public function editSelfAssessment()
	{
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){

				$userArr = $this->LoginModel->getUserFromId($json->userid);

				$educators = $this->sam->getAssessmentEducators($json->id);
				
                if ($userArr->userType == "Superadmin") {
                    $runprogram = 1;
                } else if ($userArr->userType == "Staff") {

                    $key = $this->sam->checkStaffInAssessment($json->userid,$json->id);
                    
                    if($key){
                    	$runprogram = 1;
                    }else{
                    	$runprogram = 3;
                    }
                } else {
                	$runprogram = 2;
                }

                if ($runprogram == 1) {

                	//Grab QIP areas
                	$areas = $this->QipModel->getQipAreas();

                	if (empty($json->areaid)) {
                		$areaid = $areas[0]->id;
                	} else {
                		$areaid = $json->areaid;
                	}
                	

                	//Self Assessment Details
                	$selfasmnt = $this->sam->getSelfAsmntDetails($json->id);
                	$selfasmnt->educators = $educators;

                	//Use areaid to fetch the legislative requirements
                	$legislative = $this->sam->getLegislativeReqs($areaid);
                	foreach ($legislative as $lrkey => $lrobj) {
	                	$checkInfo = $this->sam->getLegislativeReqsVals($lrobj->id);
                		if (empty($checkInfo)) {
                			$lrobj->status = "";
                			$lrobj->actions = "";
                		}else{
                			$lrobj->status = $checkInfo->status;
                			$lrobj->actions = $checkInfo->actions;
                		}
                	}




                	//Use areaid to fetch quality area
                	$qualityareas = $this->sam->getSelfAsmntQualityAreas($areaid);
                	foreach ($qualityareas as $qakey => $qaobj) {
	                	$checkqa = $this->sam->getSelfAsmntQualityAreasVals($qaobj->id);
                		if (empty($checkqa)) {
                			$qaobj->status = "";
                			$qaobj->identified_practice = "";
                		}else{
                			$qaobj->status = $checkqa->status;
                			$qaobj->identified_practice = $checkqa->identified_practice;
                		}
                	}


                	$data['Status'] = "SUCCESS";
                	$data['Details'] = $selfasmnt;
                	$data['Areas'] = $areas;
                	$data['LR'] = $legislative;
                	$data['QA'] = $qualityareas;
                }else if($runprogram == 2){
                	http_response_code(401);
					$data['Status']="ERROR";
					$data['Message']="Parent accounts are not valid!";
                }else if($runprogram == 3) {
                	http_response_code(401);
					$data['Status']="ERROR";
					$data['Message']="Staff Insufficient permission!";
                }		
			}else{
                http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
			}
		}else{
            http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
		}
		echo json_encode($data);
	}

	public function deleteSelfAssessment()
	{
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				//Get self assessment
				$selfasmnt = $this->sam->getSelfAsmntDetails($json->id);
				$userArr = $this->LoginModel->getUserFromId($json->userid);
				if (empty($selfasmnt)) {
					http_response_code(401);
					$data['Status']="ERROR";
					$data['Message']="Self assessment not found!";
				}else{
					$userid = $json->userid;
					$asmntid = $json->id;
					$centerid = $selfasmnt->centerid;

					if ($userArr->userType == "Superadmin") {
	                    $runprogram = 1;
	                } else if ($userArr->userType == "Staff") {
	                	$result = $this->sm->checkPermission($userid,'deleteSelfAssessment',$centerid);
	                	$runprogram = $result->deleteSelfAssessment;
	                } else {
	                	$runprogram = 0;
	                }

	                if($runprogram == 1){	                	
						$this->sam->deleteSelfAssessment($asmntid);
						$this->sam->deleteSelfAssessmUsers($asmntid);
						http_response_code(200);
						$data['Status']="SUCCESS";
						$data['Message']="Self Assessment Deleted!";
						$data['Name']=$selfasmnt->name;
						$data['Centerid']=$centerid;
	                }else{
	                	http_response_code(401);
						$data['Status']="ERROR";
						$data['Message']="Insufficient Permission!";
						$data['Name']=$selfasmnt->name;
						$data['Centerid']=$centerid;
	                }
				}
			}else{
                http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
			}
		}else{
            http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
		}
		echo json_encode($data);
	}

	public function saveSelfAssessment()
	{
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				foreach ($json->legalities as $key => $obj) {
					$obj->user = $json->userid;
					$this->sam->saveLegalRecords($obj);
				}
				foreach ($json->qualities as $key2 => $obj2) {
					$obj2->user = $json->userid;
					$this->sam->saveQualityRecords($obj2);
				}
				$data['Status']="SUCCESS";
				$data['Message']="Record saved successfully!";
			}else{
                http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
			}
		}else{
            http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
		}
		echo json_encode($data);
	}

	public function getSelfAsmntStaffs()
	{
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;	
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$selfasmnt = $this->sam->getSelfAsmntDetails($json->self_id);
				$centerid = $selfasmnt->centerid;
				$educators = $this->sam->getAssessmentEducators($json->self_id);
				$results = $this->sam->getCenterStaffs($centerid);
				foreach ($results as $key => $obj) {
					$check = $this->sam->checkStaffInAssessment($obj->userid,$json->self_id);
					if ($check) {
						$obj->selected = "checked";
					}else{
						$obj->selected = "";
					}
				}
				$data['Status'] = "SUCCESS";
				$data['Staffs'] = $results;
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

	public function addSelfAssessmentStaffs()
	{
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;	
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){

				//create new array
				$object = [];
				$tempobj = [];
				$date = date('Y-m-d H:i:s');

				$json->staffIds = json_decode($json->staffids);

				foreach($json->staffIds as $staffs => $staff){
					$tempobj['self_assess_id'] = $json->self_id;
					$tempobj['userid'] = $staff;
					$tempobj['added_by'] = $json->userid;
					$tempobj['added_at'] = $date;
					array_push($object, $tempobj);
				}

				$this->sam->deleteSelfAssessmUsers($json->self_id);

				foreach ($object as $key => $obj) {
					$this->sam->addSelfAssessmStaffs($obj);
				}

				$data['Status'] = "SUCCESS";
				$data['Message'] = "Educators added successfully!";
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
}

/* End of file SelfAssessment 2.php */
/* Location: ./application/controllers/SelfAssessment 2.php */