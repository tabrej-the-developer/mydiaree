<!DOCTYPE html>
<html>
<head>
<style>
	//body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}
.form-inline {  
  display: flex;
  flex-flow: row wrap;
  align-items: center;
}
.form-inline label {
  margin: 5px 10px 5px 0;
}
.form-inline input {
  vertical-align: middle;
  margin: 5px 10px 5px 0;
  padding: 10px;
  border: 1px solid #ddd;
}
.form-inline textarea {
  vertical-align: middle;
  margin: 5px 10px 5px 0;
  padding: 10px;
  border: 1px solid #ddd;
}
.form-inline button {
  padding: 10px 20px;
	margin-bottom: 10px;
	float:  right !important;
  background-color: dodgerblue;
  border: 1px solid #ddd;
  color: white;
  cursor: pointer;
}
.form-inline button:hover {
  background-color: royalblue;
}
@media (max-width: 800px) {
  .form-inline input {
    margin: 10px 0;
  }
  
  .form-inline {
    flex-direction: column;
    align-items: stretch;
  }
}
table, th,td {
  border: 1px solid black;
  border-collapse: collapse;
  padding-top: 5px;
}
body{
	 
  padding-left: 50px !important;
  padding-right: 50px !important;
}
</style>
</head>
<body>
<h2 style="text-align: center">CHILD ENROLMENT FORM</h2>
			<p style="text-align: center">Point Cook Montessori Centre</br>
			13-19 Boardwalk Boulevard, Point Cook, Vic 3030</br>
			Ph 03 8353 1299</p>
    <form action="" method="post" class="form-inline" style="width: 100%;display: block;">
			
