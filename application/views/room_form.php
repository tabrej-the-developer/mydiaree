<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $room->name; ?> | Rooms</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.1.0"/>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .d-flex-custom{
            align-items: center;
            justify-content: space-between;
        }
        .card-text {
            font-size: 26px;
        }
        .child-checkbox{
            height: 15px;
            width: 15px;
        }
        span.radio-label{
            margin-bottom: 0px;
            margin-right: 10px;
        }
        .list-thumbnail{
            width: 85px!important;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php 
        $this->load->view('sidebar'); 
        $usertype = $this->session->userdata('UserType');
        $userid = $this->session->userdata('LoginId');
    ?>
    <main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1><?= $room->name; ?></h1>
                    <div class="text-zero top-right-button-container">
                        <div class="btn-group mr-1">
                            <button data-toggle="modal" data-target="#newChildModal" class="btn btn-primary"> + NEW CHILDREN </button>
                        </div>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Room/getList?centerid='.$room->centerid); ?>">Rooms</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"><?= $room->name; ?></li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="iconsminds-building"></i>
                            <h3>Room Capacity</h3>
                            <div class="card-text"><?= $room->capacity; ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="iconsminds-building"></i>
                            <h3>Room Occupancy</h3>
                            <div class="room-occupancy d-flex d-flex-custom">
                                <div class="days">
                                    <div class="days-name">M</div>
                                    <div class="days-occupancy" style="color: #008ecc;"><?= $room->occupancy->Mon; ?></div>
                                </div>
                                <div class="days">
                                    <div class="days-name">T</div>
                                    <div class="days-occupancy" style="color: #008ecc;"><?= $room->occupancy->Tue; ?></div>
                                </div>
                                <div class="days">
                                    <div class="days-name">W</div>
                                    <div class="days-occupancy" style="color: #008ecc;"><?= $room->occupancy->Wed; ?></div>
                                </div>
                                <div class="days">
                                    <div class="days-name">T</div>
                                    <div class="days-occupancy" style="color: #008ecc;"><?= $room->occupancy->Thu; ?></div>
                                </div>
                                <div class="days">
                                    <div class="days-name">F</div>
                                    <div class="days-occupancy" style="color: #008ecc;"><?= $room->occupancy->Fri; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="iconsminds-building"></i>
                            <h3>Active Childs</h3>
                            <?php 
                                $count=0; 
                                foreach($roomChilds as $child) { if($child->status=='Active') { $count++; } }
                            ?>
                            <div class="card-text"> <?= $count; ?> </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="iconsminds-building"></i>
                            <h3>Room Vacancy</h3>
                            <div class="card-text"><?= $room->capacity - $count; ?></div>
                        </div>
                    </div>
                </div> 
            </div>
            <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
            <ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">CHILDS</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">EDUCATORS</a>
    </li>
</ul>
<button id="manageEducatorsBtn" class="btn btn-outline-primary" style="margin-left:1111px;margin-bottom:15px; display: none;" onclick="loadEducators()" >Manage Educators</button>


            <div class="tab-content">
                <div class="tab-pane show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                    <div class="row my-2">
                        <div class="col-12 text-right">
                            <!-- <button class="btn btn-outline-primary btn-xs"><i class="iconsminds-filter-2"></i> Filters</button> -->
                            <a href="<?= $sort_name; ?>" class="btn btn-outline-primary btn-xs"><i class="iconsminds-up---down"></i> Order by</a>
                            <button class="btn btn-outline-primary btn-xs" id="moveChildren"><i class="iconsminds-shuffle"></i> Move</button>
                            <button class="btn btn-outline-danger btn-xs btn-delete-child"><i class="simple-icon-trash"></i> Delete</button>
                        </div>
                    </div>
                    <div class="row">
                        <?php 
                            foreach($roomChilds as $child) {

                                if(empty($child->recentobs)){
                                    $obsUrl = "#!";
                                } else {
                                    $obsUrl = base_url('observation/view?id=') . $child->recentobs->id;
                                }

                                $date1 = new DateTime($child->dob);
                                $date2 = new DateTime(date('Y-m-d'));
                                $diff = $date1->diff($date2); 
                        ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card d-flex flex-row mb-4">
                                <a class="d-flex" href="<?php echo base_url('room/editChild?id='.$id.'&childId='.$child->id); ?>">
                                    <?php 
                                        if($child->imageUrl != ""){
                                            if (file_exists('api/assets/media/'.$child->imageUrl)) {
                                                $img = base_url('/api/assets/media/'.$child->imageUrl);
                                            }else{
                                                $img = "https://via.placeholder.com/100x100?text=No+Media";
                                            }
                                        }else{
                                            $img = "https://via.placeholder.com/100x100?text=No+Media";
                                        }
                                    ?>
                                    <img alt="Profile" src="<?= $img; ?>" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
                                </a>
                                <div class=" d-flex flex-grow-1 min-width-zero" style="width:909px;">
                                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                                        <div class="min-width-zero">
                                            <a href="<?= base_url('room/editChild?id='.$id.'&childId='.$child->id); ?>">
                                                <p class="list-item-heading mb-1 truncate"><?= $child->name; ?></p>
                                            </a>
                                            <p class="mb-2 text-muted text-small"><?= $diff->y,' years'; ?></p>
                                            <a href="<?= $obsUrl; ?>" class="btn btn-xs btn-outline-primary ">Last observation</a>
                                        </div>
                                    </div>
                                    <div class="d-flex d-flex-custom pr-3">
                                        <input type="checkbox" class="child-checkbox" value="<?= $child->id; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    
                </div>
                <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                    <div class="row">
                        <?php if(empty($roomStaff)){ ?>
                        <div class="col-12 text-center">
                            <h3>No staffs found!</h3>
                        </div>
                        <?php }else{ 
                            foreach ($roomStaff as $staffkey => $staffobj) {
                        ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card d-flex flex-row mb-4">
                                <a class="d-flex" href="#">
                                    <?php 
                                        if (empty($staffobj->imageUrl)) {
                                            $image = "https://via.placeholder.com/86x86?text=No+Image";
                                        } else {
                                            if(file_exists('api/assets/media/'.$staffobj->imageUrl)){
                                                $image = base_url('api/assets/media/'.$staffobj->imageUrl);
                                            }else{
                                                $image = "https://via.placeholder.com/86x86?text=No+Image";
                                            }
                                        }
                                        
                                    ?>
                                    <img alt="Profile" src="<?= $image; ?>" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
                                </a>
                                <div class=" d-flex flex-grow-1 min-width-zero" style="width:909px;">
                                    <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                                        <div class="min-width-zero">
                                            <a href="#">
                                                <p class="list-item-heading mb-1 truncate"><?= $staffobj->userName;?></p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php       
                            }
                        }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="moveChilds" id="moveChildsForm" method="post">
                    <div class="modal-header rmc-modal-header">
                        <h4 class="modal-title">Move children to</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="rooms-list"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Move Children</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="newChildModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Child</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('Room/addChild'); ?>" id="form-child" method="post" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                <input type="hidden" value="<?= isset($centerid)?$centerid:null; ?>" name="centerId">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">First Name *</label>
                            <span class="text-danger error_firstname"></span>
                            <input type="text" name="firstname" id="firstname" placeholder="Enter first name" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Last Name *</label>
                            <span class="text-danger error_lastname"></span>
                            <input type="text" name="lastname" id="lastname" placeholder="Enter last name" class="form-control" required>
                        </div>
                    </div>

                  
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="dob">Date of Birth *</label>
        <span class="text-danger error_dob"></span>
        <input type="text" name="dob" id="dob" value="" class="form-control date-input" required>
    </div>
    <div class="form-group col-md-6">
        <label for="doj">Date of Join *</label>
        <span class="text-danger error_doj"></span>
        <input type="text" name="startDate" id="doj" value="" class="form-control date-input" required>
    </div>
</div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="gender">Gender *</label>
                            <div class="d-flex">
                                <span class="radio-label">
                                    <input type="radio" name="gender" id="radioMale" value="Male" checked><label for="radioMale">&nbsp;Male</label> &nbsp;
                                </span>
                                <span class="radio-label">
                                    <input type="radio" name="gender" id="radioFemale" value="Female"><label for="radioFemale">&nbsp;Female</label>&nbsp;
                                </span>
                                <span class="radio-label">
                                    <input type="radio" name="gender" id="radioOther" value="Other"><label for="radioOther">&nbsp;Other</label>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="status">Status *</label>            
                            <select id="status" name="status" class="form-control">
                                <option value="Active" selected>Active</option>
                                <option value="In Active">In Active</option>
                                <option value="Enrolled">Enrolled</option>                                             
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="uploadImg">Choose Image</label>
                            <input id="uploadImg" name="file" class="form-control"  type="file"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="daysAttending">Days Attending *</label>         
                            <div class="flexCheck">
                                <input type="checkbox" name="mon" value="1" id="Monday" checked><label for="Monday">&nbsp;Monday</label>&nbsp;&nbsp;
                                <input type="checkbox" name="tue" value="1" id="Tuesday" checked><label for="Tuesday">&nbsp;Tuesday</label>&nbsp;&nbsp;
                                <input type="checkbox" name="wed" value="1" id="Wednesday" checked><label for="Wednesday">&nbsp;Wednesday</label>&nbsp;&nbsp;
                                <input type="checkbox" name="thu" value="1" id="Thursday" checked><label for="Thursday">&nbsp;Thursday</label>&nbsp;&nbsp;
                                <input type="checkbox" name="fri" value="1" id="Friday" checked><label for="Friday">&nbsp;Friday</label>&nbsp;&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-add-child">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Modal HTML -->
<div class="modal fade" id="educatorsModal" tabindex="-1" role="dialog" aria-labelledby="educatorsModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="educatorsModalLabel">Manage Educators</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="max-height:450px;overflow-y:auto;">
        <div id="educatorsList"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveEducators()">Save Changes</button>
      </div>
    </div>
  </div>
</div>

    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js"></script>
</body>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
    const BASE_URL = "<?= base_url(); ?>";
</script>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get the query string from the URL
            const queryString = window.location.search;
            
            // Create a URLSearchParams object to easily parse the query string
            const urlParams = new URLSearchParams(queryString);
            
            // Extract roomId and centerId
            const roomId = urlParams.get('id');
            const centerId = urlParams.get('centerId');
            
            // Set values to hidden input fields
            document.getElementById("roomId").value = roomId || "";
            document.getElementById("centerId").value = centerId || "";
        });
    </script>


