
<!-- <script type="text/javascript" src="<?php #echo base_url('assets/js/vendor/jquery/jquery-migrate.min.js'); ?>"></script> -->
<script type="text/javascript" src="<?php echo base_url('assets/js/vendor/jquery/jquery-ui.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/vendor/bootstrap/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/vendor/moment/moment.min.js'); ?>"></script>
<!-- <script type="text/javascript" src="<?php echo base_url('assets/js/vendor/customscrollbar/jquery.mCustomScrollbar.min.js'); ?>"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url('assets/js/vendor/bootstrap-select/bootstrap-select.js'); ?>"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url('assets/js/vendor/select2/select2.full.min.js'); ?>"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url('assets/js/vendor/multiselect/jquery.multi-select.js'); ?>"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url('assets/js/lightbox-plus-jquery.min.js'); ?>"></script> -->

<script type="text/javascript" src="<?php echo base_url('assets/js/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/vendor/bootstrap-daterange/daterangepicker.js'); ?>"></script>
<!-- <script type="text/javascript" src="<?php #echo base_url('assets/js/ckeditor/ckeditor.js'); ?>"></script> -->
<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
<!-- <script src="https://cdn.ckeditor.com/4.16.2/basic/ckeditor.js"></script> -->
      
<script type="text/javascript" src="<?php echo base_url('assets/js/app.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/app_plugins.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/app_demo.js'); ?>"></script>

<!--Datatable -->
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<!-- END APP SCRIPTS -->
<script type="text/javascript" src="<?php echo base_url('assets/js/app_demo_dashboard.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/vendor/dropzone/dropzone.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.paginate.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/survey.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-tagsinput.min.js'); ?>"></script>
<!-- fullCalendar -->
<script src="<?php echo base_url('assets/plugins/moment/moment.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/fullcalendar/dist/fullcalendar.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/slick.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.signature.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.ui.touch-punch.min.js'); ?>"></script>

