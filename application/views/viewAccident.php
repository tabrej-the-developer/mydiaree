<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Accident | Mydiaree</title>
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
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.signature.css'); ?>"> 
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/component-custom-switch.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/custom-styles.css?v=1.0.0" />
    <style>
        .modal-footer {
        display: inline-block;
        width: 100%;
        padding: 0px 30px 15px;
        height: inherit;
        margin: 0px;
        }

        .modal-body{
            padding: 0px 30px;
        }

        #person_sign{
            display: none;
        } 

        #witness_sign{
            display: none;
        }

        /* #incharge_sign{
            display: none;
        } */

        /* #supervisor_sign{
            display: none;
        } */

        .check-control{
            width: 35px;
        }
        .select2-container{
            width:100% !important;
        }
    </style>
</head>
<body id="app-container" class="menu-default">
    <?php $this->load->view('sidebar'); ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Add Accidents</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('accident?centerid=').$_GET['centerid'].'&roomid='.$_GET['roomid']; ?>">Accident</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">View Accidents</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>  
            <div class="row">
                <div class="col-12 mb-5 card pt-4">
                    <h3 class="service-title text-primary">INCIDENT, INJURY, TRAUMA, & ILLNESS RECORD</h3>
                    <form action="#!" class="flexDirColoumn" method="post" id="acc-form" enctype="multipart/form-data" autocomplete="off">
                        <!-- <input type="hidden" name="centerid" value="<?#= $_GET['centerid']; ?>">
                        <input type="hidden" name="roomid" value="<?#= $_GET['roomid']; ?>"> -->

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">Details of person completing this record</h3>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="person_name" placeholder="<?= $AccidentInfo->person_name; ?>" value="<?= $AccidentInfo->person_name; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="role">Position Role</label>
                                <input type="text" class="form-control" id="role" name="person_role" placeholder="<?= $AccidentInfo->person_role; ?>" value="<?= $AccidentInfo->person_role; ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="Record">Date Record was made</label>
                                <input type="date" class="form-control" id="Record" name="date" placeholder="<?= $AccidentInfo->date; ?>" value="<?= $AccidentInfo->date; ?>">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="Time">Time</label>
                                <input type="text" class="form-control" id="Time" name="time" placeholder="<?= $AccidentInfo->time; ?>" value="<?= $AccidentInfo->time; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    Signature&nbsp;
                                    <span class="editbtn text-primary" data-toggle="modal" data-target="#signModal" data-identity="person_sign"><i class="simple-icon-pencil"></i></span>
                                </label>
                                <input type="hidden" class="form-control" id="person_sign_dt" disabled>
                                <div id="#person_sign">
                                    <!-- <input type="hidden" name="person_sign" id="person_sign_txt"  value="<?#= $AccidentInfo->person_sign; ?>"> -->
                                    <img src="<?= base_url('/api/assets/media/').$AccidentInfo->person_sign; ?>" height="120px" width="300px" id="person_sign_img">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">Child Details</h3>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="childid" class="col-sm-12 pl-0">Select Child</label>
                                <select name="childid" id="childid" class="form-control js-example-basic-single">
                                    <option value="<?php $AccidentInfo->child_name ?>"><?php echo $AccidentInfo->child_name ?></option>
                                </select>
                                <input type="hidden" class="form-control" id="childfullname" name="child_name" value="">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="birthdate">Date of Birth</label>
                                <input type="text" class="form-control" id="birthdate" name="child_dob" value="<?php $AccidentInfo->child_dob ?>" placeholder="<?php echo $AccidentInfo->child_dob ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="age">Age</label>
                                <input type="text" class="form-control" id="age" name="child_age" value="" placeholder="<?= $AccidentInfo->child_age; ?>">     
                            </div>
                            <div class="form-group col-md-6">
                                <label for="<?= $AccidentInfo->child_gender; ?>">Gender </label>
                                <div class="radioFlex">
                                    <label for="<?= $AccidentInfo->child_gender; ?>"><input class="m-1" type="radio" id="<?= $AccidentInfo->child_gender; ?>" name="gender" value="<?= $AccidentInfo->child_gender; ?>" <?php if($AccidentInfo->child_gender) { echo "checked"; } ?> ><?= $AccidentInfo->child_gender; ?></label>
                                    <!-- <label for="Female"><input class="m-1" type="radio" id="Female" name="gender" value="Female">Female</label>
                                    <label for="Others"><input class="m-1" type="radio" id="Others" name="gender" value="Others">Others</label> -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">Incident Details</h3>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="incidentdate">Incident Date</label>
                                <input type="text" class="form-control" id="incidentdate" name="incident_date" placeholder="<?= $AccidentInfo->incident_date; ?>">     
                            </div>
                            <div class="form-group col-md-6">
                                <label for="incidenttime">Time</label>
                                <input type="text" class="form-control" id="incidenttime" name="incident_time" placeholder="<?= $AccidentInfo->incident_time; ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="location">Location</label>
                                <input type="text" class="form-control" id="location" name="incident_location" placeholder="<?= $AccidentInfo->incident_location; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="witnessname">Name of Witness</label>
                                <input type="text" class="form-control" id="witnessname" name="witness_name" placeholder="<?= $AccidentInfo->witness_name; ?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="witness-date">Date</label>
                                <input type="text" class="form-control" id="witness-date" name="witness_date" placeholder="<?= $AccidentInfo->witness_date; ?>">     
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    Signature
                                    <span class="simple-icon-pencil text-primary editbtn" data-toggle="modal" data-target="#signModal" data-identity="witness_sign"></span>
                                </label>
                                <!-- <input type="text" class="form-control" id="witness_sign_dt" disabled> -->
                                <div id="#witness_sign">
                                    <!-- <input type="hidden" name="witness_sign" id="witness_sign_txt" value=""> -->
                                    <img src="<?= base_url('/api/assets/media/').$AccidentInfo->witness_sign; ?>" height="120px" width="300px" id="witness_sign_img">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="genActivity">General activity at the time of incident/ injury/ trauma/ illness:</label>
                                <textarea class="form-control" id="genActivity" name="gen_actyvt"><?= $AccidentInfo->gen_actyvt; ?></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="causeInjury">Cause of injury/ trauma:</label>
                                <textarea class="form-control" id="causeInjury" name="cause"><?= $AccidentInfo->cause; ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="symptoms">Circumstances surrounding any illness, including apparent symptoms: </label>
                                <textarea class="form-control" id="symptoms" name="illness_symptoms"><?= $AccidentInfo->illness_symptoms; ?></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="missingChild">Circumstances if child appeared to be missing or otherwise unaccounted for (incl duration, who found child etc.):</label>
                                <textarea class="form-control" id="missingChild" name="missing_unaccounted"><?= $AccidentInfo->missing_unaccounted; ?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="Circumstances">Circumstances if child appeared to have been taken or removed from service or was locked in/out of service (incl who took the child, duration): </label>
                                <textarea class="form-control" id="Circumstances" name="taken_removed"><?= $AccidentInfo->taken_removed; ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">Nature of Injury/ Trauma/ Illness:</h3>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="svgFlex col-12 row">
                                    <span class="col-md-6 col-sm-12">
                                        <!-- <canvas id="c" width="500" height="500"></canvas> -->
                                        <img src="<?= base_url('api/assets/media/').$AccidentInfo->injury_image; ?>" alt="" srcset="">
                                    </span>
                                    <span class="col-md-6 col-sm-12">
                                        <input type="hidden" name="injury_image" id="injury-image" value="">
                                        <ul class="col-12 row">
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type1">
                                                    <input type="checkbox" name="abrasion" value="1" <?php if($AccidentInfo->abrasion){ echo "checked"; } ?>> Abrasion/ Scrape
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type2">
                                                    <input type="checkbox" name="electric_shock" value="1" <?php if($AccidentInfo->electric_shock){ echo "checked"; } ?>> Electric Shock
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type3">
                                                    <input type="checkbox" name="allergic_reaction" value="1" <?php if($AccidentInfo->allergic_reaction){ echo "checked"; } ?>> Allergic reaction
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type4">
                                                    <input type="checkbox" name="high_temperature" value="1" <?php if($AccidentInfo->high_temperature){ echo "checked"; } ?>> High Temperature
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type5">
                                                    <input type="checkbox" name="amputation" value="1" <?php if($AccidentInfo->amputation){ echo "checked"; } ?>> Amputation
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type6">
                                                    <input type="checkbox" name="infectious_disease" value="1" <?php if($AccidentInfo->infectious_disease){ echo "checked"; } ?>> Infectious Disease (inc gastrointestinal)
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type7">
                                                    <input type="checkbox" name="anaphylaxis" value="1" <?php if($AccidentInfo->anaphylaxis){ echo "checked"; } ?>> Anaphylaxis
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type8">
                                                    <input type="checkbox" name="ingestion" value="1" <?php if($AccidentInfo->ingestion){ echo "checked"; } ?>> Ingestion/ Inhalation/ Insertion
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type9">
                                                    <input type="checkbox" name="asthma" value="1" <?php if($AccidentInfo->asthma){ echo "checked"; } ?>> Asthma/ Respiratory
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type10">
                                                    <input type="checkbox" name="internal_injury" value="1" <?php if($AccidentInfo->internal_injury){ echo "checked"; } ?>> Internal injury/ Infection
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type11">
                                                    <input type="checkbox" name="bite_wound" value="1" <?php if($AccidentInfo->bite_wound){ echo "checked"; } ?>> Bite Wound
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type12">
                                                    <input type="checkbox" name="poisoning" value="1" <?php if($AccidentInfo->poisoning){ echo "checked"; } ?>> Poisoning
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type13">
                                                    <input type="checkbox" name="broken_bone" value="1" <?php if($AccidentInfo->broken_bone){ echo "checked"; } ?>> Broken Bone/ Fracture/ Dislocation
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type14">
                                                    <input type="checkbox" name="rash" value="1" <?php if($AccidentInfo->rash){ echo "checked"; } ?>> Rash
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type15">
                                                    <input type="checkbox" name="burn" value="1" <?php if($AccidentInfo->burn){ echo "checked"; } ?>> Burn/ Sunburn
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type16">
                                                    <input type="checkbox" name="respiratory" value="1" <?php if($AccidentInfo->respiratory){ echo "checked"; } ?>> Respiratory
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type17">
                                                    <input type="checkbox" name="choking" value="1" <?php if($AccidentInfo->choking){ echo "checked"; } ?>> Choking
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type18">
                                                    <input type="checkbox" name="seizure" value="1" <?php if($AccidentInfo->seizure){ echo "checked"; } ?>> Seizure/ unconscious/ convulsion
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type19">
                                                    <input type="checkbox" name="concussion" value="1" <?php if($AccidentInfo->concussion){ echo "checked"; } ?>> Concussion
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type20">
                                                    <input type="checkbox" name="sprain" value="1" <?php if($AccidentInfo->sprain){ echo "checked"; } ?>> Sprain/ swelling
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type21">
                                                    <input type="checkbox" name="crush" value="1" <?php if($AccidentInfo->crush){ echo "checked"; } ?>> Crush/ Jam
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type22">
                                                    <input type="checkbox" name="stabbing" value="1" <?php if($AccidentInfo->stabbing){ echo "checked"; } ?>> Stabbing/ piercing
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type23">
                                                    <input type="checkbox" name="cut" value="1" <?php if($AccidentInfo->cut){ echo "checked"; } ?>> Cut/ Open Wound
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type24">
                                                    <input type="checkbox" name="tooth" value="1" <?php if($AccidentInfo->tooth){ echo "checked"; } ?>> Tooth
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type25">
                                                    <input type="checkbox" name="drowning" value="1" <?php if($AccidentInfo->drowning){ echo "checked"; } ?>> Drowning (nonfatal)
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type26">
                                                    <input type="checkbox" name="venomous_bite" value="1" <?php if($AccidentInfo->venomous_bite){ echo "checked"; } ?>> Venomous bite/ sting
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type27">
                                                    <input type="checkbox" name="eye_injury" value="1" <?php if($AccidentInfo->eye_injury){ echo "checked"; } ?>> Eye Injury
                                                </label>
                                            </li>
                                            <li class="col-md-6 col-sm-12">
                                                <label for="type28">
                                                    <input type="checkbox" name="other" value="1" <?php if($AccidentInfo->other){ echo "checked"; } ?>> Other (Please specify)
                                                </label>
                                            </li>
                                            <li id="injury-remarks" style="width: 100%;display: none;">
                                                <input type="text" name="remarks" placeholder="Write here..." class="form-control col-md-6 col-sm-12" style="width: 100%;" <?php if($AccidentInfo->remarks){ echo "checked"; } ?>>
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">Action Taken</h3>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="takenAction">Details of action taken (including first aid, administration of medication etc.):</label>
                                <textarea class="form-control" id="takenAction" name="action_taken"><?= $AccidentInfo->action_taken; ?></textarea>    
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label>Did emergency services attend:</label>
                                        <div class="custom-switch custom-switch-secondary-inverse mb-2">
                                            <!-- <input class="custom-switch-input mandatory-field" id="togBtn" type="text" name="emrg_serv_attend" value="1" placeholder="<?= $AccidentInfo->emrg_serv_attend;?>"> -->
                                            <label class="custom-switch-btn" for="togBtn"><?= $AccidentInfo->emrg_serv_attend;?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label>Was medical attention sought from a registered practitioner / hospital:</label>
                                        <div class="custom-switch custom-switch-secondary-inverse mb-2">
                                            <!-- <input class="custom-switch-input mandatory-field" id="togBtn-second" type="checkbox" name="med_attention" value="1"> -->
                                            <label class="custom-switch-btn" for="togBtn-second"><?= $AccidentInfo->med_attention;?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="provideDetails">If yes to either of the above, provide details:</label>
                                <textarea class="form-control" id="provideDetails" name="med_attention_details"><?= $AccidentInfo->med_attention_details;?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="provideDetails">List the steps that have been taken to prevent or minimise this type of incident in the future:</label>
                                <ol>
                                    <li><input type="text" class="form-control" id="one" name="prevention_step_1" placeholder="<?= $AccidentInfo->prevention_step_1;?>"></li>
                                    <li><input type="text" class="form-control" id="two" name="prevention_step_2" placeholder="<?= $AccidentInfo->prevention_step_2;?>"></li>
                                    <li><input type="text" class="form-control" id="three" name="prevention_step_3" placeholder="<?= $AccidentInfo->prevention_step_3;?>"></li>
                                </ol>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">Parent/Guardian Notifications (including attempted notifications)</h3>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="parentname">Parent/ Guardian name:</label>
                                <input type="text" class="form-control" id="parentname" name="parent1_name" placeholder="<?= $AccidentInfo->parent1_name;?>">    
                            </div>
                            <div class="form-group col-md-6">
                                <label for="method">Method of Contact:</label>
                                <input type="text" class="form-control" id="method" name="contact1_method" placeholder="<?= $AccidentInfo->contact1_method;?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="contactDate">Date</label>
                                <input type="text" class="form-control" id="contactDate" name="contact1_date" placeholder="<?= $AccidentInfo->contact1_date;?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="contactTime">Time</label>
                                <input type="text" class="form-control" id="contactTime" name="contact1_time" placeholder="<?= $AccidentInfo->contact1_time;?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="contactmade">Contact Made: </label>
                                <input type="text" class="form-control check-control" id="contactmade" name="contact1_made" value="1" placeholder="<?= $AccidentInfo->contact1_made;?>">   
                            </div>
                            <div class="form-group col-md-6">
                                <label for="messageleft">Message Left:</label>
                                <input type="text" class="form-control check-control" id="messageleft" name="contact1_msg" value="1" placeholder="<?= $AccidentInfo->contact1_msg;?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="parentname2">Parent/ Guardian name:</label>
                                <input type="text" class="form-control" id="parentname2" name="parent2_name" value="" placeholder="<?= $AccidentInfo->parent2_name;?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="method2">Method of Contact:</label>
                                <input type="text" class="form-control" id="method2" name="contact2_method" value="" placeholder="<?= $AccidentInfo->contact2_method;?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="contactDate2">Date</label>
                                <input type="text" class="form-control" id="contactDate2" name="contact2_date" value="" placeholder="<?= $AccidentInfo->contact2_date;?>"> 
                            </div>
                            <div class="form-group col-md-6">
                                <label for="contactTime2">Time</label>
                                <input type="text" class="form-control" id="contactTime2" name="contact2_time" value="" placeholder="<?= $AccidentInfo->contact2_time;?>">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="contactmade2">Contact Made: </label>
                                <input type="text" class="form-control check-control" id="contactmade2" name="contact2_made" value="1" placeholder="<?= $AccidentInfo->contact2_made;?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="messageleft2">Message Left:</label>
                                <input type="text" class="form-control check-control" id="messageleft2" name="contact2_msg" value="1" placeholder="<?= $AccidentInfo->contact2_msg;?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">Internal Notifications</h3>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="res_pinc">Responsible Person in Charge Name:</label>
                                <input type="text" class="form-control" id="res_pinc" name="responsible_person_name" value="" placeholder="<?= $AccidentInfo->responsible_person_name;?>"> 
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    Signature
                                    <span class="simple-icon-pencil text-primary editbtn" data-toggle="modal" data-target="#signModal" data-identity="incharge_sign"></span>
                                </label>
                                <!-- <input type="text" class="form-control" id="res_pinc_dt" disabled> -->
                                <div id="incharge_sign">
                                    <!-- <input type="hidden" name="responsible_person_sign" id="res_pinc_txt" value=""> -->
                                    <img src="<?= base_url('/api/assets/media/').$AccidentInfo->responsible_person_sign; ?>" height="120px" width="300px" id="res_pinc_img">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="rp_internal_notif_date">Date</label>
                                <input type="text" class="form-control" id="rp_internal_notif_date" name="rp_internal_notif_date" value="<?= $AccidentInfo->rp_internal_notif_date; ?>" placeholder="<?= $AccidentInfo->rp_internal_notif_date;?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="rp_internal_notif_time">Time</label>
                                <input type="text" class="form-control" id="rp_internal_notif_time" name="rp_internal_notif_time" value="<?= $AccidentInfo->rp_internal_notif_time; ?>" placeholder="<?= $AccidentInfo->rp_internal_notif_time;?>">
                            </div>
                        </div>
                        <?php if (isset($_GET['id'])) { ?>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nom_sv">Nominated Supervisor Name:</label>
                                    <input type="text" class="form-control" id="nom_sv" name="nominated_supervisor_name" value="<?= $AccidentInfo->nominated_supervisor_name;?>" placeholder="<?= $AccidentInfo->nominated_supervisor_name;?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>
                                        Signature
                                        <span class="simple-icon-pencil text-primary editbtn" data-toggle="modal" data-target="#signModal" data-identity="supervisor_sign"></span>
                                    </label>
                                    <!-- <input type="text" class="form-control" id="nom_svs_dt" disabled placeholder="<?#= $AccidentInfo->nominated_supervisor_sign;?>"> -->
                                    <div id="supervisor_sign">
                                        <!-- <input type="hidden" name="nominated_supervisor_sign" id="nsv_sign_txt" value="" placeholder="<?#= $AccidentInfo->nominated_supervisor_sign;?>"> -->
                                        <img src="<?= base_url('/api/assets/media/').$AccidentInfo->nominated_supervisor_sign; ?>" height="120px" width="300px" id="nsv_sign_img">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="nsv_date">Date</label>
                                    <input type="text" class="form-control" id="nsv_date" name="nsv_date" value="<?= $AccidentInfo->nominated_supervisor_date;?>" placeholder="<?= $AccidentInfo->nominated_supervisor_date;?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nsv_time">Time</label>
                                    <input type="text" class="form-control" id="nsv_time" name="nsv_time" value="<?= $AccidentInfo->nominated_supervisor_time;?>" placeholder="<?= $AccidentInfo->nominated_supervisor_time;?>">
                                </div>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">External Notifications</h3>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="otheragency">Other agency:</label>
                                <input type="text" class="form-control" id="otheragency" name="otheragency" value="" placeholder="<?= $AccidentInfo->ext_notif_other_agency;?>">
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="agencyDate">Date</label>
                                        <input type="text" class="form-control" id="agencyDate" name="enor_date" value="" placeholder="<?= $AccidentInfo->enor_date;?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="agencyTime">Time</label>
                                        <input type="text" class="form-control" id="agencyTime" name="enor_time" value="" placeholder="<?= $AccidentInfo->enor_time;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="Regulatoryauthority">Regulatory authority:</label>
                                <input type="text" class="form-control" id="Regulatoryauthority" name="Regulatoryauthority" value="" placeholder="<?= $AccidentInfo->ext_notif_regulatory_auth;?>">
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="enra_date">Date</label>
                                        <input type="text" class="form-control" id="enra_date" name="enra_date" value="" placeholder="<?= $AccidentInfo->enra_date;?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="enra_time">Time</label>
                                        <input type="text" class="form-control" id="enra_time" name="enra_time" value="" placeholder="<?= $AccidentInfo->enra_time;?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($_GET['id'])) { ?>	
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3 class="service-title">Parental acknowledgement</h3>
                                    <div class="inlineInput">
                                        I <input type="text" name="ack_parent_name" placeholder="<?= $AccidentInfo->ack_parent_name;?>"> (name of parent / guardian) have been notified of my child’s incident / injury / trauma / illness.
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="RegulatoryauthorityDate">Date</label>
                                    <input type="text" class="form-control" id="RegulatoryauthorityDate" name="ack_date" value="" placeholder="<?= $AccidentInfo->ack_date;?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="RegulatoryauthorityTime">Time</label>
                                    <input type="text" class="form-control" id="RegulatoryauthorityTime" name="ack_time" value="" placeholder="<?= $AccidentInfo->ack_time;?>">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="service-title">Additional notes</h3>
                            </div>
                        </div>
                        <div class="form-row mb-5">
                            <div class="form-group col-md-12">
                                <textarea class="form-control" id="takenAction" name="add_notes"><?= $AccidentInfo->add_notes;?></textarea>
                            </div>
                        </div>

                        <!-- <div class="row m-2">
                            <div class="col-sm-12 text-right">
                                <div class="formSubmit">
                                    <button type="button" id="form-submit" class="btn btn-default btn-success">Save &amp; Next</button>
                                    <button type="button" class="btn btn-default btn-danger">Cancel</button>
                                </div>
                            </div>
                        </div> -->
                    </form>
                </div>
            </div> 
        </div>
    </main>


    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/datatables.min.js" style="opacity: 1;"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/jquery.signature.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/survey.js?v=1.0.0"></script>

</body>
    <script>
        $(document).ready(function(){
            $('.js-example-basic-single').select2();
            var sig = $('#sig').signature();
            $('#btnSignature').on('click', function() {
                let _identity = $("#identityVal").val();
                if (_identity == "person_sign") {
                    $('#person_sign').show();
                    $('#person_sign_dt').hide();
                    var _signature = $('#sig').signature('toDataURL');
                    $('#person_sign_img').attr('src', _signature);
                    $('#person_sign_txt').val(_signature);
                } else if (_identity == "witness_sign") {
                    $('#witness_sign').show();
                    $('#witness_sign_dt').hide();
                    var _signature = $('#sig').signature('toDataURL');
                    $('#witness_sign_img').attr('src', _signature);
                    $('#witness_sign_txt').val(_signature);
                } else if (_identity == "incharge_sign") {
                    $('#incharge_sign').show();
                    $('#res_pinc_dt').hide();
                    var _signature = $('#sig').signature('toDataURL');
                    $('#res_pinc_img').attr('src', _signature);
                    $('#res_pinc_txt').val(_signature);
                } else if (_identity == "supervisor_sign") {
                    $('#supervisor_sign').show();
                    $('#nom_svs_dt').hide();
                    var _signature = $('#sig').signature('toDataURL');
                    $('#nsv_sign_img').attr('src', _signature);
                    $('#nsv_sign_txt').val(_signature);
                }
                $('#sig').signature('clear');
            });

            $(document).on('show.bs.modal', '#signModal',function (event) {
            var button = $(event.relatedTarget);
            var identity = button.data('identity');
            $("#identityVal").val(identity);
            });

            // $('.select2-container').addClass('select2-container--bootstrap select2-container--below select2-container--focus w-100');
            $('.select2-selection__rendered').addClass('select2-container--bootstrap select2-container--below select2-container--focus w-100');
            
            $('.select2-container').removeClass('select2-container--default');

        });

        var canvas = new fabric.Canvas('c',{isDrawingMode:true});

        fabric.Image.fromURL('<?php echo base_url("/assets/images/baby.jpg"); ?>', function(myImg) {
            
            var img1 = myImg.set({ 
                left: 0, 
                top: 0,
                scaleX: 500 / myImg.width,
                scaleY: 500 / myImg.height,
                selectable: false,
                hasControls: false
            });

            // setCorners(img1);
            canvas.add(img1);   
        },{ crossOrigin: 'Anonymous' });

        function saveImage(){
            var pngURL = canvas.toDataURL();
            $("#injury-image").val(pngURL);
        }

        $("#form-submit").click(function(event) {
            saveImage();
            $('#acc-form').submit();
        });

        $('input[name="other"]').on('click',function(){

            if ($(this).is(':checked')) {
                $("#injury-remarks").show();
            }else{
                $("#injury-remarks").hide();
            }
        });

        $("#childid").on("change",function(){
            let _val = $(this).val();
            if (_val != "") {
                $.ajax({
                    url: '<?= base_url('Accident/getChildDetails'); ?>',
                    type: 'post',
                    data: {'childid': _val},
                })
                .done(function(json) {
                    var res = $.parseJSON(json);
                    if (res.Status == "SUCCESS") {
                        $("#childfullname").val(res.Child.name + res.Child.lastname);
                        $("#birthdate").val(res.Child.dob);
                        $("#age").val(res.Child.age);
                        if(res.Child.gender == "Male"){
                            $("#Male").prop('checked', true);
                            $("#Female").prop('checked', false);
                            $("#Others").prop('checked', false);
                        }else if(res.Child.gender == "Female"){
                            $("#Male").prop('checked', false);
                            $("#Female").prop('checked', true);
                            $("#Others").prop('checked', false);
                        }else{
                            $("#Male").prop('checked', false);
                            $("#Female").prop('checked', false);
                            $("#Others").prop('checked', true);
                        }
                    }
                });
            }
        });
    </script>
</html>