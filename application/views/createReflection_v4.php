<?php 

	$data['name']='createReflection'; 
    // echo "<pre>";
    // print_r($child);
    // exit();
	// $this->load->view('header',$data); 
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Reflection | Mydiaree</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?id=1234"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/slick.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/dropzone.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <style>
        .list-thumbnail{
            width: 40px!important;
        }
    </style>


<style>
    .eylf-tree .list-group-item {
        border-left: none;
        border-right: none;
        border-radius: 0;
    }
    
    .eylf-framework {
        background-color: #f8f9fa;
    }
    
    .eylf-outcomes-container {
        background-color: #ffffff;
        padding-left: 2rem;
    }
    
    .eylf-outcome {
        background-color: #ffffff;
        padding-left: 4rem;
    }
    
    .eylf-activity {
        background-color: #ffffff;
        padding-left: 6rem;
    }
    
    .toggle-icon {
        cursor: pointer;
        width: 20px;
        text-align: center;
    }
    
    .toggle-icon.expanded i {
        transform: rotate(90deg);
    }
</style>

<style>
.preview-item {
    position: relative;
    margin: 10px;
    border: 1px solid #ddd;
    padding: 5px;
    width: 150px;
}

.preview-img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.preview-controls {
    display: flex;
    justify-content: space-between;
    margin-top: 5px;
}

.rotate-btn {
    background: #f8f9fa;
    border: 1px solid #ddd;
    padding: 3px 8px;
    cursor: pointer;
    font-size: 12px;
}

.remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(255, 0, 0, 0.7);
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    line-height: 18px;
    text-align: center;
    cursor: pointer;
    font-size: 12px;
}

.img-counter {
    position: absolute;
    top: 5px;
    left: 5px;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 2px 6px;
    border-radius: 10px;
    font-size: 10px;
}
</style>

</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main class="default-transition" data-centerid="<?= isset($centerid)?$centerid:null; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Daily Reflection</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Reflections'); ?>">Reflection</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create Reflection</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div> 
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-5"> 
                                <h5 class="card-title">Enter Details</h5>
                            </div>
                            <form action="<?= base_url('Reflections/addreflection'); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                                    <input type="hidden" name="centerid" value="<?= $centerid; ?>">
                                <div class="row">
                                    <div class="col-md-6">

                                    <div class="form-group">
                                            <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-backdrop="static" data-target="#selectChildrenModal"> + Add Children </button>  &nbsp;<span style="color:red">*Required</span>
                                        </div>

                                        <div class="children-tags">                                            
                                            <?php 
                                                if (isset($reflection) && !empty($reflection->children)) {
                                                    foreach ($reflection->children as $key => $obj) {
                                            ?>
                                            <a href="#!" class="rem" data-role="remove" data-child="<?= $obj->childid;?>">
                                                <input type="hidden" name="childId[]" value="<?= $obj->childid;?>">
                                                <span class="badge badge-pill badge-outline-primary mb-1"><?= $obj->name; ?> X </span>
                                            </a>
                                            <?php } } ?>
                                        </div>
