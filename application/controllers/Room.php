<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Room extends CI_Controller {  
      
    public function index()  
    {
		if($this->session->has_userdata('LoginId')){
			redirect('room/getList');
		}else{
			$this->load->view('welcome');
		}
    }
	
	public function add()
	{
	  if($this->session->has_userdata('LoginId')){
		if($_SERVER['REQUEST_METHOD']=='POST'){
		    $data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$data['centerid'] = $data['dcenterid'];
			$url = BASE_API_URL.'room/createRoom';
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
				$jsonOutput = json_decode($server_output);
				$redirectURL = base_url()."room/getList?centerid=".$data['centerid'];
				redirect($redirectURL);
			}else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect('room');
		}
	   }else{
		redirect('welcome');
	   }
	}

	public function addChild()
	{
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST')
			{
				$this->load->helper('form');
			    $data = $this->input->post();
				// print_r($data); exit;
				$data['userid'] = $this->session->userdata('LoginId');
				$data['image'] =($_FILES['file']['tmp_name'])?base64_encode(file_get_contents($_FILES['file']['tmp_name'])):'';
				$data['imageName'] =($_FILES['file']['name'])?$_FILES['file']['name']:'';

				$mon = isset($data['mon'])?$data['mon']:"0";
				$tue = isset($data['tue'])?$data['tue']:"0";
				$wed = isset($data['wed'])?$data['wed']:"0";
				$thu = isset($data['thu'])?$data['thu']:"0";
				$fri = isset($data['fri'])?$data['fri']:"0";

				$data['daysAttending'] = $mon.$tue.$wed.$thu.$fri;
				
				$url = BASE_API_URL.'room/createChild';
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
				//print_r($server_output); exit;
				//echo $httpcode; exit;
				if($httpcode == 200){
					$jsonOutput = json_decode($server_output);
					redirect('room/getForm?id='.$data['id'].'&centerId='.$data['centerId']);
				} else if ($httpcode == 401){
					redirect('room/getForm?id='.$data['id'].'&centerId='.$data['centerId'].'&status=error');
				}
			}else{
				redirect('room/getForm?id='.$data['id'].'&centerId='.$data['centerId']);
			}
		}else{
			redirect('welcome');
		}
	}

	public function editChild()
	{
	  if($this->session->has_userdata('LoginId')){
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->load->helper('form');
		    $data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$data['id'] = $_GET['id'];
			$data['childId'] = $_GET['childId'];
			$data['image'] =($_FILES['file']['tmp_name'])?base64_encode(file_get_contents($_FILES['file']['tmp_name'])):'';
			$data['imageName'] =($_FILES['file']['name'])?$_FILES['file']['name']:'';
			$mon = isset($data['mon'])?$data['mon']:"0";
			$tue = isset($data['tue'])?$data['tue']:"0";
			$wed = isset($data['wed'])?$data['wed']:"0";
			$thu = isset($data['thu'])?$data['thu']:"0";
			$fri = isset($data['fri'])?$data['fri']:"0";
			$data['daysAttending'] = $mon.$tue.$wed.$thu.$fri;
			$url = BASE_API_URL.'room/editChild';
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
					$jsonOutput = json_decode($server_output);
					redirect('room/getForm?id='.$_GET['id'].'&centerId='.$data['centerId']);
				  curl_close($$ch);
				}
				else if($httpcode == 401){
					return 'error';
				}
		}else{
			redirect('room/getChildForm?id='.$_GET['id'].'&childId='.$_GET['childId']);
		}
		
	   }else{
		redirect('welcome');
	   }	
	}

	public function changeStatus()
	{
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST'){
			    $data = $this->input->post();
				$data['userid'] = $this->session->userdata('LoginId');
				$url = BASE_API_URL.'room/changeStatus';
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
				print_r($server_output); exit;
			    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			    curl_close($ch);
				echo $server_output;
			}else{
				redirect('room');
			}	
		}else{
			redirect('welcome');
		}
	}

	public function deleteRoom()
	{
		if($this->session->has_userdata('LoginId')){			
			$this->load->helper('form');
		    $data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'room/deleteRoom';
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
			redirect('welcome');
		}	
	}

	public function deleteChildren()
	{
	  if($this->session->has_userdata('LoginId')){
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->load->helper('form');
		    $data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$data['id'] = $_GET['id'];
			$url = BASE_API_URL.'room/deleteChildren';
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
					$jsonOutput = json_decode($server_output);
					redirect('room/getForm?id='.$data['id']);
				  curl_close ($ch);
				}
				else if($httpcode == 401){
					return 'error';
				}
		}else{
			redirect('room');
		}
		
	   }else{
		redirect('welcome');
	   }
	}

	public function edit()
	{
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$this->load->helper('form');
			    $data = $this->input->post();
				$data['userid'] = $this->session->userdata('LoginId');
				$url = BASE_API_URL.'room/editRoom';
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
					$jsonOutput = json_decode($server_output);
					$redirect_url = base_url("room/getList?centerid=").$data['dcenterid']."&status=success";
					redirect($redirect_url);
				} else if($httpcode == 401){
					$redirect_url = base_url("room/getList?centerid=").$data['dcenterid']."&status=error";
					redirect($redirect_url);
				}
			}else{
				redirect('room');
			}
		}else{
			redirect('welcome');
		}	
	}

	public function getList()
	{	
		if($this->session->has_userdata('LoginId')){
			
	if(empty($_GET['centerid'])){
				$centers = $this->session->userdata("centerIds");
				$defCenter = $centers[0]->id;
			}else{
				$data = $this->input->get();
				$defCenter = $data['centerid'];
			}
			
	   		$filter_name=isset($_GET['filter_name'])?$_GET['filter_name']:null;
		    $url = BASE_API_URL."room/getRooms/".$this->session->userdata('LoginId')."/". $defCenter ."/".$filter_name;
			
			$ch = curl_init($url);
			$data['userType'] = $this->session->userdata("UserType");
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			//echo $httpcode; exit;
			curl_close ($ch);
			if($httpcode == 200){
				$data = [];
				$data=json_decode($server_output);
				// echo "<pre>";
				// print_r($data);
				// die;
				$data->filter_name = $filter_name;
				$data->defcenter = $defCenter;
			
				$this->load->view('room_list',$data);				
			}
			else if($httpcode == 401){
				redirect('Welcome');
			}
	   }else{
		redirect('Welcome');
	   }
	}

	public function getChildProgNotes($childId = null)
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['childid'] = $childId;
			$url = BASE_API_URL . "ProgressNotes/getChildProgressNotes";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));			
			$server_output = curl_exec($ch);
			curl_close ($ch);
			return $server_output;
		}else{
			redirect('welcome');
		}
	}

	public function getForm()
	{
		if (!$this->session->has_userdata('LoginId')) {
			redirect('welcome');
			return;
		}
	
		try {
			$id = $this->input->get('id', TRUE);
			$order = $this->input->get('order', TRUE) ?? 'ASC';
			$type = $this->input->get('type', TRUE) ?? '';
			
			// Process filter groups
			$data['filter_groups'] = !empty($_GET['filter_groups']) ? 
				explode(",", $_GET['filter_groups']) : [];
			
			// Process filter status
			$data['filter_status'] = !empty($_GET['filter_status']) ? 
				explode(",", $_GET['filter_status']) : [];
			
			// Process filter gender
			$data['filter_gender'] = !empty($_GET['filter_gender']) ? 
				explode(",", $_GET['filter_gender']) : [];
	
			$url = BASE_API_URL . "room/getRoomDetails/" . 
				   $this->session->userdata('LoginId') . "/" . $id . "/" . $order;
	
			$headers = [
				'X-Device-Id: ' . $this->session->userdata('X-Device-Id'),
				'X-Token: ' . $this->session->userdata('AuthToken')
			];
	
			$response = $this->_makeApiRequest($url, $data, $headers);
	
			if ($response['success']) {
				$jsonOutput = $response['data'];
				
				// Prepare view data
				$viewData = $this->_prepareViewData($jsonOutput, $id, $type, 
					$data['filter_groups'], $data['filter_status'], 
					$data['filter_gender'], $order);
				
				$this->load->view('room_form', $viewData);
			} else {
				// Handle different error types
				switch ($response['code']) {
					case 401:
						redirect('welcome');
						break;
					case 404:
						show_error('Room not found', 404);
						break;
					default:
						show_error($response['message'], 500);
						break;
				}
			}
		} catch (Exception $e) {
			log_message('error', 'Error in getForm: ' . $e->getMessage());
			show_error('An unexpected error occurred', 500);
		}
	}
	
	// Helper method for API requests
	private function _makeApiRequest($url, $data, $headers)
	{
		$ch = curl_init($url);
		
		curl_setopt_array($ch, [
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CONNECTTIMEOUT => 10
		]);
	
		$server_output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		if (curl_errno($ch)) {
			curl_close($ch);
			return [
				'success' => false,
				'code' => 500,
				'message' => 'Curl error: ' . curl_error($ch)
			];
		}
		
		curl_close($ch);
		
		return [
			'success' => $httpcode === 200,
			'code' => $httpcode,
			'data' => json_decode($server_output),
			'message' => $httpcode !== 200 ? 'API request failed' : ''
		];
	}
	
	// Helper method to prepare view data
	private function _prepareViewData($jsonOutput, $id, $type, $filter_groups, 
		$filter_status, $filter_gender, $order)
	{
		$data = $jsonOutput;
		$data->centerid = $jsonOutput->room->centerid;
		$data->id = $id;
		$data->type = $type;
		$data->filter_groups = $filter_groups;
		$data->filter_status = $filter_status;
		$data->filter_gender = $filter_gender;
		
		// Prepare sorting URL
		$url = '';
		if ($order == 'ASC') {
			$url .= '&order=DESC';
			$data->order = '';
		} else {
			$url .= '&order=ASC';
			$data->order = '&order=DESC';
		}
		
		if ($type) {
			$url .= '&type=filter';
		}
		
		$data->sort_name = base_url('room/getForm?id=' . $id . $url);
		
		return $data;
	}
	


	

	public function manageEducators() {
		if($this->session->has_userdata('LoginId')) {
			$roomId = $this->input->get('roomId');
			$centerId = $this->input->get('centerId');
			
			$url = BASE_API_URL."/room/getEducatorsList/".$this->session->userdata('LoginId')."/".$roomId."/".$centerId;
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			// print_r($server_output);
			// exit;
			if($httpcode == 200) {
				echo $server_output; // Return the API response directly
			} else {
				echo json_encode(['error' => 'Failed to fetch educators']);
			}
			curl_close($ch);
		}
	}
	
	public function updateEducators() {
		if($this->session->has_userdata('LoginId')) {
			$roomId = $this->input->post('roomId');
			$selectedStaff = $this->input->post('selectedStaff');
			
			$url = BASE_API_URL."/room/updateEducatorsList";
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
				'roomId' => $roomId,
				'selectedStaff' => $selectedStaff,
				'userId' => $this->session->userdata('LoginId')
			]));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
			if($httpcode == 200) {
				echo $server_output;
			} else {
				echo json_encode(['error' => 'Failed to update educators']);
			}
			curl_close($ch);
		}
	}







	public function getRoom()
	{
	   if($this->session->has_userdata('LoginId')){

		    $id=isset($_GET['id'])?$_GET['id']:NULL;

		    $url = BASE_API_URL."/room/getRoomDetails/".$this->session->userdata('LoginId')."/".$id;
			$ch = curl_init($url);
			
			curl_setopt($ch, CURLOPT_URL,$url);
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
				$data->id=$id;
			    $this->load->view('room_popup',$data);				
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
			
	   }else{
		redirect('welcome');
	   }
	}

	public function getRoomDetails($id='')
	{
		if($this->session->has_userdata('LoginId')){
			$url = BASE_API_URL."/room/getRoomDetails/".$this->session->userdata('LoginId')."/".$id;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$jsonOutput = json_decode($server_output);
			if($httpcode == 200){
				unset($jsonOutput->groups);
				unset($jsonOutput->roomChilds);
				unset($jsonOutput->users);
				$educators = [];
				$demoEducator = [];
				foreach ($jsonOutput->roomStaff as $staffkey => $staffval) {
					$demoEducator['id'] = $staffval->userId;
					$demoEducator['text'] = $staffval->userName;
					array_push($educators,$demoEducator);
				}
				unset($jsonOutput->roomStaff);
				$jsonOutput->educators = $educators;
				echo json_encode($jsonOutput);
			}else{
				$data = [];
				$data['Status'] = "ERROR";
				$data['Message'] = $jsonOutput->Message;
				echo json_encode($data);
			}
			
		}else{
			redirect('welcome');
	    }
	}

	public function getChildForm()
	{
	   if($this->session->has_userdata('LoginId')){
		    $data = [];
			$id=isset($_GET['id'])?$_GET['id']:null;
			$childId=isset($_GET['childId'])?$_GET['childId']:null;
			$centerid=isset($_GET['centerid'])?$_GET['centerid']:null;
		    $url = BASE_API_URL."room/getChildForm/".$this->session->userdata('LoginId')."/".$id."/".$childId."/".$centerid;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				curl_close($ch);
				$data=$jsonOutput;
				if(!empty($data))
				{
					$data->id=$id;
					$data->childId=$childId;
				}else{
					$data['id']=$_GET['id'];
					$data['childId']='';
				}

			    if(isset($data->child->imageUrl) && $data->child->imageUrl)
				{
					$name=base_url('/api/assets/media/'.$data->child->imageUrl);
					$data->child->imageUrl=$name;
				}

				$childData = $this->getChildProgNotes($childId);
				$child_arr = json_decode($childData);
				$data->child_arr = $child_arr->records;
				$data->centerid = $jsonOutput->centerid;
			    $this->load->view('child_form',$data);
			}
			else if($httpcode == 401){
				redirect('welcome');
			}			
	   }else{
		redirect('welcome');
	   }		
	}

	public function loadRooms($userid,$roomId)
	{
		if($this->session->has_userdata('LoginId')){
			$url = BASE_API_URL."/room/getRoomsExcept/".$userid."/".$roomId;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$data = json_decode($server_output);
			echo json_encode($data);
		}else{
			$data = [];
			$data['Status'] = "Error!";
			$data['Message'] = "User id is invalid!";
			echo json_encode($data);
		}
	}

	public function moveChilds()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$roomid = $data['rooms'];
			$childrens = [];
			foreach ($data['childid'] as $childId => $ch) {
				$d['childid'] = $ch;
				$d['roomid'] = $data['rooms'];
				array_push($childrens,$d);
			}
			$data['children'] = $childrens;
			$data['userid'] = $this->session->userdata('LoginId');
			unset($data['childid']);
			unset($data['rooms']);
			$url = BASE_API_URL."Children/moveChildren/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			//print_r($server_output); exit;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				curl_close($ch);
				$rurl = base_url()."Room/getForm?id=".$roomid;
				redirect($rurl);
			}
			if($httpcode == 200){
				redirect("Welcome");
			}
		}else{
			redirect("Welcome");
		}
	}

	public function deleteProgressNote()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."ProgressNotes/deleteProgressNote/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			echo $server_output;
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Login error";
			echo json_encode($data);
		}
	}

	public function updateProgressNote()
	{
		if($this->session->has_userdata('LoginId')){
			$this->load->helper('form');
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."ProgressNotes/updateProgressNote/";
			$data['pnid'] = $data['updatingId'];
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_URL,$url);
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
				$rurl = base_url()."Room/getChildForm?id=".$data['id']."&childId=".$data['childid']."&centerId=".$data['centerid'];
				redirect($rurl);
			}
			if($httpcode == 200){
				redirect("welcome");
			}
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Login error";
			echo json_encode($data);
		}
	}

	public function addProgressNote()
	{
		if($this->session->has_userdata('LoginId')){
			$this->load->helper('form');
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."ProgressNotes/addProgressNote/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				curl_close($ch);
				$rurl = base_url()."Room/getChildForm?id=".$data['id']."&childId=".$data['childid']."&centerId=".$data['centerid'];
				redirect($rurl);
			}
			if($httpcode == 200){
				redirect("welcome");
			}
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Login error";
			echo json_encode($data);
		}
	}

	public function roomList()
	{	
		if($this->session->has_userdata('LoginId')){			
			if(empty($_GET['centerId'])){
				$centers = $this->session->userdata("centerIds");
				$defCenter = $centers[0]->id;
			}else{
				$data = $this->input->get();
				$defCenter = $data['centerId'];
			}
	   		$filter_name=isset($_GET['filter_name'])?$_GET['filter_name']:null;
		    $url = BASE_API_URL."room/getRooms/".$this->session->userdata('LoginId')."/". $defCenter ."/".$filter_name;
			$ch = curl_init($url);
			$data['userType'] = $this->session->userdata("UserType");
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
				$data = [];
				$data=json_decode($server_output);
				$data->filter_name=$filter_name;
				$data->defcenter = $defCenter;
			    $this->load->view('roomsList_v3',$data);				
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
	   }else{
		redirect('welcome');
	   }
	}

	public function delete($roomid = NULL)
	{
		if($this->session->has_userdata('LoginId')){
			$this->load->helper('form');
			$data['roomid']= $roomid;
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."room/deleteSingleRoom/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			echo $server_output;
		}else{
			redirect("Welcome");
		}
	}

	public function deleteChilds()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['childids']= json_decode($data['childids']);
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."room/deleteChilds/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			echo $server_output;
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Session timeout! Please relogin and try again.";
			echo json_encode($data);
		}
	}

}  
?>
