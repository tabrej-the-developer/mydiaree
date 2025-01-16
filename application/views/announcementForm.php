<?php
	$data['name']='Announcements'; 
	$this->load->view('header',$data); 
	if (!empty($Info)) {
		$announcement = $Info;
		$url = base_url()."announcements/exeUpdateAnnouncements";
		$annId = $announcement->id;
		$p = $Permissions;
	}else{
		$url = base_url()."announcements/add";
		$p = $Permissions;
	}

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
<style>
	ul.nav.nav-tabs.border-tab{
		clear: both;
	}

	.filter-box{
		margin-bottom: 0px;
	}

	#filter-child{
		margin-bottom: 10px;
	}

	.form-group label{
		width: 100%;
	}

	.child-image{
		width: 40px;
		height: 40px;
		border-radius: 50%;
	}

	.bootstrap-tagsinput{
		display: inline-block;
		width: 100%;
	}

	.app .label.label-info{
		display: inline-block;
	}
	<?php  if (isset($Info)) { ?>
	.children-tags{
		display: inline-block;
	}
	<?php  } else { ?>
	.children-tags{
		display: none;
	}
	<?php } ?>
	
</style>

<div class="container ">
	<div class="pageHead">
		<h1><?php echo isset($announcement)?"Edit Announcements":"Create Announcements"; ?></h1>
		<!-- <div class="headerForm"> -->
			<!-- <?php #if (!isset($annId)) { ?>
			<form action="" method="get" id="centerDropdown">
				<select name="centerid" id="centerId" class="form-control">
		        <?php 
		           // $dupArr = [];
		           // foreach ($this->session->userdata("centerIds") as $key => $center){
		           //    if ( ! in_array($center, $dupArr)) {
		           //       if (isset($_GET['centerid']) && $_GET['centerid'] != "" && $_GET['centerid']==$center->id) {
		        ?>
				<option value="<?php #echo $center->id; ?>" selected><?php #echo $center->centerName; ?></option>
		        <?php    #}else{ ?>
				<option value="<?php #echo $center->id; ?>"><?php #echo $center->centerName; ?></option>
		        <?php
		           //       }
		           //    }
		           //    array_push($dupArr, $center);
		           // }
		        ?>
			    </select>
			</form>
			<?php //} ?> -->
		<!-- </div> -->
	</div>
	
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url()."announcements"; ?>">Announcements</a></li>
		<li><?php echo isset($announcement)?"Edit Announcements":"Add Announcements"; ?></li>
	</ul>

	<div class="addAnnoucementListView">
		<form action="<?php echo $url; ?>" id="form-announcements" method="post" enctype="multipart/form-data">
			<input type="hidden" name="annId" value="<?php echo isset($annId)?$annId:""; ?>">
			<input type="hidden" name="centerid" value="<?php echo $centerid; ?>">
			<div class="announcement-form-sec">
				<div class="announcement-form-left">
					<div class="form-group">
						<label for="txtTitle">Title</label>
						<div class="input-group">
							<input type="text" name="title" class="form-control" id="txtTitle" value="<?php if(isset($announcement->title)){echo $announcement->title;} ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="txtDate">Date</label>
						<div class="input-group">
							<input type="text" name="eventDate" class="form-control datepicker" id="txtCalendar" aria-describedby="igSearch" value="<?php if(isset($announcement->createdAt)){echo date('m-d-Y h:i a',strtotime($announcement->createdAt));} ?>"  onkeydown="return false"  required>
							<div class="input-group-addon">
								<span class="material-icons-outlined">event</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="txtTo">To</label>
						<button type="button" class="btn btn-default btn-small btnBlue" id="select-child" data-toggle="modal" data-target="#select-child-modal"><span class="material-icons-outlined">add</span> Select Child</button>
					</div>
					<div class="children-tags">
						<div class="bootstrap-tagsinput">
							<?php 
								if (isset($Info) && !empty($announcement->children)) {
									foreach ($announcement->children as $key => $obj) {
							?>
							<span class="tag label label-info">
		                       <input type="hidden" name="childId[]" value="<?= $obj->childid;?>">
		                       <?= $obj->name;?>
		                       <span class="rem" data-role="remove" data-child="<?= $obj->childid;?>"></span>
		                    </span>
							<?php
									}
								}
							?>
		                    
		                </div>
					</div>
				</div>
				<div class="announcement-form-right">
					<div class="form-group">
						<label>About</label>
						<textarea name="text" id="editor1" class="form-control"><?php if(isset($announcement->text)){echo $announcement->text;} ?></textarea>
					</div>
				</div>
			</div>
			<div class="formSubmit">
				<?php if ($add==1 || $edit==1) { ?>
					<button type="submit" class="btn btn-default btnBlue pull-right">Save</button>
				<?php } else { ?>
					<button type="button" class="btn btn-default btnBlue pull-right">Need Permission!</button>
					<span> You don't have enough permission! </span>
				<?php } ?>
			</div>
		</form>
	</div>

	<div class="modal right sideModal fade" id="select-child-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span class="modal-close" aria-hidden="true">&times;</span>
					</button>
                	<h4 class="modal-title">Select Children</h4>
                </div>
                <div class="modal-body">
					<div class="form-group filter-box">
						<input type="text" class="form-control" id="filter-child" placeholder="Enter child name or age to search">
					</div>
                 	<ul class="nav nav-tabs border-tab">
                 		<li class="active"><a href="#tab-children" data-toggle="tab">Children</a></li>
                 		<li><a href="#tab-groups" data-toggle="tab">Groups</a></li>
                 		<li><a href="#tab-rooms" data-toggle="tab">Rooms</a></li>
                 	</ul>
                 	<div class="tab-content">
                 		<div class="tab-pane active" id="tab-children">
                 			<div class="select-all-box">
                 				<input type="checkbox" id="select-all-child">
                 				<label for="select-all-child"><strong>Select All</strong></label>
                 			</div>
                 			<table class="listtable table table-bordered">
                 				<?php  foreach ($Childrens as $childkey => $childobj) { ?>
                 				<tr>
                 					<td><input type="checkbox" class="common-child child-tab unique-tag" name="child[]" id="<?= 'child_'.$childobj->childid; ?>" value="<?= $childobj->childid; ?>" data-name="<?= $childobj->name. "- " .$childobj->age; ?>" <?= $childobj->checked; ?>></td>
                 					<td>
                 						<label for="<?= 'child_'.$childobj->childid; ?>">
		                 					<img src="<?= BASE_API_URL.'assets/media/'.$childobj->imageUrl; ?>" class="child-image">
		                 					<?= $childobj->name. " - " .$childobj->age; ?>
                 						</label>
                 					</td>
                 				</tr>
                 				<?php  } ?>
                 			</table>
                 		</div>
                 		<div class="tab-pane" id="tab-groups">
                 			<?php foreach ($Groups as $grkey => $grobj) { ?>
                 				<div class="select-all-box">
	                 				<input type="checkbox" id="<?= 'select-group-child-'.$grobj->groupid; ?>" class="select-group-child" data-groupid="<?= $grobj->groupid; ?>">
	                 				<label for="<?= 'select-group-child-'.$grobj->groupid; ?>"><strong><?= $grobj->name; ?></strong></label>
	                 			</div>
	                 			<table class="listtable table table-bordered">
	                 				<?php  foreach ($grobj->childrens as $childkey => $childobj) { ?>
	                 				<tr>
	                 					<td><input type="checkbox" class="common-child child-group" name="child[]" data-groupid="<?= $grobj->groupid; ?>" id="<?= 'child_'.$childobj->childid; ?>" value="<?= $childobj->childid; ?>" <?= $childobj->checked; ?>></td>
	                 					<td>
	                 						<label for="<?= 'child_'.$childobj->childid; ?>">
			                 					<img src="<?= BASE_API_URL.'assets/media/'.$childobj->imageUrl; ?>" class="child-image">
			                 					<?= $childobj->name. " - " .$childobj->age; ?>
	                 						</label>
	                 					</td>
	                 				</tr>
	                 				<?php  } ?>
	                 			</table>
                 			<?php } ?>
                 		</div>
                 		<div class="tab-pane" id="tab-rooms">
                 			<?php foreach ($Rooms as $roomkey => $roomobj) { ?>
                 				<div class="select-all-box">
	                 				<input type="checkbox" class="select-room-child" id="<?= 'select-room-child-'.$roomobj->roomid; ?>" data-roomid="<?= $roomobj->roomid; ?>">
	                 				<label for="<?= 'select-room-child-'.$roomobj->roomid; ?>"><strong><?= $roomobj->name; ?></strong></label>
	                 			</div>
	                 			<table class="listtable table table-bordered">
	                 				<?php  foreach ($roomobj->childrens as $childkey => $childobj) { ?>
	                 				<tr>
	                 					<td><input type="checkbox" class="common-child child-room" name="child[]" data-roomid="<?= $roomobj->roomid; ?>" id="<?= 'child_'.$childobj->childid; ?>" value="<?= $childobj->childid; ?>" <?= $childobj->checked; ?>></td>
	                 					<td>
	                 						<label for="<?= 'child_'.$childobj->childid; ?>">
			                 					<img src="<?= BASE_API_URL.'assets/media/'.$childobj->imageUrl; ?>" class="child-image">
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
                <div class="modal-footer modal-footer-fixed">
                    <button type="button" id="insert-childtags" class="btn btn-default btn-small btnBlue pull-right" data-dismiss="modal">Save</button>
                </div>
            </div>
            <!-- modal-content -->
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){

		CKEDITOR.replace('editor1');

		// $("#centerId").on('change',function(){
		// 	$("#centerDropdown").submit();
		// });

		// $(document).on("submit","#form-announcements",function(){
		// 	var centerId = $("#centerId").val();
		// 	$(this).append('<input type="hidden" name="centerid" value="'+centerId+'">');
		// });

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
			$('.bootstrap-tagsinput').empty();
			$('.unique-tag:checked').each(function(index, val) {
				$('.bootstrap-tagsinput').append(`
					<span class="tag label label-info">
                       <input type="hidden" name="childId[]" value="`+ $(this).val() +`">
                       `+ $(this).data('name') +`
                       <span class="rem" data-role="remove" data-child="`+ $(this).val() +`"></span>
                    </span>
				`);
			});
			$(".children-tags").show();
		});

		$(document).on('click', '.rem', function() {
			var _childid = $(this).data('child');
			$(this).closest('.tag').remove();
			$(".common-child[value='"+_childid+"']").trigger('click');
		});

	});
</script>