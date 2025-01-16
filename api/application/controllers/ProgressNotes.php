<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ProgressNotes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('PreogressModel');
		$this->load->model('LoginModel');

        header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {die();}
        
    }
 
    public function getAllProgressNotes()
    {
    	$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				//fetching all progress notes
				$records = $this->PreogressModel->getCenterProgressNotes($json->centerid);
				if ($records) {
					foreach ($records as $reckey => $recobj) {
						//adding user details
						$userobj = $this->PreogressModel->getUserDetails($recobj->created_by);
						$recobj->name = empty($userobj->name)?"Unknown":$userobj->name;
						$recobj->image = empty($userobj->imageUrl)?"AMIGA-Montessori.jpg":$userobj->imageUrl;
					}
				}
				$data['Status'] = 'SUCCESS';
	        	$data['records']=$records;				
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = "Userid didn't match";
			}
		}else{
			http_response_code(401);
			$data['Status'] =  'ERROR';
			$data['Message'] = 'Invalid headers sent';
		}
		echo json_encode($data);
    }

    public function getProgressNote()
    {
    	$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$record = $this->PreogressModel->getProgressNote($json->pnid);
				$data['Status'] = 'SUCCESS';
	        	$data['records']=$record;
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = 'Userid didn\'t match';
			}
		}else{
			http_response_code(401);
			$data['Status'] =  'ERROR';
			$data['Message'] = 'Invalid headers sent.';
		}
		echo json_encode($data);
    }

    public function addProgressNote()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				//Write your code within this block
				$records = $this->PreogressModel->addProgressNote($json); 
				
				if($records){
					#Populate data and share
					http_response_code(200);
					$data['Status']="SUCCESS";
					$data['Message']='Record saved successfully';
					
				}else{
					http_response_code(401);
					$data['Status'] =  'ERROR';
					$data['Message'] = 'Record not saved!';
				}
				
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = 'Userid didn\'t match';
			}
		}else{
			http_response_code(401);
			$data['Status'] =  'ERROR';
			$data['Message'] = 'Invalid headers sent.';
		}
		echo json_encode($data);
	}

	public function updateProgressNote()
	{   
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
		
			if($json!= null && $res != null && $res->userid == $json->userid){
				
				//Write your code within this block
				$records = $this->PreogressModel->updateProgressNote($json);
				
				if($records){
					#Populate data and share
					http_response_code(200);
					$data['Status']="SUCCESS";
					$data['Message']='Record saved successfully';
				}else{
					http_response_code(401);
					$data['Status'] =  'ERROR';
					$data['Message'] = 'Record not saved!';
				}				
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = 'Userid didn\'t match';
			}
		}else{
			http_response_code(401);
			$data['Status'] =  'ERROR';
			$data['Message'] = 'Invalid headers sent.';
		}
		echo json_encode($data);
	}

	public function deleteProgressNote()
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				//Write your code within this block
				$records = $this->PreogressModel->deleteProgressNote($json->pnid);
				if($records){
					#Populate data and share
					http_response_code(200);
					$data['Status']="SUCCESS";
					$data['Message']='Record deleted successfully';
				}else{
					http_response_code(401);
					$data['Status'] =  'ERROR';
					$data['Message'] = 'Record not deleted!';
				}
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = 'Userid didn\'t match';
			}
		}else{
			http_response_code(401);
			$data['Status'] =  'ERROR';
			$data['Message'] = 'Invalid headers sent.';
		}
		echo json_encode($data);
	}

	public function getChildProgressNotes()
    {
    	$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$record = $this->PreogressModel->getChildProgressNotes($json->childid);
				foreach ($record as $key => $obj) {
					$userobj = $this->PreogressModel->getUserDetails($obj->created_by);
					$obj->name = empty($userobj->name)?"Unknown":$userobj->name;
					$obj->image = empty($userobj->imageUrl)?"AMIGA-Montessori.jpg":$userobj->imageUrl;
					
				}
				$data['Status'] = 'SUCCESS';
	        	$data['records']=$record;
			}else{
				http_response_code(401);
				$data['Status'] =  'ERROR';
				$data['Message'] = 'Userid didn\'t match';
			}
		}else{
			http_response_code(401);
			$data['Status'] =  'ERROR';
			$data['Message'] = 'Invalid headers sent.';
		}
		echo json_encode($data);
    }

}
?>