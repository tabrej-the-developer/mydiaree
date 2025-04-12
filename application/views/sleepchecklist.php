<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SleepCheckList | Mydiaree</title>
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
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?id=1234"></script>
    <style>
        .drop-down{
            border: 1px solid #008ecc!important;
            border-bottom-left-radius: 50px!important;
            border-bottom-right-radius: 50px!important;
            border-top-left-radius: 50px!important;
            border-top-right-radius: 50px!important;
            background-color: transparent!important;
            color: #008ecc!important;
            text-transform: uppercase!important;
            font-weight: bold!important;
            display: block!important;
            line-height: 19.2px!important;
            font-size: 12.8px!important;
            letter-spacing: 0.8px!important;
            vertical-align: middle!important;
            padding: 12px 41.6px 9.6px 41.6px!important;
            height: 42.78px!important;
            text-align: center!important;
            -webkit-transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out;
            transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out;
            transition-property: color, background-color, border-color, box-shadow, -webkit-box-shadow;
            transition-duration: 0.15s, 0.15s, 0.15s, 0.15s, 0.15s;
            transition-timing-function: ease-in-out, ease-in-out, ease-in-out, ease-in-out, ease-in-out;
            transition-delay: 0s, 0s, 0s, 0s, 0s;
            transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;
            transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out,-webkit-box-shadow 0.15s ease-in-out;
        }

        .drop-down:hover{
            color: #ffffff!important;
            background-color: #008ecc!important;
        }
        .custom-cal{
            position: absolute;
            vertical-align: middle;
            top: 8px;
            right: 10px;
            border: none;
            color: #0085bf;
            background: transparent;
            pointer-events: none;
        }
        .custom-cal:hover{
            color: #ffffff;
            background-color: transparent;
        }
        .input-group-text{
            color: #008ecc!important;
            background-color: transparent!important;
        }
        .btn-lg{
            height: 42.78px!important;
        }
        .form-number{
            border: 1px solid #d7d7d7;
            outline: none;
            height: 35px;
        }
    </style>

<style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4f8;
      padding: 20px;
      color: #333;
    }
    .container {
      max-width: 1200px;
      margin: auto;
    }
    .child-section {
      background-color: #ffffff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .child-header {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 20px;
      color: #2c3e50;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }
    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #e1e4e8;
    }
    th {
      background-color: #ecf0f1;
      font-weight: 600;
    }
    input[type="time"],
    select,
    textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }
    textarea {
      resize: vertical;
    }
    .add-row-btn,
    .save-row-btn{
      background-color: #3498db;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 8px;
      cursor: pointer;
      margin: 5px;
      transition: background-color 0.3s ease;
    
    
    }
 
    .remove-row-btn {
        background-color: red;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 8px;
      cursor: pointer;
      margin: 5px;
      transition: background-color 0.3s ease;
    }
    .update-row-btn{
      background-color: #3498db;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 8px;
      cursor: pointer;
      margin: 5px;
      transition: background-color 0.3s ease;
    
    
    }
 
    .delete-row-btn {
        background-color: red;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 8px;
      cursor: pointer;
      margin: 5px;
      transition: background-color 0.3s ease;
    }

    .add-row-btn:hover,
    .save-row-btn:hover{
      background-color: #2980b9;
    }

    .remove-row-btn:hover {
    background-color: darkred;
    }
    
    .update-row-btn:hover{
      background-color: #2980b9;
    }

    .delete-row-btn:hover {
    background-color: darkred;
    }
  </style>

