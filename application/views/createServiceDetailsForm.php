<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Service Details | Mydiaree</title>
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

</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
<main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
    <div class="default-transition">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Service Details</h1>
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
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0" style="background-color: transparent;">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('dashboard'); ?>" style="color: dimgray;">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Service Details</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
                <?php 
                    if(empty($_GET['centerid'])){
                        $_GET['centerid'] = 1;
                    }
                ?>
                <div class="col-lg-12 col-xl-12">
                    <h3 class="service-title">Service Details</h3>
                    <form action="<?= base_url('ServiceDetails/exeServiceForm?centerid=').$_GET['centerid']; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="form-row">
                            <input type="hidden" name="centerid" value="<?= $_GET['centerid']; ?>">
                            <div class="form-group col-md-6">
                                <label for="serviceName">Service Name</label>
                                <textarea class="form-control" id="serviceName" name="serviceName"><?= empty($ServiceDetails->serviceName)?null:$ServiceDetails->serviceName; ?></textarea>
                                <?php echo form_error('serviceName','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="serviceApprovalNumber">Service Approval Number</label>
                                <textarea class="form-control" id="serviceApprovalNumber" name="serviceApprovalNumber"><?= empty($ServiceDetails->serviceApprovalNumber)?null:$ServiceDetails->serviceApprovalNumber; ?></textarea>
                                <?php echo form_error('serviceApprovalNumber','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">Primary Contacts at Service</h3>
                                <div class="service-sub-title">Physical Location of Service</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="serviceStreet">Street</label>
                                <input type="text" class="form-control" id="serviceStreet" name="serviceStreet" value="<?php 
                                echo set_value('serviceStreet'); 
                                if(!empty($ServiceDetails->serviceStreet)){
                                    echo $ServiceDetails->serviceStreet;
                                }
                                ?>">
                                <?php echo form_error('serviceStreet','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="serviceSuburb">Suburb</label>
                                <input type="text" class="form-control" id="serviceSuburb" name="serviceSuburb" value="<?php 
                                echo set_value('serviceSuburb'); 
                                if(!empty($ServiceDetails->serviceSuburb)){
                                    echo $ServiceDetails->serviceSuburb;
                                }
                                ?>">
                                <?php echo form_error('serviceSuburb','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="serviceState">State/territory</label>
                                <input type="text" class="form-control" id="serviceState" name="serviceState" value="<?php 
                                echo set_value('serviceState');
                                if(!empty($ServiceDetails->serviceSuburb)){
                                    echo $ServiceDetails->serviceSuburb;
                                } 
                                ?>">
                                <?php echo form_error('serviceState','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="servicePostcode">Postcode</label>
                                <input type="text" class="form-control" id="servicePostcode" name="servicePostcode" value="<?php echo set_value('servicePostcode');
                                if(!empty($ServiceDetails->servicePostcode)){
                                    echo $ServiceDetails->servicePostcode;
                                } 
                                ?>">
                                <?php echo form_error('servicePostcode','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-sub-title">Physical Location Contact Details</h3>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="contactTelephone">Telephone</label>
                                <input type="text" class="form-control" id="contactTelephone" name="contactTelephone" value="<?php 
                                echo set_value('contactTelephone');
                                if(!empty($ServiceDetails->contactTelephone)){
                                    echo $ServiceDetails->contactTelephone;
                                }
                                ?>">
                                <?php echo form_error('contactTelephone','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="contactMobile">Mobile</label>
                                <input type="text" class="form-control" id="contactMobile" name="contactMobile" value="<?php 
                                echo set_value('contactMobile');
                                if(!empty($ServiceDetails->contactMobile)){
                                    echo $ServiceDetails->contactMobile;
                                }
                                ?>">
                                <?php echo form_error('contactMobile','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="contactFax">Fax</label>
                                <input type="text" class="form-control" id="contactFax" name="contactFax" value="<?php 
                                echo set_value('contactFax');
                                if(!empty($ServiceDetails->contactFax)){
                                    echo $ServiceDetails->contactFax;
                                }
                                ?>">
                                <?php echo form_error('contactFax','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="contactEmail">Email</label>
                                <input type="text" class="form-control" id="contactEmail" name="contactEmail" value="<?php
                                echo set_value('contactEmail');
                                if(!empty($ServiceDetails->contactEmail)){
                                    echo $ServiceDetails->contactEmail;
                                }
                                ?>">
                                <?php echo form_error('contactEmail','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-sub-title">Approved Provider</h3>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="providerContact">Primary contact</label>
                                <input type="text" class="form-control" id="providerContact" name="providerContact"  value="<?php 
                                echo set_value('providerContact');
                                if(!empty($ServiceDetails->providerContact)){
                                    echo $ServiceDetails->providerContact;
                                }
                                ?>">
                                <?php echo form_error('providerContact','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="providerTelephone">Telephone</label>
                                <input type="text" class="form-control" id="providerTelephone" name="providerTelephone" value="<?php 
                                echo set_value('providerTelephone'); 
                                if(!empty($ServiceDetails->providerTelephone)){
                                    echo $ServiceDetails->providerTelephone;
                                }
                                ?>">
                                <?php echo form_error('providerTelephone','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="providerMobile">Mobile</label>
                                <input type="text" class="form-control" id="providerMobile" name="providerMobile" value="<?php 
                                echo set_value('providerMobile'); 
                                if(!empty($ServiceDetails->providerMobile)){
                                    echo $ServiceDetails->providerMobile;
                                }
                                ?>">
                                <?php echo form_error('providerMobile','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="providerFax">Fax</label>
                                <input type="text" class="form-control" id="providerFax" name="providerFax" value="<?php echo set_value('providerFax');
                                    if(!empty($ServiceDetails->providerFax)){
                                        echo $ServiceDetails->providerFax;
                                    }
                                ?>">
                                <?php echo form_error('providerFax','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="providerEmail">Email</label>
                                <input type="text" class="form-control" id="providerEmail" name="providerEmail" value="<?php 
                                echo set_value('providerEmail'); 
                                if(!empty($ServiceDetails->providerEmail)){
                                    echo $ServiceDetails->providerEmail;
                                }
                                ?>">
                                <?php echo form_error('providerEmail','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-sub-title">Nominated Supervisor</h3>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="supervisorName">Name</label>
                                <input type="text" class="form-control" id="supervisorName" name="supervisorName" value="<?php 
                                echo set_value('supervisorName');
                                if(!empty($ServiceDetails->supervisorName)){
                                    echo $ServiceDetails->supervisorName;
                                }
                                ?>">
                                <?php echo form_error('supervisorName','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="supervisorTelephone">Telephone</label>
                                <input type="text" class="form-control" id="supervisorTelephone" name="supervisorTelephone"  value="<?php 
                                echo set_value('supervisorTelephone');
                                if(!empty($ServiceDetails->supervisorTelephone)){
                                    echo $ServiceDetails->supervisorTelephone;
                                } ?>">
                                <?php echo form_error('supervisorTelephone','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="supervisorMobile">Mobile</label>
                                <input type="text" class="form-control" id="supervisorMobile" name="supervisorMobile" value="<?php 
                                echo set_value('supervisorMobile'); 
                                if(!empty($ServiceDetails->supervisorMobile)){
                                    echo $ServiceDetails->supervisorMobile;
                                }
                                ?>">
                                <?php echo form_error('supervisorMobile','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="supervisorFax">Fax</label>
                                <input type="text" class="form-control" id="supervisorFax" name="supervisorFax" value="<?php 
                                echo set_value('supervisorFax'); 
                                if(!empty($ServiceDetails->supervisorFax)){
                                    echo $ServiceDetails->supervisorFax;
                                }
                                ?>">
                                <?php echo form_error('supervisorFax','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="supervisorEmail">Email</label>
                                <input type="text" class="form-control" id="supervisorEmail" name="supervisorEmail" value="<?php echo set_value('supervisorEmail'); 
                                if(!empty($ServiceDetails->supervisorEmail)){
                                    echo $ServiceDetails->supervisorEmail;
                                }
                                ?>">
                                <?php echo form_error('supervisorEmail','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-sub-title">Postal address (if different to physical location of service)</h3>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="postalStreet">Street</label>
                                <input type="text" class="form-control" id="postalStreet" name="postalStreet" value="<?php echo set_value('postalStreet'); 
                                if(!empty($ServiceDetails->postalStreet)){
                                    echo $ServiceDetails->postalStreet;
                                }
                                ?>">
                                <?php echo form_error('postalStreet','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="postalSuburb">Suburb</label>
                                <input type="text" class="form-control" id="postalSuburb" name="postalSuburb"  value="<?php echo set_value('postalSuburb'); 
                                if(!empty($ServiceDetails->postalSuburb)){
                                    echo $ServiceDetails->postalSuburb;
                                }?>">
                                <?php echo form_error('postalSuburb','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="postalState">State/territory</label>
                                <input type="text" class="form-control" id="postalState" name="postalState"  value="<?php 
                                echo set_value('postalState'); 
                                if(!empty($ServiceDetails->postalState)){
                                    echo $ServiceDetails->postalState;
                                }
                                ?>">
                                <?php echo form_error('postalState','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="postalPostcode">Postcode</label>
                                <input type="text" class="form-control" id="postalPostcode" name="postalPostcode"  value="<?php echo set_value('postalPostcode'); 
                                if(!empty($ServiceDetails->postalPostcode)){
                                    echo $ServiceDetails->postalPostcode;
                                }
                                ?>">
                                <?php echo form_error('postalPostcode','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="service-sub-title">Educational leader</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="eduLeaderName">Name</label>
                                <input type="text" class="form-control" id="eduLeaderName" name="eduLeaderName" value="<?php echo set_value('eduLeaderName'); 
                                if(!empty($ServiceDetails->eduLeaderName)){
                                    echo $ServiceDetails->eduLeaderName;
                                }?>">
                                <?php echo form_error('eduLeaderName','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="eduLeaderTelephone">Telephone</label>
                                <input type="text" class="form-control" id="eduLeaderTelephone" name="eduLeaderTelephone" value="<?php echo set_value('eduLeaderTelephone'); 
                                if(!empty($ServiceDetails->eduLeaderTelephone)){
                                    echo $ServiceDetails->eduLeaderTelephone;
                                }?>">
                                <?php echo form_error('eduLeaderTelephone','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="eduLeaderEmail">Email</label>
                                <input type="text" class="form-control" id="eduLeaderEmail" name="eduLeaderEmail" value="<?php echo set_value('eduLeaderEmail'); 
                                if(!empty($ServiceDetails->eduLeaderEmail)){
                                    echo $ServiceDetails->eduLeaderEmail;
                                }?>">
                                <?php echo form_error('eduLeaderEmail','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">Additional information about your service</h3>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="strengthSummary">Summary of strengths for Educational Program and practice</label>
                                <textarea class="form-control" id="strengthSummary" name="strengthSummary"><?php echo set_value('strengthSummary'); 
                                if(!empty($ServiceDetails->strengthSummary)){
                                    echo $ServiceDetails->strengthSummary;
                                }?></textarea>
                                <?php echo form_error('strengthSummary','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="childGroupService">How are the children grouped at your service?</label>
                                <textarea class="form-control" id="childGroupService" name="childGroupService"><?php echo set_value('childGroupService'); 
                                if(!empty($ServiceDetails->childGroupService)){
                                    echo $ServiceDetails->childGroupService;
                                }?></textarea>
                                <?php echo form_error('childGroupService','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="personSubmittingQip">Write the name and position of person(s) responsible for submitting this Quality Improvement Plan (e.g. Cheryl Smith, Nominated Supervisor)</label>
                                <textarea class="form-control" id="personSubmittingQip" name="personSubmittingQip"><?php echo set_value('personSubmittingQip'); 
                                if(!empty($ServiceDetails->personSubmittingQip)){
                                    echo $ServiceDetails->personSubmittingQip;
                                }?></textarea>
                                <?php echo form_error('personSubmittingQip','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="educatorsData">For family day care services, indicate the number of educators currently registered in the service and attach a list of the educators and their addresses.</label>
                                <textarea class="form-control" id="educatorsData" name="educatorsData"><?php echo set_value('educatorsData'); 
                                if(!empty($ServiceDetails->educatorsData)){
                                    echo $ServiceDetails->educatorsData;
                                }?></textarea>
                                <?php echo form_error('educatorsData','<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">Service statement of philosophy</h3>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="philosophyStatement">Please insert your service’s statement of philosophy here.</label>
                                <textarea class="form-control" id="philosophyStatement" name="philosophyStatement"><?php echo set_value('philosophyStatement'); 
                                if(!empty($ServiceDetails->philosophyStatement)){
                                    echo $ServiceDetails->philosophyStatement;
                                }?></textarea>
                                <?php echo form_error('philosophyStatement','<span class="text-danger">', '</span>'); ?>
                            </div>
                            <!-- </div>
                            <div class="form-row"> -->
                            <div class="col-sm-12 text-right" style="padding: 10px 10px 10px 0px;">
                                <!-- <button type="button" class="btn btn-danger">Cancel</button> -->
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

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
	$(document).ready(function(){
		$('#centerId').on('change',function(){
			centerId = $(this).val();
			window.location.href = "<?php echo base_url('ServiceDetails'); ?>?centerId="+centerId;
		});
	});
</script>
</html>