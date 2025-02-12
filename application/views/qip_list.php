<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qip | Mydiaree v2</title>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
<main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
    <div class="default-transition">
        <div class="container-fluid">
            <div class="row" style="">
                <div class="col-12">
                    <h1>Quality Improvment Plan(QIP)</h1>
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
                        <?php 
                            $role = $this->session->userdata('UserType');
                            if ($role=="Staff") {
                                if (isset($permissions)) {
                                    if ($permissions->addQIP == 1) {
                                        $addQIP = 1;
                                    } else {
                                        $addQIP = 0;
                                    }

                                    if ($permissions->deleteQIP == 1) {
                                        $deleteQIP = 1;
                                    } else {
                                        $deleteQIP = 0;
                                    }

                                    if ($permissions->editQIP == 1) {
                                        $editQIP = 1;
                                    }else{
                                        $editQIP = 0;
                                    }
                                }else {
                                    $addQIP = 0;
                                    $deleteQIP = 0;
                                    $editQIP = 0;
                                }
                            } else {
                                $addQIP = 1;
                                $deleteQIP = 1;
                                $editQIP = 1;
                            }
                            if ($addQIP==1) {
                        ?>
                        <button class="btn btn-primary btn-lg" id="createQIP">NEW QIP</button>
                        <?php } ?>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Quality Improvment Plan</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
                <div class="col-12">
                <!-- START TABLE -->
                <div class="card p-5 m-1">
                    <?php  if(empty($qips)) { ?>
                    <p>No records available!</p>
                    <?php }else{ ?>
                    <table class="data-table data-tables-pagination responsive nowrap dataTable no-footer dtr-inline">
                        <thead class="pl-5"> 
                            <tr>
                                <span class="row">
                                    <span class="col-1"><th>Sl.</th></span>
                                    <span class="col-9"><th>Name</th></span>
                                    <span class="col-2"><th class="text-right">Action</th></span>
                                </span>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i = 0; 
                                foreach($qips as $qip) { 
                                    $i++;
                            ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td>
                                    <?php 
                                        if($editQIP==1){
                                    ?>
                                    <a class="view m-3" href="<?php echo base_url('qip/edit?id='.$qip->id); ?>">
                                        <?= 'QIP / ' . $qip->name; ?>
                                    </a>
                                    <?php
                                        }else{
                                            echo 'QIP / ' . $qip->name;
                                        }
                                    ?>
                                    
                                </td>
                                <!-- <td class="text-right">
                                    <span class="text-center">
                                        <?php# if ($deleteQIP==1) { ?>
                                            <a class="delete m-2" onclick="deleteqip('<?php# echo $qip->id; ?>');">
                                                <i class="simple-icon-trash text-danger"></i>
                                            </a>
                                        <?php
                                            // }
                                            // if ($editQIP==1) {
                                        ?>
                                            <a class="view m-3" href="<?php# echo base_url('qip/edit?id=' . $qip->id . "&centerid=" . $centerid); ?>">
                                                <i class="simple-icon-eye text-info"></i>
                                            </a>
                                        <?php# } ?>
                                    </span>
                                </td> -->

                                <td class="text-right">
                                    <div class="btn-group">
                                        <a class="btn btn-outline-primary btn-xs view" href="<?php echo base_url('qip/edit?id=' . $qip->id . "&centerid=" . $centerid); ?>">
                                            <i class="simple-icon-eye"></i>
                                        </a>                                              
                                        <a onclick="deleteqip('<?php echo $qip->id; ?>');" class="btn btn-outline-danger btn-xs delete">
                                            <i class="simple-icon-trash"></i>
                                        </a>                                              
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>        
                    </table>
                    <?php } ?>
                </div>
                <!-- END TABLE -->
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
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/datatables.min.js?v=1.0.0"></script>
</body>
    <script>
        function deleteqip(id)
        {
            if (confirm('Are you sure to Delete ?')) {
                var url="<?php echo base_url('qip/delete'); ?>?id="+id;
                location = url;
            } else {
                return false;
            }
        }

        $("#createQIP").on("click",function(){
            let url = "<?php echo base_url('qip/add-new-qip'); ?>?centerid=<?= $centerid; ?>";
            window.location.href = url;
        });
    </script>
</html>