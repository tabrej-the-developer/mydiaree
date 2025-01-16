<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Announcement | Mykronicle</title>
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
    <style>
        .d-flex-custom{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <?php 
        //php block 
        if($Info->status=="Sent"){
            $badge = '<span class="badge badge-pill badge-success">Sent</span>';
        }else if ($Info->status=="Pending") {
            $badge = '<span class="badge badge-pill badge-warning">Pending</span>';
        } else {
            $badge = '<span class="badge badge-pill badge-danger">Unknown</span>';
        }
    ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>View Announcement</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('announcements'); ?>">Announcements List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">View Announcement</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex-custom">
                                <h5><?= $Info->title; ?></h5>
                                <?= $badge; ?>
                            </div>
                            <div class="d-flex-custom">
                                <span>Event date: <?= date('d.m.Y',strtotime($Info->eventDate)); ?></span>
                                <span>Created at: <?= date('d.m.Y',strtotime($Info->createdAt)); ?></span>
                                <span>Created by: <?= $Info->username; ?></span>
                            </div>
                            <div class="separator my-2"></div>
                            <div class="d-flex">
                                <!-- children block -->
                            </div>
                            <div>
                                <?= html_entity_decode($Info->text); ?>
                            </div>
                        </div>
                    </div>      
                </div>
            </div>
        </div>
    </main>
    <?php $this->load->view('footer_v3'); ?>

    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js"></script>
</body>

</html>