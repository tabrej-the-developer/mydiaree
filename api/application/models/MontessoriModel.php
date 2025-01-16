<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MontessoriModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function Montessori_sub_detail(){
        $get_details=$this->db->query("SELECT * FROM montessorisubactivity")->result();
        return $get_details;
    }
}