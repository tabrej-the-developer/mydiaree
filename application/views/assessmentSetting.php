<?php
	$data['name']='Assessment Settings'; 
	$this->load->view('header',$data);
?>
<style>
.assessmentCheck{
	display: inline-block;
}

div.rightFOrmSection > form {
	display: block;
}
</style>
<div class="container settingsContainer">
    <div class="pageHead">
		<h1>Settings</h1>
    </div>
	<div class="settingsView">
		<div class="sideMenu">
			<?php $this->load->view('settings-menu-sidebar'); ?>
		</div>
		<div class="rightFOrmSection">
			<h3>
				Assessment Settings		
				<div class="filterAll">
					<select name="centerid" id="centerId" class="form-control">
	                    <?php 
	                        $dupArr = [];
	                        foreach ($this->session->userdata("centerIds") as $key => $center){
	                            if ( ! in_array($center, $dupArr)) {
	                                if (isset($_GET['centerid']) && $_GET['centerid'] != "" && $_GET['centerid']==$center->id) {
	                    ?>
	                    <option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
	                    <?php }else{ ?>
	                    <option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
	                    <?php
	                           }
	                        }
	                        array_push($dupArr, $center);
	                    }
	                    ?>
	               </select>
				</div>			
			</h3>
			<form action="<?= base_url("Settings/saveAsmntSettings"); ?>" method="post">
			<input type="hidden" name="centerid" value="<?= isset($Settings->centerid)?$Settings->centerid:$_GET['centerid']; ?>">
			<div class="assessmentCheck">
				<label for="Montessori" >
					<span class="assessmentCheckName"><a href="<?php echo base_url("Settings/montessori"); ?>">Montessori</a></span>
					<input name="montessori" id="Montessori" type="checkbox" value="1" <?= (isset($Settings->montessori)&&$Settings->montessori==1)?'checked':NULL; ?> >
				</label>
				<label for="EYLF" >
					<span class="assessmentCheckName"><a href="<?php echo base_url("Settings/eylf"); ?>">EYLF</a></span>
					<input name="eylf" id="EYLF" type="checkbox" value="1" <?= (isset($Settings->eylf)&&$Settings->eylf==1)?'checked':NULL; ?> >
				</label>
				<label for="Development-Milestone" >
					<span class="assessmentCheckName"><a href="<?php echo base_url("Settings/developmentmilestone"); ?>">Development Milestone</a></span>
					<input name="devmile" id="Development-Milestone" type="checkbox" value="1" <?= (isset($Settings->devmile)&&$Settings->devmile==1)?'checked':NULL; ?> >
				</label>
			</div>
			<div class="form-group text-right">
				<?php 
					if ($this->session->userdata('UserType') == "Superadmin") {
						$show = 1;
					} elseif ($this->session->userdata('UserType') == "Staff") {
						$show = $Permission->assessment;
					} else{
						$show = 0;
					}

					if ($show==1) {
				?>
				<button type="submit" class="btn btnBlue">Save</button>
				<?php }else{ ?>
				<button type="button" class="btn btnBlue" disabled>Save</button>
				<?php } ?>	
			</div>					
			</form>
		</div>
	</div>
</div>

<?php $this->load->view('footer'); ?>
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
		                // $tempurl = str_replace('centerid=', '', $_SERVER['QUERY_STRING']);
		                $url = $_SERVER['QUERY_STRING']."&centerid=";
		            }
		        } 
		    ?>
		    var url = "<?php echo base_url('Settings/assessment?').$url; ?>"+centerid;
	        var test = url.replace(/&/g, '&');
	        window.location.href=test;
		});
	});
</script>