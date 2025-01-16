<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Surveys | Mykronicle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/component-custom-switch.min.css" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/custom-styles.css?v=1.0.0" />
    <style>
        .list-thumbnail.xsmall{
            width: 40px;
        }
        .list-table td {
            vertical-align: middle!important;
        }
        .select-all-box{
            padding-left: 12px;
        }
        .select-all-box > label{
            margin-left: 22px;
            font-size: 15px;
        }
        span.badge.badge-danger.remove-qstn-media {
            position: absolute;
            top: 12px;
            right: 10px;
        }
        .media-box {
            position: relative;
        }
    </style>
</head>

<body id="app-container" class="menu-default show-spinner">
    <?php $this->load->view('sidebar'); ?>
    <?php 
        //PHP Block
        $role = $this->session->userdata("UserType");
        if ($role == "Superadmin") {
            $edit = 1;
            $add = 1;
        } else if ($role=="Staff") {
            $edit = isset($permissions->edit)?$permissions->edit:0;
            $add = isset($permissions->add)?$permissions->add:0;
        }else{
            $edit = 0;
            $add = 0;
        }
    ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Manage Survey</h1>
                    <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                        <ol class="breadcrumb pt-0">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('surveys/list'); ?>">Survey List</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Survey</li>
                        </ol>
                    </nav>
                    <div class="separator mb-5"></div>
                </div>
            </div> 
            <?php
                if(!empty($this->uri->segment(3))){
                    if($edit==0){
            ?>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="alert alert-info alert-dismissible fade show rounded mb-3" role="alert">
                        <strong>Notice!</strong> You are allowed to view survey form only and can't create a edit this one.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            </div>
            <?php
                    }
                }else{
                    if($add==0){
            ?>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="alert alert-info alert-dismissible fade show rounded mb-3" role="alert">
                        <strong>Notice!</strong> You are allowed to view survey form only and can't create a new one.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            </div>
            <?php
                    }
                }
            ?>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-5">
                                <h5 class="card-title">Enter Details</h5>
                            </div>
                            <form id="survey-form" action="<?= base_url('surveys/saveSurvey'); ?>" method="post" autocomplete="off" enctype="multipart/form-data">
                                <input type="hidden" name="centerid" value="<?= $centerid; ?>">
                                <?php if (isset($surveyid)) { ?>
                                <input type="hidden" name="surveyid" value="<?= $surveyid; ?>">     
                                <?php } ?>
                                <div id="survey-form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="txtTitle">Title</label>
                                                <input type="text" id="txtTitle" name="title" class="form-control" value="<?= isset($Survey)?$Survey->title:''; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="txtDesc">Description</label>
                                                <textarea id="txtDesc" name="description" class="form-control"><?= isset($Survey)?$Survey->description:''; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Select Childrens</label>
                                                <br>
                                                <button type="button" class="btn btn-secondary mb-1" data-toggle="modal" data-backdrop="static" data-target="#selectChildrenModal"> + Add Children </button>
                                            </div>
                                            <div class="children-tags">
                                                <?php 
                                                    if (isset($Survey) && !empty($Survey->childs)) {
                                                        foreach ($Survey->childs as $key => $obj) {
                                                ?>
                                                <a href="#!" class="rem" data-role="remove" data-child="<?= $obj->childid;?>">
                                                    <input type="hidden" name="childs[]" value="<?= $obj->childid;?>">
                                                    <span class="badge badge-pill badge-outline-primary mb-1"><?= $obj->name; ?> X </span>
                                                </a>
                                                <?php } } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator my-4"></div>
                                    <?php 
                                    if (isset($Survey)) {
                                        $intCount = 1;
                                        foreach($Survey->questions as $questions=>$qstnObj){
                                    ?>
                                    <div class="row qstns" id="<?= 'qstns-sec-'.$intCount; ?>">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Question</label>
                                                <input type="text" name="<?= 'qstn'.$intCount; ?>" class="form-control-line  form-control" placeholder="Enter Question" value="<?= $qstnObj->questionText; ?>" required>
                                            </div>
                                            <?php 
                                                $optCount = 1;
                                            ?>
                                            <div class="qstn-content">
                                                <?php if ($qstnObj->questionType == "RADIO") { 
                                                    $radio="selected";
                                                    $checkbox="";
                                                    $dropdown="";
                                                    $scale="";
                                                    $text="";
                                                 ?>
                                                <div class="mulopt" style="display: block;">
                                                    <div id="multiple-options">
                                                        <?php 
                                                            foreach ($qstnObj->options as $optionsKey => $optionsObj) {
                                                        ?>
                                                        <div class="options-set">
                                                            <input type="radio" disabled><input type="text" placeholder="Edit Option"  name="<?= 'ropt'.$intCount; ?>[]" class="mul-opt-label input-radio-text" value="<?= $optionsObj->optionText; ?>"><span class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addRadioOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="chkopt" style="display: none;">
                                                    <div id="checkbox-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'copt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-check-text" value=""><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel">
                                                        <input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;
                                                        <label>
                                                            <a href="#!" id="addChkOpt">Add Options</a>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="drpopt" style="display: none;">
                                                    <div id="dropdown-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'dopt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-drop-text" value=""><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addDrpOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="linopt" style="display: none;">
                                                    <div id="linear-options">
                                                        <input type="number" class="form-control-num lilow" name="<?= 'lilower'.$intCount; ?>" value="">
                                                        <label>&nbsp;To&nbsp;&nbsp;&nbsp;</label>
                                                        <input type="number" class="form-control-num lihigh" name="<?= 'lihigher'.$intCount; ?>" value=""> 
                                                    </div>
                                                </div>
                                                <div class="txtopt" style="display: none;">
                                                    <div id="text-options">
                                                        <div class="options-set">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="A Text box will be provided to the user" readonly name="<?= 'txtBox'.$intCount; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="erropt" style="display: none;">
                                                    <div id="error-options0">
                                                        Question type mismatch! 
                                                    </div>
                                                </div> 
                                                <?php } ?>
                                                <?php if ($qstnObj->questionType == "CHECKBOX") { 
                                                    $radio="";
                                                    $checkbox="selected";
                                                    $dropdown="";
                                                    $scale="";
                                                    $text="";
                                                ?>
                                                <div class="mulopt" style="display: none;">
                                                    <div id="multiple-options">
                                                        <?php 
                                                            foreach ($qstnObj->options as $optionsKey => $optionsObj) {
                                                        ?>
                                                        <div class="options-set">
                                                            <input type="radio" disabled><input type="text" placeholder="Edit Option"  name="<?= 'ropt'.$intCount; ?>[]" class="mul-opt-label input-radio-text" value=""><span class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addRadioOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="chkopt" style="display: block;">
                                                    <div id="checkbox-options">
                                                        <?php foreach ($qstnObj->options as $optionsKey => $optionsObj) { ?>
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'copt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-check-text" value="<?= $optionsObj->optionText; ?>"><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addChkOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="drpopt" style="display: none;">
                                                    <div id="dropdown-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'dopt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-drop-text" value=""><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addDrpOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="linopt" style="display: none;">
                                                    <div id="linear-options">
                                                        <input type="number" class="form-control-num lilow" name="<?= 'lilower'.$intCount; ?>" value="">
                                                        <label>&nbsp;To&nbsp;&nbsp;&nbsp;</label>
                                                        <input type="number" class="form-control-num lihigh" name="<?= 'lihigher'.$intCount; ?>" value=""> 
                                                    </div>
                                                </div>
                                                <div class="txtopt" style="display: none;">
                                                    <div id="text-options">
                                                        <div class="options-set">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="A Text box will be provided to the user" readonly name="<?= 'txtBox'.$intCount; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="erropt" style="display: none;">
                                                    <div id="error-options0">
                                                        Question type mismatch! 
                                                    </div>
                                                </div> 
                                                <?php } ?>
                                                <?php 
                                                    if ($qstnObj->questionType == "DROPDOWN") { 
                                                        $radio="";
                                                        $checkbox="";
                                                        $dropdown="selected";
                                                        $scale="";
                                                        $text="";
                                                ?>
                                                <div class="mulopt" style="display: none;">
                                                    <div id="multiple-options">
                                                        <?php 
                                                            foreach ($qstnObj->options as $optionsKey => $optionsObj) {
                                                        ?>
                                                        <div class="options-set">
                                                            <input type="radio" disabled><input type="text" placeholder="Edit Option"  name="<?= 'ropt'.$intCount; ?>[]" class="mul-opt-label input-radio-text" value=""><span class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addRadioOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="chkopt" style="display: none;">
                                                    <div id="checkbox-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'copt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-check-text" value=""><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel">
                                                        <input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;
                                                        <label>
                                                            <a href="#!" id="addChkOpt">Add Options</a>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="drpopt" style="display: block;">
                                                    <div id="dropdown-options">
                                                        <?php foreach ($qstnObj->options as $optionsKey => $optionsObj) { ?>
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'dopt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-drop-text" value="<?= $optionsObj->optionText; ?>"><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addDrpOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="linopt" style="display: none;">
                                                    <div id="linear-options">
                                                        <input type="number" class="form-control-num lilow" name="<?= 'lilower'.$intCount; ?>" value="">
                                                        <label>&nbsp;To&nbsp;&nbsp;&nbsp;</label>
                                                        <input type="number" class="form-control-num lihigh" name="<?= 'lihigher'.$intCount; ?>" value=""> 
                                                    </div>
                                                </div>
                                                <div class="txtopt" style="display: none;">
                                                    <div id="text-options">
                                                        <div class="options-set">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="A Text box will be provided to the user" readonly name="<?= 'txtBox'.$intCount; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="erropt" style="display: none;">
                                                    <div id="error-options0">
                                                        Question type mismatch! 
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php 
                                                    if ($qstnObj->questionType == "SCALE") { 
                                                        $radio="";
                                                        $checkbox="";
                                                        $dropdown="";
                                                        $scale="selected";
                                                        $text="";
                                                ?>
                                                <div class="mulopt" style="display: none;">
                                                    <div id="multiple-options">
                                                        <?php 
                                                            foreach ($qstnObj->options as $optionsKey => $optionsObj) {
                                                        ?>
                                                        <div class="options-set">
                                                            <input type="radio" disabled><input type="text" placeholder="Edit Option"  name="<?= 'ropt'.$intCount; ?>[]" class="mul-opt-label input-radio-text" value=""><span class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addRadioOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="chkopt" style="display: none;">
                                                    <div id="checkbox-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'copt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-check-text" value=""><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel">
                                                        <input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;
                                                        <label>
                                                            <a href="#!" id="addChkOpt">Add Options</a>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="drpopt" style="display: none;">
                                                    <div id="dropdown-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'dopt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-drop-text" value=""><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addDrpOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="linopt" style="display: block;">
                                                    <div id="linear-options">
                                                        
                                                        <input type="number" class="form-control-num lilow" name="<?= 'lilower'.$intCount; ?>" value="<?= $qstnObj->options[0]->optionText; ?>">
                                                        <label>&nbsp;To&nbsp;&nbsp;&nbsp;</label>
                                                        <input type="number" class="form-control-num lihigh" name="<?= 'lihigher'.$intCount; ?>" value="<?= $qstnObj->options[1]->optionText; ?>"> 
                                                    </div>
                                                </div>
                                                <div class="txtopt" style="display: none;">
                                                    <div id="text-options">
                                                        <div class="options-set">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="A Text box will be provided to the user" readonly name="<?= 'txtBox'.$intCount; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="erropt" style="display: none;">
                                                    <div id="error-options0">
                                                        Question type mismatch! 
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php 
                                                    if ($qstnObj->questionType == "TEXT") { 
                                                        $radio="";
                                                        $checkbox="";
                                                        $dropdown="";
                                                        $scale="";
                                                        $text="selected";
                                                ?>
                                                <div class="mulopt" style="display: none;">
                                                    <div id="multiple-options">
                                                        <?php 
                                                            foreach ($qstnObj->options as $optionsKey => $optionsObj) {
                                                        ?>
                                                        <div class="options-set">
                                                            <input type="radio" disabled><input type="text" placeholder="Edit Option"  name="<?= 'ropt'.$intCount; ?>[]" class="mul-opt-label input-radio-text" value=""><span class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addRadioOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="chkopt" style="display: none;">
                                                    <div id="checkbox-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'copt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-check-text" value=""><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel">
                                                        <input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;
                                                        <label>
                                                            <a href="#!" id="addChkOpt">Add Options</a>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="drpopt" style="display: none;">
                                                    <div id="dropdown-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'dopt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-drop-text" value=""><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addDrpOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="linopt" style="display: none;">
                                                    <div id="linear-options">
                                                        <input type="number" class="form-control-num lilow" name="<?= 'lilower'.$intCount; ?>" value="">
                                                        <label>&nbsp;To&nbsp;&nbsp;&nbsp;</label>
                                                        <input type="number" class="form-control-num lihigh" name="<?= 'lihigher'.$intCount; ?>" value=""> 
                                                    </div>
                                                </div>
                                                <div class="txtopt" style="display: block;">
                                                    <div id="text-options">
                                                        <div class="options-set">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="A Text box will be provided to the user" readonly name="<?= 'txtBox'.$intCount; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="erropt" style="display: none;">
                                                    <div id="error-options0">
                                                        Question type mismatch! 
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php 
                                                    $haystack = ['RADIO','CHECKBOX','DROPDOWN','SCALE','TEXT'];
                                                    if (!in_array($qstnObj->questionType, $haystack)) { 
                                                ?>
                                                <div class="mulopt" style="display: none;">
                                                    <div id="multiple-options">
                                                        <?php 
                                                            foreach ($qstnObj->options as $optionsKey => $optionsObj) {
                                                        ?>
                                                        <div class="options-set">
                                                            <input type="radio" disabled><input type="text" placeholder="Edit Option"  name="<?= 'ropt'.$intCount; ?>[]" class="mul-opt-label input-radio-text" value=""><span class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addRadioOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="chkopt" style="display: none;">
                                                    <div id="checkbox-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'copt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-check-text" value=""><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel">
                                                        <input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;
                                                        <label>
                                                            <a href="#!" id="addChkOpt">Add Options</a>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="drpopt" style="display: none;">
                                                    <div id="dropdown-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="<?= 'dopt'.$intCount; ?>[]" placeholder="Edit Option" class="mul-opt-label input-drop-text" value=""><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addDrpOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="linopt" style="display: none;">
                                                    <div id="linear-options">
                                                        <input type="number" class="form-control-num lilow" name="<?= 'lilower'.$intCount; ?>" value="">
                                                        <label>&nbsp;To&nbsp;&nbsp;&nbsp;</label>
                                                        <input type="number" class="form-control-num lihigh" name="<?= 'lihigher'.$intCount; ?>" value=""> 
                                                    </div>
                                                </div>
                                                <div class="txtopt" style="display: none;">
                                                    <div id="text-options">
                                                        <div class="options-set">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="A Text box will be provided to the user" readonly name="<?= 'txtBox'.$intCount; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="erropt" style="display: block;">
                                                    <div id="error-options0">
                                                        Question type mismatch! 
                                                    </div>
                                                </div>        
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label>Question Media</label>
                                                <input type="file" name="<?= 'fileQstn'.$intCount; ?>" id="<?= 'fileQstn'.$intCount; ?>" class="fileQstn form-control-hidden">
                                                <?php 
                                                    if (empty($qstnObj->medias)) {
                                                ?>
                                                <label class="question-media fileQstnlbl" for="<?= 'fileQstn'.$intCount; ?>">
                                                    Upload Media
                                                </label>
                                                <?php
                                                    }else{
                                                        if ($qstnObj->medias->mediaType == "Image") {
                                                ?>
                                                <div class="media-box">
                                                    <input type="hidden" name='<?= 'uploaded_file_'.$intCount; ?>' value="<?= $qstnObj->medias->id; ?>">
                                                    <img src="<?= BASE_API_URL.'assets/media/'.$qstnObj->medias->mediaUrl; ?>" height="auto" width="100%" alt="">
                                                    <span class="badge badge-danger remove-qstn-media">X Remove</span>
                                                </div>
                                                
                                                <?php
                                                        } else {
                                                ?>
                                                <div class="media-box">
                                                    <input type="hidden" name='<?= 'uploaded_file_'.$intCount; ?>' value="<?= $qstnObj->medias->id; ?>">
                                                    <video src="<?= BASE_API_URL.'assets/media/'.$qstnObj->medias->mediaUrl; ?>" controls height="auto" width="100%"></video>
                                                    <span class="badge badge-danger remove-qstn-media">X Remove</span>
                                                </div>
                                                <?php
                                                        }
                                                        
                                                ?>

                                                <label style="display:none;" class="question-media fileQstnlbl" for="<?= 'fileQstn'.$intCount; ?>">
                                                    Upload Media
                                                </label>
                                                <?php
                                                    }
                                                ?>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Question Type</label>
                                                        <select class="form-control form-control-select select-qstn" name="<?= 'qtype'.$intCount; ?>">
                                                            <option value="1" <?= $radio;?>>Multiple choice</option>
                                                            <option value="2" <?= $checkbox;?>>Check Box</option>
                                                            <option value="3" <?= $dropdown;?>>Drop Down</option>
                                                            <option value="4" <?= $scale;?>>Linear Scale</option>
                                                            <option value="5" <?= $text;?>>Text Field</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <label>Mandatory</label>
                                                            <div class="custom-switch custom-switch-secondary-inverse mb-2">
                                                                <input class="custom-switch-input mandatory-field" id="<?= 'switch'.$intCount; ?>" type="checkbox" name="<?= 'mandatory'.$intCount; ?>" <?= ($qstnObj->isMandatory==1)?'checked':''; ?>>
                                                                <label class="custom-switch-btn" for="<?= 'switch'.$intCount; ?>"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Options</label>
                                                        <div class="btn-group">
                                                            <button class="btn btn-primary copy_qstn" type="button">
                                                                <div class="glyph-icon iconsminds-duplicate-layer"></div>
                                                            </button>
                                                            <button class="btn btn-danger delete_qstn_sec" type="button">
                                                                <div class="glyph-icon simple-icon-trash"></div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                            $intCount++;
                                        }
                                    }else{
                                    ?>
                                    <div class="row qstns" id="qstns-sec-1">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Question</label>
                                                <input type="text" name="qstn1" class="form-control-line  form-control" placeholder="Enter Question" required>
                                            </div>
                                            <div class="qstn-content">
                                                <div class="mulopt">
                                                    <div id="multiple-options">
                                                        <div class="options-set">
                                                            <input type="radio" disabled><input type="text" placeholder="Edit Option"  name="ropt1[]" class="mul-opt-label input-radio-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel"><input type="radio" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addRadioOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="chkopt" style="display: none;">
                                                    <div id="checkbox-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="copt1[]" placeholder="Edit Option" class="mul-opt-label input-check-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addChkOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="drpopt" style="display: none;">
                                                    <div id="dropdown-options">
                                                        <div class="options-set">
                                                            <input type="checkbox"><input type="text" name="dopt1[]" placeholder="Edit Option" class="mul-opt-label input-drop-text"><span href="#" class="badge badge-danger rmbtn">Remove</span>
                                                        </div>
                                                    </div>
                                                    <div class="lastLabel"><input type="checkbox" disabled>&nbsp;&nbsp;&nbsp;<label><a href="#!" id="addDrpOpt">Add Options</a></label></div>
                                                </div>
                                                <div class="linopt" style="display: none;">
                                                    <div id="linear-options">
                                                        <input type="number" class="form-control-num lilow" name="lilower1" value="">
                                                        <label>&nbsp;To&nbsp;&nbsp;&nbsp;</label>
                                                        <input type="number" class="form-control-num lihigh" name="lihigher1" value=""> 
                                                    </div>
                                                </div>
                                                <div class="txtopt" style="display: none;">
                                                    <div id="text-options">
                                                        <div class="options-set">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" placeholder="A Text box will be provided to the user" readonly name="txtBox1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="erropt" style="display: none;">
                                                    <div id="error-options0">
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="form-group">
                                                <label>Question Media</label>
                                                <input type="file" name="fileQstn1" id="fileQstn1" class="fileQstn form-control-hidden">
                                                <label class="question-media fileQstnlbl" for="fileQstn1">
                                                    Upload Media
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Question Type</label>
                                                        <select class="form-control form-control-select select-qstn" name="qtype1">
                                                            <option value="1">Multiple choice</option>
                                                            <option value="2">Check Box</option>
                                                            <option value="3">Drop Down</option>
                                                            <option value="4">Linear Scale</option>
                                                            <option value="5">Text Field</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <label>Mandatory</label>
                                                            <div class="custom-switch custom-switch-secondary-inverse mb-2">
                                                                <input class="custom-switch-input mandatory-field" id="switch1" type="checkbox" name="mandatory1">
                                                                <label class="custom-switch-btn" for="switch1"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Options</label>
                                                        <div class="btn-group">
                                                            <button class="btn btn-primary copy_qstn" type="button">
                                                                <div class="glyph-icon iconsminds-duplicate-layer"></div>
                                                            </button>
                                                            <button class="btn btn-danger delete_qstn_sec" type="button">
                                                                <div class="glyph-icon simple-icon-trash"></div>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>                                  
                                </div>
                               
                            </form>
                            <div class="row">
                                    <div class="col-12 text-right">
                                        <button type="button" class="btn btn-outline-info my-2 add_qstn"> + New</button>
                                        <?php 
                                            if (isset($Survey)) {
                                                if ($edit == 1) {
                                        ?>
                                        <button type="button" class="btn btn-outline-dark my-2" id="btn-submit-draft">Make Draft</button>
                                        <button type="button" class="btn btn-primary my-2" id="btn-submit-publish">Publish Now</button>
                                        <?php
                                                }else{
                                        ?>
                                        <button type="button" class="btn btn-primary my-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="You need permission to save!">Save</button>
                                        <?php
                                                }
                                            }else{
                                                if($add == 1){
                                        ?>
                                        <button type="button" class="btn btn-outline-dark my-2" id="btn-submit-draft">Make Draft</button>
                                        <button type="button" class="btn btn-primary my-2" id="btn-submit-publish">Publish Now</button>
                                        <?php
                                                }else{
                                        ?>
                                        <button type="button" class="btn btn-primary my-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="You need permission to continue!">Save</button>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Select Children Popup Modal -->
    <div class="modal fade modal-right" id="selectChildrenModal" tabindex="-1" role="dialog" aria-labelledby="selectChildrenModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Children</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group filter-box">
                        <input type="text" class="form-control" id="filter-child" placeholder="Enter child name or age to search">
                    </div>
                    <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab"
                                aria-controls="first" aria-selected="true">Children</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab"
                                aria-controls="second" aria-selected="false">Groups</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="third-tab" data-toggle="tab" href="#third" role="tab"
                                aria-controls="third" aria-selected="false">Rooms</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                            <div class="select-all-box">
                                <input type="checkbox" id="select-all-child">
                                <label for="select-all-child" id="select-all-child-label">Select All</label>
                            </div>
                            <table class="list-table table table-condensed">
                                <?php  foreach ($Childrens as $childkey => $childobj) { ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="common-child child-tab unique-tag" name="child[]" id="<?= 'child_'.$childobj->childid; ?>" value="<?= $childobj->childid; ?>" data-name="<?= $childobj->name. "- " .$childobj->age; ?>" <?= $childobj->checked; ?>>
                                    </td>
                                    <td>
                                        <label for="<?= 'child_'.$childobj->childid; ?>">
                                            <img src="<?= BASE_API_URL.'assets/media/'.$childobj->imageUrl; ?>" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall">
                                            <?= $childobj->name. " - " .$childobj->age; ?>
                                        </label>
                                    </td>
                                </tr>
                                <?php  } ?>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                            <?php foreach ($Groups as $grkey => $grobj) { ?>
                                <div class="select-all-box">
                                    <input type="checkbox" id="<?= 'select-group-child-'.$grobj->groupid; ?>" class="select-group-child" data-groupid="<?= $grobj->groupid; ?>">
                                    <label for="<?= 'select-group-child-'.$grobj->groupid; ?>"><?= $grobj->name; ?></label>
                                </div>
                                <table class="list-table table table-condensed">
                                    <?php  foreach ($grobj->childrens as $childkey => $childobj) { ?>
                                    <tr>
                                        <td><input type="checkbox" class="common-child child-group" name="child[]" data-groupid="<?= $grobj->groupid; ?>" id="<?= 'child_'.$childobj->childid; ?>" value="<?= $childobj->childid; ?>" <?= $childobj->checked; ?>></td>
                                        <td>
                                            <label for="<?= 'child_'.$childobj->childid; ?>">
                                                <img src="<?= BASE_API_URL.'assets/media/'.$childobj->imageUrl; ?>" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall">
                                                <?= $childobj->name. " - " .$childobj->age; ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <?php  } ?>
                                </table>
                            <?php } ?>
                        </div>

                        <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
                            <?php foreach ($Rooms as $roomkey => $roomobj) { ?>
                                <div class="select-all-box">
                                    <input type="checkbox" class="select-room-child" id="<?= 'select-room-child-'.$roomobj->roomid; ?>" data-roomid="<?= $roomobj->roomid; ?>">
                                    <label for="<?= 'select-room-child-'.$roomobj->roomid; ?>"><?= $roomobj->name; ?></label>
                                </div>
                                <table class="list-table table table-condensed">
                                    <?php  foreach ($roomobj->childrens as $childkey => $childobj) { ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="common-child child-room" name="child[]" data-roomid="<?= $roomobj->roomid; ?>" id="<?= 'child_'.$childobj->childid; ?>" value="<?= $childobj->childid; ?>" <?= $childobj->checked; ?>>
                                        </td>
                                        <td>
                                            <label for="<?= 'child_'.$childobj->childid; ?>">
                                                <img src="<?= BASE_API_URL.'assets/media/'.$childobj->imageUrl; ?>" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall">
                                                <?= $childobj->name. " - " .$childobj->age; ?>
                                            </label>
                                        </td>
                                    </tr>
                                    <?php  } ?>
                                </table>
                            <?php } ?>  
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="insert-childtags" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('footer_v3'); ?>

    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/nouislider.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/select2.full.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap-datepicker.js"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.3"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/survey.js?v=1.0.0"></script>
    <script>
        $(document).ready(function() {

            $(document).on('click', "#select-all-child", function() {           
                //check if this checkbox is checked or not
                if ($(this).is(':checked')) {
                    //check all children
                    var _childid = $('input.common-child');
                    $(_childid).prop('checked', true);
                    $(".select-group-child").prop('checked', true);
                    $(".select-room-child").prop('checked', true);
                }else{
                    //uncheck all children
                    var _childid = $('input.common-child');
                    $(_childid).prop('checked', false);
                    $(".select-group-child").prop('checked', false);
                    $(".select-room-child").prop('checked', false);
                }
            });

            $(document).on('click', '#btn-submit-draft', function(event) {
                event.preventDefault();
                $("#survey-form").append('<input type="hidden" name="status" value="DRAFT">');
                $("#survey-form").submit();
            });

            $(document).on('click', '#btn-submit-publish', function(event) {
                event.preventDefault();
                $("#survey-form").append('<input type="hidden" name="status" value="PUBLISHED">');
                $("#survey-form").submit();
            });

            var _totalchilds = '<?= count($Childrens); ?>';

            $(document).on('click', '.common-child', function() {
                var _value = $(this).val();
                if ($(this).is(':checked')) {
                    $('input.common-child[value="'+_value+'"]').prop('checked', true);
                    $('input.child-group[value="'+_value+'"]').trigger('change');
                    $('input.child-room[value="'+_value+'"]').trigger('change');

                }else{
                    $('input.common-child[value="'+_value+'"]').prop('checked', false);
                    $('input.child-group[value="'+_value+'"]').trigger('change');
                    $('input.child-room[value="'+_value+'"]').trigger('change');
                }

                var _totalChildChecked = $('.child-tab:checked').length;
                if (_totalChildChecked == _totalchilds) {
                    $("#select-all-child").prop('checked', true);
                }else{
                    $("#select-all-child").prop('checked', false);
                }
            });
            
            $(document).on("click",".select-group-child",function(){
                var _groupid = $(this).data('groupid');
                var _selector = $('input.common-child[data-groupid="'+_groupid+'"]');

                if ($(this).is(':checked')) {
                    // $(_selector).prop('checked', true);
                    $.each(_selector, function(index, val) {
                        $(".common-child[value='"+$(this).val()+"']").prop('checked', true);
                    });
                }else{
                    // $(_selector).prop('checked', false);
                    $.each(_selector, function(index, val) {
                        $(".common-child[value='"+$(this).val()+"']").prop('checked', false);
                    });
                }

                var _totalChildChecked = $('.child-tab:checked').length;
                if (_totalChildChecked == _totalchilds) {
                    $("#select-all-child").prop('checked', true);
                }else{
                    $("#select-all-child").prop('checked', false);
                }
            });

            $(document).on("change", ".child-group", function(){
                var _groupid = $(this).data('groupid');
                var _selector = '#select-group-child-'+_groupid;
                var _totalGroupChilds = $('.child-group[data-groupid="'+_groupid+'"]').length;
                var _totalGroupChildsChecked = $('.child-group[data-groupid="'+_groupid+'"]:checked').length;
                if (_totalGroupChilds == _totalGroupChildsChecked) {
                    $(_selector).prop('checked', true);
                }else{
                    $(_selector).prop('checked', false);
                }
            });

            $(document).on("click",".select-room-child",function(){
                var _roomid = $(this).data('roomid');
                var _selector = $('input.common-child[data-roomid="'+_roomid+'"]');

                if ($(this).is(':checked')) {
                    $.each(_selector, function(index, val) {
                        $(".common-child[value='"+$(this).val()+"']").prop('checked', true);
                    });
                }else{
                    $.each(_selector, function(index, val) {
                        $(".common-child[value='"+$(this).val()+"']").prop('checked', false);
                    });
                }

                var _totalChildChecked = $('.child-tab:checked').length;
                if (_totalChildChecked == _totalchilds) {
                    $("#select-all-child").prop('checked', true);
                }else{
                    $("#select-all-child").prop('checked', false);
                }
            });

            $(document).on("change", ".child-room", function(){
                var _roomid = $(this).data('roomid');
                var _selector = '#select-room-child-'+_roomid;
                var _totalRoomChilds = $('.child-room[data-roomid="'+_roomid+'"]').length;
                var _totalRoomChildsChecked = $('.child-room[data-roomid="'+_roomid+'"]:checked').length;
                if (_totalRoomChilds == _totalRoomChildsChecked) {
                    $(_selector).prop('checked', true);
                }else{
                    $(_selector).prop('checked', false);                
                }
            });

            $(document).on("click","#insert-childtags",function(){
                $('.children-tags').empty();
                $('.unique-tag:checked').each(function(index, val) {
                    $('.children-tags').append(`
                        <a href="#!" class="rem" data-role="remove" data-child="`+ $(this).val() +`">
                            <input type="hidden" name="childs[]" value="`+ $(this).val() +`">
                            <span class="badge badge-pill badge-outline-primary mb-1">`+ $(this).data('name') +` X </span>
                        </a>
                    `);
                });
                $(".children-tags").show();
            });

            $(document).on('click', '.rem', function() {
                var _childid = $(this).data('child');
                $(".common-child[value='"+_childid+"']").trigger('click');
                $(this).remove();
            });

            $(document).on('click','.remove-qstn-media',function(){
                $(this).closest('.form-group').find('label').css('display','block');
                $(this).closest('.media-box').remove();
            });
        });
    </script>
</body>
</html>