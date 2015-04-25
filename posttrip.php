<!doctype html>
<html lang='en'>
<head>
<title> Wendy Wanderer </title>
</head>
<body>
<h1> Welcome to Wendy Wanderer - Post a Trip</h1>

<p> This page is used to add a potential trip for the future
<br> Please enter a start date, an end date, and the name of the city and country you're visiting

<form method='GET' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
	<!-- we want users to be able to enter
		 a start date and a finish date -->
        Start date: <input type="date" name='startdate' id='textinput'> <br>
        End date: <input type="date" name='enddate' id='textinput'> <br>
        <!-- ask the user to select a city from the list -->
        City: <select name='city' id='tableselect'>
        	<option value='novalue'> Please select a city
	        <?php
	        	include('functions.php');
	        	getAllCities();
	        ?>
    	</select>

        <input type="submit" value="submit" id='submitbutton'>
</form>

<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

$dbh = db_connect($wendy_dsn);

insertTrip();

function insertTrip(){

	if(isset($_GET['city']) and $_GET['city'] == 'novalue') {
		echo "<p> Please select a city";
	} else if(isset($_GET['startdate']) and isset($_GET['enddate'])) {
		global $dbh;

	    $sql = "INSERT INTO trip(ownerID,startDate,endDate,cityID) values (?,?,?,?)";
	    // $uid = 1;
	    // include ('search2.php');
	    // $owner = getuserID($_COOKIE['username']);
	    // $uid = $owner['id'];
	    $uid = $_COOKIE['userID'];
	    echo "Hi: $uid";
	 	$start = $_GET['startdate'];
	 	$end = $_GET['enddate'];
	    $city = $_GET['city'];
	    $values = array($uid,$start,$end,$city);
	    $resultname = prepared_query($dbh,$sql,$values);
    } else {
		 echo "<p> Please choose a city you're thinking of visiting!";
	}
}

// function getuserID($searchedName){
// 	global $dbh;
// 	$getid = "SELECT id FROM user WHERE email like ?";
//     $input = $searchedName."%"; /*allow for @wellesley.edu*/
//     $values = array($input);
//     $ownerresult = prepared_query($dbh,$getid,$values);
//     $ownerresultrow = $ownerresult->fetchRow(MDB2_FETCHMODE_ASSOC);
//     return $ownerresultrow;
// }


?>


<!-- Get all the postings -->

<p>
<a href="home.html"> Home </a><br>
<a href="signup.html"> Signup </a> <br>
<a href="login.html"> Login </a> <br>
<a href="findatrip.html"> Find a Trip </a> <br>
<a href="recommendations.html"> Recommendations </a>

</body>

</html>