<table style="width:100%">
	<tr><td style="text-align: center"><h3 style="color: green">SECTION 1: CHILD DETAILS</h3></td></tr>
  <tr>
    <td>
		<label for="email">Full Name:</label>
  <input type="text"  placeholder="" style="width:30%" name="name" value="">
  <label for="pwd">Other name(s) he/she is known by:</label>
  <input type="text" name="other_name" style="width:30%" value="">
  
	</td>
  </tr>
  <tr>
    <td>
		<label for="email">Date of Birth:</label>
  <input type="date"  name="dob"  style="width:30%"  value="">
  <label for="pwd">Language he/she speaks:</label>
  <input type="text" name="language" style="width:30%" value="">
  </br>
  <label for="email">Country of Birth:</label>
  <input type="text" name="country_of_birth"  style="width:30%"  value="">
  <label for="pwd">Religion:</label>
  <input type="text" name="religion" style="width:30%" value="">
  
	</td>
  </tr>
  <tr>
	<td>
		<label for="email">Gender:</label>
  <input type="radio"  name="gender"    value="Female">Female
  <input type="radio"  name="gender"    value="Male">Male
  <input type="radio"  name="gender"    value="Other">Other
	</td>
  </tr>
  <tr>
	<td>
		<label for="email">Home Address:</label>
        <textarea name="home_address" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
	</td>
  </tr>
  <tr>
	<td>
		<label for="email">Family Cultural Background / Special Considerations:</label>
		<input type="text" name="family_cultural_background" style="width:20%" value="">
		<label for="email">Is the child of an Aboriginal or Torres Strait Islander origin?</label>
		<input type="radio"  name="child_aboriginal"    value="Yes">Yes
        <input type="radio"  name="child_aboriginal"    value="No">No
	</td>
  </tr>
	<tr>
		<td><label for="email">Has your child attended or are they currently attending childcare?</label>
		<input type="text" name="child_attended" style="width:30%" value=""></td>
	</tr>
	<tr><td ><h3 style="text-align: center;color: green">SECTION 2: PARENT/GUARDIAN INFORMATION</h3>
	<p>A <b>parent</b> includes a guardian of the child and a person with parental responsibility for the child under a decision or courtorder.
	</br><b>Parental responsibility</b> is a term defined under section 61C of the Family Law Act 1975, which means “all the duties, powers,responsibilities and authority which, by law, parents have in relation to children”</p></td></tr>
  <tr><td ><h5 style="text-align: center">Parent/Guardian No.1</h5></td></tr>
  <tr>
    <td>
		<label for="email">Full Name:</label>
  <input type="text"  placeholder="" style="width:35%" name="parent_name" value="">
  <label for="pwd">Relation to child:</label>
  <input type="text" name="relation_to_child" style="width:35%" value="">
  
	</td>
  </tr>
  <tr>
    <td>
		<label for="email">Home Address:</label>
		<textarea name="parent_home_address" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
  
  <label for="pwd">Does the child live with this parent?</label>
  <input type="text" name="child_live_with_parent" style="width:30%" value="">
  
	</td>
  </tr>
   <tr>
    <td>
		<label for="email">Contact Details:</label></br>
		<label for="email">(H):</label>
  <input type="text"  placeholder="" style="width:25%" name="h" value="">
  <label for="pwd">(W):</label>
  <input type="text" name="w" style="width:25%" value="">
  <label for="pwd">(M):</label>
  <input type="text" name="m" style="width:25%" value="">
	</td>
  </tr>
   <tr>
    <td>
		<label for="email">Email Address:</label>
  <input type="text"  placeholder="" style="width:70%" name="email_address" value="">
  
	</td>
  </tr>
   <tr>
    <td>
		<label for="email">Occupation:</label>
		<textarea name="occupation" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
  
  <label for="pwd">Work Address:</label>
  <textarea name="work_address" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
  
  
	</td>
   </tr>
    <tr><td ><h5 style="text-align: center">Parent/Guardian No.2</h5></td></tr>
  <tr>
    <td>
		<label for="email">Full Name:</label>
  <input type="text"  placeholder="" style="width:35%" name="parent_name1" value="">
  <label for="pwd">Relation to child:</label>
  <input type="text" name="relation_to_child1" style="width:35%" value="">
  
	</td>
  </tr>
  <tr>
    <td>
		<label for="email">Home Address:</label>
		 <textarea name="parent_home_address1" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
  
  <label for="pwd">Does the child live with this parent?</label>
  <input type="text" name="child_live_with_parent1" style="width:30%" value="">
  
	</td>
  </tr>
   <tr>
    <td>
		<label for="email">Contact Details:</label></br>
		<label for="email">(H):</label>
  <input type="text"  placeholder="" style="width:25%" name="h1" value="">
  <label for="pwd">(W):</label>
  <input type="text" name="w1" style="width:25%" value="">
  <label for="pwd">(M):</label>
  <input type="text" name="m1" style="width:25%" value="">
	</td>
  </tr>
   <tr>
    <td>
		<label for="email">Email Address:</label>
  <input type="text"  placeholder="" style="width:70%" name="email_address1" value="">
  
	</td>
  </tr>
   <tr>
    <td>
		<label for="email">Occupation:</label>
		<textarea name="occupation1" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
  
  <label for="pwd">Work Address:</label>
  <textarea name="work_address1" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
  
  
	</td>
   </tr>
   <tr><td ><h3 style="text-align: center;color: green">SECTION 3: CHILD CARE SUBSIDY</h3></td></tr>
   <tr><td>
	<p>The Child Care Subsidy (CCS) is a subsidy from the Australian Government that offers different levels of financial
	assistance to help cover the cost of childcare for eligible families and will be paid directly to services. How much you 
	receive depends on your individual circumstances. Amiga Montessori is under no obligation to estimate or reduce the
	fees for the families of children enrolled at the centre in advance OR to determine whether they qualify for a fee reduction
	through Child Care Subsidy. It is the responsibility of the parent / guardian to apply for CCS</p></br>
	<span style="float:left;"><b>Will you be claiming CCS?</b></br>
	<b>Yes</b>: Please fill out the below details
	<b>No</b>: Please continue to Section 9.</span>
    <span style="float:right;"><b>For more information please visit:</b></br>
	<a href="www.familyassist.gov.au">www.familyassist.gov.au</a></br>
	<a href="www.education.gov.au/ChildCarePackage">www.education.gov.au/ChildCarePackage</a></br>
	<a href="https://my.gov.au">https://my.gov.au</a>
	</span></br></br></br>
	<p style="text-align: center"><b>If claiming CCS please ensure that the following details are provided accurately:</b></p>
   </td></tr>
   <tr><td ><h5 style="text-align: center">Parent Information</h5></td></tr>
   <tr>
    <td>
		<label for="email">CRN of parent claiming CCS:</label>
  <input type="text"  placeholder="" style="width:15%" name="parent_crn1" value="">
  <input type="text"  placeholder="" style="width:15%" name="parent_crn2" value="">
  <input type="text"  placeholder="" style="width:15%" name="parent_crn3" value="">
  <input type="text"  placeholder="" style="width:15%" name="parent_crn4" value="">
  
	</td>
  </tr>
  <tr>
    <td>
		<label for="email">Date of birth of parent claiming CCS:</label>
  <input type="date"  placeholder="" style="width:30%" name="paren_dob_ccs" value="">
  
	</td>
  </tr>
  <tr>
    <td>
		<label for="email">Full name and surname of parent claiming CCS:</label>
  <input type="text"  placeholder="" style="width:15%" name="parent_surname" value="">
	</td>
  </tr>
  <tr><td ><h5 style="text-align: center">Child Information</h5></td></tr>
   <tr>
    <td>
		<label for="email">CRN of child claiming CCS:</label>
  <input type="text"  placeholder="" style="width:15%" name="child_crn1" value="">
  <input type="text"  placeholder="" style="width:15%" name="child_crn2" value="">
  <input type="text"  placeholder="" style="width:15%" name="child_crn3" value="">
  <input type="text"  placeholder="" style="width:15%" name="childt_crn4" value="">
  
	</td>
  </tr>
  <tr>
    <td>
		<label for="email">Date of birth of child claiming CCS:</label>
  <input type="date"  placeholder="" style="width:30%" name="child_dob_ccs" value="">
  
	</td>
  </tr>
  <tr>
    <td>
		<label for="email">Full name and surname of child claiming CCS:</label>
  <input type="text"  placeholder="" style="width:15%" name="child_surname" value="">
	</td>
  </tr>
  <tr><td ><h3 style="text-align: center;color: green">SECTION 4: BOOKING INFORMATION</h3>
  <p>*All sessions are subject to conditions and availability. Late collection fees apply to all sessions and will be charged to your account</p></td></tr>
  <tr>
	<td>
		<table style="width:100%">
		<tr>
	   <td><b>Session</b></td>
	   <td><b>Session Attendance</b></td>
	   <td><b>Daily Fee</b></td>
	   <td colspan="5"><b>Booked days care will be provided for:</b>(Please √ applicable)</td>
	 </tr>
		<tr>
			<td>Full Day</br>11 Hours: Children 24-36 months</td>
			<td>7am - 6pm</td>
			<td>$136.00</td>
			<td><input type="checkbox" name="full_day_months_monday" value="Monday">Monday</td>
			<td><input type="checkbox" name="full_day_months_tuesday" value="Tuesday">Tuesday</td>
			<td><input type="checkbox" name="full_day_months_wednesday" value="Wednesday">Wednesday</td>
			<td><input type="checkbox" name="full_day_months_thursday" value="Thursday">Thursday</td>
			<td><input type="checkbox" name="full_day_months_friday" value="Friday">Friday</td>
		</tr>
		<tr>
			<td>Full Day</br>11 Hours: Children 3-6 yrs</td>
			<td>7am - 6pm</td>
			<td>$135.00</td>
			<td><input type="checkbox" name="full_day_yrs_monday" value="Monday">Monday</td>
			<td><input type="checkbox" name="full_day_yrs_tuesday" value="Tuesday">Tuesday</td>
			<td><input type="checkbox" name="full_day_yrs_wednesday" value="Wednesday">Wednesday</td>
			<td><input type="checkbox" name="full_day_yrs_thursday" value="Thursday">Thursday</td>
			<td><input type="checkbox" name="full_day_yrs_friday" value="Friday">Friday</td>
		</tr>
		<tr>
			<td>Mid Session</br>9 Hours: Children 24-36 months</td>
			<td>8am - 5pm</td>
			<td>$118.00</td>
			<td><input type="checkbox" name="mid_session_months_monday" value="Monday">Monday</td>
			<td><input type="checkbox" name="mid_session_months_tuesday" value="Tuesday">Tuesday</td>
			<td><input type="checkbox" name="mid_session_months_wednesday" value="Wednesday">Wednesday</td>
			<td><input type="checkbox" name="mid_session_months_thursday" value="Thursday">Thursday</td>
			<td><input type="checkbox" name="mid_session_months_friday" value="Friday">Friday</td>
		</tr>
		<tr>
			<td>Mid Session</br>9 Hours: Children 3-6 yrs</td>
			<td>8am - 5pm</td>
			<td>$117.00</td>
			<td><input type="checkbox" name="mid_session_yrs_monday" value="Monday">Monday</td>
			<td><input type="checkbox" name="mid_session_yrs_tuesday" value="Tuesday">Tuesday</td>
			<td><input type="checkbox" name="mid_session_yrs_wednesday" value="Wednesday">Wednesday</td>
			<td><input type="checkbox" name="mid_session_yrs_thursday" value="Thursday">Thursday</td>
			<td><input type="checkbox" name="mid_session_yrs_friday" value="Friday">Friday</td>
		</tr>
		<tr>
			<td>Sessional 6 Hours</br>Kindergarten Program attendance only</td>
			<td>9am - 3pm</td>
			<td>$83.00</td>
			<td><input type="checkbox" name="sessional_monday" value="Monday">Monday</td>
			<td><input type="checkbox" name="sessional_tuesday" value="Tuesday">Tuesday</td>
			<td><input type="checkbox" name="sessional_wednesday" value="Wednesday">Wednesday</td>
			<td><input type="checkbox" name="sessional_thursday" value="Thursday">Thursday</td>
			<td><input type="checkbox" name="sessional_friday" value="Friday">Friday</td>
		</tr>
	 </table>
 
	</td>
  </tr>
  <tr>
	<td>
		<label for="email">Date on which care will commence (does not included orientation sessions):</label>
        <input type="date"  placeholder="" style="width:30%" name="date_commence" value="">
  
	</td>
  </tr>
  <tr>
	<td>
		<label for="email">Parent Signature: __________________________</label>
  
	</td>
  </tr>
   <tr>
	<td>
		<label for="email">Dates for arranged orientation sessions: 1) </label>
        <input type="date"  placeholder="" style="width:20%" name="date_session1" value="">
		<input type="date"  placeholder="" style="width:20%" name="date_session2" value="">
  
	</td>
  </tr>
   <tr><td ><h3 style="text-align: center;color: green">SECTION 5: COURT ORDERS/PARENTING ORDERS OR PARENTING PLANS RELATING TO THE CHILD</h3>
   <p>According to the National Regulations 2011- (160), the centre must be informed & have record of details of any court orders,
   parenting order or parenting plans relating to residence, child’s contact with parents or other person, powers, duties,
   responsibilities or authorities of any person in relation to the child or access to the child.</p>
   </td>
   </tr>
   <tr>
	<td>
		<b>Parenting order</b>means a parenting order within the meaning of section 64B(1) of the Family Law Act 1975 (commonwealth)</br>
		<b>Parenting Plan</b>means a parenting plan within the meaning of section 63C (1) of the Family Law Act 1975 includes a registered parenting plan within the meaning of section 63C (6) of that Act.
		<b>Are there any court orders/parenting orders or parenting plans relating to the powers & responsibilities of the parents in relation to the child or access to the child?</b>
		</br><input type="checkbox" name="court_orders_no" value="No">No
		</br><input type="checkbox" name="court_orders_yes" value="Yes">Yes
		<p>1. Please describe the orders and provide the contact details of any person given powers, duties, responsibilities or orauthorities</p>
		<label for="email">Name:</label>
        <input type="text"  placeholder="" style="width:40%" name="duties_name" value="">
		<label for="email">Contact: </label>
        <input type="text"  placeholder="" style="width:40%" name="duties_contact" value=""></br>
		Do these court orders/parenting orders/parenting plan change the powers of the parent or guardian to:
		</br><input type="checkbox" name="consent_medical" value="Consent to the medical treatment of the child">Consent to the medical treatment of the child;
		</br><input type="checkbox" name="request_administration" value="Request or permit the administration of medication to the child">Request or permit the administration of medication to the child;
		</br><input type="checkbox" name="regulation_160" value="The powers, duties, responsibilities or authorities of any person in relation to the child or access to the child (regulation 160(3)(c))">The powers, duties, responsibilities or authorities of any person in relation to the child or access to the child (regulation 160(3)(c));
	    </br><input type="checkbox" name="other_regulation_160" value="The child’s residence of the child’s contact with a parent or other person (regulation 160(3)(d))">The child’s residence of the child’s contact with a parent or other person (regulation 160(3)(d)).
		</br>2. Original order/s to sight by and copy attached;
		</br>Staff Name & Signature:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Date:
	</td>
   </tr>
   <tr>
	<td>
		<label for="email">Restraining/ domestic violence order:</label>
        <input type="checkbox"  placeholder=""  name="restraining_yes" value="Yes">Yes
		<input type="checkbox"  placeholder=""  name="restraining_no" value="No">No
		</br>
		<u>(If yes, original copy must be sighted by centre staff and a copy must be supplied to & attached to enrolment before care can commence)</u>
	   </br>Restraining/domestic violence order sighted by and copy attached:
	   </br>Staff Name & Signature:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Date:
	</td>
   </tr>
   <tr><td ><h3 style="text-align: center;color: green">SECTION 6: EMERGENCY CONTACTS/ AUTHORISED NOMINEES</h3>
   <p>
	<b>Note:</b> It is the responsibility of the parent/guardian to inform the centre management of any updates or changes to be made
	to this list to ensure that the centre has the correct details. The list of authorised nominees may be changed at any time by
	<b>written</b> request from the parent/ guardian.
   </p>
   </td></tr>
   <tr>
	<td>
		As the parent/guardian of the child, you are required to nominate a person(s) who you give consent/permission to pick up
		your child from the centre, be notified of illness/emergency, authorise educators to bring the child out of the service,
		consent to medical treatment and authorisation to seek emergency medical treatment for the child from a registered
		medical practitioner, hospital or ambulance service; and/or transportation of the child by an ambulance service. Please
		complete their information below.
	</td>
   </tr>
   <tr>
	<td style="text-align: center"><b>NOMINEE No. 1</b></td>
   </tr>
   <tr>
    <td>
		<label for="email">Full Name:</label>
  <input type="text"  placeholder="" style="width:35%" name="nominee_name" value="">
  <label for="pwd">Relation to child:</label>
  <input type="text" name="nominee_child" style="width:35%" value="">
  
	</td>
  </tr>
     <tr>
    <td>
		<label for="email">Home Address:</label>
  <input type="text"  placeholder="" style="width:40%" name="nominee_home_address" value="">
  
	</td>
  </tr>
   <tr>
    <td>
		<label for="email">Contact Details:</label></br>
		<label for="email">(H):</label>
  <input type="text"  placeholder="" style="width:25%" name="nominee_h" value="">
  <label for="pwd">(W):</label>
  <input type="text" name="nominee_w" style="width:25%" value="">
  <label for="pwd">(M):</label>
  <input type="text" name="nominee_m" style="width:25%" value="">
	</td>
  </tr>
   <tr>
	<td>
		<label for="email">Collect your child from the centre on your behalf:</label>
       <input type="checkbox"    name="collect_your_child_yes" value="Yes">Yes
	   <input type="checkbox"    name="collect_your_child_no" value="No">No
	   </br><label for="email">Be notified of an emergency involving your child:</label>
       <input type="checkbox"    name="emergency_child_yes" value="Yes">Yes
	   <input type="checkbox"    name="emergency_child_No" value="No">No
	   </br><label for="email">Authorise an educator to take your child outside the education care service:</label>
       <input type="checkbox"    name="education_care_service_yes" value="Yes">Yes
	   <input type="checkbox"    name="education_care_service_no" value="No">No
	   </br><label for="email">Consent to medical treatment of your child:</label>
       <input type="checkbox"    name="medical_treatment_yes" value="Yes">Yes
	   <input type="checkbox"    name="medical_treatment_no" value="No">No
	   </br><label for="email">Authorised for the administration of medication to be given to your child:</label>
       <input type="checkbox"    name="auth_admin_yes" value="Yes">Yes
	   <input type="checkbox"    name="auth_admin_no" value="No">No
	   </br><label for="email">Consent to authorise transportation of your child by an ambulance service in case of an emergency:</label>
       <input type="checkbox"    name="auth_trans_yes" value="Yes">Yes
	   <input type="checkbox"    name="auth_trans_no" value="No">No
     </td>
   </tr>
   <tr>
	<td style="text-align: center"><b>Doctor/ Registered Medical Practitioner/ Medical Centre</b></td>
   </tr>
    <tr>
    <td>
		<label for="email">Full Name:</label>
  <input type="text"  placeholder="" style="width:40%" name="doctor_name" value="">
  
	</td>
	</tr>
	<tr>
	<td>
		<label for="email">Address & Phone Number:</label>
   <textarea name="doctor_address" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
	</td>
  </tr>
	 <tr>
    <td>
		<label for="email">Medicare Number:</label>
  <input type="text"  placeholder="" style="width:40%" name="medicare_number" value="">
  
	</td>
	</tr>
	 <tr>
    <td>
		<label for="email">Health Card:</label></br>
		<label for="email">Card Number:</label>
        <input type="text"  placeholder="" style="width:15%" name="card_number" value="">
		<label for="email">Start Date:</label>
        <input type="date"  style="width:15%" name="start_date" value="">
		<label for="email">End Date:</label>
        <input type="date"  style="width:15%" name="end_date" value="">
  
	</td>
	</tr>
	  <tr>
    <td>
		<label for="email">Ambulance Membership Number:</label>
  <input type="text"  placeholder="" style="width:40%" name="amb_number" value="">
  
	</td>
	</tr>
	  <tr>
		<td>Is the child currently attending or has previously attended:
		</br><input type="checkbox"  name="counsellor" value="Counsellor/ psychologist">Counsellor/ psychologist
		<input type="checkbox"  name="occ_therapy" value="Occupational Therapy">Occupational Therapy
		<input type="checkbox"  name="paediatrician" value="Paediatrician">Paediatrician
		<input type="checkbox"  name="approved_ndis" value="Approved NDIS">Approved NDIS
		</br><input type="checkbox"  name="speech_therapy" value="Speech Therapy">Speech Therapy
		<input type="checkbox"  name="dietician" value="Dietician">Dietician
		<input type="checkbox"  name="specialist" value="Specialist">Specialist
		<input type="checkbox"  name="other" value="Other">Other
		</br>
		<label for="email">If yes, please provide details:</label>
        <input type="text"  placeholder="" style="width:40%" name="if_yes" value="">
		</br>
		<label for="email">Child Health Record:</label>
		<input type="checkbox"  name="child_health_not_available" value="Not Available">Not Available
		<input type="checkbox"  name="child_health_sighted" value="Sighted">Sighted
		<input type="checkbox"  name="child_health_sighted_by" value="Sighted By">Sighted by ____________________
		</td>
	  </tr>
	  <tr>
		<td>
			Please list details of any specific health care needs of the child including any medical condition; allergies or whether your
			child have been diagnosed as at risk of anaphylaxis
			</br>
			<u><b>Specific Healthcare Needs</b></u>Reg 162.
			</br>
			<b>Allergies :</b> Does your child have any allergies: Yes <input type="checkbox"  name="allergies_yes" value="Yes">
			No <input type="checkbox"  name="allergies_no" value="No">
			</br>
			<p>
				If <b>yes</b> please provide a copy of a valid allergy action plan completed and signed by a medical practitioner; risk
				minimisation plan as well as a communication plan. Copies of these can be requested from the office. If your child
				requires any medication as stated on the action plan, this must be supplied to the centre as well. Your child will not be
				allowed to attend the centre without their prescribed medication.
			</p>
			<label for="email">Have your child been diagnosed of being at risk of <b>anaphylaxis</b>:</label>
			Yes <input type="checkbox"  name="anaphylaxis_yes" value="Yes">
			No <input type="checkbox"  name="anaphylaxis_no" value="No">
			</br>
			<p>
				If <b>yes</b> please provide a copy of a valid anaphylaxis action plan completed and signed by a medical practitioner; risk
				minimisation plan as well as a communication plan. Copies of these can be requested from the office. An Epinephrine
				Autoinjector (such as an EpiPen jnr or Anapen) must be supplied to the centre. Any child diagnosed as being at risk of
				anaphylaxis will not be allowed to attend the centre without their prescribed medication.
			</p>
			<label for="email">Have your child been diagnosed with <b>Asthma?</b></label>
			Yes <input type="checkbox"  name="asthma_yes" value="Yes">
			No <input type="checkbox"  name="asthma_no" value="No">
			</br>
			<p>
				If <b>yes</b> please provide a copy of a valid asthma action plan completed and signed by a medical practitioner; risk
				minimisation plan as well as a communication plan. Copies of these can be requested from the office. If your child
				requires any medication as stated on the action plan, this must be supplied to the centre as well. Your child will not be
				allowed to attend the centre without their prescribed medication.
			</p>
			<label for="email"><b>Specific Healthcare Needs:</b> Have your child been diagnosed with any other medical condition/ health care need that</label>
			are relevant to the care & education of your child? (e.g. Epilepsy, Diabetes etc.)
			Yes <input type="checkbox"  name="helathcare_yes" value="Yes">
			No <input type="checkbox"  name="helathcare_no" value="No">
			</br>
			<p>
				If <b>yes</b> please provide a copy of a valid action plan completed and signed by a medical practitioner; risk minimisation plan
				as well as a communication plan. Copies of these can be requested from the office. If an action plan is <b>not</b> applicable,
				please complete all the details of the healthcare need/ medical condition on pg. 10. Any child diagnosed with a medical
				condition with prescribed medication will not be allowed to attend the centre without their medication.
			</p>
			<label for="email"><b>Dietary Restrictions:</b> Does the child have any specific dietary requirements?</label>
			Yes <input type="checkbox"  name="dietary_yes" value="Yes">
			No <input type="checkbox"  name="dietary_no" value="No">
			</br>
			If yes please refer to and complete page 13
			
		</td>
	  </tr>
	  <tr>
		<td><h3 style="text-align: center">OFFICE USE ONLY</h3>
		<p>If the service is aware that the child has a specific healthcare need, allergy or other relevant medical condition as identified
		 above, has a copy of the service’s medical conditions policy been provided to the parent or guardian of the child?</p>
		    Yes <input type="checkbox"  name="service_yes" value="Yes">
			No <input type="checkbox"  name="service_no" value="No">
			N/A <input type="checkbox"  name="service_na" value="N/A">
			</br>
			<p>Has a risk management plan and medical condition communication plan for the child been completed in consulation with
			the child’s parents/ guardian and educators?</p>
			 Yes <input type="checkbox"  name="risk_yes" value="Yes">
			No <input type="checkbox"  name="risk_no" value="No">
			N/A <input type="checkbox"  name="risk_na" value="N/A">
			</br>
			<p>Have parents supplied an up to date (no older than 6 months or prior to date of review) action plan Or a ‘medical condition
			support plan’ (when an action plan is not required) along with prescribed medication? (*any medication requires an action plan)</p>
			Yes <input type="checkbox"  name="parents_yes" value="Yes">
			No <input type="checkbox"  name="parents_no" value="No">
			N/A <input type="checkbox"  name="parents_na" value="N/A">
			</br>
			<label for="email">Staff Name:</label>
			<input type="text"  name="staff_name" value="">
			<label for="email">Position:</label>
			<input type="text"  name="position" value="">
			<label for="email">Date:</label>
			<input type="date"  name="staff_date" value="">
			<br>
			Signature:____________________________
		</td>
	  </tr>
	  <tr>
		<td style="text-align: center"><h3 style="color: green">SECTION 8: CHILD IMMUNISATION RECORD & DETAILS</h3></td>
	  </tr>
	  <tr>
		<td>
			<p>On 28 February 2018, the <u><b>‘No Jab, No Play’</b></u> legislation was amended so that an Immunisation History Statement from
		    the Australian Immunisation Register (AIR) is the only form of documentation accepted for the purpose of enrolling in
			any early childhood education and care service. Previous forms of documentation, for example a letter from a GP or
			local council, are no longer accepted.</p>
			<p>For a copy of your child’s Immunisation History Statement, please log onto your myGov account OR call the AIR on
			phone 1800 653 809 OR visit a Medicare or Centrelink office</p>
			</br>
			<p><b>16 - Week Grace Period:</b> Some families experiencing vulnerability and disadvantage may face difficulties accessing
			immunisation services and documentation and as such may need additional time and help. Children who fall within any
			of the following categories are eligible for the grace period: Children experiencing vulnerability or disadvantage;
			Aboriginal and/or Torres Strait Islander Children; Children known to child protection; Children in the care of an adult who
			is not their parent; Children in emergency care; Evacuated children following an emergency. For more information please
			visit <a href="https://www2.health.vic.gov.au/">https://www2.health.vic.gov.au/</a> or speak to the centre manager.
			</p>
			<label for="email">Has your child been Immunised?</label>
			<input type="checkbox"  name="child_imm_yes" value="Yes">Yes
			<input type="checkbox"  name="child_imm_no" value="No">No</br>
			<label for="email">Is your child eligible for the 16 week grace period?</label>
			<input type="checkbox"  name="grace_period_yes" value="Yes">Yes
			<input type="checkbox"  name="grace_period_no" value="No">No</br>
			<label for="email">Immunisation History Statement sighted by <b>and</b> copy attached:</label>
			<input type="text"  name="history_statement" value=""></br>
			<label for="email">Name:</label>
			<input type="text"  name="immunisation_name" value="">
			<label for="email">Position:</label>
			<input type="text"  name="immunisation_position" value="">
			<label for="email">Date:</label>
			<input type="date"  name="immunisation_date" value="">
		</td>
	  </tr>
	  <tr>
		<td>
			<p>In some cases when there is an outbreak of a vaccine preventable disease, unimmunised children will be excluded from the Education
			and Care Service as per the period of exclusion of contacts recommended by the National Health & Medical Research Council. The
			exclusion periods table can be found at <a href="http://ideas.health.vic.gov.au/guidelines/school-exclusion-table.asp"></a> </p>
		</td>
	  </tr>
	<tr>
		<td style="text-align: center"><h3 style="color: green">SECTION 9: OTHER INFORMATION</h3></td>
	  </tr>
	<tr><td>
		<p>If there is any other information relating to the child that staff should know about (excessive fears, anxiety, behaviour
		management etc.) Please provide details:</p>
	</td></tr>
	<tr>
		<td style="text-align: center"><h3 style="color: green">SECTION 10: CONSENT TO EMERGENCY MEDICAL TREATMENT</h3></td>
	  </tr>
	<tr>
		<td>
			<p>
				I <input type="text"  name="print_full_name" value=""> (Please print full name) a person with lawful authority of the child referred to in this enrolled form;
			</p>
			<p>• Declare that all medical & health information provided in this enrolment form relating to the child is true & correct;</p>
		   <p>• Consent where it is in the best interest of my child for the obtained medical & health information of my child to be made
		   available to staff;</p>
		   <p>
			• Declare that the provided ‘Medical Condition Support Plan’ & ‘Action Plan’ relating to the child in this enrolment form is
			true, correct, signed & authorised by a registered medical practitioner;
		   </p>
		   <p>• Understand that I will not be allowed to leave the child in the care of the staff without a required action plan and/or medical
		   condition support plan; communication plan; risk minimisation plan and prescribed medication in place as set out in the
		   centres ‘Medical Conditions Policy’</p>
		   <p>
			• Understand that it is my obligation to ensure that the child(s) Medical Condition Support Plan/ Action Plan (no older than 6
			months prior to date of review at time of enrolment) is revised annually by a registered medical practitioner & that I will
			provide the centre with a new & updated copy of the ‘Medical Condition Support Plan’/ Action Plan’ as signed & authorised
			by a registered medical practitioner;
		   </p>
		   <p>• Participate in the development of a risk minimisation as well as communication plan for the child in relation to their specific
		   health care need, allergy or any other diagnosed medical condition.</p>
		   <p>
			• Agree to collect the child from the centre if the child becomes unwell at the centre and is informed of this by the centre;
		   </p>
		   <p>• Understand that it is my responsibility to check the expiry dates of the child(s) medication & to supply new medication at
		   my own cost.</p>
		   <p>• Agree that it is my responsibility to inform the centre of ANY changes to the child(s) health or medical information including
		   immunisation records as soon as possible;</p>
		   <p>• Agree & understand that it is my responsibility to inform the centre if my child has been diagnosed with an illness listed on
		   the ‘communicable diseases table’. I agree to <b>NOT</b> send my child to the centre for the period & conditions specified on the
		   communicable diseases & exclusion table <b>AND</b> understand that my child will only be allowed back in the centre when a
		   medical certificate is produced stating by a registered medical practitioner that the child is no longer infectious.</p>
		   <p>• Update my child’s Action plan & ‘Medical Condition Support Plan’ annually or at the request of the approved provider/
		   nominated supervisor</p>
		   <p>• I authorise the approved provider, the nominated supervisor or educator to seek medical treatment for my child, be it from
		   a registered medical practitioner, hospital or transportation by an ambulance service and agree to meet any expenses
		   including ambulance costs, incurred.</p>
		   <label for="email">Full First & Last Name:</label>
			<input type="text"  name="full_first_name" style="width: 40%" value="">
			</br></br>
			Signature: _________________________________________</br></br>
			Date: _____________________
		</td>
	</tr>
	<tr>
		<td ><h3 style="text-align: center;color: green">SECTION 11: AUTHORISATION & CONSENT</h3>
		<p>*Information in this section will be shared with educators</p>
		</td>
	</tr>
	<tr><td><b>Please indicate by circling ‘I agree ‘ or ‘I disagree’, whether you give your consent for the following:</b></br>
	<p>• Staff may apply sunscreen to my child when necessary. (If no: parents MUST supply their own, labelled with the child’s
	details. This will be accepted as authorisation that staff may apply the sunscreen when necessary).</p>
	<input type="checkbox"  name="staff_apply_agree" value="I Agree">I Agree
	<input type="checkbox"  name="staff_apply_disagree" value="I Disagree">I Disagree
	</td></tr>
	<tr>
		<td>
			<p>• My child’s photograph (including name & age) may be taken in the classroom or outside in the playground for the purpose
			of observation records or placed in their file/ portfolio documenting the child’s progress & development.</p>
			<input type="checkbox"  name="child_photograph_agree" value="I Agree">I Agree
	        <input type="checkbox"  name="child_photograph_disagree" value="I Disagree">I Disagree
		</td>
	</tr>
	<tr>
		<td>
			<p>• My child’s photograph may be taken in the classroom or outside in the playground for the purpose of display within- or
			newsletters from the centre- or Facebook-Parents Closed Group. The name & age of the child may be included.</p>
			<input type="checkbox"  name="child_photograph_classroom_agree" value="I Agree">I Agree
	        <input type="checkbox"  name="child_photograph_classroom_disagree" value="I Disagree">I Disagree
		</td>
	</tr>
	<tr>
		<td>
			<p>• My child’s photograph may be taken in the classroom or outside in the playground for the purpose of display and use in
			any advertising, marketing or promotion undertaken by AMIGA using any advertising, marketing or promotional medium,
			including but not limited to: AMIGA’s Facebook pages-Public, AMIGA’s website, print media, electronic media, promotional
			boards, promotional banners, promotional flyers and any other form of advertising marketing or promotion undertaken
			by AMIGA.</p>
			<input type="checkbox"  name="child_photograph_classroom_amiga_agree" value="I Agree">I Agree
	        <input type="checkbox"  name="child_photograph_classroom_amiga_disagree" value="I Disagree">I Disagree
		</td>
	</tr>
	<tr>
		<td>
			<p>
				• My child may take part in incursions or in-house activities presented by a person(s) approved by the centre under the
				supervision of staff members. (Notice of such an event will be given in advance).
			</p>
			<input type="checkbox"  name="child_incursions_agree" value="I Agree">I Agree
	        <input type="checkbox"  name="child_incursions_disagree" value="I Disagree">I Disagree
		</td>
	</tr>
	<tr>
		<td ><h3 style="text-align: center;color: green">SECTION 12: DECLARATION</h3>
	
		</td>
	</tr>
	<tr>
		<td>
			I <input type="text"  name="section12_full_name"  value=""> (Please print full name & surname), a person with lawful authority of the child
		    I <input type="text"  name="section12_child_full_name"  value=""> (Please print full name & surname of the child) referred to in this enrolment form;
			<p>
				• Declare that all information provided in the ‘enrolment form’, the ‘action plans & ‘nutrition and dietary guidelines’ & the
				‘Medical Condition support plan’ forms are true & correct.
			</p>
			<p>• Understand that it is my responsibility to ensure that management are informed of any changes relating to information
			obtained in the enrolment form’, the ‘nutrition & dietary guidelines’ & the ‘Medical Condition Support Plan, or any other
			 information which is in the best interest of the child while in the care of staff.</p>
			<p>• Acknowledge & agree to abide by and co-operate with the principles and policies & procedures outlined in the parent handbook</p>
			<p>• Acknowledge that I have been informed of the location of important information such as emergency management plan, 
			location of first-aid kits, education & care services national regulations 2011, education & care services national law act 2012
			</p>
			<p>• I/we agree to the centre or its assistants arranging for provision of medical treatment for the said child including
			administration of medication (including administration of paracetamol, Ventolin or the EpiPen) or other medications as
			considered necessary in case of emergency (this acting in the best interest of the child) or where I/we, or other nominated
			persons, cannot be readily contacted. </p>
			<p>• We understand all aspects and conditions relating to the fees & payment policy & agree that:</br>
			- My child’s enrolment will not be confirmed without payment of the $250.00 Enrolment Fee.
			- Accept & acknowledge that the Enrolment Fee comprises of $50, Non-refundable administration fee; and a further
			$200 bond which will be kept and refunded when 4 weeks notice has been given for the withdrawal of a child from
			the service and all fees have been paid up to date up to the end of the 4 weeks notice period. </br>
			- AMIGA reserves its rights to seek legal council to pursue any outstanding debt and all costs associated with the
			recovery of these funds will be carried by the registered parent.</br>
			- Payment of fees is accepted by direct debit only
			</p>
			<p>• Full-time and sessional bookings and attendances are subject to availability and conditions as set out in the enrolment
			policy.</p>
			<p>• Late collection fees apply to all sessions/ booking types and will be charged to your account.</p>
			<p>• Any Discounts on fees are subject to conditions set out in the fees and payment policy.</p>
			<p>• It is my / our responsibility to apply through the FAO for CCS & that AMIGA Montessori is under no obligation to pass on
			any fee reductions unless authorised to do so via CRN.</p>
			<p>• I / we are required to provide 4 weeks written notice when completely withdrawing my/our child/children from a position
			at the centre. Fees will be charged up to the end of the four weeks from the date at which notice was received in writing,
			whether or not the child has attended the Centre during those 4 weeks. No exceptions will be made. </p>
			<p>• We do not allow for extra additional days to make up for previous days missed due to any absence for any reason.</p>
			<p>• I / we will be invoiced for everyday the child is scheduled & booked to attend including all gazetted Public Holidays.</p>
			<p>• If a child is absent for a period longer than 2 weeks & staff have not been notified & the centre manager cannot contact a
			child’s parent or guardian, the child’s place will be withdrawn as we will assume they will not be returning.</p>
			<p>• Understand arrangements & my/our responsibility in regards to overdue accounts & dishonoured payments.</p>
			<p>• I/we understand that fee levels are set by directors and management according to the centre’s required income, budget
			and expenses necessary to provide quality care and maintain a high standard of operation and facilities. The fee structure
			will be reviewed annually or when deemed necessary by directors. Families will be provided with 4 weeks’ notice should
			there be an increase in fees. </p>
			<p>• Understand & will follow correct complaints & grievance procedures as set out in the handbook.</p>
			<p>• Respecting the individual needs, cultural practices & beliefs of families and staff in all interactions- both verbal & non-verbal.</p>
			<p>• All families/staff/management must be treated with dignity & respect. Regardless of the situation, outbursts of anger &
			frustration will not be tolerated.</p>
			<p>• Accept & acknowledge that the management will deal with any breach according to our grievance procedures, & that any
			serious breach could lead to the withdrawal of my/our child children’s place at the centre or my freedom to be in
			attendance at the centre or legal or disciplinary action. </p>
			<p>• In reference to hygiene & infection control I agree to keep my child at home when suffering from a heavy cold or other
			infectious illness likely to affect the health of other children/staff. </p>
			<p>• I will telephonically inform the centre if my child is unable to attend for a scheduled day. I also understand that I will still
			be invoiced for that day. </p>
			<p>• Any matters, concerns, arrangements or complaints in relation to a family, parent, child and staff are regarded as private
			& confidential and may not be discussed with others attending or outside the premises of the centre, unless with management. </p>
			<p>• I/we aware that the Centre is also equipped with the CCTV security. The purpose of the CCTV system is for the security of
			the premises, the safety of children, staff and visitors to the Centre. The images that are recorded will be held in a secure
			location on the systems. The images will be digitally recorded on a rolling programme of 4 days.</p>
			<label for="email">Full First & Last Name:</label>
			<input type="text"  name="section12_full_first_name" style="width: 40%" value="">
			</br></br>
			Signature: _________________________________________</br></br>
			Date: _____________________
		</td>
	</tr>
	<tr>
		<td><h4 style="text-align: center"><u>Medical Condition Support Plan</u></h4>
		<p>Any child enrolled at the centre who has a known medical condition which requires medication and/or treatment needs to have a ‘medical
		condition support plan’. This plan should include the condition, signs, symptoms and action and/ or treatment required AND must be signed 
		by a medical practitioner. Parents/ legal guardians are responsible to inform our centre upon enrolment or diagnosis after enrolment of their
		child’s medical condition. Parents/ legal guardians are responsible to provide a copy of these plans (action plan for asthma/ anaphylaxis/
		allergy; or medical condition support plan any other medical condition) to our centre upon enrolment and keep it up to date. It is understood
		and accepted that this plan will be followed in respect to the condition. </p></td>
	</tr>
	<tr><td><h4 style="text-align: center">Child Personal Details</h4></td></tr>
	<tr>
		<td>
			<label for="email">Child name and surname:</label>
  <input type="text"  placeholder="" style="width:30%" name="child_name" value=""></br>
  <label for="email">Date of birth:</label>
  <input type="date"  placeholder="" style="width:30%" name="child_dob" value=""></br>
  <label for="email">Gender:</label>
  <input type="radio"  name="child_gender"    value="Female">Female
  <input type="radio"  name="child_gender"    value="Male">Male
  <input type="radio"  name="child_gender"    value="Other">Other</br>
  <label for="email">Medical condition:</label>
  <textarea name="medical_condition" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
		</td>
	</tr>
	<tr><td><h4 style="text-align: center">Child’s health information</h4></td></tr>
	<tr>
		<td>
			<label for="email">List ANY medical condition or health requirement your child has which would require any form of treatment while in the
			care of our centre:</br></label>
             <textarea name="list_medical_condition" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
		</td>
	</tr>
	<tr>
		<td>
			<label for="email">List the signs or symptoms thereof:</br></label>
             <textarea name="list_signs" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
		</td>
	</tr>
	<tr>
		<td>
			<label for="email">List the treatment or first aid management thereof:</br>(* if any medication is required and action plan must be completed)</br></label>
             <textarea name="list_signs" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
		</td>
	</tr>
	<tr><td><h4 style="text-align: center">Parent/Guardian Contact Details</h4></td></tr>
		<tr>
		<td>
			<label for="email">Name and surname:</label>
  <input type="text"  placeholder="" style="width:30%" name="guardian_name" value=""></br>
  <label for="email">Home Phone:</label>
  <input type="text"  placeholder="" style="width:30%" name="home_phone" value="">
  <label for="email">Work Phone:</label>
  <input type="text"  placeholder="" style="width:30%" name="work_phone" value=""></br>
  <label for="email">Mobile:</label>
  <input type="text"  placeholder="" style="width:30%" name="mobile" value=""></br>
  <label for="email">Email Address:</label>
  <input type="text"  placeholder="" style="width:30%" name="guardian_email_address" value="">
		</td>
	</tr>
		<tr><td><h4 style="text-align: center">Emergency contacts</h4></td></tr>
		<tr>
			<td>
				<table style="width:100%">
					<tr>
						<td><label for="email">1. Name & surname:</label>
                           <input type="text"  placeholder=""  name="emergency_name1" style="width:40%"  value=""></td>
						<td><label for="email">2. Name & surname:</label>
                           <input type="text"  placeholder=""  name="emergency_name2" style="width:40%"  value=""></td>
					</tr>
					<tr>
						<td><label for="email">Relation to the child:</label>
                           <input type="text"  placeholder=""  name="emergency_relation1" style="width:40%"  value=""></td>
						<td><label for="email">Relation to the child:</label>
                           <input type="text"  placeholder=""  name="emergency_relation2" style="width:40%"  value=""></td>
					</tr>
					<tr>
						<td><label for="email">Home address:</label>
                           <textarea name="emergency_address1" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea>
						</td>
						<td><label for="email">Home address:</label>
                          <textarea name="emergency_address2" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea></td>
					</tr>
					<tr>
						<td><label for="email">Contact details:</label></br>
						<label for="email">H:</label>
						<input type="text"  placeholder=""  name="emergency_h1"   value="">
						<label for="email">W:</label>
						<input type="text"  placeholder=""  name="emergency_w1"   value="">
						</br>
						   <label for="email">Mobile:</label>
                           <input type="text"  placeholder=""  name="emergency_mobile1" style="width:40%"  value=""></br>
						   <label for="email">Email Address:</label>
                           <input type="text"  placeholder=""  name="emergency_email_address1" style="width:40%"  value="">
						</td>
						<td><label for="email">Contact details:</label></br>
						<label for="email">H:</label>
						<input type="text"  placeholder=""  name="emergency_h2"   value="">
						<label for="email">W:</label>
						<input type="text"  placeholder=""  name="emergency_w2"   value="">
						</br>
						   <label for="email">Mobile:</label>
                           <input type="text"  placeholder=""  name="emergency_mobile2" style="width:40%"  value=""></br>
						   <label for="email">Email Address:</label>
                           <input type="text"  placeholder=""  name="emergency_email_address2" style="width:40%"  value="">
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr><td><h4 style="text-align: center">Medical practitioner</h4></td></tr>
		<tr>
			<td>
			 <label for="email">Name:</label>
              <input type="text"  placeholder=""  name="medical_pra_name" style="width:40%"  value=""></br>
			  <label for="email">Address:</label>
              <textarea name="medical_pra_address" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea></br>
			  <label for="email">Contact Details:</label>
              <textarea name="medical_pra_contact_details" style="margin: 5px 10px 5px 0px; width: 340px; height: 94px;"></textarea></br>
			  <label for="email">Signature: __________________________ Date: __________________________</label>
			</td>
		</tr>
		<tr><td><h4 style="text-align: center">Other Information</h4></td></tr>
		<tr><td>
			<textarea name="other_info" style="margin: 5px 10px 5px 0px; width: 640px; height: 94px;"></textarea>
		</td></tr>
		<tr>
			<td><span style="float:left;"><b>Parent name & signature:</b></span>
               <span style="float:right;"><b>Date:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
		</tr>
		<tr>
			<td><h3 style="text-align: center"><u>Nutrition and Dietary Information</u></h3></td>
		</tr>
		<tr>
			<td><h4 style="text-align: center">Child Personal Details</h4></td>
		</tr>
		<tr>
			<td><label for="email">Child name and surname:</label>
  <input type="text"  placeholder="" style="width:30%" name="child_personal_name" value=""></br>
  <label for="email">Date of birth:</label>
  <input type="date"  placeholder="" style="width:30%" name="child_personal_dob" value=""></br>
  <label for="email">Gender:</label>
  <input type="radio"  name="child_personal_gender"    value="Female">Female
  <input type="radio"  name="child_personal_gender"    value="Male">Male
  <input type="radio"  name="child_personal_gender"    value="Other">Other
		</tr>
		<tr>
			<td><h4 style="text-align: center">Information relating to dietary restrictions</h4></td>
		</tr>
		<tr>
			<td>List <b>ALL</b> foods which should be avoided due to <b>allergies</b>:</br>
			<textarea name="list_all_foods" style="margin: 5px 10px 5px 0px; width: 640px; height: 94px;"></textarea>
			</br>
			<p>*Please ensure that you have completed an ‘Allergy Action Plan’ and provided the centre with prescribed medication</p></td>
		</tr>
		<tr>
			<td>List <b>ALL</b> foods which should be avoided due to a confirmed intolerance:</br>
			<textarea name="list_all_foods_intolerance" style="margin: 5px 10px 5px 0px; width: 640px; height: 94px;"></textarea>
			</br>
			<p>*Please ensure that you have completed and attached the ‘medical condition support plan’</p></td>
		</tr>
		<tr>
			<td>List any other special dietary requirements (such as for cultural or religious reasons):</br>
			<textarea name="list_all_dietary" style="margin: 5px 10px 5px 0px; width: 640px; height: 94px;"></textarea>
			</br></td>
		</tr>
		<tr>
			<td><span style="float:left;"><b>Parent name & signature:</b></span>
               <span style="float:right;"><b>Date:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
		</tr>
</table>
</br>
<div width="100%" style="display: flex;justify-content: flex-end;">
		<button type="submit" >Save</button>

</div>
	</form>
 
	
</body>
</html>