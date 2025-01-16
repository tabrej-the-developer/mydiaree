	<?php #echo '<pre>'; print_r($output);die();

	#echo '<pre>';
#	print_r($output);
	?>
				<div class="container">
					<div class="row">
						<div class="rowHead">
							<div class="col-xs-11">
								<h3>Breakfast</h3>
							</div>
							<div class="col-xs-1">
								<button type="button" data-toggle="modal" data-date="<?php echo $weekday_type; ?>" data-day="<?php echo $weekday_type; ?>" data-type="breakfast" data-target="#myModal2" class="btn btn-info btn-sm add-item-btn btn-default btnBlue btn-small">Add Item</button>
							</div>
						</div>
					</div>
					<div class="row rowListMenu">
					<?php 
					$breakfast=1;

					if (!empty($output->Menu->$breakfast)) {
						foreach ($output->Menu->$breakfast as $key => $value) { 
					?>
						<div class="col-md-3">
							<div class="panel panel-default">
								<div class="panel-heading recipe-img">
								<?php if (empty($value->recipeDetails->media[0]->mediaUrl)) { ?>
								<img src="https://via.placeholder.com/307x218?text=No+Image+Available" class="img-responsive" alt="">
								<?php } else { ?>
								<img src="<?php echo base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl; ?>" class="img-responsive" alt="">
								<?php } ?>
								</div>
								<div class="panel-body">
									<?php echo $value->recipeDetails->itemName; ?>
								<span>
									<a href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>" class="load-recipe">
										<span class="material-icons-outlined">visibility</span>
									</a>
								<?php if ($value->addedBy==$this->session->userdata('LoginId')) { if ($delete==1) {
								?>
									<a href="<?php echo "Menu/deleteMenuItem/".$value->id; ?>" class="edit-recipe-btn">
										<span class="material-icons-outlined">delete</span>
									</a>
								<?php }} ?>
								</span>
								</div>
							</div>
						</div>
					<?php } } ?>	
					</div>
				</div>

				<div class="container">
					<div class="row">
						<div class="rowHead">
							<div class="col-md-11">
								<h3>Lunch</h3>
							</div>
							<div class="col-xs-1">
								
								<button data-toggle="modal" data-date="<?php echo $weekday_type; ?>" data-day="<?php echo $weekday_type; ?>" data-type="lunch" data-target="#myModal2" class="btn btn-info btn-sm add-item-btn btn-default btnBlue btn-small">Add Item</button>
								
							</div>
						</div>
					</div>
					<div class="row rowListMenu">
					<?php 

					$lunch=2;

					if(!empty($output->Menu->$lunch)){
						foreach ($output->Menu->$lunch as $key => $value) { 
					?>
						<div class="col-md-3">
							<div class="panel panel-default">
								<div class="panel-heading recipe-img">
								<?php if (empty($value->recipeDetails->media[0]->mediaUrl)) { ?>
								<img src="https://via.placeholder.com/307x218?text=No+Image+Available" class="img-responsive" alt="">
								<?php } else { ?>
								<img src="<?php echo base_url('api/assets/media/').$value->recipeDetails->media[0]->mediaUrl; ?>" class="img-responsive" alt="">
								<?php } ?>
								</div>
								<div class="panel-body">
									<?php echo $value->recipeDetails->itemName; ?>
								<span>
									<a href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeDetails->id; ?>" class="load-recipe">
										<span class="material-icons-outlined">visibility</span>
									</a>
								<?php 
									if ($value->addedBy==$this->session->userdata('LoginId')) { if ($delete==1) {
								?>
									<a href="<?php echo "Menu/deleteMenuItem/".$value->recipeDetails->id; ?>" class="edit-recipe-btn">
										<span class="material-icons-outlined">delete</span>
									</a>
								<?php }} ?>
								</span>
								</div>
							</div>
						</div>
					<?php } }?>	
					</div>
				</div>

				<div class="container">
					<div class="row">
						<div class="rowHead">
							<div class="col-md-11">
								<h3>Snacks</h3>
							</div>
							<div class="col-xs-1">
								
								<button data-toggle="modal" data-date="<?php echo $weekday_type; ?>" data-day="<?php echo $weekday_type; ?>" data-type="snack" data-target="#myModal2" class="btn btn-info btn-sm add-item-btn btn-default btnBlue btn-small">Add Item</button>
								
							</div>
						</div>
					</div>
					<div class="row rowListMenu">
					<?php
					$snacks=3;
					if (!empty($output->Menu->$snacks)) {
						foreach ($output->Menu->$snacks as $key => $value) { 
					?>
						<div class="col-md-3">
							<div class="panel panel-default">
								<div class="panel-heading recipe-img">
								<?php if (empty($value->media[0]->mediaUrl)) { ?>
								<img src="https://via.placeholder.com/307x218?text=No+Image+Available" class="img-responsive" alt="">
								<?php } else { ?>
								<img src="<?php echo base_url('api/assets/media/').$value->media[0]->mediaUrl; ?>" class="img-responsive" alt="">
								<?php } ?>
								</div>
								<div class="panel-body">
									<?php echo $value->itemName; ?>
								<span>
									<a href="#!" title="View recipe" data-toggle="modal" data-target="#myModal3" data-recipeid="<?php echo $value->recipeid; ?>" class="load-recipe">
										<span class="material-icons-outlined">visibility</span>
									</a>
								<?php 
									if ($value->addedBy==$this->session->userdata('LoginId')) { 
										if ($delete==1) {
								?>
									<a href="<?php echo "Menu/deleteMenuItem/".$value->id; ?>" class="edit-recipe-btn">
										<span class="material-icons-outlined">delete</span>
									</a>
								<?php }} ?>
								</span>
								</div>
							</div>
						</div>
					<?php } } ?>	
					</div>
				</div>
			
