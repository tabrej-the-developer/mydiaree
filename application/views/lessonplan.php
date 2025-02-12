<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montessori Lesson Plan | Mydiaree</title>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?id=1234" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?id=1234" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?id=1234" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body id="app-container" class="menu-default" style="background-color: #f8f8f8; top: -35px; bottom:0px;">
<?php $this->load->view('sidebar'); ?> 
<main class="default-transition" style="opacity: 1;">
    <div class="default-transition" style="opacity: 1;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin-top: -15px;">
                    <h1>Montessori Lesson Plan</h1>
                    <div class="text-zero top-right-button-container dropdownPrint"> 
                        <a href="<?php echo base_url('lessonplan/printlessonPDF'); ?>" target="_blank" class="btn btn-primary h4" id="createSelfAsmnt">
                        <i class="fa fa-print" style="font-size: large;"></i>
                        </a>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0" style="background-color: transparent;">
                            <li class="breadcrumb-item">
                                <a href="#" style="color: dimgray;">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#" style="color: dimgray;">Lesson & Progress Plan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Plan Montessori Lessons</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
                <div class="col-12">
                    <div class="lessonPlanList row">
                        <?php $init=0; 
                        $GLOBALS['count_display']=0;
                        $display=4;
                        $split_count = round($child_count / $display);
                        if($split_count==0){
                            $split_count =1;
                        }
                        for($i=0;$i<$split_count;$i++){
                            for($j=$GLOBALS['count_display'];$j<$child_count;$j++){
                                $GLOBALS['count_display']++;
                                $name=$new_process[$j]->child_name;
                                $get_title=getlessontitle($new_process,$j);
                           if(isset($get_title)){ ?>
                            <div class="col-md-3 col-sm-12 p-0">
                                <div class="lessonPlanListBlock card p-3 m-1" style="">
                                    <div class="lessonPlanListBlockHeader">
                                        <img src="<?php echo base_url('api/assets/media/'.$new_process[$j]->child_imageUrl);?>" class="rounded rounded-circle mr-2" style='width: 100px;'> 
                                        <span class="h5 text-primary"><?php echo $name;?></span>
                                    </div>
                                    <ul class="mt-3 mb-0 p-0" style="list-style-type: none;">
    <?php if (isset($get_title)) {
        // echo '<pre>';
        // print_r($get_title);
        // echo '</pre>';
        foreach ($get_title as $title_key => $title_value) { ?>
            <li>
                <input id="<?php echo $title_key; ?>" class='status_change' type="checkbox">
                <label class="h6" for="<?php echo $title_key; ?>"><?php echo $title_value; ?></label>
            </li>
        <?php }
    } ?>
</ul>
                                </div>
                            </div>
                            <?php } ?>
                        <?php }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
</body>
<script>
    $(document).ready(function(){
        $('.status_change').click(function() {
        // Use $(this) to get the id of the clicked checkbox
        var get_id = $(this).attr('id'); // Changed this line
        var split_id = get_id.split('_'); // Assuming your IDs are formatted with underscores
        console.log("split_id id", split_id);
            console.log("split_id id",split_id);
            childid=split_id[0];
            actid=split_id[1];
            subid=split_id[2];
            console.log("child id",childid);
            console.log("activityid id",actid);
            console.log("subid id",subid); 

            $.ajax({
                url:'<?php echo base_url()?>/Lessonplan/lessondetailschange',
                type:'POST',
                data:'childid='+childid+'&activityid='+actid+'&subid='+subid,
                success:function(){

                    location.reload();
                }
            });
        })
    });  
</script>
</html>