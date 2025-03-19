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
			// echo "<pre>";
			// print_r($jsonOutput);
			// exit;
			$this->load->view('viewAccident', $jsonOutput);
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Pls relogin into your account!";
			echo json_encode($data);
		}
	}


	public function send_email() {
		// Check if it's an AJAX request
		if (!$this->input->is_ajax_request()) {
			show_error('No direct script access allowed');
		}
	
		// Get the POST data
		$post_data = json_decode(file_get_contents('php://input'), true);
	
		if (!isset($post_data['html_content']) || !isset($post_data['student_id'])) {
			$response = [
				'success' => false,
				'message' => 'Missing required parameters'
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
			return;
		}
	
		// Get student data and parent email
		$childId = $post_data['student_id'];
	$this->load->database();
		// Get parent IDs from "childparent" table
		$this->db->select('parentid');
		$this->db->from('childparent');
		$this->db->where('childid', $childId);
		$query = $this->db->get();
		$parentIds = array_column($query->result_array(), 'parentid');
	
		if (empty($parentIds)) {
			$response = [
				'success' => false,
				'message' => 'No parent found for the given student ID'
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
			return;
		}
	
		// Get email IDs from "users" table where userid matches parentid
		$this->db->select('emailid');
		$this->db->from('users');
		$this->db->where_in('userid', $parentIds);
		$emailQuery = $this->db->get();
		$emailIds = array_column($emailQuery->result_array(), 'emailid');
	
		if (empty($emailIds)) {
			$response = [
				'success' => false,
				'message' => 'No email found for the parent(s)'
			];
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
			return;
		}
	
		// Generate PDF using mPDF library
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		$pdf->SetTitle('Student Report');
		$pdf->WriteHTML($post_data['html_content']);
	
		// Save the PDF to a temporary file
		$pdf_filename = 'student_report_' . $childId . '_' . date('Ymd_His') . '.pdf';
		$pdf_path = FCPATH . 'uploads/reports/' . $pdf_filename;
	
		// Make sure the directory exists
		if (!file_exists(FCPATH . 'uploads/reports/')) {
			mkdir(FCPATH . 'uploads/reports/', 0777, true);
		}
	
		$pdf->Output($pdf_path, 'F');
	
		// Load email library
		$this->load->library('email');
	
		$emailSentCount = 0;
		foreach ($emailIds as $email) {
			$this->email->clear(TRUE); // Clear previous email settings
			$this->email->from('mydairee47@gmail.com', 'Accident Report');
			$this->email->to($email);
			$this->email->subject('Student Report - ' . $childId);
			$this->email->message('Please find attached the latest report for student ID: ' . $childId);
			$this->email->attach($pdf_path);
	
			if ($this->email->send()) {
				$emailSentCount++;
				log_message('info', 'Email sent to: ' . $email);
			} else {
				log_message('error', 'Failed to send email to: ' . $email . ' - ' . $this->email->print_debugger());
			}
		}
	
		// Delete the PDF file after sending emails
		unlink($pdf_path);
	
		if ($emailSentCount > 0) {
			$response = [
				'success' => true,
				'message' => 'Report sent successfully to ' . $emailSentCount . ' parent(s)'
			];
		} else {
			$response = [
				'success' => false,
				'message' => 'Failed to send emails'
			];
		}
	
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	

}

/* End of file Accident.php */
/* Location: ./application/controllers/Accident.php */