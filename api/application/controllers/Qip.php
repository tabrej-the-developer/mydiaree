<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Qip extends CI_Controller {

	function __construct() {
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
		die();
		}
		parent::__construct();
		$this->load->model('QipModel','qipModel');
		$this->load->model('ObservationModel');
		$this->load->model('LoginModel','loginModel');
		$this->load->model('UtilModel','utlm');
	}

	public function index(){
	}

	public function getQipForm($user_id,$centerid=null,$qipId=null)
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
			if($user_id!= null && $res != null && $res->userid == $user_id){
				if($qipId == null)
				{
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid User Account!";
				}else{
					//Permission code start
					$userArr = $this->loginModel->getUserFromId($user_id);
					if ($userArr->userType == "Superadmin") {
						//If user is a superadmin
	                    $permissions = $this->utlm->getEveryPermission();
	                }else{
	                    if ($userArr->userType == "Staff") {
	                    	//If user is a staff
	                        $permissions = $this->utlm->getPermissions($user_id,$centerid);
	                        if (empty($permission)) {
	                        	$permissions = $this->utlm->getNoPermission();
	                        }
	                    }else{
	                        $permissions = $this->utlm->getNoPermission();
	                    }
	                }

	                $qip = $this->qipModel->getQip($qipId,$centerid);

					$areas = $this->qipModel->getQipAreas();
					foreach ($areas as $areasKey => $areasObj) {
						$totalEmts = $this->qipModel->getTotalElements($areasObj->id);
						$noofelements = (int)$totalEmts->totalElements;
						$allElmId = $this->qipModel->getAreaElementsId($areasObj->id);
						$availElement = 0;
						foreach ($allElmId as $elemtKey => $elemtObj) {
							$ppnotescount = $this->qipModel->getProgressCount($qipId,$elemtObj->id);
							$commentscount = $this->qipModel->getElementCommentsCount($qipId,$elemtObj->id);
							$issuescount = $this->qipModel->getElementIssueCount($qipId,$elemtObj->id);

							if ($ppnotescount->totalRows) {
								$availElement = $availElement + 1;
							}elseif($commentscount->totalRows){
								$availElement = $availElement + 1;
							}elseif($issuescount->totalRows){
								$availElement = $availElement + 1;
							}else{
								$availElement = $availElement + 0;
							}							
						}					
						$areasObj->resultPer = ceil(($availElement / (int)$totalEmts->totalElements) * 100);					
					}
					
					$data['Status'] = "SUCCESS"; 
					$data['name']=$qip->name;
					$data['qip'] = $qip;
					$data['areas'] = $areas;
					$data['permissions'] = $permissions;
				}
				
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			http_response_code(401);
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function  getQipDetils($user_id,$qipId)
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
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('qipModel');
				
					
					$data['qip']=$this->qipModel->getQip($qipId);
					$values=$this->qipModel->getQipStandardvalues($qipId);
					foreach($values as $value)
					{
						$data['values'][$value->standardId]=$value;
					}
					$data['name']=$data['qip']->name;				
					$areavalues=$this->qipModel->getQipAreaValues($qipId);
					$data['previews']=array();
				foreach($areavalues as $areavalue)
				{
					$standards=$this->qipModel->getQipAreaStandards($areavalue->areaId);
					$filter_data=array('filter_qip'=>$qipId,
									   'filter_area'=>$areavalue->areaId);
					$planes=$this->qipModel->getQipImpPlan($filter_data);
					$areavalue->standards=$standards;
					$areavalue->planes=$planes;
					$data['previews'][]=$areavalue;
				}
				$data['Status'] = 'SUCCESS';
				http_response_code(200);
				echo json_encode($data);
			}else{
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid";
			}
		}else{
			http_response_code(401);
		}
	}

	public function  getAreaDetails($user_id,$id,$qipId=null)
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
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$this->load->model('qipModel');
			    $standards=$this->qipModel->getQipAreaStandards($id);
				$data['area']=$this->qipModel->getQipArea($id);
				$data['laws']=$this->qipModel->getAreaNationLaw($id);
				$name=$this->qipModel->getQipName(date('Y-m'));
				$data['name']=($name)?date('F Y',strtotime(date('Y-m-d'))).' '.$name:date('F Y',strtotime(date('Y-m-d')));
				$data['previews']=array();
				if($qipId)
				{
					$filter_data=array('filter_qip'=>$qipId,
									   'filter_area'=>$id);
					$data['areavalues']=$this->qipModel->getQipAreaValue($filter_data);
					$data['qip']=$this->qipModel->getQip($qipId);
					$values=$this->qipModel->getQipStandardvalues($qipId);
					foreach($values as $value)
					{
						$data['values'][$value->standardId]=$value;
					}
					$data['name']=$data['qip']->name;
					$data['planes']=$this->qipModel->getQipImpPlan($filter_data);
					$areavalues=$this->qipModel->getQipAreaValues($qipId);
					
					foreach($areavalues as $areavalue)
					{
						$standards=$this->qipModel->getQipAreaStandards($areavalue->areaId);
						$filter_data=array('filter_qip'=>$qipId,
										   'filter_area'=>$areavalue->areaId);
						$planes=$this->qipModel->getQipImpPlan($filter_data);
						$areavalue->standards=$standards;
						$areavalue->planes=$planes;
						$data['previews'][]=$areavalue;
					}
				}
				$data['standards']=array();
				foreach($standards as $standard)
				{
					$elements=$this->qipModel->getQipStandardElements($standard->id);
					$standard->elements=$elements;
					$data['standards'][]=$standard;
				}
				$data['Status'] = 'SUCCESS'; 
				http_response_code(200);
			} else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function  getQips($user_id,$centerid)
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
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$permissions = $this->utlm->getPermissions($user_id,$centerid);
			    $qips = $this->qipModel->getQips($centerid);
				$data['Status'] = "SUCCESS";
				$data['qips'] = $qips;
				$data['permissions'] = $permissions;
				http_response_code(200);
			}else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function createQIP()
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
				
			    $id=$this->qipModel->createQIP($json);
				http_response_code(200);
				$data['Status']='SUCCESS';
				$data['id']=$id;
			}else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid";
			}
		}
		else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
				echo json_encode($data);
	}

	public function updateQIP()
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
				$this->load->model('qipModel');
			    $id=$this->qipModel->updateQIP($json);
				http_response_code(200);
				$data['Status']='Success';
				$data['id']=$id;
				echo json_encode($data);
			}else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid";
			}
		}
		else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}
	
	public function  delete($user_id,$id)
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
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($user_id!= null && $res != null && $res->userid == $user_id){
				$qipObj = $this->qipModel->getQip($id);
				$usr = $this->loginModel->getUserFromId($user_id);
				if ($usr->userType == "Superadmin") {
					$run = 1;
				} else {
					if ($usr->userType == "Staff") {

						$prm = $this->utlm->getPermissions($user_id,$qipObj->centerId);
						
						if ($prm->deleteQIP == 1) {
							$run = 1;
						} else {
							$run = 0;
						}
						
					} else {
						$run = 0;
					}
				}

				if ($run==1) {
					$this->qipModel->deleteQip($id);
					$data['Status']='SUCCESS';
					$data['Centerid'] = $qipObj->centerId;
					$data['Message'] = "QIP Deleted Successfully!";
				} else {
					$data['Status'] = "ERROR";
					$data['Message'] = "Permission denied!";
				}
			}else {
				http_response_code(401);
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Userid!";
			}
		}
		else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}	

	public function printPDF($userid)
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
		$this->load->model('loginModel');
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$json = json_decode(file_get_contents('php://input'));
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($json != null  && $res->userid == $userid){
				// $data['areas']=isset($post['areas'])?$post['areas']:array();
				// $data['pn']=isset($post['plan'])?$post['plan']:array();
				// $data['sta']=isset($post['sta'])?$post['sta']:array();
				$this->load->library('M_pdf');
				$mpdf = $this->m_pdf->load([
				  'mode' => 'utf-8',
				  'format' => 'A4'
				]);	
				$html = $this->load->view('qip_printpdf',$json,true);
				$mpdf->WriteHTML($html);
				$pdfId = uniqid().'_pdf';
			  $mpdf->Output('../assets/'.$pdfId.'.pdf','F');
				// print_r(json_encode($json));
				$data = array(
					'Status' => 'SUCCESS',
					'Message' => 'PDF Created Successfully',
					'FileName' => "$pdfId.pdf"
				);
				http_response_code(200);
			}else{
				$data = array(
					'Status' => 'ERROR',
					'Message' =>  'PDF could not be created'
				);
				http_response_code(401);
			}
			echo json_encode($data);
		}
	}

	public function emailQIP($userid){
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
		$this->load->model('loginModel');
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$json = json_decode(file_get_contents('php://input'));
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($json != null  && $res->userid == $userid){
				$this->load->library('M_pdf');
				$mpdf = $this->m_pdf->load([
				   'mode' => 'utf-8',
				   'format' => 'A4'
				]);
				$html = $this->load->view('qip_printpdf',$json,true);
				// print_r($html);
				$html = $this->load->view('qip_printpdf',$html,true);
				$mpdf->WriteHTML($html);
				$attach_pdf_multipart = chunk_split( base64_encode( $mpdf->Output( 'qip.pdf', 'S' ) ) );
				//print_r($data->sta);
				$to = $json->email;
		        //define the subject of the email 
		        $subject = 'QIP'; 
		        //create a boundary string. It must be unique 
		        //so we use the MD5 algorithm to generate a random hash 
		        $random_hash = md5(date('r', time())); 
		        //define the headers we want passed. Note that they are separated with \r\n 
		        $headers = "From: Mykronicle@noreply.com\r\nReply-To: Mykronicle@noreply.com"; 
		        //add boundary string and mime type specification 
		        $headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";
		        $msg='';
		        $msg .= "Content-Type: application/octet-stream; name=\"qip.pdf\"\r\n";
		        $msg .= "Content-Transfer-Encoding: base64\r\n";
		        $msg .= "Content-Disposition: attachment\r\n";
		        $msg .= $attach_pdf_multipart . "\r\n";

		        $msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
		        $msg .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		        $msg .= "<p>This is text message from shohag</p>\r\n\r\n";  
		         // mail( $to, $subject, $msg, $headers );
				$config = Array(    
					    'protocol'  => 'smtp',
					    'smtp_host' => 'ssl://smtp.zoho.com',
					    'smtp_port' => 465,
					    'smtp_user' => 'demo@todquest.com',
					    'smtp_pass' => 'K!ddz1ng',
					    'mailtype'  => 'html',
					    'charset'   => 'utf-8'
				);

				$this->load->library('email',$config); // Load email template
				$this->email->set_newline("\r\n");
				$this->email->from('demo@todquest.com','Todquest');
				$this->email->to($to); 
				$this->email->subject($subject); 
				$this->email->message($html); 
				if ($this->email->send()) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Email sent successfully.";
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Something went wrong!";
				}
				echo json_encode($data);
			}
		}
	}

	public function getQualityArea($userid='')
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
		$this->load->model('loginModel');
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null  && $res->userid == $userid){
				$response = $this->qipModel->getQipAreas();
				$data['Status'] = "SUCCESS";
				$data['Areas'] = $response;
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
		}
		echo json_encode($data);
	}

	public function addNewQip()
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
		$this->load->model('loginModel');
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$json->name = date('Y M');
				$response = $this->qipModel->addNewQip($json);
				
				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "New QIP is created!";
					$data['Centerid'] = $json->centerid;
					$data['id'] = $response;
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Something went wrong!";
				}				
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
		}
		echo json_encode($data);
	}

	//new qip functions
	public function renameQip()
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
		$this->load->model('loginModel');
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$response = $this->qipModel->renameQip($json);
				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "New QIP is updated!";
					$data['qipId'] = $json->id;
					$data['qipName'] = $json->name;
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Something went wrong!";
				}				
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
		}
		echo json_encode($data);
	}

	public function viewStandard(){
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
		$this->load->model('loginModel');
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				//Check if qip exists or not
				$qipCheck = $this->qipModel->getQip($json->qipid);

				if ($qipCheck) {
					//For retrieving all qip based on centers
					$qipAreas = $this->qipModel->getQipAreas();

					//For existing standards and elements
					$response = $this->qipModel->getQipAreaStandards($json->areaid);
					if ($response) {

						foreach ($response as $respon => $resp) {
							$resp->elements = $this->qipModel->getQipStandardElements($resp->id);
							if ($resp->elements) {
								foreach ($resp->elements as $emenents => $elem) {
									$totalusers = $this->qipModel->countElementUsers($elem->id);
									$elem->totalusers = $totalusers->userCount;
									if ($totalusers->userCount > 4) {
										$extrausers = $totalusers->userCount - 4;
										$elem->extrausers = "+".$extrausers;
									}else{
										$elem->extrausers = "+0";
									}
									$elem->users = $this->qipModel->getElementUsers($elem->id);
								}
							}
						}

						$data['Status'] = "SUCCESS";
						$data['Standards'] = $response;
						$data['Centerid'] = $qipCheck->centerId;
						$data['QipAreas'] = $qipAreas;
						http_response_code(200);
					}else{
						$data['Status']="ERROR";
						$data['Message']="No record exists in database!";
						$data['QipAreas'] = $qipAreas;
						http_response_code(401);
					}
				}else{
					$data['Status']="ERROR";
					$data['Message']="QIP doesn't exists in database!";
					http_response_code(401);
				}				
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
				http_response_code(401);
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function viewDiscussions(){
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
		$this->load->model('loginModel');
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$dcss = $this->qipModel->getDiscussions($json);
				if ($dcss) {
				 	$data['Status'] = "SUCCESS";
				 	$data['Comments'] = $dcss;
				 	http_response_code(200);
				}else{
					$data['Status']="ERROR";
					$data['Message']="No comments found!";
					$data['Comments'] = [];
					http_response_code(401);
				} 
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
				http_response_code(401);
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function addComment(){
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
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$response = $this->qipModel->addComment($json);
				if ($response) {
				 	$data['Status'] = "SUCCESS";
				 	$data['Message'] = "Comment added!";
				 	http_response_code(200);
				}else{
					$data['Status']="ERROR";
					$data['Message']="Something Went Wrong!";
					http_response_code(401);
				} 
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
				http_response_code(401);
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getStandardDetails(){
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
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if (empty($json->stdid)) {
					$data['Status']="ERROR";
					$data['Message']="StandardId is empty!";
					http_response_code(401);
				}else{

					//For retrieving all qip based on centers
					$qipAreas = $this->qipModel->getQipAreas();

					//To get the standard details
					$response = $this->qipModel->getStandardDetails($json->stdid);

					if ($response) {
						$resultsArr = $this->qipModel->getStandardValues($json);
						if ($resultsArr) {
							$response->val1 = html_entity_decode($resultsArr->val1);
							$response->val2 = html_entity_decode($resultsArr->val2);
							$response->val3 = html_entity_decode($resultsArr->val3);
						}
					}
					
					if (isset($response->areaId)) {
						//To get standards of that area
						$stds = $this->qipModel->getQipAreaStandards($response->areaId);
					}else{
						$stds = NULL;
					}

				 	$data['Status'] = "SUCCESS";
				 	$data['QipAreas'] = $qipAreas;
				 	$data['Standard'] = $response;
				 	$data['OtherStandards'] = $stds;
				 	http_response_code(200);
				}
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
				http_response_code(401);
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getAreaStandards(){
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
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$response = $this->qipModel->getQipAreaStandards($json->areaid);
				if ($response) {
				 	$data['Status'] = "SUCCESS";
				 	$data['AreaStd'] = $response;
				 	http_response_code(200);
				}else{
					$data['Status']="ERROR";
					$data['Message']="No records found!";
					http_response_code(401);
				} 
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
				http_response_code(401);
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function updateQipStandard(){
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
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$json->val1 = htmlspecialchars($json->val1);
				$json->val2 = htmlspecialchars($json->val2);
				$json->val3 = htmlspecialchars($json->val3);
				$resultsArr = $this->qipModel->getStandardValues($json);
				if (empty($resultsArr)) {
					$response = $this->qipModel->insertQipStandard($json);
					$data['Status'] = "SUCCESS";
				 	$data['Message'] = "Record inserted successfully!";
				 	http_response_code(200);
				} else {
					$response = $this->qipModel->updateQipStandard($json);
					$data['Status'] = "SUCCESS";
				 	$data['Message'] = "Record updated successfully!";
				 	http_response_code(200);
				}
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
				http_response_code(401);
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getStandardElements(){
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
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$response = $this->qipModel->getQipStandardElements($json->stdid);
				if ($response) {
				 	$data['Status'] = "SUCCESS";
				 	$data['StdElements'] = $response;
				 	http_response_code(200);
				}else{
					$data['Status']="ERROR";
					$data['Message']="No records found!";
					http_response_code(401);
				} 
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
				http_response_code(401);
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveQipLinks(){
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
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$json->links = [];
				$arr = [];
				foreach ($json->linkids as $key => $obj) {
					$arr['linkid'] = $obj;
					$arr['qip_id'] = $json->qipid;
					$arr['linktype'] = $json->linktype;
					$arr['added_by'] = $json->userid;
					$arr['elementid'] = $json->elementid;
					$arr['added_at'] = date("Y-m-d H:i:s");
					array_push($json->links, $arr);
				}
				$response = $this->qipModel->saveQipLinks($json);
				if ($response) {
				 	$data['Status'] = "SUCCESS";
				 	$data['Message'] = "Links saved successfully!";
				 	http_response_code(200);
				}else{
					$data['Status']="ERROR";
					$data['Message']="Links are not saved!";
					http_response_code(401);
				} 
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
				http_response_code(401);
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function  getAllPublishedObservations($user_id="",$centerid="",$qipid='',$elementid=''){
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
			if($user_id!= null && $res != null && $res->userid == $user_id){
			    $observations = $this->ObservationModel->getPublishedObservationsFromCenter($centerid);
				$data['observations']=array();
				foreach($observations as $observation)
				{
					$observation->title = strip_tags(html_entity_decode($observation->title));
					$obsLink = $this->qipModel->getQipLinkCheck($observation->id,"OBSERVATION",$qipid,$elementid);
					if ($obsLink) {
						$observation->checked = "checked";
					}else{
						$observation->checked = NULL;
					}
					
					$media=$this->ObservationModel->getMedia($observation->id);
					$observation->media=isset($media[0]->mediaUrl)?$media[0]->mediaUrl:'';
					$observationsMedia=$this->ObservationModel->getMedia($observation->id);
					$observation->observationsMedia=isset($observationsMedia[0]->mediaUrl)?$observationsMedia[0]->mediaUrl:'';
					$observation->observationsMediaType=isset($observationsMedia[0]->mediaType)?$observationsMedia[0]->mediaType:'';
					$childs=$this->ObservationModel->getObservationChildrens($observation->id);
					$observation->childs=$childs;
					$montessoryCount=$this->ObservationModel->getObservationMontessoriCount($observation->id);
					$observation->montessoryCount=$montessoryCount;
					$eylfCount=$this->ObservationModel->getObservationEylfCount($observation->id);
					$observation->eylfCount=$eylfCount;
					$milestoneCount=$this->ObservationModel->getObservationMilestoneCount($observation->id);
					$observation->milestoneCount = $milestoneCount;
					$observation->date_added = date('d-m-Y',strtotime($observation->date_added));
					$data['Status'] = "SUCCESS";
					$data['observations'][]=$observation;
				}
				http_response_code(200);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
	}

	public function getPublishedReflections($userid,$centerid = "",$qipid="",$elementid=''){
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
			if($res != null && $res->userid == $userid){
				$reflectionsArr = $this->ObservationModel->getPublishedReflections($centerid);
				foreach ($reflectionsArr as $key => $obj) {
					$media = $this->ObservationModel->getReflectionMedia($obj->id);
					if (count($media) > 0) {
						if ($media[0]->mediaType == "Image") {
							$obj->mediaThumbnail = $media[0]->mediaUrl;
						}else{
							$obj->mediaThumbnail = "350x350.png";
						}
					}else{
						$obj->mediaThumbnail = "350x350.png";
					}
					$obj->createdAt = date('d.m.Y',strtotime($obj->createdAt));
				 	$obsLink = $this->qipModel->getQipLinkCheck($obj->id,"REFLECTION",$qipid,$elementid);
					if ($obsLink) {
						$obj->checked = "checked";
					}else{
						$obj->checked = NULL;
					}
				} 
				
				http_response_code(200);
				$data['Status'] = "SUCCESS";
				$data['reflections'] = $reflectionsArr;
			}else{
				http_response_code(401);
				$data['Status']="ERROR";
				$data['Message']="User Id doesn't match";
			}
		}else{
			http_response_code(401);
			$data['Status']="ERROR";
			$data['Message']="Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getPublishedResources() {
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
			if($json!= null && $res != null && $res->userid == $json->userid){
				$qipid = $json->qipid;
				$elementid = $json->elementid;
				$resArr = $this->qipModel->getPublishedResources();
				foreach ($resArr as $key => $obj) {
					$media = $this->qipModel->getResourceMedia($obj->id);
					if (count($media) > 0) {
						if ($media[0]->mediaType == "Image") {
							$obj->mediaThumbnail = $media[0]->mediaUrl;
						}else{
							$obj->mediaThumbnail = "350x350.png";
						}
					}else{
						$obj->mediaThumbnail = "350x350.png";
					}

				 	$obsLink = $this->qipModel->getQipLinkCheck($obj->id,"RESOURCES",$qipid,$elementid);
					if ($obsLink) {
						$obj->checked = "checked";
					}else{
						$obj->checked = NULL;
					}
				}
				$data['Status'] = "SUCCESS";
				$data['Resources'] = $resArr;
			}else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
	}

	public function getPublishedSurveys(){
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
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$json = json_decode(file_get_contents("php://input"));
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $json != null && $res->userid == $json->userid ){
				$surveysArr = $this->qipModel->getPublishedSurveys($json->centerid);
				foreach ($surveysArr as $key => $obj) {
				 	$obsLink = $this->qipModel->getQipLinkCheck($obj->id,"SURVEY",$json->qipid,$json->elementid);
					if ($obsLink) {
						$obj->checked = "checked";
					}else{
						$obj->checked = NULL;
					}
				}
				$data['Status'] = "SUCCESS";
				$data['Surveys'] = $surveysArr;
			}else{
				http_response_code(401);
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Invalid User Account!';
			}
		}else{
			http_response_code(401);
			$data['Status'] = 'Error';
			$data['Message'] = 'Invalid Headers Sent!';
		}
		echo json_encode($data);
	}

	public function getProgramPlans(){
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
				$results = $this->qipModel->getProgramPlans($json->centerid);
				foreach ($results as $key => $obj) {
				 	$obsLink = $this->qipModel->getQipLinkCheck($obj->id,"PROGRAMPLAN",$json->qipid,$json->elementid);
					if ($obsLink) {
						$obj->checked = "checked";
					}else{
						$obj->checked = NULL;
					}
				}
				$data['Status'] = "SUCCESS";
				$data['ProgramPlans'] = $results;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
				http_response_code(401);
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getAllMonSubActs(){
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
			if($json!= null && $res != null && $res->userid == $json->userid){
				$results = $this->qipModel->getMontessoriSubActivites();	
				foreach ($results as $key => $obj) {
				 	$obsLink = $this->qipModel->getQipLinkCheck($obj->idSubActivity,"MONTESSORI",$json->qipid,$json->elementid);
					if ($obsLink) {
						$obj->checked = "checked";
					}else{
						$obj->checked = NULL;
					}
				}
				$data['Status'] = "SUCCESS";	
				$data['Records'] = $results;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getAllDevMiles(){
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
			if($json!= null && $res != null && $res->userid == $json->userid){
				$results = $this->qipModel->getDevelopmentalMilestoneSubActivites();
				foreach ($results as $key => $obj) {
				 	$obsLink = $this->qipModel->getQipLinkCheck($obj->id,"MILESTONE",$json->qipid,$json->elementid);
					if ($obsLink) {
						$obj->checked = "checked";
					}else{
						$obj->checked = NULL;
					}
				}
				$data['Status'] = "SUCCESS";
				$data['Records'] = $results;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getAllEylf(){
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
			if($json!= null && $res != null && $res->userid == $json->userid){
				$results = $this->qipModel->getEylfSubActivites();
				foreach ($results as $key => $obj) {
				 	$obsLink = $this->qipModel->getQipLinkCheck($obj->id,"EYLF",$json->qipid,$json->elementid);
					if ($obsLink) {
						$obj->checked = "checked";
					}else{
						$obj->checked = NULL;
					}
				}
				$data['Status'] = "SUCCESS";
				$data['Records'] = $results;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function viewElement(){
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
		$this->load->model('loginModel');
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				//Check if qip exists or not
				$qipCheck = $this->qipModel->getQip($json->qipid);

				if ($qipCheck) {
					//For retrieving all qipareas
					$qipAreas = $this->qipModel->getQipAreas();

					//For retrieving all qip standards based on qipareas
					$qipStandards = $this->qipModel->getQipStandards($json->areaid);

					//For retrieving all qip elements of same standards
					$qipElements = $this->qipModel->getSameGroupElements($json->elementid);

					//For existing standards and elements
					$progressNotes = $this->qipModel->getElementProgressNotes($json);
					if ($progressNotes != "") {
						foreach ($progressNotes as $pronotes => $prObj) {
							$addArr = $this->qipModel->getUserdetails($prObj->added_by);
							$prObj->user_img = empty($addArr->imageUrl)?"":$addArr->imageUrl;
							$prObj->added_by = empty($addArr->name)?"":$addArr->name;
							$apprArr = $this->qipModel->getUserdetails($prObj->approved_by);
							$prObj->approved_img = empty($apprArr->imageUrl)?"":$apprArr->imageUrl;
							$prObj->approved_by = empty($apprArr->name)?"":$apprArr->name;
						}
					}else{
						$progressNotes = [];
					}
					

					$comments = $this->qipModel->getElementComments($json);
					if ($comments) {
						foreach ($comments as $comment => $cmt) {
							$userArr = $this->qipModel->getUserdetails($cmt->added_by);
							$cmt->added_by = empty($userArr->name)?"":$userArr->name;
							$cmt->user_img = empty($userArr->imageUrl)?"":$userArr->imageUrl;
						}
					} else {
						$comments = [];
					}
					
					$issues = $this->qipModel->getElementIssues($json);
					if ($issues) {
						foreach ($issues as $issue => $isu) {
							$userArr = $this->qipModel->getUserdetails($isu->addedBy);
							$isu->added_by = empty($userArr->name)?"":$userArr->name;
							$isu->user_img = empty($userArr->imageUrl)?"":$userArr->imageUrl;
						}
					} else {
						$issues = [];
					}

					$elementUsers = $this->qipModel->getQipElementUsers($json);

					//For retrieving area id of this element
					$areaArr = $this->qipModel->getAreaId($json->elementid);
					$areaid = $areaArr->areaId;
					$qipElementss = $this->qipModel->getQipElementById($json->elementid);
					$standardid = $qipElementss->standardId;
					$elementid = $json->elementid;

					$data['Status'] = "SUCCESS";
					$data['Centerid'] = $qipCheck->centerId;
					$data['ProgressNotes'] = $progressNotes;
					$data['Comments'] = $comments;
					$data['Issues'] = $issues;
					$data['QipAreas'] = $qipAreas;
					$data['QipStandards'] = $qipStandards;
					$data['QipElements'] = $qipElements;
					$data['AreaId'] = $areaid;
					$data['StandardId'] = $standardid;
					$data['ElementId'] = $elementid;
					$data['ElementUsers'] = $elementUsers;
					http_response_code(200);
				}else{
					$data['Status']="ERROR";
					$data['Message']="QIP doesn't exists in database!";
					http_response_code(401);
				}				
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
				http_response_code(401);
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function getElementStaffs()
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
		$this->load->model('loginModel');
		if($headers != null && $headers['X-Token'] != null && $headers['X-Device-Id'] != null ){
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$elementUsers = $this->qipModel->getQipElementUsers($json);
				$data['Status'] = "SUCCESS";
				$data['Staffs'] = $elementUsers;
			}else{
				$data['Status']="ERROR";
				$data['Message']="Invalid user account!";
				http_response_code(401);
			}
		}else{
			$data['Status']="ERROR";
			$data['Message']="Invalid headers sent!";
			http_response_code(401);
		}
		echo json_encode($data);
	}

	public function saveProgressNotes()
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
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$json->pronotes = htmlspecialchars($json->pronotes);
				$response = $this->qipModel->saveProgressNotes($json);
				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Progress notes added";
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid User Account!";
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function saveElementIssues()
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
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				if (empty($json->issueid)) {
					$response = $this->qipModel->saveElementIssues($json);
				}else{
					$response = $this->qipModel->updateElementIssues($json);
				}
				if ($response) {
					$data['Status'] = "SUCCESS";
					$data['Message'] = "Element Issues Saved";
				}else{
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid User Account!";
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function saveElementComment()
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
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$results = $this->qipModel->saveElementComment($json);
				$data['Status'] = "SUCCESS";
				$data['Records'] = $results;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function getCenterStaffs()
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
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				$results = $this->qipModel->getCenterStaffs($json);
				foreach ($results as $key => $obj) {
					$checkObj = new stdclass();
					$checkObj->userid = $obj->userid;
					$checkObj->qipid = $json->qipid;
					$checkObj->elementid = $json->elementid;
					$check = $this->qipModel->checkStaffInElement($checkObj);
					if ($check) {
						$obj->selected = "checked";
					}else{
						$obj->selected = "";
					}
				}
				$data['Status'] = "SUCCESS";
				$data['Staffs'] = $results;
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}

	public function addElementStaffs()
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
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
				//get standardid to store in table
				$elmArr = $this->qipModel->getElementInfo($json->elementid);

				//create new array
				$object = [];
				$tempobj = [];
				$date = date('Y-m-d H:i:s');

				$json->staffIds = json_decode($json->staffids);

				foreach($json->staffIds as $staffs => $staff){
					$tempobj['qipid'] = $json->qipid;
					$tempobj['areaid'] = $json->areaid;
					$tempobj['standardid'] = $elmArr->standardId;
					$tempobj['elementid'] = $json->elementid;
					$tempobj['userid'] = $staff;
					$tempobj['added_by'] = $json->userid;
					$tempobj['added_at'] = $date;
					array_push($object, $tempobj);
				}

				$this->qipModel->deleteQipElementUsers($json);

				foreach ($object as $key => $obj) {
					$this->qipModel->addElementStaffs($obj);
				}



				$data['Status'] = "SUCCESS";
				$data['Message'] = "Educators added successfully!";
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid User Account!";
			}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
		}
		echo json_encode($data);
	}




	public function printqip()
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
		if (!empty($headers['X-Device-Id']) && !empty($headers['X-Token'])) {
			$res = $this->loginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));

			// print_r($json->selectedOptions);
			// exit;

		

	
			if ($json != null && $res != null && $res->userid == $json->userid) {
				// print_r($json);
				// exit;
				// Load mPDF library
				$this->load->library('M_pdf');
				$mpdf = $this->m_pdf->load([
					'mode' => 'utf-8',
					'format' => 'A3',
					'margin_left' => 0,
					'margin_right' => 0,
					'margin_top' => 0,
					'margin_bottom' => 0,
					'margin_header' => 0,
					'margin_footer' => 0
				]);
	
				$baseapiurl = BASE_API_URL;
				$imgname = $baseapiurl.'assets/logo.png';
	
				// Add introduction page first
				$introHtml = $this->prepareIntroductionPage($imgname);
				$mpdf->WriteHTML($introHtml);
				
				// Add a page break after introduction
				// $mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15);


				$mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15); // Margins for the new page

// Content for the new page
$newPageContent = '
<div style="margin: 20px;">
    <h1 style="color: #003366; font-size: 20px; font-weight: bold; text-align: center; margin-bottom: 20px;">
        The National Quality Standard and Quality Improvement
    </h1>
    <p style="text-align: justify; font-size: 12px; line-height: 1.8;">
        The National Quality Standard is the standard against which providers self-assess the performance of their service/s in delivering quality education and care, and plan future improvements to their service/s. One result of this process is a Quality Improvement Plan (QIP).
    </p>
    <p style="text-align: justify; font-size: 12px; line-height: 1.8;">
        The Education and Care Services National Regulations 2017 (the National Regulations) require approved providers to prepare a Quality Improvement Plan (regulation 55) for each service that:
    </p>
    <ul style="font-size: 12px; line-height: 1.8;">
        <li>Includes an assessment by the provider of the quality of the practices of the service against the National Quality Standard.</li>
        <li>And the National Regulations; and</li>
        <li>Identifies any areas that the provider considers may require improvement; and</li>
        <li>Contains a statement of philosophy of the service.</li>
    </ul>
    <p style="text-align: justify; font-size: 12px; line-height: 1.8;">
        The National Regulations do not prescribe a format for a Quality Improvement Plan. The purpose of this template is to offer a format that supports approved providers to meet their obligations under the National Regulations.
    </p>
    <p style="text-align: justify; font-size: 12px; line-height: 1.8;">
        Approved providers also have an obligation (r56) to review and revise the Quality Improvement Plan at least annually, having regard to the National Quality Standard. A Quality Improvement Plan must be reviewed and/or submitted to the regulatory authority on request.
    </p>
    <h2 style="color: #003366; font-size: 16px; font-weight: bold; margin-top: 30px;">
        About the ACECQA Quality Improvement Plan template
    </h2>
    <p style="text-align: justify; font-size: 12px; line-height: 1.8;">
        The purpose of this template is to offer a planning format that supports approved providers to meet their obligations under the National Regulations. This template provides quick links to helpful resources for each quality area in the Guide to the National Framework and the ACECQA website.
    </p>
    <h2 style="color: #003366; font-size: 16px; font-weight: bold; margin-top: 30px;">
        Exceeding NQS themes guidance
    </h2>
    <p style="text-align: justify; font-size: 12px; line-height: 1.8;">
        The Exceeding NQS sections provided for each standard should be completed when there is evidence of one or more Exceeding NQS themes demonstrated in the practice at the service. When the QIP is submitted to the regulatory authority for assessment and rating, an authorised officer will consider the evidence documented and gathered at the assessment visit to determine if the Exceeding NQS themes are being met.
    </p>
    <p style="text-align: justify; font-size: 12px; line-height: 1.8;">
        For further information on the three Exceeding themes, including what authorised officers consider when reviewing whether evidence demonstrates a theme, see ACECQA’s Exceeding the NQS webpage.
    </p>
</div>
';

// Write the content for the new page
$mpdf->WriteHTML($newPageContent);



// footer code globally ------------------------------------------
// Set footer with image (left) and page number info (right)
$footerHtml = '
<table width="100%" style="border-top: 1px solid #000; font-size: 10px; padding-top: 5px;">
    <tr>
        <td width="10%" align="left">
            <img src="' . $imgname . '" width="45" height="35">
        </td>
        <td width="90%" align="right">
            Quality Improvement Plan template | {PAGENO}
        </td>
    </tr>
</table>';

$mpdf->SetHTMLFooter($footerHtml);
//-----------------------------------------------------

// service form page ------------------------------------
$records = $this->db->where('centerid', $json->centerid)
				->get('servicedetails')
				->result();
$record = $records[0]; 

$mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15); // Margins for the new page

// Content for the new page
$servicedetailsformpage = '
<div class="service-details-container">
    <h2 style="color: #0066cc; margin-bottom: 20px;">Service details</h2>
    
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="border: 1px solid #000; padding: 8px; width: 50%;"><strong>Service name</strong></td>
            <td style="border: 1px solid #000; padding: 8px;"><strong>Service approval number</strong></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; padding: 8px; height: 40px;">'. $record->serviceName .'</td>
            <td style="border: 1px solid #000; padding: 8px;">'. $record->serviceApprovalNumber .'</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td colspan="2" style="border: 1px solid #000; padding: 8px;"><strong>Primary contacts at service</strong></td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid #000; padding: 8px; height: 40px;"></td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="border: 1px solid #000; padding: 8px; width: 50%;"><strong>Physical location of service</strong></td>
            <td style="border: 1px solid #000; padding: 8px;"><strong>Physical location contact details</strong></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; padding: 8px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 4px; border: 1px solid black;"><strong>Street</strong></td>
                        <td style="padding: 4px; border: 1px solid black;">'. $record->serviceStreet .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Suburb</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->serviceSuburb .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>State/territory</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->serviceState .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Postcode</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->servicePostcode .'</td>
                    </tr>
                </table>
            </td>
            <td style="border: 1px solid #000; padding: 8px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Telephone</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->contactTelephone .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Mobile</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->contactMobile .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Fax</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->contactFax .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Email</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->contactEmail .'</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="border: 1px solid #000; padding: 8px; width: 50%;"><strong>Approved Provider</strong></td>
            <td style="border: 1px solid #000; padding: 8px;"><strong>Nominated Supervisor</strong></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; padding: 8px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Primary contact</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->providerContact .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Telephone</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->providerTelephone .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Mobile</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->providerMobile .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Fax</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->providerFax .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Email</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->providerEmail .'</td>
                    </tr>
                </table>
            </td>
            <td style="border: 1px solid #000; padding: 8px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Name</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->supervisorName .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Telephone</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->supervisorTelephone .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Mobile</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->supervisorMobile .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Fax</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->supervisorFax .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Email</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->supervisorEmail .'</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td colspan="2" style="border: 1px solid #000; padding: 8px;"><strong>Postal address (if different to physical location of service)</strong></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; padding: 8px; width: 50%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Street</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->postalStreet .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Suburb</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->postalSuburb .'</td>
                    </tr>
                </table>
            </td>
            <td style="border: 1px solid #000; padding: 8px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>State/territory</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->postalState .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Postcode</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->postalPostcode .'</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td colspan="1" style="border: 1px solid #000; padding: 8px;"><strong>Educational leader</strong></td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; padding: 8px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Name</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->eduLeaderName .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Telephone</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->eduLeaderTelephone .'</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px;border: 1px solid black;"><strong>Email</strong></td>
						<td style="padding: 4px; border: 1px solid black;">'. $record->eduLeaderEmail .'</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
';

$mpdf->WriteHTML($servicedetailsformpage);


//--------------------------

//----service form's next page ------
$mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15);

$serviceformnextpage = '
<div style="font-family: Arial, sans-serif;">
    <h2 style="color: #00427A; margin-bottom: 5px;">Additional information about your service</h2>
    <p style="margin-top: 0; margin-bottom: 20px;">The following information will assist the regulatory authority to plan the assessment visit.</p>
    
    <div style="border: 1px solid #000; margin-bottom: -1px;">
        <div style="padding: 10px;">
            <div style="font-weight: normal;">Provide additional information about your service—parking, school holiday dates, pupil-free days, etc.</div>
            <div style="height: 100px;"></div>
        </div>
    </div>

    <div style="border: 1px solid #000; margin-bottom: -1px;">
        <div style="padding: 10px;">
            <div style="font-weight: normal;">How are the children grouped at your service?</div>
            <div style="height: 100px;"></div>
        </div>
    </div>

    <div style="border: 1px solid #000; margin-bottom: -1px;">
        <div style="padding: 10px;">
            <div style="font-weight: normal;">Write the name and position of person(s) responsible for submitting this Quality Improvement Plan (e.g. Cheryl Smith, Nominated Supervisor)</div>
            <div style="height: 100px;"></div>
        </div>
    </div>

    <div style="border: 1px solid #000;">
        <div style="padding: 10px;">
            <div style="font-weight: normal;">For family day care services, indicate the number of educators currently registered in the service and attach a list of the educators and their addresses.</div>
            <div style="margin-top: 10px;">
                <span style="font-weight: normal;">No. of educators:</span>
                <input type="text" style="border: 1px solid #ccc; width: 100px; margin-left: 5px;">
            </div>
        </div>
    </div>
</div>
';

$mpdf->WriteHTML($serviceformnextpage);

//-------------------


//another next page of service form ------------------
$mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15);

$serviceformanotherpage = '
<div style="font-family: Arial, sans-serif;">
    <h2 style="color: #00427A; margin-bottom: 5px;">Service statement of philosophy</h2>
    <p style="margin-top: 0; margin-bottom: 20px;">Please insert your service\'s statement of philosophy here.</p>
    
    <div style="border: 1px solid #000;">
        <div style="height: 400px;">' . $record->philosophyStatement .'</div>
    </div>
</div>
';

$mpdf->WriteHTML($serviceformanotherpage);

//--------------------------------------------


 // Group selected options by "qaX"
  $qaGroups = [];
  foreach ($json->selectedOptions as $option) {
	  preg_match('/(qa\d+)_\d+/', $option, $matches);
	  if (!empty($matches[1])) {
		  $qaGroups[$matches[1]][] = $option; // Group by qaX
	  }
  }

  // Call private functions dynamically with their respective data
  foreach ($qaGroups as $qaKey => $selectedData) {
	  $method = "handle_" . $qaKey;
	  if (method_exists($this, $method)) {
		  $this->$method($mpdf, $selectedData);
	  }
  }




	
				// Generate unique file name
				$pdfId = uniqid() . '_qip.pdf';
				$filePath = FCPATH . 'assets/' . $pdfId;
				
				// Save PDF to the assets directory
				$mpdf->Output($filePath, 'F');
				$baseapiurl = BASE_API_URL;
				$FileName = $baseapiurl.'assets/'.$pdfId;
				
				$data = array(
					'Status' => 'SUCCESS',
					'Message' => 'PDF Created Successfully',
					'FileName' => $FileName,
				);
				http_response_code(200);
				echo json_encode($data, JSON_UNESCAPED_SLASHES);
				exit;
			} else {
				echo json_encode(array("Status" => "ERROR", "Message" => "Invalid User Account!"));
			}
		} else {
			echo json_encode(array("Status" => "ERROR", "Message" => "Invalid Headers Sent!"));
		}
	}
	
	private function prepareIntroductionPage($imgname)
	{
		// CSS styles for the introduction page
		$styles = '
			<style>
				.intro-page {
					background-color: #2e86c1;
					color: white;
					height: 100%;
					padding: 40px;
					text-align: center;
				}
				.logo {
					width:220px;
					height:180px;
					max-width: 800px;
					margin-bottom: 100px;
					margin-top: 150px;
				}
				.main-title {
					font-size: 32px;
					font-weight: bold;
					margin-bottom: 60px;
				}
				.sub-title {
					font-size: 26px;
					font-weight:bold;
					margin-top: 80px;
				}
				.sub-title2 {
					font-size: 22px;
					font-weight:bold;
					margin-top: 80px;
				}
			</style>
		';
	
		// HTML content for the introduction page
		$html = $styles . '
			<div class="intro-page">
            <img src="' . htmlspecialchars($imgname) . '" class="logo" alt="ACECQA Logo">
				<div class="main-title">Quality Improvement Plan template</div>
				<div class="sub-title" style="color:black;">National Quality Standard</div>

				<div class="sub-title2" style="color:black;">Updated on Jan 2025</div>
			</div>
		';
	
		return $html;
	}
	



// Example private functions:
private function handle_qa1($mpdf, $data)
{   
	$heading = "Quality Area 1: Educational program and practice";
	
	$this->QualityArea1stpage($mpdf,$heading);
	$this->QualityArea2ndpage($mpdf);
	$this->QualityArea3rdpage($mpdf);

	if (in_array('qa1_1', $data)) {
        $this->QualityArea4thpage($mpdf);
    }
    if (in_array('qa1_2', $data)) {
        $this->QualityArea5stpage($mpdf);
    }
    if (in_array('qa1_3', $data)) {
        $this->QualityArea6stpage($mpdf);
    }

	$this->QualityArea7stpage($mpdf);
	
}

private function handle_qa2($mpdf, $data)
{
	$heading = "Quality Area 2: Childrens health and safety";
	$this->QualityArea1stpage($mpdf,$heading);
	$this->QualityArea2ndpage($mpdf);
	$this->QualityArea3rdpage($mpdf);

	if (in_array('qa2_1', $data)) {
        $this->QualityArea4thpage($mpdf);
    }
    if (in_array('qa2_2', $data)) {
        $this->QualityArea5stpage($mpdf);
    }

	$this->QualityArea7stpage($mpdf);
  
}

private function handle_qa3($mpdf, $data)
{
	$this->QualityArea1stpage($mpdf);
	$this->QualityArea2ndpage($mpdf);
	$this->QualityArea3rdpage($mpdf);

	if (in_array('qa3_1', $data)) {
        $this->QualityArea4thpage($mpdf);
    }
    if (in_array('qa3_2', $data)) {
        $this->QualityArea5stpage($mpdf);
    }

	$this->QualityArea7stpage($mpdf);
}


// Example private functions:
private function handle_qa4($mpdf, $data)
{
    $this->QualityArea1stpage($mpdf);
	$this->QualityArea2ndpage($mpdf);
	$this->QualityArea3rdpage($mpdf);

	if (in_array('qa4_1', $data)) {
        $this->QualityArea4thpage($mpdf);
    }
    if (in_array('qa4_2', $data)) {
        $this->QualityArea5stpage($mpdf);
    }

	$this->QualityArea7stpage($mpdf);
}

private function handle_qa5($mpdf, $data)
{
    $this->QualityArea1stpage($mpdf);
	$this->QualityArea2ndpage($mpdf);
	$this->QualityArea3rdpage($mpdf);

	if (in_array('qa5_1', $data)) {
        $this->QualityArea4thpage($mpdf);
    }
    if (in_array('qa5_2', $data)) {
        $this->QualityArea5stpage($mpdf);
    }

	$this->QualityArea7stpage($mpdf);
}

private function handle_qa6($mpdf, $data)
{
	$this->QualityArea1stpage($mpdf);
	$this->QualityArea2ndpage($mpdf);
	$this->QualityArea3rdpage($mpdf);

	if (in_array('qa6_1', $data)) {
        $this->QualityArea4thpage($mpdf);
    }
    if (in_array('qa6_2', $data)) {
        $this->QualityArea5stpage($mpdf);
    }

	$this->QualityArea7stpage($mpdf);
}

private function handle_qa7($mpdf, $data)
{
    $this->QualityArea1stpage($mpdf);
	$this->QualityArea2ndpage($mpdf);
	$this->QualityArea3rdpage($mpdf);

	if (in_array('qa7_1', $data)) {
        $this->QualityArea4thpage($mpdf);
    }
    if (in_array('qa7_2', $data)) {
        $this->QualityArea5stpage($mpdf);
    }

	$this->QualityArea7stpage($mpdf);
}










	private function QualityArea1stpage($mpdf,$heading){
		$mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15);
		$quality1stpage ='
		<div style="font-family: Arial, sans-serif;">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100">
		  <!-- Horizontal line -->
		  <line x1="0" y1="70" x2="1000" y2="70" stroke="black" stroke-width="2"/>
		  
		  <!-- Green rectangle, positioned above the line and right-aligned -->
		  <rect x="730" y="29" width="350" height="40" fill="#4CAF50"/>
		</svg>
		
			<h2 style="color: blue; font-size: 18px; margin-top: 25px; margin-bottom: 15px;"> '. $heading .'</h2>
			
			<p style="color: #000; font-size: 14px; line-height: 1.4; margin-bottom: 15px;">
				This quality area of the <i>National Quality Standard</i> focuses on ensuring that the educational program and practice is stimulating and engaging and enhances children\'s learning and development. In school age care services, the program nurtures the development of life skills and complements children\'s experiences, opportunities and relationships at school, at home and in the community.
			</p>
			
			<p style="color: #000; font-size: 14px; line-height: 1.4; margin-bottom: 20px;">
				Additional information and resources about Quality Area 1 are available in the <a href="#" style="color: #0000FF; text-decoration: underline;">Guide to the National Quality Framework</a> and the <a href="#" style="color: #0000FF; text-decoration: underline;">ACECQA website</a>.
			</p>
			
			<h3 style="color: #000; font-size: 16px; margin-bottom: 15px;">Quality Area 1: Standards and elements</h3>
			
			<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
				<tr>
					<td colspan="3" style="background-color: #90EE90; padding: 8px; border: 1px solid #000;">
						<strong>Standard 1.1</strong> The educational program enhances each child\'s learning and development.
					</td>
				</tr>
				<tr>
					<td style="padding: 8px; border: 1px solid #000; width: 25%;"><strong>Approved learning framework</strong></td>
					<td style="padding: 8px; border: 1px solid #000; width: 15%;">Element 1.1.1</td>
					<td style="padding: 8px; border: 1px solid #000;">Curriculum decision-making contributes to each child\'s learning and development outcomes in relation to their identity, connection with community, wellbeing, confidence as learners and effectiveness as communicators.</td>
				</tr>
				<tr>
					<td style="padding: 8px; border: 1px solid #000;"><strong>Child-centred</strong></td>
					<td style="padding: 8px; border: 1px solid #000;">Element 1.1.2</td>
					<td style="padding: 8px; border: 1px solid #000;">Each child\'s current knowledge, strengths, ideas, culture, abilities and interests are the foundation of the program.</td>
				</tr>
				<tr>
					<td style="padding: 8px; border: 1px solid #000;"><strong>Program learning opportunities</strong></td>
					<td style="padding: 8px; border: 1px solid #000;">Element 1.1.3</td>
					<td style="padding: 8px; border: 1px solid #000;">All aspects of the program, including routines, are organised in ways that maximise opportunities for each child\'s learning.</td>
				</tr>
				
				<tr>
					<td colspan="3" style="background-color: #90EE90; padding: 8px; border: 1px solid #000;">
						<strong>Standard 1.2</strong> Educators facilitate and extend each child\'s learning and development.
					</td>
				</tr>
				<tr>
					<td style="padding: 8px; border: 1px solid #000;"><strong>Intentional teaching</strong></td>
					<td style="padding: 8px; border: 1px solid #000;">Element 1.2.1</td>
					<td style="padding: 8px; border: 1px solid #000;">Educators are deliberate, purposeful, and thoughtful in their decisions and actions.</td>
				</tr>
				<tr>
					<td style="padding: 8px; border: 1px solid #000;"><strong>Responsive teaching and scaffolding</strong></td>
					<td style="padding: 8px; border: 1px solid #000;">Element 1.2.2</td>
					<td style="padding: 8px; border: 1px solid #000;">Educators respond to children\'s ideas and play and extend children\'s learning through open-ended questions, interactions and feedback.</td>
				</tr>
				<tr>
					<td style="padding: 8px; border: 1px solid #000;"><strong>Child directed learning</strong></td>
					<td style="padding: 8px; border: 1px solid #000;">Element 1.2.3</td>
					<td style="padding: 8px; border: 1px solid #000;">Each child\'s agency is promoted, enabling them to make choices and decisions that influence events and their world.</td>
				</tr>
				
				<tr>
					<td colspan="3" style="background-color: #90EE90; padding: 8px; border: 1px solid #000;">
						<strong>Standard 1.3</strong> Educators and co-ordinators take a planned and reflective approach to implementing the program for each child.
					</td>
				</tr>
				<tr>
					<td style="padding: 8px; border: 1px solid #000;"><strong>Assessment and planning cycle</strong></td>
					<td style="padding: 8px; border: 1px solid #000;">Element 1.3.1</td>
					<td style="padding: 8px; border: 1px solid #000;">Each child\'s learning and development is assessed or evaluated as part of an ongoing cycle of observation, analysing learning, documentation, planning, implementation and reflection.</td>
				</tr>
				<tr>
					<td style="padding: 8px; border: 1px solid #000;"><strong>Critical reflection</strong></td>
					<td style="padding: 8px; border: 1px solid #000;">Element 1.3.2</td>
					<td style="padding: 8px; border: 1px solid #000;">Critical reflection on children\'s learning and development, both as individuals and in groups, drives program planning and implementation.</td>
				</tr>
				<tr>
					<td style="padding: 8px; border: 1px solid #000;"><strong>Information for families</strong></td>
					<td style="padding: 8px; border: 1px solid #000;">Element 1.3.3</td>
					<td style="padding: 8px; border: 1px solid #000;">Families are informed about the program and their child\'s progress.</td>
				</tr>
			</table>
		</div>';
		
		
		$mpdf->WriteHTML($quality1stpage);
	}

   
	private function QualityArea2ndpage($mpdf){
        $mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15);

       $quality2ndpage = '
         <div style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">
           <h2 style="font-size: 18px; font-weight: bold; color: #666;">National Law and National Regulations underpinning Quality Area 1</h2>
         <p>
        The table below shows the sections of the National Law and National Regulations underpinning Quality Area 1 and lists the most relevant element of the NQS associated with each section and regulation. 
        Please note that this table serves as a guide only and regulatory authorities have flexibility in how they assign non-compliance with the National Law and National Regulations against the quality areas, standards, and elements of the NQS.
          </p>
    
                <div style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">
         <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <tr style="background-color: #ccc; text-align: left;">
            <th style="padding: 10px; border: 1px solid #ddd;">National Law and National Regulations</th>
            <th style="padding: 10px; border: 1px solid #ddd;">Description</th>
            <th style="padding: 10px; border: 1px solid #ddd;">Associated element</th>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">Section 51(1)(b)</td>
            <td style="padding: 10px; border: 1px solid #ddd;">Conditions on service approval (educational and developmental needs of children)</td>
            <td style="padding: 10px; border: 1px solid #ddd;">1.1.1</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">Section 168</td>
            <td style="padding: 10px; border: 1px solid #ddd;">Offence relating to required programs</td>
            <td style="padding: 10px; border: 1px solid #ddd;">1.1.1, 1.1.2</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">Regulation 73</td>
            <td style="padding: 10px; border: 1px solid #ddd;">Educational program</td>
            <td style="padding: 10px; border: 1px solid #ddd;">1.1.1</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">Regulation 74</td>
            <td style="padding: 10px; border: 1px solid #ddd;">Documenting of child assessments or evaluations for delivery of educational program</td>
            <td style="padding: 10px; border: 1px solid #ddd;">1.3.1</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">Regulation 75</td>
            <td style="padding: 10px; border: 1px solid #ddd;">Information about educational program to be kept available</td>
            <td style="padding: 10px; border: 1px solid #ddd;">1.3.3</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">Regulation 76</td>
            <td style="padding: 10px; border: 1px solid #ddd;">Information about educational program to be given to parents</td>
            <td style="padding: 10px; border: 1px solid #ddd;">1.3.3</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">Regulation 274A NSW</td>
            <td style="padding: 10px; border: 1px solid #ddd;">Programs for children over preschool age</td>
            <td style="padding: 10px; border: 1px solid #ddd;">1.3.1</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">Regulation 289A NT</td>
            <td style="padding: 10px; border: 1px solid #ddd;">Programs for children over preschool age</td>
            <td style="padding: 10px; border: 1px solid #ddd;">1.3.1</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">Regulation 298A Queensland</td>
            <td style="padding: 10px; border: 1px solid #ddd;">Programs for children over preschool age</td>
            <td style="padding: 10px; border: 1px solid #ddd;">1.3.1</td>
        </tr>
         </table>
         </div>';


       $mpdf->WriteHTML($quality2ndpage);


	}

	private function QualityArea3rdpage($mpdf){
		$mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15);

		$quality3rdpage = '
		<div style="margin: 20px;">
			<h2 style="color: #00468C; font-size: 18px; margin-bottom: 15px;">Quality Improvement Plan for Quality Area 1</h2>
			
			<h3 style="color: #666; font-size: 16px; margin: 15px 0;">Summary of strengths for Quality Area 1</h3>
			
			<table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
				<tr style="height:400px;">
					<td style="width: 100px; height:250px; background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; vertical-align: top;">
						<strong>Strengths</strong>
					</td>
					<td style="padding: 10px; height:250px; border: 1px solid #ccc; vertical-align: top;">
						<span style="color: #0066CC; font-style: italic;">[Summarise strengths identified in the self-assessment process. Delete if not required.]</span>
					</td>
				</tr>
			</table>
		</div>';
		
		$mpdf->WriteHTML($quality3rdpage);


	}

    
	private function QualityArea4thpage($mpdf){
		$mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15);

		$quality4thpage = '
		<div style="margin: 20px;">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100">
		  <!-- Horizontal line -->
		  <line x1="0" y1="70" x2="1000" y2="70" stroke="black" stroke-width="2"/>
		  
		  <!-- Green rectangle, positioned above the line and right-aligned -->
		  <rect x="730" y="29" width="350" height="40" fill="#4CAF50"/>
		</svg>
		   <h3 style="color: #666; font-size: 16px; margin-top: 25px; margin: 15px 0;">Summary of strengths in practice where there is evidence of Exceeding NQS themes</h3>
		   
		   <div style="margin-bottom: 20px;">
			   <strong>Notes:</strong>
			   <ul style="margin-top: 5px; margin-bottom: 15px;">
				   <li>This Exceeding NQS section is to be completed when there is evidence of one or more of the Exceeding NQS themes demonstrated in the practice at your service.</li>
				   <li>Additional information about the Exceeding NQS themes is available on ACECQAs <a href="#" style="color: #0066CC;">Exceeding the NQS</a> webpage.</li>
			   </ul>
		   </div>
		
		   <h4 style="color: #666; font-size: 15px; margin: 15px 0;">Standard 1.1 Program: The educational program enhances each childs learning and development.</h4>
		
		   <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
			   <tr>
				   <td colspan="2" style="background-color: #4CAF50; color: white; padding: 8px;">
					   <strong>Exceeding themes</strong>
				   </td>
			   </tr>
			   <tr>
				   <td style="width: 250px;height:250px; background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; vertical-align: top;">
					   <strong>1. Practice is embedded in service operations</strong>
				   </td>
				   <td style="padding: 10px;height:250px; border: 1px solid #ccc;vertical-align: top;">
					   <span style="color: #0066CC;">[If you have identified strengths in this area, describe how your practices are embedded in service operations for this Standard]</span>
				   </td>
			   </tr>
			   <tr>
				   <td style="background-color: #E0E0E0;height:250px; padding: 10px; border: 1px solid #ccc; vertical-align: top;">
					   <strong>2. Practice is informed by critical reflection</strong>
				   </td>
				   <td style="padding: 10px;height:250px; border: 1px solid #ccc;vertical-align: top;">
					   <span style="color: #0066CC;">[If you have identified strengths in this area, describe how your services practices in this Standard, have been informed by critical reflection.]</span>
				   </td>
			   </tr>
			   <tr>
				   <td style="background-color: #E0E0E0; height:250px;padding: 10px; border: 1px solid #ccc; vertical-align: top;">
					   <strong>3. Practice is shaped by meaningful engagement with families, and/or community</strong>
				   </td>
				   <td style="padding: 10px;height:250px; border: 1px solid #ccc;vertical-align: top;">
					   <span style="color: #0066CC;">[If you have identified strengths in this area, describe how your services practices in this Standard, have been shaped by meaningful engagement with families, and/or community]</span>
				   </td>
			   </tr>
		   </table>
		</div>';
		
		$mpdf->WriteHTML($quality4thpage);
	}
    
	private function QualityArea5stpage($mpdf){

		$mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15);

		$quality5thpage = '
		<div style="margin: 20px;">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100">
		  <!-- Horizontal line -->
		  <line x1="0" y1="70" x2="1000" y2="70" stroke="black" stroke-width="2"/>
		  
		  <!-- Green rectangle, positioned above the line and right-aligned -->
		  <rect x="730" y="29" width="350" height="40" fill="#4CAF50"/>
		</svg>
		   <h3 style="color: #666; font-size: 16px;margin-top: 25px; margin: 15px 0;">Summary of strengths in practice where there is evidence of Exceeding NQS themes</h3>
		   
		   <div style="margin-bottom: 20px;">
			   <strong>Notes:</strong>
			   <ul style="margin-top: 5px; margin-bottom: 15px;">
				   <li>This Exceeding NQS section is to be completed when there is evidence of one or more of the Exceeding NQS themes demonstrated in the practice at your service.</li>
				   <li>Additional information about the Exceeding NQS themes is available on ACECQAs <a href="#" style="color: #0066CC;">Exceeding the NQS</a> webpage.</li>
			   </ul>
		   </div>
		
		   <h4 style="color: #666; font-size: 15px; margin: 15px 0;">Standard 1.2 Practice: Educators facilitate and extend each childs learning and development. 
		   </h4>
		
		   <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
			   <tr>
				   <td colspan="2" style="background-color: #4CAF50; color: white; padding: 8px;">
					   <strong>Exceeding themes</strong>
				   </td>
			   </tr>
			   <tr>
				   <td style="width: 250px;height:250px; background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; vertical-align: top;">
					   <strong>1. Practice is embedded in service operations</strong>
				   </td>
				   <td style="padding: 10px;height:250px; border: 1px solid #ccc;vertical-align: top;">
					   <span style="color: #0066CC;">[If you have identified strengths in this area, describe how your practices are embedded in service operations for this Standard]</span>
				   </td>
			   </tr>
			   <tr>
				   <td style="background-color: #E0E0E0;height:250px; padding: 10px; border: 1px solid #ccc; vertical-align: top;">
					   <strong>2. Practice is informed by critical reflection</strong>
				   </td>
				   <td style="padding: 10px;height:250px; border: 1px solid #ccc;vertical-align: top;">
					   <span style="color: #0066CC;">[If you have identified strengths in this area, describe how your services practices in this Standard, have been informed by critical reflection.]</span>
				   </td>
			   </tr>
			   <tr>
				   <td style="background-color: #E0E0E0; height:250px;padding: 10px; border: 1px solid #ccc; vertical-align: top;">
					   <strong>3. Practice is shaped by meaningful engagement with families, and/or community</strong>
				   </td>
				   <td style="padding: 10px;height:250px; border: 1px solid #ccc;vertical-align: top;">
					   <span style="color: #0066CC;">[If you have identified strengths in this area, describe how your services practices in this Standard, have been shaped by meaningful engagement with families, and/or community]</span>
				   </td>
			   </tr>
		   </table>
		</div>';
		
		$mpdf->WriteHTML($quality5thpage);
	}


	private function QualityArea6stpage($mpdf){

		$mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15);

		$quality6thpage = '
		<div style="margin: 20px;">
		
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100">
		  <!-- Horizontal line -->
		  <line x1="0" y1="70" x2="1000" y2="70" stroke="black" stroke-width="2"/>
		  
		  <!-- Green rectangle, positioned above the line and right-aligned -->
		  <rect x="730" y="29" width="350" height="40" fill="#4CAF50"/>
		</svg>
		
		   <h3 style="color: #666; font-size: 16px; margin-top: 25px; margin: 15px 0;">Summary of strengths in practice where there is evidence of Exceeding NQS themes</h3>
		   
		   <div style="margin-bottom: 20px;">
			   <strong>Notes:</strong>
			   <ul style="margin-top: 5px; margin-bottom: 15px;">
				   <li>This Exceeding NQS section is to be completed when there is evidence of one or more of the Exceeding NQS themes demonstrated in the practice at your service.</li>
				   <li>Additional information about the Exceeding NQS themes is available on ACECQAs <a href="#" style="color: #0066CC;">Exceeding the NQS</a> webpage.</li>
			   </ul>
		   </div>
		
		   <h4 style="color: #666; font-size: 15px; margin: 15px 0;">Standard 1.3  Assessment and planning: Educators and co-ordinators take a planned and reflective approach to implementing the
		   program for each child.</h4>
		
		   <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
			   <tr>
				   <td colspan="2" style="background-color: #4CAF50; color: white; padding: 8px;">
					   <strong>Exceeding themes</strong>
				   </td>
			   </tr>
			   <tr>
				   <td style="width: 250px;height:250px; background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; vertical-align: top;">
					   <strong>1. Practice is embedded in service operations</strong>
				   </td>
				   <td style="padding: 10px;height:250px; border: 1px solid #ccc;vertical-align: top;">
					   <span style="color: #0066CC;">[If you have identified strengths in this area, describe how your practices are embedded in service operations for this Standard]</span>
				   </td>
			   </tr>
			   <tr>
				   <td style="background-color: #E0E0E0;height:250px; padding: 10px; border: 1px solid #ccc; vertical-align: top;">
					   <strong>2. Practice is informed by critical reflection</strong>
				   </td>
				   <td style="padding: 10px;height:250px; border: 1px solid #ccc;vertical-align: top;">
					   <span style="color: #0066CC;">[If you have identified strengths in this area, describe how your services practices in this Standard, have been informed by critical reflection.]</span>
				   </td>
			   </tr>
			   <tr>
				   <td style="background-color: #E0E0E0; height:250px;padding: 10px; border: 1px solid #ccc; vertical-align: top;">
					   <strong>3. Practice is shaped by meaningful engagement with families, and/or community</strong>
				   </td>
				   <td style="padding: 10px;height:250px; border: 1px solid #ccc;vertical-align: top;">
					   <span style="color: #0066CC;">[If you have identified strengths in this area, describe how your services practices in this Standard, have been shaped by meaningful engagement with families, and/or community]</span>
				   </td>
			   </tr>
		   </table>
		</div>';
		
		$mpdf->WriteHTML($quality6thpage);
	}

	private function QualityArea7stpage($mpdf){
		$mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15);

		$quality7thpage = '
		<div style="margin: 20px;">
		
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100">
		  <!-- Horizontal line -->
		  <line x1="0" y1="70" x2="1000" y2="70" stroke="black" stroke-width="2"/>
		  
		  <!-- Green rectangle, positioned above the line and right-aligned -->
		  <rect x="730" y="29" width="350" height="40" fill="#4CAF50"/>
		</svg>
		
		   <h2 style="color: #00468C; font-size: 18px; margin-bottom: 15px;margin-top: 25px;">Key improvements sought for Quality Area 1</h2>
		   
		   <h3 style="color: #666; font-size: 16px; margin: 15px 0;">Improvement Plan</h3>
		
		   <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
			   <tr>
				   <th style="background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; width: 12%;">Standard/ element</th>
				   <th style="background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; width: 15%;">Issue identified during self-assessment</th>
				   <th style="background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; width: 15%;">What outcome or goal do we seek?</th>
				   <th style="background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; width: 8%;">Priority (L/M/H)</th>
				   <th style="background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; width: 15%;">How will we get this outcome? (Steps)</th>
				   <th style="background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; width: 15%;">Success measure</th>
				   <th style="background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; width: 8%;">By when?</th>
				   <th style="background-color: #E0E0E0; padding: 10px; border: 1px solid #ccc; width: 12%;">Progress notes</th>
			   </tr>
			   <tr>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
			   </tr>
			   <tr>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
			   </tr>
			   <tr>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
			   </tr>
			   <tr>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
				   <td style="padding: 20px; border: 1px solid #ccc;">&nbsp;</td>
			   </tr>
		   </table>
		</div>';
		
		$mpdf->WriteHTML($quality7thpage);
		
	}


	// $mpdf->AddPage('', '', '', '', '', 10, 10, 25, 25, 15, 15);

