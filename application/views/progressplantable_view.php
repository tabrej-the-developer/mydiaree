        <thead>
            <tr>
                <th style='text-align:center'>Center Preliminary Exercises</th>
            </tr>
            <tr>
                
                    <th>Preliminary Exercises</th>

                    <?php foreach($child as $child_key=>$child_value){
                        
                        echo $child_value;
                    }?>
            </tr>
        </thead>  
        
        <tbody> 
        <tr>
            <?php  
                $i=1;foreach($montessorisubactivity as $sub_key=>$sub_value){
                    $sub_act=$sub_value->idActivity;
                    $subid=$sub_value->idSubActivity;
                    ?>
                    
                        <td><a href="#"><?php echo $sub_value->title?> <span class="material-icons-outlined">arrow_forward</span></a></td>
                    
                    <?php 
                        for($i=0;$i<$data_child;$i++){
                            $status=$color='';
                            $new_status='';
                            $get_name=$name=new stdClass();
                            $name=$progressplan->{$i}->child_name.'_'.$progressplan->{$i}->child_id;

                            if($name==''){
                                $progress=$progressplan[$i];
                                $name=$progress->child_name.'_'.$progress->child_id;
                            }else{
                                $progress=$progressplan->{$i};
                            }
                            


                            $get_name = status($name,$progressplan,$subid);
                            
                            $tag='';
                            if($get_name){
                            
                                $connect = $sub_act.'_'.$get_name.'_'.$progress->child_id.'_'.$subid;

                            
                                if( (trim($get_name)=='Planned') && ($this->session->userdata('LoginId')==$progress->created_by) ){
                            
                                    //echo $progressplan->{$i}->created_by.'1';
                                    
                            
                                    //$tag="<td id='".$connect."' class='change' ><span class='material-icons-outlined' style='color: #1F86FF;'>flag</span></td>";  
                                    //$tag="<td id='".$connect."' class='change' ><span> <img src='".base_url('assets/images/flag.png')."' style='padding-left: 36%;width: 6.0em;'></img></span></td>";
                                    $tag="<td id='".$connect."' class='change' ><span> <img src='".base_url('assets/images/flag.png')."' style='padding-left: 36%;'></img></span></td>";
                                    
                                } else if( (trim($get_name)=='Planned') && ($this->session->userdata('LoginId')!=$progress->created_by) ){
                                    //echo $progressplan->{$i}->created_by.'_';
                                    //$tag="<td id='".$connect."' class='change' ><span class='material-icons-outlined'>flag</span></td>";  
                                    //$tag="<td id='".$connect."' class='change' ><span> <img src='".base_url('assets/images/flag-active.png')."' style='padding-left: 36%;width: 3.0em;'></img></span></td>";
                                    //$tag="<td id='".$connect."' class='change' ><span> <img src='".base_url('assets/images/flag-active.png')."' style='padding-left: 36%;width: 6.0em;'></img></span></td>";
                                    $tag="<td id='".$connect."' class='change' ><span> <img src='".base_url('assets/images/flag-active.png')."' style='padding-left: 36%;'></img></span></td>";
                                    
                                }
                                else{
                                    $status=$statusplan[$get_name];
                                    //$tag="<td id='".$connect."' class='change' ><span style='background:".$status."' ></span></td>";
                                    //$tag="<td id='".$connect."' class='change' ><span style='background:".$status."' ></span></td>";
                                    $tag="<td id='".$connect."' class='change' style='background:".$status."' ></td>";
                                  
                                }
                                
                                
                                echo $tag;
                            } 
                            else{
                              
                                $connect = $sub_act.'_'.'No'.'_'.$progress->child_id.'_'.$subid;
                                
                                //$tag="<td id='".$connect."' class='change' ><span class='material-icons-outlined' style='color:".$status."'>flag</span></td>";
                                //$tag="<td id='".$connect."' class='change' ><span style='background:".$status."' ></span></td>";
                                $tag="<td id='".$connect."' class='change' style='background:".$status."' ></td>";
                                echo $tag;
                            }

                        ?>
                    
                    <?php  }  ?>
            </tr>
                    
                <?php }?>


                
        </tbody>
<script>
$(document).ready(function(){



    $('.change').click(function(){
        // $(".progressPlanViewContainer").toggleClass("activeRecord");
        rowCount = $('#example >tbody >tr').length;
        get_id = $(this).attr('id');

	 get_details1();
    });

var isAjaxing = false;


function get_details1(){
        
        if(isAjaxing) return;
        isAjaxing = true;

        let obj = {
        'No':'Introduced',
        'Introduced':'Working',
        'Working':'Completed',
        'Completed':'Needs More',
	    'Needs More':''
        };

        split_id = get_id.split('_');
        
        
        activity=split_id[0];
        //new_status=obj[split_id[1]];
        status=split_id[1];

        
	/*if(status!='Planned'){
            new_status=obj[split_id[1]];
        }else{
            new_status=status;
        }*/

	if( (status!='Planned') && ($('#togBtn').is(':checked')===false) ){
            new_status=obj[split_id[1]];
        }else{
            if($('#togBtn').is(':checked')){

                if(status=='Planned'){
                    new_status='';
                }else{
                    new_status='Planned';
                }
                
            }/* else{
                new_status=status;
            }*/
        }	

        child=split_id[2];
        subid=split_id[3];

        

        if(status=='No'){
            url ='<?php echo base_url()?>progressplan/add'; 
            send='status='+new_status+'&actvityid='+activity+'&childid='+child+'&subid='+subid;
        }else{
            /*if(new_status!='Planned' && status!='Planned'){
                url ='<?php echo base_url()?>progressplan/edit';
                send='status='+new_status+'&actvityid='+activity+'&childid='+child+'&subid='+subid+'&exit_status='+status;
            }*/
            url ='<?php echo base_url()?>progressplan/edit';
            send='status='+new_status+'&actvityid='+activity+'&childid='+child+'&subid='+subid+'&exit_status='+status;
        }

        $.ajax({
            url:url,
            type:'POST',
            data:send,
            success :function(data){
                isAjaxing = false;
                //console.log(data.Status,data);
                var returnedData = JSON.parse(data);
                //if(returnedData.Status=='Success') update_progress_view();

		if(returnedData.Status=='Success'){
                    if(new_status=='Planned'){
                       plan_status();
                    }else{
                        update_progress_view();
                    }
                }

                
            }
        });
   }

    function update_progress_view(){
        $("#example thead").remove();
        $("#example thead").hide();
        $('#example').html('');
        
        $.ajax({
            url:'<?php echo base_url()?>progressplan/getchilddetails',
            type:'POST',
            //data:'center_id='+$('#'+center_id).val(),
            data:'center_id='+$('#centerId').val(),
            success:function(data){

                //$('#append_table').html(data);
                $('#example').html(data);
                

            }
        });

    }

    function plan_status(){

        if ($('#togBtn').is(':checked')) {
            current_status='Planned';
        }
        else {
        current_status='Record';
        }
    
        $.ajax({
            url:'<?php echo base_url()?>progressplan/getbulkchilderndetails',
            type:'POST',
            data:'find_status='+current_status,
            success:function(data){
                $('#example').html(data);
            }

        });
    }



});
	

</script>

