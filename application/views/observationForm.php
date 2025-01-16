<?php
$data['name']='Observation'; $this->load->view('header',$data); ?>

<div class="container observationListContainer">
	<div class="pageHead">
		<h1>Add Observation</h1>
			<div class="obsMenuTop">
            <?php if ($this->session->userdata("UserType")!="Parent") { 
               $qs = $_SERVER['QUERY_STRING'];
               $url = base_url("Observation/add").$qs;
            ?>
            <form action="" id="centerDropdown">
               <select name="centerid" id="centerId" class="form-control">
                  <?php 
                     $dupArr = [];
                     foreach ($this->session->userdata("centerIds") as $key => $center){
                        if ( ! in_array($center, $dupArr)) {
                           if (isset($_GET['centerid']) && $_GET['centerid'] != "" && $_GET['centerid']==$center->id) {
                  ?>
                  <option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
                  <?php    }else{ ?>
                  <option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
                  <?php
                           }
                        }
                        array_push($dupArr, $center);
                     }
                  ?>
               </select>
            </form>
         <?php } ?>
      </div>
   </div>

   <ul class="breadcrumb">
      <li><a href="#">Application</a></li>
      <li class="active">Observation</li>
   </ul>

   <ul class="nav nav-tabs ">
      <li <?php if($type=='observation' ) { ?>class="active line-nav-tab" <?php } else { ?> class="line-nav-tab" <?php } ?>><a href="#tabs-1" data-toggle="tab">Observation</a></li>
      <li <?php if($type=='assessments' ) { ?>class="active line-nav-tab" <?php } else { ?> class="line-nav-tab" <?php } ?>><a href="#tabs-2" data-toggle="tab">Assessments</a></li>
      <li <?php if($type=='links' ) { ?>class="active line-nav-tab" <?php } else { ?> class="line-nav-tab" <?php } ?>><a href="#tabs-3" data-toggle="tab"> Links</a></li>
   </ul>

   <div class="tab-content mainTabObservation">
      <div class="tab-pane <?php if($type=='observation' ) { ?>active<?php } ?>" id="tabs-1">
         <form action="<?php echo base_url('observation/add'); ?>" id="form-observation" method="post" enctype="multipart/form-data">
            <div class="twoColFormDiv">
               <div class="leftColForm">
               <div class="form-group required">
                  <label class="control-label" >Children</label>
                  <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-default btnBlue btn-small"><span class="material-icons-outlined">add</span> Select Children</button>
                  <div class="bootstrap-tagsinput">
                     <input type="text" readonly="" class="inputtagsinput" placeholder="" size="1">
                     <?php 
                     if(!empty($observationChildrens)) {
                        foreach($observationChildrens as $observationChildren) {
                           $date1 = new DateTime($observationChildren->dob);
                           $date2 = new DateTime(date('Y-m-d'));
                           $diff = $date1->diff($date2); 
                     ?>
                     <span class="tag label label-info">
                        <input type="hidden" name="childrens[]" value="<?php echo $observationChildren->child_id; ?>">
                        <?php echo $observationChildren->child_name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>
                        <span class="rem"  data-role="remove"></span>
                     </span>
                     <?php } 
                     } ?>
                  </div>
               </div>
               <div class="form-group required">
                  <label class=" control-label" ><?php echo 'Title'; ?></label>
                  <input type="text" name="title" id="obs_title" class="form-control" value="<?php echo isset($observation->title)?$observation->title:''; ?>">
               </div>
               <div class="form-group required">
                  <label class=" control-label" ><?php echo 'Notes'; ?></label>
                  <textarea name="notes" style="height: 73px;" class="form-control"><?php echo isset($observation->notes)?$observation->notes:''; ?></textarea>
               </div>
               <div class="form-group required">
                  <label class=" control-label" ><?php echo 'Reflection'; ?></label>
                  <textarea style="height: 73px;" name="reflection"class="form-control"><?php echo isset($observation->reflection)?$observation->reflection:''; ?></textarea>
               </div>
               </div>

               <div class="rightColForm bg-white">
                  <div class="form-group">                     
                        <div id="img-holder">
                        <?php 
                        if (!empty($observationMedia)) {
                           foreach ($observationMedia as $key => $obsMedia) {
                        ?>
                           <div class="img-preview">
                              <img class="thumb-image" src="<?php echo BASE_API_URL."assets/media/".$obsMedia->mediaUrl;?>"><span id="<?php echo $obsMedia->id; ?>" class="img-remove deleteMedia"><span class="material-icons-outlined">close</span></span>
                              <a class="img-edit img-real-edit" href="#!" data-imgcount="<?php echo $key; ?>" data-mediaid="<?php echo $obsMedia->id; ?>" data-image="<?php echo BASE_API_URL."assets/media/".$obsMedia->mediaUrl; ?>" data-toggle="modal" data-target="#myModal" data-edit="1"><span class="material-icons-outlined">edit</span></a>
                           </div>
                        <?php
                           }
                        }
                        ?>
                        </div>
                        <label class="file-upload-field" for="fileUpload"><span class="material-icons-outlined">add</span> <span>Upload</span></label>
                     
                     <input type="file" name="obsMedia[]" id="fileUpload" class="form-control-hidden" multiple>
                  </div>
               </div>

            </div>
            <div class="formSubmit">
               <?php 

                  $role = $this->session->userdata('UserType');
                  if ($role=="Staff") {
                     if (isset($permissions)) {
                        if ($permissions->addObservation == 1) {
                           $addObservation = 1;
                        } else {
                           $addObservation = 0;
                        }

                        if ($permissions->updateObservation == 1) {
                           $updateObservation = 1;
                        } else {
                           $updateObservation = 0;
                        }              
                     }else {
                        $addObservation = 0;
                        $updateObservation = 0;           
                     }
                  } else {
                     $addObservation = 1;
                     $updateObservation = 1;        
                  }

                  
                  if (empty($id)) {
                     if ($addObservation==1) {
               ?>
               <button type="button" onclick="saveObservation();" class="btn btn-default btnBlue pull-right">Save & Next</button>
               <?php
                     }
                  }else{
                     if ($updateObservation==1) {
               ?>
               <button type="button" onclick="editObservation();"  class="btn btn-default btnBlue pull-right">Save & Next</button>
               <?php
                     }
                  }

                  if ($this->session->userdata('UserType')=="Parent") {
                     if(empty($id)) {
               ?>
               <button type="button" onclick="saveObservation();" class="btn btn-default btnBlue pull-right">Save & Next</button>
               <?php
                     }else{
               ?>
               <button type="button" onclick="editObservation();"  class="btn btn-default btnBlue pull-right">Save & Next</button>
               <?php
                     }
                  }
               ?>
               <a href="<?php echo base_url('observation'); ?>" class="btn btn-default pull-right">Cancel</a>
            </div>
         </form>
         <div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
            <div class="modal-dialog" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="modal-close" aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel2">Select Children</h4>
                  </div>
                  <div class="modal-body">
                     <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search by Name, Date of Birth(day or year first) or UPN" class="form-control">
                     <div class="tabs">
                        <div class="tab">
                              <input type="radio" id="tab-1" name="tab-group-1" checked>
                              <label for="tab-1">Children</label>
                           <div class="content1">
                              <div class="pull-right selectAllCheck">
                                 Select All <input type="checkbox" class="btn-child-select-all button_child select_all">
                              </div>
                              <table id="myTable"  data-name="listtable" class="listtable table table-bordered">
                                 <?php foreach($childs as $child) {
                                    $date1 = new DateTime($child->dob);
                                    $date2 = new DateTime(date('Y-m-d'));
                                    $diff = $date1->diff($date2); 
                                    $var = false;
                                    if(!empty($observationChildrens)){
                                       foreach ($observationChildrens as $obsCh) {
                                          if ($child->id==$obsCh->child_id) {
                                             $var = true;
                                             ?>
                                             <tr>
                                                <td><?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?></td>
                                                <td class="text-right">
                                                   <input class="selected_check childcheck check<?php echo $child->id; ?>" id="<?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>" value="<?php echo $child->id; ?>" type="checkbox" checked>
                                                </td>
                                             </tr>
                                             <?php
                                          }
                                       }
                                       if($var==false){
                                          ?>
                                          <tr>
                                             <td><?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?></td>
                                             <td class="text-right">
                                                <input class="selected_check childcheck check<?php echo $child->id; ?>" id="<?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>" value="<?php echo $child->id; ?>" type="checkbox" >
                                             </td>
                                          </tr>
                                          <?php
                                       }
                                    }else{
                                       ?>
                                       <tr>
                                          <td><?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?></td>
                                          <td class="text-right">
                                             <input class="selected_check childcheck check<?php echo $child->id; ?>" id="<?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>" value="<?php echo $child->id; ?>" type="checkbox" >
                                          </td>
                                       </tr>
                                       <?php
                                    }
                                 } ?>  
                              </table>
                              <div class="no-childerns">O Children Selected</div>
                           </div>
                        </div>
                        <div class="tab">
                           <input type="radio" id="tab-2" name="tab-group-1">
                           <label for="tab-2">Sort by room</label>
                           <div class="content1">
                              <?php $group_row=0; foreach($groups as $key=>$group) { 
                                 if($key!="Status"){  ?>
                                    <span>
                                       <?php echo $key; ?>
                                       <div class="pull-right" style="padding-right:6px;">Select All <input type="checkbox" id="group<?php echo $group_row; ?>" class="btn-child-select-all btngroup sa"></div>
                                    </span>
                                    <table id="myTable" data-name="listtable" class="listtable table table-bordered">
                                       <?php foreach($group as $key=>$child) {
                                          $date1 = new DateTime($child->dob);
                                          $date2 = new DateTime(date('Y-m-d'));
                                          $diff = $date1->diff($date2); 
                                          ?>
                                          <tr>
                                             <td><?php echo $child->child_name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?></td>
                                             <td class="text-right"><input class="selected_check groupcheck check<?php echo $child->child_id; ?> group<?php echo $group_row; ?>" id="<?php echo $child->child_name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>"  value="<?php echo $child->child_id; ?>" type="checkbox"></td>
                                          </tr>
                                       <?php }?>
                                    </table>
                                    <?php  $group_row++; } ?>
                                 <?php }?>
                                 <div class="no-childerns">O Children Selected</div>
                           </div>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" onclick="select_children();" class="btn btn-default btn-small btnBlue pull-right" data-dismiss="modal">Save</button>
                     </div>
                  </div>
               </div>
                  <!-- modal-content -->
            </div>
         </div>
      </div>
      <div class="tab-pane <?php if($type=='assessments' ) { ?>active<?php } ?>" id="tabs-2">
         <ul class="nav nav-tabs border-tab">
            <li <?php if($sub_type=='Montessori' ) { ?>class="active" <?php } ?>>
               <a href="#Montessori" data-toggle="tab">Montessori</a>
            </li>
            <li <?php if($sub_type=='EYLF' ) { ?>class="active" <?php } ?>>
               <a href="#EYLF" data-toggle="tab">EYLF</a>
            </li>
            <li <?php if($sub_type=='Milestones' ) { ?>class="active" <?php } ?>>
               <a href="#Milestones" data-toggle="tab">Developmental Milestones</a>
            </li>
         </ul>
         <div class="tab-content">
            <div class="tab-pane <?php if($sub_type=='Montessori' ) { ?> active <?php } ?>" id="Montessori">
               <form action="" method="post" enctype="multipart/form-data" id="form-montessori" class="form-horizontal">
                  <ul class="nav nav-pills bold-tab">
                     <?php $i=1; foreach($mon_subjects as $mon_subject) { ?>
                     <li <?php if($i==1) { ?> class="active" <?php } ?>><a href="#<?php echo str_replace(" ","",$mon_subject->name); ?>" data-toggle="tab"><?php echo $mon_subject->name; ?></a></li>
                     <?php $i++; } ?>
                  </ul>
                  <div class="tab-content">
                     <?php $i=1; foreach($mon_subjects as $mon_subject) { ?>
                        <div class="tab-pane <?php if($i==1) { ?>  active <?php } ?>" id="<?php echo str_replace(" ","",$mon_subject->name); ?>">
                           <div class="pull-left">
                              <?php  
                              if(!empty($mon_activites[$mon_subject->idSubject])) {
                                 foreach($mon_activites[$mon_subject->idSubject] as $key1=>$mon_activity) { 
                              ?>
                              <button type="button" class="divexpand">
                                 <?php echo $mon_activity->title; ?>
                                 <span class="pull-right">
                                    <img style="height: 8px;"  src="<?php echo base_url('assets/images/icons/down_arrow.png'); ?>">
                                    <span>&nbsp;Expand</span>
                                 </span>
                              </button>
                              <div class="divcontent">
                                 <?php 
                                 if(!empty($mon_sub_activites[$mon_activity->idActivity])) {
                                    foreach($mon_sub_activites[$mon_activity->idActivity] as $key2 => $mon_sub_activity) { 
                                 ?>
                                 <div class="row">
                                    <div class="col-sm-6 divtable">
                                       <strong><?php echo $mon_sub_activity->title; ?></strong>
                                    </div>
                                    <div class="col-sm-6 divtable">
                                       <select name="montessori[<?php echo $mon_sub_activity->idSubActivity; ?>]" class="form-control divselect">
                                          <?php 
                                          if (!empty($obsMontessori)) {
                                             foreach ($obsMontessori as $key => $obsMon) {
                                                if ($obsMon->idSubActivity==$mon_sub_activity->idSubActivity) {
                                                   if ($obsMon->assesment=="Not Assessed") {
                                                      ?>
                                                      <option value="Not Assessed" selected>Not Assessed</option>
                                                      <option value="Introduced">Introduced</option>
                                                      <option value="Working">Working</option>
                                                      <option value="Completed">Completed</option>
                                                      <?php
                                                   } else if($obsMon->assesment=="Introduced"){
                                                      ?>
                                                      <option value="Not Assessed">Not Assessed</option>
                                                      <option value="Introduced" selected>Introduced</option>
                                                      <option value="Working">Working</option>
                                                      <option value="Completed">Completed</option>
                                                      <?php 
                                                   }else if($obsMon->assesment=="Working"){
                                                      ?>
                                                      <option value="Not Assessed">Not Assessed</option>
                                                      <option value="Introduced">Introduced</option>
                                                      <option value="Working" selected>Working</option>
                                                      <option value="Completed">Completed</option>
                                                      <?php
                                                   }else if($obsMon->assesment=="Completed"){
                                                      ?>
                                                      <option value="Not Assessed">Not Assessed</option>
                                                      <option value="Introduced">Introduced</option>
                                                      <option value="Working">Working</option>
                                                      <option value="Completed" selected>Completed</option>
                                                      <?php
                                                   }else{
                                                      ?>
                                                      <option value="Not Assessed">Not Assessed</option>
                                                      <option value="Introduced">Introduced</option>
                                                      <option value="Working">Working</option>
                                                      <option value="Completed">Completed</option>
                                                      <?php
                                                   }
                                                }else{
                                          ?>
                                             <option value="Not Assessed">Not Assessed</option>
                                             <option value="Introduced">Introduced</option>
                                             <option value="Working">Working</option>
                                             <option value="Completed">Completed</option>
                                          <?php } 
                                             }
                                          }else{
                                             ?>
                                             <option value="Not Assessed">Not Assessed</option>
                                             <option value="Introduced">Introduced</option>
                                             <option value="Working">Working</option>
                                             <option value="Completed">Completed</option>
                                          <?php   } ?>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="row" style="margin-bottom: 15px;">
                                    <?php if(!empty($mon_extras[$mon_sub_activity->idSubActivity])) {
                                       echo "<div class='col-sm-12'><strong>Extras</strong></div>";
                                       foreach($mon_extras[$mon_sub_activity->idSubActivity] as $key2=>$mon_extra) {
                                          if (!empty($obsMontessori)) {
                                             $var = true;
                                             foreach($obsMontessori as $obs => $ob){
                                                if ($mon_sub_activity->idSubActivity==$ob->idSubActivity) {
                                                   foreach($ob->idExtra as $extra => $obExtra){
                                                      if ($mon_extra->idExtra==$obExtra) {
                                                         $var = false;
                                    ?>
                                    <div class="col-md-12">
                                       <input type="checkbox" name="extras[<?php echo $mon_sub_activity->idSubActivity; ?>][]" value="<?php echo $mon_extra->idExtra; ?>" checked>&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $mon_extra->title; ?></label>
                                    </div>
                                    <?php
                                                      }
                                                   }
                                                }
                                             }
                                             if ($var == true) {
                                    ?>
                                    <div class="col-md-12">
                                       <input type="checkbox" name="extras[<?php echo $mon_sub_activity->idSubActivity; ?>][]" value="<?php echo $mon_extra->idExtra; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $mon_extra->title; ?></label>
                                    </div>
                                    <?php
                                             }
                                          } else {
                                    ?>
                                    <div class="col-md-12">
                                       <input type="checkbox" name="extras[<?php echo $mon_sub_activity->idSubActivity; ?>][]" value="<?php echo $mon_extra->idExtra; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $mon_extra->title; ?></label>
                                    </div>
                                    <?php
                                          }
                                       }

                                    }
                                    ?>
                                 </div>
                                 <?php } } ?>
                              </div>
                              <?php } } ?>
                           </div>
                        </div>
                     <?php $i++; } ?>
                     
                     <?php if($id) { ?>
                        <div class="formSubmit" >
                           <button type="button" onclick="saveMontessori();"  class="btn btn-default btnBlue pull-right">Save</button>
                           <a href="<?php echo base_url('observation/add?type=observation&id='.$id); ?>" class="btn btn-default btnRed pull-right">Cancel</a>
                        </div>
                     <?php } ?>
                  </div>

               </form>
            </div>
            <div class="tab-pane <?php if($sub_type=='EYLF' ) { ?> active <?php } ?>" id="EYLF">
               <form action="" method="post" enctype="multipart/form-data" id="form-eylf" class="form-horizontal">
                  <ul class="nav nav-pills bold-tab">
                     <?php $i=1; foreach($eylf_outcomes as $eylf_outcome) { ?>
                     <li <?php if($i==1) { ?> class="active" <?php } ?>>
                        <a href="#<?php echo str_replace(" ","",$eylf_outcome->title); ?>" data-toggle="tab">
                           <?php echo $eylf_outcome->title; ?>
                        </a>
                     </li>
                     <?php $i++; } ?>
                  </ul>
                  <div class="tab-content">
                        <?php 
                           $i=1;
                           foreach($eylf_outcomes as $eylf_outcome){
                        ?>
                        <div class="tab-pane <?php if($i==1){ echo "active"; } ?>" id="<?php echo str_replace(" ","",$eylf_outcome->title); ?>">
                           <p><?php echo $eylf_outcome->name; ?></p>
                           <div>
                              <?php 
                                 if(!empty($eylf_activites[$eylf_outcome->id])){
                                    foreach($eylf_activites[$eylf_outcome->id] as $key1=>$eylf_activity) {
                              ?>
                              <button type="button" class="divexpand">
                                 <?php echo $eylf_activity->title; ?>
                                 <span class="pull-right" style="color:#297DB6">
                                    <img style="height: 8px;"  src="<?php echo base_url('assets/images/icons/down_arrow.png'); ?>">
                                    <span>&nbsp;Expand</span>
                                 </span>
                              </button>
                              <div class="divcontent">
                                 <?php  
                                    if(!empty($eylf_sub_activites[$eylf_activity->id])) {
                                       foreach($eylf_sub_activites[$eylf_activity->id] as $key2=>$eylf_sub_activity){
                                 ?>
                                 <div class="row">
                                    <div class="col-sm-12 divtable">
                                       <input type="checkbox" name="eylf[<?php echo $eylf_activity->id; ?>][]" value="<?php echo $eylf_sub_activity->id; ?>" <?php if(!empty($observationEylf[$eylf_activity->id][$eylf_sub_activity->id])) { ?>checked<?php } ?>><?php echo $eylf_sub_activity->title; ?>
                                    </div>
                                 </div>
                                 <?php
                                       }
                                    } 
                                 ?>
                              </div>
                              <?php
                                    }
                                 }
                              ?>
                           </div>
                        </div>
                        <?php
                           }
                        ?>
                        <?php if(!empty($id)) { ?>
                           <div class="formSubmit">
                              <button type="button" onclick="saveEylf();"  class="btn btn-default pull-right btnBlue">Save</button>
                              <a href="<?php echo base_url('observation/add?type=observation&sub_type=Montessori&id='.$id); ?>" class="btn btn-default pull-right btnRed">Cancel</a>
                           </div>
                        <?php } ?>
                  </div>
               </form>
            </div>
            <div class="tab-pane <?php if($sub_type=='Milestones' ) { ?> active <?php } ?>" id="Milestones">
               <form action="" method="post" enctype="multipart/form-data" id="form-milestones" class="form-horizontal">
                  <ul class="nav nav-pills bold-tab">
                     <?php $i=1; foreach($milestones as $milestone) { ?>
                     <li <?php if($i==1) { ?> class="active" <?php } ?>>
                        <a href="#<?php echo str_replace(" ","",$milestone->ageGroup); ?>" data-toggle="tab"><?php echo $milestone->ageGroup; ?></a>
                     </li>
                     <?php $i++; } ?>
                  </ul>
                  <div class="tab-content">
                     <?php $i=1; foreach($milestones as $milestone) { ?>
                     <div class="tab-pane <?php if($i==1) { ?>  active <?php } ?>" id="<?php echo str_replace(" ","",$milestone->ageGroup); ?>">
                        <div class="pull-left" style="width: 100%;min-height: 250px;">
                           <?php  
                              if(!empty($dev_activites[$milestone->id])) {
                                 foreach($dev_activites[$milestone->id] as $key1=>$dev_activity) {
                           ?>
                           <button type="button" class="divexpand">
                              <?php echo $dev_activity->name; ?>
                              <span class="pull-right" style="color:#297DB6">
                                 <img style="height: 8px;"  src="<?php echo base_url('assets/images/icons/down_arrow.png'); ?>">
                                 <span>&nbsp;Expand</span>
                              </span>
                           </button>
                           <div class="divcontent">
                              <?php  
                                 if(!empty($dev_sub_activites[$dev_activity->id])) {
                                    foreach($dev_sub_activites[$dev_activity->id] as $key2=>$dev_sub_activity) { 
                              ?>
                              <div class="row ">
                                 <div class="col-sm-6 divtable">
                                    <?php echo $dev_sub_activity->name; ?>
                                 </div>
                                 <div class="col-sm-6 divtable">
                                    <select  name="milestones[<?php echo $dev_sub_activity->id; ?>]" class="form-control">
                                       <?php 
                                          if (!empty($obsMilestones)) {
                                             foreach ($obsMilestones as $key => $obsDev) {
                                                if ($obsDev->devMilestoneId==$dev_sub_activity->id) {
                                                   if ($obsDev->assessment=="Not Observed") {
                                       ?>
                                       <option value="Not Observed" selected>Not Observed</option>
                                       <option value="Not Interested">Not Interested</option>
                                       <option value="Not Calculated">Not Calculated</option>
                                       <?php
                                                   } else if($obsDev->assessment=="Not Interested"){
                                       ?>
                                       <option value="Not Observed">Not Observed</option>
                                       <option value="Not Interested" selected>Not Interested</option>
                                       <option value="Not Calculated">Not Calculated</option>
                                       <?php 
                                                   }else if($obsDev->assessment=="Not Calculated"){
                                       ?>
                                       <option value="Not Observed">Not Observed</option>
                                       <option value="Not Interested">Not Interested</option>
                                       <option value="Not Calculated" selected>Not Calculated</option>
                                       <?php
                                                   }else{
                                       ?>
                                       <option>--Select Option--</option>
                                       <option value="Not Observed">Not Observed</option>
                                       <option value="Not Interested">Not Interested</option>
                                       <option value="Not Calculated">Not Calculated</option>
                                       <?php
                                                   }

                                                }else{
                                       ?>
                                       <option>--Select Option--</option>
                                       <option value="Not Observed">Not Observed</option>
                                       <option value="Not Interested">Not Interested</option>
                                       <option value="Not Calculated">Not Calculated</option>
                                       <?php
                                                }
                                             }
                                          }else{
                                       ?>
                                       <option>--Select Option--</option>
                                       <option value="Not Observed">Not Observed</option>
                                       <option value="Not Interested">Not Interested</option>
                                       <option value="Not Calculated">Not Calculated</option>
                                       <?php   } ?>
                                    </select>
                                 </div>
                                 <div class="col-sm-12">
                                    <?php  
                                    if(!empty($dev_extras[$dev_sub_activity->id])) {
                                       echo "<div><strong>Extras</strong></div>";
                                       foreach($dev_extras[$dev_sub_activity->id] as $key2=>$dev_extra) {
                                          if(!empty($obsMilestones)){
                                             $var = true;
                                             foreach($obsMilestones as $obs => $ob){
                                                if ($ob->devMilestoneId==$dev_sub_activity->id) {
                                                   foreach($ob->idExtras as $extra => $obExtra){
                                                      if ($dev_extra->id==$obExtra) {
                                                         $var = false;
                                                         ?>
                                                         <div class="col-md-12">
                                                            <input type="checkbox" name="extras[<?php echo $dev_sub_activity->id; ?>][]" value="<?php echo $dev_extra->id; ?>" checked>&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $dev_extra->title; ?></label>
                                                         </div>
                                                         <?php
                                                      }
                                                   }
                                                }
                                             }
                                             if ($var == true) {
                                                ?>
                                                <div class="col-md-12">
                                                   <input type="checkbox" name="extras[<?php echo $dev_sub_activity->id; ?>][]" value="<?php echo $dev_extra->id; ?>" >&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $dev_extra->title; ?></label>
                                                </div>
                                                <?php
                                             }
                                          }else{
                                             ?>
                                             <div class="col-md-12">
                                                <input type="checkbox" name="extras[<?php echo $dev_sub_activity->id; ?>][]" value="<?php echo $dev_extra->id; ?>" >&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $dev_extra->title; ?></label>
                                             </div>
                                             <?php
                                          }
                                       }
                                    }
                                    ?>
                                 </div>
                              </div>
                              <?php } } ?>
                           </div>
                           <?php } } ?>
                        </div>
                     </div>
                     <?php $i++; } ?>
                     <?php if($id) { ?>
                     <div class="formSubmit">
                        <button type="button" onclick="saveMilestones();"  class="btn btn-default btnBlue pull-right ">Save</button>
                        <a href="<?php echo base_url('observation/add?type=observation&sub_type=EYLF&id='.$id); ?>" class="btn btn-default btnRed pull-right ">Cancel</a>
                     </div>
                     <?php } ?>
                  </div>
                  
               </form>
            </div>
         </div>
      </div>
      <div class="tab-pane <?php if($type=='links' ) { ?>active<?php } ?>" id="tabs-3">
         <div class="linkobservation">
            <button type="button" class="btn btn-default btn-small btnBlue" data-toggle="modal" data-target="#modal-linkobs">
            <span class="material-icons-outlined">add</span> Link Observation
            </button>
            <button type="button" class="btn btn-default btn-small btnGreen" data-toggle="modal" data-target="#modal-linkref">
            <span class="material-icons-outlined">add</span> Link Reflection
            </button>
         </div>
         <form method="post" id="form-link">
            <input type="hidden" name="linkType" value="OBSERVATION">
            <!-- Link Observation modal -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="modal-linkobs" aria-labelledby="myLargeModalLabel">
               <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Link Observation</h4>
                  </div>
                  <div class="modal-body">
                     <?php  foreach($obsPublished as $link) {  ?>
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="block obsListBox">
                              
                           <div class="obsListBoxImg">
                             <?php if(!empty($link->media)) {  ?>
                                 <div class="imageobser">
                                    <img src="<?php echo base_url('/api/assets/media/'.$link->media); ?>" style="height: auto;width: 100%">
                                 </div>
                              <?php } ?>
                             </div>

                              <div clss="obsListBoxAbt">                                 
                                 <div class="pull-right">
                                    <input type="checkbox" name="obsLinks[]" value="<?php echo $link->id; ?>">
                                 </div>
                              <div class="divmon">
                                 <?php if(!empty($link->montessoryCount)) { ?> 
                                    <span class="mon">Montessori <span class="moncount"><?php echo $link->montessoryCount; ?></span></span>
                                 <?php } ?>
                                 <?php if(!empty($link->eylfCount)) { ?>
                                    <span class="mon">EYLF <span class="moncount"><?php echo $link->eylfCount; ?></span></span>
                                 <?php } ?>
                                 <?php if(!empty($link->milestoneCount)) { ?>
                                    <span class="mon">DM <span class="moncount"><?php echo $link->milestoneCount; ?></span></span>
                                 <?php } ?>
                              </div>
                              <?php  if(!empty($link->childrens)) { ?>
                              <div class="divchild">
                                 <span style="display: inline-flex;">
                                 <?php $i=1; foreach($link->childrens as $chi) { ?>
                                    <span>
                                       <img class="circleimage" src="<?php echo base_url('/api/assets/media/'.$chi->imageUrl); ?>" width="15" height="15">
                                       <span class="childname"><?php echo $chi->child_name; ?></span>
                                    </span>
                                 <?php 
                                       if($i>=2) { 
                                          $i++; break; 
                                       } 
                                       $i++; 
                                    } 
                                       if($i>2) { 
                                 ?>
                                    <span style="margin-left: 10px">
                                       <a href="<?php echo base_url('observation/view?id='.$link->id); ?>">
                                          <span class="countchild">+<?php echo count($link->childrens)-2; ?></span>
                                       </a>
                                    </span>
                                 <?php } ?>
                                 </span>
                                 <span class="spanborder">&nbsp;<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $link->status; ?>&nbsp;</span>
                              </div>
                              <?php } ?>
                              <a href="<?php echo base_url('observation/view?id='.$link->id); ?>"><span class="obserb"><?php echo $link->title; ?></span></a>
                              <p style="float: none;">
                                 <span style="display: inline-block;width: 200px;">
                                    <span class="author">Author:</span> 
                                    <a href=""><span class="authorname"><?php echo $link->user_name; ?></span></a>
                                 </span>
                                 <span>
                                    <span class="author">Approved by:</span> 
                                    <a href=""><span class="authorname"><?php echo $link->approverName; ?></span></a>
                                 </span>
                              </p>
                              </div>
                              
                           </div>
                        </div>
                     </div>
                  <?php } ?>
                  <div class="modal-footer">
                     <button type="button" onclick="createLinks();" class="btn btn-default btn-small btnBlue pull-right">Save changes</button>
                     <button type="button" class="btn btn-default btn-small pull-right" data-dismiss="modal">Close</button>
                  </div>
                  </div>
                  </div>
               </div>
            </div>
            <!-- Link Observation modal end -->
         </form>
         <form method="post" id="form-link-ref">
            <input type="hidden" name="linkType" value="REFLECTION">
            <!-- Link Reflection Modal -->
            <div class="modal fade" id="modal-linkref" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Link Reflection</h4>
                  </div>
                  <div class="modal-body">
                     <div class="row">
                        <div class="col-md-12">
                           <?php  foreach($refPublished as $ref) {  ?>
                           <div class="ref-block">
                              <div class="ref-title">
                                 <a href="#"><?php echo ucwords(strtolower($ref->title)); ?></a>
                              <span class="pull-right">
                                 <span style="background: #0C9600; font-size: 12px; color: #fff; padding: 4px 5px; border-radius: 4px;">
                                    <?php echo $ref->status; ?>
                                 </span>&nbsp;
                                 <input type="checkbox" name="obsLinks[]" value="<?php echo $ref->id; ?>">
                              </span>
                              </div> 
                              <div class="ref-status">
                                 <?php echo "Created By: " . ucwords(strtolower($ref->name)); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 <?php #echo "Approved By: " . ucwords(strtolower($ref->approverName)); ?>
                                 
                              </div>   
                              <div class="ref-body">
                                 <p><?php echo $ref->about; ?></p>
                              </div>     
                           </div>
                           <?php } ?>               
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-small btnBlue pull-right" onclick="saveReflection();">Save changes</button>
                        <button type="button" class="btn btn-default btn-small pull-right" data-dismiss="modal">Close</button>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
            <!-- Link Reflection Modal end -->
         </form>
         <!-- Preview Modal -->.
         <div class="modal fade" id="modal-clean" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">                    
               <div class="modal-content">                    
                  <div class="modal-body">
                     <button type="button" class="close" data-dismiss="modal" aria-label="close"><i class="fa fa-close"></i></button>
                     <span style="display: flex;justify-content: center;color: #000000;font-size: 16px;">
                        <?php echo isset($observation->title)?$observation->title:''; ?>
                     </span>
                     <span>Authored by <span><?php echo isset($observation->user_name)?$observation->user_name:''; ?></span><?php echo date('d M Y h:i a',strtotime($observation->date_added)); ?></span>
                     <?php  if(!empty($observationChildrens)) { ?>
                        <div class="divchild">
                           <span style="display: inline-flex;">
                              <?php  foreach($observationChildrens as $chi) { ?>
                                 <span class="parentchildpopname">
                                    <img class="circleimage" src="<?php echo base_url('/api/assets/media/'.$chi->imageUrl); ?>" width="15" height="15">
                                    <span class="childpopname"><?php echo $chi->child_name; ?></span>
                                 </span>&nbsp;&nbsp;
                              <?php  } ?>
                           </span>
                        </div>
                     <?php } ?>
                     <?php if($observation->notes) { ?>
                        <span class="popspanhead">Notes</span></br>
                        <p class="popp"><?php echo $observation->notes; ?></p>
                     <?php } ?>
                     <?php if($observation->reflection) { ?>
                        <span class="popspanhead">Reflection</span></br>
                        <p class="popp"><?php echo $observation->notes; ?></p>
                     <?php } ?>
                     <?php if(!empty($observationEylfDetails)) { ?>
                     </br>
                     <b>Early Years Learning Framework </b>
                     <?php foreach($observationEylfDetails as $key=>$observationEylfDetail) { ?>
                        <div class="div-color3"><?php echo $outcomes->$key; ?></div>
                        <?php foreach($observationEylfDetail as $key1=>$detail) { ?>
                           <p class="background-light"><?php echo $eylfActivites->$key1; ?></p>
                           <?php foreach($detail as $det) { ?>
                              <div class="row">
                                 <div class="col-sm-9">
                                    <?php echo $det; ?></span>
                                 </div>
                                 <div class="col-sm-3">
                                    <span style="float: right;" class="spanborder">&nbsp;<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;Observed&nbsp;</span>
                                 </div>
                              </div>
                           <?php } ?>
                        <?php } ?>
                     <?php } } ?>
                     <?php if(!empty($observationMontessoriDetails)) { ?>
                        <b>Montessori Activities</b></br>
                        <?php foreach($observationMontessoriDetails as $key=>$observationMontessoriDetails) { ?>
                           <p class="background-light"><?php echo $subjects->$key; ?></p>
                           <?php foreach($observationMontessoriDetails as $key1=>$detail) { ?>
                              <p><?php echo $montessoriActivites->$key1; ?></p>
                              <?php foreach($detail as $det) { ?>
                                 <span class="spanborder2">
                                    <span style="font-weight: 500;"><?php echo $det->subactivityName; ?></span>
                                    <span class="pull-right spanborder1"><?php echo $det->extra; ?></span>
                                    <?php if($det->subject) { ?>
                                       <span class="div-color"><?php echo $det->subject; ?></span>
                                    <?php } ?>
                                 </span>
                              <?php }
                           }
                        } 
                     }
                     if(!empty($observationMilestoneDetails)) { ?>
                     </br></br>
                     <b>Developmental Milestones</b>
                     <?php foreach($observationMilestoneDetails as $key=>$observationMilestoneDetails) { ?>
                     <p style="float: none;" class="background-light"><?php echo $milestonesubjects->$key; ?></p>
                     <?php foreach($observationMilestoneDetails as $key1=>$detail) { ?>
                        <p style="float: none;" ><?php echo $milestoneActivites->$key1; ?></p>
                        <?php foreach($detail as $det) { ?>
                           <span class="spanborder2">
                              <span style="font-weight: 500;"><?php echo $det->subactivityName; ?></span>
                              <span class="pull-right spanborder1"><?php echo $det->extra; ?></span>
                              <?php if($det->subject) { ?>
                                 <span class="div-color"><?php echo $det->subject; ?></span>
                              <?php } ?>
                           </span>
                        <?php }  } ?>
                     <?php } } ?>
                  </div>                    
               </div>
            </div>            
         </div>
         <!-- Preview Modal End -->
         <div class="pub-obs-links" >
            <?php if(empty($observationLinks)){ ?>
               <img style="height: 30px;width: 30px;margin: 30px auto;" src="<?php echo base_url('assets/images/icons/broken-link.png'); ?>">
               <div>This Observation has no links</div>
            <?php }else{ 
               foreach($observationLinks as $link) {  
            ?>
            <div class="listObservationView">
               <div class="subListObservationView">
                  <div class="block">
                     <div class="pull-right">
                        <a href="<?php echo base_url('observation/deleteLink?type=links&id='.$id.'&linkId='.$link->id); ?>"><span class="text-danger fa fa-times"></span></a>
                     </div>
                     <a href="<?php echo base_url('observation/view?id='.$link->id); ?>"><span class="obserb"><?php echo $link->title; ?></span></a>
                     <p style="float: none;">
                        <span style="display: inline-block;width: 200px;">
                           <span class="author">Author:</span> 
                           <a href=""><span class="authorname"><?php echo $link->user_name; ?></span></a>
                        </span>
                        <span>
                           <span class="author">Approved by:</span> 
                           <a href=""><span class="authorname"><?php echo $link->approverName; ?></span></a>
                        </span>
                     </p>
                     <?php  if(!empty($link->childrens)) { ?>
                        <div class="divchild">
                           <span style="display: inline-flex;">
                              <?php $i=1; foreach($link->childrens as $chi) { ?>
                                 <span>
                                    <img class="circleimage" src="<?php echo base_url('/api/assets/media/'.$chi->imageUrl); ?>" width="15" height="15">
                                    <span class="childname"><?php echo $chi->child_name; ?></span>
                                 </span>
                                 <?php 
                                 if($i>=2) { 
                                    $i++; break; 
                                 } 
                                 $i++; 
                              } 
                              if($i>2) { 
                                 ?>
                                 <span style="margin-left: 10px">
                                    <a href="<?php echo base_url('observation/view?id='.$link->id); ?>">
                                       <span class="countchild">+<?php echo count($link->childrens)-2; ?></span>
                                    </a>
                                 </span>
                              <?php } ?>
                           </span>
                           <span class="spanborder">&nbsp;<i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $link->status; ?>&nbsp;</span>
                        </div>
                     <?php } 
                     if(!empty($link->media)) {  ?>
                        <div class="imageobser">
                           <img src="<?php echo base_url('/api/assets/media/'.$link->media); ?>" style="height: auto;width: 100%">
                        </div>
                     <?php } ?>
                     <div class="divmon">
                        <?php if(!empty($link->montessoryCount)) { ?> 
                           <span class="mon">Montessori <span class="moncount"><?php echo $link->montessoryCount; ?></span></span>
                        <?php } ?>
                        <?php if(!empty($link->eylfCount)) { ?>
                           <span class="mon">EYLF <span class="moncount"><?php echo $link->eylfCount; ?></span></span>
                        <?php } ?>
                        <?php if(!empty($link->milestoneCount)) { ?>
                           <span class="mon">DM <span class="moncount"><?php echo $link->milestoneCount; ?></span></span>
                        <?php } ?>
                     </div>
                  </div>
               </div>
            </div>
            <?php }
               foreach($reflectionLinks as $ref) {  ?>
            <div class="listObservationView" >
               <div class="subListObservationView">
                  <div class="ref-block">
                     <div class="ref-title">
                        <a href="#"><?php echo ucwords(strtolower($ref->title)); ?></a>
                        <a class="pull-right" href="<?php echo base_url('observation/deleteLink?type=links&id='.$id.'&linkId='.$ref->id); ?>"><span class="text-danger fa fa-times"></span></a>
                     </div> 
                     <div class="ref-status">
                        <?php echo "Created By: " . ucwords(strtolower($ref->user_name)); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo "Approved By: " . ucwords(strtolower($ref->approverName)); ?>
                        <span class="pull-right" style="background: #0C9600; font-size: 12px; color: #fff; padding: 4px 5px; border-radius: 4px;"><?php echo $ref->status; ?></span>
                     </div>   
                     <div class="ref-body">
                        <p><?php echo $ref->about; ?></p>
                     </div>     
                  </div>
               </div>
            </div>
            <?php } } ?>
            <?php if(!empty($id)) { ?>
            <div class="formSubmit" >
               <button class="btn btn-default pull-right btnGreen btn-preview" data-toggle="modal" data-target="#modal-clean">Preview</button>
               <a href="<?php echo base_url('observation/observation_dashboard'); ?>" class="btn btn-default pull-right btnBlue btn-info">Submit</a>
            </div>
            <?php } ?>
         </div>
      </div>
   </div>

   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <form id="myModalForm">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title" id="myModalLabel">Edit Image</h4>
         </div>
         <div class="modal-body">
           <div class="row">
              <div class="col-md-6">
                 <img src="" alt="" class="img-responsive">
              </div>
              <div class="col-md-6">
               <input type="hidden" class="img-count" value="">
                 <div class="form-group">
                     <label>Childs</label>
                     <select class="js-example-basic-multiple form-control" multiple="multiple" name="childsId[]" id="child-tags">
                        <?php foreach ($childs as $key => $ch) { ?>
                        <option value="<?php echo $ch->id; ?>"><?php echo $ch->name; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label>Educators</label>
                     <select class="js-example-basic-multiple form-control" multiple="multiple" name="educatorsId[]" id="educator-tags">
                     <?php foreach ($educators as $key => $ed) { ?>
                        <option value="<?php echo $ed->userid; ?>"><?php echo $ed->name; ?></option>
                     <?php } ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <label>Caption</label>
                     <input type="text" class="form-control" id="imgCaption" value="">
                  </div>
                 <div class="temp-edit-sec">
                  <input type="hidden" id="ed-mda-id" value="">
                 </div>
              </div>
           </div>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <button type="button" id="saveImgAttr" class="btn btn-primary myModalBtn" data-dismiss="modal">Save changes</button>
         </div>
         </form>
       </div>
     </div>
   </div>


<div class="modal fade" id="uploadMediaModal" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title">Select Media</h4>
         </div>
         <div class="modal-body">
           <p>One fine body&hellip;</p>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           <button type="button" class="btn btn-primary">Save changes</button>
         </div>
      </div>
   </div>
</div>

</div>



<?php $this->load->view('footer'); ?>
<script type="text/javascript">

$("#centerId").on('change',function(){
let centerid = $(this).val();
<?php  
      $qs = $_SERVER['QUERY_STRING'];
      if ($qs == "") {
?>
   $("#centerDropdown").submit();
<?php
      }else{
         if (isset($_GET['centerid'])&&$_GET['centerid']!="") {
            $url = str_replace('centerid='.$_GET['centerid'], 'centerid=', $_SERVER['QUERY_STRING']);
         } else {
            $url = $_SERVER['QUERY_STRING']."&centerid=";
         }
?>
      var url = "<?php echo base_url('observation/add?').$url; ?>"+centerid;
      var test = url.replace(/&/g, '&');
      window.location.href=test;
<?php } ?>
});

function pagination() {
   var pageSize = 4;
   var pageCount = $(".line-content").length / pageSize;
   var msg = '';
   for (var i = 0; i < pageCount; i++) {
      msg += '<li><a href="#">' + (i + 1) + '</a></li>';
   }
   $("#pagin").html(msg);
   $("#pagin li").first().find("a").addClass("current")
   showPage = function (page) {
      $(".line-content").hide();
      $(".line-content").each(function (n) {
         if (n >= pageSize * (page - 1) && n < pageSize * page)
            $(this).show();
      });
   }

   showPage(1);
}

pagination();
$("#pagin li a").click(function () {
   $("#pagin li a").removeClass("current");
   $(this).addClass("current");
   showPage(parseInt($(this).text()))
});
var base_url = '<?php echo base_url(); ?>';
$(document.body).delegate('.check_link', 'click', function () {
   links();
});
var ids = [];

function links() {
   ids = [];
   $('.check_link').each(function () {
      if ($(this).prop("checked") == true) {
         if (jQuery.inArray($(this).val(), ids) === -1) {
            ids.push($(this).val());
         }
      }
   });
}
$('.filtercollapsible').click(function () {
   if ($(this).hasClass("active")) {
      $(this).find('.subchild').html('<img style="height: 8px;"   src="' + base_url + 'assets/images/icons/up_arrow.png">');
   } else {
      $(this).find('.subchild').html('<img style="height: 8px;"   src="' + base_url + 'assets/images/icons/down_arrow_black.png">');
   }
});

function filters() {
   var childs = [];
   $('.filter_child').each(function () {
      if ($(this).prop("checked") == true && $(this).val() == 'All') {
         if ($(this).val() == 'All') {
            childs = [];
            return false;
         } else {
            childs.push($(this).val());
         }

      }

   });
   var authors = [];
   $('.filter_author').each(function () {
      if ($(this).prop("checked") == true) {
         authors.push($(this).val());
      }
   });
   var assessments = [];
   $('.filter_assessment').each(function () {
      if ($(this).prop("checked") == true) {
         assessments.push($(this).val());
      }
   });
   var base_url = '<?php echo base_url(); ?>';
   $.ajax({
      type: 'POST',
      url: '<?php echo base_url('observation/filters?id='.$id); ?>',
      data : 'childs=' + childs + '&authors=' + authors + '&assessments=' + assessments,
      datatype: 'json',
      success: function (json) {
         console.log(json);
         json = JSON.parse(json);
         var msg = '';
         $.each(json.observations, function (key, val) {
            if (jQuery.inArray(key, ids) === -1) {
               msg += '<div class="block line-content">' +
               '<div class="pull-right"><input type="checkbox" name="link[]" class="check_link" value="' + key + '">' +
               '</div>' +
               '<a href="' + base_url + 'observation/view?id=' + key + '"><span class="obserb">' + val.title + '</span></a>' +
               '<p style="float: none;"><span style="display: inline-block;width: 200px;"><span class="author">Author:</span> <a href=""><span class="authorname">' + val.userName + '</span></a></span>' +
               '<span class="author">Approved by:</span> <a href=""><span class="authorname">' + val.approverName + '</span></a></span</p>' +
               '</br>';
               if (Object.keys(val.childs).length != 0) {
                  msg += '<div class="divchild"><span style="display: inline-flex;">';
                  var i = 1;

                  $.each(val.childs, function (ckey, child) {
                     msg += '<span ><img class="circleimage" src="' + base_url + '/api/assets/media/' + child.imageUrl + '" width="15" height="15">' +
                     ' <span class="childname">' + child.child_name + '</span></span>'
                     if (i >= 2) {
                        i++;
                        return false;
                     }
                     i++;
                  });

                  if (i > 2) {

                     var count = Object.keys(val.childs).length - 2;
                     msg += '<span style="margin-left: 10px"><a href="' + base_url + 'observation/view?id=' + key + '">' +
                     '<span class="countchild">+' + count + '</span></a></span>'
                  }
                  msg += '</span><span  class="spanborder"> <i class="fa fa-check" aria-hidden="true"></i>  ' + val.status + ' </span></div>';

               }
               if (val.media) {
                  msg += '<div class="imageobser"><img src="' + base_url + '/api/assets/media/' + val.media + '" style="height: auto;width: 100%"></div>';
               }
               msg += '<div class="divmon">';
               if (val.montessoryCount != 0) {
                  msg += '<span class="mon">Montessori <span class="moncount">' + val.montessoryCount + '</span></span>';
               }
               if (val.eylfCount != 0) {
                  msg += '<span class="mon">EYLF <span class="moncount">' + val.eylfCount + '</span></span>';
               }
               if (val.milestoneCount != 0) {
                  msg += '<span class="mon">DM <span class="moncount">' + val.milestoneCount + '</span></span>';
               }

               msg += '</div></div>';
            }

         });

         $('.check_link').each(function () {
            if (jQuery.inArray($(this).val(), ids) === -1) {
               $(this).closest('.block').remove();
            }
         });

         $('.publishedobservation').append(msg);
         pagination();
      }
   });
}
$('.filter_assessment').click(function () {
   var val = $(this).val();
   if (val == 'Does Not Have Any Assessment') {
      if ($(this).prop("checked") == true) {
         $('.filter_assessment').each(function () {
            if ($(this).val() !== 'Does Not Have Any Assessment') {
               $(this).prop('checked', false);
               $(this).attr("disabled", true);
            }
         });
      } else {
         $('.filter_assessment').each(function () {
            if ($(this).val() !== 'Does Not Have Any Assessment') {
               $(this).removeAttr("disabled");
            }
         });
      }

   }
   //Does Not Have Montessori
   if (val == 'Does Not Have Montessori') {
      if ($(this).prop("checked") == true) {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Has Montessori') {
               $(this).prop('checked', false);
               $(this).attr("disabled", true);
            }
         });
      } else {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Has Montessori') {
               $(this).removeAttr("disabled");
            }
         });
      }
   }
   //Does Not Have Early Years Learning Framework
   if (val == 'Does Not Have Early Years Learning Framework') {
      if ($(this).prop("checked") == true) {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Has Early Years Learning Framework') {
               $(this).prop('checked', false);
               $(this).attr("disabled", true);
            }
         });
      } else {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Has Early Years Learning Framework') {
               $(this).removeAttr("disabled");
            }
         });
      }
   }
   //Does Not Have Developmental Milestones
   if (val == 'Does Not Have Developmental Milestones') {
      if ($(this).prop("checked") == true) {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Has Developmental Milestones') {
               $(this).prop('checked', false);
               $(this).attr("disabled", true);
            }
         });
      } else {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Has Developmental Milestones') {
               $(this).removeAttr("disabled");
            }
         });
      }
   }
   //Has Montessori
   if (val == 'Has Montessori') {
      if ($(this).prop("checked") == true) {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Does Not Have Montessori') {
               $(this).prop('checked', false);
               $(this).attr("disabled", true);
            }
         });
      } else {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Does Not Have Montessori') {
               $(this).removeAttr("disabled");
            }
         });
      }
   }
   //Has Early Years Learning Framework
   if (val == 'Has Early Years Learning Framework') {
      if ($(this).prop("checked") == true) {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Does Not Have Early Years Learning Framework') {
               $(this).prop('checked', false);
               $(this).attr("disabled", true);
            }
         });
      } else {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Does Not Have Early Years Learning Framework') {
               $(this).removeAttr("disabled");
            }
         });
      }
   }
   //Has Developmental Milestones
   if (val == 'Has Developmental Milestones') {
      if ($(this).prop("checked") == true) {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Does Not Have Developmental Milestones') {
               $(this).prop('checked', false);
               $(this).attr("disabled", true);
            }
         });
      } else {
         $('.filter_assessment').each(function () {
            if ($(this).val() == 'Does Not Have Developmental Milestones') {
               $(this).removeAttr("disabled");
            }
         });
      }
   }
