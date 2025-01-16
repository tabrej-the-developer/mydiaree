<?php 
    $data['name']='Progress Plan'; 
    $this->load->view('header',$data); 
?>

<style>
    /*
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}
*/
/* Rounded sliders */
/*.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}*/

.switch {
  position: relative;
  display: inline-block;
  width: 90px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ca2222;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2ab934;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(55px);
  -ms-transform: translateX(55px);
  transform: translateX(55px);
}

/*------ ADDED CSS ---------*/
.on
{
  display: none;
}

.on, .off
{
  color: white;
  position: absolute;
  transform: translate(-50%,-50%);
  top: 50%;
  left: 50%;
  font-size: 10px;
  font-family: Verdana, sans-serif;
}

input:checked+ .slider .on
{display: block;}

input:checked + .slider .off
{display: none;}

/*--------- END --------*/

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;}
</style>

<!--
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <input id="toggle-trigger" type="checkbox" checked data-toggle="toggle">
    <button class="btn btn-success" onclick="toggleOn()">On by API</button>
<button class="btn btn-danger" onclick="toggleOff()">Off by API</button>
<button class="btn btn-primary" onclick="getValue()">Get Value</button>
<script>
  //If you want to change it dynamically
  function toggleOn() {
    $('#toggle-trigger').bootstrapToggle('on')
  }
  function toggleOff() {
    $('#toggle-trigger').bootstrapToggle('off')  
  }
  //if you want get value
  function getValue()
  {
   var value=$('#toggle-trigger').bootstrapToggle().prop('checked');
   console.log(value);
  }
</script>-->



<div class="container progressPlanContainer">
	<div class="pageHead">
		<h1>Montessori Progress Plan</h1>
    <div class="headerForm">
      <form action="" id="centerDropdown">
          <select name="centerid" id="centerId" class="form-control">
          </select>
        </form>

        <label class="switch">
            <input type="checkbox" id="togBtn">
                <div class="slider round">
                        <span class="on">Plan</span>
                        <span class="off">Record</span>
                </div>
        </label>
    </div>
	</div>
	<ul class="breadcrumb">
        <li><a href="<?php echo base_url("Dashboard"); ?>">Dashboard</a></li>
        <li class="active">Progress Plan</li>
    </ul>




    <div class="progressPlanViewContainerUl">
        <ul>
            <li id="Introduced" class='change_check'><span id="Introduced" class="change_check material-icons-outlined" style="color: #FFF505;">thumb_up</span> Introduced</li>
            <li id="Working" class='change_check'><span id="Working" class="change_check material-icons-outlined" style="color: #2778AF;">trending_up</span> Working</li>
            <li id="Completed" class='change_check'><span id="Completed" class="change_check material-icons-outlined" style="color: #F97E7F;">verified</span> Completed</li>
            <li id="Needs More" class='change_check'><span id="Needs More" class="change_check material-icons-outlined" style="color: #FF8A00;">read_more</span> Needs More</li>
            <li id="Planned" class='change_check'><span id="Planned" class="change_check material-icons-outlined" style="color: #1F86FF;">flag</span> Planned</li>
            <li class='plannedBtSomeone'><span class="material-icons-outlined">outlined_flag</span> Planned (Planned by some one)</li>
            <!--<li><input id="Introduced" class='change_check' type="checkbox" style='width: 20px;height: 20px;'><label for="Introduced"> Introduced </label></span></li>
            <li><input id="Practiced" class='change_check' type="checkbox" style='width: 20px;height: 20px;'><label for="Practiced"> Practiced </label></span></li>
            <li><input id="Mastered" class='change_check' type="checkbox" style='width: 20px;height: 20px;'><label for="Mastered"> Mastered </label></span></li>
            <li><input id="Needs More" class='change_check' type="checkbox" style='width: 20px;height: 20px;'><label for="Needs More"> Needs More </label></span></li>
            <li><span style="background: url(<?php echo base_url('assets/images/flag.png'); ?>) no-repeat center center #E5E5E5;"></span> Planned</li>
            <li><span style="background: url(<?php echo base_url('assets/images/flag-active.png'); ?>) no-repeat center center #E5E5E5;"></span> Planned (Planned by some one)</li>-->
        </ul>
    </div>

    <div class="filterProgress">
        
    </div>
    <div class="progressPlanViewContainer dataTables_scroll" id='append_table' style='width: 100%;'>
      <table id="example" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                    <!--<th style='text-align:center'>Center Preliminary Exercises</th>-->
            </tr>
        </thead> 
        
      </table>
    </div>

