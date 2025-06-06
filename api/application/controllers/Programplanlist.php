<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Programplanlist extends CI_Controller{

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
		$this->load->model('UtilModel');
        $this->load->model('ChildrenModel');
		$this->load->model('CentersModel');
        $this->load->model('RoomModel');
		$this->load->model('ProgramplanlistModel');
		$this->load->model('UsersModel');
		$this->load->model('ObservationModel');
        
	}

	public function fetchProgPlanDetails()
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
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers))
		{
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}			
			if($json!= null && $res != null && $res->userid == $json->userid){
				if(empty($json->programid)){
					http_response_code(401);
					$data['Status']="ERROR";
					$data['Message']="Program Plan id is missing!";
				}else{

					$programPlan = $this->ProgramplanlistModel->getProgramPlanInfo($json->programid);
					$centerRecord = $this->ProgramplanlistModel->getCenterDetailsFromRoomId($programPlan->room_id);
					$rooms = $this->ProgramplanlistModel->getAllOtherRooms($programPlan->room_id);
					$usersArr = $this->ProgramplanlistModel->getCenterEducatorsFromRoomId($programPlan->room_id);					
					foreach ($usersArr as $key => $obj) {
						$resp = $this->ProgramplanlistModel->checkUserInProgramPlan($json->programid,$obj->id);
						if (empty($resp)) {
							$obj->checked = "";
						}else{
							$obj->checked = "selected";
						}
					}
					
					$programPlan->headings = $this->ProgramplanlistModel->getProgramPlanHeadings($json->programid);
					foreach ($programPlan->headings as $headingKey => $headingObj) {
						$headingObj->contents = $this->ProgramplanlistModel->getProgramPlanContents($headingObj->id);
					}

					$programPlan->users = $this->ProgramplanlistModel->getProgramPlanUsers($json->programid);
					
					$data['Status'] = "SUCCESS";
					$data['ProgramPlan'] = $programPlan;
					$data['Rooms'] = $rooms;
					$data['Users'] = $usersArr;
					$data['centerid'] = $centerRecord->id;
				}
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

	public function saveLinks()
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
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);		
			$json = json_decode(file_get_contents('php://input'));
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}			
			if($json!= null && $res != null && $res->userid == $json->userid){
				if(empty($json->programid)){
					http_response_code(401);
					$data['Status']="ERROR";
					$data['Message']="Program Plan id is missing!";
				}else{
					$this->ProgramplanlistModel->saveLinks($json);
					$data['Status']="SUCCESS";
					$data['Message']="Links saved successfully";
				}
			}else{
				http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="User Id doesn't match";
			}
		}
		else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
		}
        echo json_encode($data);
	}

    public function getprogramplandetails(){

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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			
			if($json!= null && $res != null && $res->userid == $json->userid){
		
				if(trim($json->usertype)=='Staff'){
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
				} else {
					$permission->editProgramPlan='1';
				}
                $send_room=$send_users=[];
                $get_room_details=$this->RoomModel->get_room_details();

                foreach($get_room_details as $room_key=>$room_value){
                    $send_room[$room_value->id]=$room_value->name;
                }
				$get_user=$this->UsersModel->user();

				

				foreach($get_user as $get_key=>$get_value){
					$send_users[$get_value->userid]=$get_value->name;
				}
					$data['Status']='SUCCESS';
                    $data['room']=$send_room;
					$data['users']=$send_users;
					//print_r($data);die();
                    echo json_encode($data);
                    http_response_code(200);
			}
			
			
		}
		else{
			http_response_code(401);
		}
    }


	public function saveprogramplandetails(){
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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			
			if($json!= null && $res != null && $res->userid == $json->userid){
				
				if(trim($json->usertype)=='Staff'){
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
				} else {
					$permission->editProgramPlan='1';
				}
				
				if($json->edit_id!=''){
					$get_status =$this->ProgramplanlistModel->update($json);
				}else {
					
					$get_status =$this->ProgramplanlistModel->insert($json);
				}
				
					if($get_status){
						$data['Status']='SUCCESS';
						$data['insert_id']=$get_status;
					} else {
						$data['Status']='Error';
					}
					http_response_code(200);
                    echo json_encode($data);
					
                    
			}
			
			
		}
		else{
			http_response_code(401);
		}

	}

	public function saveprogramplandetails_old(){

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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			
			if($json!= null && $res != null && $res->userid == $json->userid){
		
				if(trim($json->usertype)=='Staff'){
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
				} else {
					$permission->editProgramPlan='1';
				}
                //print_r($json);
				
				if($json->edit_id!=''){
					$get_status =$this->ProgramplanlistModel->update($json);
				}else {
					$get_status =$this->ProgramplanlistModel->insert($json);
				}
				//print_r($get_status);die();
					if($get_status){
						$data['Status']='Success';
						$data['insert_id']=$get_status;
					} else {
						$data['Status']='Error';
					}
					
                    echo json_encode($data);
					
                    http_response_code(200);
			}
			
			
		}
		else{
			http_response_code(401);
		}

	}


	public function show_details(){
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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			if($json!= null && $res != null && $res->userid == $json->userid){

				$userType = trim($json->usertype);

				$per = new stdClass();
				if($userType == "Superadmin"){
					$per->add = 1;
					$per->edit = 1;
					$per->view = 1;
					$per->delete = 1;
				}else if($userType == "Staff"){
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
					if (empty($permission)) {
						$per->add = 0;
						$per->edit = 0;
						$per->view = 0;
						$per->delete = 0;
					}else{
						$per->add = $permission->addProgramPlan;
						$per->edit = $permission->editProgramPlan;
						$per->view = $permission->viewProgramPlan;
						$per->delete = $permission->deleteProgramPlan;
					}
				} else {
					$per = NULL;
				}

				$this->load->model('RoomModel');
				$this->load->model('UsersModel');

				$programList = $this->ProgramplanlistModel->showprogram($json->centerid);
				foreach ($programList as $programKey => $programObj) {
                	$roomArr = $this->RoomModel->getRoom($programObj->room_id);
                	$programObj->roomName = $roomArr->name;
                	$programObj->roomColor = $roomArr->color;

                	$userArr = $this->UsersModel->getUserDetails($programObj->createdBy);
                	$programObj->userName = $userArr->name;
                	$programObj->userid = $userArr->userid;
                }
                $data['Status']='SUCCESS';
                $data['get_program_details'] = $programList;
                $data['permission'] = $per;
			}else{
				http_response_code(401);
				$data['Status']='ERROR';
				$data['Message']='Invalid User Account Used!';
			}
		} else {
			http_response_code(401);
			$data['Status']='ERROR';
			$data['Message']='Invalid Headers Used!';
		}
		echo json_encode($data);
	}


	public function get_details_list(){
		
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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
				// echo "<pre>";
				// print_r($json);
				// exit;
			if($json!= null && $res != null && $res->userid == $json->userid){
				if(trim($json->usertype)=='Staff'){
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
				} else {
					$permission->editProgramPlan='1';
				}
				$get_details=[];
                $get_details=$this->ProgramplanlistModel->get_programlistdetails($json);
				$data['get_details']=$get_details;
				/*$data['room']=$send_room;
				$data['users']=$send_users;*/
                $data['Status']='Success';
                echo json_encode($data);
                http_response_code(200);
			}
			
			
		}
		else{
			http_response_code(401);
		}

	}


	public function edit_programlistdetails(){

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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			
			
			if($json!= null && $res != null && $res->userid == $json->userid){
				
				if(trim($json->usertype)=='Staff'){
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
				} else {
					$permission->editProgramPlan='1';
				}

						
                
				$get_details=[];
                $get_details=$this->ProgramplanlistModel->edit_programlistdetails($json);
				
				$data['get_details']=$get_details;
                $data['Status']='Success';
				
                    echo json_encode($data);
                    http_response_code(200);
			}
			
			
		}
		else{
			http_response_code(401);
		}

	}


	// public function delete(){
	// 	$headers = $this->input->request_headers();
