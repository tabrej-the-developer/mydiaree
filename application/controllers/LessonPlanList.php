<?php defined('BASEPATH') OR exit('No direct script access allowed');  

class LessonPlanList extends CI_Controller {  

    function __construct() {
      parent::__construct();
      $this->load->helper('get_details');
      $this->load->database(); 
    }

      
    public function index2()  
    {
      if($this->session->has_userdata('LoginId')){
        $this->load->view('lessonPlan_list');
      }else{ 
        $this->load->view('welcome');
      }
    }

    public function add()
    {
      if($this->session->has_userdata('LoginId')){
        $this->load->view('lessonPlan_form');
      }else{ 
        $this->load->view('welcome');
      }
    }

    public function index()
    {
      if($this->session->has_userdata('LoginId')){
          $json=[];
          $json['created']=$this->session->userdata('LoginId');
          $json['usertype']=$this->session->userdata('UserType');
          $json['userid']=$this->session->userdata('LoginId');
              
            $cen = $this->session->userdata('centerIds');
              $json['centerid'] = $cen[0]->id;

        $url = BASE_API_URL.'Programplanlist/show_details';
        $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_URL,$url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($json));
          
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
                    'X-Token: '.$this->session->userdata('AuthToken')
            ));
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $server_output = curl_exec($ch);
          $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

          if($httpcode == 200){
            $jsonOutput = json_decode($server_output);
            $data['page_content'] = $jsonOutput->get_program_details;
            curl_close ($ch);
          }
          
        $this->load->view('programPlan_list',$data);
      }else{ 
        $this->load->view('welcome');
      }
    }

    public function addProgramPlan()
    {
      
        if($this->session->has_userdata('LoginId')) {
            $json=[];
            $json['usertype']=$this->session->userdata('UserType');
            $json['userid']=$this->session->userdata('LoginId');  
            $cen = $this->session->userdata('centerIds');
            $json['centerid'] = $cen[0]->id;
            $url = BASE_API_URL.'Programplanlist/getprogramplandetails';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($json));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
                'X-Token: '.$this->session->userdata('AuthToken')
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if($httpcode == 200){
                $jsonOutput = json_decode($server_output);
                $data['room_selector']=$jsonOutput->room;
                $data['users_selector']=$jsonOutput->users;
                curl_close ($ch);
                $this->load->view('addProgramPlan',$data);
            }
      }else{ 
        $this->load->view('welcome');
      }
    }


    public function editProgramPlan($id=NULL){
      
      if($this->session->has_userdata('LoginId')){
        $json=[];

        $json['created']=$this->session->userdata('LoginId');
        $json['usertype']=$this->session->userdata('UserType');
        $json['userid']=$this->session->userdata('LoginId');
        $cen = $this->session->userdata('centerIds');
        $json['centerid'] = $cen[0]->id;
        $json['programid']=$id;

        $save_details = get_details();
      
        $url = BASE_API_URL.'Programplanlist/edit_programlistdetails';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
                  'X-Token: '.$this->session->userdata('AuthToken')
          ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          
          if($httpcode == 200){
            $save_data=[];
            $jsonOutput = json_decode($server_output);
            
            $data['program_list']=$jsonOutput->get_details->programlist;
            $data['program_header_content']=$jsonOutput->get_details->programheader;
            $data['room_selector']=$save_details->room;
            $data['users_selector']=$save_details->user;
            
            foreach($jsonOutput->get_details->programusers as $program_key=>$program_value){
          
                array_push($save_data, $program_value->userid);
            }
            $data['show_user']=implode(",",$save_data);
            curl_close ($ch);
          }

          echo "<pre>";

          print_r($data);

        // $this->load->view('editProgramPlan',$data);
      }else{ 
        $this->load->view('welcome');
      }

    }

    public function viewnewtemplate(){
      if($this->session->has_userdata('LoginId')){

        $this->load->view('addtemplateView');

      }else{ 
        $this->load->view('welcome');
      }

    }

    public function viewProgramPlan($id=NULL)
    { 
      
      if($this->session->has_userdata('LoginId')){
          $json=$user=[];

          $data['get_details']=get_details();

           $json['usertype']=$this->session->userdata('UserType');
           $json['userid']=$this->session->userdata('LoginId');
              
              $cen = $this->session->userdata('centerIds');
              $json['centerid'] = $cen[0]->id;
              $json['programid']=$id;
              
          $url = BASE_API_URL.'Programplanlist/get_details_list';
          $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($json));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                      'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
                      'X-Token: '.$this->session->userdata('AuthToken')
              ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            
            
            if($httpcode == 200){
              $jsonOutput = json_decode($server_output);
              $data['program_list']=$jsonOutput->get_details;

              foreach($jsonOutput->get_details->programusers as $program_key=>$program_value){
                  $user[$program_value->userid]=$program_value->userid;
              }

              $data['user_show'] = $user;

              $data['program_id']=$id;

              $data['loginuser_img']=$this->session->userdata('ImgUrl');
              curl_close ($ch);
            }
        $this->load->view('viewProgramPlan',$data);
      }else{ 
        $this->load->view('welcome');
      }
    }


    public function save_programplan(){
        
      if($_SERVER['REQUEST_METHOD']=='POST') {

          $_POST['startdate']=date_change($_POST['start_date']);
          $_POST['enddate']=date_change($_POST['end_date']);

          $_POST['usertype']=$this->session->userdata('UserType');
          $_POST['userid']=$this->session->userdata('LoginId');

          $cen = $this->session->userdata('centerIds');
          $_POST['centerid'] = $cen[0]->id;


          $_POST['observation']=explode(" ",str_replace( array( '"',',' , '"', '[', ']' ), ' ', $_POST['observation']));

          $_POST['reflection']=explode(" ",str_replace( array( '"',',' , '"', '[', ']' ), ' ', $_POST['reflection']));

          $_POST['qip']=explode(" ",str_replace( array( '"',',' , '"', '[', ']' ), ' ', $_POST['qip']));

          $_POST['educators']=explode(" ",str_replace( array( '"',',' , '"', '[', ']' ), ' ', $_POST['educators']));

          $_POST['head_details']=json_decode($_POST['head_details']);
          //$_POST['head_details']=$_POST['head_details'];
          
          // print_r($_POST['head_details']);die();

          //print_r(unserialize($_POST['head_details']));

          
          // die();
          // $get_data=json_decode($_POST['head_details'],true);
          
          // print_r(json_decode($_POST['head_details']));
          // die();
          
          // exit();
          
          $_POST['priority']=json_decode($_POST['priority']);

          unset($_POST['start_date']);
          unset($_POST['end_date']);
          unset($_POST[0]);
          
          

          $url = BASE_API_URL.'Programplanlist/saveprogramplandetails';
          $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($_POST));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                      'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
                      'X-Token: '.$this->session->userdata('AuthToken')
              ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

          $server_output = curl_exec($ch);
          
          $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
          
          
          if($httpcode == 200){

            $jsonOutput = json_decode($server_output);
          
                if($jsonOutput->Status=='SUCCESS'){
                  
                    $data = ['Status'=>'Success','data'=>$jsonOutput->insert_id];
                    echo json_encode($data);
                }else{
                  
                  $data = ['Status'=>'Error'];
                  echo json_encode($data);
                }
         
                curl_close ($ch);
          }
          else if($httpcode == 401){
              echo  'error';
          }
        
          $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      } else {
          $data = ['Status'=>'Error'];
          echo json_encode($data);
        }
  
    }



    public function save_programplan_old(){
	
      if($_SERVER['REQUEST_METHOD']=='POST') {

              $program_insert=[];
      
                if($_POST['edit_id']==''){
      
                $program_insert['startdate']=date_change($_POST['start_date']);
                $program_insert['enddate']=date_change($_POST['end_date']);
                $program_insert['room_id']=$_POST['room_id'];
                
                $program_insert['user_list']=json_decode($_POST['user_list']);
                

                //$program_insert['button_action']=json_decode($_POST['button_selector']);
              } else {
                
                $program_insert['edit_id']=$_POST['edit_id'];

                $program_insert['startdate']=date_change($_POST['start_date']);
                $program_insert['enddate']=date_change($_POST['end_date']);
                $program_insert['room_id']=$_POST['room_id'];

                $program_insert['user_list']=json_decode($_POST['user_list']);
                
              }
              

              $program_insert['program_content']=json_decode($_POST['program_content']);

              $program_insert['button_action']=json_decode($_POST['button_selector']);

              if(isset($_POST['priority'])){
                $priority_explode=explode(',',$_POST['priority']);

                $program_insert['priority_explode']=$priority_explode;
              }

              

              $program_insert['created']=$this->session->userdata('LoginId');
              $program_insert['usertype']=$this->session->userdata('UserType');
              $program_insert['userid']=$this->session->userdata('LoginId');
              
              $cen = $this->session->userdata('centerIds');
              $program_insert['centerid'] = $cen[0]->id;

              //print_r($program_insert);die();
            
            $url = BASE_API_URL.'Programplanlist/saveprogramplandetails';
            $ch = curl_init($url);
              curl_setopt($ch, CURLOPT_URL,$url);
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($program_insert));
              curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
                        'X-Token: '.$this->session->userdata('AuthToken')
                ));
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            //print_r($server_output);die();

            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if($httpcode == 200){

              $jsonOutput = json_decode($server_output);
            
                  if($jsonOutput->Status=='Success'){
                      $data = ['Status'=>'Success','data'=>$jsonOutput->insert_id];
                      echo json_encode($data);
                  }else{
                    $data = ['Status'=>'Error'];
                    echo json_encode($data);
                  }
           
                  curl_close ($ch);
            }
            else if($httpcode == 401){
                echo  'error';
            }
          
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      } else {
        $data = ['Status'=>'Error'];
        echo json_encode($data);
      }
    }

    function delete(){
      if($_SERVER['REQUEST_METHOD']=='POST') {
        $program_insert=[];
        $program_insert['usertype']=$this->session->userdata('UserType');
        $program_insert['userid']=$this->session->userdata('LoginId');
  
        $cen = $this->session->userdata('centerIds');
        $program_insert['centerid'] = $cen[0]->id;
        $program_insert['delete_id']=$_POST['id'];
        
        $url = BASE_API_URL.'Programplanlist/delete';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($program_insert));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
          'X-Token: '.$this->session->userdata('AuthToken')
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // echo $httpcode; exit;
        curl_close($ch);
        if($httpcode == 200){
          $jsonOutput = json_decode($server_output);
          if($jsonOutput->Status=='Success'){
            $data = ['Status'=>'Success'];
            echo json_encode($data);
          }else{
            $data = ['Status'=>'Error'];
            echo json_encode($data);
          } 
        }else if($httpcode == 401){
          echo  'error';
        }
      } else {
        $data = ['Status'=>'Error'];
        echo json_encode($data);
      }
    }

    public function getPublishedObservations()
    {
      if($this->session->has_userdata('LoginId')){
        $url = BASE_API_URL."Programplanlist/getAllPublishedObservations/" . $this->session->userdata('LoginId') . "/" . $_POST['centerid'] . "/" . $_POST['progplanid'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
          'X-Token: '.$this->session->userdata('AuthToken')
        ));
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);			
        echo $server_output;
      }else{
        redirect("Welcome");
      }
    }

    public function getPublishedReflections()
    {
      if($this->session->has_userdata('LoginId')){        
        $url = BASE_API_URL."Programplanlist/getPublishedReflections/" . $this->session->userdata('LoginId') . "/" . $_POST['centerid'] . "/" . $_POST['progplanid'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
          'X-Token: '.$this->session->userdata('AuthToken')
        ));
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);			
        echo $server_output;
      }else{
        redirect("Welcome");
      }
    }

    public function getPublishedQip()
    {
      if($this->session->has_userdata('LoginId')){
          $url = BASE_API_URL."Programplanlist/getPublishedQip/".$this->session->userdata('LoginId')."/".$_POST['centerid']."/".$_POST['progplanid'];
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_URL,$url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
            'X-Token: '.$this->session->userdata('AuthToken')
          ));
          $server_output = curl_exec($ch);
          $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close ($ch);			
          echo $server_output;
      }else{
        redirect("Welcome");
      }
    }

    public function comments()
    {
      if($_SERVER['REQUEST_METHOD']=='POST') {

        $_POST['usertype']=$this->session->userdata('UserType');
        $_POST['userid']=$this->session->userdata('LoginId');
        
        $cen = $this->session->userdata('centerIds');
        $_POST['centerid'] = $cen[0]->id;  
        //print_r($_POST); exit;    
        $url = BASE_API_URL.'Programplanlist/comments';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($_POST));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
                  'X-Token: '.$this->session->userdata('AuthToken')
          ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        print_r($server_output); exit;
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpcode == 200){
          $jsonOutput = json_decode($server_output);
          if($jsonOutput->Status=='Success'){
              $data = ['Status'=>'Success','data'=>$jsonOutput->insert_id];
              echo json_encode($data);
          }else{
            $data = ['Status'=>'Error'];
            echo json_encode($data);
          }
          curl_close ($ch);
        }
        else if($httpcode == 401){
            echo  'error';
        }
      
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      } else {
        $data = ['Status'=>'Error'];
        echo json_encode($data);
      }
    }

    // public function programPlanList()  
    // {
    //   if($this->session->has_userdata('LoginId')){
    //       $json=[];
    //       $json['created']=$this->session->userdata('LoginId');
    //       $json['usertype']=$this->session->userdata('UserType');
    //       $json['userid']=$this->session->userdata('LoginId');
    //       if (isset($_GET['centerid'])) {
    //         $centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
    //       }else{
    //         $center = $this->session->userdata("centerIds");
    //         if (empty($center)) {
    //           $centerid = 0;
    //         }else{
    //           $centerid = $center[0]->id;
    //         }
    //       }
    //       $json['centerid']=$centerid;

    //       $url = BASE_API_URL.'Programplanlist/show_details';
    //       $ch = curl_init($url);
    //       curl_setopt($ch, CURLOPT_URL,$url);
    //       curl_setopt($ch, CURLOPT_POST, 1);
    //       curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($json));
    //       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //         'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
    //         'X-Token: '.$this->session->userdata('AuthToken')
    //       ));
    //       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //       $server_output = curl_exec($ch);
    //       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //       curl_close($ch);
    //       if($httpcode == 200){
    //         $jsonOutput = json_decode($server_output);
    //         $data['page_content'] = $jsonOutput->get_program_details;
    //         $data['centerid'] = $centerid;
    //         $data['permission'] = $jsonOutput->permission;
    //         $this->load->view('programPlanList_v3',$data);
    //       }else{
    //         redirect("Welcome");
    //       }
    //   }else{ 
    //     $this->load->view('welcome');
    //   }
    // }



    public function programPlanList()  
{
    if($this->session->has_userdata('LoginId')){
        $data = [];
        $data['created'] = $this->session->userdata('LoginId');
        $data['usertype'] = $this->session->userdata('UserType');
        $data['userid'] = $this->session->userdata('LoginId');
        
        if (isset($_GET['centerid'])) {
            $centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
        } else {
            $center = $this->session->userdata("centerIds");
            if (empty($center)) {
                $centerid = 0;
            } else {
                $centerid = $center[0]->id;
            }
        }
        $data['centerid'] = $centerid;
        
        // Get program plan data using direct DB query
        $this->db->select('ppd.*, u.name as creator_name, r.name as room_name');
        $this->db->from('programplantemplatedetailsadd as ppd');
        $this->db->join('users as u', 'u.userid = ppd.created_by', 'left');
        $this->db->join('room as r', 'r.id = ppd.room_id', 'left');
        $this->db->where('ppd.centerid', $centerid);
        $this->db->order_by('ppd.created_at', 'DESC'); // Change 'created_at' to the column you want to sort by
        $query = $this->db->get();
        
        $data['program_plans'] = $query->result();
        
        // Helper function for month conversion (directly in controller)
        $data['get_month_name'] = function($month_number) {
            $months = array(
                1 => 'January',
                2 => 'February',
                3 => 'March',
                4 => 'April',
                5 => 'May',
                6 => 'June',
                7 => 'July',
                8 => 'August',
                9 => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December'
            );
            
            return isset($months[$month_number]) ? $months[$month_number] : '';
        };
        
        $this->load->view('programPlanList_v4', $data);
    } else { 
        $this->load->view('welcome');
    }
}


