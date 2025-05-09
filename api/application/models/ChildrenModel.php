<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChildrenModel extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getChilds($groupId=NULL,$childId=NULL)
	{	
		if ($childId != NULL) {
			$q = $this->db->get_where('child',array('id'=>$childId));
		}else if ($groupId != NULL) {
			$this->db->select('*');
			$this->db->from('child');
			$this->db->join('child_group_member', 'child.child_id = child_group_member.group_id');
			$this->db->where('child_group_member.group_id', $groupId);
			$q = $this->db->get();
		} else {
			$q = $this->db->get('child');
		}	
		return $q->result();
	}

	public function getChildsFromCenter($centerid='')
	{
		$q = $this->db->query("SELECT *, c.name as name, c.id as childid FROM `child` c INNER JOIN room r ON c.room = r.id WHERE r.centerid = ".$centerid);
		return $q->result();
	}

	public function getChildsOfCenter($centerid='')
	{
		$q = $this->db->query("SELECT c.* FROM `child` c INNER JOIN room r ON c.room = r.id WHERE r.centerid = ".$centerid);
		return $q->result();
	}

	public function getChildsFromGroups($groupId)
	{	
		$this->db->select('*');
		$this->db->from('child');
		$this->db->join('child_group_member', 'child.id = child_group_member.child_id');
		$this->db->where('child_group_member.group_id', $groupId);
		$q = $this->db->get();
		return $q->result();
	}

	public function getChildGroups($centerid='')
	{
		if ($centerid) {
			$q = $this->db->get_where('child_group',array('centerid'=>$centerid));
		}else{
			$q = $this->db->get('child_group');
		}
		return $q->result();		
	}

	// TO DO
	// public function moveChild($childId,$roomId){
	// 	$this->db->query("UPDATE child SET room = $roomId where id = $childId");
	// }

	// public function moveChild($childId, $roomId) {
	// 	// Fetch the room's capacity
	// 	$roomCapacityQuery = $this->db->query("SELECT capacity FROM room WHERE id = $roomId");
	// 	$room = $roomCapacityQuery->row();
	
	// 	if (!$room) {
	// 		return "Room not found"; // In case the room does not exist
	// 	}
	
	// 	$roomCapacity = $room->capacity;
	
	// 	// Fetch the current number of children in the room
	// 	$currentChildrenQuery = $this->db->query("SELECT COUNT(*) as childCount FROM child WHERE room = $roomId");
	// 	$currentChildren = $currentChildrenQuery->row()->childCount;
	
	// 	// Check if the room is full
	// 	if ($currentChildren >= $roomCapacity) {
	// 		return "Room capacity is full"; // Room is at full capacity
	// 	}
	
	// 	// Update the child's room
	// 	$this->db->query("UPDATE child SET room = $roomId WHERE id = $childId");
	
	// 	return "Child moved successfully"; // Success message
	// }


	public function moveChild($childId, $roomId) {
		// Fetch the room's capacity and age range
		$roomQuery = $this->db->query("SELECT capacity, ageFrom, ageTo FROM room WHERE id = $roomId");
		$room = $roomQuery->row();
	
		if (!$room) {
			return "Room not found"; // In case the room does not exist
		}
	
		$roomCapacity = $room->capacity;
		$ageFrom = $room->ageFrom;
		$ageTo = $room->ageTo;
	
		// Fetch the child's date of birth (dob)
		$childQuery = $this->db->query("SELECT dob FROM child WHERE id = $childId");
		$child = $childQuery->row();
	
		if (!$child) {
			return "Child not found"; // In case the child does not exist
		}
	
		// // Calculate the child's age from the date of birth
		// $dob = new DateTime($child->dob);
		// $now = new DateTime();
		// $childAge = $now->diff($dob)->y; // Calculate the age in years
	
		// // Check if the child's age is within the room's allowed age range
		// if ($childAge < $ageFrom || $childAge > $ageTo) {
		// 	return "Child's age does not fit within the room's age range";
		// }
	
		// Fetch the current number of children in the room
		// $currentChildrenQuery = $this->db->query("SELECT COUNT(*) as childCount FROM child WHERE room = $roomId");
		// $currentChildren = $currentChildrenQuery->row()->childCount;
	
		// Check if the room is full
		// if ($currentChildren >= $roomCapacity) {
		// 	return "Room capacity is full"; // Room is at full capacity
		// }
	
		// Update the child's room
		$this->db->query("UPDATE child SET room = $roomId WHERE id = $childId");
	
		return "Child moved successfully"; // Success message
	}
	
	

	public function getChildOfParent($parentid='')
	{
		$sql = "
        SELECT DISTINCT(cp.childid), c.name AS childname
        FROM `childparent` cp
        JOIN `child` c ON cp.childid = c.id
        WHERE cp.parentid = ".$parentid;

		//$sql = "SELECT DISTINCT(childid) FROM `childparent` WHERE parentid = ".$parentid;
		$q = $this->db->query($sql);
		return $q->result(); 

	}



	public function getChildsOfParent($parentid='')
	{
		$sql = "SELECT * FROM child WHERE id IN (SELECT DISTINCT(childid) FROM `childparent` WHERE parentid = ".$parentid.")";
		$q = $this->db->query($sql);
		return $q->result(); 
	}

	public function getChildRecord($childid='')
	{
		if (empty($childid)) {
			return NULL;
		}else{
			$sql = "SELECT c.*, r.centerid FROM `child` c LEFT JOIN room r ON c.room = r.id WHERE c.id=$childid";
			$q = $this->db->query($sql);
			return $q->row(); 
		}
	}

	public function getChildRelatives($childid='')
	{
		if (empty($childid)) {
			return NULL;
		}else{
			$sql = "SELECT * FROM `users` u WHERE userid IN (SELECT DISTINCT(parentid) FROM `childparent` WHERE childid = $childid)";
			$q = $this->db->query($sql);
			return $q->result(); 
		}
	}

	public function getParentRelation($id='')
	{
		$sql = "SELECT relation FROM `childparent` WHERE parentid = '".$id."'";
		$q = $this->db->query($sql);
		return $q->row()->relation;
	}

	public function getCenterRooms($centerid='')
	{
		$q = $this->db->get_where('room', array('centerid'=>$centerid));
		return $q->result();
	}

	public function getChildsFromRooms($roomid='')
	{
		$this->db->select('*,child.id AS childid,child.name as name');
		$this->db->from('child');
		$this->db->join('room', 'child.room = room.id');
		$this->db->where('room.id', $roomid);
		$q = $this->db->get();
		return $q->result();
	}

	function getCenterChilds($centerid = NULL){
		$sql = 'SELECT id, CONCAT_WS(" ", name, lastname) as name, imageUrl, DATE_FORMAT(dob, "%d %M %Y") AS dob, gender FROM `child` c WHERE c.room IN (SELECT DISTINCT(id) FROM `room` WHERE centerid = '.$centerid.') ORDER BY name ASC';
		$q = $this->db->query($sql);
		return $q->result();
	}

	function getChildsLastObservation($childid = NULL){
		$sql = 'SELECT * FROM `observation` WHERE id IN (SELECT DISTINCT(observationId) FROM `observationchild` WHERE childId = '.$childid.') ORDER BY id DESC LIMIT 1';
		$q = $this->db->query($sql);
		return $q->row();
	}

	function getObsPeriod($centerid = NULL){
		$q = $this->db->get_where('noticesettings', ['centerid'=>$centerid]);
		return $q->row();
	}

}

/* End of file ChildrenModel.php */
/* Location: ./api/application/models/ChildrenModel.php */