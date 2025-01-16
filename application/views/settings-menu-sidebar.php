<?php $role = $this->session->userdata("UserType"); ?>
<ul class="list-unstyled">
	<?php if($role=="Staff"){ ?>
	<li class="settings-list-item"><a href="<?php echo base_url("Settings/resetPin"); ?>">Reset PIN</a></li>
	<?php }else{ ?>
	<li class="settings-list-item"><a href="<?php echo base_url("Settings/resetPassword"); ?>">Reset Password</a></li>
	<?php } ?>
	
	<li class="settings-list-item"><a href="<?php echo base_url("Settings/changeEmailId"); ?>">Change Email</a></li>
	<?php if($this->session->userdata("UserType")!="Parent"){ ?>
	<li class="settings-list-item"><a href="<?php echo base_url("Settings/moduleSettings"); ?>">Module Settings</a></li>
	<li class="settings-list-item"><a href="<?php echo base_url("Settings/userSettings"); ?>">User Settings</a></li>
	<li class="settings-list-item"><a href="<?php echo base_url("Settings/centerSettings"); ?>">Center Settings</a></li>
	<li class="settings-list-item"><a href="<?php echo base_url("Settings/parentSettings"); ?>">Parent Settings</a></li>
	<li class="settings-list-item"><a href="<?php echo base_url("Settings/childGroups"); ?>">Child Groups</a></li>
	<!-- <li class="settings-list-item"><a href="<?php echo base_url("Settings/history"); ?>">History</a></li> -->
	<li class="settings-list-item"><a href="<?php echo base_url("Settings/managePermissions"); ?>">Manage Permissions</a></li>
	<?php if ($role=="Superadmin") { ?>
	<li class="settings-list-item">
		<a href="<?php echo base_url("Settings/applicationSettings"); ?>">Application Settings</a>
	</li>
	<li class="settings-list-item">
		<a href="<?php echo base_url("Settings/noticePeriodSettings"); ?>">customize observation period</a>
	</li>
	<li class="settings-list-item">
		<a href="<?php echo base_url("Settings/assessment"); ?>">Assessment</a>
	</li>
	<?php } ?>
	<li class="settings-list-item">
		<a href="<?php echo base_url("Settings/themeSettings"); ?>">Theme Settings</a>
	</li>
	<!-- <li class="settings-list-item"><a href="<?php #echo base_url("Settings/modulesAndSubmodules"); ?>">Modules & Sub-Modules</a></li> -->
	<!-- <li class="settings-list-item"><a href="<?php #echo base_url("Settings/assessmentSettings"); ?>">Assessment Settings</a></li> -->
	<!-- <li class="settings-list-item"><a href="<?php #echo base_url("Settings/summativeAssessmentSettings"); ?>">Summative Assessment Settings</a></li> -->
	<?php } ?>
</ul>