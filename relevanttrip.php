<!-- relevanttrip.php -->
<!-- this is the php file for searchtrip.php -->
<!-- it is used to get all the trips that match the criteria for trips entered -->

<?php
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

$dbh = db_connect($wendy_dsn);

//Check to see if one of them is filled out
if (isset($_GET['cityid']) or isset($_GET['rangestartdate']) or isset($_GET['rangeenddate']) or isset($_GET['startdate']) or isset($_GET['enddate'])){

	$cityid = $_GET['cityid'];

	if(($_GET['rangestartdate'] == '') and ($_GET['rangeenddate'] == '') and ($_GET['startdate'] == '') and ($_GET['enddate'] == '')){
		$startdate = $_GET['startdate'];
		$enddate = $_GET['enddate'];
		$filteredtrips = getPostingInfo($startdate, $enddate, $cityid);
	}else if (((isset($_GET['rangestartdate'])) or (isset($_GET['rangeenddate']) )) and(($_GET['rangestartdate'] != '') or ($_GET['rangeenddate'])) ){
		echo "range";
		$startdate = $_GET['rangestartdate'];
		$enddate = $_GET['rangeenddate'];
		$filteredtrips = getPostingInfoRange($startdate, $enddate, $cityid);

	}else {
		echo "exact one";
		//Get each of part of the form
		$startdate = $_GET['startdate'];
		$enddate = $_GET['enddate'];
		//Filter the results and loop through to display them
		$filteredtrips = getPostingInfo($startdate, $enddate, $cityid);
	} 

	echo '<td valign="top" width="70%" id="resultsdiv">';
	echo "<h4> Search Results </h4>";
	// get the id of user logged on
	$buddyid = $_SESSION['userID'];

	//since getPostingInfo return everything that matches
	//we need to filter through row by row and print that way
	while($filteredtripsrow = $filteredtrips->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$tripid = $filteredtripsrow['id'];
		$tripstart = $filteredtripsrow['startDate'];
		$tripend = $filteredtripsrow['endDate'];
		if ($tripstart == '0000-00-00'){
			$tripstart = "Flexible";
		}

		if ($tripend == '0000-00-00'){

			$tripend = "Flexible";
		}

		$tripnotes = $filteredtripsrow['description'];

		//Get the Owner Contact
		$ownerid = $filteredtripsrow['ownerID'];
		$tripownerresultrow = getPersonInfo($ownerid);
		$tripownername = $tripownerresultrow['name'];
		$tripowneremail = $tripownerresultrow['email'];

		//Get the City name
		$cityresultrow = getCityInfo($filteredtripsrow['cityID']);
		$cityname = $cityresultrow['name'];

		//print out everything
		echo "<div id = $tripid>";
		echo "<b>Start Date: </b>$tripstart <br>";
		echo "<b>End Date: </b>$tripend <br>";
		echo "<b>Destination: </b>$cityname <br>";
		if (!strcmp($tripnotes, "")==0){
			echo "<b>Description/Notes: </b> $tripnotes <br>";
		}
		echo "<b>Contact Name: </b>$tripownername <br>";
		echo "<b>Email: </b>$tripowneremail<br>";
		//if the user if the owner of the trip
		if($ownerid==$buddyid){
			echo "<button onclick='deletetrip($tripid)'>delete this trip</button><br>";
		} else if (aBuddy($tripid,$buddyid)>0){ //if the user has already been added to the trip
			echo "<button onclick='deletebuddy($tripid,$buddyid)'>delete myself</button><br>";
		} else { //if the user has never been added to the trip
			echo "<button onclick='insertBuddy($tripid,$ownerid,$buddyid)'>add me</button>";
		}
		echo "</div><br>";

	}
	echo '</td></tr></table>';
}

//include the ajax functions for button onclick
include("ajaxfunctions.html");

?>
