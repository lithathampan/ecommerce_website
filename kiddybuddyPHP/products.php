<?php
    include("session.php");
    include("commonsections.php");
    $activepage = "Products";
    $successmessage = '';
    $error = '';
    $selcategory = -1;
    $selsubcategory = -1;
      if($_SERVER["REQUEST_METHOD"] == "POST") {
          // username and password sent from form            
          $selcategory = $_POST['category'];
          $selsubcategory = $_POST['subcategory'];
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

  
    <?php
    /*
      $ci=1;
      $sci=1;
      $sqlCat = "CALL `kiddybuddy`.`get_categories`('Main',-1);";
      $categories = $db->query($sqlCat); 
      if($categories === FALSE){
        $error = $db->error;
      }
      $db->next_result();
      echo '<li class="has-dropdown"><a href="#">Category</a>';
      echo '<ul class="dropdown">';
      echo '<li><label>Level One</label></li>';
      while($objCat = $categories->fetch_object()) {        
      //  $categories->close();
      //$sql = "CALL `kiddybuddy`.`get_categories`();";      
        echo '<li class="has-dropdown"><a href="#">'.$objCat->CategoryName.'</a>';
        echo '<ul class="dropdown">';
        echo '<li><label>Level Two</label></li>';
        $sqlSubCat = "CALL `kiddybuddy`.`get_categories`('Sub',$objCat->ToyCatId);";
        $subcategories = $db->query($sqlSubCat); 
       if($subcategories === FALSE){
          $error = $db->error;
        }
        $db->next_result();
        while($objSubCat = $subcategories->fetch_object()) { 
          echo '<li><a href="#">'.$objSubCat->SubCategoryName.'</a></li>';
        }
        echo '</li>';
        echo '</ul>';
        $ci++;
      }
      echo '</ul>';
      echo '</li>';
     // $db->next_result();
     */
    ?>
    
    <div class="row" style="margin-top:10px;">
      <div class="small-12">
      <div class="row">
          <div class="small-12 columns">
          <form method="POST" action="" style="margin-top:30px;">
    <table>
        <tr>
            <td>
                <label>Category:</label>
                <select class="category" name="category">
                <option value="-1">All</option>
                <?php
                  $sqlCat = "CALL `kiddybuddy`.`sp_get_categories`('Main',-1);";
                    $categories = $db->query($sqlCat); 
                    if($categories === FALSE){
                    $error = $db->error;
                    }
                    $db->next_result();
                    while($objCat = $categories->fetch_object()) {      
                      echo '<option value="'.$objCat->ToyCatId.'" '. ($objCat->ToyCatId == $selcategory ? ' selected="true" ' : '').'  >'.$objCat->CategoryName.'</option>';
                    }
                    ?>
                </select>
            </td>
            <td>
                <label>SubCategory:</label>
                <select class="subcategory" id="subcategory" name="subcategory">
                <option value="-1">All</option>
                <?php
                //Populate from posted category
                    if($selcategory !== -1)
                    {
                      $sqlSubCat = "CALL `kiddybuddy`.`sp_get_categories`('Sub','".$selcategory."');";
                      $subcategories = $db->query($sqlSubCat); 
                      if($subcategories === FALSE){
                                  $error = $db->error;
                                  }
                      $db->next_result();
                      while($objSubCat = $subcategories->fetch_object()) { 
                          echo '<option value="'.$objSubCat->ToySubCatID.'" '. ($objSubCat->ToySubCatID == $selsubcategory ? ' selected="true" ' : '').'  >'.$objSubCat->SubCategoryName.'</option>';
                      }
                    }
                ?>
                 </select>   
                <!--Response will be inserted here-->
            </td>
            <td id="apply">
            <input type="submit" value="Apply" class="labelbutton" />
              
            </td>
        </tr>
    </table>
    </form>
          </div>
        </div>
      <div class="row">
          <div class="small-12 columns">
      <table style="table-layout: fixed;overflow:scroll;">
        <?php
          $i=0;
          $product_id = array();
          $product_quantity = array();
          $sql = "CALL `kiddybuddy`.`sp_get_toylist`($selcategory, $selsubcategory);";
          $result = $db->query($sql); 
          if($result === FALSE){
            $error = $db->error;
          }

          if($result){
            while($obj = $result->fetch_object()) {
              if($i%3 == 0){
                echo "<tr>";
              }
              echo '<td>';
              echo '<p><h3>'.$obj->ToyName.'</h3></p>';
              echo '<img src="images/products/'.$obj->ToyImage.'"/>';
              echo '<p><strong>Manufacturer</strong>: '.$obj->Manufacturer.'</p>';
              echo '<p><strong>Description</strong>: '.$obj->Description.'</p>';
              echo '<p><strong>Units Available</strong>: '.$obj->CurrentStock.'</p>';
              echo '<p><strong>Price (Per Unit)</strong>: '.$currency.$obj->SalePrice.'</p>';
              


              if($obj->CurrentStock > 0){
                echo '<p><a href="update-cart.php?action=add&id='.$obj->ToyID.'"><input type="submit" value="Add To Cart" class="labelbutton" /></a></p>';
              }
              else {
                echo '<p>Out Of Stock!</p>';
              }
              if($_SESSION['login_role'] === 'owner'){
                echo '<p><a href="edittoy.php?id='.$obj->ToyID.'"><input type="submit" value="Edit Toy" class="labelbutton" /></a></p>';
              }
              echo '</td>';
              if($i%3 == 2) {
                echo "</tr>"; 
              }
              $i++;
            }

          }

          //$_SESSION['product_id'] = $product_id;


          echo '</table>';
          //echo '</div>';
          ?>
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
                  data: { category : selectedCategory , alloption : "yes" } 
              }).done(function(data){
                  $("#subcategory").html(data);
              });
          });
      });
</script>
  </body>
</html>