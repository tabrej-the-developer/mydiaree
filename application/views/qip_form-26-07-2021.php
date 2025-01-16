<?php $data['name']='Quality Improvment Plan(QIP)'; $this->load->view('header',$data); ?>

<div class="container addQipListContainer">
	<div class="pageHead">
		<h1>Quality Improvment Plan(QIP)</h1>		
	</div>

	<div class="totalFlex">
		<div class="flexField">
			<div class="spantext">Select Quality Area</div>
			<div class="spanleft">
				<select class="form-control" name="area" id="area" style="">
					<option value="">--Select--</option>
					<?php $i=1; foreach($areas as $area) { ?>
					<?php if($id && $i==1) { ?>
					<option value="<?php echo $area->id; ?>" selected><?php echo $area->title; ?></option>
					<?php } else { ?>
					<option value="<?php echo $area->id; ?>"><?php echo $area->title; ?></option>
					<?php } ?>
					
					<?php $i++; } ?>
					
				</select>
				<form action="" id="centerDropdown">
					<select name="centerid" id="centerId" class="form-control">
						<?php 
							$dupArr = [];
							foreach ($this->session->userdata("centerIds") as $key => $center){
								if ( ! in_array($center, $dupArr)) {
									if (isset($_GET['centerid']) && $_GET['centerid'] != "" && $_GET['centerid']==$center->id) {
						?>
						<option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
						<?php }else{ ?>
						<option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
						<?php
									}
								}
								array_push($dupArr, $center);
							}
						?>
					</select>
				</form>
			</div>
		</div>

		<?php if(isset($id)) { ?>
			<div class="printButtonDiv">
				<?php 
					$role = $this->session->userdata('UserType');
					if ($role=="Staff") {
						if (isset($permissions)) {
							if ($permissions->printQIP == 1) {
								$printQIP = 1;
							} else {
								$printQIP = 0;
							}

							if ($permissions->mailQIP == 1) {
								$mailQIP = 1;
							} else {
								$mailQIP = 0;
							}					
						}else {
							$printQIP = 0;
							$mailQIP = 0;				
						}
					} else {
						$printQIP = 1;
						$mailQIP = 1;			
					}

					if ($printQIP==1) {
				?>
				<button type="button" data-toggle="modal"  data-target="#modal-print" class="btn btn-small btnBlue qipbtn">
				<span class="material-icons-outlined">print</span> &nbsp; Print 
				</button>
				<?php
					}
					
					if ($mailQIP==1) {
				?>
				<button type="button" data-toggle="modal" data-target="#modal-email" class="btn btn-small btnGreen qipbtn">
				<span class="material-icons-outlined">email</span> &nbsp; Email
				</button>
				<?php } ?>
			</div>
				<div class="modal fade" id="modal-print" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="material-icons-outlined">close</span></button>
							<form action="" id="form-print" method="post" enctype="multipart/form-data">
							<table class="qipprinttable">
								<thead>
									<tr><td>Areas</td><td>Standards</td><td>Improvement  Plan</td></tr>
								</thead>
								<tbody>
									<?php foreach($previews as $preview) { ?>
									<tr><td><span><input class="check_area" type="checkbox" name="areas[]" value="<?php echo $preview->areaId; ?>"><?php echo $preview->areaName; ?></span></td>
									<td>
									<span><input disabled value="" id="<?php echo $preview->areaId; ?>s"  class="selectall <?php echo $preview->areaId; ?>" type="checkbox">Select All</span></br>
									<?php foreach($preview->standards as $standard) { ?>
									<span><input val="<?php echo $preview->areaId; ?>" disabled class="<?php echo $preview->areaId; ?> <?php echo $preview->areaId; ?>s standards" name="sta[<?php echo $preview->areaId; ?>][]" value="<?php echo $standard->id; ?>" type="checkbox"><?php echo $standard->name.'-'.$standard->about; ?></span></br>
									<?php } ?></td>
									<td><input disabled class="<?php echo $preview->areaId; ?>" name="plan[]" value="<?php echo $preview->areaId; ?>" type="checkbox"></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							</br><button type="button" onclick="print();"  target="_blank" class="btn btn-default btnBlue pull-right">Submit</button>
							</form>
						</div>
					</div>
				</div>
				</div>
				<div class="modal fade" id="modal-email" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-body">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="material-icons-outlined">close</span></button>
							<form action="" id="form-email" method="post" enctype="multipart/form-data">
								<span class="qipemail"><span class="qipema">Email :- </span><span class=""> &nbsp; <input type="text" name="email" id="email" value="" class="qipinu" /></span></span></br>
							<table class="qipprinttable">
								<thead>
									<tr><td>Areas</td><td>Standards</td><td>Improvement  Plan</td></tr>
								</thead>
								<tbody>
									<?php foreach($previews as $preview) { ?>
									<tr><td><span><input class="check_area" type="checkbox" name="areas[]" value="<?php echo $preview->areaId; ?>"><?php echo $preview->areaName; ?></span></td>
									<td>
									<span><input disabled value="" id="<?php echo $preview->areaId; ?>s"  class="selectall <?php echo $preview->areaId; ?>" type="checkbox">Select All</span></br>
									<?php foreach($preview->standards as $standard) { ?>
									<span><input val="<?php echo $preview->areaId; ?>" disabled class="<?php echo $preview->areaId; ?> <?php echo $preview->areaId; ?>s standards" name="sta[<?php echo $preview->areaId; ?>][]" value="<?php echo $standard->id; ?>" type="checkbox"><?php echo $standard->name.'-'.$standard->about; ?></span></br>
									<?php } ?></td>
									<td><input disabled class="<?php echo $preview->areaId; ?>" name="plan[]" value="<?php echo $preview->areaId; ?>" type="checkbox"></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							</br><button type="button" onclick="sendemail();"  target="_blank" class="btn btn-info pull-right">Submit</button>
							</form>
						</div>
					</div>
				</div>
				</div>
								
		<?php } ?>

	</div>

	  <div class="qip">
		<?php if(isset($id)) { ?>
	
		<?php } else { ?>
		<div class="folderform">
			<img   src="<?php echo base_url('assets/images/icons/folder.png'); ?>">
			</br></br>
			<span>Please select quality area to continue</span>
		</div>
		<?php } ?>
	</div>
</div>


<?php $this->load->view('footer'); ?>
<script>
	var id='<?php echo isset($id)?$id:null; ?>';
    function print()
	{
		
		var url="<?php echo base_url('qip/printPdf'); ?>?id="+id;
		var test= url.replace(/&amp;/g, '&');
		document.getElementById("form-print").action =test;
		document.getElementById("form-print").submit();
	}
	function sendemail()
	{
		if($('#email').val()=='')
		{
			alert('Please Enter Email');
			return false
		}
		var url="<?php echo base_url('qip/email'); ?>?id="+id;
		var test= url.replace(/&amp;/g, '&');
		document.getElementById("form-email").action =test;
		document.getElementById("form-email").submit();
	}
	$('.check_area').click(function(){
		var val=$(this).val();
	  if($(this).prop("checked") == true)
	  {
		$('.'+val).removeAttr("disabled");
	  }else{
		$('.'+val).attr("disabled", true);
		$('.'+val).prop('checked', false);
	  }
	});
	$('.selectall').click(function(){
		var val=$(this).attr('id');
	  if($(this).prop("checked") == true)
	  {
		$('.'+val).prop('checked', true);
	  }else{
		$('.'+val).prop('checked', false);
	  }
	});
	$('.standards').click(function(){
		var val=$(this).attr('val');
		var count=0;
		$('.'+val+'s').each(function(){
		if($(this).prop("checked") == true)
	    {
			count++;
		}
		});
		var len=$('.'+val+'s').length;
		
		if(len==count)
		{
			
			$('#'+val+'s').prop('checked', true);
		}else{
			$('#'+val+'s').prop('checked', false);
		}
		//alert(val);
	});
	
	if(id)
	{
		getData();
	}
	function getData()
	{
		var areaId=$('#area').val();
		var name=$('option:selected','#area').text();
		var center = $("#centerId").val();
		var url='<?php echo base_url(); ?>qip/getAreaDetails?id='+areaId+'&qipId='+id;
		$.ajax({
		   type:'POST',
		   url: url,
		   data:'data=',
		   datatype:'json',
		   success: function(json) {
			json=JSON.parse(json);
			var msg='<form action="" id="form-qip" method="post" enctype="multipart/form-data">'+
		            '<span class="qipspanview">View about <span class="viewarea">'+name+' <span class="imgview"><!--<img src="<?php // echo base_url('assets/images/icons/DownArrowBule.png'); ?>">--><span class="material-icons-outlined">arrow_drop_down</span></span></span></span>';
			msg+='<input type="hidden" name="centerid" value="'+center+'"><div class="divview borderTopView" style="display:none;"><span class="qiphide">'+json.area.about+'</span>'+
			     '<span class="spantitle">Standards and elements</span>'+
				 '<table class="areatable"><tobdy>';
				 $.each(json.standards,function(key,standard){
				 msg+='<tr class="trbule"><td>'+standard.name+'</td><td colspan="2">'+standard.about+'</td></tr>';
				 $.each(standard.elements,function(key,element){
					 msg+='<tr class="trwhite"><td style="width:20%;">'+element.name+'</td><td style="width:10%;">'+element.elementName+'</td><td >'+element.about+'</td></tr>';
				 });
				 });
				 msg+='</tbody></table><span class="spantitle">National Law and National Regulations underpinning Quality Area 1</span>'+
				 '<table class="areatable"><tobdy>'+
				 '<tr class="trbule"><td style="padding-left:10px;" >National Law and National Regulations </td><td ></td>'+
				 '<td style="text-align:center">Associated element</td></tr>';
				 $.each(json.laws,function(key,law){
					msg+='<tr class="trwhite"><td style="padding-left:10px;">'+law.section+'</td>'+
					'<td style="padding-left:20px;">'+law.about+'</td><td style="text-align:center">'+law.element+'</td></tr>';
				 });
				 msg+='</tbody></table></br></br></div>'+
			     '<div class="divview1" ><span class="qipsum">Name:- '+json.name+'<input type="hidden" name="name" value="'+json.name+'" >'+
			     '<input type="hidden" name="areaid" value="'+areaId+'" ></span></br>';
			msg+='<span class="qipsum">Summary of strengths for '+name+'</span><span class="qipstr">Strengths'+
			    '</br></br><textarea name="strength" id="editor1" rows="10" cols="80">';
				if(typeof json.areavalues !='undefined' && json.areavalues !== null)
				{
				msg+=json.areavalues.strength;	
				}
			msg+='</textarea></span>';
			$.each(json.standards,function(key,standard){
				var val=(standard.id).toString();
				msg+='<span class="spantitle">'+standard.name+'-'+standard.about+'</span><span  class="exceeding">Exceeding themes</span></br>';
				
				
					msg+='<span class="spansubtitle">1. Practice is embedded in service operations</span>';
					msg+='<textarea name="elements['+standard.id+'][val1]" style="margin: 0px -2px 0px 0px; height: 93px; width: 1203px;" placeholder="[If you have identified strengths in this area, describe how your practices are embedded in service operations for this Standard]" class="form-control textarea">';
					
					if(typeof json.values !='undefined' && json.values !== null)
					{
						var v=json.values[val];
						if(typeof v !='undefined')
						{
					     msg+=v.val1;	
						}
					}
					msg+='</textarea>';
					msg+='<span class="spansubtitle">2. Practice is informed by critical reflection</span>';
					msg+='<textarea name="elements['+standard.id+'][val2]" style="margin: 0px -2px 0px 0px; height: 93px; width: 1203px;" placeholder="[If you have identified strengths in this area, describe how your services practices in this Standard, have been informed by critical reflection.]" class="form-control textarea">';
					if(typeof json.values !='undefined' && json.values !== null)
					{
						var v=json.values[val];
						if(typeof v !='undefined')
						{
					      msg+=v.val2;
						}
					}
					msg+='</textarea>';
					msg+='<span class="spansubtitle">3. Practice is shaped by meaningful engagement with families, and/or community</span>';
					msg+='<textarea name="elements['+standard.id+'][val3]" style="margin: 0px -2px 0px 0px; height: 93px; width: 1203px;" placeholder="[If you have identified strengths in this area, describe how your services practices in this Standard, have been shaped by meaningful engagement with families, and/or community]" class="form-control textarea">';
					if(typeof json.values !='undefined' && json.values !== null)
					{
					   var v=json.values[val];
						if(typeof v !='undefined')
						{
					      msg+=v.val3;
						}
					}
					msg+='</textarea>';
					
			});
			msg+='<span class="qipkey">Key improvements sought for Quality Area 1</span><span class="qipplan">Improvement  Plan</span>';
			msg+='<table class="qiptable"><thead><tr><th style="text-align:center;">Standard/</br>element</th>'+
			     '<th style="text-align:right;">Issue identified </br>during self-assessment</th>'+
			     '<th style="text-align:right;">What outcome or </br>goal do we seek?</th><th style="text-align:center;">Priority (L/M/H)</th>'+
				 '<th style="text-align:right;">How will we get this </br>outcome? (Steps)</th>'+
				 '<th style="text-align:center;">Success measure</th><th style="text-align:center;">By when?</th>'+
				 '<th style="text-align:center;">Progress notes</th></tr></thead>'+
				 '<tbody>';
				 if(typeof json.planes !='undefined' && json.planes.length!==0)
				{
					var i=1;
					$.each(json.planes,function(key1,plane){
					msg+='<tr class="qiptr" id="tbody_qip1">'+
					        '<td><textarea name="plan['+i+'][standard]" class="form-control">'+plane.standard+'</textarea></td>'+
							'<td><textarea name="plan['+i+'][issue]" class="form-control">'+plane.issue+'</textarea></td>'+
							'<td><textarea name="plan['+i+'][outcome]" class="form-control">'+plane.outcome+'</textarea></td>'+
							'<td><textarea name="plan['+i+'][priority]" class="form-control">'+plane.priority+'</textarea></td>'+
							'<td><textarea name="plan['+i+'][outcome_step]" class="form-control">'+plane.outcome_step+'</textarea></td>'+
							'<td><textarea name="plan['+i+'][measure]" class="form-control">'+plane.measure+'</textarea></td>'+
							'<td><textarea name="plan['+i+'][by_when]" class="form-control">'+plane.by_when+'</textarea></td>'+
							'<td><textarea name="plan['+i+'][progress]" class="form-control">'+plane.progress+'</textarea></td></tr>';
							i++;
					});
				}else{
					 msg+='<tr class="qiptr" id="tbody_qip1"><td><textarea name="plan[1][standard]" class="form-control"></textarea></td>'+
							'<td><textarea name="plan[1][issue]" class="form-control"></textarea></td>'+
							'<td><textarea name="plan[1][outcome]" class="form-control"></textarea></td>'+
							'<td><textarea name="plan[1][priority]" class="form-control"></textarea></td>'+
							'<td><textarea name="plan[1][outcome_step]" class="form-control"></textarea></td>'+
							'<td><textarea name="plan[1][measure]" class="form-control"></textarea></td>'+
							'<td><textarea name="plan[1][by_when]" class="form-control"></textarea></td>'+
							'<td><textarea name="plan[1][progress]" class="form-control"></textarea></td></tr>';
				}
				
			msg+='</tbody></table>';
		    msg+='<a onclick="item();" class="btn btn-default btnBlue pull-right qipa"><img style="height: 14.96px;width: 15.12px;" class="circleimage" src="<?php echo base_url('assets/images/icons/puls.png'); ?>" > Add New</a>';
			msg+='</br></br></br><span style="float:right;"><span><a href="<?php echo base_url('qip'); ?>" class="btn btn-default">Cancel</a><span>';
			     if(id)
				 {
			msg+='<span style="padding:0px 0px 0px 10px;"><button type="button" class="btn btn-default btn-preview btnBlue" data-toggle="modal" data-target="#modal-clean">Preview</button></span>';
				 }
				 
			     msg+='<span style="padding:10px;"><button type="button" onclick="saveQip();"  class="btn btn-default btnGreen">Save</button></span></span></div></form>';
				 
				 if(id)
				 {
					msg+='<div class="modal fade" id="modal-clean" tabindex="-1" role="dialog">'+
					    '<div class="modal-dialog" role="document">'+
						'<div class="modal-content">'+
						'<div class="modal-body">'+
						'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="material-icons-outlined">close</span></button>';
						$.each(json.previews,function(key,preview){
					     msg+='<span class="qipsum">'+preview.areaName+'</span></br>';
						 msg+='<span class="qipsum">Summary of strengths for '+preview.areaName+'</span><span class="qipstr">Strengths:-'+preview.strength+'</span>';
						 $.each(preview.standards,function(key,standard){
							var val=(standard.id).toString();
							msg+='<span class="spantitle">'+standard.name+'-'+standard.about+'</span><span  class="exceeding">Exceeding themes</span></br>';
				
				
							msg+='<span class="spansubtitle">1. Practice is embedded in service operations</span></br>';
							
							if(typeof json.values !='undefined' && json.values !== null)
							{
								var v=json.values[val];
								if(typeof v !='undefined')
								{
								 msg+=v.val1+'</br>';	
								}
								
							}
							msg+='<span class="spansubtitle">2. Practice is informed by critical reflection</span></br>';
							if(typeof json.values !='undefined' && json.values !== null)
							{
								var v=json.values[val];
								if(typeof v !='undefined')
								{
								  msg+=v.val2+'</br>';
								}
							}
							msg+='<span class="spansubtitle">3. Practice is shaped by meaningful engagement with families, and/or community</span></br>';
							if(typeof json.values !='undefined' && json.values !== null)
							{
							   var v=json.values[val];
								if(typeof v !='undefined')
								{
								  msg+=v.val3+'</br>';
								}
							}
						 });
						    msg+='<span class="qipkey">Key improvements sought for Quality Area 1</span><span class="qipplan">Improvement  Plan</span>';
							msg+='<table class="qiptable"><thead><tr><th style="text-align:center;">Standard/</br>element</th>'+
								 '<th style="text-align:right;">Issue identified </br>during self-assessment</th>'+
								 '<th style="text-align:right;">What outcome or </br>goal do we seek?</th><th style="text-align:center;">Priority (L/M/H)</th>'+
								 '<th style="text-align:right;">How will we get this </br>outcome? (Steps)</th>'+
								 '<th style="text-align:center;">Success measure</th><th style="text-align:center;">By when?</th>'+
								 '<th style="text-align:center;">Progress notes</th></tr></thead>'+
								 '<tbody class="tbodypreview">';
								 if(typeof preview.planes !='undefined' && preview.planes.length!==0)
								{
									$.each(preview.planes,function(key1,plane){
									msg+='<tr >'+
											'<td>'+plane.standard+'</td>'+
											'<td>'+plane.issue+'</td>'+
											'<td>'+plane.outcome+'</td>'+
											'<td>'+plane.priority+'</td>'+
											'<td>'+plane.outcome_step+'</td>'+
											'<td>'+plane.measure+'</td>'+
											'<td>'+plane.by_when+'</td>'+
											'<td>'+plane.progress+'</td></tr>';
									});
								}
								
							msg+='</tbody></table>';
						});
					msg+='</br><?php if (!empty($permissions) && $permissions->downloadQIP==1) { ?><a href="<?php echo base_url('qip/download?id='.$id); ?>" target="_blank" class="btn btn-info pull-right">Download</a><?php } ?>'; 
					msg+='</div>'+
						'</div>'+
						'</div>'+
						'</div>';
                
				 }
			if(msg)
			{
				$('.qip').html(msg);
			}
			summernot();
		   }
		   
		});
	}
	var url='<?php echo base_url(); ?>';
	$('#area').change(function(){
		
		if($(this).val())
		{
			getData();
		}else{
			$('.qip').html('<div class="folderform"><img   src="<?php echo base_url('assets/images/icons/folder.png'); ?>"></br></br>'+
	                       '<span>Please select quality area to continue</span></div></div>');
		}
	});
	function item()
	{
		var len=$('.qiptr').length;
		len+=1;
		
		var msg='<tr class="qiptr" id="tbody_qip'+len+'"><td><textarea name="plan['+len+'][standard]" class="form-control"></textarea></td>'+
					 '<td><textarea name="plan['+len+'][issue]" class="form-control"></textarea></td>'+
					 '<td><textarea name="plan['+len+'][outcome]" class="form-control"></textarea></td>'+
					 '<td><textarea name="plan['+len+'][priority]" class="form-control"></textarea></td>'+
					 '<td><textarea name="plan['+len+'][outcome_step]" class="form-control"></textarea></td>'+
					 '<td><textarea name="plan['+len+'][measure]" class="form-control"></textarea></td>'+
					 '<td><textarea name="plan['+len+'][by_when]" class="form-control"></textarea></td>'+
					 '<td><textarea name="plan['+len+'][progress]" class="form-control"></textarea></td></tr>';
					len=len-1;
		$('#tbody_qip'+len).after(msg);
	}
	function saveQip()
	{
		
		if(id)
	   {
		var url="<?php echo base_url('qip/edit'); ?>?id="+id;
		var test= url.replace(/&amp;/g, '&');
		document.getElementById("form-qip").action =test;
		document.getElementById("form-qip").submit();
	   }else{
	   var url="<?php echo base_url('qip/add'); ?>";
	   var test= url.replace(/&amp;/g, '&');
		document.getElementById("form-qip").action =test;
		document.getElementById("form-qip").submit();
		
	   }
	}
	$(document.body).delegate('.viewarea', 'click', function() {
		if($(this).hasClass("active"))
		{
			$(this).removeClass("active");
			$('.imgview').html('<span class="material-icons-outlined">arrow_drop_down</span>');
			$('.divview').hide();
			$('.divview1').show();
		}else{
			$(this).addClass("active");
			$('.imgview').html('<span class="material-icons-outlined">arrow_drop_up</span>');
			$('.divview').show();
			$('.divview1').hide();
		}
    });
</script>
<script>
	$(document).ready(function(){
		$("#centerId").on('change',function(){
			let centerid = $(this).val();
			<?php  
			      $qs = $_SERVER['QUERY_STRING'];
			      if ($qs == "") {
			?>
			   $("#centerDropdown").submit();
			<?php
			      }else{
			         if (isset($_GET['centerid'])&&$_GET['centerid']!="") {
			            $url = str_replace('centerid='.$_GET['centerid'], 'centerid=', $_SERVER['QUERY_STRING']);
			         } else {
			            $url = $_SERVER['QUERY_STRING']."&centerid=";
			         }
			?>
			      var url = "<?php echo base_url('qip/edit?').$url; ?>"+centerid;
			      var test = url.replace(/&/g, '&');
			      window.location.href=test;
			<?php } ?>
		});
	});
</script>