<?php  session_start();   // session starts with the help of this function 
$message="";

// if(isset($_SESSION['use']))   // Checking whether the session is already there or not if 
//                               // true then header redirect it to the home page directly 
//  {
//     header("Location:file_system.php"); 
//  }

if(isset($_POST['login']))   // it checks whether the user clicked login button or not 
{
$found = false;
$username = $_POST['username'];
$h = fopen("/home/sjskkxks/files_store/users.txt", "r");
// check the users.txt to see whether the user exists
$linenum = 1;
echo "<ul>\n";
while( !feof($h) ){
        $line=trim(fgets($h));
    
       if ($line==$username) {
                $found = true;
       }
}
     echo "</ul>\n";
     // if the user exists then open the user session
     fclose($h);
        if($found == true){                                 
                $_SESSION['use']=$username;
                echo '<script type="text/javascript"> window.open("file_system.php","_self");</script>';            //  On Successful Login redirects to home.php
        }
// if the user does not exist ask the user to sign up
        else
        {
            $message= "Account does not exist. Please sign up. ";        
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

<title> Login Page   </title>
<link rel="stylesheet" type="text/css" href="./styles.css" />
</head>

<body class="auth_page">

<div class="auth">
<h1>Login</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

    

 <label for="username"> Username </label>

<input class="text_input" type="text" name="username" id="username" /> 
 <br>

 <?php
 echo $message;
 ?>
<br>
 <input class="buttons" type="submit" name="login" value="Log In">


</form>
<br>
New to the site? <a href="./signup.php">Sign up</a>
</div>

</body>
</html>
