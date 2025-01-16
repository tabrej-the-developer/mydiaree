$(document).ready(function(){
	
	//load preview function for add/edit observation form
	function loadPreview(){
		//get values from the observation form to show on the preview modal
		// let obsTitle = $("#obs_title").val();
		let obsTitle = CKEDITOR.instances.obs_title.getData();
		let obsAuthor = $("#obs_author").val();
		var editorText = CKEDITOR.instances.obs_notes.getData();
		// let obsReflection = $("#obs_reflection").val();
		let obsReflection = CKEDITOR.instances.obs_reflection.getData();
		$("#obsPreviewTitle").html(obsTitle);
		$("#obsPreviewAuthor").text(obsAuthor);
		$("#obsNotes").html(editorText);
		$("#obsReflection").html(obsReflection);
		$(".obsChildrenItem").remove();
		$("input[name='childrens[]']").each(function(){
			$("#obsChildren").append('<div class="obsChildrenItem"><img src="https://via.placeholder.com/30"><span>'+$(this).data("name")+'</span></div>');
		});


		//for sliders
		let integer = 1;
		let slider = 0;
		$(".img-preview").each(function(index,el) {
			let image = $(this).find("img").attr("src");
			$(".your-class").append(`<div><img src='`+image+`' alt=''>
									<div class="tags-section tags-sec-`+integer+`">
                                        <div class="child-tags child-tags-`+integer+`">
	                                        
                                        </div>
                                    </div>
                                </div>`);
			$(".thumbMedia").append('<span data-slide="'+slider+'"><img src="'+image+'" width="150" height="150"></span>');
			//check origin
			let origin = $(this).data('origin');
			if (origin=="NEW") {
				//if it is a local file
				let mediano = $(this).data('fileno');

				if($('input[name="obsImage_'+mediano+'[]"]').length){
					//if file child tags already exists
					$('input[name="obsImage_'+mediano+'[]"]').each(function(){
						$(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan">
						    <img src="https://via.placeholder.com/50">
						    <span style="color: #3E695A;">`+$(this).data("name")+`</span>
						</span>`);
					});
				}

				if($('input[name="obsEducator_'+mediano+'[]"]').length){
					//if file educator tags already exists
					$('input[name="obsEducator_'+mediano+'[]"]').each(function(){
						$(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan">
						    <img src="https://via.placeholder.com/50">
						    <span style="color: #6E519D;">`+$(this).data("name")+`</span>
						</span>`);
					});
				}

				if($('input[name="obsCaption_'+mediano+'"]').length){
					//if file caption already exists
					$(".tags-sec-"+integer).append(`<div class='caption'> `+$('input[name="obsCaption_'+mediano+'"]').val()+` </div>`);
				}
			}else if(origin=="UPLOADED"){
				//if it comes from the uploaded media
				let mediano = $(this).data('mediaid');
				let loadAjax = 0;
				if($('input[name="upl-media-tags-child'+mediano+'[]"]').length){
					//if file child tags already exists
					$('input[name="upl-media-tags-child'+mediano+'[]"]').each(function(){
						$(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan">
						    <img src="https://via.placeholder.com/50">
						    <span style="color: #3E695A;">`+$(this).data("name")+`</span>
						</span>`);
					});
					loadAjax = 0;
				}else{
					loadAjax = 1;
				}

				if($('input[name="obsEducator_'+mediano+'[]"]').length){
					//if file educator tags already exists
					$('input[name="obsEducator_'+mediano+'[]"]').each(function(){
						$(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan">
						    <img src="https://via.placeholder.com/50">
						    <span style="color: #6E519D;">`+$(this).data("name")+`</span>
						</span>`);
					});
					loadAjax = 0;
				}else{
					loadAjax = 1;
				}

				if($('input[name="obsCaption_'+mediano+'"]').length){
					//if file caption already exists
					$(".tags-sec-"+integer).append(`<div class='caption'> `+$('input[name="obsCaption_'+mediano+'"]').val()+` </div>`);
					loadAjax = 0;
				}else{
					loadAjax = 1;
				}

				if (loadAjax == 1) {
					let urlfortags = "http://localhost/Mykronicle/Media/getMediaTags";
					$.ajax({
				        traditional:true,
				        type: "POST",
				        url: urlfortags,
				        data: {"mediaid":mediano},
				        success: function(msg){
				        	integer = integer - 1;
				            res = jQuery.parseJSON(msg);
				            $(res.ChildTags).each(function(index,element){
				                $(".tags-sec-" + integer + " > .child-tags-"+ integer).append(`<span class="childSpan">
								    <img src="https://via.placeholder.com/50">
								    <span style="color: #3E695A;">` + element.name + `</span>
								</span>`);
				            });
				            $(res.EducatorTags).each(function(index,element){
				               $(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan">
								    <img src="https://via.placeholder.com/50">
								    <span style="color: #6E519D;">`+element.name+`</span>
								</span>`);
				            });
				            $(".tags-sec-"+integer).append(`<div class='caption'> `+res.MediaInfo.caption+` </div>`);
				        }
				    });
				}
			}else if(origin=="OBSERVED"){				
				let mediano = $(this).data('mediaid');
				let urlfortags = "http://localhost/Mykronicle/Observation/getMediaTags";
				$.ajax({
			        traditional:true,
			        type: "POST",
			        url: urlfortags,
			        data: {"mediaid":mediano},
			        success: function(msg){
			        	integer = integer - 1;
			            res = jQuery.parseJSON(msg);
			            $(res.ChildTags).each(function(index,element){
			                $(".tags-sec-" + integer + " > .child-tags-"+ integer).append(`<span class="childSpan">
							    <img src="https://via.placeholder.com/50">
							    <span style="color: #3E695A;">` + element.name + `</span>
							</span>`);
			            });
			            $(res.EducatorTags).each(function(index,element){
			               $(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan">
							    <img src="https://via.placeholder.com/50">
							    <span style="color: #6E519D;">`+element.name+`</span>
							</span>`);
			            });
			            $(".tags-sec-"+integer).append(`<div class='caption'> `+res.MediaInfo.caption+` </div>`);
			        }
			    });
			}else{
				console.log("Not a valid file!");
			}

			integer = integer + 1;
			slider = slider + 1;
		});
	
		//for assessments
		let monSubactivities = [];
		$(".subactivity-box > input:checked").each(function(index,element){
			monSubactivities.push($(this).data('subactid'));
		});

		let monSubActExtras = [];
		$(".extras:checked").each(function(index,element){
			monSubActExtras.push($(this).val());
		});

		let eylfSubActivities = [];
		$(".eylfsubactivity:checked").each(function(index,element){
			eylfSubActivities.push($(this).data("eylfsubactvt"));
		});

		let devMileSub = [];
		$(".devmilesub").each(function(index,element){
			devMileSub.push($(this).data("devsubactid"));
		});

		let devMileExtras = [];
		$(".devextras:checked").each(function(index,element){
			devMileExtras.push($(this).val());
		});

		let urlfortags = "http://localhost/Mykronicle/Observation/getAssessmentPreview";
		$.ajax({
	        traditional:true,
	        type: "POST",
	        url: urlfortags,
	        data: {
	        	"monSubactivity":JSON.stringify(monSubactivities),
	        	"monSubActExtras":JSON.stringify(monSubActExtras),
	        	"eylfSubActivities":JSON.stringify(eylfSubActivities),
	        	"devMileSub":JSON.stringify(devMileSub),
	        	"devMileExtras":JSON.stringify(devMileExtras)
	        },
	        success: function(msg){
	        	// console.log(msg);
	        	res = jQuery.parseJSON(msg);
	        	
	        	j = 1;
	        	k = 1;
	        	$(res.outcomes).each(function(index,element){
	        		if (index == 0) {
	        			$(".eylf-prvw-sub").append('<li class="active"><a href="#eylf'+element.id+'" data-toggle="tab">'+element.title+'</a></li>');
	        			$("#previewEYLF").append('<div class="tab-pane active" id="eylf'+element.id+'"></div>');
	        		}else{
	        			$(".eylf-prvw-sub").append('<li><a href="#eylf'+element.id+'" data-toggle="tab">'+element.title+'</a></li>');
	        			$("#previewEYLF").append('<div class="tab-pane" id="eylf'+element.id+'"></div>');
	        		}
	        		$(element.Activity).each(function(actIndex,actElement){
	        			$("#eylf"+element.id).append('<button type="button" class="divexpand subTab" onclick="subTab();">'+actElement.title+'<span class="pull-right"><span class="material-icons-outlined">expand_more</span><span>&nbsp;Expand</span></span></button>');
	        			$("#eylf"+element.id).append('<div class="divcontent"></div>');
	        			$(actElement.subActivity).each(function(subActIndex,subActElement){
	        				$("#eylf"+element.id+" > .divcontent").append("<p>"+subActElement.title+"</p>");
	        			});
	        		});
	        		
	            });

	            $(res.montessoriSubjects).each(function(index,element){
	        		if (index == 0) {
	        			$(".mon-prv-sub").append('<li class="active"><a href="#mon'+element.idSubject+'" data-toggle="tab">'+element.name+'</a></li>');
	        			$("#previewMontessori").append('<div class="tab-pane active" id="mon'+element.idSubject+'"></div>');
	        		}else{
	        			$(".mon-prv-sub").append('<li><a href="#mon'+element.idSubject+'" data-toggle="tab">'+element.name+'</a></li>');
	        			$("#previewMontessori").append('<div class="tab-pane" id="mon'+element.idSubject+'"></div>');
	        		}
	        		$(element.Activity).each(function(actIndex,actElement){
	        			$("#mon"+element.idSubject).append('<button type="button" class="divexpand subTab">'+actElement.title+'<span class="pull-right"><span class="material-icons-outlined">expand_more</span><span>&nbsp;Expand</span></span></button>');
	        			$("#mon"+element.idSubject).append('<div class="divcontent"></div>');
	        			$(actElement.subActivity).each(function(subActIndex,subActElement){
	        				$("#mon"+element.idSubject+" > .divcontent").append("<h5>"+subActElement.title+"</h5> <p>"+subActElement.subject+"</p>");
	        			});
	        		});
	            });

	            $(res.devMilestone).each(function(index,element){
	        		if (index == 0) {
	        			$(".dev-mil-prv").append('<li class="active"><a href="#dev'+element.id+'" data-toggle="tab">'+element.ageGroup+'</a></li>');
	        			$("#previewMilestones").append('<div class="tab-pane active" id="dev'+element.id+'"></div>');
	        		}else{
	        			$(".dev-mil-prv").append('<li><a href="#dev'+element.id+'" data-toggle="tab">'+element.ageGroup+'</a></li>');
	        			$("#previewMilestones").append('<div class="tab-pane" id="dev'+element.id+'"></div>');
	        		}
	        		$(element.Main).each(function(actIndex,actElement){
	        			$("#dev"+element.id).append('<button type="button" class="divexpand subTab">'+actElement.name+'<span class="pull-right"><span class="material-icons-outlined">expand_more</span><span>&nbsp;Expand</span></span></button>');
	        			$("#dev"+element.id).append('<div class="divcontent"></div>');
	        			$(actElement.Subjects).each(function(subActIndex,subActElement){
	        				$("#dev"+element.id+" > .divcontent").append("<h5>"+subActElement.name+"</h5> <p>"+subActElement.subject+"</p>");
	        			});
	        		});
	            });
	        }
	    });
		
	}



	$("#btn-preview").on("click",function(){
		loadPreview();
		$('.your-class').slick();
	});

	$('#modal-preview').on('shown.bs.modal', function (e) {
	  $('.your-class').slick('setPosition');
	  $('.wrap-modal-slider').addClass('open');
	});

	$('#modal-preview').on('hide.bs.modal', function (e) {	  
	    $('.your-class').slick("unslick");
	    $('.your-class').empty();
	    $('.thumbMedia').empty();
	});

	$(document).on("click",'.thumbMedia > span[data-slide]',function(e) {
	    e.preventDefault();
	    var slideno = $(this).data('slide');
	    $('.your-class').slick('slickGoTo', slideno);
	});

	$(document).on("click",".subTab",function(){
		$(this).next(".divcontent").toggle();
	});

});

