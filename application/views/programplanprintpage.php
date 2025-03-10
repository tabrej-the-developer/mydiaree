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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>NextGen Montessori Program Plan</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .page {
            margin
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


        .topdivs strong {
    display: inline-block;
    margin-bottom: 5px;
}
.topdivs ul {
    margin-top: 0;
    padding-left: 20px;
}

        .header {
    text-align: center;
    /* margin-top: 50px; */
    margin-bottom: 30px;
    position: relative;
    /* padding: 20px; */
    border-radius: 10px;
    /* background-image: url("<?= base_url(); ?>api/assets/media/header_top.png");  */
    /* Use url() for image */
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
            height: 380px;
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

        .back-button{
            position: fixed;
            top: 70px;
            right: 30px;
            padding: 10px 20px;
            background-color: #2ee9ef;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .topdivs {
            min-height:250px;
        }

        .bottomdivs{
            margin-top:10px;
        }

        @media print {
            .print-button {
                display: none;
            }
            .back-button {
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
    size: A3 landscape;
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
    
    <button onclick="window.print()" class="print-button">Print Pages&nbsp;<i class="fa-solid fa-print fa-beat-fade"></i></button>
    <button onclick="window.location.href='<?= base_url('LessonPlanList/programPlanList') ?>'" class="back-button">
    <i class="fa-solid fa-arrow-left fa-beat"></i>&nbsp;Go Back
</button>

    <!-- Page 1 -->
    <div class="page"> 
      

        <div class="header">

            <img src="<?= base_url(); ?>api/assets/media/profile_1739442700.jpeg" alt="NextGen Montessori Logo">
        </div>

        <div class="program-title">PROGRAM PLAN <span style="color:#22b1c4;"><?php echo $month_name?></span></div>

        <table>
            <tr class="room-name-row">
                <td colspan="1" style="font-weight: bold;">Room Name</td>
                
                <td colspan="3">
        <!-- Hidden select for functionality -->
        <?php echo $room_name ?>
                </td>

                <td rowspan="2" style="font-weight: bold; min-width: 60px;" class="focus-area">Focus Area</td>
                <td rowspan="2" style="min-width: 120px;">     <?php echo isset($plan['focus_area']) ? htmlspecialchars($plan['focus_area'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
            </tr>

            <tr class="educators-row">
                <td colspan="1" style="font-weight: bold;">Educators</td>
   
                 <td colspan="3"> 
                 <?php echo $educator_names ?>
                 </td>
           </tr>

            <tr class="educators-row">
                <td colspan="1" style="font-weight: bold;">Children</td>
   
                 <td colspan="5"> 
                 <?php echo $children_names ?>
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
                   
                <div class="topdivs">
    <?php 
    if (isset($plan['practical_life'])) { 
        $formatted_text = htmlspecialchars($plan['practical_life'], ENT_QUOTES, 'UTF-8'); 
        $lines = explode("\n", $formatted_text); 
        
        echo '<div>';
        $in_list = false;
        
        foreach ($lines as $line) {
            if (strpos($line, '**') === 0 && strpos($line, '** - ') !== false) {
                // Close previous list if open
                if ($in_list) {
                    echo '</ul>';
                    $in_list = false;
                }
                
                // This is an activity title
                echo '<strong>' . str_replace(['**', ' - '], '', $line) . '</strong>';
                echo '<ul>';
                $in_list = true;
            } elseif (strpos($line, '**• **') === 0) {
                // This is a sub-activity
                echo '<li>' . str_replace('**• **', '', $line) . '</li>';
            }
        }
        
        // Close the last list if open
        if ($in_list) {
            echo '</ul>';
        }
        
        echo '</div>'; 
    } else { 
        echo 'N/A'; 
    } 
    ?> 
</div>

                    <!-- <div class="planned-experiences">Planned experiences:</div> -->
                    <div class="bottomdivs">  <?php echo isset($plan['practical_life_experiences']) ? htmlspecialchars($plan['practical_life_experiences'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?> </div>
                </td>
                <td>

           <div class="topdivs">
    <?php 
    if (isset($plan['sensorial'])) { 
        $formatted_text = htmlspecialchars($plan['sensorial'], ENT_QUOTES, 'UTF-8'); 
        $lines = explode("\n", $formatted_text); 
        
        echo '<div>';
        $in_list = false;
        
        foreach ($lines as $line) {
            if (strpos($line, '**') === 0 && strpos($line, '** - ') !== false) {
                // Close previous list if open
                if ($in_list) {
                    echo '</ul>';
                    $in_list = false;
                }
                
                // This is an activity title
                echo '<strong>' . str_replace(['**', ' - '], '', $line) . '</strong>';
                echo '<ul>';
                $in_list = true;
            } elseif (strpos($line, '**• **') === 0) {
                // This is a sub-activity
                echo '<li>' . str_replace('**• **', '', $line) . '</li>';
            }
        }
        
        // Close the last list if open
        if ($in_list) {
            echo '</ul>';
        }
        
        echo '</div>'; 
    } else { 
        echo 'N/A'; 
    } 
    ?> 
</div>

                    <!-- <div class="planned-experiences">Planned experiences:</div> -->
                    <div class="bottomdivs">  <?php echo isset($plan['sensorial_experiences']) ? htmlspecialchars($plan['sensorial_experiences'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?> </div>
                </td>
                <td>


           <div class="topdivs">
    <?php 
    if (isset($plan['math'])) { 
        $formatted_text = htmlspecialchars($plan['math'], ENT_QUOTES, 'UTF-8'); 
        $lines = explode("\n", $formatted_text); 
        
        echo '<div>';
        $in_list = false;
        
        foreach ($lines as $line) {
            if (strpos($line, '**') === 0 && strpos($line, '** - ') !== false) {
                // Close previous list if open
                if ($in_list) {
                    echo '</ul>';
                    $in_list = false;
                }
                
                // This is an activity title
                echo '<strong>' . str_replace(['**', ' - '], '', $line) . '</strong>';
                echo '<ul>';
                $in_list = true;
            } elseif (strpos($line, '**• **') === 0) {
                // This is a sub-activity
                echo '<li>' . str_replace('**• **', '', $line) . '</li>';
            }
        }
        
        // Close the last list if open
        if ($in_list) {
            echo '</ul>';
        }
        
        echo '</div>'; 
    } else { 
        echo 'N/A'; 
    } 
    ?> 
</div>


                    <!-- <div class="planned-experiences">Planned experiences:</div> -->
                    <div class="bottomdivs">  <?php echo isset($plan['math_experiences']) ? htmlspecialchars($plan['math_experiences'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?> </div>
                </td>
                <td>


                <div class="topdivs">
    <?php 
    if (isset($plan['language'])) { 
        $formatted_text = htmlspecialchars($plan['language'], ENT_QUOTES, 'UTF-8'); 
        $lines = explode("\n", $formatted_text); 
        
        echo '<div>';
        $in_list = false;
        
        foreach ($lines as $line) {
            if (strpos($line, '**') === 0 && strpos($line, '** - ') !== false) {
                // Close previous list if open
                if ($in_list) {
                    echo '</ul>';
                    $in_list = false;
                }
                
                // This is an activity title
                echo '<strong>' . str_replace(['**', ' - '], '', $line) . '</strong>';
                echo '<ul>';
                $in_list = true;
            } elseif (strpos($line, '**• **') === 0) {
                // This is a sub-activity
                echo '<li>' . str_replace('**• **', '', $line) . '</li>';
            }
        }
        
        // Close the last list if open
        if ($in_list) {
            echo '</ul>';
        }
        
        echo '</div>'; 
    } else { 
        echo 'N/A'; 
    } 
    ?> 
</div>



                    <!-- <div class="planned-experiences">Planned experiences:</div> -->
                    <div class="bottomdivs">  <?php echo isset($plan['language_experiences']) ? htmlspecialchars($plan['language_experiences'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?> </div>
                </td>
                <td>
                
                <div class="topdivs">
    <?php 
    if (isset($plan['culture'])) { 
        $formatted_text = htmlspecialchars($plan['culture'], ENT_QUOTES, 'UTF-8'); 
        $lines = explode("\n", $formatted_text); 
        
        echo '<div>';
        $in_list = false;
        
        foreach ($lines as $line) {
            if (strpos($line, '**') === 0 && strpos($line, '** - ') !== false) {
                // Close previous list if open
                if ($in_list) {
                    echo '</ul>';
                    $in_list = false;
                }
                
                // This is an activity title
                echo '<strong>' . str_replace(['**', ' - '], '', $line) . '</strong>';
                echo '<ul>';
                $in_list = true;
            } elseif (strpos($line, '**• **') === 0) {
                // This is a sub-activity
                echo '<li>' . str_replace('**• **', '', $line) . '</li>';
            }
        }
        
        // Close the last list if open
        if ($in_list) {
            echo '</ul>';
        }
        
        echo '</div>'; 
    } else { 
        echo 'N/A'; 
    } 
    ?> 
</div>
                    <!-- <div class="planned-experiences">Planned experiences:</div> -->
                    <div class="bottomdivs">  <?php echo isset($plan['culture_experiences']) ? htmlspecialchars($plan['culture_experiences'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?> </div>
                </td>
                <td>
                    <div class="topdivs"> <?php echo isset($plan['art_craft']) ? htmlspecialchars($plan['art_craft'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?></div>
                    <!-- <div class="planned-experiences">Planned experiences:</div> -->
                    <div class="bottomdivs">  <?php echo isset($plan['art_craft_experiences']) ? htmlspecialchars($plan['art_craft_experiences'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?> </div>
                </td>
            
            </tr>
        </table> 

        <div class="eylf-section">
            <div class="section-label" style="margin:10px;">EYLF:</div>
            <div style="margin:10px;">
    <?php 
    echo isset($plan['eylf']) ? nl2br(htmlspecialchars($plan['eylf'], ENT_QUOTES, 'UTF-8')) : 'N/A'; 
    ?>
</div>        </div>

        <div class="footer">
        <div>1 Capricorn Road, Truganina, VIC 3029 </div>
        <!-- <img src="<?= base_url(); ?>api/assets/media/footer_down.png" style="background-size: contain;background-repeat: no-repeat; position: relative;width:100%;"> -->

          
        </div>
    </div>

    <!-- Page 2 -->
    <div class="page">
        <div class="header">
            <!-- <div class="corner-decoration top-left"></div> -->
            <!-- <div class="corner-decoration top-right"></div> -->
            <img src="<?= base_url(); ?>api/assets/media/profile_1739442700.jpeg" alt="NextGen Montessori Logo">
        </div>

        <div class="outdoor-section">
            <div class="section-label">Outdoor Experiences:</div>
            <div style="margin:10px;">
    <?php 
    if (!empty($plan['outdoor_experiences'])) {
        $experiences = explode(',', $plan['outdoor_experiences']);
        echo '<ul style="margin: 0; padding-left: 20px;">';
        foreach ($experiences as $experience) {
            echo '<li>' . htmlspecialchars(trim($experience), ENT_QUOTES, 'UTF-8') . '</li>';
        }
        echo '</ul>';
    } else {
        echo 'N/A';
    }
    ?>
</div>
        </div>

        <table>
            <tr>
                <td style="width: 33%;height: 150px;">
                    <div class="section-label">Inquiry Topic:</div>
                    <div style="margin:10px;">  <?php echo isset($plan['inquiry_topic']) ? htmlspecialchars($plan['inquiry_topic'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>   </div>
                </td>
                <td style="width: 33%;height: 150px;">
                    <div class="section-label">Sustainability Topic:</div>
                    <div style="margin:10px;">  <?php echo isset($plan['sustainability_topic']) ? htmlspecialchars($plan['sustainability_topic'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>   </div>
                </td>
               
                <td style="width: 33%;height: 150px;">
    <div class="section-label">Special Events:</div>
    <div style="margin:10px;">
        <?php 
        if (!empty($plan['special_events'])) {
            $events = explode(',', $plan['special_events']);
            echo '<ul style="margin: 0; padding-left: 20px;">';
            foreach ($events as $event) {
                echo '<li>' . htmlspecialchars(trim($event), ENT_QUOTES, 'UTF-8') . '</li>';
            }
            echo '</ul>';
        } else {
            echo 'N/A';
        }
        ?>
    </div>
              </td>
              
            </tr>
        </table>

        <table>
            <tr>
                <td colspan="3" style=" height: 150px;">
                    <div class="section-label">Children's Voices:</div>
                    <div style="margin:10px;">  <?php echo isset($plan['children_voices']) ? htmlspecialchars($plan['children_voices'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>   </div>
                </td>
                <td style="">
                    <div class="section-label">Families Input:</div>
                    <div style="margin:10px;">  <?php echo isset($plan['families_input']) ? htmlspecialchars($plan['families_input'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>   </div>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="width: 33%; height: 150px;">
                    <div class="section-label">Group Experience:</div>
                    <div style="margin:10px;">  <?php echo isset($plan['group_experience']) ? htmlspecialchars($plan['group_experience'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>   </div>
                </td>
                <td style="width: 33%;">
                    <div class="section-label">Spontaneous Experience:</div>
                    <div style="margin:10px;">  <?php echo isset($plan['spontaneous_experience']) ? htmlspecialchars($plan['spontaneous_experience'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>   </div>
                </td>
                <td style="width: 33%;">
                    <div class="section-label">Mindfulness Experiences:</div>
                    <div style="margin:10px;">  <?php echo isset($plan['mindfulness_experiences']) ? htmlspecialchars($plan['mindfulness_experiences'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?>   </div>
                </td>
            </tr>
        </table>

        <div class="footer">
            1 Capricorn Road, Truganina, VIC 3029
            <!-- <img src="<?= base_url(); ?>api/assets/media/footer_down.png" style="background-size: contain;background-repeat: no-repeat; position: relative;width:100%;"> -->

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