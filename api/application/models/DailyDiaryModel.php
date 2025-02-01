<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DailyDiaryModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getUserCenters($userid)
	{
		$query = $this->db->get_where("usercenters",array("userid"=>$userid));
		return $query->result();
	}

	public function getRooms($centerid=NULL,$roomid=NULL)
	{
		if($centerid==NULL && $roomid==NULL) {
			$query = $this->db->get("room");
		}
		elseif($roomid==NULL) {
			$query = $this->db->get_where("room",array("centerid"=>$centerid));
		} else { 
			$query = $this->db->get_where("room",array("id"=>$roomid));
		}
		return $query->result();
	}

	public function getChildsFromRoom($roomid)
	{
		$query = $this->db->get_where("child",array("room"=>$roomid));
		return $query->result();
	}

	public function getChildsFromRoomOfParent($roomid,$parentid)
	{	
		$query = $this->db->query("SELECT * FROM child c INNER JOIN childparent cp ON c.id = cp.childid WHERE c.room = $roomid AND cp.parentid = $parentid");
		return $query->result();
	}

	public function getBreakfast($childid,$date=NULL)
	{	
		if ($date==NULL) {
			$query = $this->db->get_where("dailydiarybreakfast",array("childid"=>$childid));
		} else {
			$query = $this->db->get_where("dailydiarybreakfast",array("childid"=>$childid,"diarydate"=>$date));
		}
		return $query->row();
	}

	public function getMorningTea($childid,$date=NULL)
	{
		if ($date==NULL) {
			$query = $this->db->get_where("dailydiarymorningtea",array("childid"=>$childid));
		} else {
			$query = $this->db->get_where("dailydiarymorningtea",array("childid"=>$childid,"diarydate"=>$date));
		}
		return $query->row();
	}

	public function getLunch($childid,$date=NULL)
	{
		if ($date==NULL) {
			$query = $this->db->get_where("dailydiarylunch",array("childid"=>$childid));
		} else {
			$query = $this->db->get_where("dailydiarylunch",array("childid"=>$childid,"diarydate"=>$date));
		}
		return $query->row();
	}

	public function getSleep($childid,$date=NULL)
	{
		if ($date==NULL) {
			$query = $this->db->get_where("dailydiarysleep",array("childid"=>$childid));
		} else {
			$query = $this->db->get_where("dailydiarysleep",array("childid"=>$childid,"diarydate"=>$date));
		}
		return $query->result();
	}

	public function getAfternoonTea($childid,$date=NULL)
	{
		if ($date==NULL) {
			$query = $this->db->get_where("dailydiaryafternoontea",array("childid"=>$childid));
		} else {
			$query = $this->db->get_where("dailydiaryafternoontea",array("childid"=>$childid,"diarydate"=>$date));
		}
		return $query->row();
	}

	public function getSnacks($childid,$date=NULL)
	{
		if ($date==NULL) {
			$query = $this->db->get_where("dailydiarysnacks",array("childid"=>$childid));
		} else {
			$query = $this->db->get_where("dailydiarysnacks",array("childid"=>$childid,"diarydate"=>$date));
		}
		return $query->row();
	}

	public function getSunscreen($childid,$date=NULL)
	{
		if ($date==NULL) {
			$query = $this->db->get_where("dailydiarysunscreen",array("childid"=>$childid));
		} else {
			$query = $this->db->get_where("dailydiarysunscreen",array("childid"=>$childid,"diarydate"=>$date));
		}
		return $query->result();
	}

	public function getToileting($childid, $date = NULL) {
		if ($date == NULL) {
			$query = $this->db->get_where("dailydiarytoileting", array("childid" => $childid));
		} else {
			$query = $this->db->get_where("dailydiarytoileting", array("childid" => $childid, "diarydate" => $date));
		}
		return $query->result(); // Changed from row() to result() to return all matching rows as an array
	}

	public function getItems($search=null,$type=null){
		$query = $this->db->query("SELECT * FROM `recipes` WHERE itemName LIKE '%$search%' AND `type` = '".$type."'");
		return $query->result();
	}

	public function addFoodRecord($data,$table)
	{	
		if (isset($data->diarydate)) {
			$diarydate = date('Y-m-d', strtotime($data->diarydate));
		} else {
			$diarydate = date("Y-m-d");
		}
		
		$this->db->delete($table, array('childid' => $data->childid, 'diarydate' => $diarydate));
		$ins_data = array(
		    'childid' => $data->childid,
		    'diarydate' => $diarydate,
		    'startTime' => $data->startTime,
		    'item' => isset($data->item)?$data->item:NULL,
		    'calories' => isset($data->calories)?$data->calories:0,
		    'qty' => isset($data->qty)?$data->qty:0,
		    'comments' => $data->comments,
		    'createdBy' => $data->userid,
		    'createdAt' => date('Y-m-d h:i:s')
		);
		$this->db->insert($table, $ins_data);
		$insertId = $this->db->insert_id();
		return  $insertId;
	}

	public function addSleepRecord($data,$delete=NULL)
	{
		if (isset($data->diarydate)) {
			$diarydate = date('Y-m-d', strtotime($data->diarydate));
		} else {
			$diarydate = date("Y-m-d");
		}
		if ($delete==NULL) {
			$this->db->delete('dailydiarysleep', array('childid' => $data->childid, 'diarydate' => $diarydate));
		}
		
		$ins_data = array(
		    'childid' => $data->childid,
		    'diarydate' => $diarydate,
		    'startTime' => $data->startTime,
		    'endTime' => $data->endTime,
		    'comments' => $data->comments,
		    'createdBy' => $data->userid,
		    'createdAt' => date('Y-m-d h:i:s')
		);
		$this->db->insert("dailydiarysleep", $ins_data);
		$insertId = $this->db->insert_id();
		return  $insertId;
	}

	public function addToiletingRecord($data)
{
    if (isset($data->diarydate)) {
        $diarydate = date('Y-m-d', strtotime($data->diarydate));
    } else {
        $diarydate = date("Y-m-d");
    }
    
    // Delete existing records for this child and date
    $this->db->delete('dailydiarytoileting', array('childid' => $data->childid, 'diarydate' => $diarydate));

    // Prepare to insert multiple records
    $insert_batch = [];
    
    // Count the number of entries based on startTime array
    $entry_count = count($data->startTime);
    
    for ($i = 0; $i < $entry_count; $i++) {
        $ins_data = array(
            'childid' => $data->childid,
            'diarydate' => $diarydate,
            'startTime' => $data->startTime[$i],
            // 'nappy' => $data->nappy[$i] ?? null,
            // 'potty' => $data->potty[$i] ?? null,
            // 'toilet' => $data->toilet[$i] ?? null,
            'signature' => $data->signature[$i] ?? null,
            'status' => $data->nappy_status[$i] ?? null,
            'comments' => $data->comments[$i] ?? null,
            'createdBy' => $data->userid,
            'createdAt' => date('Y-m-d H:i:s')
        );
        
        $insert_batch[] = $ins_data;
    }
    
    // Insert multiple records
    if (!empty($insert_batch)) {
        $this->db->insert_batch("dailydiarytoileting", $insert_batch);
    }
    
    return $this->db->affected_rows();
}

