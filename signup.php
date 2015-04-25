<!--   
WendyWanderer - signup.php
Created: 04/22/2015

Processes the data from form to sign users up

To Do:
- Send confirmation email for signing up
 --> 

<?php
require_once("MDB2.php");	
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

include('functions.php');
//If all the form fields are filled out
if(isset($_POST['email']) & isset($_POST['password']) 
   & isset($_POST['passwordcheck']) & isset($_POST['name'])){
	$dbh = db_connect($wendy_dsn);
	global $dbh; 

	//Get the form fields into variables
	$name = htmlspecialchars($_POST['name']);
	$email = htmlspecialchars($_POST['email'])."@wellesley.edu";
	$password =crypt(htmlspecialchars($_POST['password']));
	$passwordcheck = (htmlspecialchars($_POST['passwordcheck']));

	//Check to see if the user already exists in the db. If the user
	//exists, echo a message to them. Otherwise, if they don't then
	//check to see if the pw match. If they match, then insert user
	//into db. Otherwise, echo message that they don't match
		if(checkEmailDB($email) == 0){
			//Password check
			if(crypt($passwordcheck, $password) == $password) {
				insertUser($name, $password, $email);
				// echo "$email";
				$owner = getuserID($email);
	    		$uid = $owner['id'];
				setcookie('userID',$uid);
			} else {
				echo "Your passwords do not match";
			}
		} else {
			echo "That user already exists. Please login instead";
		}		
}

// Function to get the user id from the email
// deals with cookies so needs to be in this file
function getuserID($searchedName){
	global $dbh;
	$getid = "SELECT id FROM user WHERE email like ?";
    $input = $searchedName."%"; /*allow for @wellesley.edu*/
    $values = array($input);
    $ownerresult = prepared_query($dbh,$getid,$values);
    $ownerresultrow = $ownerresult->fetchRow(MDB2_FETCHMODE_ASSOC);
    return $ownerresultrow;
}

?>
