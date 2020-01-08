<?php
    include("session.php");
    include("commonsections.php");
    $activepage = "Order Details";
    $successmessage = '';
    $error = '';
   
?>
<html>
   
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
        $sqlOrderData = "CALL `kiddybuddy`.`sp_get_order`(".$_GET['orderid'].");";
        $orderdetails = $db->query($sqlOrderData); 
        if($orderdetails === FALSE){
           $error = $db->error;
        }
        $db->next_result();

        $count = mysqli_num_rows($orderdetails);
        $row =  $orderdetails->fetch_object();

        echo '<p><h3>Order Detail of Order Number : '.$_GET['orderid'].'('.$row->OrderStatus.')</h3></p>';
         echo '<table style="table-layout: fixed;overflow:scroll;">';
         echo '<tr>';
         echo '<th>ToyID</th>';
         echo '<th>ToyName</th>';
         echo '<th>Quantity</th>';
         echo '<th>Price</th>';
         echo '<th>Cost</th>';
         echo '</tr>';

         $sqlCart = "CALL `kiddybuddy`.`sp_get_cart`(".$row->CartID.");";
         $cartdetails = $db->query($sqlCart); 
         if($cartdetails === FALSE){
         $error = $db->error;
         }
         $db->next_result();
         $total= 0;
         while($objCartItem = $cartdetails->fetch_object()) {

             $total = $total + $objCartItem->TotalAmount; //add to the total cost

             echo '<tr>';
             echo '<td>'.$objCartItem->ToyID.'</td>';
             echo '<td>'.$objCartItem->ToyName.'</td>';
             echo '<td>'.$objCartItem->SaleQuantity.'</td>';
             echo '<td>$'.$objCartItem->SalePrice.'</td>';
             echo '<td>$'.$objCartItem->TotalAmount.'</td>';
             echo '</tr>';
           
         }         
         
                
            if($count == 1) {
                //session_register("myusername");

                echo '<tr>';
                echo '<td colspan="4" align="right">Shipping</td>';
                echo '<td>'.($row->ShippingMethod==='USPS-2Day'?'$5.00':'0.00').'</td>';
                echo '</tr>';

                echo '<tr>';
                echo '<td colspan="4" align="right">Total</td>';
                echo '<td>$'.$row->TotalAmount.'</td>';
                echo '</tr>';
            }
       echo '</table>';
       echo '<p><h3>Shipping Address</h3></p>';
       echo '<p>'.$row->ShipAddress_Name.'</p>';
       echo '<p>'.$row->ShipAddress_Street.'</p>';
       echo '<p>'.$row->ShipAddress_AptNo.'</p>';
       echo '<p>'.$row->ShipAddress_City.'</p>';
       echo '<p>'.$row->ShipAddress_State.'</p>';
       echo '<p>'.$row->ShipAddress_ZipCode.'</p>';
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
        </div>
      </div>

         <?php
        trailersection($activepage );
        ?>
   </body>
</html>