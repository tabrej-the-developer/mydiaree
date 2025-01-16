
<?php 

	$data['name']='createReflection'; 
	$this->load->view('header',$data); 
?>
<!-- Observation code use -->
<div class="container-fluid observationListContainer">
	<div class="pageHead" style="margin-top: 20px; margin-bottom:0px;">
		<h1>Reflection</h1>
	</div>
	<ul class="breadcrumb" style="background-color: none !important;">
		<li class=""><a href="#">Add New Reflection</a></li>
	</ul>
    <form action="<?php echo base_url('Reflections/addreflection'); ?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="centerid" value="<?php echo $centerid; ?>">
        <div class="row">
            <div class="row col-sm-9">
                <div class="popdiv row col-sm-6">
                    <span class="poplabel col-sm-12">Children</span>
                    <span class="col-sm-12">
                        
						<select id="Children" name="Children[]" class="popinput js-example-basic-multiple  multiple_selection form-control" multiple="multiple" style="padding: 1.5% 42% !important; margin-left:5%;">
                            <?php foreach($child as $childs => $objchild) { ?>
                                <option name="<?php echo $objchild->name; ?>" value="<?php echo $objchild->childid; ?>"><?php echo $objchild->name; ?></option>
                            <?php }?>
                        </select>
                    </span>
                </div>
                <div class="popdiv row col-sm-6">
                    <span class="poplabel col-sm-12" style="margin-left:5%;">Educators</span>
                    <span class="col-sm-12">
                        <select id="room_educators" name="Educator[]" class="popinput js-example-basic-multiple  multiple_selection form-control" multiple="multiple" style="padding: 1.5% 42% !important; margin-left:5%;">
                            <?php foreach($Educator as $Educators => $objEducator) { ?>
                                <option name="<?php echo $objEducator->name; ?>" value="<?php echo $objEducator->userid; ?>"><?php echo $objEducator->name; ?></option>
                            <?php }?>
                        </select>
                    </span>
                </div>
                <div class="title-reflection" style="margin-left:15px; margin-top:20px;">
                    <div class="form-group" style="margin-top:1%;">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control title" id="title">
                    </div>
                    <div class="form-group">
                        <label for="about">Reflection</label>
                        <textarea name="about" class="form-control about rounded-1" id="about" rows="10" style="height:500px;"></textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-3" style="margin-top:1%;height:670px;background-color:white;border: 1px dashed var(--grey5); margin-left:1%;">
            <label class="file-upload-field" for="fileUpload" style="margin-top:3%;"><span class="material-icons-outlined">add</span><span>Upload</span>
            <input type="file" name="media[]" id="fileUpload" class="form-control-hidden" multiple></label>
            </div>
			<div >
			<div class="row">
            <div class="col-sm-9"></div>
            <div class="col-sm-3">
                <input type="radio" name="status" class="btn btn-success" id="status" value="PUBLISHED"><label for="PUBLISHED">PUBLISHED</label>
                <input type="radio" name="status" class="btn btn-warning" id="status" value="DRAFT"><label for="DRAFT">DRAFT</label>
            </div>
            <div class="col-sm-2"></div>
        </div>
			</div>
			
        </div>
        <div class="row" style="margin-top:1%;">
        <div class="col-sm-9"></div>
        <button class="btn col-sm-1" style="width:7%;margin-right:1%;"><a href="<?php echo base_url('Reflections/getUserReflections'); ?>">CLOSE</button>
        <button class="btn btn-primary col-sm-1" type="submit" style="width:7%;color: #fff !important;background-color: #337ab7 !important;border-color: #2e6da4 !important;">SAVE</button>
        </div>
    </form>
</div>
<!-- end observation code -->
<!-- <php echo base_url('Reflections/getForm?id=' . $room->id); ?> -->

<?php $this->load->view('footer'); ?>
<script>
	function updImg()
	{
		$("#uploadImg").click();
	}

	$("#uploadImg").change(function() {
	  readURL(this);
	});

	function readURL(input) {
	  if (input.files && input.files[0]) {
	    var reader = new FileReader();	    
	    reader.onload = function(e) {
	      $('#blah').attr('src', e.target.result);
	    }	    
	    reader.readAsDataURL(input.files[0]); // convert to base64 string
	  }
	}

	var id="<?php echo $id; ?>";
	var childId="<?php echo $childId; ?>";
	function saveChild()
	{
		var json=true;
		if($("input[name=firstname]").val()=='')
		{
			json=false;
			$('.error_firstname').html('(Please Enter Firstname)');
		}else{
			$('.error_firstname').html('');
		}
		if($("input[name=lastname]").val()=='')
		{
			json=false;
			$('.error_lastname').html('(Please Enter Lastname)');
		}else{
			$('.error_lastname').html('');
		}
		if($("input[name=dob]").val()=='')
		{
			json=false;
			$('.error_dob').html('(Please Select Date of Birth)');
		}else{
			$('.error_dob').html('');
		}
		if($("input[name=startDate]").val()=='')
		{
			json=false;
			$('.error_doj').html('(Please Select Date of Join)');
		}else{
			$('.error_doj').html('');
		}
		if(json)
		{
			if(childId)
			{
				var url="<?php echo base_url('room/editChild'); ?>?id="+id+"&childId="+childId;
				var test= url.replace(/&amp;/g, '&');
				document.getElementById("form-child").action =test;
				document.getElementById("form-child").submit();
				
			}else{
				var url="<?php echo base_url('room/addChild'); ?>?id="+id;
				var test= url.replace(/&amp;/g, '&');
				document.getElementById("form-child").action =test;
				document.getElementById("form-child").submit();
			}
			
		}
	}
	$(document.body).delegate('.viewarea', 'click', function() {
		if($(this).hasClass("active"))
		{
			$(this).removeClass("active");
			$('.imgview').html('<img    src="<?php echo base_url('assets/images/icons/DownArrowBule.png'); ?>">');
			$('.moredetails').hide();
		}else{
			$(this).addClass("active");
			$('.imgview').html('<img    src="<?php echo base_url('assets/images/icons/UpArrowBule.png'); ?>">');
			$('.moredetails').show();
		}
      });

</script>