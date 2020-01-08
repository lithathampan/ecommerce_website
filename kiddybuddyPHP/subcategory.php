<?php
include("session.php");
$error = "";
$category ="-1";
if(isset($_POST["category"])){
    // Capture selected country
    $category = $_POST["category"];
    $alloption = $_POST["alloption"];
    // Define country and city array
                  
    if($alloption === "yes"){
        echo '<option value="-1">All</option>'; 
    }
                   
    // Display city dropdown based on country name
    if($category !== '-1'){
        $sqlSubCat = "CALL `kiddybuddy`.`sp_get_categories`('Sub','".$category."');";
        $subcategories = $db->query($sqlSubCat); 
        if($subcategories === FALSE){
                    $error = $db->error;
                    }
        $db->next_result();
        while($objSubCat = $subcategories->fetch_object()) { 
            echo '<option value="'.$objSubCat->ToySubCatID.'">'.$objSubCat->SubCategoryName.'</option>';
        }
    } 
}
?>