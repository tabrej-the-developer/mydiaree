<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Child's Observation Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 200px;
            margin-bottom:5px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
            color:blueviolet;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f8f8f8;
            font-weight: bold;
            width: 150px;
        }
        .photo-cell {
            height: 150px;
        }
        .observation-cell {
            height: 120px;
        }
        .outcomes-cell {
            height: 150px;
        }
        .analysis-cell, .reflection-cell {
            height: 120px;
            width: 50%;
        }
        .voice-cell {
            height: 80px;
        }
        .assessment-cell, .milestones-cell {
            height: 120px;
            width: 50%;
        }
        .plan-cell {
            height: 100px;
        }
     /* Photo Gallery Container */
.photo-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); /* Responsive grid */
    gap: 10px; /* Space between images */
    margin-top: 10px;
}

/* Each Photo Item */
.photo-item {
    border: 1px solid #ccc; /* Light border for clean look */
    border-radius: 12px; /* Rounded corners */
    padding: 5px; /* Space inside the box */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Light shadow */
    text-align: center; /* Center image */
}

/* Image Styling */
.child-image {
    max-width: 100%;
    width: 100%;
    max-height: 90px; /* Consistent image height */
    border-radius: 8px; /* Rounded image corners */
    object-fit: cover; /* Crop image to fill space while maintaining aspect ratio */
}
        /* .no-print {
            display: none;
        } */

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


        
        /* @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 0;
            }
            @page {
                size: A4;
                margin: 1cm;
            }
        } */

        @media print {
    /* Hide print and back buttons */
    .print-button, .back-button {
        display: none;
    }

    /* Ensure body and page styling */
    body {
        margin: 0;
        padding: 0;
        font-size: 12px; /* Consistent font size for better print output */
        line-height: 1.4;
    }

    .container {
        width: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    /* Ensure A4 size with consistent page margins */
    @page {
        size: A4; /* Standard print size */
        margin: 20mm; /* Ensure 20mm margin on all sides */
    }

    /* Ensure margin at the bottom of each page */
    .page::after {
        content: "";
        display: block;
        height: 15mm; /* Add bottom space to avoid cutoff */
    }

 

    /* Avoid breaking inside these elements */
    .no-break, .child-image, table, img {
        page-break-inside: avoid; /* Avoid breaking inside tables and images */
    }



    /* Force page break after specific sections */
    .page-break {
        page-break-after: always; /* Use where necessary to break pages */
    }

    /* Prevent headings and important sections from breaking */
    h1, h2, h3, th {
        page-break-after: avoid; /* Keep headings intact */
    }

    /* Table styling for better print readability */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    /* Ensure header and title stay together but do not push the table to a new page */
.title-wrapper {
    break-inside: avoid;       /* Avoid breaking inside */
    page-break-inside: avoid;  /* Avoid breaking inside (for older browsers) */
}

/* Ensure the table follows without forcing a new page */
table {
    break-before: auto;        /* Let the table naturally flow */
    page-break-before: auto;   /* Same for compatibility */
    break-inside: auto;        /* Avoid breaking inside if possible */
    page-break-inside: auto;   /* Compatibility */
}

    th, td {
        border: 1px solid #000; /* Solid border for print */
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f8f8f8; /* Light background for headers */
    }

    /* Image Styling */
    .photo-gallery {
        grid-template-columns: repeat(3, 1fr); /* 3 images per row on print */
        gap: 8px; /* Reduced gap for print */
    }

    .photo-item {
        box-shadow: none; /* Remove shadow for print */
        border: 0.5px solid #999; /* Thinner border for print */
    }
}

    </style>
</head>
<body>
<button onclick="window.print()" class="print-button">Print Pages&nbsp;<i class="fa-solid fa-print fa-beat-fade"></i></button>
<!-- <button onclick="window.history.back();" class="back-button">
    <i class="fa-solid fa-arrow-left fa-beat"></i>&nbsp;Go Back
</button> -->

    <div class="container">
  

        <!-- Header with Logo -->
        <div class="header" title-wrapper>
            <img src="<?= base_url('api/assets/media/profile_1739442700.jpeg') ?>" alt="NEXTGEN Montessori" class="logo">
        </div>
       
        <!-- Title -->
        <div class="title">Child's Observation:</div>
        
        <!-- Child Info Table -->
        <table>
            <tr>
                <th colspan="2">Child's Name</th>
                <td colspan="2">  
                    <?php 
                    if (!empty($childrens)) {
                        $childNames = array_map(function($child) {
                            return $child->child_name;
                        }, $childrens);
                        echo implode(', ', $childNames);
                    }
                    ?>
                </td>
                </tr>
                <tr>
                <th colspan="2">Date</th>
                <td colspan="2"><?= date('d/m/Y', strtotime($observation->date_added)) ?></td>
                </tr>
            </tr>
            <tr>
                <th>Educator's Name</th>
                <td colspan="3"><?= $observation->user_name ?></td>
            </tr>
            <tr>
                <th>Classroom</th>
                <td colspan="3">
                    <?php 
                    // If you have center/classroom information, display it here
                    if (isset($observation->roomName)) {
                        echo $observation->roomName;
                    } else {
                        echo "";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <!-- <th>Child's Photos</th> -->
                <td colspan="4" class="photo-cell">
                    <strong><p>Child's Photos</p></strong>
                   
                    <!-- <?php if (!empty($childrens)): ?>
                        <?php foreach ($childrens as $child): ?>
                            <?php if (!empty($child->imageUrl)): ?>
                                <img src="<?= base_url('api/assets/media/'.$child->imageUrl) ?>" class="child-image" alt="<?= $child->child_name ?>">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?> -->

                    <div class="photo-gallery">
                    <?php if (!empty($Media)): ?>
                         <?php foreach ($Media as $media): ?>
                            <?php if ($media->mediaType == 'Image'): ?>
                                <img src="<?= base_url('api/assets/media/'.$media->mediaUrl) ?>" class="child-image" alt="Observation Media">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?> 
                            </div>

                </td>
            </tr>
            <tr>
                <th>Observation</th>
                <td colspan="3" class="observation-cell">
                    
                <?= $observation->title ?>   
                
               
                
                </td>
               
            </tr>
            <tr>
                <td colspan="1" class="outcomes-cell" style="background-color: #f8f8f8;"><strong>EYLF Outcomes</strong></td>
                <td colspan="3" style="text-align: justify;">
                    <?php if (!empty($outcomes)): ?>
                        <?php foreach ($outcomes as $outcome): ?>
                            <strong><?= $outcome->title ?></strong><br>
                            <?php if (!empty($outcome->Activity)): ?>
                                <?php foreach ($outcome->Activity as $activity): ?>
                                    - <?= $activity->title ?><br>
                                    <?php if (!empty($activity->subActivity)): ?>
                                        <?php foreach ($activity->subActivity as $subActivity): ?>
                                            &nbsp;&nbsp;&nbsp;• <?= $subActivity->title ?><br>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <!-- <th class="analysis-cell">Analysis/Evaluation</th> -->
                <td colspan="3" style="text-align: justify;">
                <strong><p>Analysis/Evaluation</p></strong>
                    <?= $observation->notes ?>
                </td>
                <!-- <th class="reflection-cell">Reflection</th> -->
                <td colspan="3" style="text-align: justify;">
                <strong><p>Reflection</p></strong>
                    <?= $observation->reflection ?>
                </td>
            </tr>
            <tr>
                <th>Child's Voice</th>
                <td colspan="3" class="voice-cell">
                    <?php 
                    // If you have child's voice data, display it here
                    if (isset($observation->child_voice)) {
                        echo strip_tags(html_entity_decode($observation->child_voice));
                    } else {
                        echo "Not recorded";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <!-- <th class="assessment-cell">Montessori Assessment</th> -->
                <td colspan="3"> 
                <strong><p>Montessori Assessment</p></strong>
                    <?php if (!empty($montessoriSubjects)): ?>
                        <?php foreach ($montessoriSubjects as $subject): ?>
                            <strong><?= $subject->name ?></strong><br>
                            <?php if (!empty($subject->Activity)): ?>
                                <?php foreach ($subject->Activity as $activity): ?>
                                    - <?= $activity->title ?><br>
                                    <?php if (!empty($activity->subActivity)): ?>
                                        <?php foreach ($activity->subActivity as $subActivity): ?>
                                            &nbsp;&nbsp;&nbsp;• <?= $subActivity->title ?><br>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </td>
                <!-- <th class="milestones-cell">Development Milestones</th> -->
                <td colspan="2">
                <strong><p>Development Milestones</p></strong>
                    <?php if (!empty($devMilestone)): ?>
                        <?php foreach ($devMilestone as $milestone): ?>
                            <strong><?= $milestone->ageGroup ?></strong><br>
                            <?php if (!empty($milestone->Main)): ?>
                                <?php foreach ($milestone->Main as $main): ?>
                                    - <?= $main->name ?><br>
                                    <?php if (!empty($main->Subjects)): ?>
                                        <?php foreach ($main->Subjects as $subject): ?>
                                            &nbsp;&nbsp;&nbsp;• <?= $subject->name ?><br>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <br>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Future Plan/Extension</th>
                <td colspan="3" class="plan-cell">
                    <?php 
                    // If you have future plan data, display it here
                    if (isset($observation->future_plan)) {
                        echo strip_tags(html_entity_decode($observation->future_plan));
                    } else {
                        echo "";
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>