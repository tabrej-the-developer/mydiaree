
<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Login extends CI_Controller {  
	
	public function __construct() {
        parent::__construct();
        // Load the model
        $this->load->model('login_model');
    }

    public function index()  
    {
		$data['email']=isset($_GET['user_name'])?$_GET['user_name']:'';

		$utype = $_GET['type'];

		
		if ($utype=="Parent") {
			$data['heading'] = "Parent";
			$data['type'] = "Parent";
		} else if ($utype=="Staff") {
			$data['heading'] = "Staff";
			$data['type'] = "Staff";
		} else if ($utype=="Superadmin"){
			$data['heading'] = "Admin";
			$data['type'] = "Superadmin";
		} else{
			redirect('welcome');
		}
		
        $this->load->view('newLoginForm',$data);  
    }

	public function Userlogin()
	{

		$this->load->helper('form');

		$form_data = $this->input->post();
		$data['errorText'] = "";
		$data['user_name'] = "";
		$data['title'] = 'Login';
		$utype = $form_data['type'];
		

		if ($utype=="Parent") {
			$data['heading'] = "Parent";
			$data['type'] = "Parent";
			$data['userType'] = "Parent";
		} else if ($utype=="Staff") {
			$data['heading'] = "Staff";
			$data['type'] = "Staff";
			$data['userType'] = "Staff";
		} else if ($utype=="Superadmin"){
			$data['heading'] = "Admin";
			$data['type'] = "Superadmin";
			$data['userType'] = "Superadmin";
		}
		
		if($form_data != null){
			
			

			$data['user_name'] = $form_data['username'];
			if (!empty($form_data['pin'])) {
				$data['password'] = implode("",$form_data['pin']);
			}else{
				$data['password'] = $form_data['password'];
			}
			
			$data['deviceid'] = $this->getIpAddress();
			$data['devicetype'] = 'WEB';

			print_r($data);
			exit;
			
			$url = BASE_API_URL.'login/getUserValidation';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			// print_r($server_output); exit;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			curl_close ($ch);
			$jsonOutput = json_decode($server_output);
		
			if($httpcode == 200){ 
				
				if($jsonOutput->Status == "SUCCESS"){
					
					
					if (empty($jsonOutput->centers)) {
						// Call getUserCenters() to fetch centers
						$userCenters = $this->login_model->getUserCenters($jsonOutput->userid);
						$jsonOutput->centers = $userCenters; // Update centers in the output
					}


					// print_r($jsonOutput->centers);
					// die;

					$this->session->set_userdata(array(
						'AuthToken' => $jsonOutput->AuthToken,
						'LoginId' => $jsonOutput->userid,
						'UserType' => $jsonOutput->role,
						'Name' => $jsonOutput->name,
						'ImgUrl' => $jsonOutput->imageUrl,
						'Container' => $jsonOutput->container,
						'Layout' => $jsonOutput->layout,
						'X-Device-Id' => $data['deviceid'],
						'centerIds' => $jsonOutput->centers
					));

				// print_r($jsonOutput->centers);
				// exit;
				
					$url = base_url("Dashboard");
					redirect($url);
				}
				else{
				}
			}
			else if($httpcode == 401){
				 $data['errorText'] = $jsonOutput->Message;
				// echo json_encode(['success' => false, 'error' => $jsonOutput->Message]);
				// return;
			}
		}
	    if(empty($form_data)){
			$this->load->view('welcome_message');
		}else{
			$this->load->view('newLoginForm',$data);
		}
		
	}

	public function resetPassword($userid=NULL)
	{
		$url = BASE_API_URL."/auth/getUserDetails/".$userid;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($httpcode == 200){
			$output=json_decode($server_output);
			curl_close ($ch);
			if($output->Status == "SUCCESS"){
				$this->load->view('authResetPassword',$output);
			} else {
				$this->load->view('template/linkStatus', $output);
			}
		}
	}

	public function exeResetPassword()
	{	
		$data = $this->input->post();
		if (empty($_POST['password'])) {
			redirect('welcome');
		}else{
			$data['password'] = $_POST['password'];
		}
		$url = BASE_API_URL."/Auth/updatePassword/";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL,$url); 
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($httpcode == 200){
			$jsonOutput=json_decode($server_output);
			curl_close ($ch);
			$this->load->view('template/linkStatus', $jsonOutput);			
		}
		else if($httpcode == 401){
			redirect('welcome');
		}
	}

	public function forgotPassword()
	{
		$this->load->view('forgotPassword');
	}

	public function exeForgotPassword()
	{
		if (empty($_GET['txtEmail'])) {
			redirect('welcome');
		}else{
			$data['email'] = $_GET['txtEmail'];
		}

		$url = BASE_API_URL."/Auth/forgotPassword/";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($httpcode == 200){
			$output=json_decode($server_output);
			curl_close ($ch);
			$this->load->view("forgotPassword",$output);
		}
		else if($httpcode == 401){
			redirect('welcome');
		}

	}

	function getIpAddress(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		//whether ip is from proxy
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		//whether ip is from remote address
		else{
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		return $ip_address;
	}

	public function newLogin()
	{
		$data['email']=isset($_GET['username'])?$_GET['username']:'';
		$utype = $_GET['type'];
		if ($utype=="Parent") {
			$data['heading'] = "Parent";
		} else if ($utype=="Staff") {
			$data['heading'] = "Staff";
		} else if ($utype=="Admin"){
			$data['heading'] = "Admin";
		} else{
			redirect('welcome');
		}
		$this->load->view("newLoginForm",$data);
	}

	public function verifyUser($userid=null,$token=null)
	{
		if($userid != null && $token != null){
			$url = BASE_API_URL."/auth/verifyUser/".$userid."/".$token;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$output=json_decode($server_output);
				curl_close ($ch);
				if($output->Status == "SUCCESS"){
					$url = base_url()."Login/resetPassword/".$userid."/".$token;
					redirect($url);
				} else {
					$this->load->view('forgotPassword',$output);
				}
			}
		}else{
			$data=[];
			$data['Status'] = "ERROR";
			$data['Message'] = "Please request a new reset link!";
			$this->load->view('forgotPassword',$data);
		}
	}
}  
?>