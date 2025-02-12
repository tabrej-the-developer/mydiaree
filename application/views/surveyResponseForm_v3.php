<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Respond to Survey | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.1.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.1.0" />
    <!-- <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.1.0" /> -->
    <style>
        .question-text{
            font-size: 15px;
            font-weight: 600;
        }
        .label-text{
            border: 1px solid #d7d7d7;
            padding: 5px;
            height: 30px;
            width: 30px;
            font-size: 12px;
            text-align: center;
            border-radius: 50%;
            margin: 0px 10px;
        }
        .slidecontainer{
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <?php 
        // php block
        $surveys = $Surveys;
      
        if(count($surveys['survey']) > 0){
            $survey = $surveys['survey'][0];
            $surveyQstn = $surveys['surveyQuestion'];
            $surveyQstnMedia = $surveys['surveyQuestionMedia'];
            $surveyQstnOption = $surveys['surveyQuestionOption'];
           // print_r($Surveys); exit;
        }else{
            $survey = NULL;
            $surveyQstn = NULL;
            $surveyQstnMedia = NULL;
            $surveyQstnOption = NULL;
        }
        
    ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Respond Survey</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Surveys/list'); ?>">Surveys List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Respond Survey</li>
                        </ol>
                    </nav>
                    <div class="separator mb-3"></div>
                </div>
            </div>
            <div class="row">
                <?php if(isset($_GET['code']) && $_GET['code'] == 601) {?>
                        <div class="col-md-8 offset-md-2 alert alert-danger" style="">
                            <strong>
                                Error!
                            </strong>
                            You have already attempted this survey...
                        </div>
                    <?php }?>
                <?php if ($this->session->userdata('UserType') != "Parent") { ?>
                    
                <div class="col-md-12 mb-2">
                    <div class="alert alert-info alert-dismissible fade show rounded mb-0" role="alert">
                        <strong>Notice!</strong> You are allowed to view survey only and can't respond to them.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if($survey==NULL){ ?>
                            <div class="text-center">
                                <h3>Survey Unavailable!</h3>
                            </div>
                            <?php } else { ?>
                            <h5 class="card-title"><?php echo $survey['title'];  ?></h5>
                            <!-- <h1><?php// print_r($survey['id']); ?></h1> -->
                            <p><?php echo $survey['description']; ?></p>
                            <div class="separator mb-4"></div>
                            <form action="<?php echo base_url('surveys/exeSurveyRespond'); ?>" method="post">
                            <input type="hidden" name="surveyid" value="<?php echo $survey['id']; ?>">
                            <?php
                            
                                $i = 1;
                                foreach ($surveyQstn as $qstn) {
                            ?>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="question-text mb-2 text-bold">
                                        <?php
                                            if ($qstn['isMandatory']==0) {
                                                echo $i.". ". $qstn['questionText'];
                                            }else {
                                                echo $i.". ". $qstn['questionText'] ."<sup class='text-danger'>*</sup>";
                                            }
                                        ?>
                                        <input type="hidden" value="<?php echo $qstn['id']; ?>" name="questionId_<?php echo $qstn['id']; ?>">
                                        <input type="hidden" value="<?php echo $survey['id']; ?>" name="surveyid">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 mb-2">
                                            <?php 
                                            foreach ($surveyQstnMedia AS $mediasArray => $mediasObs) {
                                                foreach ($mediasObs as $mediaKey => $media) {
                                                    if ($qstn['id'] == $media['qid'] && $media['mediaUrl']!="") {
                                                        if ($media['mediaType']=="Image") {
                                                    ?>
                                                    <img src="<?php echo base_url()."api/assets/media/".$media['mediaUrl']; ?>" height="240px" style="border-radius: 10px;">
                                                    <?php
                                                        } else {
                                                    ?>
                                                    <video width="320" height="240" controls>
                                                        <source src="<?php echo base_url()."api/assets/media/".$media['mediaUrl']; ?>" type="video/mp4">
                                                    </video>
                                                    <?php
                                                        }
                                                    }
                                                }
                                            } ?>
                                        </div>
                                        <div class="col-sm-12">
                                            <?php
                                            if ($qstn['questionType']=="RADIO") {

                                                foreach ($surveyQstnOption as $option) {
                                                    echo "<div class='form-group'>";
                                                    foreach ($option as $opt) {
                                                        if ($opt['qid'] == $qstn['id']) {
                                            ?>
                                                <div class="labelGroup"><input type="radio" name="<?php echo "question_".$qstn['id']; ?>[]" value="<?php echo $opt['id']; ?>" id="<?php echo "option".$opt['id']; ?>" <?php if ($qstn['isMandatory']!=0) { echo "required"; }?>>&nbsp;&nbsp;&nbsp;<label for="<?php echo "option".$opt['id']; ?>"><?php echo $opt['optionText']; ?></label></div>
                                            <?php
                                                        }
                                                    }
                                                echo "</div>";

                                                }
                                            }else if ($qstn['questionType']=="CHECKBOX") {

                                                foreach ($surveyQstnOption as $option) {
                                                    echo "<div class='form-group'>";
                                                    foreach ($option as $opt) {
                                                        if ($opt['qid'] == $qstn['id']) {
                                            ?>
                                                <div class="labelGroup"><input type="checkbox" name="<?php echo "question_".$qstn['id']; ?>[]" value="<?php echo $opt['id']; ?>" id="<?php echo "option".$opt['id']; ?>" <?php if ($qstn['isMandatory']!=0) { echo "required"; }?>>&nbsp;&nbsp;&nbsp;<label for="<?php echo "option".$opt['id']; ?>"><?php echo $opt['optionText']; ?></label></div>
                                            <?php
                                                        }
                                                    }
                                                echo "</div>";
                                                }
                                            }else if ($qstn['questionType']=="DROPDOWN") {
                                            ?>
                                            <select name='<?php echo "question_". $qstn['id']; ?>[]' class='form-control' <?php if ($qstn['isMandatory']!=0) { echo "required"; }?>>
                                            <?php
                                                foreach ($surveyQstnOption as $option) {
                                                    foreach ($option as $opt) {
                                                        if ($opt['qid'] == $qstn['id']) {
                                                            echo "<option value='".$opt['id']."'>".$opt['optionText']."</option>";
                                                        }
                                                    }
                                                }
                                                echo "</select>";

                                            }else if ($qstn['questionType']=="SCALE") {
                                                foreach ($surveyQstnOption as $option) {
                                                    $scaleArr = array();
                                                    foreach ($option as $opt) {
                                                        if ($opt['qid'] == $qstn['id']) {
                                                            $scaleArr[]=$opt;
                                                        }
                                                    }
                                                    if (!empty($option)) {
                                                        if ($option[0]['qid']==$qstn['id']) {
                                            ?>
                                                <div class="slidecontainer">
                                                    <input type="range" min="<?php echo $scaleArr[0]['optionText']; ?>" max="<?php echo $scaleArr[1]['optionText']; ?>" id="question-<?= $qstn['id']; ?>" name="question_<?php echo $qstn['id']; ?>[]" class="slider" value="<?= $scaleArr[0]['optionText']; ?>">
                                                    <label class="label-text"><?= $scaleArr[0]['optionText']; ?></label>
                                                </div>
                                            <?php
                                                    }
                                                    }
                                                }
                                            }else if ($qstn['questionType']=="TEXT") {
                                            ?>
                                            <div class="form-group">
                                                <textarea name="question_<?php echo $qstn['id']; ?>[]" id="" class="form-control" rows="10"></textarea>
                                            </div>
                                            <?php
                                            }else {
                                                echo "Invalid question type!";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                    $i++;
                                }
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <?php if ($this->session->userdata('UserType') != "Parent") { ?>
                                        <button class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="top" title="" data-original-title="Only Parents are allowed to submit">Submit</button>   
                                    <?php }else{ ?>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    <?php } ?>
                                </div>
                            </div>          
                            </form>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </main>

    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/nouislider.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.1.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.1.0"></script>
    <script>
        $(document).ready(function(){
            $('.slider').on('input',  function() {
                $(this).siblings('label').text($(this).val());
            });
        });
    </script>   
</body>
</html>