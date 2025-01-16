<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersModel extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function getUser($user_id)
	{
		# code for getting user details on user_id

		$q = $this->db->get_where('users', array('userid' => $user_id));
		return $q->result();
	}

	public function getUserDetails($user_id)
	{
		# code for getting user details on user_id

		$q = $this->db->get_where('users', array('userid' => $user_id));
		return $q->row();
	}

	public function user(){
		$user = $this->db->query("SELECT * FROM users")->result();
		return $user;
	}
}

/* End of file UsersModel.php */
/* Location: ./application/models/announcementsModel.php */