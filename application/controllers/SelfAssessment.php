<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class SelfAssessment extends CI_Controller {  
      
    public function index()  
    {
  	  if($this->session->has_userdata('LoginId')){
        if (isset($_GET['centerid'])) {
          $data['centerid'] = $_GET['centerid'];
        }else{
          $center = $this->session->userdata("centerIds");
          if (empty($center)) {
            $data['centerid'] = 0;
          }else{
            $data['centerid'] = $center[0]->id;
          }
        }

        $data['userid'] = $this->session->userdata('LoginId');
        
        $url = BASE_API_URL.'SelfAssessment/getAllSelfAssessments/';
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
        curl_close ($ch);
        $jsonOutput = json_decode($server_output);
        $jsonOutput->centerid = $data['centerid'];
        $this->load->view('selfAssessment_list',$jsonOutput);
  		}else{ 
  			redirect('Welcome');
  		}
    }

    public function edit()
    {
      if($this->session->has_userdata('LoginId')){
        $data = $this->input->get();

        //get center for retrieving records
        if (isset($_GET['centerid'])) {
          $data['centerid'] = $this->input->get('centerid');
        }else{
          $center = $this->session->userdata("centerIds");
          if (empty($center)) {
            $data['centerid'] = 0;
          }else{
            $data['centerid'] = $center[0]->id;
          }
        }

        //get areaid to retrieving records
        if (isset($_GET['areaid'])) {
          $data['areaid'] = $this->input->get('areaid');
        }else{
          $data['areaid'] = NULL;
        }

        $data['userid'] = $this->session->userdata('LoginId');
        $url = BASE_API_URL.'SelfAssessment/editSelfAssessment/';
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
        curl_close ($ch);
        $jsonOutput = json_decode($server_output);
        $jsonOutput->centerid = $jsonOutput->Details->centerid;
        if($httpcode == 200){
          $this->load->view('editSelfAssessment',$jsonOutput);
        }else{
          echo $jsonOutput->Message;
        }
      }else{ 
        redirect('Welcome');
      }
    }

    public function delete()
    {
      if($this->session->has_userdata('LoginId')){
        $data = $this->input->get();
        $data['userid'] = $this->session->userdata('LoginId');
        $url = BASE_API_URL.'SelfAssessment/deleteSelfAssessment/';
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
        if($httpcode==200){
          $jsonOutput = json_decode($server_output);
          $usrl = base_url('SelfAssessment').'?centerid='.$jsonOutput->Centerid.'&slfasmnt='.$jsonOutput->Name.'&status=success';
          redirect($usrl);
        }else{
          redirect('SelfAssessment');
        }
        
      }else{ 
        redirect('Welcome');
      }
    }

    public function addNewSelfAssessment()
    {
     
      if($this->session->has_userdata('LoginId')){

        if (isset($_GET['centerid'])) {
          $data['centerid'] = $_GET['centerid'];
          
        }else{
          redirect("SelfAssessment");
        }

        $data['userid'] = $this->session->userdata('LoginId');
        $url = BASE_API_URL.'SelfAssessment/addNewSelfAssessment/';
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
       // print_r($server_output); exit;
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        $jsonOutput = json_decode($server_output);
        //print_r($jsonOutput); exit;
        if($httpcode == 200){
          if ($jsonOutput->Status == "SUCCESS") {
            $url = base_url('SelfAssessment').'?centerid='.$data['centerid'];
            redirect($url);
          }else{
            echo $jsonOutput->Message;
          }
        }else{
          echo $jsonOutput->Message;
        }     
      }else{
        redirect("Welcome");
      }
    }

    public function saveProgressNotes()
    {
      if($this->session->has_userdata('LoginId')){
        $data = $this->input->post();
        $data['userid'] = $this->session->userdata('LoginId');
        $url = BASE_API_URL.'Qip/saveProgressNotes/';
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
        curl_close ($ch);
        echo $server_output;
      }else{
        redirect('welcome');
      } 
    }

    public function saveSelfAssessment()
    {
      if($this->session->has_userdata('LoginId')){
        $formdata = $this->input->post();
        $legalMatches = preg_grep("/^nl_status_/",array_keys($formdata));
        $legalArr = [];
        $tempArr = [];
        foreach ($legalMatches as $key => $value) {
          $substr = substr($value, 10);
          $statusVar = 'nl_status_'.$substr;
          $noticeVar = 'nl_ncnotice_'.$substr;
          $tempArr['id'] = $substr;
          $tempArr['status'] = $formdata[$statusVar];
          $tempArr['notice'] = $formdata[$noticeVar];
          array_push($legalArr, $tempArr);
        }
        $qualityMatches = preg_grep("/^idtf_prac_/",array_keys($formdata));
        $qualityArr = [];
        $tempArr = [];
        foreach ($qualityMatches as $key => $value) {
          $substr = substr($value, 10);
          $noticeVar = 'idtf_prac_'.$substr;
          $statusVar = 'qa_status_'.$substr;
          $tempArr['id'] = $substr;
          $tempArr['status'] = isset($formdata[$statusVar])?$formdata[$statusVar]:"";
          $tempArr['ip'] = $formdata[$noticeVar];
          array_push($qualityArr, $tempArr);
        }
        $data = [];
        $data['asmnt_id'] = $formdata['asmnt_id'];
        $data['legalities'] = $legalArr;
        $data['qualities'] = $qualityArr;
        $data['userid'] = $this->session->userdata('LoginId');
        $url = BASE_API_URL.'SelfAssessment/saveSelfAssessment/';
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
        curl_close ($ch);
        if ($httpcode == "200") {
          $url = base_url("SelfAssessment/edit")."?id=".$formdata['asmnt_id']."&status=success";
        }else{
          $url = base_url("SelfAssessment/edit")."?id=".$formdata['asmnt_id']."&status=error";
        }
        redirect($url);
      }else{
        redirect('welcome');
      }
    }

    public function getSelfAsmntStaffs()
    {
      if($this->session->has_userdata('LoginId')){
        $data = $this->input->get();
        $data['userid'] = $this->session->userdata('LoginId');
        $url = BASE_API_URL.'SelfAssessment/getSelfAsmntStaffs/';
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
        echo $server_output;
      }else{
        $data['Status'] = "ERROR";
        $data['Message'] = "Not a valid account! Try relogin instead.";
        echo json_encode($data);
      }
    }

    public function addSelfAssessmentStaffs()
    {
      if($this->session->has_userdata('LoginId')){
        $data = $this->input->post();
        $data['userid'] = $this->session->userdata('LoginId');
        $url = BASE_API_URL.'SelfAssessment/addSelfAssessmentStaffs';
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
          echo $server_output;
      }else{
        $data['Status'] = "ERROR";
        $data['Message'] = "Not a valid account! Try relogin instead.";
        echo json_encode($data);
      }
    }
}