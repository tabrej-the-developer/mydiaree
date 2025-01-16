<?php
	$data['name']='Observation'; 
	$this->load->view('header',$data); 
?>

<div class="container observationListContainer">
	<div class="pageHead" style="margin-top: 20px;">
		<h1>Observation</h1>
			<div class="obsMenuTop">
				<form action="" method="get" id="obsCenters">
					<div class="form-group">
						<select name="centerid" id="centerid" class="form-control">
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
				<a href="<?php echo base_url('observation/observation_dashboard?type=filter'); ?>" class="btn btn-default btn-small filterAll">
					<span class="material-icons-outlined">filter_alt</span>
				</a>
				<?php 
					$role = $this->session->userdata('UserType');

					if ($role=="Staff") {
						if (isset($permissions)) {
							if ($permissions->addObservation == 1) {
								$show = 1;
							} else {
								$show = 0;
							}

							if ($permissions->viewAllObservation == 1) {
								$showList = 1;
							} else {
								$showList = 0;
							}
							
						}else {
							$show = 0;
							$showList = 0;
						}
					} else {
						$show = 1;
						$showList = 1;
					}
					
					if ($show == 1) {
				?>
				<a href="<?php echo base_url('observation/add'); ?>" class="btn btn-default btn-small btnBlue">
					<span class="material-icons-outlined">add</span> Add Observation
				</a>
				<?php } ?>
			</div>
		
	</div>
	<ul class="breadcrumb">
		<li><a href="#">Application</a></li>
		<li class="active">Observation</li>
	</ul>
	<?php if($type=='filter') { ?>
		<div class="observationFlex">
			<?php if($showList == 1){ ?>
			<div class="obsListView">
				<div class="publishedobservation" id="example">
					<?php 
					if(!empty($observations)){
						foreach($observations as $observation) { 
							$obsId=$observation->id;  
					?>
					<div class="obsListBox">
						<div class="obsListBoxImg">
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
							<div class="divmon">
								<?php if(!empty($observation->montessoricount)) { ?> 
								<span class="mon">Montessori <span class="moncount"><?php echo $observation->montessoricount; ?></span></span>
								<?php } if(!empty($observation->eylfcount)) { ?>
								<span class="mon">EYLF <span class="moncount"><?php echo $observation->eylfcount; ?></span></span>
								<?php } if(!empty($observation->milestonecount)) { ?>
								<span class="mon">DM <span class="moncount"><?php echo $observation->milestonecount; ?></span></span>
								<?php } ?>
							</div>
							<?php if($observation->status=='Published') { ?>
							<div class="spanborder pull-right">
								<span class="material-icons-outlined">done</span>
								<?php echo $observation->status; ?>&nbsp;
							</div>
							<?php } ?>
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
							<a class="obsTitle" href="<?php echo base_url('observation/view?id='.$obsId); ?>">
								<span class="obserb">
									<strong><?php echo strip_tags(html_entity_decode($observation->title)); ?></strong>
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

							<p class="flexAuthorDate"><span class="author">Date:</span><a href="#!"><span class="authorname"><?php echo date("d/m/Y",strtotime($observation->date_added)); ?></span></a></p>
						</div>
					</div>
					<?php  
						}
					}else{ ?>
					<h3 class="text-center">
						No Observations Found!
					</h3>
					<?php } ?>
				</div>
			</div>
			<?php }else{ ?>
			<h3 class="text-center">Not enough permission!</h3>
			<?php } ?>
			<div class="block filterBlock">
				<span class="applyfilters">Apply Filters</span>
				<button class="filtercollapsible">
					Observation status
					<span class="subchild" style="float: right;">
					<span class="material-icons-outlined">keyboard_arrow_down</span>
					</span>
				</button>
				<div class="filtercontent">
					<span style="margin-bottom: 30px;">
						<span>
							<input type="checkbox" class="filter_observation" value="Draft">
						</span>
						<span class="filterspan">In Draft</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span>
							<input type="checkbox" class="filter_observation" value="Published">
						</span>
						<span class="filterspan">Published</span>
					</span>
					</br>
				</div>
         		<button class="filtercollapsible">
         			Added
         			<span class="subchild" style="float: right;">
					<span class="material-icons-outlined">keyboard_arrow_down</span>
         			</span>
         		</button>
         		<div class="filtercontent">
					<span style="margin-bottom: 30px;">
						<span>
							<input type="radio" class="filter_added" name="filter_added" value="None">
						</span>
						<span class="filterspan">None</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span>
							<input type="radio" class="filter_added" name="filter_added" value="Today">
						</span>
						<span class="filterspan">Today</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="radio" class="filter_added" name="filter_added" value="This Week"></span>
						<span class="filterspan">This Week</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="radio" class="filter_added" name="filter_added" value="This Month"></span>
						<span class="filterspan">This Month</span>
					</span>
					</br>
					</br>
				</div>
				<button class="filtercollapsible">
					Child
					<span class="subchild" style="float: right;">
					<span class="material-icons-outlined">keyboard_arrow_down</span>
					</span>
				</button>
				<div class="filtercontent">
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_child" value="All"></span>
						<span class="filterspan">All Children</span>
					</span>
					</br>
					<?php foreach($childs as $child) { ?>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_child" value="<?php echo $child->id; ?>"></span>
						<span class="filterspan"><?php echo $child->name; ?></span>
					</span>
					<?php } ?>
       			</div>
				<button class="filtercollapsible">
					Author
					<span class="subchild" style="float: right;">
					<span class="material-icons-outlined">keyboard_arrow_down</span>
					</span>
				</button>
				<div class="filtercontent">
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_author" value="Any"></span>
						<span class="filterspan">Any</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_author" value="Me"></span>
						<span class="filterspan">Me</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_author" value="Staff"></span>
						<span class="filterspan">Staff</span>
					</span>
				</div>
				<button class="filtercollapsible">
					Assessment
					<span class="subchild" style="float: right;">
					<span class="material-icons-outlined">keyboard_arrow_down</span>
					</span>
				</button>
				<div class="filtercontent">
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_assessment" value="Does Not Have Any Assessment"></span>
						<span class="filterspan">Does Not Have Any Assessment</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_assessment" value="Has Montessori"></span>
						<span class="filterspan">Has Montessori</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_assessment" value="Has Early Years Learning Framework"></span>
						<span class="filterspan">Has Early Years Learning Framework</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_assessment" value="Has Developmental Milestones"></span>
						<span class="filterspan">Has Developmental Milestones</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_assessment" value="Does Not Have Montessori"></span>
						<span class="filterspan">Does Not Have Montessori</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_assessment" value="Does Not Have Early Years Learning Framework"></span>
						<span class="filterspan">Does Not Have Early Years Learning Framework</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_assessment" value="Does Not Have Developmental Milestones"></span>
						<span class="filterspan">Does Not Have Developmental Milestones</span>
					</span>
					</br>
				</div>
				<button class="filtercollapsible">
					Media
					<span class="subchild" style="float: right;">
					<span class="material-icons-outlined">keyboard_arrow_down</span>
					</span>
				</button>
    			<div class="filtercontent">
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_media" value="Any"></span>
						<span class="filterspan">Any</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_media" value="Image"></span>
						<span class="filterspan">Image</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_media" value="Video"></span>
						<span class="filterspan">Video</span>
					</span>
					</br>
				</div>
				<button class="filtercollapsible">
					Comments
					<span class="subchild" style="float: right;">
					<span class="material-icons-outlined">keyboard_arrow_down</span>
					</span>
				</button>
      			<div class="filtercontent">
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_comment" value="Any"></span>
						<span class="filterspan">Any</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_comment" value="With Comments"></span>
						<span class="filterspan">With Comments</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_comment" value="With Staff Comments"></span>
						<span class="filterspan">With Staff Comments</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_comment" value="With Relative Comments"></span>
						<span class="filterspan">With Relative Comments</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_comment" value="No Comments"></span>
						<span class="filterspan">No Comments</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_comment" value="No Staff Comments"></span>
						<span class="filterspan">No Staff Comments</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_comment" value="No Relative Comments"></span>
						<span class="filterspan">No Relative Comments</span>
					</span>
					</br>
				</div>
				<button class="filtercollapsible">
					Links
					<span class="subchild" style="float: right;">
					<span class="material-icons-outlined">keyboard_arrow_down</span>
					</span>
				</button>
      			<div class="filtercontent">
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_link" value="Not Filtered"></span>
						<span class="filterspan">Not Filtered</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_link" value="Linked to anything"></span>
						<span class="filterspan">Linked to anything</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_link" value="Not Linked to anything"></span>
						<span class="filterspan">Not Linked to anything</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_link" value="Linked to observations"></span>
						<span class="filterspan">Linked to observations</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_link" value="Not Linked to observations"></span>
						<span class="filterspan">Not Linked to observations</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_link" value="Linked to reflections"></span>
						<span class="filterspan">Linked to reflections</span>
					</span>
					</br>
					<span style="margin-bottom: 30px;">
						<span><input type="checkbox" class="filter_link" value="Not Linked to reflections"></span>
						<span class="filterspan">Not Linked to reflections</span>
					</span>
					</br>
				</div>
			</div>
		</div>
	<?php } else { ?>
		<div id="example">
			<?php 
			if($showList == 1){ 
				if (empty($observations)) {
			?>
				<h3 class="text-center">No Observations Found!</h3>
			<?php
				}else{
					foreach($observations as $observation) { 
						$obsId=$observation->id; 
			?>
				<div class="obsListBox">
					<div class="obsListBoxImg">
						<?php if(empty($observation->observationsMedia)) { ?>
							<div class="imageobser">
								<img src="<?php echo base_url(); ?>assets/images/350x200.png" alt="no media available">
							</div>
						<?php } else{ ?>
						<div class="imageobser">
							<?php if($observation->observationsMediaType=='Image') { ?>
								<img src="<?php echo base_url('/api/assets/media/'.$observation->observationsMedia); ?>" style="height: auto;width: 100%">
							<?php } else if($observation->observationsMediaType=='Video') { ?>
								<video style="height: auto;width: 100%" controls>
		   							<source src="<?php echo base_url('/api/assets/media/'.$observation->observationsMedia); ?>" >
		   						</video>
							<?php } ?> 
						</div>
						<?php } ?>
					</div>
					<div class="obsListBoxAbt">
						<div class="divmon">
					 		<?php if(!empty($observation->montessoricount)) { ?> 
							<span class="mon">Montessori <span class="moncount"><?php echo $observation->montessoricount; ?></span></span>
							<?php } if(!empty($observation->eylfcount)) { ?>
							<span class="mon">EYLF <span class="moncount"><?php echo $observation->eylfcount; ?></span></span>
							<?php } if(!empty($observation->milestonecount)) { ?>
							<span class="mon">DM <span class="moncount"><?php echo $observation->milestonecount; ?></span></span>
							<?php } ?>
						</div>
						<?php if($observation->status=='Published') { ?>
						<div class="spanborder pull-right">
							&nbsp;<span class="material-icons">done_all</span>
							&nbsp;&nbsp;<?php echo $observation->status; ?>&nbsp;
						</div>
						<?php } ?>
						<?php if(!empty($observation->observationChildrens)) { ?>
						<div class="divchild NameChild">
							<div style="display: inline-flex;">
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
								<?php 
										} 
										if($i>=2) { $i++; break; } 
										$i++; 
									} 
									if($i>2) { ?>
									<span style="margin-left: 10px">
										<a href="<?php echo base_url('observation/view?id='.$obsId); ?>">
											<span class="countchild">+<?php echo count($observation->observationChildrens)-2; ?></span>
										</a>
									</span>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
						<a href="<?php echo base_url('observation/view?id='.$obsId); ?>">
							<span class="obserb">
								<strong><?php echo strip_tags(html_entity_decode($observation->title)); ?></strong>
							</span>
						</a>
						<p style="float: none;">
							<div style="display: inline-block;width: 300px;">
								<span class="author">Author:</span> 
								<a href="#!">
									<span class="authorname"><?php echo $observation->user_name; ?></span>
								</a>
							</div>
							<?php if(isset($observation->approverName) && $observation->approverName) { ?>
							<div style="display: inline-block;width: 300px;">
								<span class="author">Approved by:</span>
								<a href="#!">
									<span class="authorname"><?php echo $observation->approverName; ?></span>
								</a>
							</div>
							<?php } ?>
						</p>
						<p><span class="author">Date:</span><a href="#!"><span class="authorname"><?php echo date("d/m/Y",strtotime($observation->date_added)); ?></span></a></p>
					</div>
				</div>
			<?php 
					}
				}
			}else{ 
			?>
			<h1 class="text-center">Not enough permission!</h1>
			<?php } ?>
		</div>
	<?php } ?>
