<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class Progressplan extends CI_Controller {  


		public function __construct(){
			parent::__construct();
			$this->load->helper('Get_details');
		}
      
    public function index()  
    {
  	  if($this->session->has_userdata('LoginId')){
        $url = BASE_API_URL.'Progressplan/getProgresschild';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                      'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
                      'X-Token: '.$this->session->userdata('AuthToken')
              ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            // var_dump($server_output);
            // exit();
              $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
              
            if($httpcode == 200){
              $jsonOutput = json_decode($server_output);
              
              curl_close ($ch);
              $child_source = $jsonOutput->child;
              $subactivity_source = $jsonOutput->montessorisubactivity;

              $child_get=$chil_name=$montessorisubactivity=[];
				//$image = base_url('api/assets/media').'/depositphotos_17140201-stock-photo-group-of-pupils.jpg';
				
                foreach($child_source as $key=>$val){
					//$image = base_url('api/assets/media/').$val->imageUrl;
                  $child_get[]="<th id='".$val->id."' class='".$val->name."'><img src='".$val->imageUrl."' style='padding-left: 36%;width: 3.0em;'>".$val->name."</th>";
              	  $child_name[]=$val->id;
                }
              
              
        
			}
			else if($httpcode == 401){
				return 'error';
			}
        $data['child'] = $child_get;
        $data['child_name'] = $child_name;
        $data['montessorisubactivity'] = $subactivity_source;
            $this->load->view('progressplan',$data);
			
	  	}else{ 
		  	$this->load->view('welcome');
		  }
    }

	public function add()
	{

		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST') {

			  $data = $this->input->post();
			  $data['usertype']=$this->session->userdata('UserType');
			  $data['created']=$this->session->userdata('LoginId');
			  $data['userid']=$this->session->userdata('LoginId');
			  
			  	$cen = $this->session->userdata('centerIds');
				$data['centerid'] = $cen[0]->id;
			  
				$url = BASE_API_URL.'Progressplan/createPlan';
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
				
					echo $server_output;
					curl_close ($ch);
					
				}
				else if($httpcode == 401){
					echo  'error';
				}
			}
			else{
				$this->getForm();
			}

	    }else{
			redirect('welcome');
	    }
		
	}

	public function edit(){
		
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST') {

			  $data = $this->input->post();
			  $data['created']=$this->session->userdata('LoginId');
			  $data['usertype']=$this->session->userdata('UserType');
			  $data['userid']=$this->session->userdata('LoginId');
			  
			  	$cen = $this->session->userdata('centerIds');
				$data['centerid'] = $cen[0]->id;
				
			  

				$url = BASE_API_URL.'Progressplan/updatePlan';
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
				
					echo $server_output;
					curl_close ($ch);
					
				}
				else if($httpcode == 401){
					echo  'error';
				}
			}
			else{
				$this->getForm();
			}

	    }else{
			redirect('welcome');
	    }
	}


    public function get_process_child(){

      $url = BASE_API_URL.'Progressplan/getProgresschild';
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
        $center_source = $jsonOutput->center;
        curl_close ($ch);
        
        $center = array();

          foreach($center_source as $key=>$val){
                $center[]="<option id='".$val->id."' value='".$val->id."' >".$val->centerName."</option>";
          }
        
        
        echo json_encode($center);
				
			  
			}
			else if($httpcode == 401){
				return 'error';
			}
    }

	public function getchilddetails(){

		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST') {
				
				$_POST['usertype']=$this->session->userdata('UserType');

				
				$_POST['userid']=$this->session->userdata('LoginId');
				
				$cen = $this->session->userdata('centerIds');
				$_POST['centerid'] = $cen[0]->id;
				
				//print_r($_POST);

						$url = BASE_API_URL.'Progressplan/getProgressplandetails';
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
						
							curl_close ($ch);
							$child_name=$child_get=[];
							$child_source=$jsonOutput->process_plan;
							$subactivity_source = $jsonOutput->montessorisubactivity;
							$new_child=$jsonOutput->new_process;
							$new_count=$jsonOutput->child_count;
							

							foreach($child_source as $key=>$val){
                  					$child_get[]="<th id='".$val->child_id."' class='".$val->child_name."'><img src='".$val->child_imageUrl."'>".$val->child_name."</th>";
									  $child_name[]=$val->child_id;
									  
                			}
						
				}

				else if($httpcode == 401){
					return 'error';
				}
				

				else{
					$this->getForm();
				}
				
				
				
				$data['child'] = $child_get;
				
				$data['progressplan']=$new_child;
				$data['child_name'] = $child_name;
				$data['data_child'] = $new_count;
				$data['montessorisubactivity']=$subactivity_source;
				
				$data['statusplan']=array(
					''=>'',
					'Introduced'=>'#FFF505',
					'Working'=>'#2778AF',
					'Completed'=>'#F97E7F',
					'Needs More'=>'#FF8A00'
				);
				
				 $this->load->view('progressplantable_view',$data);
		
			}
			else{
				redirect('welcome');
			}
		}
		else{
			redirect('welcome');
		}

	}


	public function getbulkchilderndetails(){
		
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST') {
				
				$_POST['usertype']=$this->session->userdata('UserType');

				
				$_POST['created_by']=$this->session->userdata('Name');
				$_POST['userid']=$this->session->userdata('LoginId');
				
				$cen = $this->session->userdata('centerIds');

				$_POST['centerid'] = $cen[0]->id;
				
				//print_r($_POST);die();
				
						$url = BASE_API_URL.'Progressplan/getstatusprogress_details';
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

						
						$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
						
						if($httpcode == 200){
							$jsonOutput = json_decode($server_output);
						
							curl_close ($ch);
							$child_name=$child_get=[];
							$child_source=$jsonOutput->process_plan;
							$subactivity_source = $jsonOutput->montessorisubactivity;
							$new_child=$jsonOutput->new_process;
							$new_count=$jsonOutput->child_count;
							

							foreach($child_source as $key=>$val){
                  					$child_get[]="<th id='".$val->child_id."' class='".$val->child_name."'><img src='".$val->child_imageUrl."'>".$val->child_name."</th>";
									  $child_name[]=$val->child_id;
									  
                			}
						
				} 
				else if($httpcode == 401){
					return 'error';
				}
				

				else{
					return 'error';
				}
				
				$data['child'] = $child_get;
				
				$data['progressplan']=$new_child;
				$data['child_name'] = $child_name;
				$data['data_child'] = $new_count;
				$data['montessorisubactivity']=$subactivity_source;
				
				$data['statusplan']=array(
					''=>'',
					'Introduced'=>'#FFF505',
					'Working'=>'#2778AF',
					'Completed'=>'#F97E7F',
					'Needs More'=>'#FF8A00'
				);
				 $this->load->view('progressplantable_view',$data);
		
			}
			else{
				redirect('welcome');
			}
		}
		else{
			redirect('welcome');
		}

	}

	/* sagar's code */

	public function list()
	{
		
		if ($this->session->has_userdata('LoginId')) {
			//echo "hhhhhhh"; exit;
			$data = $this->input->get();
			if(isset($_GET['centerid'])){
				$centerid = $this->input->get('centerid');
			}else{
				$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
			}
			$data['centerid'] = $centerid;
			$data['usertype']=$this->session->userdata('UserType');
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'Progressplan/fetchProgressPlanInfo';
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
			// print_r($server_output);exit;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			//echo $httpcode; exit;
			if ($httpcode == 200) {
				$jsonOutput = json_decode($server_output,true);
				$jsonOutput['centerid'] = $centerid;
				$this->load->view('progressplan_v3', $jsonOutput);
			} else {
				redirect('Welcome');
			}			
		} else {
			redirect('Welcome');
		}
	}

	public function updateCell()
	{
		if ($this->session->has_userdata('LoginId')) {
			$data = $this->input->post();			
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'Progressplan/updateValue';
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
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			echo $server_output;		
		} else {
			redirect('Welcome');
		}

	}

}