<script>
  $( document ).ready(function() {

      $('.single-item').slick();

      $('#childs').hide();      
      var mytagsinput = $('#childs');

      mytagsinput.tagsinput({
        itemValue: 'id', 
        itemText: 'text'
      });

      // $('.bootstrap-tagsinput').hide();
      $.fn.datepicker.defaults.format = "dd/mm/yyyy";
      //$('.datepickcal').datepicker();
      $('.datepicker').datetimepicker();
      $('#datatable').DataTable();

      $.ajax({
        traditional:true,
        type: "POST",
        url: "<?php echo BASE_API_URL.'Children/getChilds'; ?>",
        beforeSend: function(request) {
          request.setRequestHeader("X-Device-Id", "<?php echo $this->session->userdata('X-Device-Id');?>");
          request.setRequestHeader("X-Token", "<?php echo $this->session->userdata('AuthToken');?>");
        },
        data: JSON.stringify({"userid":<?php echo $this->session->userdata('LoginId');?>}),
        dataType:'json',
        success: function(msg){
          $("#loading-image").hide();
          msg.records.forEach(function(obj){
            $(".child-list").append('<li>'+ obj.name +'<span class="pull-right"><input type="checkbox" name="child[]" dataid="'+ obj.id +'" dataname="'+obj.name+'" class="child-name-list child childs-item" userid="child'+ obj.id +'" value="'+ obj.id +'"></span></li>');
          });
        }
      });

      $.ajax({
        traditional:true,
        type: "POST",
        url: "<?php echo BASE_API_URL.'Children/getGroupsAndChilds'; ?>",
        beforeSend: function(request) {
          request.setRequestHeader("X-Device-Id", "<?php echo $this->session->userdata('X-Device-Id');?>");
          request.setRequestHeader("X-Token", "<?php echo $this->session->userdata('AuthToken');?>");
        },
        data: JSON.stringify({"userid":<?php echo $this->session->userdata('LoginId');?>}),
        dataType:'json',
        success: function(msg){
          $("#loading-image").hide();
          msg.groups.forEach(function(obj){
            $('#groupsec').append('<div id="group'+obj.id+'" class="pull-left"><span>'+obj.name+'</span><span class="pull-right"><label for="groupname">Select All&nbsp;&nbsp;</label><input type="checkbox" id="group-child-list-'+obj.id+'" class="group"></span><ul class="list-unstyled ul-cg-list group-child-list-'+obj.id+'"></ul></div><div class="clearfix"></div>');
            obj.childs.forEach(function(child){
              $(".group-child-list-"+obj.id).append('<li>'+ child.name +'<span class="pull-right"><input type="checkbox" value="'+child.id+'" dataname="'+child.name+'" dataid="'+ child.id +'" userid="child'+ child.id +'" class="child-name-list room childs-item group-child-list-'+obj.id+'"></span></li>');
            });
            
          });
        }
      });
      
      if ($("input[name='listchildrentype']:checked").val() == 'children') {
          $("#loading-image").hide();
          $("#groupsec").hide();
          $("#childsec").show();
      }

      if ($("input[name='listchildrentype']:checked").val() == 'room') {
          $("#loading-image").hide();
          $("#childsec").hide();
          $("#groupsec").show();
      }

      $('input:radio[name=listchildrentype]').change(function () {
          if ($("input[name='listchildrentype']:checked").val() == 'children') {
              $("#loading-image").hide();
              $("#groupsec").hide();
              $("#childsec").show();
          }
          if ($("input[name='listchildrentype']:checked").val() == 'room') {
              $("#loading-image").hide();
              $("#childsec").hide();
              $("#groupsec").show();
          }
      });

      // Selecting and Counting all childrens in childrens modal
      $("#allChild").click(function() {
          $(".child").prop("checked", $(this).prop("checked"));
          var count = $(".childs-item:checked").length;
          if (count>1 && count!=0) {
            $('#counter').html(count + " childrens selected");
          } else {
            $('#counter').html(count + " child selected");
          }
      });

      // Checking/Unchecking similliar checkboxes in childrens modal
      $(document).on('click','.childs-item',function(){
        var id = $(this).attr('userid');
        if ($(this).is(":checked")) {
            $("[userid='"+id+"']").prop("checked",true);
        } else {
            $("[userid='"+id+"']").prop("checked",false);
        }
      });


      // $("#fileUpload").on('change', function() {
      //   $(".img-preview").remove();
      //   $("#form-observation[type='hidden']").remove();
      //   //Get count of selected files
      //   const countFiles = $(this)[0].files.length;
      //   let allGood = true;
      //   const mainHolder = $("#img-holder");

      //   for (let i = 0; i < countFiles; i++) {
      //     const file = this.files[i];
      //     const url = URL.createObjectURL(file);
      //     const imgPath = file.name;
      //     const extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
      //     const image_holder_name = "img-preview-" + i;
      //     if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg" || extn == "mp4") {
      //       if (typeof(Blob) != "undefined") {
      //         const image_holder = $("#img-preview-" + i);
      //         if (extn == "mp4") {
      //           mainHolder.append(`<div class="img-preview">
      //                                     <video class="thumb-image" controls>
      //                                       <source src="${url}" type="video/mp4">
      //                                     </video>
      //                                     <span class="img-remove">x</span>
      //                                     <a class="img-edit" href="#!" data-imgcount="${i}" data-image="${url}" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil"></i></a>
      //                                   </div>`);
      //         } else {
      //           mainHolder.append(`<div class="img-preview"><img class="thumb-image" src="${url}"><span class="img-remove">x</span><a class="img-edit" href="#!" data-imgcount="${i}" data-image="${url}" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil"></i></a></div>`);
      //         }
      //       }
      //     } else {
      //       allGood = false;
      //       alert("This browser does not support File API.");
      //       break;
      //     }
      //   }

      //   if (!allGood) {
      //     alert("Pls select only images and videos");
      //   }
      // });

      $(document).on('click','.add-childs',function(){
          $('.childs-item').each(function(index){
            if($(this).is(":checked")){
              id = $(this).attr("dataid");
              text = $(this).attr("dataname");
              mytagsinput.tagsinput('add', { id: id, text: text});
            }
          });
      });

      //Selecting all childrens in Sort By Room Modal
      $(document).on('click','input[class="group"]',function(){
        var id = $(this).attr('id');
        if($("#"+id).is(":checked")) {

          $("li ."+id).each(function(index){
            var userid = $(this).attr("userid");
            $('[userid='+userid+']').prop("checked",true);
          });

        }else{

          $("li ."+id).each(function(index){
            var userid = $(this).attr("userid");
            $('[userid='+userid+']').prop("checked",false);
          });

        }
      });

      //Counting childrens in sort by room modal
      $(document).on('click','.room',function(){
          var count = $(".room:checked").length;
          if (count>1 && count!=0) {
            $('#counter').html(count + " childrens selected");
          } else {
            $('#counter').html(count + " child selected");
          }
      });

      //counting childrens in childrens modal
      $(document).on('click','.child',function(){
          var count = $(".child:checked").length;
          if (count>1 && count!=0) {
            $('#counter').html(count + " childrens selected");
          } else {
            $('#counter').html(count + " child selected");
          }
      });

      $(document).on('click','#selectChildrenBtn2',function(){
        $(".childs-item:checked").each(function(index){
          var id = $(this).val();
          var text = $(this).attr('dataname');
          // mytagsinput.tagsinput('add', { id: id, text: text});
        });
        // $('#childs').hide();
        $('.bootstrap-tagsinput').show();
      });

   });

  // summernot();
  // function summernot()
  // {
  //  CKEDITOR.replace( 'editor1' );
  // }
  $('.menu').click( function(){
      if ($(this).hasClass('current') ) {
          $(this).removeClass('current');
      } else {
          $('li a.current').removeClass('current');
          $(this).addClass('current');    
      }
  });


    //call paginate
  $('#example').paginate();

