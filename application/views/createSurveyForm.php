<?php 
	$data['name']='Create Surveys'; 
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
		<li>Create Survey Form</li>
	</ul>
	<form action="exeCreateSurveyForm" method="post" enctype="multipart/form-data">
		<div class="createSurveyFormView">
			<div id="survey-form">
				<div class="form-group">
					<label for="txtTo">To</label>
					<select class="js-example-basic-multiple form-control" multiple="multiple" name="childs[]">
						<?php 
							foreach ($row->records as $key => $rec) {
						?>
						<option value="<?php echo $rec->id; ?>"><?php echo $rec->name; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="form-group">
					<label for="txtTitle">Title</label>
					<input type="text" id="txtTitle" name="title" class="form-control">
				</div>
				<div class="form-group">
					<label for="txtDesc">Description</label>
					<textarea id="txtDesc" name="description" class="form-control"></textarea>
				</div>
				<div class="bs-callout bs-callout-info form-group bg-white qstns" id="qstns-sec-1">
					<div class="row">
						<div class="col-sm-9">
							<input type="text" name="qstn1" class="form-control-line" placeholder="Question">
							<div class="qstn-content">
								<div class="mulopt">
									<div id="multiple-options">
										<div class="options-set">
											<input type="radio" disabled>&nbsp;&nbsp;&nbsp;<input type="text" placeholder="Edit Option"  name="ropt1[]" class="mul-opt-label input-radio-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addRadioOpt">add "Other"</a></label></div>
								</div>
								<div class="chkopt" style="display: none;">
									<div id="checkbox-options">
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name="copt1[]" placeholder="Edit Option" class="mul-opt-label input-check-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addChkOpt">add "Other"</a></label></div>
								</div>
								<div class="drpopt" style="display: none;">
									<div id="dropdown-options">
										<div class="options-set">
											<input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" name="dopt1[]" placeholder="Edit Option" class="mul-opt-label input-drop-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
										</div>
									</div>
									<div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addDrpOpt">add "Other"</a></label></div>
								</div>
								<div class="linopt" style="display: none;">
									<div id="linear-options">
										<input type="number" class="form-control-num lilow" name="lilower1" value=""><label>&nbsp;To&nbsp;</label><input type="number" class="form-control-num lihigh" name="lihigher1" value=""> 
									</div>
								</div>
								<div class="txtopt" style="display: none;">
									<div id="text-options">
										<div class="options-set">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="Edit text" disabled name="txtBox1">
											</div>
										</div>
									</div>
								</div>
								<div class="erropt" style="display: none;">
									<div id="error-options0">
									
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="left">
								<select class="form-control form-control-select select-qstn" name="qtype1">
									<option value="1">Multiple choice</option>
									<option value="2">Check Box</option>
									<option value="3">Drop Down</option>
									<option value="4">Linear Scale</option>
									<option value="5">Text Field</option>
								</select>
								
								
							</div>
							<div class="right" align="right">
								<a href="#" class="add_qstn">
									<span class="material-icons-outlined">add_circle_outline</span>
								</a>
								<br>
								<input type="file" name="imgQstn1" id="imgQstn1" class="imgQstn form-control-hidden">
								<label for="imgQstn1" class="imgQstnlbl">
									<span class="material-icons-outlined">image</span>
								</label>
								<br>
								<input type="file" name="vidQstn1" id="vidQstn1" class="vidQstn form-control-hidden">
								<label for="vidQstn1" class="vidQstnlbl">
									<span class="material-icons-outlined">play_circle_filled</span>
								</label>
							</div>
							<br style="clear:both;"/>
						</div>
					</div>
					<div class="bottom-icons">
						<ul class="list-inline">
							<li>
								<a href="#" class="copy_qstn">
									<span class="material-icons-outlined">content_copy</span>
								</a>
							</li>
							<li>
								<label class="switch2">
									<input type="checkbox" class="mandatory-field" name="mandatory1">
									<span class="slider2 round"></span>
								</label>
							</li>
							<li>
								<a href="#" class="delete_qstn_sec">
									<span class="material-icons-outlined">delete</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="formSubmit">
				<input type="submit" class="btn btn-primary btn-default btnBlue pull-right">
				<input type="button" class="btn btn-secondary btn-default btnRed pull-right" value="Cancel">
			</div>
		</div>
	</form>
</div>
<?php $this->load->view('footer'); ?>
