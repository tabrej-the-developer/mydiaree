<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<!-- jQuery (if not already included) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <title>NextGen Montessori Program Plan</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .page {
            margin-bottom: 30px;
            page-break-after: always;
        }

        /* .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            background: linear-gradient(to right, #8a7fb9, #e198b4, #87ceeb, #90ee90, #f4a460);
            padding: 20px;
            border-radius: 10px;
        } */

        .header {
    text-align: center;
    margin-bottom: 20px;
    position: relative;
    /* padding: 20px; */
    border-radius: 10px;
    background-image: url("<?= base_url(); ?>api/assets/media/header_top.png"); /* Use url() for image */
    background-size: contain; 
    background-repeat: no-repeat; 
                 }

        .header img {
    padding: 20px;

            max-width: 300px;
        }

        .program-title {
            text-align: center;
            font-size: 1.2em;
            margin: 20px 0;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 20px; */
        }

        th, td {
            border: 1px solid #000;
            padding: 10px;
            vertical-align: top;
        }

        .room-name-row td {
            height: 30px;
        }

        .educators-row td {
            height: 30px;
        }

        .main-content-row td {
            height: 400px;
        }

        .focus-area {
            text-align: left;
            padding-right: 10px;
        }

        .planned-experiences {
            font-weight: bold;
            color: navy;
            margin-bottom: 10px;
        }

        .eylf-section {
            border: 1px solid #000;
            /* padding: 10px; */
            margin-top: 0px;
            min-height: 150px;
        }

        .outdoor-section {
            border: 1px solid #000;
            padding: 10px;
            min-height: 100px;
            /* margin-bottom: 20px; */
        }

        .section-label {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 0.8em;
            margin-top: 20px;
            color: #666;
            position: relative;
            bottom: 0;
        }

        .corner-decoration {
            position: absolute;
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #87ceeb, transparent);
            border-radius: 50%;
        }

        .top-left { top: 0; left: 0; transform: translate(-50%, -50%); }
        .top-right { top: 0; right: 0; transform: translate(50%, -50%); }
        .bottom-left { bottom: 0; left: 0; transform: translate(-50%, 50%); }
        .bottom-right { bottom: 0; right: 0; transform: translate(50%, 50%); }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        @media print {
            .print-button {
                display: none;
            }

            
            body {
                margin: 0;
                padding: 0;
            }

            .page {
                margin: 0;
                padding: 20px;
            }

            @page {
                size: A4;
                margin: 0;
            }

            .header {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            /* Force background images and colors to print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            
        }



    </style>


<style>
    @media screen {
        .print-only {
            display: none !important;
        }
    }
    
    @media print {
        .screen-only { 
            display: none !important;
        }
        .print-only {
            display: block !important;
        }
    }
</style>

<style>
    @media screen {
        .print-only {
            display: none !important;
        }
    }
    
    @media print {
        .screen-only {
            display: none !important;
        }
        .print-only {
            display: block !important;
        }
    }
</style>

</head>
<body>
    
    <button onclick="window.print()" class="print-button">Print Pages</button>

    <!-- Page 1 -->
    <div class="page"> 
      

        <div class="header">
            <!-- <div class="corner-decoration top-left"></div> -->
            <!-- <div class="corner-decoration top-right"></div> -->
            <!-- <img src="<?= base_url(); ?>api/assets/media/header_top.png ?>"> -->
            <img src="<?= base_url(); ?>api/assets/media/profile_1739442700.jpeg ?>" alt="NextGen Montessori Logo">
        </div>

        <div class="program-title">PROGRAM PLAN Month</div>

        <table>
            <tr class="room-name-row">
                <td colspan="1" style="font-weight: bold;">Room Name</td>
                
                <td colspan="3">
        <!-- Hidden select for functionality -->
        <select id="room" name="room[]" multiple class="select2-multiple screen-only">
            <?php foreach($rooms as $room): ?>
                <option value="<?php echo $room->id; ?>">
                    <?php echo $room->name; ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <!-- Print-friendly display -->
        <span id="printable-rooms" class="print-only"></span>
    </td>
                <td rowspan="2" style="font-weight: bold; min-width: 60px;" class="focus-area">Focus Area</td>
                <td rowspan="2" style="min-width: 120px;"></td>
            </tr>
            <tr class="educators-row">
    <td colspan="1" style="font-weight: bold;">Educators</td>
    <td colspan="3">
        <!-- Hidden select for functionality -->
        <select id="educators" name="educators[]" multiple class="select2-multiple screen-only">
            <?php foreach($users as $user): ?>
                <?php if($user->userType == 'Staff'): ?>
                    <option value="<?php echo $user->userid; ?>">
                        <?php echo $user->name; ?>
                    </option>
                <?php endif; ?>
                <?php endforeach; ?>
            </select>
        
        <!-- Print-friendly display -->
        <span id="printable-educators" class="print-only"></span>
    </td>
</tr>
            <tr>
                <th>Practical Life</th>
                <th>Sensorial</th>
                <th>Math</th>
                <th>Language</th>
                <th>Culture</th>
                <th>Art & Craft</th>
            </tr>
            <tr class="main-content-row">
                <td>
                    <div class="planned-experiences">Planned experiences:</div>
                </td>
                <td>
                    <div class="planned-experiences">Planned experiences:</div>
                </td>
                <td>
                    <div class="planned-experiences">Planned experiences:</div>
                </td>
                <td>
                    <div class="planned-experiences">Planned experiences:</div>
                </td>
                <td>
                    <div class="planned-experiences">Planned experiences:</div>
                </td>
                <td>
                    <div class="planned-experiences">Planned experiences:</div>
                </td>
            </tr>
        </table>

        <div class="eylf-section">
            <div class="section-label" style="margin:10px;">EYLF:</div>
        </div>

        <div class="footer">
        <div>1 Capricorn Road, Truganina, VIC 3029 </div>
        <img src="<?= base_url(); ?>api/assets/media/footer_down.png ?>" style="background-size: contain;background-repeat: no-repeat; position: relative;width:100%;">

          
        </div>
    </div>

    <!-- Page 2 -->
    <div class="page">
        <div class="header">
            <!-- <div class="corner-decoration top-left"></div> -->
            <!-- <div class="corner-decoration top-right"></div> -->
            <img src="<?= base_url(); ?>api/assets/media/profile_1739442700.jpeg ?>" alt="NextGen Montessori Logo">
        </div>

        <div class="outdoor-section">
            <div class="section-label">Outdoor Experiences:</div>
        </div>

        <table>
            <tr>
                <td style="width: 33%;height: 150px;">
                    <div class="section-label">Inquiry Topic:</div>
                </td>
                <td style="width: 33%;height: 150px;">
                    <div class="section-label">Sustainability Topic:</div>
                </td>
                <td style="width: 33%;height: 150px;">
                    <div class="section-label">Special Events:</div>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td colspan="3" style=" height: 150px;">
                    <div class="section-label">Children's Voices:</div>
                </td>
                <td style="">
                    <div class="section-label">Families Input:</div>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 33%; height: 150px;">
                    <div class="section-label">Group Experience:</div>
                </td>
                <td style="width: 33%;">
                    <div class="section-label">Spontaneous Experience:</div>
                </td>
                <td style="width: 33%;">
                    <div class="section-label">Mindfulness Experiences:</div>
                </td>
            </tr>
        </table>

        <div class="footer">
            1 Capricorn Road, Truganina, VIC 3029
            <img src="<?= base_url(); ?>api/assets/media/footer_down.png ?>" style="background-size: contain;background-repeat: no-repeat; position: relative;width:100%;">

        </div>
    </div>


  
        <script>
$(document).ready(function() {
    $('.select2-multiple').select2({
        placeholder: "Select Rooms",
        allowClear: true,
        width: '100%'
    });

    // Update printable text whenever selection changes
    $('.select2-multiple').on('change', function() {
        var selectedTexts = $(this).find(':selected').map(function() {
            return $(this).text();
        }).get();
        
        $('#printable-rooms').text(selectedTexts.join(', '));
    });
});
</script>
      
<script>
$(document).ready(function() {
    $('#educators').select2({
        placeholder: "Select Educators",
        allowClear: true,
        width: '100%'
    });

    // Update printable text whenever selection changes
    $('#educators').on('change', function() {
        var selectedTexts = $(this).find(':selected').map(function() {
            return $(this).text();
        }).get();
        
        $('#printable-educators').text(selectedTexts.join(', '));
    });
});
</script>

</body>
</html>