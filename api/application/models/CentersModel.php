<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CentersModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_center_details(){
        $get_details=$this->db->query("SELECT * FROM centers")->result();
        return $get_details;
    }
}