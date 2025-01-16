<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SurveyModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function insertSurvey($data)
	{
		$data = array(
	        'title'=>$data['title'],
	        'description'=>$data['description'],
	        'centerid'=>$data['centerid'],
	        'createdAt'=>date('Y-m-d H:i:s'),
	        'createdBy'=>$data['userid']
	    );

	    $this->db->insert('survey',$data);

	    $insert_id = $this->db->insert_id();
	    
		return $insert_id;
	}

	// public function insSurveyChild($survey_id,$child_id)
	// {
	// 	$data = array('surveyid' => $survey_id, 'childid' => $child_id);

	// 	$this->db->insert('surveychild',$data);

	// 	$insert_id = $this->db->insert_id();
	    
	// 	return $insert_id;
	// }

	public function insSurveyChild($survey_id,$children_id)
	{
		foreach($children_id as $child_id){
			$data = array('surveyid' => $survey_id, 'childid' => $child_id);
			$this->db->insert('surveychild',$data);
		}
	}

	public function insQstn($survey_id,$qtype,$qtext,$qmand)
	{
		$data = array(
			'surveyid' => $survey_id, 
			'questionType' => $qtype,
			'questionText' => $qtext,
			'isMandatory' => $qmand
		);

		$this->db->insert('surveyquestion',$data);

		$insert_id = $this->db->insert_id();
	    
		return $insert_id;
	}

	public function insQstnOpts($qid,$data)
	{
		if($data != null){
			foreach ($data as $key) {
				$insData = array(
					'qid' => $qid,
					'optionText' => $key
				);
				$this->db->insert('surveyquestionoption',$insData);
			}
		}
	}

	public function surveysList($centerid="")
	{
		// $this->db->from('survey');
		// $this->db->order_by("id", "DESC");
		// $q = $this->db->get();
		$query = $this->db->query("SELECT s.*,u.name as createdByName FROM survey s left join users u on s.createdBy = u. userid WHERE s.centerid = '".$centerid."' ORDER BY s.createdAt DESC");
        return $query->result();
	}

	public function parentSurveysList($parentId)
	{
		$query = $this->db->query("SELECT DISTINCT(s.id) AS did,s.*,u.name as createdByName  FROM survey s LEFT JOIN users u on s.createdBy = u.userid INNER JOIN surveychild sc ON s.id = sc.surveyid WHERE sc.childid IN (SELECT childid FROM childparent WHERE parentid = $parentId) AND s.status = 'PUBLISHED'");
		return $query->result();
	}

	public function countResponse($survey_id)
	{
		$query = $this->db->get_where('surveyresponse', array('surveyid' => $survey_id));
		return $query->num_rows();
	}

	public function insQstnMedia($qid,$mediaUrl,$mediaType)
	{
		$this->db->delete('surveyquestionmedia',array('qid'=>$qid));
		$insData = array(
			'qid' => $qid,
			'mediaUrl' => $mediaUrl,
			'mediaType' => $mediaType
		);
		$this->db->insert('surveyquestionmedia',$insData);
	}

	public function getSurvey($surveyid)
	{
		$query = $this->db->query("SELECT * FROM survey where id = '$surveyid' ");
		return $query->row();
	}

	public function deleteSurvey($surveyid)
	{
		$query = $this->db->query("DELETE FROM survey where id = '$surveyid' ");
		$this->db->query("DELETE FROM surveychild where surveyid = '$surveyid' ");
		$surveyQuestion = $this->db->query("SELECT * FROM surveyquestion where surveyid = '$surveyid' ");
		$surveyQuestion = $surveyQuestion->result();
		$this->db->query("DELETE FROM surveyquestion where surveyid = '$surveyid' ");
		foreach($surveyQuestion as $question){
			$this->db->query("DELETE FROM surveyquestionmedia where qid = $question->id ");
			$this->db->query("DELETE FROM surveyquestionoption where qid = $question->id ");
			$this->db->query("DELETE FROM surveyresponsequestion where qid = $question->id ");
		}
		$this->db->query("DELETE FROM surveyresponse where surveyid = '$surveyid' ");
	}

	public function deleteSurveyWOM($surveyid)
	{
		$query = $this->db->query("DELETE FROM survey where id = '$surveyid' ");
		$this->db->query("DELETE FROM surveychild where surveyid = '$surveyid' ");
		$surveyQuestion = $this->db->query("SELECT * FROM surveyquestion where surveyid = '$surveyid' ");
		$surveyQuestion = $surveyQuestion->result();
		$this->db->query("DELETE FROM surveyquestion where surveyid = '$surveyid' ");
		foreach($surveyQuestion as $question){
			// $this->db->query("DELETE FROM surveyquestionmedia where qid = $question->id ");
			$this->db->query("DELETE FROM surveyquestionoption where qid = $question->id ");
			$this->db->query("DELETE FROM surveyresponsequestion where qid = $question->id ");
		}
		$this->db->query("DELETE FROM surveyresponse where surveyid = '$surveyid' ");
	}

	public function getSurveyDetails($surveyid){
		$survey = [];
		$query = $this->db->query("SELECT * FROM survey where id = '$surveyid' ");
		$survey['survey'] = $query->row();
		$query = $this->db->query("SELECT * FROM surveychild where surveyid = '$surveyid' ");
		$survey['surveyChild'] = $query->result();
		$surveyQuestion = $this->db->query("SELECT * FROM surveyquestion where surveyid = '$surveyid' ");
		$survey['surveyQuestion'] = $surveyQuestion->result();
		$surveyQuestion['surveyQuestion']['surveyQuestionMedia'] = [];
		$surveyQuestion['surveyQuestion']['surveyQuestionOption'] = [];
		$surveyQuestion['surveyQuestion']['surveyResponseQuestion'] = [];
		foreach($surveyQuestion as $question){
			$surveyQuestion['surveyQuestion']['surveyQuestionMedia'][] = $this->db->query("SELECT * FROM surveyquestionmedia where qid = '$question->id' ");
			$surveyQuestion['surveyQuestion']['surveyQuestionOption'][] = $this->db->query("SELECT * FROM surveyquestionoption where qid = '$question->id' ");
			$surveyQuestion['surveyQuestion']['surveyResponseQuestion'][] = $this->db->query("SELECT * FROM surveyresponsequestion where qid = '$question->id' ");
		}
		$surveyResponse = $this->db->query("SELECT * FROM surveyresponse where surveyid = '$surveyid' ");
		$surveyQuestion['response'] = $surveyResponse->result();
		return $survey;
	}

	public function getSurveyChilds($surveyid='')
	{
		$query = $this->db->query("SELECT ch.id as childid, ch.name, ch.imageUrl FROM surveychild sc INNER JOIN child ch ON sc.childid = ch.id WHERE sc.surveyid = '".$surveyid."'");
		return $query->result();
	}

	public function getSurveyQuestions($surveyid=NULL){
		if (empty($surveyid)) {
			$q = $this->db->get('surveyquestion');
			return $q->result();
		} else {
			$q = $this->db->get_where('surveyquestion',array('surveyid'=>$surveyid));
			return $q->result();
		}
	}

	public function getQuestionMedias($qstnid='')
	{
		$query = $this->db->query("SELECT * FROM surveyquestionmedia where qid = '".$qstnid."'");
		return $query->row();
	}

	public function getSurveyResponses($qid)
	{

		// $q = query('SELECT t1.*, t2.* FROM `surveyresponse` t1 INNER JOIN `surveyresponsequestion` t2 ON t1.id = t2.responseid WHERE t1.surveyid ='.$surveyid);

		$q = $this->db->select('t1.*, t2.*')
				      ->from('surveyresponse as t1')
				      ->where('t2.qid', $qid)
				      ->join('surveyresponsequestion as t2', 't1.id = t2.responseid')
				      ->get();

		return $q->result();
	}

	public function getUserInfo($userid)
	{
		$q = $this->db->get_where('users',array('userid'=>$userid));
		return $q->row();
	}

	public function getSurveyData($surveyid){
		$data = [];
		$query = $this->db->query("SELECT * FROM survey where id = '$surveyid'");
		$data['survey'] = $query->result();
		$query = $this->db->query("SELECT *,c.name as childname FROM surveychild sc RIGHT JOIN child c on c.id = sc.childid where surveyid = $surveyid");
		$data['surveyChild'] = $query->result();
		// foreach($data['surveyChild'] as $child){
		// 	$q = $this->db->query("SELECT * FROM surveychild FROM surveychild sc inner join child c on sc.childid = c.id  where surveyid = '$surveyid'");

		// }
		$query = $this->db->query("SELECT * FROM surveyquestion where surveyid = '$surveyid'");
		$surveyQuestions = $query->result();
		$data['surveyQuestion'] = $surveyQuestions;
		$data['surveyQuestionMedia'] = [];
		$data['surveyQuestionOption'] = [];
		foreach($surveyQuestions as $surveyQuestion ){
			$query = $this->db->query("SELECT * FROM surveyquestionmedia where qid = '$surveyQuestion->id'");
			$data['surveyQuestionMedia'][] = $query->result();
			$query = $this->db->query("SELECT * FROM surveyquestionoption where qid = '$surveyQuestion->id'");
			$data['surveyQuestionOption'][] = $query->result();
		}
		return $data;
	}

	public function updateSurveyTable($surveyId,$title,$description){
		$this->db->query("UPDATE survey SET title='$title',description='$description' where id='$surveyId'");
	}
	// public function surveyChildTable(){
	// 	$this->db->query("");
	// }
	// public function surveyQuestionTable(){
	// 	$this->db->query("");
	// }
	// public function surveyQuestionMediaTable(){
	// 	$this->db->query("");
	// }
	// public function surveyQuestionOptionTable(){
	// 	$this->db->query("");
	// }
	public function countSurveyResponse($userid,$surveyid)
	{
		$q = $this->db->get_where('surveyresponse', ['userid'=>$userid, 'surveyid'=>$surveyid]);
		return $q->num_rows();
	}

	public function insertSurveyResponse($userid,$surveyid){
		$date = date('Y-m-d H:i:s');
		$data = array(
	        'userid'=>$userid,
	        'surveyid'=>$surveyid,
	        'createdAt'=>$date
	    );
	    $this->db->insert('surveyresponse',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function insertSurveyResponseQuestion($responseId,$questionId,$r){
		$this->db->query("INSERT INTO surveyresponsequestion (responseid,qid,answerText) VALUES ($responseId,$questionId,'$r')");
	}

	public function deleteQuestion($questionId){
		$this->db->query("DELETE FROM surveyquestion where id = $questionId");
		$this->db->query("DELETE FROM surveyquestionoption where qid = $questionId");
		$this->db->query("DELETE FROM surveyquestionmedia where qid = $questionId");		
	}
	public function deleteOption($optionId){
		$this->db->query("DELETE FROM surveyquestionoption where id = $optionId");
	}
	public function deleteMedia($mediaId){
		$this->db->query("DELETE FROM surveyquestionmedia where id = $optionId");
	}

	public function getResponseStatus($surveyId,$userid)
	{	
		$query = $this->db->query("SELECT COUNT(*) as count FROM `surveyresponse` WHERE surveyid = $surveyId AND userid = $userid");
		return $query->row();
		
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

	public function getQuestionOptions($qstnid='')
	{
		$sql = "SELECT id, optionText FROM `surveyquestionoption` WHERE `qid`= $qstnid";
		$q = $this->db->query($sql);
		return $q->result();
	}

	public function deleteQuestionOptions($surveyid='')
	{
		$sql = "DELETE FROM `surveyquestionoption` WHERE `qid` IN (SELECT DISTINCT(id) FROM surveyquestion WHERE surveyid = $surveyid)";
		$q = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function deleteQuestionMedias($surveyid='')
	{
		$sql = "DELETE FROM `surveyquestionmedia` WHERE `qid` IN (SELECT DISTINCT(id) FROM surveyquestion WHERE surveyid = $surveyid)";
		$q = $this->db->query($sql);
		return $this->db->affected_rows();
	}

	public function deleteQuestions($surveyid='')
	{
		$this->db->delete("surveyquestion",array("surveyid"=>$surveyid));
		return $this->db->affected_rows();
	}

	public function updateSurvey($data)
	{
		$insdata = array(
			'id'=>$data['surveyid'],
	        'title'=>$data['title'],
	        'centerid'=>$data['centerid'],
	        'description'=>$data['description'],
	        'status'=>isset($data['status'])?$data['status']:'DRAFT',
	        'createdAt'=>date("Y-m-d H:i:s"),
	        'createdBy'=>$data['userid']
	    );
	    $this->db->insert('survey',$insdata);	    
		return $data['surveyid'];
	}

	public function checkChildInSurvey($surveyId='',$childid='')
    {
    	// $surveyId is announcement id
    	$q = $this->db->get_where('surveychild', array("surveyid"=>$surveyId,"childid"=>$childid));
    	return $q->row();
    }

    public function updateMediaQstnId($mediaId='',$qstnId='')
    {
    	$sql = "UPDATE `surveyquestionmedia` SET `qid`='" . $qstnId . "' WHERE id = " . $mediaId;
    	$this->db->query($sql);
    	return $this->db->affected_rows();
    }
}

/* End of file Surveymodel.php */
/* Location: ./application/models/Surveymodel.php */