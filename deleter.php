<?php
session_start();

$filename = $_GET['file'];

// We need to make sure that the filename is in a valid format; if it's not, display an error and leave the script.
// To perform the check, we will use a regular expression.
if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	echo "Invalid filename";
	exit;
}

// Get the username and make sure that it is alphanumeric with limited other characters.
// You shouldn't allow usernames with unusual characters anyway, but it's always best to perform a sanity check
// since we will be concatenating the string to load files from the filesystem.
$username = $_SESSION['use'];
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	exit;
}


$full_path = sprintf("/home/sjskkxks/files_store/uploads/%s/%s", $username, $filename);
$user_dir = sprintf("/home/sjskkxks/files_store/uploads/%s", $username);
$h=fopen("$user_dir/collections.txt", 'r');
$found=false;
echo "<ul>\n";
$linenum=1;
while( !feof($h) ){
  $line=fgets($h);

  if (trim($line)==$filename) {
    $contents = file_get_contents("$user_dir/collections.txt");
    // if the file is collected remove it from collection
    $contents = str_replace($line, "", $contents);
    file_put_contents("$user_dir/collections.txt", $contents);
   
    $found=true;
    $linenum =$linenum+1;
  }
}
fclose($h);
// Now we need to get the MIME type (e.g., image/jpeg).  PHP provides a neat little interface to do this called finfo.
// delete the file from the directory
if (!unlink($full_path)) {
  echo ("the file cannot be deleted due to an error");
	header("refresh:3; url=file_system.php");
	exit;
}
else {
  echo ("the file  has been deleted");
	header("refresh:3; url=file_system.php");
	exit;
}

?>
