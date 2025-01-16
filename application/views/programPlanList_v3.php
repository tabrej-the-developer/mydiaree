<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Program Plan List | Mykronicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <style>
        .list-thumbnail{
            height: 150px;
            width: 200px;
        }
        .obs-link{
            color: #008ecc;
        }
        .obs-link:hover{
            color: #000000;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Program Plan List</h1>
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
                        <?php if (isset($permission) && $permission->add == 1) { ?>
                            <a href="<?= base_url('lessonPlanList/addNew').'?centerid='.$centerid; ?>" class="btn btn-primary btn-lg top-right-button">ADD NEW</a>
                        <?php } ?>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Program Plan List</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row">
                <?php 
                    if(empty($page_content)){ 
                ?>
                <div class="col">
                    <div class="text-center">
                        <h6 class="mb-4">Ooops... looks like we don't have enough data!</h6>
                        <p class="mb-0 text-muted text-small mb-0">Error code</p>
                        <p class="display-1 font-weight-bold mb-5">
                            200
                        </p>
                        <a href="<?= base_url('dashboard'); ?>" class="btn btn-primary btn-lg btn-shadow">GO BACK HOME</a>
                    </div>
                </div>
                <?php 
                    }else{
                ?>
                <div class="col-12 list" data-check-all="checkAll">
                <?php foreach($page_content as $page_key=>$page_value) { ?>
                <div class="card d-flex flex-row mb-3">
                    <div class="d-flex flex-grow-1 min-width-zero">
                        <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                            <?php if (isset($permission) && $permission->view == 1) { ?>
                            <a class="list-item-heading mb-0 truncate w-40 w-xs-100" href="<?= base_url('lessonPlanList/view/'.$page_value->id); ?>">
                                <?= date('d.m.Y',strtotime($page_value->startdate)) . " / " . date('d.m.Y',strtotime($page_value->enddate)); ?>
                            </a>
                            <?php } else { ?>
                                <?= date('d.m.Y',strtotime($page_value->startdate)) . " / " . date('d.m.Y',strtotime($page_value->enddate)); ?>
                            <?php } ?>
                            
                            <p class="mb-0 text-muted text-small w-15 w-xs-100"><?= $page_value->userName;?></p>
                            <p class="mb-0 text-muted text-small w-15 w-xs-100"><?= date('d.m.Y',strtotime($page_value->createdAt));?></p>
                            <div class="w-15 w-xs-100">
                                <span class="badge badge-pill" style="background-color: <?= $page_value->roomColor;?>;">
                                    <?= $page_value->roomName;?>
                                </span>
                            </div>
                            <!-- <a class="btn btn-outline-primary dropdown-toggle mb-1" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -2px, 0px);">
                                <?php# if (isset($permission) && $permission->view == 1) { ?>
                                <a class="dropdown-item" href="<?#= base_url('lessonPlanList/view/'.$page_value->id); ?>">View</a>
                                <?php# }else{ ?>
                                <a class="dropdown-item" href="#!" title="Insufficient permission">View</a>
                                <?php# } ?>
                                <?php# if (isset($permission) && $permission->edit == 1) { ?>
                                <a class="dropdown-item" href="<?#= base_url('lessonPlanList/edit/'.$page_value->id); ?>">Edit</a>
                                <?php# }else{ ?>
                                <a class="dropdown-item" href="#!" title="Insufficient permission">Edit</a>
                                <?php# } ?>
                                <?php# if (isset($permission) && $permission->delete == 1) { ?>
                                <a class="dropdown-item delete" id='<?php# echo $page_value->id;?>' href="#">Delete</a>
                                <?php# }else{ ?>
                                <a class="dropdown-item" href="#!" title="Insufficient permission">Delete</a>
                                <?php# } ?>
                            </div> -->
                            <td class="text-right">
                                <div class="btn-group">
                                    <?php if (isset($permission) && $permission->view == 1) { ?>
                                    <a class="btn btn-outline-success btn-xs" href="<?= base_url('lessonPlanList/view/'.$page_value->id); ?>">
                                        <i class="simple-icon-eye"></i>
                                    </a> 
                                    <?php }else{ ?>
                                    <a class="btn btn-outline-danger btn-xs" href="#!" title="Insufficient permission"><i class="simple-icon-eye"></i></a>
                                    <?php } ?>
                                    <?php if (isset($permission) && $permission->edit == 1) { ?>
                                    <a class="btn btn-outline-primary btn-xs" href="<?= base_url('lessonPlanList/edit/'.$page_value->id); ?>">
                                        <i class="simple-icon-pencil"></i>
                                    </a>   
                                    <?php }else{ ?>
                                    <a class="btn btn-outline-primary btn-xs" href="#!" title="Insufficient permission"><i class="simple-icon-pencil"></i></a>
                                    <?php } ?>
                                    <?php if (isset($permission) && $permission->delete == 1) { ?>                                           
                                    <a class="btn btn-outline-danger btn-xs delete" id='<?php echo $page_value->id;?>' href="#">
                                        <i class="simple-icon-trash"></i>
                                    </a>  
                                    <?php }else{ ?>
                                    <a class="btn btn-outline-danger btn-xs" href="#!" title="Insufficient permission"><i class="simple-icon-trash"></i></a>
                                    <?php } ?>                                            
                                </div>
                            </td>
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
    <div class="modal fade modal-right" id="filtersModal" tabindex="-1" role="dialog" aria-labelledby="filtersModalRight" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filters</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            
                        </div>
                    </div>          
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <script type="text/javascript">
        $(document).on('click','.delete',function(){
            var id = $(this).attr('id');
            var that = this;
            if (confirm('Are you sure You want to Delete?')) {
                $.ajax({
                url : '<?php echo base_url()?>lessonPlanList/delete',
                type : 'POST',
                data :'id='+$(this).attr('id'),
                    success : function(response){
                        console.log(response);
                        location.reload();
                    }
                });
            }
        });

        $(document).ready(function(){
            $('.edit').on('click',function(){
                $('#overlay').show();
            })
        });
    </script>
</body>
</html>