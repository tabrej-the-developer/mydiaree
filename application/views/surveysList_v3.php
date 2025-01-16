<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Surveys List | Mykronicle</title>
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
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
</head>
<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <?php 
        //PHP block 
        $role = $this->session->userdata("UserType");
        if ($role == "Superadmin") {
            $delete = 1;
            $add = 1;
            $edit = 1;
        } else if ($role=="Staff") {
            $delete = isset($permissions->delete)?$permissions->delete:0;
            $add = isset($permissions->add)?$permissions->add:0;;
            $edit = isset($permissions->edit)?$permissions->edit:0;;
        } else {
            $delete = 0;
            $add = 0;
            $edit = 0;
        }
    ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Surveys List</h1>
                    <div class="text-zero top-right-button-container">
                        <div class="btn-group mr-1">
                            <?php 
                                $dupArr = [];
                                $centersList = $this->session->userdata("centerIds");
                                if (empty($centersList)) {
                            ?>
                                <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> EMPTY CENTER </div>
                            <?php
                                }else{
                                    if (isset($_GET['centerid'])) {
                                        foreach($centersList as $key => $center){
                                            if ( ! in_array($center, $dupArr)) {
                                                if ($_GET['centerid']==$center->id) {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($center->centerName); ?> </div>
                            <?php
                                                }
                                            }
                                            array_push($dupArr, $center);
                                        }
                                    } else {
                            ?>
                                <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($centersList[0]->centerName); ?> </div>
                            <?php
                                    }
                                }

                                if (!empty($centersList)) {
                            ?>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php foreach($centersList as $key => $center){ ?>
                                    <a class="dropdown-item" href="<?= current_url().'?centerid='.$center->id; ?>">
                                        <?= strtoupper($center->centerName); ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                        <?php if ($add == 1) { ?>
                        <a href="<?= base_url('surveys/addNew').'?centerid='.$centerid; ?>" class="btn btn-primary btn-lg top-right-button">ADD NEW</a>
                        <?php } ?>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Surveys List</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <?php 
                    if(empty($records)){ 
                ?>
                <div class="col">
                    <div class="text-center">
                        <h6 class="mb-4">Ooops... looks like we don't have enough data!</h6>
                        <p class="mb-0 text-muted text-small mb-0">Error code</p>
                        <p class="display-1 font-weight-bold mb-5"> 200 </p>
                        <a href="<?= base_url('dashboard'); ?>" class="btn btn-primary btn-lg btn-shadow">GO BACK HOME</a>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="col-12 list">
                <?php if ($this->session->userdata('UserType')!="Parent") { ?>
                    <?php foreach($records as $records_key=>$records_obj) { ?>
                        <div class="card d-flex flex-row mb-3">
                            <div class="d-flex flex-grow-1 min-width-zero">
                                <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                    <a class="list-item-heading mb-0 truncate w-40 w-xs-100" href="<?php echo base_url("surveys/view/").$records_obj->id; ?>">
                                        <?= ucfirst($records_obj->title); ?>
                                    </a>
                                    <p class="mb-0 text-muted text-small w-15 w-xs-100"><?= ucfirst($records_obj->createdByName); ?></p>
                                    <p class="mb-0 text-muted text-small w-15 w-xs-100"><?= date('d.m.Y',strtotime($records_obj->createdAt));?></p>
                                    <div class="w-15 w-xs-100">
                                        <a href="<?= base_url('surveys/viewResponses/') .$records_obj->id; ?>">
                                            Responses <span class="badge badge-info"><?= $records_obj->response; ?></span>
                                        </a>
                                    </div>
                                    <!-- <a class="btn btn-outline-primary dropdown-toggle mb-1" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="top-start">
                                        <a class="dropdown-item" href="<?php# echo base_url("surveys/view/").$records_obj->id; ?>">View</a>
                                        <?php# if ($edit==1) { ?>
                                        <a class="dropdown-item" href="<?php# echo base_url("surveys/edit/").$records_obj->id; ?>">Edit</a>
                                        <?php# } ?>
                                        <?php# if ($delete==1) { ?>
                                        <a class="dropdown-item" onclick="return confirm('Do you really want to remove this item?');" href="<?#= base_url('surveys/delete/').$records_obj->id; ?>">Delete</a>
                                        <?php# } ?>
                                    </div> -->
                                    <div class="btn-group">
                                        <a class="btn btn-outline-success btn-xs" href="<?php echo base_url("surveys/view/").$records_obj->id; ?>">
                                            <i class="simple-icon-eye"></i>
                                        </a> 
                                        <?php if ($edit==1) { ?>
                                        <a class="btn btn-outline-primary btn-xs" href="<?php echo base_url("surveys/edit/").$records_obj->id; ?>">
                                            <i class="simple-icon-pencil"></i>
                                        </a> 
                                        <?php } ?>
                                        <?php if ($delete==1) { ?>                                              
                                        <a class="btn btn-outline-danger btn-xs delete" onclick="return confirm('Do you really want to remove this item?');" href="<?= base_url('surveys/delete/').$records_obj->id; ?>">
                                            <i class="simple-icon-trash"></i>
                                        </a>  
                                        <?php } ?>                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <?php foreach($records as $records_key=>$records_obj) { ?>
                        <div class="card d-flex flex-row mb-3">
                            <div class="d-flex flex-grow-1 min-width-zero">
                                <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                    <a class="list-item-heading mb-0 truncate w-40 w-xs-100" href="<?php echo base_url("surveys/getSurveyQuestions/").$records_obj->id; ?>">
                                        <?= ucfirst($records_obj->title); ?>
                                    </a>
                                    <p class="mb-0 text-muted text-small w-15 w-xs-100"><?= ucfirst($records_obj->createdByName); ?></p>
                                    <p class="mb-0 text-muted text-small w-15 w-xs-100"><?= date('d.m.Y',strtotime($records_obj->createdAt));?></p>
                                    <a class="btn btn-outline-primary mb-1" href="<?php echo base_url("surveys/view/").$records_obj->id; ?>" role="button">
                                        Respond
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
                </div>
                <?php } ?>
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
    <script type="text/javascript">
        $(document).ready(function(){
            
        });
    </script>
</body>
</html>