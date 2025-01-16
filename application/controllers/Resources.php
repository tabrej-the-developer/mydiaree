<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Resources extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{ 
		
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->get();

			$data['userid'] = $this->session->userdata('LoginId');

			if (isset($data['fromdate']) && !empty($data['fromdate'])) {
				$data['fromdate'] = date("Y-m-d",strtotime(str_replace("/","-",$data['fromdate'])));
			}

			if (isset($data['todate']) && !empty($data['todate'])) {
				$data['todate'] = date("Y-m-d",strtotime(str_replace("/","-",$data['todate'])));
			}
			
			$data['page'] = isset($data['page'])?$data['page']:1;

			$url = BASE_API_URL."/Resources/getPublishedResources/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close($ch);
				$data = json_decode($server_output);
				$data->users = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($data->users));
				$data->tags = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($data->tags));
				$this->load->view('resourcesList_v3', $data);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{ 
			redirect('welcome');
		}
	}

	public function add()
	{
		if ($this->session->has_userdata('LoginId')) {
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."resources/getResouceStuff/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			if($httpcode == 200){
				$jsonOutput = json_decode($server_output);
				$staffs = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($jsonOutput->users));
				$jsonOutput->users = $staffs;
				$tags = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($jsonOutput->tags));
				$jsonOutput->tags = $tags;
				$this->load->view('createResourcesForm',$jsonOutput);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		} else {
			redirect("welcome");
		}
		;
	}

	public function addResource()
	{
		if ($this->session->has_userdata('LoginId')) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$data['createdAt'] = date('Y-m-d H:i:s');
			$data['createdBy'] = $data['userid'];
			$filesCount = count($_FILES['resMedia']['name']);
			for ($i=0; $i < $filesCount; $i++) {
				$data['resMedia'.$i]= new CurlFile($_FILES['resMedia']['tmp_name'][$i],$_FILES['resMedia']['type'][$i],$_FILES['resMedia']['name'][$i]);
			}
			$data['description'] = trim(stripslashes(htmlspecialchars($data['description'])));
			$url = BASE_API_URL."resources/addResources/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken'),
				'Content-Type: multipart/form-data'
			));
			@curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				$data = json_decode($server_output);
				redirect("Resources");
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		} else {
			redirect("welcome");
		}
	}

	public function addLike()
	{
		if ($this->session->has_userdata('LoginId')) {
			$data = $this->input->post();
			
			$url = BASE_API_URL."resources/addLike/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			echo $server_output;
		} else {
			redirect("welcome");
		}
	}

	public function removeLike()
	{
		if ($this->session->has_userdata('LoginId')) {
			$data = $this->input->post();
			$url = BASE_API_URL."resources/removeLike/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			echo $server_output;
		} else {
			redirect("welcome");
		}
	}

	public function deleteResource($resId)
	{
		if ($this->session->has_userdata('LoginId')) {
			$data['userid'] = $this->session->userdata("LoginId");
			$data['resourceId'] = $resId;
			$url = BASE_API_URL."resources/deleteResource/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			echo $server_output;
		} else {
			redirect("welcome");
		}
	}

	public function addComment()
	{
		if ($this->session->has_userdata('LoginId')) {
			$data = $this->input->post();
			$url = BASE_API_URL."resources/addComment/";
			$data['userid'] = $this->session->userdata('LoginId');
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				echo $server_output;
			}
			if($httpcode == 401){
				$data['Status'] = "ERROR";
				$data['Message'] = "Something went wrong!";
				echo json_encode($data);
			}
		} else {
			$data['Status'] = "ERROR";
			$data['Message'] = "Something went wrong!";
			echo json_encode($data);
		}
	}

	public function viewResource()
	{
		//error_reporting(0);
		if ($this->session->has_userdata('LoginId')) {
			if (empty($_GET['resId'])) {
				redirect("Resources");
			}else{
				$data['resourceid'] = $_GET['resId'];
				$data['userid'] = $this->session->userdata("LoginId");
			}
			
			$url = BASE_API_URL."resources/getResource/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				$jsonData = json_decode($server_output);
				$this->load->view("viewResource_v3",$jsonData);
				// $this->load->view("viewResource",$jsonData);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect("welcome");
		}
	}
	
	public function addShare()
	{
		if ($this->session->has_userdata('LoginId')) {
			$data = $this->input->post();
			$url = BASE_API_URL."resources/addShare/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				echo $server_output;
			}else if($httpcode == 401){
				redirect("welcome");
			}
		}else{
			redirect("welcome");
		}
	}

	public function getAuthorsFromCenter()
	{
		if ($this->session->has_userdata('LoginId')) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL."Resources/getAuthorsFromCenter/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			echo $server_output;
		} else {
			redirect("welcome");
		}
	}

	public function loadAjaxResources()
	{
		if ($this->session->has_userdata('LoginId')) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL."Resources/loadAjaxResources/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			echo $server_output;
		} else {
			redirect("welcome");
		}
	}
}

/* End of file Resources.php */
/* Location: ./application/controllers/Resources.php */