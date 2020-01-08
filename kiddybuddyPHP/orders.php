<?php
include("session.php");
include("commonsections.php");
$activepage = "Orders";
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

          echo '<p><h3>My Orders</h3></p>';

          //if(isset($_SESSION['login_user'])) {

            $total = 0;
            echo '<table>';
            echo '<tr>';
            echo '<th>Order Number</th>';
            echo '<th>Order Date</th>';
            echo '<th>Total Amount</th>';
            echo '<th>Order Status</th>';
            echo '<th>Details</th>';
            echo '</tr>';

            $sqlOrder = "CALL `kiddybuddy`.`sp_get_orders`(".$_SESSION['login_user'].");";
            $orderdetails = $db->query($sqlOrder); 
            if($orderdetails === FALSE){
            $error = $db->error;
            }
            $db->next_result();
            $count = mysqli_num_rows($orderdetails);
            while($objOrderItem = $orderdetails->fetch_object()) {

                $total = $total + $objOrderItem->TotalAmount; //add to the total cost

                echo '<tr>';
                echo '<td>'.$objOrderItem->OrderID.'</td>';
                echo '<td>'.$objOrderItem->OrderDate.'</td>';
                echo '<td>$'.$objOrderItem->TotalAmount.'</td>';
                echo '<td>'.$objOrderItem->OrderStatus.'</td>';
                echo "<td><a href='orderdetails.php?orderid=$objOrderItem->OrderID' class='labelbutton'>Detail</a></td>";
                echo '</tr>';
              
            }         

        /*  echo '<tr>';
          echo '<td colspan="4" align="right">Total</td>';
          echo '<td>$'.$total.'</td>';
          echo '</tr>';

          echo '<tr>';
          echo '<td colspan="5" align="right"><a href="update-cart.php?action=empty" class="button alert">Empty Cart</a>&nbsp;<a href="products.php" class="button [secondary success alert]">Continue Shopping</a>';
          if($total > 0) {
            echo '<a href="shipping.php"><button style="float:right;">Proceed to Shipping</button></a>';
          }

          echo '</td>';

          echo '</tr>';*/
          echo '</table>';
        //}

        //else {
       //   echo "You have not made any orders";
        //}





          echo '</div>';
          echo '</div>';
          ?>


     <?php
        trailersection($activepage );
        ?>
  </body>
</html>
