<?php
   include('config.php');
   session_start();
   //check the username currently logged in
  /* $user_check = $_SESSION['login_user'];
   //form the mysql query to check the username in db
   $ses_sql = mysqli_query($db,"select UserName from User where UserName = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['username'];*/
   //if no user is found , redirect to login page
   if(!isset($_SESSION['login_user'])){
      header("location: login.php");
   }
?>