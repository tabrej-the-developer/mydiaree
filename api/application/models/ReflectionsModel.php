<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReflectionsModel extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getReflection($refid='')
	{
		$arr_criteria = ['id'=>$refid];
		$q = $this->db->get_where('reflection', $arr_criteria);
		return $q->row();
	}

	public function getCenterReflections($centerid='')
	{
		$arr_criteria = ['centerid'=>$centerid];
		$q = $this->db->get_where('reflection', $arr_criteria);
		return $q->result();
	}

	public function getReflectionMedias($reflectionId='')
	{
		$arr_criteria = ['reflectionid'=>$reflectionId];
		$q = $this->db->get_where('reflectionmedia', $arr_criteria);
		return $q->result();
	}

	public function getReflectionMediaChilds($refMediaId='')
	{
		$arr_criteria = ['mediaId'=>$refMediaId];
		$q = $this->db->get_where('reflectionmediachilds', $arr_criteria);
		return $q->result();
	}

	public function getReflectionMediaStaffs($refMediaId='')
	{
		$arr_criteria = ['mediaid'=>$refMediaId];
		$q = $this->db->get_where('reflectionmediaeducators', $arr_criteria);
		return $q->result();
	}

	public function getReflectionChilds($refId='')
	{
		$q = $this->db->query("SELECT c.id as childid, c.name, c.imageUrl FROM child c INNER JOIN reflectionchild rc ON c.id = rc.childid WHERE rc.reflectionid = $refId");
		return $q->result();
	}

	public function getReflectionStaffs($refId='')
	{
		$q = $this->db->query("SELECT u.userid, u.name, u.imageUrl FROM users u INNER JOIN reflectionstaff rs ON u.userid = rs.staffid WHERE rs.reflectionid = $refId");
		return $q->result();
	}


	public function createReflection($data='')
	{
		$insarr = [
			"title"=>$data['title'],
			"centerid"=>$data['centerid'],
			"about"=>$data['about'],
			"eylf"=>$data['eylf'],
			"roomids" => $data['room'], // Convert array to comma-separated string
			"status"=>strtoupper($data['status']),
			"createdBy"=>$data['userid'],
			"createdAt"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('reflection', $insarr);
		return $this->db->insert_id();
	}

	public function insertReflectionMedia($data='')
	{
		$insarr = [
			"reflectionid"=>$data->reflectionId,
			"mediaUrl"=>$data->mediaUrl,
			"mediaType"=>$data->mediaType
		];
		$this->db->insert('reflectionmedia', $insarr);
		return $this->db->insert_id();
	}

	public function deleteReflection($reflid='')
	{
		$this->db->delete("reflectionmedia",['reflectionid'=>$reflid]);
		$this->db->delete("reflectionchild",['reflectionid'=>$reflid]);
		$this->db->delete("reflectionstaff",['reflectionid'=>$reflid]);
		$this->db->delete("reflection",['id'=>$reflid]);
		return $this->db->affected_rows();
	}

	public function getUserReflections($userid='')
	{
		$query = $this->db->get_where('reflection', ['createdBY'=>$userid]);
		return $query->result();
	}

	public function getParentsReflections($userid = '') {
		if (empty($userid)) {
			return [];
		}
	
		// Step 1: Get all child IDs where parentid = $userid
		$this->db->select('childid');
		$this->db->from('childparent');
		$this->db->where('parentid', $userid);
		$query = $this->db->get();
		$child_ids = array_column($query->result(), 'childid'); // Fetch as object
	
		if (empty($child_ids)) {
			return [];
		}
	
		// Step 2: Get all reflection IDs where childid is in the above child_ids
		$this->db->select('reflectionid');
		$this->db->from('reflectionchild');
		$this->db->where_in('childid', $child_ids);
		$query = $this->db->get();
		$reflection_ids = array_column($query->result(), 'reflectionid'); // Fetch as object
	
		if (empty($reflection_ids)) {
			return [];
		}
	
		// Step 3: Get all reflection data where id is in the above reflection_ids
		$this->db->select('*');
		$this->db->from('reflection');
		$this->db->where_in('id', $reflection_ids);
		$this->db->where('status', 'PUBLISHED');
		$query = $this->db->get();
		
		return $query->result(); // Return as object
	}
	
	


	public function insertReflectionChild($refid='',$childid='')
	{
		$insarr = [
			"reflectionid"=>$refid,
			"childid"=>$childid
		];
		$this->db->insert('reflectionchild', $insarr);
		return $this->db->insert_id();
	}

	public function insertReflectionEducators($refid='',$staffid='')
	{
		$insarr = [
			"reflectionid"=>$refid,
			"staffid"=>$staffid
		];
		$this->db->insert('reflectionstaff', $insarr);
		return $this->db->insert_id();
	}

	public function getCenterStaffs($centerid='')
	{
		$sql = "SELECT u.* FROM `users` u INNER JOIN `usercenters` uc ON u.userid = uc.userid WHERE u.userType = 'Staff' AND uc.centerid = $centerid";
		$q = $this->db->query($sql);
		return $q->result();
	}

    public function getRef($refId=NULL){
    	$query = $this->db->query("SELECT * FROM reflection where id = $refId");
    	$data = $query->row();
    	if (!empty($data)) {
    		$data->children = $this->getReflectionChilds($refId);
    	}    	
    	return $data;
    }

	public function updateReflection($data='')
	{
		$insarr = [
			"title"=>$data['title'],
			"centerid"=>$data['centerid'],
			"about"=>$data['about'],
			"eylf"=>$data['eylf'],
			"roomids" => $data['room'],
			"status"=>strtoupper($data['status']),
			"createdBy"=>$data['userid'],
			"createdAt"=>date('Y-m-d h:i:s')
		];
		$this->db->where('id',$data['reflectionid']);
		$this->db->update('reflection', $insarr);
		return $this->db->affected_rows();
	}

	public function removeChildsAndStaffs($reflid='')
	{
		$this->db->delete("reflectionchild",['reflectionid'=>$reflid]);
		$this->db->delete("reflectionstaff",['reflectionid'=>$reflid]);
		return true;
	}

    public function checkChildInRefl($refid='',$childid='')
    {
    	$q = $this->db->get_where('reflectionchild', array("reflectionid"=>$refid,"childid"=>$childid));
    	return $q->row();
    }
}

/* End of file ReflectionsModel.php */
/* Location: ./application/models/ReflectionsModel.php */