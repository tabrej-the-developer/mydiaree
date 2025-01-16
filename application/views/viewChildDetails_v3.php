<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Child | Mykronicle</title>
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
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <h1><?= ucwords($Children->name . " " . $Children->lastname); ?></h1>
                        <div class="text-zero top-right-button-container">
                            <?php
                                $usertype = strtoupper($this->session->userdata('UserType')); 
                                if ($usertype == "SUPERADMIN" || $usertype == "STAFF") {
                            ?>
                            <div class="btn-group mr-1">
                                <?php 
                                    $dupArr = [];
                                    $centersList = $this->session->userdata("centerIds");
                                    if (empty($centersList)) {
                                ?>
                                    <button class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> EMPTY CENTER </button>
                                <?php
                                    }else{
                                        if (isset($_GET['centerid'])) {
                                            foreach($centersList as $key => $center){
                                                if ( ! in_array($center, $dupArr)) {
                                                    if ($_GET['centerid']==$center->id) {
                                ?>
                                    <button class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($center->centerName); ?> </button>
                                <?php
                                                    }
                                                }
                                                array_push($dupArr, $center);
                                            }
                                        } else {
                                ?>
                                    <button class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($centersList[0]->centerName); ?> </button>
                                <?php
                                        }
                                    }

                                    if (!empty($centersList)) {
                                ?>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <?php foreach($centersList as $key => $center){ ?>
                                            <a class="dropdown-item dropdown-center-item" data-centerid="<?= $center->id; ?>" data-centername="<?= strtoupper($center->centerName); ?>" href="#!">
                                                <?= strtoupper($center->centerName); ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php } ?>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($Children->name . " " . $Children->lastname); ?> </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php foreach($ChildrenList as $childsList => $chList){ ?>
                                        <a class="dropdown-item" href="<?= base_url() . '?childid=' . $chList->id; ?>">
                                            <?= strtoupper($chList->name . " " . $chList->lastname); ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('Dashboard'); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Child</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="mb-2">
                        <a class="btn pt-0 pl-0 d-inline-block d-md-none" data-toggle="collapse" href="#displayOptions" role="button" aria-expanded="true" aria-controls="displayOptions">
                            Display Options <i class="simple-icon-arrow-down align-middle"></i>
                        </a>
                        <div class="collapse d-md-block" id="displayOptions">
                            <div class="d-block d-md-inline-block">
                                <div class="btn-group float-md-left mr-1 mb-1">
                                    <?php 
                                        if(isset($_GET['sort']) && $_GET['sort']!=""){
                                            if ($_GET['sort']=="DESC") {
                                                $label = "Newest first";
                                            } else {
                                                $label = "Oldest first";
                                            }
                                        }else{
                                            $label = "Order By";
                                        } 
                 
                                        if (isset($_GET['sort'])) {
                                            $_SERVER['QUERY_STRING'] = str_replace('&sort='.$_GET['sort'], '', $_SERVER['QUERY_STRING']);
                                        }

                                        $countObs = count($Observations);

                                    ?>
                                    <button class="btn btn-outline-dark btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $label; ?></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="<?= base_url('observation/viewChild?') . $_SERVER['QUERY_STRING'] . "&sort=DESC"; ?>">Newest first</a> 
                                        <a class="dropdown-item" href="<?= base_url('observation/viewChild?') . $_SERVER['QUERY_STRING'] . "&sort=ASC"; ?>">Oldest first</a>
                                    </div>
                                </div>
                            </div>
                            <div class="float-md-right">
                                <span class="text-muted text-small"><?= "Displaying 1-$countObs of $TotalObs items"; ?> </span>
                            </div>
                        </div>
                    </div>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
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
    <script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.dropdown-center-item', function(){
                var _centerid = $(this).data('centerid');
                var _centername = $(this).data('centername');
                $(this).closest('.btn-group').find('button').text(_centername);
            });
        });
    </script>   
</body>
</html>