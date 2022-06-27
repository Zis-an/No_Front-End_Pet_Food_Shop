<?php
	session_start();
	require_once("db_con.php");
	$db_handle = new DBController();
?>
<!DOCTYPE html>
<html>
<head>
	<title>CART</title>
	<link rel="icon" href="../img/logo.jpg">
	<link rel="stylesheet" type="text/css" href="../css/cart.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

		<div id="shopping-cart">
		<div class="txt-heading">Shopping Cart</div>

		<a id="btnEmpty" onclick="emptyCart()">Empty Cart</a>
		<?php
		if(isset($_SESSION["cart_products"])){
		    $total_quantity = 0;
		    $total_price = 0;
		?>	
		<table class="tbl-cart" cellpadding="10" cellspacing="1">
			<tbody>
				<tr>
					<th style="text-align:left;">Name</th>
					<th style="text-align:left;">Code</th>
					<th style="text-align:right;" width="5%">Quantity</th>
					<th style="text-align:right;" width="10%">Unit Price (Taka)</th>
					<th style="text-align:right;" width="10%">Price (Taka)</th>
					<th style="text-align:center;" width="5%">Remove</th>
				</tr>	
				<?php		
	    			foreach ($_SESSION["cart_products"] as $item){
	        			$query="SELECT * FROM products where code='".$item['code']."';";
						$result = $db_handle->runQuery($query)[0];
						$item_price = $item["quantity"]*$result["price"];
				?>
						<tr id="row-<?php echo $result["code"]; ?>">
							<td><img src="<?php echo $result["image"]; ?>" class="cart-item-image" /><?php echo $result["name"]; ?></td>
							<td><?php echo $result["code"]; ?></td>
							<td style="text-align:center;">
								<button class="btn" onclick="decrementCart(<?php echo $result["code"].','.$result["price"]; ?>)"><i class="fa fa-angle-left"></i></button>
									<span id="count-<?php echo $result["code"]; ?>"><?php echo $item["quantity"]; ?></span>
								<button class="btn" onclick="incrementCart(<?php echo $result["code"].','.$result["price"].','.$result["num_available"]; ?>)"><i class="fa fa-angle-right"></i></button>
							</td>
							<td  style="text-align:right;"><?php echo $result["price"]; ?></td>
							<td  style="text-align:right;">
								<span id="price-<?php echo $result["code"]; ?>">
									<?php echo $item_price; ?>
								</span>
							</td>
							<td style="text-align:center;"><a onclick="deleteItem(<?php echo $result["code"].','.$result["price"]; ?>)" class="btnRemoveAction"><img src="../img/icon-delete.png" alt="Remove Item" /></a></td>
						</tr>
						<?php
						$total_quantity += $item["quantity"];
						$total_price += ($result["price"]*$item["quantity"]);
					}
						?>

				<tr>
					<td colspan="2" align="right"><strong>Total:</strong></td>
					<td align="right"><strong><span id="total"><?php echo $total_quantity; ?></span></strong></td>
					<td align="right" colspan="2"><strong><span id="total-price"><?php echo $total_price; ?></strong></td></span>	
					<td></td>
				</tr>
			</tbody>
		</table>		
	    <?php
		} else {
		?>
			<div class="no-records">Your Cart is Empty</div>
		<?php 
		}
		?>
		<a id="btnCheckout" href="shippinginfo.php">Checkout</a>
	</div>

		<script>
			function deleteItem(code, price) {
				$.post('modify_session.php',{product_code:code, action: 'deleterow'}, function(response){
  					res=JSON.parse(response);
      				if(res.empty_cart){
      					location.reload();
      				}else if(res.delete_row){
      					$('#row-'+code).remove();
      					total_amount = parseFloat($('#total-price').html());
      					$('#total-price').html(total_amount-price*res.item.quantity);
      					total = parseInt($('#total').html());
      					$('#total').html(total-res.item.quantity);
      				}
   				});
			}

			function incrementCart(code, price, max_amount) {
				if(parseInt($('#count-'+code).html())<max_amount){
					$.post('modify_session.php',{product_code:code, action: 'increment'}, function(response){
  						item=JSON.parse(response);
      					$('#count-'+code).html(item.count);
      					if(item.increment){
      						amount = parseFloat($('#price-'+code).html());
      						total_amount = parseFloat($('#total-price').html());
      						$('#price-'+code).html(amount+price);
      						$('#total-price').html(total_amount+price);
      					}
      					$('#total').html(item.total);
   					});
				}else{
      				alert("No more available amount of this item in stock.");
      			}
			}
			function decrementCart(code, price) {
  				$.post('modify_session.php',{product_code:code, action: 'decrement'}, function(response){
  					item=JSON.parse(response);
      				if(item.decrement){
      					$('#count-'+code).html(item.count);
      					amount = parseFloat($('#price-'+code).html());
      					total_amount = parseFloat($('#total-price').html());
      					$('#price-'+code).html(amount-price);
      					$('#total-price').html(total_amount-price);
      					$('#total').html(item.total);
      				}else{
      					alert("Minimun amount reach. If want to remove from cart use remove option.");
      				}
   				});
			}
			function emptyCart() {
  				$.post('modify_session.php',{action: 'empty'}, function(response){
      				if(response){
      					location.reload();
      				}else{
      					alert("Cart is already empty.");
      				}
   				});
			}
		</script>
</body>
</html>