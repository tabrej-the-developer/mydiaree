<!-- <div class="contact contact-rounded contact-bordered contact-lg contact-ps-controls" style="">
	<img src="<?php echo base_url('/api/assets/media/depositphotos_17140201-stock-photo-group-of-pupils.jpg'); ?>"  alt="Logo">
</div> -->
<ul class="app-header-buttons">
	<li class="logoMenu" style="display: none;"><img src="<?php echo base_url('/assets/images/Mykronicle-logo-white.png'); ?>"></li>
	<li class="visible-mobile"><a href="#" class="deskMenuIcon" data-sidebar-toggle=".app-sidebar.dir-left"><span class="material-icons-outlined">menu</span></a></li>
	<li class="hidden-mobile"><a href="#" class="" data-sidebar-minimize=".app-sidebar.dir-left"><span class="material-icons-outlined">menu</span></a></li>
</ul>
<nav class="leftMenu">
	<ul>
		<li>
			<a href="<?php echo base_url('dashboard'); ?>" class="menu">
				<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10 19v-5h4v5c0 .55.45 1 1 1h3c.55 0 1-.45 1-1v-7h1.7c.46 0 .68-.57.33-.87L12.67 3.6c-.38-.34-.96-.34-1.34 0l-8.36 7.53c-.34.3-.13.87.33.87H5v7c0 .55.45 1 1 1h3c.55 0 1-.45 1-1z"/></svg>
				<!-- <img src="<?php // echo base_url('assets/images/icons/home.svg'); ?>" alt="home">--> 
				Home 
			</a>
		</li>
		<li>
			<a href="<?php echo base_url('observation'); ?>" class="menu">
				<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M18 15v4c0 .55-.45 1-1 1H5c-.55 0-1-.45-1-1V7c0-.55.45-1 1-1h3.02c.55 0 1-.45 1-1s-.45-1-1-1H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-5c0-.55-.45-1-1-1s-1 .45-1 1zm-2.5 3H6.52c-.42 0-.65-.48-.39-.81l1.74-2.23c.2-.25.58-.26.78-.01l1.56 1.88 2.35-3.02c.2-.26.6-.26.79.01l2.55 3.39c.25.32.01.79-.4.79zm3.8-9.11c.48-.77.75-1.67.69-2.66-.13-2.15-1.84-3.97-3.97-4.2C13.3 1.73 11 3.84 11 6.5c0 2.49 2.01 4.5 4.49 4.5.88 0 1.7-.26 2.39-.7l2.41 2.41c.39.39 1.03.39 1.42 0 .39-.39.39-1.03 0-1.42l-2.41-2.4zM15.5 9C14.12 9 13 7.88 13 6.5S14.12 4 15.5 4 18 5.12 18 6.5 16.88 9 15.5 9z"/></svg>
				<!-- <span class="fa fa-bar-chart"></span> -->
				Observation
			</a>
		</li>
		<?php if($this->session->userdata("UserType")!="Parent"){ ?>
			<li>
			<a href="#" class="menu">
			<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><g><rect fill="none" height="24" width="24"/><rect fill="none" height="24" width="24"/></g><g><g><path d="M21,8c-1.45,0-2.26,1.44-1.93,2.51l-3.55,3.56c-0.3-0.09-0.74-0.09-1.04,0l-2.55-2.55C12.27,10.45,11.46,9,10,9 c-1.45,0-2.27,1.44-1.93,2.52l-4.56,4.55C2.44,15.74,1,16.55,1,18c0,1.1,0.9,2,2,2c1.45,0,2.26-1.44,1.93-2.51l4.55-4.56 c0.3,0.09,0.74,0.09,1.04,0l2.55,2.55C12.73,16.55,13.54,18,15,18c1.45,0,2.27-1.44,1.93-2.52l3.56-3.55 C21.56,12.26,23,11.45,23,10C23,8.9,22.1,8,21,8z"/><polygon points="15,9 15.94,6.93 18,6 15.94,5.07 15,3 14.08,5.07 12,6 14.08,6.93"/><polygon points="3.5,11 4,9 6,8.5 4,8 3.5,6 3,8 1,8.5 3,9"/></g></g></svg>
				<!-- <img src="<?php // echo base_url('assets/images/icons/octicon_graph.png'); ?>" > -->
				QIP
			</a>
			
			<ul>
				<li>
					<a href="<?php echo base_url('selfassessment'); ?>">Self Assessment</a>
				</li>
				<li>
					<a href="<?php echo base_url('qip'); ?>">Quality Improvement Plan</a>
				</li>
			</ul>
		</li>
		<?php } ?>
		<?php if($this->session->userdata("UserType")!="Parent"){ ?>
        <li>
        	<a href="<?php echo base_url('room'); ?>" class="menu">
			<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><g><g><path d="M0,0h24v24H0V0z" fill="none"/></g></g><g><g><g><path d="M20,19h-1V5c0-0.55-0.45-1-1-1h-4c0-0.55-0.45-1-1-1H6C5.45,3,5,3.45,5,4v15H4c-0.55,0-1,0.45-1,1s0.45,1,1,1h9 c0.55,0,1-0.45,1-1V6h3v14c0,0.55,0.45,1,1,1h2c0.55,0,1-0.45,1-1S20.55,19,20,19z M11,13L11,13c-0.55,0-1-0.45-1-1v0 c0-0.55,0.45-1,1-1h0c0.55,0,1,0.45,1,1v0C12,12.55,11.55,13,11,13z"/></g></g></g></svg>
        		<!-- <span class="fa fa-bar-chart"></span> -->
				Rooms
        	</a>
        </li>
        <?php } ?>
        <?php if($this->session->userdata("UserType")!="Parent"){ ?>
		<li>
			<a href="<?php echo base_url('lessonPlanList/programPlanList'); ?>" class="menu">
				<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
				<!-- <span class="fa fa-bar-chart"></span> -->
				Program Plan
			</a>
		</li>
		<li>
			<a href="<?php echo base_url('ServiceDetails'); ?>" class="menu">
				<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M14.65 4.98l-5-1.75c-.42-.15-.88-.15-1.3-.01L4.36 4.56C3.55 4.84 3 5.6 3 6.46v11.85c0 1.41 1.41 2.37 2.72 1.86l2.93-1.14c.22-.09.47-.09.69-.01l5 1.75c.42.15.88.15 1.3.01l3.99-1.34c.81-.27 1.36-1.04 1.36-1.9V5.69c0-1.41-1.41-2.37-2.72-1.86l-2.93 1.14c-.22.08-.46.09-.69.01zM15 18.89l-6-2.11V5.11l6 2.11v11.67z"/></svg>
				<!-- <span class="fa fa-bar-chart"></span> -->
				Service Details
			</a>
		</li>
		<?php } ?>

		
		<li>
			<a href="<?php echo base_url('Media'); ?>" class="menu">
				<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M2 6H0v5h.01L0 20c0 1.1.9 2 2 2h18v-2H2V6zm5 9h14l-3.5-4.5-2.5 3.01L11.5 9zM22 4h-8l-2-2H6c-1.1 0-1.99.9-1.99 2L4 16c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 12H6V4h5.17l1.41 1.41.59.59H22v10z"/></svg>
				Media
			</a>
		</li>
		<li>
			<a href="#" class="menu">
				<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><g><rect fill="none" height="24" width="24"/></g><path d="M18,12L18,12c0,0.55,0.45,1,1,1h2c0.55,0,1-0.45,1-1v0c0-0.55-0.45-1-1-1h-2C18.45,11,18,11.45,18,12z"/><path d="M16.59,16.82c-0.33,0.44-0.24,1.05,0.2,1.37c0.53,0.39,1.09,0.81,1.62,1.21c0.44,0.33,1.06,0.24,1.38-0.2 c0-0.01,0.01-0.01,0.01-0.02c0.33-0.44,0.24-1.06-0.2-1.38c-0.53-0.4-1.09-0.82-1.61-1.21c-0.44-0.33-1.06-0.23-1.39,0.21 C16.6,16.81,16.59,16.82,16.59,16.82z"/><path d="M19.81,4.81c0-0.01-0.01-0.01-0.01-0.02c-0.33-0.44-0.95-0.53-1.38-0.2c-0.53,0.4-1.1,0.82-1.62,1.22 c-0.44,0.33-0.52,0.95-0.19,1.38c0,0.01,0.01,0.01,0.01,0.02c0.33,0.44,0.94,0.53,1.38,0.2c0.53-0.39,1.09-0.82,1.62-1.22 C20.05,5.87,20.13,5.25,19.81,4.81z"/><path d="M8,9H4c-1.1,0-2,0.9-2,2v2c0,1.1,0.9,2,2,2h1v3c0,0.55,0.45,1,1,1h0c0.55,0,1-0.45,1-1v-3h1l5,3V6L8,9z"/><path d="M15.5,12c0-1.33-0.58-2.53-1.5-3.35v6.69C14.92,14.53,15.5,13.33,15.5,12z"/></svg>
				<!-- <img src="<?php // echo base_url('assets/images/icons/announcements.png'); ?>" > -->
				Announcements
			</a>
			<ul>
				<?php if($this->session->userdata("UserType")!="Parent"){ ?>
				<li>
					<a href="<?php echo base_url('announcements'); ?>">Announcements</a>
				</li>
				<?php } ?>
				<li>
					<a href="<?php echo base_url('surveys'); ?>">Survey</a>
				</li>
			</ul>
		</li>

		<li>
			<a href="#" class="menu">
				<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16 6v6c0 1.1.9 2 2 2h1v7c0 .55.45 1 1 1s1-.45 1-1V3.13c0-.65-.61-1.13-1.24-.98C17.6 2.68 16 4.51 16 6zm-5 3H9V3c0-.55-.45-1-1-1s-1 .45-1 1v6H5V3c0-.55-.45-1-1-1s-1 .45-1 1v6c0 2.21 1.79 4 4 4v8c0 .55.45 1 1 1s1-.45 1-1v-8c2.21 0 4-1.79 4-4V3c0-.55-.45-1-1-1s-1 .45-1 1v6z"/></svg>
				<!-- <img src="<?php // echo base_url('assets/images/icons/food.svg'); ?>" > -->
				Healthy Eating
			</a>
			<ul>
				<li>
					<a href="<?php echo base_url('menu'); ?>">Menu</a>
				</li>
				<?php if($this->session->userdata("UserType")!="Parent"){ ?>
				<li>
					<a href="<?php echo base_url('recipe'); ?>">Recipe</a>
				</li>
				<?php } ?>
			</ul>
		</li>
		<?php if($this->session->userdata("UserType")!="Parent"){ ?>
		<li>
			<a href="<?php echo base_url('resources'); ?>" class="menu">
				<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><path d="M18 4l1.82 3.64c.08.16-.04.36-.22.36h-1.98c-.38 0-.73-.21-.89-.55L15 4h-2l1.82 3.64c.08.16-.04.36-.22.36h-1.98c-.38 0-.73-.21-.89-.55L10 4H8l1.82 3.64c.08.16-.04.36-.22.36H7.62c-.38 0-.73-.21-.9-.55L5 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V5c0-.55-.45-1-1-1h-3z"/></svg>
				<!-- <span class="fa fa-bar-chart"></span> -->
				Resources
			</a>
		</li>
		<?php } ?>
		<li>
			<a href="#" class="menu">
				<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><g><rect fill="none" height="24" width="24" x="0"/></g><g><path d="M18.15,1.35l-4,4C14.05,5.45,14,5.57,14,5.71v8.17c0,0.43,0.51,0.66,0.83,0.37l4-3.6c0.11-0.09,0.17-0.23,0.17-0.37V1.71 C19,1.26,18.46,1.04,18.15,1.35z M22.47,5.2C22,4.96,21.51,4.76,21,4.59v12.03C19.86,16.21,18.69,16,17.5,16 c-1.9,0-3.78,0.54-5.5,1.58V5.48C10.38,4.55,8.51,4,6.5,4C4.71,4,3.02,4.44,1.53,5.2C1.2,5.36,1,5.71,1,6.08v12.08 c0,0.76,0.81,1.23,1.48,0.87C3.69,18.4,5.05,18,6.5,18c2.07,0,3.98,0.82,5.5,2c1.52-1.18,3.43-2,5.5-2c1.45,0,2.81,0.4,4.02,1.04 C22.19,19.4,23,18.93,23,18.17V6.08C23,5.71,22.8,5.36,22.47,5.2z"/></g></svg>
				<!-- <img src="<?php //echo base_url('assets/images/icons/daily-diary.svg'); ?>" >  -->
				Daily Journal
			</a>
			<ul>
				<li>
					<a href="<?php echo base_url('dailyDiary'); ?>"> Daily Diary</a>
				</li>
				<?php if($this->session->userdata("UserType")!="Parent"){ ?>
				<li>
					<a href="<?php echo base_url('headChecks'); ?>">Head Checks</a>
				</li>
				<li>
					<a href="<?php echo base_url('accident'); ?>">Accidents</a>
				</li>
				<?php } ?>
			</ul>
		</li>
		<li>
			<a href="#" class="menu">
			<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#ffffff"><rect fill="none" height="24" width="24"/><path d="M18.6,19.5H21v2h-6v-6h2v2.73c1.83-1.47,3-3.71,3-6.23c0-4.07-3.06-7.44-7-7.93V2.05c5.05,0.5,9,4.76,9,9.95 C22,14.99,20.68,17.67,18.6,19.5z M4,12c0-2.52,1.17-4.77,3-6.23V8.5h2v-6H3v2h2.4C3.32,6.33,2,9.01,2,12c0,5.19,3.95,9.45,9,9.95 v-2.02C7.06,19.44,4,16.07,4,12z M16.24,8.11l-5.66,5.66l-2.83-2.83l-1.41,1.41l4.24,4.24l7.07-7.07L16.24,8.11z"/></svg>
				Lesson & Progress Plan
			</a>
			<ul>
				<li>
					<a href="<?php echo base_url('progressplan'); ?>"> Record Montessori Progress</a>
				</li>
				<li>
					<a href="<?php echo base_url('lessonplan'); ?>"> Plan Montessori Lessons</a>
				</li>
			</ul>
		</li>
		<li>
			<a href="<?= base_url('reflections'); ?>" class="menu">	
				<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><path d="M0 0h24v24H0z" fill="none"/><path d="M9 11.75c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zm6 0c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8 0-.29.02-.58.05-.86 2.36-1.05 4.23-2.98 5.21-5.37C11.07 8.33 14.05 10 17.42 10c.78 0 1.53-.09 2.25-.26.21.71.33 1.47.33 2.26 0 4.41-3.59 8-8 8z"/></svg> Reflection
			</a>
		</li>
		<li>
			<a href="<?php echo base_url('settings'); ?>" class="menu">
				<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><rect fill="none" height="24" width="24"/><g><path d="M18.04,7.99l-0.63-1.4l-1.4-0.63c-0.39-0.18-0.39-0.73,0-0.91l1.4-0.63l0.63-1.4c0.18-0.39,0.73-0.39,0.91,0l0.63,1.4 l1.4,0.63c0.39,0.18,0.39,0.73,0,0.91l-1.4,0.63l-0.63,1.4C18.78,8.38,18.22,8.38,18.04,7.99z M21.28,12.72L20.96,12 c-0.18-0.39-0.73-0.39-0.91,0l-0.32,0.72L19,13.04c-0.39,0.18-0.39,0.73,0,0.91l0.72,0.32L20.04,15c0.18,0.39,0.73,0.39,0.91,0 l0.32-0.72L22,13.96c0.39-0.18,0.39-0.73,0-0.91L21.28,12.72z M16.24,14.37l1.23,0.93c0.4,0.3,0.51,0.86,0.26,1.3l-1.62,2.8 c-0.25,0.44-0.79,0.62-1.25,0.42l-1.43-0.6c-0.2,0.13-0.42,0.26-0.64,0.37l-0.19,1.54c-0.06,0.5-0.49,0.88-0.99,0.88H8.38 c-0.5,0-0.93-0.38-0.99-0.88L7.2,19.59c-0.22-0.11-0.43-0.23-0.64-0.37l-1.43,0.6c-0.46,0.2-1,0.02-1.25-0.42l-1.62-2.8 c-0.25-0.44-0.14-0.99,0.26-1.3l1.23-0.93C3.75,14.25,3.75,14.12,3.75,14s0-0.25,0.01-0.37L2.53,12.7c-0.4-0.3-0.51-0.86-0.26-1.3 l1.62-2.8c0.25-0.44,0.79-0.62,1.25-0.42l1.43,0.6c0.2-0.13,0.42-0.26,0.64-0.37l0.19-1.54C7.45,6.38,7.88,6,8.38,6h3.23 c0.5,0,0.93,0.38,0.99,0.88l0.19,1.54c0.22,0.11,0.43,0.23,0.64,0.37l1.43-0.6c0.46-0.2,1-0.02,1.25,0.42l1.62,2.8 c0.25,0.44,0.14,0.99-0.26,1.3l-1.23,0.93c0.01,0.12,0.01,0.24,0.01,0.37S16.25,14.25,16.24,14.37z M13,14c0-1.66-1.34-3-3-3 s-3,1.34-3,3s1.34,3,3,3S13,15.66,13,14z"/></g></svg>
				<!-- <img src="<?php // echo base_url('assets/images/icons/settings.svg'); ?>" > -->
				Settings
			</a>
		</li>
	</ul>
	
</nav>
