<style>
    @media (max-width: 767px) {
    .navbar-logo {
        display: none;
    }
}
</style>

<style>
.main-menu .active {
    background-color: rgba(0, 0, 0, 0.1);
}

.sub-menu .active {
    background-color: rgba(0, 0, 0, 0.1);
}

.scroll {
    overflow-y: auto;
}

.sub-menu ul {
    display: none;
}
    </style>

<nav class="navbar fixed-top " style="padding-bottom: 0px; padding-top: 0px; height: 70px; ">
    <div class="d-flex align-items-center navbar-left col-6">
        <a href="#" class="menu-button d-none d-md-block">
            <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                <rect x="0.48" y="0.5" width="7" height="1" />
                <rect x="0.48" y="7.5" width="7" height="1" />
                <rect x="0.48" y="15.5" width="7" height="1" />
            </svg>
            <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                <rect x="1.56" y="0.5" width="16" height="1" />
                <rect x="1.56" y="7.5" width="16" height="1" />
                <rect x="1.56" y="15.5" width="16" height="1" />
            </svg>
        </a>

        <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                <rect x="0.5" y="0.5" width="25" height="1" />
                <rect x="0.5" y="7.5" width="25" height="1" />
                <rect x="0.5" y="15.5" width="25" height="1" />
            </svg>
        </a>
    </div>
    
    <a class="navbar-logo col-3 " href="#">
        <img style="width:200px; height:50px; padding: 10px; border-radius: 20px;" src="<?php echo base_url('/assets/images/MYDIAREE-new-logo.png'); ?>" alt="rajat">
    </a>

    <div class="navbar-right  col-3 mb-2">
        <div class="header-icons d-inline-block align-middle">
            <div class="position-relative d-none d-sm-inline-block">
                
            </div>
        </div>

        <div class="user d-inline-block">
            <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span>
                    <!-- <img alt="Profile Picture" src="<?= base_url(); ?>assets/v3/img/profiles/l-1.jpg" /> -->
                    <img alt="Profile Picture" src="<?= base_url(); ?>api/assets/media/<?php echo $this->session->userdata('ImgUrl'); ?>" style="margin-right: 10px !important;border-radius:0px !important;margin-left:0px !important;" />
                </span>
                <span class="name"><?php echo $this->session->userdata('Name');?></span>
            </button>

            <div class="dropdown-menu dropdown-menu-right mt-3">
                <a class="dropdown-item" href="<?php echo base_url('logout'); ?>">Sign out</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#uploadImageModal">Change Profile Pic</a>
            </div>
        </div>
    </div>
