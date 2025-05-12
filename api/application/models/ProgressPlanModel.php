<?php 
error_reporting(0);
ini_set('display_errors', 0);

defined('BASEPATH') OR exit('No direct script access allowed');

class ProgressPlanModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->date=date('Y-m-d');
	}

	public function getprocessplan($data = NULL) {
		$id = $data->center_id;
		$user_type_id = $data->userid;
	
		if (trim($data->usertype) == 'Parent') {
	
			$getprocess = $this->db->query("
				SELECT child.id as child_id, child.name as child_name, child.imageUrl as child_imageUrl,
					(SELECT GROUP_CONCAT(userprogressplan.status ORDER BY userprogressplan.status) 
						FROM userprogressplan WHERE userprogressplan.childid = child.id) as process_status,
					(SELECT GROUP_CONCAT(userprogressplan.activityid ORDER BY userprogressplan.status) 
						FROM userprogressplan WHERE userprogressplan.childid = child.id) as processactivityid,
					(SELECT GROUP_CONCAT(userprogressplan.subid ORDER BY userprogressplan.status) 
						FROM userprogressplan WHERE userprogressplan.childid = child.id) as subid,
					(SELECT GROUP_CONCAT(DISTINCT userprogressplan.created_by) 
						FROM userprogressplan WHERE userprogressplan.childid = child.id) as created_by
				FROM child 
					LEFT JOIN room ON room.id = child.room 
					LEFT JOIN centers ON centers.id = room.centerid 
				WHERE centers.id = '$id' 
					AND child.id IN (SELECT childid FROM childparent WHERE parentid = '$user_type_id')
				GROUP BY child.id 
				ORDER BY child.name ASC
			")->result();
	
		} else {
	
			$getprocess = $this->db->query("
				SELECT child.id as child_id, child.name as child_name, child.imageUrl as child_imageUrl,
					(SELECT GROUP_CONCAT(userprogressplan.status ORDER BY userprogressplan.status) 
						FROM userprogressplan WHERE userprogressplan.childid = child.id) as process_status,
					(SELECT GROUP_CONCAT(userprogressplan.activityid ORDER BY userprogressplan.status) 
						FROM userprogressplan WHERE userprogressplan.childid = child.id) as processactivityid,
					(SELECT GROUP_CONCAT(userprogressplan.subid ORDER BY userprogressplan.status) 
						FROM userprogressplan WHERE userprogressplan.childid = child.id) as subid,
					(SELECT GROUP_CONCAT(DISTINCT userprogressplan.created_by) 
						FROM userprogressplan WHERE userprogressplan.childid = child.id) as created_by
				FROM child 
					LEFT JOIN room ON room.id = child.room 
					LEFT JOIN centers ON centers.id = room.centerid 
				WHERE centers.id = '$id' 
				GROUP BY child.id 
				ORDER BY child.name ASC
			")->result();
	
		}
	
		return $getprocess;
	}

	public function createPlan($data=NULL){		

		$check_query = "SELECT * FROM userprogressplan WHERE childid='".$data->childid."' AND subid='".$data->subid."' ";

		$get_value=$this->db->query($check_query)->row();
		
		$insert_data = array(
			'childid'=>$data->childid,
			'activityid'=>$data->actvityid,
			'status'=>$data->status,
			'subid'=>$data->subid,
			'created_by'=>$data->created,
			'created_at'=>$this->date);
		
		if(!isset($get_value)){
			$this->db->insert('userprogressplan',$insert_data);
			return 'Success';
		} else {
			$pass_details = $this->updatePlan($data);
			return $pass_details;
		}
	}
	public function updatePlan($data){
		
		$update_data = array(
			'status'=>$data->status,
			'updated_by'=>$data->created,
			'updated_at'=>$this->date
		);
		
		//$get_result=$this->db->where(['childid'=>$data->childid,'activityid'=>$data->actvityid,'subid'=>$data->subid,'created_by'=>$data->created])->update('userprogressplan',$update_data);
		$get_result=$this->db->where(['childid'=>$data->childid,'activityid'=>$data->actvityid,'subid'=>$data->subid])->update('userprogressplan',$update_data); 
		//print_r($get_result);die();
		if($get_result){
			return 'Success';
		} else {
			return 'Failed';
		}
	}

	public function get_status_details($data=NULL){
		/*if($data->find_status == 'Record'){
			$sql_query = "
					SELECT
						child.id as child_id, child.name as child_name,child.imageUrl as child_imageUrl,
					(SELECT GROUP_CONCAT(userprogressplan.status) FROM userprogressplan WHERE userprogressplan.childid=child.id AND userprogressplan.status!='Planned' ) as process_status, 
					(SELECT GROUP_CONCAT(userprogressplan.activityid ) FROM userprogressplan WHERE userprogressplan.childid=child.id AND userprogressplan.status!='Planned' ) as processactivityid,
					(SELECT GROUP_CONCAT(userprogressplan.subid) FROM userprogressplan WHERE userprogressplan.childid=child.id AND userprogressplan.status!='Planned'  ) as subid,
					(SELECT GROUP_CONCAT( DISTINCT userprogressplan.created_by) FROM userprogressplan WHERE userprogressplan.childid=child.id AND userprogressplan.status!='Planned' ) as created_by 
					FROM child";
		} else {

			$sql_query = "
					SELECT
						child.id as child_id, child.name as child_name,child.imageUrl as child_imageUrl,
					(SELECT GROUP_CONCAT(userprogressplan.status) FROM userprogressplan WHERE userprogressplan.childid=child.id AND userprogressplan.status='Planned' ) as process_status, 
					(SELECT GROUP_CONCAT(userprogressplan.activityid ) FROM userprogressplan WHERE userprogressplan.childid=child.id AND userprogressplan.status='Planned' ) as processactivityid,
					(SELECT GROUP_CONCAT(userprogressplan.subid) FROM userprogressplan WHERE userprogressplan.childid=child.id AND userprogressplan.status='Planned'  ) as subid,
					(SELECT GROUP_CONCAT( DISTINCT userprogressplan.created_by) FROM userprogressplan WHERE userprogressplan.childid=child.id AND userprogressplan.status='Planned' ) as created_by 
					FROM child";
		}*/

		$sql_query = "
		SELECT
			child.id as child_id, child.name as child_name,child.imageUrl as child_imageUrl,
		(SELECT GROUP_CONCAT(userprogressplan.status) FROM userprogressplan WHERE userprogressplan.childid=child.id order by userprogressplan.status ) as process_status, 
		(SELECT GROUP_CONCAT(userprogressplan.activityid ) FROM userprogressplan WHERE userprogressplan.childid=child.id order by userprogressplan.status ) as processactivityid,
		(SELECT GROUP_CONCAT( DISTINCT userprogressplan.subid) FROM userprogressplan WHERE userprogressplan.childid=child.id order by userprogressplan.status   ) as subid,
		(SELECT GROUP_CONCAT( DISTINCT userprogressplan.created_by) FROM userprogressplan WHERE userprogressplan.childid=child.id  ) as created_by 
		FROM child group by child_name asc";
		
			$get_result=$this->db->query($sql_query)->result();

		return $get_result;
	}


	public function get_status_parent_details($data=NULL){

		$sql_query = "
		SELECT
			child.id as child_id, child.name as child_name,child.imageUrl as child_imageUrl,
		(SELECT GROUP_CONCAT(userprogressplan.status) FROM userprogressplan WHERE userprogressplan.childid=child.id order by userprogressplan.status ) as process_status, 
		(SELECT GROUP_CONCAT(userprogressplan.activityid ) FROM userprogressplan WHERE userprogressplan.childid=child.id order by userprogressplan.status ) as processactivityid,
		(SELECT GROUP_CONCAT( DISTINCT userprogressplan.subid) FROM userprogressplan WHERE userprogressplan.childid=child.id order by userprogressplan.status   ) as subid,
		(SELECT GROUP_CONCAT( DISTINCT userprogressplan.created_by) FROM userprogressplan WHERE userprogressplan.childid=child.id  ) as created_by 
		FROM child WHERE id IN (SELECT childid FROM `childparent` WHERE parentid ='".$data->userid."')";
		
			$get_result=$this->db->query($sql_query)->result();

		return $get_result;

	}

	/* Sagar's code */
	public function getCenterMontessoriList($centerid='')
	{
		$sql = "SELECT ms.idSubActivity as id, ms.title FROM `montessorisubactivity` ms INNER JOIN `montessorisubactivityaccess` msa ON 
		ms.idSubActivity = msa.idSubActivity WHERE msa.centerid = " . $centerid;
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getCenterChildrenList($centerid='')
	{
		$sql = "SELECT id as childid, name, imageUrl FROM `child` WHERE room IN (SELECT DISTINCT(id) FROM room WHERE centerid = $centerid)";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getParentChildrenList($userid)
	{
		$sql = "SELECT id as childid, name, imageUrl FROM `child` WHERE id IN (SELECT DISTINCT(childid) FROM childparent WHERE parentid = $userid)";
		$q = $this->db->query($sql);
		return $q->result();
	}



	public function checkMontessoriProgress($monSubAct='',$childId='')
	{
		$q = $this->db->get_where('userprogressplan', ['subid'=>$monSubAct,'childid'=>$childId]);
		return $q->row();
	}

	public function getSubActInfo($monSubActId='')
	{
		$q = $this->db->get_where('montessorisubactivity', ['idSubActivity'=>$monSubActId]);
		return $q->row();
	}

	public function insertChildProgress($data='')
	{
		$q = $this->db->insert('userprogressplan', $data);
		$last_id = $this->db->insert_id();
		if(empty($last_id)){
			return NULL;
		}else{
			$qu = $this->db->get_where('userprogressplan', ['id'=>$last_id]);
			return $qu->row();
		}
	}

	public function updateChildProgress($value='')
	{
		$data = [
			'status' => $value->status,
			'updated_by' => $value->updated_by,
			'updated_at'=>$value->updated_at
		];

		$condition = [
			'subid' => $value->subid,
			'childid' => $value->childid
		];
		$this->db->update('userprogressplan', $data, $condition);
		return $this->db->affected_rows();
	}
	
	
}