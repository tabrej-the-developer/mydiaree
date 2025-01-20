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
}