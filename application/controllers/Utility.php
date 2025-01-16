<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Utility extends CI_Controller {
	
		public function __construct()
		{
			parent::__construct();
		}

		public function index(){

		}
	
		public function getCenterChilds($centerid = NULL)
		{
			if($this->session->has_userdata('LoginId')){
                $usertype = strtoupper($this->session->userdata('UserType'));
                if($usertype == "PARENTS" || $usertype == "PARENT"){
                    $data['Status'] = "ERROR";
                    $data['Message'] = "Parents are not allowed to view!";
                    echo json_encode($data);
                }else{
                    if (empty($centerid) || $centerid == "undefined") {
                        $centerArr = $this->session->userdata("centerIds");
                        $data['centerid'] = $centerArr[0]->id;
                    }else{
                        $data['centerid'] = $centerid;
                    }

                    $data['userid'] = $this->session->userdata('LoginId');
                    $url = BASE_API_URL."/Children/getCenterChilds";
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
                        'X-Token: '.$this->session->userdata('AuthToken')
                    ));
                    $server_output = curl_exec($ch);
                    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close ($ch);
                    if($httpcode == 200){
                        echo $server_output;					
                    }else{
                        $data = [];
                        $data['Status'] = "ERROR";
                        $data['Message'] = "Something Went Wrong!";
                        echo json_encode($data);
                    }
                }
			}else{
				$data = [];
				$data['Status'] = "ERROR";
				$data['Message'] = "Session timeout! Please relogin to continue.";
				echo json_encode($data);
			}
		}
	
	}
	
	/* End of file Utility.php */
	/* Location: ./application/controllers/Utility.php */	