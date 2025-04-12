<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HeadChecksModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getUserCenters($userid){
		$query = $this->db->query("SELECT centerName,id from centers where id IN (SELECT centerid FROM usercenters where userid = $userid)");
		return $query->result();
	}

	public function getRooms($centerid=NULL,$roomid=NULL)
	{
		if($centerid==NULL && $roomid==NULL) {
			$query = $this->db->get("room");
		}elseif($roomid==NULL) {
			$query = $this->db->get_where("room",array("centerid"=>$centerid));
		} else {
			$query = $this->db->get_where("room",array("id"=>$roomid));
		}
		return $query->result();
	}

	public function addHeadChecks($data,$delete=NULL)
	{
		
		if ($delete==NULL) {
			$this->db->delete('dailydiaryheadcheck', array('diarydate' => $data->diarydate,'createdBy' => $data->createdBy,'roomid' => $data->roomid));
		}
		
		$ins_data = array(
		    'headcount' => $data->headCount,
		    'diarydate' => $data->diarydate,
		    'time' => $data->time,
		    'signature' => $data->signature,
		    'roomid' => $data->roomid,
		    'comments' => $data->comments,
		    'createdBy' => $data->createdBy,
		    'createdAt' => $data->createdAt
		);
		$this->db->insert("dailydiaryheadcheck", $ins_data);
		$insertId = $this->db->insert_id();
		return  $insertId;
	}

	public function getHeadChecks($userid = NULL,$diarydate=NULL,$roomid=NULL)
	{
		if ($userid == NULL) {
			$query = $this->db->get("dailydiaryheadcheck");
		} else {
			$query = $this->db->get_where("dailydiaryheadcheck",array("createdBy"=>$userid,"diarydate"=>$diarydate,"roomid"=>$roomid));
		}
		return $query->result();
	}

	public function getsleepChecks($userid = NULL,$diarydate=NULL,$roomid=NULL)
	{
		if ($userid == NULL) {
			$query = $this->db->get("dailydiarysleepchecklist");
		} else {
			$query = $this->db->get_where("dailydiarysleepchecklist",array("diarydate"=>$diarydate,"roomid"=>$roomid));
		}
		return $query->result();
	}

}

/* End of file HeadChecksModel.php */
/* Location: ./application/models/HeadChecksModel.php */