<?php
    include("config.php");
    include("commonsections.php");
    session_start();
    $activepage = "Register";
    $successmessage = '';
    $error = '';
    function verifyunamepwd($string) {
        // function to verify only alphanumeric , _ and @ characters are allowed in username and password
        if(preg_match('/[^a-zA-Z_\-0-9\@]/i', $string)) 
        {
            throw new Exception("Invalid special characters in Username or Password(Only @ and _ allowed).");
        } 
        if(strlen($string) < 8){
            throw new Exception("Username and Password should be at least 8 character.");
        }
    }
    function verifyemail($string) {
        // function to verify only alphanumeric , _ and @ characters are allowed in username and password
        if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid Email Address Provided");
        }
    }
    try{
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // username and password sent from form            
            $fname = mysqli_real_escape_string($db,$_POST['fname']);
            $mname = mysqli_real_escape_string($db,$_POST['mname']); 
            $lname = mysqli_real_escape_string($db,$_POST['lname']); 
            $useremail = mysqli_real_escape_string($db,$_POST['useremail']); 
            $requsername = mysqli_real_escape_string($db,$_POST['username']);
            $reqpassword = mysqli_real_escape_string($db,$_POST['password']); 
            verifyunamepwd($requsername);
            verifyunamepwd($reqpassword);
            verifyemail($useremail);
            $md5password = md5($reqpassword);
            $sqlRegister = "CALL `kiddybuddy`.`sp_add_user`('$fname','$mname','$lname','$useremail','$requsername','$md5password');";
            $result = $db->query($sqlRegister);
                       
            if($result === FALSE)
            {
                throw new Exception($db->error);
            }
            
            $count = mysqli_num_rows($result);
            $row =  $result->fetch_object();
            // If result matched $myusername and $mypassword, table row must be 1 row
                
            if($count == 1) {
                //session_register("myusername");
                $to = $useremail;
                $to = 'lithathampan@gmail.com'; //debug overwrite
                $subject = "Registration Request";
                $mailContent = 'Dear '.$fname.', 
                <br/>Thank you for Registering on Kiddy Buddy Online Shop. 
                <br/><br/>Regards,
                <br/>KiddyBuddy Toy Shop';
                //send email
                $success = mail($to,$subject,$mailContent,$emailheader);
                //echo 'Wait for your Email'.$passcode;
                if (!$success) {
                    throw new Exception(error_get_last()['message']);
                }
                else{
                    $successmessage = 'Thank you for registering.';
                }

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
    <!--Render Registration Form with MemberType,
Name, InstitutionID ,DateofBirth, BranchName,
StartYearMonth,EndYearMonth ,EmailID,
RequestedUserName, RequestedPassword;-->
      <div class="row">
        <div class="small-8">
            <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">First Name</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="right-label" placeholder="YourFirstName" name="fname" value ="<?php if($error <> ""){ echo $_POST['fname'];}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Middle Name</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="right-label" placeholder="YourMiddleName" name="mname" value ="<?php if($error <> ""){ echo $_POST['mname'];}?>">
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Last Name</label>
            </div>
            <div class="small-8 columns">
              <input type="text" id="right-label" placeholder="YourLastName" name="lname" value ="<?php if($error <> ""){ echo $_POST['lname'];}?>" required>
            </div>
          </div>
           <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">E-Mail Address</label>
            </div>
            <div class="small-8 columns">
              <input type="email" id="right-label" placeholder="youremail@domain.com" name="useremail" value ="<?php if($error <> ""){ echo $_POST['useremail'];}?>" required>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Proposed Username</label>
            </div>
            <div class="small-8 columns">
            <span class="has-tip tip-top" data-tooltip aria-haspopup="true" title="Minimum 8 characters with only @ and _ as special characters">
              <input type="text" id="right-label"  name="username" required>
              </span>
            </div>
            
          </div>
          <div class="row">
            <div class="small-4 columns">
              <label for="right-label" class="right inline">Proposed Password</label>
            </div>
            <div class="small-8 columns">
            <span class="has-tip tip-top" data-tooltip aria-haspopup="true" title="Minimum 8 characters with only @ and _ as special characters">
              <input type="password" id="right-label" name="password" required>
              </span>
            </div>
          </div>
          <div class="row">
            <div class="small-4 columns">

            </div>
            <div class="small-8 columns">
              <input type="submit" id="right-label" value="Register" class="labelbutton">
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
   </body>
</html>