// $updated_headers = []; // Temporary array to store modified headers

// foreach ($headers as $key => $value) {
//     $lower_key = strtolower($key);

//     // Normalize key names
//     if ($lower_key === 'x-device-id') {
//         $updated_headers['X-Device-Id'] = $value;
//     } elseif ($lower_key === 'x-token') {
//         $updated_headers['X-Token'] = $value;
//     } else {
//         $updated_headers[$key] = $value; // Keep other headers as is
//     }
// }

// // Assign back to $headers
// $headers = $updated_headers;

	// 	if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			
	// 		$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			
			
	// 		$json = json_decode(file_get_contents('php://input'));
			// if($json){
			// 	$json = $json;
			// 	}else{
			// 		$json = $_POST;
			// 		$json = (object)$_POST;
			// 	}
			
	// 		if($json!= null && $res != null && $res->userid == $json->userid){
				
	// 			if(trim($json->usertype)=='Staff'){
	// 				$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
	// 			} else {
	// 				$permission->deleteProgramPlan='1';
	// 			}
                
	// 			if($permission->deleteProgramPlan=='1'){
	// 				$get_details=$this->ProgramplanlistModel->delete($json);
    //             	$data['Status']='Success';
	// 			}else{
	// 				$data['Status']='ERROR';
	// 				$data['Message']="Permission Error.";
	// 			}
                
				
    //                 echo json_encode($data);
    //                 http_response_code(200);
	// 		}
			
			
	// 	}
	// 	else{
	// 		http_response_code(401);
	// 	}
	// }


	public function programPlanList() {
        $headers = $this->input->request_headers();

        // Normalize header keys
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

        // Validate headers and authenticate
        if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
            $res = $this->loginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);

            $json = json_decode(file_get_contents('php://input'));
            if (!$json) {
                $json = (object) $_POST;
            }

            if ($json != null && $res != null && $res->userid == $json->userid) {

                $usertype = $res->usertype;
                $userid = $res->userid;

                // Get centerid
                $centerid = isset($json->centerid) ? intval($json->centerid) : 0;

                // Superadmin - get all data
                if ($usertype == "Superadmin") {
                    $this->db->select('ppd.*, u.name as creator_name, r.name as room_name');
                    $this->db->from('programplantemplatedetailsadd as ppd');
                    $this->db->join('users as u', 'u.userid = ppd.created_by', 'left');
                    $this->db->join('room as r', 'r.id = ppd.room_id', 'left');
                    $this->db->where('ppd.centerid', $centerid);
                    $this->db->order_by('ppd.created_at', 'DESC');
                    $query = $this->db->get();
                } else {
                    // Other users - filter by created_by or educators
                    $this->db->select('ppd.*, u.name as creator_name, r.name as room_name');
                    $this->db->from('programplantemplatedetailsadd as ppd');
                    $this->db->join('users as u', 'u.userid = ppd.created_by', 'left');
                    $this->db->join('room as r', 'r.id = ppd.room_id', 'left');
                    $this->db->where('ppd.centerid', $centerid);
                    $this->db->group_start();
                    $this->db->where('ppd.created_by', $userid);
                    $this->db->or_like('ppd.educators', $userid);
                    $this->db->group_end();
                    $this->db->order_by('ppd.created_at', 'DESC');
                    $query = $this->db->get();
                }

                $program_plans = $query->result();

				// Assuming you already have these IDs
$childIDs = explode(',', $program_plans[0]->children); // Convert to array
$userIDs = explode(',', $program_plans[0]->educators); // Convert to array

$CI =& get_instance(); // Get CodeIgniter instance

// Get Child Data
$childrenData = [];
foreach ($childIDs as $id) {
    $child = $CI->db->select('name, lastname')
                    ->from('child')
                    ->where('id', trim($id))
                    ->get()
                    ->row();

    if ($child) {
        $childrenData[] = [
            'id' => $child->id,
            'name' => $child->name,
            'lastname' => $child->lastname
        ];
    }
}



// Get User Data
$educatorsData = [];
foreach ($userIDs as $id) {
    $user = $CI->db->select('name')
                   ->from('users')
                   ->where('userid', trim($id))
                   ->get()
                   ->row();

    if ($user) {
        $educatorsData[] = [
            'id' => $user->userid,
            'name' => $user->name
        ];
    }
}
			
                // echo "<pre>";
				// print_r($educatorsData);
				// exit;

                // Return data as JSON
                echo json_encode([
                    'status' => true,
                    'message' => 'Program plans fetched successfully.',
                    'data' => $program_plans,
					'childrendata' => $childrenData,
					'Educatorsdata' => $educatorsData
                ]);
                return;
            }
        }

        // Invalid auth or request
        echo json_encode([
            'status' => false,
            'message' => 'Unauthorized access or invalid data.'
        ]);
    }



	public function getProgramPlanFormData_post()
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

    if (isset($headers['X-Device-Id']) && isset($headers['X-Token'])) {
        $res = $this->loginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);
        $json = json_decode(file_get_contents('php://input'));
        if (!$json) {
            $json = (object)$_POST;
        }

        if ($json && $res && $res->userid == $json->userid) {
            $centerid = $json->centerid ?? 0;
            $userid = $res->userid;
            $usertype = $res->usertype;
            $planid = $json->planid ?? null;

            $admin = ($usertype == "Superadmin") ? 1 : 0;

            // Rooms
            if ($admin == 1) {
                $rooms = $this->db->where('centerid', $centerid)->get('room')->result();
            } else {
                $room_ids = $this->db->select('roomid')->where('staffid', $userid)->get('room_staff')->result_array();
                $room_ids = array_column($room_ids, 'roomid');
                $rooms = !empty($room_ids) ? $this->db->where_in('id', $room_ids)->get('room')->result() : [];
            }

            // Users
            $user_ids = $this->db->select('userid')->where('centerid', $centerid)->get('usercenters')->result_array();
            $user_ids = array_column($user_ids, 'userid');
            $users = !empty($user_ids) ? $this->db->where_in('userid', $user_ids)->get('users')->result() : [];

            // EYLF Outcomes + Activities
            $eylf_outcomes = $this->db->select('id, title, name')->order_by('title', 'ASC')->get('eylfoutcome')->result();
            foreach ($eylf_outcomes as $outcome) {
                $outcome->activities = $this->db->select('id, outcomeId, title')->where('outcomeId', $outcome->id)->get('eylfactivity')->result();
            }

            // Montessori subjects, activities, and subactivities
            $montessorisubjects = $this->db->select('idSubject, name')->order_by('idSubject', 'ASC')->get('montessorisubjects')->result();
            foreach ($montessorisubjects as $subject) {
                $subject->activities = $this->db->select('idActivity, idSubject, title')->where('idSubject', $subject->idSubject)->get('montessoriactivity')->result();
                foreach ($subject->activities as $activity) {
                    $activity->sub_activities = $this->db->select('title')->where('idActivity', $activity->idActivity)->get('montessorisubactivity')->result();
                }
            }

            // Plan Data (Edit case)
            $plan_data = null;
            $selected_educators = [];
            $selected_children = [];

            if ($planid) {
                $plan_data = $this->db->where('id', $planid)->get('programplantemplatedetailsadd')->row();
                if ($plan_data) {
                    if (!empty($plan_data->educators)) {
                        $selected_educators = explode(',', $plan_data->educators);
                    }
                    if (!empty($plan_data->children)) {
                        $selected_children = explode(',', $plan_data->children);
                    }
                }
            }

            // Final Response
            $response = [
                'status' => true,
                'message' => 'Data fetched successfully',
                'data' => [
                    'rooms' => $rooms,
                    'users' => $users,
                    'centerid' => $centerid,
                    'user_id' => $userid,
                    'eylf_outcomes' => $eylf_outcomes,
                    'Montessori' => $montessorisubjects,
                    'plan_data' => $plan_data,
                    'selected_educators' => $selected_educators,
                    'selected_children' => $selected_children,
                    'is_edit' => !empty($planid)
                ]
            ];
        } else {
            $response = ['status' => false, 'message' => 'Unauthorized or invalid request'];
        }
    } else {
        $response = ['status' => false, 'message' => 'Missing required headers'];
    }

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}



