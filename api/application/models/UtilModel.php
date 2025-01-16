<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UtilModel extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function GetAllCenters($userid=NULL)
	{
		if ($userid==NULL) {
			$query = $this->db->get("centers");
		} else {
			$query = $this->db->query("SELECT * FROM centers where id IN (SELECT centerid FROM usercenters where userid = '$userid')");
		}
		return $query->result();
	}

	public function GetAllCentersBySuperadmin($userid){
		$query = $this->db->query("SELECT * FROM centers where id IN (SELECT usercenters.centerid FROM users INNER JOIN usercenters on users.userid = usercenters.userid where userType = 'Superadmin' and usercenters.centerid IN (SELECT centerid FROM usercenters where userid = '$userid')) ");
		return $query->result();
	}

	public function getChildsRoomId($parentid)
	{
		$q = $this->db->query("SELECT c.room FROM child c INNER JOIN childparent cp ON c.id = cp.childid WHERE cp.parentid = $parentid");
		return $q->result();
	}
	
	public function getRoomCenters($roomid){
		$this->load->database();
		$query = $this->db->query("SELECT centerName,id from centers where id IN (SELECT centerid FROM room where id = $roomid)");
		return $query->row();
	}

	public function getUserDetails($userid='')
	{
		$q = $this->db->get_where("users",array("userid"=>$userid));
		return $q->row();
	}

	public function getPermissions($user,$centerid)
	{
		$q = $this->db->get_where("permissions",array("userid"=>$user,"centerid"=>$centerid));
		//return print_r($q); 
		return $q->row();
	}

	public function hasPermission($userid="",$perCol="")
	{
		$returnVar = 0;
		$sql = "SELECT * FROM permissions WHERE userid = ".$userid;
		$q = $this->db->query($sql);
		foreach ($q->result() as $key => $obj) {
			foreach ($obj as $k => $o) {
				if($k == $perCol && $o == 1){
					$returnVar = 1;
				}
			}
		}
		return $returnVar;
	}

	public function getAllStaffs()
	{
		$sql = "SELECT userid,name FROM `users` WHERE userType = 'Staff'";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getNoPermission()
	{
		$q = $this->db->get_where("permissions",array("id"=>0));
		return $q->row();
	}

	public function getEveryPermission()
	{
		$q = $this->db->get_where("permissions",array("id"=>1));
		return $q->row();
	}

	public function GetParentCenters($userid='')
	{
		$sql = "SELECT c.* FROM `centers` c WHERE id IN (SELECT DISTINCT(centerid) FROM room WHERE id IN(SELECT DISTINCT(room) FROM child WHERE id IN (SELECT DISTINCT(childid) FROM `childparent` WHERE parentid = ".$userid.")))";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getCenterEducators($centerid='')
	{
		$sql = "SELECT DISTINCT(u.userid) AS userid, u.* FROM `users` u INNER JOIN usercenters uc ON u.userid = uc.userid WHERE uc.centerid = ".$centerid." AND u.userType = 'Staff'";
		$q = $this->db->query($sql);
		return $q->result();
	}
}