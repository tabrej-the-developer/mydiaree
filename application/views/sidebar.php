<style>
    @media (max-width: 767px) {
    .navbar-logo {
        display: none;
    }
}
</style>
<nav class="navbar fixed-top " style="padding-bottom: 0px; padding-top: 0px; height: 70px; ">
    <div class="d-flex align-items-center navbar-left col-6">
        <a href="#" class="menu-button d-none d-md-block">
            <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                <rect x="0.48" y="0.5" width="7" height="1" />
                <rect x="0.48" y="7.5" width="7" height="1" />
                <rect x="0.48" y="15.5" width="7" height="1" />
            </svg>
            <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                <rect x="1.56" y="0.5" width="16" height="1" />
                <rect x="1.56" y="7.5" width="16" height="1" />
                <rect x="1.56" y="15.5" width="16" height="1" />
            </svg>
        </a>

        <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                <rect x="0.5" y="0.5" width="25" height="1" />
                <rect x="0.5" y="7.5" width="25" height="1" />
                <rect x="0.5" y="15.5" width="25" height="1" />
            </svg>
        </a>
    </div>
    
    <a class="navbar-logo col-3 " href="#">
        <img style="width:200px; height:50px; padding: 10px; border-radius: 20px;" src="<?php echo base_url('/assets/images/MYDIAREE-new-logo.png'); ?>" alt="rajat">
    </a>

    <div class="navbar-right  col-3 mb-2">
        <div class="header-icons d-inline-block align-middle">
            <div class="position-relative d-none d-sm-inline-block">
                
            </div>
        </div>

        <div class="user d-inline-block">
            <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span>
                    <!-- <img alt="Profile Picture" src="<?= base_url(); ?>assets/v3/img/profiles/l-1.jpg" /> -->
                    <img alt="Profile Picture" src="<?= base_url(); ?>api/assets/media/<?php echo $this->session->userdata('ImgUrl');?>" width="45px" height="45px" />
                </span>
                <span class="name"><?php echo $this->session->userdata('Name');?></span>
            </button>

            <div class="dropdown-menu dropdown-menu-right mt-3">
                <a class="dropdown-item" href="<?php echo base_url('logout'); ?>">Sign out</a>
            </div>
        </div>
    </div>
