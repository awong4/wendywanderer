<!-- imageupload.php
PHP so that the user can upload the image file
-->
<?php

include_once('navbar.php');

$destfile='';
$person = getPersonInfo($_SESSION['userID']);

//If the title is filled out, then proceed
if (isset($_POST['title'])) {
	//If there's an upload error print that out
	if( $_FILES['imagefile']['error'] != UPLOAD_ERR_OK ) {
		print "<P>Upload error: " . $_FILES['imagefile']['error'];
	
	//Check the file size
	} else if ($_FILES['imagefile']['size'] > 100000){
		echo "Too big. Shrink your file please";
	} else {
	//Check that the file is an actual jpg
	//If the file is not a jpg, the program will exit.
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		if (false === $ext = array_search(
					$finfo->file($_FILES['imagefile']['tmp_name']),
					array(
						'jpg' => 'image/jpeg',
					     ),
					true
					)) {
			echo "Invalid file format. Click 'Post Photo' on the navigation bar and try again";
			exit();
			
		}

		// image was successfully uploaded.  
		$name = $_FILES['imagefile']['name'];
		$type = $_FILES['imagefile']['type'];
		$tmp  = $_FILES['imagefile']['tmp_name'];

		$title = htmlspecialchars($_POST['title'], ENT_QUOTES);

		//Use the person's id and a random integer from 0-999999 to be the name of the jpg file
		$personid = $person['id'];
		$personname = $person['name'];
		$destdir = 'images/';
		$randint = rand(0,999999);
		$destfilename = "$personid"."$randint".".jpg";
		$destfile = $destdir . $destfilename;

		$caption = htmlspecialchars($_POST['caption'], ENT_QUOTES);		

		//If the file exists then it'll update the file. Otherwise, it'll add into the db. 
		if( file_exists($destfile) ) {
			$query = "UPDATE images SET picfile = '$destfile' WHERE title = '$title'";
		} else {
			$query = "INSERT INTO images (title, caption, picfile, addedby) VALUES ('$title','$caption', '$destfile','$personid')";
		}
		if(move_uploaded_file($tmp, $destfile)) {
			require_once("MDB2.php");
			require_once("/home/cs304/public_html/php/MDB2-functions.php");

			require_once('wendy-dsn.inc');
			$dbh = db_connect($wendy_dsn);
			query($dbh,$query);

		} else {
			print "<p>Error moving $tmp\n";
		}
	}
}

?>
