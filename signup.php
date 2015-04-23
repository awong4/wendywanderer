<! --   
WendyWanderer - signup.php
Created: 04/22/2015

Processes the data from form to sign users up

To Do:
- Send confirmation email for signing up
- Better way to check if it's a Wellesley domain. Security issue: what if someone wants to use
wellesley.edu@gmail.com as an email?
 -->

<?php
require_once("MDB2.php");	
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

//If all the form fields are filled out
if(isset($_POST['email']) & isset($_POST['password']) 
   & isset($_POST['passwordcheck']) & isset($_POST['name'])){
	$dbh = db_connect($wendy_dsn);
	
	//Get the form fields into variables
	$name = htmlspecialchars($_POST['name']);
	$email = htmlspecialchars($_POST['email']);
	$password =crypt(htmlspecialchars($_POST['password']));
	$passwordcheck = (htmlspecialchars($_POST['passwordcheck']));
	
	//Check if email is a valid Wellesley email. If false, then return a message
	//telling them to provide a valid email. Otherwise, it checks if the passwords
	//match. If the passwords match, then the user is inserted in the db. Otherwise,
	//it returns a message telling the user the passwords don't match. 
	$verifywemail = strpos($email, '@wellesley.edu');
	if ($verifywemail === false){
		echo "You did not provide a Wellesley email. Please try again";
	} else {
		if(crypt($passwordcheck, $password) != $password) {
			echo "Your passwords do not match";
		} else {
			$insertsql = "INSERT INTO user  (name, password, email) values (?, ?, ?)";
			$data = array($name, $password, $email);
			prepared_statement($dbh, $insertsql, $data); 
			
		}		
	}

}
?>
