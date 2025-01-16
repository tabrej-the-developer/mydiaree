
<?php 
    $this->load->view('header'); 
?>

<style>
    .float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
	/*background-color:#25d366;
	color:#FFF;
	border-radius:50px;
    box-shadow: 2px 2px 3px #999;
    */
	text-align:center;
    font-size:30px;
    padding-left: 2%;
	
  z-index:100;
}

.my-float{
	margin-top:16px;
}
    </style>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Button used to open the chat form - fixed at the bottom of the page */
.open-button {
  background-color: #555;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  opacity: 0.8;
  position: fixed;
  bottom: 23px;
  right: 28px;
  width: 280px;
}

/* The popup chat - hidden by default */
.chat-popup {
  display: none;
  position: fixed;
  bottom: 0;
  /*right: 15px;
  width: 20%;
  height: 100%;*/
  right:0px;
  border: 3px solid #f1f1f1;
  z-index: 9;
  height: 90%;
  width: 30%;
  overflow: auto;
}

/* Add styles to the form container */
.form-container {
  /*max-width: 300px;
  background-color: white;
  background:#edeff0;*/
  padding: 10px;
  background:#ffffff;
  padding-left: 2%;
}

/* Full-width textarea */
.form-container textarea {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  border: none;
  background: #f1f1f1;
  resize: none;
  min-height: 200px;
}

/* When the textarea gets focus, do something */
.form-container textarea:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for the submit/send button */
.form-container .btn {
  background-color: #04AA6D;
  color: white;
  padding: 16px 20px;
  border: none;
  cursor: pointer;
  width: 100%;
  margin-bottom:10px;
  opacity: 0.8;
}

/* Add a red background color to the cancel button */
.form-container .cancel {
  background-color: red;
}

/* Add some hover effects to buttons */
.form-container .btn:hover, .open-button:hover {
  opacity: 1;
}

.searchFlex input {
    min-width: 81% ! important;

}

</style>

<div class="container lessonPlanContainer">
	<div class="pageHead">
		<h1>Montessori Lesson Plan</h1>
        <!--<div class="headerForm">
        <select name="centerid" id="centerId" class="form-control">
            <option value="2">Carramar Center</option>
            <option value="2">Carramar Center</option>
            <option value="2">Carramar Center</option>
        </select>
        </div>-->

        <div class="dropdownPrint">
                <button class="print-btn btn btn-default btn-small btnGreen">
                    <a href="<?php echo base_url('lessonplan/printlessonPDF'); ?>" target="_blank" style="color: white;">Print</a>
				</button>
		</div>

	</div>
	<ul class="breadcrumb">
        <li><a href="<?php echo base_url("Dashboard"); ?>">Dashboard</a></li>
        <li class="active">Lesson Plan</li>
    </ul>

     <div class="lessonPlanList" style='justify-content:flex-start !important'>
        <?php $init=0; 
        $GLOBALS['count_display']=0;
        $display=4;
        
        $split_count = round($child_count / $display);

        if($split_count==0){
            $split_count =1;
        }


        for($i=0;$i<$split_count;$i++){
            
            for($j=$GLOBALS['count_display'];$j<$child_count;$j++){
                $GLOBALS['count_display']++;
                $name=$new_process[$j]->child_name;
                $get_title=getlessontitle($new_process,$j);
            //}
            ?>
            <div class="lessonPlanListBlock">
                    <div class="lessonPlanListBlockHeader">
                        <img src="<?php echo base_url('api/assets/media/'.$new_process[$j]->child_imageUrl);?>" style='width: 4em;'> 
                        
                        <?php echo $name;?>
                    </div>

                    <ul>
                        <?php if(isset($get_title)){
                                foreach($get_title as $title_key=>$title_value){?>
                                    <li>
                                    <input id="<?php echo $title_key;?>" class='status_change' type="checkbox">
                                    <label for="check1"><?php echo $title_value;  }?></label>
                                    </li>
                        <?php }?>
                    </ul>
            </div>
        <?php }
        }
        /*$loop_count = round(count($new_process)/$display);
        for($i=1;$i<$loop_count;$i++){
            $size_count = $GLOBALS['count_display'];
            for($j=$size_count;$j<count($new_process);$j++){
                 $GLOBALS['count_display']++;
                 $name=$new_process[$j]->child_name;
                 $get_title=getlessontitle($new_process,$j);?>

                <div class="lessonPlanListBlock">
                    <div class="lessonPlanListBlockHeader">
                        <img src="<?php echo $new_process[$j]->child_imageUrl?>"> 
                        <?php echo $name;?>
                    </div>

                    <ul>
                        
                            <?php 
                            if(isset($get_title)){
                                foreach($get_title as $title_key=>$title_value){
                                ?>
                                <li>
                                <input id="<?php echo $title_key;?>" class='status_change' type="checkbox">
                                <label for="check1"><?php echo $title_value;  }?></label>
                                </li>
                            <?php }?>
                            
                            
                        
                      
                    </ul>
                </div>
                 
                
                
            <?php
             }
            }*/
          ?>

    </div>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<a href="#" class="float" id='float' onclick="openForm()">
