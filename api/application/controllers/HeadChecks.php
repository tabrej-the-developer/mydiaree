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
		$this->load->database(); 
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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
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




	public function saveSleepChecklist()
{
    $headers = $this->input->request_headers();
    $updated_headers = [];

    // Normalize headers
    foreach ($headers as $key => $value) {
        $lower_key = strtolower($key);
        if ($lower_key === 'x-device-id') {
            $updated_headers['X-Device-Id'] = $value;
        } elseif ($lower_key === 'x-token') {
            $updated_headers['X-Token'] = $value;
        } else {
            $updated_headers[$key] = $value;
        }
    }

    $headers = $updated_headers;

    // Check auth headers
    if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
        $authUser = $this->LoginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);

        $json = json_decode(file_get_contents('php://input'));
        if (!$json) {
            $json = (object) $_POST;
        }

		
        if ($authUser != null && isset($json->userid) && $authUser->userid == $json->userid) {
            // Validate required fields
            if (empty($json->childid) || empty($json->diarydate) || empty($json->time)) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode(['success' => false, 'message' => 'Required fields are missing']));
            }
  
			$mysqlDate = $json->diarydate;
			$formattedDate = date('Y-m-d', strtotime($mysqlDate));
// print_r($formattedDate); // Outputs: 2025-05-01
// exit;
        

            // Prepare data
            $data = [
                'childid' => $json->childid,
                'diarydate' => $formattedDate,
                'roomid' => $json->roomid ?? null,
                'time' => $json->time,
                'breathing' => $json->breathing ?? null,
                'body_temperature' => $json->body_temperature ?? null,
                'notes' => $json->notes ?? null,
                'createdBy' => $authUser->userid,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->insert('dailydiarysleepchecklist', $data);

            if ($this->db->affected_rows() > 0) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(['success' => true, 'message' => 'Saved successfully']));
            } else {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(500)
                    ->set_output(json_encode(['success' => false, 'message' => 'Failed to save']));
            }

        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(403)
                ->set_output(json_encode(['success' => false, 'message' => 'Unauthorized or invalid user']));
        }

    } else {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(401)
            ->set_output(json_encode(['success' => false, 'message' => 'Missing authentication headers']));
    }
}




public function updateSleepChecklist()
{
    $headers = $this->input->request_headers();
    $updated_headers = [];

    foreach ($headers as $key => $value) {
        $lower_key = strtolower($key);
        if ($lower_key === 'x-device-id') {
            $updated_headers['X-Device-Id'] = $value;
        } elseif ($lower_key === 'x-token') {
            $updated_headers['X-Token'] = $value;
        } else {
            $updated_headers[$key] = $value;
        }
    }
    $headers = $updated_headers;

    if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
        $authUser = $this->LoginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);

        $json = json_decode(file_get_contents('php://input'));
        if (!$json) {
            $json = (object) $_POST;
        }

        if ($authUser != null && isset($json->userid) && $authUser->userid == $json->userid) {
            if (empty($json->id) || empty($json->childid) || empty($json->diarydate) || empty($json->time)) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode(['success' => false, 'message' => 'Required fields are missing']));
            }

            // $diaryDate = str_replace('-', '/', $json->diarydate);
            // $date = DateTime::createFromFormat('d/m/Y', $diaryDate);
            // $mysqlDate = $date ? $date->format('Y-m-d') : null;

			$mysqlDate = $json->diarydate;
			$formattedDate = date('Y-m-d', strtotime($mysqlDate));

            $data = [
                'childid' => $json->childid,
                'diarydate' => $formattedDate,
                'roomid' => $json->roomid ?? null,
                'time' => $json->time,
                'breathing' => $json->breathing ?? null,
                'body_temperature' => $json->body_temperature ?? null,
                'notes' => $json->notes ?? null
            ];

            $this->db->where('id', $json->id);
            $this->db->update('dailydiarysleepchecklist', $data);

            if ($this->db->affected_rows() > 0) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(['success' => true, 'message' => 'Updated successfully']));
            } else {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(['success' => false, 'message' => 'No changes made or update failed']));
            }
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(403)
                ->set_output(json_encode(['success' => false, 'message' => 'Unauthorized or invalid user']));
        }
    } else {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(401)
            ->set_output(json_encode(['success' => false, 'message' => 'Missing authentication headers']));
    }
}




public function deleteSleepChecklist()
{
    $headers = $this->input->request_headers();
    $updated_headers = [];

    foreach ($headers as $key => $value) {
        $lower_key = strtolower($key);
        if ($lower_key === 'x-device-id') {
            $updated_headers['X-Device-Id'] = $value;
        } elseif ($lower_key === 'x-token') {
            $updated_headers['X-Token'] = $value;
        } else {
            $updated_headers[$key] = $value;
        }
    }
    $headers = $updated_headers;

    if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
        $authUser = $this->LoginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);

        $json = json_decode(file_get_contents('php://input'));
        if (!$json) {
            $json = (object) $_POST;
        }

        if ($authUser != null && isset($json->userid) && $authUser->userid == $json->userid) {
            if (empty($json->id)) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(400)
                    ->set_output(json_encode(['success' => false, 'message' => 'Invalid ID']));
            }

            $this->db->where('id', $json->id);
            $this->db->delete('dailydiarysleepchecklist');

            if ($this->db->affected_rows() > 0) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(['success' => true, 'message' => 'Deleted successfully']));
            } else {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(['success' => false, 'message' => 'Failed to delete or already removed']));
            }
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(403)
                ->set_output(json_encode(['success' => false, 'message' => 'Unauthorized or invalid user']));
        }
    } else {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(401)
            ->set_output(json_encode(['success' => false, 'message' => 'Missing authentication headers']));
    }
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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
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