<hr>

                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <div class="input-group">
                                                <input type="text" name="title" class="form-control title" id="title">
                                            </div>
                                        </div>
                                        <div class=" form-group">
                                            <label>Educators &nbsp;<span style="color:red">*Required</span></label>
                                            <select id="room_educators" name="Educator[]"
                                                    class="popinput js-example-basic-multiple multiple_selection form-control select2-multiple"
                                                    multiple="multiple">
                                                    <?php foreach($Educator as $Educators => $objEducator) { ?>
                                                    <option name="<?php echo $objEducator->name; ?>"
                                                        value="<?php echo $objEducator->userid; ?>"><?php echo $objEducator->name; ?>
                                                    </option>
                                                    <?php }?>
                                            </select>
                                        </div>


                                        <div class=" form-group">
                                            <label>Classroom &nbsp;<span style="color:red">*Required</span></label>
                                            <select id="room" name="room[]"
                                                    class="popinput js-example-basic-multiple multiple_selection form-control select2-multiple"
                                                    multiple="multiple">
                                                    <?php foreach($Rooms as $Roomss => $objRooms) { ?>
                                                    <option name="<?php echo $objRooms->name; ?>"
                                                        value="<?php echo $objRooms->roomid; ?>"><?php echo $objRooms->name; ?>
                                                    </option>
                                                    <?php }?>
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="about">Reflection</label>  &nbsp;&nbsp;&nbsp; <button type="button" style="font-size:10px;font-weight:bold;margin-bottom:3px;" class="btn btn-sm btn-outline-primary mt-2 refine-about-btn">Refine Text</button>

                                            <textarea name="about" class="form-control about rounded-1" id="about" rows="10" style=""></textarea>
                                        </div>


                                        <div class="form-group" style="width:720px;">
                                        <label for="eylf">EYLF</label>
                                          <div class="input-group">
                                           <textarea class="form-control" id="eylf" name="eylf" rows="3" readonly></textarea>
                                            <div class="input-group-append">
                                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eylfModal">
                                             <i class="fa fa-search"></i> Select EYLF
                                            </button>
                                                 </div>
                                                </div>
                                            </div>



                                        
                                      
                                    
                                    </div>
                                    <div class="col-md-6">
                                      
                                        <div class="card-body border border-dotted mt-4">
                                            <h5 class="mb-4">Upload Single/Multiple Images &nbsp;&nbsp;<span style="color:blueviolet;">(upload upto 8 pics only)</span></h5>
                                            <input type="file" name="media[]" id="fileUpload" class="form-control-hidden" multiple accept="image/*" required>
                                            <div id="imagePreviewContainer" class="d-flex flex-wrap mt-3"></div>
                                        </div>
                                       
                                        <div class="mt-2">
                                            <div class="form-check-inline">
                                                <label class="form-check-label custom-control custom-checkbox mb-1 align-self-center pr-4">
                                                    <input type="radio" class="form-check-input custom-control-input" name="status" value="PUBLISHED">
                                                    <span class="custom-control-label">PUBLISHED</span>
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <label class="form-check-label custom-control custom-checkbox mb-1 align-self-center pr-4 pl-0">
                                                    <input type="radio" class="form-check-input custom-control-input" name="status" value="DRAFT" checked>
                                                    <span class="custom-control-label">DRAFT</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mr-1" style="margin-top:1%;display: flex;justify-content: end;">
                                    <div class="form-row">
                                        <div class="col">
                                            <button class="btn btn-primary" id="submit-btn" type="submit" style="color: #fff !important;background-color: #337ab7 !important;border-color: #2e6da4 !important;">Save</button>
                                        </div>
                                        <div class="col">
                                            <button class="btn btn-danger" style="margin-right:1%;">
                                                <a class="text-white" href="<?php echo base_url('Reflections/getUserReflections'); ?>">Close</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </main>

    <!-- Select Children Popup Modal -->
    <div class="modal fade modal-right" id="selectChildrenModal" tabindex="-1" role="dialog" aria-labelledby="selectChildrenModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Children</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height:550px;overflow-y:auto;">
                    <!-- <div class="form-group filter-box">
                        <input type="text" class="form-control" id="filter-child" placeholder="Enter child name ">
                    </div> -->
                    <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab"
                                aria-controls="first" aria-selected="true">Children</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab"
                                aria-controls="second" aria-selected="false">Groups</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="third-tab" data-toggle="tab" href="#third" role="tab"
                                aria-controls="third" aria-selected="false">Rooms</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                            <div class="select-all-box">
                                <input type="checkbox" id="select-all-child">
                                <label for="select-all-child" id="select-all-child-label">Select All</label>
                            </div>
                            <table class="list-table table table-condensed">
                                <?php  foreach ($child as $childs => $childobj) { ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="common-child child-tab unique-tag" name="child[]" id="<?= 'child_'.$childobj->childid; ?>" value="<?= $childobj->childid; ?>" data-name="<?= $childobj->name; ?>" <?= isset($childobj->checked)?$childobj->checked:NULL; ?>>
                                    </td>
                                    <td>
                                        <label for="<?= 'child_'.$childobj->childid; ?>">
                                            <img src="<?= BASE_API_URL.'assets/media/'.$childobj->imageUrl; ?>" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall">
                                            <?= $childobj->name; ?>
                                        </label>
                                    </td>
                                </tr>
                                <?php  } ?>
                            </table>
                        </div>
                    
                        <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                            <?php foreach ($Groups as $grkey => $grobj) { ?>
                                <div class="select-all-box">
                                    <input type="checkbox" id="<?= 'select-group-child-'.$grobj->groupid; ?>" class="select-group-child" data-groupid="<?= $grobj->groupid; ?>">
                                    <label for="<?= 'select-group-child-'.$grobj->groupid; ?>"><?= $grobj->name; ?></label>
                                </div>
                                <table class="list-table table table-condensed">
                                    <?php  foreach ($grobj->childrens as $childkey => $childobj) { ?>
                                    <tr>
                                        <td><input type="checkbox" class="common-child child-group" name="child[]" data-groupid="<?= $grobj->groupid; ?>" id="<?= 'child_'.$childobj->childid; ?>" value="<?= $childobj->childid; ?>" <?= $childobj->checked; ?>></td>
                                        <td>
                                            <label for="<?= 'child_'.$childobj->childid; ?>">
                                                <img src="<?= BASE_API_URL.'assets/media/'.$childobj->imageUrl; ?>" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall">
                                                <?= $childobj->name. " - " .$childobj->age; ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <?php  } ?>
                                </table>
                            <?php } ?>
                        </div>




          



                        <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
                            <?php foreach ($Rooms as $roomkey => $roomobj) { ?>
                                <div class="select-all-box">
                                    <input type="checkbox" class="select-room-child" id="<?= 'select-room-child-'.$roomobj->roomid; ?>" data-roomid="<?= $roomobj->roomid; ?>">
                                    <label for="<?= 'select-room-child-'.$roomobj->roomid; ?>"><?= $roomobj->name; ?></label>
                                </div>
                                <table class="list-table table table-condensed">
                                    <?php  foreach ($roomobj->childrens as $childkey => $childobj) { ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="common-child child-room" name="child[]" data-roomid="<?= $roomobj->roomid; ?>" id="<?= 'child_'.$childobj->childid; ?>" value="<?= $childobj->childid; ?>" <?= $childobj->checked; ?>>
                                        </td>
                                        <td>
                                            <label for="<?= 'child_'.$childobj->childid; ?>">
                                                <img src="<?= BASE_API_URL.'assets/media/'.$childobj->imageUrl; ?>" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall">
                                                <?= $childobj->name. " - " .$childobj->age; ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <?php  } ?>
                                </table>
                            <?php } ?>  
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="insert-childtags" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>





    <!-- EYLF Modal -->
