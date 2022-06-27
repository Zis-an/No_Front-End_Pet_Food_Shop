<?php
      session_start();

      if(!empty($_SESSION["cart_products"])) {
            $result = array();
            foreach ($_SESSION["cart_products"] as $row){
                  $result[] = $row['code'];
            }
            if(!empty(in_array($_POST['product_code'],$result))) {
                  echo "Product is already in  cart. Please goto cart for checkout."; 
            } else {
                  $_SESSION['cart_products'][] = ['code' => $_POST['product_code'], 'quantity' => 1];
                  echo "Product stored in cart. Please goto cart for checkout.";
            }
      } else {
            $_SESSION['cart_products'][] = ['code' => $_POST['product_code'], 'quantity' => 1];
            echo "Product stored in cart. Please goto cart for checkout.";
      } 
?>