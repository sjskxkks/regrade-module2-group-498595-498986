
<?php   session_start();  ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>file system</title>
<link rel="stylesheet" type="text/css" href="./styles.css" />
</head>
   <body class="files_page">
	<div class="auth">
   <?php
      if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
       {
           header("Location:login.php");  
       }
	   $username=$_SESSION['use'];
	   printf("<h1>Welcome, %s! </h1>", htmlspecialchars($username));

		echo "<a href='logout.php'> Logout</a><br/> <br/>"; 
// get all the files from the user's directory
		echo("Your files:<br/>");
		$path = sprintf("/home/sjskkxks/files_store/uploads/%s/", htmlspecialchars($username));
		$files = scandir($path);
		$files = array_diff($files, array('..', '.','collections.txt'));
		echo("<table>");
		if (count($files)==0){
			echo("No file to display. ");
		}
		foreach ($files as $file) {// read each line of filename from the user's directory
			$h=fopen("$path/collections.txt", 'r');
			$found=false;
			while( !feof($h) ){
 				$line=trim(fgets($h));
// check whether the file has been collected by the user
  				if ($line==$file) {
    				$found=true;
  				}
			}

			fclose($h);
// display each file from the user's directory
			echo("<tr>");
			echo("<td>$file</td>");
			echo("<td><a href='viewer.php?file={$file}'>view</a></td>");
			$full_path=sprintf("/home/sjskkxks/files_store/uploads/%s/%s", $_SESSION['use'],$file);
			echo("<td><a href='deleter.php?file={$file}'>delete</a></td>");

			echo("<td><a href='viewer.php?file={$file}' download>download</a></td>");
				if ($found==false) {
					echo("<td><a href='collecter.php?file={$file}'><img height='20px' width='20px' src='./images/empty_heart.svg'></img></a></td>");
				} else {
					echo("<td><a href='collecter.php?file={$file}'><img height='20px' width='20px' src='./images/filled_heart.svg'></img></a></td>");
				}


		}

		echo("</table>");

  // the file upload section        
?>
<form enctype="multipart/form-data" action="uploader.php" method="POST">
	<p>
		<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		<label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" />
	</p>
	<p>
		<input class="buttons" type="submit" value="Upload File" name="upload_file"/>
	</p>
	
</form>
</div>


</body>
</html>