</div>





<script>

var get_id,rowCount,getcheckbox_id;
$(document).ready(function(){

    

    $.ajax({
        url:'<?php echo base_url()?>progressplan/get_process_child',
        dataType:'json', 
        type:'POST',
        success:function(data){
		$('#centerId').append(data);
        }
    });

    $('#centerId').change(function(){
        center_id =$(this).attr('id');
        
        //$('#example >thead >th').html('');
        $.ajax({
            url:'<?php echo base_url()?>progressplan/getchilddetails',
            type:'POST',
            data:'center_id='+$('#'+center_id).val(),
            success:function(data){

        
                $('#example').html(data);
                

            }
        });


    });


    
    


});

$(document).ready(function(){

setTimeout(() => {
    update_progress()
}, 500);
    
    
  /*  $('.change').click(function(){
        rowCount = $('#example >tbody >tr').length;
        get_id = $(this).attr('id');
        console.log(get_id);
        
    });

    $('.change_check').click(function(){
        getcheckbox_id = $(this).attr('id');
        
        
        if(getcheckbox_id==='Introduced'){
            
            $('#'+get_id).css('background','#FFF505');
        } 

        if(getcheckbox_id=='Practiced'){
            
            $('#'+get_id).css('background','#2778AF');
        }   

        if(getcheckbox_id=='Mastered'){
            
            $('#'+get_id).css('background','#F97E7F');
        }

        if(getcheckbox_id=='Needs More'){
            
            $('#'+get_id).css('background','#FF8A00');
        }
        get_details();
    })


    var isAjaxing = false
    function get_details(){
        
        if(isAjaxing) return;
        isAjaxing = true;
        split_id = get_id.split('_');
        
        activity=split_id[0];
        status=split_id[1];
        child=split_id[2];
        subid=split_id[3];

        if(status=='No'){
            url ='<?php echo base_url()?>progressplan/add'; 
            send='status='+getcheckbox_id+'&actvityid='+activity+'&childid='+child+'&subid='+subid;
        }else{
            url ='<?php echo base_url()?>progressplan/edit';
            send='status='+getcheckbox_id+'&actvityid='+activity+'&childid='+child+'&subid='+subid+'&exit_status='+status;
        }

        $.ajax({
            url:url,
            type:'POST',
            data:send,
            success :function(data){
                isAjaxing = false;
                var returnedData = JSON.parse(data);
                if(returnedData.Status=='Success') update_progress();

                
            }
        });
    }*/





    function update_progress(){
        $("#example thead").remove();
        $("#example thead").hide();
        $('#example').html('');
        
        $.ajax({
            url:'<?php echo base_url()?>progressplan/getchilddetails',
            type:'POST',
            
            data:'center_id='+$('#centerId').val(),
            success:function(data){
            
                $('#example').html(data);
                

            }
        });

    }

});

var switchStatus = false;
$("#togBtn").on('change', function() {
    if ($(this).is(':checked')) {
        switchStatus = $(this).is(':checked');
        current_status='Planned';

        $('#append_table').addClass('progress_plan');
    }

    else {
       switchStatus = $(this).is(':checked');
        current_status='Record';
        $('#append_table').removeClass('progress_plan');
    }

    $('#example').html('');

    $.ajax({
        url:'<?php echo base_url()?>progressplan/getbulkchilderndetails',
        type:'POST',
        data:'find_status='+current_status,
        success:function(data){
            $('#example').html(data);
        }

    });
});

    </script>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
       $('#example').DataTable( {
            "scrollY": "calc(100vh - 364px)",
            "scrollX": true,
            "ordering": false,
            paging: false,
            searching: false, 
            info: false,
            bFilter: false,
            
             
        } );
    } );
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



<?php $this->load->view('footer'); ?>