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
		<h2 style="text-align: center;"><?php echo $plan->roomName; ?></h2><br/>
		<span class="spantitle">Educators</span><br/>
		<?php foreach($planEducators as $educator) { ?>
		<span><?php echo $educator->userName; ?></span><br/>
		<?php } ?>
		<span class="spantitle">Inquiry Topic</span><br/>
		<span><?php echo $plan->inqTopicTitle; ?></span><br/>
		<span class="spantitle">Sustainability Topic</span><br/>
		<span><?php echo $plan->susTopicTitle; ?></span><br/>
		<span class="spantitle">Group Activities to Explore the Inquiry Topic & Sustainability (Discussions, Resources Used, Activities)</span><br/>
		<span class="spansubtitle">Inquiry Topic</span><br/>
		<span><?php echo $plan->inqTopicDetails; ?></span><br/>
	    <span class="spansubtitle">Sustainability Topic</span><br/>
		<span><?php echo $plan->susTopicDetails; ?></span><br/>
		<span class="spantitle">Individual Activities related to the Inquiry Topic & Sustainability (What have we added to our shelves?</span><br/>
		<span class="spansubtitle">Art Experiences:</span><br/>
		<span><?php echo $plan->artExperiments; ?></span><br/>
	    <span class="spansubtitle">Activities available on the Shelf:</span><br/>
		<span><?php echo $plan->activityDetails; ?></span><br/>
		<span class="spantitle">Afternoon Activity Indoor/Outdoor Experiences (3.00 pm - 6.00 pm)</span><br/>
		<span class="spansubtitle">Outdoor Activities related to Inquiry Topic:</span><br/>
		<span><?php echo $plan->outdoorActivityDetails; ?></span><br/>
	    <span class="spansubtitle">Other Experiences:</span><br/>
		<span><?php echo $plan->otherExperience; ?></span><br/>
		
		<span class="spantitle">Special Activities</span><br/>
		<span><?php echo $plan->specialActivity; ?></span><br/>
		
	</div>
</div>

</body>
</html>
