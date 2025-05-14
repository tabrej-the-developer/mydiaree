<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php'; // Include composer autoload

use PhpOffice\PhpSpreadsheet\IOFactory;


class Settings extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->database(); 
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

	public function managepublicholiday() {
        $data['holidays'] = $this->db->get('publicholidays')->result();
        $this->load->view('managepublicholidaypages', $data);
    }


	public function upload_ajax() {
		ini_set('display_errors', 0);

        // Set up the response array
        $response = array(
            'status' => 'error',
            'message' => 'Unknown error occurred'
        );
        
        // Configure upload settings
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = 2048; // 2MB max
        
        // Create upload folder if it doesn't exist
        if (!is_dir('./uploads/')) {
            mkdir('./uploads/', 0777, true);
        }
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('excelfile')) {
            // File upload failed
            $response['message'] = $this->upload->display_errors('', '');
        } else {
            // File upload succeeded
            $upload_data = $this->upload->data();
            $file_path = $upload_data['full_path'];
            
            // Process the Excel file
            try {
                $result = $this->process_excel($file_path);
                $response['status'] = 'success';
                $response['message'] = $result;
            } catch (Exception $e) {
                $response['message'] = "Error processing file: " . $e->getMessage();
            }
            
            // Delete the file after processing
            unlink($file_path);
        }
        
        // Send JSON response
        echo json_encode($response);
		exit; // Ensure execution stops here
    }
    
	private function process_excel($file_path) {
		try {
			// Temporarily suppress deprecation warnings
			$errorLevel = error_reporting();
			error_reporting($errorLevel & ~E_DEPRECATED & ~E_USER_DEPRECATED);
			
			// Identify the type of file (xlsx, xls, csv)
			$file_type = IOFactory::identify($file_path);
			
			// Create a reader based on file type
			$reader = IOFactory::createReader($file_type);
			
			// Load the file
			$spreadsheet = $reader->load($file_path);
			
			// Restore original error reporting level
			error_reporting($errorLevel);
			
			// Rest of your code remains the same
			$worksheet = $spreadsheet->getActiveSheet();
			$highest_row = $worksheet->getHighestRow();
			$start_row = 2;
			$insert_count = 0;
			$skip_count = 0;
			
			// Begin transaction
			$this->db->trans_start();
			
			for ($row = $start_row; $row <= $highest_row; $row++) {
				$date = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$month = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				$occasion = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				
				// Skip rows with empty required fields
				if (empty($date) || empty($month) || empty($occasion)) {
					continue;
				}
				
				// Check if entry already exists in database
				$this->db->where('date', (int)$date);
				$this->db->where('month', (int)$month);
				$this->db->where('occasion', $occasion);
				$query = $this->db->get('publicholidays');
				
				// If entry exists, skip it
				if ($query->num_rows() > 0) {
					$skip_count++;
					continue;
				}
				
				// Using direct DB query instead of model
				$data = array(
					'date' => (int)$date,
					'month' => (int)$month,
					'occasion' => $occasion
				);
				
				$this->db->insert('publicholidays', $data);
				$insert_count++;
			}
			
			// Complete transaction
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE) {
				throw new Exception("Database transaction failed");
			}
			
			$message = "Successfully imported $insert_count holiday records.";
			if ($skip_count > 0) {
				$message .= " Skipped $skip_count duplicate entries.";
			}
			
			return $message;
			
		} catch (Exception $e) {
			throw $e; // Re-throw to be caught by the calling function
		}
	}


	  // API endpoint to fetch all holidays
	  public function getHolidays() {
        $holidays = $this->db->get('publicholidays')->result();
        echo json_encode(['data' => $holidays]);
    }
    
   
	public function addHoliday() {
		$state = $this->input->post('state');
		$occasion = $this->input->post('occasion');
		$isRange = $this->input->post('isRange');
		
		// Check if we're using date range or single date
		if ($isRange == '1') {
			$fromDate = $this->input->post('fromDate');
			$toDate = $this->input->post('toDate');
			
			if (empty($fromDate)) {
				echo json_encode(['status' => 'error', 'message' => 'From date is required']);
				return;
			}
			
			// Convert dates to DateTime objects
			$startDate = new DateTime($fromDate);
			
			// If toDate is empty, use fromDate as the end date (single day)
			$endDate = !empty($toDate) ? new DateTime($toDate) : clone $startDate;
			
			// If end date is before start date, swap them
			if ($endDate < $startDate) {
				$temp = $startDate;
				$startDate = $endDate;
				$endDate = $temp;
			}
			
			// Create a period iterator
			$interval = new DateInterval('P1D'); // 1 day interval
			$dateRange = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));
			
			$insertCount = 0;
			$errorCount = 0;
			
			// Loop through each date in the range and insert
			foreach ($dateRange as $date) {
				$data = [
					'state' => $state,
					'date' => $date->format('j'), // Day of month without leading zeros
					'month' => $date->format('n'), // Month without leading zeros
					'occasion' => $occasion
				];
				
				$result = $this->db->insert('publicholidays', $data);
				
				if ($result) {
					$insertCount++;
				} else {
					$errorCount++;
				}
			}
			
			if ($errorCount == 0) {
				echo json_encode([
					'status' => 'success', 
					'message' => $insertCount . ' holiday(s) added successfully'
				]);
			} else {
				echo json_encode([
					'status' => 'partial', 
					'message' => $insertCount . ' holiday(s) added, ' . $errorCount . ' failed'
				]);
			}
		} else {
			// Original single date mode (kept for backward compatibility)
			$data = [
				'state' => $state,
				'date' => $this->input->post('date'),
				'month' => $this->input->post('month'),
				'occasion' => $occasion
			];
			
			$result = $this->db->insert('publicholidays', $data);
			
			if ($result) {
				echo json_encode(['status' => 'success', 'message' => 'Holiday added successfully']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to add holiday']);
			}
		}
	}
    
    
    public function updateHoliday() {
        $id = $this->input->post('id');
        $data = [
            'state' => $this->input->post('state'),
            'date' => $this->input->post('date'),
            'month' => $this->input->post('month'),
            'occasion' => $this->input->post('occasion')
        ];
        
        $this->db->where('id', $id);
        $result = $this->db->update('publicholidays', $data);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Holiday updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update holiday']);
        }
    }
    
    // API endpoint to get single holiday for editing
    public function getHoliday() {
    $id = $this->input->get('id');
    $holiday = $this->db
        ->where('id', $id)
        ->order_by('id', 'DESC') // Add order_by clause
        ->get('publicholidays')
        ->row();

    echo json_encode(['data' => $holiday]);
}
    
    // API endpoint to delete holiday
    public function deleteHoliday() {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $result = $this->db->delete('publicholidays');
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Holiday deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete holiday']);
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


	public function send_email() {
        $this->load->library('email');

        $this->email->from('mydairee47@gmail.com', 'My Diaree Support');
        $this->email->to('tabrezk294@gmail.com');
        $this->email->subject('Test Email from CodeIgniter 3');
        $this->email->message('This is a test email from CodeIgniter 3 using GoDaddy SMTP.');

        if ($this->email->send()) {
            echo 'Email sent successfully!';
        } else {
            echo $this->email->print_debugger(); // Print errors if any
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



	public function deleteUser() {
		$this->load->database();

        $userid = $this->input->post('userid');

        // Delete from users table
        $this->db->where('userid', $userid);
        $this->db->delete('users');

        // Delete from usercenters table
        $this->db->where('userid', $userid);
        $this->db->delete('usercenters');

		if ($this->db->affected_rows() > 0) {
			// If deletion is successful
			$response = ['success' => true];
		} else {
			// If deletion fails
			$response = ['success' => false];
		}
	
		// Send JSON response
		$this->output
			->set_content_type('application/json') // Set the response content type to JSON
			->set_output(json_encode($response));
    }


	public function changeUserStatus()
{
    $userid = $this->input->post('userid');
    $status = $this->input->post('status');

    $this->db->where('userid', $userid);
    $this->db->update('users', ['status' => $status]);

    if ($this->db->affected_rows() > 0) {
        $response = ['success' => true];
    } else {
        $response = ['success' => false];
    }

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
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
			// echo "<pre>";
			// print_r($data['relation']);
			// exit;
			$email = $data['emailid'];
			$password = $data['password'];
			$childdata = $data['relation'];
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
				$this->_sendWelcomeEmail($email,$password,$childdata);
				// print_r($data);
				// exit;
				redirect("Settings/parentSettings");
			} else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("Welcome");
		}
	}



	private function _sendWelcomeEmail($email, $password, $childdata)
	{
		$this->load->library('email');
		$this->load->database();
		
		// Get child details for each child ID
		$childrenDetails = [];
		foreach ($childdata as $child) {
			$childId = $child['childid'];
			$relation = $child['relation'];
			
			// Query to get child details
			$query = $this->db->select('name, lastname, dob, imageUrl')
							 ->from('child')
							 ->where('id', $childId)
							 ->get();
			
			if ($query->num_rows() > 0) {
				$childInfo = $query->row_array();
				$childInfo['relation'] = $relation;
				$childrenDetails[] = $childInfo;
			}
		}
		
		// Generate HTML for each child
		$childrenHTML = '';
		foreach ($childrenDetails as $child) {
			$childImageUrl = BASE_API_URL . 'assets/media/' . $child['imageUrl'];
			$childFullName = $child['name'] . ' ' . $child['lastname'];
			$dob = date('d M Y', strtotime($child['dob']));
			
			$childrenHTML .= '
			<div class="child-card">
				<div class="child-photo">
					<img src="' . $childImageUrl . '" alt="' . $childFullName . '" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
				</div>
				<div class="child-info">
					<h3>' . $childFullName . '</h3>
					<p><strong>Date of Birth:</strong> ' . $dob . '</p>
					<p><strong>Your Relation:</strong> ' . $child['relation'] . '</p>
				</div>
			</div>';
		}
		
		// Create the email message
		$this->email->from('mydairee47@gmail.com', 'MyDiaree Support');
		$this->email->to($email);
		$this->email->subject('Welcome to MyDiaree (Beta) - A Smarter Way to stay in touch with your child\'s development and Learning!');
		
		// Create HTML email with professional design
		$message = '
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Welcome to MyDiaree</title>
			<style>
				body {
					font-family: "Segoe UI", Arial, sans-serif;
					line-height: 1.6;
					color: #333333;
					margin: 0;
					padding: 0;
					background-color: #f5f5f5;
				}
				.container {
					max-width: 650px;
					margin: 0 auto;
					background-color: #ffffff;
					box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
				}
				.header {
					background: linear-gradient(135deg, #5668e2 0%, #6a78f0 100%);
					color: white;
					padding: 25px 30px;
					text-align: center;
					border-radius: 5px 5px 0 0;
				}
				.content {
					padding: 30px;
					background-color: #ffffff;
				}
				h1 {
					color: #ffffff;
					margin: 0;
					font-size: 28px;
					font-weight: 600;
					letter-spacing: 0.5px;
				}
				h2 {
					color: #5668e2;
					margin-top: 5px;
					font-size: 22px;
					border-bottom: 2px solid #f0f0f0;
					padding-bottom: 10px;
				}
				.login-details {
					background-color: #f8f9ff;
					border-left: 4px solid #5668e2;
					padding: 15px 20px;
					margin: 20px 0;
					border-radius: 0 5px 5px 0;
				}
				.login-details p {
					margin: 5px 0;
				}
				.credentials {
					font-family: monospace;
					font-size: 16px;
					background-color: #f0f0f0;
					padding: 3px 6px;
					border-radius: 3px;
				}
				.check-item {
					margin-bottom: 12px;
					position: relative;
					padding-left: 30px;
				}
				.check-item:before {
					content: "";
					position: absolute;
					left: 0;
					top: 2px;
					width: 20px;
					height: 20px;
					background-color: #5668e2;
					border-radius: 50%;
					background-image: url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'12\' height=\'12\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%23ffffff\' stroke-width=\'3\' stroke-linecap=\'round\' stroke-linejoin=\'round\'%3E%3Cpolyline points=\'20 6 9 17 4 12\'%3E%3C/polyline%3E%3C/svg%3E");
					background-repeat: no-repeat;
					background-position: center;
				}
				.footer {
					text-align: center;
					padding: 20px 30px;
					font-size: 13px;
					color: #777777;
					background-color: #f9f9f9;
					border-top: 1px solid #eeeeee;
				}
				.button {
					display: inline-block;
					background: linear-gradient(135deg, #5668e2 0%, #6a78f0 100%);
					color: white;
					padding: 14px 28px;
					text-decoration: none;
					border-radius: 4px;
					margin: 20px 0;
					font-weight: bold;
					text-transform: uppercase;
					letter-spacing: 0.5px;
					font-size: 14px;
					box-shadow: 0 3px 6px rgba(106, 120, 240, 0.3);
					transition: all 0.3s ease;
				}
				.button:hover {
					background: linear-gradient(135deg, #4a5bd0 0%, #5968db 100%);
					box-shadow: 0 5px 10px rgba(106, 120, 240, 0.5);
				}
				.child-section {
					margin: 30px 0;
					border-top: 2px dashed #f0f0f0;
					padding-top: 20px;
				}
				.child-card {
					display: flex;
					background-color: #f8f9ff;
					border-radius: 10px;
					padding: 15px;
					margin-bottom: 20px;
					box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
				}
				.child-photo {
					margin-right: 20px;
					flex-shrink: 0;
				}
				.child-info {
					flex-grow: 1;
				}
				.child-info h3 {
					margin-top: 0;
					color: #5668e2;
				}
				.highlight {
					color: #5668e2;
					font-weight: bold;
				}
				.divider {
					height: 1px;
					background-color: #eeeeee;
					margin: 25px 0;
				}
			</style>
		</head>
		<body>
			<div class="container">
				<div class="header">
					<h1>Welcome to MyDiaree (Beta)</h1>
				</div>
				<div class="content">
					<h2>Dear Parent,</h2>
					<p>We are excited to welcome you to <span class="highlight">MyDiaree (Beta)</span>, our innovative platform designed to keep you connected with your child\'s development and learning journey!</p>
					
					<div class="login-details">
						<h3>Your Login Information</h3>
						<p><strong>Email:</strong> <span class="credentials">' . $email . '</span></p>
						<p><strong>Password:</strong> <span class="credentials">' . $password . '</span></p>
						<p><em>Please store this information safely for future access.</em></p>
					</div>
					
					<p>With MyDiaree, you\'ll enjoy these features:</p>
					<p class="check-item">Track daily routine and progress of your child</p>
					<p class="check-item">Stay updated with important school announcements</p>
					<p class="check-item">Communicate effortlessly with teachers</p>
					<p class="check-item">Access learning resources to support your child at home</p>
					
					<div style="text-align: center;">
						<a href="https://mydiaree.com/login?type=Parent" class="button" style="color:white;">Log In To Your Account</a>
					</div>
					
					<div class="child-section">
						<h2>Your Connected Child/ren</h2>
						<p>You have been linked to the following children in MyDiaree:</p>
						
						' . $childrenHTML . '
					</div>
					
					<div class="divider"></div>
					
					<p>We believe MyDiaree will transform how you stay connected with your child\'s educational journey, making parent-school collaboration smoother and more effective than ever before.</p>
					
					<p>If you have any questions or need assistance, our support team is always here to help at <a href="mailto:mydairee47@gmail.com" style="color: #5668e2;">mydairee47@gmail.com</a></p>
					
					<p>Welcome aboard, and thank you for being a part of this exciting journey!</p>
					
					<p>Warm regards,<br>
					<strong>Nextgen Montessori Team</strong></p>
				</div>
				<div class="footer">
					<p>&copy; ' . date('Y') . ' MyDiaree. All rights reserved.</p>
					<p>This is an automated email. Please do not reply directly to this message.</p>
				
				</div>
			</div>
		</body>
		</html>
		';
		
		$this->email->set_mailtype('html');
		$this->email->message($message);
		
		return $this->email->send();
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
				// echo "<pre>";
				// print_r($jsondata);
				// exit;
				$this->load->view('managePermissions_v3', $jsondata);
			} else if($httpcode == 401){
				return 'error';
			}

		}else{
			redirect("Welcome");
		}
	}

	public function update_permissions() {
        $user_id = $this->input->post('user_id');
		$data = array(
			'addObservation' => $this->input->post('addObservation') ? 1 : 0,
			'approveObservation' => $this->input->post('approveObservation') ? 1 : 0,
			'deleteObservation' => $this->input->post('deleteObservation') ? 1 : 0,
			'updateObservation' => $this->input->post('updateObservation') ? 1 : 0,
			'viewAllObservation' => $this->input->post('viewAllObservation') ? 1 : 0,
			
			'addQIP' => $this->input->post('addQIP') ? 1 : 0,
			'editQIP' => $this->input->post('editQIP') ? 1 : 0,
			'viewQip' => $this->input->post('viewQip') ? 1 : 0,
			'deleteQIP' => $this->input->post('deleteQIP') ? 1 : 0,
			'downloadQIP' => $this->input->post('downloadQIP') ? 1 : 0,
			'printQIP' => $this->input->post('printQIP') ? 1 : 0,
			'mailQIP' => $this->input->post('mailQIP') ? 1 : 0,
			
			'addReflection' => $this->input->post('addReflection') ? 1 : 0,
			'approveReflection' => $this->input->post('approveReflection') ? 1 : 0,
			'updatereflection' => $this->input->post('updatereflection') ? 1 : 0,
			'deletereflection' => $this->input->post('deletereflection') ? 1 : 0,
			'viewAllReflection' => $this->input->post('viewAllReflection') ? 1 : 0,
			
			'addSelfAssessment' => $this->input->post('addSelfAssessment') ? 1 : 0,
			'editSelfAssessment' => $this->input->post('editSelfAssessment') ? 1 : 0,
			'deleteSelfAssessment' => $this->input->post('deleteSelfAssessment') ? 1 : 0,
			'viewSelfAssessment' => $this->input->post('viewSelfAssessment') ? 1 : 0,
			
			'viewRoom' => $this->input->post('viewRoom') ? 1 : 0,
			'deleteRoom' => $this->input->post('deleteRoom') ? 1 : 0,
			'editRoom' => $this->input->post('editRoom') ? 1 : 0,
			'addRoom' => $this->input->post('addRoom') ? 1 : 0,
			
			'addProgramPlan' => $this->input->post('addProgramPlan') ? 1 : 0,
			'editProgramPlan' => $this->input->post('editProgramPlan') ? 1 : 0,
			'viewProgramPlan' => $this->input->post('viewProgramPlan') ? 1 : 0,
			'deleteProgramPlan' => $this->input->post('deleteProgramPlan') ? 1 : 0,
			
			'addAnnouncement' => $this->input->post('addAnnouncement') ? 1 : 0,
			'approveAnnouncement' => $this->input->post('approveAnnouncement') ? 1 : 0,
			'deleteAnnouncement' => $this->input->post('deleteAnnouncement') ? 1 : 0,
			'updateAnnouncement' => $this->input->post('updateAnnouncement') ? 1 : 0,
			'viewAllAnnouncement' => $this->input->post('viewAllAnnouncement') ? 1 : 0,
			
			'addSurvey' => $this->input->post('addSurvey') ? 1 : 0,
			'approveSurvey' => $this->input->post('approveSurvey') ? 1 : 0,
			'deleteSurvey' => $this->input->post('deleteSurvey') ? 1 : 0,
			'updateSurvey' => $this->input->post('updateSurvey') ? 1 : 0,
			'viewAllSurvey' => $this->input->post('viewAllSurvey') ? 1 : 0,
			
			'addRecipe' => $this->input->post('addRecipe') ? 1 : 0,
			'approveRecipe' => $this->input->post('approveRecipe') ? 1 : 0,
			'deleteRecipe' => $this->input->post('deleteRecipe') ? 1 : 0,
			'updateRecipe' => $this->input->post('updateRecipe') ? 1 : 0,
			
			'addMenu' => $this->input->post('addMenu') ? 1 : 0,
			'approveMenu' => $this->input->post('approveMenu') ? 1 : 0,
			'deleteMenu' => $this->input->post('deleteMenu') ? 1 : 0,
			'updateMenu' => $this->input->post('updateMenu') ? 1 : 0,
			
			'addprogress' => $this->input->post('addprogress') ? 1 : 0,
			'editprogress' => $this->input->post('editprogress') ? 1 : 0,
			'viewprogress' => $this->input->post('viewprogress') ? 1 : 0,
			
			'printpdflesson' => $this->input->post('printpdflesson') ? 1 : 0,
			'viewlesson' => $this->input->post('viewlesson') ? 1 : 0,
			'editlesson' => $this->input->post('editlesson') ? 1 : 0,
			
			'updateDailyDiary' => $this->input->post('updateDailyDiary') ? 1 : 0,
			'viewDailyDiary' => $this->input->post('viewDailyDiary') ? 1 : 0,
			'updateHeadChecks' => $this->input->post('updateHeadChecks') ? 1 : 0,
			'updateAccidents' => $this->input->post('updateAccidents') ? 1 : 0,
			
			'addUsers' => $this->input->post('addUsers') ? 1 : 0,
			'viewUsers' => $this->input->post('viewUsers') ? 1 : 0,
			'updateUsers' => $this->input->post('updateUsers') ? 1 : 0,
			
			'addCenters' => $this->input->post('addCenters') ? 1 : 0,
			'viewCenters' => $this->input->post('viewCenters') ? 1 : 0,
			'updateCenters' => $this->input->post('updateCenters') ? 1 : 0,
			
			'addParent' => $this->input->post('addParent') ? 1 : 0,
			'viewParent' => $this->input->post('viewParent') ? 1 : 0,
			'updateParent' => $this->input->post('updateParent') ? 1 : 0,
			
			'addChildGroup' => $this->input->post('addChildGroup') ? 1 : 0,
			'viewChildGroup' => $this->input->post('viewChildGroup') ? 1 : 0,
			'updateChildGroup' => $this->input->post('updateChildGroup') ? 1 : 0,
			
			'updatePermission' => $this->input->post('updatePermission') ? 1 : 0,
			'assessment' => $this->input->post('assessment') ? 1 : 0,
			'updateModules' => $this->input->post('updateModules') ? 1 : 0
		);

		// echo "<pre>";
		// print_r($data);
		// exit;

        // Check if record exists
        $this->db->where('userid', $user_id);
        $exists = $this->db->get('permissions')->num_rows();

        if ($exists) {
            // Update existing record
            $this->db->where('userid', $user_id);
            $result = $this->db->update('permissions', $data);
        } else {
            // Insert new record
            $data['userid'] = $user_id;
            $result = $this->db->insert('permissions', $data);
        }

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Permissions updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update permissions']);
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
				// echo "<pre>";
				// print_r($json);
				// exit;
				$this->load->view('assessmentSetting-newui', $json);
			} else if ($httpcode == 401){
				$json = json_decode($server_output);
				// echo "<pre>";
				// print_r($json);
				// exit;
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




public function get_centers() {
	$login_id = $this->session->userdata("LoginId");
	
	$this->db->select('c.id, c.centerName');
	$this->db->from('usercenters uc');
	$this->db->join('centers c', 'c.id = uc.centerid');
	$this->db->where('uc.userid', $login_id);
	$query = $this->db->get();
	
	echo json_encode($query->result());
}

public function get_staff_by_center() {
	$center_id = $this->input->post('center_id');
	
	$this->db->select('u.userid, u.username');
	$this->db->from('usercenters uc');
	$this->db->join('users u', 'u.userid = uc.userid');
	$this->db->where('uc.centerid', $center_id);
	$this->db->where('u.userType', 'Staff');
	$query = $this->db->get();
	
	echo json_encode($query->result());
}

public function get_permissions() {
	$user_id = $this->input->post('user_id');
	
	$this->db->select('*');
	$this->db->from('permissions');
	$this->db->where('userid', $user_id);
	$query = $this->db->get();
	
	echo json_encode($query->row());
}



	
}

/* End of file Settings.php */
/* Location: ./application/controllers/Settings.php */