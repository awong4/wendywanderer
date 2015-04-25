<!--
Functions.php - File to put all the functions
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
	$cityinforow = $cityinforesult->fetchRow(MDB2_FETCHMODE_ASSOC);
	return $cityinforow;
}

//Function to get the person's info
//Input: userid & Output: the row (there should only be
//one, ids are unique)
function getPersonInfo($personid){
	global $dbh;
	$personsql = "SELECT name, email from user where id=?";
	$persondata = array($personid);
	$personresult = prepared_query($dbh, $personsql, $persondata);
	$personresultrow = $personresult -> fetchRow(MDB2_FETCHMODE_ASSOC);	

	return $personresultrow;
}

//Function to display posting informations
//Sets the city to % if none provided and the start/end date
//to the current date if it is not provided by the user
//Input: start date, end date and cityid & Output: resultset
function getPostingInfo($startdate, $enddate, $cityid){
	global $dbh;
	if (strcmp($cityid, "novalue") == 0){
		$cityid = "%";
	}
	
	//If only one of them was filled out
	if ((strcmp($startdate, "") == 0) xor (strcmp($enddate, "")==0)){
		if(strcmp($startdate, "") == 0) { //If a start date is not provided and an end is
			//Will only show postings the end date between today and anytime in future 
			$startdate = date('Y-m-d');
			$tripinfosql = "SELECT * FROM trip
				WHERE cityID like ?
				AND enddate BETWEEN ? and ?";
			$tripinfodata = array($cityid, $startdate, $enddate);

		}else { //If an enddate is not provided but a startdate is
			$enddate = date('Y-m-d');
			$tripinfosql = "SELECT * FROM trip
				WHERE cityID like ?
				AND startdate BETWEEN ? and ?";
			$tripinfodata = array($cityid, $startdate, $enddate);

		}
	} else if (!(strcmp($startdate, "") == 0) and !(strcmp($enddate, "")==0)){ //both start and end date are filled out

		$tripinfosql = "SELECT * FROM trip 
			WHERE cityID like ?
			AND startDate BETWEEN ? AND ?
			AND endDate BETWEEN ? AND ? ";

		$tripinfodata = array($cityid, $startdate, $enddate, $startdate, $enddate);
	} else { //Otherwise, just show all the results based on the cityid provided, if any
		$tripinfosql = "SELECT * FROM trip WHERE cityID like ?";
		$tripinfodata = array($cityid);

	}
	$tripinforesult = prepared_query($dbh, $tripinfosql, $tripinfodata);
	return $tripinforesult;
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
	$reviewinforesult = prepared_query($dbh, $reviewinfosql, $reviewinfodata);
	return $reviewinforesult;
}

//Function to check the email and get the resultset
//Input: email & Output: result set
function getEmailInfo($email){
	global $dbh;
	$checkusersql = "SELECT email, password FROM user WHERE email = ?";
	$logindata = array($email);
	$checkresult = prepared_query($dbh, $checkusersql, $logindata);
	$checkrow = $checkresult->fetchRow(MDB2_FETCHMODE_ASSOC);
	return $checkrow;
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

function insertUser($name, $password, $email){
	global $dbh;
	$insertsql = "INSERT INTO user  (name, password, email) values (?, ?, ?)";
	$data = array($name, $password, $email);
	prepared_statement($dbh, $insertsql, $data); 
	echo "Signup successful for ".$email;	
}


?>
