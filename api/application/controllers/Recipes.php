<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recipes extends CI_Controller {

	function __construct($foo = null)
	{
		$this->foo = $foo;

		parent::__construct();

		$this->load->model('RecipesModel');
		$this->load->model('LoginModel');
		$this->load->model('UtilModel');

		header('Content-Type: application/json');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		header("Access-Control-Allow-Headers: X-DEVICE-ID,X-TOKEN,X-DEVICE-TYPE, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");

		$method = $_SERVER['REQUEST_METHOD'];

		if($method == "OPTIONS") {
			die();
		}
	}

	public function index(){}

	public function addRecipe(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			// $json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($res != null && $res->userid == $_POST['userid']){
					$usr = $this->LoginModel->getUserFromId($_POST['userid']);
					if ($usr->userType == "Superadmin") {
						$run = 1;
					} else {
						if ($usr->userType == "Staff") {
							$prm = $this->UtilModel->getPermissions($_POST['userid'],$_POST['centerid']);				
							if ($prm->updateRecipe == 1) {
								$run = 1;
							} else {
								$run = 0;
							}							
						} else {
							$run = 0;
						}
					}

					if($run == 1){
						$recipe = new stdClass();
						$recipe->centerid = $_POST['centerid'];
						$recipe->itemName = isset($_POST['itemName']) ? $_POST['itemName'] : null ;
						$recipe->type = isset($_POST['type']) ? $_POST['type'] : null ;
						$recipe->recipe = isset($_POST['recipe']) ? addslashes($_POST['recipe']) : null ;
						$recipe->createdBy = $_POST['userid'];
						$recipeId = $this->RecipesModel->addRecipe($recipe);
						$ingredients = isset($_POST['ingredients']) ? json_decode($_POST['ingredients']) : [];
						$destination = 'assets/media/';
						foreach($ingredients as $ingredient){
							$quantity = isset($ingredient->quantity) ? $ingredient->quantity : null;
							$calories = isset($ingredient->calories) ? $ingredient->calories : null;
							$this->RecipesModel->addIngredientToRecipe($recipeId,$ingredient->ingredientId,$quantity,$calories);
						}
						$var = 0;
						while(isset($_FILES['image' . $var]['name'])){
							if(!empty($_FILES['image' . $var]['name'])){
								move_uploaded_file($_FILES['image'.$var]['tmp_name'],$destination.$_FILES['image'.$var]['name']);
								$this->RecipesModel->addRecipeMedia($recipeId,$_FILES['image'.$var]['name'],'Image');			
							}
							$var++;
						}

						$var = 0;
						while(isset($_FILES['video'.$var]['name'])){
							if(!empty($_FILES['video'.$var]['name'])){
								move_uploaded_file($_FILES['video'.$var]['tmp_name'],$destination.$_FILES['video'.$var]['name']);
								$this->RecipesModel->addRecipeMedia($recipeId,$_FILES['video'.$var]['name'],'Video');
							}
							$var++;
						}

						http_response_code(200);
						$data['Status'] = "SUCCESS";
						$data['Message'] = "Recipe added successfully";
						$data['centerid'] = $recipe->centerid;
					}else{
						$data['Status'] = "ERROR";
						$data['Message'] = "Permission denied";
					}
					
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid User Account!";
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

	public function addIngredients(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){
					$name = isset($json->name) ? $json->name : null;
					$this->RecipesModel->addIngredient($name);
					http_response_code(200);
					$data['Status'] = "SUCCESS";
				} else {
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "Invalid";
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

	public function getIngredients($userid,$search=null){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				if($res != null && $res->userid == $userid){
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Ingredients'] = $this->RecipesModel->getIngredients($search);
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid";
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

	public function deleteRecipeFile($userid,$rowId){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				if( $res != null && $res->userid == $userid){
						$this->RecipesModel->deleteRecipeFile($rowId);
					http_response_code(200);
					$data['Status'] = "SUCCESS";
				} else {
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "Invalid";
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

	public function updateRecipe(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			// $json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($res != null && $res->userid == $_POST['userid']){

					$rcp = $this->RecipesModel->getRecipes($_POST['id']);

					if($rcp){
						$centerid = $rcp->centerid;
						$usr = $this->LoginModel->getUserFromId($_POST['userid']);
						if ($usr->userType == "Superadmin") {
							$run = 1;
						} else {
							if ($usr->userType == "Staff") {

								$prm = $this->UtilModel->getPermissions($_POST['userid'],$centerid);
								
								if ($prm->updateRecipe == 1) {
									$run = 1;
								} else {
									$run = 0;
								}
								
							} else {
								$run = 0;
							}
						}

						if ($run == 1) {
							$recipe = [];
							$recipe = (object)$recipe;
							$recipe->id = $_POST['id'];
							$recipe->itemName = isset($_POST['itemName']) ? $_POST['itemName'] : null ;
							$recipe->type = isset($rcp->type) ? $rcp->type : null ;
							$recipe->recipe = isset($_POST['recipe']) ? $_POST['recipe'] : null ;
							$this->RecipesModel->updateRecipe($recipe);
							$recipeId = $_POST['id'];
							$ingredients = isset($_POST['ingredients']) ? json_decode($_POST['ingredients']) : [];
							$this->RecipesModel->deleteRecipeIngredients($recipeId);
							foreach($ingredients as $ingredient => $ingr){
								$this->RecipesModel->addIngredientToRecipe($recipeId,$ingr->ingredientId,$ingr->quantity,$ingr->calories);
							}
							$destination = '/assets/media/';
							$var = 0;
							while(isset($_FILES['image'.$var]['name'])){
								if(isset($_FILES['image'.$var]['name'])){
									// for($i=0;$i<count($_FILES['image']['name']);$i++){
										move_uploaded_file($_FILES['image'.$var]['tmp_name'],$destination.$_FILES['image'.$var]['name']);
										$this->RecipesModel->addRecipeMedia($recipeId,$_FILES['image'.$var]['name'],'Image');
									// }
										$var++;
								}
							}
							$var = 0;
							while(isset($_FILES['video'.$var]['name'])){
								if(isset($_FILES['video'.$var]['name'])){
									// for($i=0;$i<count($_FILES['image']['name']);$i++){
										move_uploaded_file($_FILES['video'.$var]['tmp_name'],$destination.$_FILES['video'.$var]['name']);
										$this->RecipesModel->addRecipeMedia($recipeId,$_FILES['video'.$var]['name'],'Video');
									// }
									$var++;
								}
							}
							$data['Status'] = "SUCCESS";
							$data['Message'] = "Recipe updated successfully";
							$data['Centerid'] = $centerid;
						} else {
							http_response_code(401);
							$data['Status'] = "ERROR";
							$data['Message'] = "Permission denied";
						}
					} else {
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "Invalid recipeid!";
					}					
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid";
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

	public function getRecipesList($userid,$centerid=NULL){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				if($res != null && $res->userid == $userid){
					$recipes = $this->RecipesModel->getCenterRecipes($centerid);
					foreach ($recipes as $key => $obj) {
						$mediaArr = $this->RecipesModel->getRecipeMedia($obj->id);
						if (empty($mediaArr)) {
							$obj->mediaUrl = "no-image.png";
						} else {
							$obj->mediaUrl = $mediaArr->mediaUrl;
						}
					}
					$permissions = $this->UtilModel->getPermissions($userid,$centerid);
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Recipes'] = $recipes;
					$data['permissions'] = $permissions;
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid user account";
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

	public function getMenuRecipesList(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){
					$recipes = $this->RecipesModel->getMenuRecipesList($json);
					$permissions = $this->UtilModel->getPermissions($json->userid,$json->centerid);
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Recipes'] = $recipes;
					$data['permissions'] = $permissions;
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid user account";
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

	public function getCentersMenu(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){
					$recipes = $this->RecipesModel->getCentersMenu($json);
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['Recipes'] = $recipes;
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid user account";
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

	public function getRecipe($userid,$recipeId=null)
	{
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				if($res != null && $res->userid == $userid){
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$recipes = $this->RecipesModel->getRecipes($recipeId);
					$recipes->recipe = html_entity_decode($recipes->recipe);
					$data['Recipes'] = $recipes;
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid User Account";
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

	public function deleteRecipe($userid,$recipeId){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				if( $res != null && $res->userid == $userid){
					$rcp = $this->RecipesModel->getRecipes($recipeId);
					$centerid = $rcp->centerid;
					$usr = $this->LoginModel->getUserFromId($userid);
					if ($usr->userType == "Superadmin") {
						$run = 1;
					} else {
						if ($usr->userType == "Staff") {

							$prm = $this->UtilModel->getPermissions($userid,$centerid);

							if ($prm->deleteRecipe == 1) {
								$run = 1;
							} else {
								$run = 0;
							}
							
						} else {
							$run = 0;
						}
					}

					if ($run == 1) {
						$this->RecipesModel->deleteRecipe($recipeId);
						$data['Status'] = "SUCCESS";
						$data['Message'] = "Recipe deleted successfully";
					} else {
						$data['Status'] = "ERROR";
						$data['Message'] = "Permission Denied";
					}
					
				} else {
						http_response_code(401);
						$data['Status'] = "ERROR";
						$data['Message'] = "Invalid";
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

	public function addToMenu(){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if($json != null && $res != null && $res->userid == $json->userid){	
					$menu = new stdClass();
					$menu->currentDate = isset($json->currentDate) ? $json->currentDate : null; 
					// $menu->recipeid = isset($json->recipeid) ? $json->recipeid : null; 	
					$menu->mealType = isset($json->mealType) ? $json->mealType : null;
					$menu->recipe = isset($json->recipe) ? $json->recipe : []; 	
					$menu->centerid = isset($json->centerid) ? $json->centerid : null; 	
					$menu->addedBy = isset($json->addedBy) ? $json->addedBy : null; 
					if($menu->currentDate != null && $menu->recipe != null && $menu->mealType != null  && $menu->centerid != null && $menu->addedBy != null){
							$this->RecipesModel->addToMenu($menu);
							http_response_code(200);
							$data['Status'] = "SUCCESS";
						}else{
							http_response_code(401);
							$data['Status'] = "ERROR";
							$data['Message'] = "Current Date, Recipe, Meal Type, Center, Added By are mandatory";
						}
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid User Account!";
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

	public function getMenuList($userid,$centerid,$startDate=null,$endDate=null){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				if($res != null && $res->userid == $userid){
					$prm = $this->UtilModel->getPermissions($userid,$centerid);	
					$menu = $this->RecipesModel->getMenuList($centerid,$startDate,$endDate);
					$data['Menu'] = [];
					// 0 - Monday // 1 - Tuesday // 2 - Wednesday // 3- Thursday // 4 - Friday
					for($i=0;$i<5;$i++){
					//	0 - BREAKFAST //  1 - LUNCH  //  2 - SNACKS
						for($j=0;$j<3;$j++){
							$data['Menu'][$i][$j] = [];
						}
					}

					$x=0; $y=0;$z=0;
					foreach($menu as $item){
						$item->recipeDetails = $this->RecipesModel->getRecipes($item->recipeid);
						if($item->mealType == 'BREAKFAST'){
							array_push($data['Menu'][(date("w",strtotime($item->currentDate))-1)][0], $item);
							$x++;
						}
						if($item->mealType == 'LUNCH'){
							array_push($data['Menu'][(date("w",strtotime($item->currentDate))-1)][1], $item);
							$y++;
						}
						if($item->mealType == 'SNACKS'){
							array_push($data['Menu'][(date("w",strtotime($item->currentDate))-1)][2], $item);
							$z++;
						}
					}
					http_response_code(200);
					$data['Status'] = "SUCCESS";
					$data['permissions'] = $prm;
				} else {
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid user";
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

	public function deleteMenuItem($userid,$menuId){
		$headers = $this->input->request_headers();
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				if($res != null && $res->userid == $userid){

					$menu = $this->RecipesModel->getMenuDetails($menuId);

					if(empty($menu)){
						$data['Status'] = "ERROR";
						$data['Message'] = "Please check the menu id!";
					}else{
						$centerid = $menu->centerId;
						$usr = $this->LoginModel->getUserFromId($userid);
						if ($usr->userType == "Superadmin") {
							$run = 1;
						} else {
							if ($usr->userType == "Staff") {

								$prm = $this->UtilModel->getPermissions($userid,$centerid);

								if ($prm->deleteMenu == 1) {
									$run = 1;
								} else {
									$run = 0;
								}
								
							} else {
								$run = 0;
							}
						}
						if ($run == 1) {
							$this->RecipesModel->deleteMenuItem($menuId);
							$data['Status'] = "SUCCESS";
							$data['Message'] = "Menu deleted successfully";
						} else {
							$data['Status'] = "ERROR";
							$data['Message'] = "Permission Denied";
						}
					}
					
				} else {
					http_response_code(401);
					$data['Status'] = "ERROR";
					$data['Message'] = "Invalid user account!";
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


	public function getrecipesfrom_date(){
		$headers = $this->input->request_headers();
		
		if($headers != null && array_key_exists('X-Device-Id',$headers) && array_key_exists('X-Token',$headers)){
			$res = $this->LoginModel->getAuthUserId($headers['X-Device-Id'],$headers['X-Token']);
			$json = json_decode(file_get_contents('php://input'));
			
				if($json != null && $res != null && $res->userid == $json->userid){

					$result=$this->RecipesModel->getRecipes_from_date($json);		

					$data['Menu'] = [];
					
					//	1 - BREAKFAST //  2 - LUNCH  //  3 - SNACKS
					for($j=1;$j<4;$j++){
							$data['Menu'][$j] = [];
					}
					
					foreach($result as $item){

						$item->recipeDetails = $this->RecipesModel->get_recipes($item->recipeid);
						
						if($item->mealType == 'BREAKFAST'){
							array_push($data['Menu'][1], $item);
						}
						if($item->mealType == 'LUNCH'){
							array_push($data['Menu'][2], $item);
						}
						if($item->mealType == 'SNACK'){
							array_push($data['Menu'][3], $item);
							
						}
					}
					http_response_code(200);
				}else {
				$data['Status'] = "ERROR";
				$data['Message'] = "Invalid Request Method";	
				http_response_code(200);
				}
		}else{
			$data['Status'] = "ERROR";
			$data['Message'] = "Invalid Headers Sent!";
			http_response_code(401);
		}

		echo json_encode($data);


	}



}