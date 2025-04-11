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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

    <style>
        .table-responsive {
            margin-top: 5px;
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>


    <main data-centerid="">

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 style="margin-left:20px;margin-top:25px;">Manage Public Holidays</h4>
                        <button type="button" class="btn btn-info" style="margin-right:20px;margin-top:25px;" data-toggle="modal" data-target="#uploadExcelModal">
    <i class="fas fa-plus"></i> Upload Excel Sheet
</button>
                        <button type="button" class="btn btn-primary" style="margin-right:20px;margin-top:25px;" id="addNewBtn">
                            <i class="fas fa-plus"></i> Add New
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="holidayTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>State</th>
                                        <th>Date</th>
                                        <th>Month</th>
                                        <th>Occasion</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Add/Edit Modal -->
<div class="modal fade" id="holidayModal" tabindex="-1" aria-labelledby="holidayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="holidayModalLabel">Add Public Holiday</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="holidayForm">
                    <input type="hidden" id="holidayId" name="id">
                    <input type="hidden" id="isRangeInput" name="isRange" value="0">
                    
                    <div class="mb-3">
                        <label for="state" class="form-label">State</label>
                        <select class="form-select" id="state" name="state" required>
                            <option value="">Select State</option>
                            <option value="Victoria">Victoria</option>
                            <option value="New South Wales">New South Wales</option>
                        </select>
                    </div>
                    
                    <!-- Single date fields (visible in edit mode) -->
                    <div id="singleDateFields">
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="number" class="form-control" id="date" name="date" min="1" max="31">
                        </div>
                        
                        <div class="mb-3">
                            <label for="month" class="form-label">Month</label>
                            <input type="number" class="form-control" id="month" name="month" min="1" max="12">
                        </div>
                    </div>
                    
                    <!-- Date range fields (visible in add mode) -->
                    <div id="dateRangeFields">
                        <div class="mb-3">
                            <label for="fromDate" class="form-label">From Date</label>
                            <input type="date" class="form-control" id="fromDate" name="fromDate">
                        </div>
                        
                        <div class="mb-3">
                            <label for="toDate" class="form-label">To Date (Optional)</label>
                            <input type="date" class="form-control" id="toDate" name="toDate">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="occasion" class="form-label">Occasion</label>
                        <input type="text" class="form-control" id="occasion" name="occasion" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveHoliday">Save</button>
            </div>
        </div>
    </div>
</div>


    <!-- Modal for Excel Upload -->
<div class="modal fade" id="uploadExcelModal" tabindex="-1" role="dialog" aria-labelledby="uploadExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadExcelModalLabel">Upload Holiday Excel Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="uploadResponse"></div>
                <form id="excelUploadForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="excelfile">Select Excel File</label>
                        <input type="file" name="excelfile" id="excelfile" class="form-control" accept=".xlsx, .xls, .csv" required>
                        <small class="form-text text-muted">Only Excel files (.xlsx, .xls) or CSV files are allowed</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnUploadExcel">Upload</button>
            </div>
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


    <!-- Add these in the <head> section if not already included -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


    <!-- Add this at the end of your page, before the closing </body> tag -->
<script>
$(document).ready(function() {
    $('#btnUploadExcel').click(function() {
        var formData = new FormData();
        var fileInput = $('#excelfile')[0];
        
        // Validate if file is selected
        if (fileInput.files.length === 0) {
            $('#uploadResponse').html('<div class="alert alert-danger">Please select an Excel file to upload.</div>');
            return;
        }
        
        // Add file to form data
        formData.append('excelfile', fileInput.files[0]);
        
        // Show loading message
        $('#uploadResponse').html('<div class="alert alert-info">Uploading and processing your file. Please wait...</div>');
        
        // Send AJAX request
        $.ajax({
            url: '<?php echo base_url('Settings/upload_ajax'); ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
    // Try to extract just the JSON part
    var jsonResponse = response;
    
    // Check if the response contains both error text and JSON
    if (response.includes('{"status"')) {
        // Extract just the JSON part
        jsonResponse = response.substring(response.indexOf('{"status"'));
    }
    
    try {
        var data = JSON.parse(jsonResponse);
        if (data.status === 'success') {
            $('#uploadResponse').html('<div class="alert alert-success">' + data.message + '</div>');
            // Reset the file input
            $('#excelUploadForm')[0].reset();
            // Optionally refresh the page or table after 2 seconds
            setTimeout(function() {
                location.reload();
            }, 2000);
        } else {
            $('#uploadResponse').html('<div class="alert alert-danger">' + data.message + '</div>');
        }
    } catch (e) {
        // If JSON parsing fails, show the error
        console.error("Failed to parse response:", e);
        $('#uploadResponse').html('<div class="alert alert-danger">Server returned an invalid response. Please try again.</div>');
    }
},
            error: function(xhr, status, error) {
                $('#uploadResponse').html('<div class="alert alert-danger">An error occurred: ' + error + '</div>');
            }
        });
    });
});
</script>
  

    </body>


      <!-- Scripts -->
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> -->
    <script>
    $(document).ready(function() {
    // Load holiday data
    loadHolidays();
    
    // Initialize modal
    const holidayModal = new bootstrap.Modal(document.getElementById('holidayModal'));
    
    // Add New button click
    $('#addNewBtn').click(function() {
        $('#holidayModalLabel').text('Add Public Holiday');
        $('#holidayForm')[0].reset();
        $('#holidayId').val('');
        $('#isRangeInput').val('1');
        
        // Show date range fields, hide single date fields
        $('#dateRangeFields').show();
        $('#singleDateFields').hide();
        
        holidayModal.show();
    });
    
    // Save holiday (Add/Edit)
    $('#saveHoliday').click(function() {
        const id = $('#holidayId').val();
        const isRange = $('#isRangeInput').val() === '1';
        
        // Validate form based on mode (add or edit)
        if (!$('#state').val() || !$('#occasion').val()) {
            alert('Please fill all required fields');
            return;
        }
        
        if (id) {
            // Edit mode - validate single date fields
            if (!$('#date').val() || !$('#month').val()) {
                alert('Please fill all required fields');
                return;
            }
        } else {
            // Add mode - validate date range
            if (!$('#fromDate').val()) {
                alert('Please enter at least the From Date');
                return;
            }
        }
        
        // Get form data
        const formData = $('#holidayForm').serialize();
        
        // Determine if adding or editing
        const url = id ? '<?= base_url('Settings/updateHoliday') ?>' : '<?= base_url('Settings/addHoliday') ?>';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    holidayModal.hide();
                    loadHolidays();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
    
    // Handle Edit button click (using event delegation)
    $('#holidayTable').on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        
        $.ajax({
            url: '<?= base_url('Settings/getHoliday') ?>',
            type: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                const holiday = response.data;
                
                $('#holidayModalLabel').text('Edit Public Holiday');
                $('#holidayForm')[0].reset();
                $('#holidayId').val(holiday.id);
                $('#state').val(holiday.state);
                $('#date').val(holiday.date);
                $('#month').val(holiday.month);
                $('#occasion').val(holiday.occasion);
                $('#isRangeInput').val('0');
                
                // Show single date fields, hide date range fields
                $('#singleDateFields').show();
                $('#dateRangeFields').hide();
                
                holidayModal.show();
            },
            error: function() {
                alert('Failed to fetch holiday details.');
            }
        });
    });
    
    // Handle Delete button click (using event delegation)
    $('#holidayTable').on('click', '.delete-btn', function() {
        if (confirm('Are you sure you want to delete this holiday?')) {
            const id = $(this).data('id');
            
            $.ajax({
                url: '<?= base_url('Settings/deleteHoliday') ?>',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        loadHolidays();
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });
});
        
        // Function to load holidays via AJAX
        function loadHolidays() {
            $.ajax({
                url: '<?= base_url('Settings/getHolidays') ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
    const holidays = response.data;
    let html = '';

    // Month mapping array
    const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    $.each(holidays, function(index, holiday) {
        const monthName = monthNames[holiday.month - 1]; // Convert month number to month name

        html += `
            <tr>
                <td>${index + 1}</td> <!-- Serial number -->
                <td>${holiday.state}</td>
                <td>${holiday.date}</td>
                <td>${monthName}</td>
                <td>${holiday.occasion}</td>
                <td class="action-buttons">
                    <button class="btn btn-sm btn-primary edit-btn" data-id="${holiday.id}">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="${holiday.id}">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            </tr>
        `;
    });

    if (holidays.length === 0) {
        html = '<tr><td colspan="6" class="text-center">No public holidays found</td></tr>';
    }

    $('#holidayTable tbody').html(html);
},
                error: function() {
                    $('#holidayTable tbody').html('<tr><td colspan="6" class="text-center">Failed to load data</td></tr>');
                }
            });
        }
    </script>

    </html>