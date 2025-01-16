//file for survey section
$(document).ready(function(){
	$('.js-example-basic-multiple').select2();

	//Showing options according to selected question type
	$(document).on('change','.select-qstn',function(){

		var option = $(this).val();
		
		if (option==1) {
			$(this).closest(".bs-callout").find(".mulopt").css("display", "block");
			$(this).closest(".bs-callout").find(".chkopt").css("display", "none");
			$(this).closest(".bs-callout").find(".drpopt").css("display", "none");
			$(this).closest(".bs-callout").find(".linopt").css("display", "none");
			$(this).closest(".bs-callout").find(".txtopt").css("display", "none");
			$(this).closest(".bs-callout").find(".erropt").css("display", "none");
		}else if (option==2) {
			$(this).closest(".bs-callout").find(".mulopt").css("display", "none");
			$(this).closest(".bs-callout").find(".chkopt").css("display", "block");
			$(this).closest(".bs-callout").find(".drpopt").css("display", "none");
			$(this).closest(".bs-callout").find(".linopt").css("display", "none");
			$(this).closest(".bs-callout").find(".txtopt").css("display", "none");
			$(this).closest(".bs-callout").find(".erropt").css("display", "none");
		}else if (option==3) {
			$(this).closest(".bs-callout").find(".mulopt").css("display", "none");
			$(this).closest(".bs-callout").find(".chkopt").css("display", "none");
			$(this).closest(".bs-callout").find(".drpopt").css("display", "block");
			$(this).closest(".bs-callout").find(".linopt").css("display", "none");
			$(this).closest(".bs-callout").find(".txtopt").css("display", "none");
			$(this).closest(".bs-callout").find(".erropt").css("display", "none");
		}else if (option==4) {
			$(this).closest(".bs-callout").find(".mulopt").css("display", "none");
			$(this).closest(".bs-callout").find(".chkopt").css("display", "none");
			$(this).closest(".bs-callout").find(".drpopt").css("display", "none");
			$(this).closest(".bs-callout").find(".linopt").css("display", "block");
			$(this).closest(".bs-callout").find(".txtopt").css("display", "none");
			$(this).closest(".bs-callout").find(".erropt").css("display", "none");
		}else if (option==5) {
			$(this).closest(".bs-callout").find(".mulopt").css("display", "none");
			$(this).closest(".bs-callout").find(".chkopt").css("display", "none");
			$(this).closest(".bs-callout").find(".drpopt").css("display", "none");
			$(this).closest(".bs-callout").find(".linopt").css("display", "none");
			$(this).closest(".bs-callout").find(".txtopt").css("display", "block");
			$(this).closest(".bs-callout").find(".erropt").css("display", "none");
		}else{
			$(this).closest(".bs-callout").find(".mulopt").css("display", "none");
			$(this).closest(".bs-callout").find(".chkopt").css("display", "none");
			$(this).closest(".bs-callout").find(".drpopt").css("display", "none");
			$(this).closest(".bs-callout").find(".linopt").css("display", "none");
			$(this).closest(".bs-callout").find(".txtopt").css("display", "none");
			$(this).closest(".bs-callout").find(".erropt").css("display", "block");
		}
	});

	$(document).on('click','.rmbtn',function(){
		
		$(this).closest('.options-set').remove();
		
	});


	$(document).on('click','#addRadioOpt',function(){

		var tid = $(this).closest(".qstns").attr('id');
		var str = tid.split("-");
		var id = str[2];
		$(this).closest(".mulopt").children("#multiple-options").append('<div class="options-set"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<input type="text" placeholder="Edit Option"  name="ropt'+id+'[]" class="mul-opt-label input-radio-text"><span class="badge badge-danger rmbtn">Remove</span></div>');
	});

	$(document).on('click','#addChkOpt',function(){
		var tid = $(this).closest(".qstns").attr('id');
		var str = tid.split("-");
		var id = str[2];
		$(this).closest(".chkopt").children('#checkbox-options').append('<div class="options-set"><input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" placeholder="Edit Option" name="copt'+id+'[]" class="mul-opt-label input-check-text"><span class="badge badge-danger rmbtn">Remove</span></div>');
	});

	$(document).on('click','#addDrpOpt',function(){
		var tid = $(this).closest(".qstns").attr('id');
		var str = tid.split("-");
		var id = str[2];
		$(this).closest(".drpopt").children('#dropdown-options').append('<div class="options-set"><input type="checkbox">&nbsp;&nbsp;&nbsp;<input type="text" placeholder="Edit Option" name="dopt'+id+'[]" class="mul-opt-label input-drop-text"><span class="badge badge-danger rmbtn">Remove</span></div>');
	});

	var qstnCount = 1;

	$(document).on('click','.add_qstn',function(){

		const $all = $('[id^="qstns-sec-"]');
		const maxID = Math.max.apply(Math, $all.map((i, el) => +el.id.match(/\d+$/g)[0]).get());
		const newQstn = maxID + 1;

	  $("#survey-form").append('<div class="bs-callout bs-callout-info form-group bg-white qstns" id="qstns-sec-'+ newQstn +'"><div class="row"><div class="col-sm-9"> <input type="text" name="qstn'+newQstn+'" class="form-control-line" placeholder="Question" /><div class="qstn-content"><div class="mulopt"><div id="multiple-options"><div class="options-set"><input type="radio" />&nbsp;&nbsp;&nbsp;<input type="text" name="ropt'+newQstn+'[]" placeholder="Edit Option" class="mul-opt-label input-radio-text" /><span class="badge badge-danger rmbtn">Remove</span></div></div> <input type="radio" disabled />&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addRadioOpt">add "Other"</a></label></div><div class="chkopt"><div id="checkbox-options"><div class="options-set"><input type="checkbox"/>&nbsp;&nbsp;&nbsp;<input type="text" name="copt'+newQstn+'[]" placeholder="Edit Option" class="mul-opt-label input-check-text" /></div></div> <input type="checkbox" disabled />&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addChkOpt">add "Other"</a></label></div><div class="drpopt"><div id="dropdown-options"><div class="options-set"><input type="checkbox"/>&nbsp;&nbsp;&nbsp;<input type="text" name="dopt'+newQstn+'[]" placeholder="Edit Option" class="mul-opt-label input-drop-text" /></div></div> <input type="checkbox" disabled />&nbsp;&nbsp;&nbsp;<label>Add Options or&nbsp;<a href="#!" id="addDrpOpt">add "Other"</a></label></div><div class="linopt"><div id="linear-options"><input type="number" name="lilower'+newQstn+'" class="form-control-num" /><label>&nbsp;To&nbsp;</label><input type="number" name="lihigher'+newQstn+'" class="form-control-num" /></div></div><div class="txtopt"><div id="text-options"><div class="options-set"><div class="input-group"><input type="text" class="form-control" placeholder="Edit text" /></div></div></div> <br /></div><div class="erropt"><div id="error-options'+newQstn+'"></div></div></div></div><div class="col-sm-3"><div class="left"> <select class="form-control form-control-select select-qstn" name="qtype'+newQstn+'"><option value="1">Multiple choice</option><option value="2">Check Box</option><option value="3">Drop Down</option><option value="4">Linear Scale</option><option value="5">Text Field</option> </select></div><div class="right" align="right"> <a href="#!" class="add_qstn"> <span class="material-icons-outlined">add_circle_outline</span> </a> <br /> <input type="file" name="imgQstn'+newQstn+'" class="form-control-hidden" id="imgQstn'+newQstn+'" /> <label for="imgQstn'+newQstn+'" id="imgQstnlbl'+newQstn+'" class="imgQstnlbl"> <span class="material-icons-outlined">image</span> </label> <br /> <input type="file" name="vidQstn'+newQstn+'" class="form-control-hidden" id="vidQstn'+newQstn+'" /> <label for="vidQstn'+newQstn+'" id="vidQstnlbl'+newQstn+'" class="vidQstnlbl"> <span class="material-icons-outlined">play_circle_filled</span> </label></div> <br style="clear: both;" /></div></div><div class="bottom-icons"><ul class="list-inline"><li> <a href="#!" class="copy_qstn"> <span class="material-icons-outlined">content_copy</span> </a></li><li style="padding-top: 5px;"><label class="switch2"><input type="checkbox" name="mandatory'+newQstn+'"><span class="slider2 round"></span></label></li><li> <a href="#!" class="delete_qstn_sec"> <span class="material-icons-outlined">delete</span> </a></li></ul></div></div>');
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
	    $('.qstns').last().find(".imgQstn").attr('name', 'imgQstn'+newQstn ).attr('id', 'imgQstn'+newQstn );
	    $('.qstns').last().find(".vidQstn").attr('name', 'vidQstn'+newQstn ).attr('id', 'vidQstn'+newQstn );
	    $('.qstns').last().find(".imgQstnlbl").attr('for', 'imgQstn'+newQstn );
	    $('.qstns').last().find(".vidQstnlbl").attr('for', 'vidQstn'+newQstn );
	});

	$(document).on('click','.delete_qstn_sec',function(){
		var numItems = $('.qstns').length;
		if (numItems > 1) {
			$(this).closest('.qstns').remove();
		} else {
			alert("Can't delete the question");
		}
	});
	
});