filters();
});
$('.filter_author').click(function () {
   if ($(this).val() == 'Any') {
      if ($(this).prop("checked") == true) {
         $('.filter_author').prop('checked', true);
      } else {
         $('.filter_author').prop('checked', false);
      }
   }

   filters();
});
$('.filter_child').click(function () {

   if ($(this).val() == 'All') {
      if ($(this).prop("checked") == true) {
         $('.filter_child').prop('checked', true);
      } else {
         $('.filter_child').prop('checked', false);
      }
   }

   var len = $('.filter_child').length;
   len = len - 1;
   var count = 0;
   $('.filter_child').each(function () {
      if ($(this).prop("checked") == true && $(this).val() != 'All') {
         count++;
      }
   });
   if (count != len) {
      $('.filter_child').each(function () {
         if ($(this).val() == 'All') {
            $(this).prop('checked', false);
         }
      });
   } else {
      $('.filter_child').each(function () {
         if ($(this).val() == 'All') {
            $(this).prop('checked', true);
         }
      });
   }
   filters();
});

function btnLink() {
   $('.linkobservation').hide();
   $('.brokenlink').hide();
   $('.link_observation').show();
   $('.link-reflection').hide();
}

function btnReflection() {
   $('.linkobservation').hide();
   $('.brokenlink').hide();
   $('.link_observation').hide();
   $('.link-reflection').show();
}

