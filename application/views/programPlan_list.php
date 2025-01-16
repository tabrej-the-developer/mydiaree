<?php $data['name']='Program Plan'; $this->load->view('header',$data); ?>

<style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  /*width: 50%;*/
  width: 24%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>

<div class="container">
	<div class="pageHead">
		<h1>Programme Plan</h1>
		<div class="headerForm">
            <select name="centerid" id="centerId" class="form-control">
                <option value="1">Melbourne Center</option>
                <option value="2">Carramar Center</option>
            </select>
			<a class="btn btn-default btnBlue btn-small pull-right" href="<?php echo base_url('lessonPlanList/addProgramPlan') ?>">
                <span class="material-icons-outlined">add</span>
                Add
            </a>
		</div>
	</div>

    <div class="contentContainer">
			<?php if(!empty($page_content)) { 
				foreach($page_content as $page_key=>$page_value) { 
			?>
			<div class="qipblock">
				<span class="qipname"><?php echo show_date($page_value->startdate); ?></span>
				<span class="pull-right">
                        <a class="edit" href="<?php echo base_url('lessonPlanList/editProgramPlan/'.$page_value->id); ?>">
							<span class="material-icons-outlined">edit</span>
						</a>
						<a class="view" href="<?php echo base_url('lessonPlanList/viewProgramPlan/'.$page_value->id); ?>">
							<span class="material-icons-outlined">visibility</span>
						</a>
                        <a class="delete" href="#" id='<?php echo $page_value->id;?>'>
							<span class="material-icons-outlined">delete</span>
						</a>
				</span>
			</div>
            <?php } ?>
			<?php }  else { ?>
			<div class="text-center" style="padding-top: 15%;">
				<img src="<?php echo base_url('assets/images/icons/folder.png'); ?>">
				</br>
				</br>
				<p>No ProgramPlan</p>
			</div>
			<?php } ?>
	</div>

</div>



<?php $this->load->view('footer'); ?>

<script type="text/javascript">
	$(document).on('click','.delete',function(){
		var id = $(this).attr('id');
		var that = this;
		if (confirm('Are you sure You want to Delete?')) {
			$.ajax({
			url : '<?php echo base_url()?>lessonPlanList/delete',
			type : 'POST',
            data :'id='+$(this).attr('id'),
				success : function(response){
					location.reload();
				}
			});
    	}
		
	});

	$(document).ready(function(){
		$('.edit').on('click',function(){
			$('#overlay').show();
		})
	})



</script>
