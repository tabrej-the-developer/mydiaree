<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getUserType($userid){
		$query = $this->db->query("SELECT * FROM users where userid = $userid");
		return $query->row();
	}

	public function getTotalRooms($userid){
		$query = $this->db->query("SELECT * FROM room where centerid IN (SELECT id FROM centers c where id IN (SELECT centerid FROM usercenters where userid = $userid))");
		return $query->result();	
	}
	public function getTotalChildren($userid){
		$query = $this->db->query("SELECT * FROM child where room IN (SELECT id FROM room where centerid IN (SELECT id FROM centers c where id IN (SELECT centerid FROM usercenters where userid = $userid)))");
		return $query->result();
	}
	public function getTotalStaff($userid){
		$query = $this->db->query("SELECT * FROM room_staff where roomid IN (SELECT id FROM room where centerid IN (SELECT id FROM centers c where id IN (SELECT centerid FROM usercenters where userid = $userid))) ");
		return $query->result();
	}
	public function getTotalObservations($userid){
		// $query = $this->db->query("SELECT * FROM Observation");
		$query = $this->db->query("SELECT * FROM observation where userId IN (SELECT userid FROM usercenters where centerid IN (SELECT centerid FROM usercenters where userid = '$userid'))");
		return $query->result();
	}
	// public function getTotalEvents($userid){
	// 	$query = $this->db->query("SELECT * FROM announcement where createdBy IN (SELECT userid FROM usercenters where centerid IN (SELECT centerid FROM usercenters where userid = '$userid') and eventDate <> '0000-00-00 00:00:00')");
	// 	return $query->result();
	// }

	public function getTotalEvents($userid) {
		$query = $this->db->query("
			SELECT * 
			FROM announcement 
			WHERE createdBy IN (
				SELECT userid 
				FROM usercenters 
				WHERE centerid IN (
					SELECT centerid 
					FROM usercenters 
					WHERE userid = '$userid'
				) 
				AND eventDate IS NOT NULL
			)
		");
		return $query->result();
	}
	

	public function getAnnouncements($userid,$month){
		$query = $this->db->query("SELECT * FROM announcement where createdBy IN (SELECT userid FROM usercenters where centerid IN (SELECT centerid FROM usercenters where userid = '$userid') and eventDate LIKE '%-$month-%')");
		return $query->result();
	}
	public function getStaffBirthdays($userid,$month){
		 $query = $this->db->query("SELECT * from users where userType = 'Staff' and userid IN (SELECT staffid FROM room_staff where roomid IN (SELECT id FROM room where centerid IN (SELECT centerid from usercenters where userid = '$userid'))) and dob LIKE '%$month-%'");
		 return $query->result();
	}
	public function getPublicHolidays($userid,$month){
		$query = $this->db->query("SELECT * FROM publicholidays where month = $month");
		return $query->result();
	}
	public function getChildBirthdays($userid,$month){
		$query = $this->db->query("SELECT * FROM child where room IN (SELECT id FROM room where centerid IN (SELECT id FROM centers c where id IN (SELECT centerid FROM usercenters where userid = $userid))) and dob LIKE '%$month-%'");
		return $query->result();
	}
	public function getAnnouncementsM($userid){
		$query = $this->db->query("SELECT * FROM announcement where createdBy IN (SELECT userid FROM usercenters where centerid IN (SELECT centerid FROM usercenters where userid = '$userid') and eventDate <> '0000-00-00')");
		return $query->result();
	}
	public function getStaffBirthdaysM($userid){
		 $query = $this->db->query("SELECT * from users where userType = 'Staff' and userid IN (SELECT staffid FROM room_staff where roomid IN (SELECT id FROM room where centerid IN (SELECT centerid from usercenters where userid = '$userid'))) ");
		 return $query->result();
	}
	public function getPublicHolidaysM($userid){
		$query = $this->db->query("SELECT * FROM publicholidays ");
		return $query->result();
	}
	public function getChildBirthdaysM($userid){
		$query = $this->db->query("SELECT * FROM child where room IN (SELECT id FROM room where centerid IN (SELECT id FROM centers c where id IN (SELECT centerid FROM usercenters where userid = $userid)))");
		return $query->result();
	}
	public function onlyUserType($userid)
	{
		$this->db->select('userType');
		$this->db->where('userid', $userid);
		$this->db->from('users');
		$query = $this->db->get();
		return $query->row();
	}
	public function getParentsAnnmnts($userid,$year){
		$query = $this->db->query("SELECT DISTINCT an.* FROM `announcement` an INNER JOIN `announcementchild` anc ON an.id = anc.aid WHERE anc.childid IN (SELECT childid FROM `childparent` WHERE parentid=$userid) AND an.eventDate LIKE '$year-%-%'");
		return $query->result();
	}

	public function getTotalParentObservations($userid){
		$query = $this->db->query("SELECT COUNT(DISTINCT(oc.observationId)) AS countObs FROM observationchild oc WHERE oc.childid IN (SELECT childid FROM childparent WHERE parentid = $userid)");
		return $query->row();
	}

	public function getTotalChildrenOfParent($userid)
	{
		$query = $this->db->query("SELECT COUNT(DISTINCT(cp.childid)) AS countChild FROM childparent cp WHERE cp.parentid = $userid");
		return $query->row();
	}

	public function getTotalEventsOfParent($userid){
		$query = $this->db->query("SELECT COUNT(DISTINCT(aid)) AS countEvents FROM announcementchild WHERE childid IN (SELECT childid FROM childparent WHERE parentid = $userid)");
		return $query->row();
	}

	public function getUpcomingEventsOfParent($userid)
	{
		$query = $this->db->query("SELECT COUNT(DISTINCT(anc.aid)) AS countEvents FROM announcementchild anc INNER JOIN announcement an ON anc.aid = an.id WHERE childid IN (SELECT childid FROM childparent WHERE parentid = $userid) AND an.eventDate > '".date('y-m-d')."'");
		return $query->row();
	}

	//Mohit codes
	// Total Recipes
	public function getTotalRecipes(){
		$query = $this->db->query("SELECT COUNT(*) AS countRecipes FROM `menu` WHERE currentDate = '".date('Y-m-d')."'");
		return $query->row();
	}

	//parent modules
	public function totalChildObservations($parentid='')
	{
		$sql = "SELECT DISTINCT(id) FROM `observationchild` WHERE childId IN (SELECT DISTINCT(childid) FROM `childparent` WHERE parentid = $parentid)";
		$q = $this->db->query($sql);
		return $q->num_rows();
	}

	public function totalChilds($parentid='')
	{
		$sql = "SELECT DISTINCT(childid) FROM `childparent` WHERE parentid = $parentid";
		$q = $this->db->query($sql);
		return $q->num_rows();
	}

	public function totalTodayRecipes($parentid='')
	{
		$sql = "SELECT DISTINCT(id) FROM `menu` WHERE centerId IN (SELECT DISTINCT(centerid) FROM `room` WHERE id IN (SELECT DISTINCT(room) FROM child WHERE id IN (SELECT DISTINCT(childid) FROM `childparent` WHERE parentid = $parentid))) AND currentDate = '".date('Y-m-d')."'";
		$q = $this->db->query($sql);
		return $q->num_rows();
	}

	public function totalChildEvents($parentid='')
	{
		$sql = "SELECT DISTINCT(id) FROM `announcement` WHERE eventDate = '".date('Y-m-d')."' AND id IN (SELECT DISTINCT(aid) FROM `announcementchild` WHERE childid IN (SELECT DISTINCT(childid) FROM `childparent` WHERE parentid = $parentid))";
		$q = $this->db->query($sql);
		return $q->num_rows();
	}

	public function childEvents($parentid='')
	{
		$sql = "SELECT id,title,eventDate AS start FROM `announcement` WHERE id IN (SELECT DISTINCT(aid) FROM `announcementchild` WHERE childid IN (SELECT DISTINCT(childid) FROM `childparent` WHERE parentid = $parentid))";
		$q = $this->db->query($sql);
		return $q->result();
	}
}

/* End of file DashboardModel.php */
