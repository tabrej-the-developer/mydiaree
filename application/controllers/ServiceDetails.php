<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceDetails extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index($centerId=NULL)
	{

		if($this->session->has_userdata('LoginId')){
			
			if (empty($_GET['centerid'])) {
				$centerArr = $this->session->userdata("centerIds");
				$centerId = $centerArr[0]->id;
			}else{
				$centerId = $_GET['centerid'];
			}

			$userid = $this->session->userdata('LoginId');

			$url = BASE_API_URL."/serviceDetails/getServiceDetails/$userid/$centerId";
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
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				$jsonOutput->centerid = $centerId;
			    $this->load->view('createServiceDetailsForm',$jsonOutput);
			}
			if($httpcode == 400){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function exeServiceForm(){

		if($this->session->has_userdata('LoginId')){

			//Form data validation
			$this->form_validation->set_rules('serviceName', 'Service Name', 'trim|strip_tags');
			$this->form_validation->set_rules('serviceApprovalNumber', 'Service Approval Number', 'trim|strip_tags');
			$this->form_validation->set_rules('serviceStreet', 'Service Street', 'trim|strip_tags');
			$this->form_validation->set_rules('serviceSuburb', 'Service Suburb', 'trim|strip_tags');
			$this->form_validation->set_rules('serviceState', 'Service State', 'trim|strip_tags');
			$this->form_validation->set_rules('servicePostcode', 'Service Postcode', 'trim|strip_tags');
			// $this->form_validation->set_rules('servicePostcode', 'Service Postcode', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('contactTelephone', 'Telephone', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('contactMobile', 'Mobile', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('contactFax', 'Fax', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('contactEmail', 'Email', 'trim|strip_tags|valid_email');
			// $this->form_validation->set_rules('providerContact', 'Contact', 'trim|strip_tags');
			// $this->form_validation->set_rules('providerTelephone', 'Telephone', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('providerMobile', 'Mobile', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('providerFax', 'Fax', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('providerEmail', 'Email', 'trim|strip_tags|valid_email');
			// $this->form_validation->set_rules('supervisorName', 'Name', 'trim|strip_tags');
			// $this->form_validation->set_rules('supervisorTelephone', 'Telephone', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('supervisorMobile', 'Mobile', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('supervisorFax', 'Fax', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('supervisorEmail', 'Email', 'trim|strip_tags|valid_email');
			// $this->form_validation->set_rules('postalStreet', 'Street', 'trim|strip_tags');
			// $this->form_validation->set_rules('postalSuburb', 'Suburb', 'trim|strip_tags');
			// $this->form_validation->set_rules('postalState', 'State', 'trim|strip_tags');
			// $this->form_validation->set_rules('postalPostcode', 'Postcode', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('eduLeaderName', 'Leader Name', 'trim|strip_tags');
			// $this->form_validation->set_rules('eduLeaderTelephone', 'Telephone', 'trim|strip_tags|numeric or empty');
			// $this->form_validation->set_rules('eduLeaderEmail', 'Email', 'trim|strip_tags|valid_email');
			// $this->form_validation->set_rules('strengthSummary', 'Text', 'trim|strip_tags');
			// $this->form_validation->set_rules('childGroupService', 'Text', 'trim|strip_tags');
			// $this->form_validation->set_rules('personSubmittingQip', 'Text', 'trim|strip_tags');
			// $this->form_validation->set_rules('educatorsData', 'Text', 'trim|strip_tags');
			// $this->form_validation->set_rules('philosophyStatement', 'Text', 'trim|strip_tags');


			if ($this->form_validation->run() == FALSE)
            {
                $this->index();
            }else{
            	$data = $this->input->post();
            	$data['userid'] = $this->session->userdata('LoginId');
				$url = BASE_API_URL."/serviceDetails/createServiceDetails/";
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
					$jsonOutput=json_decode($server_output);
					curl_close ($ch);
					
				    // $this->load->view('createServiceDetailsForm',$data);
				    // print_r($server_output);
				    // $this->index($data['centerid']);
				    redirect("ServiceDetails?centerId=".$data['centerid']);

				}

            }
		}else{
			redirect('welcome');
		}
	}
}

/* End of file ServiceDetails.php */
/* Location: ./application/controllers/ServiceDetails.php */