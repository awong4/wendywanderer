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
        Start date: <input type="text" name='startdate' id='textinput'> <br>
        End date: <input type="text" name='enddate' id='textinput'> <br>
        <!-- ask the user to select a city from the list -->
        City: <select name='city' id='tableselect'>
        	<option value='novalue'> Please select a city
	        <?php
				require_once("MDB2.php");
				require_once("/home/cs304/public_html/php/MDB2-functions.php");
				require_once('wendy-dsn.inc');

				$dbh = db_connect($wendy_dsn);
				$sql = "SELECT name FROM city";
				$cityname = query($dbh,$sql);

				while($row = $cityname->fetchRow(MDB2_FETCHMODE_ASSOC)) {
				    $name = $row['name'];
				    echo "<option value='$name'> $name\n";
			 	}
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
	    $owner = 1;
	 	$start = $_GET['startdate'];
	 	$end = $_GET['enddate'];
	    $city = $_GET['city'];

	    $result = getID($city);
	    $row = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
	    $id = $row['id'];
	    // echo "ID: $id";
	    $values = array($owner,$start,$end,$id);
	    $resultname = prepared_query($dbh,$sql,$values);
	    // echo "$city";
    } else {
		 echo "<p> Please fill out all the form data fields";
	}
}

function getID($searchedName){
	global $dbh;
	$getcityid = "SELECT id FROM city WHERE name like ?";
    $input = "%".$searchedName."%"; /*allow for variations*/
    $values = array($input);
    $result = prepared_query($dbh,$getcityid,$values);
    return $result;
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

</html>