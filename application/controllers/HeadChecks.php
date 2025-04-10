<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HeadChecks extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
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