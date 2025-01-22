<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Room extends CI_Controller
{
    function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header(
            "Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method"
        );
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        parent::__construct();
        $this->load->model('LoginModel');
        $this->load->model('roomModel');
        $this->load->model('UtilModel');
    }

    public function index()
    {
    } 

    public function getRooms($user_id,$centerid, $filter_name = null){
        $headers = $this->input->request_headers();
        // print_r($user_id); exit;
        if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            if ($user_id != null && $res != null && $res->userid == $user_id) {
                $userArr = $this->LoginModel->getUserFromId($user_id);
                if ($userArr->userType == "Superadmin") {
                    $loadProg = 1;
                    $admin = 1;
                    $permission = NULL;
                }else{
                    if ($userArr->userType == "Staff") {
                        $admin = 0;
                        $permission = $this->UtilModel->getPermissions($user_id,$centerid);
                        if (!empty($permission) && $permission->viewRoom==1) {
                            $loadProg = 1;
                        } else {
                            $loadProg = 0;
                            $permission = $this->UtilModel->getPermissions(0,0);
                        }
                    }else{
                        $loadProg = 0;
                        $permission = NULL;
                    }
                }

                if ($loadProg == 1) {
                    $filter_type = ['filter_type' => 'staff','centerid'=>$centerid];
                    $educators = $this->roomModel->getUser($filter_type);
                    // print_r($user_id);exit;
                    $rooms = [];
                    if($userArr->userType == "Superadmin"){
                        // print_r("admin");exit;
                    $rooms = $this->roomModel->getRooms($user_id,$centerid,$filter_name);
                    }else{
                        // print_r("admin");exit;
                        $rooms = $this->roomModel->getRoomsByUserId($user_id,$centerid,$filter_name); 
                        // $rooms = $this->roomModel->getRooms($user_id,$centerid,$filter_name);
                    }
                    foreach ($rooms as $room) {
                        $filter_data = ['filter_room' => $room->id];
                        $childs = $this->roomModel->getRoomChilds($filter_data);
                        $room->childs = $childs;
                    }
                    $data['Status'] = 'SUCCESS';
                    $data['rooms'] = $rooms;
                    $data['users'] = $educators;
                    $data['userType'] = $userArr->userType;
                    $data['permission'] = $permission;
                } else {

                    $data['Status'] = "SUCCESS";
                    $data['rooms'] = $this->roomModel->getParentsChildRooms($user_id);
                    $data['users'] = [];
                    $data['userType'] = $userArr->userType;
                    $data['Message'] = "Insufficient Permission!";
                    $data['permission'] = $permission;
                }
            } else {
                http_response_code(401);
                $data['Status'] = "ERROR";
                $data['Message'] = "Invalid";
            }
        } else {
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid Headers Sent!";
            http_response_code(401);
        }
        echo json_encode($data);
    }

    // Get Rooms Without Current Room
    public function getRoomsExcept($user_id,$roomId){
        $headers = $this->input->request_headers();
        if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
            $this->load->model('LoginModel');
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            if ($user_id != null && $res != null && $res->userid == $user_id) {
                $this->load->model('roomModel');
                $data['Rooms'] = $this->roomModel->getRoomsExcept($roomId);
                $data['Status'] = 'SUCCESS';
                http_response_code(200);
            } else {
                http_response_code(401);
                $data['Status'] = "ERROR";
                $data['Message'] = "Invalid";
            }
        } else {
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid Headers Sent!";
            http_response_code(401);
        }
        echo json_encode($data);
    }

    public function createRoom()
    {
        $headers = $this->input->request_headers();
        if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
            if ($json != null && $res != null && $res->userid == $json->userid) {
                $userArr = $this->LoginModel->getUserFromId($json->userid);
                if ($userArr->userType == "Superadmin") {
                    $loadProg = 1;
                    $permission = NULL;
                }else{
                    if ($userArr->userType == "Staff") {
                        $permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
                        if (!empty($permission) && $permission->addRoom==1) {
                            $loadProg = 1;
                        } else {
                            $loadProg = 0;
                            $permission = $this->UtilModel->getPermissions(0,0);
                        }
                    }else{
                        $loadProg = 0;
                    }
                }

                if ($loadProg == 1) {
                    $id = $this->roomModel->createRoom($json);
                    $data['Status'] = 'SUCCESS';
                    $data['id'] = $id;
                }else{
                    $data['Status'] = 'ERROR';
                    $data['Message'] = 'Permission denied!';
                }
                
                echo json_encode($data);
            }
        } else {
            http_response_code(401);
        }
    }




    public function getEducatorsList($userId, $roomId) {
        // Validate user session/token here if needed
        
        // Get all staff users
        $filter_type = ['filter_type' => 'staff'];
        $all_educators = $this->roomModel->getUser($filter_type);
        
        // Get assigned staff for this room
        $assigned_staff = $this->roomModel->getRoomStaff2($roomId);
        
        // Create array of assigned staff IDs
        $assigned_staff_ids = array_column($assigned_staff, 'staffid');
        
        $response = [
            'status' => 'success',
            'educators' => $all_educators,
            'assigned_staff' => $assigned_staff_ids
        ];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
    
    public function updateEducatorsList() {
        $roomId = $this->input->post('roomId');
        $selectedStaff = json_decode($this->input->post('selectedStaff'));
        $userId = $this->input->post('userId');
        
        // Validate user session/token here if needed
        
        $result = $this->roomModel->updateRoomStaff($roomId, $selectedStaff);
        
        $response = [
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Educators updated successfully' : 'Failed to update educators'
        ];
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }






    public function editRoom()
    {
        $headers = $this->input->request_headers();
        if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers) ) {
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
            if ($json != null && $res != null && $res->userid == $json->userid) {
                $roomArr = $this->roomModel->getRoom($json->id);
                $user_id = $json->userid;
                $centerid = $roomArr->centerid;
                $userArr = $this->LoginModel->getUserFromId($user_id);
                if ($userArr->userType == "Superadmin") {
                    $loadProg = 1;
                }else{
                    if ($userArr->userType == "Staff") {
                        $permission = $this->UtilModel->getPermissions($user_id,$centerid);
                        if (!empty($permission) && $permission->viewRoom==1) {
                            $loadProg = 1;
                        } else {
                            $loadProg = 0;
                        }
                    }else{
                        $loadProg = 0;
                    }
                }

                if ($loadProg == 1) {
                    $id = $this->roomModel->editRoom($json);
                    $data['Status'] = 'SUCCESS';
                    $data['id'] = $id;
                } else {
                    $data['Status'] = 'ERROR';
                    $data['Message'] = "Permission denied!";
                }

                echo json_encode($data);
            }
        } else {
            http_response_code(401);
        }
    }

    public function createChild()
    {
        $headers = $this->input->request_headers();
        if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
            if ($json != null && $res != null && $res->userid == $json->userid) {
                if (empty($json->imageName)) {
                    $json->imageName = "";
                }else{
                    $target_dir = 'assets/media/';
                    file_put_contents(
                        $target_dir . $json->imageName,
                        base64_decode($json->image)
                    );
                }
                $json->createdAt = date("Y-m-d H:i:s");
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

    public function editChild()
    {
        $headers = $this->input->request_headers();
        if (
            $headers != null &&
            array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
            $this->load->model('LoginModel');
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
            if ($json != null &&$res != null &&$res->userid == $json->userid) {
                $this->load->model('roomModel');
                if (!empty($json->imageName)) {
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

    public function changeStatus()
    {
        $headers = $this->input->request_headers();
        if ( $headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers) ) {
            $this->load->model('LoginModel');
            $res = $this->LoginModel->getAuthUserId( $headers['X-Device-Id'], $headers['X-Token'] );
            $json = json_decode(file_get_contents('php://input'));
            if ( $json != null && $res != null && $res->userid == $json->userid ) {
                $this->load->model('roomModel');
                $id = $this->roomModel->changeStatus($json);
                http_response_code(200);
                $data['Status'] = 'SUCCESS';
                $data['Message'] = 'Rooms status changed!';
            } else {
                http_response_code(401);
                $data['Status'] = 'ERROR';
                $data['Message'] = 'Rooms status not changed!';
            }
        } else {
            http_response_code(401);
            $data['Status'] = 'ERROR';
            $data['Message'] = 'Invalid Headers Sent!';
        }
        echo json_encode($data);
    }

    public function deleteRoom()
    {
        $headers = $this->input->request_headers();
        if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
            if ($json != null && $res != null && $res->userid == $json->userid) {
                $user_id = $json->userid;
                $centerid = $json->centerid;
                $userArr = $this->LoginModel->getUserFromId($user_id);
                if ($userArr->userType == "Superadmin") {
                    $loadProg = 1;
                }else{
                    if ($userArr->userType == "Staff") {
                        $permission = $this->UtilModel->getPermissions($user_id,$centerid);
                        if (!empty($permission) && $permission->deleteRoom==1) {
                            $loadProg = 1;
                        } else {
                            $loadProg = 0;
                        }
                    }else{
                        $loadProg = 0;
                    }
                }

                if ($loadProg == 1) {
                    $temp_arr = [];
                    foreach ($json->rooms as $roomKey => $roomObj) {
                        $countChilds = $this->roomModel->getRoomChildsInfo($roomObj);
                        if(count($countChilds) == 0 ){
                            $this->roomModel->deleteExistingRoom($roomObj);
                            $temp_arr[] = 1;
                        }else{
                            $temp_arr[] = 0;
                        }
                    }

                    if (in_array(0, $temp_arr)) {
                        http_response_code(401);
                        $data['Status'] = 'ERROR';
                        $data['Message'] = "Rooms having child couldn't be deleted!";
                    }else{
                        http_response_code(200);
                        $data['Status'] = 'SUCCESS';
                        $data['Message'] = "Room Deleted Successfully";
                    }
                } else {
                    http_response_code(401);
                    $data['Status'] = 'ERROR';
                    $data['Message'] = "Permission denied!";
                }
            }else{
                http_response_code(401);
                $data['Status'] = 'ERROR';
                $data['Message'] = "Userid didn't match!";
            }
        } else {
            http_response_code(401);
            $data['Status'] = 'ERROR';
            $data['Message'] = "Invalid Headers Sent!";
        }
        echo json_encode($data);
    }

    public function deleteChildren()
    {
        $headers = $this->input->request_headers();
        if (
            $headers != null &&
            array_key_exists('X-Device-Id', $headers) &&
            array_key_exists('X-Token', $headers)
        ) {
            $this->load->model('LoginModel');
            $res = $this->LoginModel->getAuthUserId(
                $headers['X-Device-Id'],
                $headers['X-Token']
            );
            $json = json_decode(file_get_contents('php://input'));
            if (
                $json != null &&
                $res != null &&
                $res->userid == $json->userid
            ) {
                $this->load->model('roomModel');
                $id = $this->roomModel->deleteChildren($json);
                http_response_code(200);
                $data['status'] = 'Success';
                echo json_encode($data);
            }
        } else {
            http_response_code(401);
        }
    }

    public function deleteChilds()
    {
        $headers = $this->input->request_headers();
        if ( $headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers) ) {
            $this->load->model('LoginModel');
            $res = $this->LoginModel->getAuthUserId( $headers['X-Device-Id'], $headers['X-Token'] );
            $json = json_decode(file_get_contents('php://input'));
            if ( $json != null && $res != null && $res->userid == $json->userid ) {
                $this->load->model('roomModel');
                $this->roomModel->deleteChilds($json->childids);
                http_response_code(200);
                $data['Status'] = 'SUCCESS';
                $data['Message'] = "Records deleted successfully!";
            } else {
                http_response_code(401);
                $data['Status'] = 'SUCCESS';
                $data['Message'] = 'Invalid userid!';
            }
        } else {
            http_response_code(401);
            $data['Status'] = 'SUCCESS';
            $data['Message'] = 'Invalid headers!';
        }
        echo json_encode($data);
    }

    public function getRoomDetails($user_id, $roomId = null, $order = 'ASC')
    {
        $headers = $this->input->request_headers();
        if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
            if ($user_id != null && $res != null && $res->userid == $user_id) {

                if($roomId != null){
                    $data['room'] = $this->roomModel->getRoom($roomId);
                }

                if (empty($json->filter_groups) && empty($json->filter_status) && empty($json->filter_gender)) {
                    $filter_data = [
                        'filter_room' => $roomId,
                        'order' => $order,
                    ];
                } else {
                    $filter_data = [
                        'filter_room' => $roomId,
                        'filter_groups' => isset($json->filter_groups) ? $json->filter_groups : null,
                        'filter_status' => $json->filter_status,
                        'filter_gender' => $json->filter_gender,
                        'order' => $order
                    ];
                }

                $data['roomChilds'] = [];

                if($roomId != null){
                    $occupancy = [ "Mon"=>0,"Tue"=>0,"Wed"=>0,"Thu"=>0,"Fri"=>0];
                    $roomChilds = $this->roomModel->getRoomChilds($filter_data);
                    foreach ($roomChilds as $roomChild) {
                        $occup = str_split($roomChild->daysAttending);
                        $occupancy['Mon'] = $occupancy['Mon'] + $occup[0];
                        $occupancy['Tue'] = $occupancy['Tue'] + $occup[1];
                        $occupancy['Wed'] = $occupancy['Wed'] + $occup[2];
                        $occupancy['Thu'] = $occupancy['Thu'] + $occup[3];
                        $occupancy['Fri'] = $occupancy['Fri'] + $occup[4];
                        $roomChild->recentobs = $this->roomModel->getRecentObs($roomChild->id);
                        $observations = $this->roomModel->getChildObs($roomChild->id);
                        $draft = 0;
                        $pub = 0;
                        foreach ($observations as $observation) {
                            if ($observation->status == 'Published') {
                                $pub++;
                            } else {
                                $draft++;
                            }
                        }
                        $roomChild->draft = $draft;
                        $roomChild->pub = $pub;
                        $data['roomChilds'][] = $roomChild;
                    }
                    $data['room']->occupancy = $occupancy;
                }
                $data['roomStaff'] = $this->roomModel->getRoomStaff($roomId);
                $data['groups'] = $this->roomModel->getChildGrops();
                $filter_type = ['filter_type' => 'staff'];
                $data['users'] = $this->roomModel->getUser($filter_type);
                $data['Status'] = "SUCCESS";
                echo json_encode($data);
            }
        } else {
            http_response_code(401);
        }
    }

    public function getChildForm($user_id, $roomId = null, $childId = null)
    {
        $headers = $this->input->request_headers();
        if (
            $headers != null &&
            array_key_exists('X-Device-Id', $headers) &&
            array_key_exists('X-Token', $headers)
        ) {
            $this->load->model('LoginModel');
            $res = $this->LoginModel->getAuthUserId(
                $headers['X-Device-Id'],
                $headers['X-Token']
            );
            if ($user_id != null && $res != null && $res->userid == $user_id) {
                $this->load->model('roomModel');
                $data = [];
                $data['Status'] = "SUCCESS";
                if ($childId) {
                    $data['child'] = $this->roomModel->getRoomChild(
                        $roomId,
                        $childId
                    );
                }
                $result = $this->roomModel->getChildCenter($childId);
                $data['centerid'] = $result->id;

                http_response_code(200);
                echo json_encode($data);
            }
        } else {
            http_response_code(401);
        }
    }

    public function deleteSingleRoom()
    {
        $headers = $this->input->request_headers();
        if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
            if ($json != null && $res != null && $res->userid == $json->userid) {

                $user_id = $json->userid;
                $roomid = $json->roomid;
                $userArr = $this->LoginModel->getUserFromId($user_id);
                $roomArr = $this->roomModel->getRoom($roomid);

                if ($userArr->userType == "Superadmin") {
                    $loadProg = 1;
                }else{
                    if ($userArr->userType == "Staff") {
                        $permission = $this->UtilModel->getPermissions($user_id,$roomArr->centerid);
                        if (!empty($permission) && $permission->viewRoom==1) {
                            $loadProg = 1;
                        } else {
                            if ($user_id == $roomArr->created_by) {
                                $loadProg = 1;
                            } else {
                                $loadProg = 0;
                            }
                        }
                    }else{
                        $loadProg = 0;
                    }
                }

                if ($loadProg == 1) {                    
                    $countChilds = $this->roomModel->getRoomChildsInfo($roomid);
                    if(count($countChilds) == 0 ){
                        $this->roomModel->deleteExistingRoom($roomid);
                        $data['Status'] = 'SUCCESS';
                        $data['Message'] = 'Room deleted successfully!';
                    }else{
                        $data['Status'] = 'ERROR';
                        $data['Message'] = "Couldn't delete " . $roomArr->name . " room! Please delete or move childrens from the room then try deleting the room.";
                    }
                } else {
                    $data['Status'] = 'ERROR';
                    $data['Message'] = "Permission denied!";
                }
                echo json_encode($data);
            }

        } else {
            http_response_code(401);
        }
    }
}
