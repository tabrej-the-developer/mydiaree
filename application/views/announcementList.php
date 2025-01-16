<?php
	$data['name']='Announcements'; 
	$this->load->view('header',$data); 
	$role = $this->session->userdata("UserType");
	if ($role == "Superadmin") {
		$show = 1;
		$add = 1;
	} else {
		if ($role=="Staff") {
			if (isset($row->permissions->addAnnouncement)) {
				if ($row->permissions->addAnnouncement==1) {
					$add = 1;
				} else {
					$add = 0;
				}
				if ($row->permissions->viewAllAnnouncement==1) {
					$show = 1;
				} else {
					$show = 0;
				}
			} else {
				$show = 0;
				$add = 0;
			}
		}else{
			$show = 1;
			$add = 0;
		}
	}
	
?>


<div class="container">	
	<div class="pageHead">
		<h1>Announcements</h1>
		<div class="headerForm">
			<?php if ($add==1) { ?>
				<form action="" method="get" id="centerDropdown">
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
				</form>
				<a href="<?php echo base_url('announcements/add'); ?>" id='create-new' class="btn btn-default btnBlue btn-small pull-right">
				<span class="material-icons-outlined">add</span> Create Announcement
				</a>
			<?php }else{ ?>
				<form action="" method="get" id="centerDropdown">
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
				</form>
			<?php } ?>
		</div>
	</div>
	<div class="annoucementFull" >
		<table id="datatable" class="ui celled table" style="width:100%">
	        <thead>
	            <tr>
	                <th>Title</th>
	                <th>Created by</th>
	                <th>Date & Time</th>
	                <th>Status</th>
	            </tr>
	        </thead>
	        <tbody>
	        	<?php 
	        	if ($show==1) {
	        		foreach ($row->records as $key => $value) {
				?>
				<tr>
					<td><a href='<?php echo base_url()."announcements/updateAnnouncements/$userid/$value->id"; ?>'><?php echo $value->title;?></a></td>
					<td><?php echo Ucfirst($value->createdBy);?></td>
					<td><?php echo date('d-m-Y',strtotime($value->eventDate));?></td>
					<td>
						<?php 
							if($value->status=="Sent"){
								echo '<span class="label label-success">Sent</span>';
							}else if ($value->status=="Pending") {
								echo '<span class="label label-warning">Pending</span>';
							} else {
								echo '<span class="label label-danger">Unknown</span>';
							}
						?>
					</td>
				</tr>
				<?php } } ?>
	        </tbody>
	    </table>
	</div>
</div>
<?php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		$("#centerId").on('change',function(){
			$("#centerDropdown").submit();
		});

		$("#create-new").on('click',  function(e) {
			e.preventDefault();
			var _link = $(this).prop('href');
			var _centerid = $("#centerId").val();
			var _url = _link + "?centerid=" + _centerid;
			window.location.href = _url;
		});
	});
</script>