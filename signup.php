<!--   
WendyWanderer - signup.php
Created: 04/22/2015

Processes the data from form to sign users up

 --> 

<?php
require_once("MDB2.php");	
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

include("navbar.php");

// include('functions.php');
//If all the form fields are filled out
if(isset($_POST['email']) & isset($_POST['password']) 
   & isset($_POST['passwordcheck']) & isset($_POST['name'])){
	$dbh = db_connect($wendy_dsn);
	global $dbh; 

	//Get the form fields into variables
	$name = htmlspecialchars($_POST['name']);
	$email = htmlspecialchars($_POST['email'])."@wellesley.edu";
	$password = htmlspecialchars($_POST['password']);
	$passwordcheck = htmlspecialchars($_POST['passwordcheck']);

	//Check to see if the user already exists in the db. If the user
	//exists, echo a message to them. Otherwise, if they don't then
	//check to see if the pw match. If they match, then insert user
	//into db. Otherwise, echo message that they don't match
		if(checkEmailDB($email) == 0){
			//Password check
			if ($password == $passwordcheck){
				
				$confirmation = md5(uniqid(rand(),true));
				insertUser($name, crypt($password), $email, $confirmation);
				// get the user id of the user
				$owner = getuserID($email);
				$message = "Congrats, ".htmlspecialchars($name, ENT_COMPAT, 'UTF-8')."! 
					You signed up for an account. The following confirmation code needs 
					to submitted on your profile: $confirmation";
				$subject = "Confirmation email";
				$headers = 'From: Wendy Wanderer<wendywellesleywanderer@gmail.com>'."\r\n".
					'Reply-To: wendywellesleywanderer@gmail.com'."\r\n".
					'X-Mailer: PHP/'.phpversion();
				mail($email, $subject, $message, $headers); 
	    		
				$uid = $owner['id'];
	    			// start a session for the user
				$_SESSION['userID'] = $uid;
				header("Location: profile.php");
			} else {
				echo "<script> alert('Your passwords do not match') </script>";
			}
		} else {
			echo "<script> alert('That user already exists. Please login instead') </script>";
		}		
}

?>
