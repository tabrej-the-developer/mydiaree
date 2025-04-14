<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Util extends CI_Controller {

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
		$this->load->model('UtilModel');
		$this->load->model('LoginModel');
	}

	public function index(){
		
	}
	
	// All centers linked for that user
	public function GetAllCenters($userid){
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
				if( $res != null && $res->userid == $userid){
					$user = $this->UtilModel->getUserDetails($userid);
					$data['Centers'] = [];
					if ($user->userType=="Parent") {
						// $childarr = $this->LoginModel->getChildsRoomId($userid);

						// foreach ($childarr as $key => $ch) {
						// 	$centers = $this->LoginModel->getRoomCenters($ch->room);
						// 	array_push($data['Centers'], $centers);
						// }
						$data['Centers'] = $this->UtilModel->GetParentCenters($userid);
					} else {
						$data['Centers'] = $this->UtilModel->GetAllCenters($userid);
					}
					
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

	public function GetCentersBySuperadmin($userid){
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
				if( $res != null && $res->userid == $userid){
					$data['Centers'] = $this->UtilModel->GetAllCentersBySuperadmin($userid);
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

	public function getPermissions($userid='',$centerid='')
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
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			if ($userid=='') {
				$userid = $json->userid;
			}
			if ($centerid=='') {
				$centerid = $json->centerid;
			}
			if($res != null && $res->userid == $userid){
				$permission = $this->UtilModel->getPermissions($userid,$centerid);
				$data['Status'] = "SUCCESS";
				$data['Permissions'] = $permission;
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

	public function hasPermission($userid="",$pc="") // $pc means permission column
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
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			if ($userid=='') {
				$userid = $json->userid;
			}
			if ($pc=='') {
				$pc = isset($json->pc)?$json->pc:"";
			}
			if($res != null && $res->userid == $userid){
				$permission = $this->UtilModel->hasPermission($userid,$pc);
				$data['Status'] = "SUCCESS";
				$data['permissions']=$permission;
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

	public function getCenterEducators()
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
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			if ($res != NULL && $json != NULL && $res->userid = $json->userid) {
				if(empty($json->centerid)){
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Center id is required!";
				}else{
					$educators = $this->UtilModel->getCenterEducators($json->centerid);
					$data['Status'] = "SUCCESS";
					$data['educators']=$educators;
				}
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid user account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

}

/* End of file Util.php */
/* Location: ./application/controllers/Util.php */