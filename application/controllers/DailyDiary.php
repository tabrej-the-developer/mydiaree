<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DailyDiary extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database(); 
	}

	public function index()
	{
		if($this->session->has_userdata('LoginId')){
			
			if(isset($_GET['centerid'])){
				$centerid = $_GET['centerid'];
			}else{
				$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
			}
			redirect('DailyDiary/list').'?centerid='.$centerid;
			// $data['userid'] = $this->session->userdata("LoginId");		
			// $url = BASE_API_URL.'dailyDiary/getDailyDiary';
			
			// $ch = curl_init($url);
			// curl_setopt($ch, CURLOPT_URL,$url);
			// curl_setopt($ch, CURLOPT_POST, 1);
			// curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			// 	'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
			// 	'X-Token: '.$this->session->userdata('AuthToken')
			// ));
			// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// $server_output = curl_exec($ch);
			// $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			// curl_close($ch);
			// if($httpcode == 200){
			// 	$data = json_decode($server_output);
			// 	$this->load->view('dailyDiary',$data);
			// }
			// else if($httpcode == 401){
			// 	return 'error';
			// }
		}else{
			redirect("Welcome");
		}
	}

	public function list()
	{
		if($this->session->has_userdata('LoginId')){
			if(isset($_GET['centerid'])){
				$centerid = $_GET['centerid'];
			}else{
				$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
			}

			$data['centerid'] = $centerid;

            if(isset($_GET['date'])){
                $data['date'] = $_GET['date'];
            }


			                // echo "<pre>";
                            // print_r($_GET['date']);
                            // exit;
			

            if(isset($_GET['roomid'])){
                $data['roomid'] = $_GET['roomid'];
            }

			if($this->session->userdata("UserType") == "Superadmin" ){
				$data['superadmin'] = 1;
			}else if ($this->session->userdata("UserType") == "Parent"){
				$data['superadmin'] = 2;
			}else{
                $data['superadmin'] = 0;
			}


			// echo "<pre>";
			// print_r($data);
			// exit;
			
			$data['userid'] = $this->session->userdata("LoginId");
          
			$url = BASE_API_URL.'dailyDiary/getDailyDiary';
            
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			//print_r($server_output); exit;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			    // echo "<pre>"; 
				// print_r(json_decode($server_output)); 
				// exit;
			if($httpcode == 200){
				$data = json_decode($server_output);
							// echo "<pre>";
                            // print_r($data);
                            // exit;
				
				if (!is_object($data)) {
					$data = new stdClass(); // Ensure $data is an object
				}
			
				$data->centerid = $centerid;


				

				if($this->session->userdata("UserType") != "Parent" ){

				$Reqdate = $data->date; // Format: YYYY-MM-DD

				// Get the day of the week from the requested date
				$dayIndex = date('N', strtotime($Reqdate)) - 1; // 0 = Monday, 4 = Friday
				
				if ($dayIndex >= 0 && $dayIndex <= 4) { // Only filter for Mon to Fri
					$filteredChilds = [];
				
					foreach ($data->childs as $child) {
						// Ensure daysAttending string is at least 5 characters
						if (strlen($child->daysAttending) >= 5) {
							if ($child->daysAttending[$dayIndex] === '1') {
								$filteredChilds[] = $child;
							}
						}
					}
				
					$data->childs = $filteredChilds;
				}
			}

				
				            // echo "<pre>";
                            // print_r($data->childs);
                            // exit;
				
				
				$this->load->view('dailyDiary_v3', $data);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("welcome");
		}
	}




	public function addBottel()
{
    $childid   = $this->input->post('childid');
    $diarydate = $this->input->post('diarydate');
    $startTimes = $this->input->post('startTime');

    // Format diarydate
    $diarydate = date('Y-m-d', strtotime($diarydate));

    $createdBy = $this->session->userdata("LoginId");

    if (!empty($startTimes) && is_array($startTimes)) {
        foreach ($startTimes as $startTime) {
            $this->db->insert('dailydiarybottle', [
                'childid'    => $childid,
                'diarydate'  => $diarydate,
                'startTime'  => $startTime,
                'createdBy'  => $createdBy
            ]);
        }
    }

    echo json_encode(['status' => 'success']);
}


public function updateBottleTimes()
{
    $childid = $this->input->post('childid');
    $diarydate = date('Y-m-d', strtotime($this->input->post('diarydate')));
    $createdBy = $this->session->userdata("LoginId");

    // Update existing times
    $existing_ids = $this->input->post('existing_id');
    $existing_times = $this->input->post('existing_time');
    if (!empty($existing_ids)) {
        foreach ($existing_ids as $i => $id) {
            $this->db->where('id', $id)->update('dailydiarybottle', [
                'startTime' => $existing_times[$i]
            ]);
        }
    }

    // Insert new times
    $new_times = $this->input->post('new_time');
    if (!empty($new_times)) {
        foreach ($new_times as $time) {
            $this->db->insert('dailydiarybottle', [
                'childid' => $childid,
                'diarydate' => $diarydate,
                'startTime' => $time,
                'createdBy' => $createdBy
            ]);
        }
    }

    echo json_encode(['status' => 'success']);
}


public function deleteBottleTime()
{
    $id = $this->input->post('id');
    $this->db->where('id', $id)->delete('dailydiarybottle');
    echo json_encode(['status' => 'deleted']);
}




	public function getItems($type)
	{
		if($this->session->has_userdata('LoginId')){
			$data = [];
			$data['userid'] = $this->session->userdata('LoginId');
			if ($type == "morningtea" || $type=="afternoontea") {
				$data['type'] = "tea";
			}else{
				$data['type'] = $type;
			}
			if (!empty($this->input->post('searchTerm'))) {
				$data['searchTerm'] = $this->input->post('searchTerm');
			}

			$data['centerid'] = $this->input->get('centerid') ?? $this->input->post('centerid');

			// echo "<pre>";
			// print_r($data);
			// exit;
			$url = BASE_API_URL."DailyDiary/getItems/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				$results = json_decode($server_output);
				$res = $results->items;
				$response = [];
				foreach ($res as $key => $obj) {
					$resp['id'] = $obj->itemName; //$obj->id
					$resp['text'] = $obj->itemName;
					array_push($response, $resp);
				}
   
				// echo "<pre>";
                // print_r($response);
                // exit;

				echo json_encode($response);
			}
			
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect("welcome");
		}
	}

	public function addFoodRecord()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['childids'] = json_decode($data['childid']);
			// $data['item'] = json_decode($data['item']);
			unset($data['childid']);

			// print_r($data);
			// exit;

			$data['userid'] = $this->session->userdata("LoginId");	
            // echo json_encode($data); die();	
			$url = BASE_API_URL."DailyDiary/addFoodRecord/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			echo $server_output;
		}else{
			redirect("welcome");
		}
	}

	public function addSleepRecord()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['childids'] = json_decode($data['childid']);
			unset($data['childid']);
			$url = BASE_API_URL."DailyDiary/addSleepRecord/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);
            echo $server_output;
		}else{
			redirect("welcome");
		}
	}

	public function addToiletingRecord()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['startTime'] = [$data['startTime']];

			// print_r($data);
			// exit;
			$data['childids'] = json_decode($data['childid']);
			unset($data['childid']);
			$url = BASE_API_URL."DailyDiary/addToiletingRecord/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			echo $server_output;
		}else{
			redirect("Welcome");
		}
	}

	public function addSunscreenRecord()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['childids'] = json_decode($data['childid']);
			unset($data['childid']);
			$data['userid'] = $this->session->userdata('LoginId');
			// print_r($data);
			// exit;
			$url = BASE_API_URL."DailyDiary/addSunscreenRecord/";
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			echo $server_output;
		}else{
			redirect("Welcome");
		}
	}

	public function viewChildDiary()
	{
		if($this->session->has_userdata('LoginId')){
			$data = [];
			if(!empty($this->input->get())){
				$get = $this->input->get();
				$centerid = $get['centerid'];
			}else{
				$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
			}
			$data['userid'] = $this->session->userdata("LoginId");
			$data['date'] = $this->input->get("date");
			$data['childid'] = $this->input->get("childid");
			$data['centerid'] = $centerid;
			// echo "<pre>";
			// 	print_r($data);
			// 	exit;  
			$url = BASE_API_URL."DailyDiary/viewChildDiary/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				$data = json_decode($server_output);
				// echo "<pre>";
				// print_r($data); 
				// exit;  
				$data->centerid = $centerid;
				$this->load->view('viewChildDiary', $data);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect("welcome");
		}
	}


	public function reset_data() {
		// Get POST data
		$data = $this->input->post();
		
		// Initialize response array
		$response = array(
			'status' => 'error',
			'message' => 'No data was reset'
		);
		
		// Check if required data exists
		if (!isset($data['options']) || !isset($data['child_id']) || !isset($data['date'])) {
			$response['message'] = 'Missing required parameters';
			echo json_encode($response);
			return;
		}
		
		// Map option names to their corresponding table names
		$table_map = [
			'breakfast' => 'dailydiarybreakfast',
			'morningtea' => 'dailydiarymorningtea',
			'lunch' => 'dailydiarylunch',
			'sleep' => 'dailydiarysleep',
			'afternoontea' => 'dailydiaryafternoontea',
			'snack' => 'dailydiarysnacks',
			'sunscreen' => 'dailydiarysunscreen',
			'toileting' => 'dailydiarytoileting'
		];
		
		// Keep track of successful deletes
		$successful_deletes = [];
		$failed_deletes = [];
		
		// Loop through each selected option
		foreach ($data['options'] as $option) {
			// Check if this option exists in our map
			if (isset($table_map[$option])) {
				$table_name = $table_map[$option];
				
				// Delete records from the corresponding table
				$this->db->where('childid', $data['child_id']);
				$this->db->where('diarydate', $data['date']);
				$this->db->delete($table_name);
				
				// Check if delete was successful
				if ($this->db->affected_rows() > 0) {
					$successful_deletes[] = $option;
				} else {
					// There might not be any records to delete
					$failed_deletes[] = $option;
				}
			}
		}
		
		// Prepare response
		if (count($successful_deletes) > 0) {
			$response['status'] = 'success';
			$response['message'] = 'Successfully reset: ' . implode(', ', $successful_deletes);
			$response['successful'] = $successful_deletes;
			$response['failed'] = $failed_deletes;
		} else {
			$response['message'] = 'No data found to reset for the selected options';
		}
		
		// Return JSON response
		echo json_encode($response);
		exit;
	}

	public function updateChildDailyDiary()
	{
		if($this->session->has_userdata('LoginId')){
			$datetime = date('Y-m-d h:i:s');
			$data=[];

			if(!empty($this->input->get())){
				$get = $this->input->get();
				$centerid = $get['centerid'];
			}else{
				$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
			}
            if(isset($_GET['roomid'])){
                $roomid = $_GET['roomid'];
            }

			$centerid = $centerid;

			// 	echo "<pre>";	
            // print_r($centerid);  
			// exit;
			$data = $this->input->post();
			// echo "<pre>";	
            // print_r($data);  
            // exit();
			$data['userid'] = $this->session->userdata("LoginId");
			$data['breakfast']['childid'] = $data['childid'];
			$data['breakfast']['diarydate'] = $data['diarydate'];
			$data['breakfast']['startTime'] = $data['bfhour']."h:".$data['bfmins']."m";
			$data['breakfast']['item'] = !empty($data['bfitem']) ? json_encode($data['bfitem']) : NULL;
			$data['breakfast']['calories'] = $data['bfcalories'];
		    $data['breakfast']['qty'] = $data['bfqty'];
		    $data['breakfast']['comments'] = $data['bfcomments'];
		    $data['breakfast']['userid'] = $data['userid'];
		    $data['breakfast']['createdAt'] = $datetime;

		    $data['morningtea']['childid'] = $data['childid'];
			$data['morningtea']['diarydate'] = $data['diarydate'];
			$data['morningtea']['startTime'] = $data['mthour']."h:".$data['mtmins']."m";
			$data['morningtea']['item'] = empty($data['mtitem'])?NULL:$data['mtitem'];
			$data['morningtea']['calories'] = $data['mtcalories'];
		    // $data['morningtea']['qty'] = $data['mtqty'];
		    $data['morningtea']['comments'] = $data['mtcomments'];
		    $data['morningtea']['userid'] = $data['userid'];
		    $data['morningtea']['createdAt'] = $datetime;

		    $data['lunch']['childid'] = $data['childid'];
			$data['lunch']['diarydate'] = $data['diarydate'];
			$data['lunch']['startTime'] = $data['lnhour']."h:".$data['lnmins']."m";
			$data['lunch']['item'] = !empty($data['lnitem']) ? json_encode($data['lnitem']) : NULL;
			$data['lunch']['calories'] = $data['lncalories'];
		    $data['lunch']['qty'] = $data['lnqty'];
		    $data['lunch']['comments'] = $data['lncomments'];
		    $data['lunch']['userid'] = $data['userid'];
		    $data['lunch']['createdAt'] = $datetime;

		    $data['afternoontea']['childid'] = $data['childid'];
			$data['afternoontea']['diarydate'] = $data['diarydate'];
			$data['afternoontea']['startTime'] = $data['athour']."h:".$data['atmins']."m";
			$data['afternoontea']['item'] = empty($data['atitem'])?NULL:$data['atitem'];
			$data['afternoontea']['calories'] = $data['atcalories'];
		    // $data['afternoontea']['qty'] = $data['atqty'];
		    $data['afternoontea']['comments'] = $data['atcomments'];
		    $data['afternoontea']['userid'] = $data['userid'];
		    $data['afternoontea']['createdAt'] = $datetime;

		    $data['snack']['childid'] = $data['childid'];
			$data['snack']['diarydate'] = $data['diarydate'];
			$data['snack']['startTime'] = $data['lshour']."h:".$data['lsmins']."m";
			$data['snack']['item'] = !empty($data['lsitem']) ? json_encode($data['lsitem']) : NULL;
			$data['snack']['calories'] = $data['lscalories'];
		    $data['snack']['qty'] = $data['lsqty'];
		    $data['snack']['comments'] = $data['lscomments'];
		    $data['snack']['userid'] = $data['userid'];
		    $data['snack']['createdAt'] = $datetime;

		    $data['toileting']['childid'] = $data['childid'];
		    $data['toileting']['diarydate'] = $data['diarydate'];
			$data['toileting']['startTime'] = []; // Initialize an empty array

			if (isset($data['hour']) && isset($data['mins'])) {
				foreach ($data['hour'] as $key => $hour) {
					$minute = isset($data['mins'][$key]) ? $data['mins'][$key] : '00'; // Handle missing minutes
					$data['toileting']['startTime'][] = $hour . 'h:' . $minute . 'm';
				}
			}
			
		    // $data['toileting']['nappy'] = $data['nappy'];
		    // $data['toileting']['potty'] = $data['potty'];
		    $data['toileting']['nappy_status'] = $data['nappy_status'];
		    // $data['toileting']['toilet'] = $data['toilet'];
		    $data['toileting']['signature'] = $data['signature'];
		    $data['toileting']['comments'] = $data['ttcomments'];
		    $data['toileting']['userid'] = $data['userid'];
		    $data['toileting']['createdAt'] = $datetime;

		    $data['sleep'] = [];
			$data['sunscreen'] = [];

			$sleepCount = count($data['slcomments']);
			for($i=0;$i<$sleepCount;$i++){
				if (empty($data['slcomments'][$i])) {
					continue;
				}
			
				$slp['childid'] = $data['childid'];
				$slp['diarydate'] = $data['diarydate'];
				$slp['startTime'] = $data['slshour'][$i]."h:".$data['slsmins'][$i]."m";
				$slp['endTime'] = $data['slehour'][$i]."h:".$data['slemins'][$i]."m";
				$slp['comments'] = $data['slcomments'][$i];
				$slp['userid'] = $data['userid'];
				$slp['createdAt'] = $datetime;
				array_push($data['sleep'], $slp);
			}

			$ssCount = count($data['sscomments']);
			for($i=0;$i<$ssCount;$i++){
				if (empty($data['sscomments'][$i])) {
					continue; // Skip if comment is empty
				}
				$ss['childid'] = $data['childid'];
				$ss['diarydate'] = $data['diarydate'];
				$ss['startTime'] = $data['sshour'][$i]."h:".$data['ssmins'][$i]."m";
				$ss['comments'] = $data['sscomments'][$i];
				$ss['userid'] = $data['userid'];
				$ss['createdAt'] = date('Y-m-d h:i:s');
				array_push($data['sunscreen'], $ss);
			}
				// echo "<pre>";
				// print_r($data);   
				// exit();
			$url = BASE_API_URL."DailyDiary/updateChildDailyDiary/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				$data = json_decode($server_output);

				if (!$data) {
					$data = new stdClass(); // Create an empty object if $data is null
				}
				// echo "<pre>";
				// print_r($data);   
				// exit();
				$data->centerid = $centerid;
				$redUrl = base_url('dailyDiary/list').'?centerid='.$data->centerid.'&roomid='.$roomid;
				redirect($redUrl);
			}
			
			if($httpcode == 401){
				redirect('welcome');
			}

		}else{
			redirect("welcome");
		}
	}

	public function getCenterRooms()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL."DailyDiary/getCenterRooms/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				echo $server_output;
			}else{
				redirect('welcome');
			}
		}else{
			redirect("welcome");
		}
	}
}

/* End of file dailyDiary.php */
/* Location: ./application/controllers/dailyDiary.php */