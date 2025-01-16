<?php 
error_reporting(0);
ini_set('display_errors', 0);

defined('BASEPATH') OR exit('No direct script access allowed');

class LessonplanModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->date=date('Y-m-d');
	}

	public function getlessonprocess($data=null){



        if($data->usertype=='Parent'){
                $sql="
            SELECT child.id as child_id, child.name as child_name,child.imageUrl as child_imageUrl,
            GROUP_CONCAT(sub.idActivity) as activity,
            GROUP_CONCAT(sub.idSubActivity) as subactivity,
            GROUP_CONCAT(sub.title) as sub_title
            FROM child
            LEFT JOIN userprogressplan as plan ON plan.childid=child.id
            LEFT JOIN montessorisubactivity as sub ON sub.idSubActivity=plan.subid
            WHERE plan.status='Planned' AND child.id IN (SELECT childid FROM `childparent` WHERE parentid ='".$data->userid."')
            ";

        }else{
                $sql="
            SELECT child.id as child_id, child.name as child_name,child.imageUrl as child_imageUrl,
            GROUP_CONCAT(sub.idActivity) as activity,
            GROUP_CONCAT(sub.idSubActivity) as subactivity,
            GROUP_CONCAT(sub.title) as sub_title
            FROM child
            LEFT JOIN userprogressplan as plan ON plan.childid=child.id
            LEFT JOIN montessorisubactivity as sub ON sub.idSubActivity=plan.subid
            WHERE plan.status='Planned'
            group by child_name asc";
        }

        

        
        $pass_result = $this->db->query($sql)->result();
        //print_r($pass_result);die();
        return $pass_result;
    }


    public function getlessonstatusupdate($data){
        
        $update = array(
            'status'=>'Introduced',
            'updated_by'=>$data->created_by,
	    'updated_at'=>$this->date
        );
        print_r($data);die();
        $this->db->where(['childid'=>$data->childid,'activityid'=>$data->activityid,'subid'=>$data->subid])->update('userprogressplan',$update);
        
        return 'Success';
    }

    function getpdfdata($pdf_data=NULL){
        if($pdf_data->usertype=='Parent'){
            $sql="
                SELECT child.id as child_id, child.name as child_name,child.imageUrl as child_imageUrl,
                GROUP_CONCAT(sub.idActivity) as activity,
                GROUP_CONCAT(sub.idSubActivity) as subactivity,
                GROUP_CONCAT(sub.title) as sub_title
                FROM child
                LEFT JOIN userprogressplan as plan ON plan.childid=child.id
                LEFT JOIN montessorisubactivity as sub ON sub.idSubActivity=plan.subid
                WHERE plan.status='Planned' AND child.id IN (SELECT childid FROM `childparent` WHERE parentid = '".$pdf_data->userid."')
                    ";
        } else {
            $sql="
                SELECT child.id as child_id, child.name as child_name,child.imageUrl as child_imageUrl,
                GROUP_CONCAT(sub.idActivity) as activity,
                GROUP_CONCAT(sub.idSubActivity) as subactivity,
                GROUP_CONCAT(sub.title) as sub_title
                FROM child
                LEFT JOIN userprogressplan as plan ON plan.childid=child.id
                LEFT JOIN montessorisubactivity as sub ON sub.idSubActivity=plan.subid
                WHERE plan.status='Planned'
                group by child_name asc";
        }
        

        $pass_result = $this->db->query($sql)->result();

        return $pass_result;
    }

}