<?php

defined('BASEPATH') or exit('No direct script access allowed');

class roomModel extends CI_Model
{
    public function createRoom($data)
    {
        $this->load->database();

        $id = mt_rand();
        $data->room_name = $data->room_name ? $data->room_name : ' ';
        $data->room_capacity = isset($data->room_capacity) ? $data->room_capacity : ' ';
        $data->room_leader = isset($data->room_leader) ? $data->room_leader : 0;
        $data->room_color = isset($data->room_color) ? $data->room_color : ' ';
        $data->room_status = isset($data->room_status) ? $data->room_status : ' ';
        $data->centerid = isset($data->centerid) ? $data->centerid : 0;
        $data->userid = isset($data->userid) ? $data->userid : '';
        $data->ageFrom = isset($data->ageFrom) ? $data->ageFrom : '';
        $data->ageTo = isset($data->ageTo) ? $data->ageTo : '';
        // $this->db->query(
            // "INSERT INTO room SET id = " .$id .",name = '" .$data->room_name ."',capacity = '" .$data->room_capacity ."',userId = " .$data->room_leader .",color = '" .$data->room_color ."',status = '" .$data->room_status ."'"
        // );
        //Latest
        // $this->db->query("INSERT INTO room SET id = " . $id. ",name = '" . $data->room_name. "',capacity = '" . $data->room_capacity . "',
        // 				 userId = " . $data->room_leader . ",color = '" . $data->room_color . "',status = '" . $data->room_status . "',centerid = ".$data->centerid);

        $sql = "INSERT INTO `room` (`id`, `name`, `capacity`, `userId`, `color`, `ageFrom`, `ageTo`, `status`, `centerid`) VALUES (".$id.", '".addslashes($data->room_name)."', '".$data->room_capacity."', '".$data->userid."', '".$data->room_color."', '".$data->ageFrom."', '".$data->ageTo."', '".$data->room_status."', ".$data->centerid.")";

        $this->db->query($sql);

        if (!empty($data->educators)) {
            foreach ($data->educators as $key => $educator) {
                $this->db->query("INSERT INTO room_staff (`roomid`,`staffid`) VALUES ('" . $id . "','" . $educator . "')");
            }
        }

        return $id;
    }
    
    public function editRoom($data)
    {
        $this->load->database();
        $id = $data->id;
        $data->room_name = $data->room_name ? $data->room_name : ' ';
        $data->room_capacity = $data->room_capacity ? $data->room_capacity : ' ';
        $data->room_color = $data->room_color ? $data->room_color : ' ';
        $data->room_status = $data->room_status ? $data->room_status : ' ';
        $data->ageFrom = isset($data->ageFrom) ? $data->ageFrom : '';
        $data->ageTo = isset($data->ageTo) ? $data->ageTo : '';
        $this->db->query(
            "UPDATE room SET name = '" .$data->room_name ."',capacity = '" .$data->room_capacity .
                "',color = '" .$data->room_color ."',status = '" .
                $data->room_status ."',ageFrom = '".$data->ageFrom."', ageTo = '".$data->ageTo."' WHERE id = " .$id ."");

        $this->db->query("DELETE FROM room_staff where  roomid=" . $id . "");
        if (!empty($data->educators)) {
            foreach ($data->educators as $key => $educator) {
                $this->db->query("INSERT INTO room_staff SET roomid=" .$id .",staffid=" .$educator ."");
            }
        }
        return $id;
    }

