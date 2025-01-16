	$(document).ready(function(){

		$(document).on("change","#user",function(){
			$("#getPerForm").submit();
		});

		function checkObs(){
			var checkboxes = $('.obs:checkbox:checked').length;
		    var totalCheckBoxes = $('.obs:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkobs").prop('checked',true);
		    } else {
		    	$(".checkobs").prop('checked',false);
		    }
		}

		checkObs();

		function checkQip(){
			var checkboxes = $('.qip:checkbox:checked').length;
		    var totalCheckBoxes = $('.qip:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkqip").prop('checked',true);
		    } else {
		    	$(".checkqip").prop('checked',false);
		    }
		}

		checkQip();

		function checkReflections(){
			var checkboxes = $('.refl:checkbox:checked').length;
		    var totalCheckBoxes = $('.refl:checkbox').length;
		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkrefl").prop('checked',true);
		    } else {
		    	$(".checkrefl").prop('checked',false);
		    }
		}

		checkReflections();

		function checkSelfAssessment(){
			var checkboxes = $('.selfasmnt:checkbox:checked').length;
		    var totalCheckBoxes = $('.selfasmnt:checkbox').length;
		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkselfasmnt").prop('checked',true);
		    } else {
		    	$(".checkselfasmnt").prop('checked',false);
		    }
		}

		checkSelfAssessment();

		function checkRooms(){
			var checkboxes = $('.room:checkbox:checked').length;
		    var totalCheckBoxes = $('.room:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkroom").prop('checked',true);
		    } else {
		    	$(".checkroom").prop('checked',false);
		    }
		}

		checkRooms();

		function checkProgPlan(){
			var checkboxes = $('.pp:checkbox:checked').length;
		    var totalCheckBoxes = $('.pp:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkpp").prop('checked',true);
		    } else {
		    	$(".checkpp").prop('checked',false);
		    }
		}

		checkProgPlan();

		function checkAnnouncements(){
			var checkboxes = $('.announ:checkbox:checked').length;
		    var totalCheckBoxes = $('.announ:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkannoun").prop('checked',true);
		    } else {
		    	$(".checkannoun").prop('checked',false);
		    }
		}

		checkAnnouncements();


		function checkSurvey(){
			var checkboxes = $('.sur:checkbox:checked').length;
		    var totalCheckBoxes = $('.sur:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checksur").prop('checked',true);
		    } else {
		    	$(".checksur").prop('checked',false);
		    }
		}

		checkSurvey();

		function checkRecipes(){
			var checkboxes = $('.rcp:checkbox:checked').length;
		    var totalCheckBoxes = $('.rcp:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkrcp").prop('checked',true);
		    } else {
		    	$(".checkrcp").prop('checked',false);
		    }
		}

		checkRecipes();

		function checkMenu(){
			var checkboxes = $('.menus:checkbox:checked').length;
		    var totalCheckBoxes = $('.menus:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkmenu").prop('checked',true);
		    } else {
		    	$(".checkmenu").prop('checked',false);
		    }
		}

		checkMenu();

		function checkProgressPlan(){
			var checkboxes = $('.progplan:checkbox:checked').length;
		    var totalCheckBoxes = $('.progplan:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkprogplan").prop('checked',true);
		    } else {
		    	$(".checkprogplan").prop('checked',false);
		    }
		}

		checkProgressPlan();

		function checkLessonPlan(){
			var checkboxes = $('.lsnp:checkbox:checked').length;
		    var totalCheckBoxes = $('.lsnp:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checklsnplan").prop('checked',true);
		    } else {
		    	$(".checklsnplan").prop('checked',false);
		    }
		}

		checkLessonPlan();

		function checkDailyJournal(){
			var checkboxes = $('.dailyjournal:checkbox:checked').length;
		    var totalCheckBoxes = $('.dailyjournal:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkdailyjournal").prop('checked',true);
		    } else {
		    	$(".checkdailyjournal").prop('checked',false);
		    }
		}

		checkDailyJournal();

		function checkUsers(){
			var checkboxes = $('.users:checkbox:checked').length;
		    var totalCheckBoxes = $('.users:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkusers").prop('checked',true);
		    } else {
		    	$(".checkusers").prop('checked',false);
		    }
		}

		checkUsers();


		function checkCenters(){
			var checkboxes = $('.center:checkbox:checked').length;
		    var totalCheckBoxes = $('.center:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkcenter").prop('checked',true);
		    } else {
		    	$(".checkcenter").prop('checked',false);
		    }
		}

		checkCenters();

		function checkParents(){
			var checkboxes = $('.parent:checkbox:checked').length;
		    var totalCheckBoxes = $('.parent:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkparent").prop('checked',true);
		    } else {
		    	$(".checkparent").prop('checked',false);
		    }
		}

		checkParents();

		function checkChildGroups(){
			var checkboxes = $('.cg:checkbox:checked').length;
		    var totalCheckBoxes = $('.cg:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkcg").prop('checked',true);
		    } else {
		    	$(".checkcg").prop('checked',false);
		    }
		}

		checkChildGroups();

		function checkMiscSettings(){
			var checkboxes = $('.checkms:checkbox:checked').length;
		    var totalCheckBoxes = $('.checkms:checkbox').length;

		    if (checkboxes==totalCheckBoxes) {
		    	$(".checkmisc").prop('checked',true);
		    } else {
		    	$(".checkmisc").prop('checked',false);
		    }
		}

		checkMiscSettings();

		$(document).on("click",".checkobs",function(){
			if ($(this).prop('checked') == true) {
				$(".obs").prop('checked',true);
			} else {
				$(".obs").prop('checked',false);
			}
		});

		$(document).on("click",".obs",function(){
			checkObs();
		});

		$(document).on("click",".checkqip",function(){
			if ($(this).prop('checked') == true) {
				$(".qip").prop('checked',true);
			} else {
				$(".qip").prop('checked',false);
			}
		});

		$(document).on("click",".qip",function(){
			checkQip();
		});

		$(document).on("click",".checkrefl",function(){
			if ($(this).prop('checked') == true) {
				$(".refl").prop('checked',true);
			} else {
				$(".refl").prop('checked',false);
			}
		});

		$(document).on("click",".refl",function(){
			checkReflections();
		});

		$(document).on("click",".checkselfasmnt",function(){
			if ($(this).prop('checked') == true) {
				$(".selfasmnt").prop('checked',true);
			} else {
				$(".selfasmnt").prop('checked',false);
			}
		});

		$(document).on("click",".selfasmnt",function(){
			checkSelfAssessment();
		});

		$(document).on("click",".checkroom",function(){
			if ($(this).prop('checked') == true) {
				$(".room").prop('checked',true);
			} else {
				$(".room").prop('checked',false);
			}
		});

		$(document).on("click",".room",function(){
			checkRooms();
		});

		$(document).on("click",".checkpp",function(){
			if ($(this).prop('checked') == true) {
				$(".pp").prop('checked',true);
			} else {
				$(".pp").prop('checked',false);
			}
		});

		$(document).on("click",".pp",function(){
			checkProgPlan();
		});

		$(document).on("click",".checkannoun",function(){
			if ($(this).prop('checked') == true) {
				$(".announ").prop('checked',true);
			} else {
				$(".announ").prop('checked',false);
			}
		});

		$(document).on("click",".announ",function(){
			checkAnnouncements();
		});

		$(document).on("click",".checksur",function(){
			if ($(this).prop('checked') == true) {
				$(".sur").prop('checked',true);
			} else {
				$(".sur").prop('checked',false);
			}
		});

		$(document).on("click",".sur",function(){
			checkSurvey();
		});

		$(document).on("click",".checkrcp",function(){
			if ($(this).prop('checked') == true) {
				$(".rcp").prop('checked',true);
			} else {
				$(".rcp").prop('checked',false);
			}
		});

		$(document).on("click",".rcp",function(){
			checkRecipes();
		});

		$(document).on("click",".checkmenu",function(){
			if ($(this).prop('checked') == true) {
				$(".menus").prop('checked',true);
			} else {
				$(".menus").prop('checked',false);
			}
		});

		$(document).on("click",".menus",function(){
			checkMenu();
		});

		$(document).on("click",".checkprogplan",function(){
			if ($(this).prop('checked') == true) {
				$(".progplan").prop('checked',true);
			} else {
				$(".progplan").prop('checked',false);
			}
		});

		$(document).on("click",".progplan",function(){
			checkProgressPlan();
		});

		$(document).on("click",".checklsnplan",function(){
			if ($(this).prop('checked') == true) {
				$(".lsnp").prop('checked',true);
			} else {
				$(".lsnp").prop('checked',false);
			}
		});

		$(document).on("click",".lsnp",function(){
			checkLessonPlan();
		});

		$(document).on("click",".checkdailyjournal",function(){
			if ($(this).prop('checked') == true) {
				$(".dailyjournal").prop('checked',true);
			} else {
				$(".dailyjournal").prop('checked',false);
			}
		});

		$(document).on("click",".dailyjournal",function(){
			checkDailyJournal();
		});

		$(document).on("click",".checkusers",function(){
			if ($(this).prop('checked') == true) {
				$(".users").prop('checked',true);
			} else {
				$(".users").prop('checked',false);
			}
		});

		$(document).on("click",".users",function(){
			checkUsers();
		});

		$(document).on("click",".checkcenter",function(){
			if ($(this).prop('checked') == true) {
				$(".center").prop('checked',true);
			} else {
				$(".center").prop('checked',false);
			}
		});

		$(document).on("click",".center",function(){
			checkCenters();
		});

		$(document).on("click",".checkparent",function(){
			if ($(this).prop('checked') == true) {
				$(".parent").prop('checked',true);
			} else {
				$(".parent").prop('checked',false);
			}
		});

		$(document).on("click",".parent",function(){
			checkParents();
		});


		$(document).on("click",".checkcg",function(){
			if ($(this).prop('checked') == true) {
				$(".cg").prop('checked',true);
			} else {
				$(".cg").prop('checked',false);
			}
		});

		$(document).on("click",".cg",function(){
			checkChildGroups();
		});

		$(document).on("click",".checkmisc",function(){
			if ($(this).prop('checked') == true) {
				$(".checkms").prop('checked',true);
			} else {
				$(".checkms").prop('checked',false);
			}
		});

		$(document).on("click",".checkms",function(){
			checkMiscSettings();
		});

		$(document).on('change', "#users", function(){
			let _centerid = $('#centerId').val();
			let _usersArr = $(this).val();
			if(_usersArr.length > 0){
				$.ajax({
					url: "http://localhost/Mykronicle/Settings/getUsersPermissions",
					type: 'POST',
					data: {'centerid': _centerid, 'users': JSON.stringify(_usersArr)},
				}).done(function(json) {
					res = jQuery.parseJSON(json);
					if (res.Status=="SUCCESS") {
						$.each(res.permissions, function(index, val) {
							if (val==0) {
								$('input[name='+index+']').prop('checked', false);
							}else{
								$('input[name='+index+']').prop('checked', true);
							}
						});
					}else{
						console.log(res.Message);
					}
					checkObs();
					checkQip();
					checkReflections();
					checkSelfAssessment();
					checkRooms();
					checkAnnouncements();
					checkProgPlan();
					checkSurvey();
					checkParents();
					checkCenters();
					checkUsers();
					checkDailyJournal();
					checkLessonPlan();
					checkProgressPlan();
					checkMenu();
					checkRecipes();
					checkChildGroups();
					checkMiscSettings();
				});
			}else{
				alert("Please choose atleast one staff to set permission!");
			}
		});

	});