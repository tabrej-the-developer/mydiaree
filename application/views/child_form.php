<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Child | Mydiaree</title>
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
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>

    <style>
    	.btn:hover{
    		line-height: inherit!important;
    	}
    	.content{
    		display: flex;
    		align-items: center;
    	}
    	.panel-footer{
    		display: flex;
    		align-items: center;
    		justify-content: space-between;
    	}
    	.content-links{
    		display: flex;
    		align-items: center;
    		justify-content: space-evenly;
    	}
    	.content-section-img > img {
    		height: 50px;
    		width: 50px;
    	}
    	.content-section-info{
    		font-size: 18px;
    	}
    	.progress-edit,.progress-delete{
    		margin: 0px 5px;
    	}
    </style>
</head>
<body id="app-container" class="menu-default" style="background-color: #f8f8f8; top: -35px; bottom:0px;">
<?php $this->load->view('sidebar'); ?> 
<main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
    <div class="default-transition" style="opacity: 1;">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12" style="margin-top: -15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h1><?php echo empty($child)?'Add Children':'Edit Children'; ?></h1>
                            <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                                <ol class="breadcrumb pt-0" style="background-color: transparent;">
                                    <li class="breadcrumb-item">
                                        <a href="#" style="color: dimgray;">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#" style="color: dimgray;">Rooms List</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#" style="color: dimgray;">View Rooms</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Child</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="separator mb-5"></div>
                </div>

                <div class="col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-12 mb-5 card ">
                            <ul class="nav nav-tabs separator-tabs ml-0 mb-5 pt-2" role="tablist">
                                <li class="nav-item "><a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="presentation" aria-controls="first" aria-selected="false">Basic Details</a></li>
                                <li class="nav-item "><a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="presentation" aria-controls="second" aria-selected="false">Progress Notes</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                                    <form action="" id="form-child" class="addChild" method="post" enctype="multipart/form-data" autocomplete="off">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="firstname">First Name *</label>
                                                <span class="text-danger error_firstname"></span>
                                                <input type="text" name="firstname" id="firstname" value="<?php echo !empty($child->name)?$child->name:''; ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="lastname">Last Name *</label>
                                                <span class="text-danger error_lastname"></span>
                                                <input type="text" name="lastname" id="lastname" value="<?php echo !empty($child->lastname)?$child->lastname:''; ?>" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="dob">Date of Birth *</label>
                                                <span class="text-danger error_dob"></span>
                                                <?php 
                                                    if(isset($child->dob)){
                                                        $new_date = date("Y-m-d", strtotime($child->dob));
                                                    }
                                                ?>
                                                <input type="date" name="dob" id="dob" data-date-format="YYYY-MM-DD" value="<?php echo isset($child->dob)? $new_date:''; ?>" class="form-control bs-datepicker" onkeydown="return false">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="doj">Date of Join *</label>
                                                <span class="text-danger error_doj"></span>
                                                <?php 
                                                if(isset($child->startDate)){
                                                    $start_date=date("Y-m-d", strtotime($child->startDate));
                                                }
                                                ?>
                                                <input type="date" name="startDate" id="doj" data-date-format="YYYY-MM-DD" value="<?php echo isset($child->startDate)? $start_date:''; ?>" class="form-control" onkeydown="return false">
                                            </div>
                                        </div>    
                                        
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="gender">Gender *</label>
                                                <select id="gender" name="gender" class="form-control">
                                                    <?php if(isset($child->gender) && $child->gender=='Female') { ?>
                                                    <option value="Male">Male</option>
                                                    <option value="Female" selected>Female</option>
                                                    <option value="Other">Other</option>
                                                    <?php } else if (isset($child->gender) && $child->gender=='Other') { ?>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other" selected>Other</option>
                                                    <?php } else { ?>
                                                    <option value="Male" selected>Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                    <?php } ?>				
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="status">Status *</label>			
                                                <select id="status" name="status" class="form-control">
                                                    <?php if(isset($child->status) && $child->status=='Enrolled') { ?>
                                                    <option value="Active">Active</option>
                                                    <option value="In Active">In Active</option>
                                                    <option value="Enrolled" selected>Enrolled</option>
                                                    <?php } else if(isset($child->status) && $child->status=='In Active') { ?>
                                                    <option value="Active">Active</option>
                                                    <option value="In Active" selected>In Active</option>
                                                    <option value="Enrolled" >Enrolled</option>
                                                    <?php } else { ?>
                                                    <option value="Active" selected>Active</option>
                                                    <option value="In Active">In Active</option>
                                                    <option value="Enrolled">Enrolled</option>
                                                    <?php } ?>
                                                    
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="daysAttending">Days Attending *</label>			
                                                <div class="flexCheck">
                                                    <input type="checkbox" name="mon" value="1" id="Monday" checked><label for="Monday">&nbsp;Monday</label>&nbsp;&nbsp;
                                                    <input type="checkbox" name="tue" value="1" id="Tuesday" checked><label for="Tuesday">&nbsp;Tuesday</label>&nbsp;&nbsp;
                                                    <input type="checkbox" name="wed" value="1" id="Wednesday" checked><label for="Wednesday">&nbsp;Wednesday</label>&nbsp;&nbsp;
                                                    <input type="checkbox" name="thu" value="1" id="Thursday" checked><label for="Thursday">&nbsp;Thursday</label>&nbsp;&nbsp;
                                                    <input type="checkbox" name="fri" value="1" id="Friday" checked><label for="Friday">&nbsp;Friday</label>&nbsp;&nbsp;
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <img class="text-left rounded-circle" onClick="updImg();" id="blah"  style="height: 110.92px;width: 103px;" src="<?php if(isset($child->imageUrl) && $child->imageUrl) {echo $child->imageUrl; } else { echo base_url('assets/images/icons/uploadimage.png'); } ?>">
                                                <input id="uploadImg" name="file"  type="file" style="opacity: 0;" />
                                                <p class="text-primary">(Click on the image to upload a new profile pic)</p>
                                            </div>
                                        </div>

                                        <div class="row moredetails" style="display: none;">		
                                            <div class="col-sm-6">
                                                <h4 style="margin-top: 30px;">About family and child</h4>
                                                <div class="childdiv">
                                                    <span class="childlabel">
                                                        My age on starting at this center
                                                    </span></br>
                                                    <span>
                                                        <input type="text" name="age_on_center"  value="<?php echo isset($child->age_on_center)?$child->age_on_center:''; ?>" class="childinput">
                                                    </span>
                                                </div>
                                                <div class="childdiv">
                                                    <span class="childlabel">
                                                        My First language at home
                                                    </span></br>
                                                    <span>
                                                        <input type="text" name="first_language"  value="<?php echo isset($child->first_language)?$child->first_language:''; ?>" class="childinput">
                                                    </span>
                                                </div>
                                                <h4 style="margin-top: 25px;">Intereste and Preferences</h4>
                                                <div class="childdiv">
                                                    <span class="childlabel">
                                                        Things that excite me and make me happy
                                                    </span></br>
                                                    <span>
                                                        <input type="text" name="things_happy"  value="<?php echo isset($child->things_happy)?$child->things_happy:''; ?>" class="childinput">
                                                    </span>
                                                </div>
                                                <div class="childdiv">
                                                    <span class="childlabel">
                                                        Things I like doing outside
                                                    </span></br>
                                                    <span>
                                                        <input type="text" name="things_outside"  value="<?php echo isset($child->things_outside)?$child->things_outside:''; ?>" class="childinput">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                </br></br>
                                                <div class="childdiv">
                                                    <span class="childlabel">
                                                        I like to be called
                                                    </span></br>
                                                    <span>
                                                        <input type="text" name="nick_name"  value="<?php echo isset($child->nick_name)?$child->nick_name:''; ?>" class="childinput">
                                                    </span>
                                                </div>
                                                <div class="childdiv">
                                                    <span class="childlabel">
                                                        Other languages in my family
                                                    </span></br>
                                                    <span>
                                                        <input type="text" name="other_language"  value="<?php echo isset($child->other_language)?$child->other_language:''; ?>" class="childinput">
                                                    </span>
                                                </div>
                                                </br>
                                                </br>
                                                <div class="childdiv">
                                                    <span class="childlabel">
                                                        My favourite books, rhymes, activities, toys and places to go
                                                    </span></br>
                                                    <span>
                                                        <input type="text" name="favourite"  value="<?php echo isset($child->favourite)?$child->favourite:''; ?>" class="childinput">
                                                    </span>
                                                </div>
                                                <div class="childdiv">
                                                    <span class="childlabel">
                                                        My weekly routines
                                                    </span></br>
                                                    <span>
                                                        <input type="text" name="weekly_routines"  value="<?php echo isset($child->weekly_routines)?$child->weekly_routines:''; ?>" class="childinput">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <div class="col-md-12 text-right">
                                                <a href="<?php echo base_url('room/getForm?id='.$id); ?>" class="btn btn-danger">Cancel</a>
                                                <button type="button" onclick="saveChild();"  class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade col-12 row m-0 p-0" id="second" role="tabpanel" aria-labelledby="second-tab">
                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> + Add</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row mb-4">
                                        <?php foreach($child_arr as $userss => $user): ?>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="card p-3">
                                                <div class="panel panel-default">
                                                    <div class="panel-body mb-3">
                                                        <div class="content">
                                                            <div class="content-section-img">
                                                                <img src="<?= BASE_API_URL."assets/media/".$user->image;?>" class="img-circle rounded-circle" alt="">
                                                            </div>
                                                            <div class="content-section-info text-info ml-3">
                                                                <?php echo $user->name; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="panel-footer row p-3" style="background-color:#f6f6f6; padding-bottom: 5px; margin-bottom: -15px;">
                                                            <div class="content-links btn-group">
                                                                <div class="progress-edit btn btn-outline-primary btn-xs m-0" data-p="<?= $user->p_development ?>" data-e="<?= $user->emotion_development ?>" data-s="<?= $user->social_development ?>" data-c="<?= $user->child_interests ?>" data-o="<?= $user->other_goal ?>" data-whatever="@mdo" data-id="<?= $user->id ?>" data-userid="<?= $user->created_by ?>">
                                                                    <i class="simple-icon-pencil"></i>
                                                                </div>
                                                                <div class="progress-delete btn btn-outline-danger btn-xs" data-id="<?= $user->id ?>" data-userid="<?= $user->created_by ?>">
                                                                    <i class="simple-icon-trash"></i>
                                                                </div>
                                                            </div>
                                                            <div class="text-right text-primary col-lg-8 col-sm-12"><?= date("d-M-Y", strtotime($user->created_at)); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="separator mb-5"></div>

                <!-- Model -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                        <div class="modal-dialog" role="document" style="width:700px !important;">
                            <div class="modal-content">
                                <div class="modal-header ui-draggable-handle">
                                    <h4 class="modal-title" id="exampleModalLabel">Add Notes</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('Room/addProgressNote'); ?>" method="POST">
                                    <div class="modal-body ref-modal-links ps">
                                        <input type="hidden" name="childid" value="<?= $_GET['childId'] ?>">
                                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                        <input type="hidden" name="centerid" value="<?= $centerid; ?>">
                                        <div class="form-group row m-auto w-100 d-flex mb-5">
                                            <label for="inputEmail3" class="col-sm-12 col-md-4 text-primary">Physical Development </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control" id="edit-physical" name="p_development">
                                            </div>
                                        </div>
                                        <div class="form-group row m-auto w-100 d-flex mb-5">
                                            <label for="inputEmail3" class="col-sm-12 col-md-4 text-primary">Emotional Development </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control" id="edit-emotional" name="emotion_development">
                                            </div>
                                        </div>
                                        <div class="form-group row m-auto w-100 d-flex mb-5">
                                            <label for="inputEmail3" class="col-sm-12 col-md-4 text-primary">Social Developmet </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control" id="edit-social" name="social_development">
                                            </div>
                                        </div>
                                        <div class="form-group row m-auto w-100 d-flex mb-5">
                                            <label for="inputEmail3" class="col-sm-12 col-md-4 text-primary">Child's Interests </label>
                                            <div class="col-sm-12 col-md-8">
                                                <input type="text" class="form-control" id="edit-child" name="child_interests">
                                            </div>
                                        </div>
                                        <div class="form-group row m-auto w-100 d-flex ">
                                            <label for="inputEmail3" class="col-sm-12 col-md-4 text-primary">Other Goal's </label>
                                            <div class="col-sm-12 col-md-8">
                                            <input type="text" class="form-control" id="edit-other" name="other_goal">
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                        <button type="submit" id="saveImgAttr" class="btn btn-primary myModalBtn">Save changes</button>
                                    </div>
                                </form> 
                                
                            </div>
                        </div>
                    </div>
                <!-- End Model -->

                <!-- UPDATE FORM -->
                <script>
                    $(document).on('click','.progress-edit',function(){
                        var updatingid = $(this).data('id');
                        var p = $(this).data('p');
                        var e = $(this).data('e');
                        var s = $(this).data('s');
                        var c = $(this).data('c');
                        var o = $(this).data('o');
                        // alert(updatingid);
                        $("#updatingId").val(updatingid);
                        $('#physical').val(p);
                        $('#emotional').val(e);
                        $('#social').val(s);
                        $('#child').val(c);
                        $('#other').val(o);
                        $('#updateModal').modal('show');
                    });
                </script>
                <?php foreach($child_arr as $userss => $user): ?>
                <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                    <div class="modal-dialog" role="document" style="width:700px !important;">
                        <div class="modal-content">
                            <div class="modal-header ui-draggable-handle">
                                <h4 class="modal-title" id="exampleModalLabel">Add Notes</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body ref-modal-links ps">
                                <form action="<?php echo base_url('Room/updateProgressNote'); ?>" method="POST">
                                    <input type="hidden" name="childid" value="<?= $_GET['childId'] ?>">
                                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                    <input type="hidden" name="centerid" value="<?= $centerid; ?>">
                                    <input type="hidden" name="updatingId" id="updatingId">
                                <div class="form-group row m-auto w-100 d-flex mb-5">
                                    <label for="inputEmail3" class="col-sm-12 col-md-4 text-primary">Physical Development </label>
                                    <div class="col-sm-12 col-md-8">
                                        <input type="text" class="form-control" id="physical" name="p_development" placeholder="">
                                    </div>
                                </div> 
                                <div class="form-group row m-auto w-100 d-flex mb-5">
                                    <label for="inputEmail3" class="col-sm-12 col-md-4 text-primary">Emotional Development </label>
                                    <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control" id="emotional" name="emotion_development" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row m-auto w-100 d-flex mb-5">
                                    <label for="inputEmail3" class="col-sm-12 col-md-4 text-primary">Social Developmet </label>
                                    <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control" id="social" name="social_development" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row m-auto w-100 d-flex mb-5">
                                    <label for="inputEmail3" class="col-sm-12 col-md-4 text-primary">Child's Interests </label>
                                    <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control" id="child" name="child_interests" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row m-auto w-100 d-flex">
                                    <label for="inputEmail3" class="col-sm-12 col-md-4 text-primary">Other Goal's </label>
                                    <div class="col-sm-12 col-md-8">
                                    <input type="text" class="form-control" id="other" name="other_goal" placeholder="">
                                    </div>
                                </div>
                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                    <button type="submit" id="saveImgAttr" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <!-- UPDATE FORM CLOSE -->

            </div>
        </div>
    </div>
