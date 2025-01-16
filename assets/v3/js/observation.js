$(document).ready(function(){
	
	//load preview function for add/edit observation form
	function loadPreview(){
		//get values from the observation form to show on the preview modal
		
		let obsTitle = CKEDITOR.instances.obs_title.document.getBody().getText();
		let obsAuthor = $("#obs_author").val();
		var editorText = CKEDITOR.instances.obs_notes.getData();
		let obsReflection = CKEDITOR.instances.obs_reflection.getData();

		$("#obsPreviewTitle").html(obsTitle);
		$("#obsPreviewAuthor").text(obsAuthor);
		$("#obsNotes").html(editorText);
		$("#obsReflection").html(obsReflection);
		$(".obsChildrenItem").remove();
		$("input[name='childrens[]']").each(function(){
			$("#obsChildren").append(`
				<div class="col-md-4 obsChildrenItem">
				    <div class="card d-flex flex-row mb-4">
				        <a class="d-flex" href="#">
				            <img alt="Profile" src="https://via.placeholder.com/50" class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
				        </a>
				        <div class=" d-flex flex-grow-1 min-width-zero">
				            <div class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
				                <div class="min-width-zero">
				                    <a href="#">
				                        <p class="list-item-heading mb-1 truncate">`+$(this).data("name")+`</p>
				                    </a>
				                    <button type="button" class="btn btn-xs btn-outline-primary ">View</button>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
			`);
		});

		//for sliders
		let integer = 1;
		let slider = 0;
		$(".img-preview").each(function(index,el) {
			let image = $(this).find("img").attr("src");
			$(".your-class").append(`
				<div>
					<img src='`+image+`' class='modal-slider-image'>
					<div class="tags-section tags-sec-`+integer+`">
                        <div class="child-tags child-tags-`+integer+`">
	                                        
                        </div>
                    </div>
                </div>
            `);
			$(".thumbMedia").append('<span data-slide="'+slider+'"><img src="'+image+'" width="70" height="70"></span>');
			//check origin
			let origin = $(this).data('origin');
			if (origin=="NEW") {
				//if it is a local file
				let mediano = $(this).data('fileno');

				if($('input[name="obsImage_'+mediano+'[]"]').length){
					//if file child tags already exists
					$('input[name="obsImage_'+mediano+'[]"]').each(function(){
						$(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan child-info-tag">
						    <img src="https://via.placeholder.com/30" class="rounded">
						    <span>`+$(this).data("name")+`</span>
						</span>`);
					});
				}

				if($('input[name="obsEducator_'+mediano+'[]"]').length){
					//if file educator tags already exists
					$('input[name="obsEducator_'+mediano+'[]"]').each(function(){
						$(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan educator-info-tag">
						    <img src="https://via.placeholder.com/30" class="rounded">
						    <span>`+$(this).data("name")+`</span>
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
						$(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan child-info-tag">
						    <img src="https://via.placeholder.com/30" class="rounded">
						    <span>`+$(this).data("name")+`</span>
						</span>`);
					});
					loadAjax = 0;
				}else{
					loadAjax = 1;
				}

				if($('input[name="obsEducator_'+mediano+'[]"]').length){
					//if file educator tags already exists
					$('input[name="obsEducator_'+mediano+'[]"]').each(function(){
						$(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan educator-info-tag">
						    <img src="https://via.placeholder.com/30" class="rounded">
						    <span>`+$(this).data("name")+`</span>
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
				                $(".tags-sec-" + integer + " > .child-tags-"+ integer).append(`<span class="childSpan child-info-tag">
								    <img src="https://via.placeholder.com/30" class="rounded">
								    <span>` + element.name + `</span>
								</span>`);
				            });
				            $(res.EducatorTags).each(function(index,element){
				               $(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan educator-info-tag">
								    <img src="https://via.placeholder.com/30" class="rounded">
								    <span>`+element.name+`</span>
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
			                $(".tags-sec-" + integer + " > .child-tags-"+ integer).append(`<span class="childSpan child-info-tag">
							    <img src="https://via.placeholder.com/30" class="rounded">
							    <span>` + element.name + `</span>
							</span>`);
			            });
			            $(res.EducatorTags).each(function(index,element){
			               $(".tags-sec-"+integer+" > .child-tags-"+integer).append(`<span class="childSpan educator-info-tag">
							    <img src="https://via.placeholder.com/30" class="rounded">
							    <span>`+element.name+`</span>
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
		$("input.mon-sub:checked").each(function(index,element){
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
	        	
	        	res = jQuery.parseJSON(msg);
	        	
	        	
	        	j = 1;
	        	k = 1;
	        	$(".eylf-prvw-sub").empty();
        		$("#previewEYLF").empty();
        		$(".mon-prv-sub").empty();
	        	$("#previewMontessori").empty();
	        	$(".dev-prv-sub").empty();
	        	$("#previewDevMile").empty();
	        	/* Block for EYLF preview */
	        	$(res.outcomes).each(function(index, element){
	        		if (index == 0) {
	        			$(".eylf-prvw-sub").append(`
	        				<a class="btn btn-primary mb-1" data-toggle="collapse" href="#prvEylf`+element.id+`" role="button" aria-expanded="true" aria-controls="multiCollapseExample1">`+element.title+`</a>
	        			`);
	        			$("#previewEYLF").append(`
	        				<div class="collapse multi-collapse show" id="prvEylf`+element.id+`">
	        					<div class="card mb-2">
	        						<div class="card-body" id="accordionPrvEylf-`+element.id+`">
			        					<h3 class="card-title mb-0">`+element.title+`</h3>
			        					<p class="text-muted">`+element.name+`</p>
			        				</div>
	        					</div>
	        				</div>
	        			`);
	        		}else{
	        			$(".eylf-prvw-sub").append(`
	        				<a class="btn btn-primary mb-1" data-toggle="collapse" href="#prvEylf`+element.id+`" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">`+element.title+`</a>
	        			`);
	        			$("#previewEYLF").append(`
	        				<div class="collapse multi-collapse" id="prvEylf`+element.id+`">
	        					<div class="card mb-2">
	        						<div class="card-body" id="accordionPrvEylf-`+element.id+`">
			        					<h3 class="card-title mb-0">`+element.title+`</h3>
			        					<p class="text-muted">`+element.name+`</p>
			        				</div>
	        					</div>
	        				</div>
	        			`);
	        		}
	        		$(element.Activity).each(function(actIndex, actElement){
	        			let _eylfSubActPrv = "";
	        			$.each(actElement.subActivity, function(eylfSubActIndex, eylfSubActVal) {
	        				_eylfSubActPrv = _eylfSubActPrv + `<p>`+eylfSubActVal.title+`</p>`;
	        			});

	        			if (actIndex == 0) {
	        				$('#accordionPrvEylf-' + element.id).append(`
	        					<div class="border">
                                    <button class="btn btn-link text-left" data-toggle="collapse" data-target="#eylfActivity-` + actElement.id + `" aria-expanded="true" aria-controls="eylfActivity-` + actElement.id + `">
                                        ` + actElement.title + `
                                    </button>
                                    <div id="eylfActivity-` + actElement.id + `" class="collapse show" data-parent="#accordionPrvEylf-` + element.id + `">
                                        <div class="p-4">
                                            ` + _eylfSubActPrv + `
                                        </div>
                                    </div>
                                </div>
	        				`);
	        			} else {
	        				$('#accordionPrvEylf-' + element.id).append(`
	        					<div class="border">
                                    <button class="btn btn-link text-left" data-toggle="collapse" data-target="#eylfActivity-` + actElement.id + `" aria-expanded="false" aria-controls="eylfActivity-` + actElement.id + `">
                                        ` + actElement.title + `
                                    </button>
                                    <div id="eylfActivity-` + actElement.id + `" class="collapse" data-parent="#accordionPrvEylf-` + element.id + `">
                                        <div class="p-4">
                                            ` + _eylfSubActPrv + `
                                        </div>
                                    </div>
                                </div>
	        				`);
	        			}
	        		});	
	            });
	        	/* Block for EYLF preview end */

	        	/* Block for Montessori preview */
	            $(res.montessoriSubjects).each(function(index, element){
	        		if (index == 0) {
	        			$(".mon-prv-sub").append(`
	        				<a class="btn btn-primary mb-1" data-toggle="collapse" href="#mon` + element.idSubject + `" role="button" aria-expanded="true" aria-controls="montessoriCollapseExample">`+element.name+`</a>
	        			`);

	        			$("#previewMontessori").append(`
	        				<div class="collapse multi-collapse show" id="mon`+element.idSubject+`">
	        					<div class="card mb-2">
	        						<div class="card-body" id="accordionPrvMon-`+element.idSubject+`">
			        					<h3 class="card-title mb-0">`+element.name+`</h3>
			        				</div>
	        					</div>
	        				</div>
	        			`);
	        		}else{
	        			$(".mon-prv-sub").append(`
	        				<a class="btn btn-primary mb-1" data-toggle="collapse" href="#mon` + element.idSubject + `" role="button" aria-expanded="false" aria-controls="montessoriCollapseExample">`+element.name+`</a>
	        			`);

	        			$("#previewMontessori").append(`
	        				<div class="collapse multi-collapse" id="mon`+element.idSubject+`">
	        					<div class="card mb-2">
	        						<div class="card-body" id="accordionPrvMon-`+element.idSubject+`">
			        					<h3 class="card-title mb-0">`+element.name+`</h3>
			        				</div>
	        					</div>
	        				</div>
	        			`);
	        		}
	        		$(element.Activity).each(function(actIndex,actElement){	        			
	        			let _monSubActPrv = "";
	        			$.each(actElement.subActivity, function(monSubActindex, monSubActVal) {
	        				_monSubActPrv = _monSubActPrv + `<p>` + monSubActVal.title + `</p>`;
	        			});
	        			if (actIndex == 0) {
	        				$('#accordionPrvMon-' + element.idSubject).append(`
	        					<div class="border mt-3">
                                    <button class="btn btn-link text-left" data-toggle="collapse" data-target="#monActivity-` + actElement.idActivity + `" aria-expanded="true" aria-controls="monActivity-` + actElement.idActivity + `">
                                        ` + actElement.title + `
                                    </button>
                                    <div id="monActivity-` + actElement.idActivity + `" class="collapse show" data-parent="#accordionPrvMon-` + element.idSubject + `">
                                        <div class="p-4">
                                            ` + _monSubActPrv + `
                                        </div>
                                    </div>
                                </div>
	        				`);
	        			} else {
	        				$('#accordionPrvMon-' + element.idSubject).append(`
	        					<div class="border">
                                    <button class="btn btn-link text-left" data-toggle="collapse" data-target="#monActivity-` + actElement.idActivity + `" aria-expanded="false" aria-controls="monActivity-` + actElement.idActivity + `">
                                        ` + actElement.title + `
                                    </button>
                                    <div id="monActivity-` + actElement.idActivity + `" class="collapse" data-parent="#accordionPrvMon-` + element.idSubject + `">
                                        <div class="p-4">
                                            ` + _monSubActPrv + `
                                        </div>
                                    </div>
                                </div>
	        				`);
	        			}
	        		});
	            });
	            /* Block for Montessori preview end */

	            /* Block for Devmile preview */
	            $(res.devMilestone).each(function(index,element){

	        		if (index == 0) {
	        			$(".dev-mil-prv").append(`
	        				<a class="btn btn-primary mb-1" data-toggle="collapse" href="#dev` + element.id + `" role="button" aria-expanded="true" aria-controls="devmileCollapseExample">`+element.ageGroup+`</a>
	        			`);

	        			$("#previewDevMile").append(`
	        				<div class="collapse multi-collapse show" id="dev`+element.id+`">
	        					<div class="card mb-2">
	        						<div class="card-body" id="accordionPrvDev-`+element.id+`">
			        					<h3 class="card-title mb-0">`+element.ageGroup+`</h3>
			        				</div>
	        					</div>
	        				</div>
	        			`);
	        		}else{
	        			$(".dev-mil-prv").append(`
	        				<a class="btn btn-primary mb-1" data-toggle="collapse" href="#dev` + element.id + `" role="button" aria-expanded="false" aria-controls="devmileCollapseExample">`+element.ageGroup+`</a>
	        			`);

	        			$("#previewDevMile").append(`
	        				<div class="collapse multi-collapse" id="dev`+element.id+`">
	        					<div class="card mb-2">
	        						<div class="card-body" id="accordionPrvDev-`+element.id+`">
			        					<h3 class="card-title mb-0">`+element.ageGroup+`</h3>
			        				</div>
	        					</div>
	        				</div>
	        			`);
	        		}

	        		$(element.Main).each(function(actIndex,actElement){

	        			let _devSubActPrv = "";

	        			$(actElement.Subjects).each(function(subActIndex,subActElement){
	        				_devSubActPrv = _devSubActPrv + `<div>` + subActElement.name + `</div><p>` + subActElement.subject + `</p>`;
	        			});

	        			if(actIndex == 0){
	        				$("#accordionPrvDev-" + element.id).append(`
	        					<div class="border mt-3">
                                    <button class="btn btn-link text-left" data-toggle="collapse" data-target="#devActivity-` + actElement.id + `" aria-expanded="true" aria-controls="devActivity-` + actElement.id + `">
                                        ` + actElement.name + `
                                    </button>
                                    <div id="devActivity-` + actElement.id + `" class="collapse show" data-parent="#accordionPrvDev-` + element.id + `">
                                        <div class="p-4">
                                            `+_devSubActPrv+`
                                        </div>
                                    </div>
                                </div>
	        				`);
	        			}else{
	        				$("#accordionPrvDev-" + element.id).append(`
	        					<div class="border mt-3">
                                    <button class="btn btn-link text-left" data-toggle="collapse" data-target="#devActivity-` + actElement.id + `" aria-expanded="false" aria-controls="devActivity-` + actElement.id + `">
                                        ` + actElement.name + `
                                    </button>
                                    <div id="devActivity-` + actElement.id + `" class="collapse" data-parent="#accordionPrvDev-` + element.id + `">
                                        <div class="p-4">
                                            `+_devSubActPrv+`
                                        </div>
                                    </div>
                                </div>
	        				`);
	        			}
	        		});
	            });
	            /* Block for Devmile preview end */
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

