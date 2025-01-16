<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SelfAssessmentModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getLastSelfAssessment()
	{
		$this->db->select('id');
		$this->db->order_by('added_at', 'desc');
		$this->db->limit(1);
		$this->db->from('self_assessment');
		$q = $this->db->get();
		return $q->row();
	}

	public function addNewSelfAssessment($data='')
	{
		$array = [
			"centerid"=>$data->centerid,
			"name"=>$data->name,
			"added_by"=>$data->userid,
			"added_at"=>date("Y-m-d H:i:s")
		];
		$this->db->insert("self_assessment",$array);
		return $this->db->insert_id();
	}

	public function getAllAssessments($centerid=NULL)
	{
		$this->db->select('*');
		$this->db->order_by('added_at', 'desc');
		$this->db->from('self_assessment');
		$this->db->where('centerid',$centerid);
		$q = $this->db->get();
		return $q->result();
	}

	public function getUserAssessments($userid='',$centerid='')
	{
		$sql = "SELECT * FROM `self_assessment` WHERE centerid = ".$centerid." AND added_by = ".$userid." ORDER BY added_at DESC";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getAssessmentEducators($seAsmntId='')
	{
		$this->db->select('users.userid,users.name,users.imageUrl,users.gender');
		$this->db->from('users');
		$this->db->join('self_assessment_users', 'users.userid = self_assessment_users.userid');
		$this->db->where('self_assessment_users.self_assess_id', $seAsmntId);
		$q = $this->db->get();
		return $q->result();
	}

	public function getSelfAsmntDetails($id='')
	{
		$q = $this->db->get_where('self_assessment', array("id"=>$id));
		return $q->row();
	}

	public function getLegislativeReqs($areaid='')
	{
		$q = $this->db->get_where("self_assessment_legltv_req", array("areaid"=>$areaid));
		return $q->result();
	}

	public function getLegislativeReqsVals($self_asmnt_id='')
	{
		$q = $this->db->get_where("self_assessment_legltv_req_values", array("self_asmnt_lgltv_id"=>$self_asmnt_id));
		return $q->row();
	}

	public function getSelfAsmntQualityAreas($areaid='')
	{
		$q = $this->db->get_where("self_assessment_quality_area", array("areaid"=>$areaid));
		return $q->result();
	}

	public function getSelfAsmntQualityAreasVals($id='')
	{
		$q = $this->db->get_where("self_assessment_quality_area_values", array("saqa_id"=>$id));
		return $q->row();
	}

	public function saveLegalRecords($data='')
	{
		$this->db->delete("self_assessment_legltv_req_values",array("self_asmnt_lgltv_id"=>$data->id));
		$array = [
			"self_asmnt_lgltv_id" => $data->id,
			"status" => $data->status,
			"actions" => $data->notice,
			"added_by" => $data->user,
			"added_at" => date("Y-m-d H:i:s")
		];
		$this->db->insert("self_assessment_legltv_req_values",$array);
	}

	public function saveQualityRecords($data='')
	{
		$this->db->delete("self_assessment_quality_area_values",array("saqa_id"=>$data->id));
		$array = [
			"saqa_id" => $data->id,
			"status" => $data->status,
			"identified_practice" => $data->ip,
			"added_by" => $data->user,
			"added_at" => date("Y-m-d H:i:s")
		];
		$this->db->insert("self_assessment_quality_area_values",$array);
	}

	public function getCenterStaffs($centerid='')
	{
		$sql = "SELECT DISTINCT(u.userid) AS userpk, u.* FROM `users` u INNER JOIN usercenters uc ON u.userid = uc.userid WHERE uc.centerid = ".$centerid." AND u.userType = 'STAFF'";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function deleteSelfAssessment($said='')
	{
		$this->db->delete('self_assessment', array("id"=>$said));
	}

	public function deleteSelfAssessmUsers($said='')
	{
		$this->db->delete('self_assessment_users', array("self_assess_id"=>$said));
	}

	public function addSelfAssessmStaffs($data='')
	{
		$array = [
			"self_assess_id" => $data['self_assess_id'],
			"userid" => $data['userid'],
			"added_by" => $data['added_by'],
			"added_at" => date('Y-m-d h:i:s')
		];
		$this->db->insert("self_assessment_users",$array);
	}

	public function checkStaffInAssessment($userid='',$selfid='')
	{
		$q = $this->db->get_where('self_assessment_users', array("self_assess_id"=>$selfid,"userid"=>$userid));
		return $q->row();
	}
}

/* End of file SelfAssessmentModel.php */
/* Location: ./application/models/SelfAssessmentModel.php */