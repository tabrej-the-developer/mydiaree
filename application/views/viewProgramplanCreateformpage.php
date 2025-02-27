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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- Add this CSS to your <head> section or include in your CSS file -->
<style>
    .eylf-tree .list-group-item {
        border-left: none;
        border-right: none;
        border-radius: 0;
    }
    
    .eylf-framework {
        background-color: #f8f9fa;
    }
    
    .eylf-outcomes-container {
        background-color: #ffffff;
        padding-left: 2rem;
    }
    
    .eylf-outcome {
        background-color: #ffffff;
        padding-left: 4rem;
    }
    
    .eylf-activity {
        background-color: #ffffff;
        padding-left: 6rem;
    }
    
    .toggle-icon {
        cursor: pointer;
        width: 20px;
        text-align: center;
    }
    
    .toggle-icon.expanded i {
        transform: rotate(90deg);
    }
</style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <main data-centerid="<?= isset($centerid)?$centerid:null; ?>">
    <h2>Create Program Plan</h2>

<!-- Form container -->
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Create Program Plan</h4>
            <form id="programPlanForm" method="post">

            <?php if(isset($plan_data) && $plan_data): ?>
        <input type="hidden" name="plan_id" value="<?= $plan_data->id ?>">
    <?php endif; ?>
         
            <input type="hidden" name="centerid" id="centerid" value="<?= isset($centerid)?$centerid:null; ?>";>
<input type="hidden" name="user_id" id="user_id" value="<?= isset($user_id)?$user_id:null; ?>";>

          
<div class="form-group mb-4">
        <label for="months">Select Month</label>
        <select class="form-control" id="months" name="months" required>
            <option value="">Select Month</option>
            <?php
            $months = [
                '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
                '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
                '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
            ];
            foreach ($months as $key => $month): ?>
                <option value="<?= $key ?>" <?= (isset($plan_data) && $plan_data->months == $key) ? 'selected' : '' ?>><?= $month ?></option>
            <?php endforeach; ?>
        </select>
    
    </div>


                <!-- Room Selection -->
               <!-- Room Selection -->
    <div class="form-group mb-4">
        <label for="room">Select Room</label>
        <select class="form-control" id="room" name="room" required>
            <option value="">Select Room</option>
            <?php foreach($rooms as $room): ?>
                <option value="<?= $room->id ?>" <?= (isset($plan_data) && $plan_data->room_id == $room->id) ? 'selected' : '' ?>><?= $room->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>

                <!-- Users Multiple Selection -->
                <div class="form-group mb-4">
                    <label for="users">Select Educators</label>
                    <select class="form-control select2-multiple" id="users" name="users[]" multiple="multiple" required>
                        <!-- Options will be populated via AJAX -->
                    </select>
                </div>

                <!-- Children Multiple Selection -->
                <div class="form-group mb-4">
                    <label for="children">Select Children</label>
                    <select class="form-control select2-multiple" id="children" name="children[]" multiple="multiple" required>
                        <!-- Options will be populated via AJAX -->
                    </select>
                </div>

                <!-- Focus Areas Section -->
                <div class="card mb-4">
                  
                    <div class="card-body">

                    <div class="form-group mb-3">
                            <label>Focus Areas</label>
                            <input type="text" class="form-control" name="focus_area" placeholder="Focus Area" value="<?= isset($plan_data) ? $plan_data->focus_area : '' ?>">
                        </div>
                        <!-- Practical Life -->
                        <div class="form-group mb-3">
                            <label>Practical Life</label>
                            <input type="text" class="form-control" name="practical_life" value="<?= isset($plan_data) ? $plan_data->practical_life : '' ?>" placeholder="Practical Life">
                            <input type="text" class="form-control mt-2" name="practical_life_experiences" value="<?= isset($plan_data) ? $plan_data->practical_life_experiences : '' ?>" placeholder="Planned experiences">
                        </div>

                        <!-- Sensorial -->
                        <div class="form-group mb-3">
                            <label>Sensorial</label>
                            <input type="text" class="form-control" name="sensorial" value="<?= isset($plan_data) ? $plan_data->sensorial : '' ?>" placeholder="Sensorial">
                            <input type="text" class="form-control mt-2" name="sensorial_experiences" value="<?= isset($plan_data) ? $plan_data->sensorial_experiences : '' ?>" placeholder="Planned experiences">
                        </div>

                        <!-- Math -->
                        <div class="form-group mb-3">
                            <label>Math</label>
                            <input type="text" class="form-control" name="math" value="<?= isset($plan_data) ? $plan_data->math : '' ?>" placeholder="Math">
                            <input type="text" class="form-control mt-2" name="math_experiences" value="<?= isset($plan_data) ? $plan_data->math_experiences : '' ?>" placeholder="Planned experiences">
                        </div>

                        <!-- Language -->
                        <div class="form-group mb-3">
                            <label>Language</label>
                            <input type="text" class="form-control" name="language" value="<?= isset($plan_data) ? $plan_data->language : '' ?>" placeholder="Language">
                            <input type="text" class="form-control mt-2" name="language_experiences" value="<?= isset($plan_data) ? $plan_data->language_experiences : '' ?>" placeholder="Planned experiences">
                        </div>

                        <!-- Culture -->
                        <div class="form-group mb-3">
                            <label>Culture</label>
                            <input type="text" class="form-control" name="culture" value="<?= isset($plan_data) ? $plan_data->culture : '' ?>" placeholder="Culture">
                            <input type="text" class="form-control mt-2" name="culture_experiences" value="<?= isset($plan_data) ? $plan_data->culture_experiences : '' ?>" placeholder="Planned experiences">
                        </div>

                        <!-- Art & Craft -->
                        <div class="form-group mb-3">
                            <label>Art & Craft</label>
                            <input type="text" class="form-control" name="art_craft" value="<?= isset($plan_data) ? $plan_data->art_craft : '' ?>" placeholder="Art & Craft">
                            <input type="text" class="form-control mt-2" name="art_craft_experiences" value="<?= isset($plan_data) ? $plan_data->art_craft_experiences : '' ?>" placeholder="Planned experiences">
                        </div>
                    </div>
                </div>

                <!-- Additional Experiences Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Additional Experiences</h5>
                    </div>
                    <div class="card-body">
                        
                    <div class="form-group mb-3">
    <label for="eylf">EYLF</label>
    <div class="input-group">
    <textarea class="form-control" id="eylf" name="eylf" rows="3" readonly><?= isset($plan_data) ? $plan_data->eylf : '' ?></textarea>
        <div class="input-group-append">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#eylfModal">
                <i class="fa fa-search"></i> Select EYLF
            </button>
        </div>
    </div>
