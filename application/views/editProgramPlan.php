<?php $data['name']='Program Plan'; $this->load->view('header',$data); ?>
<br/>
  &nbsp;<a href="#" onclick='history.go(-1);'  class="round"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>

<style>  


    .previous {
    background-color: #f1f1f1;
    color: black;
    }

    #sort{ list-style-type: none; margin: 0;   
         padding: 0; width: 25%; float:left;}  
    #sort li{ margin: 0 3px 3px 3px; padding: 0.4em;   
         padding-left: 1.5em; font-size: 17px; height: 32%;
         width: 500px!important; }  
    .default {  
         background: var(--bodyBg);
         border: 1px solid #DDDDDD;  
         color: #333333;  
      }    
   </style>
   
   <style>
    .dot {
    height: 20px;
    width: 20px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    }

    .dot p{
        margin-left: 30px;
        white-space: nowrap;
    }
    </style>



<div class="container">
	<div class="pageHead">
		<h1>Edit Programme Plan</h1>
		<div class="headerForm">
            <input type='hidden' id='add_value' value=''>

            <input type='hidden' id='program_edit_id'  class='edit_id programplan_value' name='edit_id'   value='<?php echo $program_list->id?>'>

            <select name="room_id" id="centerId" class="form-control programplan_value">
                <?php foreach($room_selector as $room_id=>$room_value){
                        if($room_id==$program_list->room_id){
                            echo "<option value='".$room_id."' selected>".$room_value."</option>";
                        } else {
                            echo "<option value='".$room_id."' >".$room_value."</option>";
                        }
                    
                }?>
            </select>
		</div>
	</div>

    <div class="addProgrammePlanCont">
        <div class="dateStartEnd">            
            <div class="form-group">
                <label for="txtCalendar">Start date</label>
                <div class="input-group">
                    <input type="text" class="form-control datepickcal programplan_value" name="start_date" value="<?php echo show_date($program_list->startdate)?>" id="txtCalendar" onkeydown="return false">
                    <span class="material-icons-outlined">event</span>
                </div>
            </div>
            <div class="form-group">
                <label for="txtCalendar2">End date</label>
                <div class="input-group">
                    <input type="text" class="form-control datepickcal programplan_value" name="end_date" value="<?php echo show_date($program_list->enddate)?>" id="txtCalendar2" onkeydown="return false">
                    <span class="material-icons-outlined">event</span>
                </div>
            </div>
        </div>        
    
        <div class="form-group">
            <label for="selectEducators">Select educators</label>
            <div class="input-group">
            <select class="js-example-basic-multiple"  name="states"  id='educators' multiple="multiple">
                <?php 
                
                foreach($users_selector as $user_id=>$user_value){
                    if( (strpos($show_user,$user_id) !==false )   ){
                            echo "<option value='".$user_id."' selected>".$user_value."</option>";
                        } else {
                            echo "<option value='".$user_id."'>".$user_value."</option>";
                        }
                }?>
                
            </select>
            </div>
        </div>

        <div class="flexButtonDiv">
            <a class="btn btn-default btn-small btnBlue pull-left" onclick='loadObservation()'><span class="material-icons-outlined">link</span> Link Observation</a>
            <a class="btn btn-default btn-small btnBlue pull-left" onclick='loadReflection()'><span class="material-icons-outlined">link</span> Link Reflection</a>
            <a class="btn btn-default btn-small btnBlue pull-left" onclick='loadQip()'><span class="material-icons-outlined">link</span> Link QIP</a>
            <a class="btn btn-light btn-small  pull-left" onclick='createHead()'><span class="material-icons-outlined">add</span> Add Heading</a>
            <button class="priority-btn btn btn-default btn-small pull-left">
								<span class="material-icons-outlined">sort</span> Priority
							</button>
        </div>

        
        <div class='planBlockList'>
            <div class='planBlock'>
                <?php 
                $GLOBALS['i'] =0;
                    foreach($program_header_content as $key=>$value){ 
                         ++$GLOBALS['i'];
                         $save_value=$value->createdBy;
                        ?>
                    <div class="planBlockHead get_data">
                        <input type="text" id="heading_name_<?php echo $GLOBALS['i']?>" name="heading_name_<?php echo $GLOBALS['i']?>" style="  width: 95%; padding: 12px 20px; margin: 8px 0;display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" value='<?php echo $value->headingname?>' >
                        <input class="colorPalatte" type="color" id="color_type_<?php echo $GLOBALS['i']?>" value="<?php echo $value->headingcolor?>" >
                    </div>
                        <?php /*<img src="<?php echo base_url().'api/assets/media/'.$users_image->$save_value?>" class="obs-thumbnail" alt="">*/?>
                        <div id="text_area_content_<?php echo $GLOBALS['i']?>" >
                                <?php echo $value->perhaps ?>    
                        </div>
                            <br/><br/>

                                <div class="observation-image" style='margin-bottom: 3%;' class='signature'>
                                            <?php if($users_image->$save_value!=''){?>
                                                <img src="<?php echo base_url().'api/assets/media/'.$users_image->$save_value?>" class="obs-thumbnail" alt="" style='border-radius: 50%;' >
                                            <?php } else {?>
                                                <img src="https://via.placeholder.com/50x50?text=No+Image" class="obs-thumbnail" alt="" style='border-radius: 50%;'>
                                            <?php }?>
                                        
                                            <div style="margin-top: -2%;margin-left: 4%;">
                                                    <b>
                                                        <span>Date:<?php echo show_date($value->createdAt)?></span>
                                                        <span>Author:<?php echo $users_selector->$save_value;?></span>
                                                    </b>
                                            </div>
                                            
                                </div>

                                <div style="background:#1F86FF;"><br/><br/></div><br/>
                                        <div class="middle_color">
                                            <textarea id="header_<?php echo $GLOBALS['i']?>" name="header" class="header_<?php echo $GLOBALS['i']?>" rows="10" cols="230">
                                            </textarea><br/><br/>
                                            <button class="btn btn-default btnBlue btn-small" onclick="text_show(this.id)" id="type_<?php echo $GLOBALS['i']?>">Sumbit</button>
                                        </div>
                <?php }?>
            </div>
        </div>



        <div class="formSubmit">
           <button class="btn btn-default btnBlue pull-right btn-small" id='save_record'>Save</button>
        </div>

        
    </div>
