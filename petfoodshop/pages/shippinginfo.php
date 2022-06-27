<?php
    session_start();
    if(!isset($_SESSION['user']))
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
    else
        $result = $result[0];
    if(!isset($_SESSION['address'])){
        $_SESSION['address'] = $result["address"];
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
            $total_quantity = 0;
            $total_price = 0;
        ?>
        <div id="myModal" class="modal">

          <!-- Modal content -->
          <div class="modal-content">
            <span class="close">&times;</span>
            <div style="display:flex; flex-direction: column; justify-content:center; align-items: center;">
                <input id="update-address-input" type="text" name="address" placeholder="Enter address" style="width: 50%; padding: 5px 5px; margin-right: 3px; margin: 5px;">
                <p id="update-address-input-msg" style="display: none; color:red;">Enter valid address.</p>
                <button id="update-address-btn" style="padding: 1px 3px; margin: 5px;">Update Address</button>
            </div>

          </div>

        </div>

        <div style="display: flex;
                        user-select: none;
                        width: 100%;
                        height: 95vh;
                        justify-content: center;
                        align-items: center;">
                <div style="display: flex; user-select: none; flex-direction: column; justify-content: flex-start; width: 50%; padding: 10px; background-color: #F5F5F5; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); border-radius:2px;">
                    <h2 style="text-align: left; padding: 3px;">BILL TO:</h2>
                    <div style="display: flex; flex-direction: row; align-items:flex-end; padding:3px;">
                        <h3 style="padding: 0px 3px;">Name:</h3>
                        <p style="padding: 0px 3px;"><?php echo $result["first_name"]." ".$result["last_name"] ?></p>
                    </div>
                    <div style="display: flex; flex-direction: row; align-items:flex-end; padding:3px;">
                        <h3 style="padding: 0px 3px;">Email:</h3>
                        <p style="padding: 0px 3px;"><?php echo $result["email"] ?></p>
                    </div>
                    <div style="display: flex; flex-direction: row; align-items:flex-end; padding:3px;">
                        <h3 style="padding: 0px 3px;">Phone:</h3>
                        <p style="padding: 0px 3px;"><?php echo $result["contact_no"] ?></p>
                    </div>
                    <div style="display: flex; flex-direction: row; align-items:flex-end; padding:3px;">
                        <h3 style="padding: 0px 3px;">Shipping Address:</h3>
                        <p style="padding: 0px 3px;"><?php echo $_SESSION['address'] ?></p>
                        <button id="address-btn" class="button button--small button--green" style="padding: 1px 3px;">Change address</button>
                    </div>
                    <br style="border: 5px solid black;">
                    <h2 style="text-align: left; padding: 3px;">MESSAGE:</h2>
                    <div style="display: flex; flex-direction: row; align-items:flex-end; padding:3px;">
                        <textarea id='message' style="resize: none;" placeholder="Enter any message (Optional)" name="message" cols="40" rows="5"></textarea>
                    </div>
                    <br style="border: 5px solid black;">
                    <button id='next' class="button button--small button--green" style="align-self: flex-end; max-width: 100px; margin-right: 10px;">NEXT</button>
                </div>

            </div>



        <?php
        } else {
        ?>
            <div style="display: flex;
                        user-select: none;
                        width: 100%;
                        height: 95vh;
                        justify-content: center;
                        align-items: center;">
                Looks like you forget to add product to your cart. Add product to your cart for complete checkout procedure.
            </div>
        <?php 
        }
        ?>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
$("#address-btn").click(function(){
  modal.style.display = "block";
});

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

$("#update-address-btn").click(function(){
  var text = $('#update-address-input').val();
  if(text.length>0){
    $.post('update_shipping_address.php',{text:text},function(response){
        location.reload();
    });
  }else{
    $('#update-address-input-msg').show();
  }
});

$("#next").click(function(){
  var text = $('#message').val();
    $.post('set_msg.php',{msg:text},function(response){
        location.replace("order.php");
    });
});

$('#update-address-input').keyup(function(){
  $('#update-address-input-msg').css("display", "none");
});

</script>

</body>
</html>