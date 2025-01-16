<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class programPlanModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function createPlan($data){		
		$id=mt_rand();
		$explode=explode(" - ",$data->period);
		$start_date=date('Y-m-d',strtotime($explode[0]));
		$end_date=date('Y-m-d',strtotime($explode[1]));
		$this->db->query("INSERT INTO programplan SET id = " . $id. ",roomid = '" . $data->roomid. "',startDate='".$start_date."',
						 endDate='".$end_date."',inqTopicTitle = '" . $data->inqTopicTitle. "',susTopicTitle = '" . $data->susTopicTitle. "',
						 inqTopicDetails = '" . $data->inqTopicDetails. "',
						 susTopicDetails = '" . $data->susTopicDetails. "',artExperiments = '" . $data->artExperiments. "',
						 activityDetails = '" . $data->activityDetails. "',outdoorActivityDetails = '" . $data->outdoorActivityDetails. "',
						 otherExperience = '" . $data->otherExperience. "',specialActivity = '" . $data->specialActivity. "',
						 createdBy = " . $data->userid . ",createdAt=NOW()");
		if(!empty($data->educators))
		{
			foreach($data->educators as $key=>$educator)
			{
				$this->db->query("INSERT INTO programstaff SET programid=".$id.",staffid=".$educator."");
			}	
		}
		return $id;
	}
	public function updatePlan($data){
		
		$id=$data->id;
		$explode=explode(" - ",$data->period);
		$start_date=date('Y-m-d',strtotime($explode[0]));
		$end_date=date('Y-m-d',strtotime($explode[1]));
		$this->db->query("UPDATE programplan SET startDate='".$start_date."',inqTopicTitle='".$data->inqTopicTitle."',
						 endDate='".$end_date."',susTopicTitle = '" . $data->susTopicTitle. "',inqTopicDetails = '" . $data->inqTopicDetails. "',
						 susTopicDetails = '" . $data->susTopicDetails. "',artExperiments = '" . $data->artExperiments. "',
						 activityDetails = '" . $data->activityDetails. "',outdoorActivityDetails = '" . $data->outdoorActivityDetails. "',
						 otherExperience = '" . $data->otherExperience. "',specialActivity = '" . $data->specialActivity. "',
						 createdBy = " . $data->userid . ",createdAt=NOW() where id = " . $id. "");
		$this->db->query("DELETE FROM programstaff where  programid=".$id."");
		if(!empty($data->educators))
		{
			foreach($data->educators as $key=>$educator)
			{
				$this->db->query("INSERT INTO programstaff SET programid='".$id."',staffid='".$educator."'");
			}	
		}
		return $id;
	}
	public function deletePlan($id){
		$this->load->database();
		$this->db->query("DELETE FROM programplan where id=".$id."");
		$this->db->query("DELETE FROM programstaff where programid=".$id."");
	}
	public function getRooms($centerid=NULL){
		if ($centerid==NULL) {
			$query = $this->db->query("SELECT * FROM room");
		} else {
			$query = $this->db->query("SELECT * FROM room WHERE centerid = ".$centerid);
		}
		return $query->result();
	}
	public function getPlan($id){
		$query = $this->db->query("SELECT p.*, r.name as roomName, r.color as roomColor, r.centerid as centerid FROM programplan p left join room r on (r.id=p.roomid) where p.id=".$id."");
		return $query->row();
	}
	public function getPlanEducators($id){
		$this->load->database();
		$query = $this->db->query("SELECT p.staffid as userId,u.name as userName FROM programstaff p left join users u on 
								  (u.userid=p.staffid) where p.programid=".$id."");
		return $query->result();
	}
	public function getPlans($centerid=NULL){
		if ($centerid==NULL) {
			$query = $this->db->query("SELECT p.*,r.name as roomName FROM programplan p left join room r on (r.id=p.roomid)");
		} else {
			$query = $this->db->query("SELECT p.*,r.name as roomName FROM programplan p left join room r on (r.id=p.roomid) WHERE r.id IN (SELECT id FROM `room` WHERE centerid = ".$centerid." )");
		}
		return $query->result();
	}

	public function getCenterId($roomId){
		$arr_criteria = array("id"=>$roomId);
		$this->db->select("centerid");
		$q = $this->db->get_where('room', $arr_criteria);
		return $q->row();
	}

	public function getProgramPlans($centerid='')
	{
		$sql = "SELECT * FROM programplan WHERE roomid IN (SELECT DISTINCT(ID) FROM room WHERE centerid = ".$centerid.") ORDER BY createdAt DESC";
		$q = $this->db->query($sql);
		return $q->result();
	}
}