</div>
 

<?php $this->load->view('footer'); ?>
<script src="http://cdn.ckeditor.com/4.5.4/standard/ckeditor.js"></script>
<script>
var i='<?php echo $GLOBALS['i']?>';

$(document).ready(function(){
    $('#float').hide();

    for(let set=1;set<=i;set++){
        set_header = 'header_'+set;
        set_cka(set_header);
        $('#add_value').val(set);
    }
})

function createHead(){
        
            j= parseInt($('#add_value').val()) || 0;
            i = j + 1;
            domElement='<div class="planBlockHead get_data"><input type="text" id="heading_name_'+i+'" name="heading_name_'+i+'" style="  width: 95%; padding: 12px 20px; margin: 8px 0;display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" placeholder="Heading Name"><input class="colorPalatte" type="color" id="color_type_'+i+'"  ></div>';
            domElement+='<div id="text_area_content_'+i+'" ></div>';
            domElement+='<div style="background:#1F86FF;"><br/><br/></div><br/>';
            domElement+='<div class="middle_color"><textarea id="header_'+i+'" name="header['+i+']" class="header_'+i+'" rows="10" cols="230"></textarea><br/><br/>';
            domElement+='<button onclick="text_show(this.id)" id="type_'+i+'">Sumbit</button></div><br/><br/>';
            set_header = 'header_'+i;
        $('.planBlock').append(domElement);

        set_cka(set_header);
        $('#add_value').val(i);
}

function set_cka(set_header){
    CKEDITOR.replace(set_header, {
          plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar',
          contentsCss: [
            'https://cdn.ckeditor.com/4.16.2/full-all/contents.css',
            'https://ckeditor.com/docs/ckeditor4/4.16.2/examples/assets/mentions/contents.css'
          ],
          height: 150,
          toolbar: [{
              name: 'document',
              items: ['Undo', 'Redo']
            },
            {
              name: 'basicstyles',
              items: ['Bold', 'Italic', 'Strike']
            },
            {
              name: 'links',
              items: ['EmojiPanel', 'Link', 'Unlink']
            }
          ],
          extraAllowedContent: '*[*]{*}(*)'
        });
}



window.save_array={};
window.ids = {};

window.new_array=[];
window.new_id=[];
window.observation=[];
window.qip=[];
window.reflection=[];
window.priority_order = {};
window.educators=[];

var sorting_postion,position;
function text_show(get_id){
    explode_value = get_id.split("_");
    pass_value = 'header_'+explode_value[1];

    $('#text_area_content_'+explode_value[1]).append('<br/><span class="dot">'+CKEDITOR.instances[pass_value].getData()+'</span><br/>');
    CKEDITOR.instances[pass_value].setData('');

}



</script>