<!--<i class="fa fa-whatsapp my-float"></i>-->
    <!--<i class="fas fa-stroopwafel fa-spin"></i>-->
    <span style='display: inline;margin-left: -110px;'><img src='<?php echo base_url()?>assets/images/icons/loader_icon.png' style='border-radius: 52%;margin-top: -170%;' width="60" height="70"></img></span>
</a>

<!--<button class="open-button" onclick="openForm()">Chat</button>-->

<div class="chat-popup form-container" id="myForm">
  
    <h1>Table</h1>

    

    <!--<label for="msg"><b>Message</b></label>-->
    <div class="searchFlex">
      <span class="material-icons-outlined">search</span>
      <input type="text" name="filter_name"  placeholder="Search by Child name,Last Observation" class="" id='search'>
    </div>
    
    <!--<div class='text-body' id='text-body'>
        </div>-->
        <div class='text-body' id='text-body'>
            
        </div>


    <!--<textarea placeholder="Type message.." name="msg" required></textarea>-->

    <!--<button type="submit" class="btn">Send</button>
    <button type="button" class="btn cancel" onclick="closeForm()">Close</button>-->
  
</div>


</div>




<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
    $('#text-body').html('');    
  $.ajax({
      url:'<?php echo base_url()?>lessonplan/observation_child_table',
      type:'POST',
      success:function(view_data){
        //$('#text-body ').html("<table id='table'>"+view_data+'</table>');  
        
        $('#text-body ').html(view_data);  
        
        $("pre").wrapInner('<div>').find('div').unwrap();
        //$(this).removeClass('myclass');
           
      }
  })

  //$('#text-body').html('<div>Hello</div>');
}

/*$('#float').click(function(){
    document.getElementById("myForm").style.display = "none";
    $('#float').removeClass('showhidenew');
});*/

$('.lessonPlanList').click(function(){
    document.getElementById("myForm").style.display = "none";
});

/*function closeForm() {
    document.getElementById("myForm").style.display = "none";
}*/
</script>

<script>

    $(document).ready(function(){
        $('#centerId').html('');
        $.ajax({
            url:'<?php echo base_url()?>/Lessonplan/getlessoncenter',
            type:'POST',
            dataType:'json', 
            success:function(data){
                $('#centerId').append(data);
            }
        });

        $('.status_change').click(function(){
            //console.log($('.status_change').attr('id'));
            get_id=$('.status_change').attr('id');

            split_id=get_id.split('_');
            //console.log(split_id);
            childid=split_id[0];
            actid=split_id[1];
            subid=split_id[2];

            $.ajax({
                url:'<?php echo base_url()?>/Lessonplan/lessondetailschange',
                type:'POST',
                data:'childid='+childid+'&activityid='+actid+'&subid='+subid,
                success:function(){

                    location.reload();
                }
            });
        })
    });


    $(document).ready(function(){

        $('#centerId').change(function(){
            $.ajax({
            url:'<?php echo base_url()?>/Lessonplan/getlessoncenter',
            type:'POST',
            data:$('#centerId').val(),
            success:function(data){

                //console.log(data);
            }
        });     
        });

    });



    
    </script>


<script>

    
        $('#search').keyup(function() {
            //console.log(';;p;p');
           /* var valThis = $(this).val().toLowerCase();
                if(valThis == ""){
                    //$('.navList > li').show();
                    $('.serach span').show();
                } else {
                    //$('.navList > li').each(function(){
                        console.log($(this));
                    $('.serach  span').each(function(){
                    var text = $(this).text().toLowerCase();
                    (text.indexOf(valThis) >= 0) ? $(this).show() : $(this).hide();
                });
            };*/

            var matcher = new RegExp($(this).val(), 'gi');
            console.log(matcher);
            $('.col1').show().not(function(){
                    return matcher.test($(this).find('.name, .category').text())
            }).hide();
        });
            
     
    

    </script>




<?php $this->load->view('footer'); ?>