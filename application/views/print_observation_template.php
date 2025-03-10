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
        .child-image {
            border-radius:15px;
            max-width: 130px;
            max-height: 82px;
            margin: 5px;
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
        }
    </style>
</head>
<body>
<button onclick="window.print()" class="print-button">Print Pages&nbsp;<i class="fa-solid fa-print fa-beat-fade"></i></button>
<!-- <button onclick="window.history.back();" class="back-button">
    <i class="fa-solid fa-arrow-left fa-beat"></i>&nbsp;Go Back
</button> -->

    <div class="container">
  
        <!-- Print Button (only visible on screen)
        <div class="no-print">
            <button onclick="window.print();" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer; margin-bottom: 20px;">
                Print Observation
            </button>
        </div> -->
        
        <!-- Header with Logo -->
        <div class="header">
            <img src="<?= base_url('api/assets/media/profile_1739442700.jpeg') ?>" alt="NEXTGEN Montessori" class="logo">
        </div>
        
        <!-- Title -->
        <div class="title">Child's Observation:</div>
        
        <!-- Child Info Table -->
        <table>
            <tr>
                <th colspan="1">Child's Name</th>
                <td colspan="1">  
                    <?php 
                    if (!empty($childrens)) {
                        $childNames = array_map(function($child) {
                            return $child->child_name;
                        }, $childrens);
                        echo implode(', ', $childNames);
                    }
                    ?>
                </td>
                <th colspan="1">Date</th>
                <td colspan="1"><?= date('d/m/Y', strtotime($observation->date_added)) ?></td>
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
                    if (isset($observation->centerName)) {
                        echo $observation->centerName;
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
                    <?php if (!empty($childrens)): ?>
                        <?php foreach ($childrens as $child): ?>
                            <?php if (!empty($child->imageUrl)): ?>
                                <img src="<?= base_url('api/assets/media/'.$child->imageUrl) ?>" class="child-image" alt="<?= $child->child_name ?>">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Observation</th>
                <td colspan="3" class="observation-cell"><?= $observation->title ?>   <?php if (!empty($Media)): ?>
                        <?php foreach ($Media as $media): ?>
                            <?php if ($media->mediaType == 'Image'): ?>
                                <img src="<?= base_url('api/assets/media/'.$media->mediaUrl) ?>" class="child-image" alt="Observation Media">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?></td>
               
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
                    if (isset($observation->childVoice)) {
                        echo $observation->childVoice;
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
                    if (isset($observation->futurePlan)) {
                        echo $observation->futurePlan;
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