$('.button_child').click(function () {
   if ($(this).hasClass('select_all')) {
      var obj = {};
      var i = 0;
      $('.selected_check').each(function () {
         $(this).prop('checked', true);
         if (obj[$(this).val()] === undefined) {
            obj[$(this).val()] = 0;
            i++;
         }
      });
      if (i == 1) {
         $('.no-childerns').html(i + ' Child Selected');
      } else {
         $('.no-childerns').html(i + ' Childern Selected');
      }
      $(this).removeClass("select_all");
      $(this).addClass("deselect_all");

      $('.btn-child-select-all').removeClass("select_all");
      $('.btn-child-select-all').addClass("deselect_all");
      $('.btn-child-select-all').prop('checked', true);
   } else {
      $('.selected_check').each(function () {
         $(this).prop('checked', false);
      });
      $('.no-childerns').html('O Children Selected');
      $(this).removeClass("deselect_all");
      $(this).addClass("select_all");

      $('.btn-child-select-all').removeClass("deselect_all");
      $('.btn-child-select-all').addClass("select_all");
      $('.btn-child-select-all').prop('checked', false);
   }
});

$('.btngroup').click(function() {
   var id = $(this).attr('id');
   if ($(this).hasClass('sa')) {
      var obj = {};
      var i = 0;
      $('.' + id).each(function () {
         $(this).prop('checked', true);
         var val = $(this).val()
         $('.check' + val).prop('checked', true);
      });
      $('.selected_check').each(function () {
         if ($(this).prop("checked") == true) {
            if (obj[$(this).val()] === undefined) {
               obj[$(this).val()] = 0;
               i++;
            }
         }
      });
      if (i == 1) {
         $('.no-childerns').html(i + ' Child Selected');
      } else {
         $('.no-childerns').html(i + ' Childern Selected');
      }
      $(this).removeClass("sa");
      $(this).addClass("dsa");
      $(this).prop('checked', true);
   } else {

      $('.' + id).each(function () {
         $(this).prop('checked', false);
         var val = $(this).val()
         $('.check' + val).prop('checked', false);
      });
      var obj = {};
      var i = 0;
      $('.selected_check').each(function () {
         if ($(this).prop("checked") == true) {
            if (obj[$(this).val()] === undefined) {
               obj[$(this).val()] = 0;
               i++;
            }
         }
      });
      if (i == 1) {
         $('.no-childerns').html(i + ' Child Selected');
      } else {
         $('.no-childerns').html(i + ' Childern Selected');
      }
      $(this).removeClass("dsa");
      $(this).addClass("sa");
      $(this).prop('checked', false);
   }
   total();
});