    public function createChild($data)
    {
        $this->load->database();
        // $data->age_on_center = $data->age_on_center ? $data->age_on_center : 0;
        // $data->first_language = $data->first_language ? $data->first_language : ' ';
        // $data->things_happy = $data->things_happy ? $data->things_happy : '';
        // $data->things_outside = $data->things_outside ? $data->things_outside : '';
        // $data->nick_name = $data->nick_name ? $data->nick_name : '';
        // $data->other_language = $data->other_language ? $data->other_language : '';
        // $data->favourite = $data->favourite ? $data->favourite : '';
        // $data->weekly_routines = $data->weekly_routines ? $data->weekly_routines : '';
        $data->dob = date('Y-m-d',strtotime($data->dob));
        $data->startDate = date('Y-m-d',strtotime($data->startDate));
        $name = $data->firstname;
        $lastname = $data->lastname;
        $id = mt_rand();

        $this->db->query("INSERT INTO `child` (`id`, `name`, `lastname`,`dob`, `startDate`, `room`, `imageUrl`, `gender`, `status`, `daysAttending`, `createdBy`, `createdAt`) VALUES (NULL, '".$name."',  '".$lastname."', '".$data->dob."', '".$data->startDate."', '".$data->id."', '".$data->imageName."', '".$data->gender."', '".$data->status."', ".$data->daysAttending.", '".$data->userid."', '".$data->createdAt."')");
        // $this->db->query("UPDATE room SET occupancy = occupancy+1 where id=" . $data->id);
        return $id;
    }

    public function editChild($data)
    {
        $this->load->database();
        // $data->age_on_center = $data->age_on_center ? $data->age_on_center : 0;
        // $data->first_language = $data->first_language ? $data->first_language : ' ';
        // $data->things_happy = $data->things_happy ? $data->things_happy : '';
        // $data->things_outside = $data->things_outside ? $data->things_outside : '';
        // $data->nick_name = $data->nick_name ? $data->nick_name : '';
        // $data->other_language = $data->other_language ? $data->other_language : '';
        // $data->favourite = $data->favourite ? $data->favourite : '';
        // $data->imageName = $data->imageName ? $data->imageName : '';
        // $data->weekly_routines = $data->weekly_routines ? $data->weekly_routines : '';
        $name = $data->firstname;
        $lastname = $data->lastname;
        $id = $data->childId;

        $this->db->query("UPDATE child SET name = '" . $name ."', lastname = '" . $lastname . "',dob = '" . $data->dob ."',startDate = '" . $data->startDate ."',status = '" . $data->status ."', `daysAttending`='".$data->daysAttending."', gender = '" . $data->gender . "' where id='" . $id ."'");

        if (!empty($data->imageName)) {
            $this->db->query(
                "UPDATE child SET imageUrl = '" .$data->imageName ."' where id=" .$id ."");
        }
        return $id;
    }

    public function changeStatus($data)
    {
        $this->load->database();
        if (!empty($data->rooms)) {
            foreach ($data->rooms as $key => $room) {
                $this->db->query("UPDATE room SET status = '" .$data->filter_status ."' where id=" .$room ."");
            }
        }
    }

    public function deleteRoom($data)
    {
        $this->load->database();

        if (!empty($data->rooms)) {
            foreach ($data->rooms as $key => $room) {
                $this->db->query("DELETE FROM room where id= $room");
                $this->db->query("DELETE FROM room_staff where  roomid= $room");
                $this->db->query("DELETE FROM child where  room=$room");
            }
        }
    }

    public function deleteChildren($data)
    {
        $this->load->database();

        if (!empty($data->childs)) {
            foreach ($data->childs as $key => $room) {
                $this->db->query("DELETE FROM child where id=" . $room . "");
                // $this->db->query(
                //     "UPDATE room SET occupancy = occupancy-1 where id=" .
                //         $data->id .
                //         ""
                // );
            }
        }
    }