</main>

<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery.smartWizard.min.js" style="opacity: 1;"></script>
</body>

<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    var modal = $(this)

    });
</script>
<script>
	function updImg()
	{
		$("#uploadImg").click();
	}

	$("#uploadImg").change(function() {
	  readURL(this);
	});

	function readURL(input) {
	  if (input.files && input.files[0]) {
	    var reader = new FileReader();	    
	    reader.onload = function(e) {
	      $('#blah').attr('src', e.target.result);
	    }	    
	    reader.readAsDataURL(input.files[0]); // convert to base64 string
	  }
	}

	var id="<?php echo $id; ?>";
	var childId="<?php echo $childId; ?>";
	function saveChild()
	{
		var json=true;
		if($("input[name=firstname]").val()=='')
		{
			json=false;
			$('.error_firstname').html('(Please Enter Firstname)');
		}else{
			$('.error_firstname').html('');
		}
		if($("input[name=lastname]").val()=='')
		{
			json=false;
			$('.error_lastname').html('(Please Enter Lastname)');
		}else{
			$('.error_lastname').html('');
		}
		if($("input[name=dob]").val()=='')
		{
			json=false;
			$('.error_dob').html('(Please Select Date of Birth)');
		}else{
			$('.error_dob').html('');
		}
		if($("input[name=startDate]").val()=='')
		{
			json=false;
			$('.error_doj').html('(Please Select Date of Join)');
		}else{
			$('.error_doj').html('');
		}
		if(json)
		{
			if(childId)
			{
				var url="<?php echo base_url('room/editChild'); ?>?id="+id+"&childId="+childId;
				var test= url.replace(/&amp;/g, '&');
				document.getElementById("form-child").action =test;
				document.getElementById("form-child").submit();
				
			}else{
				var url="<?php echo base_url('room/addChild'); ?>?id="+id;
				var test= url.replace(/&amp;/g, '&');
				document.getElementById("form-child").action =test;
				document.getElementById("form-child").submit();
			}
			
		}
	}
	
	$(document.body).delegate('.viewarea', 'click', function() {
		if($(this).hasClass("active"))
		{
			$(this).removeClass("active");
			$('.imgview').html('<img    src="<?php echo base_url('assets/images/icons/DownArrowBule.png'); ?>">');
			$('.moredetails').hide();
		}else{
			$(this).addClass("active");
			$('.imgview').html('<img    src="<?php echo base_url('assets/images/icons/UpArrowBule.png'); ?>">');
			$('.moredetails').show();
		}
      });

	$(document).ready(function(){
		$("#firstname").keypress(function (e) {
		var keyCode = e.keyCode || e.which;
		let regex = /^[A-Za-z]+$/;
		var isValid = regex.test(String.fromCharCode(keyCode))
		$(".error_firstname").html("");
		if (!isValid) {
                $(".error_firstname").html("Only Alphabets allowed.");
            }
            return isValid;
		});
		$('#lastname').keypress(function (e) {
			var keyCode = e.keyCode || e.which;
			let regex = /^[A-Za-z]+$/;
			var isValid = regex.test(String.fromCharCode(keyCode))
			$(".error_lastname").html("");
			if (!isValid) {
					$(".error_lastname").html("Only Alphabets allowed.");
				}
				return isValid;
		});
	})

	$(document).on('click','.progress-delete',function(){
		var id = $(this).data('id');
		$.ajax({
			traditional:true,
			url: "<?php echo base_url('Room/deleteProgressNote'); ?>",
			type: "POST",
			data:{"pnid":id},
			success: function(msg){
				res=JSON.parse(msg);
				if (res.Status == "SUCCESS") {
					location.reload();
				} else {
					console.log(res.Message);
				}
			}
		});
	});


</script>
</html>