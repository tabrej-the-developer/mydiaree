<?php 
	$data['name']='Daily Diary'; 
	$this->load->view('header',$data); 
?>
<style>
	.common-dd-tbl{
		display: none;
		width: 100%;
	}

	.drop-down{
		border: 1px solid #008ecc;
		border-bottom-left-radius: 50px;
		border-bottom-right-radius: 50px;
		border-top-left-radius: 50px;
		border-top-right-radius: 50px;
		background-color: transparent;
		color: #008ecc;
		text-transform: uppercase;
		font-weight: bold;
		display: block;
		line-height: 19.2px;
		font-size: 12.8px;
		letter-spacing: 0.8px;
		vertical-align: middle;
		padding: 12px 41.6px 9.6px 41.6px;
		height: 42.78px;
	}
</style>
<?php 
	if ($this->session->userdata("UserType")=="Parent") {
?>
<style>.btn-add{display: none;}</style>
<?php
	}
?>

<div class="container ">
	<div class="pageHead">
		<h1>Daily Diary</h1>
		<div class="headerForm">
			<form action="" method="get" id="dailyDiary">
				<select name="centerid" id="centerId" class="form-control">
					<?php 
						$dupArr = [];
						foreach ($this->session->userdata("centerIds") as $key => $center){
							if ( ! in_array($center, $dupArr)) {
								if (isset($_GET['centerid']) && $_GET['centerid']==$center->id) {
					?>
					<option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
					<?php
								}else{
					?>
					<option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
					<?php
								}
							}
							array_push($dupArr, $center);
						}
					?>
				</select>
				<select name="roomid" id="roomid" class="form-control">
					<option>-- Select Room --</option>
					<?php 
						foreach ($rooms as $room => $rObj) { 
							if ($rObj->id==$roomid || (isset($_GET['roomid']) && $_GET['roomid']==$rObj->id)) {
					?>
					<option value="<?php echo $rObj->id; ?>" selected><?php echo $rObj->name; ?></option>
					<?php
							} else {
					?>
					<option value="<?php echo $rObj->id; ?>"><?php echo $rObj->name; ?></option>
					<?php
							}
						} 
					?>
				</select>
				<div class="form-group">
					<div class="input-group">
						<?php 
							if(isset($date)){
								$calDate = date('d-m-Y',strtotime($date));
							}else if (isset($_GET['date']) && $_GET['date'] != "") {
								$calDate = date('d-m-Y',strtotime($_GET['date']));
							}else{
								$calDate = date('d-m-Y');
							}
						?>
						<input type="text" class="form-control datepickcal" name="date" value="<?php echo $calDate; ?>" id="txtCalendar">
						<div class="input-group-addon"><span class="material-icons-outlined">event</span></div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url()."dailyDiary/";?>">Daily Diary</a></li>
	</ul>
	<div class="daiilyDiaryView">
		<div class="room-div" style="background-color: <?php echo $roomcolor; ?>;">
			<?php echo $roomname; ?>
		</div>
		<table class="dailyDiaryTable" width="100%">
			<thead>
				<tr>
					<th class="child-name-cell-title">
						<?php if ($this->session->userdata("UserType")!="Parent") { ?>
						<input type="checkbox" id="checkAllStudents"> 
						<?php } ?>
						<span>Child Name</span>
					</th>
					<?php if($columns->breakfast==1){ ?>
						<th style="background-color: #FFECB3;"> Breakfast </th>
					<?php } ?>
					<?php if($columns->morningtea==1){ ?>
						<th style="background-color: #C0CCD9;"> Morning Tea </th>
					<?php } ?>
					<?php if($columns->lunch==1){ ?>
					<th style="background-color: rgba(19, 109, 246, 0.2);"> Lunch </th>
					<?php } ?>
					<?php if($columns->sleep==1){ ?>
					<th style="background-color: rgba(239, 206, 74, 0.62);"> Sleep </th>
					<?php } ?>
					<?php if($columns->afternoontea==1){ ?>
					<th style="background-color: #F0CDFF;"> Afternoon Tea </th>
					<?php } ?>
					<?php if($columns->latesnacks==1){ ?>
					<th style="background-color: #FEC093;"> Late Snacks </th>
					<?php } ?>
					<?php if($columns->sunscreen==1){ ?>
					<th style="background-color: #E07F7F;"> SunScreen </th>
					<?php } ?>
					<?php if($columns->toileting==1){ ?>
					<th style="background-color: #D1FFCD;"> Toileting </th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($childs as $child => $cobj) {
				?>
				<tr>
					<td class="kids-cell">
						<?php if ($this->session->userdata("UserType")!="Parent") { ?>
						<input type="checkbox" class="check-kids" value="<?php echo $cobj->id; ?>" name="kids[]">
						<?php } ?>
						<a href="<?php echo base_url("dailyDiary/viewChildDiary")."?childid=".$cobj->id."&date=".$date; ?>"><?php echo $cobj->name; ?></a>
					</td>
					<?php if($columns->breakfast==1){ ?>
					<td>
						<?php 
							if (empty($cobj->breakfast->startTime)) {
						?>
						<button class="btn btn-outline-primary btn-small btn-add" data-toggle="modal" data-target="#foodModal" data-bgcolor="#FFECB3" data-title="Add Breakfast" data-type="BREAKFAST" data-childid="<?php echo $cobj->id; ?>"><span class="material-icons-outlined">add</span> Add</button>
						<?php
							} else {
								echo $cobj->breakfast->startTime;
							}
						?>
					</td>
					<?php } ?>
					<?php if($columns->morningtea==1){ ?>
					<td>
						<?php 
							if (empty($cobj->morningtea->startTime)) {
						?>
						<button class="btn btn-outline-primary btn-small btn-add" data-toggle="modal" data-target="#foodModal" data-bgcolor="#C0CCD9" data-title="Add Morning Tea" data-type="morningtea" data-childid="<?php echo $cobj->id; ?>"><span class="material-icons-outlined">add</span> Add</button>
						<?php
							} else {
								echo $cobj->morningtea->startTime;
							}
						?>
					</td>
					<?php } ?>
					<?php if($columns->lunch==1){ ?>
					<td>
						<?php 
							if (empty($cobj->lunch->startTime)) {
						?>
						<button class="btn btn-outline-primary btn-small btn-add" data-toggle="modal" data-target="#foodModal" data-bgcolor="#D0E2FD" data-title="Add Lunch" data-type="lunch" data-childid="<?php echo $cobj->id; ?>"><span class="material-icons-outlined">add</span> Add</button>
						<?php
							} else {
								echo $cobj->lunch->startTime;
							}
						?>
					</td>
					<?php } ?>
					<?php if($columns->sleep==1){ ?>
					<td>
						<?php 
							if (empty($cobj->sleep[0]->startTime)) {
						?>
						<button class="btn btn-outline-primary btn-small " data-toggle="modal" data-target="#sleepModal" data-bgcolor="#F5E18F" data-title="Add Sleep" data-type="sleep" data-childid="<?php echo $cobj->id; ?>"><span class="material-icons-outlined">add</span> Add</button>
						<?php
							} else {
								echo $cobj->sleep[0]->startTime;
							}
						?>
					</td>
					<?php } ?>
					<?php if($columns->afternoontea==1){ ?>
					<td>
						<?php 
							if (empty($cobj->afternoontea->startTime)) {
						?>
						<button class="btn btn-outline-primary btn-small btn-add" data-toggle="modal" data-target="#sunscreenModal" data-bgcolor="#F0CDFF" data-title="Add Afternoon Tea" data-type="afternoontea" data-childid="<?php echo $cobj->id; ?>"><span class="material-icons-outlined">add</span>  Add</button>
						<?php
							} else {
								echo $cobj->afternoontea->startTime;
							}
						?>
					</td>
					<?php } ?>
					<?php if($columns->latesnacks==1){ ?>
					<td>
						<?php 
							if (empty($cobj->snacks->startTime)) {
						?>
						<button class="btn btn-outline-primary btn-small btn-add" data-toggle="modal" data-target="#foodModal" data-bgcolor="#FEC093" data-title="Add Snacks" data-type="snack" data-childid="<?php echo $cobj->id; ?>"><span class="material-icons-outlined">add</span> Add</button>
						<?php
							} else {
								echo $cobj->snacks->startTime;
							}
						?>
					</td>
					<?php } ?>
					<?php if($columns->sunscreen==1){ ?>
					<td>
						<?php 
							if (empty($cobj->sunscreen[0]->startTime)) {
						?>
						<button class="btn btn-outline-primary btn-small btn-add" data-toggle="modal" data-target="#sunscreenModal" data-bgcolor="#E07F7F" data-title="Add Sunscreen" data-type="sunscreen" data-childid="<?php echo $cobj->id; ?>"><span class="material-icons-outlined">add</span> Add</button>
						<?php
							} else {
								echo $cobj->sunscreen[0]->startTime;
							}
						?>
					</td>
					<?php } ?>
					<?php if($columns->toileting==1){ ?>
					<td>
						<?php 
							if (empty($cobj->toileting->startTime)) {
						?>
						<button class="btn btn-outline-primary btn-small " data-toggle="modal" data-target="#toiletingModal" data-bgcolor="#D1FFCD" data-title="Add Toileting Info" data-type="toileting" data-childid="<?php echo $cobj->id; ?>"> <span class="material-icons-outlined">add</span> Add</button>
						<?php
							} else {
								echo $cobj->toileting->startTime;
							}
						?>
					</td>
					<?php } ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<table class="common-dd-tbl" width="100%">
			<thead>
				<tr>
				  <?php if($columns->breakfast==1){ ?>
						<th style="background-color: #FFECB3;"> Breakfast </th>
					<?php } ?>
					<?php if($columns->morningtea==1){ ?>
						<th style="background-color: #C0CCD9;"> Morning Tea </th>
					<?php } ?>
					<?php if($columns->lunch==1){ ?>
					<th style="background-color: rgba(19, 109, 246, 0.2);"> Lunch </th>
					<?php } ?>
					<?php if($columns->sleep==1){ ?>
					<th style="background-color: rgba(239, 206, 74, 0.62);"> Sleep </th>
					<?php } ?>
					<?php if($columns->afternoontea==1){ ?>
					<th style="background-color: #F0CDFF;"> Afternoon Tea </th>
					<?php } ?>
					<?php if($columns->latesnacks==1){ ?>
					<th style="background-color: #FEC093;"> Late Snacks </th>
					<?php } ?>
					<?php if($columns->sunscreen==1){ ?>
					<th style="background-color: #E07F7F;"> SunScreen </th>
					<?php } ?>
					<?php if($columns->toileting==1){ ?>
					<th style="background-color: #D1FFCD;"> Toileting </th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php if($columns->breakfast==1){ ?>
					<td>
						<button class="btn cmn-btn-add btn-outline-primary btn-small " data-toggle="modal" data-target="#foodModal" data-bgcolor="#FFECB3" data-title="Add Breakfast" data-type="BREAKFAST"><span class="material-icons-outlined">add</span> Add</button>
					</td>
					<?php } ?>
					<?php if($columns->morningtea==1){ ?>
					<td>
						<button class="btn cmn-btn-add btn-outline-primary btn-small " data-toggle="modal" data-target="#foodModal" data-bgcolor="#C0CCD9" data-title="Add Morning Tea" data-type="morningtea"><span class="material-icons-outlined">add</span> Add</button>
					</td>
					<?php } ?>
					<?php if($columns->lunch==1){ ?>
					<td>
						<button class="btn cmn-btn-add btn-outline-primary btn-small " data-toggle="modal" data-target="#foodModal" data-bgcolor="rgba(19, 109, 246, 0.2)" data-title="Add Lunch" data-type="lunch"><span class="material-icons-outlined">add</span> Add</button>
					</td>
					<?php } ?>
					<?php if($columns->sleep==1){ ?>
					<td>
						<button class="btn cmn-btn-add btn-outline-primary btn-small " data-toggle="modal" data-target="#sleepModal" data-bgcolor="rgba(239, 206, 74, 0.62)" data-title="Add Sleep" data-type="sleep"><span class="material-icons-outlined">add</span> Add</button>
					</td>
					<?php } ?>
					<?php if($columns->afternoontea==1){ ?>
					<td>
						<button class="btn cmn-btn-add btn-outline-primary btn-small " data-toggle="modal" data-target="#foodModal" data-bgcolor="#F0CDFF" data-title="Add Afternoon Tea" data-type="afternoontea"><span class="material-icons-outlined">add</span> Add</button>
					</td>
					<?php } ?>
					<?php if($columns->latesnacks==1){ ?>
					<td>
						<button class="btn cmn-btn-add btn-outline-primary btn-small " data-toggle="modal" data-target="#foodModal" data-bgcolor="#FEC093" data-title="Add Snacks" data-type="snack"><span class="material-icons-outlined">add</span> Add</button>
					</td>
					<?php } ?>
					<?php if($columns->sunscreen==1){ ?>
					<td>
						<button class="btn cmn-btn-add btn-outline-primary btn-small " data-toggle="modal" data-target="#sunscreenModal" data-bgcolor="#E07F7F" data-title="Add Sunscreen" data-type="sunscreen"><span class="material-icons-outlined">add</span> Add</button>
					</td>
					<?php } ?>
					<?php if($columns->toileting==1){ ?>
					<td>
						<button class="btn cmn-btn-add btn-outline-primary btn-small " data-toggle="modal" data-target="#toiletingModal" data-bgcolor="#D1FFCD" data-title="Add Toileting" data-type="toileting"><span class="material-icons-outlined">add</span> Add</button>
					</td>
					<?php } ?>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="foodModal" id="foodModal" style='height: auto ! important;width: auto ! important;'>
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    	<form action="" id="addDailyFoodRecord" method="post">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		<span aria-hidden="true">&times;</span>
	        	</button>
	        	<h4 class="modal-title" id="foodModalLabel">Title</h4>
	      	</div>
	      	<div class="modal-body">
	      		<div class="form-group">
	      			<label>Time</label>
	      			<br>
	      			<input type="number" min="1" max="12" value="1" name="hour" class="form-hour"> H : <input type="number" min="0" max="59" value="0" name="mins" class="form-mins"> M
	      		</div>
		        <div class="form-group">
		        	<label>Item</label>
		        	<select name="item" id="item" class="form-control modal-form-control">
		        	</select>
		        </div>
		        <div class="form-group">
		        	<label>Calories</label>
		        	<input type="text" name="calories" id="calories" class="form-control modal-form-control">
		        </div>
		        <div class="form-group">
		        	<label for="qty">Quantity</label>
		        	<input type="text" id="qty" name="qty" class="form-control modal-form-control">
		        </div>
		        <div class="form-group">
		        	<label for="comments">Comments</label>
		        	<textarea name="comments" class="form-control modal-form-control" id="comments" rows="4"></textarea>
		        </div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-info btn-small btn-default  btn-small pull-right">SAVE</button>
				</div>
	      	</div>
    	</form>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="sleepModal" id="sleepModal" style='height: auto ! important;width: auto ! important;'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form action="" id="addDailySleepRecord" method="post">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		<span aria-hidden="true">&times;</span>
	        	</button>
	        	<h4 class="modal-title" id="sleepModalLabel">Add Sleep Record</h4>
	      	</div>
	      	<div class="modal-body">
	      		<div class="form-group">
	      			<label>Time</label>
	      			<br>
	      			<input type="number" min="1" max="12" value="1" name="hour" class="form-hour from-hour"> H : <input type="number" min="0" max="59" value="00" name="mins" class="form-mins from-mins"> M to
	      			<input type="number" min="1" max="12" value="1" name="hour" class="form-hour to-hour"> H : <input type="number" min="0" max="59" value="00" name="mins" class="form-mins to-mins"> M
	      		</div>
		        <div class="form-group">
		        	<label for="comments">Comments</label>
		        	<textarea name="comments" class="form-control modal-form-control sl-comments" rows="4"></textarea>
		        </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="submit" class="btn btn-info btn-sm">SAVE</button>
	      	</div>
    	</form>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="toiletingModal" id="toiletingModal" style='height: auto ! important;width: auto ! important;'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form action="" id="addDailyToiletingRecord" method="post">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		<span aria-hidden="true">&times;</span>
	        	</button>
	        	<h4 class="modal-title" id="sleepModalLabel">Add Toileting Info</h4>
	      	</div>
	      	<div class="modal-body">
	      		<div class="form-group">
	      			<label>Time</label>
	      			<br>
	      			<input type="number" min="1" max="12" value="1" name="hour" class="form-hour form-hour-toilet"> H : <input type="number" min="0" max="59" value="00" name="mins" class="form-mins form-mins-toilet"> M 
	      		</div>
	      		<div class="form-group">
	      			<label for="nappy">Nappy</label>
	      			<input type="text" class="form-control modal-form-control" name="nappy" id="nappy">
	      		</div>
	      		<div class="form-group">
	      			<label for="potty">Potty</label>
	      			<input type="text" class="form-control modal-form-control" name="potty" id="potty">
	      		</div>
	      		<div class="form-group">
	      			<label for="toilet">Toilet</label>
	      			<input type="text" class="form-control modal-form-control" name="toilet" id="toilet">
	      		</div>
	      		<div class="form-group">
	      			<label for="signature">Signature</label>
	      			<input type="text" class="form-control modal-form-control" name="signature" id="signature">
	      		</div>
		        <div class="form-group">
		        	<label for="comments">Comments</label>
		        	<textarea name="comments" class="form-control modal-form-control tt-comments" rows="4"></textarea>
		        </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="submit" class="btn btn-info btn-sm">SAVE</button>
	      	</div>
    	</form>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="sunscreenModal" id="sunscreenModal" style='height: auto ! important;width: auto ! important;'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<form action="" id="addDailySunscreenRecord" method="post">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		<span aria-hidden="true">&times;</span>
	        	</button>
	        	<h4 class="modal-title" id="sunscreenModalLabel">Add Sunscreen Record</h4>
	      	</div>
	      	<div class="modal-body">
	      		<div class="form-group">
	      			<label>Time</label>
	      			<br>
	      			<input type="number" min="1" max="12" value="1" name="hour" class="form-hour form-hour-ss"> H : <input type="number" min="0" max="59" value="00" name="mins" class="form-mins form-mins-ss"> M 
	      		</div>
		        <div class="form-group">
		        	<label for="comments">Comments</label>
		        	<textarea name="comments" class="form-control modal-form-control ss-comments" rows="4"></textarea>
		        </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="submit" class="btn btn-info btn-sm">SAVE</button>
	      	</div>
    	</form>
    </div>
  </div>
</div>

<?php $this->load->view('footer'); ?>

<script>
	$(document).ready(function(){
		//when add button clicked for food 
		$(document).on("click",".btn-add",function(){
			var title = $(this).data("title");
			var bgcolor = $(this).data("bgcolor");
			var type = $(this).data("type");
			var childid = $(this).data("childid");
			$("#foodModal").find(".modal-body").append('<input type="hidden" class="childid" name="childids[]" value="'+childid+'">');
			$("#foodModal").find(".modal-body").append('<input type="hidden" class="type" name="type" value="'+type+'">');
			$(".modal-header").css({"background":bgcolor,"color":"#000000"});
			$(".modal-title").text(title);
			if(type!=""){
				$('#item').select2({
					ajax: { 
					    url: "<?php echo base_url(); ?>dailyDiary/getItems/"+type,
					    type: "post",
					    dataType: 'json',
					    delay: 250,
					    data: function (params) {
					        return {
					      		searchTerm: params.term // search term
					    	};
					   	},
					    processResults: function (response) {
					     	return {
					        	results: response
					     	};
					   	},
					   	cache: true
					},
					dropdownParent: $('#foodModal .modal-content')
				});
			}
		});

		//for submitting food modal
		$(document).on("submit","#addDailyFoodRecord",function(e){
			e.preventDefault();
			var hour = $(".form-hour").val();
			var mins = $(".form-mins").val();
			var startTime = hour+"h:"+mins+"m";
			var childids = [];
	        $("input[name='childids[]']").each(function(){
	            childids.push(this.value);
	        });
			var item = $("#item").val();
			var qty = $("#qty").val();
			var comments = $("#comments").val();
			var calories = $("#calories").val();
			var today = new Date();
			var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
			var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
			var createdAt = date+' '+time;
			var type = $(".type").val();
			$.ajax({
			    traditional:true,
			    type: "POST",
			    url: "<?php echo base_url().'dailyDiary/addFoodRecord'; ?>",
			    beforeSend: function(request) {
			      request.setRequestHeader("x-device-id", "<?php echo $this->session->userdata('x-device-id');?>");
			      request.setRequestHeader("x-token", "<?php echo $this->session->userdata('AuthToken');?>");
			    },
			    data: {"userid":<?php echo $this->session->userdata('LoginId');?>,'startTime':startTime,'item':item,'qty':qty,'comments':comments,'createdAt':createdAt,'childid':JSON.stringify(childids),'type':type,'calories':calories},
			    success: function(msg){
			      var res = jQuery.parseJSON(msg);
			      if (res.Status == "SUCCESS") {
				    window.location.reload();
			      } else {
			      	alert(res.Message);
			      }
			    }
			});
		});

		//for submitting sleep modal
		$(document).on("submit","#addDailySleepRecord",function(e){
			e.preventDefault();
			var hour = $(".from-hour").val();
			var mins = $(".from-mins").val();
			var startTime = hour+"h:"+mins+"m";

			var endhour = $(".to-hour").val();
			var endmins = $(".to-mins").val();
			var endTime = endhour+"h:"+endmins+"m";

			var childids = [];
	        $("input[name='childids[]']").each(function(){
	            childids.push(this.value);
	        });
			var comments = $(".sl-comments").val();
			var today = new Date();
			var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
			var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
			var createdAt = date+' '+time;
			$.ajax({
			    traditional:true,
			    type: "POST",
			    url: "<?= base_url().'dailyDiary/addSleepRecord'; ?>",
			    data: {"userid":<?php echo $this->session->userdata('LoginId');?>,'startTime':startTime,'endTime':endTime,'comments':comments,'createdAt':createdAt,'childid':JSON.stringify(childids)},
			    success: function(msg){
			      var res = jQuery.parseJSON(msg);
			      if (res.Status == "SUCCESS") {
					    window.location.reload();
			      } else {
			      	alert(res.Message);
			      }
			    }
			});
		});

		//for submitting toileting modal
		$(document).on("submit","#addDailyToiletingRecord",function(e){
			e.preventDefault();
			var hour = $(".form-hour-toilet").val();
			var mins = $(".form-mins-toilet").val();
			var startTime = hour+"h:"+mins+"m";
			var nappy = $("#nappy").val();
			var potty = $("#potty").val();
			var toilet = $("#toilet").val();
			var signature = $("#signature").val();
			var childids = [];
	        $("input[name='childids[]']").each(function(){
	            childids.push(this.value);
	        });
			var comments = $(".tt-comments").val();
			var today = new Date();
			var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
			var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
			var createdAt = date+' '+time;
			$.ajax({
			    traditional:true,
			    type: "POST",
			    url: "<?php echo base_url().'dailyDiary/addToiletingRecord'; ?>",
			    beforeSend: function(request) {
			      request.setRequestHeader("x-device-id", "<?php echo $this->session->userdata('x-device-id');?>");
			      request.setRequestHeader("x-token", "<?php echo $this->session->userdata('AuthToken');?>");
			    },
			    data: {"userid":<?php echo $this->session->userdata('LoginId');?>,'startTime':startTime,'nappy':nappy,'comments':comments,'signature':signature,'potty':potty,'toilet':toilet,'createdAt':createdAt,'childid':JSON.stringify(childids)},
			    success: function(msg){
			      var res = jQuery.parseJSON(msg);
			      if (res.Status == "SUCCESS") {
				    window.location.reload();
			      } else {
			      	alert(res.Message);
			      }
			    }
			});
		});

		//for submitting sunscreen modal
		$(document).on("submit","#addDailySunscreenRecord",function(e){
			e.preventDefault();
			var hour = $(".form-hour-ss").val();
			var mins = $(".form-mins-ss").val();
			var startTime = hour+"h:"+mins+"m";
			var childids = [];
			$("input[name='childids[]']").each(function(){
				childids.push(this.value);
			});
			var comments = $(".ss-comments").val();
			var today = new Date();
			var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
			var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
			var createdAt = date+' '+time;
			$.ajax({
			    traditional:true,
			    type: "POST",
			    url: "<?php echo base_url().'dailyDiary/addSunscreenRecord'; ?>",
			    data: {"userid":<?php echo $this->session->userdata('LoginId');?>,'startTime':startTime,'comments':comments,'createdAt':createdAt,'childid':JSON.stringify(childids)},
			    success: function(msg){
			      var res = jQuery.parseJSON(msg);
			      if (res.Status == "SUCCESS") {
				    window.location.reload();
			      } else {
			      	alert(res.Message);
			      }
			    }
			});
		});

		//select all kids
		$(document).on('click','#checkAllStudents', function(){
			if($(this).prop('checked') == true) {
				$('.check-kids').prop("checked",true);
				$(".common-dd-tbl").css("display","table");
			} else {
				$('.check-kids').prop('checked', false);
				$(".common-dd-tbl").css("display","none");
			}
		});

		$(document).on('click','.check-kids',function() {
		    var checkboxes = $('.check-kids:checkbox:checked').length;
		    var totalKids = $('.check-kids:checkbox').length;
		    if(checkboxes>1) {
		    	$(".common-dd-tbl").css("display","table");
		    	if(totalKids==checkboxes){
		    		$('#checkAllStudents').prop('checked',true);
		    	}else{
		    		$('#checkAllStudents').prop('checked',false);
		    	}
		    } else {
		    	$(".common-dd-tbl").css("display","none");
		    }
		});

		$(document).on('click','.cmn-btn-add',function(){
			var type = $(this).data("type");
			var bgcolor = $(this).data("bgcolor");
			var title = $(this).data("title");

			$(".modal-header").css({"background":bgcolor,"color":"#000000"});
			$(".modal-title").text(title);

			if(type=="BREAKFAST" || type=="morningtea" || type=="lunch" || type=="afternoontea" || type=="snack") {
				var modalName = "#addDailyFoodRecord";
				var modalId = "#foodModal";
				$(modalName).find(".modal-body").append('<input type="hidden" class="type" name="type" value="'+type+'">');
			}else if (type=="sunscreen") {
				var modalName = "#addDailySunscreenRecord";
				var modalId = "#sunscreenModal";
				$(modalName).find(".modal-body").append('<input type="hidden" class="type" name="type" value="'+type+'">');
			}else if (type=="sleep") {
				var modalName = "#addDailySleepRecord";
				var modalId = "#sleepModal";
				$(modalName).find(".modal-body").append('<input type="hidden" class="type" name="type" value="'+type+'">');
			}else{
				var modalName = "#addDailyToiletingRecord";
				var modalId = "#toiletingModal";
				$(modalName).find(".modal-body").append('<input type="hidden" class="type" name="type" value="'+type+'">');
			}

			$('input[name="kids[]"]:checked').each(function() {
			  	$(modalName).find(".modal-body").append('<input type="hidden" class="childid" name="childids[]" value="'+this.value+'">');
			});
			
			if(type=="BREAKFAST" || type=="morningtea" || type=="lunch" || type=="afternoontea" || type=="snack"){
				$('#item').select2({
					ajax: { 
					    url: "<?php echo base_url(); ?>dailyDiary/getItems/"+type,
					    type: "post",
					    dataType: 'json',
					    delay: 250,
					    data: function (params) {
					        return {
					      		searchTerm: params.term // search term
					    	};
					   	},
					    processResults: function (response) {
					     	return {
					        	results: response
					     	};
					   	},
					   	cache: true
					},
					dropdownParent: $(modalId+' .modal-content')
				});
			}
		});

		$(document).on('change','#centerId',function(){
			var centerId = $(this).val();
			$.ajax({
				traditional: true,
				url: "<?php echo base_url("DailyDiary/getCenterRooms")?>",
				type: "POST",
			    beforeSend: function(request) {
			      request.setRequestHeader("x-device-Id", "");
			      request.setRequestHeader("x-token", "609ca994bf421");
			    },
			    data: {"userid":3, 'centerId':centerId},
			    success: function(msg){
			    	$("#roomid").html("");
					var res = jQuery.parseJSON(msg);
					// console.log(res.Rooms[0].id);
					$("#roomid").append('<option>-- Select Room --</option>');
					for (loop=0; loop < res.Rooms.length; loop++) {
				     	$("#roomid").append('<option value="'+ res.Rooms[loop].id +'">'+ res.Rooms[loop].name +'</option>');
					}
				}
			});
		});

		$(document).on('change','#roomid',function(){
			$('#dailyDiary').submit();
		});

		$(document).on('change','#txtCalendar',function(){
			$('#dailyDiary').submit();
		});
	});


	// $(document).ready(function(){
	// 	$('#foodModal,#sleepModal,#sunscreenModal,#toiletingModal').draggable({
	// 		handle: ".modal-header"
	// 	});
	// });
</script>