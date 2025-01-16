<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Announcements | Mykronicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <style>
        .list-thumbnail.xsmall{
            width: 40px;
        }
        .list-table td {
            vertical-align: middle!important;
        }
        .select-all-box{
            padding-left: 12px;
        }
        .select-all-box > label{
            margin-left: 22px;
            font-size: 15px;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <?php 
        //PHP Block
        $role = $this->session->userdata("UserType");
        if ($role == "Superadmin") {
            $edit = 1;
            $add = 1;
        } else {
            if ($role=="Staff") {
                if (isset($Permissions->addAnnouncement)) {
                    if ($Permissions->addAnnouncement==1) {
                        $add = 1;
                    } else {
                        $add = 0;
                    }
                    if ($Permissions->updateAnnouncement==1) {
                        $edit = 1;
                    } else {
                        $edit = 0;
                    }
                } else {
                    $edit = 0;
                    $add = 0;
                }
            }else{
                $edit = 1;
                $add = 0;
            }
        }
    ?>
    <main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Manage Announcements</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('announcements'); ?>">Announcements List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Announcement</li>
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
                            <form action="<?= base_url('announcements/save'); ?>" method="post" autocomplete="off">
                                <?php if (isset($announcement)) { ?>
                                <input type="hidden" name="annId" value="<?= $announcement->id; ?>">  
                                <?php } ?>
                                <input type="hidden" name="centerid" value="<?= $centerid; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" name="title" required="" value="<?= isset($announcement->title)?$announcement->title:''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Date</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control calendar" name="eventDate" value="<?= isset($announcement->eventDate)?date('d-m-Y',strtotime($announcement->eventDate)):''; ?>" data-date-format="dd-mm-yyyy">
                                                <span class="input-group-text input-group-append input-group-addon">
                                                    <i class="simple-icon-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-secondary mb-1" data-toggle="modal" data-backdrop="static" data-target="#selectChildrenModal"> + Add Children </button>
                                        </div>
                                        <div class="children-tags">                                            
                                            <?php 
                                                if (isset($Info) && !empty($announcement->children)) {
                                                    foreach ($announcement->children as $key => $obj) {
                                            ?>
                                            <a href="#!" class="rem" data-role="remove" data-child="<?= $obj->childid;?>">
                                                <input type="hidden" name="childId[]" value="<?= $obj->childid;?>">
                                                <span class="badge badge-pill badge-outline-primary mb-1"><?= $obj->name; ?> X </span>
                                            </a>
                                            <?php } } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="text" id="about"><?= isset($announcement->text)?$announcement->text:''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <?php 
                                            if (isset($announcement)) {
                                                if ($edit == 1) {
                                        ?>
                                        <button type="submit" class="btn btn-primary my-2">Save</button>
                                        <?php
                                                }else{
                                        ?>
                                        <button type="button" class="btn btn-primary my-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="You need permission to save!">Save</button>
                                        <?php
                                                }
                                            }else{
                                                if($add == 1){
                                        ?>
                                        <button type="submit" class="btn btn-primary my-2">Save</button>
                                        <?php
                                                }else{
                                        ?>
                                        <button type="button" class="btn btn-primary my-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="You need permission to save!">Save</button>
                                        <?php
                                                }
                                            }
                                        ?>
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
                <div class="modal-body">
                    <div class="form-group filter-box">
                        <input type="text" class="form-control" id="filter-child" placeholder="Enter child name or age to search">
                    </div>
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
                                <?php  foreach ($Childrens as $childkey => $childobj) { ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="common-child child-tab unique-tag" name="child[]" id="<?= 'child_'.$childobj->childid; ?>" value="<?= $childobj->childid; ?>" data-name="<?= $childobj->name. "- " .$childobj->age; ?>" <?= $childobj->checked; ?>>
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

    <?php $this->load->view('footer_v3'); ?>

    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <!-- <script src="<?= base_url('assets/v3'); ?>/js/vendor/ckeditor5-build-classic/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap-datepicker.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <script>
        $(document).ready(function() {


            var date = new Date();
            date.setDate(date.getDate());

            $('.calendar').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy',
                startDate: date,
                templates: {
                  leftArrow: '<i class="simple-icon-arrow-left"></i>',
                  rightArrow: '<i class="simple-icon-arrow-right"></i>'
                }
            });


            CKEDITOR.replace('about', {
                toolbar: [{
                    name: 'document',
                    items: ['Undo', 'Redo']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Strike', 'Format']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink', 'NumberedList', 'BulletedList']
                }]
            });

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
        });
    </script>
</body>
</html>