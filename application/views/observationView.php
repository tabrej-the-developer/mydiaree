<?php
	$user = $_SESSION['Name'];
	$data['name']='View Observation'; 
	$this->load->view('header',$data); 
?>
<div class="container observationListContainer">
	<div class="pageHead">
		<h1>Observation</h1>
		<div class="obsMenuTop">
			<?php  if ($observation->status != "Published" || $user == $observation->user_name) { ?>
				<a href="<?php echo base_url('observation/add?type=observation&id='.$id); ?>" class="btn btn-default btn-small btnBlue"><span class="material-icons-outlined">edit</span> Edit</i></a>
			<?php	}	?>
		</div>
	</div>	
	<ul class="breadcrumb">
		<li><a href="<?= base_url('dashboard');?>">Dashboard</a></li>
		<li><a href="<?= base_url('observation');?>">Observations List</a></li>
		<li class="active">View Observation</li>
	</ul>
	<div class="obsListBoxView">
		<h2>
			<?php echo $observation->title; ?>
			<div class="nextPrevObsList">
				<a class="prev" href="<?php echo base_url()."observation/view?id=".$nextObsId; ?>">
					<span class="material-icons-outlined">keyboard_arrow_left</span>
				</a>
				<a class="next" href="<?php echo base_url()."observation/view?id=".$prevObsId; ?>">
					<span class="material-icons-outlined">keyboard_arrow_right</span>
				</a>
			</div>
		</h2>
		<!-- <div class="obsListBoxViewOnlyStuff">This observation is only visible to staff</div> -->
		<div class="obsListBoxViewFlex">
			<div class="obsListBoxViewFlexLeft">
				<span class="obsListBoxViewFlexLeftHead">Author: <a href="<?php echo base_url('user/info&id='.$observation->userId); ?>"><?php echo $observation->user_name; ?></a></span>

				<div class="childList">
				<?php foreach($childrens as $observationChildren) { ?>
				<span >
					<img src="<?php echo base_url('/api/assets/media/'.$observationChildren->imageUrl); ?>" width="15" height="15">
					<span><?php echo $observationChildren->child_name; ?></span>
				</span>			
				<?php } ?>
				</div>

				<?php if($observation->notes) { ?>
				<span><b>Notes:</b>
					 <p><?php echo nl2br($observation->notes); ?></p>
					</span>
				<?php } ?>

				<?php if($observation->reflection) { ?>
				<span><b>Reflection:</b>
				<p><?php echo nl2br($observation->reflection); ?></p></span>
				<?php } ?>
				<ul class="nav nav-tabs border-tab">
					<li class="active">
						<a href="#Montessori" data-toggle="tab" aria-expanded="true">Montessori</a>
					</li>
					<li>
						<a href="#EYLF" data-toggle="tab" aria-expanded="true">EYLF</a>
					</li>
					<li>
						<a href="#Milestones" data-toggle="tab" aria-expanded="true">Developmental Milestones</a>
					</li>
				</ul>
				<div class="tab-content obsViewMainTab">
          <div class="tab-pane active" id="Montessori">
						<div class="form">
							<ul class="nav nav-pills bold-tab">
								<?php 
									if (isset($montessoriSubjects) && !empty($montessoriSubjects)) {
										$i = 1;
										foreach ($montessoriSubjects as $montessoriSubs => $monSubs) {
											if ($i == 1) {
												$actv = ' class="active"';
											}else{
												$actv = "";
											}
											$string = $monSubs->name;
											$s = ucfirst($string);
											$bar = ucwords(strtolower($s));
											$name = preg_replace('/\s+/', '', $bar);
								?>
								<li<?php echo $actv; ?>>
									<a href="#<?php echo $name; ?>" data-toggle="tab" aria-expanded="true"><?php echo $monSubs->name; ?></a>
								</li>
								<?php
											$i++;
										}	
									}
								?>
							</ul>
							<div class="tab-content">
								<?php 
									if (isset($montessoriSubjects) && !empty($montessoriSubjects)) {
										$i = 1;
										foreach ($montessoriSubjects as $montessoriSubs => $monSubs) {

											if ($i == 1) {
												$actv = ' class="tab-pane active"';
											}else{
												$actv = ' class="tab-pane"';
											}

											$string = $monSubs->name;
											$s = ucfirst($string);
											$bar = ucwords(strtolower($s));
											$name = preg_replace('/\s+/', '', $bar);

											foreach ($monSubs->Activity as $activity => $actvt) {
								?>
								<div <?php echo $actv; ?> id="<?php echo $name; ?>">                         
									<button type="button" class="divexpand">
										<?php echo $actvt->title; ?>                                
										<span class="pull-right">
											<span class="material-icons-outlined">expand_more</span>
											<span>&nbsp;Expand</span>
										</span>
									</button> 
									<div class="divcontent" style="display: none;">
										<?php foreach ($actvt->subActivity as $subActvts => $subAct): ?>
											<h4><?php echo $subAct->title; ?></h4>
											<p><?php echo $subAct->subject; ?></p>
										<?php endforeach ?>
									</div>
								</div>
								<?php
											}
											$i++;
										}
									}
								?>
							</div>
						</div>
					</div>
          <div class="tab-pane" id="EYLF">
						<div class="form">
							<ul class="nav nav-pills bold-tab">
								<?php 
									if (isset($outcomes) && !empty($outcomes)) {
										$i = 1;
										foreach ($outcomes as $outcomesArr => $outcomeObj) {
											if ($i == 1) {
												$actv = ' class="active"';
											}else{
												$actv = "";
											}
											$string = $outcomeObj->title;
											$s = ucfirst($string);
											$bar = ucwords(strtolower($s));
											$name = preg_replace('/\s+/', '', $bar);
								?>
								<li<?php echo $actv; ?>>
									<a href="#<?php echo $name; ?>" data-toggle="tab" aria-expanded="true"><?php echo $outcomeObj->title; ?></a>
								</li>
								<?php
											$i++;
										}	
									}
								?>
							</ul>
							<div class="tab-content">
								<?php 
									if (isset($outcomes) && !empty($outcomes)) {
										$i = 1;
										foreach ($outcomes as $outcomesArr => $outcomeObj) {

											if ($i == 1) {
												$actv = ' class="tab-pane active"';
											}else{
												$actv = ' class="tab-pane"';
											}

											$string = $outcomeObj->title;
											$s = ucfirst($string);
											$bar = ucwords(strtolower($s));
											$name = preg_replace('/\s+/', '', $bar);

											foreach ($outcomeObj->Activity as $activity => $actvt) {
								?>
								<div <?php echo $actv; ?> id="<?php echo $name; ?>">                         
									<button type="button" class="divexpand">
										<?php echo $actvt->title; ?>                                
										<span class="pull-right">
											<span class="material-icons-outlined">expand_more</span>
											<span>&nbsp;Expand</span>
										</span>
									</button> 
									<div class="divcontent" style="display: none;">
										<?php foreach ($actvt->subActivity as $subActvts => $subAct): ?>
											<p><?php echo $subAct->title; ?></p>
										<?php endforeach ?>
									</div>
								</div>
								<?php
											}
											$i++;
										}	
									}
								?>
							</div>
						</div>
					</div>
          <div class="tab-pane" id="Milestones">
						<div class="form">
							<ul class="nav nav-pills bold-tab">
								<?php 
									if (isset($devMilestone) && !empty($devMilestone)) {
										$i = 1;
										foreach ($devMilestone as $devMilestoneArr => $devMilestoneObj) {
											if ($i == 1) {
												$actv = ' class="active"';
											}else{
												$actv = "";
											}
											$string = $devMilestoneObj->ageGroup;
											$s = ucfirst($string);
											$bar = ucwords(strtolower($s));
											$name = preg_replace('/\s+/', '', $bar);
								?>
								<li<?php echo $actv; ?>>
									<a href="#<?php echo $name; ?>" data-toggle="tab" aria-expanded="true"><?php echo $devMilestoneObj->ageGroup; ?></a>
								</li>
								<?php
											$i++;
										}	
									}
								?>
							</ul>
							<div class="tab-content">
								<?php 
									if (isset($devMilestone) && !empty($devMilestone)) {
										$i = 1;
										foreach ($devMilestone as $devMilestoneArr => $devMilestoneObj) {
											if ($i == 1) {
												$actv = ' class="tab-pane active"';
											}else{
												$actv = ' class="tab-pane"';
											}
											$string = $devMilestoneObj->ageGroup;
											$s = ucfirst($string);
											$bar = ucwords(strtolower($s));
											$name = preg_replace('/\s+/', '', $bar);
											foreach ($devMilestoneObj->Main as $main => $mainObj) {
								?>
								<div <?php echo $actv; ?> id="<?php echo $name; ?>">                         
									<button type="button" class="divexpand">
										<?php echo $mainObj->name; ?>                                
										<span class="pull-right">
											<span class="material-icons-outlined">expand_more</span>
											<span>&nbsp;Expand</span>
										</span>
									</button> 
									<div class="divcontent" style="display: none;">
										<?php foreach ($mainObj->Subjects as $subjects => $subject): ?>
											<div class="text">
												<h4><?php echo $subject->name; ?></h4>
												<p><?php echo $subject->subject; ?></p>
												<ul>
												<?php 
													if(isset($subject->extras) && !empty($subject->extras)){
														foreach ($subject->extras as $extras => $xtra) { 
												?>
													<li><?php echo $xtra->title; ?></li>		
												<?php 
														}
													}else{
														echo "Not available!";
													}
												?>
												</ul>
											</div>
										<?php endforeach ?>
									</div>
								</div>
								<?php
											}
										}	
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<form action="" id="form-comment" method="post">
					<div class="form-group">
						<label for="comment">Comment</label>
						<textarea class="form-control" name="comment" id="comment" data-sample-short></textarea>
					</div>
					<div class="form-group">
						<button type="button" onclick="commentobs();"class="btn btn-info btn-default btn-small btnBlue pull-right">Submit</button>
					</div>
				</form>
				<div class="commentSection">
					<?php 
					if(!empty($Comments)) { 
						foreach($Comments as $comment) { 
					?>
					<blockquote class="commentList">
						<span><img src="https://via.placeholder.com/50"><?php echo $comment->userName; ?> : </span>
						<?php echo $comment->comments; ?>
						<span class="commentTiming">10:30 am</span>
					</blockquote>
					<?php } } ?>
				</div>
			</div>
			<div class="obsListBoxViewFlexRight">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<?php 
							$i = 1;
							foreach($Media as $media) { 
								if($media->mediaType=='Image') {
						?>
						<div class="item <?php if($i==1){ echo "active"; } ?>">
							<img class="mainImg" src="<?php echo base_url('/api/assets/media/'.$media->mediaUrl); ?>">
							<div class="tags-section">
								<div class="child-tags">
									<?php foreach ($media->childs as $key => $ch) { 
										if (file_exists(base_url('/api/assets/media/'.$ch->imageUrl))) {
									?>
										<span class="childSpan">
											<img src="<?php echo base_url('/api/assets/media/'.$ch->imageUrl); ?>" width="15" height="15">
											<span style="color: #3E695A;"><?php echo $ch->name; ?></span>
										</span>
									<?php
										} else {
									?>
									<span class="childSpan">
											<img src="https://via.placeholder.com/50">
											<!-- <img src="<?php  //echo base_url('assets/images/user-alt-512.webp'); ?>" width="15" height="15"> -->
											<span style="color: #3E695A;"><?php echo $ch->name; ?></span>
										</span>
									<?php
										}
										
									} ?>
									<?php foreach ($media->educators as $key => $ch) {
										if (file_exists(base_url('/api/assets/media/'.$ch->imageUrl))) {
									?>
									<span class="childSpan">
											<img src="<?php echo base_url('/api/assets/media/'.$ch->imageUrl); ?>" width="15" height="15">
											<span style="color: #6E519D;"><?php echo $ch->name; ?></span>
										</span>
									<?php
										} else {
									?>
									<span class="childSpan">
											<img src="https://via.placeholder.com/50">
											<!-- <img src="<?php// echo base_url('assets/images/user-alt-512.webp'); ?>" width="15" height="15"> -->
											<span style="color: #6E519D;"><?php echo $ch->name; ?></span>
										</span>
									<?php
										}
									} ?>
								</div>
								<div class="caption">
								<?php echo $media->caption; ?>
								</div>
							</div>
						</div>
						<?php
								} elseif($media->mediaType=='Video') {
						?>
						<div class="item <?php if($i==1){ echo "active"; } ?>">
							<video style="width:100%" controls>
								<source src="<?php echo base_url('/api/assets/media/'.$media->mediaUrl); ?>" >
							</video>
							<div class="tags-section">
								<div class="child-tags">
									<?php foreach ($media->childs as $key => $ch) { 
										if (file_exists(base_url('/api/assets/media/'.$ch->imageUrl))) {
									?>
										<span>
											<img src="<?php echo base_url('/api/assets/media/'.$ch->imageUrl); ?>" width="15" height="15">
											<span style="color: #3E695A;"><?php echo $ch->name; ?></span>
										</span>
									<?php
										} else {
									?>
										<span>
											<img src="<?php echo base_url('assets/images/user-alt-512.webp'); ?>" width="15" height="15">
											<span style="color: #3E695A;"><?php echo $ch->name; ?></span>
										</span>
									<?php
										}
										
									} ?>
									<?php foreach ($media->educators as $key => $ch) {
										if (file_exists(base_url('/api/assets/media/'.$ch->imageUrl))) {
									?>
										<span>
											<img src="<?php echo base_url('/api/assets/media/'.$ch->imageUrl); ?>" width="15" height="15">
											<span style="color: #3E695A;"><?php echo $ch->name; ?></span>
										</span>
									<?php
										} else {
									?>
										<span>
											<img src="<?php echo base_url('assets/images/user-alt-512.webp'); ?>" width="15" height="15">
											<span style="color: #3E695A;"><?php echo $ch->name; ?></span>
										</span>
									<?php
										}
									} ?>
								</div>
								<div class="caption">
								<?php echo $media->caption; ?>
								</div>
							</div>
						</div>
						<?php
								}
								$i++;
							}
						?>
					</div>

					<!-- Controls -->
					<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"><span class="material-icons-outlined">keyboard_arrow_left</span></a>
					<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"><span class="material-icons-outlined">keyboard_arrow_right</span><span class="sr-only">Next</span></a>
				</div>
				<div class="thumbMedia">
					<?php 
						$k = 0;
						$countMedia = count($Media);
						if ($countMedia > 1) {
						
							foreach($Media as $media) { 
								if($media->mediaType=='Image') {
					?>
					<a href="#!" data-target="#carousel-example-generic" data-slide-to="<?php echo $k; ?>">
						<img src="<?php echo base_url('/api/assets/media/'.$media->mediaUrl); ?>" width="150" height="150">
					</a>
					<?php
								} elseif($media->mediaType=='Video') {
					?>
					<a href="#!" data-target="#carousel-example-generic" data-slide-to="<?php echo $k; ?>">
						<video style="width:150px;width: 150px;">
							<source src="<?php echo base_url('/api/assets/media/'.$media->mediaUrl); ?>" >
						</video>
					</a>
					<?php
								}
								$k++;
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal" id="tagsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        	<span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">View Tag Details</h4>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>
<?php $this->load->view('footer'); ?>
<script>
	$('#tagsModal').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget);
	  var type = button.data('type');
	  var tagid = button.data('tagid');
	  var modal = $(this);
	  $.ajax({
	  	url: '<?= base_url("Observation/getActTagInfo"); ?>',
	  	type: 'GET',
	  	data: {'type': type,'tagid':tagid},
	  })
	  .done(function(json) {
	  	res = jQuery.parseJSON(json);
	  	if(res.Status == "SUCCESS"){

	  		if (res.Tag.imageUrl == "") {
	  			var _imageurl = "https://via.placeholder.com/350x260/FFFF00/000000?text=Image+not+found";
	  		}else{
	  			var _imageurl = "<?= base_url('api/assets/media/'); ?>"+res.Tag.imageUrl;
	  		}

	  		if(res.Tag.extras.length > 0){
	  			var _extras = `<ul>`;
	  			$.each(res.Tag.extras, function(index, val) {
	  				_extras += `<li>`+val.title+`</li>`
	  			});
	  			_extras += `</ul>`;
	  		}else{
	  			var _extras = `<p>No extension available for this Subactivity.</p>`;
	  		}
	  		modal.find('.modal-body').append(`
	  			<div class="main-block">
	      		<div class="main-block-details">
		      		<div class="main-img">
		      			<img src="`+_imageurl+`" class="img-fluid" alt="">
		      		</div>
		      		<div class="main-info">
		      			<h3>`+res.Tag.title+`</h3>
		      			<p>`+res.Tag.subject+`</p>
		      		</div>
	      		</div>
	      		<div class="main-block-extras">
	      			<h4>Extras</h4>
	      			<div class="extras-block">
	      				`
	      				+_extras+
	      				`
	      			</div>
	      		</div>	
	      	</div>
	  		`);
	  	}else{
	  		alert(res.Message);
	  	}
	  });
	});
	var users = <?php echo $getStaffChild; ?>;
	CKEDITOR.replace('comment', {
    	plugins: 'mentions,basicstyles,undo,link,wysiwygarea,toolbar,format,list',
    	contentsCss: [
      	'http://cdn.ckeditor.com/4.16.2/full-all/contents.css',
      	'https://ckeditor.com/docs/ckeditor4/4.16.2/examples/assets/mentions/contents.css'
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
        	items: ['Link', 'Unlink', 'NumberedList', 'BulletedList']
      }],
      mentions: [{  
     	feed: dataFeed,
      		itemTemplate: '<li data-id="{id}">' +
        		'<strong class="username">{name}</strong>' +
        		'</li>',
      		outputTemplate: '<a href="#">{name}</a><span>&nbsp;</span>',
      		minChars: 0
    	}]
   	});

    function dataFeed(opts, callback) {
      var matchProperty = 'name',
        data = users.filter(function(item) {
          return item[matchProperty].indexOf(opts.query.toLowerCase()) == 0;
        });

      data = data.sort(function(a, b) {
        return a[matchProperty].localeCompare(b[matchProperty], undefined, {
          sensitivity: 'accent'
        });
      });

      callback(data);
    }

    function tagsFeed(opts, callback) {
      var matchProperty = 'title',
      data = tags.filter(function(item) {
         return item[matchProperty].indexOf(opts.query.toLowerCase()) == 0;
      });

      data = data.sort(function(a, b) {
         return a[matchProperty].localeCompare(b[matchProperty], undefined, {
            sensitivity: 'accent'
         });
      });

      callback(data);
    }
</script>
<script>
	$(document).ready(function(){
		$("#carousel-example-generic").carousel();
	});

	var id="<?php echo $id; ?>"; 
	function commentobs()
	{
		if(CKEDITOR.instances.comment.getData()=='')
		{
			alert('Please Enter Comments');
			return false;
		}
		var url="<?php echo base_url('observation/comment'); ?>?id="+id;
		var test= url.replace(/&amp;/g, '&');
		document.getElementById("form-comment").action =test;
		document.getElementById("form-comment").submit();
	}
</script>