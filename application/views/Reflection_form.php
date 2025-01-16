<!-- <pre> -->
<?php
// foreach($reflection as $Reflections => $ref){
//     print_r($ref);
//     }
//     exit();
	$data['name']='Reflection_form'; 
	$this->load->view('header',$reflection); 
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- Observation code use -->
<div class="container-fluid observationListContainer">
    <div class="pageHead" style="margin-top: 20px;">
        <h1>Reflection</h1>
        <div class="obsMenuTop">
            <form action="" method="get" id="obsCenters">
                <div class="form-group">
                    <select name="centerid" id="centerId" class="form-control">
                        <?php 
								foreach ($this->session->userdata("centerIds") as $key => $center) {
								if ($_GET['centerId']==$center->id) {
							?>
                        <option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
                        <?php
								} else {
							?>
                        <option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
                        <?php
								}
								}
							?>
                    </select>
                </div>
            </form>
            <?php 
					$role = $this->session->userdata('UserType');
				?>
            <a href="<?php echo base_url('Reflections/createReflection'); ?>" class="btn btn-default btn-small btnBlue">
                <span class="material-icons-outlined">add</span>
            </a>
        </div>
    </div>
</div>
<!-- <php foreach($reflection as $Reflections => $ref): ?>
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner" role="listbox">
							<php $i = 1; foreach($ref->media as $refmedia => $mediadata) { ?>
								<div class="item <php if($i==1){ echo "active"; } ?>">
								<img src="<= BASE_API_URL."assets/media/".$mediadata->mediaUrl;?>" alt="No media here" style="width:200px;height:200px;">
								</div>
							<php $i++; } ?>
						</div>
						<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"><span class="material-icons-outlined">keyboard_arrow_left</span></a>
						<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"><span class="material-icons-outlined">keyboard_arrow_right</span><span class="sr-only">Next</span></a>
					</div>
				<php endforeach ?> -->

<!-- end observation code -->
<?php if($center->id) { ?>
<?php foreach($reflection as $Reflections => $ref): ?>
<div class="reflection-main-content">
    <div class="reflection-inner-content bg-white row" style="margin:10px;">
        <div class="col-sm-2 text-right">
            <span class="img-pro">

                <div id="carousel-example-generic-<?= $ref->id; ?>" class="carousel slide" data-ride="carousel">

                    <div class="carousel-inner" role="listbox">
                        <?php $i = 1; foreach($ref->media as $refmedia => $mediadata) { ?>
                        <div class="item <?php if($i==1){ echo "active"; } ?>" style="margin-left: 32px;">
                            <img src="<?= BASE_API_URL."assets/media/".$mediadata->mediaUrl;?>" alt="No media here"
                                style="width:200px;height:200px;">
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic-<?= $ref->id; ?>" role="button"
                            data-slide="prev"><span class="material-icons-outlined">keyboard_arrow_left</span></a>
                        <a class="right carousel-control" href="#carousel-example-generic-<?= $ref->id; ?>"
                            role="button" data-slide="next"><span
                                class="material-icons-outlined">keyboard_arrow_right</span><span
                                class="sr-only">Next</span></a>
                        <?php $i++; } ?>
                    </div>
                </div>
            </span>
        </div>
        <div class="col-sm-10">
            <span class="reflection-icon row">
                <h3 class="reflection-heading col-sm-10" style="padding-left:0px; margin:0px;"><?php echo $ref->title ?>
                </h3>
                <a href="<?php echo base_url('Reflections/Reflection_update/?reflectionid='.$ref->id); ?>">
                    <span data-id="<?= $ref->id; ?>" class="reflection-edit col-md-1" style="padding:4px;width:2%;"><i
                            class="fas fa-pen text-primary"></i></span>
                </a>
                <span class="reflection-delete col-md-1" id="reflection-delete" data-id="<?= $ref->id; ?>"
                    data-userid="<?= $ref->createdBy; ?>" style='padding:4px;width:2%;'><i
                        class='fas fa-trash-alt text-danger'></i></span>
                <?php if($ref->status == 'PUBLISHED') { ?>
                <span class="btn-success col-md-1 text-center"
                    style="padding:4px;margin-left:1%;border-radius:3px;"><?php echo $ref->status ?></span>
                <?php }else{ ?>
                <span class="btn-warning col-md-1 text-center"
                    style="padding:4px;margin-left:1%;border-radius:3px;"><?php echo $ref->status ?></span>
                <?php } ?>
            </span>
            <h5 class="text-primary" style="margin:0px;margin-bottom:20px;margin-top:-19px;">
                <?php echo date('d M Y',strtotime($ref->createdAt)) ?></h5>
            <div class="reflection-child-data row" style="">
                <?php foreach($ref->childs as $refChild => $childdata) { ?>
                <span>
                    <span class="col-sm-1" style="width:4.333333%;"><img
                            src="<?= BASE_API_URL."assets/media/".$childdata->imageUrl;?>" alt=""
                            style=" border-radius:50%;width:50px;height:50px;"></span>
                    <h3 class="text-primary col-sm-1" style="margin-top:12px;"><?php echo $childdata->name; ?></h3>
                </span>
                <?php } ?>
            </div>
            <p class="reflection-text" style="margin-top:20px;"><?php echo $ref->about ?></p>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php }else{} ?>

<?php $this->load->view('footer'); ?>
<script>
$(document).ready(function() {
    $('#centerId').on('change', function() {
        centerId = $(this).val();
        window.location.href = "<?php echo base_url("Reflections/getUserReflections"); ?>?centerId=" +
            centerId;
    });
});

$(document).on('click', '.reflection-delete', function() {
    var reflectionid = $(this).data('id');
    var userid = $(this).data('userid');
    $.ajax({
        traditional: true,
        url: "<?php echo base_url('Reflections/deleteReflection'); ?>",
        type: "POST",
        data: {
            "userid": userid,
            "reflectionid": reflectionid
        },
        success: function(msg) {
            console.log(msg);
            res = JSON.parse(msg);
            if (res.Status == "SUCCESS") {
                location.reload();
            } else {
                console.log(res.Message);
            }
        }
    });
});
</script>