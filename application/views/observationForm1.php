<?php
   $data['name']='Observation'; 
   $this->load->view('header',$data); 
?>
<style>
   .activity-box{
      display: flex;
      align-items: center;
      justify-content: space-between;
   }
   .selectAllCheck{
      padding: 6px 0px;
   }
   .main-row{
      display: flex;
      justify-content: space-between;
      align-items: center;
   }

   .sub-act-row{
      border-bottom: 1px solid #ececec;
      margin: 5px 0px;
   }

   .sub-row{
      border-top: 1px dashed #ececec;
   }
</style>
<div class="container observationListContainer">
   <div class="pageHead">
      <h1>Add Observation</h1>
      <div class="extra-options">
         <div class="obsMenuTop">
            <?php 
            // if ($this->session->userdata("UserType")!="Parent") { 
            //    $qs = $_SERVER['QUERY_STRING'];
            //    $url = base_url("Observation/add").$qs;
            ?>
            <form action="" id="centerDropdown">
               <select name="centerid" id="centerId" class="form-control">
                  <?php 
                     $dupArr = [];
                     $centersList = $this->session->userdata("centerIds");
                     if (empty($centersList)) {
                  ?>
                  <option value="">-- No centers available --</option>
                  <?php
                     }else{
                        foreach($centersList as $key => $center){
                        if ( ! in_array($center, $dupArr)) {
                           if ((isset($_GET['centerid']) && $_GET['centerid'] != "") && $_GET['centerid']==$center->id) {
                  ?>
                  <option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
                  <?php }else{ ?>
                  <option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
                  <?php } } array_push($dupArr, $center); } } ?>
               </select>
            </form>
         <?php #} ?>
         </div>
         <button type="button" class="btn btn-default btn-small" id="btn-preview" data-toggle="modal" data-target="#modal-preview">
           <span class="material-icons-outlined">visibility</span> Preview
         </button>
      </div>
   </div>
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url("Dashboard"); ?>">Application</a></li>
      <li class="active">Observation</li>
   </ul>
   <ul class="nav nav-tabs ">     
      <li <?php if($type=='observation' ) { ?>class="active line-nav-tab" <?php } else { ?> class="line-nav-tab" <?php } ?>>
         <a href="#tabs-1" data-toggle="tab">Observation</a>
      </li>      
      <?php if ($_SESSION['UserType'] != 'Parent') { ?>      
      <li <?php if($type=='assessments' ) { ?>class="active line-nav-tab" <?php } else { ?> class="line-nav-tab" <?php } ?>>
         <a href="#tabs-2" data-toggle="tab">Assessments</a>
      </li>
      <li <?php if($type=='links' ) { ?>class="active line-nav-tab" <?php } else { ?> class="line-nav-tab" <?php } ?>>
         <a href="#tabs-3" data-toggle="tab"> Links</a>
      </li>
      <?php } ?>
   </ul>
   <div class="temp-obs-section">
      <?php 
         if(isset($observation->user_name)){
            $obs_author = $observation->user_name;
         }else{
            $obs_author = $this->session->userdata("Name");
         }
      ?>
      <input type="hidden" id="obs_author" value="<?= $obs_author; ?>">
   </div>
   <div class="tab-content mainTabObservation">
      <div class="tab-pane <?php if($type=='observation') { ?>active<?php } ?>" id="tabs-1">
         <form action="<?php echo base_url('observation/add'); ?>" id="form-observation" method="post" enctype="multipart/form-data">
            <div class="twoColFormDiv row">
               <div class="leftColForm col-sm-6">
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
                           <input type="hidden" name="childrens[]" value="<?php echo $observationChildren->child_id; ?>" data-name="<?php echo $observationChildren->child_name; ?>">
                           <?php echo $observationChildren->child_name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>
                           <span class="rem"  data-role="remove"></span>
                        </span>
                        <?php } 
                        } ?>
                     </div>
                  </div>
                  <div class="form-group required">
                     <label class=" control-label" ><?php echo 'Title'; ?></label>
                     <textarea name="title" id="obs_title" class="form-control" data-sample-short><?php echo isset($observation->title)?$observation->title:''; ?></textarea>
                  </div>
                  <div class="form-group required">
                     <label class="control-label">Notes</label>
                     <textarea name="notes" style="height: 73px;" id="obs_notes"><?php echo isset($observation->notes)?$observation->notes:''; ?></textarea>
                  </div>
                  <?php if ($_SESSION['UserType'] != 'Parent') { ?>
                  <div class="form-group required">
                     <label class=" control-label" >Reflection</label>
                     <textarea style="height: 73px;" id="obs_reflection" name="reflection" class="form-control"><?php echo isset($observation->reflection)?$observation->reflection:''; ?></textarea>
                  </div>
                  <?php } ?>
               </div>
               <div id="img-droppable" class="rightColForm bg-white col-md-6 ">
                  <div class="form-group">                     
                        <div id="img-holder">
                        <?php 
                        if (!empty($observationMedia)) {
                           foreach ($observationMedia as $key => $obsMedia) {
                        ?>
                           <div class="img-preview sticky-preview" data-origin="OBSERVED" data-mediaid="<?php echo $obsMedia->id; ?>" data-key="<?php echo $obsMedia->id; ?>">
                              <img class="thumb-image" src="<?php echo BASE_API_URL."assets/media/".$obsMedia->mediaUrl;?>"><span id="<?php echo $obsMedia->id; ?>" class="img-remove deleteMedia"><span class="material-icons-outlined">close</span></span>
                              <a class="img-edit img-real-edit" href="#!" data-imgcount="<?php echo $key; ?>" data-mediaid="<?php echo $obsMedia->id; ?>" data-image="<?php echo BASE_API_URL."assets/media/".$obsMedia->mediaUrl; ?>" data-toggle="modal" data-target="#myModal" data-edit="1" data-mediaorigin="OBSERVED"><span class="material-icons-outlined">edit</span></a>
                           </div>
                        <?php
                           }
                        }
                        ?>
                        </div>
                        <label class="file-upload-field" data-toggle="modal" data-target="#uploadMediaModal"><span class="material-icons-outlined">add</span><span>Upload</span></label>
                        <input type="file" name="obsMedia[]" id="fileUpload" multiple style="display: none;">
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

                  if ($role == 'Parent') {
                     if(empty($id)) {
               ?>
               <button type="button" onclick="saveObservation();" class="btn btn-default btnBlue pull-right">Publish</button>
               <button type="button" onclick="draftObservation();" class="btn btn-default btnBlue pull-right">Draft</button>
               <?php }else{ ?>
               <button type="button" onclick="editObservation();"  class="btn btn-default btnBlue pull-right">Update</button>
               <?php   
                     }
                  }else{                  
                  if (empty($id)) {
                     if ($addObservation==1) {
               ?>
               <button type="button" onclick="saveObservation();" class="btn btn-default btnBlue pull-right">Save & Next</button>
               <?php
                     }
                  }else{
                     if ($updateObservation==1) {
               ?>
               <button type="button" onclick="editObservation();"  class="btn btn-default btnBlue pull-right">Update</button>
               <?php
                     }
                  }
               }
               ?>
               <a href="<?php echo base_url('observation'); ?>" class="btn btn-default pull-right">Cancel</a>
            </div>
         </form>
         <div class="modal right sideModal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
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
                                             <input class="selected_check childcheck check<?php echo $child->id; ?>" data-name="<?php echo $child->name; ?>" id="<?php echo $child->name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>" value="<?php echo $child->id; ?>" type="checkbox" name='<?php echo $child->name?>'>
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
                                       <div class="pull-right">Select All <input type="checkbox" id="group<?php echo $group_row; ?>" class="btn-child-select-all btngroup sa"></div>
                                    </span>
                                    <table id="myTable" data-name="listtable" class="listtable table table-bordered">
                                       <?php foreach($group as $key=>$child) {
                                          $date1 = new DateTime($child->dob);
                                          $date2 = new DateTime(date('Y-m-d'));
                                          $diff = $date1->diff($date2); 
                                          ?>
                                          <tr>
                                             <td><?php echo $child->child_name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?></td>
                                             <td class="text-right"><input class="selected_check groupcheck check<?php echo $child->child_id; ?> group<?php echo $group_row; ?>" data-name="<?php echo $child->child_name; ?>" id="<?php echo $child->child_name.' - '.$diff->y . ' years, ' . $diff->m.' months'; ?>"  value="<?php echo $child->child_id; ?>" type="checkbox"></td>
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
      <?php if ($role != 'Parent') { ?>
      <div class="tab-pane <?php if($type=='assessments' ) { ?>active<?php } ?>" id="tabs-2">
         <ul class="nav nav-tabs border-tab">
            <?php
               $i = 1; 
               if (isset($assessments)) {
                  $activeSubTypeId = isset($_GET['sub_type']) ? $_GET['sub_type'] : $assessments[0]->id;
                  foreach ($assessments as $asmntKey => $asmntObj) {
                        if ($asmntObj->id == $activeSubTypeId) {
            ?>
            <li class="active">
               <a href="<?= '#asmnttab-'.$asmntObj->id; ?>" data-toggle="tab"><?= $asmntObj->name; ?></a>
            </li>
            <?php
                        } else {
            ?>
            <li>
               <a href="<?= '#asmnttab-'.$asmntObj->id; ?>" data-toggle="tab"><?= $asmntObj->name; ?></a>
            </li>
            <?php
                        }
                     }
            ?>
         </ul>
         <div class="tab-content">
            <?php 
               foreach ($assessments as $asmntKey => $asmntObj) {
            ?>
            <div class="tab-pane <?php echo $asmntObj->id == $activeSubTypeId ? "active" : "";?>" id="<?= 'asmnttab-'.$asmntObj->id; ?>">
               <form action="" method="post" enctype="multipart/form-data" id="form-montessori" class="form-horizontal">
                  <ul class="nav nav-pills bold-tab">
                     <?php $i=1; foreach($asmntObj->subjects as $mon_subject) { ?>
                     <li <?php if($i==1) { ?> class="active" <?php } ?>><a href="#<?php echo str_replace(" ","",$mon_subject->name); ?>" data-toggle="tab"><?php echo $mon_subject->name; ?></a></li>
                     <?php $i++; } ?>
                  </ul>
                  <div class="tab-content">
                     <?php 
                        $i=1; 
                        foreach($asmntObj->subjects as $mon_subject) { 
                     ?>
                        <div class="tab-pane <?php if($i==1) { ?>  active <?php } ?>" id="<?php echo str_replace(" ","",$mon_subject->name); ?>">
                           <div class="pull-left">
                              <?php  
                              if(!empty($mon_subject->activities)) {
                                 foreach($mon_subject->activities as $key1=>$mon_activity) { 
                              ?>
                              <button type="button" class="divexpand">
                                 <?php echo $mon_activity->name; ?>
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
                                 <div class="activity-box">
                                    <div class="subactivity-box">
                                       <strong><?php echo $mon_sub_activity->title; ?></strong>
                                    </div>
                                    <div class="subactivity-box">
                                       <label><input type="radio" id="<?php echo $mon_sub_activity->idSubActivity;?>montessoriNotAssessed" name="montessori[<?php echo $mon_sub_activity->idSubActivity; ?>]" value="Not Assessed" data-subactid="<?php echo $mon_sub_activity->idSubActivity; ?>">NA</label>
                                       &nbsp;&nbsp;
                                       <label><input type="radio" id="<?php echo $mon_sub_activity->idSubActivity;?>montessoriIntroduced" name="montessori[<?php echo $mon_sub_activity->idSubActivity; ?>]" value="Introduced" data-subactid="<?php echo $mon_sub_activity->idSubActivity; ?>">I</label>
                                       &nbsp;&nbsp;
                                       <label><input type="radio" id="<?php echo $mon_sub_activity->idSubActivity;?>montessoriWorking" name="montessori[<?php echo $mon_sub_activity->idSubActivity; ?>]" value="Working" data-subactid="<?php echo $mon_sub_activity->idSubActivity; ?>">W</label>
                                       &nbsp;&nbsp;
                                       <label><input type="radio" id="<?php echo $mon_sub_activity->idSubActivity;?>montessoriCompleted" name="montessori[<?php echo $mon_sub_activity->idSubActivity; ?>]" value="Completed" data-subactid="<?php echo $mon_sub_activity->idSubActivity; ?>">C</label>
                                    <?php 
                                       if (!empty($obsMontessori)) {
                                          foreach ($obsMontessori as $key => $obsMon) {
                                             if ($obsMon->idSubActivity==$mon_sub_activity->idSubActivity) {
                                                   ?>
                                                   <script type="text/javascript">
                                                      var _assesment = "<?php echo $obsMon->assesment;?>";
                                                      var _id = "<?php echo $mon_sub_activity->idSubActivity;?>";
                                                      if(_assesment == "Not Assessed"){
                                                         document.getElementById(`${_id}montessoriNotAssessed`).checked = true;
                                                      }
                                                      else if(_assesment == "Introduced"){
                                                         document.getElementById(`${_id}montessoriIntroduced`).checked = true;
                                                      }
                                                      else if(_assesment == "Working"){
                                                         document.getElementById(`${_id}montessoriWorking`).checked = true;
                                                      }
                                                      else if(_assesment == "Completed"){
                                                         document.getElementById(`${_id}montessoriCompleted`).checked = true;
                                                      }
                                                   </script>
                                                <?php }
                                             }
                                          }
                                    ?>
                                    </div>
                                 </div>
                                 <div class="row" style="margin-bottom: 15px;">
                                    <?php if(!empty($mon_extras[$mon_sub_activity->idSubActivity])) {
                                       echo "<div class='col-sm-12'><strong><i>Extras</i></strong></div>";
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
                                       <input type="checkbox" class="extras" name="extras[<?php echo $mon_sub_activity->idSubActivity; ?>][]" value="<?php echo $mon_extra->idExtra; ?>" checked>&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $mon_extra->title; ?></label>
                                    </div>
                                    <?php
                                                      }
                                                   }
                                                }
                                             }
                                             if ($var == true) {
                                    ?>
                                    <div class="col-md-12">
                                       <input type="checkbox" class="extras" name="extras[<?php echo $mon_sub_activity->idSubActivity; ?>][]" value="<?php echo $mon_extra->idExtra; ?>">&nbsp;&nbsp;&nbsp;&nbsp;<label><?php echo $mon_extra->title; ?></label>
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
         <?php } ?>

         </div>
      <?php } ?>
      </div>
      <div class="tab-pane <?php if($type=='links' ) { echo 'active'; } ?>" id="tabs-3">
         <div class="linkobservation">
            <button type="button" class="btn btn-default btn-small btnBlue" data-toggle="modal" data-target="#modal-linkobs">
               <span class="material-icons-outlined">add</span> Link Observation
            </button>
            <button type="button" class="btn btn-default btn-small btnGreen" data-toggle="modal" data-target="#modal-linkref">
               <span class="material-icons-outlined">add</span> Link Reflection
            </button>
            <button type="button" class="btn btn-default btn-small btnBlue" data-toggle="modal" data-target="#modal-linkqip">
               <span class="material-icons-outlined">add</span> Link QIP
            </button>
            <button type="button" class="btn btn-default btn-small btnGreen" data-toggle="modal" data-target="#modal-linkprogplan">
               <span class="material-icons-outlined">add</span> Link Program Plan
            </button>
         </div>
         <!-- Link Observation Modal -->
         <form method="post" id="form-link">
            <input type="hidden" name="linkType" value="OBSERVATION">
            <!-- Link Observation modal -->
            <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="modal-linkobs" aria-labelledby="myLargeModalLabel" style='height: auto ! important;width: auto ! important;'>
               <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="myModalLabel">Link Observation</h4>
                  </div>
                  <div class="modal-body">
                     <?php if(isset($obsPublished)){ foreach($obsPublished as $link) {  ?>
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

                              <div class="obsListBoxAbt">                                 
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
                                    <span class="spanborder">&nbsp;<span class="material-icons">done_all</span>&nbsp;&nbsp;<?php echo $link->status; ?>&nbsp;</span>
                                 </div>
                                 <?php } ?>
                                 <a href="<?php echo base_url('observation/view?id='.$link->id); ?>"><span class="obserb"><?php echo strip_tags(html_entity_decode($link->title)); ?></span></a>
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
                     <?php } } ?>
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
         <!-- Link Observation Modal End-->

         <!-- Link Reflection Modal -->
         <form method="post" id="form-link-ref">
            <input type="hidden" name="linkType" value="REFLECTION">
            <!-- Link Reflection Modal -->
            <div class="modal fade" id="modal-linkref" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style='height: auto ! important;width: auto ! important;'>
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Link Reflection</h4>
                     </div>
                     <div class="modal-body">
                        <div class="row">
                           <div class="col-md-12">
                              <?php if(isset($refPublished)){ foreach($refPublished as $ref) {  ?>
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
                              <?php } } ?>               
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
         <!-- Link Reflection Modal End-->

         <!-- Link QIP Modal -->
         <form method="post" id="form-link-qip">
            <input type="hidden" name="linkType" value="QIP">
            <!-- Link qip Modal -->
            <div class="modal fade" id="modal-linkqip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style='height: auto ! important;width: auto ! important;'>
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Link QIP</h4>
                     </div>
                     <div class="modal-body">
                        <div class="row">
                           <?php 
                           if (empty($qipPublished)) {
                           ?>
                              <h3>QIP is not available!</h3>
                           <?php
                            } else{
                              foreach($qipPublished as $qipArr => $qipObj) {  
                           
                           ?>
                           <div class="col-md-12 modal-qip-box">
                              <div class="qip-title"><label for="<?= $qipObj->name; ?>"><?= $qipObj->name; ?></label></div>
                              <div class="qip-checkbox">
                                 <input type="checkbox" name="obsLinks[]" id="<?= $qipObj->name; ?>" value="<?= $qipObj->id; ?>">
                              </div>
                           </div>
                           <?php 
                                 }
                              }
                           ?>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default btn-small btnBlue pull-right" onclick="saveQip();">Save changes</button>
                           <button type="button" class="btn btn-default btn-small pull-right" data-dismiss="modal">Close</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Link qip Modal end -->
         </form>
         <!-- Link QIP Modal End -->

         <!-- Link Program Plan Modal -->
         <form method="post" id="form-link-pp">
            <input type="hidden" name="linkType" value="PROGRAMPLAN">
            <!-- Link Reflection Modal -->
            <div class="modal fade" id="modal-linkprogplan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style='height: auto ! important;width: auto ! important;'>
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Link Program Plan</h4>
                     </div>
                     <div class="modal-body">
                        <div class="row">
                           <?php  
                           if(isset($progPlanPublished)){
                              foreach($progPlanPublished as $ppArr => $ppObj) {  
                           ?>
                           <div class="col-md-12 modal-pp-box">
                              <div class="pp-title">
                                 <label for="proplan<?= $ppObj->id; ?>">
                                    <?= date('d-m-Y',strtotime($ppObj->startdate))."/".date('d-m-Y',strtotime($ppObj->enddate)); ?>
                                 </label>
                              </div>
                              <div class="pp-checkbox">
                                 <input type="checkbox" name="obsLinks[]" id="proplan<?= $ppObj->id; ?>" value="<?= $ppObj->id; ?>">
                              </div>
                           </div>
                           <?php
                              }
                           }
                           ?>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-default btn-small btnBlue pull-right" onclick="saveProplan();">Save changes</button>
                           <button type="button" class="btn btn-default btn-small pull-right" data-dismiss="modal">Close</button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Link Reflection Modal end -->
         </form>
         <!-- Link Program Plan Modal End -->

         <!-- Published observation link -->
         <div class="pub-obs-links" >
            <?php if(empty($observationLinks) && empty($reflectionLinks) && empty($qipLinks) && empty($programplanLinks)){ ?>
               <img style="height: 30px;width: 30px;margin: 30px auto;" src="<?php echo base_url('assets/images/icons/broken-link.png'); ?>">
               <div>This Observation has no links</div>
            <?php }else{ 
               foreach($observationLinks as $link) {  
            ?>
            <div class="listObservationView">
               <div class="subListObservationView">
                  <div class="block">
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
                        <div class="divchild NameChild">
                           <span style="display: inline-flex;">
                              <?php $i=1; foreach($link->childrens as $chi) { ?>
                                 <span>
                                    <img class="circleimage" src="<?php echo base_url('/api/assets/media/'.$chi->imageUrl); ?>" width="30" height="30">
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
                           <span class="spanborder">&nbsp;<span class="material-icons">done_all</span>&nbsp;&nbsp;<?php echo $link->status; ?>&nbsp;</span>
                        </div>
                     <?php } ?>
                     <div class="pull-right">
                        <a href="<?php echo base_url('observation/deleteLink?type=links&id='.$id.'&linkId='.$link->id); ?>"><span class="text-danger fa fa-times"></span></a>
                     </div>
                     <a href="<?php echo base_url('observation/view?id='.$link->id); ?>"><span class="obserb"><strong><?php echo strip_tags(html_entity_decode($link->title)); ?></strong></span></a>

                     <p style="float: none;"></p>
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
                     
                        <?php if(!empty($link->media)) {  ?>
                        <div class="imageobser">
                           <img src="<?php echo base_url('/api/assets/media/'.$link->media); ?>" style="height: auto;width: 100%">
                        </div>
                     <?php } ?>
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
            <?php } 
                  foreach ($qipLinks as $qipLink => $qipLiObj) {
            ?>
            <div class="col-md-12 modal-qip-box">
               <div class="qip-title">
                  <span>QIP</span>
                  <h4><?= $qipLiObj->name; ?></h4>
               </div>
            </div>
            <?php 
                  }
                  foreach ($programplanLinks as $ppLinks => $ppLiObj) {
            ?>
            <div class="col-md-12 modal-pp-box">
               <div class="pp-title">
                  <span>Program Plan</span>
                  <h4><?= $ppLiObj->name; ?></h4>
               </div>
            </div>
            <?php
                  }
               } 
            ?>
            <?php if(!empty($id)) { ?>
            <div class="formSubmit text-right" >
               <a href="<?php echo base_url('observation/changeObsStatus')."?obsid=".$id."&status=0"; ?>" class="btn btn-default btnRed">Make Draft</a>
               <a href="<?php echo base_url('observation/changeObsStatus')."?obsid=".$id."&status=1"; ?>" class="btn btn-default btnBlue">Publish Now</a>
            </div>
            <?php } ?>
         </div>
         <!-- Published observation link end -->
      </div>
      <?php } ?>      
   </div>

   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">   
      <div class="modal-dialog" role="document">
       <div class="modal-content">
         <form id="myModalForm">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Add Image Details</h4>
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
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-small btnRed pull-right" data-dismiss="modal">Close</button>
              <button type="button" id="saveImgAttr" class="btn btn-default btn-small btnBlue pull-right btn-primary myModalBtn" data-dismiss="modal">Save changes</button>
            </div>
            </div>
         </form>
       </div>
      </div>
   </div>

   <div class="modal bs-example-modal-lg" id="uploadMediaModal" tabindex="-1" role="dialog">
      <div class="modal-dialog w660" role="document">
         <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Select Media</h4>
            </div>
            <div class="modal-body">
               <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active line-nav-tab"><a href="#uploadNew" aria-controls="uploadNew" role="tab" data-toggle="tab">Upload New</a></li>
                  <li role="presentation" class="line-nav-tab"><a href="#uploadedImages" aria-controls="uploadedImages" role="tab" data-toggle="tab">Uploaded Images</a></li>
               </ul>

               <div class="tab-content">
                  <div role="tabpanel" class="tab-pane active" id="uploadNew">
                     <label class="file-upload-field" for="fileUpload">
                        <span class="material-icons-outlined">add</span> 
                        <span>Upload</span>
                     </label>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="uploadedImages">
                     <div class="weekListThumbBlock">
                        <?php 
                           if (isset($uploadedMedia) && !empty($uploadedMedia)) {
                              foreach ($uploadedMedia as $uploadedMedias => $uplMedia) {
                                 if ($uplMedia->type == "Image") {
                        ?>
                        <div class="imgBlock">
                           <input type="checkbox" id="<?php echo "check".$uplMedia->id; ?>" name="uploadedImgList[]" value="<?php echo $uplMedia->id; ?>" class="uploaded-media-list" data-type="image" data-url="<?php echo BASE_API_URL."assets/media/".$uplMedia->filename; ?>">
                           <label for="<?php echo "check".$uplMedia->id; ?>">
                              <img src="<?php echo BASE_API_URL."assets/media/".$uplMedia->filename; ?>">
                           </label>
                        </div>
                        <?php } elseif ($uplMedia->type == "Video") { ?>
                        <div class="imgBlock">
                           <input type="checkbox" id="<?php echo "check".$uplMedia->id; ?>" name="uploadedImgList[]" value="<?php echo $uplMedia->id; ?>" class="uploaded-media-list" data-type="video" data-url="<?php echo BASE_API_URL."assets/media/".$uplMedia->filename; ?>">
                           <label for="<?php echo "check".$uplMedia->id; ?>">
                              <video src="<?php echo BASE_API_URL."assets/media/".$uplMedia->filename; ?>">
                           </label>
                        </div>
                        <?php  
                                 } else {
                                    
                                 }
                              }
                           }else{
                        ?>
                        <p>No media found!</p>
                        <?php } ?>
                     </div>
                     <button type="button" id="addImgToForm" class="btn btn-default btn-small btnBlue pull-right" data-dismiss="modal">Use</button>
                  </div>
               </div>
            </div>
            <div class="modal-footer" style="padding:0px 20px 10px 0px;height:auto;">
               <!-- <button type="button" class="btn btn-primary btn-small btnBlue pull-right">Save changes</button> -->
               
            </div>
         </div>
      </div>
   </div>

   <!-- Preview Modal -->
   <div class="modal" id="modal-preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style='height: 800px ! important;'>
      <div class="modal-dialog modal-lg" role="document">                    
         <div class="modal-content">                    
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
               <h4 class="modal-title" id="myModalLabel">Observation Preview</h4>
            </div>   
            <div class="modal-body">
               <div class="modal-container">
                  <div class="row" id="obser-info">
                     <div class="col-md-6">
                        <h3 id="obsPreviewTitle"></h3>
                        <p>Author: <span id="obsPreviewAuthor"></span></p>
                        <div id="obsChildren"></div>
                        <div id="obsNotesSec">
                           <strong>Notes:</strong>
                           <div id="obsNotes"></div>
                        </div>
                        <div id="obsReflectionSec">
                           <strong>Reflection:</strong>
                           <div id="obsReflection"></div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                              <ul class="nav nav-tabs border-tab">
                                 <li class="active"><a href="#previewMontessori" data-toggle="tab">Montessori</a></li>
                                 <li><a href="#previewEYLF" data-toggle="tab">EYLF</a> </li>
                                 <li><a href="#previewMilestones" data-toggle="tab">Developmental Milestones</a></li>
                              </ul>
                              <div class="tab-content">
                                 <div class="tab-pane active" id="previewMontessori">
                                    <ul class="nav nav-pills bold-tab mon-prv-sub"></ul>
                                 </div>
                                 <div class="tab-pane" id="previewEYLF">
                                    <ul class="nav nav-pills bold-tab eylf-prvw-sub"></ul>
                                 </div>
                                 <div class="tab-pane" id="previewMilestones">
                                    <ul class="nav nav-pills bold-tab dev-mil-prv"></ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 sliderRight">
                        <div class="wrap-modal-slider">
                           <div class="your-class">
                           </div>
                        </div>
                        <div class="thumbMedia">                           
                        </div>  
                     </div>
                  </div>
               </div>
            </div>         
         </div>
      </div>            
   </div>
   <!-- Preview Modal End -->
</div>

<!-- Modal -->
<div class="modal" id="tagsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">View Tag Details</h4>
      </div>
      <div class="modal-body">
      
      </div>
    </div>
   </div>
</div>

<?php $this->load->view('footer'); ?>
<script>
   var users = <?php echo $getStaffChild; ?>,tags = <?php echo $getTagsList; ?>;

   CKEDITOR.replace('obs_notes', {
      plugins: 'mentions,basicstyles,undo,link,wysiwygarea,toolbar,format,list',
      contentsCss: [
         'http://cdn.ckeditor.com/4.16.2/full-all/contents.css',
         'https://ckeditor.com/docs/ckeditor4/4.16.2/examples/assets/mentions/contents.css'
      ],
      height: 150,
      toolbar: [{
          name: 'document',
          items: ['Undo', 'Redo']
      },
      {
          name: 'basicstyles',
          items: ['Bold', 'Italic', 'Strike', 'Format']
      },
      {
          name: 'links',
          items: ['Link', 'Unlink', 'NumberedList', 'BulletedList']
      }],
      extraAllowedContent: '*[*]{*}(*)',
      mentions: [{  
         feed: dataFeed,
            itemTemplate: '<li data-id="{id}">' +
               '<strong class="username">{name}</strong>' +
               '</li>',
            outputTemplate: '<a href="user_{id}">{name}</a>',
            minChars: 0
         },
         {
            feed: tagsFeed,
            marker: '#',
            itemTemplate: '<li data-id="{id}"><strong>{title}</strong></li>',
            outputTemplate: '<a href="#tags_{rid}" data-tagid="{rid}" data-type="{type}" data-toggle="modal" data-target="#tagsModal">#{title}</a>',
            minChars: 0
         }
      ]
   });

   CKEDITOR.replace('obs_reflection', {
      plugins: 'mentions,basicstyles,undo,link,wysiwygarea,toolbar,format,list',
      contentsCss: [
         'http://cdn.ckeditor.com/4.16.2/full-all/contents.css',
         'https://ckeditor.com/docs/ckeditor4/4.16.2/examples/assets/mentions/contents.css'
      ],
      height: 150,
      toolbar: [{
          name: 'document',
          items: ['Undo', 'Redo']
      },
      {
          name: 'basicstyles',
          items: ['Bold', 'Italic', 'Strike', 'Format']
      },
      {
          name: 'links',
          items: ['Link', 'Unlink', 'NumberedList', 'BulletedList']
      }],
      extraAllowedContent: '*[*]{*}(*)',
      mentions: [{  
         feed: dataFeed,
            itemTemplate: '<li data-id="{id}">' +
               '<strong class="username">{name}</strong>' +
               '</li>',
            outputTemplate: '<a href="user_{id}">{name}</a>',
            minChars: 0
         },
         {
            feed: tagsFeed,
            marker: '#',
            itemTemplate: '<li data-id="{id}"><strong>{title}</strong></li>',
            outputTemplate: '<a href="#tags_{rid}" data-tagid="{rid}" data-type="{type}" data-toggle="modal" data-target="#tagsModal">#{title}</a>',
            minChars: 0
         }
      ]
   });

   CKEDITOR.replace('obs_title', {
      plugins: 'mentions,basicstyles,undo,link,wysiwygarea,toolbar,format,list',
      contentsCss: [
         'http://cdn.ckeditor.com/4.16.2/full-all/contents.css',
         'https://ckeditor.com/docs/ckeditor4/4.16.2/examples/assets/mentions/contents.css'
      ],
      height: 150,
      toolbar: [{
          name: 'document',
          items: ['Undo', 'Redo']
      },
      {
          name: 'basicstyles',
          items: ['Bold', 'Italic', 'Strike', 'Format']
      },
      {
          name: 'links',
          items: ['Link', 'Unlink', 'NumberedList', 'BulletedList']
      }],
      extraAllowedContent: '*[*]{*}(*)',
      mentions: [{  
         feed: dataFeed,
            itemTemplate: '<li data-id="{id}">' +
               '<strong class="username">{name}</strong>' +
               '</li>',
            outputTemplate: '<a href="user_{id}">{name}</a>',
            minChars: 0
         },
         {
            feed: tagsFeed,
            marker: '#',
            itemTemplate: '<li data-id="{id}"><strong>{title}</strong></li>',
            outputTemplate: '<a href="#tags_{rid}" data-tagid="{rid}" data-type="{type}" data-toggle="modal" data-target="#tagsModal">#{title}</a>',
            minChars: 0
         }
      ]
   });

   function dataFeed(opts, callback) {
      var matchProperty = 'name',
         data = users.filter(function(item) {
            return item[matchProperty].indexOf(opts.query.toLowerCase()) == 0;
         });

      data = data.sort(function(a, b) {
         return a[matchProperty].localeCompare(b[matchProperty], undefined, {
            sensitivity: 'accent'
         });
      });
      callback(data);
   }

   function tagsFeed(opts, callback) {
      var matchProperty = 'title',
      data = tags.filter(function(item) {
         return item[matchProperty].indexOf(opts.query.toLowerCase()) == 0;
      });

      data = data.sort(function(a, b) {
         return a[matchProperty].localeCompare(b[matchProperty], undefined, {
            sensitivity: 'accent'
         });
      });
      callback(data);
   }
</script>
<script src="<?php echo base_url('assets/js/observation.js'); ?>"></script>
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

               if (isset($_GET['centerid']) && $_GET['centerid']!="") {
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
                     msg += '</span><span  class="spanborder"> <span class="material-icons">done_all</span>  ' + val.status + ' </span></div>';

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
            $('.no-childerns').html(i + ' Children Selected');
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

   function saveQip() {
      var url = "<?php echo base_url('observation/add?type=links&status=true&id='.$id); ?>";
      var test = url.replace(/&/g, '&');
      document.getElementById("form-link-qip").action = test;
      document.getElementById("form-link-qip").submit();
   }

   function saveProplan() {
      var url = "<?php echo base_url('observation/add?type=links&status=true&id='.$id); ?>";
      var test = url.replace(/&/g, '&');
      document.getElementById("form-link-pp").action = test;
      document.getElementById("form-link-pp").submit();
   }

   function editObservation() {
      $(".img-preview").each(function(){
         $("#form-observation").append('<input type="hidden" name="origin[]" value="'+$(this).data("origin")+'">');
         $("#form-observation").append('<input type="hidden" name="priority[]" value="'+$(this).data("key")+'">');
      });

      $(".uploaded-imgs").each(function(){
         $("#form-observation").append('<input type="hidden" name="mediaid[]" value="'+$(this).data("mediaid")+'">');
      });

      $(".nonsticky-preview").each(function(){
         $("#form-observation").append('<input type="hidden" name="fileno[]" value="'+$(this).data("fileno")+'">');
      });

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

      $(".img-preview").each(function(){
         $("#form-observation").append('<input type="hidden" name="origin[]" value="'+$(this).data("origin")+'">');
         $("#form-observation").append('<input type="hidden" name="priority[]" value="'+$(this).data("key")+'">');
      });

      $(".uploaded-imgs").each(function(){
         $("#form-observation").append('<input type="hidden" name="mediaid[]" value="'+$(this).data("mediaid")+'">');
      });
      
      $(".nonsticky-preview").each(function(){
         $("#form-observation").append('<input type="hidden" name="fileno[]" value="'+$(this).data("fileno")+'">');
      });

      var url = "<?php echo base_url('observation/add?type=assessments'); ?>";
      var test = url.replace(/&/g, '&');
      document.getElementById("form-observation").action = test;
      document.getElementById("form-observation").submit();
   }

   function draftObservation() {

      $(".img-preview").each(function(){
         $("#form-observation").append('<input type="hidden" name="origin[]" value="'+$(this).data("origin")+'">');
         $("#form-observation").append('<input type="hidden" name="priority[]" value="'+$(this).data("key")+'">');
      });

      $(".uploaded-imgs").each(function(){
         $("#form-observation").append('<input type="hidden" name="mediaid[]" value="'+$(this).data("mediaid")+'">');
      });
      
      $(".nonsticky-preview").each(function(){
         $("#form-observation").append('<input type="hidden" name="fileno[]" value="'+$(this).data("fileno")+'">');
      });

      $("#form-observation").append('<input type="hidden" name="status" value="Draft">')

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
               msg += '<span class="tag label label-info"><input type="hidden" name="childrens[]" data-name="'+ $(this).data("name") +'" value="' + $(this).val() + '">' + $(this).attr('id') + '<span class="rem" data-role="remove"></span></span>';
            }
            // console.log($(this));
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
         } else if(edit==1){
            $('#ed-mda-id').val(button.data('mediaid'));
            $(".myModalBtn").attr("id","addImgTags");  
         } else {
            $(".myModalBtn").attr("id","saveImgAttr");
         }
      }); 

      $(document).on('click','#saveImgAttr',function(){
         var ctext = $('#child-tags').select2('data');
         // var childIds = $('#child-tags').val();
         var emediaId = $('#ed-mda-id').val();
         // var educatorIds = $('#educator-tags').val();
         var educatorIds = $('#educator-tags').select2('data');
         var imgCaption = $('#imgCaption').val();
         var imgCount = $('.img-count').val();
         $('input[name="obsImage_'+imgCount+'[]"]').remove();

         for(d=0;d<ctext.length;d++){
            $("#form-observation").append('<input type="hidden" name="obsImage_'+imgCount+'[]" value="'+ctext[d].id+'" data-name="'+ctext[d].text+'">');
         }

         $('input[name="obsEducator_'+imgCount+'[]"]').remove();

         for(j=0;j<educatorIds.length;j++){
            
            $("#form-observation").append('<input type="hidden" name="obsEducator_'+imgCount+'[]" value="'+educatorIds[j].id+' "data-name="'+educatorIds[j].text+'">');
         }

         $('input[name="obsMediaId_'+imgCount+'"]').remove();
         if(emediaId!=""){
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
               // var res = jQuery.parseJSON(msg);
               console.log(msg);
            }
         });

         $("#child-tags").select2('destroy').val("").select2();
         $('#educator-tags').select2('destroy').val("").select2();
         $('#ed-mda-id').val("");
         $("#myModalForm").get(0).reset();
      });

      $(document).on('click','#addImgTags',function(){
         var childIds = $("#child-tags").select2("data");
         var educatorIds = $('#educator-tags').select2("data");
         var imgCaption = $('#imgCaption').val();
         var mediaId = $('#ed-mda-id').val();
         $("#child-tags").select2('destroy').val("").select2();
         $('#educator-tags').select2('destroy').val("").select2();
         $("#myModalForm").get(0).reset();
         $(childIds).each(function(index,element){
            $("#form-observation").append('<input type="hidden" name="upl-media-tags-child'+mediaId+'[]" value="'+element.id+'" data-name="'+element.name+'">');
         });

         $(educatorIds).each(function(index,element){
            $("#form-observation").append('<input type="hidden" name="upl-media-tags-educator'+mediaId+'[]" value="'+element.id+'" data-name="'+element.name+'">');
         });

         $("#form-observation").append('<input type="hidden" name="upl-media-tags-caption'+mediaId+'" value="'+imgCaption+'">');
      });

      $("#fileUpload").on('change', function() {
         let imgPrevs = $(".img-preview").length;
         if(imgPrevs==0){
            imgPrevs = 1;
         }else{
            imgPrevs = imgPrevs + 1;
         }
         $(".nonsticky-preview").remove();
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
                    mainHolder.append(`<div class="img-preview nonsticky-preview" data-origin="NEW" data-fileno="${i}" data-key="${i}">
                                          <video class="thumb-image" controls>
                                             <source src="${url}" type="video/mp4">
                                          </video>
                                          <span class="img-remove">
                                             <span class="material-icons-outlined">close</span>
                                          </span>
                                          <a class="img-edit" href="#!" data-mediaorigin="NEW" data-imgcount="${i}" data-image="${url}" data-toggle="modal" data-target="#myModal" data-priority="${imgPrevs}">
                                             <span class="material-icons-outlined">edit</span>
                                          </a>
                                       </div>`);
                 } else {
                    mainHolder.append(`<div class="img-preview nonsticky-preview" data-origin="NEW" data-fileno="${i}" data-key="${i}">
                                          <img class="thumb-image" src="${url}">
                                          <span class="img-remove">
                                             <span class="material-icons-outlined">close</span>
                                          </span>
                                          <a class="img-edit" href="#!" data-mediaorigin="NEW" data-imgcount="${i}" data-image="${url}" data-toggle="modal" data-target="#myModal" data-priority="${imgPrevs}">
                                             <span class="material-icons-outlined">edit</span>
                                          </a>
                                       </div>`);
                 }
               }
            } else {
               allGood = false;
               alert("This browser does not support File API.");
               break;
            }
            imgPrevs = imgPrevs + 1;
         }

         if (!allGood) {
            alert("Pls select only images and videos");
         }

         // $("#fileUpload").val("");
         $("#uploadMediaModal").modal("hide");
      });

      $(document).on('click','.img-remove',function(){
         if (confirm("Are you sure?")) {
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
         }      
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
         $("#ed-mda-id").val(mediaid);
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
                  childTags.push(this.childId);
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

      $(document).on("click",".img-uploaded-edit",function(){
         var mediaid = $(this).data("mediaid");
         var type = $(this).data("type");
         if (type=="image") {
             var imgUrl = $(this).siblings(".img-thumb").attr("src");
             $("#imageContent").attr("src",imgUrl);
             $("#videoContent").hide();
         } else {
             var vidUrl = $(this).siblings(".vid-thumb").find('Source:first').attr('src');
             $("#videoContent").find('Source').attr("src", vidUrl);
             $("#imageContent").hide();
         }
         $("#mediaRecId").val(mediaid);
         $.ajax({
             traditional:true,
             type: "POST",
             url: "<?php echo base_url('Media/getTagsArr'); ?>",
             data: {"mediaid":mediaid},
             success: function(msg){
                 res = jQuery.parseJSON(msg);
                 var childTags = [];
                 var staffTags = [];
                 $(res.ChildTags).each(function(){
                    childTags.push(this.userid);
                 });
                 $(res.StaffTags).each(function(){
                    staffTags.push(this.userid);
                 });
                 $("#child-tags").val(childTags);
                 $('#child-tags').trigger('change');
                 $("#educator-tags").val(staffTags);
                 $('#educator-tags').trigger('change');
                 $('#imgCaption').val(res.Media.caption);
                 $('.modal-footer > #saveImgAttr').remove();
                 $('#saveImgProp').remove();
                 $('.modal-footer').append('<button type="button" id="addImgTags" class="btn btn-primary myModalBtn btn-small btnBlue pull-right" data-dismiss="modal">Save Changes</button>');
                 $("input[name='upl-media-tags-child"+mediaid+"[]']").remove();
                 $("input[name='upl-media-tags-educator"+mediaid+"[]']").remove();
                 $("input[name='upl-media-tags-caption"+mediaid+"']").remove();
                 $("#ed-mda-id").val(mediaid);
             }
         });
      });

      <?php if (isset($_GET['id'])) { ?>
         $( "#img-holder" ).sortable({ 
            items: "> .img-preview",
            beforeStop: function( event, ui ) {
               let countImages = $("#img-holder .img-preview").length - 1;
               let arr = [];
               $("#img-holder .img-preview a").each(function(){
                  let mediaId = $(this).data("mediaid");
                  if(mediaId == undefined){
                     arr.push(0);
                  } else {
                     arr.push(mediaId);
                  }              
               });
               $.ajax({
                  traditional: true,
                  url: "<?php echo base_url('Observation/updateImagePriority')?>",
                  type: "POST",
                  data: {priority:JSON.stringify(arr)},
                  success: function(msg){
                     // var res = jQuery.parseJSON(msg);
                     console.log(msg);
                  }
               });
            } 
         });
      <?php } else { ?>
         $( "#img-holder" ).sortable({ 
            items: "> .img-preview" 
         });
      <?php } ?>

      $("#img-holder").disableSelection();

      $(document).on("click","#addImgToForm",function(){
         let imgPrevs = $(".img-preview").length;
         if(imgPrevs==0){
            imgPrevs = 1;
         }
         $(".uploaded-media-list:checked").each(function(){
            let ftype = $(this).data("type");
            let fmedia = $(this).data("url");
            let fmediaid = $(this).val();
            getTagsForUploadedMedia(fmediaid);
            if (ftype=="image") {
               $("#img-holder").append('<div class="img-preview sticky-preview uploaded-imgs" data-origin="UPLOADED" data-mediaid="'+fmediaid+'" data-key="'+fmediaid+'"><img class="thumb-image" src="'+fmedia+'"><span id="'+fmediaid+'" class="img-remove deleteMedia"><span class="material-icons-outlined">close</span></span><a class="img-edit img-uploaded-edit" href="#!" data-mediaid="'+fmediaid+'" data-image="'+fmedia+'" data-toggle="modal" data-target="#myModal" data-mediaorigin="UPLOADED" data-edit="2" data-priority="'+imgPrevs+'"><span class="material-icons-outlined">edit</span></a></div>');
            } else if (ftype=="video"){
               $("#img-holder").append('<div class="img-preview nonsticky-preview uploaded-imgs" data-origin="UPLOADED" data-mediaid="'+fmediaid+'" data-key="'+fmediaid+'"> <video class="thumb-image" controls> <source src="'+fmedia+'" type="video/mp4"> </video> <span class="img-remove"><span class="material-icons-outlined">close</span></span> <a class="img-edit img-uploaded-edit" href="#!" data-image="'+fmedia+'" data-toggle="modal" data-target="#myModal" data-mediaorigin="UPLOADED" data-edit="2" data-priority="'+imgPrevs+'"><span class="material-icons-outlined">edit</span></a> </div>');
            }
            imgPrevs = imgPrevs + 1;
         });
      });

      function getTagsForUploadedMedia(mediaId) {
         $.ajax({
            traditional:true,
            type: "POST",
            url: "<?php echo base_url('Media/getTagsArr'); ?>",
            data: {"mediaid":mediaId},
            success: function(msg){
               // console.log(msg);
               res = jQuery.parseJSON(msg);
               var childTags = [];
               var staffTags = [];
               $(res.ChildTags).each(function(index,element){
                  $("#form-observation").append('<input type="hidden" name="upl-media-tags-child'+mediaId+'[]" value="'+element.userid+'">');
                  
               });
               $(res.StaffTags).each(function(index,element){
                  $("#form-observation").append('<input type="hidden" name="upl-media-tags-educator'+mediaId+'[]" value="'+element.userid+'">');
               });

               $("#form-observation").append('<input type="hidden" name="upl-media-tags-caption'+mediaId+'" value="'+res.Media.caption+'">');
            }
         });
      }
   });

   $(document).ready(function(){
      check_val='<?php echo $get_child;?>';
      if(check_val!=''){
         console.log(check_val);
         $("input[name='"+check_val+"']").prop('checked', true);
      }
   });

   $(document).ready(function(){
         $('#modal-preview,#modal-linkobs,#modal-linkref,#modal-linkqip,#modal-linkprogplan').draggable({
                  handle: ".modal-header"
         });
});
</script>