<?php 

	$data['name']='Resources'; 
	$this->load->view('header',$data); 
?>
<div class="container ">
	<div class="pageHead">
		<h1>Resources</h1>
		<div class="headerForm">
			<button class="btn btn-default btn-small pull-right btnResFilter"><span class="material-icons-outlined">filter_alt</span></button>
			<a href="<?php echo base_url('resources/add'); ?>" class="btn btn-info btn-default btn-small btnBlue pull-right">
				<span class="material-icons-outlined">add</span> Add Resource
			</a>
		</div>
	</div>

	<div class="flexResourcesTagsList">
	<?php 
		if (!empty($trendingTags)) {
			foreach ($trendingTags as $trendingtags => $trending) {
	?>
	<div class="flexResourcesTags">
		<button class="loadTag" data-tag="<?php echo $trending->tags; ?>">
			<?php echo $trending->tags; ?>
		</button>
	</div>
	<?php
			}
		}
	?>
	</div>

	<div class="resourceListView">		
		<div class="flexResourceListView" id="flexResourceListView">
			<?php
				$i = 1;
				if(!empty($resources)){
					foreach ($resources as $key => $res) {
			?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a href="<?php echo base_url('resources/viewResource')."?resId=".$res->id; ?>" class="panel-res-title"><?php echo $res->title;?></a>
						<?php
							if($res->createdBy == $this->session->userdata("Name")){
						?>
						<span class="pull-right">
							<a role="menuitem" onclick="return confirm('Are you sure?');" tabindex="-1" href="<?php echo base_url('resources/deleteResource/').$res->id; ?>">Delete</a>
						</span>
						<?php } ?>
					</div>
					<div class="panel-body">
						<?php 
							if (empty($res->media)) {
						?>
							<div class="multi-media-slide">
								<img src="https://via.placeholder.com/1366x320.png?text=No+Media+Available" class="img-responsive" alt="No Media Available">
							</div>
						<?php
							} else {
						?>
							<div class="multi-media-slide">
								<?php
									foreach ($res->media as $medias => $medobj) {
										if ($medobj->mediaType == "Image") {
								?>
									<img src="<?php echo BASE_API_URL."assets/media/".$medobj->mediaUrl; ?>" class="img-responsive" alt="<?php echo $medobj->mediaUrl; ?>">
								<?php
										} else {
								?>
									<video width="100%" height="345px" controls>
										<source src="<?php echo BASE_API_URL."assets/media/".$medobj->mediaUrl; ?>" type="video/mp4">
										Your browser does not support the video tag.
									</video>
								<?php
										}
									}
								?>
							</div>
						<?php
							}
							
						?>
						<div class="resource-details-block">
							<div class="resource-time">
								<?php 
									$date = time();
									$post_date = strtotime($res->createdAt);
									$difference = abs($date - $post_date)/3600;
									if ($difference>24){
										echo date("d-m-Y",$post_date)." on ".date("H:ia",$post_date);
									}else{
										echo number_format($difference,0)." hours ago";
									}
								?>
							</div>
							<div><?php echo html_entity_decode($res->description); ?></div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="panel-footer-icons">
							<div class="action-btn-group">
								<?php
									if ($res->likes->liked==0) {
								?>
								<div class="like-btn text-center do-like" data-resourceid="<?php echo $res->id; ?>">
									<span class="material-icons-outlined favorite_border">favorite_border</span>
								</div>
								<?php 
									}else{
								?>
								<div class="like-btn text-center do-unlike"  data-resourceid="<?php echo $res->id; ?>" data-likeid="<?php echo $res->likes->likeid; ?>">
									<span class="material-icons-outlined favorite_fill">favorite</span>
								</div>
								<?php
									} 
								?>
								<div class="comment-btn text-center">
									<span class="material-icons-outlined">question_answer</span>
								</div>
								<!-- <div class="share-btn text-center">
									<img src="<?php #echo base_url()."assets/images/icons/share.svg"; ?>" alt="share-btn">
								</div> -->
							</div>
							<div class="social-share-group">
								<div class="facebook-icon share-resource-btn" data-sharetype="facebook" data-resourceid="<?php echo $res->id; ?>">
									<img src="<?php echo base_url()."assets/images/icons/facebook.svg"; ?>" alt="fb-btn">
								</div>
								<!-- <div class="twitter-icon share-resource-btn" data-sharetype="twitter" data-resourceid="<?php #echo $res->id; ?>">
									<img src="<?php #echo base_url()."assets/images/icons/twitter.svg"; ?>" alt="tw-btn">
								</div> -->
								<div class="whatsapp-icon share-resource-btn" data-sharetype="whatsapp" data-resourceid="<?php echo $res->id; ?>">
									<img src="<?php echo base_url()."assets/images/icons/whatsapp.svg"; ?>" alt="wa-btn">
								</div>
							</div>
						</div>
						<div class="status">
						<?php 
							if($res->likes->likesCount==1)
							{ 
								echo '<p class="likes-count">';
								echo  $res->likes->likesCount." Like";
								echo '</p>';
							}elseif($res->likes->likesCount>1){
								echo '<p class="likes-count">';
								echo  $res->likes->likesCount." Likes";
								echo '</p>';
							}else{

							}
						?>
						</div>
						<?php if ($res->comments->userCommented!=NULL) { ?>
						<div class="last-comment"><strong><?php echo $res->comments->userCommented.": "; ?></strong><?php echo $res->comments->lastComment; ?>
							<span><a href="<?php echo base_url('resources/viewResource')."?resId=".$res->id; ?>">View all <?php echo $res->comments->totalComments; ?> Comments</a></span>
						</div>
						<?php }else{
							echo "<div class='mesCont'>Be the first one to comment!</div>";
						} ?>
						<form class="comment-form" data-resourceid="<?php echo $res->id; ?>" autocomplete="off">
							<div class="line">
								<input type="text" placeholder="Write your comment" class="add-comment" name="comment" id='<?php echo "comment_box_".$i; ?>'>
								<div class="add-comment-btn">
									<button class="post-comment-btn" type="submit">
										<span class="material-icons-outlined">send</span>
									</button>
								</div>	
								<div style="clear:both;"></div>											
							</div>
						</form>
					</div>
				</div>
			<?php   	
						$i++;
					}
				}else{
			?>
			<h1>No results found!</h1>
			<?php
				}
			?>
		</div>
		<!-- Filter section -->
		<div class="filter-section">
			<div class="panel panel-default">
				<div class="panel-heading">
					Apply Filters
				</div>
				<div class="panel-body">
					<form action="" method="get" autocomplete="off">
						<div class="sub-panel-section">
							<div class="sub-panel-title">
								<strong>Show Resources</strong>
							</div>
							<div class="form-group">
								<input type="text" class="form-control datepickcal" name="fromdate" placeholder="Choose Fromdate">
							</div>
							<div class="form-group">
								<input type="text" class="form-control datepickcal" name="todate" placeholder="Choose Todate">
							</div>
						</div>
						<div class="sub-panel-section">
							<div class="sub-panel-title">
								<strong>Select Center</strong>
							</div>
							<div class="form-group">
								<select name="centerid" id="centerid" class="form-control">
									<option value="">Choose center</option>
									<?php 
										$dupArr = [];
										$centersList = $this->session->userdata("centerIds");
										if (empty($centersList)) {
									?>
									<option value="">-- No centers available --</option>
									<?php
										}else{
											foreach($centersList as $key => $center){
									?>
									<option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
									<?php   } } ?>
								</select>
							</div>
						</div>
						<div class="sub-panel-section">
							<div class="sub-panel-title">
								<strong>Select Author</strong>
							</div>
							<div class="form-group">
								<select name="author" id="author" class="form-control">
									<option value="">Choose an Author</option>
								</select>
							</div>
						</div>
						<div class="sub-panel-section text-center">
							<button type="submit" id="apply-filter" class="btn btn-default btn-small pull-right btnBlue">Apply</button>
						</div>
					</form>
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

	$(document).ready(function(){

		$('.datepickcal').datepicker();

		$('.multi-media-slide').slick({
			arrows: false,
			dots: false
		});

		//ajax for tags filter
		let tag = [];

		$(document).on("click",".loadTag",function(){
			count = 1;
			let newTag = $(this).data("tag");
			
			//stop duplicate entries upon clicking on tags
			if (findValueInArray(newTag,tag)) {
				//left empty for required scene
			}else{
				tag.push(newTag);
				//$(this).css("border","1px solid royalblue");
			}

			$.ajax({
				url: '<?php echo base_url("Resources/loadAjaxResources"); ?>',
				type: 'POST',
				data: {"tags": JSON.stringify(tag)},
			})
			.done(function(msg) {
				res = JSON.parse(msg);
				$("#flexResourceListView").empty();
				if(res.Resources.length>0){
					$.each(res.Resources, function(index, val) {
						/* iterate through media array or object */
						mediaCount = val.media.length;
						if (mediaCount > 0) {
							$.each(val.media, function(mediaIndex, mediaVal) {
								/* iterate through array or object */
								if(mediaVal.mediaType=="Image"){
									media = `<img src="<?php echo BASE_API_URL."assets/media/"; ?>`+mediaVal.mediaUrl+`" class="img-responsive" alt="`+mediaVal.mediaUrl+`">`;
								}else if(mediaVal.mediaType=="Video"){
									media = `
									<video width="100%" height="345px" controls>
										<source src="<?php echo BASE_API_URL."assets/media/"; ?>`+mediaVal.mediaUrl+`" type="video/mp4">
										Your browser does not support the video tag.
									</video>
									`;
								}else{
									media = `<img src='https://via.placeholder.com/1366x420.png?text=Invalid+Media+File' class='img-responsive' alt='Invalid media file'>`;
								}
							});
						}else{
							media = `<img src='https://via.placeholder.com/1366x420.png?text=No+Media+Available' class='img-responsive' alt='No Media Available'>`;
						}
						//for delete button
						userLogged = '<?php echo $this->session->userdata("LoginId"); ?>';
						if(val.createdBy == userLogged){
							deleteItem = `
								<span class="pull-right">
									<li class="dropdown" style="list-style: none;">
										<a class="dropdown-toggle text-center" data-toggle="dropdown" href="#">
											<i class="fa fa-ellipsis-h"></i>
										</a>
										<ul class="dropdown-menu">
											<li role="presentation">
												<a role="menuitem" tabindex="-1" href="<?php echo base_url('resources/deleteResource/'); ?>`+val.id+`">Delete</a>
											</li>
										</ul>
									</li>
								</span>
							`;
						}else{
							deleteItem = ``;
						}
						/* for description */
						resDesc = $("<div></div>").html(val.description).text(); 
						/* check liked or not */
						if(val.likes.liked==0){
							resLike = `
								<div class="like-btn text-center do-like" data-resourceid="`+val.id+`">
									<span class="material-icons-outlined favorite_border">favorite_border</span>
								</div>
							`;
						}else{
							resLike = `
								<div class="like-btn text-center do-unlike" data-resourceid="`+val.id+`" data-likeid="`+ val.likes.likeid +`">
									<span class="material-icons-outlined favorite_border">favorite_border</span>
								</div>
							`;
						}
						/* likes count */
						if(val.likes.likesCount==1)
						{ 
							resLikesCount = `<p class="likes-count">`+val.likes.likesCount+`Like </p>`;
						}else if(val.likes.likesCount>1){
							resLikesCount = `<p class="likes-count">`+val.likes.likesCount+`Likes </p>`;
						}else{
							resLikesCount = ``;
						}
						/* comments check */
						if (val.comments.userCommented==null) {
							resComment = `<div class='mesCont'>Be the first one to comment!</div>`;
						}else{
							resComment = `
								<div class="last-comment">
								<strong>`+val.comments.userCommented+`:</strong>
								`+ val.comments.lastComment +`
									<span>
										<a href="<?php echo base_url('resources/viewResource')."?resId="; ?>`+val.id+`">
											View all `+val.comments.totalComments+` Comments
										</a>
									</span>
								</div>
							`;
						}
						records = `
							<div class="panel panel-default">
								<div class="panel-heading">
									<a href="<?php echo base_url('resources/viewResource')."?resId="; ?>`+val.id+`" class="panel-res-title">
									`+ val.title +`
									</a>
									`+deleteItem+`
								</div>
								<div class="panel-body">
									<div class="multi-media-slide">
									`+media+`
									</div>
									<div class="resource-details-block">
										`+resDesc+`
									</div>
								</div>
								<div class="panel-footer">
									<div class="panel-footer-icons">
										<div class="action-btn-group">
										`+resLike+`
											<div class="comment-btn text-center">
												<span class="material-icons-outlined">question_answer</span>
											</div>
										</div>
										<div class="social-share-group">
											<div class="facebook-icon share-resource-btn" data-sharetype="facebook" data-resourceid="">
												<img src="<?php echo base_url()."assets/images/icons/facebook.svg"; ?>" alt="fb-btn">
											</div>
											<div class="whatsapp-icon share-resource-btn" data-sharetype="whatsapp" data-resourceid="">
												<img src="<?php echo base_url()."assets/images/icons/whatsapp.svg"; ?>" alt="wa-btn">
											</div>
										</div>
									</div>
									<div class="status">
										`+resLikesCount+`
									</div>
									`+resComment+`
									<form class="comment-form" data-resourceid="`+val.id+`" autocomplete="off">
										<div class="line">
											<input type="text" placeholder="Write your comment" class="add-comment" name="comment" id='comment_box_`+count+`'>
											<div class="add-comment-btn">
												<button class="post-comment-btn" type="submit">
													<span class="material-icons-outlined">send</span>
												</button>
											</div>	
											<div style="clear:both;"></div>											
										</div>
									</form>
								</div>

							</div>
						`;
						count = count + 1;
						$("#flexResourceListView").append(records);
					});
				}else{
					$("#flexResourceListView").append("<h1>No resources found!</h1>");
				}
				//Reinitialize ckeditor
				var users = <?php echo $users; ?>,tags = <?php echo $tags; ?>;
		        $('.add-comment').each(function(e){
		            let commentid  = $(this).prop("id");
		            // CKEDITOR.instances.commentid.destroy();
		            CKEDITOR.replace( commentid , {
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
					    extraAllowedContent: '*[*]{*}(*)',
		                mentions: [{  
		                    feed: dataFeed,
			                    itemTemplate: '<li data-id="{id}">' +
			                       '<strong class="username">{name}</strong>' +
			                       '</li>',
			                    outputTemplate: '<a href="user_{id}">{name}</a>',
			                    minChars: 0
			                },
		                 	{
			                    feed: tagsFeed,
			                    marker: '#',
			                    itemTemplate: '<li data-id="{id}"><strong>{title}</strong></li>',
			                    outputTemplate: '<a href="#tags_{rid}" data-tagid="{rid}" data-type="{type}" data-toggle="modal" data-target="#tagsModal">#{title}</a>',
			                    minChars: 0
		                 	}
		                ]
		            });
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
			});
		});
		
		

		$(document).on('click','.do-like',function(){
			var elemObj = $(this);
			var resId = $(this).data('resourceid');
			var userid = <?php echo $this->session->userdata("LoginId"); ?>;
			//Perform Ajax
			$.ajax({
				traditional:true,
				type: "POST",
				url: "<?php echo base_url().'resources/addLike'; ?>",
				beforeSend: function(request) {
				request.setRequestHeader("x-device-id", "<?php echo $this->session->userdata('x-device-id');?>");
				request.setRequestHeader("x-token", "<?php echo $this->session->userdata('AuthToken');?>");
				},
				data: {"userid":userid,'resourceId':resId},
				success: function(msg){
				// console.log(msg);
					var ajaxObj = jQuery.parseJSON(msg);
					// console.log(ajaxObj.Message);
					if (ajaxObj.Message=="Liked") {
						elemObj.addClass("do-unlike").removeClass("do-like");
						//elemObj.find('.favorite_border').addClass('favorite_fill').removeClass('favorite_border');
						elemObj.find('.favorite_border').html('favorite_fill');
						elemObj.find('.favorite_border').addClass('favorite_fill').removeClass('favorite_border');
						elemObj.attr("data-likeid", ajaxObj.likeId);
					} else {
						alert(ajaxObj.Message);
					}
				}
			});
		});

		$(document).on('click','.do-unlike',function(){
			var eleObj = $(this);
			var likeid = $(this).data('likeid');
			var userid = <?php echo $this->session->userdata("LoginId"); ?>;
			//Perform Ajax
			$.ajax({
				traditional:true,
				type: "POST",
				url: "<?php echo base_url().'resources/removeLike'; ?>",
				beforeSend: function(request) {
				request.setRequestHeader("x-device-id", "<?php echo $this->session->userdata('x-device-id');?>");
				request.setRequestHeader("x-token", "<?php echo $this->session->userdata('AuthToken');?>");
				},
				data: {"userid":userid,'likeId':likeid},
				success: function(msg){
					var ajaxObj = jQuery.parseJSON(msg);
					if (ajaxObj.Message=="Disliked") {
						eleObj.addClass("do-like").removeClass("do-unlike");
						//eleObj.find('.favorite_fill').addClass('favorite_border').removeClass('favorite_fill');
						eleObj.find('.favorite_fill').html('favorite_border');
						eleObj.find('.favorite_fill').addClass('favorite_border').removeClass('favorite_fill');
					} else {
						alert(ajaxObj.Message);
					}
				}
			});
		});

		$(document).on('submit',".comment-form",function(e){
			e.preventDefault();
			var eleFormObj = $(this);
			var comment = $(this).find(".add-comment").val();
			var resId = $(this).data("resourceid");
			var userid = <?php echo $this->session->userdata("LoginId"); ?>;
			if (comment=="") {
				eleFormObj.find("input").attr("placeholder","Please enter your comment.").css("border-bottom", "1px solid #FF0000");
			} else {
				$.ajax({
					traditional:true,
					type: "POST",
					url: "<?php echo base_url().'resources/addComment'; ?>",
					beforeSend: function(request) {
					request.setRequestHeader("x-device-id", "<?php echo $this->session->userdata('x-device-id');?>");
					request.setRequestHeader("x-token", "<?php echo $this->session->userdata('AuthToken');?>");
					},
					data: {"userid":userid,'comment':comment,'resourceId':resId},
					success: function(msg){
						var ajaxObj = jQuery.parseJSON(msg);
						if (ajaxObj.Status=="SUCCESS") {
							eleFormObj.trigger("reset");
						} else {
							alert(ajaxObj.Message);
						}
						// console.log(msg);
					}
				});
			}
		});

		$(document).on('click',".share-resource-btn", function(){
			var shareType = $(this).data("sharetype");
			var resId = $(this).data("resourceid");
			var userid = <?php echo $this->session->userdata("LoginId"); ?>;
			$.ajax({
				traditional:true,
				type: "POST",
				url: "<?php echo base_url().'resources/addShare'; ?>",
				beforeSend: function(request) {
				request.setRequestHeader("x-device-id", "<?php echo $this->session->userdata('x-device-id');?>");
				request.setRequestHeader("x-token", "<?php echo $this->session->userdata('AuthToken');?>");
				},
				data: {"userid":userid,'shareType':shareType,'resourceId':resId},
				success: function(msg){
					// var ajaxObj = jQuery.parseJSON(msg);
					// if (ajaxObj.Status=="SUCCESS") {
					// 	eleFormObj.trigger("reset");
					// } else {
					// 	alert(ajaxObj.Message);
					// }
					console.log(msg);
				}
			});
		});

		//clicking on filter button
		$(document).on("click",".btnResFilter",function(){
			$(".filter-section").toggle();
			$(".flexResourceListView").toggleClass("active");
		});

		$(document).on("click","#apply-filter",function(){
			let todate = $("#todate").val();
			let fromdate = $("#fromdate").val();
			let center = $("#center").val();
			let author = $("#author").val();
			let url = '<?php echo base_url("Resources/filterResources"); ?>';
			$.ajax({
				url: url,
				type: 'post',
				data: {"fromdate": fromdate,"todate": todate,"center": center,"author":author},
			})
			.done(function() {
				console.log("success");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				// console.log("complete");
				$(".resourceListView").empty();
			});
		});
	});

	$(document).on("change","#centerid",function(){
		let centerid = $(this).val();
		$.ajax({
			url: '<?php echo base_url("Resources/getAuthorsFromCenter"); ?>',
			type: 'POST',
			data: {'centerid': centerid},
		})
		.done(function(msg) {
			res = jQuery.parseJSON(msg);
			if(res.Status == "SUCCESS"){
				$("#author").empty();
				$("#author").append('<option value="">Choose an Author</option>');
				$(res.Authors).each(function(index,obj){
					$("#author").append('<option value="'+obj.id+'">'+obj.name+'</option>');
				});
			}else{
				$("#author").empty();
				$("#author").append('<option value="">No Authors Available</option>');
			}
		});	
	});

	

	function findValueInArray(value,arr){
	  var result = false;
	 
	  for(var i=0; i<arr.length; i++){
	    var name = arr[i];
	    if(name == value){
	      result = true;
	      break;
	    }
	  }

	  return result;
	}

	function updateTagsCss() {
		// $.each(tag, function(index, val) {
		// 	console.log();
		// });
	}

</script>
<script>
    $(document).ready(function(){
        var users = <?php echo $users; ?>,tags = <?php echo $tags; ?>;
        $('.add-comment').each(function(e){
            let cid  = $(this).prop("id");            
            CKEDITOR.replace( cid , {
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
			    extraAllowedContent: '*[*]{*}(*)',
                mentions: [{  
                    feed: dataFeed,
	                    itemTemplate: '<li data-id="{id}">' +
	                       '<strong class="username">{name}</strong>' +
	                       '</li>',
	                    outputTemplate: '<a href="user_{id}">{name}</a>',
	                    minChars: 0
	                },
                 	{
	                    feed: tagsFeed,
	                    marker: '#',
	                    itemTemplate: '<li data-id="{id}"><strong>{title}</strong></li>',
	                    outputTemplate: '<a href="#tags_{rid}" data-tagid="{rid}" data-type="{type}" data-toggle="modal" data-target="#tagsModal">#{title}</a>',
	                    minChars: 0
                 	}
                ]
            });
            // CKEDITOR.instances.cid.destroy();            
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
    });
</script>