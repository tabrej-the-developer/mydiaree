<?php defined('BASEPATH') OR exit('No direct script access allowed');  

class LessonPlanList extends CI_Controller {  

    function __construct() {
      parent::__construct();
      $this->load->helper('get_details');
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

    public function programPlanList()  
    {
      if($this->session->has_userdata('LoginId')){
          $json=[];
          $json['created']=$this->session->userdata('LoginId');
          $json['usertype']=$this->session->userdata('UserType');
          $json['userid']=$this->session->userdata('LoginId');
          if (isset($_GET['centerid'])) {
            $centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
          }else{
            $center = $this->session->userdata("centerIds");
            if (empty($center)) {
              $centerid = 0;
            }else{
              $centerid = $center[0]->id;
            }
          }
          $json['centerid']=$centerid;

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
          curl_close($ch);
          if($httpcode == 200){
            $jsonOutput = json_decode($server_output);
            $data['page_content'] = $jsonOutput->get_program_details;
            $data['centerid'] = $centerid;
            $data['permission'] = $jsonOutput->permission;
            $this->load->view('programPlanList_v3',$data);
          }else{
            redirect("Welcome");
          }
      }else{ 
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
          $this->load->view('editProgramPlan_v3', $data);
        }else{
          redirect('Welcome');
        }

      }else{ 
        redirect('Welcome');
      }
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