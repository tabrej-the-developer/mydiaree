<?php 
	if (!empty($records['Surveys']['survey'][0])) {
		$survey = $records['Surveys']['survey'][0];
	}

	if (!empty($records['Surveys']['surveyQuestion'])) {
		$surveyQuestion	= $records['Surveys']['surveyQuestion'];
	}

	$surveyChilds = $records['Surveys']['surveyChild'];

	$data['name']='Update Survey'; 
	$this->load->view('header',$data); 
?>



<div class="container ">
	<div class="pageHead">
		<h1>Surveys</h1>
		<div class="headerForm">
		</div>
	</div>
	<ul class="breadcrumb">
		<li><a href="<?php echo base_url()."surveys/";?>">Surveys</a></li>
		<li>Update Survey Form</li>
	</ul>
	<form action="<?= base_url('Surveys/updateSurveyForm'); ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="surveyid" value="<?php echo $survey['id']; ?>">
		<div class="createSurveyFormView">
			<div id="survey-form">
				<div class="form-group">
					<label for="txtTo">To</label>
					<select class="js-example-basic-multiple form-control" multiple="multiple" name="childs[]">
						<?php 
							foreach ($surveyChilds as $svyChilds) {
								if ($svyChilds['surveyid']==$survey['id']) {
						?>
						<option value="<?php echo $svyChilds['id']; ?>" selected><?php echo $svyChilds['name']; ?></option>
						<?php	
								} else {
						?>
						<option value="<?php echo $svyChilds['id']; ?>"><?php echo $svyChilds['name']; ?></option>
						<?php	
								}
							} 
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="txtTitle">Title</label>
					<input type="text" id="txtTitle" name="title" class="form-control" value="<?php echo $survey['title'];?>">
				</div>
				<div class="form-group">
					<label for="txtDesc">Description</label>
					<textarea id="txtDesc" name="description" class="form-control"><?php echo $survey['description'];?></textarea>
				</div>
			    <?php 
					if (!empty($surveyQuestion)) {
						$i = 1;
						foreach ($surveyQuestion as $key => $sq) {
				?>
				<div class="bs-callout bs-callout-info form-group bg-white qstns" id="qstns-sec-<?php echo $i; ?>">
					<div class="row">
						<div class="col-sm-9">
							<input type="text" name="<?php echo "qstn".$i; ?>" class="form-control-line" placeholder="Question" value="<?php echo $sq['questionText']; ?>">
							<div class="qstn-content">
								<?php if ($sq['questionType']=="RADIO") { ?>
								<div class="mulopt">
									<div id="multiple-options">
										<?php 
										foreach ($records['Surveys']['surveyQuestionOption'] as $surveyQstnOpt => $sqo) {
											foreach ($sqo as $sqOpt) {
												if ($sq['id']==$sqOpt['qid']) {
										?>
										<div class="options-set">
											<input type="radio" disabled>&nbsp;&nbsp;&nbsp;<input type="text" placeholder="Edit Option"  name="<?php echo "ropt".$i; ?>[]" class="mul-opt-label input-radio-text" value="<?php echo $sqOpt['optionText']; ?>"><span class="badge badge-danger rmbtn" onclick="deleteElement('<?php echo $sqOpt['id']; ?>','OPTION');">Remove</span>
										</div>
										<?php
												}
											}
										}
										?>
									</div>
									<div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addRadioOpt">add "Other"</a></label></div>
								</div>
								<div class="chkopt" style="display: none;">
									<div id="checkbox-options">
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name='<?php echo "copt".$i."[]"; ?>' placeholder="Edit Option" class="mul-opt-label input-check-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addChkOpt">add "Other"</a></label></div>
								</div>
								<div class="drpopt" style="display: none;">
									<div id="dropdown-options">
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name='<?php echo "dopt".$i."[]"; ?>' placeholder="Edit Option" class="mul-opt-label input-drop-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addDrpOpt">add "Other"</a></label></div>
								</div>
								<div class="linopt" style="display: none;">
									<div id="linear-options">
										<input type="number" class="form-control-num lilow" name="<?php echo "lilower".$i; ?>" value=""><label>&nbsp;To&nbsp;</label><input type="number" class="form-control-num lihigh" name="<?php echo "lihigher".$i; ?>" value=""> 
									</div>
								</div>
								<div class="txtopt" style="display: none;">
									<div id="text-options">
										<div class="options-set">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Edit text" disabled name="<?php echo "txtBox".$i; ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="erropt" style="display: none;">
									<div id="error-options0"></div>
								</div>
								<?php }elseif ($sq['questionType']=="CHECKBOX") { ?>
								<div class="mulopt" style="display: none;">
									<div id="multiple-options">
										<div class="options-set">
											<input type="radio" disabled>&nbsp;&nbsp;&nbsp;<input type="text" placeholder="Edit Option"  name="<?php echo "ropt".$i; ?>[]" class="mul-opt-label input-radio-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addRadioOpt">add "Other"</a></label></div>
								</div>
								<div class="chkopt" style="display:block;">
									<div id="checkbox-options">
										<?php 
										foreach ($records['Surveys']['surveyQuestionOption'] as $surveyQstnOpt => $sqo) {
											foreach ($sqo as $sqOpt) {
												if ($sq['id']==$sqOpt['qid']) {
										?>
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name="<?php echo "copt".$i; ?>[]" placeholder="Edit Option" class="mul-opt-label input-check-text" value="<?php echo $sqOpt['optionText']; ?>"><span href="#" class="badge badge-danger rmbtn" onclick="deleteElement('<?php echo $sqOpt['id']; ?>','OPTION');">Remove</span>
										</div>
										<?php 		}
												}
											} 
										?>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addChkOpt">add "Other"</a></label></div>
								</div>
								<div class="drpopt" style="display: none;">
									<div id="dropdown-options">
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name='<?php echo "dopt".$i."[]"; ?>' placeholder="Edit Option" class="mul-opt-label input-drop-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addDrpOpt">add "Other"</a></label></div>
								</div>
								<div class="linopt" style="display: none;">
									<div id="linear-options">
										<input type="number" class="form-control-num lilow" name="<?php echo "lilower".$i; ?>" value=""><label>&nbsp;To&nbsp;</label><input type="number" class="form-control-num lihigh" name="<?php echo "lihigher".$i; ?>" value=""> 
									</div>
								</div>
								<div class="txtopt" style="display: none;">
									<div id="text-options">
										<div class="options-set">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Edit text" disabled name="<?php echo "txtBox".$i; ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="erropt" style="display: none;">
									<div id="error-options0"></div>
								</div>
								<?php }elseif ($sq['questionType']=="DROPDOWN") { ?>
								<div class="mulopt" style="display: none;">
									<div id="multiple-options">
										<div class="options-set">
											<input type="radio" disabled>&nbsp;&nbsp;&nbsp;<input type="text" placeholder="Edit Option"  name="<?php echo "ropt".$i; ?>[]" class="mul-opt-label input-radio-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addRadioOpt">add "Other"</a></label></div>
								</div>
								<div class="chkopt" style="display: none;">
									<div id="checkbox-options">
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name='<?php echo "copt".$i."[]"; ?>' placeholder="Edit Option" class="mul-opt-label input-check-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addChkOpt">add "Other"</a></label></div>
								</div>
								<div class="drpopt" style="display:block;">
									<div id="dropdown-options">
										<?php 
										foreach ($records['Surveys']['surveyQuestionOption'] as $surveyQstnOpt => $sqo) {
											foreach ($sqo as $sqOpt) {
												if ($sq['id']==$sqOpt['qid']) {
										?>
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name="<?php echo "dopt".$i; ?>[]" placeholder="Edit Option" class="mul-opt-label input-drop-text" value="<?php echo $sqOpt['optionText']; ?>"><span href="#" class="badge badge-danger rmbtn" onclick="deleteElement('<?php echo $sqOpt['id']; ?>','OPTION');">Remove</span>
										</div>
										<?php 	
													}
												}
											}
										?>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addDrpOpt">add "Other"</a></label></div>
								</div>
								<div class="linopt" style="display: none;">
									<div id="linear-options">
										<input type="number" class="form-control-num lilow" name="<?php echo "lilower".$i; ?>" value=""><label>&nbsp;To&nbsp;</label><input type="number" class="form-control-num lihigh" name="<?php echo "lihigher".$i; ?>" value=""> 
									</div>
								</div>
								<div class="txtopt" style="display: none;">
									<div id="text-options">
										<div class="options-set">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Edit text" disabled name="<?php echo "txtBox".$i; ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="erropt" style="display: none;">
									<div id="error-options0"></div>
								</div>
								<?php }elseif ($sq['questionType']=="SCALE") {
									$int = 1;
									$lilower = "";
									$lihigher = "";
									foreach ($records['Surveys']['surveyQuestionOption'] as $surveyQstnOpt => $sqo) {
										foreach ($sqo as $sqOpt) {
											if ($sq['id']==$sqOpt['qid']) {
												if($int==1){
													$lilower = $sqOpt['optionText'];
													$int++;
												}elseif ($int==2) {
													$lihigher = $sqOpt['optionText'];
												}
											}
										}

									}
								?>
								<div class="mulopt" style="display: none;">
									<div id="multiple-options">
										<div class="options-set">
											<input type="radio" disabled>&nbsp;&nbsp;&nbsp;<input type="text" placeholder="Edit Option"  name="<?php echo "ropt".$i; ?>[]" class="mul-opt-label input-radio-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addRadioOpt">add "Other"</a></label></div>
								</div>
								<div class="chkopt" style="display: none;">
									<div id="checkbox-options">
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name='<?php echo "copt".$i."[]"; ?>' placeholder="Edit Option" class="mul-opt-label input-check-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addChkOpt">add "Other"</a></label></div>
								</div>
								<div class="drpopt" style="display: none;">
									<div id="dropdown-options">
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name='<?php echo "dopt".$i."[]"; ?>' placeholder="Edit Option" class="mul-opt-label input-drop-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addDrpOpt">add "Other"</a></label></div>
								</div>
								<div class="linopt" style="display:block;">
									<div id="linear-options">
										<input type="number" class="form-control-num lilow" name="<?php echo "lilower".$i; ?>" value="<?php echo $lilower; ?>"><label>&nbsp;To&nbsp;</label><input type="number" class="form-control-num lihigh" name="<?php echo "lihigher".$i; ?>" value="<?php echo $lihigher; ?>"> 
									</div>
								</div>
								<div class="txtopt" style="display: none;">
									<div id="text-options">
										<div class="options-set">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Edit text" disabled name="<?php echo "txtBox".$i; ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="erropt" style="display: none;">
									<div id="error-options0"></div>
								</div>
								<?php }elseif ($sq['questionType']=="TEXT") { ?>
								<div class="mulopt" style="display: none;">
									<div id="multiple-options">
										<div class="options-set">
											<input type="radio" disabled>&nbsp;&nbsp;&nbsp;<input type="text" placeholder="Edit Option"  name="<?php echo "ropt".$i; ?>[]" class="mul-opt-label input-radio-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addRadioOpt">add "Other"</a></label></div>
								</div>
								<div class="chkopt" style="display: none;">
									<div id="checkbox-options">
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name='<?php echo "copt".$i."[]"; ?>' placeholder="Edit Option" class="mul-opt-label input-check-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addChkOpt">add "Other"</a></label></div>
								</div>
								<div class="drpopt" style="display: none;">
									<div id="dropdown-options">
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name='<?php echo "dopt".$i."[]"; ?>' placeholder="Edit Option" class="mul-opt-label input-drop-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addDrpOpt">add "Other"</a></label></div>
								</div>
								<div class="linopt" style="display: none;">
									<div id="linear-options">
										<input type="number" class="form-control-num lilow" name="<?php echo "lilower".$i; ?>" value=""><label>&nbsp;To&nbsp;</label><input type="number" class="form-control-num lihigh" name="<?php echo "lihigher".$i; ?>" value=""> 
									</div>
								</div>
								<div class="txtopt" style="display: none;">
									<div id="text-options">
										<div class="options-set">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Edit text" disabled name="<?php echo "txtBox".$i; ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="txtopt" style="display:block;">
									<div id="text-options">
										<div class="options-set">
											<div class="input-group">
											  <input type="text" class="form-control" placeholder="Edit text" disabled name="<?php echo "txtBox".$i; ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="erropt" style="display: none;">
									<div id="error-options0"></div>
								</div>
								<?php }else { ?>
								<div class="erropt" style="display:block;">
									<div id="error-options0">										
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
						<div class="col-sm-3" style="max-height:220px;">
							<div class="left">
								<select class="form-control form-control-select select-qstn" name="<?php echo "qtype".$i; ?>">
									<?php
										if ($sq['questionType']=="RADIO") {
									?>
									<option value="1" selected>Multiple choice</option>
									<option value="2">Check Box</option>
									<option value="3">Drop Down</option>
									<option value="4">Linear Scale</option>
									<option value="5">Text Field</option>
									<?php
										}else if ($sq['questionType']=="CHECKBOX") {
									?>
									<option value="1">Multiple choice</option>
									<option value="2" selected>Check Box</option>
									<option value="3">Drop Down</option>
									<option value="4">Linear Scale</option>
									<option value="5">Text Field</option>
									<?php
										}else if ($sq['questionType']=="DROPDOWN") {
									?>
									<option value="1">Multiple choice</option>
									<option value="2">Check Box</option>
									<option value="3" selected>Drop Down</option>
									<option value="4">Linear Scale</option>
									<option value="5">Text Field</option>
									<?php
										}else if ($sq['questionType']=="SCALE") {
									?>
									<option value="1">Multiple choice</option>
									<option value="2">Check Box</option>
									<option value="3">Drop Down</option>
									<option value="4" selected>Linear Scale</option>
									<option value="5">Text Field</option>
									<?php
										}else if ($sq['questionType']=="TEXT") {
									?>
									<option value="1">Multiple choice</option>
									<option value="2">Check Box</option>
									<option value="3">Drop Down</option>
									<option value="4">Linear Scale</option>
									<option value="5" selected>Text Field</option>
									<?php
										}else{
									?>
									<option>--Select Option--</option>
									<option value="1">Multiple choice</option>
									<option value="2">Check Box</option>
									<option value="3">Drop Down</option>
									<option value="4">Linear Scale</option>
									<option value="5">Text Field</option>
									<?php } ?>
								</select>
							</div>
							<div class="right" align="right">
								<a href="#" class="add_qstn">
									<span class="material-icons-outlined">add_circle_outline</span>
								</a>
								<br>
								<input type="file" name="<?php echo "imgQstn".$i; ?>" id="<?php echo "imgQstn".$i; ?>" class="imgQstn form-control-hidden">
								<label for="<?php echo "imgQstn".$i; ?>" class="imgQstnlbl">
									<span class="material-icons-outlined">image</span>
								</label>
								<br>
								<input type="file" name="<?php echo "vidQstn".$i; ?>" id="<?php echo "vidQstn".$i; ?>" class="vidQstn form-control-hidden">
								<label for="<?php echo "vidQstn".$i; ?>" class="vidQstnlbl">
									<span class="material-icons-outlined">play_circle_filled</span>
								</label>
							</div>
							<br style="clear:both;"/>
						</div>
					</div>
					<div class="Uploadmedia">
						<?php 
							foreach ($records['Surveys']['surveyQuestionMedia'] as $surveyQstnMedia => $sqm) {
								foreach ($sqm as $surveyMedia) {
									if ($surveyMedia['qid']==$sq['id']) {
										if ($surveyMedia['mediaType'] == 'Image') {
						?>
							<img src="<?php echo BASE_API_URL."assets/media/".$surveyMedia['mediaUrl']; ?>" style="margin: auto;" width="400px" height="225px">
						<?php
										} else {
						?>
						<video src="<?php echo BASE_API_URL."assets/media/".$surveyMedia['mediaUrl']; ?>"  style="margin: auto;" width="400px" height="225px" controls></video>
						<?php
										}
									}
								}
							}
						?>
					</div>
					<div class="bottom-icons" >
						<ul class="list-inline">
							<li>
								<a href="#" class="copy_qstn">
									<span class="material-icons-outlined">content_copy</span>
								</a>
							</li>
							<li style="padding-top: 5px;">
								<label class="switch2">
								<?php 
									if ($sq['isMandatory']==1) {
								?>
								<input type="checkbox" class="mandatory-field" name="<?php echo "mandatory".$i; ?>" checked>
								<?php
									}else{
								?>
								<input type="checkbox" class="mandatory-field" name="<?php echo "mandatory".$i; ?>">
								<?php
									}
								?>
								<span class="slider2 round"></span>
								</label>
							</li>
							<li>
								<a href="#" class="delete_qstn_sec_1" onclick="deleteElement('<?php echo $sq['id']; ?>','QUESTION');">
									<span class="material-icons-outlined">delete</span>
								</a>
							</li>
						</ul>
					</div>	
				</div>
				<?php   
						$i++;
						}
					}
				?>
			</div>
			<div class="text-right">
				<button type="submit" class="btn btnBlue">Update</button>
			</div>
		</div>
	</form>
</div>
<?php $this->load->view('footer'); ?>
