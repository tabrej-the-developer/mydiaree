<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
   
class Qip extends CI_Controller {  
      
    public function index()  
    {
		if($this->session->has_userdata('LoginId')){
			$this->getList();
		}else{
			redirect('welcome');
		}         
    }

	public function view()  
    {    
		// if($this->session->has_userdata('LoginId')){
		// 	$data = $this->input->get();
		// 	if (empty($data['qipid']) || empty($data['areaid'])) {
		// 		redirect('Qip');
		// 	}
		// 	$data['userid'] = $this->session->userdata('LoginId');
		// 	$url = BASE_API_URL.'qip/viewStandard/';
		// 	$ch = curl_init($url);
		// 	curl_setopt($ch, CURLOPT_URL,$url);
		// 	curl_setopt($ch, CURLOPT_POST, 1);
		// 	curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
		// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		// 		'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
		// 		'X-Token: '.$this->session->userdata('AuthToken')
		//     ));
		// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// 	$server_output = curl_exec($ch);
		//     $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//     curl_close ($ch);
		//     $jsonOutput = json_decode($server_output);
		// 	// getting comments for qiparea
		// 	$discss = $this->getQipDiscussion($data['qipid'],$data['areaid']);
		// 	$discussion = json_decode($discss);
		// 	$jsonOutput->discussion = isset($discussion->Comments)?$discussion->Comments:NULL;
		// 	$this->load->view('standardAndElement',$jsonOutput);
		// }   

		if ($this->session->has_userdata('LoginId')) {
			$data = $this->input->get();
			
			// Check if required parameters are present
			if (empty($data['qipid']) || empty($data['areaid'])) {
				redirect('Qip');
			}
		
			// Adding user ID to the data
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL . 'qip/viewStandard/';
			
			// Initialize CURL
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: ' . $this->session->userdata('X-Device-Id'),
				'X-Token: ' . $this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			// Execute the CURL request
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			
			// Decode the JSON output
			$jsonOutput = json_decode($server_output);
		
			// Check for errors in the CURL execution
			if ($httpcode !== 200 || json_last_error() !== JSON_ERROR_NONE) {
				log_message('error', 'CURL request failed or invalid JSON: HTTP Code - ' . $httpcode . ', Response - ' . $server_output);
				$jsonOutput = null; // Handle this as necessary
			}
		
			// Getting comments for QIP area
			$discss = $this->getQipDiscussion($data['qipid'], $data['areaid']);
		
			// Decode the discussion output and check for errors
			if ($discss && is_string($discss)) {
				$discussion = json_decode($discss);
				if (json_last_error() !== JSON_ERROR_NONE) {
					log_message('error', 'JSON decode error for discussion: ' . json_last_error_msg());
					$discussion = null; // Handle JSON decode error
				}
			} else {
				log_message('error', 'getQipDiscussion returned null or non-string value');
				$discussion = null; // Handle the case when $discss is null
			}
		
			// Assign discussion comments to jsonOutput
			$jsonOutput->discussion = isset($discussion->Comments) ? $discussion->Comments : null;
		
			// Load the view with the output
			$this->load->view('standardAndElement', (array)$jsonOutput); // Casting to array in case jsonOutput is null
		} else {
			// Redirect or handle the case where the user is not logged in
			redirect('Login'); // or any other action
		}
		

    }

    public function editStandards()
    {
    	if($this->session->has_userdata('LoginId')){
			$data = $this->input->get();
			if (empty($data['stdid']) || empty($data['qipid'])) { redirect('Qip'); }
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'qip/getStandardDetails/';
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
		    $jsonOutput = json_decode($server_output);
		    if ($httpcode == 200) {
		    	$this->load->view('editStandard',$jsonOutput);
		    }else{
		    	redirect("Qip");
		    }
		} 
    }

    public function editQIP()  
    {
		if($this->session->has_userdata('LoginId')){
            $this->load->view('editStandardAndElement');
		}else{
			redirect('welcome');
		}         
    }

