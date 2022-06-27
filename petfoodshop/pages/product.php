<!DOCTYPE html>
<html>
<head>
	<title>Website</title>
	<link rel="icon" href="../img/logo.jpg">
	<link rel="stylesheet" type="text/css" href="../css/product.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>

		<div class="topnav">
  			<a href="aboutus.php">About Us</a>
  			<a href="feedback.php">Feedback</a>
  			<a href="cart.php">Cart</a>
  			<a href="login.php">User Profile</a>
  			<a href="product.php">Product</a>
  			<a href="index.php" style="float: left; font-weight: bold; margin-left: 20px; font-size: 20px;">PetCart</a>
		</div>

		<div style="display: flex; align-items: center; flex-direction: column;">
			<div id="search-div">
				<input type="text" id="search" name="search_text" placeholder="Search..">
			</div>
			<div id="product-container" style="display: flex; width: 70%; justify-content: center; padding: 10px; flex-wrap: wrap;">
			</div>
		</div>

		<script>

		function addToCart(code) {
  			$.post('store_session.php',{product_code:code}, function(response){
      			alert(response);
   			});
		}

		$(document).ready(function(){
		    load_data();
			function load_data(query){
				$.ajax({
				url:"fetch_product.php",
				method:"post",
				data:{'query':query},
				success:function(data)
				{
					$('#product-container').html(data);
				}
				});
			}
			$('#search').keyup(function(){ 
  				var search = $(this).val(); 
  				if(search != ''){ 
   					load_data(search); 
  				} 
  				else{ 
   					load_data(); 
  				} 
 			}); 
		});
		</script>
</body>
</html>