<div class="modal fade" id="eylfModal" tabindex="-1" role="dialog" aria-labelledby="eylfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eylfModalLabel">Select EYLF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height:500px;overflow-y:auto;">
                <div class="eylf-tree">
                    <ul class="list-group">
                        <!-- Main EYLF Framework -->
                        <li class="list-group-item eylf-framework">
                            <div class="d-flex align-items-center">
                                <span class="mr-2 toggle-icon" data-toggle="collapse" data-target="#eylfFramework">
                                    <i class="fa fa-chevron-right"></i>
                                </span>
                                <span>Early Years Learning Framework (EYLF) - Australia (V2.0 2022)</span>
                            </div>
                            
                            <!-- EYLF Framework content -->
                            <div id="eylfFramework" class="collapse mt-2">
                                <ul class="list-group">
                                    <!-- EYLF Learning Outcomes -->
                                    <li class="list-group-item eylf-outcomes-container">
                                        <div class="d-flex align-items-center">
                                            <span class="mr-2 toggle-icon" data-toggle="collapse" data-target="#eylfOutcomes">
                                                <i class="fa fa-chevron-right"></i>
                                            </span>
                                            <span>EYLF Learning Outcomes</span>
                                        </div>
                                        
                                        <!-- List of all outcomes -->
                                        <div id="eylfOutcomes" class="collapse mt-2">
                                            <ul class="list-group">
                                                <?php foreach ($eylf_outcomes as $outcome) : ?>
                                                <li class="list-group-item eylf-outcome">
                                                    <div class="d-flex align-items-center">
                                                        <span class="mr-2 toggle-icon" data-toggle="collapse" data-target="#outcome<?= $outcome->id ?>">
                                                            <i class="fa fa-chevron-right"></i>
                                                        </span>
                                                        <span><?= $outcome->title ?> - <?= $outcome->name ?></span>
                                                    </div>
                                                    
                                                    <!-- Activities for this outcome -->
                                                    <div id="outcome<?= $outcome->id ?>" class="collapse mt-2">
                                                        <ul class="list-group">
                                                            <?php foreach ($outcome->activities as $activity) : ?>
                                                            <li class="list-group-item eylf-activity">
                                                                <div class="form-check">
                                                                    <input class="form-check-input eylf-activity-checkbox"
                                                                           type="checkbox"
                                                                           value="<?= $activity->id ?>"
                                                                           id="activity<?= $activity->id ?>"
                                                                           data-outcome-id="<?= $outcome->id ?>"
                                                                           data-outcome-title="<?= $outcome->title ?>"
                                                                           data-outcome-name="<?= $outcome->name ?>"
                                                                           data-activity-title="<?= $activity->title ?>">
                                                                    <label class="form-check-label" for="activity<?= $activity->id ?>">
                                                                        <?= $activity->title ?>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>
                                    
                                    <!-- You can add EYLF Practices and EYLF Principles here if needed -->
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveEylfSelections">Save selections</button>
            </div>
        </div>
    </div>
