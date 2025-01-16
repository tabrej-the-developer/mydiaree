
<?php 
    $data['name']='Lesson Plan'; 
    $this->load->view('header',$data); 
?>

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
                    <a href="<?php echo base_url('lessonplan/printlessonPDF/P'); ?>" target="_blank" style="color: white;">Print</a>
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
        //$size_count=0;
        #echo count($new_process);
        #echo '--------------';
        #echo count($new_process)%$display;
        #echo '--------------';
        $loop_count = round(count($new_process)/$display);
        //echo '<pre>';
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
                 
                
                
            <?php }

            //$get_title=getlessontitle($new_process,$j);
            //echo $GLOBALS['count_display'];

         }
        
        /*foreach($new_process as $new_key=>$new_value){
            

            if($display==)


        }*/

            
              /* for($j=$size_count;$j<$display;$j++){

                    if(!isset($new_process[$j])){
                        break;
                    }

                    

                    $name=$new_process[$j]->child_name;
                    $get_title=getlessontitle($new_process,$j);
                    
                    
                    ?>
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
                    <?php   }*/  ?>

    </div>

</div>

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
                data:'childid='+childid+'&actid='+actid+'&subid='+subid,
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


<?php $this->load->view('footer'); ?>