</nav>
<div class="menu">
    <div class="main-menu" style="top: 70px; height: calc(100% - 40px);">
        <div class="scroll">
            <ul class="list-unstyled">
                <li class="<?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') === TRUE ? 'active' : ''); ?>">
                    <a href="<?php echo base_url('dashboard'); ?>">
                        <i class="simple-icon-home"></i>Home
                    </a>
                </li>
                <li class="<?= (strpos($_SERVER['REQUEST_URI'], 'observation/observationList') === TRUE ? 'active' : ''); ?>">
                    <a href="<?php echo base_url('observation/observationList'); ?>">
                        <i class="simple-icon-equalizer"></i>Observation
                    </a>
                </li>
                <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <li class="<?= (strpos($_SERVER['REQUEST_URI'], 'selfassessment') === TRUE || strpos($_SERVER['REQUEST_URI'], 'qip') === TRUE ? 'active' : ''); ?>">
                        <a href="#homeSubmenu">
                            <i class="iconsminds-notepad"></i>QIP
                        </a>
                    </li>
                    <li  class="<?= (strpos($_SERVER['REQUEST_URI'], 'room/getList') === TRUE ? 'active' : ''); ?>">
                        <a href="<?php echo base_url('room'); ?>">
                            <i class="iconsminds-building"></i>Rooms
                        </a>
                    </li>

                    <?php } ?>


                    <li  class="<?= (strpos($_SERVER['REQUEST_URI'], 'lessonPlanList/programPlanList') === TRUE ? 'active' : ''); ?>">
                        <a href="<?php echo base_url('lessonPlanList/programPlanList'); ?>">
                            <i class="iconsminds-testimonal"></i>Program Plan
                        </a>
                    </li>

                    <?php if($this->session->userdata("UserType")!="Parent"){ ?>

                    <li  class="<?= (strpos($_SERVER['REQUEST_URI'], 'ServiceDetails') === TRUE ? 'active' : ''); ?>">
                        <a href="<?php echo base_url('ServiceDetails'); ?>">
                            <i class="iconsminds-receipt-4"></i>Service Details
                        </a>
                    </li>

                    <li  class="<?= (strpos($_SERVER['REQUEST_URI'], 'Media') === TRUE ? 'active' : ''); ?>">
                        <a href="<?php echo base_url('Media'); ?>">
                            <i class="iconsminds-photo-album-2"></i>Media
                        </a>
                    </li>

                    
                    <?php } ?>
                
                    <li>
                        <a href="#announcements">
                            <i class="iconsminds-speaker-1"></i>Announcements
                        </a>
                    </li>
                    <li>
                        <a href="#Healthy">
                            <i class="iconsminds-hamburger"></i>Healthy Eating
                        </a>
                    </li>
                    <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <li  class="<?= (strpos($_SERVER['REQUEST_URI'], 'Resources') === TRUE ? 'active' : ''); ?>">
                        <a href="<?php echo base_url('Resources'); ?>">
                            <i class="iconsminds-eci-icon"></i>Resources
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="#Daily">
                            <i class="iconsminds-wallet"></i>Daily Journal
                        </a>
                    </li>
                 
                    <li  class="<?= (strpos($_SERVER['REQUEST_URI'], 'dashboard') === TRUE ? 'active' : ''); ?>">
                        <a href="<?php echo base_url('Reflections'); ?>">
                            <i class="iconsminds-reset"></i>Daily Reflections
                        </a>
                    </li>
              
                    <li>
                        <a href="#Lesson">
                            <i class="iconsminds-line-chart-1"></i>L&P Plan
                        </a>
                    </li>
                    <li>
                        <a href="#homeSettings">
                            <i class="iconsminds-gear"></i>Settings
                        </a>
                    </li>
            </ul>
        </div>
    </div>

    <div class="sub-menu" style="top: 70px; height: calc(100% - 40px);">
        <div class="scroll">
            <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                <ul class="list-unstyled" data-link="homeSubmenu" id="homeSubmenu">
                    <li>
                        <a href="<?php echo base_url('selfassessment'); ?>">
                            <i class="simple-icon-rocket"></i> <span class="d-inline-block">Self Assessment</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('qip'); ?>">
                            <i class="simple-icon-rocket"></i> <span class="d-inline-block">Quality Improvement Plan</span>
                        </a>
                    </li>
                </ul>
            <?php } ?>

            <?php
                //  if($this->session->userdata("UserType")!="Parent"){ 
            ?>
                <ul class="list-unstyled" data-link="homeSettings" id="homeSettings">
                    <li>
                        <a href="<?php echo base_url('Settings/resetPassword'); ?>">
                            <span class="d-inline-block">Reset Password</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/changeEmail'); ?>">
                            <span class="d-inline-block">Change Email</span>
                        </a>
                    </li>
                    <?php if ($_SESSION['UserType'] != "Parent") { ?>
                    
                    <li>
                        <a href="<?php echo base_url('Settings/managepublicholiday'); ?>">
                            <span class="d-inline-block">Manage Public Holidays</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url('Settings/moduleSettings'); ?>">
                            <span class="d-inline-block">Module Settings</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url('Settings/userSettings'); ?>">
                            <span class="d-inline-block">User Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/centerSettings'); ?>">
                            <span class="d-inline-block">Center Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/parentSettings'); ?>">
                            <span class="d-inline-block">Parent Settings</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo base_url('Settings/superadminSettings'); ?>">
                            <span class="d-inline-block">Super-Admin Settings</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url('Settings/childGroups'); ?>">
                            <span class="d-inline-block">Child Groups</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/managePermissions'); ?>">
                            <span class="d-inline-block">Manage Permissions</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/applicationSettings'); ?>">
                            <span class="d-inline-block">Application Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/noticePeriodSettings'); ?>">
                            <span class="d-inline-block">Customize Observation Period</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('Settings/assessment'); ?>">
                            <span class="d-inline-block">Assessment</span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            <?php
                // } 
            ?>

            <?php
            //  if($this->session->userdata("UserType")!="Parent"){ 
            ?>
                <ul class="list-unstyled" data-link="announcements" id="announcements">
                    <li>
                        <a href="<?php echo base_url('announcements'); ?>">
                            <i class="simple-icon-picture"></i> <span class="d-inline-block">Announcements</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('surveys/list'); ?>">
                            <i class="simple-icon-picture"></i> <span class="d-inline-block">Survey</span>
                        </a>
                    </li>
                </ul>
            <?php
            //  } 
            ?>

            
            <ul class="list-unstyled" data-link="Healthy" id="Healthy">
                <li>
                    <a href="<?php echo base_url('menu'); ?>">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">Menu</span>
                    </a>
                </li>

                <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                
                <li>
                    <a href="<?php echo base_url('recipe'); ?>">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">Recipe</span>
                    </a>
                </li>

                <?php } ?>
              
            </ul>

            <ul class="list-unstyled" data-link="Daily" id="Daily">
                <li>
                    <a href="<?php echo base_url('dailyDiary/list'); ?>">
                    <i class="simple-icon-picture"></i><span class="txt-inner">Daily Diary</span>
                    </a>
                </li>
                <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                    <li>
                        <a href="<?php echo base_url('headChecks'); ?>">
                            <i class="simple-icon-picture"></i> <span class="d-inline-block">Head Checks</span>
                        </a>
                    </li>
                <?php } ?>
            
                <?php if($this->session->userdata("UserType")!="Parent"){ ?>
                     <li>
                        <a href="<?php echo base_url('headChecks/sleepchecklistindex'); ?>">
                            <i class="simple-icon-picture"></i> <span class="d-inline-block">Sleep Check List</span>
                        </a>
                    </li>
                    <?php } ?>


                <li>
                    <a href="<?php echo base_url('accident'); ?>">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">Accidents</span>
                    </a>
                </li>
            </ul>

            <ul class="list-unstyled" data-link="Lesson" id="Lesson">
                <li>
                    <a href="<?php echo base_url('progressPlan/list'); ?>">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">Record Montessori Progress</span>
                    </a>
                </li>
                <?php
                if($this->session->userdata("UserType")!="Parent"){  ?>
                <li>
                    <a href="<?php echo base_url('lessonplan'); ?>">
                        <i class="simple-icon-picture"></i> <span class="d-inline-block">Plan Montessori Lessons</span>
                    </a>
                </li>
                <?php }  ?>
            </ul>

        </div>
    </div>
