<?php
	$data['name']='View Survey';
	$this->load->view('header',$data);
	$surveys = $records['Surveys'];
	$survey = $surveys['survey'][0];
	$surveyQstn = $surveys['surveyQuestion'];
	$surveyQstnMedia = $surveys['surveyQuestionMedia'];
	$surveyQstnOption = $surveys['surveyQuestionOption'];
?>


<div class="container ">
	<div class="pageHead">
		<h1>Respond Survey</h1>
		<div class="headerForm">
		</div>
	</div>
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
		<li><a href="<?php echo base_url('surveys'); ?>">Surveys List</a></li>
		<li class="active">Respond Survey</li>
	</ul>
	<div class="getSurveyQues"><?php echo $survey['title']; ?>
		<span style="font-size:12px; color:#ddd;"><?php echo $survey['description']; ?></span>
	</div>

	<p class="author">By: <a href="#"><?php echo $survey['createdBy']; ?></a> On: <?php echo date('d-m-Y h:i:s',strtotime($survey['createdAt'])); ?></p>
	
	<?php if ($records['Responsed']== 1) { ?>
 	<div class="form-group successMessgae text-center text-success">
		<h3>You have successfully submitted your response.</h3>
	</div>
 	<?php } ?>

	 <form action="<?php echo base_url('surveys/exeSurveyRespond'); ?>" method="post">
		<div class="bsCalloutView">
	<?php
	 	$i = 1;
 		foreach ($surveyQstn as $qstn) {
 	?>
	 	<div class="row">
	 		<div class="col-md-12">
	 			<div class="question-text bold">
	 				<?php
	 					if ($qstn['isMandatory']==0) {
	 						echo $i.". ". $qstn['questionText'];
	 					}else {
	 						echo $i.". ". $qstn['questionText'] ."<sup class='text-danger'>*</sup>";
	 					}
	 				?>
	 				<input type="hidden" value="<?php echo $qstn['id']; ?>" name="questionId_<?php echo $qstn['id']; ?>">
	 				<input type="hidden" value="<?php echo $survey['id']; ?>" name="surveyid">
	 			</div>

	 			<div class="row">
	 				<div class="col-sm-8">
	 					<?php
			 			if ($qstn['questionType']=="RADIO") {

			 				foreach ($surveyQstnOption as $option) {
			 					echo "<div class='form-group' style='padding:0px 15px;'>";
			 					foreach ($option as $opt) {
			 						if ($opt['qid'] == $qstn['id']) {
			 			?>
			 				<div class="labelGroup"><input type="radio" name="<?php echo "question_".$qstn['id']; ?>[]" value="<?php echo $opt['id']; ?>" id="<?php echo "option".$opt['id']; ?>" <?php if ($qstn['isMandatory']!=0) { echo "required"; }?>>&nbsp;&nbsp;&nbsp;<label for="<?php echo "option".$opt['id']; ?>"><?php echo $opt['optionText']; ?></label></div>
			 				<br>
			 			<?php
			 						}
			 					}
			 				echo "</div>";

			 				}
			 			}else if ($qstn['questionType']=="CHECKBOX") {

			 				foreach ($surveyQstnOption as $option) {
			 					echo "<div class='form-group' style='padding:0px 15px;'>";
			 					foreach ($option as $opt) {
			 						if ($opt['qid'] == $qstn['id']) {
			 			?>
			 				<div class="labelGroup"><input type="checkbox" name="<?php echo "question_".$qstn['id']; ?>[]" value="<?php echo $opt['id']; ?>" id="<?php echo "option".$opt['id']; ?>" <?php if ($qstn['isMandatory']!=0) { echo "required"; }?>>&nbsp;&nbsp;&nbsp;<label for="<?php echo "option".$opt['id']; ?>"><?php echo $opt['optionText']; ?></label></div> <br>
			 			<?php
			 						}
			 					}
			 				echo "</div>";
					 		}
			 			}else if ($qstn['questionType']=="DROPDOWN") {
			 			?>
			 			<select name='<?php echo "question_". $qstn['id']; ?>[]' class='form-control' <?php if ($qstn['isMandatory']!=0) { echo "required"; }?>>
			 			<?php
			 				foreach ($surveyQstnOption as $option) {
			 					foreach ($option as $opt) {
			 						if ($opt['qid'] == $qstn['id']) {
			 							echo "<option value='".$opt['id']."'>".$opt['optionText']."</option>";
			 						}
			 					}
			 				}
			 				echo "</select>";

			 			}else if ($qstn['questionType']=="SCALE") {
			 				foreach ($surveyQstnOption as $option) {
			 					$scaleArr = array();
			 					foreach ($option as $opt) {
			 						if ($opt['qid'] == $qstn['id']) {
				 						$scaleArr[]=$opt;
				 					}
			 					}
								if (!empty($option)) {
									if ($option[0]['qid']==$qstn['id']) {
						?>
							<div class="slidecontainer">
							  <input type="range" min="<?php echo $scaleArr[0]['optionText']; ?>" max="<?php echo $scaleArr[1]['optionText']; ?>" value="" name="question_<?php echo $qstn['id']; ?>[]" class="slider">
							  <label></label>
							</div>
						<?php
				 			    }
								}
			 				}
			 			}else if ($qstn['questionType']=="TEXT") {
			 			?>
			 			<div class="form-group">
			 				<textarea name="question_<?php echo $qstn['id']; ?>[]" id="" class="form-control" rows="10"></textarea>
			 			</div>
			 			<?php
			 			}else {
			 				echo "Invalid question type!";
			 			}
			 			?>
	 				</div>
	 				<!-- <div class="col-md-4"></div> -->
	 				<div class="col-sm-4 text-right">
	 					<?php foreach ($surveyQstnMedia as $mediasArray) {
			 				foreach ($mediasArray as $media) {
			 					if ($qstn['id']==$media['qid'] && $media['mediaUrl']!="") {
				 					if ($media['mediaType']=="Image") {
				 				?>
				 				<img src="<?php echo base_url()."assets/images/".$media['mediaUrl']; ?>" height="240px" alt="">
				 				<?php
				 					} else {
				 				?>
				 				<video width="320" height="240" controls>
									<source src="<?php echo base_url()."assets/images/".$media['mediaUrl']; ?>" type="video/mp4">
								</video>
				 				<?php
				 					}
				 				}
			 				}
			 			} ?>
	 				</div>
	 			</div>
	 		</div>
	 	</div>
	<?php
 			$i++;
 		}

 		if ($records['Responsed']!= 1) {
 	?>

	<div class=" formSubmit">
			<input type="submit" class="btn btn-primary btn-default btnBlue pull-right">
			<input type="button" class="btn btn-secondary btn-default btnRed pull-right" onclick='history.go(-1);' value="Cancel">
	</div>
	 
	<?php } ?>
	</div>

	</form>

</div>


<?php $this->load->view('footer'); ?>
<script>
$(document).ready(function(){
	$(document).on('change','.slider',function(){
		var value = $(this).val();
		$(this).parent().find('label').text(value);
	});
});
</script>