var coll = document.getElementsByClassName("divexpand");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
var coll = document.getElementsByClassName("filtercollapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}

function deleteElement(eleId,option){

  $.ajax({
    traditional:true,
    type: "POST",
    url: "<?php echo base_url().'surveys/deleteElements'; ?>",
    beforeSend: function(request) {
      request.setRequestHeader("X-Device-Id", "<?php echo $this->session->userdata('X-Device-Id');?>");
      request.setRequestHeader("X-Token", "<?php echo $this->session->userdata('AuthToken');?>");
    },
    data: {"userid":<?php echo $this->session->userdata('LoginId');?>,'eleId':eleId,'option':option},
    success: function(msg){
      window.location.reload();
      // console.log(msg);
    }
  });
}

</script>


  




  <!--- Icon For Child Table --->
  <div>
    <!--<a href="#" class="float" id='float' onclick="openForm()">-->
        <a href="#" class="float floatButton" id='float'>
          <span><img src='<?php echo base_url()?>assets/images/icons/loader_icon.png' width="60" height="60"></img></span>
      </a>
  </div>
  <!--- Icon For Child Table --->

  <!--- Icon Click Side Child Table View --->

    <div class="chat-popup form-container" id="myForm">
  
          <h1>Table</h1>
    
              <div class="searchFlex">
                <span class="material-icons-outlined">search</span>
                <input type="text" name="filter_name"  placeholder="Search by Child name,Last Observation" class="" id='search'>
              </div>
    
              <div class='text-body' id='text-body'>
                  
              </div>
    </div>
  <!--- Icon Click Side Child Table View --->

  <div id="overlay">
      <div class="cv-spinner">
        <span class="spinner"></span>
      </div>
  </div>

  <script>

    $('#float').click(function(){
      document.getElementById("myForm").style.display = "block";
          $('#text-body').html('');    
          $.ajax({
              url:'<?php echo base_url()?>observation/observation_child_table',
              type:'POST',
              success:function(view_data){
                $('#text-body ').html(view_data);  
                $("pre").wrapInner('<div class="listViewChildTable">').find('div').unwrap();
                
                  
              }
          });
    });

    function openForm() {
      document.getElementById("myForm").style.display = "block";
          $('#text-body').html('');    
          $.ajax({
              url:'<?php echo base_url()?>observation/observation_child_table',
              type:'POST',
              success:function(view_data){
                $('#text-body ').html(view_data);  
                $("pre").wrapInner('<div>').find('div').unwrap();
                
                  
              }
          });
    }


    $('.container').click(function(){
        document.getElementById("myForm").style.display = "none";
    });


        $('#search').keyup(function() {
            var matcher = new RegExp($(this).val(), 'gi');
            console.log(matcher);
            $('.col1').show().not(function(){
                    //return matcher.test($(this).find('.name, .category').text());
                    return matcher.test($(this).find('.name').text());
            }).hide();
        });
</script>




        </body>
</html>
