<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class QipModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function createQIP($data){
		$id=mt_rand();
		// $this->db->query("INSERT INTO qip SET id = " . $id. ",name = '" . $data->name. "',created_by = " . $data->userid . ",created_at=NOW(),'centerId'=".$data->centerid);

		$this->db->query("INSERT INTO `qip` (`id`, `centerId`, `name`, `created_at`, `created_by`) VALUES (".$id.", '".$data->centerid."', '".$data->name."', '".date('Y-m-d H:i:s')."', '".$data->userid."')");
		
		$this->db->query("INSERT INTO qip_area_values SET qipId = " . $id. ",areaId = " . $data->areaid. ",strength = '" . $data->strength . "'");
		if(!empty($data->plan))
		{
		foreach($data->plan as $key=>$plan)
		{
			$this->db->query("INSERT INTO qip_improvement_plan SET qipId = " . $id . ",areaId = " . $data->areaid. ",
							 standard = '" . $plan->standard . "',issue = '".$plan->issue."'
							 ,outcome = '" . $plan->outcome . "',priority = '" . $plan->priority . "',outcome_step = '" . $plan->outcome_step . "',
							 measure = '" . $plan->measure . "',by_when = '" . $plan->by_when . "',progress = '" . $plan->progress . "'");
		}	
		}
		if(!empty($data->elements))
		{
		foreach($data->elements as $key=>$element)
		{
			$this->db->query("INSERT INTO qip_standard_values SET qipId = " . $id . ",standardId = " . $key . ",val1 = '".$element->val1."'
							 ,val2 = '" . $element->val2 . "',val3 = '" . $element->val3 . "'");
		}	
		}
		
		
		return $id;
	}

	public function updateQIP($data){
		$this->load->database();
		
		$id=$data->id;
		$query = $this->db->query("SELECT * FROM qip_area_values where qipId = " . $id. " and areaId = " . $data->areaid. "");
		echo "SELECT * FROM qip_area_values where qipId = " . $id. " and areaId = " . $data->areaid. "";
		$query=$query->row();
		if(!empty($query))
		{
		 $this->db->query("UPDATE qip_area_values SET strength = '" . $data->strength . "' where qipId = " . $id. " and areaId = " . $data->areaid. "");	
		}else{
		 $this->db->query("INSERT INTO qip_area_values SET qipId = " . $id. ",areaId = " . $data->areaid. ",strength = '" . $data->strength . "'");
		}
		
		$this->db->query("DELETE FROM qip_improvement_plan where qipId = " . $id. " and areaId = " . $data->areaid. "");
		
		if(!empty($data->plan))
		{
			
		foreach($data->plan as $key=>$plan)
		{
			$this->db->query("INSERT INTO qip_improvement_plan SET qipId = " . $id . ",areaId = " . $data->areaid. ",
							 standard = '" . $plan->standard . "',issue = '".$plan->issue."'
							 ,outcome = '" . $plan->outcome . "',priority = '" . $plan->priority . "',outcome_step = '" . $plan->outcome_step . "',
							 measure = '" . $plan->measure . "',by_when = '" . $plan->by_when . "',progress = '" . $plan->progress . "'");
			
		}	
		}
		if(!empty($data->elements))
		{
		foreach($data->elements as $key=>$element)
		{
			$this->db->query("DELETE  FROM qip_standard_values where qipId = " . $id. " and standardId = " . $key. "");
		    
			$this->db->query("INSERT INTO qip_standard_values SET qipId = " . $id . ",standardId = " . $key . ",val1 = '".$element->val1."'
							 ,val2 = '" . $element->val2 . "',val3 = '" . $element->val3 . "'");
		
			
			
		}	
		}
		
		
		return $id;
	}

	public function deleteQip($id)
	{
		$this->load->database();
		$this->db->query("DELETE FROM qip where id=".$id."");
		$this->db->query("DELETE FROM qip_area_values where qipId=".$id."");
		$this->db->query("DELETE FROM qip_improvement_plan where qipId=".$id."");
		$this->db->query("DELETE FROM qip_standard_values where qipId=".$id."");
	}

	public function getQipAreas()
	{
		$query = $this->db->get("qip_area");
		return $query->result();
	}

	public function getQipArea($id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM qip_area where id=".$id."");
		return $query->row();
	}

	public function getQipAreaValue($data=array())
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM qip_area_values where qipid=".$data['filter_qip']." and areaId=".$data['filter_area']."");
		return $query->row();
	}

	public function getQipAreaValues($id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT qav.strength,qa.title as areaName,qa.id as areaId FROM qip_area_values qav left join qip_area qa on
								  (qa.id=qav.areaId) where qav.qipid=".$id."");
		return $query->result();
	}

	public function getQips($centerid)
{
    $this->db->where('centerId', $centerid);
    $this->db->order_by('id', 'DESC'); // Replace 'id' with the column name to sort by
    $query = $this->db->get("qip");
    return $query->result();
}

	public function getQip($id,$centerid=null)
	{	
		if ($centerid==null) {
			$query = $this->db->query("SELECT * FROM qip WHERE id=".$id);
		}else{
			$query = $this->db->query("SELECT * FROM qip WHERE id=".$id." AND centerId=".$centerid);
		}
		return $query->row();
	}

	public function getQipAreaStandards($id)
	{
		$query = $this->db->query("SELECT * FROM qip_standards where areaId=".$id."");
		return $query->result();
	}

	public function getAreaNationLaw($id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM qip_national_law where areaId=".$id."");
		return $query->result();
	}

	public function getQipImpPlan($data=array())
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM qip_improvement_plan where qipid=".$data['filter_qip']." and areaId=".$data['filter_area']."");
		return $query->result();
	}

	public function getQipStandardvalues($id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM qip_standard_values where qipId=".$id."");
		return $query->result();
	}

	public function getQipStandardElements($id)
	{
		$this->load->database();
		$query = $this->db->query("SELECT * FROM qip_elements where standardId=".$id."");
		return $query->result();
	}
	
	public function getQipName($date)
	{
		$this->load->database();
		$query = $this->db->query("SELECT count(*) as total FROM qip where DATE_FORMAT(created_at,'%Y-%m')='".$date."'");
	    $query=$query->row();
		return $query->total;
	}

	//new qip functions

	public function addNewQip($data='')
	{
		$arr = [
			"centerId"=>$data->centerid,
			"name"=>$data->name,
			"created_at"=>date("Y-m-d h:i:s"),
			"created_by"=>$data->userid
		];
		$this->db->insert("qip",$arr);
		return $this->db->insert_id();
	}





	public function renameQip($data='')
	{
		$this->db->update('qip', array("name"=>$data->name), array("id"=>$data->id));
		return $this->db->affected_rows();
	}

	public function getElementUsers($elementId='')
	{	
		$sql = "SELECT u.userid,u.name,u.imageUrl FROM `qip_standards_user` qsu INNER JOIN users u ON qsu.userid = u.userid WHERE qsu.elementid = ".$elementId;
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getQipElementUsers($data='')
	{	
		$sql = "SELECT u.userid,u.name,u.imageUrl FROM `qip_standards_user` qsu INNER JOIN users u ON qsu.userid = u.userid WHERE qsu.elementid = ".$data->elementid." AND qsu.qipid = ".$data->qipid;
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function countElementUsers($elementId='')
	{	
		$sql = "SELECT COUNT(id) as userCount FROM `qip_standards_user` WHERE elementid = $elementId";
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function getDiscussions($data='')
	{
		$sql = "SELECT u.name,u.imageUrl,qsb.commentText,qsb.added_at FROM qip_discussion_board qsb INNER JOIN users u ON qsb.added_by = u.userid WHERE qsb.qipid = ".$data->qipid." AND qsb.areaid = ".$data->areaid." ORDER BY qsb.added_at DESC";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function addComment($data='')
	{
		$array = [
			"qipid"=>$data->qipid,
			"areaid"=>$data->areaid,
			"commentText"=>$data->commentText,
			"added_by"=>$data->userid,
			"added_at"=>date("Y-m-d H:i:s")
		];
		$this->db->insert('qip_discussion_board', $array);
		return $this->db->insert_id();
	}

	public function getQipsFromCenterOfQip($qipid='')
	{
		$sql = "SELECT id,name FROM `qip` WHERE centerId IN (SELECT centerId FROM qip WHERE id = ".$qipid.")";
		$q = $this->db->query($sql);
		return $q->result();
	}

	// public function getStandardDetails($stdid='')
	// {
	// 	$sql = "SELECT qsv.*, qs.areaId,qs.name,qs.about FROM qip_standard_values qsv INNER JOIN qip_standards qs ON qsv.standardId = qs.id WHERE qsv.standardId = ".$stdid;
	// 	$q = $this->db->query($sql);
	// 	return $q->row();
	// }

	public function getStandardDetails($stdid='')
	{
		$sql = "SELECT * FROM qip_standards WHERE id = ".$stdid;
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function getStandardValues($data='')
	{
		$sql = "SELECT * FROM qip_standard_values WHERE qipId = ".$data->qipid." AND standardId =".$data->stdid;
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function updateQipStandard($data='')
	{
		$insdata = [
			"val1"=>$data->val1,
			"val2"=>$data->val2,
			"val3"=>$data->val3
		];
		$this->db->update('qip_standard_values', $insdata, array("standardId"=>$data->stdid,"qipId"=>$data->qipid));
		return $this->db->affected_rows();
	}

	public function insertQipStandard($data='')
	{
		$insdata = [
			"val1"=>$data->val1,
			"val2"=>$data->val2,
			"val3"=>$data->val3,
			"standardId"=>$data->stdid,
			"qipId"=>$data->qipid
		];
		$this->db->insert('qip_standard_values', $insdata);
		return $this->db->insert_id();
	}

	public function saveQipLinks($data='')
	{
		$array = ['qip_id' => $data->qipid , 'linktype' => $data->linktype, 'elementid' => $data->elementid];
		$this->db->delete('qip_links', $array);

		foreach ($data->links as $key => $obj) {
			$this->db->insert('qip_links', $obj);
		}

		return TRUE;
	}

	public function getPublishedResources()
	{
		$this->db->select("r.id,r.title,r.description,u.name AS createdBy,r.createdAt");
		$this->db->from('resource r');
		$this->db->join('users u', 'r.createdBy = u.userid');
		$q = $this->db->get();
		return $q->result();
	}

	public function getResourceMedia($resId='')
	{
		$q = $this->db->get_where("resourcemedia",['resourceid'=>$resId]);
		return $q->result();
	}

	public function getQipLinkCheck($objid='',$linktype='',$qipid='',$elementid='')
	{
		// this is for checking qip_links table
		$arr_criteria = ["linkid"=>$objid,"linktype"=>$linktype,"qip_id"=>$qipid,"elementid"=>$elementid];
		$q = $this->db->get_where('qip_links', $arr_criteria);
		return $q->row();
	}

	public function getPublishedSurveys($centerid='')
	{
		$this->db->select('s.*, u.name as createdBy');
		$this->db->from('survey s');
		$this->db->join('users u', 's.createdBy = u.userid');
		$this->db->where(array("s.status"=>'PUBLISHED',"s.centerid"=>$centerid));
		$q = $this->db->get();
		return $q->result();
	}

	public function getProgramPlans($centerid='')
	{
		$sql = "SELECT * FROM programplanlist WHERE room_id IN (SELECT DISTINCT(ID) FROM room WHERE centerid = ".$centerid.") ORDER BY createdAt DESC";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getMontessoriSubActivites()
	{
		$query = $this->db->query("SELECT * FROM montessorisubactivity");
		return $query->result();
	}

	public function getDevelopmentalMilestoneSubActivites()
	{
		$query = $this->db->query("SELECT * FROM devmilestonesub");
		return $query->result();
	}

	public function getEylfSubActivites()
	{
		$query = $this->db->query("SELECT * FROM eylfsubactivity");
		return $query->result();
	}

	public function getQipStandards($areaid='')
	{
		$q = $this->db->query("SELECT id,name FROM `qip_standards` WHERE areaId = $areaid");
		return $q->result();
	}

	public function getSameGroupElements($elementid='')
	{
		$sql = "SELECT id,elementName FROM `qip_elements` WHERE standardId = (SELECT standardId FROM qip_elements WHERE id = $elementid)";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function getUserdetails($userid='')
	{
		$q = $this->db->get_where("users",array("userid"=>$userid));
		return $q->row();
	}

	public function getElementProgressNotes($data='')
	{
		$arr_criteria = [ "qip_id" => $data->qipid, "element_id" => $data->elementid ];		
		$q = $this->db->get_where('qip_elements_progressnotes', $arr_criteria);
		return $q->result();
	}

	public function getElementComments($data='')
	{
		$arr_criteria = [ "qipid" => $data->qipid, "element_id" => $data->elementid ];		
		$q = $this->db->get_where('qip_elements_comments', $arr_criteria);
		return $q->result();
	}

	public function getElementIssues($data='')
	{
		$arr_criteria = [ "qipid" => $data->qipid, "elementid" => $data->elementid ];		
		$q = $this->db->get_where('qip_elements_issues', $arr_criteria);
		return $q->result();
	}

	public function getAreaId($elementid='')
	{
		$q = $this->db->query("SELECT areaId FROM `qip_standards` WHERE id = (SELECT standardId FROM qip_elements WHERE id = $elementid)");
		return $q->row();
	}

	public function getQipElementById($id='')
	{
		$q = $this->db->get_where("qip_elements",array("id"=>$id));
		return $q->row();
	}

	public function saveProgressNotes($data=''){
		$insArr = [
			"qip_id" => $data->qipid,
			"element_id" => $data->elementid,
			"notetext" => $data->pronotes,
			"added_by" => $data->userid,
			"approved_by" => $data->userid,
			"added_at" => date("Y-m-d H:i:s")
		];
		$this->db->insert("qip_elements_progressnotes",$insArr);
		return $this->db->insert_id();
	}

	public function saveElementIssues($data=''){
		$insArr = [
			"qipid" => $data->qipid,
			"elementid" => $data->elementid,
			"issueIdentified" => $data->issueIdentified,
			"outcome" => $data->outcome,
			"priority" => $data->priority,
			"expectedDate" => date("Y-m-d",strtotime($data->expectedDate)),
			"successMeasure" => $data->successMeasure,
			"howToGetOutcome" => $data->howToGetOutcome,
			"addedBy" => $data->userid,
			"addedAt" => date("Y-m-d H:i:s"),
			"status" => $data->status
		];

		$this->db->insert("qip_elements_issues",$insArr);
		return $this->db->insert_id();
	}

	public function updateElementIssues($data=''){
		$insArr = [
			"qipid" => $data->qipid,
			"elementid" => $data->elementid,
			"issueIdentified" => $data->issueIdentified,
			"outcome" => $data->outcome,
			"priority" => $data->priority,
			"expectedDate" => date("Y-m-d",strtotime($data->expectedDate)),
			"successMeasure" => $data->successMeasure,
			"howToGetOutcome" => $data->howToGetOutcome,
			"addedBy" => $data->userid,
			"addedAt" => date("Y-m-d H:i:s"),
			"status" => $data->status
		];
		$this->db->update("qip_elements_issues",$insArr,array("id"=>$data->issueid));
		return $this->db->affected_rows();
	}

	public function saveElementComment($data=''){
		$insArr = [
			"qipid" => $data->qipid,
			"element_id" => $data->elementid,
			"commentText" => $data->comment,
			"added_by" => $data->userid,
			"added_at" => date("Y-m-d H:i:s")
		];
		$this->db->insert("qip_elements_comments",$insArr);
		return $this->db->insert_id();
	}

	public function getTotalElements($areaid='')
	{
		$q = $this->db->query("SELECT COUNT(*) AS totalElements FROM qip_elements WHERE standardId IN (SELECT DISTINCT(id) FROM qip_standards WHERE areaId = '".$areaid."')");
		return $q->row();
	}

	public function getAreaElementsId($areaid='')
	{
		$q = $this->db->query("SELECT id FROM qip_elements WHERE standardId IN (SELECT DISTINCT(id) FROM qip_standards WHERE areaId = '".$areaid."')");
		return $q->result();
	}

	public function getProgressCount($qipid,$elmId)
	{
		$sql = "SELECT COUNT(*) AS totalRows FROM qip_elements_progressnotes WHERE qip_id = ".$qipid." AND element_id = ".$elmId;
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function getElementCommentsCount($qipid,$elmId)
	{
		$sql = "SELECT COUNT(*) AS totalRows FROM qip_elements_comments WHERE qipid = ".$qipid." AND element_id = ".$elmId;
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function getElementIssueCount($qipid,$elmId)
	{
		$sql = "SELECT COUNT(*) AS totalRows FROM qip_elements_issues WHERE qipid = ".$qipid." AND elementid = ".$elmId;
		$q = $this->db->query($sql);
		return $q->row();
	}

	public function getCenterStaffs($data='')
	{
		$sql = "SELECT DISTINCT(u.userid) AS userid, u.* FROM `users` u INNER JOIN `usercenters` uc ON u.userid = uc.userid WHERE u.userType = 'Staff' AND uc.centerid = (SELECT DISTINCT(centerId) FROM qip WHERE id = ".$data->qipid.")";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function checkStaffInElement($data='')
	{
		$array = [
			"qipid" => $data->qipid,
			"userid" => $data->userid,
			"elementid" => $data->elementid
		];
		$q = $this->db->get_where("qip_standards_user",$array);
		$row = $q->row();
		if (isset($row))
		{
		    return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getElementInfo($elementid='')
	{
		$q = $this->db->get_where("qip_elements",array('id'=>$elementid));
		return $q->row();
	}

	public function addElementStaffs($data='')
	{
		$this->db->insert('qip_standards_user', $data);
	}

	public function deleteQipElementUsers($data='')
	{
		$delete = [
			'qipid' => $data->qipid,
			'areaid' => $data->areaid,
			'elementid' => $data->elementid
		];
		$this->db->delete('qip_standards_user', $delete);
	}
}