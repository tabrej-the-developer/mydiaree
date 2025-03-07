<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accident extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->session->has_userdata('LoginId')){

			if(isset($_GET['centerid'])){
				$data['centerid'] = $this->input->get('centerid');
			}else{
				$center = $this->session->userdata("centerIds");
				$data['centerid'] = $center[0]->id;
			}

			if(isset($_GET['roomid'])){
				$data['roomid'] = $this->input->get('roomid');
			}
			$data['userid'] = $this->session->userdata("LoginId");	
            $data['username'] = $this->session->userdata('Name'); 
			$data['UserType'] = $this->session->userdata('UserType');
			$url = BASE_API_URL.'accident/getAccidents';			
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
		
			// echo "<pre>";
			// print_r($server_output);
			// echo "</pre>"; 
			// exit;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$data = json_decode($server_output);
				curl_close ($ch);
				$this->load->view('accidentsList',$data);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("welcome");
		}			
	}

	public function add()
	{
		if($this->session->has_userdata('LoginId')){
			if(isset($_GET['centerid'])){
				$data['centerid'] = $this->input->get('centerid');
			}else{
				$center = $this->session->userdata("centerIds");
				$data['centerid'] = $center[0]->id;
			}
			if(isset($_GET['roomid'])){
				$data['roomid'] = $this->input->get('roomid');
			}else{
				$data['roomid'] = NULL;
			}
			$data['userid'] = $this->session->userdata("LoginId");	
            $data['username'] = $this->session->userdata('Name');  
			$url = BASE_API_URL.'accident/getPageData';			
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
			if($httpcode == 200){
				$data = json_decode($server_output);
				curl_close ($ch);
				$this->load->view('AddAccidentsView',$data);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("welcome");
		}
	}

	public function saveAccident()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");	
            $data['username'] =$this->session->userdata('Name');
            $centerid = $data['centerid'];
            $roomid = $data['roomid'];

			

			$url = BASE_API_URL.'accident/saveAccident';	
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
			if($httpcode == 200){
			// echo "<pre>";
			// print_r(json_encode($server_output));
			// exit;
				$r_url = base_url("Accident")."?status=success&centerid=".$centerid.'&roomid='.$roomid;
				redirect($r_url);
			}else{
			// echo "<pre>";
			// print_r(json_encode($server_output));
			// exit;
				$r_url = base_url("Accident")."?status=error";
				redirect($r_url);
			}
		}else{
			redirect("welcome");
		}
	}

	public function getChildDetails()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'accident/getChildDetails';			
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
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Pls relogin into your account!";
			echo json_encode($data);
		}
	}

	public function getCenterRooms()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'accident/getCenterRooms';			
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
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Pls relogin into your account!";
			echo json_encode($data);
		}
	}

	public function view()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->get();
			if (!isset($data['id']) || empty($data['id'])) {
				redirect('welcome');
			}else{
				$data['accidentid'] = $data['id'];
			}
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'accident/getAccidentDetails';		
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
			$jsonOutput = json_decode($server_output);
			$this->load->view('viewAccident', $jsonOutput);
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Pls relogin into your account!";
			echo json_encode($data);
		}
	}
}

/* End of file Accident.php */
/* Location: ./application/controllers/Accident.php */