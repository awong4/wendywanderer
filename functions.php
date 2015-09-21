<!--
functions.php - File to put all the functions
so that we can  use them in multiple files
-->

<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

$dbh = db_connect($wendy_dsn);

//Function to get the city's info
//Input: city id & Output: the row (there should only 
//be one, ids are unique)
function getCityInfo($cityid){
	global $dbh;
	$cityinfosql = "SELECT name FROM city where id = ?";
	$cityinfodata = array($cityid);
	$cityinforesult = prepared_query($dbh, $cityinfosql, $cityinfodata);
	return $cityinforesult->fetchRow(MDB2_FETCHMODE_ASSOC);
}

//Function to get the person's info
//Input: userid & Output: the row (there should only be
//one, ids are unique)
function getPersonInfo($personid){
	global $dbh;
	$personsql = "SELECT * from user where id=?";
	$persondata = array($personid);
	$personresult = prepared_query($dbh, $personsql, $persondata);
	return $personresult -> fetchRow(MDB2_FETCHMODE_ASSOC);	
}

//Function to display posting informations
//Sets the each variable to be % if there is nothing
//filled out in the form
//Input: start date, end date and cityid & Output: resultset
function getPostingInfo($startdate, $enddate, $cityid){
	global $dbh;
	if (strcmp($cityid, "novalue") == 0){
		$cityid = "%";
	}

	//If startdate is not provided 
	if(strcmp($startdate, "") == 0) { 
		$startdate = '%';
	}

	//If enddate is not provided
	if (strcmp($enddate, "")==0){ 
		$enddate ='%';
	}
	$tripinfosql = "SELECT * FROM trip 
		WHERE cityID like ?
		AND startDate like ?
		AND endDate like ? ";

	$tripinfodata = array($cityid, $startdate, $enddate);
	return prepared_query($dbh, $tripinfosql, $tripinfodata);
}

//Function to get all the posts in a range of dates
function getPostingInfoRange ($startdate, $enddate, $cityid){
	global $dbh;

        if (strcmp($cityid, "novalue") == 0){
                $cityid = "%";
        }


	if ((strcmp($startdate, "") == 0) xor (strcmp($enddate, "")==0)){
		if(strcmp($startdate, "") == 0) { //If a start date is not provided and an end is
			//Will only show postings the end date between today and anytime in future
			$startdate = date('Y-m-d');
			$tripinfosql = "SELECT * FROM trip
				WHERE cityID like ?
				AND enddate BETWEEN ? and ?";
			$tripinfodata = array($cityid, $startdate, $enddate);
			
		}else { //If an enddate is not provided but a startdate is
			$enddate = '2100-01-01';
			echo "here";
			$tripinfosql = "SELECT * FROM trip
				WHERE cityID like ?
				AND startdate BETWEEN ? and ?";
			$tripinfodata = array($cityid, $startdate, $enddate);

		}
	} else {//if (!(strcmp($startdate, "") == 0) and !(strcmp($enddate, "")==0)){ //both start and end date are filled out

		$tripinfosql = "SELECT * FROM trip
			WHERE cityID like ?
			AND startDate BETWEEN ? AND ?
			AND endDate BETWEEN ? AND ? ";

		$tripinfodata = array($cityid, $startdate, $enddate, $startdate, $enddate);


	}
	return prepared_query($dbh, $tripinfosql, $tripinfodata);

}

//Function to get the reviews from the db
//Sets variables to % if nothing was submitted for that field
//Input: keyword and cityid & Output: result set 
function getReviews($reviewkeyword, $cityid){
	global $dbh;
	if(strcmp($cityid, "novalue") == 0) {
		$cityid = '%';
	}

	if(strcmp($reviewkeyword, "") == 0) {
		$reviewkeyword = '%';
	}
	$reviewinfosql = "SELECT * from review where cityID like ? and review like concat('%',?,'%')";
	$reviewinfodata = array($cityid, $reviewkeyword);	
	return prepared_query($dbh, $reviewinfosql, $reviewinfodata);
}

//Function to check the email and get the resultset
//Input: email & Output: result set
function getEmailInfo($email){
	global $dbh;
	$checkusersql = "SELECT email, password FROM user WHERE email = ?";
	$logindata = array($email);
	$checkresult = prepared_query($dbh, $checkusersql, $logindata);
	return $checkresult->fetchRow(MDB2_FETCHMODE_ASSOC);
}

//Function to get all the cities and put them as options in a select
//menu. Queries the db for all the cities and echoes the options
//Input: None & Output: None
function getAllCities(){
	global $dbh;
	$allcitysql = "SELECT id, name FROM city";
	$city = query($dbh, $allcitysql);
	while($cityrow = $city->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$cityid = $cityrow['id'];
		$cityname = $cityrow['name'];
		echo "<option value='$cityid'> $cityname \n";
	}
}

