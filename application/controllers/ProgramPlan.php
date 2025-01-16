
<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
   
class ProgramPlan extends CI_Controller {  
      
    public function index()  
    {
		if($this->session->has_userdata('LoginId')){
			redirect('programPlan/getList');
		}else{
			$this->load->view('welcome');
		} 
    }

	public function delete()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'programPlan/delete/'.$data['userid'].'/'.$_GET['id'];
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
				redirect('programPlan');
			  curl_close ($ch);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}
	}
	public function add()
	{
		if($this->session->has_userdata('LoginId')){
			if($_SERVER['REQUEST_METHOD']=='POST') {
			    $data = $this->input->post();
				$data['userid'] = $this->session->userdata('LoginId');
				$url = BASE_API_URL.'programPlan/createPlan';
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
					curl_close ($ch);
					redirect('programPlan');
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
			if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['id']))
			{
			    $data = $this->input->post();
				$data['userid'] = $this->session->userdata('LoginId');
				$data['id'] = $_GET['id'];
				$url = BASE_API_URL.'programPlan/updatePlan';
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
					redirect('programPlan');
				  curl_close ($ch);
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
	public function printPdf()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL.'programPlan/printForm/'.$data['userid'].'/'.$_GET['id'];
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
				
				$html = $this->load->view('plan_printpdf',$data,true);
				$mpdf->WriteHTML($html);
                $mpdf->Output();
			    curl_close ($ch);
			}
			if($httpcode == 401){
				return 'error';
			}
		}
	}
	public function email()
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$post = $this->input->post();
			$url = BASE_API_URL.'programPlan/printForm/'.$data['userid'].'/'.$_GET['id'];
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
				$html = $this->load->view('plan_printpdf',$data,true);
				$mpdf->WriteHTML($html);
				$attach_pdf_multipart = chunk_split( base64_encode( $mpdf->Output( 'programplan.pdf', 'S' ) ) );
				//print_r($data->sta);
				$to = $post['email'];
		        //define the subject of the email 
		        $subject = 'Program Plan'; 
		        //create a boundary string. It must be unique 
		        //so we use the MD5 algorithm to generate a random hash 
		        $random_hash = md5(date('r', time())); 
		        //define the headers we want passed. Note that they are separated with \r\n 
		        $headers = "From: Mykronicle@noreply.com\r\nReply-To: Mykronicle@noreply.com"; 
		        //add boundary string and mime type specification 
		        $headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";
		        $msg='';
		        $msg .= "Content-Type: application/octet-stream; name=\"programplan.pdf\"\r\n";
		        $msg .= "Content-Transfer-Encoding: base64\r\n";
		        $msg .= "Content-Disposition: attachment\r\n";
		        $msg .= $attach_pdf_multipart . "\r\n";

		        $msg .= "Content-Type: text/html; charset=\"iso-8859-1\"\r\n";
		        $msg .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
		        $msg .= "<p>This is text message from shohag</p>\r\n\r\n";  
		        @mail( $to, $subject, $msg, $headers );
                redirect('programPlan/edit?id='.$_GET['id']);
		        curl_close ($ch);
			}
			if($httpcode == 401){
				return 'error';
			}
		}
	}
	public function getList()
	{
	   if($this->session->has_userdata('LoginId')){

	   		if (isset($_GET['centerid'])) {
		    	$centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
		    }else{
		    	$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
		    }

		    $url = BASE_API_URL."/programPlan/getPlans/".$this->session->userdata('LoginId')."/".$centerid;
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
			    $this->load->view('programPlan_list',$data);
			}
			else if($httpcode == 401){
				redirect('welcome');
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

		    $url = BASE_API_URL."/programPlan/getProgramPlanForm/".$this->session->userdata('LoginId')."/".$centerid."/".$id;
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
			    $this->load->view('programPlan_form',$data);
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
			
	   }else{
		redirect('welcome');
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
				//var_dump($server_output);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				 print_r(($server_output));
			}
		}
	}	
}  
?>