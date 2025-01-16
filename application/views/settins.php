<?php
	$data['name']='Reset Password'; 
	$this->load->view('header',$data);
?>

<div class="container settingsContainer">
    <div class="pageHead">
		<h1><?php echo $data['name']; ?></h1>
    </div>
    <div class="settingsView">
        <div class="sideMenu">
            <?php $this->load->view('settings-menu-sidebar'); ?>
        </div> 
        <div class="rightFOrmSection">
            <h3>Reset Password</h3>

            <form>
                <div class="form-group required">
                     <label class=" control-label">Current Password</label>
                     <input type="password" name="password" id="" class="form-control" value="">
                </div>
                <div class="form-group required">
                     <label class=" control-label">New Password</label>
                     <input type="password" name="password" id="" class="form-control" value="">
                </div>
                <div class="form-group required">
                     <label class=" control-label">Confirm Password</label>
                     <input type="password" name="password" id="" class="form-control" value="">
                </div>
                <div class="pull-right">
                    <a href="http://localhost/Mykronicle/settings" class="btn btn-default">Cancel</a>
                    <button type="button" onclick="saveObservation();" class="btn btn-info">Save &amp; Next</button>
                </div>
            </form>
        </div> 
    </div>
</div>



<?php $this->load->view('footer'); ?>