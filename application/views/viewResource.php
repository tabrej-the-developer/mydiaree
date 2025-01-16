<?php
	$data['name']='View Resource'; 
	$this->load->view('header',$data); 
?>
 


 <div class="container ">
	<div class="pageHead">
		<h1><?php echo $data['name']; ?></h1>
		<div class="headerForm">
		</div>
	</div>
    <ul class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
        <li><a href="<?php echo base_url('Resources'); ?>">Resources Timeline</a></li>
        <li class="active"><?php echo $data['name']; ?></li>
    </ul>

    <div class="viewResourceContainer">
        <div class="resource-medias" >
            <?php 
            if(isset($Resource->media)){
                foreach($Resource->media as $key => $media){
                    if($media->mediaType == "Image") {
            ?>
            <img src="<?php echo BASE_API_URL."assets/media/".$media->mediaUrl; ?>" style="width:100%; max-height:400px!important; object-fit:cover;" alt="Image">
            <?php
                    }elseif($media->mediaType == "Video"){
            ?>
            <video width="100%" height="auto" controls>
                <source src="<?php echo BASE_API_URL."assets/media/".$media->mediaUrl; ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <?php
                    }else{
            ?>
            <div>Not a valid file!</div>
            <?php
                        }
                    }
                }
            ?>
        </div>
        <div class="rightResourceMedias">
            <div class="col-sm-12">
                <h2 class="resource-block-title"><?php echo $Resource->title; ?></h2>
                <div class="resource-info">
                <?php 
                    $date = time();
                    $post_date = strtotime($Resource->createdAt);
                    $difference = abs($date - $post_date)/3600;
                    if ($difference > 24){
                        echo date("d-m-Y",$post_date)." on ".date("H:ia",$post_date);
                    }else{
                        echo number_format($difference,0)." hours ago";
                    }
                ?>
                </div>
            </div>
            <div class="col-sm-12 resource-block-descr">
                <?php echo html_entity_decode(html_entity_decode($Resource->description));?>
            </div>
            <div class="col-sm-12 resource-action-btn-group">
                <div class="row">
                    <div class="col-sm-1 text-center">
                        <?php
                            if ($Resource->likes->liked==0) {
                        ?>
                        <div class="resource-like-block text-center do-like" data-resourceid="<?php echo $Resource->id; ?>">
                            <span class="material-icons-outlined">favorite_border</span>
                        </div>
                        <?php 
                            }else{
                        ?>
                        <div class="resource-like-block text-center do-unlike"  data-resourceid="<?php echo $Resource->id; ?>" data-likeid="<?php echo $Resource->likes->likeid; ?>">
                            <span class="material-icons-outlined">favorite</span>
                        </div>
                        <?php
                            } 
                        ?>
                        <p class="likes-count">
                            <?php 
                                if($Resource->likes->likesCount > 1){
                                    echo $Resource->likes->likesCount." Likes";
                                }elseif($Resource->likes->likesCount == 1){
                                    echo $Resource->likes->likesCount." Like";
                                }else{
                                    echo "No Likes";
                                }
                            ?>
                        </p>
                    </div>
                    <div class="col-sm-1 text-center">
                        <div class="resource-comment-block">
                            <span class="material-icons-outlined">question_answer</span>
                            Comment
                        </div>
                    </div>
                    <div class="col-sm-1 text-center">
                        <div class="resource-share-block">
                            <!-- <img src="<?php// echo base_url()."assets/images/icons/share.svg"; ?>" alt="share-btn"> -->
                            <span class="material-icons-outlined">share</span>
                            Share
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 resource-block-comments">
                <?php 
                    foreach ($Resource->comment->commentsList as $key => $comObj) {
                ?>
                <div class="comment-row">
                    <div class="commenter">
                        <?php echo $comObj->userName; ?> : 
                    </div>
                    <div class="comment">
                    <?php echo $comObj->userComment; ?>
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <?php } ?>
            </div>
            <div class="col-sm-12 resource-chat-box">
                <form class="comment-form" data-resourceid="<?php echo $Resource->id; ?>" autocomplete="off">
                    <input type="text" placeholder="Write your comment" class="add-comment" name="comment">
                    <div class="add-comment-btn">
                        <button class="post-comment-btn" type="submit">
                            <span class="material-icons-outlined">send</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<?php $this->load->view('footer'); ?>
<script>
    $(document).ready(function(){
        $(".resource-medias").slick();

        // setInterval( "alert('Hello')", 3000 );

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
						elemObj.find('.fa-heart-o').addClass('fa-heart').removeClass('fa-heart-o');
						elemObj.attr("data-likeid", ajaxObj.likeId);
						location.reload();
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
						eleObj.find('.fa-heart').addClass('fa-heart-o').removeClass('fa-heart');
						location.reload();
		
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
                            window.location.reload();
						} else {
							alert(ajaxObj.Message);
						}
						// console.log(msg);
					}
				});
			}
		});

    });
</script>