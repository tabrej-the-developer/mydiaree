 <?php
defined('BASEPATH') OR exit('No direct script access allowed');  
  
class Login extends CI_Controller {  
	public function __construct()
	{
		parent::__construct();
		$this->load->model('LoginModel');
	}
      
    public function index()  
    {  
        $this->load->view('login');  
    }

	public function getLogins($deviceId){
		
		$data = $this->LoginModel->getLogins($deviceId);
		http_response_code(200);
		echo json_encode($data);
	}

	public function getUserValidation(){
		
		// header('Content-Type: application/json');

		// Check all possible input sources
		$json = json_decode(file_get_contents('php://input'));
	
		// echo json_encode([
		// 	'php_input' => $json,
		// 	'post_data' => $_POST,
		// 	'request_data' => $_REQUEST,
		// ]);
	

		// If raw JSON is null, use $_POST
		if (is_null($json)) {
			$json = (object) $_POST;
		}

		// print_r($json);
		// exit;
	
		// Output for debugging (You can remove this in production)
		// echo json_encode([
		// 	'received_data' => $json
		// ]);
		// exit;
		 

		if($json != null){
			$email = $json->user_name;
			$password = sha1($json->password);
			$deviceid = $json->deviceid;
			$devicetype = isset($json->devicetype) ? $json->devicetype : 'MOBILE';
			$userType = isset($json->userType) ? $json->userType : NULL ;

			if($email != "" && $email != null && $password != "" && $password != null && $deviceid != "" && $deviceid != null){
				$this->load->model('LoginModel');
				$user = $this->LoginModel->getUser($email,$password);
				$emailExist = $this->LoginModel->getUserFromUsername($email);
                // print_r($emailExist); 
				// echo "-----$email ========$password";
				// print_r($user);
				//  exit;
				if($user == null){
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid email id or password";
					if($userType == 'Staff'){
						if($emailExist == null){
							$data['Status'] = "ERROR";
							$data['Message'] = "Username does not exist. Please contact the admin.";
						}else{
							$data['Status'] = "ERROR";
							$data['Message'] = "Invalid PIN";
						}
					} else {
						if($emailExist == null){
							$data['Status'] = "ERROR";
							$data['Message'] = "User does not exist";
						}else{
							$data['Status'] = "ERROR";
							$data['Message'] = "Invalid Password";
						}
					}
				}elseif($user->userType != $userType){
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "You are not an $userType";
				} else{
					http_response_code(200);
					$authToken = uniqid();
					$this->LoginModel->insertLogin($user->userid,$deviceid,$authToken,$devicetype);
					$data['Status'] = "SUCCESS";
					$data['AuthToken'] = $authToken;
					$data['userid'] = $user->userid;
					$data['email'] = $user->emailid;
					$data['name'] = $user->name;
					$data['role'] = $user->userType;
					$data['imageUrl'] = $user->imageUrl;
					$data['title'] = $user->title;
					$theme = $this->LoginModel->getTheme($user->theme);
					if ($theme) {
						$data['container'] = $theme->cssname;
						$data['layout'] = $theme->layoutcss;
					}else{
						$data['container'] = "container.css";
						$data['layout'] = "layout.css";
					}
					

					$data['centers'] = [];
					if ($user->userType=="Parent") {
						$data['centers'] = $this->LoginModel->getParentCenters($user->userid);
					} else {
						$data['centers'] = $this->LoginModel->getUserCenters($user->userid);
					}
					$data['permissions'] = $this->LoginModel->getPermissions($user->userid);
					$this->logs($data);
				}
			}
			else{
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid parameters";
			}
			echo json_encode($data);
		}
		else{
			http_response_code(401);
		}
	}


	


	function logs($params){
		$ip = $this->get_client_ip();
		$data['usertype'] = $params['role'];
		$data['userid'] = $params['userid'];
		$data['login_at'] = date('Y-m-d H:i:s');
		$data['auth_token'] = $params['AuthToken'];
		$data['ip'] = $ip;
		$this->load->model('LoginModel');
		$this->LoginModel->logs($data);
	}

	function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}
}  
?>