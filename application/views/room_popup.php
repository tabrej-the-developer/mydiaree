	<div class="modal right fade" id="modal-room" tabindex="-1" role="dialog" aria-labelledby="editRoom">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="modal-close" aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="editRoom">Edit Room</h4>
				</div>
				<div class="modal-body">
					<form action="" id="form-editroom" method="post" enctype="multipart/form-data">
					<div class="popdiv">
						<span class="poplabel">
							Room Name
						</span>
						<span >
							<input type="text" name="room_name" placeholder="ex. Adventures" value="<?php echo $room->name; ?>" class="popinput">
						</span>
					</div>
					<div class="popdiv">
						<span class="poplabel">
							Room Capacity
						</span>
						<span >
							<input type="text" name="room_capacity" placeholder="ex. 2" value="<?php echo $room->capacity; ?>" class="popinput">
						</span>
					</div>
					<div class="popdiv">
						<span class="poplabel">
							Room Leader
						</span>
						<span >
							<select name="room_leader" class="popinput" >
								<option value="">--Select--</option>
								<?php foreach($users as $user) { ?>
                                <?php if($user->userid==$room->userId) { ?>
                                <option value="<?php echo $user->userid; ?>" selected><?php echo $user->name; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $user->userid; ?>"><?php echo $user->name; ?></option>
                                <?php } ?>
								
								<?php } ?>
							</select>
						</span>
					</div>
					<div class="popdiv">
						<span class="poplabel">
							Room Status
						</span>
						<span >
							<select name="room_status" class="popinput" >
                                <?php if($room->status=='Inactive') { ?>
                                <option value="Active">Active</option>
								<option value="Inactive" selected>Inactive</option>
                                <?php  } else { ?>
                                <option value="Active" selected>Active</option>
								<option value="Inactive">Inactive</option>
                                <?php } ?>
								
							</select>
						</span>
					</div>
					<div class="popdiv">
						<span class="poplabel">
							Room Color
						</span>
						<span >
							<input type="color" name="room_color" value="<?php echo $room->color; ?>" class="popinput">
						</span>
					</div>
                     <div class="popdiv">
						<span class="poplabel">
							Select educators
						</span>
						<span >
							<select id="room_educators1" class="popinput" >
								<option value="">--Select--</option>
								<?php foreach($users as $user) { ?>
								<option name="<?php echo $user->name; ?>" value="<?php echo $user->userid; ?>"><?php echo $user->name; ?></option>
								<?php } ?>
							</select>
							<div id="product-category1" class="well well-sm"  style="height: 80px; overflow: auto;">
                                <?php 
								if(!empty($roomStaff)) { 
									foreach($roomStaff as $staff) { ?>
                                <div id="product-category<?php echo $staff->userId; ?>">
                                    <i class="fa fa-minus-circle"></i> <?php echo $staff->userName; ?>
                                    <input type="hidden" name="educators[]" value="<?php echo $staff->userId; ?>" /></div>
                                <?php } } ?>
							</div>
						</span>
					</div>      
					</form>
					 <div class="modal-footer fixedButton">
						<button type="button" data-dismiss="modal" aria-label="Close"  class="btn btn-default greyBtn">Cancel</button>
                  <button type="button" onclick="saveEditRoom();" class="btn btn-info bluBtn">Save</button>
                </div>
				</div>

			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div>
<script>
    var id="<?php echo $id; ?>";
	 $('#room_educators1').change(function(){
        if($(this).val()){
            $('#product-category' + $(this).val()).remove();
            $('#product-category').append('<div id="product-category' + $(this).val() + '"><i class="fa fa-minus-circle"></i> ' + $('option:selected', this).attr('name') + '<input type="hidden" name="educators[]" value="' + $(this).val() + '" /></div>');
        }
    });

	$(document).on('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();
    });
    
    function saveEditRoom(){
        var url="<?php echo base_url('room/edit'); ?>?id="+id;
		var test= url.replace(/&amp;/g, '&');
		document.getElementById("form-editroom").action =test;
		document.getElementById("form-editroom").submit();
    }

    $()
</script>