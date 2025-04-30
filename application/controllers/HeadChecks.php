<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HeadChecks extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database(); 
	}

	public function index()
	{
		if($this->session->has_userdata('LoginId')){
			if(!empty($this->input->get())){
				$data = $this->input->get();
			} else {
				$data = [];
			}
			$data['userid'] = $this->session->userdata("LoginId");	
			$url = BASE_API_URL.'HeadChecks/getHeadChecks';
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
				// echo "<pre>";
				// print_r($data);
				// exit;
				$this->load->view('HeadChecksView',$data);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("welcome");
		}
	}


	public function sleepchecklistindex(){
		if($this->session->has_userdata('LoginId')){
			if(!empty($this->input->get())){
				$data = $this->input->get();
			} else {
				$data = [];
			}

			// echo "<pre>";
			// print_r($data);
			// exit;
			$data['userid'] = $this->session->userdata("LoginId");	
			$url = BASE_API_URL.'HeadChecks/getsleepChecks';
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
				// echo "<pre>";
				// print_r($data);
				// exit;
				$this->load->view('sleepchecklist',$data);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("welcome");
		}
	}

	public function sleep_checklist_save() {
		// Get the input data
		$input = $this->input->post();

		

		// 	echo "<pre>";
		// print_r($input);
		// exit;
		
		// Validate required fields (adjust as needed)
		if (empty($input['childid']) || empty($input['diarydate']) || empty($input['time'])) {
			echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
			return;
		}

		$input['diarydate'] = str_replace('-', '/', $input['diarydate']);
		$date = DateTime::createFromFormat('d/m/Y', $input['diarydate']);
		$mysqlDate = $date ? $date->format('Y-m-d') : null;



	
		// Prepare data for insertion
		$data = [
			'childid' => $input['childid'],
			'diarydate' => $mysqlDate,
			'roomid' => $input['roomid'],
			'time' => $input['time'],
			'breathing' => $input['breathing'] ?? null, // Use null if not provided
			'body_temperature' => $input['body_temperature'] ?? null,
			'notes' => $input['notes'] ?? null,
			'createdBy' => $this->session->userdata('LoginId'), // Assuming you're using session
			'created_at' => date('Y-m-d H:i:s')
		];
	

		// echo "<pre>";
		// print_r($data);
		// exit;
		// Insert into database
		$this->db->insert('dailydiarysleepchecklist', $data);
		
		// Check if insertion was successful
		if ($this->db->affected_rows() > 0) {
			echo json_encode(['success' => true, 'message' => 'Saved successfully']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to save']);
		}
	}


	public function sleep_checklist_update() {
		$input = $this->input->post();
	
		if (empty($input['id']) || empty($input['childid']) || empty($input['diarydate']) || empty($input['time'])) {
			echo json_encode(['success' => false, 'message' => 'Required fields are missing']);
			return;
		}
	
		// $input['diarydate'] = str_replace('-', '/', $input['diarydate']);
		// $mysqlDate = date('Y-d-m', strtotime($input['diarydate']));

		$input['diarydate'] = str_replace('-', '/', $input['diarydate']);
		$date = DateTime::createFromFormat('d/m/Y', $input['diarydate']);
		$mysqlDate = $date ? $date->format('Y-m-d') : null;
	
		$data = [
			'childid' => $input['childid'],
			'diarydate' => $mysqlDate,
			'roomid' => $input['roomid'],
			'time' => $input['time'],
			'breathing' => $input['breathing'] ?? null,
			'body_temperature' => $input['body_temperature'] ?? null,
			'notes' => $input['notes'] ?? null
			// 'updatedBy' => $this->session->userdata('LoginId'),
			// 'updated_at' => date('Y-m-d H:i:s')
		];
	
		$this->db->where('id', $input['id']);
		$this->db->update('dailydiarysleepchecklist', $data);
	
		if ($this->db->affected_rows() > 0) {
			echo json_encode(['success' => true, 'message' => 'Updated successfully']);
		} else {
			echo json_encode(['success' => false, 'message' => 'No changes made or update failed']);
		}
	}


	public function sleep_checklist_delete() {
		$id = $this->input->post('id');
	
		if (empty($id)) {
			echo json_encode(['success' => false, 'message' => 'Invalid ID']);
			return;
		}
	
		$this->db->where('id', $id);
		$this->db->delete('dailydiarysleepchecklist');
	
		if ($this->db->affected_rows() > 0) {
			echo json_encode(['success' => true, 'message' => 'Deleted successfully']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to delete or already removed']);
		}
	}
	
	


	public function addHeadChecks()
	{
		if($this->session->has_userdata('LoginId')){
			$post = $this->input->post();
			$data = [];
			$data['userid'] = $this->session->userdata("LoginId");
			$data['headcounts'] = [];
			$post['diarydate'] = str_replace("/", "-", $post['diarydate']);
			$count = count($post['hour']);
			for($i=0; $i < $count ; $i++){ 
				$d['time'] = $post['hour'][$i]."h:".$post['mins'][$i]."m";
				$d['diarydate'] = date('Y-m-d',strtotime($post['diarydate']));
				$d['headCount'] = $post['headCount'][$i];
				$d['signature'] = $post['signature'][$i];
				$d['comments'] = $post['comments'][$i];
				$d['roomid'] = $post['roomid'];
				$d['centerid'] = $post['centerid'];
				$d['createdBy'] = $this->session->userdata("LoginId");
				$d['createdAt'] = date('Y-m-d h:i:s');
				array_push($data['headcounts'],$d);
			}
			
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'HeadChecks/addHeadChecks';
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
				$retUrl = base_url()."HeadChecks?roomid=".$post['roomid']."&date=".$post['diarydate']."&centerid=".$post['centerid'];
				redirect($retUrl);
			}
			else if($httpcode == 401){
				return 'error';
			}

		}else{
			redirect("welcome");
		}
	}
}

/* End of file HeadChecks.php */
/* Location: ./application/controllers/HeadChecks.php */