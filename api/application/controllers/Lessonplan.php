<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Lessonplan extends CI_Controller {

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
		$this->load->model('LessonplanModel');
		$this->load->model('UtilModel');
        $this->load->model('ChildrenModel');
		$this->load->model('MontessoriModel');
		$this->load->model('CentersModel');
		$this->load->helper('url');
		$this->load->database();
        
	}


    // public function getlessondetails(){
             
    //             $headers = $this->input->request_headers();
// $updated_headers = []; // Temporary array to store modified headers

// foreach ($headers as $key => $value) {
//     $lower_key = strtolower($key);

//     // Normalize key names
//     if ($lower_key === 'x-device-id') {
//         $updated_headers['X-Device-Id'] = $value;
//     } elseif ($lower_key === 'x-token') {
//         $updated_headers['X-Token'] = $value;
//     } else {
//         $updated_headers[$key] = $value; // Keep other headers as is
//     }
// }

// // Assign back to $headers
// $headers = $updated_headers;
    //             if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
	// 				$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
	// 				$json = json_decode(file_get_contents('php://input'));
			// if($json){
			// 	$json = $json;
			// 	}else{
			// 		$json = $_POST;
			// 		$json = (object)$_POST;
			// 	}	

	// 				if($json!= null && $res != null && $res->userid == $json->userid){
	// 					if($json->usertype !='Superadmin'){
	// 						$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
	// 					} else {
	// 						$permission->viewlesson='1';
	// 					}

	// 					if ($permission->viewlesson==1) {

	// 						$tempData = [];
	// 						$new_result = [];
	// 						$get_result=$this->LessonplanModel->getlessonprocess($json);
	// 						//print_r($get_result);die();
	// 						foreach($get_result as $child_key=>$child_value){ 
	// 							$new_result[]=$child_value;
	// 						}			

	// 						foreach ($new_result as $result => $res) {
								
	// 							$activity = explode(',',$res->activity);
	// 							$sub_id = explode(',',$res->subactivity);
	// 							$sub_title = explode(',',$res->sub_title);

	// 							for($i=0;$i<count($sub_id);$i++){
	// 								$tempData['activity'] = $activity[$i];
	// 								$tempData['subactivity'] = $sub_id[$i];
	// 								$tempData['sub_title'] = $sub_title[$i];
	// 								$res->child_process[$i] = $tempData;
	// 							}
								
	// 						}

	// 						$data['Status']='Success';
	// 						//$data['process_plan']=$get_result;
	// 						// $data['child_count']=count($get_result);
	// 						$data['child_count'] = isset($get_result) ? count($get_result) : 0;

	// 						$data['new_process']=$new_result;
	// 						//$data['new_process_web']=$get_result;

						
	// 					}
	// 					else{
	// 						$data['Status']='ERROR';
	// 						$data['Message']="Permission Error..";
	// 					}
						
	// 					echo json_encode($data);
	// 					http_response_code(200);

	// 				}else{
	// 						$data['Status']='ERROR';
	// 						$data['Message']="Permission Error.";
							
	// 						echo json_encode($data);
	// 						http_response_code(200);
	// 					}
    //             }else{
    //                 http_response_code(401);
    //             }
            
    // }

	public function getlessondetails()
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
		// print_r(file_get_contents('php://input')); exit;
		if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			
			if ($json != null && $res != null && $res->userid == $json->userid) {
				if ($json->usertype != 'Superadmin') {
					//echo "$json->userid ==== $json->centerid"; exit;
					$permission = $this->UtilModel->getPermissions($json->userid, $json->centerid);
					//print_r($permission); exit;
				} else {
					$permission = new stdClass();
					$permission->viewlesson = '1';
				}
			
				if ($permission->viewlesson == 1) {
					$tempData = [];
					$new_result = [];
					$get_result = $this->LessonplanModel->getlessonprocess($json);

					foreach ($get_result as $child_value) {
						$new_result[] = $child_value;
					}

					foreach ($new_result as $res) {
						$activity = explode(',', $res->activity);
						$sub_id = explode(',', $res->subactivity);
						$sub_title = explode(',', $res->sub_title);

						for ($i = 0; $i < count($sub_id); $i++) {
							$tempData['activity'] = $activity[$i];
							$tempData['subactivity'] = $sub_id[$i];
							$tempData['sub_title'] = $sub_title[$i];
							$res->child_process[$i] = $tempData;
						}
					}

					$data['Status'] = 'Success';
					$data['new_process'] = $new_result;
					$data['child_count'] = isset($get_result) ? count($get_result) : 0; // Ensure child_count exists

				} else {
					$data['Status'] = 'ERROR';
					$data['Message'] = "Permission Error...";
				}

				echo json_encode($data);
				http_response_code(200);
			} else {
				$data['Status'] = 'ERROR';
				$data['Message'] = "Permission Error.";
				echo json_encode($data);
				http_response_code(200);
			}
		} else {
			http_response_code(401);
		}
    }


	public function getlessoncenter(){
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
			$data['center'] = $this->CentersModel->get_center_details();

			echo json_encode($data);
			http_response_code(200);
			

		}else{
			http_response_code(401);
		}
	}

	public function getlessonstatusdetails() {
		try {
			$headers = $this->input->request_headers();
			$updated_headers = [];
	
			foreach ($headers as $key => $value) {
				$lower_key = strtolower($key);
	
				if ($lower_key === 'x-device-id') {
					$updated_headers['X-Device-Id'] = $value;
				} elseif ($lower_key === 'x-token') {
					$updated_headers['X-Token'] = $value;
				} else {
					$updated_headers[$key] = $value;
				}
			}
	
			$headers = $updated_headers;
	
			if ($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)) {
				$this->load->model('loginModel');
				$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);
				$json = json_decode(file_get_contents('php://input'));
	
				if (!$json) {
					$json = (object)$_POST;
				}
	
				if ($json != null && $res != null && $res->userid == $json->userid) {
	
					if ($json->usertype != 'Superadmin') {
						$permission = $this->UtilModel->getPermissions($json->userid, $json->centerid);
					} else {
						$permission = new stdClass();
						$permission->editlesson = '1';
					}
	
					if ($permission->editlesson == 1) {
						$get_result = $this->LessonplanModel->getlessonstatusupdate($json);
						$data['Status'] = 'Success';
						// You can include $get_result in the response if needed
					} else {
						$data['Status'] = 'ERROR';
						$data['Message'] = "Permission Error.";
					}
	
					echo json_encode($data);
					http_response_code(200);
				} else {
					http_response_code(403);
					echo json_encode(['Status' => 'ERROR', 'Message' => 'Unauthorized access.']);
				}
	
			} else {
				http_response_code(401);
				echo json_encode(['Status' => 'ERROR', 'Message' => 'Missing headers.']);
			}
	
		} catch (Exception $e) {
			log_message('error', 'Lesson Status Error: ' . $e->getMessage());
			http_response_code(500);
			echo json_encode(['Status' => 'ERROR', 'Message' => 'Internal Server Error']);
		}
	}
	

	public function printlessonPDF($get_mode=null){
		
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
			 $res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json){
				$json = $json;
				}else{
					$json = $_POST;
					$json = (object)$_POST;
				}
			
// print_r($res);
// print_r($json); exit;
			 if($json != null && $res != null && $res->userid == $json->userid){
			
				// if(trim($json->usertype)=='Staff'){
				// 	$permission = $this->UtilModel->getPermissions($json->userid,$json->centerid);
				// } else {
				// 	$permission->printpdflesson = 1;
				// }
// print_r($permission); exit;
				

				// if ($permission->printpdflesson==1) {
					if(trim($json->usertype)=='Parent'){
						$get_result=$this->LessonplanModel->getpdfdata($json);
					}else{
						$get_result=$this->LessonplanModel->getpdfdata($json);
					}
					
					$data['pass_value']=$get_result;
					$data['file'] = uniqid().".pdf";
					$this->load->view('lessonPdf',$data);
					$data['path'] = base_url('api/uploads/pdfs/');
					$data['Status']='Success';
					
				//	print_r($data);die();
					echo json_encode($data);
					http_response_code(200);
					
					
				// }else{
				// 	$data['Status']='ERROR';
				// 	$data['Message']="Permission Error.";
				// 	echo json_encode($data);
				// 	http_response_code(200);
					
				// }
				
			 }
		 }
		 else{
		 	http_response_code(401);
		 }
	}

	
}