public function getRoomUsers_post()
{
    $headers = $this->input->request_headers();
    $headers = array_change_key_case($headers, CASE_LOWER); // Normalize headers

    if (isset($headers['x-device-id']) && isset($headers['x-token'])) {
        $authUser = $this->loginModel->getAuthUserId($headers['x-device-id'], $headers['x-token']);
        $json = json_decode(file_get_contents('php://input'));
        if (!$json) {
            $json = (object)$_POST;
        }

        if ($authUser && $authUser->userid == $json->userid) {
            $room_id = $json->room_id ?? 0;
            $center_id = $json->center_id ?? 0;

            // Fetch staff IDs
            $staff_query = $this->db->select('staffid')->where('roomid', $room_id)->get('room_staff');

            if ($staff_query->num_rows() > 0) {
                $staff_ids = array_column($staff_query->result_array(), 'staffid');

                // Fetch user info
                $users_query = $this->db->select('userid, name')->where_in('userid', $staff_ids)->get('users');
                $users = [];
                foreach ($users_query->result() as $user) {
                    $users[] = [
                        'id' => $user->userid,
                        'name' => $user->name
                    ];
                }

                $response = ['status' => true, 'users' => $users];
            } else {
                $response = ['status' => true, 'users' => []];
            }
        } else {
            $response = ['status' => false, 'message' => 'Unauthorized or invalid user'];
        }
    } else {
        $response = ['status' => false, 'message' => 'Missing authentication headers'];
    }

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}



