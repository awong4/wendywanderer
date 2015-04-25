<!--
To do later:
- filter out the ones that already have happened
- filter out the bad ones (i.e. the ones with 0000-00-00 as yrs)
  in the case that all of them display
-->

<?php
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

$dbh = db_connect($wendy_dsn);

//Check to see if one of them is filled out
if(isset($_GET['startdate']) or isset($_GET['enddate']) or isset($_GET['cityid'])) {
	//Get each of part of the form
	$startdate = $_GET['startdate'];
	$enddate = $_GET['enddate'];
	$cityid = $_GET['cityid'];

	//Filter the results and loop through to display them
	$filteredtrips = getPostingInfo($startdate, $enddate, $cityid);

	echo "<h4> Search Results </h4>";

	while($filteredtripsrow = $filteredtrips->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$tripid = $filteredtripsrow['id'];
		$tripstart = $filteredtripsrow['startDate'];
		$tripend = $filteredtripsrow['endDate'];

		//Get the Owner Contact
		$tripownerresultrow = getPersonInfo($filteredtripsrow['ownerID']);
		$tripownername = $tripownerresultrow['name'];
		$tripowneremail = $tripownerresultrow['email']."@wellesley.edu";

		//Get the City name
		$cityresultrow = getCityInfo($filteredtripsrow['cityID']);
		$cityname = $cityresultrow['name'];

		echo "<div id = $tripid>";
		echo "<b>Start Date: </b>$tripstart <br>";
		echo "<b>End Date: </b>$tripend <br>";
		echo "<b>Destination: </b>$cityname <br>";
		echo "<b>Contact Name: </b>$tripownername <br>";
		echo "<b>Email: </b>$tripowneremail";
		echo "</div><br>";
	}
}

?>
