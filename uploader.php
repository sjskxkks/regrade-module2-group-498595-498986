<?php

session_start();

// Get the filename and make sure it is valid
$filename = basename($_FILES['uploadedfile']['name']);
if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	echo "Invalid filename";
	header("refresh:3; url=file_system.php");
	exit;
}

// Get the username and make sure it is valid
$username = $_SESSION['use'];
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	header("refresh:3; url=file_system.php");
	exit;
}
$full_path = sprintf("/home/sjskkxks/files_store/uploads/%s/%s", $username, $filename);
$user_dir = sprintf("/home/sjskkxks/files_store/uploads/%s", $username);

if (is_file($full_path)) {
	echo("File with the same name already exists. ");
// if file already exists redirect to the file system	
	header("refresh:2; url=file_system.php");
	exit;
}

else if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
	// give the directory permission 
	chmod($full_path, 0777);	

	chmod($user_dir,0777);
	echo("success");
	// if successfully uploaded return to the file system
	header("refresh:2; url=file_system.php");
	exit;
}else{
	echo("upload failed");
	
	header("refresh:2; url=file_system.php");
	exit;
}


?>
