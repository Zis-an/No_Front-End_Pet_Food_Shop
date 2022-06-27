<?php
      session_start();
      if(!empty($_SESSION["cart_products"])) {
            if(!empty($_POST["action"])){
                  if($_POST["action"] == 'increment'){
                        $i=0;
                        $total=0;
                        $count=0;
                        $increment=false;
                        foreach ($_SESSION["cart_products"] as $row){
                              if($_POST['product_code'] == $row['code']) {
                                    $_SESSION["cart_products"][$i]['quantity'] = $_SESSION["cart_products"][$i]['quantity']+1;
                                    $count = $_SESSION["cart_products"][$i]['quantity'];
                                    $increment=true;
                              }
                              $total=$total+$_SESSION["cart_products"][$i]['quantity'];
                              $i=$i+1;
                        }
                        echo json_encode(array("count"=>$count,"total"=>$total,"increment"=>$increment));  
                  }
                  else if($_POST["action"] == 'decrement'){
                        $i=0;
                        $total=0;
                        $count=1;
                        $decrement=false;
                        foreach ($_SESSION["cart_products"] as $row){
                              if($_POST['product_code'] == $row['code']) {
                                    if($_SESSION["cart_products"][$i]['quantity']>=2){
                                          $_SESSION["cart_products"][$i]['quantity'] = $_SESSION["cart_products"][$i]['quantity']-1;
                                          $count = $_SESSION["cart_products"][$i]['quantity'];
                                          $decrement=true;
                                    }

                              }
                              $total=$total+$_SESSION["cart_products"][$i]['quantity'];
                              $i=$i+1;
                        }
                        echo json_encode(array("count"=>$count,"total"=>$total, "decrement"=>$decrement));
                  }
                  else if($_POST["action"] == 'empty'){
                        unset($_SESSION["cart_products"]);
                        echo True;
                  }
                  else if($_POST["action"] == 'deleterow'){
                        $items_in_cart = is_array($_SESSION['cart_products']) ? count($_SESSION['cart_products']) : 0;
                        if($items_in_cart>1){
                              $i=0;
                              foreach ($_SESSION["cart_products"] as $row){
                                    if($_POST['product_code'] == $row['code']) {
                                          $data = $row;
                                          array_splice($_SESSION["cart_products"], $i, 1);
                                          echo json_encode(array("delete_row"=>True, "item"=>$data));
                                          break;
                                    }
                                    $i=$i+1;
                              }
                        }else{
                              unset($_SESSION["cart_products"]);
                              echo json_encode(array("empty_cart"=>True));
                        }
                        
                  }
            }
            
      } 
?>