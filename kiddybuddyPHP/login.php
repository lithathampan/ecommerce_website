<?php
    include("config.php");
    include("commonsections.php");
    session_start();
    $activepage = "Login";
    $error ="";
    function verifyentry($string) {
        // function to verify only alphanumeric , _ and @ characters are allowed in username and password
        if(preg_match('/[^a-z_\-0-9\@]/i', $string)) 
        {
            throw new Exception("Invalid characters in input");
        }
    }
    try{
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // username and password sent from form            
            $myusername = mysqli_real_escape_string($db,$_POST['username']);
            $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
            verifyentry($myusername);
            verifyentry($mypassword);
            $md5password = md5($mypassword);
            $sqlLogin = "CALL `kiddybuddy`.`sp_login_check`('$myusername','$md5password');";
            $result = $db->query($sqlLogin);
            if($result === FALSE)
            {
                throw new Exception($db->error);
            }
            
            $count = mysqli_num_rows($result);
            $row =  $result->fetch_object();
            // If result matched $myusername and $mypassword, table row must be 1 row
                
            if($count == 1) {
                //session_register("myusername");
                $_SESSION['login_user'] = $row->UserID;
                $_SESSION['login_role'] = $row->GroupName;
                $_SESSION['login_session'] = $row->SessionID;
                header("location: index.php");
            }else {
                throw new Exception("Your Login Name or Password is invalid");
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
        topbar($activepage );
    ?>
    <form method="POST" action="" style="margin-top:30px;">
        <div class="row">
            <div class="small-8">

                <div class="row">
                    <div class="small-4 columns">
                    <label for="right-label" class="right inline">Username</label>
                    </div>
                    <div class="small-8 columns">
                    <input type="text" id="right-label" placeholder="myusername" name="username">
                    </div>
                </div>
                <div class="row">
                    <div class="small-4 columns">
                    <label for="right-label" class="right inline">Password</label>
                    </div>
                    <div class="small-8 columns">
                    <input type="password" id="right-label" name="password">
                    </div>
                </div>

                <div class="row">
                    <div class="small-4 columns">

                    </div>
                    <div class="small-8 columns">
                    <input type="submit" id="right-label" value="Login" class="labelbutton">
                    <input type="reset" id="right-label" value="Reset" class="labelbutton">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="small-4 columns">

                    </div>
                    <div class="small-8 columns">
                    <span class="input-group-error">
                    <span class="input-group-cell"></span>
                    <span class="input-group-cell"><span class="form-error"><?php echo $error; ?></span></span>
                    </div>
                
            </div>
        </div>
        </form>

        <?php
        trailersection($activepage );
        ?>
   </body>
</html>