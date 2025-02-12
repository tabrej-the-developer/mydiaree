<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recipe | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/baguetteBox.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
	<style>
		a.delete-recipe-btn:hover {
			color: #ffffff;
			background: #ff0000;
		}

		a.delete-recipe-btn{
			color: #ff0000;
		}

		a.edit-recipe-btn:hover {
			color: #ffffff;
			background: #164768;
		}

		a.edit-recipe-btn{
			color: #164768;
		}

		a.load-recipe:hover {
			color: #ffffff;
			background: #37659d;
		}

		a.load-recipe-btn{
			color: #ff0000;
		}

		.btn-item-title{
			padding: 4px 0px 0px 0px!important;
		    margin-bottom: 0px!important;
		    font-size: 15px!important;
		    color: #000000!important;
		}

		.add-ingr{
		    border: 2px solid #008ecc!important;
		}

		.select2-single >.select2-drop-active{
		    margin-top: -25px;
		}

		#ingredient_tbl tbody tr td{
			vertical-align: middle!important;
			font-size: 15px;
		}

		.file-upload-field{
			width: 150px;
		    height: 150px;
		    background-color: #d8efffe6;
		    border: 1px dotted #008ecc;
		    display: flex;
		    align-items: center;
		    justify-content: center;
		    margin: 2px;
		}

		.img-preview, .vid-preview{
			position: relative;
		}

		span.image-remove, span.video-remove{
			position: absolute;
		    display: flex;
		    align-items: center;
		    justify-content: center;
		    top: 5px;
		    right: 6px;
		    height: 22px;
		    width: 22px;
		    text-align: center;
		    font-size: 20px;
		    background-color: #ffffff;
		    border-bottom-left-radius: 50px;
		    border-bottom-right-radius: 50px;
		    border-top-left-radius: 50px;
		    border-top-right-radius: 50px;
		}

		.thumb-image, .thumb-video{
			width: 150px;
		    height: 150px;
		    background-color: #d8efffe6;
		    border: 1px dotted #008ecc;
		    position: relative;
		    margin: 2px;
		}

		#img-holder, #vid-holder{
			display: flex;
			align-items: center;
			justify-content: start;
		}

		#itemImages, #itemVideos{
			display: none;
		}

		.flex-wrap{
			flex-wrap: wrap;
		}

		.load-recipe{
			cursor: pointer;
		}

		.card-img-top{
			max-height: 186px;
		}
	</style>
</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); 
	$role = $this->session->userdata('UserType');
	$logged_user = $this->session->userdata('LoginId');
	if ($role == "Superadmin") {
		$add = 1;
		$edit = 1;
		$delete = 1;
	} else {
		if ($role == "Staff") {
			if (isset($permissions) && !empty($permissions)) {
				$p = $permissions;
				if ($p->addRecipe == 1) {
					$add = 1;
				} else {
					$add = 0;
				}

				if ($p->deleteRecipe == 1) {
					$delete = 1;
				} else {
					$delete = 0;
				}

				if ($p->updateRecipe == 1) {
					$edit = 1;
				} else {
					$edit = 0;
				}	
			}else{
				$add = 0;
				$edit = 0;
				$delete = 0;
			}
		} else {
			$add = 0;
			$edit = 0;
			$delete = 0;
		}
	}
