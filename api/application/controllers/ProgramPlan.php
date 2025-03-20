<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramPlan extends CI_Controller {

	function __construct() {
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
		die();
		}
		parent::__construct();
		$this->load->model('loginModel');
		$this->load->model('programPlanModel');
		$this->load->model('UtilModel');
		$this->load->model('roomModel');
	}

	public function index(){

	}

	public function  getProgramPlanForm($user_id,$centerid=null,$proPlanId=null)
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

			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);

			if($user_id!= null && $res != null && $res->userid == $user_id){

				$permission = $this->UtilModel->getPermissions($user_id,$centerid);

				if(empty($proPlanId) || $proPlanId==NULL)
				{
					$data['rooms']=$this->programPlanModel->getRooms($centerid);
				}else{
					$planArr = $this->programPlanModel->getPlan($proPlanId);
					$centerArr = $this->programPlanModel->getCenterId($planArr->roomid);
					$data['rooms']=$this->programPlanModel->getRooms($centerArr->centerid);
					$data['plan']=$this->programPlanModel->getPlan($proPlanId);
					$data['planEducators']=$this->programPlanModel->getPlanEducators($proPlanId);
				}

				$filter_type = array('filter_type'=>'staff');
			    $data['users'] = $this->roomModel->getUser($filter_type);
			    $data['permissions']=$permission;
			    
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  printForm($user_id,$proPlanId=null)
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
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$planArr = $this->programPlanModel->getPlan($proPlanId);
				$centerArr = $this->programPlanModel->getCenterId($planArr->roomid);
				$data['plan']=$this->programPlanModel->getPlan($proPlanId);
				$data['planEducators']=$this->programPlanModel->getPlanEducators($proPlanId);			    
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function updatePlan()
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
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$usr = $this->loginModel->getUserFromId($json->userid);
				if ($usr->userType == "Superadmin") {
					$run = 1;
				} else {
					if ($usr->userType == "Staff") {
						$prm = $this->UtilModel->getPermissions($json->userid,$json->centerid);
						if ($prm->addProgramPlan == 1) {
							$run = 1;
						} else {
							$run = 0;
						}
					} else {
						$run = 0;
					}
				}
				if ($run==1) {
					$id = $this->programPlanModel->updatePlan($json);
					$data['Status'] = 'SUCCESS';
					$data['id'] = $id;
				} else {
					$data['Status']='ERROR';
					$data['Message']='Permission error!';
				}
				http_response_code(200);
				echo json_encode($data);
			}
		} else {
			http_response_code(401);
		}
	}

	public function  getPlans($user_id,$centerid=NULL)
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
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				if ($centerid==NULL) {
					$plans = $this->programPlanModel->getPlans();
					$data['plans'] = $plans;
				} else {
					$permission = $this->UtilModel->getPermissions($user_id,$centerid);
					$plans = $this->programPlanModel->getPlans($centerid);
					$data['plans'] = $plans;
					$data['permissions'] = $permission;
				}
			    $data['Status'] = "SUCCESS";
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function  delete($user_id,$id)
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
			$this->load->model('loginModel');
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$planArr = $this->programPlanModel->getPlan($id);
				$centerArr = $this->programPlanModel->getCenterId($planArr->roomid);
				$usr = $this->loginModel->getUserFromId($json->userid);
				if ($usr->userType == "Superadmin") {
					$run = 1;
				} else {
					if ($usr->userType == "Staff") {
						$prm = $this->UtilModel->getPermissions($user_id,$centerArr->centerid);
						if ($prm->deleteProgramPlan == 1) {
							$run = 1;
						} else {
							$run = 0;
						}
					} else {
						$run = 0;
					}
				}

				if($run==1){
					$this->programPlanModel->deletePlan($id);
					$data['Status']='SUCCESS';
					$data['Message']='Program plan deleted';
				}else{
					$data['Status']='ERROR';
					$data['Message']='Permission error!';
				}
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function createPlan()
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
			$this->load->model('loginModel');
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$usr = $this->loginModel->getUserFromId($json->userid);
				if ($usr->userType == "Superadmin") {
					$run = 1;
				} else {
					if ($usr->userType == "Staff") {
						$prm = $this->UtilModel->getPermissions($json->userid,$json->centerid);
						if ($prm->addProgramPlan == 1) {
							$run = 1;
						} else {
							$run = 0;
						}
					} else {
						$run = 0;
					}
				}
				if ($run==1) {
				    $id=$this->programPlanModel->createPlan($json);
				    $data['Status']='SUCCESS';
					$data['id']=$id;
				}else{
					$data['Status']='ERROR';
					$data['Message']="Permission Error.";
				}
				http_response_code(200);
				echo json_encode($data);
			}
		}
		else{
			http_response_code(401);
		}
	}

	public function getProgramPlans()
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
			$this->load->model('loginModel');
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$results = $this->programPlanModel->getProgramPlans($json->centerid);
				$data['Status'] = "SUCCESS";
				$data['ProgramPlans'] = $results;
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