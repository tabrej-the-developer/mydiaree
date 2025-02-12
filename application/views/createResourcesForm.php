<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Resouces | Mydiaree</title>
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
    	#img-holder {
		    display: flex;
		    width: 100%;
		    flex-direction: row;
		    flex-wrap: wrap;
		}
    	.img-preview.m-2 {
		    position: relative;
		}
		span.img-remove.m-2.text-danger {
		    position: absolute;
		    right: 0px;
		    background: #ffffff;
		    border: 1px solid #000000;
		    height: 22px;
		    width: 22px;
		    text-align: center;
		    border-radius: 50%;
		    cursor: pointer;
		}
    </style>
</head>
<body id="app-container" class="menu-default show-spinner">
<?php $this->load->view('sidebar'); ?>
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1>Add Resources</h1>
                <nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
                    <ol class="breadcrumb pt-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('Dashboard'); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('resources'); ?>">Resources</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Resources</li>
                    </ol>
                </nav>
                <div class="separator mb-5"></div>
                </div>
                <div class="col-12">
                    <form action="addResource" method="post" enctype="multipart/form-data" id="resourcesForm">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="addResourceLeft m-1 p-4 card">
                                    <div class="form-group">
                                        <label for="txtTitle">Title</label>
                                        <input type="text" id="txtTitle" name="title" class="form-control" placeholder="Write resources title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtTitle">Description</label>
                                        <textarea type="text" id="txtDesc" name="description" class="form-control" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="card">
                                	<div class="card-body">
                                		<div id="img-holder"></div>
	                                    <div class="form-group">
	                                        <label class="file-upload-field w-100" for="fileUpload" style="padding-top: 20px;background-color: #f8f8f8; height: 100px;border: 1px dashed #ECECEC; margin: auto;">
	                                            <div class="mediaBox">
	                                                <div class="mediaUpload">
	                                                    <div class="uploadContainer">
	                                                        <div class="uploadText h5 text-center">
	                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
	                                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
	                                                            </svg>
	                                                            <br>Upload
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </label>
	                                        <input type="file" name="resMedia[]" id="fileUpload" class="form-control-hidden hidden" multiple="" style="display:none">
	                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="formSubmit text-right">
                            <button type="submit" class="btn btn-primary btn-default btn-small pull-right btnBlue">Add Post</button>
                            <!-- <button type="button" class="btn btn-default btn-small btn-danger">Cancel</button> -->
                            <a href="<?= base_url('Resources'); ?>" class="btn btn-default text-decoration-none btn-small btn-danger">Cancel</a>
                        </div>
                    </form>
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
    <!-- <script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>  -->
	<script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>

</body>
<script>
	$(document).ready(function(){
        var allEditors = document.querySelectorAll('.editor');
        for (var i = 0; i < allEditors.length; ++i) {
            ClassicEditor.create(allEditors[i]);
        }
		$("#resourcesForm").on("submit",function(e){
			
			let title = $("#txtTitle").val();
			let files = 0;
			if ($('#fileUpload').get(0).files.length === 0) {
			    files = 0;
			}else{
			    files = 1;
			}
			if (title=="" || files==0) {
				e.preventDefault();
				alert("File & Title field is mandatory!");
			}
		});

		$("#fileUpload").on('change', function() {
	        $(".img-preview").remove();
	        $("#form-observation[type='hidden']").remove();
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
	                                        <span class="img-remove">x</span>
	                                    </div>`);
						} else {
	                		mainHolder.append(`<div class="img-preview m-2"><img class="thumb-image" src="${url}" style="width: 150px; height: 100px;"><span class="img-remove m-2 text-danger">x</span></div>`);
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
			$('#fileUpload')[0].files  = myFileList;
			$(this).parent().remove();
		});

		var users = <?= $users; ?>, tags = <?= $tags; ?>;

CKEDITOR.replace('txtDesc', {
    plugins: 'mentions,basicstyles,undo,link,wysiwygarea,toolbar,format,list',
    contentsCss: [
        'https://cdn.ckeditor.com/4.22.1/full-all/contents.css',
        'https://ckeditor.com/docs/ckeditor4/4.22.1/examples/assets/mentions/contents.css'
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
        }
    ],
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

	});
</script>	
</html>