</nav>
<div class="menu">
    <div class="main-menu" style="top: 70px; height: calc(100% - 40px);">
        <div class="scroll">
            <ul class="list-unstyled">
                <li class="<?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') === TRUE ? 'active' : ''); ?>">
                    <a href="<?php echo base_url('dashboard'); ?>">
                        <i class="simple-icon-home"></i>Home
                    </a>
                </li>
                <li class="<?= (strpos($_SERVER['REQUEST_URI'], 'observation/observationList') === TRUE ? 'active' : ''); ?>">
                    <a href="<?php echo base_url('observation/observationList'); ?>">
                        <i class="simple-icon-equalizer"></i>Observation
                    </a>
                </li>
                <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <li class="<?= (strpos($_SERVER['REQUEST_URI'], 'selfassessment') === TRUE || strpos($_SERVER['REQUEST_URI'], 'qip') === TRUE ? 'active' : ''); ?>">
                        <a href="#homeSubmenu">
                            <i class="iconsminds-notepad"></i>QIP
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('room'); ?>">
                            <i class="iconsminds-building"></i>Rooms
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('lessonPlanList/programPlanList'); ?>">
                            <i class="iconsminds-testimonal"></i>Program Plan
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('ServiceDetails'); ?>">
                            <i class="iconsminds-receipt-4"></i>Service Details
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo base_url('Media'); ?>">
                            <i class="iconsminds-photo-album-2"></i>Media
                        </a>
                    </li>
                    <li>
                        <a href="#announcements">
                            <i class="iconsminds-speaker-1"></i>Announcements
                        </a>
                    </li>
                    <li>
                        <a href="#Healthy">
                            <i class="iconsminds-hamburger"></i>Healthy Eating
                        </a>
                    </li>
                    <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <li>
                        <a href="<?php echo base_url('Resources'); ?>">
                            <i class="iconsminds-eci-icon"></i>Resources
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="#Daily">
                            <i class="iconsminds-wallet"></i>Daily Journal
                        </a>
                    </li>
                    <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <li>
                        <a href="<?php echo base_url('Reflections'); ?>">
                            <i class="iconsminds-reset"></i>Reflections
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="#Lesson">
                            <i class="iconsminds-line-chart-1"></i>L&P Plan
                        </a>
                    </li>
                    <li>
                        <a href="#homeSettings">
                            <i class="iconsminds-gear"></i>Settings
                        </a>
                    </li>
            </ul>
        </div>
    </div>

    <div class="sub-menu" style="top: 70px; height: calc(100% - 40px);">
        <div class="scroll">
            <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                <ul class="list-unstyled" data-link="homeSubmenu" id="homeSubmenu">
                    <li>
                        <a href="<?php echo base_url('selfassessment'); ?>">
                            <i class="simple-icon-rocket"></i> <span class="d-inline-block">Self Assessment</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('qip'); ?>">
                            <i class="simple-icon-rocket"></i> <span class="d-inline-block">Quality Improvement Plan</span>
                        </a>
                    </li>
                </ul>
            <?php } ?>

            <?php
                //  if($this->session->userdata("UserType")!="Parent"){ 
            ?>
                <ul class="list-unstyled" data-link="homeSettings" id="homeSettings">
                    <li>
                        <a href="<?php echo base_url('Settings/resetPassword'); ?>">
                            <span class="d-inline-block">Reset Password</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/changeEmail'); ?>">
                            <span class="d-inline-block">Change Email</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['UserType'] != "Parent") { ?>
                    
                    <li>
                        <a href="<?php echo base_url('Settings/moduleSettings'); ?>">
                            <span class="d-inline-block">Module Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/userSettings'); ?>">
                            <span class="d-inline-block">User Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/centerSettings'); ?>">
                            <span class="d-inline-block">Center Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/parentSettings'); ?>">
                            <span class="d-inline-block">Parent Settings</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo base_url('Settings/superadminSettings'); ?>">
                            <span class="d-inline-block">Super-Admin Settings</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url('Settings/childGroups'); ?>">
                            <span class="d-inline-block">Child Groups</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/managePermissions'); ?>">
                            <span class="d-inline-block">Manage Permissions</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/applicationSettings'); ?>">
                            <span class="d-inline-block">Application Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/noticePeriodSettings'); ?>">
                            <span class="d-inline-block">Customize Observation Period</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/assessment'); ?>">
                            <span class="d-inline-block">Assessment</span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            <?php
                // } 
            ?>

            <?php
            //  if($this->session->userdata("UserType")!="Parent"){ 
            ?>
                <ul class="list-unstyled" data-link="announcements" id="announcements">
                    <li>
                        <a href="<?php echo base_url('announcements'); ?>">
                            <i class="simple-icon-picture"></i> <span class="d-inline-block">Announcements</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('surveys/list'); ?>">
                            <i class="simple-icon-picture"></i> <span class="d-inline-block">Survey</span>
                        </a>
                    </li>
                </ul>
            <?php
            //  } 
            ?>

            
            <ul class="list-unstyled" data-link="Healthy" id="Healthy">
                <li>
                    <a href="<?php echo base_url('menu'); ?>">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">Menu</span>
                    </a>
                </li>
                
                <li>
                    <a href="<?php echo base_url('recipe'); ?>">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">Recipe</span>
                    </a>
                </li>
              
            </ul>

            <ul class="list-unstyled" data-link="Daily" id="Daily">
                <li>
                    <a href="<?php echo base_url('dailyDiary/list'); ?>">
                    <i class="simple-icon-picture"></i><span class="txt-inner">Daily Diary</span>
                    </a>
                </li>
                <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <li>
                        <a href="<?php echo base_url('headChecks'); ?>">
                            <i class="simple-icon-picture"></i> <span class="d-inline-block">Head Checks</span>
                        </a>
                    </li>
                <?php } ?>
                <li>
                    <a href="<?php echo base_url('accident'); ?>">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">Accidents</span>
                    </a>
                </li>
            </ul>

            <ul class="list-unstyled" data-link="Lesson" id="Lesson">
                <li>
                    <a href="<?php echo base_url('progressPlan/list'); ?>">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">Record Montessori Progress</span>
                    </a>
                </li>
                <?php
                if($this->session->userdata("UserType")!="Parent"){  ?>
                <li>
                    <a href="<?php echo base_url('lessonplan'); ?>">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">Plan Montessori Lessons</span>
                    </a>
                </li>
                <?php }  ?>
            </ul>

        </div>
    </div>
</div>