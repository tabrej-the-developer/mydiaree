<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	//index for welcome controller
	public function index()
	{
	    $data['deviceid'] = $this->getIpAddress();
	    $url = BASE_API_URL.'login/getLogins/'.$data['deviceid'];	
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//echo $httpcode; exit;
		if($httpcode == 200){
			$jsonOutput = json_decode($server_output);
			if(!empty($jsonOutput))
			{
				$data['users']=$jsonOutput;
				//print_r($jsonOutput);exit;
				$this->load->view('welcome_users',$data);
			}else{
				$this->load->view('welcome_message');
			}
		}
		
	}

	public function account()
	{
		$this->load->view('welcome_message');
	}
	public function account2()
	{
		$this->load->view('indexpage');
	}



	//function to get ip address
	function getIpAddress(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//whether ip is from proxy
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else{
			//whether ip is from remote address
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		return $ip_address;
	}
}
