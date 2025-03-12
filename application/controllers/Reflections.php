<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Reflections extends CI_Controller {

    public function index()  
    {
		if($this->session->has_userdata('LoginId')){
            redirect('Reflections/getUserReflections');
		}else{
			$this->load->view('welcome');
		}
    }

	public function getUsersPermissions($centerid=NULL,$print=NULL)
	{
		if ($this->session->has_userdata("LoginId")) {
			$data =  $this->input->post();
			$data['centerid'] = $centerid;
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/getUsersPermissions';
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
			$jsondata = json_decode($server_output);
			
			$permissions = $jsondata->permissions;
			
			if($print==NULL){
				return $permissions;
			}else{
				print_r($permissions);
			}
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Session timeout! Please relogin.";
			echo json_encode($data);
		}
	}

    public function getUserReflections()
	{	
		if($this->session->has_userdata('LoginId')){

			if(empty($_GET['centerid'])){
				$centers = $this->session->userdata("centerIds");
				$defCenter = $centers[0]->id;
			}else{
				$data = $this->input->get();
				$defCenter = $data['centerid'];
			}
	
			$data['userid'] = $this->session->userdata('LoginId');
			$data['userType'] = $this->session->userdata("UserType");
			$data['centerid'] = $defCenter;
		    $url = BASE_API_URL."Reflections/getUserReflections/".$this->session->userdata('LoginId')."/". $defCenter;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);			
			curl_close($ch);
			if($httpcode == 200){
				$data = [];
				$jsondata = json_decode($server_output);
				// echo "<pre>";
				// print_r($jsondata->permission);
				// die;
				$data['reflection'] = $jsondata->Reflections;
				// $data['permission'] = $this->getUsersPermissions($defCenter);
				$data['permission'] = $jsondata->permission;
				$this->load->view('Reflection_v4',$data);
				// $this->load->view('Reflection_form-newui',$data);				
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
	   }else{
		redirect('welcome');
	   }
	}

	public function createReflection()
	{	
		if($this->session->has_userdata('LoginId')){
			
			if(empty($_GET['centerid'])){
				$centers = $this->session->userdata("centerIds");
				$defCenter = $centers[0]->id;
			}else{
				$data = $this->input->get();
				$defCenter = $data['centerid'];
			}
			$data['userid'] = $this->session->userdata('LoginId');
			$data['userType'] = $this->session->userdata("UserType");
			$data['centerid'] = $defCenter;
			
		    $url = BASE_API_URL."Reflections/getReflectionDetails?centerid=".$defCenter;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			//print_r($server_output); exit;
			if($httpcode == 200){
				$data = [];
				$jsondata = json_decode($server_output);
				$data['child'] = $jsondata->Childs;
				$data['Educator'] = $jsondata->Educators;
				$data['centerid'] = $defCenter;
                $childArr = $this->getChildRecords($defCenter,NULL);
				// $data['Childrens'] = $childArr->Childrens;
				$data['Childrens'] = $childArr->Childrens;
				$data['Groups'] = $childArr->Groups;
				$data['Rooms'] = $childArr->Rooms;
				// $this->load->view('createReflection-newui',$data);				
				$this->load->view('createReflection_v4',$data);				
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
	   }else{
		redirect('welcome');
	   }
	}

	public function addreflection()
	{
		if ($this->session->has_userdata('LoginId')) {
			$this->load->helper('form');
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$data['createdAt'] = date('Y-m-d H:i:s');
			$data['createdBy'] = $data['userid'];
			$data['childs'] = json_encode($data['childId']);
            unset($data['childId']);
			$data['educators'] = json_encode($data['Educator']);
			unset($data['Educator']);
			if(!empty($_FILES['media'])){
				$filesCount = count($_FILES['media']['name']);
				for ($i=0; $i < $filesCount; $i++) {
					$data['media'.$i]= new CurlFile($_FILES['media']['tmp_name'][$i],$_FILES['media']['type'][$i],$_FILES['media']['name'][$i]);
				}
			}
			// $data['description'] = trim(stripslashes(htmlspecialchars($data['description'])));
			$url = BASE_API_URL."Reflections/createReflection/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken'),
				'Content-Type: multipart/form-data'
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				$data = json_decode($server_output);
				redirect("Reflections");
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		} else {
			redirect("welcome");
		}
	}

	public function deleteReflection()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."Reflections/deleteReflection/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			echo $server_output;
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Login error";
			echo json_encode($data);
		}
	}

	public function Reflection_update()
	{
		if($this->session->has_userdata('LoginId')){
			if(empty($_GET['centerId'])){
				$centers = $this->session->userdata("centerIds");
				$defCenter = $centers[0]->id;
			}else{
				$data = $this->input->get();
				$defCenter = $data['centerId'];
			}
			$data['userid'] = $this->session->userdata('LoginId');
			$data['userType'] = $this->session->userdata("UserType");
			$data['centerid'] = $defCenter;
			$data['reflectionid'] = isset($_GET['reflectionid'])?$_GET['reflectionid']:null;
			$url = BASE_API_URL."Reflections/getReflection/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if($httpcode == 200){
				$data = [];
				$data = json_decode($server_output);
                $childArr = $this->getChildRecords($defCenter,$_GET['reflectionid']);
				$data->child = $childArr->Childrens;
				$data->Groups = $childArr->Groups;
				$data->Rooms = $childArr->Rooms;			
				$this->load->view('reflectionUpdate_v4.php',$data);			
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
	   }else{
		redirect('welcome');
	   }
	}

	public function updateReflection()
	{
		if($this->session->has_userdata('LoginId')){
			$this->load->helper('form');
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$data['reflectionid'] = $_GET['reflectionId'];
            
			$data['childs'] = json_encode($data['childId']);
            unset($data['childId']);
			$data['educators'] = json_encode($data['Educator']);
			unset($data['Educator']);
			if(!empty($_FILES['media'])){
				$filesCount = count($_FILES['media']['name']);
				for ($i=0; $i < $filesCount; $i++) {
					if(!empty($_FILES['media']['tmp_name'][$i])){
						$data['media'.$i]= new CurlFile($_FILES['media']['tmp_name'][$i],$_FILES['media']['type'][$i],$_FILES['media']['name'][$i]);
					}
				}
			}
			$url = BASE_API_URL."Reflections/updateReflection/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);

			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				curl_close ($ch);
				$rurl = base_url()."Reflections/getUserReflections";
				redirect($rurl);
			}
			if($httpcode == 200){
				redirect("welcome");
			}
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Login error";
			echo json_encode($data);
		}
	}

    public function getChildRecords($centerid='',$refid='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['centerid'] = $centerid;
			$data['refid'] = $refid;
	   		$url = BASE_API_URL."Reflections/getChildRecords/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				return $jsonOutput;	
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}
}  