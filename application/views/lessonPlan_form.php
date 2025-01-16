<?php $data['name']='Program Plan'; $this->load->view('header',$data); ?>

<div class="container">
	<div class="pageHead">
		<h1>Add Lesson Plan</h1>
        <div class="headerForm">

        </div>        
    </div>
    <div class="addProgPlanContainer">
        <div class="uploadImage">
            <img src="https://via.placeholder.com/2600x500.png">
            <a class="editLink" href="#">
                <span class="material-icons-outlined">photo_camera</span>
                Edit Cover Photo
            </a>
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <div class="input-group">
                <input id="color" type="color" name="title" class="form-control" required="">
            </div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <div class="input-group">
                <textarea id="description" class="form-control"></textarea>
            </div>
        </div>
        <div class="formSubmit">
                <button type="submit" class="btn btn-default btnBlue pull-right">Save</button>
        </div>
    </div>
</div>



<?php $this->load->view('footer'); ?>