$('.selected_check').click(function () {
   var val = $(this).val();
   if ($(this).prop("checked") == true) {
      $('.check' + val).prop('checked', true);
   } else {
      $('.check' + val).prop('checked', false);
   }
   total();
});

function total() {
   var i = 0;
   var count = $('.childcheck').length;
   $('.childcheck').each(function () {
      if ($(this).prop("checked") == true) {
         i++;
      }
   });
   if (i == count) {
      $('.button_child').removeClass("select_all");
      $('.button_child').addClass("deselect_all");
      $('.button_child').prop('checked', true);;
   } else {
      $('.button_child').removeClass("deselect_all");
      $('.button_child').addClass("select_all");
      $('.button_child').prop('checked', false);;
   }
   $('.btngroup').each(function () {
      var id = $(this).attr('id');
      var i = 0;
      var count = $('.' + id).length;
      $('.' + id).each(function () {
         if ($(this).prop("checked") == true) {
            i++;
         }
      });
      if (i == count) {
         $(this).removeClass("select_all");
         $(this).addClass("deselect_all");
         $(this).prop('checked', true);;
      } else {
         $(this).removeClass("deselect_all");
         $(this).addClass("select_all");
         $(this).prop('checked', false);
      }
   });
   var obj = {};
   var i = 0;
   $('.selected_check').each(function () {
      if ($(this).prop("checked") == true) {
         if (obj[$(this).val()] === undefined) {
            obj[$(this).val()] = 0;
            i++;
         }
      }
   });
   if (i == 1) {
      $('.no-childerns').html(i + ' Child Selected');
   } else {
      $('.no-childerns').html(i + ' Childern Selected');
   }
}

