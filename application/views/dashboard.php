<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?=  base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <style>
    .title {
      font-size: 20px; 
    }
 
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
    }

  </style>
</head>

<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 

<main>
    <div class="default-transition">
        <div class="container-fluid">
            <div class="row" style="">
                <div class="col-12">
                    <h1 style="font-size:30px">Dashboard</h1>
                   
                    <h1><?php echo isset($calendar) ? json_encode($calendar) : "no data "; ?><h1>

                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    </nav>
                    <div class="separator mb-5"></div>
                </div>

                <div class="col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Calendar</h4>
                                    <div class="calendar" id="cal"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xl-6">
                            <?php 
                                $userType = $this->session->userdata("UserType");
                                if($userType=="Parent"){
                            ?>
                            <div class="icon-cards-row mt-0">
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-4">
                                        <a href="<?php echo base_url('observation/observationList'); ?>" class="card">
                                            <div class="card-body text-center">
                                                <!-- <i class="iconsminds-clock"></i> -->
                                                <i class="simple-icon-equalizer"></i>
                                                <p class="card-text mb-0">Observation</p>
                                                <p class="lead text-center"><?php  $totalObservations; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <a href="<?php echo base_url('announcements'); ?>" class="card">
                                            <div class="card-body text-center">
                                                <i class="iconsminds-speaker-1"></i>
                                                <p class="card-text mb-0">Announcements</p>
                                                <p class="lead text-center"><?php  $totalChildEvents; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <a href="<?php echo base_url('progressPlan/list'); ?>" class="card">
                                            <div class="card-body text-center">
                                                <i class="iconsminds-line-chart-1"></i>
                                                <p class="card-text mb-0">L&P Plan</p>
                                                <p class="lead text-center"><?php  $totalChilds; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="<?php echo base_url('recipe'); ?>" class="card"> 
                                            <div class="card-body text-center">
                                                <i class="simple-icon-cup"></i>
                                                <p class="card-text mb-0">Recipes</p>
                                                <p class="lead text-center"><?php  $totalChildRecipes; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php }else{ ?>
                            <div class="icon-cards-row mt-0">
                                <div class="row mb-4">
                                    <div class="col-md-4 mb-4">
                                        <a href="<?= base_url("Room"); ?>" class="card">
                                            <div class="card-body text-center">
                                                <i class="iconsminds-building"></i>
                                                <p class="card-text mb-0 title">Rooms</p>
                                                <p class="lead text-center"><?php  $roomsCount; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <a href="<?= base_url("dailyDiary"); ?>" class="card">
                                            <div class="card-body text-center">
                                                <i class="iconsminds-students"></i>
                                                <p class="card-text mb-0 title">Children</p>
                                                <p class="lead text-center"><?php  $childrenCount; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <a href="<?= base_url("Settings/userSettings"); ?>" class="card">
                                            <div class="card-body text-center">
                                                <i class="simple-icon-people"></i>
                                                <p class="card-text mb-0 title">Educators</p>
                                                <p class="lead text-center"><?php  $staffCount; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="<?= base_url("Observation/observationList"); ?>" class="card">
                                            <div class="card-body text-center">
                                                <i class="simple-icon-equalizer"></i>
                                                <p class="card-text mb-0 title">Observations</p>
                                                <p class="lead text-center"><?php  $observationCount; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="<?= base_url("announcements"); ?>" class="card">
                                            <div class="card-body text-center">
                                                <i class="simple-icon-event"></i>
                                                <p class="card-text mb-0 title">Events</p>
                                                <p class="lead text-center"><?php  $eventsCount; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="<?= base_url("recipe"); ?>" class="card">
                                            <div class="card-body text-center">
                                                <i class="iconsminds-book"></i>
                                                <p class="card-text mb-0 title">Recipes</p>
                                                <p class="lead text-center"><?php  $recipesCount; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
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

<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <script>
        $(document).ready(function(){
            /* 03.10. Calendar */
            if ($().fullCalendar) {
            var testEvent = new Date(new Date().setHours(new Date().getHours()));
            var day = testEvent.getDate();
            var month = testEvent.getMonth() + 1;
            $("#cal").fullCalendar({
                    themeSystem: "bootstrap4",
                    height: "auto",
                    buttonText: {
                    today: "Today",
                    month: "Month",
                    week: "Week",
                    day: "Day",
                    list: "List"
                },
                bootstrapFontAwesome: {
                    prev: " simple-icon-arrow-left",
                    next: " simple-icon-arrow-right",
                    prevYear: " simple-icon-control-start",
                    nextYear: " simple-icon-control-end"
                },
                events: <?= isset($calendar)?json_encode($calendar):"";?>
            });
            }
        });
    </script>

    <!-- <script>
    $(document).ready(function(){
        /* 03.10. Calendar */
        if ($().fullCalendar) {
            var testEvent = new Date(new Date().setHours(new Date().getHours()));
            var day = testEvent.getDate();
            var month = testEvent.getMonth() + 1;
            $("#cal").fullCalendar({
                themeSystem: "bootstrap4",
                height: "auto",
                buttonText: {
                    today: "Today",
                    month: "Month",
                    week: "Week",
                    day: "Day",
                    list: "List"
                },
                bootstrapFontAwesome: {
                    prev: "simple-icon-arrow-left",
                    next: "simple-icon-arrow-right",
                    prevYear: "simple-icon-control-start",
                    nextYear: "simple-icon-control-end"
                },
                events: <?= isset($events) ? json_encode($events) : '[]'; ?>
            });
        }
    });
</script> -->

</body>

</html>