</div>


                        <div class="form-group mb-3">
                            <label for="outdoor_experiences">Outdoor Experiences</label>
                            <textarea class="form-control" id="outdoor_experiences" name="outdoor_experiences" rows="3"><?= isset($plan_data) ? $plan_data->outdoor_experiences : '' ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="inquiry_topic">Inquiry Topic</label>
                            <textarea class="form-control" id="inquiry_topic" name="inquiry_topic"  rows="3"><?= isset($plan_data) ? $plan_data->inquiry_topic : '' ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="sustainability_topic">Sustainability Topic</label>
                            <textarea class="form-control" id="sustainability_topic" name="sustainability_topic" rows="3"><?= isset($plan_data) ? $plan_data->sustainability_topic : '' ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="special_events">Special Events</label>
                            <textarea class="form-control" id="special_events" name="special_events" rows="3"><?= isset($plan_data) ? $plan_data->special_events : '' ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="children_voices">Children's Voices</label>
                            <textarea class="form-control" id="children_voices" name="children_voices"  rows="3"><?= isset($plan_data) ? $plan_data->children_voices : '' ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="families_input">Families Input</label>
                            <textarea class="form-control" id="families_input" name="families_input"  rows="3"><?= isset($plan_data) ? $plan_data->families_input : '' ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="group_experience">Group Experience</label>
                            <textarea class="form-control" id="group_experience" name="group_experience" rows="3"><?= isset($plan_data) ? $plan_data->group_experience : '' ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="spontaneous_experience">Spontaneous Experience</label>
                            <textarea class="form-control" id="spontaneous_experience" name="spontaneous_experience" rows="3"><?= isset($plan_data) ? $plan_data->spontaneous_experience : '' ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="mindfulness_experiences">Mindfulness Experiences</label>
                            <textarea class="form-control" id="mindfulness_experiences" name="mindfulness_experiences"  rows="3"><?= isset($plan_data) ? $plan_data->mindfulness_experiences : '' ?></textarea>
                        </div>
                    </div>
                </div>

                <?php if(isset($plan_data) && $plan_data): ?>
               
                <?php else: ?>
                    <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <?php endif; ?>
                
            </form>
        </div>
    </div>
</div>


</main>




