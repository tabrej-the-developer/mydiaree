<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed'); 

    
    function status($name,$array,$subid)
    { 
        
        $get_name=new stdClass();
        if(isset($array->$name)){
            $get_name=$array->$name;
            
            return $get_name->{$subid};
        }
    } 

    function getlessontitle($array,$j)
    { 
        $get_name=array();

        if($array[$j]->sub_title!=''){
            $lesson_title=explode(',',$array[$j]->sub_title);
            $lesson_subid=explode(',',$array[$j]->subactivity);
            $lesson_actid=explode(',',$array[$j]->activity);
	        $child_id=$array[$j]->child_id;

            //print_r($lesson_actid);die();
            
            for($i=0;$i<count($lesson_title);$i++){
                $get_name[$child_id.'_'.$lesson_actid[$i].'_'.$lesson_subid[$i]]=$lesson_title[$i];
            }
            //print_r($get_name);die();
            return $get_name;
        }
    }



    function date_change($get_date){
        
        $change_date=str_replace('%2F','/',$get_date);

        $explode_date = explode('/',$change_date);

        if(isset($explode_date)){
            //$second_explode = explode('=',$explode_date[0]);
            $send_date = $explode_date[2].'-'.$explode_date[1].'-'.$explode_date[0];
        
            return $send_date;
        }
        
    }



    function show_date($get_date){
        
        $explode_date = explode('-',$get_date);
        $send_date = $explode_date[2].'/'.$explode_date[1].'/'.$explode_date[0];

        return $send_date;
    }


    function get_details(){
        $CI = & get_instance();  //get instance, access the CI superobject
        #$CI->session->userdata();

        $json['created']=$CI->session->userdata('LoginId');
        $json['usertype']=$CI->session->userdata('UserType');
        $json['userid']=$CI->session->userdata('LoginId');

        $url=BASE_API_URL.'Programplanlist/get_details';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($json));
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'X-Device-Id: '.$CI->session->userdata('X-Device-Id'),
                  'X-Token: '.$CI->session->userdata('AuthToken')
          ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        
        
        if($httpcode == 200){
            $jsonOutput = json_decode($server_output);

            if($jsonOutput->Status=='Success'){
                    return $jsonOutput;
            }else {
                    return "Permission Error!!";
            }

        }else{
            return "Error!!";
        }
        
        
    }