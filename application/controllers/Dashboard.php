<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Dashboard extends CI_Controller {  
      
    public function oldDashboard()  
    {
		if($this->session->has_userdata('LoginId')){
			$url = BASE_API_URL."/Dashboard/getDashboardDetails/".$this->session->userdata('LoginId');
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				curl_close ($ch);
				$data = $jsonOutput;
				$getCalDetails=json_decode($this->calendarEvents());
				$records['Announcements'] = $getCalDetails->Announcements;
				$records['StaffBirthdays'] = $getCalDetails->StaffBirthdays;
				$records['PublicHolidays'] = $getCalDetails->PublicHolidays;
				$records['ChildBirthdays'] = $getCalDetails->ChildBirthdays;
				// print_r($records['ChildBirthdays']);
				// exit();

				$recs = [];

				if ($this->session->userdata('UserType')=="Parent") {

					foreach ($records['Announcements'] as $recAnn => $recAnnObj) {
						$recAn['title'] = $recAnnObj->title;
						$recAn['start'] = date('D M d Y',strtotime($recAnnObj->eventDate));
						$recAn['backgroundColor'] = "#297DB6";
						$recAn['allDay'] = true;
						array_push($recs, $recAn);
					}

				} else {

					foreach ($records['ChildBirthdays'] as $recChildBirthdays => $recCBObj) {
						$recCB['title'] = $recCBObj->name."'s Birthday";
						$recCB['start'] = date('D M d Y',strtotime($recCBObj->dob));
						$recCB['backgroundColor'] = "#297DB6";
						$recCB['allDay'] = true;
						array_push($recs, $recCB);
					}

					foreach ($records['Announcements'] as $recAnn => $recAnnObj) {
						$recAn['title'] = $recAnnObj->title;
						$recAn['start'] = date('D M d Y',strtotime($recAnnObj->eventDate));
						$recAn['backgroundColor'] = "#297DB6";
						$recAn['allDay'] = true;
						array_push($recs, $recAn);
					}

					foreach ($records['StaffBirthdays'] as $recStaffBirthdays => $recSb) {
						$recStb['title'] = $recSb->name."'s Birthday";
						$recStb['start'] = date('D M d Y',strtotime($recSb->dob));
						$recStb['backgroundColor'] = "#297DB6";
						$recStb['allDay'] = true;
						array_push($recs, $recStb);
					}

					foreach ($records['PublicHolidays'] as $records => $recObj) {
						$rec['title'] = $recObj->occasion;
						$rec['start'] = date('D M d Y',strtotime($recObj->date));
						$rec['backgroundColor'] = "#297DB6";
						$rec['allDay'] = true;
						array_push($recs, $rec);
					}
				}
				
				$data->calendar = $recs;

			    $this->load->view('dashboard',$data);
			}
			// if($httpcode == 401){
			// 	redirect('welcome');
			// } 
		} else{
			redirect('Welcome');
		}
         
    }

    // public function calendarEvents(){
    // 	if($this->session->has_userdata('LoginId')){
    // 		$url = BASE_API_URL."/Dashboard/getCalDetails/".$this->session->userdata('LoginId')."/".date('Y');
	// 		$ch = curl_init($url);
	// 		curl_setopt($ch, CURLOPT_URL,$url);
	// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	// 			'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
	// 			'X-Token: '.$this->session->userdata('AuthToken')
	// 		));
	// 		$server_output = curl_exec($ch);
	// 		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	// 		if($httpcode == 200){
	// 			curl_close ($ch);
	// 		    return $server_output;
	// 		}
    // 	}
    // }

	public function calendarEvents() {
		if ($this->session->has_userdata('LoginId')) {
			$url = BASE_API_URL . "/Dashboard/getCalDetails/" . $this->session->userdata('LoginId') . "/" . date('Y');
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: ' . $this->session->userdata('X-Device-Id'),
				'X-Token: ' . $this->session->userdata('AuthToken')
			));
			
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
	
			if ($httpcode == 200) {
				return $server_output;
			} else {
				// Return an empty JSON object if the request fails
				return json_encode(new stdClass());
			}
		}
	
		// Return an empty JSON object if LoginId is not set
		return json_encode(new stdClass());
	}
	

    // public function index()  
    // {
	// 	if($this->session->has_userdata('LoginId')){
			
	// 		if($this->session->userdata('UserType') == "Parent"){
	// 			redirect('Dashboard/parent');
	// 		}else{
	// 			$url = BASE_API_URL."Dashboard/getDashboardDetailsNew/".$this->session->userdata('LoginId');
	// 			//echo $url; exit;
	// 			$ch = curl_init($url);
	// 			curl_setopt($ch, CURLOPT_URL,$url);
	// 			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	// 				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
	// 				'X-Token: '.$this->session->userdata('AuthToken')
	// 			));
	// 			$server_output = curl_exec($ch);
	// 			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	// 			//var_dump($server_output); exit;
	// 			curl_close ($ch);
	// 			//echo $httpcode; exit;
	// 			if($httpcode == 200){
	// 				$jsonOutput=json_decode($server_output);
	// 				$data = $jsonOutput;
	// 				$getCalDetails=json_decode($this->calendarEvents());
	// 				//var_dump($getCalDetails); exit;
	// 				$records['Announcements'] = $getCalDetails->Announcements;
	// 				$records['StaffBirthdays'] = $getCalDetails->StaffBirthdays;
	// 				$records['PublicHolidays'] = $getCalDetails->PublicHolidays;
	// 				$records['ChildBirthdays'] = $getCalDetails->ChildBirthdays;

	// 				$recs = [];

	// 				if ($this->session->userdata('UserType')=="Parent") {

	// 					foreach ($records['Announcements'] as $recAnn => $recAnnObj) {
	// 						$recAn['title'] = $recAnnObj->title;
	// 						$recAn['start'] = date('D M d Y',strtotime($recAnnObj->eventDate));
	// 						$recAn['backgroundColor'] = "#297DB6";
	// 						$recAn['allDay'] = true;
	// 						array_push($recs, $recAn);
	// 					}

	// 				} else {
						

	// 					foreach ($records['ChildBirthdays'] as $recChildBirthdays => $recCBObj) {
	// 						$recCB['title'] = $recCBObj->name."'s Birthday";
	// 						$recCB['start'] = date('D M d Y',strtotime($recCBObj->dob));
	// 						$recCB['backgroundColor'] = "#297DB6";
	// 						$recCB['allDay'] = true;
	// 						array_push($recs, $recCB);
	// 					}

	// 					foreach ($records['Announcements'] as $recAnn => $recAnnObj) {
	// 						$recAn['title'] = $recAnnObj->title;
	// 						$recAn['start'] = date('D M d Y',strtotime($recAnnObj->eventDate));
	// 						$recAn['backgroundColor'] = "#297DB6";
	// 						$recAn['allDay'] = true;
	// 						array_push($recs, $recAn);
	                    
	// 					}

	// 					foreach ($records['StaffBirthdays'] as $recStaffBirthdays => $recSb) {
	// 						$recStb['title'] = $recSb->name."'s Birthday";
	// 						$recStb['start'] = date('D M d Y',strtotime($recSb->dob));
	// 						$recStb['backgroundColor'] = "#297DB6";
	// 						$recStb['allDay'] = true;
	// 						array_push($recs, $recStb);
	// 					}

	// 					foreach ($records['PublicHolidays'] as $records => $recObj) {
	// 						$rec['title'] = $recObj->occasion;
	// 						$rec['start'] = date('D M d Y',strtotime($recObj->date));
	// 						$rec['backgroundColor'] = "#297DB6";
	// 						$rec['allDay'] = true;
	// 						array_push($recs, $rec);
	// 					}
	// 				}
					
					
	// 				$data->calendar = $recs;
	// 				//var_dump($data); exit;
	// 				$this->load->view('dashboard',$data);
					
	// 			    //$this->load->view('sidebar',$data);
	// 			}
	// 			if($httpcode == 401){
	// 				redirect('welcome');
	// 			} 
	// 		}
	// 	} else{
	// 		redirect('Welcome');
	// 	}         
    // }


	// public function index()  
	// {
	// 	if ($this->session->has_userdata('LoginId')) {

	// 		if ($this->session->userdata('UserType') == "Parent") {
	// 			redirect('Dashboard/parent');
	// 		} else {
	// 			$url = BASE_API_URL . "Dashboard/getDashboardDetailsNew/" . $this->session->userdata('LoginId');

	// 			// Initialize cURL
	// 			$ch = curl_init($url);
	// 			curl_setopt($ch, CURLOPT_URL, $url);
	// 			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	// 				'X-Device-Id: ' . $this->session->userdata('X-Device-Id'),
	// 				'X-Token: ' . $this->session->userdata('AuthToken')
	// 			));

	// 			// Execute cURL request
	// 			$server_output = curl_exec($ch);
	// 			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	// 			curl_close($ch);

	// 			// Check if the request was successful and $server_output is not null
	// 			if ($httpcode == 200 && $server_output) {
	// 				// Decode JSON response
	// 				$jsonOutput = json_decode($server_output);

	// 				if (json_last_error() === JSON_ERROR_NONE) {
	// 					$data = $jsonOutput;
	// 				} else {
	// 					// Handle JSON decode error
	// 					log_message('error', 'JSON decode error: ' . json_last_error_msg());
	// 					$data = new stdClass(); // or handle as needed
	// 				}
	// 			} else {
	// 				$data = new stdClass(); // or handle as needed
	// 			}

	// 			// Decode calendar events
	// 			$getCalDetails = json_decode($this->calendarEvents());

	// 			// Ensure $getCalDetails is not null and is an object
	// 			if ($getCalDetails && is_object($getCalDetails)) {
	// 				$records['Announcements'] = $getCalDetails->Announcements ?? [];
	// 				$records['StaffBirthdays'] = $getCalDetails->StaffBirthdays ?? [];
	// 				$records['PublicHolidays'] = $getCalDetails->PublicHolidays ?? [];
	// 				$records['ChildBirthdays'] = $getCalDetails->ChildBirthdays ?? [];
	// 			} else {
	// 				// Handle the case where $getCalDetails is null or not an object
	// 				$records['Announcements'] = [];
	// 				$records['StaffBirthdays'] = [];
	// 				$records['PublicHolidays'] = [];
	// 				$records['ChildBirthdays'] = [];
	// 			}

	// 			$recs = [];

	// 			if ($this->session->userdata('UserType') == "Parent") {
	// 				foreach ($records['Announcements'] as $recAnnObj) {
	// 					if (is_object($recAnnObj)) {
	// 						$recAn = [
	// 							'title' => $recAnnObj->title,
	// 							'start' => date('D M d Y', strtotime($recAnnObj->eventDate)),
	// 							'backgroundColor' => "#297DB6",
	// 							'allDay' => true
	// 						];
	// 						$recs[] = $recAn;
	// 					}
	// 				}
	// 			} else {
	// 				foreach ($records['ChildBirthdays'] as $recCBObj) {
	// 					if (is_object($recCBObj)) {
	// 						$recCB = [
	// 							'title' => $recCBObj->name . "'s Birthday",
	// 							'start' => date('D M d Y', strtotime($recCBObj->dob)),
	// 							'backgroundColor' => "#297DB6",
	// 							'allDay' => true
	// 						];
	// 						$recs[] = $recCB;
	// 					}
	// 				}

	// 				foreach ($records['Announcements'] as $recAnnObj) {
	// 					if (is_object($recAnnObj)) {
	// 						$recAn = [
	// 							'title' => $recAnnObj->title,
	// 							'start' => date('D M d Y', strtotime($recAnnObj->eventDate)),
	// 							'backgroundColor' => "#297DB6",
	// 							'allDay' => true
	// 						];
	// 						$recs[] = $recAn;
	// 					}
	// 				}

	// 				foreach ($records['StaffBirthdays'] as $recSb) {
	// 					if (is_object($recSb)) {
	// 						$recStb = [
	// 							'title' => $recSb->name . "'s Birthday",
	// 							'start' => date('D M d Y', strtotime($recSb->dob)),
	// 							'backgroundColor' => "#297DB6",
	// 							'allDay' => true
	// 						];
	// 						$recs[] = $recStb;
	// 					}
	// 				}

	// 				foreach ($records['PublicHolidays'] as $recObj) {
	// 					if (is_object($recObj)) {
	// 						$rec = [
	// 							'title' => $recObj->occasion,
	// 							'start' => date('D M d Y', strtotime($recObj->date)),
	// 							'backgroundColor' => "#297DB6",
	// 							'allDay' => true
	// 						];
	// 						$recs[] = $rec;
	// 					}
	// 				}
	// 			}

	// 			$data->calendar = $recs;

	// 			// Load the view with the data
	// 			$this->load->view('dashboard', $data);
	// 		}
	// 	} else {
	// 		redirect('Welcome');
	// 	}
	// }

	public function index()  
{
    if ($this->session->has_userdata('LoginId')) {

        if ($this->session->userdata('UserType') == "Parent") {
            redirect('Dashboard/parent');
        } else {
            $url = BASE_API_URL . "Dashboard/getDashboardDetailsNew/" . $this->session->userdata('LoginId');

            // Initialize cURL
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Device-Id: ' . $this->session->userdata('X-Device-Id'),
                'X-Token: ' . $this->session->userdata('AuthToken')
            ));

            // Execute cURL request
            $server_output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Check if the request was successful and $server_output is not null
            if ($httpcode == 200 && $server_output) {
                // Decode JSON response
                $jsonOutput = json_decode($server_output);

                if (json_last_error() === JSON_ERROR_NONE) {
                    $data = $jsonOutput;
                } else {
                    // Handle JSON decode error
                    log_message('error', 'JSON decode error: ' . json_last_error_msg());
                    $data = new stdClass(); // or handle as needed
                }
            } else {
                $data = new stdClass(); // or handle as needed
            }

            // Decode calendar events
            $calendarEventsJson = $this->calendarEvents();
            $getCalDetails = json_decode($calendarEventsJson);

            // Ensure $getCalDetails is not null and is an object
            if ($getCalDetails && is_object($getCalDetails)) {
                $records['Announcements'] = $getCalDetails->Announcements ?? [];
                $records['StaffBirthdays'] = $getCalDetails->StaffBirthdays ?? [];
                $records['PublicHolidays'] = $getCalDetails->PublicHolidays ?? [];
                $records['ChildBirthdays'] = $getCalDetails->ChildBirthdays ?? [];
            } else {
                // Handle the case where $getCalDetails is null or not an object
                $records['Announcements'] = [];
                $records['StaffBirthdays'] = [];
                $records['PublicHolidays'] = [];
                $records['ChildBirthdays'] = [];
            }

            $recs = [];

            if ($this->session->userdata('UserType') == "Parent") {
                foreach ($records['Announcements'] as $recAnnObj) {
                    if (is_object($recAnnObj)) {
                        $recAn = [
                            'title' => $recAnnObj->title,
                            'start' => date('D M d Y', strtotime($recAnnObj->eventDate)),
                            'backgroundColor' => "#297DB6",
                            'allDay' => true
                        ];
                        $recs[] = $recAn;
                    }
                }
            } else {
                foreach ($records['ChildBirthdays'] as $recCBObj) {
                    if (is_object($recCBObj)) {
                        $recCB = [
                            'title' => $recCBObj->name . "'s Birthday",
                            'start' => date('D M d Y', strtotime($recCBObj->dob)),
                            'backgroundColor' => "#297DB6",
                            'allDay' => true
                        ];
                        $recs[] = $recCB;
                    }
                }

                foreach ($records['Announcements'] as $recAnnObj) {
                    if (is_object($recAnnObj)) {
                        $recAn = [
                            'title' => $recAnnObj->title,
                            'start' => date('D M d Y', strtotime($recAnnObj->eventDate)),
                            'backgroundColor' => "#297DB6",
                            'allDay' => true
                        ];
                        $recs[] = $recAn;
                    }
                }

                foreach ($records['StaffBirthdays'] as $recSb) {
                    if (is_object($recSb)) {
                        $recStb = [
                            'title' => $recSb->name . "'s Birthday",
                            'start' => date('D M d Y', strtotime($recSb->dob)),
                            'backgroundColor' => "#297DB6",
                            'allDay' => true
                        ];
                        $recs[] = $recStb;
                    }
                }

                foreach ($records['PublicHolidays'] as $recObj) {
                    if (is_object($recObj)) {
                        $rec = [
                            'title' => $recObj->occasion,
                            'start' => date('D M d Y', strtotime($recObj->date)),
                            'backgroundColor' => "#297DB6",
                            'allDay' => true
                        ];
                        $recs[] = $rec;
                    }
                }
            }

            $data->calendar = $recs;

            // Load the view with the data
            $this->load->view('dashboard', $data);
        }
    } else {
        redirect('Welcome');
    }
}



	

    public function parent($value='')
    {
    	if($this->session->has_userdata('LoginId')){
    		$data['userid'] = $this->session->userdata('LoginId');
    		$url = BASE_API_URL."/Dashboard/getParentDashboard";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			if ($httpcode == 200) {
				$jsonOutput = json_decode($server_output);
				$this->load->view('dashboard', $jsonOutput);
			} else {
				// redirect(base_url('logout'));
			}
    	}else{
    		redirect('Welcome');
    	}
    }


    public function test($value='')
    {
    	$this->load->view('ckeditor');
    }

}  
?>