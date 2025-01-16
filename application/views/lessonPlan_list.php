<?php $data['name']='Program Plan'; $this->load->view('header',$data); ?>


<div class="container">
	<div class="pageHead">
		<h1>Lesson Plan</h1>
		<div class="headerForm">
            <select name="centerid" id="centerId" class="form-control">
                <option value="1">Melbourne Center</option>
                <option value="2">Carramar Center</option>
            </select>
			<a class="btn btn-default btnBlue btn-small pull-right" href="<?php echo base_url('lessonPlanList/add') ?>">
                <span class="material-icons-outlined">add</span>
                Add
            </a>
		</div>
	</div>
    <div class="searchMain">
        <div class="searchDiv">
            <input type="search" placeholder="Search here...">
        </div>
    </div>
    <div class="lessonPlanList">
        <div class="lessonPlanListPageBlock">
            <img src="https://via.placeholder.com/350x150.png">
            <h3 style="background: #CA0000;">Creative Expession <a href="<?php echo base_url('lessonPlanList/add') ?>"><span class="material-icons-outlined">edit</span></a></h3>
        </div>
        <div class="lessonPlanListPageBlock">
            <img src="https://via.placeholder.com/350x150.png">
            <h3 style="background: #FD7900;">Culture & Community <a href="<?php echo base_url('lessonPlanList/add') ?>"><span class="material-icons-outlined">edit</span></a></h3>
        </div>
        <div class="lessonPlanListPageBlock">
            <img src="https://via.placeholder.com/350x150.png">
            <h3 style="background: #FFD600;">Literacy &Numeracy <a href="<?php echo base_url('lessonPlanList/add') ?>"><span class="material-icons-outlined">edit</span></a></h3>
        </div>
        <div class="lessonPlanListPageBlock">
            <img src="https://via.placeholder.com/350x150.png">
            <h3 style="background: #1F86FF;">Science & Nature <a href="<?php echo base_url('lessonPlanList/add') ?>"><span class="material-icons-outlined">edit</span></a></h3>
        </div>
        <div class="lessonPlanListPageBlock">
            <img src="https://via.placeholder.com/350x150.png">
            <h3 style="background: #1F86FF;">Science & Nature <a href="<?php echo base_url('lessonPlanList/add') ?>"><span class="material-icons-outlined">edit</span></a></h3>
        </a>
    </div>
</div>
    
<?php $this->load->view('footer'); ?>

<script>
$(document).ready(function(){
    $(".lessonPlanListPageBlock").on("click", function(){   
        window.location = "<?php echo base_url('lessonPlanList/programPlanList') ?>";
    });
});

</script>