public function addSunscreenRecord($data)
{
    if (isset($data->diarydate)) {
        $diarydate = date('Y-m-d', strtotime($data->diarydate));
    } else {
        $diarydate = date("Y-m-d");
    }
    
    // Delete existing records for this child and date
    $this->db->delete('dailydiarysunscreen', array('childid' => $data[0]->childid, 'diarydate' => $diarydate));

    // Prepare to insert multiple records
    $insert_batch = [];
    
    // Insert each entry in the sunscreen array
    foreach ($data as $entry) {
        $ins_data = array(
            'childid' => $entry->childid,
            'diarydate' => $diarydate,
            'startTime' => $entry->startTime,
            'comments' => $entry->comments,
            'createdBy' => $entry->userid,
            'createdAt' => date('Y-m-d H:i:s')
        );
        
        $insert_batch[] = $ins_data;
    }
    
    // Insert multiple records
    if (!empty($insert_batch)) {
        $this->db->insert_batch("dailydiarysunscreen", $insert_batch);
    }
    
    return $this->db->affected_rows();
}

public function addSunscreenRecord2($data)
{
    if (isset($data->diarydate)) {
        $diarydate = date('Y-m-d', strtotime($data->diarydate));
    } else {
        $diarydate = date("Y-m-d");
    }

    $insert_batch = [];

    foreach ($data->childids as $childid) {
        // Delete existing records for this child and date
        $this->db->delete('dailydiarysunscreen', ['childid' => $childid, 'diarydate' => $diarydate]);

        // Prepare new entry
        $ins_data = [
            'childid'   => $childid,
            'diarydate' => $diarydate,
            'startTime' => $data->startTime,
            'comments'  => $data->comments,
            'createdBy' => $data->userid,
            'createdAt' => date('Y-m-d H:i:s')
        ];

        $insert_batch[] = $ins_data;
    }

    // Insert multiple records
    if (!empty($insert_batch)) {
        $this->db->insert_batch("dailydiarysunscreen", $insert_batch);
    }

    return $this->db->affected_rows();
}


	public function getChildInfo($childid)
	{
		$query = $this->db->query("SELECT c.id, c.name, c.room as roomId, r.name as roomName, r.color FROM child c INNER JOIN room r ON c.room = r.id WHERE c.id = $childid");
		return $query->result();
	}

	public function getItemNameOfChild($childid,$date,$table)
	{
		$query = $this->db->query("SELECT item FROM $table WHERE childid = '".$childid."' AND diarydate = '".$date."'");
		foreach ($query->result() as $row)
		{
		    return $row->item;
		}
	}

	public function getRecipes($type=NULL)
	{
		if ($type==NULL) {
			$query = $this->db->get("recipes");
		} else {
			$query = $this->db->get_where("recipes",array('type'=>strtoupper($type)));
		}
		return $query->result();
	}

	public function getCenterRooms($centerid)
	{
		$query = $this->db->get_where("room",array('centerid'=>$centerid));
		return $query->result();
	}

	public function getCenterDDSettings($centerid='')
	{
		$q = $this->db->get_where('dailydiarysettings', array('centerid'=>$centerid));
		return $q->row();
	}
}

/* End of file DailyDiaryModel.php */
/* Location: ./application/models/DailyDiaryModel.php */