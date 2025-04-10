<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recipe extends CI_Controller {

	private $table = 'ingredients';


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		
	}

	public function index()
	{
		if($this->session->has_userdata('LoginId')){
			$data = [];
			if (isset($_GET['centerid'])) {
		    	$centerid = strip_tags(trim(stripslashes($_GET['centerid'])));
		    }else{
		    	$center = $this->session->userdata("centerIds");
				$centerid = $center[0]->id;
		    }
		    $data['centerid'] = $centerid;
			$data['userid'] = $this->session->userdata('LoginId');
			$url = BASE_API_URL."/Recipes/getRecipesList/".$data['userid']."/".$data['centerid'];
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			// print_r($server_output);
			// echo $httpcode; 
			// exit;
			if($httpcode == 200){
				curl_close ($ch);
				$data = json_decode($server_output);
				$ingredientsArr = json_decode($this->getIngredients());				
				$data->ingredients = $ingredientsArr;
				$data->centerid = $centerid;
				// echo "<pre>";
				// print_r($data);
				// exit;
				$this->load->view('RecipeList', $data);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function getIngredients()
	{
	  	if($this->session->has_userdata('LoginId')){
			$data = [];

			$data['userid'] = $this->session->userdata('LoginId');
			if (empty($this->input->post('searchTerm'))) {
				$url = BASE_API_URL."/Recipes/getIngredients/".$data['userid'];
			} else {
				$data['searchTerm'] = $this->input->post('searchTerm');
				$url = BASE_API_URL."/Recipes/getIngredients/".$data['userid']."/".$data['searchTerm'];
			}
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
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

				$res = $results->Ingredients;
				$response = [];
				foreach ($res as $key => $obj) {
					$resp['id'] = $obj->id;
					$resp['text'] = $obj->name;
					array_push($response, $resp);
				}

				return json_encode($response);
			}
			
			if($httpcode == 401){
				redirect('welcome');
			}
			
		}else{
			redirect('welcome');
		}
	}

	public function addRecipe()
	{
		if($this->session->has_userdata('LoginId')){
			//data processing
			$data = $this->input->post();

			$data['recipe'] = htmlspecialchars($data['recipe']);
			if (isset($_FILES)) {
				if (isset($_FILES['image'])) {
					$imageCount = count($_FILES['image']['name']);
					if ($imageCount>0) {					
						for ($i=0; $i < $imageCount; $i++) { 
							if(isset($_FILES['image']['tmp_name'][$i]) && !empty($_FILES['image']['tmp_name'][$i])){
								$data['image'.$i] = new CurlFile($_FILES['image']['tmp_name'][$i],$_FILES['image']['type'][$i],$_FILES['image']['name'][$i]);
							}
						}
					}
				}
				
				if (isset($_FILES['video'])) {
					$videoCount = count($_FILES['video']['name']);
					if ($videoCount>0) {
						for ($i=0; $i < $videoCount; $i++) { 
							if(isset($_FILES['video']['tmp_name'][$i]) && !empty($_FILES['video']['tmp_name'][$i])){
								$data['video'.$i] = new CurlFile($_FILES['video']['tmp_name'][$i],$_FILES['video']['type'][$i],$_FILES['video']['name'][$i]);
							}
						}
					}
				}
			}

			$ingredients = [];
			if (isset($data['ingredientId'])) {
				$countIngredients = count($data['ingredientId']);
				for ($i=0; $i <$countIngredients ; $i++) { 
					$ing['ingredientId'] = $data['ingredientId'][$i];
					$ing['quantity'] = $data['quantity'][$i];
					$ing['calories'] = $data['calories'][$i];
					array_push($ingredients, $ing);
				}
				$data['ingredients'] = json_encode($ingredients);
				unset($data['ingredientId']);
			}
			
			$data['userid'] = $this->session->userdata('LoginId');
			unset($data['quantity']);
			unset($data['calories']);
			$url = BASE_API_URL."/Recipes/addRecipe/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			// print_r($server_output); exit;
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200){
				$jsonOutput=json_decode($server_output);
				curl_close ($ch);
			    $redirect_url = base_url("recipe")."?centerid=".$jsonOutput->centerid."&status=added";
			    redirect($redirect_url);
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect('welcome');
		}
	}

	public function updateRecipe()
	{
		if($this->session->has_userdata('LoginId')){
			//data processing
			$data = $this->input->post();

			  $center_id = $data['centerid'];
	  
		// print_r($data);
		// exit;
			$data['recipe'] = htmlspecialchars($data['recipe']);
			if (isset($_FILES)) {
				if (isset($_FILES['image'])) {
					$imageCount = count($_FILES['image']['name']);
					if ($imageCount>0) {					
						for ($i=0; $i < $imageCount; $i++) { 
							if(isset($_FILES['image']['tmp_name'][$i]) && !empty($_FILES['image']['tmp_name'][$i])){
								$data['image'.$i] = new CurlFile($_FILES['image']['tmp_name'][$i],$_FILES['image']['type'][$i],$_FILES['image']['name'][$i]);
							}
						}
					}
				}
				
				if (isset($_FILES['video'])) {
					$videoCount = count($_FILES['video']['name']);
					if ($videoCount>0) {
						for ($i=0; $i < $videoCount; $i++) { 
							if(isset($_FILES['video']['tmp_name'][$i]) && !empty($_FILES['video']['tmp_name'][$i])){
								$data['video'.$i] = new CurlFile($_FILES['video']['tmp_name'][$i],$_FILES['video']['type'][$i],$_FILES['video']['name'][$i]);
							}
						}
					}
				}
			}

			$ingredients = [];
			if (isset($data['ingredientId'])) {
				$countIngredients = count($data['ingredientId']);
				for ($i=0; $i <$countIngredients ; $i++) { 
					$ing['ingredientId'] = $data['ingredientId'][$i];
					$ing['quantity'] = $data['quantity'][$i];
					$ing['calories'] = $data['calories'][$i];
					array_push($ingredients, $ing);
				}
				$data['ingredients'] = json_encode($ingredients);
				unset($data['ingredientId']);
			}
			//print_r($ingredients); exit;
			$data['userid'] = $this->session->userdata('LoginId');
			unset($data['quantity']);
			unset($data['calories']);
			$url = BASE_API_URL."/Recipes/updateRecipe/";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'X-Device-Id: '.$this->session->userdata('X-Device-Id'),
				'X-Token: '.$this->session->userdata('AuthToken')
			));
			$server_output = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			// print_r($server_output); exit;
			curl_close($ch);
			if ($httpcode == 200) {
				$jsonOutput = json_decode($server_output);
				// print_r($jsonOutput);
				// exit;
				$redirect_url = base_url('Recipe')."?centerid=".$center_id."&status=success";
				redirect($redirect_url);
			}
		}else{
			redirect('welcome');
		}
	}

	public function getRecipeDetails()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->get();
			$url = BASE_API_URL."/Recipes/getRecipe/".$data['userid']."/".$data['rcpId'];
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL,$url);
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
				redirect('welcome');
			}
		}else{
			redirect("welcome");
		}

	}

	public function deleteRecipeFile()
	{
		if($this->session->has_userdata('LoginId')){
			$data = $this->input->get();
			$url = BASE_API_URL."/Recipes/deleteRecipeFile/".$data['userid']."/".$data['rowId'];
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
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect("welcome");
		}
	}

	public function deleteRecipe($recipeId=NULL,$centerid=NULL)
	{
		if($this->session->has_userdata('LoginId')){
			$data['userid'] = $this->session->userdata("LoginId");
			$url = BASE_API_URL."/Recipes/deleteRecipe/".$data['userid']."/".$recipeId;
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
				curl_close($ch);
				if ($centerid==NULL) {
					redirect("Recipe");
				}else{
					$url_redirect = base_url('Recipe')."?centerid=".$centerid;
					redirect($url_redirect);
				}		
			}
			if($httpcode == 401){
				redirect('welcome');
			}
		}else{
			redirect("welcome");
		}
	}





	public function get_all() {
        // Direct DB query to get all ingredients
        $query = $this->db->get($this->table);
        $ingredients = $query->result_array();
        
        echo json_encode($ingredients);
    }
    
    public function add() {
        $name = $this->input->post('name');
        
        if (empty($name)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ingredient name is required'
            ]);
            return;
        }
        
        // Direct DB query to insert ingredient
        $data = array(
            'name' => $name
        );
        
        $result = $this->db->insert($this->table, $data);
        
        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Ingredient added successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to add ingredient'
            ]);
        }
    }
    
    public function update() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        
        if (empty($id) || empty($name)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ingredient ID and name are required'
            ]);
            return;
        }
        
        // Direct DB query to update ingredient
        $data = array(
            'name' => $name
        );
        
        $this->db->where('id', $id);
        $result = $this->db->update($this->table, $data);
        
        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Ingredient updated successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update ingredient'
            ]);
        }
    }
    
    public function delete() {
        $id = $this->input->post('id');
        
        if (empty($id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ingredient ID is required'
            ]);
            return;
        }
        
        // Direct DB query to delete ingredient
        $this->db->where('id', $id);
        $result = $this->db->delete($this->table);
        
        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Ingredient deleted successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to delete ingredient'
            ]);
        }
    }
    
    // Optional method to get a single ingredient by ID
    public function get_by_id() {
        $id = $this->input->get('id');
        
        if (empty($id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ingredient ID is required'
            ]);
            return;
        }
        
        // Direct DB query to get ingredient by ID
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        $ingredient = $query->row_array();
        
        if ($ingredient) {
            echo json_encode($ingredient);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Ingredient not found'
            ]);
        }
    }




}

/* End of file Recipe.php */
/* Location: ./application/controllers/Recipe.php */