<script>


    $(document).ready(function(){
        $(document).on('click','.priority-btn',function(){

            let count = $('div.get_data').find('input[type="text"]');
            

            save_string="<div><ul id='sort'>"; 
            
                $(count).each(function(index,key){
            
                        if($('#'+key.id).val()!=''){
                            value=$('#'+key.id).val();
                        }else{
                            value='Heading';
                            $('#'+key.id).val(value);
                            
                        }
                        
                        set_id =value+'_'+index;
                            save_string+="<li id='"+set_id+"' class='default' >"+value+"<span area_id='"+index+"' class='changeRoleOrder'>";
                            save_string+="<span class='material-icons-outlined' style='position: absolute;right: 15%;'>sort</span></span></li>";

                });       
                save_string+="</ul></div><br/><br/><br/><br/>";        
                        $(".priority_areas").empty();            
                        $(".priority_areas").append(save_string);
                        $('.modal_priority').modal('show');

                        


                        setTimeout(function(){
                                $('#sort').sortable({
                                    update: function(event, ui) {  
                                            position=$(this).sortable('toArray');
                                            //console.log(position);
                                            $(position).each(function(key,value){
                                                split_string = value.split('_');
                                                priority_order[split_string[0]]=parseInt(key)+1;
                                            });
                                            
                                        }
                                    });
                                    $("#sort").disableSelection();  
                        }, 1000);
                
            
	   });

    });
    

</script>
    

