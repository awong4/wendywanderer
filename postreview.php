<html>
<head>
<title> Wendy Wanderer </title>
</head>
<body>
<h1> Welcome to Wendy Wanderer -  Reviews</h1>

<p> This page is used to add a review to the city you went to

<form method='GET' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
	<input type="text" name='review' id='textinput'> <br>
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

insertReview();

function insertReview(){

	if(isset($_GET['city']) and $_GET['city'] == 'novalue') {
			echo "<p> Please select a city";
	} else if (isset($_GET['review'])) {
		// get the database handle
		global $dbh;

	    $sql = "INSERT INTO review(cityID,contactID,review) values (?,?,?)";
	    $review = $_GET['review'];
	    $city = $_GET['city'];
	    // $contact = 1;
	    $contact = $_COOKIE['userID'];
	    $values = array($city,$contact,htmlspecialchars($review));
	    $resultreview = prepared_query($dbh,$sql,$values);
    } else {
		 echo "<p> Please fill out all the form data fields";
	}
}

?>

<!-- Get all the postings -->

<p>
<a href="home.html"> Home </a><br>
<a href="signup.html"> Signup </a> <br>
<a href="login.html"> Login </a> <br>
<a href="findatrip.html"> Find a Trip </a> <br>
<a href="recommendations.html"> Recommendations </a>

</body>

<!-- </html> -->