<?php
    include("session.php");
    include("commonsections.php");
    $activepage = "Place Order";
    $successmessage = '';
    $error = '';
    try{
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // username and password sent from form         
            $orderid = $_SESSION['order'];   
            $name = mysqli_real_escape_string($db,$_POST['name']);
            $street = mysqli_real_escape_string($db,$_POST['street']); 
            $aptno = mysqli_real_escape_string($db,$_POST['aptno']); 
            $city = mysqli_real_escape_string($db,$_POST['city']); 
            $state = mysqli_real_escape_string($db,$_POST['state']); 
            $zip = mysqli_real_escape_string($db,$_POST['zip']);
            if ($orderid === null)
            {
                throw new Exception('Order Screen Expired. Please create a new Shopping Cart');
            }
            $sqlOrder = "CALL `kiddybuddy`.`sp_create_transaction`('$name','$street','$aptno','$city','$state','$zip',$orderid);";
            $result = $db->query($sqlOrder);
                       
            if($result === FALSE)
            {
                throw new Exception($db->error);
            }
            
            $count = mysqli_num_rows($result);
            $row =  $result->fetch_object();
            // If result matched $myusername and $mypassword, table row must be 1 row
                
            if($count == 1) {
                //session_register("myusername");
                //echo 'Wait for your Email'.$passcode;
                $successmessage = 'Thank you for Ordering.';
                unset($_SESSION['cart']);
                unset($_SESSION['order']);
                header("location:orders.php");
            }
        }

    }
    catch(Exception $e)
    {
    $error = $e->getMessage();
    }
?>
<html>
   
    <?php
        headersection($activepage );
    ?>
   
   <body>
    <?php
        topbar($activepage )
    ?>
  <form method="POST" action="" style="margin-top:30px;">
  <div class="row" style="margin-top:10px;">
      <div class="large-12">
  <?php
         echo '<table style="table-layout: fixed;overflow:scroll;">';
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
         $sqlOrderData = "CALL `kiddybuddy`.`sp_get_order`(".$_SESSION['order'].");";
         $orderdetails = $db->query($sqlOrderData); 
         if($orderdetails === FALSE){
         $error = $db->error;
         }
         $db->next_result();
         $count = mysqli_num_rows($orderdetails);
         $row =  $orderdetails->fetch_object();
                
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
            echo '<p><h3>Billing Information</h3></p>';
    ?>
    
      <div class="row">
        <div class="small-8">
            <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Name</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="right-label" placeholder="Name of Payer" name="name" value ="<?php if($error <> ""){ echo $_POST['name'];}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Street Address</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="right-label" placeholder="Street Address" name="street" value ="<?php if($error <> ""){ echo $_POST['street'];}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Apt No</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="right-label" placeholder="Apt No (Optional)" name="aptno" value ="<?php if($error <> ""){ echo $_POST['aptno'];}?>" >
            </div>
          </div>
           <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">City</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="right-label" placeholder="City" name="city" value ="<?php if($error <> ""){ echo $_POST['city'];}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">State</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="right-label" placeholder="State" name="state" value ="<?php if($error <> ""){ echo $_POST['state'];}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Zip Code</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="right-label" placeholder="Zip Code" name="zip" value ="<?php if($error <> ""){ echo $_POST['zip'];}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">

            </div>
            <div class="small-8 columns">
              <input type="submit" id="right-label" value="Confirm Payment" class="labelbutton">
              <input type="reset" id="right-label" value="Reset" class="labelbutton">
            </div>
          </div>
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
    </form>

         <?php
        trailersection($activepage );
        ?>
   </body>
</html>