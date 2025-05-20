<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Program Plan List | Mydiaree</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<!-- Add this to your header section for jQuery (if not already included) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    

<style>
    /* Main Container Styling */
    .program-plan-container {
        padding: 20px;
        background-color: #f8f9fa;
    }
    
    /* Card Styling */
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 30px;
        transition: transform 0.3s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .card-body {
        padding: 25px;
    }
    
    .card-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 20px;
        font-size: 1.5rem;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 12px;
    }
    
    /* Table Styling */
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .table {
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table thead th {
        background-color: #3498db;
        color: white;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        padding: 15px;
        vertical-align: middle;
        border: none;
    }
    
    .table tbody tr:nth-child(odd) {
        background-color: #f8f9fa;
    }
    
    .table tbody tr:nth-child(even) {
        background-color: #ffffff;
    }
    
    .table tbody tr:hover {
        background-color: #e8f4fd;
    }
    
    .table td {
        vertical-align: middle;
        padding: 12px 15px;
        border-top: 1px solid #e9ecef;
        font-size: 0.9rem;
    }
    
    /* Button Styling */
    .btn {
        border-radius: 5px !important;
        font-weight: 500;
        letter-spacing: 0.5px;
        padding: 8px 15px;
        margin: 3px;
        transition: all 0.3s;
    }
    
    .btn i {
        margin-right: 5px;
    }
    
    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    
    .btn-info:hover {
        background-color: #138496;
        border-color: #117a8b;
        box-shadow: 0 4px 10px rgba(23, 162, 184, 0.3);
    }
    
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }
    
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
        box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
    }
    
    /* Status Badge */
    .badge {
        padding: 6px 10px;
        border-radius: 20px;
        font-weight: 500;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #dee2e6;
    }
    
    /* Action Button Container */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 5px;
    }
    
    /* Month Label Styling */
    .month-label {
        background-color: #e9f7fe;
        color: #3498db;
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: 500;
    }
    
    /* Table Header and ID Column */
    .table .id-column {
        width: 60px;
        text-align: center;
    }
    
    /* Page Title */
    .page-title {
        margin-bottom: 30px;
        color: #2c3e50;
        font-weight: 700;
    }
    
    /* Animation Classes */
    .animated-icon {
        display: inline-block;
        animation-duration: 0.75s;
    }
    
    @keyframes beat {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
    
    .fa-beat {
        animation: beat 1s infinite;
    }
    
    @keyframes fade {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    
    .fa-beat-fade {
        animation: fade 1.5s infinite;
    }
</style>


</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Program Plan List</h1>
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
                        <?php if (isset($permission) && $permission->add == 1) { ?>
    <!-- <a href="#" class="btn btn-primary btn-lg top-right-button" id="addnewbtn" data-toggle="modal" data-target="#templateModal">ADD NEW</a> -->
<?php } ?>

<!-- <a href="<?= base_url('lessonPlanList/viewnewtemplate').'?centerid='.$centerid; ?>">
    <button class="btn btn-outline-primary" style="margin-left:5px;">Add Templates</button>
</a> -->
<?php if ($this->session->userdata('UserType')!='Parent') {    ?> 
<a href="<?= base_url('lessonPlanList/viewProgramplanCreateformpage').'?centerid='.$centerid; ?>">
    <button class="btn btn-outline-primary" style="margin-left:5px;">Add ProgramPlan</button>
</a>

<?php } ?>
                    </div>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Program Plan List</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
         
         
            <div class="program-plan-container">
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="card-title">Program Plan List</h4> -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="id-column">ID</th>
                                    <th>Month</th>
                                    <th>Room</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th width="240">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($program_plans)): ?>
                                    <?php $serial_no = 1; // Initialize the serial number ?>
                                    <?php foreach($program_plans as $plan): ?>
                                        <tr>
                                            <td class="id-column"><?php echo $serial_no++; ?></td>
                                            <td>
                                                <span class="month-label"><?php echo $get_month_name($plan->months); ?>&nbsp;<?php echo $plan->years ?? 'N/A'; ?></span>
                                            </td>
                                            <td><?php echo $plan->room_name ?? 'N/A'; ?></td>
                                            <td><?php echo $plan->creator_name ?? 'N/A'; ?></td>
                                            <td>
                                                <?php 
                                                $created_date = new DateTime($plan->created_at);
                                                echo $created_date->format('d M Y / H:i'); 
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $updated_at = new DateTime($plan->updated_at);
                                                echo $updated_at->format('d M Y / H:i'); 
                                                ?>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="<?php echo base_url('LessonPlanList/programplanprintpage/'.$plan->id); ?>" class="btn btn-sm btn-info">
                                                        <i class="fa-solid fa-print animated-icon"></i> Print
                                                    </a>
                                                    <?php if ($this->session->userdata('UserType')!='Parent') {    ?> 
                                                    <a href="<?php echo base_url('LessonPlanList/viewProgramplanCreateformpage'."?centerid=".$centerid."&planid=".$plan->id); ?>" class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-pen-to-square animated-icon"></i> Edit
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger delete-program" data-id="<?php echo $plan->id; ?>">
                                                        <i class="fa-solid fa-trash animated-icon"></i> Delete
                                                    </button>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="empty-state">
                                            <i class="fa-solid fa-clipboard-list"></i>
                                            <p>No program plans found</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
 

    <script>
$(document).ready(function() {
    // Delete program plan
    $(document).on('click', '.delete-program', function() {
        var programId = $(this).data('id');
        var row = $(this).closest('tr');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('LessonPlanList/deletedataofprogramplan') ?>',
                    type: 'POST',
                    data: {
                        program_id: programId,
                        <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            );
                            // Remove the row from the table
                            row.fadeOut(400, function() {
                                $(this).remove();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Something went wrong with the server. Please try again.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>