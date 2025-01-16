<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProgressNotes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->session->has_userdata("LoginId")) {
			//Check centerid 
			if (isset($_GET['centerid'])) {
		    	$centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
		    }else{
		    	$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
		    }
			
		    $data['userid'] = $this->session->userdata('LoginId');
		    $data['centerid'] = $centerid;

		    $url = BASE_API_URL."ProgressNotes/get/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);

			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			if ($httpcode=="200") {
				$data = json_decode($server_output);
				$this->load->view("progressNotes",$data);
			} else {
				redirect('Welcome');
			}
		}else{
			redirect('Welcome');
		}
	}

	public function edit()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $_POST;
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL."ProgressNotes/edit/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($httpcode=="200") {
				redirect("progressNotes");
			} else {
				$data["Status"] = "ERROR";
				$data["Message"] = "Something went wrong!";
				echo json_encode($data);
			}
		} else {
			redirect('Welcome');
		}
	}

	public function update($userid="",$id="")
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data["userid"] = $this->session->userdata("LoginId");
			$data["id"] = $id;
			$url = BASE_API_URL."ProgressNotes/update/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($httpcode=="200") {
				echo $server_output;
			} else {
				$data["Status"] = "ERROR";
				$data["Message"] = "Something went wrong!";
				echo json_encode($data);
			}
			
		} else {
			$data["Status"] = "ERROR";
			$data["Message"] = "Please relogin to get the data!";
			echo json_encode($data);
		}
	}

	public function delete($userid="",$id="")
	{
		if ($this->session->has_userdata("LoginId")) {
			$data["userid"] = $this->session->userdata("LoginId");
			$data["id"] = $id;
			$url = BASE_API_URL."ProgressNotes/delete/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			echo $server_output;			
		} else {
			$data["Status"] = "ERROR";
			$data["Message"] = "Please relogin to get the data!";
			echo json_encode($data);
		}
	}

	// public function saveImageTags()
	// {
	// 	if ($this->session->has_userdata("LoginId")) {
	// 		$data = $this->input->post();
	// 		$data['tags'] = [];
	// 		$data["userid"] = $this->session->userdata("LoginId");
	// 		$data['childTags'] = json_decode($data['childTags']);
	// 		$data['staffTags'] = json_decode($data['staffTags']);
	// 		$cts = [];
	// 		foreach ($data['childTags'] as $childtags => $ct) {
	// 			$cts['usertype'] = "child";
	// 			$cts['mediaid'] = $data['mediaId'];
	// 			$cts['userid'] = $ct;
	// 			array_push($data['tags'],$cts);
	// 		}
	// 		$sts = [];
	// 		foreach ($data['staffTags'] as $stafftags => $st) {
	// 			$sts['usertype'] = "staff";
	// 			$sts['mediaid'] = $data['mediaId'];
	// 			$sts['userid'] = $st;
	// 			array_push($data['tags'],$sts);
	// 		}
	// 		unset($data['childTags']);
	// 		unset($data['staffTags']);
	// 		$url = BASE_API_URL."Media/saveImageTags/";


	// 		$ch = curl_init($url);
	// 		curl_setopt($ch, CURLOPT_URL,$url);
	// 		curl_setopt($ch, CURLOPT_POST, 1);
	// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
	// 		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	// 			'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
	// 			'X-Token: '.$this->session->userdata('AuthToken')
	// 		));
	// 		$server_output = curl_exec($ch);
	// 		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	// 		curl_close($ch);
	// 		if ($httpcode=="200") {
	// 			echo $server_output;
	// 		} else {
	// 			$data["Status"] = "ERROR";
	// 			$data["Message"] = "Something went wrong!";
	// 			echo json_encode($data);
	// 		}
			
	// 	} else {
	// 		$data["Status"] = "ERROR";
	// 		$data["Message"] = "Please relogin to get the data!";
	// 		echo json_encode($data);
	// 	}
	// }

}

/* End of file Media.php */
/* Location: ./application/controllers/Media.php */