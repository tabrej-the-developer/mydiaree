<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceDetails extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
		$this->load->model('ServiceDetailsModel');
		$this->load->model('LoginModel');
	}

	public function index(){
		
	}


	// For update and create use this API 
	public function createServiceDetails(){
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
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid && $json->centerid != null){
					$data = new \stdClass;
					$data->serviceid = isset($json->serviceid) ? $json->serviceid : 0;
					$data->serviceName = isset($json->serviceName) ? $json->serviceName : null;	
					$data->serviceApprovalNumber = isset($json->serviceApprovalNumber) ? $json->serviceApprovalNumber : null;	
					$data->serviceStreet = isset($json->serviceStreet) ? $json->serviceStreet : null;	
					$data->serviceSuburb = isset($json->serviceSuburb) ? $json->serviceSuburb : null;	
					$data->serviceState = isset($json->serviceState) ? $json->serviceState : null;	
					$data->servicePostcode = isset($json->servicePostcode) ? $json->servicePostcode : null;	
					$data->contactTelephone = isset($json->contactTelephone) ? $json->contactTelephone : null;
					$data->contactMobile = isset($json->contactMobile) ? $json->contactMobile : null;	
					$data->contactFax = isset($json->contactFax) ? $json->contactFax : null;	
					$data->contactEmail = isset($json->contactEmail) ? $json->contactEmail : null;	
					$data->providerContact = isset($json->providerContact) ? $json->providerContact : null;	
					$data->providerTelephone = isset($json->providerTelephone) ? $json->providerTelephone : null;	
					$data->providerMobile = isset($json->providerMobile) ? $json->providerMobile : null;	
					$data->providerFax = isset($json->providerFax) ? $json->providerFax : null;	
					$data->providerEmail = isset($json->providerEmail) ? $json->providerEmail : null;	
					$data->supervisorName = isset($json->supervisorName) ? $json->supervisorName : null;	
					$data->supervisorTelephone = isset($json->supervisorTelephone) ? $json->supervisorTelephone : null;	
					$data->supervisorMobile = isset($json->supervisorMobile) ? $json->supervisorMobile : null;
					$data->supervisorFax = isset($json->supervisorFax) ? $json->supervisorFax : null;	
					$data->supervisorEmail = isset($json->supervisorEmail) ? $json->supervisorEmail : null;	
					$data->postalStreet = isset($json->postalStreet) ? $json->postalStreet : null;	
					$data->postalSuburb = isset($json->postalSuburb) ? $json->postalSuburb : null;	
					$data->postalState = isset($json->postalState) ? $json->postalState : null;	
					$data->postalPostcode = isset($json->postalPostcode) ? $json->postalPostcode : null;	
					$data->eduLeaderName = isset($json->eduLeaderName) ? $json->eduLeaderName : null;	
					$data->eduLeaderTelephone = isset($json->eduLeaderTelephone) ? $json->eduLeaderTelephone : null;
					$data->eduLeaderEmail = isset($json->eduLeaderEmail) ? $json->eduLeaderEmail : null;	
					$data->strengthSummary = isset($json->strengthSummary) ? $json->strengthSummary : null;	
					$data->childGroupService = isset($json->childGroupService) ? $json->childGroupService : null;	
					$data->personSubmittingQip = isset($json->personSubmittingQip) ? $json->personSubmittingQip : null;	
					$data->educatorsData = isset($json->educatorsData) ? $json->educatorsData : null;	
					$data->philosophyStatement = isset($json->philosophyStatement) ? $json->philosophyStatement : null;
					$data->centerid = $json->centerid;
					$fetch = $this->ServiceDetailsModel->getServiceDetails($data->centerid);
					if($fetch == null){
						$this->ServiceDetailsModel->addServiceDetails($data);
					}
					else{
						$this->ServiceDetailsModel->updateServiceDetails($data);
					}
					$output = [];
					$output['Status'] = "SUCCESS";
				} else {
					http_response_code(401);
					$output['Status'] = "ERROR";
					$output['Message'] = "Invalid";
				}
			}else{
				http_response_code(401);
				$output['Status'] = "ERROR";
				$output['Message'] = "Invalid Request Method";
			}
		}else{
			$output['Status'] = "ERROR";
			$output['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($output);
	}


	public function getServiceDetails($userid,$centerid){
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
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				if($res != null && $res->userid == $userid){
					$data['ServiceDetails'] = $this->ServiceDetailsModel->getServiceDetails($centerid);
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

public function deleteServiceDetails($userid,$serviceid){
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
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				if($res != null && $res->userid == $userid){
					$data['ServiceDetails'] = $this->ServiceDetailsModel->deleteServiceDetails($serviceid);
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

	}

/* End of file ServiceDetails.php */
