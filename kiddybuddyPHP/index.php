<?php
    include("session.php");
    include("commonsections.php");
    $activepage = "Home";
?>
<!doctype html>
<html class="no-js" lang="en">
  
  <?php
        headersection($activepage );
    ?>
  <body>

   
   <body>
    <?php
        topbar($activepage );
    ?>




    <img data-interchange="[images/KiddyBuddyHome.jpg, (retina)], [images/KiddyBuddyHome.jpg, (large)], [images/KiddyBuddyHome.jpg, (mobile)], [images/KiddyBuddyHome.jpg, (medium)]">
    <noscript><img src="images/KiddyBuddyHome.jpg"></noscript>


    <?php
        trailersection($activepage );
        ?>
  </body>
</html>