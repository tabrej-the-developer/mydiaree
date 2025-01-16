<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surveys extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
	}

	public function index()
	{	
		$url = BASE_API_URL."/surveys/surveysList/";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL,$url);
		$data['userid'] = $this->session->userdata('LoginId');
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
			$data2['row']=$jsonOutput;
		    $this->load->view('surveysList',$data2);
		}
		if($httpcode == 401){
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

			$url = BASE_API_URL."surveys/surveysList/";
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
				$jsonOutput=json_decode($server_output);
				$jsonOutput->centerid = $centerid;
			    $this->load->view('surveysList_v3',$jsonOutput);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function view($surveyid='')
	{
		if ($surveyid!='') {
			if($this->session->has_userdata('LoginId')){
				$data['userid'] = $this->session->userdata('LoginId');
				$data['surveyid'] = $surveyid;
				$url = BASE_API_URL."/surveys/getSurveyData/";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL,$url);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
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
					$jsonOutput = json_decode($server_output,TRUE);
					$this->load->view('surveyResponseForm_v3',$jsonOutput);
				}
				if($httpcode == 401){
					redirect('welcome');
				}
			}else{
				redirect('Welcome');
			}
		}else{
			redirect('Welcome');
		}
	}

	public function add()
	{
		if($this->session->has_userdata('LoginId')){
			$url = BASE_API_URL."/Children/getChilds/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			$data['userid'] = $this->session->userdata('LoginId');
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
				$data2['row']=$jsonOutput;
			  $this->load->view('createSurveyForm',$data2);
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function exeCreateSurveyForm()
	{
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$data = $this->input->post();
				$data['userid'] = $this->session->userdata('LoginId');
				$data['createdBY'] = $this->session->userdata('Name');
				$data['createdAt'] = date('Y-m-d h:i:s');
				$data['childs'] = json_encode($_POST['childs']);
				$i=1;
				$j=1;
				$k=1;
				foreach($_POST as $key=>$value){
					 $check = true;
					if($check == true && count(explode('ropt',$key)) > 1){
						$data['ropt'.$i] = json_encode($value);
						$check = false;
						$i++;
					}
					if($check == true && count(explode('copt',$key)) > 1){
						$data['copt'.$j] = json_encode($value);
						$check = false;
						$j++;
					}
					if($check == true && count(explode('dopt',$key)) > 1){
						$data['dopt'.$k] = json_encode($value);
						$check = false;
						$k++;
					}
				}
				$url = BASE_API_URL."/surveys/createSurvey";
				$filesCount = (count($_FILES))/2;
				$files = array();
				// $file = array();
				for ($i=1; $i < ($filesCount + 1); $i++) { 
					$img = "imgQstn".$i;
					$vid = "vidQstn".$i;
					$imgfile = array();
					$vidfile = array();
					if(isset($_FILES['imgQstn'.$i]['name']) && isset($_FILES['imgQstn'.$i]['name']) != null && isset($_FILES['imgQstn'.$i]['name']) != "" && !empty($_FILES['imgQstn'.$i]['name']) ){
						$data['fileImg'.$i] = new CurlFile($_FILES['imgQstn'.$i]['tmp_name'],$_FILES['imgQstn'.$i]['type'],$_FILES['imgQstn'.$i]['name']);
					}

					if(isset($_FILES['vidQstn'.$i]['name']) && isset($_FILES['vidQstn'.$i]['name']) != null && isset($_FILES['vidQstn'.$i]['name']) != "" && !empty($_FILES['vidQstn'.$i]['name']) ){
					    $data['fileVid'.$i] = new CurlFile($_FILES['vidQstn'.$i]['tmp_name'],$_FILES['vidQstn'.$i]['type'],$_FILES['vidQstn'.$i]['name']);
					}
				}

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL,$url);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			    curl_setopt($ch, CURLOPT_POST, 1);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
					'X-Token: '.$this->session->userdata('AuthToken')
				));
				@curl_setopt($ch, CURLOPT_POSTFIELDS, ($data));
				$server_output = curl_exec($ch);
				print_r($server_output);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if($httpcode == 200){
					$jsonOutput=json_decode($server_output,TRUE);
					curl_close ($ch);
						redirect(base_url('surveys'));
					}
				
				if($httpcode == 401){
					redirect('welcome');
				}
			}else{
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function updateSurveyForm()
	{
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST'){
				$data = $this->input->post();
				$data['userid'] = $this->session->userdata('LoginId');
				$data['createdBY'] = $this->session->userdata('Name');
				$data['createdAt'] = date('Y-m-d h:i:s');
				$data['childs'] = json_encode($_POST['childs']);
				$i=1;
				$j=1;
				$k=1;
				foreach($_POST as $key=>$value){
					 $check = true;
					if($check == true && count(explode('ropt',$key)) > 1){
						$data['ropt'.$i] = json_encode($value);
						$check = false;
						$i++;
					}
					if($check == true && count(explode('copt',$key)) > 1){
						$data['copt'.$j] = json_encode($value);
						$check = false;
						$j++;
					}
					if($check == true && count(explode('dopt',$key)) > 1){
						$data['dopt'.$k] = json_encode($value);
						$check = false;
						$k++;
					}
				}
				$url = BASE_API_URL."/Surveys/updateSurveyRecord";

				$filesCount = (count($_FILES))/2;
				$files = array();
				for ($i=1; $i < ($filesCount + 1); $i++) { 
					$img = "imgQstn".$i;
					$vid = "vidQstn".$i;
					$imgfile = array();
					$vidfile = array();
					if(isset($_FILES['imgQstn'.$i]['name']) && isset($_FILES['imgQstn'.$i]['name']) != null && isset($_FILES['imgQstn'.$i]['name']) != "" && !empty($_FILES['imgQstn'.$i]['name']) ){
						$data['fileImg'.$i] = new CurlFile($_FILES['imgQstn'.$i]['tmp_name'],$_FILES['imgQstn'.$i]['type'],$_FILES['imgQstn'.$i]['name']);
						}
					if(isset($_FILES['vidQstn'.$i]['name']) && isset($_FILES['vidQstn'.$i]['name']) != null && isset($_FILES['vidQstn'.$i]['name']) != "" && !empty($_FILES['vidQstn'.$i]['name']) ){
					    $data['fileVid'.$i] = new CurlFile($_FILES['vidQstn'.$i]['tmp_name'],$_FILES['vidQstn'.$i]['type'],$_FILES['vidQstn'.$i]['name']);
					}
				}

				

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL,$url);
			    curl_setopt($ch, CURLOPT_POST, 1);
			    @curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
					'X-Token: '.$this->session->userdata('AuthToken')
				));
				
				$server_output = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if($httpcode == 200){
					$jsonOutput=json_decode($server_output,TRUE);
					curl_close ($ch);
						redirect(base_url('surveys'));
					}
				
				if($httpcode == 401){
					redirect('welcome');
				}
			}else{
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function deleteSurvey($surveyId)
	{
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				$userid = $this->session->userdata('LoginId');
				$url = BASE_API_URL."Surveys/DeleteSurvey/$userid/$surveyId";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
					'X-Token: '.$this->session->userdata('AuthToken')
				));
				$server_output = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if($httpcode == 200){
					$jsonOutput=json_decode($server_output,TRUE);
					curl_close($ch);
					echo $jsonOutput;
				}
					
			}
		}
	}

	public function viewResponses($surveyId=NULL)
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['surveyId'] = $surveyId;
			$url = BASE_API_URL."/surveys/surveyResponse";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$server_output = curl_exec($ch);

			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output,TRUE);
				curl_close ($ch);
				$row['records']=$jsonOutput;
				$this->load->view('viewResponses',$row);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
			
		}else{

		}		
	}

	public function updateSurvey($surveyId=NULL)
	{
		if($this->session->has_userdata('LoginId')){
			$data=array();
			$data['userid'] = $this->session->userdata('LoginId');
			$data['surveyid'] = $surveyId;
			$url = BASE_API_URL."/surveys/getSurveyData";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$server_output = curl_exec($ch);
			// echo $server_output;
			// exit();
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output,TRUE);
				curl_close ($ch);
				$row['records']=$jsonOutput;
				
				$this->load->view('updateSurveyForm',$row);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
			
		}else{
			redirect('welcome');
		}	
	}

	public function getSurveyQuestions($surveyId=NULL)
	{			
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['surveyid'] = $surveyId;
			$url = BASE_API_URL."/surveys/getSurveyData/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output,TRUE);
				curl_close ($ch);
				$row['records']=$jsonOutput;
				$this->load->view('getSurveyQuestions',$row);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function exeSurveyRespond()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['surveyid'] = $_POST['surveyid'];
			$data['responses'] = array();
			// $count = count($_POST);
			//echo $_POST['surveyid']; exit;
			$demo = [];
			$demo['questionId'] = "";
			foreach ($_POST as $key => $value) {
				$demo['responses'] = [];
				if(count(explode('questionId_',$key)) > 1){
					$demo['questionId'] = $value;
				}
				if ($value!="") {
					if(count(explode('question_',$key)) > 1){
						foreach ($value as $k) {
							array_push($demo['responses'], $k);
						}
						$d = (object) $demo;
						array_push($data['responses'], $d);
						$demo = [];
						$demo['questionId'] = "";
					}
				}
			}
			$url = BASE_API_URL."/surveys/surveyResponse/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			//print_r($server_output); exit;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output,TRUE);
				curl_close ($ch);
				$row['records']=$jsonOutput;
				redirect('surveys/list');
			}
			if($httpcode == 401){
				$rurl = base_url('surveys/view/'.$_POST['surveyid'])."?status=error&code=601";
				redirect($rurl);
			}
		}else{
			redirect('welcome');
		}
	}

	public function deleteElements()
	{
		
		if($this->session->has_userdata('LoginId')){
			$formdata = $_POST;
			$data['userid'] = $this->session->userdata('LoginId');
			$data['elementid'] = $formdata['eleId'];
			$data['option'] = $formdata['option'];
			$url = BASE_API_URL."/surveys/deleteSurveyElement/".$data['userid']."/".$data['option']."/".$data['elementid'];
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    // curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
		    // curl_setopt($ch, CURLOPT_POST, 1);
		    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			print_r($server_output);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output,TRUE);
				curl_close ($ch);
				// $row['records']=$jsonOutput;
				// $this->load->view('getSurveyQuestions',$row);
				// redirect('surveys');

			}
			// if($httpcode == 401){
			// 	redirect('welcome');
			// }
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
			$url = BASE_API_URL."/Surveys/getChildRecords/";
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
				$jsonOutput=json_decode($server_output);	
				$jsonOutput->centerid = $centerid;		
				$permission = json_decode($this->getPermission($data['userid'],$data['centerid']));
				$jsonOutput->permissions = new stdClass();
				if ($permission->Status == "SUCCESS") {
					$jsonOutput->permissions->add = $permission->Permissions->addSurvey;
					$jsonOutput->permissions->edit = $permission->Permissions->updateSurvey;
				} else {
					$jsonOutput->permissions->add = 0;
					$jsonOutput->permissions->edit = 0;
				}
				$this->load->view('createSurveyForm_v3',$jsonOutput);
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function edit($surveyid='')
	{
		if($this->session->has_userdata('LoginId')){
		    $data['surveyid'] = $surveyid;
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."/Surveys/getSurveyDetails/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			$data['userid'] = $this->session->userdata('LoginId');
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
				$jsonOutput=json_decode($server_output);	
				$jsonOutput->centerid = $jsonOutput->Survey->centerid;
				$jsonOutput->surveyid = $jsonOutput->Survey->id;
				$childrensArr = $this->getChildRecords($jsonOutput->centerid,$jsonOutput->Survey->id);
				$jsonOutput->Childrens = $childrensArr->Childrens;
				$jsonOutput->Groups = $childrensArr->Groups;
				$jsonOutput->Rooms = $childrensArr->Rooms;
				$this->load->view('createSurveyForm_v3',$jsonOutput);
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function getChildRecords($centerid='',$surveyId='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['centerid'] = $centerid;
			$data['surveyId'] = $surveyId;
	   		$url = BASE_API_URL."Surveys/getChildRecords/";
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

	public function delete($surveyId=NULL)
	{
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				$data['surveyid'] = $surveyId;
				$data['userid'] = $this->session->userdata('LoginId');
				$url = BASE_API_URL."Surveys/delete";
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
					curl_close($ch);
					$jsonOutput = json_decode($server_output);
					$redirectUrl = base_url('Surveys/list')."?centerid=".$jsonOutput->centerid;
					redirect($redirectUrl);
				}else{
					redirect('surveys/list');
				}		
			}
		}
	}

	public function saveSurvey()
	{
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				$data = $this->input->post();
				if (isset($_POST['childs'])) {
					$data['childs'] = json_encode($_POST['childs']);
				}

				// data section
				$i=1;
				$j=1;
				$k=1;
				foreach($_POST as $key=>$value){
					$check = true;
					if($check == true && count(explode('ropt',$key)) > 1){
						$data['ropt'.$i] = json_encode($value);
						$check = false;
						$i++;
					}
					if($check == true && count(explode('copt',$key)) > 1){
						$data['copt'.$j] = json_encode($value);
						$check = false;
						$j++;
					}
					if($check == true && count(explode('dopt',$key)) > 1){
						$data['dopt'.$k] = json_encode($value);
						$check = false;
						$k++;
					}
				}

				// files section
				$filesCount = count($_FILES);
				$keys = array_keys($_FILES);
				$matches = preg_grep("/^fileQstn/",$keys);
				$obsTags = [];
				$end = end($matches);
				$count = substr($end, -1);

				for ($i=0; $i <= $count; $i++) { 
					if(isset($_FILES['fileQstn'.$i]['tmp_name']) && !empty($_FILES['fileQstn'.$i]['tmp_name'])){
						$data['fileQstn'.$i] = new CurlFile($_FILES['fileQstn'.$i]['tmp_name'],$_FILES['fileQstn'.$i]['type'],$_FILES['fileQstn'.$i]['name']);
					}
				}

				$data['userid'] = $this->session->userdata('LoginId');
				$url = BASE_API_URL."Surveys/saveSurvey";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL,$url);
				@curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
					'X-Token: '.$this->session->userdata('AuthToken')
				));
				$server_output = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);				
				if($httpcode == 200){
					curl_close($ch);
					$jsonOutput = json_decode($server_output);
					$redirectUrl = base_url('Surveys/list')."?centerid=".$jsonOutput->centerid;
					redirect($redirectUrl);
				}else{
					redirect('surveys/list');
				}		
			}else{
				redirect('surveys/list');
			}
		}else{
			redirect('surveys/list');
		}
	}

	public function viewOld($surveyId='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['surveyid'] = $surveyId;
			$url = BASE_API_URL."/surveys/getSurveyData/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output,TRUE);
				
				curl_close ($ch);
				$row['records']=$jsonOutput;
				$this->load->view('getSurveyQuestions',$row);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function getPermission($userid='',$centerid='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['user'] = $userid;
			$data['center'] = $centerid;
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."/surveys/getPermission/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			return $server_output;
		}else{
			$data = [];
			$data['Status'] = 'ERROR';
			$data['Message'] = 'Session timeout!';
			return json_encode($data);
		}
	}

}

/* End of file Surveys.php */
/* Location: ./application/controllers/Surveys.php */