<!-- EYLF Modal -->
<div class="modal fade" id="eylfModal" tabindex="-1" role="dialog" aria-labelledby="eylfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eylfModalLabel">Select EYLF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height:500px;overflow-y:auto;">
                <div class="eylf-tree">
                    <ul class="list-group">
                        <!-- Main EYLF Framework -->
                        <li class="list-group-item eylf-framework">
                            <div class="d-flex align-items-center">
                                <span class="mr-2 toggle-icon" data-toggle="collapse" data-target="#eylfFramework">
                                    <i class="fa fa-chevron-right"></i>
                                </span>
                                <span>Early Years Learning Framework (EYLF) - Australia (V2.0 2022)</span>
                            </div>
                            
                            <!-- EYLF Framework content -->
                            <div id="eylfFramework" class="collapse mt-2">
                                <ul class="list-group">
                                    <!-- EYLF Learning Outcomes -->
                                    <li class="list-group-item eylf-outcomes-container">
                                        <div class="d-flex align-items-center">
                                            <span class="mr-2 toggle-icon" data-toggle="collapse" data-target="#eylfOutcomes">
                                                <i class="fa fa-chevron-right"></i>
                                            </span>
                                            <span>EYLF Learning Outcomes</span>
                                        </div>
                                        
                                        <!-- List of all outcomes -->
                                        <div id="eylfOutcomes" class="collapse mt-2">
                                            <ul class="list-group">
                                                <?php foreach ($eylf_outcomes as $outcome) : ?>
                                                <li class="list-group-item eylf-outcome">
                                                    <div class="d-flex align-items-center">
                                                        <span class="mr-2 toggle-icon" data-toggle="collapse" data-target="#outcome<?= $outcome->id ?>">
                                                            <i class="fa fa-chevron-right"></i>
                                                        </span>
                                                        <span><?= $outcome->title ?> - <?= $outcome->name ?></span>
                                                    </div>
                                                    
                                                    <!-- Activities for this outcome -->
                                                    <div id="outcome<?= $outcome->id ?>" class="collapse mt-2">
                                                        <ul class="list-group">
                                                            <?php foreach ($outcome->activities as $activity) : ?>
                                                            <li class="list-group-item eylf-activity">
                                                                <div class="form-check">
                                                                    <input class="form-check-input eylf-activity-checkbox"
                                                                           type="checkbox"
                                                                           value="<?= $activity->id ?>"
                                                                           id="activity<?= $activity->id ?>"
                                                                           data-outcome-id="<?= $outcome->id ?>"
                                                                           data-outcome-title="<?= $outcome->title ?>"
                                                                           data-outcome-name="<?= $outcome->name ?>"
                                                                           data-activity-title="<?= $activity->title ?>">
                                                                    <label class="form-check-label" for="activity<?= $activity->id ?>">
                                                                        <?= $activity->title ?>
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </li>
                                    
                                    <!-- You can add EYLF Practices and EYLF Principles here if needed -->
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveEylfSelections">Save selections</button>
            </div>
        </div>
    </div>
</div>








    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>

    </body>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
$(document).ready(function () {
    // Initialize Select2
    $('.select2').select2();
    
    // Store selected educators and children for edit mode
    var selectedEducators = <?= json_encode($selected_educators) ?>;
    var selectedChildren = <?= json_encode($selected_children) ?>;
    
    // Function to load educators with pre-selection
    function loadEducators(roomId, centerId) {
        $.ajax({
            url: '<?= base_url("LessonPlanList/get_room_users"); ?>',
            method: 'POST',
            data: { room_id: roomId, center_id: centerId },
            success: function (response) {
                let users = JSON.parse(response);
                $('#users').empty();
                
                users.forEach(user => {
                    let option = new Option(user.name, user.id, false, false);
                    $('#users').append(option);
                });
                
                // For edit mode: pre-select educators
                if (selectedEducators.length > 0) {
                    $('#users').val(selectedEducators).trigger('change');
                }
            }
        });
    }
    
    // Function to load children with pre-selection
    function loadChildren(roomId, centerId) {
        $.ajax({
            url: '<?= base_url("LessonPlanList/get_room_children"); ?>',
            method: 'POST',
            data: { room_id: roomId, center_id: centerId },
            success: function (response) {
                let children = JSON.parse(response);
                $('#children').empty();
                
                children.forEach(child => {
                    let option = new Option(child.name, child.id, false, false);
                    $('#children').append(option);
                });
                
                // For edit mode: pre-select children
                if (selectedChildren.length > 0) {
                    $('#children').val(selectedChildren).trigger('change');
                }
            }
        });
    }

    // Fetch users and children based on room selection
    $('#room').change(function () {
        let roomId = $(this).val();
        let centerId = $('#centerid').val();

        if (roomId) {
            loadEducators(roomId, centerId);
            loadChildren(roomId, centerId);
        }
    });
    
    // If in edit mode, trigger room change to load educators and children
    <?php if(isset($plan_data) && $plan_data): ?>
        // Trigger room change event to load educators and children
        let roomId = '<?= $plan_data->room_id ?>';
        let centerId = '<?= $centerid ?>';
        
        if (roomId) {
            loadEducators(roomId, centerId);
            loadChildren(roomId, centerId);
        }
    <?php endif; ?>

    // Form submission handler
    $('#programPlanForm').on('submit', function(e) {
        e.preventDefault();
        
        // If month field is disabled for edit mode, ensure the value is included
        if ($('#months').prop('disabled')) {
            // The hidden input field already handles this
        }
        
        $.ajax({
            url: '<?= base_url("LessonPlanList/save_program_planinDB"); ?>',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                const result = JSON.parse(response);
                if (result.success) {
                    window.location.href = result.redirect_url;
                } else {
                    alert('Error saving program plan. Please try again.');
                }
            },
            error: function() {
                alert('An error occurred while processing your request.');
            }
        });
    });
});
</script>


