<?php 
    $reflectionid = $_GET['reflectionid'];
    $data['name']='createReflection'; 
    $this->load->view('header',$data); 
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<div class="container-fluid observationListContainer">
<div class="pageHead">
    <h1>Reflection</h1>
</div>
<ul class="breadcrumb" style="background-color: none !important;">
    <li class=""><a href="#">Add New Reflection</a></li>
</ul>
<form action="<?php echo base_url('Reflections/updateReflection?reflectionId='.$reflectionid); ?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="centerid" value="<?php echo $Reflections->centerid; ?>">
    <div class="row">
        <div class="row col-sm-9">
            <div class="popdiv row col-sm-6">
                <span class="poplabel col-sm-12">Children</span>
                <span class="col-sm-12" style="width: 106%;">
            <select class="js-example-basic-multiple multiple_selection form-control" name="Children[]" multiple="multiple" style="padding: 1.5% 42% !important;">
                <?php foreach($Childs as $childs => $objchild) { ?>
                            <option name="<?php echo $objchild->name; ?>" value="<?php echo $objchild->childid; ?>"><?php echo $objchild->name; ?></option>
                        <?php }?>
            </select>   
                </span>
            </div>
            <div class="popdiv row col-sm-6">
                <span class="poplabel col-sm-12" style="margin-left:5%;">Educators</span>
                <span class="col-sm-12" style="width: 106%; margin-left: 37px;">
                    <select id="room_educators" name="Educator[]" class="js-example-basic-multiple  multiple_selection form-control" multiple="multiple" style="padding: 1.5% 42% !important; width: 106%; margin-left: 37px;">
                    <?php foreach($Reflections->staffs as $staff => $objstaff) { ?>
                            <option  value="<?php echo $objstaff->userid; ?>"></option>
                        <?php }?>
                    <?php foreach($Educators as $educator => $objEducator) { ?>
                            <option name="<?php echo $objEducator->name; ?>" value="<?php echo $objEducator->userid; ?>"><?php echo $objEducator->name; ?></option>
                        <?php }?>
                    </select>
                </span>
            </div>
            <div class="title-reflection" style="margin-left:15px; margin-top:20px;">
                <div class="form-group" style="margin-top:1%;">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control title" id="title" value="<?= $Reflections->title ?>">
                </div>
                <div class="form-group">
                    <label for="about">Reflection</label>
                    <textarea name="about" class="form-control about rounded-1" id="about" rows="10" value="<?= $Reflections->about ?>" placeholder="<?= $Reflections->about ?>" style="height:500px;"><?= $Reflections->about ?></textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-3" style="margin-top:1%;height:655px;background-color:white;border: 1px dashed var(--grey5); margin-left:1%;">
        <label class="file-upload-field" for="fileUpload" style="margin-top:3%;"><span class="material-icons-outlined">add</span><span>Upload</span>
        <?php foreach($Reflections->refMedia as $media => $objmedia) {?>
            <input type="file" name="media[]" id="fileUpload" class="form-control-hidden" multiple value="<?php echo $objmedia->mediaUrl; ?>"></label>
         <?php
            echo $objmedia->mediaUrl;
            echo "<br>"; }?>
        </div>
		<div class="row">
            <div class="col-sm-9"></div>
            <div class="col-sm-3">
                <input type="radio" name="status" class="btn btn-success" id="status" value="PUBLISHED"><label for="PUBLISHED">PUBLISHED</label>
                <input type="radio" name="status" class="btn btn-warning" id="status" value="DRAFT"><label for="DRAFT">DRAFT</label>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
    <div class="row" style="margin-top:1%;">
    <div class="col-sm-9"></div>
    <button class="btn col-sm-1" style="width:7%;margin-right:1%;"><a href="<?php echo base_url('Reflections/getUserReflections'); ?>">CLOSE</button>
    <button class="btn btn-primary col-sm-1" type="submit" style="width:7%;color: #fff !important;background-color: #337ab7 !important;border-color: #2e6da4 !important;">SAVE</button>
    </div>
</form>
</div>
<?php $this->load->view('footer'); ?>
<script>

</script>