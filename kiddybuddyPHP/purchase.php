<?php
    include("session.php");
    include("commonsections.php");
    include("ownercheck.php");
    $activepage = "Purchase";
    $successmessage = '';
    $error = '';
    try{
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // username and password sent from form            
            $toyid = mysqli_real_escape_string($db,$_POST['toyid']);
            $quantity = mysqli_real_escape_string($db,$_POST['quantity']); 
            $unitcost = mysqli_real_escape_string($db,$_POST['unitcost']); 

            $sqlPurchase = "CALL `kiddybuddy`.`sp_add_purchase`($toyid,$quantity,$unitcost);";
            $result = $db->query($sqlPurchase);
                       
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
                
                    $successmessage = 'Thank you for adding purchase. Stock has been updated';
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
      <div class="row">
        <div class="small-8">

        <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Toy</label>
            </div>
            <div class="small-8 columns">
            <select id="right-label" name='toyid'>
            <?php
            $sql = "CALL `kiddybuddy`.`sp_get_toylist`(-1, -1);";
            $result = $db->query($sql); 
            if($result === FALSE){
                $error = $db->error;
            }
            $db->next_result();
            if($result){
                while($obj = $result->fetch_object()) {
                    echo '<option value="'.$obj->ToyID.'">'.$obj->ToyName.'</option>';
                }
            }
                ?>
            </select>
            </div>
          </div>
            <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Quantity</label>
            </div>
            <div class="small-8 columns">
              <input type="number" id="right-label" placeholder="Number of Units" name="quantity" value ="<?php if($error <> ""){ echo $_POST['quantity'];}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Unit Cost</label>
            </div>
            <div class="small-8 columns">
              <input type="number" min="0.01" step="0.01" max="999999.99" id="right-label" placeholder="Purchase cost per unit" name="unitcost" value ="<?php if($error <> ""){ echo $_POST['unitcost'];}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">

            </div>
            <div class="small-8 columns">
              <input type="submit" id="right-label" value="Add Purchase" class="labelbutton">
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