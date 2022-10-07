<?php  
$message="";
session_start();   // session starts with the help of this function 



if(isset($_POST['signup']))   // it checks whether the user clicked login button or not 
{
  $found = false;
  $username = $_POST['username'];
     
  $h = fopen("/home/sjskkxks/files_store/users.txt", "r");
// check through the user list to see whether the user already exists
  $linenum = 1;
  echo "<ul>\n";
  while( !feof($h) ){
    $line=trim(fgets($h));
    
    if ($line==$username) {
      $found = true;
    }
  }
  echo "</ul>\n";
     
  fclose($h);
  if($found == true) {                                 
    $message ="Username already exists.";
  }

      // make sure that the user name is valid
  else if (!preg_match('/^[\w_\-]+$/', $username)) {
    $message = "Illegal character(s) exist in the usename.";
  }
  else
	{
		// add the username to the user list
      $fp = fopen('/home/sjskkxks/files_store/users.txt', 'a');
      fwrite($fp, "\n$username")or die("Unable to register. Refresh and try again. ");
	    fclose($fp);
	    $old=umask(0);
	    // create the user's own directory to store its files
      mkdir("/home/sjskkxks/files_store/uploads/$username",0777, true);
	    umask($old);
	    // add the collection txt
	    file_put_contents("/home/sjskkxks/files_store/uploads/$username/collections.txt", "");
      echo "Signup successful, redirecting to login page. ";   
      header("refresh:2; url=login.php");
      exit;
  }
}
?>
<!DOCTYPE html>
<html lang = "en">
<head>

<title> Signup Page   </title>
<link rel="stylesheet" type="text/css" href="./styles.css" />
</head>

<body class="auth_page">
    <div class="auth">
<br><h1>Sign up</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
   
    <label for="username"> Username </label>
 <input class="text_input" type="text" name="username" id="username" > 
 <br>
 <?php echo $message;
 ?>
<br>
 <input class="buttons" type="submit" name="signup" value="Sign up">


</form>
<br>
Already has an account? <a href="./login.php">Log in</a>
</div>

</body>
</html>
