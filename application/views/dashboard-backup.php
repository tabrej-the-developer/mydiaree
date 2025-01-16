<?php
	$data['name']='Dashboard'; 
	$this->load->view('header',$data); 
?>

<style>
	#share-src-wrapper{
		display: none;
	}
</style>
<div class="container">
	<div class="row">
		<div class="col-sm-9">
			<div class="row">
				<div class="col-sm-4">
					<div class="data-panel">
						<div class="data-img">
							<img src="<?php echo base_url('assets/images/d-room.png'); ?>" alt="">
						</div>
						<div class="data-text">
							<?php 
								$userType = $this->session->userdata("UserType");
								if ($userType=="Parent") {
							?>
							<a href="<?php echo base_url("Observation"); ?>">
								<div class="data-title">
									Observation <span class="pull-right"><?php echo $observationCount; ?></span>
								</div>
							</a>
							<?php
								} else {
							?>
							<a href="<?php echo base_url("Room"); ?>">
								<div class="data-title">
									Rooms <span class="pull-right"><?php echo $roomsCount; ?></span>
								</div>
							</a>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="data-panel">
						<div class="data-img">
							<img src="<?php echo base_url('assets/images/d-students.png'); ?>" alt="">
						</div>
						<div class="data-text">
							<?php
								if ($userType=="Parent") {
							?>
							<a href="<?php echo base_url("Room"); ?>">
								<div class="data-title">
									Children <span class="pull-right"><?php echo $childrenCount; ?></span>
								</div>
							</a>
							<?php
								} else {
							?>
							<a href="<?php echo base_url("Room"); ?>">
								<div class="data-title">
									Students <span class="pull-right"><?php echo $childrenCount; ?></span>
								</div>
							</a>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="data-panel">
						<div class="data-img">
							<img src="<?php echo base_url('assets/images/d-analytics.png'); ?>" alt="">
						</div>
						<div class="data-text">
							<?php
								if ($userType=="Parent") {
							?>
							<a href="<?php echo base_url("announcements"); ?>">
								<div class="data-title">
									Events <span class="pull-right"><?php echo $eventsCount; ?></span>
								</div>
							</a>
							<?php
								} else {
							?>
							<a href="<?php echo base_url("Settings/userSettings"); ?>">
								<div class="data-title">
									Staffs <span class="pull-right"><?php echo $staffCount; ?></span>
								</div>
							</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="bg-white" style="padding: 25px; margin: 20px;box-shadow: 0px 0px 10px rgba(34, 110, 153, 0.1);border-radius: 4px;">
						<div id="calendar"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="row">
				<div class="col-sm-12 text-center">
					<object data="https://www.sunsmart.com.au/uvalert/default.asp?version=australia&locationid=161" height="300" id="sunsmart">
					    <embed src="https://www.sunsmart.com.au/uvalert/default.asp?version=australia&locationid=161" height="300"> </embed>
					    Error: Embedded data could not be displayed.
					</object>
				</div>
				<?php if ($userType!="Parent") { ?>
				<div class="col-sm-12">
					<div class="data-panel">
						<div class="data-img">
							<img src="<?php echo base_url('assets/images/d-upcomingEvents.png'); ?>" alt="">
						</div>
						<a href="<?php echo base_url("Observation"); ?>">
							<div class="data-text">
								<div class="data-title">Observations <span class="pull-right"><?php echo $observationCount; ?></span></div>
							</div>
						</a>
					</div>
				</div>
				<?php } ?>
				<div class="col-sm-12">
					<div class="data-panel">
						<div class="data-img">
							<img src="<?php echo base_url('assets/images/d-previousEvents.png'); ?>" alt="">
						</div>
						<div class="data-text">
							<?php if ($userType=="Parent") { ?>
							<div class="data-title">Upcoming Events <span class="pull-right"><?php echo $upcomingEventsCount; ?></span></div>
							<?php
								} else {
							?>
							<a href="<?php echo base_url("announcements"); ?>">
								<div class="data-title">
									Events <span class="pull-right"><?php echo $eventsCount; ?></span>
								</div>
							</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		$('#sunsmart').ready(function(){
			// $(this).contents().find('html').html();
			// console.log();
		});

		//Date for the calendar events
		var date = new Date()
	    var d    = date.getDate(),
	        m    = date.getMonth(),
	        y    = date.getFullYear()

	    $('#calendar').fullCalendar({
		    header    : {
		        left  : '',
		        center: 'title',
		        right : 'prev,next'
		    },
		    buttonText: {
		        today: 'today',
		        month: 'month',
		        week : 'week',
		        day  : 'day'
		    },
		      //Random default events
		    events    : <?php echo json_encode($calendar); ?>
    	});
	});
</script>