<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Children extends CI_Controller {

	function __construct($foo = null)
	{
		$this->foo = $foo;

		parent::__construct();

		$this->load->model('ChildrenModel');
		$this->load->model('LoginModel');

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

	public function getChilds()
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

				if (isset($json->centerid)) {
					$records = $this->ChildrenModel->getChildsFromCenter($json->centerid);
				}else{
					$records = $this->ChildrenModel->getChilds();
				}
				$data['Status']='SUCCESS';
				$data['records']=$records;
				echo json_encode($data);

				// print_r($records);
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = 'Invalid Data Passed';
			}
		}else{
			http_response_code(401);
		}
	}

	public function getGroupsAndChilds()
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
				$groups = $this->ChildrenModel->getChildGroups();
				foreach ($groups as $group) {
					$groupId = $group->id;
					$group->childs = $this->ChildrenModel->getChildsFromGroups($groupId);
				}
				http_response_code(200);
				$data['Status']='SUCCESS';
				$data['groups']=$groups;
				echo json_encode($data);
			}else{
				http_response_code(401);
				$data['Status']='ERROR';
				$data['Message']="User doesn't match!";
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function moveChildren(){
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
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){
					$children = isset($json->children) ? $json->children : [];
					foreach($children as $child){
						$childId = isset($child->childid) ? $child->childid : null;
						$roomId = isset($child->roomid) ? $child->roomid : null;
						if($childId != null && $roomId != null){
							$this->ChildrenModel->moveChild($childId,$roomId);
						}
					}
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

    public function createChild()
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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
          if ($json != null && $res != null && $res->userid == $json->userid){
              $this->load->model('roomModel');
              if ($json->imageName) {
                  $target_dir = 'assets/media/';
                  file_put_contents($target_dir . $json->imageName,base64_decode($json->image));
              }
              $id = $this->roomModel->createChild($json);
              http_response_code(200);
              $data['status'] = 'Success';
              $data['id'] = $id;
              echo json_encode($data);
          }
        } else {
            http_response_code(401);
        }
    }
    public function editChild(){
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
        if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
            $this->load->model('loginModel');
            $res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
            if ($json != null &&$res != null &&$res->userid == $json->userid) {
                $this->load->model('roomModel');
                if ($json->imageName) {
                    $target_dir = 'assets/media/';
                    file_put_contents($target_dir . $json->imageName,base64_decode($json->image));
                }
                $id = $this->roomModel->editChild($json);
                http_response_code(200);
                $data['status'] = 'Success';
                $data['id'] = $id;
                echo json_encode($data);
            }
        } else {
            http_response_code(401);
        }
    }

    public function getChildrenInRoom($userid,$roomId){
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
						$this->ChildrenModel->getChildrenInRoom($roomId);
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

    public function getCenterChilds(){
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
        if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
            $this->load->model('loginModel');
            $res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
            if ($json != null &&$res != null &&$res->userid == $json->userid) {
				$records = $this->ChildrenModel->getCenterChilds($json->centerid);
				$centerinfo = $this->ChildrenModel->getObsPeriod($json->centerid);
				foreach ($records as $key => $obj) {
					$lastObsArr = $this->ChildrenModel->getChildsLastObservation($obj->id);
					if (empty($lastObsArr)) {
						$obj->observation_id = NULL;
						$obj->observation_title = NULL;
						$obj->observation_status = NULL;
						$obj->observation_createdOn = NULL;
						$obj->observation_color = NULL;
					}else{
						$obj->observation_id = $lastObsArr->id;
						$obj->observation_title = $lastObsArr->title;
						$obj->observation_status = $lastObsArr->status;
						$obj->observation_createdOn = $lastObsArr->date_added;
						$date1=date_create($lastObsArr->date_added);
						$date2=date_create(date('d-m-Y'));
						$diff=date_diff($date1,$date2);
						if ($diff->format("%a") > $centerinfo->days) {
							$obj->observation_color = "red";
						}
					}
				}
				http_response_code(200);
				$data['Status'] = "SUCCESS";
				$data['Childs'] = $records;
                $data['TotalChilds'] = count($records);
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

}

/* End of file Children.php */
/* Location: ./application/controllers/Children.php */