<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
include("session.php");

$cartid = $_SESSION['cart'];

$sqlOrder = "CALL `kiddybuddy`.`sp_create_order`($cartid);";
$orderdetails = $db->query($sqlOrder); 
if($orderdetails === FALSE){
          $error = $db->error;
          }
$db->next_result();
$count = mysqli_num_rows($orderdetails);
$row =  $orderdetails->fetch_object();
// If result matched $myusername and $mypassword, table row must be 1 row
    
if($count == 1) {
    //session_register("myusername");
   $_SESSION['order'] = $row -> v_orderid;

}

header("location:order.php");

?>
