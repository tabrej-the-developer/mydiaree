<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->database();
	}
	public function getUser($email,$password){
		$query = $this->db->get_where('users', [
			'username' => $email,
			'password' => $password
		]);
		return $query->row();
	}
	public function getUserFromUsername($un){
		
		$query = $this->db->query("SELECT * FROM users where username = '$un'");
		return $query->row();
	}
	public function getUserFromEmail($email){
		
		$query = $this->db->query("SELECT * FROM users where emailid = '$email'");
		return $query->row();
	}
	public function getUserType($userid='')
	{
		$arr_criteria = ["userid"=>$userid];
		$q = $this->db->get_where('users', $arr_criteria);
		if(empty($q->row())){
			return false;
		}else{
			return $q->row()->userType;
		}
	}
	public function getUserFromId($userid){
		$query = $this->db->query("SELECT * FROM users where userid = '$userid'");
		return $query->row();
	}
	public function insertLogin($userid,$deviceid,$token,$deviceType){
		
		$query = $this->db->query("DELETE FROM logins WHERE userid = '$userid' AND deviceType = '$deviceType'");
		$query = $this->db->query("INSERT INTO logins VALUES(0,'$userid','".date('Y-m-d h:i:s')."','$deviceid','$token','N','$deviceType')");
	}
	public function getPermissions($userid){
		
		$query = $this->db->query("SELECT * FROM permissions WHERE userid = '$userid'");
		return $query->row();
	}
	public function logs($data){
		
		$usertype = $data['usertype'];
		$userid = $data['userid'];
		$login_at = $data['login_at'];
		$ip = $data['ip'];
		$auth = $data['auth_token'];
		$query = $this->db->query("INSERT into log (usertype , userid , login_at , ip , auth_token) VALUES ('$usertype', '$userid', '$login_at', '$ip', '$auth')");
	}
	public function getAuthUserId($deviceId,$authToken){
		
		$query = $this->db->query("SELECT * FROM logins WHERE deviceId='$deviceId' and authToken='$authToken' and isLoggedOutYN='N'");
		
		return $query->row();
	}


	
	// public function getLogins($deviceId){
		
	// 	$query = $this->db->query("SELECT u.name,u.emailid,u.userType,u.username FROM logins l left join users u on (u.userid=l.userid) WHERE l.deviceId='$deviceId' and u.userType IN ('Superadmin','Staff') group by  u.name,u.emailid,u.userType ");
	// 	return $query->result();
	// }

	public function getLogins($deviceId) {
		$this->db->select('u.name, u.emailid, u.userType, u.username');
		$this->db->from('logins l');
		$this->db->join('users u', 'u.userid = l.userid', 'left');
		$this->db->where('l.deviceId', $deviceId);
		$this->db->where_in('u.userType', ['Superadmin', 'Staff']);
		$this->db->group_by('u.name');
		$this->db->group_by('u.emailid');
		$this->db->group_by('u.userType');
		$this->db->group_by('u.username');
		
		$query = $this->db->get();
		return $query->result();
	}
	

	public function getUserCenters($userid){
		
		$query = $this->db->query("SELECT id, centerName FROM centers WHERE id IN (SELECT DISTINCT(centerid) FROM usercenters WHERE userid = $userid)");
		return $query->result();
	}

	public function getChildsRoomId($parentid)
	{
		$q = $this->db->query("SELECT c.room FROM child c INNER JOIN childparent cp ON c.id = cp.childid WHERE cp.parentid = $parentid");
		return $q->result();
	}
	
	public function getRoomCenters($roomid){
		
		$query = $this->db->query("SELECT centerName,id from centers where id IN (SELECT centerid FROM room where id = $roomid)");
		return $query->row();
	}

	public function getTheme($themeid='')
	{
		$q = $this->db->get_where('themes', array("id"=>$themeid));
		return $q->row();
	}

	public function getParentCenters($parentid='')
	{
		$sql = "SELECT id,centerName FROM `centers` WHERE id IN (SELECT DISTINCT(centerid) FROM `room` WHERE id IN (SELECT DISTINCT(room) FROM `child` WHERE id IN (SELECT DISTINCT(childid) FROM `childparent` WHERE parentid = $parentid)))";
		// echo $sql; exit;
		$q = $this->db->query($sql);
		return $q->result();
	}
}
?>