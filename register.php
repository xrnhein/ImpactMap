<?php
session_start();
if(isset($_SESSION['user']))
{
 header("Location: index.htm");
}
//include_once 'php/common/constants.inc.php';
require_once "php/common/dbConnect.php";
require_once "php/common/class.map.php";

$map = new Map();

if(isset($_POST['btn-signup']))
{
	 $lname = trim($_POST['lname']);
	 $fname = trim($_POST['fname']);
	 $phone = trim($_POST['phone']);
	 $email = trim($_POST['email']);	 
	 $upass = md5( ($_POST['pass']) );
	 $upass1 = ($_POST['pass']);
	 $upass2 = ($_POST['pass2']);
	 
   if($fname=="") {
      $error[] = "Please enter your first name."; 
   }
   else if($lname=="") {
      $error[] = "Please enter your last name."; 
   }
   else if($email=="") {
      $error[] = "Please enter an email address."; 
   }
   else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Please enter a valid email address !';
   }
   else if($upass=="") {
      $error[] = "Please enter a password.";
   }
   else if(strlen($upass) < 6){
      $error[] = "Password must be at least 6 characters."; 
   }
   else if($upass1 != $upass2){
   		$error[] = "Passwords do not match.";
   }

else
   {
      try
      {
        
		$row = $map -> login_user($email);

         if($row['email'] == $email) {
            $error[] = "Sorry, this email address is already in use.";
         }//email in use

         else if( $map -> insert_user($fname, $lname, $phone, $email, $upass) )
	 	 {
	 		?>
	        <script>alert('Successfully Registered! Redirecting you to the Login page...');</script> 
	        <?php
	       //header("Location: login.php");
	 	 	header( "refresh:0.5; url=login.php" ); 
	 	}//insert user
     }//try
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
  
  }//else
	 /*else
	 {
	  ?>
	        <script>alert('Error while registering you...');</script>
	        <?php
	 }*/
} //if button clicked

//end php
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login & Registration System</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
 <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</head>
<body>
<center>
	<div id="login-form">
	<div class="form-container">
	<h2>Register</h2>

	      <?php
            if(isset($error))
            {
               foreach($error as $error)
               {
                  ?>
                  <div class="alert alert-danger">
                      <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                  </div>
                  <?php
               }
            }
            else if(isset($_GET['joined']))
            {
                 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                 </div>
                 <?php
            }
            ?>
	
	<br> 
	<form method="post">
		<div class="form-group">
			<input type="text" class="form-control" name="fname" placeholder="First Name *" required />
		</div>
		<div class="form-group">
			<input type="text" class="form-control" name="lname" placeholder="Last Name *" required />
		</div>
		<div class="form-group">
			<input type="tel" class="form-control" name="phone" placeholder="Phone Number"/>
		</div>
		<div class="form-group">
			<input type="email" class="form-control" name="email" placeholder="Your Email *" required/>
		</div>	
		<div class="form-group">	
			<input type="password" class="form-control" name="pass" placeholder="Your Password *" required />
		</div>
		<div class="form-group">	
			<input type="password" class="form-control" name="pass2" placeholder="Re-enter Password *" required />
		</div>
		<button type="submit" class="btn btn-block btn-primary" action="login.php" name="btn-signup"><i class="glyphicon glyphicon-open-file"></i>&nbsp;SIGN UP</button>

		<div class="clearfix"></div><hr />

		 <label>Already have an account? <a href="login.php">Sign In</a></label>

	</form>
	</div>
	</div>
</center>
</body>
</html>