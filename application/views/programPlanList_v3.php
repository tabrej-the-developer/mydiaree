<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Program Plan List | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
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
    <a href="#" class="btn btn-primary btn-lg top-right-button" id="addnewbtn" data-toggle="modal" data-target="#templateModal">ADD NEW</a>
<?php } ?>

<a href="<?= base_url('lessonPlanList/viewnewtemplate').'?centerid='.$centerid; ?>">
    <button class="btn btn-outline-primary" style="margin-left:5px;">Add Templates</button>
</a>

<a href="<?= base_url('lessonPlanList/viewProgramplanCreateformpage').'?centerid='.$centerid; ?>">
    <button class="btn btn-outline-primary" style="margin-left:5px;">Add ProgramPlan</button>
</a>
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
                        <h6 class="mb-4">You don't have any Program Plans, Create New Program Plans.....</h6>
                        <!-- <p class="mb-0 text-muted text-small mb-0">Error code</p>
                        <p class="display-1 font-weight-bold mb-5">
                            200
                        </p> -->
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

 

<div class="modal fade" id="templateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Option</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <a href="<?= base_url('lessonPlanList/addNew').'?centerid='.$centerid; ?>"  class="btn btn-success btn-lg mb-3">
                            <i class="fa fa-plus"></i> Create Without Template
                        </a>
                    </div>
                    <div class="col-md-6 text-center">
                        <button class="btn btn-primary btn-lg mb-3" id="loadTemplates">
                            <i class="fa fa-list"></i> Select Existing Template
                        </button>
                    </div>
                </div>

                <div id="existingTemplatesList" style="display:none;">
                    <hr>
                    <h6 class="text-center">Available Templates</h6>
                    <div class="row" id="templateContainer">
                        <!-- Templates will be dynamically loaded here -->
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


<script>
$(document).ready(function() {
    $('#loadTemplates').on('click', function() {
        $('#existingTemplatesList').show();
        console.log("this is here");
        // Load templates if not already loaded
        if ($('#templateContainer').children().length === 0) {
            $.ajax({
                url: '<?= base_url('LessonPlanList/getTemplates') ?>',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    let container = $('#templateContainer');
                    container.empty();

                    if (response.length === 0) {
                        container.append('<div class="col-12 text-center"><p>No templates available</p></div>');
                        return;
                    }

                    response.forEach(function(template) {
    let templateCard = `
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">${template.template_name}</h6>
                    <a href="<?= base_url('lessonPlanList/templateload/') ?>${template.template_id}" 
                       class="btn btn-primary btn-sm">
                        Use Template
                    </a>
                    <span class="delete-icon" data-template-id="${template.template_id}" style="cursor: pointer; color: red; float: right;">
                        <i class="fas fa-trash"></i>
                    </span>
                </div>
            </div>
        </div>
    `;
    container.append(templateCard);
});
                },
                error: function() {
                    $('#templateContainer').html('<div class="col-12 text-center text-danger">Failed to load templates</div>');
                }
            });
        }
    });
});
</script>

<script>
    $(document).on('click', '.delete-icon', function() {
    let templateId = $(this).data('template-id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to delete the template
            $.ajax({
                url: '<?= base_url('lessonPlanList/deleteTemplate/') ?>' + templateId,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Deleted!',
                            'Your template has been deleted.',
                            'success'
                        ).then(() => {
                            // Reload the page or remove the card from the DOM
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                           'There was an error deleting the template.',
                            'error'
                        );
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the template.',
                        'error'
                    );
                }
            });
        }
    });
});
    </script>

</body>
</html>