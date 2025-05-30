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

	public function getRooms2($userid) {
        $this->load->database();

        // Raw SQL to get all room IDs where staffid = $userid
        $sql = "SELECT roomid FROM room_staff WHERE staffid = ?";
        $query = $this->db->query($sql, [$userid]);

        // Fetch room IDs
        $roomIds = array_column($query->result_array(), 'roomid');

        if (empty($roomIds)) {
            return []; // Return empty array if no rooms found
        }

        // Convert array to comma-separated string for SQL query
        $roomIdString = implode(',', array_map('intval', $roomIds));

        // Raw SQL to get all rooms with matching room IDs
        $sql = "SELECT * FROM room WHERE id IN ($roomIdString)";
        $query = $this->db->query($sql);

        return $query->result(); // Return room data
    }



	public function getRoomsofParents($userid) {
		if (empty($userid)) {
			return [];
		}
	
		// Step 1: Get all child IDs where parentid = $userid
		$this->db->select('childid');
		$this->db->from('childparent');
		$this->db->where('parentid', $userid);
		$query = $this->db->get();
		$child_ids = array_column($query->result(), 'childid');
	
		if (empty($child_ids)) {
			return [];
		}
	
		// Step 2: Get all room IDs where child ID is in the child_ids
		$this->db->select('room');
		$this->db->from('child');
		$this->db->where_in('id', $child_ids);
		$this->db->where('room IS NOT NULL'); // Skip if no room is assigned
		$query = $this->db->get();
		$room_ids = array_column($query->result(), 'room');
	
		if (empty($room_ids)) {
			return [];
		}
	
		// Step 3: Get all room data where id is in the room_ids
		$this->db->select('*');
		$this->db->from('room');
		$this->db->where_in('id', $room_ids);
		$query = $this->db->get();
	
		return $query->result(); // Return as object
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



	public function getBottle($childid,$date=NULL)
	{	
		if ($date==NULL) {
			$query = $this->db->get_where("dailydiarybottle",array("childid"=>$childid));
		} else {
			$query = $this->db->get_where("dailydiarybottle",array("childid"=>$childid,"diarydate"=>$date));
		}
		return $query->result();
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

	// public function getItems($search=null,$type=null){
	// 	$query = $this->db->query("SELECT * FROM `recipes` WHERE itemName LIKE '%$search%' AND `type` = '".$type."'");
	// 	return $query->result();
	// }

	public function getItems($search = null, $type = null, $centerid = null) {
		$sql = "SELECT * FROM `recipes` WHERE 1=1";
	
		$params = [];
	
		// Add search condition if provided
		if (!empty($search)) {
			$sql .= " AND `itemName` LIKE ?";
			$params[] = "%$search%";
		}
	
		// Add type condition if provided
		if (!empty($type)) {
			$sql .= " AND `type` = ?";
			$params[] = $type;
		}
	
		// Add centerid condition if provided
		if (!empty($centerid)) {
			$sql .= " AND `centerid` = ?";
			$params[] = $centerid;
		}
	
		// Execute query with binding to prevent SQL injection
		$query = $this->db->query($sql, $params);
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

	public function addSleepRecord2($data,$delete=NULL)
	{
		if (isset($data->diarydate)) {
			$diarydate = date('Y-m-d', strtotime($data->diarydate));
		} else {
			$diarydate = date("Y-m-d");
		}
		// if ($delete==NULL) {
		// 	$this->db->delete('dailydiarysleep', array('childid' => $data->childid, 'diarydate' => $diarydate));
		// }
		
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


public function addSunscreenRecord3($data)
{
    if (isset($data->diarydate)) {
        $diarydate = date('Y-m-d', strtotime($data->diarydate));
    } else {
        $diarydate = date("Y-m-d");
    }

    $insert_batch = [];

    foreach ($data->childids as $childid) {
        // Delete existing records for this child and date
        // $this->db->delete('dailydiarysunscreen', ['childid' => $childid, 'diarydate' => $diarydate]);

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

	public function getRecipes($type = NULL, $centerid = NULL)
{
    $this->db->from("recipes");

    if ($type !== NULL) {
        $this->db->where("type", strtoupper($type));
    }

    if ($centerid !== NULL) {
        $this->db->where("centerid", $centerid);
    }

    $query = $this->db->get();
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