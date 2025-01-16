<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccidentsModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getUserDetails($userid='')
	{
		$q = $this->db->get_where('users',array('userid'=>$userid));
		return $q->row();
	}

	public function getUserCenters($userid){
		$query = $this->db->query("SELECT centerName,id from centers where id IN (SELECT centerid FROM usercenters where userid = $userid)");
		return $query->result();
	}

	public function getRooms($centerid=NULL,$roomid=NULL)
	{
		
		if($centerid==NULL && $roomid==NULL) {
			$query = $this->db->get("room");
		}elseif($roomid==NULL) {
			$query = $this->db->get_where("room",array("centerid"=>$centerid));
		} else {
			$query = $this->db->get_where("room",array("id"=>$roomid));
		}
		return $query->result();
	}

	public function getAccidents($roomid = NULL)
	{
		if ($roomid == NULL) {
			$query = $this->db->query("SELECT * FROM `accidents`");
		} else {
			$query = $this->db->query("SELECT id,child_name,child_gender,roomid,incident_date,ack_parent_name,added_by FROM `accidents` WHERE roomid = $roomid");
		}
		return $query->result();
	}

	public function getChildAccidents($userid)
{
   
    $this->db->select('a.id, a.child_name, a.child_gender, a.roomid, a.incident_date, a.ack_parent_name, a.added_by');
    $this->db->from('accidents a');
    $this->db->join('childparent cp', 'cp.childid = a.childid');
    $this->db->where('cp.parentid', $userid);

    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->result() : null;
}



	

	public function getChilds($roomid)
	{
		$query = $this->db->get_where("child",array("room"=>$roomid));
		return $query->result();
	}

	public function insertAccident($data='')
	{
		$ins_arr = [
			'centerid' => $data->centerid,
			'roomid' => $data->roomid,
			'person_name' => $data->person_name,
			'person_role' => $data->person_role,
			'date' => $data->date,
			'time' => $data->time,
			// 'person_sign' => $data->person_sign,
			'childid' => $data->childid,
			'child_name' => $data->child_name,
			'child_dob' => $data->child_dob,
			'child_age' => $data->child_age,
			'child_gender' => $data->gender,
			'incident_date' => $data->incident_date,
			'incident_time' => $data->incident_time,
			'incident_location' => $data->incident_location,
			'witness_name' => $data->witness_name,
			'witness_date' => $data->witness_date,
			// 'witness_sign' => $data->witness_sign,
			'gen_actyvt' => $data->gen_actyvt,
			'cause' => $data->cause,
			'illness_symptoms' => $data->illness_symptoms,
			'missing_unaccounted' => $data->missing_unaccounted,
			'taken_removed' => $data->taken_removed,
			// 'injury_image' => $data->injury_image,
			'action_taken' => $data->action_taken,
			'emrg_serv_attend' => isset($data->emrg_serv_attend)?"Yes":"No",
			'med_attention' => isset($data->med_attention)?"Yes":"No",
			'med_attention_details' => $data->med_attention_details,
			'prevention_step_1' => $data->prevention_step_1,
			'prevention_step_2' => $data->prevention_step_2,
			'prevention_step_3' => $data->prevention_step_3,
			'parent1_name' => $data->parent1_name,
			'contact1_method' => $data->contact1_method,
			'contact1_date' => $data->contact1_date,
			'contact1_time' => $data->contact1_time,
			'contact1_made' => $data->contact1_made,
			'contact1_msg' => $data->contact1_msg,
			'parent2_name' => $data->parent2_name,
			'contact2_method' => $data->contact2_method,
			'contact2_date' => $data->contact2_date,
			'contact2_time' => $data->contact2_time,
			'contact2_made' => $data->contact2_made,
			'contact2_msg' => $data->contact2_msg,
			'responsible_person_name' => $data->responsible_person_name,
			'responsible_person_sign' => $data->responsible_person_sign,
			'rp_internal_notif_date' => $data->rp_internal_notif_date,
			'rp_internal_notif_time' => $data->rp_internal_notif_time,
			'nominated_supervisor_name' => $data->nominated_supervisor_name,
			'nominated_supervisor_sign' => $data->nominated_supervisor_sign,
			'nominated_supervisor_date' => $data->nsv_date,
			'nominated_supervisor_time' => $data->nsv_time,
			'ext_notif_other_agency' => $data->otheragency,
			'enor_date' => $data->enor_date,
			'enor_time' => $data->enor_time,
			'ext_notif_regulatory_auth' => $data->Regulatoryauthority,
			'enra_date' => $data->enra_date,
			'enra_time' => $data->enra_time,
			// 'ack_parent_name' => $data->ack_parent_name,
			// 'ack_date' => $data->ack_date,
			// 'ack_time' => $data->ack_time,
			'add_notes' => $data->add_notes,
			'added_by' => $data->userid,
			'added_at' => date('Y-m-d h:i:s')
		];

		$this->db->insert('accidents', $ins_arr);
		return $this->db->insert_id();
	}

	public function updateAccident($data='')
	{
		$ins_arr = [
			'centerid' => $data->centerid,
			'roomid' => $data->roomid,
			'person_name' => $data->person_name,
			'person_role' => $data->person_role,
			'date' => $data->date,
			'time' => $data->time,
			// 'person_sign' => $data->person_sign,
			'childid' => $data->childid,
			'child_name' => $data->child_name,
			'child_dob' => $data->child_dob,
			'child_age' => $data->child_age,
			'child_gender' => $data->gender,
			'incident_date' => $data->incident_date,
			'incident_time' => $data->incident_time,
			'incident_location' => $data->incident_location,
			'witness_name' => $data->witness_name,
			'witness_date' => $data->witness_date,
			// 'witness_sign' => $data->witness_sign,
			'gen_actyvt' => $data->gen_actyvt,
			'cause' => $data->cause,
			'illness_symptoms' => $data->illness_symptoms,
			'missing_unaccounted' => $data->missing_unaccounted,
			'taken_removed' => $data->taken_removed,
			// 'injury_image' => $data->injury_image,
			'action_taken' => $data->action_taken,
			'emrg_serv_attend' => isset($data->emrg_serv_attend)?"Yes":"No",
			'med_attention' => isset($data->med_attention)?"Yes":"No",
			'med_attention_details' => $data->med_attention_details,
			'prevention_step_1' => $data->prevention_step_1,
			'prevention_step_2' => $data->prevention_step_2,
			'prevention_step_3' => $data->prevention_step_3,
			'parent1_name' => $data->parent1_name,
			'contact1_method' => $data->contact1_method,
			'contact1_date' => $data->contact1_date,
			'contact1_time' => $data->contact1_time,
			'contact1_made' => $data->contact1_made,
			'contact1_msg' => $data->contact1_msg,
			'parent2_name' => $data->parent2_name,
			'contact2_method' => $data->contact2_method,
			'contact2_date' => $data->contact2_date,
			'contact2_time' => $data->contact2_time,
			'contact2_made' => $data->contact2_made,
			'contact2_msg' => $data->contact2_msg,
			'responsible_person_name' => $data->responsible_person_name,
			// 'responsible_person_sign' => $data->responsible_person_sign,
			'rp_internal_notif_date' => $data->rp_internal_notif_date,
			'rp_internal_notif_time' => $data->rp_internal_notif_time,
			'nominated_supervisor_name' => $data->nominated_supervisor_name,
			// 'nominated_supervisor_sign' => $data->nominated_supervisor_sign,
			'nominated_supervisor_date' => $data->nsv_date,
			'nominated_supervisor_time' => $data->nsv_time,
			'ext_notif_other_agency' => $data->otheragency,
			'enor_date' => $data->enor_date,
			'enor_time' => $data->enor_time,
			'ext_notif_regulatory_auth' => $data->ext_notif_regulatory_auth,
			'enra_date' => $data->enra_date,
			'enra_time' => $data->enra_time,
			'ack_parent_name' => $data->ack_parent_name,
			'ack_date' => $data->ack_date,
			'ack_time' => $data->ack_time,
			'add_notes' => $data->add_notes,
			'added_by' => $data->userid,
			'added_at' => date('Y-m-d h:i:s')
		];
		$this->db->where('id',$data->accidentid);
		$this->db->update('accidents', $ins_arr);
		return $this->db->affected_rows();
	}

	public function updatePersonSign($accidentid='',$value='')
	{
		$ins_arr = ['person_sign'=>$value];
		$this->db->where('id',$accidentid);
		$this->db->update('accidents', $ins_arr);
		return $this->db->affected_rows();
	}

	public function updateWitnessSign($accidentid='',$value='')
	{
		$ins_arr = ['witness_sign'=>$value];
		$this->db->where('id',$accidentid);
		$this->db->update('accidents', $ins_arr);
		return $this->db->affected_rows();
	}

	public function updateInjuryImage($accidentid='',$value='')
	{
		$ins_arr = ['injury_image'=>$value];
		$this->db->where('id',$accidentid);
		$this->db->update('accidents', $ins_arr);
		return $this->db->affected_rows();
	}

	public function updatePersonIncSign($accidentid='',$value='')
	{
		$ins_arr = ['responsible_person_sign'=>$value];
		$this->db->where('id',$accidentid);
		$this->db->update('accidents', $ins_arr);
		return $this->db->affected_rows();
	}

	public function updateNomSupervisor($accidentid='',$value='')
	{
		$ins_arr = ['nominated_supervisor_sign'=>$value];
		$this->db->where('id',$accidentid);
		$this->db->update('accidents', $ins_arr);
		return $this->db->affected_rows();
	}

	public function updateIllness($data='')
	{
		$this->db->delete("accident_illness",['accident_id'=>$data->accidentid]);
		$ins_arr = [
			'accident_id'=>$data->accidentid,
			'abrasion' => isset($data->abrasion)?1:0,
			'electric_shock' => isset($data->electric_shock)?1:0,
			'allergic_reaction' => isset($data->allergic_reaction)?1:0,
			'high_temperature' => isset($data->high_temperature)?1:0,
			'amputation' => isset($data->amputation)?1:0,
			'infectious_disease' => isset($data->infectious_disease)?1:0,
			'anaphylaxis' => isset($data->anaphylaxis)?1:0,
			'ingestion' => isset($data->ingestion)?1:0,
			'asthma' => isset($data->asthma)?1:0,
			'internal_injury' => isset($data->internal_injury)?1:0,
			'bite_wound' => isset($data->bite_wound)?1:0,
			'poisoning' => isset($data->poisoning)?1:0,
			'broken_bone' => isset($data->broken_bone)?1:0,
			'rash' => isset($data->rash)?1:0,
			'burn' => isset($data->burn)?1:0,
			'respiratory' => isset($data->respiratory)?1:0,
			'choking' => isset($data->choking)?1:0,
			'seizure' => isset($data->seizure)?1:0,
			'concussion' => isset($data->concussion)?1:0,
			'sprain' => isset($data->sprain)?1:0,
			'crush' => isset($data->crush)?1:0,
			'stabbing' => isset($data->stabbing)?1:0,
			'cut' => isset($data->cut)?1:0,
			'tooth' => isset($data->tooth)?1:0,
			'drowning' => isset($data->drowning)?1:0,
			'venomous_bite' => isset($data->venomous_bite)?1:0,
			'eye_injury' => isset($data->eye_injury)?1:0,
			'other' => isset($data->other)?1:0,
			'remarks' => $data->remarks
		];
		$this->db->insert('accident_illness', $ins_arr);
		return $this->db->insert_id();
	}

	public function getChildDetails($value='')
	{
		$arr_criteria = ['id'=>$value];
		$q = $this->db->get_where('child', $arr_criteria);
		return $q->row();
	}

	public function getCenterRooms($centerid='')
	{
		$arr_criteria = ['centerid'=>$centerid];
		$q = $this->db->get_where('room', $arr_criteria);
		return $q->result();
	}

	public function getAccidentDetails($accid='')
	{
		$arr_criteria = ['id'=>$accid];
		// $q = $this->db->get_where('accidents', $arr_criteria);
		// return $q->row();

        $sql = "SELECT a.*,ai.* FROM accidents a INNER JOIN accident_illness ai ON a.id = ai.accident_id WHERE a.id = ".$accid;
        $q = $this->db->query($sql);
        return $q->row();
	}
}

/* End of file HeadChecksModel.php */
/* Location: ./application/models/HeadChecksModel.php */