<script>
$(document).ready(function() {
    // Toggle menu items and rotate chevron - make each toggle independent
    $('.toggle-icon').on('click', function(e) {
        // Prevent the event from bubbling up
        e.stopPropagation();
        
        // Toggle only the clicked icon's expanded class
        $(this).toggleClass('expanded');
        
        // Change only this icon
        if ($(this).hasClass('expanded')) {
            $(this).find('i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        } else {
            $(this).find('i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        }
        
        // Toggle the collapse that this icon controls
        const targetId = $(this).data('target');
        $(targetId).collapse('toggle');
    });
    
    // When collapsible elements show/hide - only affect the direct parent toggle
    $('.collapse').on('show.bs.collapse', function(e) {
        // Stop event propagation to avoid triggering parent collapses
        e.stopPropagation();
        
        // Only find the toggle icon that directly controls this collapse
        const toggleIcon = $('[data-target="#' + $(this).attr('id') + '"]');
        toggleIcon.addClass('expanded').find('i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    }).on('hide.bs.collapse', function(e) {
        // Stop event propagation
        e.stopPropagation();
        
        // Only find the toggle icon that directly controls this collapse
        const toggleIcon = $('[data-target="#' + $(this).attr('id') + '"]');
        toggleIcon.removeClass('expanded').find('i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    });
    
    // Prevent collapse events from triggering multiple collapses
    $('.collapse').on('show.bs.collapse hide.bs.collapse', function(e) {
        // Only trigger for the element that received the click
        if (e.target !== this) {
            e.stopPropagation();
        }
    });
    
    // Save EYLF selections - rest of the code remains the same
    $('#saveEylfSelections').on('click', function() {
        var selectedActivities = [];
        
        $('.eylf-activity-checkbox:checked').each(function() {
            var activityId = $(this).val();
            var outcomeId = $(this).data('outcome-id');
            var outcomeTitle = $(this).data('outcome-title');
            var outcomeName = $(this).data('outcome-name');
            var activityTitle = $(this).data('activity-title');
            
            selectedActivities.push({
                activityId: activityId,
                outcomeId: outcomeId,
                outcomeTitle: outcomeTitle,
                outcomeName: outcomeName,
                activityTitle: activityTitle
            });
        });
        
        // Format the selected activities for display in the textarea
        var formattedText = '';
        if (selectedActivities.length > 0) {
            selectedActivities.forEach(function(item, index) {
                formattedText += item.outcomeTitle + ' - ' + item.outcomeName + ': ' + item.activityTitle;
                if (index < selectedActivities.length - 1) {
                    formattedText += '\n';
                }
            });
        }
        
        // Set the formatted text in the textarea
        $('#eylf').val(formattedText);
        
        // Store the raw data in a hidden input for form submission
        if (!$('#eylfData').length) {
            $('<input>').attr({
                type: 'hidden',
                id: 'eylfData',
                name: 'eylfData'
            }).appendTo('form');
        }
        $('#eylfData').val(JSON.stringify(selectedActivities));
        
        // Close the modal
        $('#eylfModal').modal('hide');
    });
});
</script>



</html>