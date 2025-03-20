<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Progressplan extends CI_Controller {

	function __construct() {
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
		die();
		}
		parent::__construct();
		$this->load->model('loginModel');
		$this->load->model('ProgressPlanModel');
		$this->load->model('UtilModel');
        $this->load->model('ChildrenModel');
		$this->load->model('MontessoriModel');
		$this->load->model('CentersModel');
        
	}


    public function getProgresschild(){
        
		$data['center'] = $this->CentersModel->get_center_details();
        $data['child'] = $this->ChildrenModel->getChilds();
		$data['montessorisubactivity'] = $this->MontessoriModel->Montessori_sub_detail();
        
        http_response_code(200);
				echo json_encode($data);
    }

    public function getProgressplandetails(){
		
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		//print_r($headers);
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			//print_r($res);
			$json = json_decode(file_get_contents('php://input'));
			
			if($json!= null && $res != null && $res->userid == $json->userid){
				//print_r($json);
				if(trim($json->usertype)=='Staff'){
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
				} else {
					$permission->viewprogress='1';
				}
				//print_r($json);
				
				if ($permission->viewprogress==1) {
					
					$new_result=$new=$concat=[];
					
					if(trim($json->usertype)=='Parent'){
						$get_result=$this->ProgressPlanModel->getprocessplan($json); 

					}else{
						$get_result=$this->ProgressPlanModel->getprocessplan($json);
					}
				    
					
					

					foreach($get_result as $child_key=>$child_value){ 
						$new_result[]=$child_value;
						if($child_value->process_status!='' && $child_value->subid!=''){
							$child_status=explode(',',$child_value->process_status);
							$child_sub=explode(',',$child_value->subid);
	
							for($i=0;$i<count($child_status);$i++){
								
								//$new_result[$child_value->child_name][$child_sub[$i]]=$child_status[$i];
								$new_result[$child_value->child_name.'_'.$child_value->child_id][$child_sub[$i]]=$child_status[$i];
								
							}
							
						}
						
						

					}
					

					$data['Status']='Success';
					$data['process_plan']=$get_result;
					$data['child_count']=count($get_result);

					$data['new_process']=$new_result;
					$data['montessorisubactivity'] = $this->MontessoriModel->Montessori_sub_detail();
					
				}else{
					$data['Status']='ERROR';
					$data['Message']="Permission Error.";
				}
				http_response_code(200);
				
				echo json_encode($data);
			}
			
			
		}
		else{
			http_response_code(401);
		}

	}
	
		public function getstatusprogress_details(){
			
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			
			$this->load->model('loginModel');
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			
			if($json!= null && $res != null && $res->userid == $json->userid){
				
				if(trim($json->usertype)=='Staff'){
					
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);

				} else {
					
					$permission->viewprogress='1';
				}
				
				
				if ($permission->viewprogress==1) {
					
				    $new_result=$new=$concat=[];

					if(trim($json->usertype)=='Parent'){
						
						$get_result=$this->ProgressPlanModel->get_status_parent_details($json); 
					}
					else {
						$get_result=$this->ProgressPlanModel->get_status_details($json); 
					}

					
					
					foreach($get_result as $child_key=>$child_value){ 
						$new_result[]=$child_value;
						if($child_value->process_status!='' && $child_value->subid!=''){
							$child_status=explode(',',$child_value->process_status);
							$child_sub=explode(',',$child_value->subid);
	
							for($i=0;$i<count($child_status);$i++){
								//$new_result[$child_value->child_name][$child_sub[$i]]=$child_status[$i];
								$new_result[$child_value->child_name.'_'.$child_value->child_id][$child_sub[$i]]=$child_status[$i];
								
							}
						}
						
						

					}
					
					$data['Status']='Success';
					$data['process_plan']=$get_result;
					$data['child_count']=count($get_result);

					$data['new_process']=$new_result;
					$data['montessorisubactivity'] = $this->MontessoriModel->Montessori_sub_detail();

					

				}else{
					$data['Status']='ERROR';
					$data['Message']="Permission Error.";
				}
				http_response_code(200);
				
				echo json_encode($data);
			}
			
			
		}
		else{
			http_response_code(401);
		}

	}

	public function createPlan()
	{
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){

			$this->load->model('loginModel');
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));

			if($json!= null && $res != null && $res->userid == $json->userid){
			
				if($json->usertype !='Superadmin'){
					
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
				} else {
					$permission->addprogress='1';
				}
				
				
				if ($permission->addprogress==1) {

				    $get_result=$this->ProgressPlanModel->createPlan($json);
					$data['Status']=$get_result;
				}else{
					$data['Status']='ERROR';
					$data['Message']="Permission Error.";
				}
				http_response_code(200);
				
				echo json_encode($data);
			}
			
			
		}
		else{
			http_response_code(401);
		}
	}

	public function updatePlan()
	{
		
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			
			$this->load->model('loginModel');
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			
			$json = json_decode(file_get_contents('php://input'));
			
			
			
			if($json!= null && $res != null && $res->userid == $json->userid){
			
				if($json->usertype !='Superadmin'){
					$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
					
				} else {
					$permission->editprogress='1';
				}				
				
				if ($permission->editprogress==1) {
					
					
				    $get_result=$this->ProgressPlanModel->updatePlan($json);
					
					$data['Status']=$get_result;
				}else{
					$data['Status']='ERROR';
					$data['Message']="Permission Error.";
				}
				echo json_encode($data);
				http_response_code(200);
				//print_r($data);
				
			}
			
			
		}
		else{
			http_response_code(401);
		}
	}
	
	
	/* Sagar's Code */
	public function fetchProgressPlanInfo()
	{
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('loginModel');
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			// var_dump($json);
			if($json!= null && $res != null && $res->userid == $json->userid){
				if (!empty($json->centerid) && is_numeric($json->centerid)) {
					$centerid = ceil($json->centerid);
					$montessoriList = $this->ProgressPlanModel->getCenterMontessoriList($centerid);

					// echo $res->usertype;exit;
					if($json->usertype == "Parent"){
						$childrenList = $this->ProgressPlanModel->getParentChildrenList($res->userid);

					}	
					else{
						$childrenList = $this->ProgressPlanModel->getCenterChildrenList($centerid);
					}
					// var_dump($childrenList);exit;
					$tableData = [];
					foreach ($montessoriList as $monkey => $monobj) {
						$records = [];
						$records['id'] = $monobj->id;
						$records['title'] = $monobj->title;
						$records['childList'] = [];
						foreach ($childrenList as $childkey => $childObject) {
							$checkDetailsArr = $this->ProgressPlanModel->checkMontessoriProgress($monobj->id,$childObject->childid);
							$childList = [];
							$childList['childid'] = $childObject->childid;
							$childList['firstname'] = $childObject->name;
							$childList['imageUrl'] = $childObject->imageUrl;
							$childList['status'] = isset($checkDetailsArr->status)?$checkDetailsArr->status:NULL;
							$childList['created_by'] = isset($checkDetailsArr->created_by)?$checkDetailsArr->created_by:NULL;
							array_push($records['childList'],$childList);
						}
						array_push($tableData,$records);
					}

					$data['Status'] = "SUCCESS";
					$data['montessoriList'] = $montessoriList;
					$data['childrenList'] = $childrenList;
					$data['tableData'] = $tableData;
				}else{
					$data['Status'] = 'ERROR';
					$data['Message'] = 'Center id is required & should be a number!';
				}
			}else{
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Userid is invalid!';
			}
		}else{
			$data['Status'] = 'ERROR';
			$data['Message'] = 'Invalid headers used!';
		}
		echo json_encode($data);
	}

	public function updateValue()
	{
		$headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$this->load->model('loginModel');
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$bySomeone = 0;
				if(empty($json->childid) || empty($json->montessoriid)){
					http_response_code(401);
					$data['Status'] = 'ERROR';
					$data['Message'] = 'Montessori ID and Child ID is required!';
				}else{
					$monid = $json->montessoriid;
					$childid = $json->childid;
					$checkRecord = $this->ProgressPlanModel->checkMontessoriProgress($monid,$childid);
					if(empty($checkRecord)){
						//No record exists, create a new entry
						$getSubActInfo = $this->ProgressPlanModel->getSubActInfo($monid);
						if(empty($getSubActInfo)){
							http_response_code(401);
							$data['Status'] = 'ERROR';
							$data['Message'] = 'Montessori id is invalid!';
						}else{
							$demo = new stdClass();
							$demo->childid = $childid;
							$demo->activityid = $getSubActInfo->idActivity;
							$demo->subid = $monid;
							if ($json->plan == 0) {
								$demo->status = "Introduced";
							} else {
								$demo->status = "Planned";
							}
							$demo->created_by = $json->userid;
							$demo->created_at = date('Y-m-d h:i:s');
							$demo->updated_by = NULL;
							$demo->updated_at = NULL;
							$response = $this->ProgressPlanModel->insertChildProgress($demo);
							$data['Status'] = 'SUCCESS';
							$data['Response'] = $response;
						}
					}else{
						//Record exists update the old record
						
						if ($json->plan == 0) {
							switch ($checkRecord->status) {
								case 'Introduced':
	                                $class = "Working";
	                                break;

	                            case 'Needs More':
	                                $class = "";
	                                break;

	                            case '':
	                                $class = "Introduced";                                                          
	                                break;

	                            case 'Working':
	                                $class = "Completed";
	                                break;

	                            case 'Completed':
	                                $class = "Needs More";
	                                break;
	                            
	                            default:
	                                $class = "Introduced";
	                                break;
							}
						}else{
							if ($checkRecord->status != "Planned" && $checkRecord->status != "") {
								$class = $checkRecord->status;
							}else if ($checkRecord->status == "Planned"){
								if($json->userid==$checkRecord->created_by){
									$class = "";
								}else{
									$class = "Planned";
									$bySomeone = 1;
								}
							}else{
								$class = "Planned";
							}
						}
						$demo = new stdClass();
						$demo->childid = $childid;
						$demo->subid = $monid;
						$demo->status = $class;
						$demo->updated_by = $json->userid;
						$demo->updated_at = date('Y-m-d h:i:s');
						$affeRows = $this->ProgressPlanModel->updateChildProgress($demo);
						if (empty($affeRows)) {
							$response = NULL;
						}else{
							$response = $this->ProgressPlanModel->checkMontessoriProgress($monid,$childid);
						}
						$data['Status'] = 'SUCCESS';
						$data['Response'] = $response;
					}
				}
			}else{
				http_response_code(401);
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Userid is invalid!';
			}
		}else{
			http_response_code(401);
			$data['Status'] = 'ERROR';
			$data['Message'] = 'Invalid headers used!';
		}
		echo json_encode($data);
	}
}