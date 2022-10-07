<?php
session_start();

$filename = $_GET['file'];

// We need to make sure that the filename is in a valid format; if it's not, display an error and leave the script.
// To perform the check, we will use a regular expression.
if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	echo "Invalid filename";
	exit;
}

$username = $_SESSION['use'];
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	exit;
}

$user_dir = sprintf("/home/sjskkxks/files_store/uploads/%s", $username);
$full_path = sprintf("home/sjskkxks/files_store/uploads/%s/%s", $username, $filename);

$h=fopen("$user_dir/collections.txt", 'r');
$found=false;
echo "<ul>\n";
$linenum=1;
while( !feof($h) ){
 $line=fgets($h);
// if the file is already in collection, remove it from collection
  if (trim($line)==$filename) {
    $contents = file_get_contents("$user_dir/collections.txt");
    $contents = str_replace($line, "", $contents);
    file_put_contents("$user_dir/collections.txt", $contents);
    $found=true;
    $linenum =$linenum+1;
    fclose($h);
    header("Location:file_system.php");
    exit;

  }
}

echo "</ul>\n";

fclose($h);
// if the file is not in collection, add the file to the list of collections
if ($found==false) {
    $fp = fopen("$user_dir/collections.txt", 'a');
    fwrite($fp, "$filename\n")or die("Unable to add to favrourite. Refresh and try again. ");
    fclose($fp);
    header("Location:file_system.php");
    exit;
}
	// header("refresh:3; url=file_system.php");
	// exit;



?>
