<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Media extends CI_Controller {

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
				$centerid = $center[0]->id; //default center
		    }

		    $data['userid'] = $this->session->userdata('LoginId');
		    $data['centerid'] = $centerid;

		    $url = BASE_API_URL."media/index/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			$server_output = curl_exec($ch);
			//print_r($server_output); exit;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			if ($httpcode=="200") {
				$data = [];
				$data = json_decode($server_output);
				$data->centerid = $centerid;
				
				$this->load->view("mediaList_v4",$data);
			} else {
				redirect('Welcome');
			}
		}else{
			redirect('Welcome');
		}
	}

	public function fileUpload()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $_POST;

			if (!empty($_FILES['fileUpload']['name'])) {
				$countFiles = count($_FILES['fileUpload']['name']);
				for ($i=0; $i < $countFiles ; $i++) { 
					$data['media'.$i] = new CurlFile($_FILES['fileUpload']['tmp_name'][$i],$_FILES['fileUpload']['type'][$i],$_FILES['fileUpload']['name'][$i]);

					if (isset($data['childTags'.$i])) {
						$data['childTags'.$i] = json_encode($data['childTags'.$i]);
					}

					if (isset($data['eduTags'.$i])) {
						$data['eduTags'.$i] = json_encode($data['eduTags'.$i]);
					}
				}
			}
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL."Media/uploadFiles/";
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
				redirect("Media");
			} else {
				$data["Status"] = "ERROR";
				$data["Message"] = "Something went wrong!";
				echo json_encode($data);
			}
		} else {
			redirect('Welcome');
		}
	}

	public function getTagsArr()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data["userid"] = $this->session->userdata("LoginId");
			$url = BASE_API_URL."Media/getTagsArr/";
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

	public function deleteMedia($mediaId="")
	{
		if ($this->session->has_userdata("LoginId")) {
			$data["userid"] = $this->session->userdata("LoginId");
			$data["mediaid"] = $mediaId;
			$url = BASE_API_URL."Media/deleteMedia/";
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
			print_r($server_output); exit;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			echo $server_output;			
		} else {
			$data["Status"] = "ERROR";
			$data["Message"] = "Please relogin to get the data!";
			echo json_encode($data);
		}
	}

	public function saveImageTags()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['tags'] = [];
			$data["userid"] = $this->session->userdata("LoginId");
			$data['childTags'] = json_decode($data['childTags']);
			$data['staffTags'] = json_decode($data['staffTags']);
			$cts = [];
			foreach ($data['childTags'] as $childtags => $ct) {
				$cts['usertype'] = "child";
				$cts['mediaid'] = $data['mediaId'];
				$cts['userid'] = $ct;
				array_push($data['tags'],$cts);
			}
			$sts = [];
			foreach ($data['staffTags'] as $stafftags => $st) {
				$sts['usertype'] = "staff";
				$sts['mediaid'] = $data['mediaId'];
				$sts['userid'] = $st;
				array_push($data['tags'],$sts);
			}
			unset($data['childTags']);
			unset($data['staffTags']);
			$url = BASE_API_URL."Media/saveImageTags/";
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

	public function test($value='')
	{
		echo phpinfo();
	}

	public function getMediaInfo()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
		    $data['userid'] = $this->session->userdata('LoginId');
		    $url = BASE_API_URL."media/getMediaInfo/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			echo $server_output;
		}else{
			redirect('Welcome');
		}
	}

	public function uploadFiles()
	{
		if ($this->session->has_userdata("LoginId")) {
			if (isset($_FILES['file']['tmp_name'])) {
				$data = $this->input->post();
				$data['media'] = new CurlFile($_FILES['file']['tmp_name'],$_FILES['file']['type'],$_FILES['file']['name']);
				$data['userid'] =  $this->session->userdata("LoginId");
				$url = BASE_API_URL."Media/uploadFile/";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
					'X-Token: '.$this->session->userdata('AuthToken')
				));
				$server_output = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				echo $server_output;
			}else{
				return null;
			}
		}else{
			return null;
		}
	}
	
	public function storeImageTags()
	{
		if ($this->session->has_userdata("LoginId")) {
			$data = $this->input->post();
			$data['tags'] = [];
			$data["userid"] = $this->session->userdata("LoginId");

			$cts = [];
			if (!empty($data['childTags'])) {
				foreach ($data['childTags'] as $childtags => $ct) {
					$cts['usertype'] = "child";
					$cts['mediaid'] = $data['mediaId'];
					$cts['userid'] = $ct;
					array_push($data['tags'],$cts);
				}
			}
			
			$sts = [];
			if(!empty($data['staffTags'])){
				foreach ($data['staffTags'] as $stafftags => $st) {
					$sts['usertype'] = "staff";
					$sts['mediaid'] = $data['mediaId'];
					$sts['userid'] = $st;
					array_push($data['tags'],$sts);
				}
			}
			
			unset($data['childTags']);
			unset($data['staffTags']);

			$url = BASE_API_URL."Media/saveImageTags/";
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

}

/* End of file Media.php */
/* Location: ./application/controllers/Media.php */