<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class SettingsModel extends CI_Model {

	function __construct()
	{
		$this->load->database();
	}	
	public function getPIN($userid){
		$query = $this->db->query("SELECT password FROM users WHERE userid = '$userid'");
		return $query->row();
	}
	public function getPassword($userid){
		$query = $this->db->query("SELECT password from users WHERE userid = '$userid'");
		return $query->row();
	}
	public function changePassword($password,$userid){
		$this->db->query("UPDATE users SET password ='".sha1($password)."' WHERE userid = '".$userid."'");
	}
	public function getEmail($userid){
		$query = $this->db->query("SELECT emailid FROM users WHERE userid = '$userid'");
		return $query->row();
	}
	public function changeEmail($email,$userid){
		$this->db->query("UPDATE users SET emailid ='$email' WHERE userid = '$userid'");
	}
	public function changeUsernameEmail($email,$userid)
	{
		$this->db->query("UPDATE users SET emailid ='$email', username = '$email' WHERE userid = '$userid'");
	}
	public function getModuleSettings($centerId)
	{
		$query = $this->db->get_where("modules",array("centerid"=>$centerId));
		return $query->row();
	}

	public function addModuleSettings($data)
	{
		$this->db->delete("modules",array("centerid"=>$data->centerid));
		$insData = array(
			"centerid"=> $data->centerid,
	        "observation"=> $data->observation,
	        "qip"=> $data->qip,
	        "room"=> $data->room,
	        "programplans"=> $data->programplans,
	        "announcements"=> $data->announcements,
	        "survey"=> $data->survey,
	        "menu"=> $data->menu,
	        "recipe"=> $data->recipe,
	        "resources"=> $data->resources,
	        "dailydiary"=> $data->dailydiary,
	        "headchecks"=> $data->headchecks,
	        "accidents"=> $data->accidents,
	        "servicedetails"=> $data->servicedetails
		);
		$this->db->insert('modules', $insData);

		$insert_id = $this->db->insert_id();

		return $insert_id;
	}

	public function getUserStats($centerid=NULL)
	{
		$total_staff_sql = "SELECT * FROM `users` WHERE userType = 'Staff' AND userid IN (SELECT DISTINCT(userid) FROM `usercenters` WHERE centerid = $centerid)";
		$totalUsers = $this->db->query($total_staff_sql);

		$active_users_sql = "SELECT * FROM `users` WHERE userType = 'Staff' AND status = 'ACTIVE' AND userid IN (SELECT DISTINCT(userid) FROM `usercenters` WHERE centerid = $centerid)";
		$activeUsers = $this->db->query($active_users_sql);

		$inactive_users_sql = "SELECT * FROM `users` WHERE userType = 'Staff' AND status = 'IN-ACTIVE' AND userid IN (SELECT DISTINCT(userid) FROM `usercenters` WHERE centerid = $centerid)";
		$inactiveUsers = $this->db->query($inactive_users_sql);

		$pending_users_sql = "SELECT * FROM `users` WHERE userType = 'Staff' AND status = 'PENDING' AND userid IN (SELECT DISTINCT(userid) FROM `usercenters` WHERE centerid = $centerid)";
		$pendingUsers = $this->db->query($pending_users_sql);

		$data = ["totalUsers"=>$totalUsers->num_rows(),"activeUsers"=>$activeUsers->num_rows(),"inactiveUsers"=>$inactiveUsers->num_rows(),"pendingUsers"=>$pendingUsers->num_rows()];
		return $data;
	}

	public function getUserDetails($data)
	{	
		$groups = "";
		$status = "";
		$gender = "";
		$sflag = FALSE;

		$query ="SELECT DISTINCT(u.userid),u.* FROM users u";

		if(empty($data->groups)) {
			$groups = "";
		}else{
			$count = count($data->groups);
			for ($i=0; $i<$count ; $i++) { 
				if ($i==0) {
					$groups = "'".$data->groups[$i]."'";
				}elseif($i==$count-1){
					$groups .= ",'".$data->groups[$i]."'";
				}elseif($i<$count-1){
					$groups .= ",'".$data->groups[$i]."'";
				}
			}
			$sflag = TRUE;
			$query .= " LEFT JOIN child_group cg ON u.userid = cg.userid WHERE cg.id IN (".$groups.") ";
		}

		if(empty($data->status)) {
			$status = "";
		}else{
			$count = count($data->status);
			for ($i=0; $i<$count ; $i++) { 
				if ($i==0) {
					$status = "'".$data->status[$i]."'";
				}elseif($i==$count-1){
					$status .= ",'".$data->status[$i]."'";
				}elseif($i<$count-1){
					$status .= ",'".$data->status[$i]."'";
				}
			}
			if ($sflag == TRUE) {
				$query .= " AND u.status IN (".$status.") ";
			} else {
				$query .= " WHERE u.status IN (".$status.") ";
			}
			$sflag = TRUE;
		}

		if(empty($data->gender)) {
			$gender = "";
		}else{
			$count = count($data->gender);
			for ($i=0; $i<$count ; $i++) { 
				if ($i==0) {
					$gender = "'".$data->gender[$i]."'";
				}elseif($i==$count-1){
					$gender .= ",'".$data->gender[$i]."'";
				}elseif($i<$count-1){
					$gender .= ",'".$data->gender[$i]."'";
				}
			}

			if ($sflag == TRUE) {
				$query .= " AND u.gender IN (".$gender.") ";
			} else {
				$query .= " WHERE u.gender IN (".$gender.") ";
			}
			
		}

		if(!empty($data->order)) {
			$query .= " AND u.userType='Staff' ORDER BY u.userid ".strtoupper($data->order);
		}
		$sql = $this->db->query($query);
		return $sql->result();
		// return $query;
	}

	public function getChildGroups()
	{
		$this->db->select('id, name');
		$query = $this->db->get('child_group');
		return $query->result();
	}

	public function addUsersToCenter($data)
	{
		$insData = array(
			"centerid"=> $data['centerid'],
			"userid"=> $data['userid']
		);
		$this->db->insert('usercenters', $insData);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function updateUsersPassword($data='')
	{
		$this->db->update('users', ['password'=>sha1($data['password'])], ['userid'=>$data['recordId']]);
		return $this->db->affected_rows();
	}

	public function saveUsersDetails($data=NULL)
	{
		if (isset($data['recordId'])) {
			$userid = $data['recordId'];
			$updateData = array(
				"username"=>$data['username'], 
				"emailid"=>$data['emailid'],
				"contactNo"=>$data['contactNo'], 
				"name"=>$data['name'], 
                "status"=>$data['status'],
				"dob"=>date('Y-m-d',strtotime($data['dob'])), 
				"gender"=>$data['gender'], 
				"title"=>$data['title'],
				"imageUrl"=>$data['image_name'], 
				"userType"=>"Staff"
			);
			$this->db->update('users', $updateData, ['userid'=>$userid]);
			return $userid;
		} else {
			$userid = NULL;
			$insData = array(
				"userid"=>$userid, 
				"username"=>$data['username'], 
				"emailid"=>$data['emailid'],
				"contactNo"=>$data['contactNo'], 
				"name"=>$data['name'], 
				"dob"=>date('Y-m-d',strtotime($data['dob'])), 
				"gender"=>$data['gender'], 
				"title"=>$data['title'],
				"imageUrl"=>$data['image_name'], 
				"userType"=>"Staff",
				"password"=>$data['password']
			);
			$this->db->insert('users', $insData);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
	}

	public function getUsersDetails($userid)
	{
		$query = $this->db->get_where("users",array("userid"=>$userid));
		return $query->row();
	}

	public function getUserCenters($userid)
	{
		$query = $this->db->query("SELECT centerName,id from centers where id IN (SELECT centerid FROM usercenters where userid = $userid)");
		return $query->result();
	}

	public function checkEmpCodeAvl($value='')
	{
		$this->db->where('username', $value);
		$this->db->from('users');
		return $this->db->count_all_results();
	}

	public function removeUserCenterRecords($userid='')
	{
		$array = ['userid'=>$userid];
		$this->db->delete('usercenters', $array);
	}

	public function getCenterUsers($centerid='', $userid='', $order=NULL)
	{
		if (empty($userid)) {
			$sql = "SELECT DISTINCT(u.userid), u.name, u.imageUrl, u.status FROM `usercenters` uc INNER JOIN `users` u ON uc.userid = u.userid WHERE uc.centerid = $centerid AND u.userType='Staff'";
		} else {
			$sql = "SELECT DISTINCT(u.userid), u.name, u.imageUrl, u.status FROM `usercenters` uc INNER JOIN `users` u ON uc.userid = u.userid WHERE uc.centerid = $centerid AND u.userType='Staff' AND u.userid != $userid";
		}

		if($order != NULL) {
			$sql .= " ORDER BY u.userid " . strtoupper($order);
		}

		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getPermissionColumns()
	{
		$sql = "SELECT `COLUMN_NAME` AS columns FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='Mykronicle' AND `TABLE_NAME`='permissions'";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function checkPermission($userid='',$column='*',$centerid='')
	{
		$sql = "SELECT ".$column." FROM permissions WHERE userid = $userid AND centerid = $centerid";
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function checkMultiplePermission($userid='',$column='*',$centerid='')
	{
		$sql = "SELECT ".$column." FROM permissions WHERE userid = $userid AND centerid = $centerid";
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function getCenters($data='')
	{
		if(isset($data->order)){
			$this->db->order_by('id', strtoupper($data->order));
			$query = $this->db->get("centers");
		}else{
			$query = $this->db->get("centers");
		}
		return $query->result();
	}

	public function getCenterDetails($centerid)
	{
		$query = $this->db->get_where("centers",array("id"=>$centerid));
		return $query->row();
	}

	public function saveCenterDetails($data)
	{
		if (isset($data->centerid)) {
			$id = $data->centerid;
			$this->db->delete("centers", array("id"=>$id));
		} else {
			$id = NULL;
		}
		
		$insData = array(
			"id"=>$id, 
			"centerName"=>$data->centerName, 
			"adressStreet"=>$data->adressStreet,
			"addressCity"=>$data->addressCity, 
			"addressState"=>$data->addressState, 
			"addressZip"=>$data->addressZip
		);

		$this->db->insert('centers', $insData);
		 
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function addRoom($roomName,$roomCapacity,$roomStatus,$roomColor,$centerId,$userid)
	{
		$insData = array(
			"name"=>$roomName, 
			"capacity"=>$roomCapacity, 
			"userId"=>$userid,
			"color"=>$roomColor, 
			"status"=>$roomStatus,
			"centerid"=>$centerId
		);

		$this->db->insert('room', $insData);
	}

	public function updRoom($roomid,$roomName,$roomCapacity,$roomStatus,$roomColor,$centerId,$userid)
	{
		$insdata = array(
			'id'=> $roomid,
	        "name"=>$roomName, 
			"capacity"=>$roomCapacity, 
			"userId"=>$userid,
			"color"=>$roomColor, 
			"status"=>$roomStatus,
			"centerid"=>$centerId
		);

		// $this->db->where('id', $roomid);
		$this->db->insert('room', $insdata);
	}

	public function removeCenterRooms($centerid=""){
		$this->db->delete('room', ['centerid'=>$centerid]);
	}

	public function getRoomsDetails($centerid)
	{
		$query = $this->db->get_where("room",array('centerid' => $centerid));
		return $query->result();
	}

	public function getParentStats()
	{	
		$this->db->where('userType', 'Parent');
		$this->db->from('users');
		$totalParents = $this->db->count_all_results();
		$this->db->where('status', 'ACTIVE');
		$this->db->where('userType', 'Parent');
		$this->db->from('users');
		$activeParents = $this->db->count_all_results();
		$this->db->where('status', 'IN-ACTIVE');
		$this->db->where('userType', 'Parent');
		$this->db->from('users');
		$inactiveParents = $this->db->count_all_results();
		$this->db->where('status', 'PENDING');
		$this->db->where('userType', 'Parent');
		$this->db->from('users');
		$pendingParents = $this->db->count_all_results();

		$data = ["totalParents"=>$totalParents,"activeParents"=>$activeParents,"inactiveParents"=>$inactiveParents,"pendingParents"=>$pendingParents];
		return $data;
	}

	public function getParentDetails($userid = NULL)
	{
		if ($userid==NULL) {
			$query = $this->db->get_where("users",array("userType"=>"Parent"));
			return $query->result();
		} else {
			$query = $this->db->get_where("users",array("userType"=>"Parent","userid"=>$userid));
			return $query->row();
		}
	}

	public function getChildren()
	{
		$this->db->select('id, name');
		$query = $this->db->get("child");
		return $query->result();
	}

	public function getParentChild($parentId)
	{
		$query = $this->db->query("SELECT * FROM `childparent` WHERE parentid = $parentId");
		return $query->result();
	}

	public function saveParent($data)
	{		
		$insData = array(
			"username"=>$data->emailid, 
			"emailid"=>$data->emailid,
			"contactNo"=>$data->contactNo, 
			"password"=>sha1($data->password), 
			"name"=>$data->name, 
			"dob"=>date('Y-m-d',strtotime($data->dob)), 
			"gender"=>$data->gender, 
			"userType"=>"Parent"
		);

		$this->db->insert('users', $insData);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function updateParent($data)
	{
		$insdata = array(
	        "username"=>$data->emailid, 
			"emailid"=>$data->emailid,
			"contactNo"=>$data->contactNo, 
			"password"=>sha1($data->password),
			"name"=>$data->name, 
			"dob"=>date('Y-m-d',strtotime($data->dob)), 
			"gender"=>$data->gender, 
			"userType"=>"Parent"
		);

		$this->db->where('userid', $data->recordId);
		$this->db->update('users', $insdata);
	}

	public function removeParentRelations($parentid='')
	{
		$this->db->delete("childparent",array("parentid"=>$parentid));
	}

	public function addRelation($childid,$parentid,$relation)
	{
		$insData = array("childid"=>$childid,"parentid"=>$parentid,"relation"=>$relation);
		$this->db->insert('childparent', $insData);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function getGroupDetails($groupId = NULL)
	{
		if ($groupId == NULL) {
			$query = $this->db->get("child_group");
			return $query->result();
		} else {
			$query = $this->db->get_where("child_group",array("id"=>$groupId));
			return $query->row();
		}
	}

	public function getGroupChilds($groupId)
	{
		$query = $this->db->get_where("child_group_member",array("group_id"=>$groupId));
		return $query->result();
	}

	public function updateChildGroup($data)
	{
		$insdata = array(
	        "name"=>$data->name, 
			"description"=>$data->description,
			"date_modified"=>date('Y-m-d h:i:s')
		);

		$this->db->where('id', $data->groupId);
		$this->db->update('child_group', $insdata);
	}

	public function saveChildGroup($data)
	{
		$insdata = array(
	        "name"=>$data->name, 
			"description"=>$data->description,
			"userid"=>$data->userid,
			"date_added"=>date('Y-m-d h:i:s')
		);

		$this->db->insert('child_group', $insdata);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function deleteChildFromGroup($groupId)
	{
		$this->db->delete("child_group_member",array("group_id"=>$groupId));
	}
	
	public function insertChildRecord($childId,$groupId)
	{
		$insdata = array(
	        "child_id"=>$childId, 
			"group_id"=>$groupId
		);

		$this->db->insert('child_group_member', $insdata);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function getGroupChildrens($groupId)
	{
		$query = $this->db->query("SELECT * FROM `child_group_member` cgm INNER JOIN `child` ch ON cgm.child_id = ch.id WHERE cgm.group_id = $groupId");
		return $query->result();
	}

	public function getAllUsers($userType)
	{
		$query = $this->db->get_where("users",array("userType"=>$userType));
		return $query->result();
	}

	public function getPermissions($data)
	{
		$userid = $data->user;
		$centerid = $data->center;
		$query = $this->db->get_where("permissions",array("userid"=>$userid,"centerid"=>$centerid));
		return $query->row();
	}

	public function savePermissions($data)
	{
		$this->db->delete("permissions",array("userid"=>$data->indvuser,"centerid"=>$data->center));
		$insdata = array(
	        "userid"=> isset($data->indvuser)?$data->indvuser:0, 
			"centerid"=> isset($data->center)?$data->center:0, 
			"addObservation"=> isset($data->addObservation)?$data->addObservation:0, 
			"approveObservation"=> isset($data->approveObservation)?$data->approveObservation:0, 
			"deleteObservation"=> isset($data->deleteObservation)?$data->deleteObservation:0, 
			"updateObservation"=> isset($data->updateObservation)?$data->updateObservation:0, 
			"viewAllObservation"=> isset($data->viewAllObservation)?$data->viewAllObservation:0,
			"addReflection"=> isset($data->addReflection)?$data->addReflection:0,
			"approveReflection"=> isset($data->approveReflection)?$data->approveReflection:0,
			"deletereflection"=> isset($data->deletereflection)?$data->deletereflection:0,
			"updatereflection"=> isset($data->updatereflection)?$data->updatereflection:0,
			"viewAllReflection"=> isset($data->viewAllReflection)?$data->viewAllReflection:0,
			"addQIP"=> isset($data->addQIP)?$data->addQIP:0, 
			"editQIP"=> isset($data->editQIP)?$data->editQIP:0, 
			"deleteQIP"=> isset($data->deleteQIP)?$data->deleteQIP:0, 
			"downloadQIP"=> isset($data->downloadQIP)?$data->downloadQIP:0, 
			"printQIP"=> isset($data->printQIP)?$data->printQIP:0, 
			"mailQIP"=> isset($data->mailQIP)?$data->mailQIP:0, 
			"viewQip"=> isset($data->viewQip)?$data->viewQip:0, 
			"viewRoom"=> isset($data->viewRoom)?$data->viewRoom:0, 
			"addProgramPlan"=> isset($data->addProgramPlan)?$data->addProgramPlan:0, 
			"editProgramPlan"=> isset($data->editProgramPlan)?$data->editProgramPlan:0, 
			"viewProgramPlan"=> isset($data->viewProgramPlan)?$data->viewProgramPlan:0, 
			"deleteProgramPlan"=> isset($data->deleteProgramPlan)?$data->deleteProgramPlan:0, 
			"addRoom"=> isset($data->addRoom)?$data->addRoom:0, 
			"editRoom"=> isset($data->editRoom)?$data->editRoom:0, 
			"deleteRoom"=> isset($data->deleteRoom)?$data->deleteRoom:0, 
			// "updateRoom"=> isset($data->updateRoom)?$data->updateRoom:0, 
			"addAnnouncement"=> isset($data->addAnnouncement)?$data->addAnnouncement:0, 
			"approveAnnouncement"=> isset($data->approveAnnouncement)?$data->approveAnnouncement:0, 
			"deleteAnnouncement"=> isset($data->deleteAnnouncement)?$data->deleteAnnouncement:0, 
			"updateAnnouncement"=> isset($data->updateAnnouncement)?$data->updateAnnouncement:0, 
			"viewAllAnnouncement"=> isset($data->viewAllAnnouncement)?$data->viewAllAnnouncement:0, 
			"addSurvey"=> isset($data->addSurvey)?$data->addSurvey:0, 
			"approveSurvey"=> isset($data->approveSurvey)?$data->approveSurvey:0, 
			"deleteSurvey"=> isset($data->deleteSurvey)?$data->deleteSurvey:0, 
			"updateSurvey"=> isset($data->updateSurvey)?$data->updateSurvey:0, 
			"viewAllSurvey"=> isset($data->viewAllSurvey)?$data->viewAllSurvey:0, 
			"addRecipe"=> isset($data->addRecipe)?$data->addRecipe:0, 
			"approveRecipe"=> isset($data->approveRecipe)?$data->approveRecipe:0, 
			"deleteRecipe"=> isset($data->deleteRecipe)?$data->deleteRecipe:0, 
			"updateRecipe"=> isset($data->updateRecipe)?$data->updateRecipe:0, 
			"addMenu"=> isset($data->addMenu)?$data->addMenu:0, 
			"approveMenu"=> isset($data->approveMenu)?$data->approveMenu:0, 
			"deleteMenu"=> isset($data->deleteMenu)?$data->deleteMenu:0, 
			"updateMenu"=> isset($data->updateMenu)?$data->updateMenu:0, 
			"updateDailyDiary"=> isset($data->updateDailyDiary)?$data->updateDailyDiary:0, 
			"updateHeadChecks"=> isset($data->updateHeadChecks)?$data->updateHeadChecks:0, 
			"updateAccidents"=> isset($data->updateAccidents)?$data->updateAccidents:0, 
			"updateModules"=> isset($data->updateModules)?$data->updateModules:0, 
			"addUsers"=> isset($data->addUsers)?$data->addUsers:0, 
			"viewUsers"=> isset($data->viewUsers)?$data->viewUsers:0, 
			"updateUsers"=> isset($data->updateUsers)?$data->updateUsers:0, 
			"addCenters"=> isset($data->addCenters)?$data->addCenters:0, 
			"viewCenters"=> isset($data->viewCenters)?$data->viewCenters:0, 
			"updateCenters"=> isset($data->updateCenters)?$data->updateCenters:0, 
			"addParent"=> isset($data->addParent)?$data->addParent:0, 
			"viewParent"=> isset($data->viewParent)?$data->viewParent:0, 
			"updateParent"=> isset($data->updateParent)?$data->updateParent:0, 
			"addChildGroup"=> isset($data->addChildGroup)?$data->addChildGroup:0, 
			"viewChildGroup"=> isset($data->viewChildGroup)?$data->viewChildGroup:0, 
			"updateChildGroup"=> isset($data->updateChildGroup)?$data->updateChildGroup:0,
			"viewDailyDiary"=> isset($data->viewDailyDiary)?$data->viewDailyDiary:0,
			"updateModules"=> isset($data->updateModules)?$data->updateModules:0,
			"updatePermission"=> isset($data->updatePermission)?$data->updatePermission:0,
			"addprogress"=> isset($data->addprogress)?$data->addprogress:0,
			"editprogress"=> isset($data->editprogress)?$data->editprogress:0,
			"viewprogress"=> isset($data->viewprogress)?$data->viewprogress:0,
			"editlesson"=> isset($data->editlesson)?$data->editlesson:0,
			"viewlesson"=> isset($data->viewlesson)?$data->viewlesson:0,
			"printpdflesson"=> isset($data->printpdflesson)?$data->printpdflesson:0,
			"assessment"=> isset($data->assessment)?$data->assessment:0,
			"addSelfAssessment"=> isset($data->addSelfAssessment)?$data->addSelfAssessment:0,
			"editSelfAssessment"=> isset($data->editSelfAssessment)?$data->editSelfAssessment:0,
			"deleteSelfAssessment"=> isset($data->deleteSelfAssessment)?$data->deleteSelfAssessment:0,
			"viewSelfAssessment"=> isset($data->viewSelfAssessment)?$data->viewSelfAssessment:0
		);

		$this->db->insert('permissions', $insdata);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function getCenterJournalTabs($centerid='')
	{
		$q = $this->db->get_where('dailydiarysettings', array("centerid"=>$centerid));
		return $q->row();
	}

	public function getAllCenters()
	{
		$q = $this->db->get('centers');
		return $q->result();
	}

	public function checkUserCenter($userid='',$centerid='')
	{
		$q = $this->db->get_where('usercenters', array("userid"=>$userid,"centerid"=>$centerid));
		return $q->row();
	}

	public function insertCenterJournalTabs($data='')
	{
		$array = [
			"centerid"=>$data->centerid,
			"breakfast"=>$data->breakfast,
			"morningtea"=>$data->morningtea,
			"lunch"=>$data->lunch,
			"sleep"=>$data->sleep,
			"afternoontea"=>$data->afternoontea,
			"latesnacks"=>$data->latesnacks,
			"sunscreen"=>$data->sunscreen,
			"toileting"=>$data->toileting
		];
		$this->db->insert('dailydiarysettings', $array);

	}

	public function updateCenterJournalTabs($data='')
	{
		$array = [
			"breakfast"=>$data->breakfast,
			"morningtea"=>$data->morningtea,
			"lunch"=>$data->lunch,
			"sleep"=>$data->sleep,
			"afternoontea"=>$data->afternoontea,
			"latesnacks"=>$data->latesnacks,
			"sunscreen"=>$data->sunscreen,
			"toileting"=>$data->toileting
		];
		$this->db->where(array("centerid"=>$data->centerid));
		$this->db->update("dailydiarysettings",$array);
	}

	public function getCenterNoticeSettings($centerid='')
	{
		$q = $this->db->get_where('noticesettings', array("centerid"=>$centerid));
		return $q->row();
	}

	public function insertCenterNoticeSettings($data='')
	{
		$array = [
			"centerid"=>$data->centerid,
			"days"=>$data->number
		];
		$this->db->insert('noticesettings', $array);

	}

	public function updateCenterNoticeSettings($data='')
	{
		$array = [
			"days"=>$data->number
		];
		$this->db->where(array("centerid"=>$data->centerid));
		$this->db->update("noticesettings",$array);

	}

	public function get_export(){
		$get_details=$this->db->query("SELECT emailid, contactNo,name,dob,gender,userType FROM users")->result();
		return $get_details;
	}
	public function getAllThemes()
	{
		$q = $this->db->get('themes');
		return $q->result();
	}

	public function getUserInfo($userid='')
	{
		$q = $this->db->get_where("users",array("userid"=>$userid));
		return $q->row();
	}

	public function applyTheme($data='')
	{
		$sql = "UPDATE `users` SET `theme`='".$data->theme."' WHERE `userid` = ".$data->userid;
		$q = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function getAssessmentSettings($centerid='')
	{
		$q = $this->db->get_where("assessmentsettings",array("centerid"=>$centerid));
		return $q->row();
	}

	public function saveAsmntSettings($data='')
	{
		$array = [
		    "montessori" => $data->montessori,
		    "eylf" => $data->eylf,
		    "devmile" => $data->devmile
		];
		$this->db->where('centerid', $data->centerid);
		$this->db->update('assessmentsettings', $array);
		return $this->db->affected_rows();
		// return $this->db->set($array)->get_compiled_update('assessmentsettings');
	}

	public function addAsmntSettings($data='')
	{
		$array = [
		    "montessori" => $data->montessori,
		    "eylf" => $data->eylf,
		    "devmile" => $data->devmile,
		    "centerid"=> $data->centerid
		];
		$this->db->insert('assessmentsettings', $array);
		return $this->db->insert_id();
		// return $this->db->set($array)->get_compiled_insert('assessmentsettings');
	}

	public function updateMonActivity($data='')
	{
		$arr = [
			"idSubject"=>$data->subject,
			"title"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->where("idActivity",$data->activity);
		$this->db->update('montessoriactivity', $arr);
		return $this->db->affected_rows();
	}

	public function insertMonActivity($data='')
	{
		$arr = [
			"idSubject"=>$data->subject,
			"title"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('montessoriactivity', $arr);
		return $this->db->insert_id();
	}

	public function updateMonSubActivity($data='')
	{
		$arr = [
			"idActivity"=>$data->activity,
			"title"=>$data->title,
			"subject"=>$data->subject,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->where("idSubActivity",$data->subactivity);
		$this->db->update('montessorisubactivity', $arr);
		return $this->db->affected_rows();
	}

	public function insertMonSubActivity($data='')
	{
		$arr = [
			"idActivity"=>$data->activity,
			"title"=>$data->title,
			"subject"=>$data->subject,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('montessorisubactivity', $arr);
		return $this->db->insert_id();
	}

	public function getSubActivity($subactid='')
	{
		$q = $this->db->get_where('montessorisubactivity', array('idSubActivity'=>$subactid));
		return $q->row();
	}

	public function updateMonSubActivityExtra($data='')
	{
		$arr = [
			"idSubActivity"=>$data->subactivity,
			"title"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->where("idExtra ",$data->extra);
		$this->db->update('montessoriextras', $arr);
		return $this->db->affected_rows();
	}

	public function insertMonSubActivityExtra($data='')
	{
		$arr = [
			"idSubActivity"=>$data->subactivity,
			"title"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('montessoriextras', $arr);
		return $this->db->insert_id();
	}

	public function deleteMonActivity($id='')
	{
		$this->db->delete("montessoriactivity", array('idActivity' => $id));
		return $this->db->affected_rows();
	}

	public function deleteMonSubActivity($id='')
	{
		$this->db->delete("montessorisubactivity", array('idSubActivity' => $id));
		return $this->db->affected_rows();
	}

	public function deleteMonSubActivityExtras($id='')
	{
		$this->db->delete("montessoriextras", array('idExtra' => $id));
		return $this->db->affected_rows();
	}

	public function clearMonActvtAccess($centerid='')
	{
		$this->db->delete("montessoriactivityaccess",array('centerid' => $centerid));
	}

	public function clearMonSubActvtAccess($centerid='')
	{
		$this->db->delete("montessorisubactivityaccess",array('centerid' => $centerid));
	}

	public function clearMonSubActvtExtrasAccess($centerid='')
	{
		$this->db->delete("montessorisubactivityextrasaccess",array('centerid' => $centerid));
	}

	public function insertMonActivityAccess($data='')
	{
		$array = [
			"idActivity"=>$data->activity,
			"centerid"=>$data->centerid,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('montessoriactivityaccess', $array);
	}

	public function insertMonSubActivityAccess($data='')
	{
		$array = [
			"idSubActivity"=>$data->subactivity,
			"centerid"=>$data->centerid,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('montessorisubactivityaccess', $array);
	}

	public function insertMonSubActivityExtraAccess($data='')
	{
		$array = [
			"idExtra"=>$data->extra,
			"centerid"=>$data->centerid,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('montessorisubactivityextrasaccess', $array);
	}

	public function updateEylfActivity($data='')
	{
		$arr = [
			"outcomeId"=>$data->outcome,
			"title"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->where("id",$data->activity);
		$this->db->update('eylfactivity', $arr);
		return $this->db->affected_rows();
	}

	public function insertEylfActivity($data='')
	{
		$arr = [
			"outcomeId"=>$data->outcome,
			"title"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('eylfactivity', $arr);
		return $this->db->insert_id();
	}

	public function updateEylfSubActivity($data='')
	{
		$arr = [
			"activityid"=>$data->activity,
			"title"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->where("id",$data->subactivity);
		$this->db->update('eylfsubactivity', $arr);
		return $this->db->affected_rows();
	}

	public function insertEylfSubActivity($data='')
	{
		$arr = [
			"activityid"=>$data->activity,
			"title"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('eylfsubactivity', $arr);
		return $this->db->insert_id();
	}

	public function getEylfSubActivity($subactid='')
	{
		$q = $this->db->get_where('eylfsubactivity', array('id'=>$subactid));
		return $q->row();
	}

	public function deleteEylfActivity($id='')
	{
		$this->db->delete("eylfactivity", array('id' => $id));
		return $this->db->affected_rows();
	}

	public function deleteEylfSubActivity($id='')
	{
		$this->db->delete("eylfsubactivity", array('id' => $id));
		return $this->db->affected_rows();
	}

	public function clearEylfActvtAccess($centerid='')
	{
		$this->db->delete("eylfactivityaccess",array('centerid' => $centerid));
	}

	public function clearEylfSubActvtAccess($centerid='')
	{
		$this->db->delete("eylfsubactivityaccess",array('centerid' => $centerid));
	}

	public function insertEylfActivityAccess($data='')
	{
		$array = [
			"activityid"=>$data->activity,
			"centerid"=>$data->centerid,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('eylfactivityaccess', $array);
	}

	public function insertEylfSubActivityAccess($data='')
	{
		$array = [
			"subactivityid"=>$data->subactivity,
			"centerid"=>$data->centerid,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('eylfsubactivityaccess', $array);
	}
	/* dev mile */
	public function updateDevMileActivity($data='')
	{
		$arr = [
			"ageId"=>$data->milestone,
			"name"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->where("id",$data->activity);
		$this->db->update('devmilestonemain', $arr);
		return $this->db->affected_rows();
	}

	public function insertDevMileActivity($data='')
	{
		$arr = [
			"ageId"=>$data->milestone,
			"name"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('devmilestonemain', $arr);
		return $this->db->insert_id();
	}

	public function updateDevMileSubActivity($data='')
	{
		$arr = [
			"milestoneid"=>$data->activity,
			"name"=>$data->title,
			"subject"=>$data->subject,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->where("id",$data->subactivity);
		$this->db->update('devmilestonesub', $arr);
		return $this->db->affected_rows();
		// return $this->db->set($arr)->get_compiled_update('devmilestonesub');

	}

	public function insertDevMileSubActivity($data='')
	{
		$arr = [
			"milestoneid"=>$data->activity,
			"name"=>$data->title,
			"subject"=>$data->subject,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('devmilestonesub', $arr);
		return $this->db->insert_id();
		// return $this->db->set($arr)->get_compiled_insert('devmilestonesub');
	}

	public function getDevMileSubActivity($subactid='')
	{
		$q = $this->db->get_where('devmilestonesub', array('id'=>$subactid));
		return $q->row();
	}

	public function updateDevMileSubActivityExtra($data='')
	{
		$arr = [
			"idsubactivity"=>$data->subactivity,
			"title"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->where("id",$data->extra);
		$this->db->update('devmilestoneextras', $arr);
		return $this->db->affected_rows();
	}

	public function insertDevMileSubActivityExtra($data='')
	{
		$arr = [
			"idsubactivity"=>$data->subactivity,
			"title"=>$data->title,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('devmilestoneextras', $arr);
		return $this->db->insert_id();
	}

	public function deleteDevMileActivity($id='')
	{
		$this->db->delete("devmilestonemain", array('id' => $id));
		return $this->db->affected_rows();
	}

	public function deleteMileSubActivity($id='')
	{
		$this->db->delete("devmilestonesub", array('id' => $id));
		return $this->db->affected_rows();
	}

	public function deleteMileSubActExtras($id='')
	{
		$this->db->delete("devmilestoneextras", array('id' => $id));
		return $this->db->affected_rows();
	}

	public function clearMileActvtAccess($centerid='')
	{
		$this->db->delete("devmilestonemainaccess",array('centerid' => $centerid));
	}

	public function clearMileSubActvtAccess($centerid='')
	{
		$this->db->delete("devmilestonesubaccess",array('centerid' => $centerid));
	}

	public function clearMileSubActvtExtrasAccess($centerid='')
	{
		$this->db->delete("devmilestoneextrasaccess",array('centerid' => $centerid));
	}

	public function insertMileActivityAccess($data='')
	{
		$array = [
			"idmain"=>$data->activity,
			"centerid"=>$data->centerid,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('devmilestonemainaccess', $array);
	}

	public function insertMileSubActivityAccess($data='')
	{
		$array = [
			"idsubactivity"=>$data->subactivity,
			"centerid"=>$data->centerid,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('devmilestonesubaccess', $array);
	}

	public function insertMileSubActivityExtraAccess($data='')
	{
		$array = [
			"idextra"=>$data->extra,
			"centerid"=>$data->centerid,
			"added_by"=>$data->userid,
			"added_at"=>date('Y-m-d h:i:s')
		];
		$this->db->insert('devmilestoneextrasaccess', $array);
	}
}