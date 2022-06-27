<?php
require_once("db_con.php");
$db_handle = new DBController();

if(!isset($_POST["query"])){
	$query="SELECT * FROM products";
	$result = $db_handle->runQuery($query);
	$output = '';
	if($result){
		foreach($result as $product){
			$output .='
			<div class="card">'.
			    '<img src="'.$product["image"].'" style="user-drag: none; user-select: none; width:150px; height:150px">'.
  				'<h3 style="user-select: none;">'.$product["name"].'</h3>'.
  				'<p class="price" style="user-select: none;">'.$product["price"].' Taka</p>'.
  				'<p style="user-select: none;"><button onclick="addToCart('.$product["code"].')">Add to Cart</button></p>'.
			'</div>';
		}
		echo $output;

	}else{
		echo "<div>No products available</div>";
	}
}else{
	$search=$_POST["query"]; 
 	$query="SELECT * FROM products WHERE name LIKE '%".$search."%'";
	$result = $db_handle->runQuery($query);
	$output = '';
	if($result){
		foreach($result as $product){
			$output .='
			<div class="card">'.
			    '<img src="'.$product["image"].'" style="user-drag: none; user-select: none; width:150px; height:150px">'.
  				'<h3 style="user-select: none;">'.$product["name"].'</h3>'.
  				'<p class="price" style="user-select: none;">'.$product["price"].' Taka</p>'.
  				'<p style="user-select: none;"><button onclick="addToCart('.$product["code"].')">Add to Cart</button></p>'.
			'</div>';
		}
		echo $output;

	}else{
		echo "<div>No products available</div>";
	}
}

?>