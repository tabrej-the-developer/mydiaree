
<?php $data['name']='Program Plan'; $this->load->view('header',$data); ?>

<div class="container">
	<div class="pageHead">
		<h1>Add Program Plan</h1>
		<div class="headerForm">
			<?php if($id) { ?>
			<button type="button" onclick="print();"  target="_blank" class="btn btn-default btnGreen btn-small qipbtn"> <span class="material-icons-outlined">print</span>&nbsp;Print </button>
			<button type="button" data-toggle="modal" data-target="#modal-email" class="btn btn-default btnBlue btn-small qipbtn"> <span class="material-icons-outlined">email</span>&nbsp;Email</button>
		
			<div class="modal fade" id="modal-email" tabindex="-1" role="dialog">
		       <div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="material-icons-outlined">close</span></button>
							<h4 class="modal-title" id="myModalLabel2">Email</h4>
						</div>
						<div class="modal-body">
							<form action="" id="form-email" method="post" enctype="multipart/form-data">
								<span class="qipemail">
									<span class="qipema">Email :- </span>
									<span class=""> &nbsp; <input type="text" name="email" id="email" value="" class="qipinu" /></span>
								</span>
								<div class="modal-footer">
									<button type="button" onclick="sendemail();"  target="_blank" class="btn btn-default btn-small btnBlue pull-right">Submit</button>
								</div>
							</form>
						</div>
					</div>
			   </div>
			</div>
			<?php } ?>	
		</div>		
	</div>
	
	<form action="" id="form-plan" method="post" enctype="multipart/form-data">
		<div class="totalFlex">
			<div class="flexField2">
				<select name="centerid" id="centerId" class="form-control">
					<?php 
						$dupArr = [];
						foreach ($this->session->userdata("centerIds") as $key => $center){
							if ( ! in_array($center, $dupArr)) {
								if (isset($_GET['centerid']) && $_GET['centerid'] != "" && $_GET['centerid']==$center->id) {
					?>
					<option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
					<?php    }else{ ?>
					<option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
					<?php
								}
							}
							array_push($dupArr, $center);
						}
					?>
				</select>
				<select class="form-control" name="roomid" id="room">
					<option value="">--Select--</option>
					<?php  
					foreach($rooms as $room) {
						if(isset($plan->roomid) && $plan->roomid==$room->id) { 
					?>
						<option value="<?php echo $room->id; ?>" selected><?php echo $room->name; ?></option>
					<?php } else { ?>
						<option value="<?php echo $room->id; ?>"><?php echo $room->name; ?></option>
					<?php } } ?>
				</select>
			</div>
		</div>

		<div class="programmePlanForm">		
			<h4 class="planroom">Adventures Room - Fortnightly Plan</h4>
			<div class="programmePlanFormFlex">
				<div class="form-group">
					<label>Educators</label>
					<select id="room_educators" class="planinput form-control" >
						<option value="">--Select--</option>
						<?php foreach($users as $user) { ?>
						<option name="<?php echo $user->name; ?>" value="<?php echo $user->userid; ?>"><?php echo $user->name; ?></option>
						<?php } ?>
					</select>
					<div id="product-category" class="well well-sm" >
						<?php 
						if(!empty($planEducators)) { 
							foreach($planEducators as $staff) { 
						?>
						<div id="product-category<?php echo $staff->userId; ?>">
							<span class="material-icons-outlined removeMinus">remove_circle</span> <?php echo $staff->userName; ?>
							<input type="hidden" name="educators[]" value="<?php echo $staff->userId; ?>" />
						</div>
						<?php } } ?>
						
					</div>	
				</div>
				<div class="form-group">
					<label for="inquiry">Inquiry Topic</label>
					<textarea id="inquiry" name="inqTopicTitle" placeholder="" value="" class="plantextarea form-control"><?php echo isset($plan->inqTopicTitle)?$plan->inqTopicTitle:''; ?></textarea>
				</div>
				<div class="form-group">
					<label for="sustainable">Sustainability Topic</label>
					<textarea id="sustainable" name="susTopicTitle" placeholder="" value="" class="plantextarea form-control"><?php echo isset($plan->susTopicTitle)?$plan->susTopicTitle:''; ?></textarea>
				</div>
				<div class="form-group">
					<label for="period">Period</label>
					<input type="text" name="period" placeholder=""	value="<?php echo isset($plan->startDate)?date('m/d/Y',strtotime($plan->startDate)).' - '.date('m/d/Y',strtotime($plan->endDate)):date('m/d/Y').' - '.date('m/t/Y'); ?>" class="planinput form-control daterange">
				</div>
			</div>
		</div>

		<div class="groupActBlock" >
			<span class="plangroup">Group Activities to Explore the Inquiry Topic & Sustainability (Discussions, Resources Used, Activities) </span>
			<div class="plandivgroup">
				<span class="planspaninquiry">Inquiry Topic</span>
				<textarea class="form-control" name="inqTopicDetails" style="border:none !important;width: auto; height: 117px;resize: none;"><?php echo isset($plan->inqTopicDetails)?$plan->inqTopicDetails:''; ?></textarea>
				<span class="planspaninquiry">Sustainability Topic</span>
				<textarea class="form-control" name="susTopicDetails" style="border:none !important;width: auto; height: 117px;resize: none;"><?php echo isset($plan->susTopicDetails)?$plan->susTopicDetails:''; ?></textarea>
			</div>
			<span class="planind">Individual Activities related to the Inquiry Topic & Sustainability (What have we added to our shelves?)</span>
			<div class="plandivgroup">
				<span class="plandivind">Art Experiences:</span>
				<textarea class="form-control" name="artExperiments" style="border:none !important;width: auto; height: 117px;resize: none;"><?php echo isset($plan->artExperiments)?$plan->artExperiments:''; ?></textarea>
				<span class="plandivind">Activities available on the Shelf:</span>
				<textarea class="form-control" name="activityDetails" style="border:none !important;width: auto; height: 117px;resize: none;"><?php echo isset($plan->activityDetails)?$plan->activityDetails:''; ?></textarea>
			</div>
			<span class="planafter">Afternoon Activity Indoor/Outdoor Experiences (3.00 pm - 6.00 pm)</span>
			<div class="plandivgroup">
				<span class="plandivafter">Outdoor Activities related to Inquiry Topic:</span>
				<textarea class="form-control" name="outdoorActivityDetails" style="border:none !important;width: auto; height: 117px;resize: none;"><?php echo isset($plan->outdoorActivityDetails)?$plan->outdoorActivityDetails:''; ?></textarea>
				<span class="plandivafter">Other Experiences:</span>
				<textarea class="form-control" name="otherExperience" style="border:none !important;width: auto; height: 117px;resize: none;"><?php echo isset($plan->otherExperience)?$plan->otherExperience:''; ?></textarea>
			</div>
			<span class="plansub">Special Activities </span>
			<div class="plandivgroup">
				<textarea class="form-control" name="specialActivity" style="border:none !important;width: auto; height: 117px;resize: none;"><?php echo isset($plan->specialActivity)?$plan->specialActivity:''; ?></textarea>

			</div>

			<div class="formSubmit">						
				<?php if (isset($permissions->editProgramPlan) && $permissions->editProgramPlan==1 || isset($permissions->addProgramPlan) && $permissions->addProgramPlan==1 ) { ?>
					<button type="button" onclick="saveQip();"  class="btn btn-default btnBlue pull-right">Save</button>
				<?php } ?>
				<a href="<?php echo base_url('qip'); ?>" class="btn btn-default btnRed pull-right">Cancel</a>
			</div>
		</div>
		
		
	</form>

