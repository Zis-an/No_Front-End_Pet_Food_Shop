<?php
    session_start();
    if(!isset($_SESSION['user']) && !isset($_SESSION['order_details']))
        echo("<script type='text/javascript'>
            alert('Please login to complete checkout procedure.');
            location.replace(\"login.php\");
        </script>");
    require_once("db_con.php");
    $db_handle = new DBController();
    $id = $_SESSION['user'];
    $query="SELECT * FROM users where id='{$id}'";
    $result = $db_handle->runQuery($query);
    if(!isset($result[0]) && !empty(!isset($result[0]))){
        unset($_SESSION['user']);
        echo("<script type='text/javascript'>
            location.replace(\"login.php\");
        </script>"); 
    }
    else{
        $result = $result[0]; 
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shipping Information</title>
    <link rel="icon" href="../img/logo.jpg">
    <link rel="stylesheet" type="text/css" href="../css/shippinginfo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://js.braintreegateway.com/web/dropin/1.32.0/js/dropin.js"></script>
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

        <?php
        if(isset($_SESSION["cart_products"])){
        ?>
        <div style="display:flex; flex-direction:column; width:100%; height: 95vh;justify-content:center; align-items:center;">
            <div style="display:flex; flex-direction:column; width:50%; justify-content:center; align-items:center;">
                <div id="dropin-container"></div>
                <button id="submit-button" class="button button--small button--green">Purchase</button>
            </div>
        </div>
        <?php
        } else {
            echo("<script type='text/javascript'>
                location.replace(\"product.php\");
            </script>");
        }
        ?>

<script>

var button = document.querySelector('#submit-button');
$.get('token.php',function (authorization_token){
      braintree.dropin.create({
      authorization: authorization_token,
      selector: '#dropin-container'
    }, function (err, instance) {
      button.addEventListener('click', function () {
        instance.requestPaymentMethod(function (err, payload) {
          // Submit payload.nonce to your server
            $.post('payment_server.php',{nonce:payload.nonce},function(response){
                if(response == 1){
                    $.post('complete_payment_db.php',function(res){
                        if(res == 1){
                            alert('Payment successfull.');
                            location.replace("product.php");
                        }else{
                            alert('Payment failed please try again.');
                            history.back();
                        }
                    });
                }else{
                    alert('Payment failed please try again.');
                    history.back();
                }
            });
        });
      })
    });
});

</script>


</body>
</html>