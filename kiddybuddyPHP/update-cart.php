<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
include("session.php");

$product_id = $_GET['id'];
$action = $_GET['action'];
$sessionid = $_SESSION['login_session'];
if ($product_id === null){
  $product_id = "NULL";
}
$sqlCart = "CALL `kiddybuddy`.`sp_cart_action`('$action',$product_id,$sessionid);";
$cartdetails = $db->query($sqlCart); 
if($cartdetails === FALSE){
          $error = $db->error;
          }
$db->next_result();
$count = mysqli_num_rows($cartdetails);
$row =  $cartdetails->fetch_object();
// If result matched $myusername and $mypassword, table row must be 1 row
    
if($count == 1) {
    //session_register("myusername");
   $_SESSION['cart'] = $row -> v_cartid;

}

header("location:cart.php");

?>
