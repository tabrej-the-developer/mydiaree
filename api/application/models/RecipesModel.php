<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecipesModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function addRecipe($data){
		$query = $this->db->query("INSERT INTO recipes (itemName,type,recipe,createdAt,createdBy,centerid) VALUES ('".$data->itemName."','".strtoupper($data->type)."','".$data->recipe."','".date('Y-m-d h:i:s')."','".$data->createdBy."','".$data->centerid."')");
		return $this->db->insert_id();
	}

	public function addRecipeMedia($recipeId,$fileName,$fileType)
	{
		$query = $this->db->query("INSERT INTO recipe_media (recipeid,mediaUrl,mediaType) VALUES ($recipeId,'".$fileName."','".$fileType."')");
	}

	public function addIngredientToRecipe($recipeId,$id,$quantity,$calories){
		$query = $this->db->query("INSERT INTO recipe_ingredients (recipeId,ingredientId,qty,calories) VALUES ($recipeId,$id,'$quantity','$calories')");
	}

	public function addIngredient($name){
		$query = $this->db->query("INSERT INTO ingredients (name) VALUES ($name)");
	}

	public function getIngredients($search=null){
		if ($search==null) {
			$query = $this->db->query("SELECT * FROM ingredients");
		}else{
			$query = $this->db->query("SELECT * FROM ingredients where name LIKE '%$search%'");
		}		
		return $query->result();
	}

	public function deleteRecipeFile($rowId){
		$query = $this->db->query("DELETE FROM recipe_media where id = $rowId");
	}

	public function updateRecipe($recipe){
		$query = $this->db->query("UPDATE recipes SET itemName='".$recipe->itemName."',type='".$recipe->type."',recipe='".$recipe->recipe."' WHERE id='".$recipe->id."'");
	}

	public function deleteRecipeIngredients($recipeId){
		$this->db->delete('recipe_ingredients', ['recipeId'=>$recipeId]);
	}

	public function getRecipesList($centerid=null){
		if($centerid == null)
			$query = $this->db->query("SELECT * FROM recipes");
		else
			$query = $this->db->query("SELECT * FROM recipes where centerid = $centerid");
		$recipes = $query->result();
		foreach($recipes as $recipe){
			$qu = $this->db->query("SELECT re_in.*,ing.name as name FROM  recipe_ingredients re_in INNER JOIN ingredients ing on re_in.ingredientId = ing.id  where re_in.recipeId = $recipe->id");
			$recipe->ingredients = $qu->result();
			$que = $this->db->query("SELECT * FROM recipe_media where recipeid = $recipe->id");
			$recipe->media = $que->result();
		}
		return $recipes;
	}

	public function getMenuRecipesList($data=null){
		$query = $this->db->query("SELECT * FROM recipes where centerid = $data->centerid AND type = '".strtoupper($data->type)."' ");
		$recipes = $query->result();
		foreach($recipes as $recipe){
			$qu = $this->db->query("SELECT re_in.*,ing.name as name FROM  recipe_ingredients re_in INNER JOIN ingredients ing on re_in.ingredientId = ing.id  where re_in.recipeId = $recipe->id");
			$recipe->ingredients = $qu->result();
			$que = $this->db->query("SELECT * FROM recipe_media where recipeid = $recipe->id");
			$recipe->media = $que->result();
		}
		return $recipes;
	}

	public function getCentersMenu($data='')
	{
		$sql = "SELECT r.id, r.itemName FROM recipes r where r.centerid = $data->centerid AND r.type = '".strtoupper($data->type)."' AND id NOT IN (SELECT DISTINCT(recipeid) FROM `menu` WHERE currentDate = '".date('Y-m-d', strtotime($data->date))."' AND mealType = '".strtoupper($data->type)."' )";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getRecipes($recipeId=null)
	{
		$query = $this->db->query("SELECT * FROM recipes where id = ".$recipeId);
		$recipes = $query->row();
		if(!empty($recipes)){
			$qu = $this->db->query("SELECT re_in.*, ing.name as name FROM  recipe_ingredients re_in INNER JOIN ingredients ing ON re_in.ingredientId = ing.id WHERE re_in.recipeId = ".$recipes->id);
			$recipes->ingredients = $qu->result();
			$que = $this->db->query("SELECT * FROM recipe_media where recipeid = '".$recipes->id."'");
			$recipes->media = $que->result();
		}		
		return $recipes;
	}

	public function deleteRecipe($recipeId){
		$this->db->query("DELETE FROM recipes where id = $recipeId");
		$this->db->query("DELETE FROM recipe_ingredients where recipeId = $recipeId");
		$this->db->query("DELETE FROM recipe_media where recipeid = $recipeId");
		$this->db->query("DELETE FROM menu where recipeid = $recipeId");
	}

	public function addToMenu($menu){
		foreach($menu->recipe as $recipe){
			$this->db->query("INSERT INTO menu (currentDate,recipeid,mealType,centerid,addedBy) VALUES ('$menu->currentDate',$recipe,'$menu->mealType',$menu->centerid,'$menu->addedBy')");
		}
	}

	public function getMenuList($centerid,$startDate=null,$endDate=null){ 
		if($startDate == null && $endDate == null){
			$query = $this->db->query("SELECT * FROM menu where centerId = $centerid");
		}
		elseif($startDate != null && $endDate == null){
			$query = $this->db->query("SELECT * FROM menu where centerId = $centerid AND  currentDate = '$startDate'");
		}
		elseif($startDate != null && $endDate != null){
			$query = $this->db->query("SELECT * FROM menu where centerId = $centerid AND ( currentDate >= '$startDate' AND currentDate <= '$endDate' )");
		}
		return $query->result();
	}

	public function deleteMenuItem($menuId){
		$this->db->query("DELETE FROM menu WHERE recipeid = ".$menuId);
	}

	public function getMenuDetails($menuId='')
	{
		$arr_criteria = ["recipeid"=>$menuId];
		$q = $this->db->get_where('menu', $arr_criteria);
		return $q->row();
	}


	public function getRecipes_from_date($get_data){

		$recipe_query = "
		SELECT * , menu.recipeid as recipeid FROM `menu`
		 LEFT JOIN recipes ON recipes.id=menu.recipeid
		 LEFT JOIN recipe_media ON recipe_media.recipeid=recipes.id
		 WHERE menu.centerId=".$get_data->center_id." AND menu.currentDate='".$get_data->date."'";

		$get_details=$this->db->query($recipe_query)->result();

		return $get_details;
	}

	public function get_recipes($id){
		
		$recipes=[];
		$qu = $this->db->query("SELECT re_in.*, ing.name as name FROM  recipe_ingredients re_in INNER JOIN ingredients ing ON re_in.ingredientId = ing.id WHERE re_in.recipeId = '".$id."'");
		
		if($qu->num_rows()!='0'){
			$recipes['ingredients'] = $qu->result();
		}
		
		$que = $this->db->query("SELECT * FROM recipe_media where recipeid = '".$id."'");
		
		if($qu->num_rows()!='0'){
			$recipes['media'] = $que->result();
		}
		return $recipes;
	}

	// public function getCenterRecipes($centerid='')
	// {
	// 	$sql = "SELECT r.id, r.itemName, r.type, r.recipe, r.createdBy, u.name, u.userType, r.createdAt FROM `recipes` r LEFT JOIN `users` u ON r.createdBy = u.userid WHERE r.centerid = $centerid ORDER BY r.type ASC";
	// 	$q = $this->db->query($sql);
	// 	return $q->result();
	// }

	public function getCenterRecipes($centerid = '')
	{
		// Use CodeIgniter's query builder
		$this->db->select('r.id, r.itemName, r.type, r.recipe, r.createdBy, u.name, u.userType, r.createdAt');
		$this->db->from('recipes r');
		$this->db->join('users u', 'r.createdBy = u.userid', 'left');
		$this->db->where('r.centerid', $centerid);
		$this->db->order_by('r.type', 'ASC');
	
		// Execute the query and return the result
		$query = $this->db->get();
		return $query->result();
	}
	





	public function getRecipeMedia($recipeId='')
	{
		$sql = "SELECT * FROM `recipe_media` WHERE recipeid = $recipeId AND mediaType = 'Image'";
		$q = $this->db->query($sql);
		return $q->row();
	}

}