<?php 
error_reporting(0);
ini_set('display_errors', 0);

defined('BASEPATH') OR exit('No direct script access allowed');

class ProgramplanlistModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->date=date('Y-m-d');
	}


    public function insert( $data ){
        
        $insert_program['createdAt']=$this->date;
        $insert_program['createdBy']=$data->userid;
        $insert_program['startdate']=$data->startdate;
        $insert_program['enddate']=$data->enddate;
        $insert_program['room_id']=$data->room_id;
        
        $this->db->insert('programplanlist',$insert_program);
        $get_insert = $this->db->insert_id();       
        
        foreach($data->head_details as $decode_key=>$decode_value){

            

            $insert_program_header =array(
                'headingname'=>$decode_value->heading_name,
                'headingcolor'=>$decode_value->heading_color,
                'priority_order'=>'',
                'programplanparentid'=>$get_insert);

            $this->db->insert('programplanlistheader',$insert_program_header);
            $get_insert_id = $this->db->insert_id();

        

            
                
            $insert_program_content=array(
                'headingid'=>$get_insert_id,
                'perhaps'=>$decode_value->content,
                'programplanparentid'=>$get_insert,
                'createdAt'=>$this->date,
                'createdBy'=>$data->userid,
            );
            
            $this->db->insert('programplanlistcontent',$insert_program_content);
        
        }
     
        //$observation_replace=explode(" ",str_replace( array( '"',',' , '"', '[', ']' ), ' ', $data->observation));
        //print_r($observation_replace);die();
        
        foreach($data->observation as $ob_key=>$ob_value){

            if($ob_value!=''){

                $link_insert = array(
                    'link_id'=>$ob_value,
                    'programplanparentid'=>$get_insert,
                    'link_type'=>'OBSERVATION',
                    'added_by'=>$data->userid,
                    'added_at'=>$this->date
                );

                $this->db->insert('programplanlistlinks',$link_insert);

            }
            
        }

        //$reflection_replace=explode(" ",str_replace( array( '"',',' , '"', '[', ']' ), ' ', $data->reflection));

        foreach($data->reflection as $ref_key=>$ref_value){

            if($ref_value!=''){

                $link_insert = array(
                    'link_id'=>$ref_value,
                    'programplanparentid'=>$get_insert,
                    'link_type'=>'REFLECTION',
                    'added_by'=>$data->userid,
                    'added_at'=>$this->date
                );

                $this->db->insert('programplanlistlinks',$link_insert);

            }
            
        }

        //$qip_replace=explode(" ",str_replace( array( '"',',' , '"', '[', ']' ), ' ', $data->qip));

        foreach($data->qip as $qip_key=>$qip_value){

            if($qip_value!=''){

                $link_insert = array(
                    'link_id'=>$qip_value,
                    'programplanparentid'=>$get_insert,
                    'link_type'=>'QIP',
                    'added_by'=>$data->userid,
                    'added_at'=>$this->date
                );

                $this->db->insert('programplanlistlinks',$link_insert);
            }
            
        }

        //$educators_replace=explode(" ",str_replace( array( '"',',' , '"', '[', ']' ), ' ', $data->educators));

        foreach($data->educators as $edu_key=>$edu_value){

            if($edu_value!=''){
                $program_users = array(
                    'userid'=>$edu_value,
                    'createdAt'=>$this->date,
                    'createdBy'=>$data->userid,
                    'programplanparentid'=>$get_insert
                );
                $this->db->insert('programplanlistusers',$program_users);
            }
        }


        //$decode_head=json_decode($data->head_details);

        

    return $get_insert;

    }


    public function update( $update_details ){
        
        $update_program['updatedAt']=$this->date;
        $update_program['updatedBy']=$update_details->userid;
        $update_program['startdate']=$update_details->startdate;
        $update_program['enddate']=$update_details->enddate;
        $update_program['room_id']=$update_details->room_id;
        
        $this->db->where(['id'=>$update_details->edit_id])->update('programplanlist',$update_program);
        
        $priority=$update_details->priority;

        $order = '';

        $this->db->delete('programplanlistheader',['programplanparentid'=>$update_details->edit_id]);
        $this->db->delete('programplanlistcontent',['programplanparentid'=>$update_details->edit_id]);

        foreach($update_details->head_details as $decode_key=>$decode_value){
                $get_name=$decode_value->heading_name;
                
                if($priority->$get_name){
                    $order = $priority->$get_name;
                }
                

                $insert_program_header =array(
                    'headingname'=>$get_name,
                    'headingcolor'=>$decode_value->heading_color,
                    'priority_order'=>$order,
                    'programplanparentid'=>$update_details->edit_id);
    
                $this->db->insert('programplanlistheader',$insert_program_header);
                $get_insert_id = $this->db->insert_id();
                
                
                
                $insert_program_content=array(
                    'headingid'=>$get_insert_id,
                    'perhaps'=>$decode_value->content,
                    'programplanparentid'=>$update_details->edit_id,
                    'createdAt'=>$this->date,
                    'createdBy'=>$update_details->userid,
                );
                
                $this->db->insert('programplanlistcontent',$insert_program_content);
                

        }
        
        
        foreach($update_details->observation as $ob_key=>$ob_value){

            if($ob_value!=''){

                $this->db->where(['programplanparentid'=>$update_details->edit_id,'link_type'=>'OBSERVATION'])->delete('programplanlistlinks');

                $link_insert = array(
                    'link_id'=>$ob_value,
                    'programplanparentid'=>$update_details->edit_id,
                    'link_type'=>'OBSERVATION',
                    'added_by'=>$update_details->userid,
                    'added_at'=>$this->date
                );

                $this->db->insert('programplanlistlinks',$link_insert);
                
                

            }
            
        }

        

        foreach($update_details->reflection as $ref_key=>$ref_value){

            if($ref_value!=''){

                $this->db->where(['programplanparentid'=>$update_details->edit_id,'link_type'=>'REFLECTION'])->delete('programplanlistlinks');

                $link_insert = array(
                    'link_id'=>$ref_value,
                    'programplanparentid'=>$update_details->edit_id,
                    'link_type'=>'REFLECTION',
                    'added_by'=>$update_details->userid,
                    'added_at'=>$this->date
                );

                $this->db->insert('programplanlistlinks',$link_insert);
                

            }
            
        }

        //$qip_replace=explode(" ",str_replace( array( '"',',' , '"', '[', ']' ), ' ', $update_details->qip));

        foreach($update_details->qip as $qip_key=>$qip_value){

            if($qip_value!=''){

                $this->db->where(['programplanparentid'=>$update_details->edit_id,'link_type'=>'QIP'])->delete('programplanlistlinks');

                $link_insert = array(
                    'link_id'=>$qip_value,
                    'programplanparentid'=>$update_details->edit_id,
                    'link_type'=>'QIP',
                    'added_by'=>$update_details->userid,
                    'added_at'=>$this->date
                );

                $this->db->insert('programplanlistlinks',$link_insert);
            }
            
        }

        //$educators_replace=explode(" ",str_replace( array( '"',',' , '"', '[', ']' ), ' ', $update_details->educators));

        

        foreach($update_details->educators as $edu_key=>$edu_value){

            if($edu_value!=''){
                $this->db->delete('programplanlistusers',['programplanparentid'=>$update_details->edit_id]);
                
                $program_users = array(
                    'userid'=>$edu_value,
                    'createdAt'=>$this->date,
                    'createdBy'=>$update_details->userid,
                    'programplanparentid'=>$update_details->edit_id
                );
                $this->db->insert('programplanlistusers',$program_users);
            }
        }


        //$decode_head=json_decode($update_details->head_details);

//        $priority=json_decode($update_details->priority);
        
        
        return $update_details->edit_id;



    }

    public function insert_new( $data ){

        $insert_program['createdAt']=$this->date;
        $insert_program['createdBy']=$data->created;
        $insert_program['startdate']=$data->startdate;
        $insert_program['enddate']=$data->enddate;
        $insert_program['room_id']=$data->room_id;
        
        $this->db->insert('programplanlist',$insert_program);
        $get_insert = $this->db->insert_id();


        if($data->program_content->head_count!=''){

            for($i=1;$i<=$data->program_content->head_count;$i++){
                $get_color ='color_type'.'_'.$i;
   
                $get_content ='content'.'_'.$i;
   
                //'headingid'=>$i,
   
               $insert_program_header =array(
                   'headingname'=>'',
                   'headingcolor'=>$data->program_content->$get_color,
                   'priority_order'=>'',
                   'programplanparentid'=>$get_insert);
   
               $this->db->insert('programplanlistheader',$insert_program_header);
               $get_insert_id = $this->db->insert_id();
               
   
               $insert_program_content=array(
                   'headingid'=>$get_insert_id,
                   'perhaps'=>$data->program_content->$get_content,
                   'programplanparentid'=>$get_insert,
                   'createdAt'=>$this->date,
                   'createdBy'=>$data->created,
               );
               
               $this->db->insert('programplanlistcontent',$insert_program_content);
           }
        }

        

                foreach($data->user_list as $list_key=>$list_value){
                    $program_users = array(
                        'userid'=>$list_value->value,
                        'createdAt'=>$this->date,
                        'createdBy'=>$data->created,
                        'programplanparentid'=>$get_insert
                    );
                    $this->db->insert('programplanlistusers',$program_users);

                }

        if(isset($data->button_action)){
            $button_insert=[];

            foreach($data->button_action as $button_key=>$button_value){
                $button_explode = explode('_',$button_key);

                $button_insert = array(
                    'link_id'=>$button_value,
                    'programplanparentid'=>$get_insert,
                    'link_type'=>$button_explode[0],
                    'added_by'=>$data->created,
                    'added_at'=>$this->date
                );

                $this->db->insert('programplanlistlinks',$button_insert);
            }
        }

        
        return $get_insert;
    }


   



    public function update_new( $update_details ){
        $update_program['updatedAt']=$this->date;
        $update_program['updatedBy']=$update_details->created;
        $update_program['startdate']=$update_details->startdate;
        $update_program['enddate']=$update_details->enddate;
        $update_program['room_id']=$update_details->room_id;
        
        $this->db->where(['id'=>$update_details->edit_id])->update('programplanlist',$update_program);
        
            if($update_details->priority_explode[0]=='' || $update_details->priority_explode[0]=='undefined'){
            
                $this->db->delete('programplanlistheader',['programplanparentid'=>$update_details->edit_id]);
                $this->db->delete('programplanlistcontent',['programplanparentid'=>$update_details->edit_id]);
    
                for($i=1;$i<=$update_details->program_content->head_count;$i++){
                    $get_color ='color_type_'.$i;
                    $get_content ='content_'.$i;
                    $get_head = 'heading_name_'.$i;
    
                        $insert_program_header =array(
                            'headingname'=>$update_details->program_content->$get_head,
                            'headingcolor'=>$update_details->program_content->$get_color,
                            'priority_order'=>$i,
                            'programplanparentid'=>$update_details->edit_id);

                        $this->db->insert('programplanlistheader',$insert_program_header);
                        $get_insert_id = $this->db->insert_id();
                        
            
                        $insert_program_content=array(
                            'headingid'=>$get_insert_id,
                            'perhaps'=>$update_details->program_content->$get_content,
                            'programplanparentid'=>$update_details->edit_id,
                            'createdAt'=>$this->date,
                            'createdBy'=>$update_details->created,
                        );
                        
                        $this->db->insert('programplanlistcontent',$insert_program_content);
                        
                }
                
            }else{
                
    
                $this->db->delete('programplanlistheader',['programplanparentid'=>$update_details->edit_id]);
                $this->db->delete('programplanlistcontent',['programplanparentid'=>$update_details->edit_id]);
    
                foreach($update_details->priority_explode as $priority_key=>$priority_value){
                
                    $prioty_value_explode = explode('_',$priority_value);
                    $sum=$prioty_value_explode[1]+1;
                    $get_color ='color_type_'.$sum;
                    $get_content ='content_'.$sum;
                    $get_head = 'heading_name_'.$sum;
    
                    $priority_change = $priority_key+1;
                    
    
                    if( ($update_details->program_content->head_count) >= $sum){
                        //'headingname'=>$update_details->program_content->$priority_value,
                        $insert_program_header =array(
                            'headingname'=>$update_details->program_content->$get_head,
                            'headingcolor'=>$update_details->program_content->$get_color,
                            'priority_order'=>$priority_change,
                            'programplanparentid'=>$update_details->edit_id);

                        
                        
                        $this->db->insert('programplanlistheader',$insert_program_header);
                        $get_insert_id = $this->db->insert_id();
                        
                        $insert_program_content=array(
                            'headingid'=>$get_insert_id,
                            'perhaps'=>$update_details->program_content->$get_content,
                            'programplanparentid'=>$update_details->edit_id,
                            'createdAt'=>$this->date,
                            'createdBy'=>$update_details->created,
                        );
                        
                        $this->db->insert('programplanlistcontent',$insert_program_content);
                    }
                    
                }
                
                
    
            }
        
            $this->db->delete('programplanlistusers',['programplanparentid'=>$update_details->edit_id]);
            //print_r($update_details->user_list);die();

        foreach($update_details->user_list as $list_key=>$list_value){
            $update_program_user = array(
                    'userid'=>$list_value->value,
                    'createdAt'=>$this->date,
                    'programplanparentid'=>$update_details->edit_id,
                    'createdBy'=>$update_details->created
            );
            $this->db->insert('programplanlistusers',$update_program_user);
        }

        if(isset($update_details->button_action)){
            foreach($update_details->button_action as $button_key=>$button_value){
                $button_explode = explode('_',$button_key);
                $this->db->where(['programplanparentid'=>$update_details->edit_id,'link_type'=>$button_explode[0],'link_id'=>$button_value])->delete('programplanlistlinks');

                $button_insert = array(
                    'link_id'=>$button_value,
                    'programparentid'=>$update_details->edit_id,
                    'link_type'=>$button_explode[0],
                    'added_by'=>$update_details->created,
                    'added_at'=>$this->date
                );
                
                $this->db->insert('programplanlistlinks',$button_insert);
                
            }
        }
        
        return $update_details->edit_id;
    }



    public function delete($get_id){

        $delete_table = array('programplanlist'=>'id','programplanlistheader'=>'programplanparentid','programplanlistcontent'=>'programplanparentid','programplanlistusers'=>'programplanparentid','programplanlistlinks'=>'programplanparentid');

        foreach($delete_table as $delete_key=>$delete_value){
            $this->db->delete($delete_key, array($delete_value=>$get_id->delete_id));
        }

        return;

        
    }

    public function showprogram($centerid){
        
        $query = "SELECT * FROM programplanlist WHERE room_id IN (SELECT DISTINCT(id) FROM room WHERE centerid = '".$centerid."' ) ORDER BY id DESC";
        $program=$this->db->query($query);
        return $program->result();
    }


    public function edit_programlistdetails($get_id=null){
        $pass_value = [];
        $main_id=$get_id->programid;

        $pass_value['programlist']=$this->db->query("SELECT * FROM programplanlist WHERE id='$main_id'")->row();

        $pass_value['programheader']=$this->db->query("
                SELECT * FROM programplanlistheader as header
                LEFT JOIN   programplanlistcontent as content ON header.id=content.headingid
         WHERE header.programplanparentid='$main_id' ORDER BY priority_order ASC")->result();

        //$pass_value['programusers']=$this->db->query("SELECT GROUP_CONCAT(userid) AS userid FROM programplanlistusers  WHERE programplanparentid='$main_id'")->result();


        $comment_query = "
        SELECT * FROM  programplancomments as comments
        LEFT JOIN users ON users.userid=comments.userid
        WHERE programplanparentid='$main_id' ORDER BY id DESC";

        $pass_value['comments']=$this->db->query($comment_query)->result();

        $pass_value['get_user']=$this->db->query("SELECT userid,name FROM users")->result();

        $get_user = "
            SELECT * FROM users as user
                 LEFT JOIN 
                 programplanlistusers as programplanlist_users ON 
                 programplanlist_users.createdBy = user.userid
             WHERE programplanlist_users.programplanparentid='$main_id'
         ";
         
        $pass_value['programusers']=$this->db->query($get_user)->result();

        
        return $pass_value;
    }


    public function get_programlistdetails($get_id=null){
        $pass_value = [];
        $main_id=$get_id->programid;

        //$pass_value['programlist']=$this->db->query("SELECT * FROM programplanlist WHERE id='$main_id'")->row();

        $pass_value['programheader']=$this->db->query("
                SELECT * FROM programplanlistheader as header
                LEFT JOIN   programplanlistcontent as content ON header.id=content.headingid
         WHERE header.programplanparentid='$main_id' ORDER BY priority_order ASC")->result();

        //$pass_value['programusers']=$this->db->query("SELECT GROUP_CONCAT(userid) AS userid FROM programplanlistusers  WHERE programplanparentid='$main_id'")->result();


        $comment_query = "
        SELECT * FROM  programplancomments as comments
        LEFT JOIN users ON users.userid=comments.userid
        WHERE programplanparentid='$main_id' ORDER BY id DESC";

        $pass_value['comments']=$this->db->query($comment_query)->result();

        //$pass_value['get_user']=$this->db->query("SELECT * FROM users")->result();

        $get_user = "
            SELECT * FROM users as user
                 LEFT JOIN 
                 programplanlistusers as programplanlist_users ON 
                 programplanlist_users.createdBy = user.userid
             WHERE programplanlist_users.programplanparentid='$main_id'
         ";
         
        $pass_value['programusers']=$this->db->query($get_user)->result();

        
        return $pass_value;
    }

    public function getProgramplanlink($typeid='', $type='', $programid=''){
        $q = $this->db->get_where('programplanlistlinks', ['link_id'=>$typeid,'link_type'=>$type,'programplanparentid'=>$programid]);
        return $q->row();
    }

    public function getPublishedQip($get_center_id){

        $write_qip_query = "SELECT *, qip.name as qip_name, qip.id as qip_id FROM qip LEFT JOIN centers ON qip.centerid=centers.id
        LEFT JOIN users ON users.userid = qip.created_by WHERE centers.id = $get_center_id";

        $send_query = $this->db->query($write_qip_query)->result();

        return $send_query;
    }

    //Written by Sagar

    public function commentinsert( $comment_data ){

        $comment_insert = array(
            'programplanparentid'=>$comment_data->programplanparentid,
            'userid'=>$comment_data->userid,
            'commenttext'=>trim($comment_data->user_comment),
            'commentdatetime'=>$this->date
        );
      
        $this->db->insert('programplancomments',$comment_insert);
        $get_insert_id = $this->db->insert_id();
        // echo "jbudj";
        // echo $get_insert_id;
       // echo $this->db->_error_message(); exit;
        return $get_insert_id;
        
    }

    public function fetchProgPlanComments($ppid='')
    {
        $sql = "SELECT * FROM `programplancomments` WHERE `programplanparentid` = $ppid ORDER BY id ASC";
        $q = $this->db->query($sql);
        return $q->result();
    }

    public function getCenterRooms($centerid=""){
        $sql = "SELECT id,name,color FROM `room` WHERE centerid = ".$centerid." AND status = 'Active'";
        $q = $this->db->query($sql);
        return $q->result();
    }

    public function getCenterEducators($centerid=""){
        $sql = "SELECT DISTINCT(u.userid) as id, u.name, u.imageUrl FROM `users` u INNER JOIN `usercenters` uc ON u.userid = uc.userid WHERE u.userType = 'Staff' AND uc.centerid = ".$centerid;
        $q = $this->db->query($sql);
        return $q->result();
    }


    public function insertProPlan($data='')
    {
        $insdata = [
            'id' => isset($data->id)?$data->id:NULL,
            'room_id' => $data->room,
            'startdate' => date('Y-m-d', strtotime($data->start_date)),
            'enddate' => date('Y-m-d', strtotime($data->end_date)),
            'createdBy' => $data->userid,
            'createdAt' => date('Y-m-d h:i:s')
        ];
        $q = $this->db->insert('programplanlist', $insdata);
        return $this->db->insert_id();
    }

    public function insertProPlanUsers($data='')
    {
        $insdata = [
            'userid' => $data->member,
            'programplanparentid' => $data->progPlanId,
            'createdBy' => $data->userid,
            'createdAt' => date('Y-m-d h:i:s')
        ];
        $q = $this->db->insert('programplanlistusers', $insdata);
        return $this->db->insert_id();
    }

    public function insertProPlanHeading($data='')
    {
        $insdata = [
            'headingname' => $data->name,
            'headingcolor' => $data->color,
            'priority_order' => $data->priority,
            'programplanparentid' => $data->progPlanId
        ];
        $q = $this->db->insert('programplanlistheader', $insdata);
        return $this->db->insert_id();
    }

    public function insertProPlanContents($data='')
    {
        $insdata = [
            'headingid' => $data->heading_id,
            'perhaps' => $data->perhaps,
            'createdBy' => $data->userid,
            'createdAt' => date('Y-m-d h:i:s'),
            'programplanparentid' => $data->progPlanId
        ];
        $q = $this->db->insert('programplanlistcontent', $insdata);
        return $this->db->insert_id();
    }

    public function deleteProPlan($progPlanId='')
    {
        $this->db->delete('programplanlist', ['id'=>$progPlanId]);
        $this->db->delete('programplanlistusers', ['programplanparentid'=>$progPlanId]);
        $this->db->delete('programplanlistheader', ['programplanparentid'=>$progPlanId]);
        $this->db->delete('programplanlistcontent', ['programplanparentid'=>$progPlanId]);
    }

    public function getProgramPlanInfo($progPlanId='')
    {
        $q = $this->db->get_where('programplanlist', ['id'=>$progPlanId]);
        return $q->row();
    }

    public function getProgramPlanHeadings($progPlanId='')
    {
        $q = $this->db->get_where('programplanlistheader', ['programplanparentid'=>$progPlanId] );
        return $q->result();
    }

    public function getProgramPlanContents($headingId='')
    {
        $q = $this->db->get_where('programplanlistcontent', ['headingid'=>$headingId] );
        return $q->result();
    }

    public function getProgramPlanUsers($progPlanId='')
    {
        $sql = "SELECT u.* FROM `users` u INNER JOIN `programplanlistusers` pplu ON u.userid = pplu.userid WHERE pplu.programplanparentid = " . $progPlanId;
        $q = $this->db->query($sql);
        return $q->result();
    }

    public function getAllOtherRooms($roomid='')
    {
        $sql = "SELECT * FROM `room` WHERE status = 'Active' AND centerid IN (SELECT DISTINCT(centerid) FROM room WHERE id = ".$roomid.")";
        $q = $this->db->query($sql);
        return $q->result();
    }

    public function getCenterEducatorsFromRoomId($roomid='')
    {
        $sql = "SELECT DISTINCT(u.userid) as id, u.name, u.imageUrl FROM `users` u INNER JOIN `usercenters` uc ON u.userid = uc.userid WHERE u.userType = 'Staff' AND uc.centerid IN (SELECT DISTINCT(centerid) FROM room WHERE id = ".$roomid.")";
        $q = $this->db->query($sql);
        return $q->result();
    }

    public function checkUserInProgramPlan($ppid='',$userid='')
    {
        $query = $this->db->get_where('programplanlistusers', ['userid'=>$userid,'programplanparentid'=>$ppid]);
        return $query->row();
    }

    public function getCenterDetailsFromRoomId($roomid='')
    {
        $sql = "SELECT * FROM `centers` WHERE id = (SELECT DISTINCT(centerid) FROM room WHERE id = ".$roomid.")";
        $q = $this->db->query($sql);
        return $q->row();
    }

    public function getCenterPublishedQip($centerid){
        $q = $this->db->get_where('qip', ['centerId'=>$centerid]);
        return $q->result();
    }

    public function saveLinks($data){

        $this->db->query("DELETE FROM programplanlistlinks where programplanparentid = '" . $data->programid . "' AND link_type = '".$data->link_type."'");

        foreach($data->linkids as $key => $val)
        {
            $array = [
                'link_id'=>$val,
                'programplanparentid'=>$data->programid,
                'link_type'=>$data->link_type,
                'added_by'=>$data->userid,
                'added_at'=>date('Y-m-d h:i:s')
            ];
            $this->db->insert('programplanlistlinks', $array);
        }
    }

}


?>