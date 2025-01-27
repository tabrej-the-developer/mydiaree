<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DailyDiary extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
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

            if(isset($_GET['roomid'])){
                $data['roomid'] = $_GET['roomid'];
            }

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
			if($httpcode == 200){
				$data = new stdClass();
				$data = json_decode($server_output);
				$data->centerid = $centerid;
				//print_r($data); exit;
				$this->load->view('dailyDiary_v3',$data);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("welcome");
		}
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
			unset($data['childid']);

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
			$data = $this->input->post();
			// echo "<pre>";	
            // print_r($data);  
            // exit();
			$data['userid'] = $this->session->userdata("LoginId");
			$data['breakfast']['childid'] = $data['childid'];
			$data['breakfast']['diarydate'] = $data['diarydate'];
			$data['breakfast']['startTime'] = $data['bfhour']."h:".$data['bfmins']."m";
			$data['breakfast']['item'] = $data['bfitem'];
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
			$data['lunch']['item'] = $data['lnitem'];
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
			$data['snack']['item'] = empty($data['lsitem'])?NULL:$data['lsitem'];
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
			
		    $data['toileting']['nappy'] = $data['nappy'];
		    $data['toileting']['potty'] = $data['potty'];
		    $data['toileting']['toilet'] = $data['toilet'];
		    $data['toileting']['signature'] = $data['signature'];
		    $data['toileting']['comments'] = $data['ttcomments'];
		    $data['toileting']['userid'] = $data['userid'];
		    $data['toileting']['createdAt'] = $datetime;

		    $data['sleep'] = [];
			$data['sunscreen'] = [];

			$sleepCount = count($data['slcomments']);
			for($i=0;$i<$sleepCount;$i++){
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
				// print_r($roomid);   
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