</div>




    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/slick.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/ckeditor5-build-classic/ckeditor.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/dropzone.min.js"></script>
    <script>
    
        $(document).on('click', "#select-all-child", function() {           
            //check if this checkbox is checked or not
            if ($(this).is(':checked')) {
                //check all children
                var _childid = $('input.common-child');
                $(_childid).prop('checked', true);
                $(".select-group-child").prop('checked', true);
                $(".select-room-child").prop('checked', true);
            }else{
                //uncheck all children
                var _childid = $('input.common-child');
                $(_childid).prop('checked', false);
                $(".select-group-child").prop('checked', false);
                $(".select-room-child").prop('checked', false);
            }
        });

        var _totalchilds = '<?= count($Childrens); ?>';

        $(document).on('click', '.common-child', function() {
            var _value = $(this).val();
            if ($(this).is(':checked')) {
                $('input.common-child[value="'+_value+'"]').prop('checked', true);
                $('input.child-group[value="'+_value+'"]').trigger('change');
                $('input.child-room[value="'+_value+'"]').trigger('change');

            }else{
                $('input.common-child[value="'+_value+'"]').prop('checked', false);
                $('input.child-group[value="'+_value+'"]').trigger('change');
                $('input.child-room[value="'+_value+'"]').trigger('change');
            }

            var _totalChildChecked = $('.child-tab:checked').length;
            if (_totalChildChecked == _totalchilds) {
                $("#select-all-child").prop('checked', true);
            }else{
                $("#select-all-child").prop('checked', false);
            }
        });
        
        $(document).on("click",".select-group-child",function(){
            var _groupid = $(this).data('groupid');
            var _selector = $('input.common-child[data-groupid="'+_groupid+'"]');

            if ($(this).is(':checked')) {
                // $(_selector).prop('checked', true);
                $.each(_selector, function(index, val) {
                    $(".common-child[value='"+$(this).val()+"']").prop('checked', true);
                });
            }else{
                // $(_selector).prop('checked', false);
                $.each(_selector, function(index, val) {
                    $(".common-child[value='"+$(this).val()+"']").prop('checked', false);
                });
            }

            var _totalChildChecked = $('.child-tab:checked').length;
            if (_totalChildChecked == _totalchilds) {
                $("#select-all-child").prop('checked', true);
            }else{
                $("#select-all-child").prop('checked', false);
            }
        });

        $(document).on("change", ".child-group", function(){
            var _groupid = $(this).data('groupid');
            var _selector = '#select-group-child-'+_groupid;
            var _totalGroupChilds = $('.child-group[data-groupid="'+_groupid+'"]').length;
            var _totalGroupChildsChecked = $('.child-group[data-groupid="'+_groupid+'"]:checked').length;
            if (_totalGroupChilds == _totalGroupChildsChecked) {
                $(_selector).prop('checked', true);
            }else{
                $(_selector).prop('checked', false);
            }
        });

        $(document).on("click",".select-room-child",function(){
            var _roomid = $(this).data('roomid');
            var _selector = $('input.common-child[data-roomid="'+_roomid+'"]');

            if ($(this).is(':checked')) {
                $.each(_selector, function(index, val) {
                    $(".common-child[value='"+$(this).val()+"']").prop('checked', true);
                });
            }else{
                $.each(_selector, function(index, val) {
                    $(".common-child[value='"+$(this).val()+"']").prop('checked', false);
                });
            }

            var _totalChildChecked = $('.child-tab:checked').length;
            if (_totalChildChecked == _totalchilds) {
                $("#select-all-child").prop('checked', true);
            }else{
                $("#select-all-child").prop('checked', false);
            }
        });

        $(document).on("change", ".child-room", function(){
            var _roomid = $(this).data('roomid');
            var _selector = '#select-room-child-'+_roomid;
            var _totalRoomChilds = $('.child-room[data-roomid="'+_roomid+'"]').length;
            var _totalRoomChildsChecked = $('.child-room[data-roomid="'+_roomid+'"]:checked').length;
            if (_totalRoomChilds == _totalRoomChildsChecked) {
                $(_selector).prop('checked', true);
            }else{
                $(_selector).prop('checked', false);                
            }
        });

        $(document).on("click","#insert-childtags",function(){
            $('.children-tags').empty();
            $('.unique-tag:checked').each(function(index, val) {
                $('.children-tags').append(`
                    <a href="#!" class="rem" data-role="remove" data-child="`+ $(this).val() +`">
                        <input type="hidden" name="childId[]" value="`+ $(this).val() +`">
                        <span class="badge badge-pill badge-outline-primary mb-1">`+ $(this).data('name') +` X </span>
                    </a>
                `);
            });
            $(".children-tags").show();
        });

        $(document).on('click', '.rem', function() {
            var _childid = $(this).data('child');
            $(".common-child[value='"+_childid+"']").trigger('click');
            $(this).remove();
        });
    </script>