<script>
    $(document).ready(function(){
        //$('.btn-delete-child').on('click', function() {
        //    let _childIds = [];
        //    $.each($('.child-checkbox:checked'), function(index, val) {
        //        _childIds.push(val.value);
       //     });
        //    if (_childIds.length > 0) {
       //         if(confirm('Are you sure to delete?')){
       //             $.ajax({
        //                url: '<?= base_url("Room/deleteChilds"); ?>',
         //               type: 'POST',
         //               data: {childids: JSON.stringify(_childIds)},
        //            })
        //            .done(function(msg) {
        //                msg = $.parseJSON(msg);
        //                if (msg.Status == "SUCCESS") {
        //                    $('.child-checkbox:checked').closest('.col-lg-4').hide('slow');
        //                } else {
        //                    alert(msg.Message);
       //                 }
        //            });
        //        }
        //    } else {
        //        alert('Please select a children first!');
        //    }
       // });

       $('.btn-delete-child').on('click', function() {
    let _childIds = [];
    $.each($('.child-checkbox:checked'), function(index, val) {
        _childIds.push(val.value);
    });

    // Check if any child is selected
    if (_childIds.length > 0) {
        // Show confirmation only if children are selected
        if (confirm('Are you sure to delete?')) {
            $.ajax({
                url: '<?= base_url("Room/deleteChilds"); ?>',
                type: 'POST',
                data: {childids: JSON.stringify(_childIds)},
            })
            .done(function(msg) {
                msg = $.parseJSON(msg);
                if (msg.Status == "SUCCESS") {
                    $('.child-checkbox:checked').closest('.col-lg-4').hide('slow');
                } else {
                    alert(msg.Message);
                }
            });
        }
    } else {
        // Alert if no children are selected
        alert('Please select a child first!');
    }
});


        $(document).on('click',"#moveChildren",function(){

            $("#rooms-list").empty();

            var _childIds = [];
            const urlParams = new URLSearchParams(window.location.search);
            var roomId = urlParams.get('id');
           
            var userid = <?= $this->session->userdata('LoginId'); ?>;

            $.each($('.child-checkbox:checked'), function(index, val) {
                _childIds.push(val.value);
                $("#rooms-list").append('<input type="hidden" name="childid[]" value="'+val.value+'">');
            });

            if (_childIds.length > 0) {
                $('#myModal').modal('show');
                $.ajax({
                    traditional:true,
                    type: "GET",
                    url: "<?= base_url('Room/loadRooms'); ?>/"+userid+"/"+roomId,
                    success: function(msg){
                        var res = jQuery.parseJSON(msg);
                        if (res.Rooms.length == 0) {
                            $("#rooms-list").append(`<p class='text-center'>You currently have only one room in this center. Please create some rooms first.</p>`);
                            $('#moveChildsForm').find('button[type="submit"]').hide();
                        }else{
                            for (let i = 0; i < res.Rooms.length; i++) {
                                $("#rooms-list").append(`
                                    <div class="form-group">
                                        <input type="radio" name="rooms" value="`+res.Rooms[i].id+`">
                                        <label>&nbsp;`+res.Rooms[i].name+`</label>
                                    </div>
                                `);
                            }
                            $('#moveChildsForm').find('button[type="submit"]').show();
                        }
                    }
                });
            } else {
                $('#myModal').modal('hide');
                alert('Please select a children first!');
            }
            
        });
    });


    function loadEducators() {
        const queryString = window.location.search; // e.g., "?id=1251376692&centerId=104"
    
    // Create a URLSearchParams object to easily parse the query string
    const urlParams = new URLSearchParams(queryString);
    
    // Extract roomId and centerId
    const roomId = urlParams.get('id');
    const centerId = urlParams.get('centerId');
    
    // Log the values to verify
    console.log('roomId:', roomId);
    console.log('centerId:', centerId);


    $.ajax({
        url: '<?= base_url("room/manageEducators") ?>',
        type: 'GET',
         data: { 
            roomId: roomId,
            centerId: centerId 
        },
        success: function(response) {
            const data = typeof response === 'string' ? JSON.parse(response) : response;
            console.log(data);
            if (data.status === 'success') {
                let html = '<div class="form-group">';
                
                data.educators.forEach(educator => {
    const isChecked = data.assigned_staff.includes(educator.userid) ? 'checked' : '';
    const imageUrl = educator.imageUrl 
                    ? `${BASE_URL}/api/assets/media/${educator.imageUrl}` 
                    : "https://via.placeholder.com/100x100?text=No+Media";
    
    html += `
        <div class="checkbox d-flex align-items-center mb-2">
            <img src="${imageUrl}" alt="${educator.name}" class="rounded-circle mr-3" style="width: 50px; height: 50px; object-fit: cover;">
            <label class="flex-grow-1 mb-0">
                <input type="checkbox" name="educator" value="${educator.userid}" ${isChecked}>
                ${educator.name}
            </label>
        </div>
    `;
});

                
                html += '</div>';
                $('#educatorsList').html(html);
                $('#educatorsModal').modal('show');
            } else {
                alert('Error loading educators. Please try again.');
            }
        },
        error: function() {
            alert('Failed to connect to the server. Please try again.');
        }
    });
}

