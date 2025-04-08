<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
use Intervention\Image\ImageManager;

  
class Reflections extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->database(); 
		$this->load->library('image_intervention');

	  }

    public function index()  
    {
		if($this->session->has_userdata('LoginId')){
            redirect('Reflections/getUserReflections');
		}else{
			$this->load->view('welcome');
		}
    }

	public function getUsersPermissions($centerid=NULL,$print=NULL)
	{
		if ($this->session->has_userdata("LoginId")) {
			$data =  $this->input->post();
			$data['centerid'] = $centerid;
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL.'Settings/getUsersPermissions';
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
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$jsondata = json_decode($server_output);
			
			$permissions = $jsondata->permissions;
			
			if($print==NULL){
				return $permissions;
			}else{
				print_r($permissions);
			}
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Session timeout! Please relogin.";
			echo json_encode($data);
		}
	}

    public function getUserReflections()
	{	
		if($this->session->has_userdata('LoginId')){
					

			if(empty($_GET['centerid'])){
				$centers = $this->session->userdata("centerIds");
				$defCenter = $centers[0]->id;
			}else{
				$data = $this->input->get();
				$defCenter = $data['centerid'];
			}
	
			$data['userid'] = $this->session->userdata('LoginId');
			$data['userType'] = $this->session->userdata("UserType");
			$data['centerid'] = $defCenter;
		    $url = BASE_API_URL."Reflections/getUserReflections/".$this->session->userdata('LoginId')."/". $defCenter;
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
			curl_close($ch); 

			// echo "<pre>";
			// print_r($server_output);
			// exit;
			if($httpcode == 200){
				$data = [];
				$jsondata = json_decode($server_output);
			
				
				$data['reflection'] = $jsondata->Reflections;
				// $data['permission'] = $this->getUsersPermissions($defCenter);
				$data['permission'] = $jsondata->permission;
				$this->load->view('Reflection_v4',$data);
				// $this->load->view('Reflection_form-newui',$data);				
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
	   }else{
		redirect('welcome');
	   }
	}

	public function createReflection()
	{	
		if($this->session->has_userdata('LoginId')){
			
			if(empty($_GET['centerid'])){
				$centers = $this->session->userdata("centerIds");
				$defCenter = $centers[0]->id;
			}else{
				$data = $this->input->get();
				$defCenter = $data['centerid'];
			}
			$data['userid'] = $this->session->userdata('LoginId');
			$data['userType'] = $this->session->userdata("UserType");
			$data['centerid'] = $defCenter;
			
		    $url = BASE_API_URL."Reflections/getReflectionDetails?centerid=".$defCenter;
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
			curl_close($ch);
			//print_r($server_output); exit;
			if($httpcode == 200){
				$data = [];
				$jsondata = json_decode($server_output);
				$data['child'] = $jsondata->Childs;
				$data['Educator'] = $jsondata->Educators;
				$data['centerid'] = $defCenter;
                $childArr = $this->getChildRecords($defCenter,NULL);
				// $data['Childrens'] = $childArr->Childrens;
				$data['Childrens'] = $childArr->Childrens;
				$data['Groups'] = $childArr->Groups;
				$data['Rooms'] = $childArr->Rooms;

				      // Fetch EYLF Outcomes
					  $eylf_outcomes = $this->db->select('id, title, name')
					  ->order_by('title', 'ASC')
					  ->get('eylfoutcome')
					  ->result();

				    // Fetch EYLF Activities for each outcome
					$outcomes_with_activities = [];
					foreach ($eylf_outcomes as $outcome) {
					$activities = $this->db->select('id, outcomeId, title')
				   ->where('outcomeId', $outcome->id)
				   ->get('eylfactivity')
				   ->result();
		
				  $outcome->activities = $activities;
				  $outcomes_with_activities[] = $outcome;
				   }
				$data['eylf_outcomes'] = $outcomes_with_activities;

				// $this->load->view('createReflection-newui',$data);	
				// echo "<pre>";
				// print_r($data);
				// exit;			 
				$this->load->view('createReflection_v4',$data);				
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
	   }else{
		redirect('welcome');
	   }
	}

	public function print($reflectionId) {
		// Check if user is logged in
		if (!$this->session->has_userdata('LoginId')) {
			redirect('login');
		}
		
		// Get reflection data
		$data['reflection'] = $this->db->where('id', $reflectionId)
								   ->get('reflection')
								   ->row_array();

								   if (!empty($data['reflection']['roomids'])) {
									// Convert room IDs string to an array
									$roomIds = explode(',', $data['reflection']['roomids']);
								
									// Fetch room names where id matches the given IDs
									$rooms = $this->db->where_in('id', $roomIds)
													  ->select('name')
													  ->get('room')
													  ->result_array();
								
									// Extract names from the result array
									$roomNames = array_column($rooms, 'name');
								
									// Convert array to a comma-separated string
									$data['reflection']['room_names'] = implode(', ', $roomNames);
								}						   
		
		// Get reflection child data
		$data['reflectionChildren'] = $this->db->where('reflectionid', $reflectionId)
										  ->get('reflectionchild')
										  ->result_array();
		
		// Get all child data associated with this reflection
		$childIds = array();
		foreach ($data['reflectionChildren'] as $refChild) {
			$childIds[] = $refChild['childid'];
		}
		
		if (!empty($childIds)) {
			$data['children'] = $this->db->where_in('id', $childIds)
									->get('child')
									->result_array();

									  // Create comma-separated string of children names
        $childrenNames = array();
        foreach ($data['children'] as $child) {
            $childrenNames[] = $child['name'] . ' ' . $child['lastname'];
        }
        $data['childrenNamesString'] = implode(', ', $childrenNames);
		} else {
			$data['children'] = array();
		}

		
		
		// Get reflection media data
		$data['reflectionMedia'] = $this->db->where('reflectionid', $reflectionId)
									   ->get('reflectionmedia')
									   ->result_array();
		
		// Get reflection staff data
		$data['reflectionStaff'] = $this->db->where('reflectionid', $reflectionId)
									   ->get('reflectionstaff')
									   ->result_array();
		
		// Get all staff user data
		$staffIds = array();
		foreach ($data['reflectionStaff'] as $refStaff) {
			$staffIds[] = $refStaff['staffid'];
		}
		
		if (!empty($staffIds)) {
			$data['staffUsers'] = $this->db->where_in('userid', $staffIds)
									  ->get('users')
									  ->result_array();

									   // Create comma-separated string of staff names
        $staffNames = array();
        foreach ($data['staffUsers'] as $staff) {
            $staffNames[] = $staff['name'];
        }
        $data['staffNamesString'] = implode(', ', $staffNames);

		} else {
			$data['staffUsers'] = array();
		}
		
		// Load the view with all the data
		// echo "<pre>";
		// print_r($data);
		// exit;
		$this->load->view('print_reflections_template', $data);
	}

	public function addreflection()
	{
		if ($this->session->has_userdata('LoginId')) {
			$this->load->helper('form');
			$data = $this->input->post();
			$data['room'] = implode(",", $data['room']);

			
			// echo "<pre>";
			// print_r($data); 
            // // print_r($_FILES); 
            // exit;


			$data['userid'] = $this->session->userdata('LoginId');
			$data['createdAt'] = date('Y-m-d H:i:s');
			$data['createdBy'] = $data['userid'];
			$data['childs'] = json_encode($data['childId']);
            unset($data['childId']);
			$data['educators'] = json_encode($data['Educator']);
			unset($data['Educator']);
			
			if (!empty($_FILES['media'])) {
				$filesCount = count($_FILES['media']['name']);
			
				for ($i = 0; $i < $filesCount; $i++) {
					$fileSize = $_FILES['media']['size'][$i];
					$tempPath = $_FILES['media']['tmp_name'][$i];
					$originalName = $_FILES['media']['name'][$i];
					$fileType = $_FILES['media']['type'][$i];
			
					// Get rotation angle from POST data
					$rotationKey = 'image_rotation_' . $i;
					$rotationAngle = isset($_POST[$rotationKey]) ? (int)$_POST[$rotationKey] : 0;
			
					// Normalize rotation to always be within 0-360
					$rotationAngle = $rotationAngle % 360; 
			
					// Convert clockwise CSS rotation to counterclockwise Intervention Image rotation
					$rotationAngle = -$rotationAngle;  
			
					// Load image using Intervention Image
					$image = \Intervention\Image\ImageManagerStatic::make($tempPath);
			
					// Apply rotation only if needed
					if ($rotationAngle !== 0) {
						$image->rotate($rotationAngle);  // Correct rotation direction
						$rotatedFile = sys_get_temp_dir() . '/' . uniqid('rotated_', true) . '.' . pathinfo($originalName, PATHINFO_EXTENSION);
						$image->save($rotatedFile);
						$tempPath = $rotatedFile;
					}
			
					// Check if file is larger than 2MB for compression
					if ($fileSize > 2 * 1024 * 1024) {
						$compressedFile = sys_get_temp_dir() . '/' . uniqid('compressed_', true) . '.' . pathinfo($originalName, PATHINFO_EXTENSION);
			
						try {
							// Compress and save the image
							$compressedPath = $this->image_intervention->compress($tempPath, $compressedFile, 1024, 70);
			
							if ($compressedPath) {
								$tempPath = $compressedPath;
							}
						} catch (Exception $e) {
							log_message('error', 'Image Compression Error: ' . $e->getMessage());
						}
					}
			
					// Assign processed file for upload
					$data['media' . $i] = new CurlFile($tempPath, $fileType, $originalName);
				}
			}
			
			
			
			

			// $data['description'] = trim(stripslashes(htmlspecialchars($data['description'])));
			$url = BASE_API_URL."Reflections/createReflection/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken'),
				'Content-Type: multipart/form-data'
			));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				curl_close ($ch);
				$data = json_decode($server_output);
				// echo "<pre>";
				// print_r($data);
				// exit;
				redirect("Reflections");
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		} else {
			redirect("welcome");
		}
	}

	public function deleteReflection()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->post();
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."Reflections/deleteReflection/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			echo $server_output;
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Login error";
			echo json_encode($data);
		}
	}

	public function Reflection_update()
	{
		if($this->session->has_userdata('LoginId')){
			if(empty($_GET['centerId'])){
				$centers = $this->session->userdata("centerIds");
				$defCenter = $centers[0]->id;
			}else{
				$data = $this->input->get();
				$defCenter = $data['centerId'];
			}
			$data['userid'] = $this->session->userdata('LoginId');
			$data['userType'] = $this->session->userdata("UserType");
			$data['centerid'] = $defCenter;
			$data['reflectionid'] = isset($_GET['reflectionid'])?$_GET['reflectionid']:null;
			$url = BASE_API_URL."Reflections/getReflection/";
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
			curl_close($ch);
			if($httpcode == 200){
				$data = [];
				$data = json_decode($server_output);
                $childArr = $this->getChildRecords($defCenter,$_GET['reflectionid']);
				$data->child = $childArr->Childrens;
				$data->Groups = $childArr->Groups;
				$data->Rooms = $childArr->Rooms;	

			
				
				$eylf_outcomes = $this->db->select('id, title, name')
				->order_by('title', 'ASC')
				->get('eylfoutcome')
				->result();

			  // Fetch EYLF Activities for each outcome
			  $outcomes_with_activities = [];
			  foreach ($eylf_outcomes as $outcome) {
			  $activities = $this->db->select('id, outcomeId, title')
			 ->where('outcomeId', $outcome->id)
			 ->get('eylfactivity')
			 ->result();
  
			$outcome->activities = $activities; 
			$outcomes_with_activities[] = $outcome;
			 }
		  $data->eylf_outcomes = $outcomes_with_activities;

		  if (isset($data->Reflections->staffs) && is_array($data->Reflections->staffs)) {
			$staffIDs = array();
			foreach ($data->Reflections->staffs as $staff) {
				if (isset($staff->userid)) {
					$staffIDs[] = $staff->userid;
				}
			}
			$data->Reflections->staffsID = implode(',', $staffIDs);
		} else {
			$data->Reflections->staffsID = ''; // Or null, or handle the case as needed
		}

		//   echo "<pre>";
		//   print_r($data);
		//   exit;

				$this->load->view('reflectionUpdate_v4.php',$data);			
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
	   }else{
		redirect('welcome');
	   }
	}

	public function updateReflection()
	{
		if($this->session->has_userdata('LoginId')){
			$this->load->helper('form');
			$data = $this->input->post();
			// echo "<pre>";
			// print_r($data);
			// exit;
			$data['userid'] = $this->session->userdata('LoginId');
			$data['reflectionid'] = $_GET['reflectionId'];

			$data['room'] = implode(",", $data['room']);

            
			$data['childs'] = json_encode($data['childId']);
            unset($data['childId']);
			$data['educators'] = json_encode($data['Educator']);
			unset($data['Educator']);
			// if(!empty($_FILES['media'])){
			// 	$filesCount = count($_FILES['media']['name']);
			// 	for ($i=0; $i < $filesCount; $i++) {
			// 		if(!empty($_FILES['media']['tmp_name'][$i])){
			// 			$data['media'.$i]= new CurlFile($_FILES['media']['tmp_name'][$i],$_FILES['media']['type'][$i],$_FILES['media']['name'][$i]);
			// 		}
			// 	}
			// }

			if (!empty($_FILES['media'])) {
				$filesCount = count($_FILES['media']['name']);
			
				for ($i = 0; $i < $filesCount; $i++) {
					// Skip if there's no valid uploaded file
					if (empty($_FILES['media']['tmp_name'][$i]) || $_FILES['media']['error'][$i] !== UPLOAD_ERR_OK) {
						continue;
					}
			
					$fileSize = $_FILES['media']['size'][$i];
					$tempPath = $_FILES['media']['tmp_name'][$i];
					$originalName = $_FILES['media']['name'][$i];
					$fileType = $_FILES['media']['type'][$i];
					
					// Verify file exists and is readable
					if (!file_exists($tempPath) || !is_readable($tempPath)) {
						log_message('error', 'File not accessible: ' . $tempPath);
						continue;
					}
			
					// Get rotation angle from POST data
					$rotationKey = 'image_rotation_' . $i;
					$rotationAngle = isset($_POST[$rotationKey]) ? (int)$_POST[$rotationKey] : 0;
					
					// Normalize rotation to always be within 0-360
					$rotationAngle = $rotationAngle % 360;
					
					// Convert clockwise CSS rotation to counterclockwise Intervention Image rotation
					$rotationAngle = -$rotationAngle;
					
					// Only attempt to load image if rotation is needed or needs compression
					$needsProcessing = ($rotationAngle !== 0 || $fileSize > 2 * 1024 * 1024);
					
					if ($needsProcessing) {
						try {
							// Load image using Intervention Image
							$image = \Intervention\Image\ImageManagerStatic::make($tempPath);
							
							// Apply rotation if needed
							if ($rotationAngle !== 0) {
								$image->rotate($rotationAngle);  // Correct rotation direction
								$rotatedFile = sys_get_temp_dir() . '/' . uniqid('rotated_', true) . '.' . pathinfo($originalName, PATHINFO_EXTENSION);
								$image->save($rotatedFile);
								$tempPath = $rotatedFile;
							}
							
							// Check if file is larger than 2MB for compression
							if ($fileSize > 2 * 1024 * 1024) {
								$compressedFile = sys_get_temp_dir() . '/' . uniqid('compressed_', true) . '.' . pathinfo($originalName, PATHINFO_EXTENSION);
								
								try {
									// Compress and save the image
									$compressedPath = $this->image_intervention->compress($tempPath, $compressedFile, 1024, 70);
									
									if ($compressedPath) {
										$tempPath = $compressedPath;
									}
								} catch (Exception $e) {
									log_message('error', 'Image Compression Error: ' . $e->getMessage());
								}
							}
						} catch (Exception $e) {
							// Log the error and continue with the original file
							log_message('error', 'Image Processing Error: ' . $e->getMessage());
							// Use the original file without processing
							$tempPath = $_FILES['media']['tmp_name'][$i];
						}
					}
			
					// Assign processed file for upload
					$data['media' . $i] = new CurlFile($tempPath, $fileType, $originalName);
				}
			}


			$url = BASE_API_URL."Reflections/updateReflection/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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
				$rurl = base_url()."Reflections/getUserReflections";
				redirect($rurl);
			}
			if($httpcode == 200){
				redirect("welcome");
			}
		}else{
			$data = [];
			$data['Status'] = "ERROR";
			$data['Message'] = "Login error";
			echo json_encode($data);
		}
	}

	// public function save_file() {


	// 	echo "<pre>";
	// 	print_r($_FILES);
	// 	exit;

	// 	if (!empty($_FILES['image']['name'])) {
	// 		$config['upload_path'] = './uploads/';
	// 		$config['allowed_types'] = 'jpg|jpeg|png';
	// 		$config['file_name'] = uniqid('img_');
	
	// 		if (!is_dir($config['upload_path'])) {
	// 			mkdir($config['upload_path'], 0755, true);
	// 		}
	
	// 		$this->load->library('upload', $config);
	
	// 		if ($this->upload->do_upload('image')) {
	// 			$uploadData = $this->upload->data();
	// 			$filename = $uploadData['file_name'];
	
	// 			// Save to DB
	// 			$this->db->insert('images', [
	// 				'image_name' => $filename,
	// 				'uploaded_at' => date('Y-m-d H:i:s')
	// 			]);
	
	// 			echo "Image uploaded: " . $filename;
	// 		} else {
	// 			echo "Upload failed: " . $this->upload->display_errors('', '');
	// 		}
	// 	} else {
	// 		echo "No image received";
	// 	}
	// }
	
	public function receive_rotated_image() {
		// $data =  $this->input->post();
		
		if (!empty($_FILES['image']['tmp_name'])) {
			$fileSize = $_FILES['image']['size'];
			$tempPath = $_FILES['image']['tmp_name'];
			$fileName = $_FILES['image']['name'];
			$fileType = $_FILES['image']['type'];
			$reflectionid = $this->input->post('reflectionIds'); 
	
			// Check size and compress if needed
			if ($fileSize > 2 * 1024 * 1024) {
				$compressedFile = tempnam(sys_get_temp_dir(), 'compressed_');
				$compressedFile .= '.' . pathinfo($fileName, PATHINFO_EXTENSION);
	
				$compressedPath = $this->image_intervention->compress(
					$tempPath, $compressedFile, 1024, 70
				);
	
				$sendFile = $compressedPath
					? new CurlFile($compressedPath, $fileType, $fileName)
					: new CurlFile($tempPath, $fileType, $fileName);
			} else {
				$sendFile = new CurlFile($tempPath, $fileType, $fileName);
			}

		
			// Prepare cURL data
			$data = [
				'obsMedia0' => $sendFile,
				'reflectionId' => $reflectionid 
			];
			
		// echo "<pre>";
		// print_r($data);
		// exit;
	
	
			$url = base_url('Reflections/image_upload_endpoint');
			$url = BASE_API_URL."Reflections/image_upload_endpoint";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				'X-Device-Id: ' . $this->session->userdata('X-Device-Id'),
				'X-Token: ' . $this->session->userdata('AuthToken')
			]);
	
			$response = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
	
			echo ($httpcode == 200) ? "Image uploaded successfully" : "Upload failed with code $httpcode";
		} else {
			echo "No file received.";
		}
	}
	
	

	public function deleteMedia() {
		$reflectionid = $this->input->post('reflectionid');
		$mediaurl = $this->input->post('mediaurl');
	
		if (!$reflectionid || !$mediaurl) {
			echo json_encode(['status' => 'error', 'message' => 'Missing data']);
			return;
		}
	
		// Full path to file
		$file_path = FCPATH . 'assets/media/' . $mediaurl;
	
		// Delete from database
		$this->db->where('reflectionid', $reflectionid);
		$this->db->where('mediaUrl', $mediaurl);
		$delete = $this->db->delete('reflectionmedia');
	
		if ($delete) {
			if (file_exists($file_path)) {
				unlink($file_path); // delete physical file
			}
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Database delete failed']);
		}
	}
	
	

    public function getChildRecords($centerid='',$refid='')
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata('LoginId');
			$data['centerid'] = $centerid;
			$data['refid'] = $refid;
	   		$url = BASE_API_URL."Reflections/getChildRecords/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				return $jsonOutput;	
			}
			else if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}
}  