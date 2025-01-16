<?php $data['name']='Survey Response List'; $this->load->view('header',$data); ?>
 

<div class="container">
	
	<div class="row">
		<div class="col-sm-6">
			<div class="title">
				<h1>Observation</h1>
			</div>
			<ul class="breadcrumb">
				<li><a href="#">Application</a></li>
				<li class="active">Observation</li>
			</ul>
		</div>
		<div class="col-sm-6">
			<div class="pull-right">
				<a href="<?php echo base_url('observation/observation_dashboard?type=filter'); ?>" class="btn btn-default">
					<i class="fa fa-filter"></i>
				</a>
				<a href="<?php echo base_url('observation/add'); ?>" class="btn btn-info">
					<i class="fa fa-plus">Add Observation</i>
				</a>
			</div>
		</div>
	</div>
	
 	<div class="row">

 	</div>
</div>
<?php $this->load->view('footer'); ?>