// // Add the rest of the content
// $contentHtml = $this->prepareHTML($json);
// $mpdf->WriteHTML($contentHtml);
     
	private function prepareHTML($apiData)
	{
		$html = '<h1>Quality Inspection Report</h1>';
		foreach ($apiData->selectedOptions as $option) {
			// Extract quality area (qa1, qa2, etc.)
			preg_match('/qa(\d+)_/', $option, $matches);
			$qualityAreaId = $matches[1];
	
			// Fetch data from database
			$records = $this->db->where('qipid', $apiData->id)
				->where('standardId', $qualityAreaId)
				->get('qip_standard_values')
				->result();
	
			// Create a section for each quality area
			$html .= '<h2>Quality Area: QA' . $qualityAreaId . '</h2>';
			$html .= '<table border="1" cellpadding="5" cellspacing="0">';
			$html .= '<tr><th>Val1</th><th>Val2</th><th>Val3</th></tr>';
	
			foreach ($records as $record) {
				$html .= '<tr>';
				$html .= '<td>' . $record->val1 . '</td>';
				$html .= '<td>' . $record->val2 . '</td>';
				$html .= '<td>' . $record->val3 . '</td>';
				$html .= '</tr>';
			}
	
			$html .= '</table><br><pagebreak />';
		}
	
		return $html;
	}



}