public function getRoomChildren_post()
{
    $headers = $this->input->request_headers();
    $headers = array_change_key_case($headers, CASE_LOWER);

    if (isset($headers['x-device-id']) && isset($headers['x-token'])) {
        $authUser = $this->loginModel->getAuthUserId($headers['x-device-id'], $headers['x-token']);
        $json = json_decode(file_get_contents('php://input'));
        if (!$json) {
            $json = (object)$_POST;
        }

        if ($authUser && $authUser->userid == $json->userid) {
            $room_id = $json->room_id ?? 0;
            $center_id = $json->center_id ?? 0;

            $query = $this->db->select('id, name, lastname')->where('room', $room_id)->get('child');

            $children = [];
            foreach ($query->result() as $child) {
                $children[] = [
                    'id' => $child->id,
                    'name' => $child->name . ' ' . $child->lastname
                ];
            }

            $response = ['status' => true, 'children' => $children];
        } else {
            $response = ['status' => false, 'message' => 'Unauthorized or invalid user'];
        }
    } else {
        $response = ['status' => false, 'message' => 'Missing authentication headers'];
    }

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}


public function deleteProgramPlan_post()
{
    $headers = $this->input->request_headers();
    $headers = array_change_key_case($headers, CASE_LOWER);

    if (isset($headers['x-device-id']) && isset($headers['x-token'])) {
        $authUser = $this->loginModel->getAuthUserId($headers['x-device-id'], $headers['x-token']);
        $json = json_decode(file_get_contents("php://input"));
		if (!$json) {
            $json = (object)$_POST;
        }

        if ($authUser && $authUser->userid == ($json->user_id ?? null)) {
            $program_id = $json->program_id ?? null;

            if (empty($program_id)) {
                $response = ['status' => 'error', 'message' => 'Program ID is required'];
                return $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }

            try {
                $this->db->where('id', $program_id);
                $result = $this->db->delete('programplantemplatedetailsadd');

                if ($result) {
                    $response = ['status' => 'success', 'message' => 'Program plan deleted successfully'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Failed to delete program plan'];
                }
            } catch (Exception $e) {
                $response = ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
            }
        } else {
            $response = ['status' => false, 'message' => 'Unauthorized or invalid user'];
        }
    } else {
        $response = ['status' => false, 'message' => 'Missing authentication headers'];
    }

    $this->output->set_content_type('application/json')->set_output(json_encode($response));
}



public function saveProgramPlan_post()
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

    if (isset($headers['X-Device-Id']) && isset($headers['X-Token'])) {
        $authUser = $this->loginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);

		$json = json_decode(file_get_contents('php://input'));
        if (!$json) {
            $json = (object)$_POST;
        }

        if ($authUser && $authUser->userid == ($json->user_id ?? null)) {
            // Validate required fields
            if (empty($json->room) || empty($json->months) || empty($json->users) || empty($json->children)) {
                $response = ['status' => 'error', 'message' => 'room, months, users, and children are required.'];
                return $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }

            // Convert arrays to comma-separated strings
            $educators = is_array($json->users) ? implode(',', $json->users) : NULL;
            $children = is_array($json->children) ? implode(',', $json->children) : NULL;

            // Build data for insert/update
            $program_data = [
                'room_id' => $json->room,
                'months' => $json->months,
                'years' => $json->years ?? NULL,
                'centerid' => $json->centerid ?? NULL,
                'created_by' => $json->user_id ?? NULL,
                'educators' => $educators,
                'children' => $children,
                'practical_life' => $json->practical_life ?? NULL,
                'focus_area' => $json->focus_area ?? NULL,
                'practical_life_experiences' => $json->practical_life_experiences ?? NULL,
                'sensorial' => $json->sensorial ?? NULL,
                'sensorial_experiences' => $json->sensorial_experiences ?? NULL,
                'math' => $json->math ?? NULL,
                'math_experiences' => $json->math_experiences ?? NULL,
                'language' => $json->language ?? NULL,
                'language_experiences' => $json->language_experiences ?? NULL,
                'culture' => $json->culture ?? NULL,
                'culture_experiences' => $json->culture_experiences ?? NULL,
                'art_craft' => $json->art_craft ?? NULL,
                'art_craft_experiences' => $json->art_craft_experiences ?? NULL,
                'eylf' => $json->eylf ?? NULL,
                'outdoor_experiences' => $json->outdoor_experiences ?? NULL,
                'inquiry_topic' => $json->inquiry_topic ?? NULL,
                'sustainability_topic' => $json->sustainability_topic ?? NULL,
                'special_events' => $json->special_events ?? NULL,
                'children_voices' => $json->children_voices ?? NULL,
                'families_input' => $json->families_input ?? NULL,
                'group_experience' => $json->group_experience ?? NULL,
                'spontaneous_experience' => $json->spontaneous_experience ?? NULL,
                'mindfulness_experiences' => $json->mindfulness_experiences ?? NULL,
            ];

            if (!empty($json->plan_id)) {
                // Update
                $program_data['updated_at'] = date('Y-m-d H:i:s', strtotime('now Australia/Sydney'));
                $this->db->where('id', $json->plan_id);
                $result = $this->db->update('programplantemplatedetailsadd', $program_data);

                if ($result) {
                    $response = [
                        'success' => true,
                        'message' => 'Program plan updated successfully',
                        'redirect_url' => base_url('LessonPlanList/programplanprintpage/' . $json->plan_id)
                    ];
                } else {
                    $response = ['status' => 'error', 'message' => 'Error updating program plan.'];
                }
            } else {
                // Insert
                $program_data['created_at'] = date('Y-m-d H:i:s', strtotime('now Australia/Sydney'));
                $result = $this->db->insert('programplantemplatedetailsadd', $program_data);

                if ($result) {
                    $insert_id = $this->db->insert_id();
                    $response = [
                        'success' => true,
                        'message' => 'Program plan created successfully',
                        'redirect_url' => base_url('LessonPlanList/programplanprintpage/' . $insert_id)
                    ];
                } else {
                    $response = ['status' => 'error', 'message' => 'Error creating program plan.'];
                }
            }
        } else {
            $response = ['status' => false, 'message' => 'Unauthorized or invalid user'];
        }
    } else {
        $response = ['status' => false, 'message' => 'Missing authentication headers'];
    }

    $this->output->set_content_type('application/json')->set_output(json_encode($response));
}



	public function delete(){
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
			
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);
			
			// Decode JSON with error handling
			$json = json_decode(file_get_contents('php://input'));
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			if (json_last_error() !== JSON_ERROR_NONE) {
				http_response_code(400);
				echo json_encode(['Status' => 'ERROR', 'Message' => 'Invalid JSON format']);
				return;
			}
	
			// Check if authenticated user ID matches the JSON payload's user ID
			if ($json != null && $res != null && isset($res->userid) && $res->userid == $json->userid) {
	
				// Get permissions based on usertype
				if (trim($json->usertype) == 'Staff') {
					$permission = $this->UtilModel->getPermissions($json->userid, $json->centerid);
				} else {
					$permission = new stdClass();
					$permission->deleteProgramPlan = '1'; // Default permission for non-staff, adjust as needed
				}
	
				// Check permission for deleting the program plan
				if ($permission->deleteProgramPlan == '1') {
					$get_details = $this->ProgramplanlistModel->delete($json);
					$data = ['Status' => 'Success'];
				} else {
					$data = ['Status' => 'ERROR', 'Message' => 'Permission Error'];
				}
				
				// Send response
				echo json_encode($data);
				http_response_code(200);
			} else {
				// Unauthorized due to invalid user ID match
				http_response_code(403);
				echo json_encode(['Status' => 'ERROR', 'Message' => 'Unauthorized']);
			}
		} else {
			// Missing required headers
			http_response_code(401);
			echo json_encode(['Status' => 'ERROR', 'Message' => 'Unauthorized: Missing headers']);
		}
	}
	

	public function  getAllPublishedObservations($user_id,$center_id,$program_id){
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
				$progPlanId = $json->progplanid;
				$observations = $this->ObservationModel->getPublishedObservationsFromCenter($center_id);
				$data['observations'] = array();
				foreach($observations as $observation)
				{
					$observation->title = strip_tags(html_entity_decode($observation->title));
					$obsLink = $this->ProgramplanlistModel->getProgramplanlink($observation->id,"OBSERVATION",$program_id);
					if (empty($obsLink)) {
						$observation->checked = NULL;
					}else{
						$observation->checked = "checked";
					}
					unset($observation->notes);
					unset($observation->reflection);					
					$media = $this->ObservationModel->getMedia($observation->id);
					$observation->media = isset($media[0]->mediaUrl)?$media[0]->mediaUrl:'';
					$observationsMedia = $this->ObservationModel->getMedia($observation->id);
					$observation->observationsMedia = isset($observationsMedia[0]->mediaUrl)?$observationsMedia[0]->mediaUrl:'';
					$observation->observationsMediaType = isset($observationsMedia[0]->mediaType)?$observationsMedia[0]->mediaType:'';
					// $childs=$this->ObservationModel->getObservationChildrens($observation->id);
					// $observation->childs=$childs;
					// $montessoryCount=$this->ObservationModel->getObservationMontessoriCount($observation->id);
					// $observation->montessoryCount=$montessoryCount;
					// $eylfCount=$this->ObservationModel->getObservationEylfCount($observation->id);
					// $observation->eylfCount=$eylfCount;
					// $milestoneCount=$this->ObservationModel->getObservationMilestoneCount($observation->id);
					// $observation->milestoneCount = $milestoneCount;
					$observation->date_added = date('d-m-Y',strtotime($observation->date_added));
				}
				http_response_code(200);
				$data['Status'] = "SUCCESS";
				$data['observations'] = $observations;
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function getPublishedReflections($userid,$centerid,$programid){
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
			if($res != null && $res->userid == $userid){
				$reflectionsArr = $this->ObservationModel->getPublishedReflections($centerid);
				//print_r($reflectionsArr); exit;
				foreach ($reflectionsArr as $key => $obj) {
					$media = $this->ObservationModel->getReflectionMedia($obj->id);
					if (count($media) > 0) {
						if ($media[0]->mediaType == "Image") {
							$obj->mediaThumbnail = $media[0]->mediaUrl;
						}else{
							$obj->mediaThumbnail = "350x350.png";
						}
					}else{
						$obj->mediaThumbnail = "350x350.png";
					}
					$obj->createdAt = date('d.m.Y',strtotime($obj->createdAt));
					$obsLink = $this->ProgramplanlistModel->getProgramplanlink($obj->id,"REFLECTION",$programid);
					if (empty($obsLink)) {
						$obj->checked = NULL;
					}else{
						$obj->checked = "checked";
					}
				} 
				
				http_response_code(200);
				$data['Status'] = "SUCCESS";
				$data['reflections'] = $reflectionsArr;
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

	function getPublishedQip($userid,$centerid,$programid){
		$headers = $this->input->request_headers($userid,$centerid,$programid);
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $res->userid == $userid){
				$qipArr = $this->ProgramplanlistModel->getCenterPublishedQip($centerid);
				foreach ($qipArr as $key => $obj) {					
					$qipLink = $this->ProgramplanlistModel->getProgramplanlink($obj->id, "QIP", $programid);
					if (empty($qipLink)) {
						$obj->checked = NULL;
					}else{
						$obj->checked = "checked";
					}
				} 
				http_response_code(200);
				$data['Status'] = "SUCCESS";
				$data['qip'] = $qipArr;
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


	public function comments(){


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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}		
				//var_dump($res); exit;
			if($json!= null && $res != null && $res->userid == $json->userid){		
				// if(trim($json->usertype)=='Staff'){
				// 	$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
				// } else {
				// 	$permission->editProgramPlan='1';
				// }
               // print_r($json);exit;
				$get_status =$this->ProgramplanlistModel->commentinsert($json);			
				if($get_status){
					$data['Status']='Success';
					$data['insert_id']=$get_status;
				} else {
					$data['Status']='Error';
				}				
                http_response_code(200);
			}else{
				http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="User Id doesn't match";
			}
		}
		else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
		}
        echo json_encode($data);
	}


	public function get_details(){

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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			
			if($json!= null && $res != null && $res->userid == $json->userid){

				$send_room=$send_users=$send_image=[];

					$get_room_details=$this->RoomModel->get_room_details();

					foreach($get_room_details as $room_key=>$room_value){
							$send_room[$room_value->id]=$room_value->name;
					}

					$get_user=$this->UsersModel->user();

					foreach($get_user as $get_key=>$get_value){
						$send_users[$get_value->userid]=$get_value->name;
						$send_image[$get_value->userid]=$get_value->imageUrl;
					}

					
						$data['Status']='Success';
						$data['user']=$send_users;
						$data['image']=$send_image;
						$data['room']=$send_room;
					
                    echo json_encode($data);
					
                    http_response_code(200);
			} else{
				$data['Status']='Permission Error!!';
			}
			
			
		}else{
			http_response_code(401);
		}
	}

	
	public function getProgPlanComments()
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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}			
			if($json!= null && $res != null && $res->userid == $json->userid){	
				if(empty($json->progplanid)){
					http_response_code(401);
					$data['Status']="ERROR";
					$data['Message']="Program plan id is required!";
				}else{
					$ppid = $json->progplanid;
					$commentsArr = $this->ProgramplanlistModel->fetchProgPlanComments($ppid);
					foreach ($commentsArr as $commentsKey => $commentsObj) {
	                	$userArr = $this->UsersModel->getUserDetails($commentsObj->userid);
	                	$commentsObj->userName = $userArr->name;
	                	$commentsObj->userImage = $userArr->imageUrl;
	                	$commentsObj->commentdatetime = date('d.m.Y',strtotime($commentsObj->commentdatetime));
					}
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Comments'] = $commentsArr;
				}
			}else{
				http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="User Id doesn't match";
			}
		}
		else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
		}
        echo json_encode($data);
	}

	public function getProgramPlanData()
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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}			
			if($json!= null && $res != null && $res->userid == $json->userid){	
				if (empty($json->centerid)) {
					http_response_code(401);
					$data['Status']="ERROR";
					$data['Message']="Invalid Centerid Provided!";
				}else{
					$roomsArr = $this->ProgramplanlistModel->getCenterRooms($json->centerid);
					$usersArr = $this->ProgramplanlistModel->getCenterEducators($json->centerid);
					$data['Status'] = "SUCCESS";
					$data['Centerid'] = $json->centerid;
					$data['Rooms'] = $roomsArr;
					$data['Users'] = $usersArr;
				}
			}else{
				http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="User Id doesn't match";
			}
		}
		else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
		}
        echo json_encode($data);
	}

	public function save()
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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}			
			if($json!= null && $res != null && $res->userid == $json->userid){	

				if (isset($json->progplanid)) {
					$id = $json->progplanid;
					$this->ProgramplanlistModel->deleteProPlan($id);
					$json->id = $id;
					$this->ProgramplanlistModel->insertProPlan($json);
				}else{
					$id = $this->ProgramplanlistModel->insertProPlan($json);
				}
				if($id){

					//insert members
					foreach ($json->members as $key => $value) {
						$members = new stdClass();
						$members->member = $value;
						$members->progPlanId = $id;
						$members->userid = $json->userid;
						$this->ProgramplanlistModel->insertProPlanUsers($members);
					}

					//insert headings and content
					$i = 1;
					foreach ($json->headings as $headingKey => $headingObj) {
						$headingArr = new stdClass();
						$headingArr->name = $headingObj->heading_title;
						$headingArr->color = $headingObj->heading_color;
						$headingArr->priority = $i;
						$headingArr->progPlanId = $id;
						$i++;
						$hid = $this->ProgramplanlistModel->insertProPlanHeading($headingArr);
						foreach ($headingObj->contents as $contentsKey => $contentsObj) {
							$contentArr = new stdClass();
							$contentArr->heading_id = $hid;
							$contentArr->perhaps = htmlspecialchars($contentsObj);
							$contentArr->userid = $json->userid;
							$contentArr->progPlanId = $id;
							$this->ProgramplanlistModel->insertProPlanContents($contentArr);
						}
					}
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Message']="Program plan added successfully!";
				}else{
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message']="Technical error occured!";
				}
			}else{
				http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="User Id doesn't match";
			}
		}
		else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
		}
        echo json_encode($data);
	}


	public function templatesave(){
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
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}			
			if($json != null && $res != null && $res->userid == $json->userid){	
				// Start a database transaction
				$this->db->trans_start();
	            
				$template_id = 'TPL_' . uniqid() . '_' . time();
				// Prepare header data
				$template_name = $json->template_name;
				$center_id = $json->centerid;
				$created_by = $json->userid;
	
				// Insert headings into template_programplanlist_header
				$header_insert_data = [];
				foreach ($json->headings as $index => $heading) {
					$header_insert_data[] = [
						'template_id' => $template_id,
						'template_name' => $template_name,
						'headingname' => $heading->heading_title,
						'headingcolor' => $heading->heading_color,
						'priority_order' => $index + 1, // start from 1 instead of 0
						'center_id' => $center_id,
						'created_by' => $created_by
					];
				}
	
				// Batch insert into header table
				$this->db->insert_batch('template_programplanlist_header', $header_insert_data);
	
				// Get the inserted header IDs
				$header_ids = $this->db->insert_id();
	
				// Prepare content data
				$content_insert_data = [];
				foreach ($json->headings as $index => $heading) {
					// Calculate the correct header ID (first ID + index)
					$header_id = $header_ids + $index;
	
					// Check if contents exist for this heading
					if (isset($heading->contents) && is_array($heading->contents)) {
						foreach ($heading->contents as $content_index => $content) {
							$content_insert_data[] = [
								'template_id' => $template_id,
								'headingid' => $header_id,
								'perhaps' => htmlspecialchars($content),
								'createdBy' => $created_by,
								'template_name' => $template_name
							];
						}
					}
				}
	
				// Batch insert into content table
				if (!empty($content_insert_data)) {
					$this->db->insert_batch('template_programplanlist_content', $content_insert_data);
				}
	
				// Complete the transaction
				$this->db->trans_complete();
	
				// Check if the transaction was successful
				if ($this->db->trans_status() === FALSE) {
					// Transaction failed
					http_response_code(500);
					$data = [
						'Status' => 'ERROR',
						'Message' => 'Failed to save template'
					];
				} else {
					// Transaction successful
					http_response_code(200);
					$data = [
						'Status' => 'SUCCESS',
						'Message' => 'Template saved successfully'
					];
				}
			} else {
				http_response_code(401);
				$data = [
					'Status' => 'ERROR',
					'Message' => 'User Id doesn\'t match'
				];
			}
		} else {
			http_response_code(401);
			$data = [
				'Status' => 'ERROR',
				'Message' => 'Invalid Headers Sent!'
			];
		}
		
		echo json_encode($data);
	}


	public function deletetemplates() {
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
	
		// Validate headers
		if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
			// Authenticate the user
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);
	
			// Decode the JSON payload
			$json = json_decode(file_get_contents('php://input'));
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
	
			// Validate payload and user
			if ($json != null && $res != null && $res->userid == $json->userid) {
				// Start a transaction
				$this->db->trans_start();
	
				// Delete from template_programplanlist_content table
				$this->db->where('template_id', $json->template_id);
				$this->db->delete('template_programplanlist_content');
	
				// Delete from template_programplanlist_header table
				$this->db->where('template_id', $json->template_id);
				$this->db->delete('template_programplanlist_header');
	
				// Complete the transaction
				$this->db->trans_complete();
	
				// Check if the transaction was successful
				if ($this->db->trans_status() === FALSE) {
					// If there was an error, return a failure response
					http_response_code(500); // Internal Server Error
					echo json_encode(['success' => false, 'message' => 'Failed to delete template.']);
				} else {
					// If successful, return a success response
					http_response_code(200); // OK
					header('Content-Type: application/json'); // Set JSON header
					echo json_encode(['success' => true, 'message' => 'Template deleted successfully.']);
				}
			} else {
				// Unauthorized: User ID doesn't match or invalid payload
				http_response_code(401); // Unauthorized
				echo json_encode(['success' => false, 'message' => 'User ID doesn\'t match or invalid payload.']);
			}
		} else {
			// Unauthorized: Invalid headers
			http_response_code(401); // Unauthorized
			echo json_encode(['success' => false, 'message' => 'Invalid headers sent.']);
		}
	}

}
?>