//Function to check if the email provided is in the db already
//Prepares a query and then execute it.
//Input: email & Output: an integer representing how many have the same email
//in the db
function checkEmailDB($email){
	global $dbh;
	$checkemailsql = "SELECT count(*) FROM user where email=?";
	$checkemaildata = array($email);
	$resultcheckemail = prepared_query($dbh, $checkemailsql, $checkemaildata);

	$resultrow = $resultcheckemail ->fetchRow(MDB2_FETCHMODE_ASSOC);
	return $resultrow['count(*)'];
}

//Function to insert the user, their password hash and their email into db
//Prepares a statement and executes it. Echos a message when done.
//Input: name, pw hash and email & Output: none 

function insertUser($name, $password, $email, $confirmation){
	global $dbh;
	$insertsql = "INSERT INTO user (name, password, email, confirmation) values (?, ?, ?, ?)";
	$data = array($name, $password, $email, $confirmation);
	prepared_statement($dbh, $insertsql, $data); 
	echo "Signup successful for ".$email;	
}

// Function to get the user id from the email
// deals with cookies so needs to be in this file
function getuserID($searchedName){
	global $dbh;
	$getid = "SELECT id FROM user WHERE email like ?";
	$input = $searchedName."%"; /*allow for @wellesley.edu*/
	$values = array($input);
	$ownerresult = prepared_query($dbh,$getid,$values);
	return $ownerresult->fetchRow(MDB2_FETCHMODE_ASSOC);
}

//get all the trips an user has initiated
function getOwnedTrips($userid){
	global $dbh;
	$sql = "SELECT * FROM trip where ownerID = ?";
	$data = array($userid);
	return prepared_query($dbh, $sql, $data);
}

//get all the trips an user has been on as a buddy
function getBuddyTrips($userid){
	global $dbh;
	$sql = "SELECT * FROM buddy where buddyID = ?";
	$data = array($userid);
	return prepared_query($dbh, $sql, $data);
}

//count the number of trips that the buddy is in
//it's used in relevant trip for the delete self button
//if the result is more than 1, we know the user had added herself to the trip and so will provide the 
//delete self option
function aBuddy($trip,$id){
	$result = 0;
	$buddytrips = getBuddyTrips($id);
	while($row = $buddytrips->fetchRow(MDB2_FETCHMODE_ASSOC)){
		if($row['tripID']==$trip){
			$result = $result + 1;
		}
	}
	return $result;
}

//Function to get all the buddies on a trip
function getAllPeople($tripid){
	global $dbh;
	$sql = "SELECT * FROM buddy where tripID = ?";
	$data = array($tripid);
	return prepared_query($dbh, $sql, $data);
}

//Function to get a trip information
function getTrips($tripid){
	global $dbh;
	$sql = "SELECT * FROM trip where id = ?";
	$data = array($tripid);
	return prepared_query($dbh, $sql, $data);
}

function displayProfileTrips($trips, $id){
	include("ajaxfunctions.html");
	while($row = $trips->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$ownerid = $row['ownerID'];
		$tripid = $row['id'];
		$tripstart = $row['startDate'];
		$tripend = $row['endDate'];
		$tripnotes = $row['description'];
		$cityresultrow = getCityInfo($row['cityID']);
		$cityname = $cityresultrow['name'];

		echo "<div id = $tripid>";
		echo "<b>Start Date: </b>$tripstart <br>";
		echo "<b>End Date: </b>$tripend <br>";
		echo "<b>Destination: </b>$cityname <br>";
		if (!strcmp($tripnotes, "")==0){
			echo "<b>Description/Notes: </b> $tripnotes <br>";
		}
		echo "</div>";
		if($id == 0){
			echo "<button onclick='deletetrip($tripid)'>delete this trip</button><br>";
		} else {
			echo "<button onclick='deletebuddy($tripid,$id)'>delete myself</button><br>";
		}

		echo "People on this trip: <br>";
		$pplontrip = getAllPeople($tripid);
		$owner = getPersonInfo($ownerid);
		$ownername = $owner['name'];
		echo "Owner: $ownername<br>";
		while($pplrow = $pplontrip->fetchRow(MDB2_FETCHMODE_ASSOC)){
			$personinfo = getPersonInfo($pplrow['buddyID']);
			$buddyname = $personinfo['name'];
			echo "$buddyname<br>";
		}
		echo "<br>";
	}
}

//Function to get all from buddies for the trips that the user is on
function getAllOwnedTripsForRating($userid){
	global $dbh;
	$sql = "SELECT * FROM buddy where userID = ?";
	$data = array($userid);
	return prepared_query($dbh, $sql, $data);
}

