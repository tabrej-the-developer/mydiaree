<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Assessment | Mydiaree</title>  
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css" />
    <!-- <link rel="stylesheet" href="<?#= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css" /> -->
    <style>
        tr > td{
            vertical-align: middle!important;
        }
        .x-50{
            height: 50px;
            width: 50px;
        } 
    </style>
</head>
<body id="app-container" class="menu-default show-spinner">
<?php 
    $this->load->view('sidebar'); 
    $role = $this->session->userdata('UserType');
    if ($role == "Superadmin") {
        $add = 1;
        $edit = 1; 
        $delete = 1; 
        $view = 1; 
    } else if ($role == "Staff") {
        $add = isset($Permissions->add)?$Permissions->add:0;
        $edit = isset($Permissions->edit)?$Permissions->edit:0; 
        $delete = isset($Permissions->delete)?$Permissions->delete:0; 
        $view = isset($Permissions->view)?$Permissions->view:0; 
    } else {
        $add = 0;
        $edit = 0; 
        $delete = 0; 
        $view = 0; 
    }
?> 
<main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>
    <div class="default-transition">
        <div class="container-fluid">
            <div class="row">
                <!-- self assessment data  -->
                <div class="col-12">
                    <h1>Self Assessment</h1>
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
                        <?php if($add == 1){ ?>
                        <button class="btn btn-primary btn-lg" id="createSelfAsmnt">
                            <i class="iconsminds-add"></i> ADD NEW test
                        </button>
                        <?php }else{ ?>
                        <button class="btn btn-primary btn-lg" data-toggle="tooltip" data-placement="top" title="" data-original-title="Insufficient permission!">
                            <i class="iconsminds-add"></i> ADD NEW
                        </button>
                        <?php } ?>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0" style="background-color: transparent;">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Self Assessment</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
                <div class="col-12">
                    <?php 
                        if(isset($_GET['status'])){
                            if ($_GET['status']=="success") {
                    ?>
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                      <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                      </symbol>
                      <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                      </symbol>
                      <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                      </symbol>
                    </svg>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="alert alert-success alert-dismissible fade show rounded mb-4" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                                    <use xlink:href="#check-circle-fill"/>
                                </svg> You've successfully deleted "<strong><?= empty($_GET['slfasmnt'])?'the asessment':$_GET['slfasmnt']; ?></strong>". 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                            } else {
                                
                            }
                            
                        }
                    ?>
                    <div class="card">
                        <div class="card-body">
                            <?php if (isset($Records) && !empty($Records)) { ?>
                            <table class="table table-condensed table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <td width="5%">Sl.</td>
                                        <td width="20%">Name</td>
                                        <td align="right">Educators</td>
                                        <td width="10%">Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $k = 1;
                                        foreach ($Records as $key => $obj) { 
                                    ?>
                                    <tr>
                                        <td width="5%"><?= $k; ?></td>
                                        <td width="20%">
                                            <a class="text-dark" href="<?= base_url('SelfAssessment/edit').'?id='.$obj->id; ?>">
                                                <?= $obj->name; ?>
                                            </a>
                                        </td>
                                        <td align="right">
                                            <?php if(!empty($obj->educators)){ ?>
                                                <div class="eduMember">
                                                    <?php 
                                                        $count = count($obj->educators);
                                                        for ($i=0; $i < $count ; $i++) { 
                                                            if ($obj->educators[$i]->imageUrl == "") {
                                                                $imgurl = "https://via.placeholder.com/50";
                                                            } else {
                                                                $imgurl = base_url("api/assets/media/").$obj->educators[$i]->imageUrl;
                                                            }
                                                            if ($i==4) {
                                                                break;
                                                            }
                                                    ?>
                                                    <span class="user-images">
                                                        <img class="rounded-circle x-50" src="<?= $imgurl; ?>" title="<?= $obj->educators[$i]->name; ?>">
                                                    </span>
                                                    <?php } 
                                                        if ($count > 4) {
                                                            $total = $count - 4;
                                                    ?>
                                                    <span class="moreLast col-4"><?= "+".$total; ?></span>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td width="10%" align="center">
                                            <div class="btn-group">
                                                <?php if ($edit == 1) { ?>
                                                <a class="btn btn-outline-primary btn-xs" href="<?= base_url('SelfAssessment/edit').'?id='.$obj->id; ?>">
                                                    <i class="simple-icon-pencil"></i>
                                                </a>
                                                <?php } else { ?>
                                                <a class="btn btn-outline-primary btn-xs" href="#!" onclick="return alert('You don\'t have enough permission');">
                                                    <i class="simple-icon-pencil"></i>
                                                </a>
                                                <?php } ?>
                                                
                                                <?php 
                                                    if ($delete == 1) {
                                                ?>
                                                <a onclick="return confirm('Do you really want to delete?');" class="btn btn-outline-danger btn-xs" href="<?= base_url('SelfAssessment/delete').'?id='.$obj->id; ?>">
                                                    <i class="simple-icon-trash"></i>
                                                </a>
                                                <?php
                                                    } else {
                                                ?>
                                                <a onclick="return alert('You don\'t have enough permission');" class="btn btn-outline-danger btn-xs" href="#!">
                                                    <i class="simple-icon-trash"></i>
                                                </a>
                                                <?php
                                                    }
                                                    
                                                ?>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $k++; } ?>
                                </tbody>
                            </table>
                            <?php } else { ?>
                            <h2 class="text-center"> Self assessments list is empty! </h2>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- END SELF ASSESSMENT -->
            </div>
        </div>
    </div>
</main>

<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js"></script> 
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/datatables.min.js"></script>
</body>
<script>
	function deleteqip(id)
	{
		if (confirm('Are you Want Delete ?')) {
			var url="<?php echo base_url('qip/delete'); ?>?id="+id;
			location = url;
		 } else {
			return false;
       }
	}

	$("#centerId").on('change',function(){
	   $("#centerDropdown").submit();
	});

	$("#createSelfAsmnt").on("click",function(){
   
		let center = <?= $centerid; ?>;
		let url = "<?php echo base_url('selfassessment/add-new-self-assessment'); ?>?centerid="+center;
        //console.log({url});
        
		window.location.href = url;
	});
</script>
</html>