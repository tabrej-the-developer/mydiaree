<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ResourcesModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function addResource($data)
	{
		$data = array(
	        'title'=>$data['title'],
	        'description'=>$data['description'],
	        'createdAt'=>$data['createdAt'],
	        'createdBy'=>$data['createdBy']
	    );
	    $this->db->insert('resource',$data);
	    $insert_id = $this->db->insert_id();
		return $insert_id;
	}

    public function insResMedia($rid,$mediaUrl,$mediaType)
    {
        $insData = array(
			'resourceid' => $rid,
			'mediaUrl' => $mediaUrl,
			'mediaType' => $mediaType
		);
		$this->db->insert('resourcemedia',$insData);
    }

    public function getUserDetails($userid)
    {
        $query = $this->db->get_where('users',array('userid'=>$userid));
        return $query->row();
    }

    public function getUserCenters($userid,$limit=NULL)
    {
        $query = $this->db->get_where('usercenters', array('userid' => $userid), $limit);
        return $query->result();
    }

    public function getUsersFromCenter($centerid){
        $query = $this->db->get_where('usercenters', array('centerid' => $centerid));
        return $query->result();
    }

	public function isAdmin($userid)
	{
		$query = $this->db->get_where("users",array('userid'=>$userid,'userType'=>'Superadmin'));
		foreach($query->result() as $res){
			if ($res->userType == "Superadmin") {
				return 1;
			} else {
				return 0;
			}
		}
	}

	public function getAllResources($userid=NULL)
	{
		#pass user id to get specific user records
		if($userid==NULL){
			$query = $this->db->get("resource");
		}else{
			$query = $this->db->get_where("resource",array("createdBy"=>$userid));
		}
		return $query->result();
	}

	public function getAllResourcesByAdmin($adminId,$page=0)
	{
		if ($page==0) {
			$query = $this->db->query("SELECT * FROM `resource` WHERE createdBy IN (SELECT DISTINCT(userid) FROM usercenters WHERE centerid IN (SELECT centerid FROM usercenters WHERE userid = $adminId)) ORDER BY createdAt DESC");
		}else{
			if ($page==1) {
				$query = $this->db->query("SELECT * FROM `resource` WHERE createdBy IN (SELECT DISTINCT(userid) FROM usercenters WHERE centerid IN (SELECT centerid FROM usercenters WHERE userid = $adminId)) ORDER BY createdAt DESC LIMIT 10");
			} else {
				$sql = "SELECT * FROM `resource` WHERE createdBy IN (SELECT DISTINCT(userid) FROM usercenters WHERE centerid IN (SELECT centerid FROM usercenters WHERE userid = $adminId)) ORDER BY createdAt DESC LIMIT 10 OFFSET ".(($page-1)*10+1);
				$query = $this->db->query($sql);
			}
			
		}
		
		return $query->result();
	}

	public function getResourceMedia($resId)
	{
		$query = $this->db->get_where("resourcemedia", array("resourceid"=>$resId));
		return $query->result();
	}
	
	public function getResourceLikes($resId)
	{
		$query = $this->db->get_where("resourcelike", array("resourceid"=>$resId));
		return $query->result();
	}

	public function getResourceComments($resId)
	{
		$query = $this->db->get_where("resourcecomments", array("resourceid"=>$resId));
		return $query->result();
	}

	public function countComments($resId='')
	{
		$sql = "SELECT COUNT(*) AS totalComments FROM resourcecomments WHERE resourceid = $resId";
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function insertLike($userid,$resId)
	{
		$insData = array(
			'resourceid' => $resId,
			'userid' => $userid,
			'createdAt' => date("Y-m-d H:i:s")
		);
		$this->db->insert('resourcelike',$insData);
		return $this->db->insert_id();
	}

	public function getLikeRecord($likeid='')
	{
		$q = $this->db->get_where('resourcelike', ['id'=>$likeid]);
		return $q->row();
	}

	public function countLikes($resId='')
	{
		$sql = "SELECT COUNT(*) as likes FROM `resourcelike` WHERE resourceid = " . $resId;
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function insertComment($userid,$resId,$comment)
	{
		$insData = array(
			'resourceid' => $resId,
			'userid' => $userid,
			'comment' => $comment,
			'createdAt' => date("Y-m-d H:i:s")
		);
		$this->db->insert('resourcecomments',$insData);
		return $this->db->insert_id();
	}

	public function removeLike($id)
	{
		if($this->db->delete('resourcelike', array('id' => $id))){
			return 1;
		}else{
			return 0;
		}
	}

	public function removeComment($id)
	{
		if($this->db->delete('resourcecomments', array('id' => $id))){
			return 1;
		}else{
			return 0;
		}
	}

	public function insertShare($userid,$resId,$shareType)
	{
		$insData = array(
			'resourceid' => $resId,
			'userid' => $userid,
			'shareType	' => $shareType,
			'createdAt' => date("Y-m-d H:i:s")
		);

		if($this->db->insert('resourceshare',$insData)){
			return 1;
		}else{
			return 0;
		}
	}

	public function deleteResource($resId)
	{
		$rsr = $this->db->delete('resource', array('id' => $resId));
		$rsrLike = $this->db->delete('resourcelike', array('resourceid' => $resId));
		$rsrMedia = $this->db->delete('resourcemedia', array('resourceid' => $resId));
		$rsrShare = $this->db->delete('resourceshare', array('resourceid' => $resId));
		$rsrComment = $this->db->delete('resourcecomments', array('resourceid' => $resId));

		if ($rsr == 1) {  // && $rsrLike == 1 && $rsrMedia == 1 && $rsrShare == 1 && $rsrComment == 1
			return 1;
		} else {
			return 0;
		}
		
	}

	public function getUserResources($userid,$resId = NULL)
	{
		if ($resId==NULL) {
			$query = $this->db->get_where("resource",array("createdBy"=>$userid));
		} else {
			$query = $this->db->get_where("resource",array("createdBy"=>$userid,"id"=>$resId));
		}
		return $query->result();
	}

	public function getResource($resId=NULL)
	{
		if ($resId==NULL) {
			$query = $this->db->get("resource");
		} else {
			$query = $this->db->get_where("resource",array("id"=>$resId));
		}
		return $query->result();
	}


	public function getComments($resourceId)
	{
		$query = $this->db->query("SELECT rc.id, u.name, rc.comment, rc.createdAt FROM `resourcecomments` rc INNER JOIN `users` u ON `rc`.`userid` = `u`.`userid` WHERE `rc`.`resourceid` = $resourceId");
		return $query->result();
	}

	public function fetchComments($resourceId=NULL, $limit=NULL, $order=DESC)
	{
		if($limit==NULL){
			$query = $this->db->query("SELECT rc.id, u.name, rc.comment, rc.createdAt FROM `resourcecomments` rc INNER JOIN `users` u ON `rc`.`userid` = `u`.`userid` WHERE `rc`.`resourceid` = $resourceId ORDER BY rc.createdAt DESC");
		}else{
			$query = $this->db->query("SELECT rc.id, u.name, u.imageUrl, rc.comment, rc.createdAt FROM `resourcecomments` rc INNER JOIN `users` u ON `rc`.`userid` = `u`.`userid` WHERE `rc`.`resourceid` = $resourceId ORDER BY rc.createdAt $order LIMIT $limit");
		}
		return $query->result();
	}

	public function getAllStaff()
	{
		$this->db->select('userid AS id, name');
		$q = $this->db->get_where("users",array("userType"=>"Staff"));
		return $q->result();
	}

	public function getAuthorsFromCenter($centerid='')
	{
		$sql = "SELECT u.userid as id, u.name FROM `users` u WHERE userid IN (SELECT DISTINCT(userid) FROM usercenters WHERE centerid = ".$centerid.")";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getFilterResources($data='')
	{
		$sql= "SELECT * FROM `resource`";

		//if author is present
		if (!empty($data->author)) {

			$sql.=" WHERE createdBy = '".$data->author."' ";

			if (!empty($data->fromdate) && !empty($data->todate)) {
				$sql.="AND createdAt BETWEEN '".$data->fromdate."' AND '".$data->todate."'";
			}

		}else{
			if (!empty($data->centerid) ) {
				$sql.=" WHERE 'createdBy' IN (SELECT DISTINCT(userid) FROM usercenters WHERE centerid = ".$data->centerid.") ";
				if (!empty($data->fromdate) && !empty($data->todate)) {
					$sql.="AND createdAt BETWEEN '".$data->fromdate."' AND '".$data->todate."'";
				}
			}else{
				if (!empty($data->fromdate) && !empty($data->todate)) {
					$sql.=" WHERE createdAt BETWEEN '".$data->fromdate."' AND '".$data->todate."'";
				}
			}

			
		}

		if (empty($data->page) || $data->page == 0) {
			$sql .= "";
		}elseif ($data->page == 1) {
			$sql .= " LIMIT 10";  
		}else{
			$data->page = (int)$data->page;
			$sql .= " LIMIT 10 OFFSET ".(($data->page - 1) * 10 + 1);

		}
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getTagsCount($tag='')
	{
		$sql = "SELECT count(*) AS number FROM resourcestags WHERE tags = '".$tag."'"; 
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function updateTagsCount($tag='')
	{
		$sql = "UPDATE resourcestags SET count = count + 1, last_modified = '".date("Y-m-d h:i:sa")."' WHERE tags = '".$tag."'"; 
		$q = $this->db->query($sql);
	}

	public function insertResTags($tag='')
	{
		$insArr = [
			"tags"=>$tag,
			"count"=>1,
			"last_modified"=>date("Y-m-d h:i:sa")
		];
		$this->db->insert("resourcestags",$insArr);
	}

	public function getTrendingTags($value='')
	{	
		$this->db->order_by('count', 'DESC');
		$query = $this->db->get('resourcestags', 5);
		return $query->result();
	}

	public function filterTagsResources($data='')
	{
		$i = 1;

		foreach ($data as $key => $obj) {
			if ($i==1) {
				$sql = "SELECT * FROM `resource` WHERE `description` LIKE '%".$obj."%'";
			}else{
				$sql .= " OR `description` LIKE '%".$obj."%'";
			}
			$i++;
		}
		
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getUsername($userid='')
	{
		$sql = "SELECT userid AS id, name, imageUrl FROM users WHERE userid = $userid";
		$q = $this->db->query($sql);
		return $q->row();
	}
}
