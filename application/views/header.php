<!DOCTYPE html>
<html lang="en">
    <head>                        
        <title><?php echo $name; ?></title>            
        
        <!-- META SECTION -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        

        <!-- END META SECTION -->
        <!-- CSS INCLUDE -->
        <!-- <link rel="stylesheet" href="<?php // echo base_url('assets/css/style_new.css'); ?>">
		<link rel="stylesheet" href="<?php // echo base_url('assets/css/styles.css'); ?>"> -->
        <!-- <link rel="stylesheet" href="<?php // echo base_url('assets/css/style_new.css'); ?>">
		<link rel="stylesheet" href="<?php // echo base_url('assets/css/styles.css'); ?>"> -->
		
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
        <style> @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap'); </style>
        
        <script type="text/javascript" src="<?php echo base_url('assets/js/vendor/jquery/jquery.min.js'); ?>"></script>
        
		<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.paginate.css'); ?>" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datepicker.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-tagsinput.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/surveys.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/service-details.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.dataTables.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/lightbox.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/progressNotes.css'); ?>">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.semanticui.min.css">
        <link rel="stylesheet" href="<?php echo base_url('assets/css/slick.css'); ?>">  
        <link rel="stylesheet" href="<?php echo base_url('assets/css/slick-theme.css'); ?>">
        <?php if (isset($_SESSION)) { ?>
        <link rel="stylesheet" id="csslayout" href="<?php echo base_url('assets/css/'.$_SESSION["Container"]); ?>">
        <link rel="stylesheet" id="csscontainer" href="<?php echo base_url('assets/css/'.$_SESSION["Layout"]); ?>">     
        <?php }else{?>
        <link rel="stylesheet" id="csslayout" href="<?php echo base_url('assets/css/layout.css'); ?>">
        <link rel="stylesheet" id="csscontainer" href="<?php echo base_url('assets/css/container.css'); ?>">
        <?php } ?>        
        <link rel="stylesheet" href="<?php echo base_url('assets/css/modals.css'); ?>">
        <!-- fullCalendar -->
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fullcalendar/dist/fullcalendar.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fullcalendar/dist/fullcalendar.print.min.css'); ?>" media="print">
        <!-- <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-grid.min.css'); ?>"> -->

        <!-- Child Table Screen Plugin -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
            <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"> 
            <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.signature.css'); ?>"> 
        <!-- Child Table Screen Plugin -->

        <?php if (!empty($Resource->title)) { ?>
            <meta property="og:url" content="<?php echo base_url()."resources/viewResource?resId=".$Resource->id; ?>" />
            <meta property="og:type" content="article"/>
            <meta property="og:title" content="<?php echo $Resource->title; ?>" />
            <meta property="og:description" content="<?php echo $Resource->description; ?>" />
            <?php 
                if(isset($Resource->media[0])){
                    if($Resource->media[0]->mediaType == "Image"){
            ?>
            <meta property="og:image" content="<?php echo BASE_API_URL."assets/media/".$Resource->media[0]->mediaUrl; ?>" />
            <?php  }else{ ?>
            <meta property="og:image" content="https://via.placeholder.com/1200x628?text=NO+PREVIEW" />
            <?php  } } } ?>

    	<style>
            /*.select2-close-mask{
                z-index: 2099;
            }
            .select2-dropdown{
                z-index: 3051;
            }*/
            .paginate { padding: 0; margin: 0; }
            .paginate > li { list-style: none; padding: 10px 20px; border: 1px solid #ddd; margin: 10px 0; }
            #loading-image{
                width:100%;
                text-align: center;
                padding:100px 0px;
            }
            .child-list>li{
                padding: 5px 10px;
                border: 1px solid #ececec;
                width: 100%;
                margin-top: 1px;
                margin-bottom: 1px;
            }
            .ul-cg-list>li{
                padding: 5px 10px;
                border: 1px solid #ececec;
                width: 100%;
                margin-top: 1px;
                margin-bottom: 1px;
            }
            #groupsec > div { width:100%; margin:5px 0px; }
            #counter{
                position:absolute;
                left:5px;
                bottom: -10px;
            }
            .thumb-image,.thumb-video{
                height: 100px;
                width: auto;
                margin: 0px 5px;
            }
            #image-holder,#video-holder{
                position: relative;
                width:110px;
                float:left;
                display: flex;
            }
            .img-remove,.vid-remove, .image-remove, .video-remove{
                font-size: 11px;
                background-color: #f5f5f5;
                color: rgb(0 0 0 / 95%);
                height: 20px;
                width: 20px;
                border-radius: 50%;
                position: absolute;
                border: 1px solid #000;
                line-height: 1.4;
                top: 2px;
                right: 2px;
                z-index: 10;
                cursor: pointer;
            }
            .fixed-bottom{
                position: absolute;
                bottom: 0px;
            }
            .img-preview,.vid-preview{
                position: relative;
                width:110px;
                float:left;
                display: flex;
                overflow-x: hidden;
            }    	
            .slidecontainer {
                width: 100%;
            }
            .pd-02{
                padding:0px 20px 20px 20px;
            }
            .img-edit {
                font-size: 11px;
                background-color: #f5f5f5;
                color: rgb(0 0 0 / 95%);
                height: 20px;
                width: 20px;
                border-radius: 50%;
                position: absolute;
                border: 1px solid #000;
                line-height: 1.4;
                top: 30px;
                right: 2px;
                z-index: 10;
                cursor: pointer;
            }
        </style>

        <!--- Side Table Design -->


        <style>
            .float{
            position:fixed;
            width:60px;
            height:60px;
            bottom:40px;
            right:40px;
            text-align:center;
            font-size:30px;
            padding-left: 2%;
            z-index:100;
        }

        .my-float{
            margin-top:16px;
        }
        </style>
        <style>
            body {font-family: Arial, Helvetica, sans-serif;}
            * {box-sizing: border-box;}

            /* Button used to open the chat form - fixed at the bottom of the page */
            .open-button {
            background-color: #555;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            opacity: 0.8;
            position: fixed;
            bottom: 23px;
            right: 28px;
            width: 280px;
            }

            /* The popup chat - hidden by default */
            .chat-popup {
            display: none;
            position: fixed;
            bottom: 0;
            right:0px;
            border: 3px solid #f1f1f1;
            z-index: 9;
            height: 90%;
            width: 30%;
            overflow: auto;
            }

            /* Add styles to the form container */
            .form-container {
            padding: 10px;
            background:#ffffff;
            padding-left: 2%;
            }

            /* Full-width textarea */
            .form-container textarea {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            border: none;
            background: #f1f1f1;
            resize: none;
            min-height: 200px;
            }

            /* When the textarea gets focus, do something */
            .form-container textarea:focus {
            background-color: #ddd;
            outline: none;
            }

            /* Set a style for the submit/send button */
            .form-container .btn {
            background-color: #04AA6D;
            color: white;
            padding: 16px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-bottom:10px;
            opacity: 0.8;
            }

            /* Add a red background color to the cancel button */
            .form-container .cancel {
            background-color: red;
            }

            /* Add some hover effects to buttons */
            .form-container .btn:hover, .open-button:hover {
            opacity: 1;
            }

            .searchFlex input {
                min-width: 81% ! important;

            }

        </style>
        <!--- Side Table Design -->

        <style>
            #overlay{	
                    position: fixed;
                    top: 0;
                    z-index: 100;
                    width: 100%;
                    height:100%;
                    display: none;
                    background: rgba(0,0,0,0.6);
            }
            .cv-spinner {
                    height: 100%;
                    display: flex;
                    justify-content: center;
                    align-items: center;  
            }
            .spinner {
                    width: 40px;
                    height: 40px;
                    border: 4px #ddd solid;
                    border-top: 4px #2e93e6 solid;
                    border-radius: 50%;
                    animation: sp-anime 0.8s infinite linear;
            }
            @keyframes sp-anime {
                    100% { 
                        transform: rotate(360deg); 
                    }
            }
            .is-hide{
                display:none;
            }
            </style>


    </head>
    <body>
        <!-- APP WRAPPER -->
        <div class="app">
            <!-- START APP CONTAINER -->
            <div class="app-container">
                <!-- START SIDEBAR -->
                <div class="app-sidebar app-navigation app-navigation-fixed scroll app-navigation-style-default app-navigation-open-hover dir-left" data-type="close-other">
					<?php $this->load->view('menu'); ?>
				</div>
                <!-- END SIDEBAR -->
                <!-- START APP CONTENT -->
                <div class="app-content appRightCont">
                    <!-- START APP HEADER -->
                    <div class="app-header app-header-design-default">
                        <!-- <ul class="app-header-buttons">
                            <li class="visible-mobile"><a href="#" class="btn btn-link btn-icon deskMenuIcon" data-sidebar-toggle=".app-sidebar.dir-left"><span class="material-icons-outlined">menu</span></a></li>
                            <li class="hidden-mobile"><a href="#" class="btn btn-link btn-icon " data-sidebar-minimize=".app-sidebar.dir-left"><span class="material-icons-outlined">menu</span></a></li>
                        </ul> -->
                           
                    
                        <ul class="app-header-buttons pull-right">
                            <li>
                                <div class="contact contact-rounded contact-bordered contact-lg contact-ps-controls">
                                    <div class="contact-container accountDet">
                                        <div class="profPic"></div>
                                        <div class="profDet">
                                            <p><?php echo $this->session->userdata('Name'); ?></p>
                                            <span><?php echo $this->session->userdata('UserType'); ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-controls">
                                        <div class="dropdown">
                                            <!-- <button type="button" class="btn btn-icon" data-toggle="dropdown"><span class="material-icons-outlined">settings</span></button>                         -->
                                            <ul class="dropdown-menu dropdown-left">
                                               <!-- <li><a href="#"><span class="icon-cog"></span> Settings</a></li> 
                                                <li><a href="#"><span class="icon-envelope"></span> Messages <span class="label label-danger pull-right">+24</span></a></li>
                                                <li><a href="#"><span class="icon-users"></span> Contacts <span class="label label-default pull-right">76</span></a></li> <li class="divider"></li>
                                               -->
                                                <!-- <li>
                                                    <a href="<php echo base_url('logout'); ?>">
                                                        <span class="material-icons">person</span> My Account
                                                    </a>
                                                </li>  -->
                                                <li>
                                                    <a href="<?php echo base_url('logout'); ?>">
                                                        <span class="material-icons">logout</span> Log Out
                                                    </a>
                                                </li> 
                                            </ul>
                                        </div>                    
                                    </div>
                                </div>
                            </li>        
                        </ul>
                    </div>

                    <script>
                        $(document).ready(function(){
                            $(".accountDet").on("click", function() {
                                $(".dropdown").toggleClass("open");
                            });
                        });
                    </script>