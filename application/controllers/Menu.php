<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->session->has_userdata('LoginId')){

			if (empty($_GET['centerid'])) {
				$centerArr = $this->session->userdata("centerIds");
				$centerId = $centerArr[0]->id;
			}else{
				$centerId = $_GET['centerid'];
			}
			$userid = $this->session->userdata("LoginId");
			if (isset($_GET['date'])) {
				$date = strtotime($_GET['date']);
				$day = strtolower(date('l', $date));
				if ($day == 'monday') {
					$monday = $date;
				}else{
					$monday = date("Y-m-d", strtotime('previous monday', $date));
					$monday = strtotime($monday);
				}
				
			}else{
				$monday = strtotime("last monday");
				$monday = date('w', $monday)==date('w') ? $monday + 7*86400 : $monday;
			}

			$tuesday = strtotime(date("Y-m-d",$monday)." +1 days");
			$wednesday = strtotime(date("Y-m-d",$monday)." +2 days");
			$thursday = strtotime(date("Y-m-d",$monday)." +3 days");
			$friday = strtotime(date("Y-m-d",$monday)." +4 days");
			$saturday = strtotime(date("Y-m-d",$monday)." +5 days");
			$sunday = strtotime(date("Y-m-d",$monday)." +6 days");
			$this_week_sd = date("Y-m-d", $monday);
			$this_week_ed = date("Y-m-d",$friday);			

			$data['monday'] = date('Y-m-d',$monday);
			$data['tuesday'] = date('Y-m-d',$tuesday);
			$data['wednesday'] = date('Y-m-d',$wednesday);
			$data['thursday'] = date('Y-m-d',$thursday);
			$data['friday'] = date('Y-m-d',$friday);

			$url = BASE_API_URL."Recipes/getMenuList/".$userid."/".$centerId."/".$this_week_sd."/".$this_week_ed;
			
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
				$data['day'] = strtolower(date("l"));
				$data['date'] = date('d-m-Y',strtotime($this_week_sd));
				$data['output'] = $jsonOutput;
				$data['centerid'] = $centerId;
				if (isset($day)) {
					if ($day == "sunday" || $day == "saturday") {
						$data['day'] = "monday";
					}else{
						$data['day'] = $day;
					}
				}else{
					$data['day'] = "monday";
				}

				// echo "<pre>";
				// print_r($data);
				// exit;
				$this->load->view('recipeMenu',$data);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function addToMenu()
	{
		//echo "addToMedvsnu"; exit;
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['centerid'] = $data['centerid'];
			$data['mealType'] = strtoupper($data['mealType']);
			$data['addedBy'] = $this->session->userdata('LoginId');
			$data['userid'] = $this->session->userdata('LoginId');
			$data['currentDate'] = $data['curDate'];
			unset($data['centerId']);
			$url = BASE_API_URL.'Recipes/addToMenu';
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
			if($httpcode == 200){
				$jsonOutput = json_decode($server_output);
				curl_close ($ch);
				$red_url = base_url()."Menu?centerid=".$data['centerid']."&date=".$data['currentDate'];
				redirect($red_url);
			}
			else if($httpcode == 401){
				return 'error';
			}
		}else{
			redirect("welcome");
		}
	}

	public function deleteMenuItem($menuid)
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."/Recipes/deleteMenuItem/".$data['userid']."/".$menuid;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken'),
				'Content-Type:application/json'
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				echo $server_output;			
			}
		}else{
			redirect('welcome');
		}
	}

	public function getRecipesList()
	{
		if($this->session->has_userdata('LoginId')){
			$data= $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL . "Recipes/getCentersMenu/";	
			// echo $url ."\t";
			// echo "X-Device-Id: " . $this->session->userdata('X-Device-Id') . "\t";	
			// echo "X-Token: " . $this->session->userdata('AuthToken') . "\t";	
			// echo json_encode($data);
			// exit();
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
			}
			if($httpcode == 401){
				redirect('Welcome');
			}
		}else{
			redirect("Welcome");
		}
	}

	public function get_date_menu(){
		//print_r($_POST);
		if($this->session->has_userdata('LoginId')){
			$data= $this->input->post();

			$data['userid'] = $this->session->userdata('LoginId');
			$data['date']   = $_POST['date'];
			$data['center_id'] = $_POST['center_id'];

			$url = BASE_API_URL."Recipes/getrecipesfrom_date";			
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

				$server_output=json_decode($server_output);
				$data['output']=$server_output;
				$data['weekday_type']=$_POST['weekday'];
				
				$this->load->view('show_date_menu',$data);
				
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect("welcome");
		}
	}

}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */