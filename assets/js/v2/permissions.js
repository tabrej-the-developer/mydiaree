	$(document).ready(function(){

		$(document).on("change","#user",function(){
			$("#getPerForm").submit();
		});

		$(document).on("change","#center",function(){
			$("#getPerForm").submit();
		});

		function countObs(){
			var checkboxes = $('.obs:checkbox:checked').length;
		    var totalCheckBoxes = $('.obs:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkobs").prop('checked',true);
		    } else {
		    	$(".checkobs").prop('checked',false);
		    }
		}

		countObs();

		function countSur(){
			var checkboxes = $('.sur:checkbox:checked').length;
		    var totalCheckBoxes = $('.sur:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checksur").prop('checked',true);
		    } else {
		    	$(".checksur").prop('checked',false);
		    }
		}

		countSur();

		function countQip(){
			var checkboxes = $('.qip:checkbox:checked').length;
		    var totalCheckBoxes = $('.qip:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkqip").prop('checked',true);
		    } else {
		    	$(".checkqip").prop('checked',false);
		    }
		}

		countQip();

		function countRoom(){
			var checkboxes = $('.room:checkbox:checked').length;
		    var totalCheckBoxes = $('.room:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkroom").prop('checked',true);
		    } else {
		    	$(".checkroom").prop('checked',false);
		    }
		}

		countRoom();

		function countPp(){
			var checkboxes = $('.pp:checkbox:checked').length;
		    var totalCheckBoxes = $('.pp:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkpp").prop('checked',true);
		    } else {
		    	$(".checkpp").prop('checked',false);
		    }
		}

		countPp();

		function countAnn(){
			var checkboxes = $('.announ:checkbox:checked').length;
		    var totalCheckBoxes = $('.announ:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkannoun").prop('checked',true);
		    } else {
		    	$(".checkannoun").prop('checked',false);
		    }
		}

		countAnn();

		function countRcp(){
			var checkboxes = $('.rcp:checkbox:checked').length;
		    var totalCheckBoxes = $('.rcp:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkrcp").prop('checked',true);
		    } else {
		    	$(".checkrcp").prop('checked',false);
		    }
		}

		countRcp();

		function countMenu(){
			var checkboxes = $('.menu:checkbox:checked').length;
		    var totalCheckBoxes = $('.menu:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkmenu").prop('checked',true);
		    } else {
		    	$(".checkmenu").prop('checked',false);
		    }
		}

		countMenu();

		$(document).on("click",".checkobs",function(){
			if ($(this).prop('checked') == true) {
				$(".obs").prop('checked',true);
			} else {
				$(".obs").prop('checked',false);
			}
		});

		$(document).on("click",".obs",function(){
			countObs();
		});

		$(document).on("click",".checkqip",function(){
			if ($(this).prop('checked') == true) {
				$(".qip").prop('checked',true);
			} else {
				$(".qip").prop('checked',false);
			}
		});

		$(document).on("click",".qip",function(){
			countQip();
		});

		$(document).on("click",".checkroom",function(){
			if ($(this).prop('checked') == true) {
				$(".room").prop('checked',true);
			} else {
				$(".room").prop('checked',false);
			}
		});

		$(document).on("click",".room",function(){
			countRoom();
		});

		$(document).on("click",".checkpp",function(){
			if ($(this).prop('checked') == true) {
				$(".pp").prop('checked',true);
			} else {
				$(".pp").prop('checked',false);
			}
		});

		$(document).on("click",".pp",function(){
			countPp();
		});

		$(document).on("click",".checkannoun",function(){
			if ($(this).prop('checked') == true) {
				$(".announ").prop('checked',true);
			} else {
				$(".announ").prop('checked',false);
			}
		});

		$(document).on("click",".announ",function(){
			countAnn();
		});

		$(document).on("click",".checksur",function(){
			if ($(this).prop('checked') == true) {
				$(".sur").prop('checked',true);
			} else {
				$(".sur").prop('checked',false);
			}
		});

		$(document).on("click",".sur",function(){
			countSur();
		});

		$(document).on("click",".checkrcp",function(){
			if ($(this).prop('checked') == true) {
				$(".rcp").prop('checked',true);
			} else {
				$(".rcp").prop('checked',false);
			}
		});

		$(document).on("click",".rcp",function(){
			countRcp();
		});

		$(document).on("click",".checkmenu",function(){
			if ($(this).prop('checked') == true) {
				$(".menu").prop('checked',true);
			} else {
				$(".menu").prop('checked',false);
			}
		});

		$(document).on("click",".menu",function(){
			countMenu();
		});
	});