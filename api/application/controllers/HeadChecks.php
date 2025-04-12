<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HeadChecks extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('LoginModel');
		$this->load->model('HeadChecksModel','hcm');
		$this->load->model('UtilModel');
		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
	}

	public function index()
	{
	}

	public function getHeadChecks()
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

				$userid = $json->userid;
				if(empty($json->centerid)) {
					$userCentersArr = $this->hcm->getUserCenters($userid);
					$centerid = $userCentersArr[0]->id;
				} else {
					$centerid = $json->centerid;
				}

				if (empty($json->roomid)) {
					$getCenterRoomsArr = $this->hcm->getRooms($centerid);
					$roomid = $getCenterRoomsArr[0]->id;
					$roomname = $getCenterRoomsArr[0]->name;
					$roomcolor = $getCenterRoomsArr[0]->color;
				} else {
					$roomid = $json->roomid;
					$getRoom = $this->hcm->getRooms(NULL,$roomid);
					$roomname = $getRoom[0]->name;
					$roomcolor = $getRoom[0]->color;
					$getCenterRoomsArr = $this->hcm->getRooms($centerid);
				}

				if (empty($json->date)) {
					$date = date("Y-m-d");
				} else {
					$date = date("Y-m-d",strtotime($json->date));
				}

				$role = $this->LoginModel->getUserType($userid);
				if ($role=="Superadmin") {
					$permission = NULL;
				} else {
					if ($role == "Staff") {
						$permission = $this->UtilModel->getPermissions($userid,$centerid);
					} else {
						$permission = NULL;
					}
					
				}
				
				$data['Status'] = "SUCCESS";
				$data['centerid'] = $centerid;
				$data['date'] = $date;
				$data['roomid'] = $roomid;
				$data['roomname'] = $roomname;
				$data['roomcolor'] = $roomcolor;
				$data['rooms'] = $getCenterRoomsArr;
				$data['headChecks'] = $this->hcm->getHeadChecks($userid,$date,$roomid); //use userid to get specific records
				$data['permissions'] = $permission;
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = "Userid didn't match";
			}
		}else{
			$data['Status'] =  'ERROR';
			$data['Message'] = 'Invalid headers sent.';
		}
		echo json_encode($data);
	}




	public function getsleepChecks()
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

				$userid = $json->userid;
				if(empty($json->centerid)) {
					$userCentersArr = $this->hcm->getUserCenters($userid);
					$centerid = $userCentersArr[0]->id;
				} else {
					$centerid = $json->centerid;
				}

				if (empty($json->roomid)) {
					$getCenterRoomsArr = $this->hcm->getRooms($centerid);
					$roomid = $getCenterRoomsArr[0]->id;
					$roomname = $getCenterRoomsArr[0]->name;
					$roomcolor = $getCenterRoomsArr[0]->color;
				} else {
					$roomid = $json->roomid;
					$getRoom = $this->hcm->getRooms(NULL,$roomid);
					$roomname = $getRoom[0]->name;
					$roomcolor = $getRoom[0]->color;
					$getCenterRoomsArr = $this->hcm->getRooms($centerid);
				}

				if (empty($json->date)) {
					$date = date("Y-m-d");
				} else {
					$date = date("Y-m-d",strtotime($json->date));
				}

				$role = $this->LoginModel->getUserType($userid);
				if ($role=="Superadmin") {
					$permission = NULL;
				} else {
					if ($role == "Staff") {
						$permission = $this->UtilModel->getPermissions($userid,$centerid);
					} else {
						$permission = NULL;
					}
					
				}

				if($roomid){
					// Get the CodeIgniter database instance
					$this->load->database();
					
					// Prepare and execute the query
					$query = $this->db->get_where('child', array('room' => $roomid));
					
					// Get all results as an array of objects
					$children = $query->result();

					
					
					// Alternatively, to get results as an array of arrays:
					// $children = $query->result_array();
					
					// Now $children contains all child records with room = $roomid
					// You can process this data as needed
				}

				// http_response_code(200);
				// $dataToSend = [
				// 	'userid' => $userid,
				// 	'date' => $date,
				// 	'roomid' => $roomid,
				// ];
				
				// $jsonOutput = json_encode($dataToSend);
				
				// echo $jsonOutput;
				// exit;
				
				$data['Status'] = "SUCCESS";
				$data['centerid'] = $centerid;
				$data['date'] = $date;
				$data['roomid'] = $roomid;
				$data['children'] = $children;
				$data['roomname'] = $roomname;
				$data['roomcolor'] = $roomcolor;
				$data['rooms'] = $getCenterRoomsArr;
				$data['sleepChecks'] = $this->hcm->getsleepChecks($userid,$date,$roomid); //use userid to get specific records
				$data['permissions'] = $permission;
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = "Userid didn't match";
			}
		}else{
			$data['Status'] =  'ERROR';
			$data['Message'] = 'Invalid headers sent.';
		}
		echo json_encode($data);
	}





	public function addHeadChecks()
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
				$i=0;
				foreach ($json->headcounts as $hc) {
					if ($i==0) {
						$records = $this->hcm->addHeadChecks($hc);
					} else {
						$records = $this->hcm->addHeadChecks($hc,1);
					}
					$i++;
				}
				$data['Status'] = "SUCCESS";
				$data['Message'] = "Record added successfully";
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = 'Userid didn\'t match';
			}
		}else{
			$data['Status'] =  'ERROR';
			$data['Message'] = 'Invalid headers sent.';
		}
		echo json_encode($data);
	}

}

/* End of file HeadChecks.php */
/* Location: ./application/controllers/HeadChecks.php */