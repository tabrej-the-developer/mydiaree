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
                            <option value="<?= $key ?>"><?= $month ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <!-- Room Selection -->
                <div class="form-group mb-4">
                    <label for="room">Select Room</label>
                    <select class="form-control" id="room" name="room" required>
                        <option value="">Select Room</option>
                        <?php foreach($rooms as $room): ?>
                            <option value="<?= $room->id ?>"><?= $room->name ?></option>
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
<input type="hidden" name="centerid" id="centerid" value="<?= isset($centerid)?$centerid:null; ?>";>
<input type="hidden" name="user_id" id="user_id" value="<?= isset($user_id)?$user_id:null; ?>";>
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
                            <input type="text" class="form-control" name="focus_area" placeholder="Focus Area">
                        </div>
                        <!-- Practical Life -->
                        <div class="form-group mb-3">
                            <label>Practical Life</label>
                            <input type="text" class="form-control" name="practical_life" placeholder="Practical Life">
                            <input type="text" class="form-control mt-2" name="practical_life_experiences" placeholder="Planned experiences">
                        </div>

                        <!-- Sensorial -->
                        <div class="form-group mb-3">
                            <label>Sensorial</label>
                            <input type="text" class="form-control" name="sensorial" placeholder="Sensorial">
                            <input type="text" class="form-control mt-2" name="sensorial_experiences" placeholder="Planned experiences">
                        </div>

                        <!-- Math -->
                        <div class="form-group mb-3">
                            <label>Math</label>
                            <input type="text" class="form-control" name="math" placeholder="Math">
                            <input type="text" class="form-control mt-2" name="math_experiences" placeholder="Planned experiences">
                        </div>

                        <!-- Language -->
                        <div class="form-group mb-3">
                            <label>Language</label>
                            <input type="text" class="form-control" name="language" placeholder="Language">
                            <input type="text" class="form-control mt-2" name="language_experiences" placeholder="Planned experiences">
                        </div>

                        <!-- Culture -->
                        <div class="form-group mb-3">
                            <label>Culture</label>
                            <input type="text" class="form-control" name="culture" placeholder="Culture">
                            <input type="text" class="form-control mt-2" name="culture_experiences" placeholder="Planned experiences">
                        </div>

                        <!-- Art & Craft -->
                        <div class="form-group mb-3">
                            <label>Art & Craft</label>
                            <input type="text" class="form-control" name="art_craft" placeholder="Art & Craft">
                            <input type="text" class="form-control mt-2" name="art_craft_experiences" placeholder="Planned experiences">
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
                            <textarea class="form-control" id="eylf" name="eylf" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="outdoor_experiences">Outdoor Experiences</label>
                            <textarea class="form-control" id="outdoor_experiences" name="outdoor_experiences" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="inquiry_topic">Inquiry Topic</label>
                            <textarea class="form-control" id="inquiry_topic" name="inquiry_topic" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="sustainability_topic">Sustainability Topic</label>
                            <textarea class="form-control" id="sustainability_topic" name="sustainability_topic" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="special_events">Special Events</label>
                            <textarea class="form-control" id="special_events" name="special_events" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="children_voices">Children's Voices</label>
                            <textarea class="form-control" id="children_voices" name="children_voices" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="families_input">Families Input</label>
                            <textarea class="form-control" id="families_input" name="families_input" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="group_experience">Group Experience</label>
                            <textarea class="form-control" id="group_experience" name="group_experience" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="spontaneous_experience">Spontaneous Experience</label>
                            <textarea class="form-control" id="spontaneous_experience" name="spontaneous_experience" rows="3"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="mindfulness_experiences">Mindfulness Experiences</label>
                            <textarea class="form-control" id="mindfulness_experiences" name="mindfulness_experiences" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>


</main>
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
            $('.select2').select2();

            // Fetch users and children based on room selection
            $('#room').change(function () {
                let roomId = $(this).val();
                let centerId = $('main').data('centerid');

                if (roomId) {
                    $.ajax({
                        url: '<?= base_url("LessonPlanList/get_room_users"); ?>',
                        method: 'POST',
                        data: { room_id: roomId, center_id: centerId },
                        success: function (response) {
                            let users = JSON.parse(response);
                            $('#users').empty();
                            users.forEach(user => {
                                $('#users').append(new Option(user.name, user.id));
                            });
                        }
                    });

                    $.ajax({
                        url: '<?= base_url("LessonPlanList/get_room_children"); ?>',
                        method: 'POST',
                        data: { room_id: roomId, center_id: centerId },
                        success: function (response) {
                            let children = JSON.parse(response);
                            $('#children').empty();
                            children.forEach(child => {
                                $('#children').append(new Option(child.name, child.id));
                            });
                        }
                    });
                }
            });
     


        $('#programPlanForm').on('submit', function(e) {
        e.preventDefault();
        
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





</html>