public function deletedataofprogramplan()
{
    // Check if user is logged in
    if (!$this->session->has_userdata('LoginId')) {
        echo json_encode(['status' => 'error', 'message' => 'You must be logged in to perform this action']);
        return;
    }
    
    // Check if it's an AJAX request
    if (!$this->input->is_ajax_request()) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        return;
    }
    
    // Get the program ID from POST data
    $program_id = $this->input->post('program_id');
    
    if (!$program_id) {
        echo json_encode(['status' => 'error', 'message' => 'Program ID is required']);
        return;
    }
    
    try {
        // Delete the program plan
        $this->db->where('id', $program_id);
        $result = $this->db->delete('programplantemplatedetailsadd');
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Program plan deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete program plan']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}


    public function viewProgramplanCreateformpage() {
      if ($this->session->has_userdata('LoginId')) {
          $centerid = $this->input->get('centerid');
          $userid = $this->session->userdata('LoginId');
          $usertype = $this->session->userdata('UserType');
          $planid = $this->input->get('planid');
          // print_r($planid);
          // exit;

  
          $admin = ($usertype == "Superadmin") ? 1 : 0;
  
          // Fetch room data
          if ($admin == 1) {
              // Superadmin: Get all rooms for the center
              $rooms = $this->db->where('centerid', $centerid)->get('room')->result();
          } else {
              // Normal user: Get room IDs from room_staff where staffid = $userid
              $room_ids = $this->db->select('roomid')->where('staffid', $userid)->get('room_staff')->result_array();
              $room_ids = array_column($room_ids, 'roomid');
              
              if (!empty($room_ids)) {
                  $rooms = $this->db->where_in('id', $room_ids)->get('room')->result();
              } else {
                  $rooms = [];
              }
          }
  
          // Fetch user data
          $user_ids = $this->db->select('userid')->where('centerid', $centerid)->get('usercenters')->result_array();
          $user_ids = array_column($user_ids, 'userid');
  
          if (!empty($user_ids)) {
              $users = $this->db->where_in('userid', $user_ids)->get('users')->result();
          } else {
              $users = [];
          }

           // Fetch EYLF Outcomes
        $eylf_outcomes = $this->db->select('id, title, name')
        ->order_by('title', 'ASC')
        ->get('eylfoutcome')
        ->result();

// Fetch EYLF Activities for each outcome
$outcomes_with_activities = [];
foreach ($eylf_outcomes as $outcome) {
$activities = $this->db->select('id, outcomeId, title')
           ->where('outcomeId', $outcome->id)
           ->get('eylfactivity')
           ->result();

$outcome->activities = $activities;
$outcomes_with_activities[] = $outcome;
}

$plan_data = null;
$selected_educators = [];
$selected_children = [];

// If planid is provided, fetch plan data for editing
if ($planid) {
    $plan_data = $this->db->where('id', $planid)
                        ->get('programplantemplatedetailsadd')
                        ->row();
    
    if ($plan_data) {
        // Process educators and children IDs
        if (!empty($plan_data->educators)) {
            $selected_educators = explode(',', $plan_data->educators);
        }
        
        if (!empty($plan_data->children)) {
            $selected_children = explode(',', $plan_data->children);
        }
    }
}


          // Load view with data
          $data = [
              'rooms' => $rooms,
              'users' => $users,
              'centerid' => $centerid,
              'user_id' => $userid,
              'eylf_outcomes' => $outcomes_with_activities,
              'plan_data' => $plan_data,
              'selected_educators' => $selected_educators,
              'selected_children' => $selected_children,
              'is_edit' => !empty($planid)
          ];
          // echo "<pre>";
          // print_r($data);
          // exit;
          $this->load->view('viewProgramplanCreateformpage', $data);
      } else { 
          $this->load->view('welcome');
      }
  }


  public function get_room_users() {
    $room_id = $this->input->post('room_id');
    $center_id = $this->input->post('center_id');
    
    // First get staffids from room_staff table
    $this->db->select('staffid');
    $this->db->from('room_staff');
    $this->db->where('roomid', $room_id);
    $staff_query = $this->db->get();
    
    if ($staff_query->num_rows() > 0) {
        // Get all staffids in an array
        $staff_ids = array_column($staff_query->result_array(), 'staffid');
        
        // Now get user details from users table
        $this->db->select('userid, name'); // Add any other required fields
        $this->db->from('users');
        $this->db->where_in('userid', $staff_ids);
        $users_query = $this->db->get();
        
        // Format the data for response
        $users = array();
        foreach ($users_query->result() as $user) {
            $users[] = array(
                'id' => $user->userid,
                'name' => $user->name
            );
        }
        
        echo json_encode($users);
    } else {
        echo json_encode(array());
    }
}

public function get_room_children() {
  $room_id = $this->input->post('room_id');
  $center_id = $this->input->post('center_id');
  
  // Get children with separate name fields
  $this->db->select('id, name, lastname');
  $this->db->from('child');
  $this->db->where('room', $room_id);
  $query = $this->db->get();
  
  // Format the data for the dropdown
  $children = array();
  foreach ($query->result() as $child) {
      $children[] = array(
          'id' => $child->id,
          'name' => $child->name . ' ' . $child->lastname
      );
  }
  
  echo json_encode($children);
}






public function save_program_planinDB() {
  // Get the posted data
  $data = $this->input->post();

  // Validate required fields
  if (empty($data['room']) || empty($data['months']) || empty($data['users']) || empty($data['children'])) {
      $response = array(
          'status' => 'error',
          'message' => 'room_id, months, educators, and children fields are required.'
      );
      echo json_encode($response);
      return;
  }

  // Convert arrays to comma-separated strings
  $educators = is_array($data['users']) ? implode(',', $data['users']) : NULL;
  $children = is_array($data['children']) ? implode(',', $data['children']) : NULL;

  // Prepare data for database insert
  $insert_data = array(
      'room_id' => $data['room'],
      'months' => $data['months'],
      'centerid' => $data['centerid'] ?? NULL,
      'created_by' => $data['user_id'] ?? NULL,
      'educators' => $educators,
      'children' => $children,
      'practical_life' => $data['practical_life'] ?? NULL,
      'focus_area' => $data['focus_area'] ?? NULL,
      'practical_life_experiences' => $data['practical_life_experiences'] ?? NULL,
      'sensorial' => $data['sensorial'] ?? NULL,
      'sensorial_experiences' => $data['sensorial_experiences'] ?? NULL,
      'math' => $data['math'] ?? NULL,
      'math_experiences' => $data['math_experiences'] ?? NULL,
      'language' => $data['language'] ?? NULL,
      'language_experiences' => $data['language_experiences'] ?? NULL,
      'culture' => $data['culture'] ?? NULL,
      'culture_experiences' => $data['culture_experiences'] ?? NULL,
      'art_craft' => $data['art_craft'] ?? NULL,
      'art_craft_experiences' => $data['art_craft_experiences'] ?? NULL,
      'eylf' => $data['eylf'] ?? NULL,
      'outdoor_experiences' => $data['outdoor_experiences'] ?? NULL,
      'inquiry_topic' => $data['inquiry_topic'] ?? NULL,
      'sustainability_topic' => $data['sustainability_topic'] ?? NULL,
      'special_events' => $data['special_events'] ?? NULL,
      'children_voices' => $data['children_voices'] ?? NULL,
      'families_input' => $data['families_input'] ?? NULL,
      'group_experience' => $data['group_experience'] ?? NULL,
      'spontaneous_experience' => $data['spontaneous_experience'] ?? NULL,
      'mindfulness_experiences' => $data['mindfulness_experiences'] ?? NULL,
      'created_at' => date('Y-m-d H:i:s', strtotime('now Australia/Sydney'))
  );

  // Insert data into the database
  $result = $this->db->insert('programplantemplatedetailsadd', $insert_data);

  if ($result) {
      $plan_id = $this->db->insert_id();

      $response = array(
          'success' => true,
          'redirect_url' => base_url('LessonPlanList/programplanprintpage/' . $plan_id)
      );
  } else {
      $response = array(
          'status' => 'error',
          'message' => 'Database error occurred. Please try again.'
      );
  }

  // Return JSON response
  echo json_encode($response);
}


public function programplanprintpage($id) {
  if (!$this->session->has_userdata('LoginId')) {
      // Redirect to login if not logged in
      $this->load->view('welcome');
      return;
  }

  // Fetch program plan by ID
  $plan = $this->db->get_where('programplantemplatedetailsadd', ['id' => $id])->row_array();

  if (!$plan) {
      show_404(); // Show error if plan not found
      return;
  }

  $month_name = strtoupper(date('F', mktime(0, 0, 0, $plan['months'], 1)));



  // Get room name
  $room = $this->db->get_where('room', ['id' => $plan['room_id']])->row_array();
  $room_name = $room ? $room['name'] : 'Unknown Room';

  // Get educator names
  $educator_ids = explode(',', $plan['educators']);
  if (!empty($educator_ids)) {
      $this->db->select('name');
      $this->db->from('users');
      $this->db->where_in('userid', $educator_ids);
      $educators = $this->db->get()->result_array();
      $educator_names = implode(',', array_column($educators, 'name'));
  } else {
      $educator_names = 'No Educators';
  }

  // Get child names
  $child_ids = explode(',', $plan['children']);
  if (!empty($child_ids)) {
      $this->db->select('name');
      $this->db->from('child');
      $this->db->where_in('id', $child_ids);
      $children = $this->db->get()->result_array();
      $children_names = implode(',', array_column($children, 'name'));
  } else {
      $children_names = 'No Children';
  }

  // Pass data to the view
  $data = [
      'plan' => $plan,
      'room_name' => $room_name,
      'educator_names' => $educator_names,
      'children_names' => $children_names,
      'month_name' => $month_name
  ];

  // echo "<pre>";
  // print_r($data);
  // exit;

  $this->load->view('programplanprintpage', $data);
}


  

    public function deleteTemplate($template_id) {
      if ($this->session->has_userdata('LoginId')) {
          // Prepare the payload
          $payload = [
              'template_id' => $template_id,
              'userid' => $this->session->userdata('LoginId') // Include userid in the payload
          ];
  
          $url = BASE_API_URL . 'Programplanlist/deletetemplates';
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload)); // Send the correct payload
          curl_setopt($ch, CURLOPT_HTTPHEADER, [
              'X-Device-Id: ' . $this->session->userdata('X-Device-Id'),
              'X-Token: ' . $this->session->userdata('AuthToken'),
              'Content-Type: application/json' // Specify JSON content type
          ]);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $server_output = curl_exec($ch);
          $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);
  
          if ($httpcode == 200) { 
              $jsonOutput = json_decode($server_output, true); // Decode the JSON response
              if ($jsonOutput['success']) {
                  // Success: Show a success message or redirect
                  header('Content-Type: application/json'); // Set JSON header
                  echo json_encode(['success' => true, 'message' => 'Template deleted successfully.']);
              } else {
                  // Failure: Show an error message
                  echo json_encode(['success' => false, 'message' => 'Failed to delete template.']);
              }
          } else {
              // Handle other HTTP status codes (e.g., 401 Unauthorized)
              echo json_encode(['success' => false, 'message' => 'Unauthorized or server error.']);
          }
      } else {
          // Redirect to login if the user is not logged in
          $this->load->view('welcome');
      }
  }

    public function view($id = NULL)
    { 
      if($this->session->has_userdata('LoginId')){
        $json=$user=[];
        $data['get_details'] = get_details();
        $json['usertype']=$this->session->userdata('UserType');
        $json['userid']=$this->session->userdata('LoginId');
        $json['programid']=$id;
              
        $url = BASE_API_URL.'Programplanlist/fetchProgPlanDetails';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
          'X-Token: '.$this->session->userdata('AuthToken')
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        if($httpcode == 200){
          $jsonOutput = json_decode($server_output);
          $comments = json_decode($this->ProgPlanComments($id));
        //print_r($comments);  exit;
          $jsonOutput->Comments = $comments->Comments;
          $jsonOutput->program_id = $id;
          $this->load->view('viewProgramPlan_v3',$jsonOutput);
        }else{
          redirect('Welcome');
        }
      }else{ 
        $this->load->view('welcome');
      }
    }

    public function ProgPlanComments($id='',$ret = 1)
    {
      if($this->session->has_userdata('LoginId')){
        $json['progplanid'] = $id;
        $json['userid'] = $this->session->userdata("LoginId");
        $url = BASE_API_URL.'Programplanlist/getProgPlanComments';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
          'X-Token: '.$this->session->userdata('AuthToken')
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        //print_r($server_output); exit;
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode==200){
          if ($ret == 1) {
            return $server_output;
          } else {
            echo $server_output;
          }
        }else{
          $data['Status'] = "Error";
          $data['Comments'] = NULL;
          $data['Message'] = "Something Went Wrong!";
          if ($ret == 1) {
            return json_encode($data);
          } else {
            echo json_encode($data);
          }
        }
      }else{
        $data['Status'] = "Error";
        $data['Comments'] = NULL;
        $data['Message'] = "Please relogin to continue!";
        if ($ret == 1) {
          return json_encode($data);
        } else {
          echo json_encode($data);
        }
      }
    }

    public function edit($id = NULL)
    {
      if($this->session->has_userdata('LoginId')){
        $json['programid'] = $id;      
        $json['userid'] = $this->session->userdata("LoginId");
        $url = BASE_API_URL.'Programplanlist/fetchProgPlanDetails';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
          'X-Token: '.$this->session->userdata('AuthToken')
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode == 200){
          $data = [];
          $data = json_decode($server_output);
          // echo "<pre>";
          // print_r($data);
          // exit;
          $this->load->view('editProgramPlan_v3', $data);
        }else{
          redirect('Welcome');
        }

      }else{ 
        redirect('Welcome');
      }
    }





    public function templateload($template_id = null) {
      if ($template_id) {
          // Fetch headers
          $headers = $this->db->where('template_id', $template_id)
                              ->order_by('priority_order', 'ASC')
                              ->get('template_programplanlist_header')
                              ->result();
  
          $programPlan = new stdClass();
          $programPlan->headings = [];
  
          foreach ($headers as $header) {
              // Fetch contents for each header
              $contents = $this->db->where('template_id', $template_id)
                                   ->where('headingid', $header->id)
                                   ->get('template_programplanlist_content')
                                   ->result();
  
              $headingObj = new stdClass();
              $headingObj->id = $header->id;
              $headingObj->headingname = $header->headingname;
              $headingObj->headingcolor = $header->headingcolor;
              $headingObj->priority_order = $header->priority_order;
              $headingObj->programplanparentid = $template_id;
              $headingObj->contents = $contents;
  
              $programPlan->headings[] = $headingObj;
          }
  
          // Fetch Users (Staff)
          $users = $this->db->select('userid as id, name, imageUrl')
                            ->where('userType', 'Staff')
                            ->get('users')
                            ->result();
          
          // $users['id'] = $users['userid'];
  
          // Fetch Rooms for specific center
          $centerid = 1;
          $rooms = $this->db->where('centerid', $centerid)
                            ->get('room')
                            ->result();
  
          $data = [
              'ProgramPlan' => $programPlan,
              'Users' => $users,
              'Rooms' => $rooms,
              'centerid' => $centerid
          ];
          // echo "<pre>";
          // print_r($data);
          // exit;
          $this->load->view('editProgramPlan_v3', $data);
      } else {
          // Handle case when no template is selected
          redirect('Welcome');
      }
  }


    public function getTemplates() {
      // Fetch unique templates from header table
      $templates = $this->db->select('template_id, template_name')
                            ->from('template_programplanlist_header')
                            ->group_by('template_id, template_name') // Use group_by instead
                            ->get()
                            ->result();
      
      echo json_encode($templates);
  }





    public function addNew()
    {
      
      if($this->session->has_userdata('LoginId')){

        if (isset($_GET['centerid'])) {
          $centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
        }else{
          $center = $this->session->userdata("centerIds");
          $centerid = $center[0]->id;
        }

        $data = [];
        $data['centerid'] = $centerid;
        $data['userid'] = $this->session->userdata('LoginId');
      
        $url = BASE_API_URL.'Programplanlist/getProgramPlanData';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
          'X-Token: '.$this->session->userdata('AuthToken')
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
          if($httpcode == 200){
            $jsonOutput = json_decode($server_output);
            $jsonOutput->centerid = $centerid;
            $this->load->view('editProgramPlan_v3',$jsonOutput);
          }else{
            redirect('Welcome');
          }

      }else{ 
        redirect('Welcome');
      }
    }

    public function save()
    {
    
      if($this->session->has_userdata('LoginId')){

        $formdata = $this->input->post();
        $keys = array_keys($formdata);
        $matches = preg_grep("/^content_/",$keys);
        $end = end($matches);
        $count = substr($end, -1);
        
        $json = [];
        $jsonInput = [];

        for ($i=0; $i < count($formdata['heading_color']); $i++) { 
          $json['heading_color'] = $formdata['heading_color'][$i];
          $json['heading_title'] = $formdata['heading_title'][$i];
          $integer = 1;
          for ($j=1; $j <= $count; $j++) { 
            if (isset($formdata['content_'.$j])) {
              $countElem = count($formdata['content_'.$j]);
              if( $countElem != 0 ){
                if($integer == 1){
                  $json['contents'] = $formdata['content_'.$j];
                  unset($formdata['content_'.$j]);
                  $integer++;
                }
              }
            }
          }
          array_push($jsonInput, $json);
        }
        
        if (isset($_POST['centerid'])) {
          $centerid = strip_tags(trim(stripslashes($_POST['centerid'])));
        }else{
          $center = $this->session->userdata("centerIds");
          $centerid = $center[0]->id;
        }

        $formdata['headings'] = $jsonInput;
        $formdata['centerid'] = $centerid;
        $formdata['userid'] = $this->session->userdata('LoginId');

        unset($formdata['heading_color']);
        unset($formdata['heading_title']);
        // echo "<pre>";
        // print_r($formdata);
        // exit;

        $url = BASE_API_URL.'Programplanlist/save';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($formdata));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
          'X-Token: '.$this->session->userdata('AuthToken')
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if($httpcode == 200){
          $url = base_url('LessonPlanList/programPlanList').'?centerid='.$centerid;
          redirect($url);
        }else{
          redirect('Welcome');
        }
      }
      else{ 
        redirect('Welcome');
      }
    }



    public function saveTemplate(){
      if($this->session->has_userdata('LoginId')){
        $formdata = $this->input->post();
       
        $keys = array_keys($formdata);
        $matches = preg_grep("/^content_/",$keys);
        $end = end($matches);
        $count = substr($end, -1);
        
        $json = [];
        $jsonInput = [];

        for ($i=0; $i < count($formdata['heading_color']); $i++) { 
          $json['heading_color'] = $formdata['heading_color'][$i];
          $json['heading_title'] = $formdata['heading_title'][$i];
          $integer = 1;
          for ($j=1; $j <= $count; $j++) { 
            if (isset($formdata['content_'.$j])) {
              $countElem = count($formdata['content_'.$j]);
              if( $countElem != 0 ){
                if($integer == 1){
                  $json['contents'] = $formdata['content_'.$j];
                  unset($formdata['content_'.$j]);
                  $integer++;
                }
              }
            }
          }
          array_push($jsonInput, $json);
        }
      
        $formdata['headings'] = $jsonInput;
        $formdata['userid'] = $this->session->userdata('LoginId');
      
        if (isset($_GET['centerid'])) {
          $centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
        }else{
          $center = $this->session->userdata("centerIds");
          $centerid = $center[0]->id;
        }

        $formdata['centerid'] = $centerid;
        unset($formdata['heading_color']);
        unset($formdata['heading_title']);
        // echo "<pre>";
        // print_r($formdata);
        // exit;


        $url = BASE_API_URL.'Programplanlist/templatesave';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($formdata));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
          'X-Token: '.$this->session->userdata('AuthToken')
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if($httpcode == 200){
          $this->session->set_flashdata('success', 'Template Stored Successfully!');

          $url = base_url('LessonPlanList/viewnewtemplate').'?centerid='.$centerid;
          redirect($url);
        }else{
          redirect('Welcome');
        }

      }else{ 
          redirect('Welcome');
        }

    }



    public function saveLinks()
    {
      if($this->session->has_userdata('LoginId')){
        $formdata = $this->input->post();       
        $formdata['userid'] = $this->session->userdata('LoginId');
        $url = BASE_API_URL.'Programplanlist/saveLinks';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($formdata));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
          'X-Token: '.$this->session->userdata('AuthToken')
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        echo $server_output;
      }else{ 
        redirect('Welcome');
      }
    }
}