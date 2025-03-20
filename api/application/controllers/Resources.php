<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resources extends CI_Controller {

	function __construct($foo = null)
	{
		$this->foo = $foo;

		parent::__construct();

        $this->load->model('ResourcesModel');
		$this->load->model('ObservationModel');
		$this->load->model('LoginModel');

		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");

		$method = $_SERVER['REQUEST_METHOD'];

		if($method == "OPTIONS") {
			die();
		}
	}

	public function index()
	{	
	}

	public function addResources()
    {
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($res != null && $res->userid == $_POST['userid']){
                #error checking variable
                $error = 0;
                #create new resorce record
                
                $tagsArr = [];
                $userLink = [];

                //Process title for saving into db
                
                if (!empty($_POST['description'])) {
                    preg_match_all('/<a .*?>(.*?)<\/a>/',html_entity_decode($_POST['description']),$titleMatch);
                    foreach ($titleMatch[1] as $key => $obj) {
                        if (strpos($obj, '#') !== false) {
                            $getTags = $this->ResourcesModel->getTagsCount($obj);
                            if ($getTags->number > 0) {
                                $this->ResourcesModel->updateTagsCount($obj);
                            }else{
                                $this->ResourcesModel->insertResTags($obj);
                            }
                        }
                    }
                    $_POST['description'] = str_replace("a href=","a link='#link' href=",$_POST['description']);
                    $_POST['description'] = html_entity_decode($_POST['description']);
                    preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i',html_entity_decode($_POST['description']),$descMatch);
                    foreach ($descMatch['href'] as $key => $obj) {
                        if (!in_array($obj, $userLink)) {
                            array_push($userLink, $obj);
                        }
                    }

                    $linkDom = new DOMDocument;
                    $linkDom->loadHTML($_POST['description']);
                    $allLinks = $linkDom->getElementsByTagName('a');
                    $i = 0;
                    foreach ($allLinks as $rawLink) {
                        $longLink = $rawLink->getAttribute('link');
                        $shortURL = $userLink[$i];
                        $rawLink->setAttribute('link', $shortURL);
                        $i++;
                    }
                    $_POST['description'] = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">','',$linkDom->saveHTML());
                    $_POST['description'] = str_replace('<html><body>','',$_POST['description']);
                    $_POST['description'] = str_replace('</body></html>','',$_POST['description']);
                    $_POST['description'] = htmlspecialchars($_POST['description']);
                }

                $resId = $this->ResourcesModel->addResource($_POST);

                #insert resource medias
                $countFiles = count($_FILES);
                foreach ($_FILES as $rsMedia => $rsm) {
                    if ($rsm['name']!="") {
                        if ($rsm['type']=="image/jpeg" || $rsm['type']=="image/jpg" || $rsm['type']=="image/png") {

                            $newName = uniqid();
                            $extension = explode('/', $rsm['type']);
                            $target_dir = "assets/media/".$newName.".".$extension[1];
                            move_uploaded_file($rsm['tmp_name'], $target_dir);
                            $this->ResourcesModel->insResMedia($resId,$newName.".".$extension[1],'Image');

                        } elseif($rsm['type']=="video/mp4" || $rsm['type']=="video/mkv") {
                            
                            $newName = uniqid();
                            $extension = explode('/', $rsm['type']);
                            $target_dir = "assets/media/".$newName.".".$extension[1];
                            move_uploaded_file($rsm['tmp_name'], $target_dir);
                            $this->ResourcesModel->insResMedia($resId,$newName.".".$extension[1],'Video');

                        }else{
                            $error = 1;
                        }
                    }
                }

                #Checking errors
                if($error==1){
                    $data['Status'] = 'WARNING';
                    $data['Message'] = stripslashes('Some resources file/s is/are not uploaded');
                }else{
                    $data['Status'] = 'SUCCESS';
                    $data['Message'] = 'Resource created successfully';
                }
                
                #sending data
                echo json_encode($data);
            }else{
				$data['Status'] = 'ERROR';
				$data['Message'] = 'Invalid Data';
				http_response_code(401);
				echo json_encode($data);
			}
		}else{
			http_response_code(401);
		}
    }

    public function getResource()
    {
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
                $resId = $json->resourceid;
                $resourcesArr = $this->ResourcesModel->getResource($resId); //call blank function to get all resources
                foreach ($resourcesArr as $resources => $resArr) {
                    $resArr->description = htmlspecialchars($resArr->description);
                    #media info insertion into api
                    $media = [];
                    $mediaArr = $this->ResourcesModel->getResourceMedia($resArr->id);
                    foreach ($mediaArr as $mediasArr => $mArr) {
                        array_push($media,$mArr);
                    }
                    $resArr->media = $media;

                    #likes detail insertion into api
                    $likesArr = $this->ResourcesModel->getResourceLikes($resArr->id);
                    $likesCount = count($likesArr);
                    $liked = 0;
                    $likeid = NULL;
                    $likesDtl = [];
                    foreach($likesArr as $lyksArr=>$lykObj){
                        if($lykObj->userid==$json->userid){
                            $liked = 1;
                            $likeid = $lykObj->id;
                        }else{
                            $liked = 0;
                            $likeid = NULL;
                        }
                    }
                    $likesDtl['liked'] = $liked;
                    $likesDtl['likeid'] = $likeid;
                    $likesDtl['likesCount'] = $likesCount;
                    $resArr->likes = $likesDtl;

                    #comment details insertion into api
                    $commentsArr = $this->ResourcesModel->getResourceComments($resArr->id);
                    $commentsCount = count($commentsArr);
                    $comments['commentsCount'] = $commentsCount;
                    $comments['commentsList'] = [];
                    foreach ($commentsArr as $key => $cmntsObj) {
                        $userDetailsArr = $this->ResourcesModel->getUserDetails($cmntsObj->userid);
                        $c["userName"] = $userDetailsArr->name;
                        $c['userComment'] = $cmntsObj->comment;
                        $c['commentTime'] = date("d-m-Y H:i:s",strtotime($cmntsObj->createdAt));
                        array_push($comments['commentsList'],$c);
                    }
                    $resArr->comment = $comments;
                }
                $result = $this->ResourcesModel->getAllStaff();
                $tags = $this->ObservationModel->getMonSubActs();
                $data['Status'] = "SUCCESS";
                $data['users'] = $result;
                $data['tags'] = $tags;
                $data['Resource'] = $resArr;
            }else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }

    public function getPublishedResources()
    {
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
                $userid = $json->userid;
                //filter variables

                if (isset($json->fromdate) && !empty($json->fromdate)) {

                    $fromdate = date("Y-m-d",strtotime($json->fromdate));

                    if (isset($json->todate) && !empty($json->todate)) {
                        $todate = date("Y-m-d",strtotime($json->todate));
                    }else{
                        $todate = date("Y-m-d");
                    }
                }else{
                    $fromdate = "";
                    $todate = "";
                }

                

                if (isset($json->centerid) && !empty($json->centerid)) {
                    $centerid = trim(strip_tags(stripslashes($json->centerid)));
                }else{
                    $centerid = "";
                }

                if (isset($json->author) && !empty($json->author)) {
                    $author = trim(strip_tags(stripslashes($json->author)));
                }else{
                    $author = "";
                }

                if (isset($json->page)) {
                    $page = $json->page;
                }else{
                    $page = 0;
                }
                //filter ends
                $userDetails = $this->ResourcesModel->getUserDetails($userid);
                if($userDetails->userType == "Superadmin"){
                    $adminId = $userid;
                }else{
                    #find center
                    $centersArr = $this->ResourcesModel->getUserCenters($userid,1); //userid and number of centers required
                    if(empty($centersArr[0]->centerid)) {
                        $data['Status'] = "ERROR";
                        $data['Message'] = "User doesn't has any centers.";
                    } else {
                        $centerId = $centersArr[0]->centerid;
                        #find users
                        $centerUsersArr = $this->ResourcesModel->getUsersFromCenter($centerId);

                        #get admin id
                        foreach ($centerUsersArr as $cenUsrArr => $cua) {
                            $uid = $cua->userid;
                            $isAdmin = $this->ResourcesModel->isAdmin($uid);
                            if ($isAdmin) {
                                $adminId = $uid;
                            }
                        }
                    }
                }

                if ($author != "" || $centerid!="" || $todate !="" || $fromdate!="") {
                    $filter = new stdClass();
                    $filter->centerid = $centerid;
                    $filter->todate = $todate;
                    $filter->fromdate = $fromdate;
                    $filter->author = $author;
                    $filter->page = $page;
                    $resourcesArr = $this->ResourcesModel->getFilterResources($filter);
                    foreach($resourcesArr as $resArr => $res){
                        $resourceId = $res->id;
                        $res->description = trim(stripslashes($res->description));
                        $res->createdBy = $this->ResourcesModel->getUsername($res->createdBy);
                        #Media array
                        $media = [];
                        $mediaArray = $this->ResourcesModel->getResourceMedia($resourceId);
                        foreach ($mediaArray as $mediaArr => $mdArr) {
                            array_push($media,$mdArr);
                        }
                        $res->media = $media;

                        #Likes array
                        $likesArr = $this->ResourcesModel->getResourceLikes($resourceId);
                        $likesCount = count($likesArr);
                        $liked = 0;
                        $likeid = NULL;
                        foreach($likesArr as $lyksArr=>$lykObj){
                            if($lykObj->userid==$userid){
                                $liked = 1;
                                $likeid = $lykObj->id;
                            }else{
                                $liked = 0;
                                $likeid = NULL;
                            }
                        }
                        $likesDtl = [];
                        $likesDtl['liked'] = $liked;
                        $likesDtl['likeid'] = $likeid;
                        $likesDtl['likesCount'] = $likesCount;
                        if (empty($likesDtl)) {
                            $res->likes = NULL;
                        } else {
                            $res->likes = $likesDtl;
                        }

                        #comment details insertion into api
                        $commentsArr = $this->ResourcesModel->getResourceComments($resourceId);
                        $cmntsDtl = [];
                        $commentsCount = count($commentsArr);
                        if ($commentsCount > 0) {
                            foreach($commentsArr as $cmntsArr=>$cmtObj){
                                if($cmtObj->resourceid == $resourceId){
                                    $userDtls = $this->ResourcesModel->getUserDetails($cmtObj->userid);
                                    $exactCmnt = $cmtObj->comment;
                                    $userCmnted = empty($userDtls->name)?"Unknown":$userDtls->name;
                                    $userCmntedImg = empty($userDtls->imageUrl)?"dummy-user.jpg":$userDtls->imageUrl;
                                    $timeCmnted = date('d-m-Y h:i:s',strtotime($cmtObj->createdAt));
                                }
                            }
                            $cmntsDtl['lastComment'] = $exactCmnt;
                            $cmntsDtl['userCommented'] = $userCmnted;
                            $cmntsDtl['userCommentedImage'] = $userCmntedImg;
                            $cmntsDtl['timeCmnted'] = $timeCmnted;
                            $cmntsDtl['totalComments'] = $commentsCount;
                            $res->comments = $cmntsDtl;
                        }else{
                            $cmntsDtl['lastComment'] = NULL;
                            $cmntsDtl['userCommented'] = NULL;
                            $cmntsDtl['timeCmnted'] = NULL;
                            $cmntsDtl['totalComments'] = NULL;
                            $res->comments = $cmntsDtl;
                        }
                    }
                } elseif (!empty($adminId)){
                    $resourcesArr = $this->ResourcesModel->getAllResourcesByAdmin($adminId,$page);
                    foreach($resourcesArr as $resArr => $res){
                        $resourceId = $res->id;
                        $res->description = trim(stripslashes($res->description));
                        $res->createdBy = $this->ResourcesModel->getUsername($res->createdBy);
                        #Media array
                        $media = [];
                        $mediaArray = $this->ResourcesModel->getResourceMedia($resourceId);
                        foreach ($mediaArray as $mediaArr => $mdArr) {
                            array_push($media,$mdArr);
                        }
                        $res->media = $media;

                        #Likes array
                        $likesArr = $this->ResourcesModel->getResourceLikes($resourceId);
                        $likesCount = count($likesArr);
                        $liked = 0;
                        $likeid = NULL;
                        foreach($likesArr as $lyksArr=>$lykObj){
                            if($lykObj->userid==$userid){
                                $liked = 1;
                                $likeid = $lykObj->id;
                            }else{
                                $liked = 0;
                                $likeid = NULL;
                            }
                        }
                        $likesDtl = [];
                        $likesDtl['liked'] = $liked;
                        $likesDtl['likeid'] = $likeid;
                        $likesDtl['likesCount'] = $likesCount;
                        if (empty($likesDtl)) {
                            $res->likes = NULL;
                        } else {
                            $res->likes = $likesDtl;
                        }

                        #comment details insertion into api
                        $commentsArr = $this->ResourcesModel->getResourceComments($resourceId);
                        $cmntsDtl = [];
                        $commentsCount = count($commentsArr);
                        if ($commentsCount > 0) {
                            foreach($commentsArr as $cmntsArr=>$cmtObj){
                                if($cmtObj->resourceid == $resourceId){
                                    $userDtls = $this->ResourcesModel->getUserDetails($cmtObj->userid);
                                    $exactCmnt = $cmtObj->comment;
                                    $userCmnted = empty($userDtls->name)?"Unknown":$userDtls->name;
                                    $userCmntedImg = empty($userDtls->imageUrl)?"dummy-user.jpg":$userDtls->imageUrl;
                                    $timeCmnted = date('d-m-Y h:i:s',strtotime($cmtObj->createdAt));
                                }
                            }
                            $cmntsDtl['lastComment'] = $exactCmnt;
                            $cmntsDtl['userCommented'] = $userCmnted;
                            $cmntsDtl['userCommentedImage'] = $userCmntedImg;
                            $cmntsDtl['timeCmnted'] = $timeCmnted;
                            $cmntsDtl['totalComments'] = $commentsCount;
                            $res->comments = $cmntsDtl;
                        }else{
                            $cmntsDtl['lastComment'] = NULL;
                            $cmntsDtl['userCommented'] = NULL;
                            $cmntsDtl['timeCmnted'] = NULL;
                            $cmntsDtl['totalComments'] = NULL;
                            $res->comments = $cmntsDtl;
                        }
                    }
                }else{
                    $data['Status'] = "ERROR";
                    $data['Message'] = "Admin Id is not available.";
                }
                $result = $this->ResourcesModel->getAllStaff();
                $tagsList = [];
                $d = [];    
                $int = 0;

                $montessoriList = $this->ObservationModel->getMonSubActs(NULL,$json->userid);
                foreach ($montessoriList as $monkey => $monobj) {
                    $d['id'] = $int + 1;
                    $d['rid'] = $monobj->id;                    
                    $d['title'] = $monobj->title;
                    $d['type'] = "Montessori";
                    array_push($tagsList,$d);
                    $int++;
                }

                $d = [];
                $eylfsubactivityList = $this->ObservationModel->getEylfSubActivites(NULL,$json->userid);
                foreach ($eylfsubactivityList as $eylfkey => $eylfobj) {
                    $d['id'] = $int + 1;
                    $d['rid'] = $eylfobj->id;
                    $d['title'] = $eylfobj->title;
                    $d['type'] = "Eylf";
                    array_push($tagsList,$d);
                    $int++;
                }

                $dmsubactivityList = $this->ObservationModel->getDevMileSubActs(NULL,$json->userid);
                foreach ($dmsubactivityList as $dmkey => $dmobj) {
                    $d['id'] = $int + 1;
                    $d['rid'] = $dmobj->id;
                    $d['title'] = $dmobj->name;
                    $d['type'] = "DevMile";
                    array_push($tagsList,$d);
                    $int++;
                }
                $trendingTags = $this->ResourcesModel->getTrendingTags();
                $data['Status'] = "SUCCESS";
                $data['users'] = $result;
                $data['tags'] = $tagsList;
                $data['resources'] = $resourcesArr;
                $data['trendingTags'] = $trendingTags;
            }else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }

    public function addLike(){
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
                $userid = $json->userid;
                $resId = $json->resourceId;
                $result = $this->ResourcesModel->insertLike($userid,$resId);
                $likesArr = $this->ResourcesModel->countLikes($resId);
                if (empty($likesArr)) {
                    $likes = "";
                }else{
                    if ($likesArr->likes == 0) {
                        $likes = "";
                    } else if ($likesArr->likes == 1){
                        $likes = "1 Like";
                    } else {
                        $likes = $likesArr->likes." Likes";
                    }
                }
                if ($result!="") {
                    $data['Status'] = "SUCCESS";
                    $data['Message'] = "Liked";
                    $data['likeId'] = $result;
                    $data['likes'] = $likes;
                } else {
                    $data['Status'] = "ERROR";
                    $data['Message'] = "Can't Like Due to some technical error!";
                }
            }else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }

    public function removeLike(){
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
                $likeId = $json->likeId;
                $resArr = $this->ResourcesModel->getLikeRecord($likeId);
                $result = $this->ResourcesModel->removeLike($likeId);
                $likesArr = $this->ResourcesModel->countLikes($resArr->resourceid);
                if (empty($likesArr)) {
                    $likes = "";
                }else{
                    if ($likesArr->likes == 0) {
                        $likes = "";
                    } else if ($likesArr->likes == 1){
                        $likes = "1 Like";
                    } else {
                        $likes = $likesArr->likes." Likes";
                    }
                }

                if ($result==1) {
                    $data['Status'] = "SUCCESS";
                    $data['likes'] = $likes;
                    $data['Message'] = "Disliked";
                } else {
                    $data['Status'] = "ERROR";
                    $data['likes'] = $likes;
                    $data['Message'] = "Can't dislike due to some technical issue!";
                }
            }else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }

    public function addComment(){
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'], $headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
                $userid = $json->userid;
                $resId = $json->resourceId;
                $comment = $json->comment;
                $last_id = $this->ResourcesModel->insertComment($userid,$resId,$comment);
                $last_comments = $this->ResourcesModel->fetchComments($resId,2,"DESC");
                $last_comments = json_decode(json_encode($last_comments),true);
                $cmntCount = $this->ResourcesModel->countComments($resId);
                if (empty($cmntCount)) {
                    $totalComments ="No Comments";
                } else {
                    if($cmntCount->totalComments == 0){
                        $totalComments = "No Comment";
                    }else if($cmntCount->totalComments == 1){
                        $totalComments = "1 Comment";
                    }else{
                        $totalComments = $cmntCount->totalComments . " Comments";
                    }
                }
                
                usort($last_comments, $this->make_comparer('id'));

                if ($last_id!=NULL) {
                    http_response_code(200);
                    $data['Status'] = "SUCCESS";
                    $data['Message'] = "Comment added successfully!";
                    $data['Comments'] = $last_comments;
                    $data['totalComments'] = $totalComments;
                } else {
                    http_response_code(401);                    
                    $data['Status'] = "ERROR";
                    $data['Message'] = "Can't add comment now. Some technical error occured!";
                }
            }else{
                http_response_code(401);
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            http_response_code(401);
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }

    public function make_comparer() {
        // Normalize criteria up front so that the comparer finds everything tidy
        $criteria = func_get_args();
        foreach ($criteria as $index => $criterion) {
            $criteria[$index] = is_array($criterion)
                ? array_pad($criterion, 3, null)
                : array($criterion, SORT_ASC, null);
        }

        return function($first, $second) use ($criteria) {
            foreach ($criteria as $criterion) {
                // How will we compare this round?
                list($column, $sortOrder, $projection) = $criterion;
                $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

                // If a projection was defined project the values now
                if ($projection) {
                    $lhs = call_user_func($projection, $first[$column]);
                    $rhs = call_user_func($projection, $second[$column]);
                }
                else {
                    $lhs = $first[$column];
                    $rhs = $second[$column];
                }

                // Do the actual comparison; do not return if equal
                if ($lhs < $rhs) {
                    return -1 * $sortOrder;
                }
                else if ($lhs > $rhs) {
                    return 1 * $sortOrder;
                }
            }

            return 0; // tiebreakers exhausted, so $first == $second
        };
    }

    public function removeComment(){
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
                $userid = $json->userid;
                $resId = $json->resourceId;
                $likeId = $json->likeId;
                $result = $this->ResourcesModel->removeComment($commentId);
                if ($result==1) {
                    $data['Status'] = "SUCCESS";
                    $data['Message'] = "Liked";
                } else {
                    $data['Status'] = "ERROR";
                    $data['Message'] = "Can't Like Due to some technical error!";
                }
            }else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }

    public function addShare(){
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
                $userid = $json->userid;
                $resId = $json->resourceId;
                $shareType = $json->shareType;
                $result = $this->ResourcesModel->insertShare($userid,$resId,$shareType);
                if ($result==1) {
                    $data['Status'] = "SUCCESS";
                    $data['Message'] = "Shared";
                } else {
                    $data['Status'] = "ERROR";
                    $data['Message'] = "Can't add share record now. Some technical error occured!";
                }
            }else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }

    public function deleteResource()
    {
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($json!= null && $res != null && $res->userid == $json->userid){
                $userid = $json->userid;
                $resId = $json->resourceId;
                $userDetails = $this->ResourcesModel->getUserDetails($userid);
                if($userDetails->userType == "Superadmin"){
                    $result = $this->ResourcesModel->deleteResource($resId);
                    $data['Status'] = "SUCCESS";
                    $data['Message'] = "Deleted Successfully";
                }else{
                    $resArr = $this->ResourcesModel->getUserResources($userid,$resId); //userid and resourceid(optional) to get single record
                    $countRes = count($resArr);
                    //Check if it is created by the user or not
                    if ($countRes == 1) {
                        $result = $this->ResourcesModel->deleteResource($resId);
                        $data['Status'] = "SUCCESS";
                        $data['Message'] = "Deleted Successfully";

                    } else {
                        $data['Status'] = "ERROR";
                        $data['Message'] = "You are not authorized to delete this resource.";
                    }
                }  
            }else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }

    public function getComments($userid = NULL, $resourceId = NULL)
    {
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
		if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);

            if ($resourceId == NULL || $userid == NULL) {
                $json = json_decode(file_get_contents('php://input'));
                $resourceId = $json->resourceId;
                $userid = $json->userid;
            }

            if($res != null && $res->userid == $userid){
                $commentsArr = $this->ResourcesModel->getComments($resourceId);
                $data['Status'] = "SUCCESS";
                $data['commentsList'] = $commentsArr;
            }else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }
    
    public function getResouceStuff()
    {
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
        if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
            if($json!= null && $res != null && $res->userid == $json->userid){
                $result = $this->ResourcesModel->getAllStaff();
                $tagsList = [];
                $d = [];    
                $int = 0;

                $montessoriList = $this->ObservationModel->getMonSubActs(NULL,$json->userid);
                foreach ($montessoriList as $monkey => $monobj) {
                    $d['id'] = $int + 1;
                    $d['rid'] = $monobj->id;                    
                    $d['title'] = $monobj->title;
                    $d['type'] = "Montessori";
                    array_push($tagsList,$d);
                    $int++;
                }

                $d = [];
                $eylfsubactivityList = $this->ObservationModel->getEylfSubActivites(NULL,$json->userid);
                foreach ($eylfsubactivityList as $eylfkey => $eylfobj) {
                    $d['id'] = $int + 1;
                    $d['rid'] = $eylfobj->id;
                    $d['title'] = $eylfobj->title;
                    $d['type'] = "Eylf";
                    array_push($tagsList,$d);
                    $int++;
                }

                $dmsubactivityList = $this->ObservationModel->getDevMileSubActs(NULL,$json->userid);
                foreach ($dmsubactivityList as $dmkey => $dmobj) {
                    $d['id'] = $int + 1;
                    $d['rid'] = $dmobj->id;
                    $d['title'] = $dmobj->name;
                    $d['type'] = "DevMile";
                    array_push($tagsList,$d);
                    $int++;
                }
                if ($result!=NULL) {
                    $data['Status'] = "SUCCESS";
                    $data['users'] = $result;
                    $data['tags'] = $tagsList;
                } else {
                    $data['Status'] = "ERROR";
                    $data['Message'] = "Something went wrong!";
                }
            }else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }

    public function getAuthorsFromCenter()
    {

        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
        if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
            if($json!= null && $res != null && $res->userid == $json->userid){
                if (empty($json->centerid)) {
                    $data['Status'] = "ERROR";
                    $data['Message'] = "Centerid is empty.";
                } else {
                    $response = $this->ResourcesModel->getAuthorsFromCenter($json->centerid);
                    $data['Status'] = "SUCCESS";
                    $data['Authors'] = $response;
                }
            }else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }

    public function loadAjaxResources()
    {
        $headers = $this->input->request_headers();
$updated_headers = []; // Temporary array to store modified headers

foreach ($headers as $key => $value) {
    $lower_key = strtolower($key);

    // Normalize key names
    if ($lower_key === 'x-device-id') {
        $updated_headers['X-Device-Id'] = $value;
    } elseif ($lower_key === 'x-token') {
        $updated_headers['X-Token'] = $value;
    } else {
        $updated_headers[$key] = $value; // Keep other headers as is
    }
}

// Assign back to $headers
$headers = $updated_headers;
        if($headers != null && array_key_exists('X-Device-Id', $headers) && array_key_exists('X-Token', $headers)){
            $res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
            $json = json_decode(file_get_contents('php://input'));
            if($json!= null && $res != null && $res->userid == $json->userid){
                $tags = json_decode($json->tags);
                $result = $this->ResourcesModel->filterTagsResources($tags);
                foreach($result as $resArr => $res){

                    $resourceId = $res->id;
                    $userInfo = $this->LoginModel->getUserFromId($res->createdBy);
                    if (empty($userInfo)) {
                        $res->imageUrl = "AMIGA-Montessori.jpg";
                        $res->userName = "Unknown";
                    }else{
                        $res->imageUrl = empty($userInfo->imageUrl)?"AMIGA-Montessori.jpg":$userInfo->imageUrl;
                        $res->userName = $userInfo->name;
                    }

                    $res->description = trim(stripslashes($res->description));

                    #Media array
                    $media = [];
                    $mediaArray = $this->ResourcesModel->getResourceMedia($resourceId);
                    foreach ($mediaArray as $mediaArr => $mdArr) {
                        array_push($media,$mdArr);
                    }
                    $res->media = $media;

                    #Likes array
                    $likesArr = $this->ResourcesModel->getResourceLikes($resourceId);
                    $likesCount = count($likesArr);
                    $liked = 0;
                    $likeid = NULL;
                    foreach($likesArr as $lyksArr=>$lykObj){
                        if($lykObj->userid==$json->userid){
                            $liked = 1;
                            $likeid = $lykObj->id;
                        }else{
                            $liked = 0;
                            $likeid = NULL;
                        }
                    }
                    $likesDtl = [];
                    $likesDtl['liked'] = $liked;
                    $likesDtl['likeid'] = $likeid;
                    $likesDtl['likesCount'] = $likesCount;
                    if (empty($likesDtl)) {
                        $res->likes = NULL;
                    } else {
                        $res->likes = $likesDtl;
                    }

                    #comment details insertion into api
                    $commentsArr = $this->ResourcesModel->getResourceComments($resourceId);
                    $cmntsDtl = [];
                    $commentsCount = count($commentsArr);
                    if ($commentsCount > 0) {
                        foreach($commentsArr as $cmntsArr=>$cmtObj){
                            if($cmtObj->resourceid == $resourceId){
                                $userDtls = $this->ResourcesModel->getUserDetails($cmtObj->userid);
                                $exactCmnt = $cmtObj->comment;
                                $userCmnted = $userDtls->name;
                                $timeCmnted = date('d-m-Y h:i:s',strtotime($cmtObj->createdAt));
                                $userImage = $userDtls->imageUrl;
                            }
                        }
                        $cmntsDtl['lastComment'] = $exactCmnt;
                        $cmntsDtl['userCommented'] = $userCmnted;
                        $cmntsDtl['timeCmnted'] = $timeCmnted;
                        $cmntsDtl['totalComments'] = $commentsCount;
                        $cmntsDtl['userImage'] = $userImage;
                        $res->comments = $cmntsDtl;
                    }else{
                        $cmntsDtl['lastComment'] = null;
                        $cmntsDtl['userCommented'] = null;
                        $cmntsDtl['timeCmnted'] = null;
                        $cmntsDtl['totalComments'] = null;
                        $cmntsDtl['userImage'] = null;
                        $res->comments = $cmntsDtl;
                    }
                }
                
                $data['Status'] = "SUCCESS";
                $data['Resources'] = $result;
            }else{
                $data['Status'] = "ERROR";
                $data['Message'] = "Userid doesn't match.";
            }
        }else{
            $data['Status'] = "ERROR";
            $data['Message'] = "Invalid headers sent!";
        }
        echo json_encode($data);
    }
}

/* End of file resources.php */
/* Location: ./application/controllers/resources.php */