</div>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadImageModalLabel">Upload Profile Picture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="imageUploadForm">
                    <input type="hidden" id="userId" value="<?= $this->session->userdata('LoginId'); ?>">

                    <!-- Image Preview -->
                    <div class="form-group text-center">
                        <img id="imagePreview" src="<?= base_url(); ?>api/assets/media/<?php echo $this->session->userdata('ImgUrl');?>" width="100" height="100" style="border-radius: 50%;" />
                    </div>

                    <!-- Upload Guidelines -->
                    <div class="alert alert-info">
                        <strong>Upload Guidelines:</strong><br>
                        - Supported formats: <b>JPG, JPEG, PNG, GIF, WEBP, HEIC, HEIF</b> <br>
                        - Maximum size: <b>2MB</b>
                    </div>

                    <div class="form-group">
                        <input type="file" class="form-control-file" id="profileImage" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Allowed file extensions
        var allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'heic', 'heif'];

        // Preview Image
        $("#profileImage").change(function() {
            var file = this.files[0];

            if (file) {
                var fileName = file.name;
                var fileSize = file.size / 1024 / 1024; // Convert to MB
                var fileExt = fileName.split('.').pop().toLowerCase();

                // Validate file extension
                if (!allowedExtensions.includes(fileExt)) {
                    Swal.fire("Invalid File", "Please upload a valid image format (JPG, JPEG, PNG, GIF, WEBP, HEIC, HEIF)", "error");
                    $(this).val(''); // Clear file input
                    return;
                }

                // Validate file size
                if (fileSize > 2) {
                    Swal.fire("File Too Large", "Image size must be under 2MB", "error");
                    $(this).val(''); // Clear file input
                    return;
                }

                // Display preview
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#imagePreview").attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle Upload
        $("#imageUploadForm").submit(function(e) {
            e.preventDefault();

            var formData = new FormData();
            formData.append("imageUrl", $("#profileImage")[0].files[0]);
            formData.append("userId", $("#userId").val());

            $.ajax({
                url: "<?= base_url('Settings/uploadProfileImage'); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    Swal.fire({
                        title: "Uploading...",
                        text: "Please wait while we upload your image.",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.close();
                    var res = JSON.parse(response);
                    if (res.status === "success") {
                        Swal.fire("Success!", res.message, "success").then(() => {
                            location.reload(); // Reload to reflect the new image
                        });
                    } else {
                        Swal.fire("Error!", res.message, "error");
                    }
                },
                error: function() {
                    Swal.fire("Error!", "Something went wrong. Please try again.", "error");
                }
            });
        });
    });
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the body element
    const body = document.getElementById('app-container');

    // Set the initial body class to ensure submenus are hidden
    body.className = "menu-default ltr rounded menu-sub-hidden sub-hidden";

    // Select all submenus and hide them on page load
    const submenus = document.querySelectorAll('.sub-menu ul');
    submenus.forEach(submenu => {
        submenu.style.display = 'none';
    });

    // Show submenu only when parent is clicked
    const mainMenuItems = document.querySelectorAll('.main-menu a[href^="#"]');

    mainMenuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetSubmenu = document.querySelector(`[data-link="${targetId}"]`);

            if (targetSubmenu) {
                const isVisible = targetSubmenu.style.display === 'none';

                // Hide all submenus first
                submenus.forEach(submenu => {
                    submenu.style.display = 'none';
                });

                

                // Toggle target submenu
                if (isVisible) {
                    targetSubmenu.style.display = 'none';
                    body.className = "menu-default ltr rounded menu-sub-hidden sub-hidden"; // Hidden state
                } else {
                    targetSubmenu.style.display = 'block';
                    body.className = "ltr rounded menu-default menu-sub-hidden sub-show-temporary"; // Visible state
                }
            }
        });
    });

    

    // Function to handle active state and scrolling
    function handleActiveMenuItem() {
        const currentPath = window.location.pathname;
        let activeMainItem = null;
        let activeSubItem = null;

        // Check main menu items
        document.querySelectorAll('.main-menu a').forEach(item => {
            const href = item.getAttribute('href');
            if (href && !href.startsWith('#')) {
                const cleanHref = href.replace('<?php echo base_url(); ?>', '');
                if (currentPath.includes(cleanHref)) {
                    item.parentElement.classList.add('active');
                    activeMainItem = item.parentElement;
                }
            }
        });

        // Check submenu items
        document.querySelectorAll('.sub-menu a').forEach(item => {
            const href = item.getAttribute('href');
            if (href) {
                const cleanHref = href.replace('<?php echo base_url(); ?>', '');
                if (currentPath.includes(cleanHref)) {
                    // Find parent submenu and main menu item
                    const parentSubmenu = item.closest('ul');
                    if (parentSubmenu) {
                        const dataLink = parentSubmenu.getAttribute('data-link');
                        const mainMenuItem = document.querySelector(`.main-menu a[href="#${dataLink}"]`);
                        if (mainMenuItem) {
                            // Add active classes
                            mainMenuItem.parentElement.classList.add('active');
                            item.parentElement.classList.add('active');
                            activeSubItem = item.parentElement;
                            activeMainItem = mainMenuItem.parentElement;
                        }
                    }
                }
            }
        });

        // Scroll to active main menu item
        if (activeMainItem) {
            const mainScroll = activeMainItem.closest('.scroll');
            if (mainScroll) {
                setTimeout(() => {
                    const topPos = activeMainItem.offsetTop - (mainScroll.clientHeight / 2);
                    mainScroll.scrollTo({
                        top: Math.max(0, topPos)
                    });
                }, 100);
            }
        }
    }

    // Initialize when page loads
    handleActiveMenuItem();

    // Handle browser back/forward buttons
    window.addEventListener('popstate', handleActiveMenuItem);
});

</script>