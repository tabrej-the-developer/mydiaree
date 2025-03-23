<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Reflections extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->database(); 
	  }

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

			// echo "<pre>";
			// print_r($server_output);
			// exit;
			if($httpcode == 200){
				$data = [];
				$jsondata = json_decode($server_output);
			
				
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
				$data['eylf_outcomes'] = $outcomes_with_activities;

				// $this->load->view('createReflection-newui',$data);	
				// echo "<pre>";
				// print_r($data);
				// exit;			
				$this->load->view('createReflection_v4',$data);				
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
	   }else{
		redirect('welcome');
	   }
	}

	public function print($reflectionId) {
		// Check if user is logged in
		if (!$this->session->has_userdata('LoginId')) {
			redirect('login');
		}
		
		// Get reflection data
		$data['reflection'] = $this->db->where('id', $reflectionId)
								   ->get('reflection')
								   ->row_array();
		
		// Get reflection child data
		$data['reflectionChildren'] = $this->db->where('reflectionid', $reflectionId)
										  ->get('reflectionchild')
										  ->result_array();
		
		// Get all child data associated with this reflection
		$childIds = array();
		foreach ($data['reflectionChildren'] as $refChild) {
			$childIds[] = $refChild['childid'];
		}
		
		if (!empty($childIds)) {
			$data['children'] = $this->db->where_in('id', $childIds)
									->get('child')
									->result_array();

									  // Create comma-separated string of children names
        $childrenNames = array();
        foreach ($data['children'] as $child) {
            $childrenNames[] = $child['name'] . ' ' . $child['lastname'];
        }
        $data['childrenNamesString'] = implode(', ', $childrenNames);
		} else {
			$data['children'] = array();
		}

		
		
		// Get reflection media data
		$data['reflectionMedia'] = $this->db->where('reflectionid', $reflectionId)
									   ->get('reflectionmedia')
									   ->result_array();
		
		// Get reflection staff data
		$data['reflectionStaff'] = $this->db->where('reflectionid', $reflectionId)
									   ->get('reflectionstaff')
									   ->result_array();
		
		// Get all staff user data
		$staffIds = array();
		foreach ($data['reflectionStaff'] as $refStaff) {
			$staffIds[] = $refStaff['staffid'];
		}
		
		if (!empty($staffIds)) {
			$data['staffUsers'] = $this->db->where_in('userid', $staffIds)
									  ->get('users')
									  ->result_array();

									   // Create comma-separated string of staff names
        $staffNames = array();
        foreach ($data['staffUsers'] as $staff) {
            $staffNames[] = $staff['name'];
        }
        $data['staffNamesString'] = implode(', ', $staffNames);

		} else {
			$data['staffUsers'] = array();
		}
		
		// Load the view with all the data
		// echo "<pre>";
		// print_r($data);
		// exit;
		$this->load->view('print_reflections_template', $data);
	}

	public function addreflection()
	{
		if ($this->session->has_userdata('LoginId')) {
			$this->load->helper('form');
			$data = $this->input->post();
			// echo "<pre>";
			// print_r($data['eylf']);
			// exit;
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
		  $data->eylf_outcomes = $outcomes_with_activities;

		//   echo "<pre>";
		//   print_r($data);
		//   exit;

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