function saveMontessori() {
   var url = "<?php echo base_url('observation/add?type=assessments&sub_type=EYLF&id='.$id); ?>";
   var test = url.replace(/&/g, '&');
   document.getElementById("form-montessori").action = test;
   document.getElementById("form-montessori").submit();
}

function saveEylf() {
   var url = "<?php echo base_url('observation/add?type=assessments&sub_type=Milestones&id='.$id); ?>";
   var test = url.replace(/&/g, '&');
   document.getElementById("form-eylf").action = test;
   document.getElementById("form-eylf").submit();
}

function createLinks() {
   var url = "<?php echo base_url('observation/add?type=links&status=true&id='.$id); ?>";
   var test = url.replace(/&/g, '&');
   document.getElementById("form-link").action = test;
   document.getElementById("form-link").submit();
}

function saveReflection() {
   var url = "<?php echo base_url('observation/add?type=links&status=true&id='.$id); ?>";
   var test = url.replace(/&/g, '&');
   document.getElementById("form-link-ref").action = test;
   document.getElementById("form-link-ref").submit();
}

function editObservation() {
   if ($('#obs_title').val() == '') {
      alert('Plz Enter Title');
      return false;
   }
   var url = "<?php echo base_url('observation/add?type=assessments&sub_type=Montessori&id='.$id); ?>";
   var test = url.replace(/&/g, '&');
   document.getElementById("form-observation").action = test;
   document.getElementById("form-observation").submit();
}

