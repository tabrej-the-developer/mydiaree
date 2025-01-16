
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard_New | Mykronicle v2</title>  
</head>
<body id="app-container" class="menu-default" style="background-color: #f8f8f8; top: -35px; bottom:0px;">
<?php $this->load->view('topbar_newV2'); ?>    
<?php $this->load->view('sidebar_newV2'); ?> 
<main class="default-transition" style="opacity: 1;">
    <div class="default-transition" style="opacity: 1;">
        <div class="container-fluid">
            <div class="row" style="">
                <div class="col-12" style="margin-bottom: -30px; margin-top: -30px;">
                    <h1>Dashboard</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <!-- <ol class="breadcrumb pt-0" style="background-color: transparent;">
                            <li class="breadcrumb-item">
                                <a href="#" style="color: dimgray;">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#" style="color: dimgray;">Library</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data</li>
                        </ol> -->
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
                <div class="col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6" style="opacity: 0.75;">
                            <!-- <div class="card h-100"> -->
                            <div class="card h-100">
                                <div class="card-body" style="height: 500px;">
                                    <h5 class="card-title" style="margin-bottom: 0;">Calendar</h5>
                                    <div class="calendar"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xl-6">
                            <div class="icon-cards-row">
                                <div class="glide dashboard-numbers">
                                    <div class="glide__track" data-glide-el="track">
                                        <div class="col-lg-1"></div>
                                        <ul class="glide__slides col-lg-12" style="margin-bottom: 0px;">
                                            <li class="glide__slide col-4 custom-column-2">
                                                <?php 
                                                    $userType = $this->session->userdata("UserType");
                                                    if ($userType=="Parent") {
                                                ?>
                                                <a href="<?php echo base_url("Observation"); ?>" class="card">
                                                    <div class="card-body text-center">
                                                        <!-- <i class="iconsminds-clock"></i> -->
                                                        <i class="iconsminds-mail-read"></i>
                                                        <p class="card-text mb-0">Observation</p>
                                                        <p class="lead text-center"><?php echo $observationCount; ?></p>
                                                    </div>
                                                </a>
                                                <?php
                                                    } else {
                                                ?>
                                                <a href="<?php echo base_url("Room"); ?>" class="card">
                                                    <div class="card-body text-center">
                                                        <!-- <i class="iconsminds-clock"></i> -->
                                                        <i class="iconsminds-building"></i>
                                                        <p class="card-text mb-0">Rooms</p>
                                                        <p class="lead text-center"><?php echo $roomsCount; ?></p>
                                                    </div>
                                                </a>
                                                <?php } ?>
                                            </li>

                                            <li class="glide__slide col-4 custom-column-2">
                                                <?php
                                                    if ($userType=="Parent") {
                                                ?>
                                                <a href="<?php echo base_url("Room"); ?>" class="card">
                                                    <div class="card-body text-center">
                                                        <!-- <i class="iconsminds-basket-coins"></i> -->
                                                        <i class="iconsminds-students"></i>
                                                        <img src="<?php echo base_url('assets/images/d-students.png'); ?>" alt="">
                                                        <p class="card-text mb-0">Children</p>
                                                        <p class="lead text-center"><?php echo $childrenCount; ?></p>
                                                    </div>
                                                </a>
                                                <?php
                                                    } else {
                                                ?>
                                                <a href="<?php echo base_url("Room"); ?>" class="card">
                                                    <div class="card-body text-center">
                                                        <!-- <i class="iconsminds-basket-coins"></i> -->
                                                        <!-- <i class="simple-icon-user"></i> -->
                                                        <i class="iconsminds-students"></i>
                                                        <p class="card-text mb-0">Students</p>
                                                        <p class="lead text-center"><?php echo $childrenCount; ?></p>
                                                    </div>
                                                </a>
                                                <?php } ?>
                                            </li>

                                            <li class="glide__slide col-4 custom-column-2">
                                                <?php
                                                    if ($userType=="Parent") {
                                                ?>
                                                <a href="<?php echo base_url("announcements"); ?>" class="card">
                                                    <div class="card-body text-center">
                                                        <!-- <i class="iconsminds-arrow-refresh"></i> -->
                                                        <i class="simple-icon-event"></i>
                                                        <p class="card-text mb-0">Events</p>
                                                        <p class="lead text-center"><?php echo $eventsCount; ?></p>
                                                    </div>
                                                </a>
                                                <?php
                                                    } else {
                                                ?>
                                                <a href="<?php echo base_url("Settings/userSettings"); ?>" class="card">
                                                    <div class="card-body text-center">
                                                        <!-- <i class="iconsminds-arrow-refresh"></i> -->
                                                        <i class="simple-icon-people"></i>
                                                        <p class="card-text mb-0">Staffs</p>
                                                        <p class="lead text-center"><?php echo $staffCount; ?></p>
                                                    </div>
                                                </a>
                                                <?php } ?>
                                            </li>
                                        </ul>

                                        <ul class="glide__slides col-lg-12" >
                                            <li class="glide__slide col-4 custom-column-2">
                                                <a href="<?php echo base_url("Observation"); ?>" class="card">
                                                    <div class="card-body text-center">
                                                        <!-- <i class="iconsminds-mail-read"></i> -->
                                                        <i class="iconsminds-preview"></i>
                                                        <p class="card-text mb-0">Observations</p>
                                                        <p class="lead text-center"><?php echo $observationCount; ?></p>
                                                    </div>
                                                </a>
                                            </li>
                                            
                                            <li class="glide__slide col-4 custom-column-2">
                                                <?php if ($userType=="Parent") { ?>
                                                <a href="#" class="card">
                                                    <div class="card-body text-center">
                                                        <!-- <i class="fas fa-calendar-day"></i> -->
                                                        <i class="simple-icon-event"></i>
                                                        <p class="card-text mb-0">Upcoming Events</p>
                                                        <p class="lead text-center"><?php echo $upcomingEventsCount; ?></p>
                                                    </div>
                                                </a>
                                                <?php
                                                    } else {
                                                ?>
                                                <a href="<?php echo base_url("announcements"); ?>" class="card">
                                                    <div class="card-body text-center">
                                                        <i class="simple-icon-event"></i>
                                                        <!-- <i class="iconsminds-mail-read"></i> -->
                                                        <!-- <i class="fas fa-calendar-day"></i> -->
                                                        <p class="card-text mb-0">Events</p>
                                                        <p class="lead text-center"><?php echo $eventsCount; ?></p>
                                                    </div>
                                                </a>
                                                <?php } ?>
                                            </li>

                                            <li class="glide__slide col-4 custom-column-2">
                                                <?php if ($userType=="Parent") { ?>
                                                <a href="#" class="card">
                                                    <div class="card-body text-center">
                                                    <i class="simple-icon-event"></i>
                                                        <p class="card-text mb-0">Upcoming Events</p>
                                                        <p class="lead text-center"><?php echo $upcomingEventsCount; ?></p>
                                                    </div>
                                                </a>
                                                <?php
                                                    } else {
                                                ?>
                                                <a href="<?php echo base_url("announcements"); ?>" class="card">
                                                    <div class="card-body text-center">
                                                        <!-- <i class="glyph-icon iconsminds-hamburger"></i> -->
                                                        <!-- <i class="iconsminds-chef-hat"></i> -->
                                                        <i class="iconsminds-book"></i>
                                                        <!-- <i class="fas fa-calendar-day"></i> -->
                                                        <p class="card-text mb-0">Recipes</p>
                                                        <p class="lead text-center"><?php echo $recipesCount; ?></p>
                                                    </div>
                                                </a>
                                                <?php } ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card">
                                        <object data="https://www.sunsmart.com.au/uvalert/default.asp?version=australia&locationid=161" height="300" id="sunsmart">
                                            <embed src="https://www.sunsmart.com.au/uvalert/default.asp?version=australia&locationid=161" height="300"> </embed>
                                            Error: Embedded data could not be displayed.
                                        </object>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</main>
    <?php $this->load->view('footer_newV2'); ?> 
</body>
</html>