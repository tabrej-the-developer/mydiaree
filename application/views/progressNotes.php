<?php 
    $data['name']='ProgressNotes'; 
    $this->load->view('header',$data); 
?>
<div class="container mediaContainer">
    <div class="pageHead">
        <h1>ProgressNotes</h1>
        <form action="" method="get" id="centerDropdown">
            <select name="centerid" id="centerId" class="form-control new-select">
                <?php 
                    $dupArr = [];
                    foreach ($this->session->userdata("centerIds") as $key => $center){
                        if ( ! in_array($center, $dupArr)) {
                            if (isset($_GET['centerid']) && $_GET['centerid'] != "" && $_GET['centerid']==$center->id) {
                ?>
                <option value="<?php echo $center->id; ?>" selected><?php echo $center->centerName; ?></option>
                <?php
                            }else{
                ?>
                <option value="<?php echo $center->id; ?>"><?php echo $center->centerName; ?></option>
                <?php
                            }
                        }
                        array_push($dupArr, $center);
                    }
                ?>
            </select>
        </form>
    </div>
    
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style='height: auto ! important;width: auto ! important;'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="myModalForm">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Manage tags</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <img src="" id="imageContent" class="img-responsive">
                            <video id="videoContent" controls>
                                <source src=""  />
                            </video>
                            <input type="hidden" class="img-count" value="">
                            <div class="form-group">
                             <label>Childs</label>
                             <select class="js-example-basic-multiple form-control" multiple="multiple" name="childsId[]" id="child-tags">
                                <?php foreach ($Children as $key => $ch) { ?>
                                <option value="<?php echo $ch->id; ?>"><?php echo $ch->name; ?></option>
                                <?php } ?>
                             </select>
                            </div>
                            <div class="form-group">
                             <label>Educators</label>
                             <select class="js-example-basic-multiple form-control" multiple="multiple" name="educatorsId[]" id="staff-tags">
                             <?php foreach ($Users as $key => $ed) { ?>
                                <option value="<?php echo $ed->userid; ?>"><?php echo $ed->name; ?></option>
                             <?php } ?>
                             </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="saveImgAttr" class="btn btn-primary myModalBtn btn-small btnBlue pull-right" data-dismiss="modal">Save</button>
                        <button type="button" class="btn btn-default btn-small btnRed pull-right" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>

<script>
        $(document).on('click','.media-remove',function(){
          var mediaid = $(this).data('mediaid');
          var userid = <?php echo $this->session->userdata('LoginId'); ?>;

                if (confirm('Are you sure,You want to Delete ?')) {
                    $.ajax({
                        traditional:true,
                        type: "GET",
                        url: "<?php echo base_url().'Media/deleteMedia/'; ?>"+userid+"/"+mediaid,
                        success: function(msg){
                            location.reload();
                            //console.log(msg);
                        }
                    });
                }
        });
</script>



