<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MediaModel extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
	}

	public function insertMedia($data='')
	{
		$insArr = array(
			"userid" => $data['userid'],
			"filename" => $data['name'],
			"type" => $data['type'],
			"centerid" => $data['centerid'],
			"caption" => addslashes($data['caption']),
			"uploaded_date" => date('Y-m-d')
		);
		$this->db->insert('media', $insArr);
		$insertId = $this->db->insert_id();
		return $insertId;
	}

	public function insertMediaTags($data='')
	{
		$insArr = array(
			"mediaId" => $data['mediaId'],
			"userid" => $data['userid'],
			"usertype" => $data['usertype']
		);
		$this->db->insert('mediatags', $insArr);
	}

	public function getMediaInfo($mediaId='')
	{
		$sql = "SELECT m.*, u.name AS createdBy, u.imageUrl AS userImage FROM `media` m INNER JOIN `users` u ON m.userid = u.userid WHERE m.id = $mediaId";
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function getMediaChildTags($mediaId='')
	{
		$arr_criteria = [
			"mediaId" => $mediaId,
			"usertype" => "child"
		];
		$q = $this->db->get_where('mediatags', $arr_criteria);
		return $q->result();
	}

	public function getMediaStaffTags($mediaId='')
	{
		$arr_criteria = [
			"mediaId" => $mediaId,
			"usertype" => "staff"
		];
		$q = $this->db->get_where('mediatags', $arr_criteria);
		return $q->result();
	}

	public function updateMediaInfo($data='')
	{
		$sql = "UPDATE `media` SET caption='".$data->imgCaption."' WHERE id = ".$data->mediaId;
		$q = $this->db->query($sql);
	}

	public function updateMediaTagsInfo($data='')
	{
		$this->db->delete("mediatags",array("mediaId"=>$data->mediaId));
		foreach ($data->tags as $key => $tg) {
			$sql = "INSERT INTO `mediatags`(`mediaId`, `userid`, `usertype`) VALUES ('".$tg->mediaid."','".$tg->userid."','".$tg->usertype."')";
			$q = $this->db->query($sql);
		}
	}

	public function getRecentMedias($data='')
	{
		$sql = "SELECT * FROM `media` WHERE userid = ".$data->userid." AND centerid = ".$data->centerid." ORDER BY id DESC LIMIT 10";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getThisWeekMedias($data='')
	{
		$sql = "SELECT * FROM `media` WHERE userid = ".$data->userid." AND centerid = ".$data->centerid." AND uploaded_date BETWEEN '".$data->weekDate."' AND '".$data->today."' ORDER BY id DESC";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getEarlierMedias($data='')
	{
		$sql = "SELECT * FROM `media` WHERE userid = ".$data->userid." AND centerid = ".$data->centerid." ORDER BY id DESC";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getRecentChildMediaId($data='')
	{
		$sql = "SELECT * FROM `media` WHERE id IN (SELECT DISTINCT(mediaId) FROM `mediatags` WHERE usertype = 'child' AND userid IN (".$data->childstr.")) AND centerid = ".$data->centerid." ORDER BY id LIMIT 10";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getThisWeekChildMediaId($data='')
	{
		$sql = "SELECT * FROM `media` WHERE id IN (SELECT DISTINCT(mediaId) FROM `mediatags` WHERE usertype = 'child' AND userid IN (".$data->childstr.")) AND centerid = ".$data->centerid." AND uploaded_date BETWEEN '".$data->weekDate."' AND '".$data->today."'";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getEarlierChildMediaId($data='')
	{
		$sql = "SELECT * FROM `media` WHERE id IN (SELECT DISTINCT(mediaId) FROM `mediatags` WHERE usertype = 'child' AND userid IN (".$data->childstr.")) AND centerid = ".$data->centerid." ORDER BY id";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function deleteMedia($mediaId){
		$mquery = $this->db->query("DELETE FROM media WHERE id = $mediaId");
		$mtquery = $this->db->query("DELETE FROM mediatags WHERE mediaId = $mediaId");
	}

	public function getMediaOfChildren($childid='')
	{
		$sql = "SELECT * FROM `media` WHERE id IN (SELECT DISTINCT(mediaId) FROM `mediatags` WHERE userid = '".$childid."' AND usertype = 'child')";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getChildInfo($childid='')
	{
		$q = $this->db->query("SELECT id, CONCAT_WS(' ',name,lastname) as name, imageUrl FROM `child` WHERE id = $childid");
		return $q->row();
	}

	public function getStaffInfo($staffid='')
	{
		$q = $this->db->query("SELECT userid AS id, name, imageUrl FROM `users` WHERE userid = $staffid");
		return $q->row();
	}
}

/* End of file MediaModel.php */
/* Location: ./application/models/MediaModel.php */