?> 
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>Recipe</h1>
                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Recipe</li>
                    </ol>
                </nav>
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
                <div class="separator mb-5"></div>
            </div>
        </div>
        <?php 
    		if(isset($_GET['status'])){
    			if ($_GET['status']=='added') {
    	?>
    	<div class="row">
    		<div class="col-md-3"></div>
    		<div class="col-md-6">
    			<div class="alert alert-success alert-dismissible fade show rounded mb-0" role="alert">
                    <strong>Success!</strong> Your item has been added!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
    		</div>
    		<div class="col-md-3"></div>
    	</div>
    	<?php
    			}
    		}
    	?>
        <div class="row mb-3">
        	<div class="col-md-10">
        		<h4>Breakfast</h4>
        	</div>
        	<div class="col-md-2 text-right">
        		<?php if ($add==1) { ?>
        		<button class="btn btn-outline-primary btn-sm add-item-btn" type="button" data-toggle="modal" data-type="breakfast" data-target="#myModal2">+ Add new</button>
        		<?php } ?>
        	</div>
        </div>
        <div class="row">
	        <?php 
	        	$i = 1;
	        	foreach ($Recipes as $recipeKey => $rcp) { 
	        		if ($rcp->type == "BREAKFAST") {
	        ?>
			<div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
	            <div class="card">
	                <div class="position-relative">
	                    <a href="#">
	                    	<img class="card-img-top" src="<?= BASE_API_URL.'assets/media/'.$rcp->mediaUrl; ?>" alt="Card image cap">
	                   	</a>
	                   	<?php if ($rcp->userType == "Parent") { ?>
		                    <span class="badge badge-pill badge-theme-1 position-absolute badge-top-left">SUGGESTED</span>
	                   	<?php } ?>
	                </div>
	                <div class="card-body">
	                    <div class="row">
	                        <div class="col-12">
	                        	<?php if ($logged_user == $rcp->createdBy) { ?>
	                        	<button id="<?= 'btnGroup-'.$i; ?>" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                                <?= $rcp->itemName; ?>
	                            </button>
	                            <div class="dropdown-menu" aria-labelledby="<?= 'btnGroup-'.$i; ?>">
	                                <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $rcp->id; ?>">View</a>
	                                <?php if ($edit==1) { ?>
	                                <a class="dropdown-item edit-recipe-btn" href="#!" title="Edit recipe" data-toggle="modal" data-target="#myModal2" data-recipeid="<?php echo $rcp->id; ?>">Edit</a>
		                            <?php } ?>

	                                <?php if ($delete==1) { ?>
	                                <a class="dropdown-item" href="<?= base_url("Recipe/deleteRecipe/").$rcp->id."/".$centerid; ?>">Delete</a>
		                            <?php } ?>
	                            </div>
	                        	<?php }else{ ?>
	                        	<p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $rcp->id; ?>"><?= $rcp->itemName; ?></p>
	                        	<?php } ?>
	                            <p class="text-muted text-small mb-0 font-weight-light">By: <?= $rcp->name; ?> (<?= $rcp->userType; ?>)</p>
	                            <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y',strtotime($rcp->createdAt)); ?></p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div> 
			<?php } $i++; } ?>   	
        </div>
        <div class="row mb-3">
        	<div class="col-md-10">
        		<h4>Lunch</h4>
        	</div>
        	<div class="col-md-2 text-right">
        		<?php if ($add==1) { ?>
        		<button class="btn btn-outline-primary btn-sm add-item-btn" type="button" data-toggle="modal" data-type="lunch" data-target="#myModal2">+ Add new</button>
        		<?php } ?>
        	</div>
        </div>
        <div class="row">
        	<?php 
	        	$i = 1;
	        	foreach ($Recipes as $recipeKey => $rcp) { 
	        		if ($rcp->type == "LUNCH") {
	        ?>
			<div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
	            <div class="card">
	                <div class="position-relative">
	                    <a href="#">
	                    	<img class="card-img-top" src="<?= BASE_API_URL.'assets/media/'.$rcp->mediaUrl; ?>" alt="Card image cap">
	                   	</a>
	                   	<?php if ($rcp->userType == "Parent") { ?>
		                    <span class="badge badge-pill badge-theme-1 position-absolute badge-top-left">SUGGESTED</span>
	                   	<?php } ?>
	                </div>
	                <div class="card-body">
	                    <div class="row">
	                        <div class="col-12">
	                        	<?php if ($logged_user == $rcp->createdBy) { ?>
	                        	<button id="<?= 'btnGroup-'.$i; ?>" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                                <?= $rcp->itemName; ?>
	                            </button>
	                            <div class="dropdown-menu" aria-labelledby="<?= 'btnGroup-'.$i; ?>">
	                                <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $rcp->id; ?>">View</a>
	                                <?php if ($edit==1) { ?>
	                                <a class="dropdown-item edit-recipe-btn" href="#!" title="Edit recipe" data-toggle="modal" data-target="#myModal2" data-recipeid="<?php echo $rcp->id; ?>">Edit</a>
		                            <?php } ?>

	                                <?php if ($delete==1) { ?>
	                                <a class="dropdown-item" href="<?php echo base_url("Recipe/deleteRecipe/").$rcp->id; ?>">Delete</a>
		                            <?php } ?>
	                            </div>
	                        	<?php }else{ ?>
	                        	<p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $rcp->id; ?>"><?= $rcp->itemName; ?></p>
	                        	<?php } ?>
	                            <p class="text-muted text-small mb-0 font-weight-light">By: <?= $rcp->name; ?> (<?= $rcp->userType; ?>)</p>
	                            <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y',strtotime($rcp->createdAt)); ?></p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
			<?php } $i++; } ?> 
        </div>
        <div class="row mb-3">
        	<div class="col-md-10">
        		<h4>Snacks</h4>
        	</div>
        	<div class="col-md-2 text-right">
        		<?php if ($add==1) { ?>
        		<button class="btn btn-outline-primary btn-sm add-item-btn" type="button" data-toggle="modal" data-type="snacks" data-target="#myModal2">+ Add new</button>
        		<?php } ?>
        	</div>
        </div>
        <div class="row">
        	<?php 
	        	$i = 1;
	        	foreach ($Recipes as $recipeKey => $rcp) { 
	        		if ($rcp->type == "SNACKS") {
	        ?>
			<div class="col-xl-3 col-lg-4 col-12 col-sm-6 mb-4">
	            <div class="card">
	                <div class="position-relative">
	                    <a href="#">
	                    	<img class="card-img-top" src="<?= BASE_API_URL.'assets/media/'.$rcp->mediaUrl; ?>" alt="Card image cap">
	                   	</a>
	                   	<?php if ($rcp->userType == "Parent") { ?>
		                    <span class="badge badge-pill badge-theme-1 position-absolute badge-top-left">SUGGESTED</span>
	                   	<?php } ?>
	                </div>
	                <div class="card-body">
	                    <div class="row">
	                        <div class="col-12">
	                        	<?php if ($logged_user == $rcp->createdBy) { ?>
	                        	<button id="<?= 'btnGroup-'.$i; ?>" type="button" class="btn btn-link dropdown-toggle btn-item-title " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	                                <?= $rcp->itemName; ?>
	                            </button>
	                            <div class="dropdown-menu" aria-labelledby="<?= 'btnGroup-'.$i; ?>">
	                                <a class="dropdown-item load-recipe" href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $rcp->id; ?>">View</a>
	                                <?php if ($edit==1) { ?>
	                                <a class="dropdown-item edit-recipe-btn" href="#!" title="Edit recipe" data-toggle="modal" data-target="#myModal2" data-recipeid="<?= $rcp->id; ?>">Edit</a>
		                            <?php } ?>

	                                <?php if ($delete==1) { ?>
	                                <a class="dropdown-item" href="<?php echo base_url("Recipe/deleteRecipe/").$rcp->id; ?>">Delete</a>
		                            <?php } ?>
	                            </div>
	                        	<?php }else{ ?>
	                        	<p class="list-item-heading mb-1 pt-1 load-recipe" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $rcp->id; ?>"><?= $rcp->itemName; ?></p>
	                        	<?php } ?>
	                            <p class="text-muted text-small mb-0 font-weight-light">By: <?= $rcp->name; ?> (<?= $rcp->userType; ?>)</p>
	                            <p class="text-muted text-small mb-0 font-weight-light"><?= date('d.m.Y',strtotime($rcp->createdAt)); ?></p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div> 
			<?php } $i++; } ?> 
        </div>
    </div>
