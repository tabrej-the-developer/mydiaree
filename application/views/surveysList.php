<?php 
	$data['name']='Surveys'; 
	$this->load->view('header',$data); 
?>


<div class="container ">
	<div class="pageHead">
		<h1>Surveys</h1>
		<div class="headerForm">
			<?php if ($this->session->userdata('UserType')!="Parent") { ?>
				<a href="<?php echo base_url('surveys/add'); ?>" class="btn btn-default btn-small btnBlue pull-right">
					<span class="material-icons-outlined">add</span> Create Survey Form
				</a>
			<?php } ?>
		</div>
	</div>
	<ul class="breadcrumb">
		<li>Surveys List</li>
	</ul>

	<div class="surveyListView">	
	<?php if ($this->session->userdata('UserType')!="Parent") { ?>

		<table class="surveys-table">
			<?php foreach ($row->records as $rec) {	?>
				<tr class="rowRadius">
					<td class="suveys-table-data">
						<a href="<?php echo base_url("surveys/getSurveyQuestions/").$rec->id; ?>"><?php echo $rec->title; ?></a>
					</td>
					<td class="suveys-table-data">
						By: <a href="#"><?php echo ucwords(strtolower($rec->createdByName)); ?></a>
					</td>
					<td class="suveys-table-data">
						On: <a href="#"><?php echo date("dS M Y",strtotime($rec->createdAt)); ?></a>
					</td>
					<td class="suveys-table-data">
						<a href="surveys/viewResponses/<?php echo $rec->id; ?>">Responses <span class="badge badge-info"><?php echo $rec->response; ?></span></a>
					</td>
					<td class="suveys-table-data">
						<span class="label label-warning">Draft</span>
					</td>
					<td class="suveys-table-data tableIcon text-right" >
						<a href="surveys/updateSurvey/<?php echo $rec->id; ?>">
							<span class="material-icons-outlined">edit</span>
						</a>
						<a class="deleteIcon" href="#" id="<?php echo $rec->id; ?>">
							<span class="material-icons-outlined">delete</span>
						</a>
					</td>
				</tr>
			<?php } ?>
		</table>
	
	<?php } else { ?>

		<table class="surveys-table">
			<?php 
				foreach ($row->records as $rec) {
			?>
				<tr class="rowRadius">
					<td class="suveys-table-data">
						<a href="<?php echo base_url("surveys/view/").$rec->id; ?>"><?php echo $rec->title; ?></a>
					</td>
					<td class="suveys-table-data">
						By: <a href="#"><?php echo ucwords(strtolower($rec->createdBy)); ?></a>
					</td>
					<td class="suveys-table-data">
						On: <a href="#"><?php echo date("dS M Y H:ia",strtotime($rec->createdAt)); ?></a>
					</td>
				</tr>
			<?php } ?>
		</table>

	<?php } ?>
	</div>
</div>





<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript">
	$(document).on('click','.deleteIcon',function(){
		var id = $(this).attr('id');
		var that = this;
		var url = "<?php echo base_url('Surveys/deleteSurvey/'); ?>/"+id;
		if (confirm('Are you sure You want to Delete?')) {
			$.ajax({
			url : url,
			type : 'GET',
				success : function(response){
					$(that).closest('.surveys-table-row').remove();
				}
			});
    	}
		
	});
</script>
<?php $this->load->view('footer'); ?>
