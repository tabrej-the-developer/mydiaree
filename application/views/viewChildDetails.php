<?php
	$data['name']='All Observations of child'; 
	$this->load->view('header',$data); 
?>
<div class="container viewChildContainer">
	<div class="inner-container">
		<div class="top-utility-section">
			<div class="child-dropdown">
				<form action="" method="get" id="obsChilds">
					<div class="form-group">
						<select name="childid" id="childid" class="form-control form-control-child">
						<?php 
							foreach ($ChildrenList as $childsList => $chList) {
								if (isset($_GET['childid']) && !empty($_GET['childid']) && $_GET['childid'] == $chList->id) {
						?>
						<option value="<?php echo $chList->id; ?>" selected><?php echo $chList->name; ?></option>
						<?php }else{ ?>
						<option value="<?php echo $chList->id; ?>"><?php echo $chList->name; ?></option>
						<?php } } ?>
						</select>
					</div>
				</form>
			</div>
			<div class="center-dropdown">
				<form action="" method="get" id="centerDropdown">
					<div class="form-group">
						<select name="centerid" id="centerId" class="form-control form-control-center">
							<?php 
								$dupArr = [];
								$centersList = $this->session->userdata("centerIds");
								if (empty($centersList)) {
							?>
							<option value="">-- No centers available --</option>
							<?php
								}else{
									foreach($centersList as $key => $center){
									if ( ! in_array($center, $dupArr)) {
										if ($_GET['centerid'] != "" && $_GET['centerid']==$center->id) {
							?>
							<option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
							<?php }else{ ?>
							<option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
							<?php } } array_push($dupArr, $center); } } ?>
						</select>
					</div>
				</form>
			</div>
		</div>
		<div class="row rowViewChildContainer">
			<div class="col-md-3">
				<div class="row">
					<div class="col-md-12">
						<div class="child-profile-box">
							<div class="child-image">
								<?php if (!empty($Children->imageUrl)) { ?>	
								<img src="https://via.placeholder.com/350">
								<?php } else { ?>
								<img src="<?php echo $Children->imageUrl; ?>" alt="">
								<?php } ?>
							</div>
							<div class="child-name">
								<?php echo $Children->name; ?>
							</div>
							<div class="child-dob">
								<?php 
									$dateOfBirth = $Children->dob;
									$today = date("Y-m-d");
									$diff = date_diff(date_create($dateOfBirth), date_create($today));
									echo $diff->y." Years ".$diff->m." months ".$diff->d." days";
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="child-media-box">
						<?php if (isset($Media) && !empty($Media)) { ?>
							<div class="childMediaSlider">	
								<?php 
									foreach ($Media as $mediaKey => $mediaObj) { 
										if ($mediaObj->type=="Image") {
								?>
								<div>
									<img src="<?php echo BASE_API_URL."assets/media/".$mediaObj->filename; ?>">
									<p class="text-center"><?php echo $mediaObj->caption; ?></p>
								</div>
								<?php } else if($mediaObj->type=="Video") { ?>
								<div>
									<video src="<?php echo BASE_API_URL."assets/media/".$mediaObj->filename; ?>" controls></video>
									<p class="text-center"><?php echo $mediaObj->caption; ?></p>
								</div>		
								<?php } } ?>
							</div>
							<div class="thumbMedia">
								<?php 
									$i = 0;
									foreach ($Media as $key => $obj) {
								?>
								<span class="media-thumb" data-slide="<?php echo $i; ?>"><img src="<?php echo BASE_API_URL."assets/media/".$obj->filename; ?>" width="75px" height="75px"></span>
								<?php $i++; } ?>                       
	                        </div>
						<?php } ?>	
						</div>					
					</div>
				</div>					
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6">
						<h3>Observations</h3>
					</div>
					<div class="col-md-3"></div>
					<div class="col-md-3">
						<select name="sort" id="dropdown-sort" class="form-control">
							<option hidden>--Sort By--</option>
							<?php 
								if(isset($_GET['sort']) && $_GET['sort']!=""){
									if ($_GET['sort']=="DESC") {
							?>
							<option value="DESC" selected="">Newest first</option>
							<option value="ASC">Oldest first</option>
							<?php
									} else {
							?>
							<option value="DESC">Newest first</option>
							<option value="ASC" selected>Oldest first</option>
							<?php
									}
								}else{
							?>
							<option value="DESC">Newest first</option>
							<option value="ASC">Oldest first</option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-md-12">
					<?php 
					foreach($Observations as $observation) { 
						$obsId=$observation->id;  
					?>
					<div class="obsListBox child-obs-item">
						<div class="obsListBoxImg text-center">
						<?php if(empty($observation->observationsMedia)) { ?>
						<div class="imageobser">
							<img src="<?php echo base_url(); ?>assets/images/350x200.png" alt="no media available">
						</div>
						<?php } else{ ?>
						<div class="imageobser">
						<?php if($observation->observationsMediaType=='Image') { ?>
							<img src="<?php echo base_url('/api/assets/media/'.$observation->observationsMedia); ?>" >
						<?php } else if($observation->observationsMediaType=='Video') { ?>
							<video style="height: auto;width: 100%" controls>
								<source src="<?php echo base_url('/api/assets/media/'.$observation->observationsMedia); ?>" >
							</video>
						<?php } ?> 
						</div>
						<?php } ?>
						</div>
						<div class="obsListBoxAbt">
							
						<?php if($observation->status=='Published') { ?>
						<div class="spanborder pull-right">
							<span class="material-icons-outlined">done</span>
							<?php echo $observation->status; ?>&nbsp;
						</div>
						<?php } ?>
							
							<a class="obsTitle" href="<?php echo base_url('observation/view?id='.$obsId); ?>">
								<span class="obserb">
									<strong><?php echo $observation->title; ?></strong>
								</span>
							</a>
							<div class="flexAuthor">
								<div >
									<span class="author">Author:</span> 
									<a href="#!">
										<span class="authorname"><?php echo $observation->user_name; ?></span>
									</a>
								</div>
								<?php if(isset($observation->approverName) && $observation->approverName) { ?>
								<div>
									<span class="author">Approved by:</span>
									<a href="#!">
										<span class="authorname"><?php echo $observation->approverName; ?></span>
									</a>
								</div>
								<?php } ?>
							</div>
							<p class="flexAuthorDate">
								<span class="author">Date:</span>
								<a href="#!">
									<span class="authorname">
										<?php echo date("d/m/Y",strtotime($observation->date_added)); ?>
									</span>
								</a>
							</p>
							<?php if(!empty($observation->observationChildrens)) { ?>
							<div class="divchild NameChild">
								<?php 
									$i=1; 
									foreach($observation->observationChildrens as $observationChildren) { 
										if (empty($observationChildren->imageUrl)) {
								?>
								<div class="child-icon">
									<img class="circleimage" src="<?php echo base_url('assets/images/user.png'); ?>" width="30" height="30">
									<span class="childname">
										<?php echo $observationChildren->child_name; ?>
									</span>
								</div>
								<?php } else { ?>
								<div>
									<img class="circleimage" src="<?php echo base_url('/api/assets/media/'.$observationChildren->imageUrl); ?>" width="30" height="30">
									<span class="childname">
										<?php echo $observationChildren->child_name; ?>
									</span>
								</div>
								<?php } 
										if($i>=2) { $i++; break; } 
										$i++; 
									} 
									if($i>2) { ?>
									<span class="countChildSpan">
										<a href="<?php echo base_url('observation/view?id='.$obsId); ?>">
											<span class="countchild">+<?php echo count($observation->observationChildrens)-2; ?></span>
										</a>
									</span>
								<?php } ?>
							</div>
							<?php } ?>
							
							<div class="divmon">
								<?php if(!empty($observation->montessoricount)) { ?> 
								<span class="mon">Montessori <span class="moncount"><?php echo $observation->montessoricount; ?></span></span>
								<?php } if(!empty($observation->eylfcount)) { ?>
								<span class="mon">EYLF <span class="moncount"><?php echo $observation->eylfcount; ?></span></span>
								<?php } if(!empty($observation->milestonecount)) { ?>
								<span class="mon">DM <span class="moncount"><?php echo $observation->milestonecount; ?></span></span>
								<?php } ?>
							</div>
						</div>
					</div>
					<?php  } ?>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="child-relatives-box">
					<h3>Relatives</h3>
					<?php 
						if(empty($Relatives)){
							echo "No relatives found!";
						}else{
							foreach ($Relatives as $relatives => $relative) {
					?>
					<div class="relatives-box">
						<div class="relative-image">
							<?php if (empty($relative->imageUrl)) { ?>	
							<img src="https://via.placeholder.com/250">
							<?php } else { ?>
							<img src="<?php echo $relative->imageUrl; ?>">
							<?php } ?>
						</div>
						<div class="relative-details">
							<div class="relative-name"><?php echo $relative->username; ?></div>
							<div class="relative-relation"><?php echo $relative->relation; ?></div>
						</div>
					</div>
					<?php
							}
						}
					?>
				</div>
				<div class="child-other-info">
					<h3>Other Info</h3>
					<ul>
						<li>Gender: <?php echo $Children->gender; ?></li>
						<li>Status: <?php echo $Children->status; ?></li>
						<li>Dob: <?php echo $Children->dob; ?></li>
					</ul>
				</div>
			</div>
		</div>			
	</div>	
</div>
<?php $this->load->view('footer'); ?>
<script>
	$(document).ready(function(){
		$(".childMediaSlider").slick();

		$("#childid").on('change',function(){
			$("#obsChilds").submit();
		});

		$("#dropdown-sort").on('change',function(){
		   let sort = $(this).val();
		   <?php  
		    $qs = $_SERVER['QUERY_STRING'];
		         
            if (isset($_GET['sort'])&&$_GET['sort']!="") {
               $url = str_replace('sort='.$_GET['sort'], 'sort=', $_SERVER['QUERY_STRING']);
            } else {
               $url = $_SERVER['QUERY_STRING']."&sort=";
            }
		   ?>
		         var url = "<?php echo base_url('observation/viewChild?').$url; ?>"+sort;
		         var test = url.replace(/&/g, '&');
		         window.location.href=test;
		});

		$("#centerId").on('change',function(){
			let centerid = $(this).val();
			$.ajax({
				url: '<?php echo base_url("observation/getChildFromCenter"); ?>',
				type: 'post',
				data: {"centerid": centerid},
			})
			.done(function(msg) {
				res = jQuery.parseJSON(msg);
				$("#childid").empty();
				if (res.ChildList.length == 0) {
					$("#childid").append(`
						<option selected hidden>No Children</option>	
					`);
				} else {
					$(res.ChildList).each(function(index, list) {
						$("#childid").append(`
							<option value="`+list.childid+`">`+list.name+`</option>	
						`);
					});
				}
			});
			
		});
	});

	$(document).on("click",'.thumbMedia > span[data-slide]',function(e) {
	    e.preventDefault();
	    var slideno = $(this).data('slide');
	    $('.childMediaSlider').slick('slickGoTo', slideno);
	});
</script>	