</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?> 
<main class="default-transition">
    <div class="default-transition">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12" style="margin-top: -15px;">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <h1>Sleep Check List</h1>
                            <div class="text-zero top-right-button-container d-flex flex-row">
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
                                <div class="btn-group mr-1">
                                    <?php 
                                        if(empty($rooms)){
                                    ?>
                                    <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> NO ROOMS AVAILABLE </div>
                                    <?php   
                                        }else{
                                            $count = count($rooms);
                                            $int = 0;
                                            foreach ($rooms as $room => $rObj) { 
                                                if ($rObj->id==$roomid || (isset($_GET['roomid']) && $_GET['roomid']==$rObj->id)) {
                                    ?>
                                    <div class="btn btn-outline-primary btn-lg dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?= strtoupper($rObj->name); ?> </div>
                                    <?php
                                                }
                                                $int++;
                                            }
                                    ?>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <?php foreach ($rooms as $room => $rObj) { ?>
                                            <a class="dropdown-item" href="<?= current_url().'?centerid='.$centerid.'&roomid='.$rObj->id; ?>">
                                                <?= strtoupper($rObj->name); ?>
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                                <?php 
                                    if (isset($_GET['date']) && $_GET['date'] != "") {
                                        $calDate = date('d-m-Y',strtotime($_GET['date']));
                                    }else if(isset($date)){
                                        $calDate = date('d-m-Y',strtotime($date));
                                    } else {
                                        $calDate = date('d-m-Y');
                                    }
                                ?>
                                <div class="form-group">
                                    <div class="input-group date">
                                        <input type="text" class="form-control drop-down" id="txtCalendar" name="start_date" value="<?= $calDate; ?>">
                                        <span class="input-group-text input-group-append input-group-addon custom-cal">
                                            <i class="simple-icon-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                                <ol class="breadcrumb pt-0" style="background-color: transparent;">
                                    <li class="breadcrumb-item">
                                        <a href="<?= base_url('dashboard'); ?>" style="color: dimgray;">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="#" style="color: dimgray;">Daily Journal</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Sleep Check List</li>
                                </ol>
                            </nav>
 
                        </div>
                    </div>
                    <div class="separator mb-5"></div>
                </div>

<input type="hidden" id="roomid" value="<?= $roomid ?>" >
<input type="hidden" id="date" value="<?= $calDate ?>" >

<div class="container">
  <?php foreach ($children as $index => $child): ?>
    <div class="child-section" id="child<?php echo $child->id; ?>">
      <div class="child-header">
      <?php if (!empty($child->imageUrl)): ?>
        <div class="child-avatar" style="display: inline-block; margin-right: 10px;">
          <img src="<?php echo base_url('api/assets/media/' . $child->imageUrl); ?>" alt="<?php echo htmlspecialchars($child->name); ?>" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
        </div>
        <?php else: ?>
        <div class="child-avatar" style="display: inline-block; margin-right: 10px;">
          <div style="width: 40px; height: 40px; border-radius: 50%; background-color: #ccc; display: inline-flex; align-items: center; justify-content: center;">
            <span style="font-size: 18px; color: #666;">
              <?php echo strtoupper(substr($child->name, 0, 1)); ?>
            </span>
          </div>
        </div>
        <?php endif; ?>
        <span><?php echo htmlspecialchars($child->name . ' ' . $child->lastname); ?></span>
      </div>

      <table>
        <thead>
          <tr>
            <th>Time</th>
            <th>Breathing</th>
            <th>Body Temperature</th>
            <th>Notes</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>

          <!-- Existing Saved Data Rows -->
          <?php
          $childSleepChecks = array_filter($sleepChecks, fn($sc) => $sc->childid == $child->id);
          usort($childSleepChecks, fn($a, $b) => strcmp($a->time, $b->time));
          foreach ($childSleepChecks as $sleep): ?>
            <tr data-id="<?= $sleep->id ?>">
              <td><input type="time" value="<?= $sleep->time ?>" /></td>
              <td>
                <select>
                  <option value="">Select</option>
                  <option value="Regular" <?= $sleep->breathing == 'Regular' ? 'selected' : '' ?>>Regular</option>
                  <option value="Fast" <?= $sleep->breathing == 'Fast' ? 'selected' : '' ?>>Fast</option>
                  <option value="Difficult" <?= $sleep->breathing == 'Difficult' ? 'selected' : '' ?>>Difficult</option>
                </select>
              </td>
              <td>
                <select>
                  <option value="">Select</option>
                  <option value="Warm" <?= $sleep->body_temperature == 'Warm' ? 'selected' : '' ?>>Warm</option>
                  <option value="Cool" <?= $sleep->body_temperature == 'Cool' ? 'selected' : '' ?>>Cool</option>
                  <option value="Hot" <?= $sleep->body_temperature == 'Hot' ? 'selected' : '' ?>>Hot</option>
                </select>
              </td>
              <td><textarea rows="2"><?= htmlspecialchars($sleep->notes) ?></textarea></td>
              <td>
                <button class="update-row-btn" onclick="updateRow(this, <?= $child->id ?>, <?= $sleep->id ?>)">Update</button>
                <button class="delete-row-btn" onclick="deleteRow(this, <?= $sleep->id ?>)">Delete</button>
              </td>
            </tr>
          <?php endforeach; ?>

          <!-- Empty Row for New Entry -->
          <tr>
            <td><input type="time" name="children[<?= $child->id ?>][time][]"></td>
            <td>
              <select name="children[<?= $child->id ?>][breathing][]">
                <option value="">Select</option>
                <option value="Regular">Regular</option>
                <option value="Fast">Fast</option>
                <option value="Difficult">Difficult</option>
              </select>
            </td>
            <td>
              <select name="children[<?= $child->id ?>][temperature][]">
                <option value="">Select</option>
                <option value="Warm">Warm</option>
                <option value="Cool">Cool</option>
                <option value="Hot">Hot</option>
              </select>
            </td>
            <td><textarea rows="2" name="children[<?= $child->id ?>][notes][]" placeholder="Sleep Check List Notes..."></textarea></td>
            <td>
              <button class="save-row-btn" onclick="saveRow(this, <?= $child->id ?>)">Save</button>
              <button class="remove-row-btn" onclick="removeRow(this)">Remove</button>
            </td>
          </tr>

        </tbody>
      </table>
      <button class="add-row-btn" onclick="addRow('child<?= $child->id ?>', <?= $child->id ?>)">+ Add 10-Min Entry</button>
    </div>
  <?php endforeach; ?>
</div>



















                </div>
        </div>
    </div>
</main>
    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?id=1234"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery.smartWizard.min.js" style="opacity: 1;"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap-datepicker.js?v=1.0.0"></script>
</body>

<script>
    function addRow(childId, childDbId) {
      const tableBody = document.querySelector(`#${childId} table tbody`);
      const row = document.createElement('tr');
      row.innerHTML = `
        <td><input type="time" name="children[${childDbId}][time][]"></td>
        <td>
          <select name="children[${childDbId}][breathing][]">
            <option value="">Select</option>
            <option value="Regular">Regular</option>
            <option value="Fast">Fast</option>
            <option value="Difficult">Difficult</option>
          </select>
        </td>
        <td>
          <select name="children[${childDbId}][temperature][]">
            <option value="">Select</option>
            <option value="Warm">Warm</option>
            <option value="Cool">Cool</option>
            <option value="Hot">Hot</option>
          </select>
        </td>
        <td><textarea rows="2" name="children[${childDbId}][notes][]" placeholder="Sleep Check List Notes..."></textarea></td>
        <td>
          <button class="save-row-btn" onclick="saveRow(this, ${childDbId})">Save</button>
          <button class="remove-row-btn" onclick="removeRow(this)">Remove</button>
        </td>
      `;
      tableBody.appendChild(row);
    }

    function removeRow(button) {
      button.closest('tr').remove();
    }

    function saveRow(button, childId) {
    const row = button.closest('tr');
    const timeInput = row.querySelector('input[type="time"]');
    const breathingSelect = row.querySelector('select[name*="breathing"]');
    const temperatureSelect = row.querySelector('select[name*="temperature"]');
    const notesTextarea = row.querySelector('textarea');

    var roomIdValue = document.getElementById("roomid").value;

    var dateValue = document.getElementById("date").value;

    // Get values
    const time = timeInput.value;
    const breathing = breathingSelect.value;
    const temperature = temperatureSelect.value;
    const notes = notesTextarea.value;

    // Validation
    if (!time) {
        alert('Please enter a time');
        timeInput.focus();
        return;
    }

    if (!breathing) {
        alert('Please select breathing status');
        breathingSelect.focus();
        return;
    }

    if (!temperature) {
        alert('Please select body temperature');
        temperatureSelect.focus();
        return;
    }

    // Prepare form data
    const formData = new FormData();
    formData.append('childid', childId);
    formData.append('roomid', roomIdValue);
    formData.append('diarydate', dateValue);
    formData.append('time', time);
    formData.append('breathing', breathing);
    formData.append('body_temperature', temperature);
    
    // Notes is optional, only append if it has value
    if (notes) {
        formData.append('notes', notes);
    }

    // Disable button during save to prevent duplicate submissions
    button.disabled = true;
    button.textContent = 'Saving...';

    fetch("<?= base_url('HeadChecks/sleep_checklist_save') ?>", {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(result => {
        if (result.success) {
            alert(result.message);
            // Update UI to reflect saved state
            button.textContent = 'Saved';
            setTimeout(() => {
            location.reload();
        }, 500);
            // Optional: Highlight the saved row or change its appearance
            // row.style.backgroundColor = '#f0fff0'; // Light green background
        } else {
            alert(result.message);
            // Re-enable button if save failed
            button.disabled = false;
            button.textContent = 'Save';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving data. Please try again.');
        // Re-enable button on error
        button.disabled = false;
        button.textContent = 'Save';
    });
}



function updateRow(button, childId, entryId) {
  const row = button.closest('tr');
  const time = row.querySelector('input[type="time"]').value;
  const selects = row.querySelectorAll('select');
const breathing = selects[0]?.value || '';
const temperature = selects[1]?.value || '';
  const notes = row.querySelector('textarea').value;
  const roomIdValue = document.getElementById("roomid").value;
  const dateValue = document.getElementById("date").value;

  console.log("breathing",breathing);
  console.log("row",row);
  console.log("entryId",entryId);
  console.log("temperature",temperature);
  if (!time || !breathing || !temperature) {
    alert("Please fill all fields.");
    return;
  }

  const formData = new FormData();
  formData.append('id', entryId);
  formData.append('childid', childId);
  formData.append('roomid', roomIdValue);
  formData.append('diarydate', dateValue);
  formData.append('time', time);
  formData.append('breathing', breathing);
  formData.append('body_temperature', temperature);
  formData.append('notes', notes);

  button.disabled = true;
  button.textContent = "Updating...";

  fetch("<?= base_url('HeadChecks/sleep_checklist_update') ?>", {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(result => {
      alert(result.message);
      button.disabled = false;
      button.textContent = "Update";
      location.reload();
    })
    .catch(err => {
      console.error(err);
      alert("Update failed.");
      button.disabled = false;
      button.textContent = "Update";
    });
}

function deleteRow(button, entryId) {
  if (!confirm("Are you sure you want to delete this entry?")) return;

  const formData = new FormData();
  formData.append('id', entryId);

  button.disabled = true;
  button.textContent = "Deleting...";

  fetch("<?= base_url('HeadChecks/sleep_checklist_delete') ?>", {
    method: 'POST',
    body: formData
  })
    .then(res => res.json())
    .then(result => {
      if (result.success) {
        button.closest('tr').remove();
        alert(result.message);
        location.reload();
      } else {
        alert(result.message);
        button.disabled = false;
        button.textContent = "Delete";
        location.reload();
      }
    })
    .catch(err => {
      console.error(err);
      alert("Delete failed.");
      button.disabled = false;
      button.textContent = "Delete";
    });
}

  </script>

  <script>
    	$(document).on('change','#txtCalendar',function(){
			// $('#headCheckForm').submit();
            let date = $(this).val();
            let url = "<?= base_url('HeadChecks/sleepchecklistindex').'?centerid='.$centerid.'&roomid='.$roomid.'&date='; ?>"+date;
            window.location.href = url;
		});
    </script>


</html>