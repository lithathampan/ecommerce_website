<?php
   define('DB_SERVER', '127.0.0.1');
   define('DB_USERNAME', 'kiddybuddy_app_user'); //application user
   define('DB_PASSWORD', 'kiddybuddy');
   define('DB_DATABASE', 'kiddybuddy');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   $currency='$';
   // If connection fails , throw error in screen
    if (mysqli_connect_errno())
    {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
        //Common variables
    //set content-type header for sending HTML email
    $emailheader = "MIME-Version: 1.0" . "\r\n";
    $emailheader .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    //additional headers
    $emailheader .= 'From: KiddyBuddy<birdsoffeathers2018@gmail.com>' . "\r\n";
?>