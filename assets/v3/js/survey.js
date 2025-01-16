//file for survey section
$(document).ready(function(){
	$('.js-example-basic-multiple').select2();

	//Showing options according to selected question type
	$(document).on('change','.select-qstn',function(){

		var option = $(this).val();
		
		if (option==1) {
			$(this).closest(".qstns").find(".mulopt").css("display", "block");
			$(this).closest(".qstns").find(".chkopt").css("display", "none");
			$(this).closest(".qstns").find(".drpopt").css("display", "none");
			$(this).closest(".qstns").find(".linopt").css("display", "none");
			$(this).closest(".qstns").find(".txtopt").css("display", "none");
			$(this).closest(".qstns").find(".erropt").css("display", "none");
		}else if (option==2) {
			$(this).closest(".qstns").find(".mulopt").css("display", "none");
			$(this).closest(".qstns").find(".chkopt").css("display", "block");
			$(this).closest(".qstns").find(".drpopt").css("display", "none");
			$(this).closest(".qstns").find(".linopt").css("display", "none");
			$(this).closest(".qstns").find(".txtopt").css("display", "none");
			$(this).closest(".qstns").find(".erropt").css("display", "none");
		}else if (option==3) {
			$(this).closest(".qstns").find(".mulopt").css("display", "none");
			$(this).closest(".qstns").find(".chkopt").css("display", "none");
			$(this).closest(".qstns").find(".drpopt").css("display", "block");
			$(this).closest(".qstns").find(".linopt").css("display", "none");
			$(this).closest(".qstns").find(".txtopt").css("display", "none");
			$(this).closest(".qstns").find(".erropt").css("display", "none");
		}else if (option==4) {
			$(this).closest(".qstns").find(".mulopt").css("display", "none");
			$(this).closest(".qstns").find(".chkopt").css("display", "none");
			$(this).closest(".qstns").find(".drpopt").css("display", "none");
			$(this).closest(".qstns").find(".linopt").css("display", "block");
			$(this).closest(".qstns").find(".txtopt").css("display", "none");
			$(this).closest(".qstns").find(".erropt").css("display", "none");
		}else if (option==5) {
			$(this).closest(".qstns").find(".mulopt").css("display", "none");
			$(this).closest(".qstns").find(".chkopt").css("display", "none");
			$(this).closest(".qstns").find(".drpopt").css("display", "none");
			$(this).closest(".qstns").find(".linopt").css("display", "none");
			$(this).closest(".qstns").find(".txtopt").css("display", "block");
			$(this).closest(".qstns").find(".erropt").css("display", "none");
		}else{
			$(this).closest(".qstns").find(".mulopt").css("display", "none");
			$(this).closest(".qstns").find(".chkopt").css("display", "none");
			$(this).closest(".qstns").find(".drpopt").css("display", "none");
			$(this).closest(".qstns").find(".linopt").css("display", "none");
			$(this).closest(".qstns").find(".txtopt").css("display", "none");
			$(this).closest(".qstns").find(".erropt").css("display", "block");
		}
	});

	$(document).on('click','.rmbtn',function(){
		
		$(this).closest('.options-set').remove();
		
	});


	$(document).on('click','#addRadioOpt',function(){

		var tid = $(this).closest(".qstns").attr('id');
		var str = tid.split("-");
		var id = str[2];
		$(this).closest(".mulopt").children("#multiple-options").append('<div class="options-set"><input type="radio" disabled><input type="text" placeholder="Edit Option"  name="ropt'+id+'[]" class="mul-opt-label input-radio-text"><span class="badge badge-danger rmbtn">Remove</span></div>');
	});

	$(document).on('click','#addChkOpt',function(){
		var tid = $(this).closest(".qstns").attr('id');
		var str = tid.split("-");
		var id = str[2];
		$(this).closest(".chkopt").children('#checkbox-options').append('<div class="options-set"><input type="checkbox"><input type="text" placeholder="Edit Option" name="copt'+id+'[]" class="mul-opt-label input-check-text"><span class="badge badge-danger rmbtn">Remove</span></div>');
	});

	$(document).on('click','#addDrpOpt',function(){
		var tid = $(this).closest(".qstns").attr('id');
		var str = tid.split("-");
		var id = str[2];
		$(this).closest(".drpopt").children('#dropdown-options').append('<div class="options-set"><input type="checkbox"><input type="text" placeholder="Edit Option" name="dopt'+id+'[]" class="mul-opt-label input-drop-text"><span class="badge badge-danger rmbtn">Remove</span></div>');
	});

	var qstnCount = 1;

	$(document).on('click','.add_qstn',function(){

		const $all = $('[id^="qstns-sec-"]');
		const maxID = Math.max.apply(Math, $all.map((i, el) => +el.id.match(/\d+$/g)[0]).get());
		const newQstn = maxID + 1;

	  $("#survey-form").append('<div class="row qstns" id="qstns-sec-'+ newQstn +'"> <div class="col-md-6 col-sm-12"> <div class="form-group"> <label>Question</label> <input type="text" name="qstn'+newQstn+'" class="form-control-line form-control" placeholder="Enter Question"> </div><div class="qstn-content"> <div class="mulopt"> <div id="multiple-options"> <div class="options-set"> <input type="radio" disabled><input type="text" placeholder="Edit Option" name="ropt'+newQstn+'[]" class="mul-opt-label input-radio-text"><span href="#" class="badge badge-danger rmbtn">Remove</span> </div></div><div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addRadioOpt">Add Options</a></label></div></div><div class="chkopt" style="display: none;"> <div id="checkbox-options"> <div class="options-set"> <input type="checkbox"><input type="text" name="copt'+newQstn+'[]" placeholder="Edit Option" class="mul-opt-label input-check-text"><span href="#" class="badge badge-danger rmbtn">Remove</span> </div></div><div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addChkOpt">Add Options</a></label></div></div><div class="drpopt" style="display: none;"> <div id="dropdown-options"> <div class="options-set"> <input type="checkbox"><input type="text" name="dopt'+newQstn+'[]" placeholder="Edit Option" class="mul-opt-label input-drop-text"><span href="#" class="badge badge-danger rmbtn">Remove</span> </div></div><div class="lastLabel"> <input type="checkbox" disabled>&nbsp;&nbsp;&nbsp; <label><a href="#!" id="addDrpOpt">Add Options</a></label> </div></div><div class="linopt" style="display: none;"> <div id="linear-options"> <input type="number" class="form-control-num lilow" name="lilower'+newQstn+'" value=""> <label>&nbsp;To&nbsp;&nbsp;&nbsp;</label> <input type="number" class="form-control-num lihigh" name="lihigher'+newQstn+'" value=""> </div></div><div class="txtopt" style="display: none;"> <div id="text-options"> <div class="options-set"> <div class="input-group"> <input type="text" class="form-control" placeholder="A Text box will be provided to the user" readonly name="txtBox'+newQstn+'"> </div></div></div></div><div class="erropt" style="display: none;"> <div id="error-options'+newQstn+'"> </div></div></div></div><div class="col-md-3 col-sm-12"> <div class="form-group"> <label>Question Media</label> <input type="file" name="fileQstn' + newQstn + '" id="fileQstn' + newQstn + '" class="fileQstn form-control-hidden"> <label class="question-media fileQstnlbl" for="fileQstn' + newQstn + '"> Upload Media </label> </div></div><div class="col-md-3 col-sm-12"> <div class="row"> <div class="col-12"> <div class="form-group"> <label>Question Type</label> <select class="form-control form-control-select select-qstn" name="qtype'+newQstn+'"> <option value="1">Multiple choice</option> <option value="2">Check Box</option> <option value="3">Drop Down</option> <option value="4">Linear Scale</option> <option value="5">Text Field</option> </select> </div></div></div><div class="row"> <div class="col"> <div class="form-group row"> <div class="col-12"> <label>Mandatory</label> <div class="custom-switch custom-switch-secondary-inverse mb-2"> <input class="custom-switch-input mandatory-field" id="switch'+newQstn+'" type="checkbox" name="mandatory'+newQstn+'"> <label class="custom-switch-btn" for="switch'+newQstn+'"></label> </div></div></div></div><div class="col"> <div class="form-group"> <label>Options</label> <div class="btn-group"> <button class="btn btn-primary copy_qstn" type="button"> <div class="glyph-icon iconsminds-duplicate-layer"></div></button> <button class="btn btn-danger delete_qstn_sec" type="button"> <div class="glyph-icon simple-icon-trash"></div></button> </div></div></div></div></div></div>');
	});

	$(document).on('click','.copy_qstn',function(){
		const $all = $('[id^="qstns-sec-"]');
		const maxID = Math.max.apply(Math, $all.map((i, el) => +el.id.match(/\d+$/g)[0]).get());
		const newQstn = maxID + 1;

	    // $(this).closest('.qstns').find(".select-qstn").attr('name','qtype'+newQstn+'[]');

	    $(this).closest(".qstns").clone().prop('id', 'qstns-sec-'+newQstn ).appendTo("#survey-form");

	    var pqval = $(this).closest('.qstns').find(".select-qstn").val();

	    $('.qstns').last().find(".select-qstn").attr('name','qtype'+newQstn);
	    $('.qstns').last().find(".mandatory-field").attr('name','mandatory'+newQstn);
	    $('.qstns').last().find(".form-control-line").attr('name', 'qstn'+newQstn );
	    $('.qstns').last().find(".input-radio-text").attr('name', 'ropt'+newQstn+'[]' );
	    $('.qstns').last().find(".input-check-text").attr('name', 'copt'+newQstn+'[]' );
	    $('.qstns').last().find(".input-drop-text").attr('name', 'dopt'+newQstn+'[]' );
	    $('.qstns').last().find(".lilow").attr('name', 'lilower'+newQstn );
	    $('.qstns').last().find(".lihigh").attr('name', 'lihigher'+newQstn );
	    $('.qstns').last().find(".lihigh").attr('name', 'lihigher'+newQstn );
	    $('.qstns').last().find(".fileQstn").attr('name', 'fileQstn'+newQstn ).attr('id', 'fileQstn'+newQstn );
	    $('.qstns').last().find(".fileQstnlbl").attr('for', 'fileQstn'+newQstn );
	    // $('.qstns').last().find(".vidQstn").attr('name', 'vidQstn'+newQstn ).attr('id', 'vidQstn'+newQstn );
	    // $('.qstns').last().find(".vidQstnlbl").attr('for', 'vidQstn'+newQstn );
	});

	$(document).on('click','.delete_qstn_sec',function(){
		var numItems = $('.qstns').length;
		if (numItems > 1) {
			$(this).closest('.qstns').remove();
		} else {
			alert("Minimum 1 question is mandatory to create a survey.");
		}
	});

	$(document).on('change', '.fileQstn', function(){
		if ($(this).val() == "") {
			$(this).siblings('.question-media').text('Upload Media');
		}else{
			$(this).siblings('.question-media').text($(this)[0].files[0].name + " is selected!");
		}
	});
	
});