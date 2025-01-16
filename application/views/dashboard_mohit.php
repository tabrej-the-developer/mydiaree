<?php
	$data['name']='Dashboard'; 
	$this->load->view('header',$data); 
?>
<br>
<div class="container-fluid"> 	
	<div class="dashboardContainer">
		<div class="leftDataPanel">
			<div class="totalLeftDataPanelBlock">
				<div class="dataPanelBlock">
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
				<div class="dataPanelBlock">
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
				<div class="dataPanelBlock">
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
			<div class="bg-white calendarView" >
				<div id="calendar"></div>
			</div>
		</div>
		<div class="rightDataPanel">
			<div class="weatherPanel">
				<object data="https://www.sunsmart.com.au/uvalert/default.asp?version=australia&locationid=161" height="300" id="sunsmart">
					<embed src="https://www.sunsmart.com.au/uvalert/default.asp?version=australia&locationid=161" height="300"> </embed>
					Error: Embedded data could not be displayed.
				</object>
			</div>
			<div class="totalRightDataPanelBlock">
				<div class="dataPanelBlock">
					<div class="data-img">
						<img src="<?php echo base_url('assets/images/d-upcomingEvents.png'); ?>" alt="">
					</div>
					<div class="data-text">
						<a href="<?php echo base_url("Observation"); ?>">
							<div class="data-text">
								<div class="data-title">Observations <span class="pull-right"><?php echo $observationCount; ?></span></div>
							</div>
						</a>
					</div>
				</div>
				<div class="dataPanelBlock">
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