    public function deleteChilds($data)
    {
        $this->load->database();
        foreach ($data as $key => $value) {
            $this->db->query("DELETE FROM child WHERE id = " . $value);
            $this->db->query("DELETE FROM childparent WHERE childid = " . $value);
            $this->db->query("DELETE FROM accidents WHERE childid = " . $value);
            $this->db->query("DELETE FROM announcementchild WHERE childid = " . $value);
            $this->db->query("DELETE FROM child_group_member WHERE child_id = " . $value);
            $this->db->query("DELETE FROM mediatags WHERE userid = " . $value . " AND usertype='child'");
            $this->db->query("DELETE FROM progressnotes WHERE childid = " . $value);
            $this->db->query("DELETE FROM surveychild WHERE childid = " . $value);
            $this->db->query("DELETE FROM reflectionchild WHERE childid = " . $value);
            $this->db->query("DELETE FROM reflectionmediachilds WHERE childId = " . $value);
            $this->db->query("DELETE FROM observationchild WHERE childId = " . $value);
        }        
    }

    public function getUser($data = [])
    {
        $this->load->database();
        $sql = "SELECT * FROM users ";
        if (!empty($data['filter_type'])) {
            $sql .= " where userType='" . $data['filter_type'] . "'";
        }
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getChildGrops()
    {
        $this->load->database();
        $sql = "SELECT * FROM child_group ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getRecentObs($id)
    {
        $this->load->database();
        $sql = "SELECT o.id,o.title FROM observationchild oc left join observation o on (o.id=oc.observationId) where oc.childId= $id ORDER BY o.date_added desc limit 1";
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getChildObs($id)
    {
        $this->load->database();
        $sql =
            "SELECT o.id,o.status FROM observationchild oc left join observation o on (o.id=oc.observationId) where oc.childId=" .
            $id .
            " group by o.id,o.status";
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    }


    

    public function getRoomStaff2($roomId) {
        return $this->db
            ->select('staffid')
            ->where('roomid', $roomId)
            ->get('room_staff')
            ->result_array();
    }
    
    public function updateRoomStaff($roomId, $staffIds) {
        // Begin transaction
        $this->db->trans_start();
        
        // Delete existing assignments
        $this->db->where('roomid', $roomId)->delete('room_staff');
        
        // Insert new assignments
        $data = [];
        foreach ($staffIds as $staffId) {
            $data[] = [
                'roomid' => $roomId,
                'staffid' => $staffId
            ];
        }
        
        if (!empty($data)) {
            $this->db->insert_batch('room_staff', $data);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }



    // public function getRooms($userid, $centerid, $filter_name = null)
    // {
    //     $this->load->database();
    //     // $sql="SELECT r.*,u.name as userName FROM room r left join users u on
    //     // (u.userid=r.userid) left join child c on (c.room=r.id)  ";
    //     $sql = "SELECT r.*,u.name as userName from room r LEFT JOIN users u on u.userid = r.userId where centerid IN (SELECT id FROM centers where id = $centerid)";
    //     if (!empty($filter_name)) {
    //         // or c.name like '%".$filter_name."%'
    //         $sql .= " AND (r.name like '%" . $filter_name . "%' )";
    //     }
    //     $sql .= " group by r.id,r.name,r.capacity,r.color,r.status";
    //     $query = $this->db->query($sql);
    //     return $query->result();
    // }


    public function getRooms($userid, $centerid, $filter_name = null)
{
    $this->load->database();
    
    // Use parameterized queries to avoid SQL injection
    $sql = "SELECT r.id, r.name, r.capacity, r.color, r.status, u.name as userName
            FROM room r
            LEFT JOIN users u ON u.userid = r.userId
            WHERE r.centerid = ?";
    
    // If there is a filter name, add it to the query
    if (!empty($filter_name)) {
        $sql .= " AND r.name LIKE ?";
        $filter_name = "%$filter_name%";
        $query = $this->db->query($sql, [$centerid, $filter_name]);
    } else {
        $query = $this->db->query($sql, [$centerid]);
    }
    
    return $query->result();
}

public function getRoomsByUserId($userid, $centerid, $filter_name = null)
{
    $this->load->database();

    // Step 1: Get all room IDs for the given user ID from the room_staff table
    $this->db->select('roomid');
    $this->db->from('room_staff');
    $this->db->where('staffid', $userid);
    $subquery = $this->db->get_compiled_select();

    // Step 2: Use the room IDs to fetch room details from the room table
    $sql = "SELECT r.id, r.name, r.capacity, r.color, r.status, u.name AS userName
            FROM room r
            LEFT JOIN users u ON u.userid = r.userId
            WHERE r.centerid = ? AND (r.id IN ($subquery) OR r.userId = ?)";

    // If a filter name is provided, add it to the query
    if (!empty($filter_name)) {
        $sql .= " AND r.name LIKE ?";
        $filter_name = "%$filter_name%";
        $query = $this->db->query($sql, [$centerid, $userid, $filter_name]);
    } else {
        $query = $this->db->query($sql, [$centerid, $userid]);
    }

    // Return the result as an array of objects
    return $query->result();
}


    


    public function getRoomsExcept($roomId)
    {
        $this->load->database();
        $centerid = $this->db->query("SELECT * FROM room where id = $roomId ");
        $centerid = $centerid->row();
        $centerid = $centerid->centerid;
        $sql = "SELECT * from room where centerid = $centerid AND id != $roomId";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getRoomChilds($data = [])
    {
        $this->load->database();
        $sql ="SELECT c.id,c.name,c.room,c.dob,c.startDate,c.room,c.imageUrl,c.gender,c.daysAttending,c.status FROM child c left join child_group_member g on (g.child_id=c.id) where c.room=" . $data['filter_room'] .
            " ";

        if (!empty($data['filter_groups'])) {
            $sql .=
                " and  g.group_id  IN (" .
                implode(',', $data['filter_groups']) .
                ") ";
        }
        if (!empty($data['filter_status'])) {
            $filter_status = implode("','", $data['filter_status']);
            $sql .= " and  c.status IN ('" . $filter_status . "') ";
        }
        if (!empty($data['filter_gender'])) {
            $filter_gender = implode("','", $data['filter_gender']);
            $sql .= " and  c.gender  IN ('" . $filter_gender . "') ";
        }
        $sql .=
            " group by c.id,c.name,c.room,c.dob,c.startDate,c.room,c.imageUrl,c.gender,c.status order by c. name";
        if (isset($data['order']) && $data['order'] == 'DESC') {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getRoomStaff($id)
    {
        $this->load->database();
        $sql = "SELECT r.staffid as userId, u.name as userName, u.imageUrl FROM room_staff r left join users u on (u.userid=r.staffid) where r.roomid= '". $id . "'";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getRoomChild($roomId, $childId)
    {
        $this->load->database();
        $sql = "SELECT * FROM child where id=$childId and room=$roomId";
        $query = $this->db->query($sql);
        return $query->row();
    }
    
    public function getRoom($id)
    {
        $this->load->database();
        $sql = "SELECT * FROM room where id=$id ";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getRoomChildsInfo($roomid='')
    {
        $this->load->database();
        $query = $this->db->get_where('child', ['room'=>$roomid]);
        return $query->result();
    }

    public function deleteExistingRoom($room='')
    {
        $this->db->query("DELETE FROM room where id = $room");
        $this->db->query("DELETE FROM room_staff where  roomid = $room");
    }


    public function get_room_details(){

        $get_room=$this->db->query("SELECT * FROM room")->result();
        return $get_room;
    }

    public function getChildCenter($childId='')
    {
        $sql = "SELECT * FROM centers WHERE id IN (SELECT DISTINCT(centerid) FROM room WHERE id IN (SELECT DISTINCT(room) FROM child WHERE id = $childId))";
       $q = $this->db->query($sql);
       return $q->row();
    }

 //parent section
    public function getParentsChildRooms($parentid='')
    {
        $sql = "SELECT * FROM `room` WHERE id IN (SELECT DISTINCT(room) FROM `child` WHERE id IN (SELECT DISTINCT(childid) FROM childparent WHERE parentid = ".$parentid."))";
        $q = $this->db->query($sql);
        return $q->result();
    }   
}
