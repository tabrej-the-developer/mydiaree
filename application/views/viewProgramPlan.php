<?php 
  $data['name']='Program Plan'; 
  $this->load->view('header',$data); 
?>
<div class="container">
	<div class="pageHead">
		<h1><a href="#" onclick='history.go(-1);'  class="round"><i class="fa fa-backward" aria-hidden="true"></i> Back</a> View Programme Plan</h1>
		<div class="headerForm">

		</div>
	</div>

  <div class='row' style="overflow-x: hidden;overflow-y: auto;">
    <div class="col-sm-9 col-md-11 col-lg-12 col-xl-12" >
        <div id="grid_groups_wrapper" class="">
               
              <div id="grid_groups" class="table table-hover w-100" >             
                  <?php foreach($user_show as $get_key=>$get_user){?>
                      <div class="userList">
                        <div title="Baby Yoda" class="rounded-circle member-overlap-item" style="background: url(<?php echo base_url().'api/assets/media/'.$get_details->image->$get_user?>) 0 0 no-repeat;">
                        </div>
                        <div class='hello'><h2><?php echo $get_details->user->$get_user ?></h2></div>
                      </div>
                  <?php }  ?>
              </div>
          </div>
      </div>
  </div>

  
  <div class="viewProgrammePlanListCont">
    
    <?php 
    
    foreach($program_list->programheader as $page_key=>$page_value){
        $color=$page_value->headingcolor;
        ?>
            <div class="row" style='border-radius: 0px 0px 10px 10px;'>
                    <div class="column" style="background-color:#FFFFFF;border: 1px solid #C0CCD9;margin-left: 1%;">
                        <!--<div class='heading' style='background-color:#C8DBE5;width: 100%;height: 13%;left: 124px;top: 250px;background: #C8DBE5; '>-->
                        <div class='heading' style="background-color: <?php echo $color?>" >
                            <h2><?php echo $page_value->headingname?></h2>
                        </div>
                          
                        <?php //echo trim($page_value->perhaps)
                          //echo str_replace("<br>", "", $page_value->perhaps);
                          echo html_entity_decode($page_value->perhaps);
                        ?>
                    </div>
            </div>
            <br/>
    <?php }?>
 
</div>
                     


<!--</div>-->




<!--- Icon Click Side Child Table View --->

<div class="comment-container" id="comment">

  <div>
      <h1>Comments</h1>
      <div class='sort' style="margin-left: 90%;margin-top: -3%;">
        <label class='sort_click'>
          <span class="material-icons-outlined ">sort</span> SORT BY
        </label>
      </div>
  </div>

    <br/>
      <br/>

  <div class="container">
		<div class="col-md-12" id="fbcomment">
			<div class="body_comment">
				<div class="row">
              <div class="avatar_comment col-md-1">
                <!--<img src="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg" alt="avatar" />-->
                <?php $url=base_url().'api/assets/media/'.$loginuser_img;

                      if(!file_exists($url)){
                          $get_file= "https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg";
                        } else {
                          $get_file=base_url().'api/assets/media/'.$loginuser_img;
                        }


                
                    ?>

                <img src="<?php echo $get_file?>" alt="avatar" />
              </div>

              <div class="box_comment col-md-11">
					        <!--<textarea class="commentar" placeholder="Add a public comments..." onchange='submit_comment()'></textarea>-->
                  <textarea class="commentar" placeholder="Add a public comments..."></textarea>
                <button onclick="submit_comment()" type="button" value="1"><span class="material-icons-outlined">send</span></button>
  					    </div>
                <!--<textarea class="commentar" placeholder="Add a public comments..." onchange='submit_comment()' style='margin: -10% 3% 6% ! important;'></textarea>-->
                
				</div>

              <div class="row comments">
					        <ul id="list_comment" class="col-md-12">
						          <!-- Start List Comment 1 -->
						            <li class="box_result row">
						            </li>
					        </ul>
				      </div>
		</div>
	</div>
</div>

<!--- Icon Click Side Child Table View --->

</div>   

<?php $this->load->view('footer'); ?>

<script>

      $(document).ready(function(){
        document.getElementById("comment").style.display = "block";

        
      })
  </script>


<script>

function submit_comment(){
  var comment = $('.commentar').val();

  url="<?php $file = base_url().'api/assets/media/'.$loginuser_img;
          if(!file_exists($file)){
            echo "https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg";
          } else{
            echo $file;
          }
        ?>";
  
  el = document.createElement('li');
  el.className = "box_result row";


  /*el.innerHTML =
		'<div class=\"avatar_comment col-md-1\">'+
		  '<img src=\"https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg\" alt=\"avatar\"/>'+
		'</div>'+
		'<div class=\"result_comment col-md-11\">'+
		'<h4>Anonimous</h4>'+
		'<p>'+ comment +'</p>'+
		'</div>';*/
    el.innerHTML =
		'<div class=\"avatar_comment col-md-1\">'+
		  '<img src=\"'+url+'\" alt=\"avatar\"/>'+
		'</div>'+
		'<div class=\"result_comment col-md-11\">'+
		'<h4>Anonimous</h4>'+
		'<p>'+ comment +'</p>'+
		'</div>';
	document.getElementById('list_comment').prepend(el);
	$('.commentar').val('');

  insert_command(comment);
}


<?php foreach($program_list->comments as $comment_key=>$comment_value){
  if($comment_value->imageUrl==''){
    $url="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg";
  }else{
    $url=base_url().'api/assets/media/'.$comment_value->imageUrl;

    if(!file_exists($url)){
      $url="https://static.xx.fbcdn.net/rsrc.php/v1/yi/r/odA9sNLrE86.jpg";
    }
    
  }

  

  ?>

$(document).ready(function(){
    el = document.createElement('li');
    comment='<?php echo trim($comment_value->commenttext)?>';
    image = '<?php echo $url?>';
    name='<?php echo $comment_value->name?>';

    
    /*el.innerHTML =
		'<div class=\"avatar_comment col-md-1\" style=\"margin-left: -11%;\">'+
		  '<img src=\"'+image+'\" style=\"border-radius: 50%;margin-left: -10%;\" alt=\"avatar\"/>'+
     '<div style=\"margin-top: -12%;\"><h4>'+name+'</h4></div></div>'+
		'<div class=\"result_comment col-md-11\">'+
		'<h4>Anonimous</h4>'+
		'<p>'+comment+'</p></div>';*/
    el.innerHTML =
		'<div class=\"avatar_comment col-md-1\" >'+
		  '<img src=\"'+image+'\" alt=\"avatar\"/>'+
     '<div ><h4 >'+name+'</h4><p >'+comment+'</p></div></div>';
	document.getElementById('list_comment').prepend(el);

});    
  <?php }?>









function insert_command(get_comment){
    let id='<?php echo $program_id?>';
    $.ajax({
      url:'<?php echo base_url()?>lessonPlanList/comments',
      type:'POST',
      data:'user_comment='+get_comment+'&programplanparentid='+id,
      success:function(){
        return true;
      }
    });
}


$(document).ready(function(){
  $('.sort_click').click(function(){

    var list, i, switching, b, shouldSwitch;
  list = document.getElementById("list_comment");
  switching = true;
  
  while (switching) {
  
    switching = false;
    b = list.getElementsByTagName("LI");
  
    for (i = 0; i < (b.length - 1); i++) {
  
      shouldSwitch = false;
  
      if (b[i].innerHTML.toLowerCase() > b[i + 1].innerHTML.toLowerCase()) {
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {      
      b[i].parentNode.insertBefore(b[i + 1], b[i]);
      switching = true;
    }
  }

  });
});

  </script>

