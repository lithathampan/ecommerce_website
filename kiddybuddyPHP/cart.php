<?php
include("session.php");
include("commonsections.php");
$activepage = "Cart";
$successmessage = '';
$error = '';

?>

<!doctype html>
<html class="no-js" lang="en">
    <?php
        headersection($activepage );
    ?>

    <body>
    <?php
        topbar($activepage )
    ?>



    <div class="row" style="margin-top:10px;">
      <div class="large-12">
        <?php

          echo '<p><h3>Your Shopping Cart</h3></p>';

          if(isset($_SESSION['cart'])) {

            $total = 0;
            echo '<table>';
            echo '<tr>';
            echo '<th>ToyID</th>';
            echo '<th>ToyName</th>';
            echo '<th>Quantity</th>';
            echo '<th>Price</th>';
            echo '<th>Cost</th>';
            echo '</tr>';

            $sqlCart = "CALL `kiddybuddy`.`sp_get_cart`(".$_SESSION['cart'].");";
            $cartdetails = $db->query($sqlCart); 
            if($cartdetails === FALSE){
            $error = $db->error;
            }
            $db->next_result();
            $count = mysqli_num_rows($cartdetails);
            while($objCartItem = $cartdetails->fetch_object()) {

                $total = $total + $objCartItem->TotalAmount; //add to the total cost

                echo '<tr>';
                echo '<td>'.$objCartItem->ToyID.'</td>';
                echo '<td>'.$objCartItem->ToyName.'</td>';
                echo '<td>'.$objCartItem->SaleQuantity.'&nbsp;<a class="button [secondary success alert]" style="padding:5px;" href="update-cart.php?action=add&id='.$objCartItem->ToyID.'">+</a>&nbsp;<a class="button alert" style="padding:5px;" href="update-cart.php?action=remove&id='.$objCartItem->ToyID.'">-</a></td>';
                echo '<td>$'.$objCartItem->SalePrice.'</td>';
                echo '<td>$'.$objCartItem->TotalAmount.'</td>';
                echo '</tr>';
              
            }         

          echo '<tr>';
          echo '<td colspan="4" align="right">Total</td>';
          echo '<td>$'.$total.'</td>';
          echo '</tr>';

          echo '<tr>';
          echo '<td colspan="5" align="right"><a href="update-cart.php?action=empty" class="button alert">Empty Cart</a>&nbsp;<a href="products.php" class="button [secondary success alert]">Continue Shopping</a>';
          if($total > 0) {
            echo '<a href="shipping.php"><button style="float:right;">Proceed to Shipping</button></a>';
          }

          echo '</td>';

          echo '</tr>';
          echo '</table>';
        }

        else {
          echo "You have no items in your shopping cart.";
        }





          echo '</div>';
          echo '</div>';
          ?>


     <?php
        trailersection($activepage );
        ?>
  </body>
</html>
