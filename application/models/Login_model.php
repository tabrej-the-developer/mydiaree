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


    public function getCenterUsersParent($centerid = '', $userid = '', $order = NULL, $search = NULL)
{
    $sql = "SELECT DISTINCT(u.userid), u.name, u.imageUrl, u.status, u.dob 
            FROM `usercenters` uc 
            INNER JOIN `users` u ON uc.userid = u.userid 
            WHERE uc.centerid = $centerid AND u.userType = 'Parent'";

    if (!empty($userid)) {
        $sql .= " AND u.userid != $userid";
    }

    if (!empty($search)) {
        $search = $this->db->escape_like_str($search); // Sanitize input
        $sql .= " AND u.name LIKE '%$search%'";
    }

    if ($order != NULL) {
        $sql .= " ORDER BY u.userid " . strtoupper($order);
    }

    $query = $this->db->query($sql);
    $parents = $query->result();

    // (Child loading logic remains the same...)
    foreach ($parents as $parent) {
        $this->db->select('childid, relation');
        $this->db->from('childparent');
        $this->db->where('parentid', $parent->userid);
        $childLinks = $this->db->get()->result();

        $childData = [];

        foreach ($childLinks as $link) {
            $this->db->select('name, lastname');
            $this->db->from('child');
            $this->db->where('id', $link->childid);
            $child = $this->db->get()->row();

            if ($child) {
                $childData[] = (object)[
                    'name' => $child->name,
                    'lastname' => $child->lastname,
                    'relation' => $link->relation
                ];
            }
        }

        $parent->children = $childData;
    }

    return $parents;
}



}