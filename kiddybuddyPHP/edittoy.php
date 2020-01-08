<?php
    include("session.php");
    include("commonsections.php");
    include("ownercheck.php");
    $activepage = "Edit Toy";
    $successmessage = '';
    $error = '';
    try{
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // username and password sent from form            
            $toyid = mysqli_real_escape_string($db,$_POST['toyid']);
            $subcategory = mysqli_real_escape_string($db,$_POST['subcategory']);
            $toyname = mysqli_real_escape_string($db,$_POST['toyname']);
            $toydescription = mysqli_real_escape_string($db,$_POST['toydescription']);
            $salesprice = mysqli_real_escape_string($db,$_POST['salesprice']); 
            $manufacturer = mysqli_real_escape_string($db,$_POST['manufacturer']);
            $imagefile = mysqli_real_escape_string($db,$_POST['imagefile']);
            $discount = mysqli_real_escape_string($db,$_POST['discount']); 
            $stock = mysqli_real_escape_string($db,$_POST['stock']); 

            $sqlToy = "CALL `kiddybuddy`.`sp_update_toy`($toyid,'$toyname','$toydescription',$salesprice,$discount,'$manufacturer',$subcategory,'$imagefile',$stock );";
            $result = $db->query($sqlToy);
                       
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
                header("location:products.php");
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
        <?php
             $sqlToyDetails = "CALL `kiddybuddy`.`sp_get_toydetails`(".$_GET['id'].");";
             $toydetails = $db->query($sqlToyDetails); 
             if($toydetails === FALSE){
             $error = $db->error;
             }
             $db->next_result();
             $count = mysqli_num_rows($toydetails);
             $toy  =  $toydetails->fetch_object();
             //T.ToyID,T.ToyName,T.Description,T.SalePrice,T.DiscountPercentage,T.Manufacturer,T.ToySubCatID,T.ToyImage,TSC.ToyCatId,I.CurrentStock
             ?>
        <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Category</label>
            </div>
            <div class="small-8 columns">
            <select class="category" id="category" name='category'>
            <?php
             $sqlCat = "CALL `kiddybuddy`.`sp_get_categories`('Main',-1);";
             $categories = $db->query($sqlCat); 
             if($categories === FALSE){
             $error = $db->error;
             }
             $db->next_result();
             while($objCat = $categories->fetch_object()) {      
               echo '<option value="'.$objCat->ToyCatId.'" '. ($objCat->ToyCatId == $toy->ToyCatId ? ' selected="true" ' : '').' >'.$objCat->CategoryName.'</option>';
             }
                ?>
            </select>
            </div>
          </div>
        <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">SubCategory</label>
            </div>
            <div class="small-8 columns">
            <select class="subcategory" id="subcategory" name='subcategory'>
            <?php
                
                    $sqlSubCat = "CALL `kiddybuddy`.`sp_get_categories`('Sub',".$toy->ToyCatId.");";
                    $subcategories = $db->query($sqlSubCat); 
                    if($subcategories === FALSE){
                                $error = $db->error;
                                }
                    $db->next_result();
                    while($objSubCat = $subcategories->fetch_object()) { 
                        echo '<option value="'.$objSubCat->ToySubCatID.'" '. ($objSubCat->ToySubCatID == $toy->ToySubCatID ? ' selected="true" ' : '').' >'.$objSubCat->SubCategoryName.'</option>';
                    }
               
                ?>
            </select>
            </div>
        </div>
        <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Toy Name</label>
            </div>
            <div class="small-8 columns">
              <input type="hidden" id="right-label" name="toyid" value ="<?php {echo $toy->ToyID;}?>"> 
              <input type="text" id="right-label" placeholder="Name of the Toy" name="toyname" value ="<?php if($error <> ""){ echo $_POST['toyname'];}else {echo $toy->ToyName;}?>">
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Manufacturer Name</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="right-label" placeholder="Name of the Maker" name="manufacturer" value ="<?php if($error <> ""){ echo $_POST['manufacturer'];}else {echo $toy->Manufacturer;}?>">
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Toy Description</label>
            </div>
            <div class="small-8 columns">
            <textarea 	id="content" name="toydescription" 	placeholder="Enter Toy Description"> <?php if($error <> ""){ echo $_POST['toydescription'];}else {echo $toy->Description;}?></textarea>              
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Sale Price</label>
            </div>
            <div class="small-8 columns">
              <input type="number" min="0.01" step="0.01" max="999999.99" id="right-label" placeholder="Sales Price per unit" name="salesprice" value ="<?php if($error <> ""){ echo $_POST['salesprice'];}else {echo $toy->SalePrice;}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Discount</label>
            </div>
            <div class="small-8 columns">
              <input type="number" min="0.00" step="0.01" max="100.00" id="right-label" placeholder="Discount percentage" name="discount" value ="<?php if($error <> ""){ echo $_POST['discount'];} else {echo $toy->DiscountPercentage;}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Toy Image File Name</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="right-label" placeholder="filename.jpg" name="imagefile" value ="<?php if($error <> ""){ echo $_POST['imagefile'];}else {echo $toy->ToyImage;}?>">
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Current Stock</label>
            </div>
            <div class="small-8 columns">
              <input type="number" step="1" id="right-label" placeholder="Discount percentage" name="stock" value ="<?php if($error <> ""){ echo $_POST['stock'];} else {echo $toy->CurrentStock;}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">

            </div>
            <div class="small-8 columns">
              <input type="submit" id="right-label" value="Update Toy" class="labelbutton">
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
           <script type="text/javascript">
                $(document).ready(function(){
                    $("select.category").change(function(){
                        var selectedCategory = $(".category option:selected").val();
                        $.ajax({
                            type: "POST",
                            url: "subcategory.php",
                            data: { category : selectedCategory , alloption : "no" } 
                        }).done(function(data){
                            $("#subcategory").html(data);
                        });
                    });
                });
            </script>
   </body>
</html>