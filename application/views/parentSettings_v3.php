<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Parents Settings | Mydiaree</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?v=1.0.0"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet"
        href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
    .userSettings {
        display: block;
        width: 100%;
    }

    .rowUserSettings {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 0 0 30px;
    }

    .rowUserSettingsBlock .info-block {
        padding: 20px;
        background: var(--blue5);
        border: 1px solid var(--blue5);
    }

    .input-group.searchGroup {
        display: flex;
        align-items: center;
        width: 100%;
        position: relative;
    }

    .selectFilters {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .userListContainer {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        align-items: flex-start;
        justify-content: flex-start;
        margin: 30px 0 0;
    }

    .users-box {
        display: flex;
        align-items: center;
    }

    .users-box .users-img {
        background: var(--grey5);
        margin-right: 20px;
        border-radius: 200px;
        display: inline-block;
        overflow: hidden;
        width: 120px;
        height: 120px;
    }

    .users-box .users-img img {
        width: 100%;
    }

    .users-info {
        width: calc(100% - 140px);
    }

    .userListContainer .col-sm-4 {
        flex: 0 0 calc(50% - 15px);
        padding: 30px;
        margin-bottom: 20px;
        margin-right: 10px;
        /* margin-top: 30px;
			margin-left: 30px; */
        box-shadow: 0 0 5px rgb(0 0 0 / 16%);
        -o-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
        -ms-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
        -moz-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
        -webkit-box-shadow: 0 0 5px rgb(0 0 0 / 16%);
    }

    .rowUserSettingsBlock {
        width: 100%;
        text-align: center;
        margin-right: 20px;
    }

    .input-group-text {
        background-color: white;
        border-right: none;
    }

    @media only screen and (min-width: 320px) and (max-width: 600px) {
        .userListContainer .col-sm-6 {
            flex: inherit;
            margin-bottom: 20px;
        }

        .rowUserSettings {
            align-items: inherit;
            display: block;
        }

        .rowUserSettingsBlock {
            width: 100%;
            margin-right: 20px;
        }

        .selectFilters {
            justify-content: center;
        }
    }

    .list-thumbnail {
        width: 85px !important;
    }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main data-centerid="<?= $centerid; ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Parent Settings</h1>

                    <div class="text-zero top-right-button-container d-flex flex-row">
                        <div class="btn-group mr-1">
                            <?php 
                                $dupArr = [];
                                $centersList = $this->session->userdata("centerIds");
                                if (empty($centersList)) {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> EMPTY CENTER </div>
                            <?php
                                }else{
                                    if (isset($_GET['centerid'])) {
                                        foreach($centersList as $key => $center){
                                            if ( ! in_array($center, $dupArr)) {
                                                if ($_GET['centerid']==$center->id) {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= strtoupper($center->centerName); ?> </div>
                            <?php
                                                }
                                            }
                                            array_push($dupArr, $center);
                                        }
                                    } else {
                            ?>
                            <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= strtoupper($centersList[0]->centerName); ?> </div>
                            <?php
                                    }
                                }

                                if (!empty($centersList)) {
                            ?>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php foreach($centersList as $key => $center){ ?>
                                <a class="dropdown-item" href="<?= current_url() . '?centerid=' . $center->id; ?>">
                                    <?= strtoupper($center->centerName); ?>
                                </a>
                                <?php } ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">Settings</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Parent Settings</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <p>Total Parents</p>
                                <h4><?= $parentStats->totalParents; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <p>Active Parents</p>
                                <h4><?= $parentStats->activeParents; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <p>Inactive Parents</p>
                                <h4><?= $parentStats->inactiveParents; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <p>Pending Parents</p>
                                <h4><?= $parentStats->pendingParents; ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="selectFilters my-4 text-right">
                        <div class="filterAll">
                            <?php 
					            if (isset($_GET['order']) && $_GET['order']=="ASC" || empty($_GET['order'])) {
					              $url = base_url("Settings/parentSettings")."?order=DESC";
					            } else { 
					              $url = base_url("Settings/parentSettings")."?order=ASC";
					            }
				            ?>
                            <a class="btn icon-btn btn-outline-primary" href="<?= $url; ?>">
                                <div class="icon-btn">
                                    <img src="<?php echo base_url("assets/images/icons/sort.svg"); ?>" alt="sort">
                                </div>
                            </a>
                            <a href="<?= base_url("Settings/addParent") . '?centerid=' . $centerid; ?>"
                                class="btn btn-primary">
                                <span class="simple-icon-plus"></span> Add Parent
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <?php foreach ($parents as $key => $pobj) { ?>
                <div class="col-md-4">
                    <div class="card d-flex flex-row mb-4">



                        <a class="d-flex"
                            href="<?= base_url("Settings/addParent")."?recordId=".$pobj->userid."&centerid=".$centerid; ?>">
                            <?php 
								if (empty($pobj->imageUrl)) {
									$image = "https://cdn.pixabay.com/photo/2020/07/01/12/58/icon-5359553_1280.png";
								} else {
									$image = base_url("api/assets/media/").$pobj->imageUrl;
								}
							?>
                            <img alt="Profile" src="<?= $image;?>"
                                class="img-thumbnail border-0 rounded-circle m-4 list-thumbnail align-self-center">
                        </a>
                        <div class="d-flex flex-grow-1 min-width-zero">

                            <div
                                class="card-body pl-0 align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero">
                                <div class="min-width-zero">
                                    <a
                                        href="<?= base_url("Settings/addParent")."?recordId=".$pobj->userid."&centerid=".$centerid; ?>">
                                        <p class="list-item-heading mb-1 truncate">
                                            <?= ucwords(strtolower($pobj->name)); ?></p>
                                    </a>
                                    <ul class="list-unstyled">
									<li class="users-list-item">
    <span class="iconsminds-suitcase"></span>
    <?php if ($pobj->status == 'ACTIVE') { ?>
        <span style="color: green; font-weight: bold;">Active</span>
    <?php } else { ?>
        <span style="color: red; font-weight: bold;">Deactivated</span>
    <?php } ?>
</li>
                                        <li class="users-list-item">
                                            <span class="simple-icon-calendar"></span>
                                            <?= date('d-m-y',strtotime($pobj->dob)); ?>
                                        </li>
                                    </ul>

									<?php if (!empty($pobj->children)) { ?>
    <ul class="list-unstyled mt-2">
        <li class="font-weight-bold">Child/ren:</li>
		<?php foreach ($pobj->children as $child) { ?>
    <li class="ml-3">
        <i class="simple-icon-user"></i>
        <?= ucwords(strtolower($child->name . ' ' . $child->lastname)); ?>
        <small class="text-muted"> (<?= ucfirst(strtolower($child->relation)); ?>)</small>
    </li>
<?php } ?>
    </ul>
<?php } else { ?>
    <ul class="list-unstyled mt-2">
        <li class="ml-3 text-muted">No children linked</li>
    </ul>
<?php } ?>

                                </div>
                            </div>

							

                            <div style="margin-right: 15px;margin-top: 10px;">
                                <a href="#" class="delete-link" data-userid="<?= $pobj->userid; ?>">
                                    <i class="fa-solid fa-trash fa-fade" style="color: #ff1605;"></i>
                                </a>

								&nbsp;&nbsp;

								   <!-- Activate/Deactivate Button -->
    <?php if ($pobj->status == 'ACTIVE') { ?>
        <a href="#" class="deactivate-link" data-userid="<?= $pobj->userid; ?>" data-action="deactivate" title="Deactivate">
			<i class="fa-solid fa-user-check" style="color: #28a745;"></i>
        </a>
    <?php } else { ?>
        <a href="#" class="deactivate-link" data-userid="<?= $pobj->userid; ?>" data-action="activate" title="Activate">
		<i class="fa-solid fa-user-slash" style="color: #f39c12;"></i>
        </a>
    <?php } ?>



                            </div>

							
                        </div>
                    </div>
                </div>
                <?php } ?>
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
    <script>
    $(document).ready(function() {

    });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script>
    $(document).ready(function() {
        $('.delete-link').on('click', function(e) {
            e.preventDefault();
            var userId = $(this).data('userid');

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
                        url: '<?= base_url("Settings/deleteUser"); ?>',
                        type: 'POST',
                        data: {
                            userid: userId
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'The user has been deleted.',
                                    'success'
                                ).then(() => {
                                    location
                                .reload(); // Reload the page after deletion
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the user.',
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the user.',
                                'error'
                            );
                        }
                    });
                }
            });
        });



		$('.deactivate-link').on('click', function(e) {
    e.preventDefault();

    var userId = $(this).data('userid');
    var action = $(this).data('action'); // 'activate' or 'deactivate'
    var newStatus = (action === 'deactivate') ? 'IN-ACTIVE' : 'ACTIVE';
    var confirmText = (action === 'deactivate') ? 'Deactivate this user?' : 'Activate this user?';

    Swal.fire({
        title: 'Are you sure?',
        text: confirmText,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, proceed!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("Settings/changeUserStatus"); ?>',
                type: 'POST',
                data: {
                    userid: userId,
                    status: newStatus
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire(
                            'Success!',
                            'User status updated.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', 'Failed to update user status.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'There was a server error.', 'error');
                }
            });
        }
    });
});


		
    });





    </script>

</body>

</html>