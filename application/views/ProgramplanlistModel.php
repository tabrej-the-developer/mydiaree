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
        //print_r($data);die();
        

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
        
        if($data->user_count!=''){

                foreach($data->user_list as $list_key=>$list_value){

                    $program_users = array(
                        'userid'=>$list_value->value,
                        'createdAt'=>$this->date,
                        'createdBy'=>$data->created,
                        'programplanparentid'=>$get_insert
                    );
                    $this->db->insert('programplanlistusers',$program_users);

                }
        }

        




        
        return $get_insert;
    }

    public function update( $update_details ){
        echo '<pre>';
        print_r($update_details);die(); 

        $update_program['updatedAt']=$this->date;
        $update_program['updatedBy']=$update_details->created;
        $update_program['startdate']=$update_details->startdate;
        $update_program['enddate']=$update_details->enddate;
        $update_program['room_id']=$update_details->room_id;
        
        $this->db->where(['id'=>$update_details->edit_id])->update('programplanlist',$update_program);

        if($update_details->program_content->head_count!=''){

            for($i=1;$i<=$update_details->program_content->head_count;$i++){
                $get_color ='color_type'.'_'.$i;
   
                $get_content ='content'.'_'.$i;
   
                
                $update_program_header =array(
                   'headingname'=>'',
                   'headingcolor'=>$update_details->program_content->$get_color,
                   'priority_order'=>''
                   );

                $this->db->where(['id'=>$update_details->header_id])->update('programplanlistheader',$update_program_header);
               
   
                $update_program_content=array(
                   'perhaps'=>$update_details->program_content->$get_content,
                   'updatedAt'=>$this->date,
                   'updatedBy'=>$data->created,
               );

                $this->db->where(['id'=>$update_details->content_id])->update('programplanlistcontent', $update_program_content);
               
           }
   

        }
        
        return $update_details->edit_id;
    }



    public function delete($get_id){

        $delete_table = array('programplanlist'=>'id','programplanlistheader'=>'programplanparentid','programplanlistcontent'=>'programplanparentid','programplanlistusers'=>'programplanparentid');

        foreach($delete_table as $delete_key=>$delete_value){
            $this->db->delete($delete_key, array($delete_value=>$get_id->delete_id));
        }

        return;

        
    }

    public function showprogram(){
        
        $query = 'SELECT * FROM programplanlist';
        $program=$this->db->query($query)->result();
        return $program;
    }


    public function get_programlistdetails($get_id=null){
        /*$write_query = "
        SELECT * 
         FROM programplanlistheader as header
        LEFT JOIN programplanlistcontent as content ON  content.headingid=header.id
        WHERE content.programplanparentid='".$get_id->programid."'";*/
        
        /*$write_query = "
        SELECT *,programlist.id as programid,header.id as headerid,content.id as contentid,
        (SELECT COUNT(headingid) FROM programplanlistcontent WHERE headingid=header.id  AND programplanparentid='1') as getcount
        FROM programplanlist as programlist 
        LEFT JOIN programplanlistheader as header ON header.programplanparentid=programlist.id
        LEFT JOIN programplanlistcontent as content ON content.headingid=header.id 
        WHERE content.programplanparentid='".$get_id->programid."'";*/

        $write_query = "
        SELECT *,programlist.id as programid,header.id as headerid,content.id as contentid,
        (SELECT COUNT(headingid) FROM programplanlistcontent WHERE headingid=header.id  AND programplanparentid='".$get_id->programid."') as getcount,
        (SELECT GROUP_CONCAT(userid) FROM programplanlistusers WHERE programplanparentid='".$get_id->programid."') as userid
        FROM programplanlist as programlist 
        LEFT JOIN programplanlistheader as header ON header.programplanparentid=programlist.id
        LEFT JOIN programplanlistcontent as content ON content.headingid=header.id 
        WHERE content.programplanparentid='".$get_id->programid."'";
        
        $pass_value = $this->db->query($write_query)->result();
        return $pass_value;
    }



}


?>