function saveObservation() {

   if ($('#obs_title').val() == '') {
      alert('Plz Enter Title');
      return false;
   }

   var url = "<?php echo base_url('observation/add?type=assessments'); ?>";
   var test = url.replace(/&/g, '&');
   document.getElementById("form-observation").action = test;
   document.getElementById("form-observation").submit();
}

function saveMilestones() {
   var url = "<?php echo base_url('observation/add?type=links&id='.$id); ?>";
   var test = url.replace(/&/g, '&');
   document.getElementById("form-milestones").action = test;
   document.getElementById("form-milestones").submit();
   console.log(test);
}

function myFunction() {
   var input, filter, table, tr, td, i, alltables;
   alltables = document.querySelectorAll("table[data-name=listtable]");
   input = document.getElementById("myInput");
   filter = input.value.toUpperCase();
   alltables.forEach(function (table) {
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
         td = tr[i].getElementsByTagName("td")[0];
         if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
               tr[i].style.display = "";
            } else {
               tr[i].style.display = "none";
            }
         }
      }
   });
}
'<?php if(!empty($observationChildrens)) { ?>'
$('.bootstrap-tagsinput').show();
'<?php  } else { ?>'
$('.bootstrap-tagsinput').hide();
'<?php } ?>'

function select_children() {
   var obj = {};
   var msg = '';
   $('.selected_check').each(function () {
      if ($(this).prop("checked") == true) {
         if (obj[$(this).val()] === undefined) {
            obj[$(this).val()] = 0;
            msg += '<span class="tag label label-info"><input type="hidden" name="childrens[]" value="' + $(this).val() + '">' + $(this).attr('id') + '<span class="rem" data-role="remove"></span></span>';
         }
      }
   });
   msg += '<input type="text" readonly="" placeholder="" size="1">';
   $('.bootstrap-tagsinput').html(msg);
   $('.bootstrap-tagsinput').show();
}