<script>

    $(document).ready(function(){
        
        
            $(document).on("click",".priority_save",function(){
                        sorting_position=position;                        
                        $('.modal_priority').modal('hide');
                        
                        $('#save_record').trigger('click');
            });




        $('#save_record').click(function(){
            set_head();
            list=$('#educators').serializeArray();
            educators=[];
            
            $(list).each(function(key,value){
                educators.push(value.value);
            });	
            
            $('#overlay').show();
            $.ajax({
                url:'<?php echo base_url()?>lessonPlanList/save_programplan',
                type:'POST',
                data:$('.programplan_value').serialize()+'&observation='+JSON.stringify(observation)+'&reflection='+JSON.stringify(reflection)+'&qip='+JSON.stringify(qip)+'&head_details='+JSON.stringify(new_array)+'&educators='+JSON.stringify(educators)+'&priority='+JSON.stringify(priority_order),
                success:function(get_data){
                    
                    convert_json = JSON.parse(get_data);
                    
                    $('#overlay').hide();
                    if(convert_json.Status == "Success"){
                        window.location.replace('<?php echo base_url()?>/lessonPlanList/editProgramPlan/'+convert_json.data);
                    }
                    

                    
                }
            });
        });
    });


    function set_head(){
        let count = $('div.get_data').find('input[type="text"]');
        new_array=[];
            $(count).each(function(index,value){
                get_id =value.id;


                split_string = get_id.split('_');

                new_array.push({
		            heading_name:$('#'+get_id).val(),
		            heading_color:$('#color_type_'+split_string[2]).val(),
		            content:$('#text_area_content_'+split_string[2]).html()
                    });
            });
    }


    function loadObservation(){
        base_url='<?php echo base_url()?>';
        $(document).find(".appendCont").empty();
        $.ajax({
            url: '<?php echo  base_url("lessonPlanList/getPublishedObservations"); ?>',
            type:'POST',
            data:'centerid='+$('#centerId').val()+'&edit_id='+$('#program_edit_id').val(),
        })
        .done(function(msg) {
            res = $.parseJSON(msg);            
            if (res.Status == "SUCCESS") {
                $.each(res.observations, function(index, val) {
                    let child_len = val.childs.length;
                    if (child_len > 1 ) {
                        remaining_childs = child_len - 1;
                        child_remain = `<div class="remaining-childs"><span> +`+remaining_childs+` </span> childs </div>`;
                    }else{
                        child_remain = ``;
                    }

                    if (val.childs[0].imageUrl == "") {
                        imgUrl = base_url + 'api/assets/media/' + val.childs[0].imageUrl;
                    }else{
                        imgUrl = "https://via.placeholder.com/50x50?text=No+Image";
                    }

                    $(".appendCont").append(`
                        <div class="observation-box">
                            <div class="observation-details">
                                <div class="observation-image">
                                    <img src="`+ base_url + 'api/assets/media/' + val.observationsMedia +`" class="obs-thumbnail" alt="">
                                </div>
                                <div class="observation-info">
                                    <a href="#">`+ val.title +`</a>
                                    <div class="observation-childs">
                                        <div class="child-img">
                                            <img src="`+ imgUrl +`" class="obs-child-icon" alt=""> `+ val.childs[0].child_name +`
                                        </div>
                                        `+ child_remain +`
                                    </div>
                                    <div class="observation-extras">
                                        <span>Author: `+ val.user_name +`</span>
                                        <span>Date: `+ val.date_added +`</span>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-element">
                                <input type="checkbox" name="linkids[]" class="modal-checkbox Observation"  value="`+ val.id +`" `+val.checked+`>
                            </div>     
                        </div>
                    `);
                });
            }else{
                alert(res.Message);
            }
        }); 
        $('#myModalLabel').text('Observation');
        $("#txtType").val("OBSERVATION");
        $('#myModal').modal('show');
    }


    function loadReflection(){
        base_url='<?php echo base_url()?>';
        $(document).find(".appendCont").empty();
        $.ajax({
            url: '<?php echo  base_url("lessonPlanList/getPublishedReflections"); ?>',
            type:'POST',
            data:'centerid='+$('#centerId').val()+'&edit_id='+$('#program_edit_id').val(), 
        })
        .done(function(msg) {
            res = $.parseJSON(msg);
            if (res.Status == "SUCCESS") {
                $.each(res.reflections, function(index, val) {
                    $(".appendCont").append(`
                        <div class="ref-block">
                            <div class="ref-title">
                                <a href="#">`+ val.title +`</a>
                                <span class="pull-right">
                                    <span style="background: #0C9600; font-size: 12px; color: #fff; padding: 4px 5px; border-radius: 4px;">
                                        PUBLISHED       
                                    </span>&nbsp;
                                    <input type="checkbox" name="linkids[]" class="modal-checkbox Reflection"  value="`+ val.id +`" `+val.checked+`>
                                </span>
                            </div> 
                            <div class="ref-status"> Created By: `+ val.name +` </div>   
                            <div class="ref-body">
                                <p>`+ val.about +`</p>
                            </div>     
                        </div>
                    `);
                });
            }else{
                alert(res.Message);
            }
        }); 
        $('#myModalLabel').text('Reflection');
        $("#txtType").val("REFLECTION");
        $('#myModal').modal('show');
    }

    function loadQip(){
        base_url='<?php echo base_url()?>';
        $(document).find(".appendCont").empty();
        $.ajax({
            url: '<?php echo  base_url("lessonPlanList/getPublishedQip"); ?>',
            type:'POST',
            data:'centerid='+$('#centerId').val()+'&edit_id='+$('#program_edit_id').val(),
        })
        .done(function(msg) {
            res = $.parseJSON(msg);            
            console.log(res);
            if (res.Status == "SUCCESS") {
                $.each(res.qip, function(index, val) {
                    $(".appendCont").append(`<div class="observation-box">
                            <div class="observation-details">
                                <div class="observation-info">
                                    <a href="#">`+ val.qip_name +`</a>
                                    <div class="observation-childs">
                                    </div>
                                    <div class="observation-extras">
                                        <span>Author: `+ val.name +`</span>
                                        <span>Date: `+ val.created_at +`</span>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-element">
                                <input type="checkbox" name="linkids[]" class="modal-checkbox Qip"  value="`+ val.qip_id +`" `+val.checked+`>
                            </div>     
                        </div>`);

                });
            }else{
                alert(res.Message);
            }
        }); 
        $('#myModalLabel').text('Qip');
        $("#txtType").val("QIP");
        $('#myModal').modal('show');
    }


    $(document).on("click","#saveQipLinks",function(){
        let type = $("#txtType").val();
        let check = $('#myModalLabel').text();

        $('.'+check).each(function() {
            if ($(this).prop("checked") == true) {
                if (jQuery.inArray($(this).val(), ids) === -1) {
                      //ids[type+'_'+$(this).val()]=$(this).val();

                      if(type=='OBSERVATION'){
                            observation.push($(this).val());
                        }
                        
                        if(type=='REFLECTION'){
                            reflection.push($(this).val());
                        }
                        
                        if(type=='QIP'){
                            qip.push($(this).val());
                        }
                }
            }
        });
    });

   
    </script>
    
<!-- Modal for links -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style='height: auto ! important;width: auto ! important;' >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="txtType" value="">
        <div class="appendCont">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-small btnRed pull-right" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-default btn-small btnBlue pull-right" id="saveQipLinks" data-dismiss="modal">Save</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End of modal -->    

<div class="modal_priority modal modalNew " >
	<div class="modal-dialog mw-40">
		<div class="modal-content NewFormDesign">
			<span class="modal-header" >
				<h3 class="modal-title">Edit Priority</h3>
			</span>
			<div class="modal-body">
				<div class="priority_areas">

				</div>
                <br>
				<div class="modal-footer">
					<button class="close_priority btn btn-default btn-small pull-right" role="button" data-dismiss="modal">
						<span class="material-icons-outlined">close</span> Cancel
					</button>
					<button class="priority_save btn btn-default btn-small btnBlue pull-right">
						<span class="material-icons-outlined">save</span> Save
					</button>
				</div>
			</div>
		</div>
	</div>
</div>