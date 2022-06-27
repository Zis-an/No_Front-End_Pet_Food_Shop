<?php
	session_start();
	require_once("db_con.php");
	$db_handle = new DBController();
	$order_details = array();
	if(!isset($_SESSION['user']))
        echo("<script type='text/javascript'>
            alert('Please login to complete checkout procedure.');
            location.replace(\"login.php\");
        </script>");
    require_once("db_con.php");
    $db_handle = new DBController();
    $id = $_SESSION['user'];
    $query="SELECT * FROM users where id='{$id}'";
    $user = $db_handle->runQuery($query);
    if(!isset($user[0]) && !empty(!isset($user[0]))){
        unset($_SESSION['user']);
        echo("<script type='text/javascript'>
            location.replace(\"login.php\");
        </script>"); 
    }
    else{
        $user = $user[0];
        $order_details['user_id'] = $_SESSION['user'];
        $order_details['bill_to'] = $user["first_name"]." ".$user["last_name"];
        $order_details['ship_addr'] = $_SESSION['address'];
        $order_details['email'] = $user["email"];
        $order_details['contact'] = $user["contact_no"];
        $order_details['products'] = array();
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Confirm Order</title>
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
		<div class="txt-heading">Confirm Order</div>
		<br>

		<?php
		if(isset($_SESSION["cart_products"])){
		    $total_quantity = 0;
		    $total_price = 0;
		?>
		<div style="width:100%; display: flex; justify-content:center; align-items:center; padding:5px;">
			<h2>Please Recheck And Confirm Your Order</h2>
		</div>
		<div style="width:100%; display: flex; flex-direction: row; justify-content:space-between;">
			<div style="display: flex; flex-direction: column; padding: 10px 0px;">
				<div style="display: flex; padding: 3px 0px; align-items: center;">
					<h2>Bill To:</h2> <p style="font-size: 1.5em; padding-left: 3px;"><?php echo $user["first_name"]." ".$user["last_name"] ?></p>
				</div>
				<div style="display: flex; padding: 3px 0px; align-items: center;">
					<h2>Shipping address:</h2> <p style="font-size: 1.5em; padding-left: 3px;"><?php echo $_SESSION['address'] ?></p>
				</div>
				<div style="display: flex; padding: 3px 0px; align-items: center;">
					<h2>Email:</h2> <p style="font-size: 1.5em; padding-left: 3px;"><?php echo $user["email"] ?></p>
				</div>
				<div style="display: flex; padding: 3px 0px; align-items: center;">
					<h2>Contact number:</h2> <p style="font-size: 1.5em; padding-left: 3px;"><?php echo $user["contact_no"] ?></p>
				</div>
			</div>
			<div style="display: flex; flex-direction: column;  padding: 10px 0px;">
				<div style="display: flex; padding: 3px 0px; align-items: center;">
					<h2>Date:</h2> <p style="font-size: 1.5em; padding-left: 3px;"><?php $order_details['date'] = date("d-m-Y"); echo date("d-m-Y") ?></p>
				</div>
				<div style="display: flex; padding: 3px 0px; align-items: center;">
					<h2>Estimated delivery on:</h2> <p style="font-size: 1.5em; padding-left: 3px;"><?php $order_details['es_del_date'] = date("d-m-Y", strtotime(date("d-m-Y") . ' +3 day')); echo date("d-m-Y", strtotime(date("d-m-Y") . ' +3 day')); ?></p>
				</div>
				
			</div>
		</div>

		<table class="tbl-cart" cellpadding="10" cellspacing="1">
			<tbody>
				<tr>
					<th style="text-align:left;">Name</th>
					<th style="text-align:left;">Code</th>
					<th style="text-align:right;" width="5%">Quantity</th>
					<th style="text-align:right;" width="10%">Unit Price (Taka)</th>
					<th style="text-align:right;" width="10%">Price (Taka)</th>
				</tr>	
				<?php		
	    			foreach ($_SESSION["cart_products"] as $item){
	        			$query="SELECT * FROM products where code='".$item['code']."';";
						$result = $db_handle->runQuery($query)[0];
						$item_price = $item["quantity"]*$result["price"];
						$product_details = array();
						$product_details['code'] = $result["code"];
						$product_details['name'] = $result["name"];
						$product_details['image'] = $result["image"];
						$product_details['amount'] = $item["quantity"];
						$product_details['uprice'] = $result["price"];
						$product_details['tname'] = $item_price;
						$order_details['products'][] = $product_details;

				?>
						<tr id="row-<?php echo $result["code"]; ?>">
							<td><img src="<?php echo $result["image"]; ?>" class="cart-item-image" /><?php echo $result["name"]; ?></td>
							<td><?php echo $result["code"]; ?></td>
							<td style="text-align:center;">
									<span id="count-<?php echo $result["code"]; ?>"><?php echo $item["quantity"]; ?></span>
							</td>
							<td  style="text-align:right;"><?php echo $result["price"]; ?></td>
							<td  style="text-align:right;">
								<span id="price-<?php echo $result["code"]; ?>">
									<?php echo $item_price; ?>
								</span>
							</td>
						</tr>
						<?php
						$total_quantity += $item["quantity"];
						$total_price += ($result["price"]*$item["quantity"]);
					}
						?>

				<tr>
					<td colspan="2" align="right"><strong>Subtotal:</strong></td>
					<td align="right"><strong><span id="total"><?php $order_details['tamount'] = $total_quantity; echo $total_quantity; ?></span></strong></td>
					<td align="right" colspan="2"><strong><span id="total-price"><?php $order_details['stprice'] = $total_price; echo $total_price; ?></strong></td></span>	
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
		<div style="display:flex; justify-content: flex-start; align-items: flex-start; padding:10px 0px;">
			<div style="display: flex; padding: 3px 0px; align-items: center;">
				<h2>Your Message: </h2>
					<?php
					if(isset($_SESSION['message']) && !empty($_SESSION['message'])){ ?>
						 <p style="font-size: 1.2em; padding-left: 3px;"><span id="total-price"><?php $order_details['message'] = $_SESSION['message']; echo $_SESSION['message']; ?></p>
					<?php }else{?>
						<p style="font-size: 1.2em; padding-left: 3px;"><span id="total-price">No message for this order.</p>
						<?php
					}

					?>
			</div>
		</div>
		<div style="display:flex; justify-content: space-between; align-items: flex-end;">
			<div style="padding:30px;">
				<div style="display: flex; padding: 3px 0px; align-items: center;">
					<h2>Subtotal: </h2> <p style="font-size: 1.5em; padding-left: 3px;"><span id="total-price"><?php $order_details['dcharge'] = 60; echo '৳'.$total_price; ?></p>
				</div>
				<div style="display: flex; padding: 3px 0px; align-items: center;">
					<h2>Shipping Fee: </h2> <p style="font-size: 1.5em; padding-left: 3px;">৳60</p>
				</div>
				<div style="display: flex; padding: 3px 0px; align-items: center;">
					<h2>Total: </h2> <p style="font-size: 1.5em; padding-left: 3px;"><span id="total-price"><?php $order_details['tprice'] = $total_price+60; echo '৳'.$total_price+60; ?></p>
				</div>
			</div>

    	<form action="payment_page.php" method="post">
            <?php $_SESSION['order_details'] = $order_details; ?>
            <button class="button button--small button--green" type="submit" name="confirm_order">Confirm Payment</button>
    	</form>
		</div>
		
	</div>

		<script>
			function payment(order_details){
				console.log(order_details);
			}
		</script>
</body>
</html>