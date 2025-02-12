<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Montessori Progress Plan | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/component-custom-switch.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <style>
        .bg-introduced{
            background: #F97E7F!important;
        }
        .bg-working{
            background: #2778AF!important;
        }
        .bg-completed{
            background: #FFF505!important;
        }
        .bg-needs-more{
            background: #FF8A00!important;
        }
        .bg-planned{
            background: url('<?= base_url("assets/images/flag-active.png"); ?>'), #FFFFFF;
            background-repeat: no-repeat;
            background-position: center; 
        }
        .bg-someone-planned{
            background: url('<?= base_url("assets/images/flag-active.png"); ?>'), #FFFFFF;
            background-repeat: no-repeat;
            background-position: center; 
        }
        #childDataTable{
            max-width: 100%;
            overflow-x: scroll;
        }
        .table-cell:hover{
            cursor: pointer;
            opacity: 0.9;
        }
        .justify-content-custom{
            align-items: center!important;
            justify-content: center!important;
        }
        .justify-content-space{
            align-items: center!important;
            justify-content: space-between!important;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <?php
        //PHP Block
        $user = $_SESSION['Name'];
    ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Montessori Progress Plan</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Montessori Progress Plan</li>
                        </ol>
                    </nav>
                    <div class="text-zero top-right-button-container">
                        <div class="btn-group mr-1">
                            <?php 
                                $dupArr = [];
                                $centersList = $this->session->userdata("centerIds");
                                if (empty($centersList)) {
                            ?>
                                <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> EMPTY CENTER </div>
                            <?php
                                }else{
                                    if (isset($_GET['centerid'])) {
                                        foreach($centersList as $key => $center){
                                            if ( ! in_array($center, $dupArr)) {
                                                if ($_GET['centerid']==$center->id) {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($center->centerName); ?> </div>
                            <?php
                                                }
                                            }
                                            array_push($dupArr, $center);
                                        }
                                    } else {
                            ?>
                                <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($centersList[0]->centerName); ?> </div>
                            <?php
                                    }
                                }

                                if (!empty($centersList)) {
                            ?>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php foreach($centersList as $key => $center){ ?>
                                    <a class="dropdown-item" href="<?= current_url().'?centerid='.$center->id; ?>">
                                        <?= strtoupper($center->centerName); ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-5">
                    <table class="table table-bordered">
                        <tr>
                            <td class="bg-introduced"> Introduced </td>
                            <td class="bg-working"> Working </td>
                            <td class="bg-completed"> Completed</td>
                            <td class="bg-needs-more"> Needs More</td>
                            <td class="bg-planned"> Planned </td>
                            <td class="bg-someone-planned"> Planned By Someone Else</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-space mr-0">
                                <h5 class="card-title">Center Preliminary Exercises</h5>
                                <div class="form-group row mb-1">
                                    <div class="col-6 text-right pt-1">
                                        <h5>Plan</h5>
                                    </div>
                                    <div class="col-6 text-left pl-0">
                                        <div class="custom-switch custom-switch-secondary mb-2">
                                            <input class="custom-switch-input" id="switch2" type="checkbox">
                                            <label class="custom-switch-btn" for="switch2"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table id="childDataTable" class="table table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>
                                            <h3>Table</h3>
                                        </th>
                                        <?php foreach ($childrenList as $childkey => $childobj) { ?>
                                        <th>
                                            <div class="d-flex justify-content-custom">
                                                <img src="<?= BASE_API_URL."assets/media/".$childobj['imageUrl']; ?>" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall" height="40px" width="40px">
                                                <?= $childobj['name']; ?>
                                            </div>
                                        </th>   
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tableData as $tableKey => $tableObj) { ?>
                                        <tr>
                                            <td>
                                                <?= ucfirst(strtolower($tableObj['title'])); ?>
                                            </td>  
                                            <?php 
                                                foreach ($tableObj['childList'] as $childkey => $childobj) {
                                                    $created_by = $childobj['created_by'];
                                                    $logged_user = $this->session->userdata('LoginId');
                                                    switch ($childobj['status']) {
                                                        case 'Introduced':
                                                            $class = "table-cell bg-introduced";
                                                            break;

                                                        case 'Needs More':
                                                            $class = "table-cell bg-needs-more";
                                                            break;

                                                        case 'Planned':
                                                            if($created_by==$logged_user){
                                                                $class = "table-cell bg-planned";
                                                            }else{
                                                                $class = "table-cell bg-someone-planned";
                                                            }                                                            
                                                            break;

                                                        case 'Working':
                                                            $class = "table-cell bg-working";
                                                            break;

                                                        case 'Completed':
                                                            $class = "table-cell bg-completed";
                                                            break;
                                                        
                                                        default:
                                                            $class = "table-cell bg-white";
                                                            break;
                                                    }
                                            ?>

                                            <td class="<?= $class; ?>" id="<?= "cell-".$tableObj['id']."-".$childobj['childid']; ?>" data-monid="<?= $tableObj['id']; ?>" data-childid="<?= $childobj['childid']; ?>"></td>
                                            <?php } ?> 
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>      
            </div>  
        </div>
    </main>
    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
    <script>


    <?php
        if($this->session->userdata('UserType') != "Parent")
    { ?>
        $(document).ready(function() {
            $(document).on('click','.table-cell',function(){

                
                let _cellid = $(this).prop('id');
                let _montid = $(this).data('monid');
                let _childid = $(this).data('childid');
                let _planMode = 0;

                if ($('#switch2').prop('checked') == false) {
                    _planMode = 0;
                }else{
                    _planMode = 1;
                }

                $.ajax({
                    url: '<?= base_url("progressPlan/updateCell"); ?>',
                    type: 'POST',
                    data: {'childid': _childid, 'montessoriid': _montid, 'plan':_planMode },
                })
                .done(function(response) {
                    console.log(response);
                    res = $.parseJSON(response);
                    if(res.Status = "SUCCESS"){
                        if(res.Response.status == ""){
                            $('#'+_cellid).removeClass();
                            $('#'+_cellid).addClass('table-cell bg-white');
                        }else if(res.Response.status == "Introduced"){
                            $('#'+_cellid).removeClass();
                            $('#'+_cellid).addClass('table-cell bg-introduced');
                        }else if(res.Response.status == "Working"){
                            $('#'+_cellid).removeClass();
                            $('#'+_cellid).addClass('table-cell bg-working');
                        }else if(res.Response.status == "Completed"){
                            $('#'+_cellid).removeClass();
                            $('#'+_cellid).addClass('table-cell bg-completed');
                        }else if(res.Response.status == "Planned"){
                            $('#'+_cellid).removeClass();
                            $('#'+_cellid).addClass('table-cell bg-planned');
                        }else{
                            $('#'+_cellid).removeClass();
                            $('#'+_cellid).addClass('table-cell bg-needs-more');
                        }
                    }else{
                        alert("Something went wrong!");
                    }
                });
            });

            $(document).on('change','#switch2',function(){
                if ($(this).prop('checked') == true) {
                    $("#childDataTable").css({
                        background: '#000000',
                        color: '#ffffff',
                        border: '1px solid #000000'
                    });
                } else {
                    $("#childDataTable").css({
                        background: '#ffffff',
                        color: '#3a3a3a',
                        border: '1px solid #dee2e6'
                    });
                }
            });
        });
    <?php  }?>
    </script>   
</body>
</html>