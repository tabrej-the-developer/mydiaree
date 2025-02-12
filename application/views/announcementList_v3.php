<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcement List | Mydiaree</title>
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
            $show = 1;
            $add = 1;
        } else {
            if ($role=="Staff") {
                if (isset($permissions->addAnnouncement)) {
                    if ($permissions->addAnnouncement==1) {
                        $add = 1;
                    } else {
                        $add = 0;
                    }
                    if ($permissions->viewAllAnnouncement==1) {
                        $show = 1;
                    } else {
                        $show = 0;
                    }
                } else {
                    $show = 0;
                    $add = 0;
                }
            }else{
                $show = 1;
                $add = 0;
            }
        }
    ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Announcement List</h1>
                    <div class="text-zero top-right-button-container pb-2">
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
                        <a href="<?= base_url('announcements/addNew').'?centerid='.$centerid; ?>" class="btn btn-primary btn-lg top-right-button">ADD NEW</a>
                        <?php } ?>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Announcements List</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <?php 
                    if (isset($_GET['status'])) {
                        if (strtoupper($_GET['status']) == 'SUCCESS') {
                ?>
                <div class="col-md-6 offset-md-3">
                    <div class="alert alert-success alert-dismissible fade show rounded mb-3" role="alert">
                        <strong>Success!</strong> Announcement has been deleted.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <?php
                        }

                        if (strtoupper($_GET['status']) == 'SUCCESS-SAVE') { 
                ?>
                <div class="col-md-6 offset-md-3">
                    <div class="alert alert-success alert-dismissible fade show rounded mb-3" role="alert">
                        <strong>Success!</strong> Announcement has been saved.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <?php
                        }

                        if (strtoupper($_GET['status']) == 'ERROR') {
                ?>
                <div class="col-md-6 offset-md-3 mb-3">
                    <div class="alert alert-danger alert-dismissible fade show rounded mb-3" role="alert">
                        <strong>Warning!</strong> Some technical error occured.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <?php
                        }

                        if (strtoupper($_GET['status']) == 'ERROR-SAVE') {
                ?>
                <div class="col-md-6 offset-md-3 mb-3">
                    <div class="alert alert-danger alert-dismissible fade show rounded mb-3" role="alert">
                        <strong>Warning!</strong> Error saving the announcement.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <?php
                        }
                    }
                ?>
                <?php 
                    if(empty($records)){ 
                ?>
            </div>
            <div class="row">
                <div class="col">
                    <div class="text-center">
                        <h6 class="mb-4">Ooops... looks like we don't have enough data!</h6>
                        <p class="mb-0 text-muted text-small mb-0">Error code</p>
                        <p class="display-1 font-weight-bold mb-5"> 200 </p>
                        <a href="<?= base_url('dashboard'); ?>" class="btn btn-primary btn-lg btn-shadow">GO BACK HOME</a>
                    </div>
                </div>
                <?php 
                    }else{
                ?>
                <div class="col-12 list" data-check-all="checkAll">
                <?php foreach($records as $records_key=>$records_obj) {  ?>
                    <div class="card d-flex flex-row mb-3">
                        <div class="d-flex flex-grow-1 min-width-zero">
                            <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                <a class="list-item-heading mb-0 truncate w-40 w-xs-100" href="#">
                                    <?= ucfirst($records_obj->title); ?>
                                </a>
                                <p class="mb-0 text-muted text-small w-15 w-xs-100"><?= ucfirst($records_obj->createdBy); ?></p>
                                <p class="mb-0 text-muted text-small w-15 w-xs-100"><?= date('d.m.Y',strtotime($records_obj->eventDate));?></p>
                                <br>
                                <div class="w-15 w-xs-100">
                                    <?php 
                                        if($records_obj->status=="Sent"){
                                            echo '<span class="badge badge-pill badge-success">Sent</span>';
                                        }else if ($records_obj->status=="Pending") {
                                            echo '<span class="badge badge-pill badge-warning">Pending</span>';
                                        } else {
                                            echo '<span class="badge badge-pill badge-danger">Unknown</span>';
                                        }
                                    ?>
                                </div>
                                <br>
                                <div class="btn-group ">
                                    <a class="btn btn-outline-success btn-xs" href="<?= base_url('announcements/view/').$records_obj->aid; ?>">
                                        <i class="simple-icon-eye"></i>
                                    </a> 
                                    <?php 
                                        $date1 = new DateTime($records_obj->eventDate);
                                        $date2 = new DateTime("today");
                                        if ($date1 > $date2) { 
                                    ?>
                                    <?php if($this->session->userdata("UserType") != "Parent"){ ?>
                                    <a class="btn btn-outline-primary btn-xs" href="<?= base_url('announcements/edit/').$records_obj->id; ?>">
                                        <i class="simple-icon-pencil"></i>
                                    </a> 
                                    <?php } } ?>
                                    <?php if($this->session->userdata("UserType")!="Parent"){ ?>                                              
                                    <a class="btn btn-outline-danger btn-xs delete" onclick="return confirm('Do you really want to remove this item?');" href="<?= base_url('announcements/delete/').$records_obj->id; ?>">
                                        <i class="simple-icon-trash"></i>
                                    </a>  
                                    <?php } ?>                                            
                                </div>
                            </div>
                        </div>
                    </div>
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