<!doctype html>
<html lang='en'>
<head>
<title> Wendy Wanderer </title>
</head>
<body>
<h1> Welcome to Wendy Wanderer - Post a Trip</h1>

<!-- Search function -->

<!-- id int auto_increment primary key,
        ownerID int NOT NULL,
        foreign key(ownerID) references user(id) on delete cascade,
        startDate date,
        endDate date,
        cityID int NOT NULL, -->
<p> This page is used to add a potential trip for the future
<br> Please enter a start date, an end date, and the name of the city and country you're visiting

<form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
	<!-- we want users to be able to enter
		 a start date, a finish date, and the city name -->
        Start date: <input type="text" name="startdate" id='textinput'> <br>
        End date: <input type="text" name="enddate" id='textinput'> <br>
        City: <input type="text" name="cityname" id='textinput'> <br>

        <input type="submit" value="submit" id='submitbutton'>
</form>


<!-- Get all the postings -->

<p>
<a href="home.html"> Home </a><br>
<a href="signup.html"> Signup </a> <br>
<a href="login.html"> Login </a> <br>
<a href="findatrip.html"> Find a Trip </a> <br>
<a href="recommendations.html"> Recommendations </a>


<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

$dbh = db_connect($wendy_dsn);

insertTrip();

function insertTrip(){
	// check to see all the forms values are not null
	if(isset($_GET['startdate']) and 
		isset($_GET['enddate']) and 
		isset($_GET['city'])){
		global $dbh;

		$cityID = getID(isset($_GET['city']));
	    $sqlname = "INSERT INTO Trip values (?,?,?,?)";
	    $owner = 0;
	 	$start = $_GET['startdate'];
	 	$end = $_GET['enddate'];
	    $cID = $cityID;
	    $values = array($owner,$start,$end,$cID);
	    $resultname = prepared_query($dbh,$sqlname,$values);

	    
	} else {
		 echo "<p> Please fill out all the form data fields";
	}
}

function getID($searchedName){
		$getcityid = "SELECT id FROM city where name like ?";
        $input = "%".$searchedName."%"; /*allow for variations*/
        $values = array($input);
        global $dbh;
        $result = prepared_query($dbh,$getcityid,$values);

        $row = $result->fetchRow(MDB2_FETCHMODE_ASSOC);
	    $id = $row['id'];
        return $id;
}


?>

</body>

</html>