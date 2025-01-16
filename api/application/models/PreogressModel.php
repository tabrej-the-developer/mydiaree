<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PreogressModel extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
 
 	//inserting progress notes
	public function addProgressNote($data='')
	{
		$object = [
			'childid'=>$data->childid,
			'centerid'=>$data->centerid,
			'p_development'=>$data->p_development,
			'emotion_development'=>$data->emotion_development,
			'social_development'=>$data->social_development,
			'child_interests'=>$data->child_interests,
			'other_goal'=>$data->other_goal,
			'created_by'=>$data->userid,
			'created_at'=>date('Y-m-d h:i:s')
		];
		$this->db->insert('progressnotes', $object);
		return $this->db->insert_id();
		// return $this->db->set($object)->get_compiled_insert('mytable');
	}

	//updating progress notes
	public function updateProgressNote($data='')
	{
		$object = [
			'childid'=>$data->childid,
			'centerid'=>$data->centerid,
			'p_development'=>$data->p_development,
			'emotion_development'=>$data->emotion_development,
			'social_development'=>$data->social_development,
			'child_interests'=>$data->child_interests,
			'other_goal'=>$data->other_goal,
			'created_by'=>$data->userid,
			'created_at'=>date('Y-m-d h:i:s')
		];
		$condition = ['id'=>$data->pnid];
		$this->db->update('progressnotes', $object, $condition);
		return $this->db->affected_rows();
		// return $this->db->set($object)->get_compiled_update('progressnotes');
	}

	//fetching all records
	public function getCenterProgressNotes($centerid='')
	{
		$con_arr = ['centerid'=>$centerid];
		$q = $this->db->get_where('progressnotes',$con_arr);
		return $q->result();
	}

	//fetching one record
	public function getProgressNote($pnid='')
	{
		$con_arr = ['id'=>$pnid];
		$q = $this->db->get_where('progressnotes',$con_arr);
		return $q->row();
	}

	//fetching user details
	public function getUserDetails($userid='')
	{
		$con_arr = ['userid'=>$userid];
		$q = $this->db->get_where('users',$con_arr);
		return $q->row();
	}

	//deleting progress notes
	public function deleteProgressNote($pnid='')
	{
		$con_arr = ['id'=>$pnid];
		$q = $this->db->delete('progressnotes',$con_arr);
		return $this->db->affected_rows();
	}

	//fetching child progressNotes
	public function getChildProgressNotes($childid='')
	{
		$con_arr = ['childid'=>$childid];
		$q = $this->db->get_where('progressnotes',$con_arr);
		return $q->result();
	}
} 
