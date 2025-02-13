<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rooms List | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css" />
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
        input[type='color']{
            padding: 0rem 0.10rem;
        }
        .card-title {
            margin-bottom: 0rem!important;
        }
        .d-flex-custom{
            align-items: center;
            justify-content: space-between;
        }
        .rooms{
            height: 15px;
            width: 15px;
        }
        .card-title > span {
            color: darkgray;
            font-size: 13px;
            font-style: italic;
        }
        .delete-room,.delete-rooms-btn{
            cursor: pointer;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php //echo "hello";
        $this->load->view('sidebar'); 
        $usertype = $this->session->userdata('UserType');
        $userid = $this->session->userdata('LoginId');
        if (isset($userType)) {
            if ($userType=="Superadmin") {
                $addRoom = 1;
                $deleteRoom = 1;
                $viewRoom = 1;
                $editRoom = 1;
            }elseif($userType=="Staff"){

                if ($permission != NULL && $permission->addRoom == 1) {
                  $addRoom = 1;
                } else {
                  $addRoom = 0;
                }

                if ($permission != NULL && $permission->deleteRoom == 1) {
                  $deleteRoom = 1;
                } else {
                  $deleteRoom = 0;
                }

                if ($permission != NULL && $permission->viewRoom == 1) {
                  $viewRoom = 1;
                } else {
                  $viewRoom = 0;
                }

                if ($permission != NULL && $permission->editRoom == 1) {
                  $editRoom = 1;
                } else {
                  $editRoom = 0;
                }

            }else{
                $addRoom = 0;
                $deleteRoom = 0;
                $viewRoom = 0;
                $editRoom = 0;
            }
        }else{
          $addRoom = 0;
          $deleteRoom = 0;
          $viewRoom = 0;
          $editRoom = 0;
        }
        // echo "$defcenter - nxxnju";
    ?>
    <main data-centerid="<?= isset($defcenter)?$defcenter:null; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Rooms List</h1>
                    <div class="text-zero top-right-button-container">
                        <div class="btn-group mr-1">
                            <?php 
                                $dupArr = [];
                                $centersList = $this->session->userdata("centerIds");
                                if (empty($centersList)) {
                            ?>
                                <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                                    EMPTY CENTER 
                                </div>
                            <?php
                                }else{
                                    if (isset($_GET['centerid'])) {
                                        foreach($centersList as $key => $center){
                                            if ( ! in_array($center, $dupArr)) {
                                                if ($_GET['centerid']==$center->id) {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                                <?= strtoupper($center->centerName); ?> 
                            </div>
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
                            
                            
                            if ($addRoom == 1) { 
                        ?>
                        <button type="button" class="btn btn-primary btn-lg top-right-button add-room" data-toggle="modal" data-target="#roomModal">ADD NEW</button>
                        <?php } ?>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Rooms List</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <div class="input-group typeahead-container">
                        <input type="text" class="form-control typeahead" name="filter_name" id="filter_name" placeholder="Start typing room name or child name to search..." data-provide="typeahead" autocomplete="off">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary default" id="button-search">
                                <i class="simple-icon-magnifier"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-right">
                    <select name="filter_status" id="filter_status" class="form-control">
                        <option value="">--Select--</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">In Active</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <?php if ($deleteRoom == 1) { ?>
                    <button type="button" class="btn btn-outline-primary btn-block delete-rooms-btn" onclick="deleteRoom();" disabled>
                        <i class="simple-icon-trash"></i> Delete
                    </button>
                    <?php } ?>
                </div>
            </div>

            <div class="row">
                <?php 
                    if($viewRoom == 1){
                        $counter = 1; 
                        foreach($rooms as $room) {
                    ?>
                    <div class="col-md-4">
                        <div class="card my-3">
                            <div class="card-body" style="border-left: 5px solid <?php echo $room->color; ?>; border-radius: inherit;">
                                <div class="mb-3 d-flex d-flex-custom">
                                    <div class="room-info d-flex d-flex-custom">
                                        <input type="checkbox" class="rooms" id="<?= "check_".$counter; ?>" name="rooms[]" value="<?php echo $room->id; ?>"> &nbsp;
                                        <a href="<?= base_url('room/getForm?id=' . $room->id. '&centerId='. $defcenter ); ?>" style="color: <?php echo $room->color; ?>;">
                                            <h3 class="card-title">
                                                <?php echo ucfirst($room->name); ?> <span><?= ($room->status != "Active")?'('.$room->status.')':''; ?></span>
                                            </h3>
                                        </a>
                                    </div>
                                    
                                    <div class="room-action">
                                        <a href="#!" id="dropdown-<?= $counter; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="simple-icon-options-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdown-<?= $counter; ?>">
                                            <a class="dropdown-item view-room" href="<?= base_url('room/getForm?id=' . $room->id); ?>">View</a>
                                            <?php if($editRoom == 1){ ?>
                                            <a class="dropdown-item edit-room" href="#!" data-roomid="<?= $room->id; ?>" data-toggle="modal" data-target="#roomModal">Edit</a>
                                            <?php } ?>
                                            <?php 
                                                if ($deleteRoom == 1) {
                                                    $delete = 1;
                                                }else{
                                                    if ($userid == $room->created_by) {
                                                        $delete = 1;
                                                    }else{
                                                        $delete = 0;
                                                    }
                                                }

                                                if ($delete == 1) {
                                            ?>
                                                <a class="dropdown-item delete-room" data-href="<?= base_url('room/delete/'.$room->id); ?>">Delete</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="roomChild" >
                                        <i class="iconsminds-reddit"></i>
                                        <?php echo sprintf("%02d", count($room->childs)); ?> Children
                                    </div>
                                    <div class="roomLeader" >
                                        <i class="simple-icon-people"></i>
                                       
                                        <?php echo $room->userName ? ucfirst($room->userName) : ''; ?> (Lead)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        $counter++; }
                    }else{ 
                ?>
                <div class="col">
                    <div class="text-center">
                        <h6 class="mb-4">Ooops... looks like you lack of permission!</h6>
                        <p class="mb-0 text-muted text-small mb-0">Error code</p>
                        <p class="display-1 font-weight-bold mb-5">
                            200
                        </p>
                        <a href="<?= base_url('dashboard'); ?>" class="btn btn-primary btn-lg btn-shadow">GO BACK HOME</a>
                    </div>
                </div>
                <?php } ?>
            </div>  
        </div>
    </main>

    <?php $this->load->view('footer_v3'); ?>

    <div class="modal fade" id="roomModal" tabindex="-1" role="dialog" aria-labelledby="filtersModalRight" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roomModalLabel">Add Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" id="form-room" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="dcenterid" value="<?= $defcenter; ?>">
                                <div class="form-group">
                                    <label for="txtRoomName">Name</label>
                                    <input type="text" name="room_name" id="txtRoomName" placeholder="e.g Adventures" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="txtRoomCapacity">Capacity</label>
                                    <input type="text" name="room_capacity" id="txtRoomCapacity" placeholder="e.g 20" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="txtFromAge">From Age</label>
                                            <input type="text" name="ageFrom" id="txtFromAge" min="0" placeholder="e.g 0" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="txtToAge">To Age</label>
                                            <input type="text" name="ageTo" id="txtToAge" min="0" placeholder="e.g 5" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="txtRoomStatus">Status</label>
                                            <select name="room_status" id="txtRoomStatus" class="form-control">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="txtRoomColor">Color</label>
                                            <input type="color" name="room_color" id="txtRoomColor" value="#009DFF" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txtRoomEducators">Educators</label>
                                    <select id="txtRoomEducators" name="educators[]" class="form-control select2-multiple" multiple="multiple" data-width="100%">
                                        <?php foreach($users as $user) { ?>
                                            <option value="<?= $user->userid; ?>"><?= $user->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>          
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-room-btn" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js"></script>
</body>
<script>

    $(document).on('click', '#save-room-btn', function(){
        $('#form-room').prop('action','<?= base_url('Room/add/'); ?>').submit();
    });

    $(document).on('click', '#edit-room-btn', function(){
        $('#form-room').prop('action','<?= base_url('Room/edit/'); ?>').submit();
    });

    $(document).on('click', '.edit-room', function(){
        $('#form-room').append(`<input type='hidden' class='hidden-room-id' name='id' value='` + $(this).data('roomid') + `'>`);
        $('#roomModalLabel').text('Edit Room');
        $('#save-room-btn').prop('id','edit-room-btn');
    });

    $(document).on('click', '.add-room', function(){
        $("#form-room").find('.hidden-room-id').remove();
        $('#roomModalLabel').text('New Room');
        $('#edit-room-btn').prop('id','save-room-btn');
        $('#form-room').trigger("reset");
        $("#txtRoomEducators").val([]).change();
    });

    function editRoom(id)
    {
        var url='<?php echo base_url(); ?>room/getRoom?id='+id;
        $('#modal-room').remove();
        $.ajax({
            url: url,
            dataType: 'html',
            success: function(html) {
                $('.container').append(html);
                $('#modal-room').modal('show');
            }
        });
    }

    function saveRoom()
    {
      var url="<?php echo base_url('room/add'); ?>";
      var test= url.replace(/&amp;/g, '&');
      document.getElementById("form-room").action =test;
      document.getElementById("form-room").submit();
    }

    $(document).on('click', '.rooms', function(){
        count = $('.rooms:checked').length;
        if(count>0){
            $('button.delete-rooms-btn').removeAttr("disabled");
            $('#filter_status').removeAttr("disabled");
        }else{
            $('.delete-rooms-btn').prop("disabled","disabled");
            $('#filter_status').prop("disabled","disabled");
        }
    });

    $('#filter_status').change(function(){
        var _url="<?php echo base_url('Room/changeStatus'); ?>";
        var _status = $(this).val();
        var _rooms = [];
        $.each($('.rooms:checked'), function(index, val) {
            _rooms.push(val.value);
        });

        if(_status != ""){
            $.ajax({
                url: _url,
                type: 'POST',
                data: {rooms: _rooms, filter_status:_status},
            })
            .done(function(msg) {
                res = $.parseJSON(msg);
               // console.log(res);
                
                if (_status == "Inactive") {
                    $('.rooms:checked').siblings('a').find('span').text('('+_status+')');
                }else{
                    $('.rooms:checked').siblings('a').find('span').text('');
                }
            });
        }
    });

    function deleteRoom()
    {
      if(confirm('Are you sure you want to delete?')){
        let _rooms = [];
        $.each($('.rooms:checked'), function(index, val) {
            _rooms.push(val.value);
        });

        $.ajax({
            url: '<?php echo base_url('Room/deleteRoom'); ?>',
            type: 'POST',
            data: {rooms: _rooms, centerid: <?= $defcenter; ?>},
        })
        .done(function(msg) {
            res = $.parseJSON(msg);
            if (res.Status == "SUCCESS") {
                location.reload();
            } else {
                alert(res.Message);
            }
        });
        
      }
    }

    $('#button-search').on('click', function() {
        console.log("SEARCH CLCIKED: ");
        var url="<?php echo base_url('Room/getList'); ?>";	
        var filter_name = $('input[name=\'filter_name\']').val();
        if (filter_name) { url += '?filter_name=' + encodeURIComponent(filter_name); }
        // console.log("URl : ",url);
        location = url;
    });
</script>
<script>
    //code written by Sagar
    $(document).on('click', '.delete-room', function(event) {
        event.preventDefault();
        let _confirm = confirm('Are you sure you want to delete this room?');
        let _objectDelete = $(this);
        let _url = $(this).data('href');
        if(_confirm){
            $.ajax({
                url: _url,
                type: 'POST'
            })
            .done(function(response) {
                console.log(response);
                res = $.parseJSON(response);
                if(res.Status == "SUCCESS"){
                    _objectDelete.closest('.col-md-4').fadeOut(1500, function() { $(this).remove() });
                }else{
                    alert(res.Message);
                }
            });
        }
    });

    $(document).on('click', '.edit-room', function(){
        let _roomid = $(this).data('roomid');
        $.ajax({
            url: '<?= base_url("Room/getRoomDetails"); ?>/' + _roomid ,
            type: 'GET'
        })
        .done(function(response) {
            let educatorTags = [];
            response = $.parseJSON(response);
            $('#txtRoomName').val(response.room.name);
            $('#txtRoomCapacity').val(response.room.capacity);
            $('#txtFromAge').val(response.room.ageFrom);
            $('#txtToAge').val(response.room.ageTo);
            $('#txtRoomStatus').val(response.room.status);
            $('#txtRoomColor').val(response.room.color);
            $(response.educators).each(function(){
                educatorTags.push(this.id);
            });
            $("#txtRoomEducators").val(educatorTags);
            $('#txtRoomEducators').trigger('change');
        });  
    }); 
</script>
</html>