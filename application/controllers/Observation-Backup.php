<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Observation extends CI_Controller {  
      
    public function index()  
    {
	    if($this->session->has_userdata('LoginId')){
			redirect('observation/observation_dashboard');
		}else{ 
			$this->load->view('welcome');
		}	
    }

	public function observation_dashboard()
	{
	   if($this->session->has_userdata('LoginId')){
		    
		    $page=isset($_GET['page'])?$_GET['page']:1;
		    if (isset($_GET['centerid'])) {
		    	$centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
		    }else{
		    	$center = $this->session->userdata("centerIds");
		    	if (empty($center)) {
		    		$centerid = 0;
		    	}else{
		    		$centerid = $center[0]->id;
		    	}
		    }

		    $url = BASE_API_URL."/observation/getListObservations/".$this->session->userdata('LoginId')."/".$centerid."/".$page;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			// echo $server_output;
			// exit();
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				curl_close ($ch);
				$data=$jsonOutput;
				$data->type = isset($_GET['type'])?$_GET['type']:'';
				$count=$data->observationsTotal/10;
				$data->page=$page;
				$data->count=ceil($count);
			    $this->load->view('observationList',$data);
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}
	
	public function deleteLink()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'observation/deleteLink/'.$data['userid'].'/'.$_GET['id'].'/'.$_GET['linkId'];
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
					$type=isset($_GET['type'])?$_GET['type']:'assessments';
					redirect('observation/add?type='.$type.'&id='.$_GET['id']);
				  curl_close ($ch);
				}
				else if($httpcode == 401){
					return 'error';
				}
		}
	}
	
	public function view()
	{
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST')
			{
				
			}
			else{
				$this->getView();
			}
			
		}else{
			$this->load->view('welcome');	
		}
	}
	
	public function add($get_child=NULL)
	{
		
		if($this->session->has_userdata('LoginId')){

			if ($this->session->userdata('UserType')!="Parent") {
				if (isset($_GET['centerid'])) {
					$centerid = $_GET['centerid'];
				} else {
					$cen = $this->session->userdata('centerIds');
					$centerid = $cen[0]->id;
				}
			}

			if($_SERVER['REQUEST_METHOD']=='POST')
			{
				$url1='';
				$this->load->helper('form');
				$data=[];
		        $data = $this->input->post();
		        $data['centerid'] = $centerid;
				$data['userid'] = $this->session->userdata('LoginId');

				if(isset($_GET['sub_type']) && $_GET['sub_type']!="")
				{
					$data['observationId']=$_GET['id'];

					if($_GET['sub_type']=='EYLF')
					{
						$url1= '&sub_type=' . $_GET['sub_type'];
						$url = BASE_API_URL.'observation/createMontessori';
						$datas = array();
						$datas['montessori'] = [];
						foreach ($data['montessori'] as $key=>$value) {
							$d['idSubActivity'] = $key;
							$d['assessment'] = $value;
							$d['extras'] = [];
							if (isset($data['extras']) && !empty($data['extras'])) {
								foreach ($data['extras'] as $key => $value) {
									if ($key == $d['idSubActivity']) {
										$d['extras'] = $value;
									}
								}
							}
							array_push($datas['montessori'], $d);
						}
						$data['montessori'] = [];
						unset($data['extras']);
						$data['montessori'] = $datas['montessori'];
						$data = json_encode($data);
					}else if($_GET['sub_type']=='Milestones') {
						$url1='&sub_type='.$_GET['sub_type'];
						$url = BASE_API_URL.'observation/createEylf';
						$data = json_encode($data);
					}else if($_GET['sub_type']=='Montessori') {
						$tags = [];
						$url1='&sub_type='.$_GET['sub_type'];

						if (isset($_FILES['obsMedia']['name']) && !empty($_FILES['obsMedia']['name'][0])) {
							$countFiles = count($_FILES['obsMedia']['name']);
							for ($i=0; $i <$countFiles ; $i++) { 
								$data['obsMedia'.$i] = new CurlFile($_FILES['obsMedia']['tmp_name'][$i],$_FILES['obsMedia']['type'][$i],$_FILES['obsMedia']['name'][$i]);
							}
						}

						if (isset($_POST['mediaid'])) {
							$countMedias = count($_POST['mediaid']);
							for ($i=0; $i < $countMedias ; $i++) { 
								$child = "upl-media-tags-child".$_POST['mediaid'][$i];
								if (isset($data[$child])) {
									$data[$child] = json_encode($data[$child]);
								}
								$educator = "upl-media-tags-educator".$_POST['mediaid'][$i];
								if(isset($data[$educator])){
									$data[$educator] = json_encode($data[$educator]);
								}
							}
						}
						

						if (isset($data['origin'])) {
							$data['origin'] = json_encode($data['origin']);
						}
						
						if (isset($data['mediaid'])) {
							$data['mediaid'] = json_encode($data['mediaid']);
						}

						if (isset($data['priority'])) {
							$data['priority'] = json_encode($data['priority']);
						}

						if (isset($_POST['fileno'])) {
							foreach ($_POST['fileno'] as $fileno => $fn) {
								$obsImg = "obsImage_".$fn;
								$obsEdu = "obsEducator_".$fn;
								if (isset($data[$obsImg])){
									$data[$obsImg] = json_encode($data[$obsImg]);
								}
								if(isset($data[$obsEdu])){
									$data[$obsEdu] = json_encode($data[$obsEdu]);
								}
							}
							$data['fileno'] = json_encode($data['fileno']);
						}
							
						if (isset($data['childrens'])) {
							$data['childrens'] = json_encode($data['childrens']);
						}

						$data['title'] = $this->dataready($data['title']);
						$data['notes'] = $this->dataready($data['notes']);
						$data['reflection'] = $this->dataready($data['reflection']);
						$url = BASE_API_URL.'observation/editObservation';
					}
				}else{
					if(isset($_GET['type']) && $_GET['type']=='links')
					{
						$data['observationId'] = $_GET['id'];
						if(isset($_GET['status']) && $_GET['status']=='true')
						{

							$url = BASE_API_URL.'observation/createLinks';
							$data = json_encode($data);
						}else{
							$url = BASE_API_URL.'observation/createMilestones';
							$datas = array();
							$datas['milestones'] = [];
							foreach ($data['milestones'] as $key=>$value) {
								$d['devMilestoneId'] = $key;
								$d['assessment'] = $value;
								$d['extras'] = [];
								if (isset($data['extras']) && !empty($data['extras'])) {
									foreach ($data['extras'] as $key => $value) {
										if ($key == $d['devMilestoneId']) {
											$d['extras'] = $value;
										}
									}
									array_push($datas['milestones'], $d);
								}else{
									array_push($datas['milestones'], $d);
								}
								
							}
							
							$data['milestones'] = $datas['milestones']; 
							$data = json_encode($data);
						}
					}else{

						$tags = [];

						if (isset($_FILES['obsMedia']['name']) && !empty($_FILES['obsMedia']['name'][0])) {
							$countFiles = count($_FILES['obsMedia']['name']);
							for ($i=0; $i < $countFiles ; $i++) { 
								$data['obsMedia'.$i] = new CurlFile($_FILES['obsMedia']['tmp_name'][$i],$_FILES['obsMedia']['type'][$i],$_FILES['obsMedia']['name'][$i]);
							}
						}

						if (isset($_POST['mediaid'])) {
							$countMedias = count($_POST['mediaid']);
							for ($i=0; $i < $countMedias ; $i++) { 
								$child = "upl-media-tags-child".$_POST['mediaid'][$i];
								if (isset($data[$child])) {
									$data[$child] = json_encode($data[$child]);
								}
								$educator = "upl-media-tags-educator".$_POST['mediaid'][$i];
								if(isset($data[$educator])){
									$data[$educator] = json_encode($data[$educator]);
								}
							}
						}

						if (isset($data['origin'])) {
							$data['origin'] = json_encode($data['origin']);
						}
						
						if (isset($data['mediaid'])) {
							$data['mediaid'] = json_encode($data['mediaid']);
						}

						if (isset($data['priority'])) {
							$data['priority'] = json_encode($data['priority']);
						}

						if (isset($_POST['fileno'])) {
							foreach ($_POST['fileno'] as $fileno => $fn) {
								$obsImg = "obsImage_".$fn;
								$obsEdu = "obsEducator_".$fn;
								if (isset($data[$obsImg])){
									$data[$obsImg] = json_encode($data[$obsImg]);
								}
								if(isset($data[$obsEdu])){
									$data[$obsEdu] = json_encode($data[$obsEdu]);
								}
								$mediaCount = count($_FILES['obsMedia']['name']);
								for ($i=0; $i < $mediaCount; $i++) { 
									if(isset($_FILES['obsMedia']['tmp_name'][$i]) && !empty($_FILES['obsMedia']['tmp_name'][$i])){
										$data['obsMedia'.$i] = new CurlFile($_FILES['obsMedia']['tmp_name'][$i],$_FILES['obsMedia']['type'][$i],$_FILES['obsMedia']['name'][$i]);
									}
								}
						
								$keys = array_keys($_POST);
								$matches = preg_grep("/^obsImage_/",$keys);
								$obsTags = [];
								$end = end($matches);
								$count = substr($end, -1);
								for ($i=0; $i <= $count; $i++) { 
									if (isset($_POST['obsImage_'.$i]) && $_POST['obsImage_'.$i] != "") {
										$d['obsImage'] = $_POST['obsImage_'.$i];
										$d['obsEducator'] = $_POST['obsEducator_'.$i];
										$d['obsCaption'] = $_POST['obsCaption_'.$i];
										array_push($obsTags, $d);
									}
									$data['fileno'] = json_encode($data['fileno']);
								}

								if (isset($data['obsTags'])) {
									$data['obsTags'] = json_encode($obsTags);
								}
							}
						}

						if (isset($data['title']) && !empty($data['title'])) {
							$data['title'] = $this->dataready($data['title']);
						}

						if (isset($data['notes']) && !empty($data['notes'])) {
							$data['notes'] = $this->dataready($data['notes']);
						}
						
						if (isset($data['reflection']) && !empty($data['reflection'])) {
							$data['reflection'] = $this->dataready($data['reflection']);
						}

						if (isset($data['childrens'])) {
							$data['childrens'] = json_encode($data['childrens']);
						}

						$url = BASE_API_URL.'observation/createObservation';
					}
				}
				
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				@curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
					'X-Token: '.$this->session->userdata('AuthToken')
			    ));	
				$server_output = curl_exec($ch);
			    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if($httpcode == 200){
					if ($this->session->userdata('UserType')=="Parent") {
						redirect(base_url()."observation");
					}else{
						$jsonOutput = json_decode($server_output);
						$type=isset($_GET['type'])?$_GET['type']:'assessments';
						$id=isset($_GET['id']) ? $_GET['id'] : $jsonOutput->id;
						
						$send_data = 'type='.$type.'&id='.$id.$url1;
						
						curl_close ($ch);
						//redirect('observation/add?type='.$type.'&id='.(isset($_GET['id']) ? $_GET['id'] : $jsonOutput->id).$url1);
						//redirect(base_url('observation/add?type='.$type.'&id='.$id.$url1),'refresh');
						redirect(base_url()."observation/add?$send_data");
					}
				}
				if($httpcode == 401){
					return 'error';
				}
			}else{
				
				$this->getForm($get_child);
			}
			
		}else{
			$this->load->view('welcome');	
		}
	}

	public function getMediaTags()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'observation/getMediaTags';
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
		    echo $server_output;
		}else{
			$this->load->view('welcome');
		}
	}

	public function getAssessmentPreview()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$data['monSubactivity'] = json_decode($data['monSubactivity']);
			$data['monSubActExtras'] = json_decode($data['monSubActExtras']);
			$data['eylfSubActivities'] = json_decode($data['eylfSubActivities']);
			$data['devMileSub'] = json_decode($data['devMileSub']);
			$data['devMileExtras'] = json_decode($data['devMileExtras']);
			$url = BASE_API_URL.'observation/getAssessmentPreview';
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
		    echo $server_output;
		}else{
			$this->load->view('welcome');
		}
	}

	public function comment()
	{
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST')
			{
				$this->load->helper('form');
		        $data = $this->input->post();
				$data['userid'] = $this->session->userdata('LoginId');
				$data['id'] = $_GET['id'];				
				$url = BASE_API_URL.'observation/createComment';
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
					// redirect('observation/view?type='.$type.'&id='.$data['id']);
					redirect('observation/view?id='.$data['id']);
				    curl_close ($ch);
				}
				else if($httpcode == 401){
					return 'error';
				}
			}else{
				$this->getForm();
			}
		}else{
			$this->load->view('welcome');	
		}
	}

	public function filters()
	{
		if($this->session->has_userdata('LoginId')){
		    $userid = $this->session->userdata('LoginId');
			if(!empty($_POST['childs']))
			{
				$data['childs']=explode(",",$_POST['childs']);
			}else{
				$data['childs']=array();
			}
			
			if(!empty($_POST['authors']))
			{
				$data['authors']=explode(",",$_POST['authors']);
			}else{
				$data['authors']=array();
			}
			
			if(!empty($_POST['assessments']))
			{
				$data['assessments']=explode(",",$_POST['assessments']);
			}else{
				$data['assessments']=array();
			}
			
		    $url = BASE_API_URL.'observation/getFilterObservations/'.$userid.'/'.$_GET['id'];
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
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
				
			}
		}
	}

	public function listfilters()
	{
		if($this->session->has_userdata('LoginId')){

			$userid = $this->session->userdata('LoginId');
			if(!empty($_POST['childs']))
			{
				$data['childs']=explode(",",$_POST['childs']);
			}else{
				$data['childs']=array();
			}
			
			if(!empty($_POST['authors']))
			{
				$data['authors']=explode(",",$_POST['authors']);
			}else{
				$data['authors']=array();
			}
			
			if(!empty($_POST['assessments']))
			{
				$data['assessments']=explode(",",$_POST['assessments']);
			}else{
				$data['assessments']=array();
			}
			
			if(!empty($_POST['observations']))
			{
				$data['observations']=explode(",",$_POST['observations']);
			}else{
				$data['observations']=array();
			}
			
			if(!empty($_POST['added']))
			{
				$data['added']=explode(",",$_POST['added']);
			}else{
				$data['added']=array();
			}
			
			if(!empty($_POST['media']))
			{
				$data['media']=explode(",",$_POST['media']);
			}else{
				$data['media']=array();
			}
			
			if(!empty($_POST['comments']))
			{
				$data['comments']=explode(",",$_POST['comments']);
			}else{
				$data['comments']=array();
			}
			if(!empty($_POST['links']))
			{
				$data['links']=explode(",",$_POST['links']);
			}else{
				$data['links']=array();
			}
		    $url = BASE_API_URL.'observation/getListFilterObservations/'.$userid;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
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
				echo $server_output;
			}
		}
	}

	public function getForm($get_child=NULL)
	{
		if($this->session->has_userdata('LoginId')){
		    $data['userid'] = $this->session->userdata('LoginId');
		    $userid = $this->session->userdata('LoginId');

		    if (isset($_GET['centerid'])) {
				$centerid = $_GET['centerid'];
			} else {
				$cen = $this->session->userdata('centerIds');
				$centerid = $cen[0]->id;
			}

			if ($this->session->userdata('UserType')!="Parent") {
				$data['centerid'] = $centerid;
		    	$url = BASE_API_URL.'observation/getChildren?centerId='.$data['centerid'].'&userid='.$data['userid'];
			}else{				
				$data['parentid'] = $this->session->userdata('LoginId');
		    	$url = BASE_API_URL.'observation/getChildren?parentId='.$data['parentid'].'&userid='.$data['userid'];
			}
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
		    ));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			$apidata = json_decode($server_output);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				$assessments = $this->getAssessmentSettings($centerid);
				// echo "<pre>";
				// print_r($assessments);
				// exit();
				$assmntSetting = $assessments->Settings;
				$data['assessments'] = $assmntSetting;
				$data['childs']=$apidata->child;
				$data['groups']=json_decode($this->getGroups());
				$data['mon_activites']=$this->getMontessoriActivites($centerid);
				$data['mon_sub_activites']=$this->getMontessoriSubActivites($centerid);
				$data['mon_extras']=$this->getMontessoriExtras($centerid);
				$data['mon_subjects']=json_decode($this->getMontessoriSubjects($centerid));
				$data['eylf_outcomes']=json_decode($this->getEylfOutcomes());
				$data['eylf_activites']=$this->getEylfActivites($centerid);
				$data['eylf_sub_activites']=$this->getEylfSubActivites($centerid);
				$data['milestones']=json_decode($this->getDevelopmentalMilestone($centerid));
				$data['dev_activites']=$this->getDevelopmentalMilestoneActivites($centerid);
				$data['dev_sub_activites']=$this->getDevelopmentalMilestoneSubActivites($centerid);
				$data['dev_extras']=$this->getDevelopmentalMilestoneExtras($centerid);
				$data['type']=isset($_GET['type'])?$_GET['type']:'observation';

				if ($assmntSetting->montessori == 1) {
					$data['sub_type']=isset($_GET['sub_type'])?$_GET['sub_type']:'Montessori';
				} elseif($assmntSetting->eylf == 1) {
					$data['sub_type']=isset($_GET['sub_type'])?$_GET['sub_type']:'EYLF';
				} elseif($assmntSetting->devmile == 1) {
					$data['sub_type']=isset($_GET['sub_type'])?$_GET['sub_type']:'Milestones';
				}
				// else {
				// 	$data['sub_type']=isset($_GET['sub_type'])?$_GET['sub_type']:'Montessori';
				// }			

				$data['id'] = isset($_GET['id'])?$_GET['id']:'0';

				$obsPublished=$this->getPublishedObservations($data['id']);
				$refPublished=$this->getPublishedReflections($centerid);
				$qipPublished = $this->getPublishedQIP($centerid);
				$progPlanPublished = $this->getPublishedProgPlan($centerid);
				$educators=$this->getEducators($centerid);
				$uploadedMedia = $this->getUploadedMediaFiles();
				$getStaffChild = $this->getAllUsers();
				$getAllMontSubAct = $this->getAllMontSubAct();
				foreach ($getStaffChild->UsersList as $key => $obj) {
					$obj->id = $obj->type."_".$obj->id;
				}

				$myUserString = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($getStaffChild->UsersList));
				$myMontString = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($getAllMontSubAct->TagsList));
				$data['uploadedMedia'] = $uploadedMedia->uploadedMediaList;
				$data['getStaffChild'] = $myUserString;
				$data['getTagsList'] = $myMontString;
				if (!empty($obsPublished) && $obsPublished->observations != NULL) {
					$data['obsPublished'] = $obsPublished->observations;
				}

				if ($refPublished->reflections != NULL) {
					$data['refPublished'] = $refPublished->reflections;
				}

				if ($qipPublished->qip != NULL) {
					$data['qipPublished'] = $qipPublished->qip;
				}

				if ($progPlanPublished->ProgramPlan != NULL) {
					$data['progPlanPublished'] = $progPlanPublished->ProgramPlan;
				}				
				
				$data['educators'] = $educators->Educators;
				$permissions = $this->getPermissions($userid,$centerid);
				$data['permissions'] = $permissions->Permissions;
				if($data['id'])
				{
					$observation = $this->getObservation($data['id']);
					if ($observation!=null) {
						$data['observationEylfDetails']=$observation->observationEylfDetails;
						$data['outcomes']=$observation->outcomes;
						$data['eylfActivites']=$observation->eylfActivites;
						$data['observationMontessoriDetails']=$observation->observationMontessoriDetails;
						$data['subjects']=$observation->subjects;
						$data['montessoriActivites']=$observation->montessoriActivites;
						$data['observationMilestoneDetails']=$observation->observationMilestoneDetails;
						$data['milestonesubjects']=$observation->milestonesubjects;
						$data['milestoneActivites']=$observation->milestoneActivites;
						$data['observation']=$observation->observation;
						$data['obsMontessori']=$observation->obsMontessori;
						$data['obsMilestones']=$observation->observationMilestones;
						// $data['obsEylf']=$observation->observationEylf;
						$data['observationChildrens']=$observation->observationChildrens;
						$data['observationLinks']=$observation->observationLinks;
						$data['reflectionLinks']=$observation->reflectionLinks;
						$data['qipLinks']=$observation->qipLinks;
						$data['programplanLinks']=$observation->programplanLinks;
						$data['observationMedia']=array();
						foreach($observation->observationMedia as $media)
						{
							$name=base_url('/api/assets/media/'.$media->mediaUrl);
						    $media->name=base64_encode(file_get_contents($name));
							$media->image=$name;
							$data['observationMedia'][]=$media;
						}
						$data['observationMontessori']=array();
						foreach($observation->observationMontessori as $mon)
						{
							$data['observationMontessori'][$mon->idSubActivity]=$mon->idExtra;
						}
						$data['observationEylf']=array();
						foreach($observation->observationEylf as $mon)
						{
							$data['observationEylf'][$mon->eylfActivityId][$mon->eylfSubactivityId]=$mon->eylfSubactivityId;
						}
						$data['observationMilestones']=array();
						foreach($observation->observationMilestones as $mon)
						{
							$data['observationMilestones'][$mon->devMilestoneId]=$mon->idExtras;
						}
					}
				}
				$data['get_child']=str_replace('%20',' ', $get_child);
			    $this->load->view('observationForm1',$data);
			    // echo "<pre>";
			    // print_r($data);
			    // exit();
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
			
		}else{
			$this->load->view('welcome');	
		}
	}

	public function getEducators($centerid = NULL)
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
		    $url = BASE_API_URL.'observation/getEducators/'.$data['userid'].'/'.$centerid;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
		    ));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			// print_r($server_output);
			// exit();
				
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				$data=json_decode($server_output);
				return $data;
			}else if($httpcode == 401){
				return 'failed';
		   }
	    }
	}

	public function getView()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['observationId'] = $_GET['id'];
		    $url = BASE_API_URL.'observation/getObsView/';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
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
				$data=json_decode($server_output);
				$data->observation->title =  html_entity_decode($data->observation->title);
				$data->observation->notes = html_entity_decode($data->observation->notes);
				$data->observation->reflection = html_entity_decode($data->observation->reflection);
				$data->id = isset($_GET['id'])?$_GET['id']:'';
				$getStaffChild = $this->getAllUsers();
				$getAllMontSubAct = $this->getAllMontSubAct();
				foreach ($getStaffChild->UsersList as $key => $obj) {
					$obj->id = $obj->type."_".$obj->id;
				}
				$myUserString = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($getStaffChild->UsersList));
				$myTagsString = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($getAllMontSubAct->TagsList));
				$data->getStaffChild = $myUserString;
				$data->getTagsList = $myTagsString;
				$this->load->view('observationView',$data);
			}else if($httpcode == 401){
				return FALSE;
		   }
	    }
	}
	
	public function getObservations($id)
	{
		$url = BASE_API_URL."/observation/getObservations/".$this->session->userdata('LoginId')."/".$id;
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
			
			return $jsonOutput;
		    
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}
	
	public function getPublishedObservations($id)
	{
		$url = BASE_API_URL."/observation/getPublishedObservations/".$this->session->userdata('LoginId')."/".$id;
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
			return $jsonOutput;
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getPublishedReflections($id)
	{
		$url = BASE_API_URL."/observation/getPublishedReflections/".$this->session->userdata('LoginId')."/".$id;
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
			return $jsonOutput;
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getPublishedQIP($id)
	{
		$url = BASE_API_URL."/observation/getPublishedQip/".$this->session->userdata('LoginId')."/".$id;
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
			return $jsonOutput;
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getPublishedProgPlan($id)
	{
		$url = BASE_API_URL."/observation/getPublishedProgPlan/".$this->session->userdata('LoginId')."/".$id;
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
			return $jsonOutput;
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}
	
	public function getObservation($id)
	{
		$url = BASE_API_URL."/observation/getObservation/".$this->session->userdata('LoginId')."/".$id;
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
			return $jsonOutput;	    
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getUploadedMediaFiles($userid="")
	{
		$url = BASE_API_URL."/observation/getUploadedMediaFiles/".$this->session->userdata('LoginId');		
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
			return $jsonOutput;
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getDevelopmentalMilestoneExtras()
	{
		$url = BASE_API_URL."/observation/getDevelopmentalMilestoneExtras/".$this->session->userdata('LoginId');
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
			$data=array();
			foreach($jsonOutput as $json)
			{
				$data[$json->idsubactivity][]=$json;
			}
			return $data;
		    
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getDevelopmentalMilestone($centerid="")
	{
		$url = BASE_API_URL."/observation/getDevelopmentalMilestone/".$this->session->userdata('LoginId')."/".$centerid;
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
			return $server_output;
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getDevelopmentalMilestoneActivites($centerid="")
	{
		$url = BASE_API_URL."/observation/getDevelopmentalMilestoneActivites/".$this->session->userdata('LoginId')."/".$centerid;
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
			$data=array();
			
			foreach($jsonOutput as $json)
			{
				$data[$json->ageId][]=$json;
			}
			return $data;
		    
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getDevelopmentalMilestoneSubActivites($centerid="")
	{
		$url = BASE_API_URL."/observation/getDevelopmentalMilestoneSubActivites/".$this->session->userdata('LoginId')."/".$centerid;
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
		$data=array();
		
			foreach($jsonOutput as $json)
			{
				$data[$json->milestoneid][]=$json;
			}
			return $data;
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getEylfActivites($centerid='')
	{
		$url = BASE_API_URL."observation/getEylfActivites/".$this->session->userdata('LoginId')."/".$centerid;
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
			$data=array();
			foreach($jsonOutput as $json)
			{
				$data[$json->outcomeId][]=$json;
			}
			return $data;
		    
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getEylfSubActivites($centerid="")
	{
		$url = BASE_API_URL."/observation/getEylfSubActivites/".$this->session->userdata('LoginId')."/".$centerid;
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
			$data=array();
			foreach($jsonOutput as $json)
			{
				$data[$json->activityid][]=$json;
			}
			return $data;
		    
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getMontessoriExtras($centerid='')
	{
		$url = BASE_API_URL."/observation/getMontessoriExtras/".$this->session->userdata('LoginId')."/".$centerid;
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
			$data=array();
			foreach($jsonOutput as $json)
			{
				$data[$json->idSubActivity][]=$json;
			}
			return $data;
		    
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getMontessoriSubActivites($centerid='')
	{
		$url = BASE_API_URL."/observation/getMontessoriSubActivites/".$this->session->userdata('LoginId')."/".$centerid;
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
			$data=array();
			foreach($jsonOutput as $json)
			{
				$data[$json->idActivity][]=$json;
			}
			return $data;
		    
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getMontessoriActivites($centerid='')
	{
		$url = BASE_API_URL."observation/getMontessoriActivites/".$this->session->userdata('LoginId')."/".$centerid;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL,$url);
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
			$data=array();
			foreach($jsonOutput as $json)
			{
				$data[$json->idSubject][]=$json;
			}
			return $data;
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getMontessoriSubjects()
	{
		$url = BASE_API_URL."/observation/getMontessoriSubjects/".$this->session->userdata('LoginId');
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
			return $server_output;
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function getEylfOutcomes()
	{
		$url = BASE_API_URL."/observation/getEylfOutcomes/".$this->session->userdata('LoginId');
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
			return $server_output;
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}
	
	public function getGroups()
	{
		$url = BASE_API_URL."/observation/getChildrenGroups/".$this->session->userdata('LoginId');
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
			return $server_output;
			curl_close ($ch);
		}
		else if($httpcode == 401){
			return 'failed';
		}
	}

	public function saveImageTags()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $_POST;
			$data['childIds'] = json_decode($data['childIds']);
			$data['educatorIds'] = json_decode($data['educatorIds']);
			$data['userid'] = $this->session->userdata('LoginId');
			// echo json_encode($data);
			// exit();
			$url = BASE_API_URL."/Observation/saveImageTags/";
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
		    if ($httpcode == 200) {
		    	echo $server_output;
		    } else {
		    	redirect('welcome');
		    }
		}else{ 
			redirect('welcome');
		}
	}

	public function getPermissions($user,$centerid)
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['user'] = $user;
			$data['centerid'] = $centerid;
			$url = BASE_API_URL."/Util/getPermissions/";
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
		    $data = json_decode($server_output);
		    curl_close($ch);
		    if ($httpcode == 200) {
		    	return $data;
		    } else {
		    	redirect('welcome');
		    }
		}else{ 
			redirect('welcome');
		}
	}

	public function updateImagePriority()
	{
		if($this->session->has_userdata('LoginId')){
			$data = [];
			$data['priority'] = [];
			$string = json_decode(html_entity_decode(stripslashes($_POST['priority'])));
			$i = 1;
			foreach ($string as $obj) {
				$d['mediaid'] = $obj;
				$d['priority'] = $i;
				array_push($data['priority'],$d);
				$i++;
			}
			$data['userid'] = $this->session->userdata('LoginId');

			$url = BASE_API_URL."Observation/updateImagePriority/";
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
		    $data = json_decode($server_output);
		    curl_close($ch);
		    if ($httpcode == 200) {
		    	echo $server_output;
		    } else {
		    	redirect('welcome');
		    }
		}else{ 
			redirect('welcome');
		}
	}

	public function getObsView()
	{
		if($this->session->has_userdata('LoginId')){
			$data = [];
			$data['userid'] = $this->session->userdata('LoginId');
			$data['observationId'] = 16;

			$url = BASE_API_URL."Observation/getObsView/";
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
		    $data = json_decode($server_output);
		    curl_close($ch);
		    if ($httpcode == 200) {
		    	echo $server_output;
		    } else {
		    	redirect('welcome');
		    }
		}else{ 
			redirect('welcome');
		}
	}

	public function viewChild()
	{
		if($this->session->has_userdata('LoginId')){
			$data = [];
			$data['userid'] = $this->session->userdata('LoginId');
			$data['page'] = isset($_GET['page'])?$_GET['page']:1;
			$data['sort'] = isset($_GET['sort'])?$_GET['sort']:"DESC";
			$data['childid'] = $_GET['childid'];

			$url = BASE_API_URL."Observation/getChildDetails/";
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
		    $data = json_decode($server_output);
		    curl_close($ch);
		    if ($httpcode == 200) {
		    	$output = json_decode($server_output);
		    	$this->load->view("viewChildDetails",$output);
		    } else {
		    	redirect('welcome');
		    }
		}else{ 
			redirect('welcome');
		}
	}

	public function getChildFromCenter()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."Observation/getChildFromCenter/";
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
		    $data = json_decode($server_output);
		    curl_close($ch);
		    if ($httpcode == 200) {
		    	echo $server_output;
		    } else {
		    	redirect('welcome');
		    }
		}else{ 
			redirect('welcome');
		}
	}

	public function getAllMontSubAct()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."Observation/getAllMontSubAct/";
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
		    $data = json_decode($server_output);
		    curl_close($ch);
		    if ($httpcode == 200) {
		    	$jsonOutput=json_decode($server_output);
		    	// $myJsonString = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($jsonOutput->MontessoriList));
				return $jsonOutput;
		    } else {
		    	redirect('welcome');
		    }
		}else{ 
			redirect('welcome');
		}
	}

	public function getAllUsers()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."Observation/getAllChildsAndStaffs/";
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
		    $data = json_decode($server_output);
		    curl_close($ch);
		    if ($httpcode == 200) {
		    	$jsonOutput=json_decode($server_output);
		    	// $myJsonString = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', json_encode($jsonOutput->UsersList));
				return $jsonOutput;
		    } else {
		    	redirect('welcome');
		    }
		}else{ 
			redirect('welcome');
		}
	}

	public function dataready($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	public function observation_child_table(){
		error_reporting(0);
		ini_set('display_errors', 0);
		
		if($this->session->has_userdata('LoginId')){
		  
		  $_POST['usertype']=$this->session->userdata('UserType');
		  $_POST['userid']=$this->session->userdata('LoginId');
		  $centerIds=$this->session->userdata('centerIds');
		  $_POST['centerid']=$centerIds[0]->id;
	
			$url = BASE_API_URL.'observation/child_table_details';
			  
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL,$url);
	
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($_POST));
	
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					  'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
					  'X-Token: '.$this->session->userdata('AuthToken')
				));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$server_output = curl_exec($ch);
				//print_r($server_output);die();
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
				if($httpcode == 200){
				  $jsonOutput = json_decode($server_output);
				  if($jsonOutput->Status == 'Success'){
					$data['table_value']=$jsonOutput->Child_table;
					$data['now_date']=date('Y-m-d');
					$this->load->view('observation_child_table_view',$data);
				  }else{
					$data=['Error'=>'Permission Error'];
					echo json_encode($data);
				  }
				  curl_close ($ch);
				  }
	
				  else if($httpcode == 401){
					return 'error';
				  }
				  
	
				  else{
					return 'error';
				  }
			} else{
			  redirect('welcome');
			}
	
	
	  }


	public function changeObsStatus()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->get();
			if (empty($_GET['obsid']) && empty($_GET['status'])) {
				redirect('Observation');
			}
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."Observation/changeObsStatus/";
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
		    $data = json_decode($server_output);
		    curl_close($ch);
		    if ($httpcode == 200) {
		    	redirect('Observation');
		    } else {
		    	redirect('Observation');
		    }
		}else{ 
			redirect('welcome');
		}
	}

	public function getActTagInfo()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->get();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."Observation/getActTagInfo/";
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
		}else{ 
			redirect('welcome');
		}
	}

	public function getAssessmentSettings($centerid='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['centerid'] = $centerid;
			$url = BASE_API_URL."Observation/getAssessmentSettings";
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
		    $data = json_decode($server_output);
		    curl_close($ch);
		    if ($httpcode == 200) {
		    	$jsonOutput=json_decode($server_output);
				return $jsonOutput;
		    } else {
		    	redirect('welcome');
		    }
		}else{ 
			redirect('welcome');
		}
	}

}  
?>