//Function to get all photos
function getAllPhotos($userid){
	global $dbh;
	$sql = "SELECT * FROM images where addedBy= ?";
	$data = array($userid);
	return prepared_query($dbh, $sql, $data);
}

//Function to calculate reliabilitiy rating
function calcReliable($personid){
	global $dbh;
	$sql = "SELECT reliablerating FROM rating where rateeID=?";
	$data = array($personid);
	$allratings = prepared_query($dbh, $sql, $data);
	$total = 0;
	$count = 0;
	while($allratingsrow = $allratings->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$total = $total + $allratingsrow['reliablerating'];
		$count = $count + 1;
	}
	if ($count == 0){
		$avg = 0;
	} else {
		$avg = $total/$count;
	}

	return $avg;
}

//Function to calculate organized rating
function calcOrganized($personid){
	global $dbh;
	$sql = "SELECT organizedrating FROM rating where rateeID=?";
	$data = array($personid);
	$allratings = prepared_query($dbh, $sql, $data);
	$total = 0;
	$count = 0;
	while($allratingsrow = $allratings->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$total = $total + $allratingsrow['organizedrating'];
		$count = $count + 1;
	}
	if ($count == 0){
		$avg = 0;
	} else { 
		$avg = $total/$count;
	}
	return $avg;
}

//Function to change a user to be confirmed
function confirmation($personid, $confirmationcode){
	global $dbh;
	$sql = "SELECT confirmation from user where id = ?";
	$data = array ($personid);
	$user = prepared_query($dbh, $sql, $data);
	$userrow = $user->fetchRow(MDB2_FETCHMODE_ASSOC);
	if ($confirmationcode == $userrow['confirmation']){
		$updatesql = "UPDATE user
			SET active = true
			WHERE id = ?";
		prepared_statement($dbh, $updatesql, $personid);
		echo "Confirmed!";
	} else {
		echo "Oops you have the wrong confirmation code. Try again";
	}
}

//Function to check that the user is active
function active ($personid){
	global $dbh;
	$sql = "SELECT count(*) from user where id =? and active=1";
	$user = prepared_query($dbh, $sql, $personid);
	$usercount = $user->fetchRow(MDB2_FETCHMODE_ASSOC);
	if ($usercount['count(*)'] == 0){
		return false;
	} else {
		return true;
	}

}

// this function inserts the trip the user entered in "post trip" to the trip table of the database
function insertTrip(){
	// the only thing that must be entered is the city so check for that
	if(isset($_POST['city']) and $_POST['city'] == 'novalue') {
		echo "<p> Please select a city";
	} else if(isset($_POST['startdate']) and isset($_POST['enddate'])) {
		global $dbh;
		// insert into the database
	    $sql = "INSERT INTO trip(ownerID,startDate,endDate,cityID,description) values (?,?,?,?,?)";
	    $uid = $_SESSION['userID'];
	 	$start = $_POST['startdate'];
	 	$end = $_POST['enddate'];
	    $city = $_POST['city'];
	    $description = htmlspecialchars($_POST['description'], ENT_COMPAT);
	    $values = array($uid,$start,$end,$city,$description);
	    $resultname = prepared_query($dbh,$sql,$values);
    	echo "Successfully posted trip!";
	} 
}

// this function inserts a review into the review table of the database
function insertReview(){
	if(isset($_POST['city']) and $_POST['city'] == 'novalue') {
		//the user must select a city to review for
		echo "<p> Please select a city";
	} else if (isset($_POST['review'])) {
		// get the database handle
		global $dbh;
		//we want to see who the person doing the reviewing is
		$person = getPersonInfo($_SESSION['userID']);
		$checksql = "SELECT count(*) from review where contactID = ? and cityID =?";
		$checksqldata = array($person['id'], $_POST['city']);
		$checksqlresult = prepared_query($dbh, $checksql, $checksqldata);
		$checksqlrow = $checksqlresult->fetchRow(MDB2_FETCHMODE_ASSOC);
		//we want to make sure the user is doing any double reviewing for any particular city
		//check to see if count is 0
		if ($checksqlrow['count(*)'] == 0) {	
	    		$sql = "INSERT INTO review(cityID,contactID,review) values (?,?,?)";
	    		$review = htmlspecialchars($_POST['review']);
	    		$city = $_POST['city'];
	    		$contact = $_SESSION['userID'];
	    		$values = array($city,$contact,$review);
	    		$resultreview = prepared_query($dbh,$sql,$values);
	    		echo "Review posted!";
   	 	} else {
			echo "You already submitted a review of this city!";
    	}
	}
}
?>
