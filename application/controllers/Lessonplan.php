<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
//error_reporting(-1);
//ini_set('display_errors', 0); 

class Lessonplan extends CI_Controller {  

  public function __construct(){
    parent::__construct();
	$this->load->helper('get_details');
  }
  

    // public function index()  
    // {
	  //   if($this->session->has_userdata('LoginId')){
    //       $url = BASE_API_URL.'Lessonplan/getlessondetails';
    //       $ch = curl_init($url);
    //       curl_setopt($ch, CURLOPT_URL,$url);
    //       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //                 'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
    //                 'X-Token: '.$this->session->userdata('AuthToken')
    //         ));
    //       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //       $server_output = curl_exec($ch);
    //       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     // print_r($server_output); exit;
    //       if($httpcode == 200){
    //               $jsonOutput = json_decode($server_output);
    //               curl_close ($ch);
    //         }
    //         else if($httpcode == 401){
    //           return 'error';
    //         }
            
    //         $data['new_process'] =$jsonOutput->new_process;
    //         $data['child_count']=$jsonOutput->child_count;
    //         $this->load->view('lessonplan',$data);
		//   }
    //   else{ 
		// 	  $this->load->view('welcome');
		//   }

    // }

    public function index()  
{
  
    if($this->session->has_userdata('LoginId')) {

      $data['usertype']=$this->session->userdata('UserType');
      $data['userid']=$this->session->userdata('LoginId');
      $data['created_by']=$this->session->userdata('Name');
      $centerIds=$this->session->userdata('centerIds');

      if($data['usertype']=='Superadmin'){
        $data['centerid']='0';
      }else{
       // echo "parent"; exit;
        $data['centerid']=$centerIds[0]->id;
      } 

        $url = BASE_API_URL.'Lessonplan/getlessondetails';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
			  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Device-Id: ' . $this->session->userdata('X-Device-Id'),
            'X-Token: ' . $this->session->userdata('AuthToken')
            
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //print_r($server_output); exit;
        if ($httpcode == 200) {
            $jsonOutput = json_decode($server_output);
            curl_close($ch);

            // Ensure child_count and new_process exist
            $data['new_process'] = isset($jsonOutput->new_process) ? $jsonOutput->new_process : [];
            $data['child_count'] = isset($jsonOutput->child_count) ? $jsonOutput->child_count : 0;

            $this->load->view('lessonplan', $data);
        } else if ($httpcode == 401) {
            return 'error';
        }
    } else { 
        $this->load->view('welcome');
    }  
}

  // public function printlessonPDF(){
  //   if($this->session->has_userdata('LoginId')) {

  //       $data['usertype']=$this->session->userdata('UserType');
  //       $data['userid']=$this->session->userdata('LoginId');
  //       $data['created_by']=$this->session->userdata('Name');
  //       $centerIds=$this->session->userdata('centerIds');

  //       if($data['usertype']=='Superadmin'){
  //         $data['centerid']='0';
  //       }else{
  //         $data['centerid']=$centerIds->id;
  //       } 

  //       $url = BASE_API_URL.'Lessonplan/printlessonPDF';
  //       $ch = curl_init($url);
  //       curl_setopt($ch, CURLOPT_URL, $url);
  //       curl_setopt($ch, CURLOPT_POST, 1);
  //       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  //       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  //           'X-Device-Id: ' . $this->session->userdata('X-Device-Id'),
  //           'X-Token: ' . $this->session->userdata('AuthToken')
            
  //       ));
  //       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //       $server_output = curl_exec($ch);
  //       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  //       if ($httpcode == 200) {
  //           $jsonOutput = json_decode($server_output);
  //           curl_close($ch);

  //           print_r($jsonOutput); exit;

          
  //       } else if ($httpcode == 401) {
  //           return 'error';
  //       }
  //   } else { 
  //       $this->load->view('welcome');
  //   } 
  // }

  public function printlessonPDF(){
    if($this->session->has_userdata('LoginId')) {

        $data['usertype'] = $this->session->userdata('UserType');
        $data['userid'] = $this->session->userdata('LoginId');
        $data['created_by'] = $this->session->userdata('Name');
        $centerIds = $this->session->userdata('centerIds');

        if ($data['usertype'] == 'Superadmin') {
            $data['centerid'] = '0';
        } else {
            $data['centerid'] = $centerIds->id;
        }

        $url = BASE_API_URL.'Lessonplan/printlessonPDF';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X-Device-Id: ' . $this->session->userdata('X-Device-Id'),
            'X-Token: ' . $this->session->userdata('AuthToken')
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpcode == 200) {
            $jsonOutput = json_decode($server_output);
            curl_close($ch);

            if ($jsonOutput->Status == 'Success' && !empty($jsonOutput->path) && !empty($jsonOutput->file)) {
                $pdfUrl = $jsonOutput->path . $jsonOutput->file;

                // Redirect to the PDF URL in a new tab
                echo "<script>window.open('$pdfUrl', '_blank');</script>";
            }
        } else if ($httpcode == 401) {
            return 'error';
        }
    } else { 
        $this->load->view('welcome');
    } 
}



  public function getlessoncenter(){

    if($this->session->has_userdata('LoginId')){
        $url = BASE_API_URL.'Lessonplan/getlessoncenter';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
                  'X-Token: '.$this->session->userdata('AuthToken')
          ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
          $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          
        if($httpcode == 200){
          $jsonOutput = json_decode($server_output);
          $center_source = $jsonOutput->center;
          curl_close ($ch);
          
          $center = array();

            foreach($center_source as $key=>$val){
                  $center[]="<option id='".$val->id."' value='".$val->id."' >".$val->centerName."</option>";
            }
          
          echo json_encode($center);
        }
        else if($httpcode == 401){
          return 'error';
        }
      }
  }

  public function lessondetailschange(){
    //ini_set('display_errors', -1);
    if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST') {

        $_POST['usertype']=$this->session->userdata('UserType');
        $_POST['userid']=$this->session->userdata('LoginId');
        $_POST['created_by']=$this->session->userdata('Name');
				$centerIds=$this->session->userdata('centerIds');
        // print_r($centerIds);
        // exit;
          if($_POST['usertype']=='Superadmin'){
            $_POST['centerid']='0';
          }else{
            $_POST['centerid']=$centerIds[0]->id;
          } 
          
          
          $url = BASE_API_URL.'lessonplan/getlessonstatusdetails';
          
         
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
            print_r($jsonOutput);
            exit;
            $status = $jsonOutput->status;
            curl_close ($ch);
            }

            else if($httpcode == 401){
              return 'error';
            }
            
    
            else{
              //$this->getForm();
            }
       } else{
				redirect('welcome');
			}
    }
    else{
			redirect('welcome');
		}


  }



}