</div>
<?php $this->load->view('footer'); ?>
<script>
	var base_url='<?php echo base_url(); ?>';

	// $('body').on('DOMSubtreeModified', '#example', function(element, options){
	// 	var defaults = {
 //            perPage:                10,              //how many items per page
 //            autoScroll:             true,           //boolean: scroll to top of the container if a user clicks on a pagination link
 //            scope:                  '',             //which elements to target
 //            paginatePosition:       ['bottom'],     //defines where the pagination will be displayed
 //            containerTag:           'nav',
 //            paginationTag:          'ul',
 //            itemTag:                'li',
 //            linkTag:                'a',
 //            useHashLocation:        true,           //Determines whether or not the plugin makes use of hash locations
 //            onPageClick:            function() {}   //Triggered when a pagination link is clicked
 //        };

 //        var plugin = this;
 //        var plugin_index = $('.paginate').length;

 //        plugin.settings = {};

 //        var $element = $(element);
 //        var curPage, items, offset, maxPage;

 //        /*
 //            #Initliazes plugin
 //        */
 //        plugin.init = function() {
	//         plugin.settings = $.extend({}, defaults, options);
	// 		curPage = 1;
	//         items =  $element.children(plugin.settings.scope);
	//         maxPage = Math.ceil( items.length / plugin.settings.perPage ); //determines how many pages exist
	// 		var paginationHTML = generatePagination(); //generate HTML for pageination

	//         if($.inArray('top', plugin.settings.paginatePosition) > -1) {
	//             $element.before(paginationHTML);
	//         }

	//         if($.inArray('bottom', plugin.settings.paginatePosition) > -1) {
	//             $element.after(paginationHTML);
	//         }

	//         $element.addClass("paginate");
	//         $element.addClass("paginate-" + plugin_index);

	//         var hash = location.hash.match(/\#paginate\-(\d)/i);

	//         //Check if URL has matching location hash
	//         if(hash && plugin.settings.useHashLocation) {
	//             plugin.switchPage(hash[1]);
	//         } else {
	//             plugin.switchPage(1); //go to initial page
	//         }

 //        };

 //        /*
 //            #Switch to Page > 'page'
 //        */
 //        plugin.switchPage = function(page) {

 //            if(page == "next") {
 //                page = curPage + 1;
 //            }

 //            if(page == "prev") {
 //                page = curPage - 1;
 //            }

 //            //If page is out of range return false
 //            if(page < 1 || page > maxPage) {
 //                return false;
 //            }

 //            if(page > maxPage) {
 //                $('.paginate-pagination-' + plugin_index).find('.page-next').addClass("deactive");
 //                return false;
 //            } else {
 //                $('.paginate-pagination-' + plugin_index).find('.page-next').removeClass("deactive");
 //            }

 //            $('.paginate-pagination-' + plugin_index).find('.active').removeClass('active');
 //            $('.paginate-pagination-' + plugin_index).find('.page-' + page).addClass('active');

 //            offset = (page - 1) * plugin.settings.perPage;

 //            $( items ).hide();

 //            //Display items of page
 //            for(i = 0; i < plugin.settings.perPage; i++) {
 //                if($( items[i + offset] ).length)
 //                    $( items[i + offset] ).fadeTo(100, 1);
 //            }

 //            //Deactive prev button
 //            if(page == 1) {
 //                $('.paginate-pagination-' + plugin_index).find('.page-prev').addClass("deactive");
 //            } else {
 //                $('.paginate-pagination-' + plugin_index).find('.page-prev').removeClass("deactive");
 //            }

 //            //Deactive next button
 //            if(page == maxPage) {
 //                $('.paginate-pagination-' + plugin_index).find('.page-next').addClass("deactive");
 //            } else {
 //                $('.paginate-pagination-' + plugin_index).find('.page-next').removeClass("deactive");
 //            }

 //            curPage = page;

 //            return curPage;

 //        };

 //        /*
 //        #Kills plugin
 //        */
 //        plugin.kill = function() {

 //            $( items ).show();
 //            $('.paginate-pagination-' + plugin_index).remove();
 //            $element.removeClass('paginate');
 //            $element.removeData('paginate');

 //        };

 //        /*
 //        #Generates HTML for pagination (nav)
 //        */
 //        var generatePagination = function() {
 //            var paginationEl = '<' + plugin.settings.containerTag + ' class="paginate-pagination paginate-pagination-' + plugin_index + '" data-parent="' + plugin_index + '">';
 //            paginationEl += '<' + plugin.settings.paginationTag + ' style="display:flex;">';

 //            paginationEl += '<' + plugin.settings.itemTag + ' style="width:5% !important;">';
 //            paginationEl += '<' + plugin.settings.linkTag + ' href="#" data-page="prev" class="page page-prev">&laquo;</' + plugin.settings.linkTag + '>';
 //            paginationEl += '</' + plugin.settings.itemTag + '>';

 //            for(i = 1; i <= maxPage; i++) {
 //                paginationEl += '<' + plugin.settings.itemTag + ' style="width:5% !important;">';
 //                paginationEl += '<' + plugin.settings.linkTag + ' href="#paginate-' + i + '" data-page="' + i + '" class="page page-' + i + '">' + i + '</' + plugin.settings.linkTag + '>';
 //                paginationEl += '</' + plugin.settings.itemTag + '>';
 //            }

 //            paginationEl += '<' + plugin.settings.itemTag + ' style="width:5% !important;">';
 //            paginationEl += '<' + plugin.settings.linkTag + ' href="#" data-page="next" class="page page-next">&raquo;</' + plugin.settings.linkTag + '>';
 //            paginationEl += '</' + plugin.settings.itemTag + '>';

 //            paginationEl += '</' + plugin.settings.paginationTag + '>';
 //            paginationEl += '</' + plugin.settings.containerTag + '>';

 //            //Adds event listener for the buttons
 //            $(document).on('click', '.paginate-pagination-' + plugin_index + ' .page', function(e) {
 //                e.preventDefault();

 //                var page = $(this).data('page');
 //                var paginateParent = $(this).parents('.paginate-pagination').data('parent');

 //                //Call onPageClick callback function
 //                $('.paginate-' + paginateParent).data('paginate').settings.onPageClick();

 //                page = $('.paginate-' + paginateParent).data('paginate').switchPage(page);

 //                if(page) {
 //                    if(plugin.settings.useHashLocation)
 //                        location.hash = '#paginate-' + page; //set location hash

 //                    if(plugin.settings.autoScroll)
 //                        $('html, body').animate({scrollTop: $('.paginate-' + paginateParent).offset().top}, 'slow');

 //                }

 //            });

 //            return paginationEl;

 //        };

 //        plugin.init();
	// });



	$('.filtercollapsible').click(function(){
		if($(this).hasClass("active"))
		{
			$(this).find('.subchild').html('<span class="material-icons-outlined">keyboard_arrow_down</span>');
		}else{
				$(this).find('.subchild').html('<span class="material-icons-outlined">keyboard_arrow_up</span>');
		}
	});

	function filters()
	{
		var childs=[];
		$('.filter_child').each(function(){
			if($(this).prop("checked") == true){
				if($(this).val()=='All')
				{
					childs=[];
					return false;
				}else{
					childs.push($(this).val());
				}
			}
		});

		var authors=[];
		$('.filter_author').each(function(){
			if($(this).prop("checked") == true ){
				authors.push($(this).val());
			}
		});

		var assessments=[];
		$('.filter_assessment').each(function(){
			if($(this).prop("checked") == true ){
				assessments.push($(this).val());
			}
		});
		
		var observations=[];
		$('.filter_observation').each(function(){
			if($(this).prop("checked") == true ){
				observations.push($(this).val());
			}
		});
		
		var added=[];
		$('.filter_added').each(function(){
			if($(this).prop("checked") == true ){
				if($(this).val()=='All')
				{
					added=[];
					return false;
				}else{
					added.push($(this).val());
				}			
			}
		});

		var media=[];
		$('.filter_media').each(function(){
			if($(this).prop("checked") == true ){
				if($(this).val()=='Any')
				{
					media=[];
					return false;
				}else{
					media.push($(this).val());
				}
			}
		});
		
		var comments=[];
		$('.filter_comment').each(function(){
			if($(this).prop("checked") == true ){
				if($(this).val()=='Any')
				{
					comments=[];
					return false;
				}else{
					comments.push($(this).val());
				}	
			}
		});
		
		var links=[];
		$('.filter_link').each(function(){
			if($(this).prop("checked") == true ){
				if($(this).val()=='Not Filtered')
				{
					links=[];
					return false;
				}else{
					links.push($(this).val());
				}
			}
		});

		$.ajax({
		    type:'POST',
		    url: '<?php echo base_url('observation/listfilters'); ?>',
			data:'childs='+childs+'&authors='+authors+'&assessments='+assessments+'&observations='+observations+'&added='+added+'&media='+media+'&comments='+comments+'&links='+links,
			datatype:'json',
			success: function(json) {
				// console.log('childs='+childs+'&authors='+authors+'&assessments='+assessments+'&observations='+observations+'&added='+added+'&media='+media+'&comments='+comments+'&links='+links);
				// console.log(json);
				json=JSON.parse(json);
				var msg='';
				$.each(json.observations,function(key,val){
					msg+='<div class="obsListBox"><div class="obsListBoxImg">';
					if(val.media==""){
						msg+='<div class="imageobser"><img src="'+base_url+'assets/images/350x200.png" alt="no media available"></div>';
					}else{
						msg+='<div class="imageobser"><img src="'+base_url+'api/assets/media/'+val.media+'" alt="'+val.media+'"></div>';
					}
					msg+='</div><div class="obsListBoxAbt"><div class="divmon">';
					if(val.montessoryCount!=0)
					{
						msg+='<span class="mon">Montessori <span class="moncount">'+val.montessoryCount+'</span></span>';
					}
					if(val.eylfCount!=0)
					{
						msg+='<span class="mon">EYLF <span class="moncount">'+val.eylfCount+'</span></span>';
					}
					if(val.milestoneCount!=0)
					{
						msg+='<span class="mon">DM <span class="moncount">'+val.milestoneCount+'</span></span>';
					}
	      			msg+='</div>';
	      			if(val.status=='Published')
					{
						msg+='<div class="spanborder pull-right">&nbsp;<span class="material-icons">done_all</span>&nbsp;&nbsp;'+val.status+'&nbsp;</div>';
					}
					if(Object.keys(val.childs).length!=0)
					{
						msg+='<div class="divchild NameChild"><span style="display: inline-flex;">';
						var i=1;
						$.each(val.childs,function(ckey,child){
							if (child.imageUrl=="") {
								msg+='<div class="child-icon"><img class="circleimage" src="'+base_url+'/assets/images/user.png" width="30" height="30">'+'&nbsp;<span class="childname">'+child.child_name+'</span></div>'
							} else {
								msg+='<div class="child-icon"><img class="circleimage" src="'+base_url+'/api/assets/media/'+child.imageUrl+'" width="30" height="30">'+'&nbsp;<span class="childname">'+child.child_name+'</span></div>'
							}
							if(i>=2) {
								i++;
								return false;
							}			
							i++;
						});
						if(i>2)
						{
							var count=Object.keys(val.childs).length-2;
							if(count!=0){
								msg+='<span style="margin-left: 20px"><a href="'+base_url+'observation/view?id='+key+'">'+
					            '<span class="countchild">+'+count+'</span></a></span>'
							}							
						}
				        msg+='</span></div>';
					}
					msg+='<a href="'+base_url+'observation/view?id='+key+'" style="margin-left:20px;"><span class="obserb"><strong>'+val.title+'</strong></span></a>';
					msg+=`<p style="float: none;">
							<div style="display: inline-block;width: 200px; margin-left: 20px;">
								<span class="author">Author:</span> 
								<a href="#!">
									<span class="authorname">`+val.userName+`</span>
								</a>
							</div>
							<?php if(isset($observation->approverName) && $observation->approverName) { ?>
							<div style="display: inline-block;width: 200px;">
								<span class="author">Approved by:</span>
								<a href="#!">
									<span class="authorname">`+val.approverName+`</span>
								</a>
							</div>
							<?php } ?>
						</p>`;
					msg+='<p style="margin-left: 20px;"><span class="author">Date:</span><a href="#!"><span class="authorname">'+val.date_added+'</span></a></p>';
					msg+='</div></div>';
				});
				$('.publishedobservation').html(msg);
				// pagination();
			}
		});
	}
	
	$('.filter_observation').click(function(){
		var val=$(this).val();
		if(val=='In Draft')
		{
			if($(this).prop("checked") == true)
			{
				$('.filter_observation').each(function(){
					if($(this).val()=='Published')
					{
						$(this).prop('checked', false);
						$(this).attr('disabled', true);
					}
			  	});
			}else{
				$('.filter_observation').each(function(){

					if($(this).val()=='Published')
					{
						 $(this).removeAttr("disabled");
					}
			  	});
			}
		}

		if(val=='Published')
		{
			if($(this).prop("checked") == true)
			{
				$('.filter_observation').each(function(){
					if($(this).val()=='In Draft')
					{
							$(this).prop('checked', false);
						 $(this).attr("disabled", true);
					}
		  		});
			}else{
				$('.filter_observation').each(function(){
					if($(this).val()=='In Draft')
					{
						$(this).removeAttr("disabled");
					}
			  	});
			}
		}
		filters();
	});
	
	
	$('.filter_assessment').click(function(){
		
		var val=$(this).val();
		if(val=='Does Not Have Any Assessment')
		{
			if($(this).prop("checked") == true)
			{
				$('.filter_assessment').each(function(){
					if($(this).val()!=='Does Not Have Any Assessment')
					{
						$(this).prop('checked', false);
						$(this).attr("disabled", true);
					}
		  		});
			}else{
				$('.filter_assessment').each(function(){
					if($(this).val()!=='Does Not Have Any Assessment')
					{
						$(this).removeAttr("disabled");
					}
				});
			}
		}
		//Does Not Have Montessori
		if(val=='Does Not Have Montessori')
			{
				if($(this).prop("checked") == true)
				{
					$('.filter_assessment').each(function(){
						if($(this).val()=='Has Montessori')
						{
							$(this).prop('checked', false);
							$(this).attr("disabled", true);
						}
					});
				}else{
						$('.filter_assessment').each(function(){
						if($(this).val()=='Has Montessori')
						{
							$(this).removeAttr("disabled");
						}
					});
				}
			}
				//Does Not Have Early Years Learning Framework
		if(val=='Does Not Have Early Years Learning Framework')
			{
				if($(this).prop("checked") == true)
				{
					$('.filter_assessment').each(function(){
						if($(this).val()=='Has Early Years Learning Framework')
						{
							$(this).prop('checked', false);
							$(this).attr("disabled", true);
						}
					});
				}else{
						$('.filter_assessment').each(function(){
						if($(this).val()=='Has Early Years Learning Framework')
						{
							$(this).removeAttr("disabled");
						}
					});
				}
			}
				//Does Not Have Developmental Milestones
		if(val=='Does Not Have Developmental Milestones')
			{
				if($(this).prop("checked") == true)
				{
					$('.filter_assessment').each(function(){
						if($(this).val()=='Has Developmental Milestones')
						{
							$(this).prop('checked', false);
							$(this).attr("disabled", true);
						}
					});
				}else{
						$('.filter_assessment').each(function(){
						if($(this).val()=='Has Developmental Milestones')
						{
							$(this).removeAttr("disabled");
						}
					});
				}
			}
				//Has Montessori
		if(val=='Has Montessori')
			{
				if($(this).prop("checked") == true)
				{
					$('.filter_assessment').each(function(){
						if($(this).val()=='Does Not Have Montessori')
						{
							$(this).prop('checked', false);
							$(this).attr("disabled", true);
						}
					});
				}else{
						$('.filter_assessment').each(function(){
						if($(this).val()=='Does Not Have Montessori')
						{
							$(this).removeAttr("disabled");
						}
					});
				}
			}
				//Has Early Years Learning Framework
		if(val=='Has Early Years Learning Framework')
			{
				if($(this).prop("checked") == true)
				{
					$('.filter_assessment').each(function(){
						if($(this).val()=='Does Not Have Early Years Learning Framework')
						{
							$(this).prop('checked', false);
							$(this).attr("disabled", true);
						}
					});
				}else{
						$('.filter_assessment').each(function(){
						if($(this).val()=='Does Not Have Early Years Learning Framework')
						{
							$(this).removeAttr("disabled");
						}
					});
				}
			}
				//Has Developmental Milestones
		if(val=='Has Developmental Milestones')
		{
			if($(this).prop("checked") == true)
			{
				$('.filter_assessment').each(function(){
					if($(this).val()=='Does Not Have Developmental Milestones')
					{
						$(this).prop('checked', false);
						$(this).attr("disabled", true);
					}
				});
			}else{
					$('.filter_assessment').each(function(){
					if($(this).val()=='Does Not Have Developmental Milestones')
					{
						$(this).removeAttr("disabled");
					}
				});
			}
		}
		filters();
	});

	$('.filter_author').click(function(){
		if($(this).val()=='Any')
		{
			if($(this).prop("checked") == true){
					$('.filter_author').prop('checked', true);
				}else{
					$('.filter_author').prop('checked', false);
				}
		}
	
		filters();
	});

	$('.filter_media').click(function(){
		if($(this).val()=='Any')
		{
			if($(this).prop("checked") == true){
						$('.filter_media').prop('checked', true);
				}else{
					$('.filter_media').prop('checked', false);
				}
		}
		var len=$('.filter_media').length;
		len=len-1;
		var count=0;
		$('.filter_media').each(function(){
				if($(this).prop("checked") == true && $(this).val()!='Any'){
					count++;
				}
		});
		if(count!=len)
		{
			$('.filter_media').each(function(){
				if($(this).val()=='Any')
				{
					$(this).prop('checked', false);
				}
			});
		}else{
				$('.filter_media').each(function(){
				if($(this).val()=='Any')
				{
					$(this).prop('checked', true);
				}
			});
		}
		filters();
	});

	$('.filter_added').click(function(){
		if($(this).val()=='None')
		{
			// if($(this).prop("checked") == true){
			// 	$('.filter_added').prop('checked', true);
			// }else{
				$('.filter_added').prop('checked', false);
			// }
		}
		filters();
	});

	$('.filter_comment').click(function(){
		var val=$(this).val();
		if(val=='Any')
		{
			if($(this).prop("checked") == true)
			{
				$('.filter_comment').each(function(){
					if($(this).val()!=='Any'){
						$(this).prop('checked', false);
						$(this).attr("disabled", true);
					}
			  	});
			}else{
				$('.filter_comment').each(function(){
					if($(this).val()!=='Any')
					{
						$(this).removeAttr("disabled");
					}
				});
			}
		}

		if(val=='With Comments' || val=='With Staff Comments' || val=='With Relative Comments')
		{
			if($(this).prop("checked") == true)
			{
				$('.filter_comment').each(function(){
					if($(this).val()=='No Comments' || $(this).val()=='No Staff Comments' || $(this).val()=='No Relative Comments')
					{
						$(this).prop('checked', false);
						$(this).attr("disabled", true);
					}
				});
			}else{
					$('.filter_comment').each(function(){
					if($(this).val()=='No Comments' || $(this).val()=='No Staff Comments' || $(this).val()=='No Relative Comments')
					{
						$(this).removeAttr("disabled");
					}
				});
			}
		}
			
		if(val=='No Comments' || val=='No Staff Comments' || val=='No Relative Comments')
		{
			if($(this).prop("checked") == true)
			{
				$('.filter_comment').each(function(){
					if($(this).val()=='With Comments' || $(this).val()=='With Staff Comments' || $(this).val()=='With Relative Comments')
					{
						$(this).prop('checked', false);
						$(this).attr("disabled", true);
					}
				});
			}else{
					$('.filter_comment').each(function(){
						if($(this).val()=='With Comments' || $(this).val()=='With Staff Comments' || $(this).val()=='With Relative Comments')
					{
						$(this).removeAttr("disabled");
					}
				});
			}
		}
				
		filters();
	});

	$('.filter_link').click(function(){
		if($(this).val()=='Not Filtered'){
			if($(this).prop("checked") == true){
				$('.filter_link').each(function(){
					if($(this).val()!=='Not Filtered'){
						$(this).prop('checked', false);
						$(this).attr("disabled", true);
					}
			  	});
			}else{
				$('.filter_link').each(function(){
					if($(this).val()!=='Not Filtered'){
						$(this).removeAttr("disabled");
					}
				});
			}
		}

		if($(this).val()=='Linked to anything'){
			if($(this).prop("checked") == true){
				$('.filter_link').each(function(){
					if($(this).val()!=='Linked to anything'){
						$(this).prop('checked', false);
						$(this).attr("disabled", true);
					}
			  	});
			}else{
				$('.filter_link').each(function(){
					if($(this).val()!=='Linked to anything'){
						$(this).removeAttr("disabled");
					}
				});
			}
		}

		if($(this).val()=='Not Linked to anything'){
			if($(this).prop("checked") == true)
			{
				$('.filter_link').each(function(){
					if($(this).val()!=='Not Linked to anything')
					{
						$(this).prop('checked', false);
						$(this).attr("disabled", true);
					}
				});
			}else{
				$('.filter_link').each(function(){
					if($(this).val()!=='Not Linked to anything')
					{
						$(this).removeAttr("disabled");
					}
				});
			}
		}

		if($(this).val()=='Linked to observations')
		{
			if($(this).prop("checked") == true){
				$('.filter_link').each(function(){
					if($(this).val()!=='Linked to observations'){
						if($(this).val()!=='Linked to reflections'){
							if($(this).val()!=='Not Linked to reflections'){
								$(this).prop('checked', false);
								$(this).attr("disabled", true);
							}
						}
					}
				});
			}else{
				$('.filter_link').each(function(){
					if($(this).val()!=='Linked to observations'){
						if($(this).val()!=='Linked to reflections'){
							if($(this).val()!=='Not Linked to reflections'){
								$(this).removeAttr("disabled");
							}
						}
					}
				});
			}
		}

		if($(this).val()=='Not Linked to observations')
		{
			if($(this).prop("checked") == true)
					{
						$('.filter_link').each(function(){
						if($(this).val()!=='Not Linked to observations')
						{
								if($(this).val()!=='Linked to reflections')
						 {
								if($(this).val()!=='Not Linked to reflections')
						 {
								$(this).prop('checked', false);
							$(this).attr("disabled", true);
							}
						}
						}
			  	});
					}else{
							$('.filter_link').each(function(){
						if($(this).val()!=='Not Linked to observations')
						{
								if($(this).val()!=='Linked to reflections')
						 {
								if($(this).val()!=='Not Linked to reflections')
						 {
								$(this).removeAttr("disabled");
							}
							}
						}
						});
					}
		}

		if($(this).val()=='Linked to reflections')
		{
			if($(this).prop("checked") == true)
					{
						$('.filter_link').each(function(){
						if($(this).val()!=='Linked to reflections')
						{
								if($(this).val()!=='Linked to observations')
						 {
								if($(this).val()!=='Not Linked to observations')
						 {
								$(this).prop('checked', false);
							$(this).attr("disabled", true);
							}
						}
						}
			  	});
					}else{
							$('.filter_link').each(function(){
						if($(this).val()!=='Linked to reflections')
						{
								if($(this).val()!=='Linked to observations')
						 {
								if($(this).val()!=='Not Linked to observations')
						 {
								$(this).removeAttr("disabled");
							}
							}
						}
						});
					}
		}

		if($(this).val()=='Not Linked to reflections')
		{
			if($(this).prop("checked") == true)
					{
						$('.filter_link').each(function(){
						if($(this).val()!=='Linked to reflections')
						{
								if($(this).val()!=='Linked to observations')
						 {
								if($(this).val()!=='Not Linked to observations')
						 {
								$(this).prop('checked', false);
							$(this).attr("disabled", true);
							}
						}
						}
			  	});
					}else{
							$('.filter_link').each(function(){
						if($(this).val()!=='Not Linked to reflections')
						{
								if($(this).val()!=='Linked to observations')
						 {
								if($(this).val()!=='Not Linked to observations')
						 {
								$(this).removeAttr("disabled");
							}
							}
						}
						});
					}
		}

		filters();
	});

	$('.filter_child').click(function(){
	
		if($(this).val()=='All')
		{
			if($(this).prop("checked") == true){
				$('.filter_child').prop('checked', true);
			}else{
				$('.filter_child').prop('checked', false);
			}
		}
		
		var len=$('.filter_child').length;
		len=len-1;
		var count=0;

		$('.filter_child').each(function(){
			if($(this).prop("checked") == true && $(this).val()!='All'){
				count++;
			}
		});

		if(count!=len)
		{
			$('.filter_child').each(function(){
				if($(this).val()=='All')
				{
					$(this).prop('checked', false);
				}
			});
		}else{
			$('.filter_child').each(function(){
				if($(this).val()=='All')
				{
					$(this).prop('checked', true);
				}
			});
		}
		filters();
	});

	$(document).on('change','#centerid',function(){
		$('#obsCenters').submit();
	});
</script>