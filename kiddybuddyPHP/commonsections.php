
<?php
function headersection($activepage)
{
   echo' <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>'.$activepage.' || KiddyBuddy Toy Shop</title>
        <link rel="stylesheet" href="css/foundation.css" />
        <link rel="stylesheet" href="css/app.css" />  
        <script src="js/vendor/modernizr.js"></script>      
   </head>';
}
function topbar($activepage)
{
    echo '<nav class="top-bar" data-topbar role="navigation">
      <ul class="title-area">
        <li class="name">
          <h1><a href="index.php">KiddyBuddy Toy Shop</a></h1>
        </li>
        <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
      </ul>

      <section class="top-bar-section">
      <!-- Right Nav Section -->
        <ul class="right"> ';
        if (isset($_SESSION['login_user']) and $_SESSION['login_role'] === 'owner'){
            echo '<li class="has-dropdown"><a href="#">Owner</a>';
            echo '<ul class="dropdown">';
            echo '<li><label>Level One</label></li>';
            echo '<li><a href="purchase.php">Add Purchase</a></li>';
            echo '<li><a href="addtoy.php">Add a Toy</a></li>';
            echo '<li><a href="updateorder.php">Update Order</a></li>';
            echo '</ul>';
            echo '</li>';
          }
        echo '<li class="divider"></li>';
        if(isset($_SESSION['login_user'])){
        //echo '<li'.($activepage == 'about' ? ' class="active"' : '').'><a href="about.php">About</a></li>';
        echo '<li'.($activepage == 'Products' ? ' class="active"' : '').'><a href="products.php">Products</a></li>';
        echo '<li'.($activepage == 'Cart' ? ' class="active"' : '').'><a href="cart.php">View Cart</a></li>';
        echo '<li'.($activepage == 'Orders' ? ' class="active"' : '').'><a href="orders.php">My Orders</a></li>';
        //echo '<li'.($activepage == 'contact' ? ' class="active"' : '').'><a href="contact.php">Contact</a></li>';
         
         //   echo '<li><a href="account.php">My Account</a></li>';
            echo '<li><a href="logout.php">Log Out</a></li>';
          }
          else{
            echo '<li'.($activepage == 'Login' ? ' class="active"' : '').'><a href="login.php">Log In</a></li>';
            echo '<li'.($activepage == 'Register' ? ' class="active"' : '').'><a href="register.php">Register</a></li>';
          }
       echo' </ul>
      </section>
    </nav>';
        }

function trailersection($activepage)
{
    echo'<div class="row" style="margin-top:10px;">
        <div class="small-12">

            <footer>
            <p style="text-align:center; font-size:0.8em;">&copy; KiddyBuddy Toys Shop. All Rights Reserved.</p>
            </footer>

        </div>
        </div>

        <script src="js/vendor/jquery.js"></script>
        <script src="js/foundation.min.js"></script>
        <script>
        $(document).foundation();
        </script>';
}
?>
  