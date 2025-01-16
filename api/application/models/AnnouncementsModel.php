<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AnnouncementsModel extends CI_Model {

	protected $antbl = 'announcement';
	protected $anchtbl = 'announcementchild';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function createAnnouncement($data)
	{
		# api to insert announcement data into db
		$insData = array(
			'title' => $data->title, 
			'text' => $data->text, 
			'eventDate' => isset($data->eventDate)?$data->eventDate:date('Y-m-d h:i:s',strtotime(date('Y-m-d'),'+1 day')), 
			'status' => $data->status, 
			'createdBy' => $data->userid, 
			'centerid' => $data->centerid,
			'createdAt' => date('Y-m-d H:i:s') 
		);
		$this->db->insert('announcement', $insData);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function addAnnouncementChild($childId,$value)
	{
		# add announcements to child
		$insData = array(
			'aid' => $value,
			'childid' => $childId
		);

		if($this->db->insert('announcementchild', $insData)){
			return 1;
		}else{
			return 0;
		}
	}

	public function count_antbl() {
		# code to count records in announcement table
        return $this->db->count_all($this->antbl);
    }

    public function getChildAnnouncements($childId) {
        
        $this->db->select('*');
    	$this->db->from('announcement');
    	$this->db->join('announcementchild','announcement.id = announcementchild.aid');
    	if(!empty($childId)){
        	$this->db->where('announcementchild.childid', $childId);
        }
    	$this->db->order_by('announcement.id','DESC');
		$q= $this->db->get();
        
        $q = $q->result();
        return $q;
    }

    public function getAnnouncements($userid=NULL,$centerid=NULL) {

		//return $userid . " ===" . $centerid; exit;

    	if ($userid == NULL && $centerid != NULL) {
    		$q = $this->db->query("SELECT *, id as aid FROM announcement WHERE centerid = " . $centerid . " ORDER BY id DESC");
    	} else {
    		$q = $this->db->query("SELECT *, id as aid FROM announcement WHERE createdBy = " . $userid . " AND centerid = " . $centerid . " ORDER BY id DESC");
    	}
        return $q->result();
    }

    public function getParentsInfo($value)
    {
    	# code for retriving parent recs with child id
    	$this->db->select('*');
    	$this->db->from('users');
    	$this->db->join('childparent','users.userid=childparent.parentid','left');
    	$this->db->where('users.userid', $value);
		$q= $this->db->get();
		return $q->result();
    }

    public function getUserChilds($userid='')
    {
    	$q = $this->db->get_where("childparent",array("parentid"=>$userid));
    	return $q->result();
    }

    public function childGroupsList()
    {
    	# code for getting records from child_group table
    	$q = $this->db->get('child_group');
    	return $q->result();
    }

    public function getAnnouncement($announcementId){
    	$query = $this->db->query("SELECT * FROM announcement where id = $announcementId");
    	$data = $query->row();
    	if (!empty($data)) {
    		$data->children = $this->getAnnouncementChild($announcementId);
    	}    	
    	return $data;
    }

    public function getAnnouncementChild($announcementId){
    	$query = $this->db->query("SELECT ac.*,c.name FROM announcementchild ac  JOIN child c on ac.childid = c.id  where aid = $announcementId");
    	return $query->result();	
    }

    public function updateAnnouncements($id,$title,$description,$date,$children,$status){
    	$date = date('Y-m-d H:i:s',strtotime($date));
    	$query = "UPDATE announcement SET title = '$title',text = " . $this->db->escape($description) . ", eventDate = '$date',status = '$status' where id = $id";
    	$query = $this->db->query($query);
    	$this->db->query("DELETE FROM announcementchild where aid = $id");
    	foreach($children as $child){
    		$this->db->query("INSERT INTO announcementchild (aid,childid) VALUES ($id,$child)");
    	}
    }

    public function getCreatedByName($userid)
    {
    	$q = $this->db->get_where("users",array("userid"=>$userid));
    	return $q->row();
    }

    public function getUserType($userid)
    {
    	$q = $this->db->get_where("users",array("userid"=>$userid));
    	return $q->row()->userType;
    }

    public function getUserDetails($userid)
    {
    	$q = $this->db->get_where("users",array("userid"=>$userid));
    	return $q->row();
    }

    public function checkChildInAnmnt($annid='',$childid='')
    {
    	// $annid is announcement id
    	$q = $this->db->get_where('announcementchild', array("aid"=>$annid,"childid"=>$childid));
    	return $q->row();
    }

    public function saveAnnouncement($data='')
    {
    	$update_data = [
    		'title' =>$data->title,
    		'eventDate'=>isset($data->eventDate)?$data->eventDate:date('Y-m-d h:i:s',strtotime(date('Y-m-d'),'+1 day')),
    		'text'=>$data->text,
    		'status'=>$data->status
    	];

    	$condition = ['id'=>$data->annId];

    	$this->db->update('announcement', $update_data, $condition);
    }

    public function removeAnnouncementChilds($annid='')
    {
    	$array = [ "aid" => $annid ];
    	$this->db->delete('announcementchild', $array);
    }

    public function removeAnnouncement($annid='')
    {
    	$array = [ "id" => $annid ];
    	$this->db->delete('announcement', $array);
    	return $this->db->affected_rows();
    }
}

/* End of file announcementsModel.php */
/* Location: ./application/models/announcementsModel.php */