<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Child/ren</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.1.0"/>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.1.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <style>
        .child-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            height: 100%;
        }
        .child-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.15);
        }
        .child-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .child-info {
            padding: 20px;
        }
        .edit-btn {
            position: absolute;
            right: 20px;
            bottom: 20px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .badge-custom {
            font-size: 0.8rem;
            padding: 0.5em 0.8em;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .empty-state {
            text-align: center;
            padding: 100px 0;
        }
        .page-header {
            background: linear-gradient(135deg, #6DD5FA 0%, #2980B9 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .delete-btn {
    position: absolute;
    right: 70px; /* Position next to edit button */
    bottom: 20px;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-buttons {
    position: absolute;
    right: 20px;
    bottom: 20px;
    display: flex;
}
    </style>

    </head>

<body id="app-container" class="menu-default show-spinner">


<?php 
        $this->load->view('sidebar'); 
        $usertype = $this->session->userdata('UserType');
        $userid = $this->session->userdata('LoginId');
    ?>

<main data-centerid="">

<div class="page-header">
        <!-- <div class="container">
            <h1 class="fw-bold"><i class="fas fa-child me-2"></i> Children's Directory</h1>
            <p class="lead mb-0">Manage and view all children information</p>
        </div> -->
    </div>

    <div class="container mb-5">
        <!-- Search and Filter Options -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Search children...">
                </div>
            </div>
            <!-- <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <button class="btn btn-primary"><i class="fas fa-plus me-2"></i> Add New Child</button>
            </div> -->
        </div>

        <!-- Children Cards -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="childrenContainer">
            <?php if(isset($children) && !empty($children)): ?>
                <?php foreach($children as $child): ?>
                    <div class="col">
                        <div class="card child-card position-relative">
                            <img src="<?php echo !empty($child['imageUrl']) ? base_url('/api/assets/media/'.$child['imageUrl']) : 'http://www.listercarterhomes.com/wp-content/uploads/2013/11/dummy-image-square.jpg'; ?>" 
                                 class="child-image" alt="<?php echo $child['name'] ?? 'Child'; ?>">
                            <div class="child-info">
                                <h5 class="card-title fw-bold"><?php echo $child['name'] ?? 'N/A'; ?>&nbsp;<?php echo $child['lastname'] ?? 'N/A'; ?></h5>
                                
                                <div class="mb-3">
                                    <?php if(!empty($child['dob'])): ?>
                                        <span class="badge bg-info text-dark badge-custom">Date of Birth: <?php echo date(' d / M / Y', strtotime($child['dob'])); ?></span>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($child['gender'])): ?>
                                        <span class="badge bg-light text-dark badge-custom">
                                            <?php echo $child['gender'] == 'Male' ? '<i class="fas fa-mars text-primary"></i> Male' : '<i class="fas fa-venus text-danger"></i> Female'; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <p class="mb-1"><i class="fas fa-id-card me-2 text-secondary"></i> ID: <?php echo $child['id'] ?? 'N/A'; ?></p>
                                
                                <?php if(!empty($child['room_name'])): ?>
                                    <p class="mb-1"><i class="fas fa-door-open me-2 text-secondary"></i> Room: <?php echo $child['room_name']; ?></p>
                                <?php endif; ?>
                                
                                <?php if(!empty($child['parent_name'])): ?>
                                    <p class="mb-1"><i class="fas fa-user-friends me-2 text-secondary"></i> Parent: <?php echo $child['parent_name']; ?></p>
                                <?php endif; ?>
                                
                                <?php if(!empty($child['createdAt'])): ?>
                                    <p class="mb-1"><i class="far fa-calendar-alt me-2 text-secondary"></i> Joined: <?php echo date('M d, Y', strtotime($child['createdAt'])); ?></p>
                                <?php endif; ?>
                                
                                <div class="action-buttons">
                                <a href="<?php echo base_url('room/getChildForm/?id='.$child['room'].'&childId='.$child['id'].'&redirectPage=customPage'); ?>" class="btn btn-primary edit-btn">
    <i class="fas fa-edit"></i>
</a>

<button class="btn btn-danger delete-btn ms-2" 
            data-id="<?php echo $child['id']; ?>" 
            data-name="<?php echo $child['name']; ?>">
        <i class="fas fa-trash"></i>
    </button> </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <img src="<?php echo base_url('assets/images/empty-state.svg'); ?>" alt="No Data" style="max-width: 200px; margin-bottom: 20px;">
                        <h3>No Children Found</h3>
                        <p class="text-muted">There are no children assigned to your rooms or centers.</p>
                        <button class="btn btn-primary mt-3"><i class="fas fa-plus me-2"></i> Add Your First Child</button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

            </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Simple search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const childCards = document.querySelectorAll('#childrenContainer .col');
            
            childCards.forEach(card => {
                const cardText = card.textContent.toLowerCase();
                if (cardText.includes(searchValue)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>



<!-- Add SweetAlert library before your script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Existing search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const childCards = document.querySelectorAll('#childrenContainer .col');
        
        childCards.forEach(card => {
            const cardText = card.textContent.toLowerCase();
            if (cardText.includes(searchValue)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Delete functionality
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const childId = this.getAttribute('data-id');
            const childName = this.getAttribute('data-name');
            
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${childName}'s record. This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete
                    fetch('<?php echo base_url("room/deletechilddata"); ?>/' + childId, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Deleted!',
                                `${childName}'s record has been deleted.`,
                                'success'
                            ).then(() => {
                                // Remove the card from the DOM
                                const card = button.closest('.col');
                                card.remove();
                                
                                // If no children left, show empty state
                                if (document.querySelectorAll('#childrenContainer .col').length === 0) {
                                    const emptyState = `
                                        <div class="col-12">
                                            <div class="empty-state">
                                                <img src="<?php echo base_url('assets/images/empty-state.svg'); ?>" alt="No Data" style="max-width: 200px; margin-bottom: 20px;">
                                                <h3>No Children Found</h3>
                                                <p class="text-muted">There are no children assigned to your rooms or centers.</p>
                                                <button class="btn btn-primary mt-3"><i class="fas fa-plus me-2"></i> Add Your First Child</button>
                                            </div>
                                        </div>
                                    `;
                                    document.getElementById('childrenContainer').innerHTML = emptyState;
                                }
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'There was a problem deleting the record.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'There was a problem with the server.',
                            'error'
                        );
                    });
                }
            });
        });
    });
</script>

<?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js"></script>
</body>