<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Sidebar | Mykronicle</title>
</head>

<body id="app-container" class="menu-default" style="background-color: #f8f8f8; top: -35px;">
    <div class="menu">
        <div class="main-menu" style="margin: -35px 0px;">
            <div class="scroll">
                <ul class="list-unstyled">
                    <li class="active dashboard-active">
                        <a href="<?php echo base_url('dashboard'); ?>">
                        <i class="simple-icon-home"></i>
                        <span class="txt"><strong>Home</strong></span> 
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('observation'); ?>">
                        <!-- <i class="iconsminds-mail-read"></i> -->
                        <!-- <i class="iconsminds-preview"></i> -->
                        <i class="simple-icon-equalizer"></i>
                        <span class="txt"><strong>Observation</strong></span>
                        </a>
                    </li>
                    <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <li>
                        <a href="#homeSubmenu">
                        <i class="iconsminds-notepad"></i>
                        <span class="txt"><strong>QIP</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('room'); ?>">
                        <i class="iconsminds-building"></i>
                        <span class="txt"><strong>Rooms</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('lessonPlanList/programPlanList'); ?>">
                        <i class="iconsminds-testimonal"></i>
                        <span class="txt"><strong>Program Plan</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('ServiceDetails'); ?>">
                        <i class="iconsminds-receipt-4"></i>
                        <span class="txt"><strong>Service Details</strong></span>
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo base_url('Media'); ?>">
                        <i class="iconsminds-photo-album-2"></i>
                        <span class="txt"><strong>Media</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="#announcements">
                        <i class="iconsminds-speaker-1"></i>
                        <span class="txt"><strong>Announcements</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="#Healthy">
                        <i class="iconsminds-hamburger"></i>
                        <span class="txt"><strong>Healthy Eating</strong></span>
                        </a>
                    </li>
                    <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <li>
                        <a href="<?php echo base_url('resources'); ?>">
                        <i class="iconsminds-eci-icon"></i>
                        <span class="txt"><strong>Resources</strong></span>
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="#Daily">
                        <i class="iconsminds-wallet"></i>
                        <span class="txt"><strong>Daily Journal</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Reflections'); ?>">
                        <i class="iconsminds-reset"></i>
                        <span class="txt"><strong>REFLECTION</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="#Lesson">
                        <i class="iconsminds-line-chart-1"></i>
                        <span class="txt"><strong>Lesson & Progress Plan</strong></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('settings'); ?>">
                        <i class="iconsminds-gear"></i>
                        <span class="txt"><strong>Settings</strong></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sub-menu">
            <div class="scroll">
                <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <ul class="list-unstyled" data-link="homeSubmenu" id="homeSubmenu">
                        <li>
                            <a href="<?php echo base_url('selfassessment'); ?>">
                                <span class="txt-inner">Self Assessment</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('qip'); ?>">
                            <span class="txt-inner">Quality Improvement Plan</span>
                            </a>
                        </li>
                    </ul>
                <?php } ?>

                <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <ul class="list-unstyled" data-link="announcements" id="announcements">
                        <li>
                            <a href="<?php echo base_url('announcements'); ?>">
                                <span class="txt-inner">Announcements</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('surveys'); ?>">
                                <span class="txt-inner">Survey</span>
                            </a>
                        </li>
                    </ul>
                <?php } ?>

                <ul class="list-unstyled" data-link="Healthy" id="Healthy">
                    <li>
                        <a href="<?php echo base_url('menu'); ?>">
                            <span class="txt-inner">Menu</span>
                        </a>
                    </li>
                    <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <li>
                        <a href="<?php echo base_url('recipe'); ?>">
                            <span class="txt-inner">Recipe</span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>

                <ul class="list-unstyled" data-link="Daily" id="Daily">
                    <li>
                        <a href="<?php echo base_url('dailyDiary'); ?>">
                            <span class="txt-inner">Daily Diary</span>
                        </a>
                    </li>
                    <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                        <li>
                            <a href="<?php echo base_url('headChecks'); ?>">
                                <span class="txt-inner">Head Checks</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('accident'); ?>">
                                <span class="txt-inner">Accidents</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>

                <ul class="list-unstyled" data-link="Lesson" id="Lesson">
                    <li>
                        <a href="<?php echo base_url('progressplan'); ?>">
                            <span class="txt-inner">Record Montessori Progress</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('lessonplan'); ?>">
                            <span class="txt-inner">Head Checks</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('accident'); ?>">
                            <span class="ttxt-innerxt">Plan Montessori Lessons</span>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</body>
</html>