</div>



<?php $this->load->view('footer'); ?>
<script>
	 $('#room_educators').change(function(){
		if($(this).val())
		{
			$('#product-category' + $(this).val()).remove();
			$('#product-category').append('<div id="product-category' + $(this).val() + '"><span class="material-icons-outlined removeMinus">remove_circle</span> ' + $('option:selected', this).attr('name') + '<input type="hidden" name="educators[]" value="' + $(this).val() + '" /></div>');
		}       
    });

	$(document).on('click', '.removeMinus', function(){ 
		$(this).parent().remove();
	});

	// $('#product-category').delegate('.fa-minus-circle', 'click', function() {
    //     $(this).parent().remove();
    // });
	var id='<?php echo $id; ?>';
    function print()
	{
		
		var url="<?php echo base_url('programPlan/printPdf'); ?>?id="+id;
		location=url;
	}
	function sendemail()
	{
		if($('#email').val()=='')
		{
			alert('Please Enter Email');
			return false
		}
		var url="<?php echo base_url('programPlan/email'); ?>?id="+id;
		var test= url.replace(/&amp;/g, '&');
		document.getElementById("form-email").action =test;
		document.getElementById("form-email").submit();
	}
	
	
	
	function saveQip()
	{
		
		if(id)
	   {
		var url="<?php echo base_url('programPlan/edit'); ?>?id="+id;
		var test= url.replace(/&amp;/g, '&');
		document.getElementById("form-plan").action =test;
		document.getElementById("form-plan").submit();
	   }else{
	   var url="<?php echo base_url('programPlan/add'); ?>";
	   var test= url.replace(/&amp;/g, '&');
		document.getElementById("form-plan").action =test;
		document.getElementById("form-plan").submit();
		
	   }
	}
	
</script>

<script>
	$("#centerId").on('change',function(){
		let centerid = $(this).val();
		<?php  
		      $qs = $_SERVER['QUERY_STRING'];
		      if ($qs == "") {
		?>
		   var url = "<?php echo base_url('programPlan/add?centerid='); ?>"+centerid;
		   var test = url.replace(/&/g, '&');
	      window.location.href=test;
		<?php
		      }else{
		         if (isset($_GET['centerid'])&&$_GET['centerid']!="") {
		            $url = str_replace('centerid='.$_GET['centerid'], 'centerid=', $_SERVER['QUERY_STRING']);
		         } else {
		            $url = $_SERVER['QUERY_STRING']."&centerid=";
		         }
		?>
		if(id)
	   {
			var url = "<?php echo base_url('programPlan/edit?').$url; ?>"+centerid;
	   }else{
		   var url = "<?php echo base_url('programPlan/add?').$url; ?>"+centerid;		
	   }
	      var test = url.replace(/&/g, '&');
	      window.location.href=test;
		<?php } ?>
	});
</script>