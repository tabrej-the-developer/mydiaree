<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        // Load database
        $this->load->database();
    }
    
    public function getUserCenters($userid) {
        // Using query binding for security
        $query = $this->db->query("SELECT id, centerName 
                                  FROM centers 
                                  WHERE id IN (SELECT DISTINCT(centerid) 
                                             FROM usercenters 
                                             WHERE userid = ?)", 
                                array($userid));
        return $query->result();
    }
}