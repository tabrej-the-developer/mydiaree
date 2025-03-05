<?php

 	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Dashboard extends CI_Controller {
		public function __construct()
		{
			parent::__construct();
			header('Access-Control-Allow-Origin: *');
			header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
			header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
			$method = $_SERVER['REQUEST_METHOD'];
			if($method == "OPTIONS") {
				die();
			}
			$this->load->model('DashboardModel');
			$this->load->model('LoginModel');
		}

		public function index(){
			
		}

		public function getDashboardDetails($userid){
			$headers = $this->input->request_headers();
			if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
				$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
				if($_SERVER['REQUEST_METHOD'] == 'GET'){
					if( $res != null && $res->userid == $userid){

						$user = $this->DashboardModel->getUserType($userid);

						if ($user->userType=="Parent") {
							$observations = $this->DashboardModel->getTotalParentObservations($userid);
							$data['observationCount'] = $observations->countObs;

							$children = $this->DashboardModel->getTotalChildrenOfParent($userid);
							$data['childrenCount'] = $children->countChild;

							$events = $this->DashboardModel->getTotalEventsOfParent($userid);
							$data['eventsCount'] = $events->countEvents;

							$uevnt = $this->DashboardModel->getUpcomingEventsOfParent($userid);
							$data['upcomingEventsCount'] = $uevnt->countEvents;
						} else {
							// Room
							$rooms = $this->DashboardModel->getTotalRooms($userid);
							$data['roomsCount'] = count($rooms);
							// Children
							$children = $this->DashboardModel->getTotalChildren($userid);
							$data['childrenCount'] = count($children);
							// Staff
							$staff = $this->DashboardModel->getTotalStaff($userid);
							$data['staffCount'] = count($staff);
							// Total Observations
							## -- 
							$observations = $this->DashboardModel->getTotalObservations($userid);
							$data['observationCount'] = count($observations);
							// Total Events
							## -- 
							$events = $this->DashboardModel->getTotalEvents($userid);
							$data['eventsCount'] = count($events);
						}

						$data['Status'] = "SUCCESS";

					} else {
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "User Id Doesn't Match";
					}
				}else{
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid Request Method";
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Headers Sent!";
				http_response_code(401);
			}
			echo json_encode($data);
		}

		// Data for a particular Month 
		public function getCalendarDetails($userid,$month=null,$year=null){
			$headers = $this->input->request_headers();
			if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
				$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
				if($_SERVER['REQUEST_METHOD'] == 'GET'){
					if($res != null && $res->userid == $userid){
						if($month == null){
							$month = sprintf("%02d",intval(date('n')));
						}else{
							$month = sprintf("%02d",$month);
						}
						// Announcements
						$data['Announcements'] = $this->DashboardModel->getAnnouncements($userid,$month);
						// Staff Birth Date
						## Staff Birthday field
						$data['StaffBirthdays'] = $this->DashboardModel->getStaffBirthdays($userid,$month);
						// Public Holidays
						$data['PublicHolidays'] = $this->DashboardModel->getPublicHolidays($userid,$month);
						foreach($data['PublicHolidays'] as $holiday){
							if($year == null){
								$holiday->date = sprintf("%02d",$holiday->month) ."-". sprintf("%02d",$holiday->date);
							}else{
							$holiday->date = sprintf("%02d",$year)."-".sprintf("%02d",$holiday->month) ."-". sprintf("%02d",$holiday->date);
							}
						}
						// Child Birthdays
						$data['ChildBirthdays'] = $this->DashboardModel->getChildBirthdays($userid,$month);
						http_response_code(200);
						$data['Status'] = "SUCCESS";
					} else {
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "User Id Doesn't Match";
					}
				}else{
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid Request Method";
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Headers Sent!";
				http_response_code(401);
			}
			echo json_encode($data);
		}

		// Without Month -- Whole data
		public function getCalDetails($userid,$year=null){
			$headers = $this->input->request_headers();
			if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
				$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
				if($_SERVER['REQUEST_METHOD'] == 'GET'){
					if($res != null && $res->userid == $userid){

						$user = $this->DashboardModel->getUserType($userid);

						if ($user->userType=="Parent") {
							$data['Announcements'] = $this->DashboardModel->getParentsAnnmnts($userid,$year);
						} else {
							$data['Announcements'] = $this->DashboardModel->getAnnouncementsM($userid);
						}

						// Announcements
						
						// Staff Birth Date
						## Staff Birthday field
						$data['StaffBirthdays'] = $this->DashboardModel->getStaffBirthdaysM($userid);
				// echo "<pre>";
				// print_r($data['StaffBirthdays']);
				// exit;
						// Public Holidays
						$data['PublicHolidays'] = $this->DashboardModel->getPublicHolidaysM($userid);
						foreach($data['PublicHolidays'] as $holiday){
							if($year == null){
								$holiday->date = sprintf("%02d",$holiday->month) ."-". sprintf("%02d",$holiday->date);
							}else{
							$holiday->date = sprintf("%02d",$year)."-".sprintf("%02d",$holiday->month) ."-". sprintf("%02d",$holiday->date);
							}
						}
						// Child Birthdays
						$data['ChildBirthdays'] = $this->DashboardModel->getChildBirthdaysM($userid);
						http_response_code(200);
						$data['Status'] = "SUCCESS";
					} else {
							http_response_code(401);
							$data['Status'] = "ERROR";
							$data['Message'] = "User Id Doesn't Match";
					}
				}else{
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid Request Method";
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Headers Sent!";
				http_response_code(401);
			}
			echo json_encode($data);
		}

		public function getDashboardDetailsNew($userid){
			
			// $userid = $this->session->has_userdata('LoginId');
			$headers = $this->input->request_headers();
			if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
				$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
				if($_SERVER['REQUEST_METHOD'] == 'GET'){
					if( $res != null && $res->userid == $userid){

						$user = $this->DashboardModel->getUserType($userid);


						if ($user->userType=="Parent") {
							$observations = $this->DashboardModel->getTotalParentObservations($userid);
							$data['observationCount'] = $observations->countObs;

							$children = $this->DashboardModel->getTotalChildrenOfParent($userid);
							$data['childrenCount'] = $children->countChild;

							$events = $this->DashboardModel->getTotalEventsOfParent($userid);
							$data['eventsCount'] = $events->countEvents;

							$uevnt = $this->DashboardModel->getUpcomingEventsOfParent($userid);
							$data['upcomingEventsCount'] = $uevnt->countEvents;


						} else {
							// Room
							$rooms = $this->DashboardModel->getTotalRooms($userid);
							$data['roomsCount'] = count($rooms);
							// Children
							$children = $this->DashboardModel->getTotalChildren($userid);
							$data['childrenCount'] = count($children);
							// Staff
							$staff = $this->DashboardModel->getTotalStaff($userid);
							$data['staffCount'] = count($staff);
							// Total Observations
							## -- 
							$observations = $this->DashboardModel->getTotalObservations($userid);
							$data['observationCount'] = count($observations);
							// Total Events
							## -- 
							$events = $this->DashboardModel->getTotalEvents($userid);
							$data['eventsCount'] = count($events);
							// Total Racipes
							## -- 				
						}
						
						$recipes = $this->DashboardModel->getTotalRecipes();
						$data['recipesCount'] = $recipes->countRecipes;

						$data['Status'] = "SUCCESS";

					} else {
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "User Id Doesn't Match";
					}
				}else{
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid Request Method";
				}
			}else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Headers Sent!";
				http_response_code(401);
			}
			echo json_encode($data);
		}

		public function getParentDashboard()
		{
			$headers = $this->input->request_headers();
			if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
				$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
				$json = json_decode(file_get_contents('php://input'));
				if($json!= null && $res != null && $res->userid == $json->userid){
					$totalObservations = $this->DashboardModel->totalChildObservations($json->userid);
					$totalChilds = $this->DashboardModel->totalChilds($json->userid);
					$totalChildRecipes = $this->DashboardModel->totalTodayRecipes($json->userid);
					$totalChildEvents = $this->DashboardModel->totalChildEvents($json->userid);

					$events = $this->DashboardModel->childEvents($json->userid);

					$data['Status'] =  'SUCCESS';
					$data['totalObservations'] = $totalObservations;
					$data['totalChilds'] = $totalChilds;
					$data['totalChildRecipes'] = $totalChildRecipes;
					$data['totalChildEvents'] = $totalChildEvents;
					$data['events'] = $events;

				}else{
					http_response_code(401);
					$data['Status'] =  'ERROR';
					$data['Message'] = "Userid doesn\'t match";
				}
			}else{
				$data['Status'] =  'ERROR';
				$data['Message'] = 'Invalid headers sent.';
			}
			echo json_encode($data);
		}

	}

/* End of file Dashboard.php */
