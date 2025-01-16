<?php
	$user = $this->session->userdata('LoginId');
	if ($this->session->userdata('UserType') == "Superadmin") {
		$run = 1;
	}elseif($this->session->userdata('UserType') == "Staff"){
		$run = $Permissions->assessment;
	}else{
		$run = 0;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montessori Settings | Mykronicle</title>
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
	<style>
		.title-section {
		   display: flex;
		   align-items: center;
		   justify-content: space-between;
		   margin-bottom: 20px;
		}

		.title-section h3{
			margin: 0px!important;
		}

		.activity-box{
	   	display: flex;
	   	justify-content: space-between;
		}

		.btn.btn-sm, .btn.btn-sm:hover {
		   display: flex;
		   align-items: center;
		   width: auto;
		   padding: 3px 8px 3px;
		   height: 30px;
		   line-height: 31px;
		}

		.btn.btn-sm span.material-icons-outlined{
			font-size: 17px;
		}

		.activityBlockSub{
			display: inline-block;
		}
		.activityBlockSubMain{
			display: flex;
		   justify-content: space-between;
		   align-items: center;
		}
		.activityBlockSubExtras{
			display: flex;
			flex-direction: column;
			position: relative;
			left: 20px;
			margin-top: 10px;
		}
		.activityBlockSubExtras .activityBlockSubExtrasMain label{
			font-size: 13px;
			margin: 3px 0px;
		}
		.activityBlockSubExtrasMain{
			display: flex;
			justify-content: space-between;
		   align-items: center;
		   margin-bottom: 3px;
	    	margin-right: 20px;
		}
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

		.custom-flex{
		    display: flex;
		    justify-content: space-between;
		    align-items: center;
		}
	</style>
</head>
<body id="app-container" class="menu-default show-spinner">
	<?php $this->load->view('sidebar'); ?> 
	<main class="default-transition">
	    <div class="default-transition">
	        <div class="container-fluid">
	            <div class="row">
	             	<div class="col-12">
		                 <h1>Montessori Settings</h1>
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
		                    <a class="btn btn-primary btnBlue" href="#">
								<i class="iconsminds-add"></i> Import CSV
							</a>
		                 </div>
		                 <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
		                     <ol class="breadcrumb pt-0" style="background-color: transparent;">
		                         <li class="breadcrumb-item">
		                             <a href="#" style="color: dimgray;">Dashboard</a>
		                         </li>
		                         <li class="breadcrumb-item">
		                             <a href="#" style="color: dimgray;">Settings</a>
		                         </li>
		                         <li class="breadcrumb-item active" aria-current="page">Assessment Settings</li>
		                     </ol>
		                 </nav>
		           		<div class="separator mb-5"></div>
		          	</div>
	          		<div class="col-12">
	              		<div class="card">
	                     	<div id="smartWizardClickable" class="sw-main sw-theme-default">
								<ul class="nav nav-tabs">
									<?php 
										$i = 1;
										foreach ($Subjects as $key => $obj) {
									?>
									<li class="line-nav-tab nav-item clickable done <?= ($i == 1)?'active':'';?>">
										<a class="nav-link" href="<?= '#tabs-'.$i;?>" data-toggle="tab" aria-expanded="<?= ($i == 1)?'true':'false';?>">
											<?= $obj->name;?>
										</a>
									</li>
									<?php
											$i++;
										}
									?> 
								</ul>
								<div class="card-body sw-container tab-content">
									<div class="tab-content mainTabAssessment">
										<?php 
											$i = 1;
											foreach ($Subjects as $key => $obj) {
											?>
											<div class="tab-pane step-content <?= ($i == 1)?'active':'';?>" id="<?= 'tabs-'.$i;?>">
												<div class="activity-box mb-3">
													<h3><?= $obj->name;?></h3>
													<button type="button" class="btn btn-outline-primary btnAddActivity default" data-activity="" data-title="" data-subject="<?= $obj->idSubject;?>" data-toggle="modal" data-target="#modal-activity">
														<i class="iconsminds-add"></i>Add Activity
													</button>
												</div>
												<div class="activityBlockList activityBlockListPractices">
													<?php  foreach ($obj->activities as $actkey => $actobj) { ?>
													<div class="activityBlock mb-3">
														<div class="activityBlockMain custom-flex pl-3 mb-2 border-bottom border-2">
															<label for="<?= 'activity-'.$actobj->idActivity; ?>" class="activityBlockLabel">
																<input id="<?= 'activity-'.$actobj->idActivity; ?>" type="checkbox" class="activity" data-activity="<?= $actobj->idActivity; ?>" <?= $actobj->checked; ?>> <?= $actobj->title;?>
															</label>
															<div class="btn-group mr-3">
																<?php if($actobj->added_by == $user){ ?>
																<button type="button" class="btn btn-outline-primary btn-xs default" data-activity="<?= $actobj->idActivity; ?>" data-subactivity="" data-toggle="modal" data-target="#modal-subactivity">
																	<i class="fas fa-plus-circle"></i> Add
																</button>
																<button type="button" class="btn btn-outline-secondary btn-xs default" data-subject="<?= $obj->idSubject;?>" data-activity="<?= $actobj->idActivity; ?>" data-title="<?= $actobj->title;?>" data-toggle="modal" data-target="#modal-activity">
																	<i class="fas fa-exclamation-circle"></i> Edit
																</button>
																<a href="<?= base_url('Settings/deleteMonActivity') . '?id=' . $actobj->idActivity . '&centerid='.$CenterId; ?>" onclick="return confirm('Are you sure?');" class="btn btn-outline-danger btn-xs default">
																	<i class="fas fa-minus-circle"></i> Delete
																</a>
																<?php } ?>	
															</div>							
														</div>

														<?php foreach ($actobj->subactivity as $subkey => $subobj) { ?>
														<div class="activityBlockSub col-12">
															<div class="activityBlockSubMain">
																<label for="<?= 'subactivity-'.$subobj->idActivity; ?>" class="activityBlockLabel">
																	<input id="<?= 'subactivity-'.$subobj->idSubActivity; ?>" class="subactivity" data-subactivity="<?= $subobj->idSubActivity; ?>" type="checkbox" <?= $subobj->checked; ?>> <?= $subobj->title; ?>
																</label>

																<?php if($subobj->added_by == $user){ ?>
																<div class="btn-group">
																	<button type="button" class="btn btn-outline-primary btn-xs default" data-title="" data-extra="" data-subactivity="<?= $subobj->idSubActivity; ?>" data-toggle="modal" data-target="#modal-extras">
																		Add
																	</button>

																	<button type="button" class="btn btn-outline-secondary btn-xs default" data-activity="<?= $actobj->idActivity; ?>" data-subactivity="<?= $subobj->idSubActivity; ?>" data-toggle="modal" data-target="#modal-subactivity">
																		Edit
																	</button>

																	<a href="<?= base_url('Settings/deleteMonSubActivity') . '?id=' . $subobj->idSubActivity.'&centerid='.$CenterId; ?>" onclick="return confirm('Are you sure? All extras will be also deleted.');" class="btn btn-outline-danger btn-xs default">Delete</a>
																</div>
																<?php } ?>
															</div>
															<div class="activityBlockSubExtras">
																<?php foreach ($subobj->extras as $extrakey => $extraobj) { ?>
																<div class="activityBlockSubExtrasMain">
																	<label for="<?= 'extra-'.$extraobj->idExtra; ?>">
																		<input id="<?= 'extra-'.$extraobj->idExtra; ?>" class="extra" data-extra="<?= $extraobj->idExtra; ?>"  type="checkbox" <?= $extraobj->checked; ?>> <?= $extraobj->title; ?>
																	</label>
																	<?php if($subobj->added_by == $user){ ?>
																		<div class="btn-group">										
																			<button type="button" class="btn btn-outline-secondary btn-xs default" data-title="<?= $extraobj->title; ?>" data-extra="<?= $extraobj->idExtra; ?>" data-subactivity="<?= $subobj->idSubActivity; ?>" data-toggle="modal" data-target="#modal-extras"><i class="fas fa-exclamation-circle"></i></button>

																			<a href="<?= base_url('Settings/deleteMonSubActivityExtras') . '?id=' . $extraobj->idExtra . '&centerid='.$CenterId; ?>" onclick="return confirm('Are you sure?');" class="btn btn-outline-danger btn-xs default"><i class="fas fa-minus-circle"></i></a>
																		</div>
																<?php }
																echo "</div>";
																} ?>
															</div>
														</div>	
														<?php } ?>
													</div>
													<?php } ?>						
												</div>
												<div class="form-buttons-sec text-right">
													<?php if($run == 0){ ?>
														<p>You don't have enough permission!</p>
													<?php } ?>
													<button class="btn btn-primary pull-right saveMontessori" type="<?= ($run == 1)?'submit':'button';?>">SAVE</button>
												</div>
											</div>
											<?php
												$i++;
											}
										?>
									</div>
								</div>
		                	</div>
	                	
	                	</div>
	             	

		             	<div class="modal" id="modal-activity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
							   <div class="modal-content">
							   	<form action="<?= base_url('Settings/saveActivity'); ?>" method="post">
							      <div class="modal-header">
							      	<h4 class="modal-title text-primary" id="myModalLabel">Add New Activity</h4>
							         <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
							            <span aria-hidden="true">&times;</span>
							         </button>
							      </div>
							      <div class="modal-body">
							      	<input type="hidden" name="subject" value="">
							      	<input type="hidden" name="activity" value="">
							      	<input type="hidden" name="centerid" value="">
										<div class="form-group">
											<label for="title">Title</label>
											<div class="input-group">
												<input id="title" type="text" class="form-control " name="title" value="">
											</div>
										</div>
							      </div>
							      <div class="modal-footer">
							         <button type="submit" class="btn btn-primary pull-right">Add</button>
							         <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
							      </div>
							      </form>
							   </div>
							</div>
						</div>

						<div class="modal fade" id="modal-subactivity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title text-primary" id="myModalLabel">Add New SubActivity</h4>
										<button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form action="<?= base_url('Settings/saveSubActivity'); ?>" method="post">
									<div class="modal-body">
										<input type="hidden" name="subactivity" value="">
						         	<input type="hidden" name="activity" value="">
						         	<input type="hidden" name="centerid" value="">
										<div class="form-group">
											<label for="title">Title</label>
											<div class="input-group">
												<input id="title" type="text" class="form-control " name="title" value="">
											</div>
										</div>
										<div class="form-group">
											<label for="about">About</label>
											<div class="input-group">
												<textarea id="about" type="text" class="form-control " name="subject" value=""></textarea>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-success pull-right" >Save</button>
										<button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
									</div>
									</form>
								</div>
							</div>
						</div>

						<div class="modal" id="modal-extras" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						   <div class="modal-dialog" role="document">
						      <div class="modal-content">
						      	<form action="<?= base_url('Settings/saveExtras'); ?>" method="post">
							         <div class="modal-header">
							         	<h4 class="modal-title text-primary" id="myModalLabel">Add New Activity</h4>
							            <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
							               <span aria-hidden="true">&times;</span>
							            </button>
							         </div>
							         <div class="modal-body">
							         	<input type="hidden" name="extra" value="">
							         	<input type="hidden" name="subactivity" value="">
							         	<input type="hidden" name="centerid" value="">
											<div class="form-group">
												<label for="title">Title</label>
												<div class="input-group">
													<input id="title" type="text" class="form-control " name="title" value="">
												</div>
											</div>
							         </div>
							         <div class="modal-footer">
							            <button type="submit" class="btn btn-primary pull-right">Add</button>
							            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
							         </div>
						         </form>
						      </div>
						   </div>
						</div>
					</div>
	          	</div>
	       	</div>
		</div>
	</main>
	<?php $this->load->view('footer_v3'); ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js"></script>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js"></script>
	<script src="https://kit.fontawesome.com/5be04f7085.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js"></script>
	<script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js"></script>
	<script src="<?= base_url('assets/v3'); ?>/js/dore.script.js"></script>
	<script src="<?= base_url('assets/v3'); ?>/js/scripts.js"></script> 
	<script>
		$(document).ready(function(){
			
			$("#centerId").on('change',function(){
			   let centerid = $(this).val();
			   <?php  
			      $qs = $_SERVER['QUERY_STRING'];
			      if ($qs == "") {
				      $url = "centerid=";
			      }else{
		            if (isset($_GET['centerid']) && $_GET['centerid']!="") {
		               $url = str_replace('centerid='.$_GET['centerid'], 'centerid=', $_SERVER['QUERY_STRING']);
		            } else {
		               $url = $_SERVER['QUERY_STRING']."&centerid=";
		            }
			      } 
			   ?>
			   var url = "<?php echo base_url('Settings/montessori?').$url; ?>"+centerid;
		      var test = url.replace(/&/g, '&');
		      window.location.href=test;
			});

			$("#modal-activity").on('show.bs.modal', function (event) {
			   var button = $(event.relatedTarget);
			   var subject = button.data('subject');
			   var activity = button.data('activity');
			   var title = button.data('title');
			   var centerid = <?= $CenterId;?>;
			   var modal = $(this);
			   modal.find('.modal-body input[name="subject"]').val(subject);
			   modal.find('.modal-body input[name="activity"]').val(activity);		  
			   modal.find('.modal-body input[name="title"]').val(title);
			   modal.find('.modal-body input[name="centerid"]').val(centerid);
			   if (title.length > 0) {
			  		modal.find('.modal-title').text('Edit Activity');
			   }else{
			   	modal.find('.modal-title').text('Add New Activity');
			   }		   
			});

			$("#modal-subactivity").on('show.bs.modal', function (event) {
			   var button = $(event.relatedTarget);
			   var activity = button.data('activity');
			   var subactivity = button.data('subactivity');
			   
			   var centerid = <?= $CenterId;?>;
			   var modal = $(this);
			   modal.find('.modal-body input[name="subactivity"]').val(subactivity);
			   modal.find('.modal-body input[name="activity"]').val(activity);		  
			   
			   modal.find('.modal-body input[name="centerid"]').val(centerid);
			   if (title.length > 0) {
			  		modal.find('.modal-title').text('Edit Sub Activity');
			   }else{
			   	modal.find('.modal-title').text('Add New Sub Activity');
			   }

			   if(subactivity != ""){
			   	$.ajax({
				   	url: '<?= base_url("Settings/getSubActivity"); ?>',
				   	type: 'POST',
				   	data: {'subactivity': subactivity,'centerid': centerid},
				   })
				   .done(function(json) {
				   	console.log(json);
				   	res = jQuery.parseJSON(json);
				   	if (res.Status == "SUCCESS") {
				   		modal.find('.modal-body input[name="title"]').val(res.Result.title);
				   		$("#about").val(res.Result.subject);
				   	}else{
				   		alert(res.Message);
				   	}
				   });
			   }else{
			   	modal.find('.modal-body input[name="title"]').val("");
				   $("#about").val("");
			   }		   
			});

			$("#modal-extras").on('show.bs.modal', function (event) {
			   var button = $(event.relatedTarget);
			   var extra = button.data('extra');
			   var subactivity = button.data('subactivity');
			   var title = button.data('title');
			   var centerid = <?= $CenterId;?>;
			   var modal = $(this);
			   modal.find('.modal-body input[name="extra"]').val(extra);
			   modal.find('.modal-body input[name="subactivity"]').val(subactivity);
			   modal.find('.modal-body input[name="centerid"]').val(centerid);

			   if (title.length > 0) {
			  		modal.find('.modal-title').text('Edit Extra');
			  		modal.find('.modal-body input[name="title"]').val(title);
			   }else{
			   	modal.find('.modal-title').text('Add New Extras');
			   	modal.find('.modal-body input[name="title"]').val("");
			   }		   
			});

			$(document).on('click', 'button.saveMontessori[type="submit"]', function(event) {

				var centerid = <?= $CenterId;?>;

				var activity = [];
				$("input.activity:checked").each(function(index, val) {
					activity.push($(this).data('activity'));
				});

				var subactivity = [];
				$("input.subactivity:checked").each(function(index, val) {
					subactivity.push($(this).data('subactivity'));
				});

				var extras = [];
				$("input.extra:checked").each(function(index, val) {
					extras.push($(this).data('extra'));
				});

				$.ajax({
					url: '<?= base_url("Settings/saveMontessoriList");?>',
					type: 'POST',
					data: {'centerid': centerid, 'activity': JSON.stringify(activity), 'subactivity': JSON.stringify(subactivity), 'extras': JSON.stringify(extras)},
				})
				.done(function(json) {
					// console.log(json);
					res = jQuery.parseJSON(json);
					if (res.Status == "SUCCESS") {
						swal("Success!", res.Message, "success");
					}else{
						swal("Alert!", res.Message, "error");
					}
				});
			});

		});
	</script>
</body>
</html>