</main>

<!-- View Recipe Modal -->
	<div class="modal fade" id="myModal3" role="dialog" aria-labelledby="view-recipe-modal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="view-recipe-modal"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span class="modal-close" aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div id="modal-recipe-media">
								
							</div>
							<div class="container-fluid mt-5">
								<div class="row mb-5">
									<div class="col-md-2">
										<h5 class="mb-2">Ingredients</h5>
										<div class="separator my-3"></div>
										<div id="modal-ingredient-list" class="text-muted"></div>
									</div>
									<div class="col-md-10">
										<h5 class="mb-2">Recipe</h5>
										<div class="separator my-3"></div>
										<div id="modal-recipe-method" class="text-muted"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">				
					<button data-dismiss="modal" class="btn btn-outline-secondary">Close</button>
				</div>
			</div>
		</div>
	</div>
<!-- End View Recipe Modal -->

<!-- Add item modal -->
	<div class="modal fade sideModal" id="myModal2" role="dialog" aria-labelledby="myModalLabel2">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-primary" id="myModalLabel2">Add Item</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span class="modal-close text-danger" aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="" method="post" enctype="multipart/form-data" id="recipe-form" class="add-recipe-modal">
						<div class="form-group">
							<label for="item-name">Item Name</label>
							<input type="text" name="itemName" id="item-name" class="form-control" required>
						</div>
						<input type="hidden" id="type" name="type" value="">
						<div class="input-group">
						    <select id="ingredients" class="form-control select2-single" data-width="91%">
						        <?php foreach ($ingredients as $ingKey => $ingObj): ?>
						            <option value="<?= $ingObj->id; ?>"><?= $ingObj->text; ?></option>
						        <?php endforeach ?>
						    </select>
						    <span class="input-group-text input-group-append bg-primary text-white input-group-addon add-ingr">
						        <i class="simple-icon-plus"></i>
						    </span>
						</div>
						<div class="form-group">
							<table id="ingredient_tbl" class="table table-condensed">
								<thead>
									<tr>
										<th>Ingredient</th>
										<th>Quantity</th>
										<th>Calories</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
						<div class="form-group">
							<label for="recipe">Recipe</label>
							<textarea name="recipe" id="recipe" class="form-control" rows="4"></textarea>
						</div>
						<div class="form-group">
							<label>Add Image</label>
							<div class="d-flex flex-wrap">
								<div id="img-holder"></div>
								<label class="file-upload-field" for="itemImages">
									<i class="fa fa-plus"></i>
									<span>Upload</span>
								</label>
							</div>
							<input type="file" name="image[]" id="itemImages" class="form-control-hidden" multiple>
						</div>
						<div class="form-group">
							<label>Add Video</label>
							<div class="d-flex flex-wrap">
								<div id="vid-holder"></div>
								<label class="file-upload-field" for="itemVideos">
									<i class="fa fa-plus"></i>
									<span>Upload</span>
								</label>
							</div>
							<input type="file" name="video[]" id="itemVideos" class="form-control-hidden" multiple>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn btn-outline-secondary" type="reset" data-dismiss="modal">Close</button>
					<button class="btn btn-primary" id="recipe-form-submit" type="button">Save</button>
				</div>
			</div>
		</div>
	</div>
