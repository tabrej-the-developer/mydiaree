
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Standard | Mydiaree v2</title>
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/iconsmind-s/css/iconsminds.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/font/simple-line-icons/css/simple-line-icons.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/fullcalendar.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/perfect-scrollbar.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/glide.core.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-stars.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/nouislider.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/vendor/bootstrap-datepicker3.min.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/main.css?v=1.0.0" />
    <link rel="stylesheet" href="<?= base_url('assets/v3'); ?>/css/dore.light.blueolympic.min.css?v=1.0.0" />
    <style>
        .cke_toolbar_break{
            display: none;
        }
    </style>
</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?>
    <main data-centerid="<?= isset($_GET['centerid'])?$_GET['centerid']:null; ?>">
        <div class="default-transition">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h1>Edit Standard</h1>
                        <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                            <ol class="breadcrumb pt-0">
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('Qip').'?centerid=' . $_GET['centerid']; ?>">QIP</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('qip/edit').'?id=' . $_GET['qipid']; ?>">Edit QIP</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= base_url('qip/view').'?qipid=' . $_GET['qipid'].'&areaid='.$_GET['areaid']; ?>">Standard & Element</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Standard</li>
                            </ol>
                        </nav>
                        <div class="separator mb-5"></div>
                    </div>
                    <div class="col-12 mb-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select id="qipAreasDD" class="form-control">
                                            <option value="" hidden>-- Select Area --</option>
                                            <?php 
                                                if(isset($QipAreas)){
                                                    foreach ($QipAreas as $qiparea => $area) {
                                                        if ($area->id == $Standard->areaId) {
                                            ?>
                                            <option value="<?= $area->id; ?>" selected><?= $area->title; ?></option>
                                            <?php
                                                        } else {
                                            ?>
                                            <option value="<?= $area->id; ?>"><?= $area->title; ?></option>
                                            <?php  
                                                        }
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="" id="standardFrom">
                                            <input type="hidden" name="qipid" value="<?= $_GET['qipid']; ?>">
                                            <input type="hidden" name="areaid" value="<?= $_GET['areaid']; ?>">
                                            <input type="hidden" name="centerid" value="<?= $_GET['centerid']; ?>">
                                            <select id="qipStandardsDD" class="form-control" name="stdid">
                                                <option value="" hidden>-- Select Standard --</option>
                                                <?php 
                                                    if(isset($OtherStandards) && $OtherStandards != NULL){
                                                        foreach ($OtherStandards as $otherStd => $ostd) {
                                                            if ($ostd->id == $_GET['stdid']) {
                                                ?>
                                                <option value="<?= $ostd->id; ?>" selected><?= $ostd->name; ?></option>
                                                <?php
                                                            } else {
                                                ?>
                                                <option value="<?= $ostd->id; ?>"><?= $ostd->name; ?></option>
                                                <?php  
                                                            }
                                                        }
                                                    }else{
                                                ?>
                                                <option value="" selected>-- No Records Found! --</option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($_GET['status']) && strtolower($_GET['status']) == "success") { ?>
                        <div class="col-md-6 offset-md-3 mb-4">
                            <div class="alert alert-success alert-dismissible fade show rounded mb-0" role="alert">
                                <strong>Success!</strong> Record updated successfully.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-12 mb-3">
                        <?php if ($Standard==NULL) { ?>
                            <h3 class="text-center text-danger">No records found!</h3>
                        <?php }else{ ?>
                            <form action="<?= base_url("Qip/updateQipStandard"); ?>" method="post">
                                <input type="hidden" name="stdid" value="<?= isset($_GET['stdid'])?$_GET['stdid']:NULL; ?>">
                                <input type="hidden" name="qipid" value="<?= isset($_GET['qipid'])?$_GET['qipid']:NULL; ?>">
                                <input type="hidden" name="areaid" value="<?= $_GET['areaid']; ?>">
                                <input type="hidden" name="centerid" value="<?= $_GET['centerid']; ?>">
                                <div class="standard-info">
                                    <h4 class="text-primary"><?= $Standard->name." - ".$Standard->about; ?></h4>
                                    <div class="card mt-4 mb-4 p-4">
                                        <div class="text-field">
                                            <p>1. Practice is embedded in service operations</p>
                                            <div class="form-group">
                                                <textarea name="val1" class="editor" id="val1"><?php echo isset($Standard->val1)?html_entity_decode($Standard->val1):NULL; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="text-field">
                                            <p>2. Practice is informed by critical reflection</p>
                                            <div class="form-group">
                                                <textarea name="val2" class="editor" id="val2"><?php echo isset($Standard->val2)?html_entity_decode($Standard->val2):NULL; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="text-field">
                                            <p>3. Practice is shaped by meaningful engagement with families, and/or community</p>
                                            <div class="form-group">
                                                <textarea name="val3" class="editor" id="val3"><?php echo isset($Standard->val3)?html_entity_decode($Standard->val3):NULL; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Update Now</button>
                                </div>
                            </form> 
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php $this->load->view('footer_v3'); ?>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/jquery-3.3.1.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/bootstrap.bundle.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/moment.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/fullcalendar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/perfect-scrollbar.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/mousetrap.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/glide.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/dore.script.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/scripts.js?v=1.0.0"></script> 
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/datatables.min.js?v=1.0.0"></script>
    <script src="<?= base_url('assets/v3'); ?>/js/vendor/ckeditor5-build-classic/ckeditor.js?v=1.0.0"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function(){
            var allEditors = document.querySelectorAll('.editor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(allEditors[i]);
            }
            // $(".editor").each(function () {
            //     let id = $(this).attr('id');
            //     CKEDITOR.replace(id, options);
            // });
            // CKEDITOR.replace('val1', {
            //   plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar',
            //   contentsCss: [
            //     'https://cdn.ckeditor.com/4.16.2/full-all/contents.css',
            //     'https://ckeditor.com/docs/ckeditor4/4.16.2/examples/assets/mentions/contents.css'
            //   ],
            //   height: 150,
            //   toolbar: [{
            //       name: 'document',
            //       items: ['Undo', 'Redo']
            //     },
            //     {
            //       name: 'basicstyles',
            //       items: ['Bold', 'Italic', 'Strike']
            //     },
            //     {
            //       name: 'links',
            //       items: ['EmojiPanel', 'Link', 'Unlink']
            //     }
            //   ],
            //   extraAllowedContent: '*[*]{*}(*)'
            // });

            // CKEDITOR.replace('val2', {
            //   plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar',
            //   contentsCss: [
            //     'https://cdn.ckeditor.com/4.16.2/full-all/contents.css',
            //     'https://ckeditor.com/docs/ckeditor4/4.16.2/examples/assets/mentions/contents.css'
            //   ],
            //   height: 150,
            //   toolbar: [{
            //       name: 'document',
            //       items: ['Undo', 'Redo']
            //     },
            //     {
            //       name: 'basicstyles',
            //       items: ['Bold', 'Italic', 'Strike']
            //     },
            //     {
            //       name: 'links',
            //       items: ['EmojiPanel', 'Link', 'Unlink']
            //     }
            //   ],
            //   extraAllowedContent: '*[*]{*}(*)'
            // });

            // CKEDITOR.replace('val3', {
            //   plugins: 'mentions,emoji,basicstyles,undo,link,wysiwygarea,toolbar',
            //   contentsCss: [
            //     'https://cdn.ckeditor.com/4.16.2/full-all/contents.css',
            //     'https://ckeditor.com/docs/ckeditor4/4.16.2/examples/assets/mentions/contents.css'
            //   ],
            //   height: 150,
            //   toolbar: [{
            //       name: 'document',
            //       items: ['Undo', 'Redo']
            //     },
            //     {
            //       name: 'basicstyles',
            //       items: ['Bold', 'Italic', 'Strike']
            //     },
            //     {
            //       name: 'links',
            //       items: ['EmojiPanel', 'Link', 'Unlink']
            //     }
            //   ],
            //   extraAllowedContent: '*[*]{*}(*)'
            // });

            $("#qipAreasDD").on("change",function(){
                let areaid = $(this).val();
                $.ajax({
                    url: '<?= base_url("Qip/getAreaStandards"); ?>',
                    type: 'POST',
                    data: {'areaid': areaid}
                })
                .done(function(msg) {
                    console.log(msg);
                    res = $.parseJSON(msg);
                    $("#qipStandardsDD").empty();
                    if (res.Status == "SUCCESS") {
                        $("#qipStandardsDD").append(`
                            <option value="">-- Select Standard --</option>
                        `);
                        $.each(res.AreaStd, function(index, val) {
                            $("#qipStandardsDD").prop("disabled",false);
                            $("#qipStandardsDD").append(`
                                <option value="`+val.id+`">`+val.name+`</option>
                            `);
                        });
                    }else{
                        $("#qipStandardsDD").prop("disabled",true);
                        $("#qipStandardsDD").append(`
                            <option value="">-- No Options Found --</option>
                        `);
                    }
                });  
            });

            $("#qipStandardsDD").on("change",function(){
                $("#standardFrom").submit();
            });
        });
    </script>
</body>
</html>
