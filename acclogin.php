<!--
WendyWanderer - acclogin.php
Created 04/23/2015

Checks to see if the user has entered
the correct user/password to login
-->
<?php
	require_once("MDB2.php");
	require_once("/home/cs304/public_html/php/MDB2-functions.php");
	require_once('wendy-dsn.inc');
	include("navbar.php");

//If both the email and password field is filled out
if(isset($_POST['email']) & isset($_POST['password'])){
	$dbh = db_connect($wendy_dsn);

	global $dbh;	
	//Get the email and password	
	$email=htmlspecialchars($_POST['email'], ENT_QUOTES)."@wellesley.edu";
	$password=htmlspecialchars($_POST['password']);
	
	//Check if the user email exists
	//If so check that the passwords match
	$emailInfo = getEmailInfo($email);
	if(isset($emailInfo)){
		// In the db we stored the hash of the user's pw
		// when they signed up.
		$dbpw=$emailInfo['password'];

		//We use two arguments for crypt because the second argument
		//contains a hash which will be used on the first argument
		//to return a hash that will equal when the passwords are the
		//same
		if (crypt($password, $dbpw) == $dbpw){
			echo "Successfully logged in";
			// get the user id of the user
			$owner = getuserID($email);
    		$uid = $owner['id'];
    		// start a session for the user
			$_SESSION['userID'] = $uid;
			header("Location: profile.php");
		} else {
			echo "<script> alert('User/PW does not exist or is invalid. Try again.') </script>";
		}	
	} else {
		echo "<script> alert('User/PW does not exist or is invalid. Try again.') </script>";
	}	
}

?>
