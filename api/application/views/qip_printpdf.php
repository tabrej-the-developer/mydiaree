<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>QIP</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	.qipsum {
	    color: #444;
		background-color: transparent;
		font-size: 19px;
		display: block;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
     }
	 
	 

	 code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	
	
	.qipstr{
	display: block;
    margin-top: 20px;
				font-style: normal;
font-weight: normal;
font-size: 14px;
line-height: 16px;

color: #001529;
}

.spantitle{
	font-style: normal;
font-weight: 500;
font-size: 16px;
line-height: 21px;
margin-top: 20px;
display: inline-block;
/* identical to box height */


color: #1B2E4B;
}
.spansubtitle {
	font-style: normal;
font-weight: normal;
font-size: 14px;
line-height: 16px;
margin-top: 20px;
display: inline-block;
margin-bottom: 10px;
color: #000000;
}
.exceeding {
    border: 1px solid #D8D8D8;
    background: #0C9600;
    color: #FFFFFF;
				float: right;
				padding: 0 0.5rem;
    display: inline-block;
    margin-top: 20px;

}
.qipkey {
	font-style: normal;
font-weight: 500;
font-size: 18px;
line-height: 21px;
margin-top: 20px;
/* identical to box height */
display: block;
color: #1B2E4B;
}

.qipplan {
	font-style: normal;
font-weight: normal;
font-size: 16px;
line-height: 21px;
/* identical to box height */


color: #1B2E4B;
margin-top: 20px;
/* identical to box height */
display: block;
}
.qiptable {
  border-collapse: collapse;
  width: 100%;
}
.qiptable  th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}


.qiptable  td {
  border: 1px solid #dddddd;
  text-align: left;
}
.qiptable > thead > tr {
	background: rgba(34, 110, 153, 0.1);
}
.qiptable  tr:nth-child(even) {
  background-color: #dddddd;
}
	</style>
</head>
<body>

<div id="container">
	<div id="body">
		<h2 style="text-align: center;"><?php echo $name; ?></h2><br/>
	<?php foreach($previews as $preview) {
			$areaid=$preview->areaId; 
				if(in_array($preview->areaId,$areas)) { ?>
	<span class="qipsum"><?php echo $preview->areaName; ?></span>
	<br/><br/>
	<span class="qipsum">Summary of strengths for <?php echo $preview->areaName; ?></span>
	<br/><br/>
	<span class="qipstr">Strengths:-<?php echo $preview->strength; ?></span>
	  <?php 
	  foreach($preview->standards as $standard){
	   $val= $standard->id; 
	   $v = strval($preview->areaId);
	   $previewAreaId = $preview->areaId;
	   if(isset($sta->$v)  && in_array($standard->id,$sta->$previewAreaId)) { ?>
	  	<span class="spantitle"><?php echo $standard->name.'-'.$standard->about; ?></span><br/>
	  	<span class="spansubtitle">1. Practice is embedded in service operations</span><br/>
  		<?php if(!empty($values)) {  
			   if(!empty($values->$val)){
			    $v=$values->$val;
			    echo $v->val1; 
		?><br/>
	  <?php } 
	   } ?>
	  <span class="spansubtitle">2. Practice is informed by critical reflection</span><br/>
	  <?php if(!empty($values)){  
	  			if(!empty($values->$val)){ 
	  				$v=$values->$val; 
		  				echo $v->val2; 
						echo "<br />";
					} 
				} 
		?>
	  <span class="spansubtitle">3. Practice is shaped by meaningful engagement with families, and/or community</span><br/>
	  <?php if(!empty($values)){   
	  			if(!empty($values->$val)){ 
	  				$v=$values->$val; 
	  				 echo $v->val3; 
	  				 echo "<br />";
	  				  } 
	  				}
				}
			} ?>
	  <?php if(in_array($preview->areaId,$pn)) { ?>
	  <span class="qipkey">Key improvements sought for Quality Area 1</span><br/>
	  <span class="qipplan">Improvement  Plan</span><br/>
	  <table class="qiptable">
		<thead><tr><th style="text-align:center;">Standard/</br>element</th>
		<th style="text-align:right;">Issue identified </br>during self-assessment</th>
		<th style="text-align:right;">What outcome or </br>goal do we seek?</th>
		<th style="text-align:center;">Priority (L/M/H)</th>
		<th style="text-align:right;">How will we get this </br>outcome? (Steps)</th>
		<th style="text-align:center;">Success measure</th><th style="text-align:center;">By when?</th>
		<th style="text-align:center;">Progress notes</th></tr></thead>
		<tbody class="tbodypreview">
			<?php foreach($preview->planes as $plan) { ?>
			<tr >
				<td><?php echo $plan->standard; ?></td>
				<td><?php echo $plan->issue; ?></td>
				<td><?php echo $plan->outcome; ?></td>
				<td><?php echo $plan->priority; ?></td>
				<td><?php echo $plan->outcome_step; ?></td>
				<td><?php echo $plan->measure; ?></td>
				<td><?php echo $plan->by_when; ?></td>
				<td><?php echo $plan->progress; ?></td>
			</tr>
			<?php } ?>
			</tbody></table>
	  <?php } ?>
	<?php } ?>
	<?php } ?>
	</div>
</div>

</body>
</html>
