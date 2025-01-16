<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Responses| Mykronicle</title>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css" />
</head>
<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main class="default-transition" style="opacity: 1;">
        <div class="default-transition" style="opacity: 1;">
            <div class="container-fluid">
                <div class="row" style="">
                    <div class="col-12">
                        <h1>View Responses</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('Dashboard'); ?>">Announcement</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('Dashboard'); ?>">Survey</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">View Survey</li>
                            </ol>
                        </nav>
                        <div class="separator mb-5"></div>
                    </div>
                    <div class="col-12">
                        <div class="getSurveyQues">
                            <?php echo $survey['title']; ?><br><span style="font-size:12px; color:#ddd;"><?php echo $survey['description']; ?></span>
                        </div>
	                    <p class="author h5">By: <a href="#">Shomalia Jackson</a> On: 3rd Dec 2020 at 11.30 AM</p>
                        <?php 
                            $i=1;
                            $qstnArr = array();

                            foreach ($survey['questions'] as $qstn => $qts) {
                        ?>
                        <div class="bsCalloutView">
                            <div class="question-text"><?php echo $i.". ".$qts['questionText']; ?></div>
                            <div class="user-records">
                                <?php
                                    $arr = array();

                                    foreach ($qts['responses'] as $resp => $res) {
                                        
                                        if (!in_array($res['userid'], $arr)) {
                                            array_push($arr, $res['userid']);
                                    ?>
                                        <div class="user-name"><?php echo $res['name']; ?></div>
                                    <?php } ?>
                                        <span><?php echo $res['answerText']; ?></span>
                                <?php }  ?>
                            </div>	
                        </div>
                        <?php
                                $i++;
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js"></script> 
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/datatables.min.js"></script>
</body>
</html>