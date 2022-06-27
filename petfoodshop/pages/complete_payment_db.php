<?php
    session_start();
    if(isset($_SESSION['user']) && isset($_SESSION['order_details']) && isset($_SESSION['transaction_id']) && isset($_SESSION['paid_amount'])){
        require_once("db_con.php");
        $db_handle = new DBController();
        $order_details = json_encode($_SESSION['order_details']);
        $query="INSERT INTO `orders` (`user_id`, `order_details`, `transaction_id`, `total_amount`, `total_paid_amount`, `payment_status`, `delivary_status`) VALUES ('{$_SESSION['user']}', '{$order_details}', '{$_SESSION['transaction_id']}', '{$_SESSION['order_details']['tprice']}', '{$_SESSION['paid_amount']}', 'paid', 'In progress');";
        $result = $db_handle->registerUser($query);
        foreach ($_SESSION["cart_products"] as $item){
            $up_query="UPDATE `products` SET `num_available` = num_available-{$item["quantity"]} WHERE `code` = '{$item["code"]}';";
            $db_handle->updateQuery($up_query);
        }
        if(isset($result) && !empty($result)){
            unset($_SESSION['order_details']);
            unset($_SESSION['transaction_id']);
            unset($_SESSION['paid_amount']);
            unset($_SESSION['address']);
            unset($_SESSION["cart_products"]);
            unset($_SESSION['message']);
            echo 1;
        }else{
            echo 0;
        }
    }