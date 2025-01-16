<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Announcements extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()  
    {
	    if($this->session->has_userdata('LoginId')){
			redirect('announcements/list');
		}else{
			$this->load->view('welcome');
		} 
    }

    public function announcements_dashboard()
	{
	   	if($this->session->has_userdata('LoginId')){
 			
 			if (isset($_GET['centerid'])) {
		    	$centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
		    }else{
		    	$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
		    }

		    $data['centerid'] = $centerid;
		    $data['userid'] = $this->session->userdata('LoginId');

	   		$url = BASE_API_URL."/announcements/announcementsList/";

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				curl_close ($ch);
				$data['row']=$jsonOutput;
			    $this->load->view('announcementList',$data);
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
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$data = $this->input->post();
				$data['userid'] = $this->session->userdata('LoginId');
				$data['text'] = htmlspecialchars($data['text']);
				$url = BASE_API_URL."/announcements/createAnnouncement/";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
					'X-Token: '.$this->session->userdata('AuthToken'),
					'Content-Type:application/json'
				));
				$server_output = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if($httpcode == 200){
					curl_close ($ch);
				    $url = base_url('Announcements').'?centerid='.$centerid;
		            redirect($url);
				}
				if($httpcode == 401){
					redirect('welcome');
				}
			}else{
				if (isset($_GET['centerid'])) {
			    	$centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
			    }else{
			    	$center = $this->session->userdata("centerIds");
					$centerid = $center[0]->id;
			    }
			    $data['centerid'] = $centerid;
				$data['userid'] = $this->session->userdata('LoginId');
				$url = BASE_API_URL."Announcements/getChildRecords/";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
					'X-Token: '.$this->session->userdata('AuthToken')
				));
				$server_output = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if($httpcode == 200){
					$jsonOutput = json_decode($server_output);
					curl_close ($ch);
					$usertype = $this->session->userdata('UserType');
					if ($usertype == "Superadmin") {
						$data = [];
						$data = $jsonOutput;
						$data->Permissions = NULL;
					} else {
						$data = [];
						$data = $jsonOutput;
						$perInfo = $this->getPermission($data['userid'],$data['centerid']);
						$permissions = json_decode($perInfo);
						$data['Permissions'] = $permissions->Permissions;
					}
					$data->centerid = $centerid;
				    $this->load->view('announcementForm',$data);
				}
				
				if($httpcode == 401){
					redirect('welcome');
				}
			}
		}else{
			redirect('welcome');
		}
	}

	public function getForm()
	{
		# form for adding announcements
		if($this->session->has_userdata('LoginId')){
			$this->load->view('announcementForm');
		}else{
			redirect('welcome');
		}
	}

	public function updateAnnouncements()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');		
			$data['annId'] = $this->uri->segment(4);
	   		$url = BASE_API_URL."announcements/getAnnouncement/".$data['userid']."/".$data['annId'];
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				$childsRecords = $this->getChildRecords($jsonOutput->centerid,$data['annId']);
				$jsonOutput->Childrens = $childsRecords->Childrens;
				$jsonOutput->Groups = $childsRecords->Groups;
				$jsonOutput->Rooms = $childsRecords->Rooms;
			    $this->load->view('announcementForm',$jsonOutput);				
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function exeUpdateAnnouncements()
	{
		if($this->session->has_userdata('LoginId')){			
			$data['userid'] = $this->session->userdata('LoginId');
			$data['announcementId'] = $_POST['annId'];
			$data['title'] = $_POST['title'];
			$data['children'] = $_POST['childId'];
			$data['description'] = $_POST['text'];
			$data['date'] = $_POST['eventDate'];
	   		$url = BASE_API_URL."Announcements/updateAnnouncement/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				curl_close ($ch);
				$data=$jsonOutput;
			    $url = base_url('Announcements') . '?centerid=' . $data->centerid;
	            redirect($url);				
			}else if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function getPermission($userid='',$centerid='')
	{
		if($this->session->has_userdata('LoginId')){
			$url = BASE_API_URL."Util/getPermissions/".$userid."/".$centerid;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			if($httpcode == 200){
				return $server_output;
			}
		}else{
			redirect('welcome');
		}
	}

	public function getChildRecords($centerid='',$annId='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['centerid'] = $centerid;
			$data['annId'] = $annId;
	   		$url = BASE_API_URL."Announcements/getChildRecords/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				return $jsonOutput;	
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function list()
	{
	   	if($this->session->has_userdata('LoginId')){
 			
 			if (isset($_GET['centerid'])) {
		    	$centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
		    }else{
		    	$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
		    }

		    $data['centerid'] = $centerid;
		    $data['userid'] = $this->session->userdata('LoginId');

	   		$url = BASE_API_URL."/announcements/announcementsList/";

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			if($httpcode == 200){
				$jsonOutput = json_decode($server_output);
				$jsonOutput->centerid = $centerid;	
			    $this->load->view('announcementList_v3',$jsonOutput);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function addNew()
	{
		if($this->session->has_userdata('LoginId')){
			if (isset($_GET['centerid'])) {
		    	$centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
		    }else{
		    	$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
		    }
		    $data['centerid'] = $centerid;
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."Announcements/getChildRecords/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));

			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);			
			if($httpcode == 200){
				$jsonOutput = json_decode($server_output);
				curl_close ($ch);
				$usertype = $this->session->userdata('UserType');
				if ($usertype == "Superadmin") {
					$jsondata = [];
					$jsondata = $jsonOutput;
					$jsondata->Permissions = NULL;
				} else {
					$jsondata = $jsonOutput;
					$perInfo = $this->getPermission($data['userid'],$data['centerid']);
					$permissions = json_decode($perInfo);
					$jsondata->Permissions = $permissions->Permissions;
				}
				$jsondata->centerid = $centerid;
			    $this->load->view('announcementForm_v3',$jsondata);
			}
			
			if($httpcode == 401){ redirect('Welcome'); }

		}else{
			redirect('Welcome');
		}
	}

	public function save()
	{
		$data = $this->input->post();
		$data['userid'] = $this->session->userdata('LoginId');
		$data['text'] = htmlspecialchars($data['text']);
		$data['eventDate'] = empty($data['eventDate'])?date('Y-m-d h:i:s',strtotime(date('Y-m-d'),'+1 day')):date('Y-m-d', strtotime($data['eventDate']));
		$url = BASE_API_URL."/announcements/save";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
			'X-Token: '.$this->session->userdata('AuthToken')
		));
		$server_output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if($httpcode == 200){
			$redirect_url = base_url("Announcements/list") . "?centerid=" . $data['centerid'] . "&status=success-save";
		    redirect($redirect_url);
		}
		if($httpcode == 401){
			$redirect_url = base_url("Announcements/list") . "?centerid=" . $data['centerid'] . "&status=error-save";
		    redirect($redirect_url);
		}
	}

	public function edit($annId='')
	{
		if($this->session->has_userdata('LoginId')){
			$userid = $this->session->userdata('LoginId');
			$url = BASE_API_URL."Announcements/getAnnouncement/".$userid."/".$annId;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if($httpcode == 200){
				$jsonOutput = json_decode($server_output);
				$data = $jsonOutput;
				$usertype = $this->session->userdata('UserType');
				if ($usertype == "Superadmin") {
					$data->Permissions = NULL;
				} else {
					$perInfo = $this->getPermission($userid,$data->centerid);
					$permissions = json_decode($perInfo);
					$data->Permissions = $permissions->Permissions;
				}
				$data->announcement = $data->Info;
				$childArr = $this->getChildRecords($data->centerid,$annId);
				$data->Childrens = $childArr->Childrens;
				$data->Groups = $childArr->Groups;
				$data->Rooms = $childArr->Rooms;
			    $this->load->view('announcementForm_v3',$data);
			}
			
			if($httpcode == 401){ redirect('welcome'); }
		}else{
			redirect('welcome');
		}
	}

	public function view($annId='')
	{

		//echo $annId; exit;
		if($this->session->has_userdata('LoginId')){
			$userid = $this->session->userdata('LoginId');
			$url = BASE_API_URL."Announcements/getAnnouncement/".$userid."/".$annId;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			//print_r($server_output); exit;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if($httpcode == 200){
				$jsonOutput = json_decode($server_output);
				$data = $jsonOutput;			
			    $this->load->view('viewAnnouncement_v3',$data);
			}
			
			if($httpcode == 401){ echo $server_output; }
		}else{
			redirect('welcome');
		}
	}


	public function delete($annId='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['annId'] = $annId;
			$url = BASE_API_URL."Announcements/delete/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if($httpcode == 200){
				$jsondata = json_decode($server_output);
				$redirect_url = base_url("Announcements/list") . "?centerid=" . $jsondata->centerid . "&status=success";
			    redirect($redirect_url);
			}			
			if($httpcode == 401){ 
				$redirect_url = base_url("Announcements/list") . "?centerid=" . $jsondata->centerid . "&status=error";
			    redirect($redirect_url);
			}
		}else{
			redirect('welcome');
		}
	}

}

/* End of file announcements.php */
/* Location: ./application/controllers/announcements.php */