	public function delete()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'qip/delete/'.$data['userid'].'/'.$_GET['id'];
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
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
				$urlqip = base_url('Qip')."?centerid=".$jsonOutput->Centerid;
				redirect($urlqip);
			}else if($httpcode == 401){
				return 'error';
			}
		}
	}

	public function add()
	{

		// echo "text"; exit;
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST')
			{
				$this->load->helper('form');
			    $data = $this->input->post();
				$data['userid'] = $this->session->userdata('LoginId');
				$url = BASE_API_URL.'qip/createQIP';
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
					curl_close($ch);
					redirect('qip');
				}
				else if($httpcode == 401){
					return 'error';
				}
			}else{
				$this->getForm();
			}
		}else{
			redirect('welcome');
		}
	}

	public function edit()
	{
		if($this->session->has_userdata('LoginId')){
			$this->getForm();
		}else{
			redirect('welcome');
		}
	}

	public function download()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'qip/getQipDetils/'.$data['userid'].'/'.$_GET['id'];
			$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
									'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
									'X-Token: '.$this->session->userdata('AuthToken')
			    ));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
				$server_output = curl_exec($ch);
				
			    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if($httpcode == 200){
					$jsonOutput = json_decode($server_output);
					$data=$jsonOutput;
					$this->load->library('M_pdf');
					$mpdf = $this->m_pdf->load([
					   'mode' => 'utf-8',
					   'format' => 'A4'
					]);
					
					$html = $this->load->view('qip_pdf',$data,true);
					$mpdf->WriteHTML($html);
					
                    $mpdf->Output();
        
				  curl_close ($ch);
				}
				else if($httpcode == 401){
					return 'error';
				}
		}
	}

	public function pdfPrint($userid,$data){
		$url = BASE_API_URL.'qip/printPDF/'.$userid;
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
			return $jsonOutput;
		}else{

		}
	}

	public function printPdf()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$userid = $data['userid'];
			$post = $this->input->post();
			$url = BASE_API_URL.'qip/getQipDetils/'.$data['userid'].'/'.$_GET['id'];
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
				$data=$jsonOutput;
				$data->areas = isset($post['areas']) ? $post['areas'] : array();
				$data->pn = isset($post['plan']) ? $post['plan'] : array();
				$data->sta = isset($post['sta']) ? $post['sta'] : array();
				$output = $this->pdfPrint($userid,$data);
				$filename = $output->FileName;
				redirect('assets/'.$filename);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}
	}

	public function qipEmail($userid,$data)
	{
		$url = BASE_API_URL.'qip/emailQIP/'.$userid;
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
		}
	}

	public function email()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$userid = $data['userid'];
			$post = $this->input->post();
			$url = BASE_API_URL.'qip/getQipDetils/'.$data['userid'].'/'.$_GET['id'];
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput = json_decode($server_output);
				$data=$jsonOutput;
				$data->areas=isset($post['areas'])?$post['areas']:array();
				$data->pn=isset($post['plan'])?$post['plan']:array();
				$data->sta=isset($post['sta'])?$post['sta']:array();
				$data->email = isset($post['email'])?$post['email']:null ;
				$this->qipEmail($userid,$data);
				curl_close ($ch);
			}else if($httpcode == 401){
				return 'error';
			}
		}
	}

	public function getList($json = 0)
	{
	   if($this->session->has_userdata('LoginId')){

		   	if (isset($_GET['centerid'])) {
		    	$centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
		    }else{
		    	$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
		    }
		    $url = BASE_API_URL."qip/getQips/".$this->session->userdata('LoginId')."/".$centerid;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			
			if ($json==0) {
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				if($httpcode == 200){
					$jsonOutput = json_decode($server_output);
					$jsonOutput->centerid = $centerid;
				    $this->load->view('qip_list', $jsonOutput);
				}
				else if($httpcode == 401){
					redirect('welcome');
				}
			}else{
				echo $server_output;
			}
	   }else{
		redirect('welcome');
	   }
	}

	public function getForm()
	{
	   if($this->session->has_userdata('LoginId')){
	   	
		    $id=isset($_GET['id'])?$_GET['id']:null;

		    if (isset($_GET['centerid'])) {
		    	$centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
		    }else{
		    	$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
		    }

		    $url = BASE_API_URL."qip/getQipForm/".$this->session->userdata('LoginId')."/".$centerid."/".$id;
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
			$jsonOutput=json_decode($server_output);
			if($httpcode == 200){
				if ($jsonOutput->Status == "SUCCESS") {
					$jsonOutput->id = $id;
					$jsonOutput->centerid = $centerid;
					$this->load->view('qip_form', $jsonOutput);
				}else{
					redirect("Qip");
				}
			}
			else if($httpcode == 401){
				redirect('Welcome');
			}			
	   }else{
			redirect('Welcome');
	   }	
	}

	public function getAreaDetails()
	{
		if($this->session->has_userdata('LoginId')){
		    $userid = $this->session->userdata('LoginId');
			$id=$_GET['id'];
			$qipId=$_GET['qipId'];
		    $url = BASE_API_URL.'qip/getAreaDetails/'.$userid.'/'.$id.'/'.$qipId;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
		    ));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				print_r($server_output);
			}
		}
	}

	//A whole new way of managing QIP by Todquest
	
	public function addNewQip()
	{

		// echo "add qigfdgp"; exit;
		if($this->session->has_userdata('LoginId')){

			if (isset($_GET['centerid'])) {
				$data['centerid'] = $_GET['centerid'];
			}else{
				redirect("Qip");
			}
			
			$data['userid'] = $this->session->userdata('LoginId');
		    $url = BASE_API_URL.'qip/addNewQip/';
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
			$jsonOutput = json_decode($server_output);
			// print_r($jsonOutput);
			// exit;
			if($httpcode == 200){
				if ($jsonOutput->Status == "SUCCESS") {
					$this->session->set_flashdata('success', 'New Qip Added!');
					$urlqip = base_url('qip/')."edit?id=".$jsonOutput->id."&centerid=".$jsonOutput->Centerid;
					// $urlqip = base_url('Qip')."?centerid=".$jsonOutput->Centerid;
					redirect($urlqip);
				}else{
					echo $jsonOutput->Message;
				}
			}else{
				echo $jsonOutput->Message;
			}			
		}else{
			redirect("Welcome");
		}
	}

	public function renameQip()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();			
			$data['userid'] = $this->session->userdata('LoginId');
		    $url = BASE_API_URL.'Qip/renameQip/';
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
	
	public function getQipDiscussion($qipid='',$areaid='',$ajax='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['qipid'] = $qipid;
			$data['areaid'] = $areaid;
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'qip/viewDiscussions/';
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
				if ($ajax==1) {
					echo $server_output;
				} else {
					return $server_output;
				}
			}else if($httpcode == 401){
				return NULL;
			}
		}else{
			redirect("Welcome");
		}
	}

	public function addComment()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'qip/addComment/';
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
				echo $server_output;
			}else if($httpcode == 401){
				echo NULL;
			}
		}else{
			redirect("Welcome");
		}
	}

	public function getAreaStandards()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'qip/getAreaStandards/';
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

	public function getStandardElements()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'qip/getStandardElements/';
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

	public function updateQipStandard()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'qip/updateQipStandard/';
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
			$jsonOutput = json_decode($server_output);
			if ($jsonOutput->Status == "SUCCESS") {
				$url = base_url("Qip/editStandards")."?centerid=".$data['centerid']."&stdid=".$data['stdid']."&qipid=".$data['qipid']."&areaid=".$data['areaid']."&status=success";
				redirect($url);
			}else{
				redirect("Qip");
			}
		}else{
			redirect("Welcome");
		}
	}

	public function getPublishedObservations($centerid='',$qipid='',$elementid='')
	{
		if($this->session->has_userdata('LoginId')){
			$url = BASE_API_URL."Qip/getAllPublishedObservations/".$this->session->userdata('LoginId')."/".$centerid."/".$qipid."/".$elementid;
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
			if ($httpcode == 200) {

				$json = json_decode($server_output);

				foreach ($json->observations as $key => $obj) {
					$obj->title = substr_replace(strip_tags(html_entity_decode($obj->title)),'...',30);
				}

				echo json_encode($json);
				
			}else{
				echo $server_output;
			}
		}else{
			redirect("Welcome");
		}
	}
	
	public function getPublishedReflections($centerid='',$qipid='',$elementid='')
	{
		if($this->session->has_userdata('LoginId')){
			$url = BASE_API_URL."Qip/getPublishedReflections/".$this->session->userdata('LoginId')."/".$centerid."/".$qipid."/".$elementid;
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
			echo $server_output;
		}else{
			redirect("Welcome");
		}
	}

	public function getPublishedResources()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL."Qip/getPublishedResources/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$jsonOutput = json_decode($server_output);
			$jsonObj = new stdclass();
			$jsonObj->Status = $jsonOutput->Status;
			if ($jsonObj->Status == "SUCCESS") {
				$jsonObj->Resources = $jsonOutput->Resources;
				foreach ($jsonObj->Resources as $resource => $res) {
					$res->description = strip_tags(html_entity_decode($res->description));
					$res->createdAt = date('d-m-Y',strtotime($res->createdAt));
				}
			} else {
				$jsonObj->Message =  $jsonOutput->Message;
			}
			echo json_encode($jsonObj);
		}else{
			redirect("Welcome");
		}
	}

	public function getPublishedSurveys($centerid='',$qipid='',$elementid='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata("LoginId");
			$data['centerid'] = empty($centerid)?NULL:$centerid;
			$data['qipid'] = empty($qipid)?NULL:$qipid;
			$data['elementid'] = empty($elementid)?NULL:$elementid;
			$url = BASE_API_URL."Qip/getPublishedSurveys/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			echo $server_output;
		}else{
			redirect("Welcome");
		}
	}

	public function getProgramPlan($centerid='',$qipid='',$elementid='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata("LoginId");
			$data['centerid'] = empty($centerid)?NULL:$centerid;
			$data['qipid'] = empty($qipid)?NULL:$qipid;
			$data['elementid'] = empty($elementid)?NULL:$elementid;
			$url = BASE_API_URL."Qip/getProgramPlans/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$jsonOutput = json_decode($server_output);
			$jsonObj = new stdclass();
			$jsonObj->Status = $jsonOutput->Status;
			if ($jsonObj->Status == "SUCCESS") {
				foreach ($jsonOutput->ProgramPlans as $programplan => $pp) {
					$pp->createdAt = date('d-m-Y',strtotime($pp->createdAt));
				}
				$jsonObj->ProgramPlans = $jsonOutput->ProgramPlans;
			} else {
				$jsonObj->Message =  $jsonOutput->Message;
			}
			echo json_encode($jsonObj);
		}else{
			redirect("Welcome");
		}
	}

	public function getAllMonSubActs($qipid='',$elementid='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata("LoginId");
			$data['centerid'] = empty($centerid)?NULL:$centerid;
			$data['qipid'] = empty($qipid)?NULL:$qipid;
			$data['elementid'] = empty($elementid)?NULL:$elementid;
			$url = BASE_API_URL."Qip/getAllMonSubACts/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			echo $server_output;
		}else{
			redirect("Welcome");
		}
	}

	public function getAllDevMiles($qipid='',$elementid='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata("LoginId");
			$data['qipid'] = empty($qipid)?NULL:$qipid;
			$data['elementid'] = empty($elementid)?NULL:$elementid;
			$data['centerid'] = empty($centerid)?NULL:$centerid;
			$url = BASE_API_URL."Qip/getAllDevMiles/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			echo $server_output;
		}else{
			redirect("Welcome");
		}
	}

	public function getAllEylf($qipid='',$elementid='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['qipid'] = empty($qipid)?NULL:$qipid;
			$data['elementid'] = empty($elementid)?NULL:$elementid;
			$data['userid'] = $this->session->userdata("LoginId");
			$data['centerid'] = empty($centerid)?NULL:$centerid;
			$url = BASE_API_URL."Qip/getAllEylf/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			echo $server_output;
		}else{
			redirect("Welcome");
		}
	}

	public function saveQipLinks()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['linkids'] = json_decode($data['linkids']);
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL."Qip/saveQipLinks/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			echo $server_output;
		}else{
			redirect("Welcome");
		}
	}

	public function editElement()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->get();
			if (empty($data['qipid']) || empty($data['areaid']) || empty($data['elementid'])) {
				redirect('Qip');
			}else{
				$data['userid'] = $this->session->userdata('LoginId');
				$url = BASE_API_URL.'qip/viewElement/';
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
			    $jsonOutput = json_decode($server_output);
				$this->load->view('editElement',$jsonOutput);
			}
		}else{
			redirect('welcome');
		} 
	}

	public function saveProgressNotes()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'Qip/saveProgressNotes/';
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
		    $jsonOutput = json_decode($server_output);
			$url = base_url("qip/editElement")."?qipid=".$data['qipid']."&areaid=".$data['areaid']."&elementid=".$data['elementid']."&tab=1";
			redirect($url);
		}else{
			redirect('welcome');
		} 
	}

	public function saveElementIssues()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['expectedDate'] = str_replace("/", "-", $data['expectedDate']);
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'Qip/saveElementIssues/';
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
			print_r($data);
		    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		    curl_close ($ch);
		    $jsonOutput = json_decode($server_output);
			$url = base_url("qip/editElement")."?qipid=".$data['qipid']."&areaid=".$data['areaid']."&elementid=".$data['elementid']."&tab=2";
			redirect($url);
		}else{
			redirect('welcome');
		} 
	}

	public function saveElementComment()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'Qip/saveElementComment/';
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
		    $jsonOutput = json_decode($server_output);
			$url = base_url("qip/editElement")."?qipid=".$data['qipid']."&areaid=".$data['areaid']."&elementid=".$data['elementid']."&tab=3";
			redirect($url);
		}else{
			redirect('welcome');
		} 
	}

	public function getCenterStaffs()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'Qip/getCenterStaffs/';
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
			$data['Status'] = "ERROR";
			$data['Message'] = "Not a valid account! Try relogin instead.";
			echo json_encode($data);
		}
	}

	public function getElementStaffs()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'Qip/getElementStaffs/';
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
			$data['Status'] = "ERROR";
			$data['Message'] = "Not a valid account! Try relogin instead.";
			echo json_encode($data);
		}
	}

	public function addElementStaffs()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'Qip/addElementStaffs/';
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
			$data['Status'] = "ERROR";
			$data['Message'] = "Not a valid account! Try relogin instead.";
			echo json_encode($data);
		}
	}
}  
?>