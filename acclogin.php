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

	include('functions.php');
//If both the email and password field is filled out
if(isset($_POST['email']) & isset($_POST['password'])){
	$dbh = db_connect($wendy_dsn);

	global $dbh;	
	//Get the email and password	
	$email=htmlspecialchars($_POST['email'])."@wellesley.edu";
	$password=htmlspecialchars($_POST['password']);
	
	//Check if the user email exists
	//If so check that the passwords match
	$emailInfo = getEmailInfo($email);
	if(isset($emailInfo)){
		$dbpw=$emailInfo['password'];
		if (crypt($password, $dbpw) == $dbpw){
			echo "Successfully logged in";
		} else {
			echo "User/PW does not exist or is invalid";
		}	
	} else {
		echo "User/PW does not exist or is invalid";
	}	
}

?>