function saveEducators() {
    const selectedStaff = [];
    $('input[name="educator"]:checked').each(function() {
        selectedStaff.push($(this).val());
    });
    
    const urlParams = new URLSearchParams(window.location.search);
    const roomId = urlParams.get('id');
    
    $.ajax({
        url: '<?= base_url("room/updateEducators") ?>',
        type: 'POST',
        data: {
            roomId: roomId,
            selectedStaff: JSON.stringify(selectedStaff)
        },
        success: function(response) {
            const result = typeof response === 'string' ? JSON.parse(response) : response;
            
            if (result.status === 'success') {
                alert('Educators updated successfully!');
                $('#educatorsModal').modal('hide');
                location.reload();
            } else {
                alert('Error updating educators. Please try again.');
            }
        },
        error: function() {
            alert('Failed to connect to the server. Please try again.');
        }
    });
}



</script>


<script>
$(document).ready(function() {
    // Show the button when the second tab is clicked
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        if ($(e.target).attr('id') === 'second-tab') {
            $('#manageEducatorsBtn').show(); // Show the button
        } else {
            $('#manageEducatorsBtn').hide(); // Hide the button
        }
    });
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    flatpickr(".date-input", {
        dateFormat: "d-m-Y", // Set date format
        allowInput: true,    // Allow manual typing
        static: true,        // Ensures the calendar stays near the input
        appendTo: document.body, // Fixes the positioning inside modals
    });

    // Auto-format while typing (DD-MM-YYYY)
    document.querySelectorAll(".date-input").forEach(input => {
        input.addEventListener("input", function (e) {
            let value = this.value.replace(/\D/g, ""); // Remove non-numeric characters
            if (value.length > 2) value = value.slice(0, 2) + "-" + value.slice(2);
            if (value.length > 5) value = value.slice(0, 5) + "-" + value.slice(5);
            this.value = value.slice(0, 10); // Max length of 10 chars (DD-MM-YYYY)
        });
    });
});

</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelector("#form-child").addEventListener("submit", function (event) {
        let button = document.querySelector(".btn-add-child");
        button.disabled = true;
        button.innerHTML = "Submitting...";
    });
});
    </script>

</html>