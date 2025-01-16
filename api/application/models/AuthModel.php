<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model {

	public function getAuthUserId($deviceId,$authToken){
		$this->load->database();
		$query = $this->db->query("SELECT * FROM logins WHERE deviceId='$deviceId' and authToken='$authToken' and isLoggedOutYN='N' ORDER BY id DESC");
		return $query->row();
	}

	public function getUserDetails($userid){
		$this->load->database();
		$query = $this->db->query("SELECT * FROM users WHERE userid='$userid'");
		return $query->row();
	}

	public function getSuperAdminId($userid){
		$this->load->database();
		$query = $this->db->query("SELECT * FROM `users` where role = 1 and instr(center,(SELECT u.center FROM users as u WHERE u.id='$userid'))");
		return $query->row();
	}

	public function getUserFromEmail($email){
		$this->load->database();
		$query = $this->db->query("SELECT * FROM users where emailid = '$email'");
		return $query->row();
	}
		public function getUserFromId($email){
		$this->load->database();
		$query = $this->db->query("SELECT * FROM users where id = '$email'");
		return $query->row();
	}
	
	public function insertUser($email,$password,$name,$role,$title,$center,$manager,$createdBy,$roleid,$level,$bonusRate){
		$this->load->database();
		$uid = uniqid();
		$query = $this->db->query("INSERT INTO users  VALUES('$uid','$email','$password','$name',null,$role,'$title','$center|','$manager','N',now(),'$createdBy',$roleid,$level,$bonusRate,null)");
		return $uid;
	}

	public function verifyUser($userid){
		$this->load->database();
		$query = $this->db->query("UPDATE users SET isVerified = 'Y' WHERE id='$userid'");
	}

	public function insertToken($userid,$token,$isForgotYN){
		$this->load->database();
		$query = $this->db->query("INSERT INTO authtokens VALUES(0,'$userid','$token','$isForgotYN')");
	}

	public function getToken($userid,$token){
		$this->load->database();
		$query = $this->db->query("SELECT * FROM authtokens WHERE userid = '$userid' AND token = '$token'");
		return $query->row();
	}

	public function deleteToken($userid,$token){
		$this->load->database();
		$this->db->query("DELETE FROM authtokens WHERE userid='$userid' AND token = '$token'");
	}

	public function updatePassword($userid,$password){
		$this->load->database();
		$this->db->query("UPDATE users SET password = '$password' WHERE userid='$userid'");
	}

	public function getUser($email,$password){
		$this->load->database();
		$query = $this->db->query("SELECT * FROM users WHERE (email='$email' OR id='$email') and password='$password'");
		return $query->row();
	}

	public function getAuthUser($userid,$password){
		$this->load->database();
		$query = $this->db->query("SELECT * FROM users WHERE id='$userid' AND password = '$password'");
		return $query->row();
	}

	public function insertLogin($userid,$deviceid,$token,$deviceType){
		$this->load->database();
		$query = $this->db->query("DELETE FROM logins WHERE userid = '$userid' AND deviceType = '$deviceType'");
		$query = $this->db->query("INSERT INTO logins VALUES(0,'$userid','now()','$deviceid','$token','N','$deviceType')");
	}

	public function getPermissions($userid){
		$this->load->database();
		$query = $this->db->query("SELECT * FROM permissions WHERE userid = '$userid'");
		return $query->row();
	}
	public function logs($data){
		$this->load->database();
		$usertype = $data['usertype'];
		$userid = $data['userid'];
		$login_at = $data['login_at'];
		$ip = $data['ip'];
		$auth = $data['auth_token'];
		$query = $this->db->query("INSERT into log (usertype , userid , login_at , ip , auth_token) VALUES (   '$usertype', '$userid', '$login_at', '$ip', '$auth')");
	}
	public function logoutTime($id){
		$this->load->database();
		$date = date('Y-m-d H:i:s');
		$query =  $this->db->query("UPDATE  log SET logout_at = '$date'  WHERE auth_token = '$id'");
	}

}