<script>
    $(document).ready(function() {
    $(document).on('click', '.toggle-icon', function(e) {
        // Prevent the event from bubbling up
        e.stopPropagation();
        
        // Toggle only the clicked icon's expanded class
        $(this).toggleClass('expanded');
        
        // Change only this icon
        if ($(this).hasClass('expanded')) {
            $(this).find('i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        } else {
            $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        }
        
        // Toggle the collapse that this icon controls
        const targetId = $(this).data('target');
        $(targetId).collapse('toggle');
    });
    
    // Handle collapse events
    $(document).on('show.bs.collapse', '.collapse', function(e) {
        // Stop event propagation to avoid triggering parent collapses
        e.stopPropagation();
        
        // Only find the toggle icon that directly controls this collapse
        const toggleIcon = $('[data-target="#' + $(this).attr('id') + '"]');
        toggleIcon.addClass('expanded').find('i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    });
    
    $(document).on('hide.bs.collapse', '.collapse', function(e) {
        // Stop event propagation
        e.stopPropagation();
        
        // Only find the toggle icon that directly controls this collapse
        const toggleIcon = $('[data-target="#' + $(this).attr('id') + '"]');
        toggleIcon.removeClass('expanded').find('i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    });
    
    // Prevent collapse events from triggering multiple collapses
    $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function(e) {
        // Only trigger for the element that received the click
        if (e.target !== this) {
            e.stopPropagation();
        }
    });
    
     // Save EYLF selections - rest of the code remains the same
     $('#saveEylfSelections').on('click', function() {
        var selectedActivities = [];
        
        $('.eylf-activity-checkbox:checked').each(function() {
            var activityId = $(this).val();
            var outcomeId = $(this).data('outcome-id');
            var outcomeTitle = $(this).data('outcome-title');
            var outcomeName = $(this).data('outcome-name');
            var activityTitle = $(this).data('activity-title');
            
            selectedActivities.push({
                activityId: activityId,
                outcomeId: outcomeId,
                outcomeTitle: outcomeTitle,
                outcomeName: outcomeName,
                activityTitle: activityTitle
            });
        });
        
        // Format the selected activities for display in the textarea
        var formattedText = '';
        if (selectedActivities.length > 0) {
            selectedActivities.forEach(function(item, index) {
                formattedText += item.outcomeTitle + ' - ' + item.outcomeName + ': ' + item.activityTitle;
                if (index < selectedActivities.length - 1) {
                    formattedText += '\n';
                }
            });
        }
        
        // Set the formatted text in the textarea
        $('#eylf').val(formattedText);
        
        // Store the raw data in a hidden input for form submission
        if (!$('#eylfData').length) {
            $('<input>').attr({
                type: 'hidden',
                id: 'eylfData',
                name: 'eylfData'
            }).appendTo('form');
        }
        $('#eylfData').val(JSON.stringify(selectedActivities));
        
        // Close the modal
        $('#eylfModal').modal('hide');
    });

});

    </script>

<script>
        document.getElementById('fileUpload').addEventListener('change', function() {
    const maxFiles = 8;
    if (this.files.length > maxFiles) {
        alert(You can upload a maximum of ${maxFiles} images.);
        this.value = ''; // Clear the file input
    }
});
 
</script>

<script>
 document.addEventListener('DOMContentLoaded', function() {
    // Select form and necessary elements
    const form = document.querySelector('form');
    const addChildrenButton = document.querySelector('button[data-target="#selectChildrenModal"]');
    const childrenTagsContainer = document.querySelector('.children-tags');
    const submitButton = document.getElementById('submit-btn');

    // Create error modal if it doesn't exist
    function createErrorModal() {
        // Check if modal already exists
        if (document.getElementById('childrenErrorModal')) return;

        const modalHtml = `
        <div class="modal fade" id="childrenErrorModal" tabindex="-1" role="dialog" aria-labelledby="childrenErrorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="childrenErrorModalLabel">Validation Error</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Please select at least one child before submitting the reflection.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        `;

        // Create a temporary div to insert the modal
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = modalHtml.trim();
        document.body.appendChild(tempDiv.firstChild);
    }

    // Function to validate children selection
    function validateChildrenSelection() {
        const selectedChildren = childrenTagsContainer.querySelectorAll('input[name="childId[]"]');
        
        if (selectedChildren.length === 0) {
            // Create modal if not exists
            createErrorModal();
            
            // Show the modal using jQuery (assuming Bootstrap is used)
            if (window.jQuery && window.jQuery.fn.modal) {
                $('#childrenErrorModal').modal('show');
            } else {
                // Fallback alert if jQuery/Bootstrap is not available
                alert('Please select at least one child before submitting the reflection.');
            }
            
            return false;
        }
        return true;
    }

    // Add form submission event listener
    form.addEventListener('submit', function(event) {
        // Prevent form submission if no children are selected
        if (!validateChildrenSelection()) {
            event.preventDefault();
        }
    });

    // Optional: Validate on submit button click as well
    submitButton.addEventListener('click', function(event) {
        if (!validateChildrenSelection()) {
            event.preventDefault();
        }
    });

    // Optional: Remove error message when children are added
    const mutationObserver = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                // Close the modal if children are added
                if (window.jQuery && window.jQuery.fn.modal) {
                    $('#childrenErrorModal').modal('hide');
                }
            }
        });
    });

    // Start observing the children tags container
    mutationObserver.observe(childrenTagsContainer, { 
        childList: true 
    });
});
    </script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileUpload = document.getElementById('fileUpload');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const form = document.querySelector('form');
    const MAX_FILES = 8;
    let rotationAngles = {};
    let uploadedFiles = [];
    
    fileUpload.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        
        // Check if total files exceed the limit
        if (uploadedFiles.length + files.length > MAX_FILES) {
            alert(`You can only upload up to ${MAX_FILES} images. Please select fewer images.`);
            return;
        }
        
        // Process each selected file
        files.forEach(file => {
            if (!file.type.match('image.*')) {
                return;
            }
            
            // Create unique ID for each image
            const imageId = 'img_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            rotationAngles[imageId] = 0;
            uploadedFiles.push({
                id: imageId,
                file: file
            });
            
            // Create preview elements
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            previewItem.id = 'container_' + imageId;
            
            const counter = document.createElement('div');
            counter.className = 'img-counter';
            counter.textContent = uploadedFiles.length;
            
            const img = document.createElement('img');
            img.className = 'preview-img';
            img.id = imageId;
            
            const removeBtn = document.createElement('button');
            removeBtn.className = 'remove-btn';
            removeBtn.innerHTML = 'X';
            removeBtn.onclick = function(e) {
                e.preventDefault(); // Prevent form submission
                removeImage(imageId);
            };
            
            const controls = document.createElement('div');
            controls.className = 'preview-controls';
            
            const rotateLeftBtn = document.createElement('button');
            rotateLeftBtn.className = 'rotate-btn';
            rotateLeftBtn.innerHTML = '↺ Left';
            rotateLeftBtn.type = 'button'; // Explicitly set button type
            rotateLeftBtn.onclick = function(e) {
                e.preventDefault(); // Prevent form submission
                rotateImage(imageId, -90);
            };
            
            const rotateRightBtn = document.createElement('button');
            rotateRightBtn.className = 'rotate-btn';
            rotateRightBtn.innerHTML = '↻ Right';
            rotateRightBtn.type = 'button'; // Explicitly set button type
            rotateRightBtn.onclick = function(e) {
                e.preventDefault(); // Prevent form submission
                rotateImage(imageId, 90);
            };
            
            controls.appendChild(rotateLeftBtn);
            controls.appendChild(rotateRightBtn);
            
            previewItem.appendChild(img);
            previewItem.appendChild(counter);
            previewItem.appendChild(removeBtn);
            previewItem.appendChild(controls);
            
            imagePreviewContainer.appendChild(previewItem);
            
            // Read and display the image
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
        
        // Store the files in the file input
        updateFileInput();
    });
    
    function rotateImage(imageId, degrees) {
    console.log(`Rotating Image ID: ${imageId} by ${degrees} degrees`);

    const img = document.getElementById(imageId);
    rotationAngles[imageId] = (rotationAngles[imageId] + degrees + 360) % 360;
    img.style.transform = `rotate(${rotationAngles[imageId]}deg)`;

    // Find the index of this image in our uploadedFiles array
    const fileIndex = uploadedFiles.findIndex(item => item.id === imageId);
    console.log(`Rotation Angle for ${imageId}: ${rotationAngles[imageId]}`);

    // Ensure hidden input exists
    let hiddenField = $('#rotation_' + imageId);
    if (!hiddenField.length) {
        console.log(`Creating new hidden input for ${imageId}`);
        hiddenField = $('<input>').attr({
            type: 'hidden',
            id: 'rotation_' + imageId,
            name: 'image_rotation_' + fileIndex
        }).appendTo('form');
    }
    
    // Set the correct value
    hiddenField.val(rotationAngles[imageId]);

    console.log(`Final Hidden Input Value:`, hiddenField.val());
}


    
    function removeImage(imageId) {
        // Remove from uploadedFiles array
        uploadedFiles = uploadedFiles.filter(item => item.id !== imageId);
        
        // Remove rotation data
        delete rotationAngles[imageId];
        
        // Remove hidden field if exists
        const hiddenField = document.getElementById('rotation_' + imageId);
        if (hiddenField) hiddenField.remove();
        
        // Remove preview element
        document.getElementById('container_' + imageId).remove();
        
        // Update counters
        updateCounters();
        
        // Update the file input
        updateFileInput();
    }
    
    function updateCounters() {
        const counters = document.querySelectorAll('.img-counter');
        counters.forEach((counter, index) => {
            counter.textContent = index + 1;
        });
    }
    
    function updateFileInput() {
        if (typeof DataTransfer !== 'undefined') {
            const dataTransfer = new DataTransfer();
            uploadedFiles.forEach(item => {
                dataTransfer.items.add(item.file);
            });
            fileUpload.files = dataTransfer.files;
        }
    }
    
    // Handle form submission to include rotated images
    $('form').on('submit', function(e) {
    console.log('Form submission triggered, setting final values');

    // Loop through rotationAngles and update hidden input fields
    Object.keys(rotationAngles).forEach(imageId => {
        $('#rotation_' + imageId).val(rotationAngles[imageId]);
        console.log(`Setting rotation_${imageId} to ${rotationAngles[imageId]}`);
    });

    console.log('Serialized Form Data:', $(this).serialize());
});

});


</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const refineAboutBtn = document.querySelector(".refine-about-btn");

    if (refineAboutBtn) {
        refineAboutBtn.addEventListener("click", function () {
            const aboutTextarea = document.getElementById("about");
            const originalText = this.innerText;

            // Show "Refining..." while processing
            this.innerText = "Refining...";
            this.disabled = true;

            fetch("<?= base_url('observation/refine_text') ?>", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ text: aboutTextarea.value })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    aboutTextarea.value = data.refined_text;
                } else {
                    alert("Error refining text: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Something went wrong!");
            })
            .finally(() => {
                this.innerText = originalText;
                this.disabled = false;
            });
        });
    }
});

    </script>

</body>

</html>

<!-- <php echo base_url('Reflections/getForm?id=' . $room->id); ?> -->

<!-- <php $this->load->view('footer'); ?> -->