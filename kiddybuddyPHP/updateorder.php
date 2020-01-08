<?php
include("session.php");
include("commonsections.php");
include("ownercheck.php");
$activepage = "Update Orders";
$successmessage = '';
$error = '';
try{
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form            
        $orderid = mysqli_real_escape_string($db,$_POST['orderid']);
        $orderstatus = mysqli_real_escape_string($db,$_POST['orderstatus']); 
        $sqlOrder = "CALL `kiddybuddy`.`sp_update_order`($orderid,'$orderstatus');";
        $result = $db->query($sqlOrder);
                   
        if($result === FALSE)
        {
            throw new Exception($db->error);
        }
        $db->next_result();
        $count = mysqli_num_rows($result);
        $row =  $result->fetch_object();
        // If result matched $myusername and $mypassword, table row must be 1 row
            
        if($count == 1) {
            //session_register("myusername");
            
                $successmessage = 'Updated the Order Status';
        }
    }

}
catch(Exception $e)
{
$error = $e->getMessage();
}
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

          echo '<p><h3>All Orders</h3></p>';

          //if(isset($_SESSION['login_user'])) {

            $total = 0;
            echo '<table style="table-layout: fixed;overflow:scroll;">';
            echo '<tr>';
            echo '<th>Order Number</th>';
            echo '<th>Customer Name</th>';
            echo '<th>Order Date</th>';
            echo '<th>Total Amount</th>';
            echo '<th>Order Status</th>';
            echo '<th>Details</th>';
            echo '<th>Update</th>';
            echo '</tr>';

            $sqlOrder = "CALL `kiddybuddy`.`sp_get_orders`(-1);";
            $orderdetails = $db->query($sqlOrder); 
            if($orderdetails === FALSE){
            $error = $db->error;
            }
            $db->next_result();
            $count = mysqli_num_rows($orderdetails);
            while($objOrderItem = $orderdetails->fetch_object()) {

                $total = $total + $objOrderItem->TotalAmount; //add to the total cost
                
                echo '<tr><form action="" method="post">';
                echo '<td>'.$objOrderItem->OrderID.'</td>';
                echo '<td>'.$objOrderItem->CustomerName.'</td>';
                echo '<td>'.$objOrderItem->OrderDate.'</td>';
                echo '<td>$'.$objOrderItem->TotalAmount.'</td>';
                echo '<td><select  name="orderstatus">';
                echo '<option value="Placed" '. ($objOrderItem->OrderStatus == 'Placed' ? ' selected="true" ' : '').'  >Placed</option>';
                echo '<option value="Shipped" '. ($objOrderItem->OrderStatus == 'Shipped' ? ' selected="true" ' : '').'  >Shipped</option>';
                echo '<option value="Completed" '. ($objOrderItem->OrderStatus == 'Completed' ? ' selected="true" ' : '').'  >Completed</option>';   
                echo' </select></td>';
                echo "<td><a href='orderdetails.php?orderid=$objOrderItem->OrderID' class='labelbutton'>Detail</a></td>";
                echo "<td><input type='hidden' name='orderid' value='".$objOrderItem->OrderID."' /> 
                        <input type='submit' name='update' class='labelbutton' value='Update'></td>";
                echo '</form></tr>';
              
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

             <div class="row">
                    <div class="small-4 columns">

                    </div>
                    <div class="small-8 columns">
                    <label for="right-label" class="right inline"><?php echo $successmessage; ?></label>
                    </div>

        </div>
          <div class="row">
                    <div class="small-4 columns">

                    </div>
                    <div class="small-8 columns">
                    <span class="input-group-error">
                    <span class="input-group-cell"></span>
                    <span class="input-group-cell"><span class="error-message"><?php echo $error; ?></span></span>
                    </div>

            </div>
     <?php
        trailersection($activepage );
        ?>
  </body>
</html>
