<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->has_userdata("LoginId")) {
			$role = $this->session->userdata('UserType');
			if ($role == "Staff") {
				$this->load->view('ResetPin');
			}else{
				$this->load->view('ResetPassword');
			}
		}else{
			redirect("Welcome");
		} 
		
	}

	public function resetPin()
	{
		if ($this->session->has_userdata("LoginId")) {
			$url = base_url("Settings");
			redirect($url);
		}else{
			redirect("Welcome");
		}
	}

	public function changePin()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();

			if (
				!isset($data['currentPin'], $data['pin'], $data['confirmPin']) ||
				strlen($data['currentPin']) < 4 ||
				strlen($data['pin']) < 4 ||
				strlen($data['confirmPin']) < 4
			) {
				$viewData['message'] = "All pins must be at least 4 digits.";
				$this->load->view('ResetPin', $viewData);
				return;
			}
		 // Validate and process the input data
		 $data['currentPin'] = is_array($data['currentPin']) ? implode("", $data['currentPin']) : $data['currentPin'];
		 $data['pin'] = is_array($data['pin']) ? implode("", $data['pin']) : $data['pin'];
		 $data['confirmPin'] = is_array($data['confirmPin']) ? implode("", $data['confirmPin']) : $data['confirmPin'];
		//  print_r($data);
		//  exit;
			unset($data['newPin']);
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/changePin';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			$data = json_decode($server_output);
				// print_r($data);
				// exit;
						
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($httpcode == 200) {
				$viewData['message'] = "Pin changed successfully!";
			} else {
				$viewData['message'] = 	$data->Message;
			}
	
			// Load the ResetPin view with the message
			$this->load->view('ResetPin', $viewData);

		} else {
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "You've been logged out!";
			echo json_encode();
		}
	}

	
	public function adminresetpassword()
	{
		if ($this->session->has_userdata("LoginId")) {
			if($this->session->userdata("UserType") != "Superadmin" ){
				redirect('Welcome');
			}
			$recordId = $this->input->get('recordId'); 
			
			if ($recordId) {
				// echo "Your record Id is: " . $recordId; exit;
				$this->load->database();
				$query = $this->db->get_where('users', ['userid' => $recordId]);
				$user = $query->row();
	
				if ($user) {
					// $email = $user->emailid; 
					// $password = $user->password; 
					// // $this->load->library('email');
					// $this->load->library('email', $config);
					// $this->email->from('your_email@example.com', 'Your App Name');
					// $this->email->to($email);
					// $this->email->subject('Your Password');
					// $this->email->message("Your password is: " . $password);
	
					// if ($this->email->send()) {
					// 	echo "Password has been sent to the user's email.";
					// } else {
					// 	echo "Failed to send the email.";
					// 	echo $this->email->print_debugger();
					// }
  
					$this->load->library('form_validation');



					if ($this->input->post()) {
						// Handle form submission
						$this->form_validation->set_rules('change_pin', 'Change Pin', 'required|numeric|exact_length[4]');
						$this->form_validation->set_rules('confirm_pin', 'Confirm Pin', 'required|matches[change_pin]');
	
						if ($this->form_validation->run() == TRUE) { 
							$newPin = $this->input->post('change_pin');
							$this->db->where('userid', $recordId);
							$this->db->update('users', ['password' => sha1($newPin)]);
	
							$this->session->set_flashdata('success', 'PIN updated successfully!');
							redirect('Settings/adminresetpassword?recordId=' . $recordId);
						} else {
							$this->session->set_flashdata('error', validation_errors());
						}
					}
	
					$this->load->view('admin_reset_password', ['user' => $user]);
          

				} else {
					echo "No user found with the provided Record ID.";
				}
			} else {
				echo "Record ID is missing!";
			}
		} else {
			redirect("Welcome");
		}
	}


	public function resetPassword()
	{
		if ($this->session->has_userdata("LoginId")) {
			$url = base_url("Settings");
			redirect($url);
		}else{
			redirect("Welcome");
		}
	}

	public function changePassword()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/changePassword';
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
				$this->load->view('ResetPassword',$data);
			}
			else if($httpcode == 401){
				return 'error';
			}
		} else {
			redirect("Welcome");
		}
	}
	public function changeEmail()
	{
		$this->load->view('changeEmail_v3');
	}
	public function exeChangeEmail()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/changeEmail';
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
				$this->load->view('changeEmail_v3',$data);
			}
			else if($httpcode == 401){
				return 'error';
			}
		} else {
			redirect("Welcome");
		}
	}

	public function moduleSettings($centerid = NULL)
	{
		if ($this->session->has_userdata("LoginId")) {
			if($this->session->userdata("UserType") != "Superadmin" ){
				redirect('Welcome');
			}
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			if (empty($_GET['centerid'])) {
				$centerArr = $this->session->userdata("centerIds");
				$centerId = $centerArr[0]->id;
			}else{
				$centerId = $_GET['centerid'];
			}
			$data['centerid'] = $centerId;
			$url = BASE_API_URL.'Settings/getModuleSettings';
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
				$data=[];
				$data = json_decode($server_output);
				$data->centerid = $centerId;
				$this->load->view('moduleSettings',$data);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("Welcome");
		}
	}

	public function addModuleSettings()
	{
		if ($this->session->has_userdata("LoginId")) {
			
			$data = $this->input->post();
		
			$data['userid'] = $this->session->userdata("LoginId");
			if (!isset($data['observation'])) {	$data['observation'] = 0; }
			if (!isset($data['room'])) { $data['room'] = 0; }
			if (!isset($data['programplans'])) { $data['programplans'] = 0; }
			if (!isset($data['qip'])) { $data['qip'] = 0; }
			if (!isset($data['announcements'])) { $data['announcements'] = 0; }
			if (!isset($data['survey'])) { $data['survey'] = 0; }
			if (!isset($data['menu'])) { $data['menu'] = 0; }
			if (!isset($data['recipe'])) { $data['recipe'] = 0; }
			if (!isset($data['dailydiary'])) { $data['dailydiary'] = 0; }
			if (!isset($data['headchecks'])) { $data['headchecks'] = 0; }
			if (!isset($data['accidents'])) { $data['accidents'] = 0; }
			if (!isset($data['resources'])) { $data['resources'] = 0; }
			if (!isset($data['servicedetails'])) { $data['servicedetails'] = 0; }
			
			$centerid = $_GET['centerid'];
			$data['centerid'] = $centerid;
			$url = BASE_API_URL.'Settings/addModuleSettings';
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
				$_url = base_url("Settings/moduleSettings")."?centerId=".$centerid;
				// $_url = base_url("Settings/moduleSettings-newui")."?centerId=".$centerid;
				redirect($_url);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("Welcome");
		}
	}

	public function userSettings()
	{

		if ($this->session->has_userdata("LoginId")) {
			if($this->session->userdata("UserType") != "Superadmin" ){
				redirect('Welcome');
			}
			if(isset($_GET['centerid'])){
				$get = $this->input->get();
				$centerid = $get['centerid'];
			}else{
				$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
			}
			$data['centerid'] = $centerid;
			$data['userid'] = $this->session->userdata("LoginId");

			if (isset($_GET["order"])) {
				$data['order'] = $_GET["order"];
			}else{
				$data['order'] = NULL;
			}

				// echo "<pre>";
				// print_r($data);
				// exit;

			// if (isset($_POST['filter'])) {
			// 	if (isset($_POST['groups'])) {
			// 		$data['groups'] = $_POST['groups'];
			// 	}
			// 	if (isset($_POST['status'])) {
			// 		$data['status'] = $_POST['status'];
			// 	}
			// 	if (isset($_POST['gender'])) {
			// 		$data['gender'] = $_POST['gender'];
			// 	}
			// }

			$url = BASE_API_URL.'Settings/getUsersSettings';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
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
			//var_dump($server_output); exit;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			curl_close($ch);
			if($httpcode == 200){
				$data = json_decode($server_output);
				// echo "<pre>";
				// print_r($data); 
				// echo "</pre>";
				// exit;
				$data->centerid = $centerid;
				$this->load->view('userSettings-newui',$data);
			} else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("Welcome");
		}
	}


	public function addsuperadmin() {
		// Check if request is AJAX
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		$this->load->database();

		// $data = $this->input->post();
		// echo "<pre>";
		// print_r($data);
		// exit;
		// Start transaction
		$this->db->trans_start();
	
		try {
			// Handle image upload if provided
			$imageUrl = '';
			if (!empty($_FILES['imageUrl']['name'])) {
				$config['upload_path'] = './api/assets/media/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = 2048; // 2MB max
	
				$this->load->library('upload', $config);
				
				if (!$this->upload->do_upload('imageUrl')) {
					throw new Exception($this->upload->display_errors());
				}
				
				$uploadData = $this->upload->data();
				$imageUrl = $uploadData['file_name'];
			}else{
				$imageUrl = null;
			}
	
			// Prepare user data
			$userData = [
				'username' => $this->input->post('username'),
				'emailid' => $this->input->post('emailid'),
				'password' =>  sha1($this->input->post('password')),
				'contactNo' => $this->input->post('contactNo'),
				'name' => $this->input->post('name'),
				'dob' => $this->input->post('dob'),
				'gender' => $this->input->post('gender'),
				'title' => $this->input->post('title'),
				'imageUrl' => $imageUrl,
				'userType' => 'Superadmin'
			];
			
			// Insert user data
			$this->db->insert('users', $userData);
			$userId = $this->db->insert_id();
	
			// Prepare center data
			$centerData = [
				'centerName' => $this->input->post('centerName'),
				'adressStreet' => $this->input->post('adressStreet'),
				'addressCity' => $this->input->post('addressCity'),
				'addressState' => $this->input->post('addressState'),
				'addressZip' => $this->input->post('addressZip')
			];
	
			// Insert center data
			$this->db->insert('centers', $centerData);
			$centerId = $this->db->insert_id();
	
			// Link user to center
			$userCenterData = [
				'userid' => $userId,
				'centerid' => $centerId
			];
			$this->db->insert('usercenters', $userCenterData);

			 // Prepare daily diary settings data
			 $diarySettingsData = [
				'centerid' => $centerId,
				'breakfast' => 1,
				'morningtea' => 1,
				'lunch' => 1,
				'sleep' => 1,
				'afternoontea' => 1,
				'latesnacks' => 1,
				'sunscreen' => 1,
				'toileting' => 1
			];
	
			// Insert daily diary settings
			$this->db->insert('dailydiarysettings', $diarySettingsData);
	
			// Complete transaction
			$this->db->trans_complete();
	
			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Transaction failed');
			}
	
			echo json_encode(['status' => 'success']);
	
		} catch (Exception $e) {
			// Rollback transaction
			$this->db->trans_rollback();
			
			echo json_encode([
				'status' => 'error',
				'message' => $e->getMessage()
			]);
		}
	}


	public function superadminSettings(){
		if ($this->session->has_userdata("LoginId")) {
			if($this->session->userdata("UserType") != "Superadmin" ){
				redirect('Welcome');
			}
			if($this->session->userdata("LoginId") != 1 ){
				redirect('Welcome');
			}
             
			$this->load->database();
			$query = $this->db->where('userType', 'Superadmin')
			->where('userid !=', 1)
			->get('users');  // Assuming your table name is 'users'

             $data['users'] = $query->result();
             $data['title'] = 'Superadmin Settings';

       	// echo "<pre>";
        // print_r($data); 
        // echo "</pre>";
        // exit;
		$this->load->view('superadminsetting',$data);

		}else{
			redirect("Welcome");
		}
	}

	public function addUsers()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = [];
			if (isset($_GET['recordId'])) {
				$data['recordId'] = $_GET['recordId'];
				$data['userid'] = $this->session->userdata("LoginId");
				$url = BASE_API_URL.'Settings/getUsersDetails';
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
				// 	print_r($server_output);
				// 	exit; 
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if($httpcode == 200){
					$data = json_decode($server_output);
					// echo "<pre>";
					// print_r($data);
					// exit; 	 	
					curl_close ($ch);
					$this->load->view('addUsersSettings_v3',$data);
				}
			}else{
				$this->load->view('addUsersSettings_v3',$data);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function saveUsersDetails()
	{	
		
		if ($this->session->has_userdata("LoginId")) {
			$data =  $this->input->post();
			// echo "<pre>";
			// print_r($data);
			// exit;
			if (!isset($data['centerIds']) || empty($data['centerIds'])) {
				$data = [];
				$data['Status'] = "ERROR";
				$data['Message'] = "Please select at least one center.";
				echo json_encode($data);
				return;
			}
			
			$data['centerIds'] = json_encode($data['centerIds']);
			if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])){
				$data['image'] = new CurlFile($_FILES['image']['tmp_name'],$_FILES['image']['type'],$_FILES['image']['name']);
			}
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'Settings/saveUsersDetails';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
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
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "You've been logged out!";
			echo json_encode($data);
		}
	}

	public function fetchEmpCodeAvl()
	{
		if ($this->session->has_userdata("LoginId")) {

			$data =  $this->input->post();
			
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/fetchEmpCodeAvl';
			
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
			echo $server_output;
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "You've been logged out!";
			echo json_encode($data);
		}
	}


	public function centerSettings()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data['userid'] = $this->session->userdata("LoginId");
			if (isset($_GET["order"])) {
				$data['order'] = $_GET["order"];
			}
			$url = BASE_API_URL.'Settings/getCentersSettings';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$data = json_decode($server_output);
				curl_close($ch);
				$this->load->view('centersSettings_v3',$data);
			} else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("Welcome");
		}
	}

	public function addCenter()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = [];
			if (isset($_GET['centerId'])) {
				$data['centerId'] = $_GET['centerId'];
				$data['userid'] = $this->session->userdata("LoginId");
				$url = BASE_API_URL.'Settings/getCenterDetails';
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
					curl_close($ch);
					$this->load->view('addCenterSettings_v3',$data);
				}
			}else{
				$this->load->view('addCenterSettings_v3',$data);
			}
			
		}else{
			redirect("Welcome");
		}
	}

	public function saveCenterDetails()
	{
		if ($this->session->has_userdata("LoginId")) {

			$data =  $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$count = count($_POST['roomName']);

			$data['rooms'] = [];

			for ($i=0; $i < $count ; $i++) { 
				if (empty($_POST['roomid'][$i])) {
					$d['roomid'] = "";
					$d['roomName'] = $_POST['roomName'][$i];
					$d['roomCapacity'] = $_POST['roomCapacity'][$i];
					$d['roomStatus'] = $_POST['roomStatus'][$i];
					$d['roomColor'] = $_POST['roomColor'][$i];
				}else{
					$d['roomid'] = $_POST['roomid'][$i];
					$d['roomName'] = $_POST['roomName'][$i];
					$d['roomCapacity'] = $_POST['roomCapacity'][$i];
					$d['roomStatus'] = $_POST['roomStatus'][$i];
					$d['roomColor'] = $_POST['roomColor'][$i];
				}
				array_push($data['rooms'], $d);
			}

			unset($data['roomName']);
			unset($data['roomid']);
			unset($data['roomCapacity']);
			unset($data['roomStatus']);
			unset($data['roomColor']);
			$url = BASE_API_URL.'Settings/saveCenterDetails';
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
				redirect("Settings/centerSettings");
			} else if($httpcode == 401){
				return 'error';
			}

		}else{
			redirect("Welcome");
		}
	}

	public function parentSettings()
	{
		if ($this->session->has_userdata("LoginId")) {

			// if($this->session->userdata("UserType") != "Superadmin" ){
			// 	redirect('Welcome');
			// }
			if(isset($_GET['centerid'])){
				$get = $this->input->get();
				$centerid = $get['centerid'];
			}else{
				$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
			}
			$data['centerid'] = $centerid;

			$data['userid'] = $this->session->userdata("LoginId");

			// echo "<pre>";
			// print_r($data);
			// exit;

			if (isset($_GET["order"])) {
				$data['order'] = $_GET["order"];
			}
			$url = BASE_API_URL.'Settings/getParentSettings';
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
				// echo "<pre>";
				// print_r($data);
				// exit;
				curl_close ($ch);
				$data->centerid = $centerid;
				$this->load->view('parentSettings_v3',$data);
			} else if($httpcode == 401){
				return 'error';
			}

		}else{
			redirect("Welcome");
		}
	}
	public function addParent()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = [];
			if (isset($_GET['recordId'])) {
				$data['recordId'] = $_GET['recordId'];
			}

			 // Get the centerid from the URL query string
			 $centerid = $this->input->get('centerid');

			 // Pass the centerid to the view
			 $data['centerid'] = $centerid;

			if($this->session->userdata("UserType") != "Superadmin" ){
				$data['superadmin'] = 0;
			}else{
                $data['superadmin'] = 1;
			}

			$data['userid'] = $this->session->userdata("LoginId");
			// echo "<pre>";
			// 	print_r($data);
			// 	exit;
			
			$url = BASE_API_URL.'Settings/getParentDetails';

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			// echo $server_output;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$data = json_decode($server_output);
				$data->centerid = $centerid;
				// echo "<pre>";
				// print_r($data);
				// exit;
				curl_close ($ch);
				$this->load->view('addParentSettings_v3',$data);
			}
		}else{
			redirect("Welcome");
		}
	}
	
	public function saveParentDetails()
	{
		if ($this->session->has_userdata("LoginId")) {
			
			$relation = [];
			$count = count($_POST['children']);
			for ($i=0; $i < $count; $i++) { 
				$d['childid'] = $_POST['children'][$i];
				$d['relation'] = $_POST['relation'][$i];
				array_push($relation, $d);
			}
			unset($_POST['children']);
			unset($_POST['relation']);
			$data = $_POST;
			$data['relation'] = $relation;
			$data['userid'] = $this->session->userdata("LoginId");
			// print_r($data);
			// exit;
			$url = BASE_API_URL.'Settings/saveParentDetails';
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
			// echo $server_output;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$data = json_decode($server_output);
				curl_close ($ch);
				redirect("Settings/parentSettings");
			} else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("Welcome");
		}
	}

	public function childGroups()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = [];
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/getChildGroups';

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
				// $this->load->view('childGroups',$data);
				$this->load->view('childGroups-newui',$data);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function addChildGroup()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = [];
			if (isset($_GET['groupId'])) {
				$data['groupId'] = $_GET['groupId'];
			}
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/getChildGroupDetails';

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
			// echo $server_output;
			// exit();
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$data = json_decode($server_output);
				// print_r($data);
				curl_close ($ch);
				// $this->load->view('addChildGroups',$data);
				$this->load->view('addChildGroups-newui',$data);
			}
		}else{
			redirect("Welcome");
		}
	}
	public function saveChildGroup()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data =  $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/saveChildGroup';
			
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
			// echo $server_output;
			// exit();
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$data = json_decode($server_output);
				curl_close ($ch);
				redirect("Settings/childGroups");
			} else if($httpcode == 401){
				return 'error';
			}

		}else{
			redirect("Welcome");
		}
	}

	public function managePermissions()
	{
		if ($this->session->has_userdata("LoginId")) {
			if($this->session->userdata("UserType") != "Superadmin" ){
				redirect('Welcome');
			}
			$data =  $this->input->post();
			if (empty($_POST['centerId'])) {
				$centerArr = $this->session->userdata("centerIds");
				$centerId = $centerArr[0]->id;
			}else{
				$centerId = $_POST['centerId'];
			}
			$data['centerid'] = $centerId;
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
			curl_close($ch);
			if($httpcode == 200){
				$jsondata = json_decode($server_output);
				$this->load->view('managePermissions_v3', $jsondata);
			} else if($httpcode == 401){
				return 'error';
			}

		}else{
			redirect("Welcome");
		}
	}

	public function getUsersPermissions()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data =  $this->input->post();
			$data['users'] = json_decode($data['users']);
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
			echo $server_output;
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Session timeout! Please relogin.";
			echo json_encode($data);
		}
	}

	public function getCenterUsers()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data =  $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/getCenterUsers';
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
			echo $server_output;
		}else{
			redirect("Welcome");
		}
	}

	public function savePermission()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data =  $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/savePermissions';			
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
			echo $server_output;
		}else{
			redirect("Welcome");
		}
	}

	public function applicationSettings()
	{
		if ($this->session->has_userdata("LoginId")) {
			//Only Superadmin can access these
			if($this->session->userdata("UserType") != "Superadmin" ){
				redirect('Welcome');
			}

			$data = $this->input->post();

			if (empty($_GET['centerId'])) {
				$centerArr = $this->session->userdata("centerIds");
				$centerId = $centerArr[0]->id;
			}else{
				$centerId = $_GET['centerId'];
			}

			$data['centerid'] = $centerId;

			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/dailyJournalTabs';


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
			if($httpcode == 200){
				$jsonOutput = json_decode($server_output);
				// $this->load->view('applicationSettings', $jsonOutput);
				$this->load->view('applicationSettings-newui', $jsonOutput);				
			} else if($httpcode == 401){
				return 'error';
			}

		}else{
			redirect("Welcome");
		}
	}

	public function saveApplicationSettings()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			if (!isset($data['breakfast'])) { $data['breakfast'] = 0; }else{ $data['breakfast'] = 1; }
			if (!isset($data['morningtea'])) { $data['morningtea'] = 0; }else{ $data['morningtea'] = 1; }
			if (!isset($data['lunch'])) { $data['lunch'] = 0; }else{ $data['lunch'] = 1; }
			if (!isset($data['sleep'])) { $data['sleep'] = 0; }else{ $data['sleep'] = 1; }
			if (!isset($data['afternoontea'])) { $data['afternoontea'] = 0; }else{ $data['afternoontea'] = 1; }
			if (!isset($data['latesnacks'])) { $data['latesnacks'] = 0; }else{ $data['latesnacks'] = 1; }
			if (!isset($data['sunscreen'])) { $data['sunscreen'] = 0; }else{ $data['sunscreen'] = 1; }
			if (!isset($data['toileting'])) { $data['toileting'] = 0; }else{ $data['toileting'] = 1; }
			$centerid = $data['centerid'];
			$url = BASE_API_URL.'Settings/saveApplicationSettings';
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
				$_url = base_url("Settings/applicationSettings")."?centerId=".$centerid;
				redirect($_url);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("Welcome");
		}
	}

	public function noticePeriodSettings()
	{
		if ($this->session->has_userdata("LoginId")) {
			//Only Superadmin can access these
			if($this->session->userdata("UserType") != "Superadmin" ){
				redirect('Welcome');
			}

			$data = $this->input->post();

			if (empty($_GET['centerId'])) {
				$centerArr = $this->session->userdata("centerIds");
				$centerId = $centerArr[0]->id;
			}else{
				$centerId = $_GET['centerId'];
			}

			$data['centerid'] = $centerId;

			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/noticePeriodSettings';
			
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
			if($httpcode == 200){
				$jsonOutput = json_decode($server_output);
				// $this->load->view('noticePeriodSettings', $jsonOutput);
				$this->load->view('noticePeriodSettings-newui', $jsonOutput);
			} else if($httpcode == 401){
				return 'error';
			}

		}else{
			redirect("Welcome");
		}
	}

	public function saveNoticeSettings($value='')
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$centerid = $data['centerid'];
			$url = BASE_API_URL.'Settings/saveNoticeSettings';
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
				$_url = base_url("Settings/noticePeriodSettings")."?centerId=".$centerid;
				redirect($_url);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("Welcome");
		}
	}

	public function export_excel(){
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$centerArr = $this->session->userdata("centerIds");
			$data['centerid'] = $centerArr[0]->id;
			$url = BASE_API_URL.'Settings/export_excel';
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
				$columnHeader = "S.No". "\t" . "Name" . "\t" . "Email-Id" . "\t" . "Contact No" . "\t" . "DOB" . "\t". "Gender" . "\t". "UserType" . "\t";  
				$i=0;
				$rowData =$setData = '';  
				foreach ($data->export as $export_key=>$export_value) {  
					$value = '' .++$i. '' . "\t".'' . $export_value->name. '' . "\t".'' . $export_value->emailid. '' . "\t".'' . $export_value->contactNo. '' . "\t". $export_value->dob. '' . "\t". $export_value->gender. '' . "\t". $export_value->userType. '' . "\t\n";  
					$rowData .= $value;  
				}  
				$setData .= trim($rowData) . "\n";  


				header("Content-type: application/octet-stream");  
				header("Content-Disposition: attachment; filename=User_Detail.xls");  
				header("Pragma: no-cache");  
				header("Expires: 0");  

  				echo ucwords($columnHeader) . "\n" . $setData . "\n";  

				//redirect($_url);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			//redirect("Welcome");
		}
	}

	public function themeSettings($value='')
	{
		if ($this->session->has_userdata("LoginId")) {
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/themeSettings';
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
				$json = json_decode($server_output);
				curl_close ($ch);
				$this->load->view("themeSettings",$json);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("Welcome");
		}
	}

	public function saveThemeSettings($value='')
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/saveThemeSettings';
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
				$json = json_decode($server_output);
				curl_close ($ch);
				redirect('Logout');
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("Welcome");
		}
	}

	public function assessment() 
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			if (empty($_GET['centerid']) || !isset($_GET['centerid'])) {
				$centerArr = $this->session->userdata("centerIds");
				$centerId = $centerArr[0]->id;
			}else{
				$centerId = $_GET['centerid'];
			}
			$data['userid'] = $this->session->userdata("LoginId");
			$data['centerid'] = $centerId;
			$url = BASE_API_URL.'Settings/getAssessmentSettings/';
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
				$json = json_decode($server_output);
				$this->load->view('assessmentSetting-newui', $json);
			} else if ($httpcode == 401){
				$json = json_decode($server_output);
				$this->load->view('assessmentSetting-newui', $json);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function saveAsmntSettings()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['montessori'] = isset($data['montessori'])?$data['montessori']:0;
			$data['devmile'] = isset($data['devmile'])?$data['devmile']:0;
			$data['eylf'] = isset($data['eylf'])?$data['eylf']:0;
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/saveAsmntSettings/';
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
			if($httpcode == 200){
				$goto_url = base_url("Settings/assessment")."?centerid=".$data['centerid']."&status=success";
				redirect($goto_url);
			}
			else if($httpcode == 401){
				$goto_url = base_url("Settings/assessment")."?centerid=".$data['centerid']."&status=error";
				redirect($goto_url);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function montessori() {
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			if (empty($_GET['centerid'])) {
				$centerArr = $this->session->userdata("centerIds");
				$centerId = $centerArr[0]->id;
			}else{
				$centerId = $_GET['centerid'];
			}
			$data['userid'] = $this->session->userdata("LoginId");
			$data['centerid'] = $centerId;
			$url = BASE_API_URL.'Settings/getMontessoriSettings/';
			
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
			if($httpcode == 200){
				$json = json_decode($server_output);
				$this->load->view('montessoriSetting', $json);
			}
			else if($httpcode == 401){
				$json = json_decode($server_output);
				$this->load->view('montessoriSetting', $json);
			}
		}else{
			redirect("Welcome");
		}
	}


	public function saveActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/saveActivity/';
			
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
			if($httpcode == 200){
				$newurl = base_url("Settings/montessori")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/montessori")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function saveSubActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/saveSubActivity';
			
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
			if($httpcode == 200){
				$newurl = base_url("Settings/montessori")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/montessori")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function getSubActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/getSubActivity';
			
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
			redirect("Welcome");
		}
	}

	public function saveExtras()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/saveExtras';
			
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
			if($httpcode == 200){
				$newurl = base_url("Settings/montessori")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/montessori")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function deleteMonActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/deleteMonActivity';
			
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
			if($httpcode == 200){
				$newurl = base_url("Settings/montessori")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/montessori")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function deleteMonSubActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/deleteMonSubActivity';
			
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
			if($httpcode == 200){
				$newurl = base_url("Settings/montessori")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/montessori")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function deleteMonSubActivityExtras()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/deleteMonSubActivityExtras';

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
			if($httpcode == 200){
				$newurl = base_url("Settings/montessori")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/montessori")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function saveMontessoriList()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$data['activity'] = json_decode($data['activity']);
			$data['subactivity'] = json_decode($data['subactivity']);
			$data['extras'] = json_decode($data['extras']);
			$url = BASE_API_URL.'Settings/saveMontessoriList';

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
			redirect("Welcome");
		}
	}

	public function eylf() 
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			if (empty($_GET['centerid'])) {
				$centerArr = $this->session->userdata("centerIds");
				$centerId = $centerArr[0]->id;
			}else{
				$centerId = $_GET['centerid'];
			}
			$data['userid'] = $this->session->userdata("LoginId");
			$data['centerid'] = $centerId;
			$url = BASE_API_URL.'Settings/getEylfSettings/';
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
			if($httpcode == 200){
				$json = json_decode($server_output);
				$json->centerid = $centerId;
				$this->load->view('eylfSetting', $json);
			}
			else if($httpcode == 401){
				$json = json_decode($server_output);
				$json->centerid = $centerId;
				$this->load->view('eylfSetting', $json);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function saveEylfActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/saveEylfActivity/';
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
			if($httpcode == 200){
				$newurl = base_url("Settings/eylf")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/eylf")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function saveEylfSubActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/saveEylfSubActivity';
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
			if($httpcode == 200){
				$newurl = base_url("Settings/eylf")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/eylf")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function getEylfSubActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/getEylfSubActivity';
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
			redirect("Welcome");
		}
	}

	public function deleteEylfActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/deleteEylfActivity';
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
			if($httpcode == 200){
				$newurl = base_url("Settings/eylf")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/eylf")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function deleteEylfSubActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/deleteEylfSubActivity';
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
			if($httpcode == 200){
				$newurl = base_url("Settings/eylf")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/eylf")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function deleteEylfSubActivityExtras()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/deleteEylfSubActivityExtras';
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
			if($httpcode == 200){
				$newurl = base_url("Settings/eylf")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/eylf")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function saveEylfList()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$data['activity'] = json_decode($data['activity']);
			$data['subactivity'] = json_decode($data['subactivity']);
			$url = BASE_API_URL.'Settings/saveEylfList';
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
			redirect("Welcome");
		}
	}
	
	public function developmentmilestone() {
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			if (empty($_GET['centerid'])) {
				$centerArr = $this->session->userdata("centerIds");
				$centerId = $centerArr[0]->id;
			}else{
				$centerId = $_GET['centerid'];
			}
			$data['userid'] = $this->session->userdata("LoginId");
			$data['centerid'] = $centerId;
			$url = BASE_API_URL.'Settings/getDevMileSettings/';

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
			if($httpcode == 200){
				$json = json_decode($server_output);
				$json->centerid = $centerId;
				$this->load->view('developmentmilestoneSetting', $json);
			}
			else if($httpcode == 401){
				$json = json_decode($server_output);
				$json->centerid = $centerId;
				$this->load->view('developmentmilestoneSetting', $json);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function saveDevMileActivity()
	{
		//working fine
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/saveDevMileActivity/';

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
			if($httpcode == 200){
				$newurl = base_url("Settings/developmentmilestone")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/developmentmilestone")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function saveDevMileSubActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/saveDevMileSubActivity';

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
			if($httpcode == 200){
				$newurl = base_url("Settings/developmentmilestone")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/developmentmilestone")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function getDevMileSubActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/getDevMileSubActivity';
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
			redirect("Welcome");
		}
	}

	public function saveDevMileExtras()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/saveDevMileExtras';
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
			if($httpcode == 200){
				$newurl = base_url("Settings/developmentmilestone")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/developmentmilestone")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function deleteMileMain()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/deleteMileMain';
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
			if($httpcode == 200){
				$newurl = base_url("Settings/developmentmilestone")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/developmentmilestone")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function deleteMileSubActivity()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/deleteMileSubActivity';
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
			if($httpcode == 200){
				$newurl = base_url("Settings/developmentmilestone")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/developmentmilestone")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function deleteMileSubActExtras()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/deleteMileSubActExtras';
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
			if($httpcode == 200){
				$newurl = base_url("Settings/developmentmilestone")."?status=success&centerid=".$data['centerid'];
				redirect($newurl);
			}else{
				$newurl = base_url("Settings/developmentmilestone")."?status=error&centerid=".$data['centerid'];
				redirect($newurl);
			}
		}else{
			redirect("Welcome");
		}
	}

	public function saveDevMileList()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$data['activity'] = json_decode($data['activity']);
			$data['subactivity'] = json_decode($data['subactivity']);
			$data['extras'] = json_decode($data['extras']);
			$url = BASE_API_URL.'Settings/saveDevMileList';
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
			redirect("Welcome");
		}
	}



public function uploadProfileImage()
{
    try {
		$this->load->database();
        $userId = $this->input->post('userId');
        if (!$userId) {
            throw new Exception("User ID is required.");
        }

        // Handle image upload
        if (!empty($_FILES['imageUrl']['name'])) {
            $config['upload_path'] = './api/assets/media/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|heic|heif'; // Updated supported types
            $config['max_size'] = 2048; // 2MB max
            $config['file_name'] = 'profile_' . time(); // Rename to prevent duplicates

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('imageUrl')) {
                throw new Exception($this->upload->display_errors());
            }

            $uploadData = $this->upload->data();
            $imageUrl = $uploadData['file_name'];

            // Update user record
            $this->db->where('userid', $userId);
            $this->db->update('users', ['imageUrl' => $imageUrl]);

            // Update session with new image
            $this->session->set_userdata('ImgUrl', $imageUrl);

            echo json_encode(['status' => 'success', 'message' => 'Profile picture updated successfully!']);
        } else {
            throw new Exception("No file uploaded.");
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}






	
}

/* End of file Settings.php */
/* Location: ./application/controllers/Settings.php */