<!-- end Add Item Modal -->

	<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <!-- <script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script> -->
	<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>
    <script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <script>
		$(document).ready(function(){

			//add items form
			$(document).on('click', '#recipe-form-submit', function(){
				let _itemName = $('#item-name').val();
				if (_itemName.length > 0) {
					$('#recipe-form').submit();
				}else{
					alert('Please enter item name!');
				}
			});

			$(document).on('click','.add-item-btn',function(){
				var type = $(this).data('type');
				var centerid = '<?= $centerid; ?>';
				$("#type").val(type);
				$("#recipe-form").append("<input type='hidden' name='centerid' value='"+centerid+"'>");
				$('#recipe-form').attr('action', '<?= base_url("Recipe/addRecipe"); ?>');
			});

			CKEDITOR.replace('recipe', {
    plugins: 'mentions,basicstyles,undo,link,wysiwygarea,toolbar,format,list',
    contentsCss: [
        'https://cdn.ckeditor.com/4.22.1/full-all/contents.css',
        'https://ckeditor.com/docs/ckeditor4/4.22.1/examples/assets/mentions/contents.css'
    ],
    height: 150,
    toolbar: [{
            name: 'document',
            items: ['Undo', 'Redo']
        },
        {
            name: 'basicstyles',
            items: ['Bold', 'Italic', 'Strike', 'Format']
        },
        {
            name: 'links',
            items: ['NumberedList', 'BulletedList', 'Link', 'Unlink']
        }
    ]
});
			
			//Add ingredient 
			$('.add-ingr').on('click',function(){

				$('#ingredient_tbl').css("display","block");

				var ingr = $('#ingredients').val();

				var ingr_txt = $('#ingredients option:selected').text();

				if (ingr == null) {

					alert("Please select an ingredient.");

				}else{
					ingr_dupl = [];
					$.each($('.form-ingredient'), function(index, val) {
						ingr_dupl.push(val.value);
					});

					if ($.inArray(ingr, ingr_dupl) != -1) {

						alert("You've already added this ingredient");

					}else{

						$('#ingredient_tbl > tbody:last-child').append(`
							<tr>
								<td width="50%">
									<span class="text-danger rem-ingredient simple-icon-close"></span>&nbsp;`+ingr_txt+`
									<input type="hidden" class="form-ingredient" name="ingredientId[]" value="`+ingr+`" readonly>
								</td>
								<td>
									<input type="text" class="form-control" name="quantity[]" value="">
								</td>
								<td>
									<input type="text" class="form-control" name="calories[]" value="">
								</td>
							</tr>
						`);

					}
				}
			});

			//remove ingredient
			$(document).on('click','.rem-ingredient',function(){
				$(this).closest("tr").remove();
				var rowCount = $('#ingredient_tbl tbody tr').length;
				if (rowCount==0) {
					$('#ingredient_tbl').css("display","none");
				}
			});

			//holding images 
			$("#itemImages").on('change', function () {
				$(".img-preview").remove();
		         //Get count of selected files
		         var countFiles = $(this)[0].files.length;
		         var allGood = true;
		         var mainHolder = $("#img-holder");
		         var image_holder_name = "img-preview-"+i;
		         // image_holder_name.empty();
		         for (var i = 0; i < countFiles; i++) {
		         var imgPath = $(this)[0].files[i].name;
		         var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
		         // var image_holder = $("#img-preview-"+i);
		         // console.log(image_holder);
		         
		         if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
		                if (typeof (FileReader) != "undefined") {
		                //loop for each file selected for uploaded.
		                    var image_holder = $("#img-preview-"+i);
		                      var reader = new FileReader();
		                      reader.onload = function (e) {
		                        mainHolder.append(`<div class="img-preview"><img class="thumb-image" src="${e.target.result}"><span class="image-remove text-danger"><i class="simple-icon-close"></i></span></div>`)
		                      }
		                    reader.readAsDataURL($(this)[0].files[i]);
		                }
		             } else {
		                allGood = false;
		                break;
		                alert("This browser does not support FileReader.");
		             }
		         } 
		         if(!allGood){
		             alert("Pls select only images and videos");
		         }
		    });

		    $("#itemVideos").on('change', function() {
				$(".vid-preview").remove();
				$("#vid-holder").empty();
		         //Get count of selected files
		         var countFiles = $(this)[0].files.length;
		         var allGood = true;
		         var mainHolder = $("#vid-holder");
		         for (var i = 0; i < countFiles; i++) {
		         var vidPath = $(this)[0].files[i].name;
		         var extn = vidPath.substring(vidPath.lastIndexOf('.') + 1).toLowerCase();
		         // var image_holder = $("#img-preview-"+i);
		         // console.log(image_holder);
		         var video_holder_name = "vid-preview-"+i;
		         // video_holder_name.empty();
		         if(extn == "mkv" || extn == "3gp" || extn == "mp4") {
		             if (typeof (FileReader) != "undefined") {
		                //loop for each file selected for uploaded.
		                    var video_holder = $("#vid-preview-"+i);
							var reader = new FileReader();
							reader.onload = function (e) {
							mainHolder.append(`<div class="vid-preview">
							                    <video class="thumb-video" controls>
							                      <source src="${e.target.result}" type="video/mp4">
							                    </video>
							                    <span class="video-remove text-danger"><i class="simple-icon-close"></i></span>
							                  </div>`)

							}
		                    reader.readAsDataURL($(this)[0].files[i]);
		                }
		            } else {
		               allGood = false;
		               break;
		                 alert("This browser does not support FileReader.");
		            }
		         } 
		         if(!allGood){
		             alert("Pls select only videos");
		         }
		    });

		    $(document).on('click','.image-remove',function(){
		        var imgArr = $('#itemImages')[0].files;
		        var length = $('#itemImages')[0].files.length;
		        var len = $(this).parent("div").prevAll().length;
		        let list = new DataTransfer();
		        let myFileList;
		        for(i=0;i<length;i++){
		          if($(this).parent('div').prevAll().length != i){
		          let file = new File(["content"], imgArr[i].name);
		          list.items.add(file);
		          myFileList = list.files;
		          }
		        }
		        $('#itemImages')[0].files  = myFileList
		        $(this).parent().remove();
		    });

		    $(document).on('click','.video-remove',function(){
		        var vidArr = $('#itemVideos')[0].files;
		        var length = $('#itemVideos')[0].files.length;
		        var len = $(this).parent("div").prevAll().length;
		        let list = new DataTransfer();
		        let myFileList;
		        for(i=0;i<length;i++){
		          if($(this).parent('div').prevAll().length != i){
		          let file = new File(["content"], vidArr[i].name);
		          list.items.add(file);
		          myFileList = list.files;
		          }
		        }
		        $('#itemVideos')[0].files  = myFileList
		        $(this).parent().remove();
		    });

		    $(document).on('click','.load-recipe', function(){
		    	var rcpId = $(this).attr("data-recipeid");
		    	$.ajax({ 
		    		traditional:true,
				    url: "<?php echo base_url('Recipe/getRecipeDetails'); ?>",
				    type: "GET",
				    data: {"userid":<?php echo $this->session->userdata('LoginId'); ?>,'rcpId':rcpId},
				    success: function(msg){
				    	console.log(msg);
				    	var res = jQuery.parseJSON(msg);
				        $("#modal-ingredient-list").empty();
				        $("#modal-recipe-method").empty();
				        $("#modal-recipe-media").empty();

				        $('#view-recipe-modal').text(res.Recipes.itemName);

				        var ing = res.Recipes.ingredients;

				        for(i=0;i<ing.length;i++){
				        	$("#modal-ingredient-list").append("<div>"+res.Recipes.ingredients[i].name+"</div>");
				        }

				        $("#modal-recipe-method").html(res.Recipes.recipe);

				        var media = res.Recipes.media;
				        if(media.length==0){
				        	$("#modal-recipe-media").append("<div class='text-center'><img src='<?= base_url('api/assets/media/no-image.png');?>' class='img-fluid'></div>");
				        }else{	

				        	_media = ``;

					        for(i=0; i < media.length; i++){

					        	if (i==0) {
					        		_active = " active";
					        	} else {
					        		_active = "";
					        	}

					        	if(res.Recipes.media[i].mediaType=="Video") {
					        		_media = _media + `
					        			<div class="carousel-item `+_active+`">
									      <video class='d-block w-100' src='<?= base_url('api/assets/media/');?>` + res.Recipes.media[i].mediaUrl + `' controls></video>
									    </div>
					        		`;
					        	}else if (res.Recipes.media[i].mediaType=="Image") {
					        		_media = _media + `
					        			<div class="carousel-item `+_active+`">
									      <img class='d-block w-100' src='<?= base_url('api/assets/media/');?>` + res.Recipes.media[i].mediaUrl + `'>
									    </div>
					        		`;
					        	}
					        }
					    }

					    _carousel = `
					    	<div id="recipe-carousel" class="carousel slide" data-ride="carousel">
								<div class="carousel-inner">
								    `+_media+`
								</div>
								<a class="carousel-control-prev" href="#recipe-carousel" role="button" data-slide="prev">
								    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
								    <span class="sr-only">Previous</span>
								</a>
								<a class="carousel-control-next" href="#recipe-carousel" role="button" data-slide="next">
								    <span class="carousel-control-next-icon" aria-hidden="true"></span>
								    <span class="sr-only">Next</span>
								</a>
							</div>
					    `;

					    $("#modal-recipe-media").append(_carousel);
				    }
				});
		    });

		    $(document).on('click','.edit-recipe-btn', function(){
				
		    	var rcpId = $(this).data("recipeid");

				var form_action_url = "<?= base_url("Recipe/updateRecipe"); ?>";

				$("#recipe-form").attr("action", form_action_url);

		    	$.ajax({ 
		    		traditional:true,
				    url: "<?php echo base_url('Recipe/getRecipeDetails'); ?>",
				    type: "GET",
				    data: {"userid":<?= $this->session->userdata('LoginId'); ?>,'rcpId':rcpId},
				    success: function(msg){

				    	var res = jQuery.parseJSON(msg);
						$('#item-name').val(res.Recipes.itemName);
						$('#recipe').val(res.Recipes.recipe);
						$("#recipe-form").append('<input type="hidden" name="id" value="'+rcpId+'">');
						$('#myModalLabel2').text("Edit Recipe");

						var media = res.Recipes.media;
						$(document).find('.img-preview').remove();
						$(document).find('.vid-preview').remove();

						for(i=0;i<media.length;i++){
				        	if (res.Recipes.media[i].mediaType=="Image") {
					        	$("#img-holder").append('<div class="img-preview"><img class="thumb-image" src="<?php echo base_url("api/assets/media/"); ?>'+res.Recipes.media[i].mediaUrl+'"><span class="image-remove media-rcp-delete" id="'+res.Recipes.media[i].id+'">x</span></div>');
					        }

					        if(res.Recipes.media[i].mediaType=="Video") {
					        	$("#vid-holder").append('<div class="vid-preview"><video class="thumb-video" controls=""><source src="<?php echo base_url("api/assets/media/"); ?>'+res.Recipes.media[i].mediaUrl+'" type="video/mp4"></video><span class="video-remove media-rcp-delete" id="'+res.Recipes.media[i].id+'">x</span></div>');
					        }
				        }

						var ing = res.Recipes.ingredients;
						$(document).find('#ingredient_tbl > tbody').empty();
				        for(i=0;i<ing.length;i++)
				        {
				        	$('#ingredient_tbl > tbody:last-child').append('<tr><td width="50%"><span class="text-danger rem-ingredient simple-icon-close"></span>&nbsp;'+res.Recipes.ingredients[i].name+'<input type="hidden" class="form-ingredient" name="ingredientId[]" value="'+res.Recipes.ingredients[i].ingredientId+'" readonly></td><td><input type="text" class="form-control" name="quantity[]" value="'+res.Recipes.ingredients[i].qty+'"></td><td><input type="text" class="form-control" name="calories[]" value="'+res.Recipes.ingredients[i].calories+'"></td></tr>');
				        }
				    }
				});
		    });

			$(document).on('click','.media-rcp-delete',function(){
				var mediaId = $(this).attr('id');
				if (confirm('Are you sure You want to Delete?')) {
					$.ajax({
						traditional: true,
						url: "<?= base_url('Recipe/deleteRecipeFile'); ?>",
						type: "GET",
					    data: {"userid":<?= $this->session->userdata('LoginId'); ?>,'rowId':mediaId},
					    success: function(msg){
							var res = jQuery.parseJSON(msg);
						}
					});
	    		}	
			});

			$(document).on('click',"button[data-target='#myModal2']",function(){
				var form_action_url = "<?= base_url("Recipe/addRecipe"); ?>";
				$("#recipe-form").attr("action",form_action_url);
				$('#recipe-form')[0].reset();
				$("#img-holder").empty();
				$("#vid-holder").empty();
				$("#ingredient_tbl").css("display","none");
				$('#ingredient_tbl > tbody').empty();
				$("#myModalLabel2").text("Add Item");
			});

			$(document).on('change','#centerid',function(){
				$('#rcpCenters').submit();
			});
		});
	</script>
</body>
</html>