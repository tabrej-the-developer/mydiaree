<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ServiceDetailsModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

    public function addServiceDetails($data)
    {
        $this->db->query("INSERT INTO servicedetails (serviceName,serviceApprovalNumber,serviceStreet,serviceSuburb,serviceState,servicePostcode,contactTelephone,contactMobile,contactFax,contactEmail,providerContact,providerTelephone,providerMobile,providerFax,providerEmail,supervisorName,supervisorTelephone,supervisorMobile,supervisorFax,supervisorEmail,postalStreet,postalSuburb,postalState,postalPostcode,eduLeaderName,eduLeaderTelephone,eduLeaderEmail,strengthSummary,childGroupService,personSubmittingQip,educatorsData,philosophyStatement,centerid) VALUES ('$data->serviceName','$data->serviceApprovalNumber','$data->serviceStreet','$data->serviceSuburb','$data->serviceState','$data->servicePostcode','$data->contactTelephone','$data->contactMobile','$data->contactFax','$data->contactEmail','$data->providerContact','$data->providerTelephone','$data->providerMobile','$data->providerFax','$data->providerEmail','$data->supervisorName','$data->supervisorTelephone','$data->supervisorMobile','$data->supervisorFax','$data->supervisorEmail','$data->postalStreet','$data->postalSuburb','$data->postalState','$data->postalPostcode','$data->eduLeaderName','$data->eduLeaderTelephone','$data->eduLeaderEmail','$data->strengthSummary','$data->childGroupService','$data->personSubmittingQip','$data->educatorsData','$data->philosophyStatement',$data->centerid) ");
    }

    public function updateServiceDetails($data){
    	$this->db->query("UPDATE servicedetails SET serviceName = '$data->serviceName', serviceApprovalNumber = '$data->serviceApprovalNumber', serviceStreet = '$data->serviceStreet', serviceSuburb = '$data->serviceSuburb', serviceState = '$data->serviceState', servicePostcode = '$data->servicePostcode', contactTelephone = '$data->contactTelephone', contactMobile = '$data->contactMobile', contactFax = '$data->contactFax', contactEmail = '$data->contactEmail', providerContact = '$data->providerContact', providerTelephone = '$data->providerTelephone', providerMobile = '$data->providerMobile', providerFax = '$data->providerFax', providerEmail = '$data->providerEmail', supervisorName = '$data->supervisorName', supervisorTelephone = '$data->supervisorTelephone', supervisorMobile = '$data->supervisorMobile', supervisorFax = '$data->supervisorFax', supervisorEmail = '$data->supervisorEmail', postalStreet = '$data->postalStreet', postalSuburb = '$data->postalSuburb', postalState = '$data->postalState', postalPostcode = '$data->postalPostcode', eduLeaderName = '$data->eduLeaderName', eduLeaderTelephone = '$data->eduLeaderTelephone', eduLeaderEmail = '$data->eduLeaderEmail', strengthSummary = '$data->strengthSummary', childGroupService = '$data->childGroupService', personSubmittingQip = '$data->personSubmittingQip', educatorsData = '$data->educatorsData', philosophyStatement = '$data->philosophyStatement' where centerid = $data->centerid ");
    }

    public function getServiceDetails($centerid){
    	$query = $this->db->query("SELECT * FROM servicedetails where centerid = $centerid ");
    	return $query->row();
    } 

    public function deleteServiceDetails($id){
    	$query = $this->db->query("DELETE FROM servicedetails where id = '$id' ");
    } 
	
}

/* End of file ServiceDetailsModel.php */