$(document.body).delegate('.rem', 'click', function () {
   $(this).parent().remove();
});
$(document.body).delegate('.dz-remove', 'click', function () {
   $(this).parent().remove();
});

$(document).on('click','.rem',function(){
   var val = $(this).parent().find('input').val();
   $("input.selected_check[value='"+val+"']").prop("checked",false);
});

$(document).ready(function(){
   var child_count = $(".childcheck:checked").length;
   var group_child_count = $(".groupcheck:checked").length;

   if (child_count>0) {
      $('.no-childerns').text(child_count+" Children Selected");
   }

   if (group_child_count>0) {
      $('.no-childerns').text(child_count+" Children Selected");
   }

   $('.childcheck').each(function(index){
      var checkbox = $(this).val();
      if ($(this).is(":checked")) {
         $("input.selected_check[value='"+checkbox+"']").prop("checked",true);
      }else{
         $('input.selected_check[value="'+checkbox+'"]').prop("checked",false);
      }
   });

   $('#myModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var edit = button.data('edit');
      var img = button.data('image');
      var imgCount = button.data('imgcount');
      var modal = $(this);
      modal.find('img').prop("src",img);
      modal.find('.img-count').val(imgCount);

      if (edit==1) {
         $('#ed-mda-id').val(button.data('mediaid'));
         $(".myModalBtn").attr("id","saveImgProp");         
      } else {
         $(".myModalBtn").attr("id","saveImgAttr");
      }
   }); 

   $(document).on('click','#saveImgAttr',function(){
      var childIds = $('#child-tags').val();
      var emediaId = $('#ed-mda-id').val();
      var educatorIds = $('#educator-tags').val();
      var imgCaption = $('#imgCaption').val();
      var imgCount = $('.img-count').val();
      for(i=0;i<childIds.length;i++){
         $('input[name="obsImage_'+imgCount+'[]"]').remove();
         $("#form-observation").append('<input type="hidden" name="obsImage_'+imgCount+'[]" value="'+childIds[i]+'">');
      }
      for(j=0;j<educatorIds.length;j++){
         $('input[name="obsEducator_'+imgCount+'[]"]').remove();
         $("#form-observation").append('<input type="hidden" name="obsEducator_'+imgCount+'[]" value="'+educatorIds[j]+'">');
      }

      if(emediaId!=""){
         $('input[name="obsMediaId_'+imgCount+'"]').remove();
         $("#form-observation").append('<input type="hidden" name="obsMediaId_'+imgCount+'" value="'+emediaId+'">');
      }
      $('input[name="obsCaption_'+imgCount+'"]').remove();
      $("#form-observation").append('<input type="hidden" name="obsCaption_'+imgCount+'" value="'+imgCaption+'">');

      $("#child-tags").select2('destroy').val("").select2();
      $('#educator-tags').select2('destroy').val("").select2();
      $('#ed-mda-id').val("");
      $("#myModalForm").get(0).reset();
   });

   $(document).on('click','#saveImgProp',function(){
      var obsId = "<?php echo isset($_GET['id'])?$_GET['id']:0; ?>";
      var childIds = $("#child-tags").select2("val");
      var emediaId = $('#ed-mda-id').val();
      var educatorIds = $('#educator-tags').select2("val");
      var imgCaption = $('#imgCaption').val();
      childIds = JSON.stringify(childIds);
      educatorIds = JSON.stringify(educatorIds);
      $.ajax({
         traditional: true,
         url: "<?php echo base_url("Observation/saveImageTags")?>",
         type: "POST",
         data: {"obsId":obsId,"childIds":childIds,"emediaId":emediaId,"educatorIds":educatorIds,"imgCaption":imgCaption},
         success: function(msg){
            var res = jQuery.parseJSON(msg);
            console.log(msg);
         }
      });

      $("#child-tags").select2('destroy').val("").select2();
      $('#educator-tags').select2('destroy').val("").select2();
      $('#ed-mda-id').val("");
      $("#myModalForm").get(0).reset();
   });

   $("#fileUpload").on('change', function() {
      //Get count of selected files
      const countFiles = $(this)[0].files.length;
      let allGood = true;
      const mainHolder = $("#img-holder");
      for (let i = 0; i < countFiles; i++) {
         const file = this.files[i];
         const url = URL.createObjectURL(file);
         const imgPath = file.name;
         const extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
         const image_holder_name = "img-preview-" + i;
         if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg" || extn == "mp4") {
            if (typeof(Blob) != "undefined") {
              const image_holder = $("#img-preview-" + i);
              if (extn == "mp4") {
                mainHolder.append(`<div class="img-preview">
                                          <video class="thumb-image" controls>
                                            <source src="${url}" type="video/mp4">
                                          </video>
                                          <span class="img-remove"><span class="material-icons-outlined">close</span></span>
                                          <a class="img-edit" href="#!" data-imgcount="${i}" data-image="${url}" data-toggle="modal" data-target="#myModal"><span class="material-icons-outlined">edit</span></a>
                                        </div>`);
              } else {
                mainHolder.append(`<div class="img-preview"><img class="thumb-image" src="${url}"><span class="img-remove"><span class="material-icons-outlined">close</span></span><a class="img-edit" href="#!" data-imgcount="${i}" data-image="${url}" data-toggle="modal" data-target="#myModal"><span class="material-icons-outlined">edit</span></a></div>`);
              }
            }
         } else {
            allGood = false;
            alert("This browser does not support File API.");
            break;
         }
      }

        if (!allGood) {
          alert("Pls select only images and videos");
      }
   });

   $(document).on('click','.img-remove',function(){
      var img = $(this).data('imgcount');
      var imgArr = $('#fileUpload')[0].files;
      var length = $('#fileUpload')[0].files.length;
      var len = $(this).parent("div").prevAll().length;
      let list = new DataTransfer();
      let myFileList;
      for(i=0;i<length;i++){
       if($(this).parent('div').prevAll().length != i){
       let file = new File(["content"], imgArr[i].name);
       list.items.add(file);
       myFileList = list.files;
       }
      }
      $('#fileUpload')[0].files  = myFileList
      $(this).parent().remove();

      $("input[type='hidden'][name='obsImage_"+img+"[]']").remove();
      $("input[type='hidden'][name='obsEducator_"+img+"[]']").remove();
      $("input[type='hidden'][name='obsCaption_"+img+"']").remove();
   });

   $(document).on('click','.deleteMedia',function(){
      var id = $(this).attr('id');
      var img = $(this).data('imgcount');
      var userid = <?php echo $this->session->userdata('LoginId'); ?>;
      $.ajax({
         traditional:true,
         type: "GET",
         url: "<?php echo BASE_API_URL.'observation/deleteMedia/'; ?>"+userid+"/"+id,
         beforeSend: function(request) {
         request.setRequestHeader("X-Device-Id", "<?php echo $this->session->userdata('X-Device-Id');?>");
         request.setRequestHeader("X-Token", "<?php echo $this->session->userdata('AuthToken');?>");
         },
         success: function(msg){
         console.log("Success");
         }
      });
   });

   $(document).on('click','.img-real-edit', function (event) {
      var mediaid = $(this).data('mediaid');
      $.ajax({
         traditional:true,
         type: "POST",
         url: "<?php echo base_url('Observation/getMediaTags/'); ?>",
         data: {"mediaid":mediaid},
         success: function(msg){
            res = jQuery.parseJSON(msg);

            var childTags = [];
            var educatorTags = [];
            $(res.ChildTags).each(function(){
               childTags.push(this.id);
            });
            $(res.EducatorTags).each(function(){
               educatorTags.push(this.userId);
            });
            $("#child-tags").val(childTags);
            $('#child-tags').trigger('change');
            $("#educator-tags").val(educatorTags);
            $('#educator-tags').trigger('change');
            $('#imgCaption').val(res.MediaInfo.caption);
         }
      });
   });


});
</script>