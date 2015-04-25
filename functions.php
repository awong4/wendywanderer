<?php

require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

$dbh = db_connect($wendy_dsn);

function getCityInfo($cityid){
	global $dbh;
	$cityinfosql = "SELECT name FROM city where id = ?";
	$cityinfodata = array($cityid);
	$cityinforesult = prepared_query($dbh, $cityinfosql, $cityinfodata);
	$cityinforow = $cityinforesult->fetchRow(MDB2_FETCHMODE_ASSOC);
	return $cityinforow;
}

function getOwnerInfo($tripowner){
	global $dbh;
	$ownersql = "SELECT name, email from user where id=?";
	$ownerdata = array($tripowner);
	$ownerresult = prepared_query($dbh, $ownersql, $ownerdata);
	$ownerresultrow = $ownerresult -> fetchRow(MDB2_FETCHMODE_ASSOC);	

	return $ownerresultrow;
}

//Function to display posting informations
function getPostingInfo($startdate, $enddate, $cityid){
	global $dbh;
	if (strcmp($cityid, "novalue") == 0){
		$cityid = "%";
	}

	if ((strcmp($startdate, "") == 0) xor (strcmp($enddate, "")==0)){
		if(strcmp($startdate, "") == 0) {
			//Will only show postings the end date between today and anytime in future 
			$startdate = date('Y-m-d');
			$tripinfosql = "SELECT * FROM trip
				WHERE cityID like ?
				AND enddate BETWEEN ? and ?";
			$tripinfodata = array($cityid, $startdate, $enddate);

		}else { //(strcmp($enddate, "") == 0)
			$enddate = date('Y-m-d');
			$tripinfosql = "SELECT * FROM trip
				WHERE cityID like ?
				AND startdate BETWEEN ? and ?";
			$tripinfodata = array($cityid, $startdate, $enddate);

		}
	} else if ((strcmp($startdate, "") == 0) xor (strcmp($enddate, "")==0)){ //both start and end date are filled out

		$tripinfosql = "SELECT * FROM trip 
			WHERE cityID like ?
			AND startDate BETWEEN ? AND ?
			AND endDate BETWEEN ? AND ? ";

		$tripinfodata = array($cityid, $startdate, $enddate, $startdate, $enddate);
	} else {
		$tripinfosql = "SELECT * FROM trip WHERE cityID like ?";
		$tripinfodata = array($cityid);

	}
	$tripinforesult = prepared_query($dbh, $tripinfosql, $tripinfodata);
	return $tripinforesult;
}

//
function getReviews($reviewkeyword, $city){
	global $dbh;
		if(strcmp($city, "novalue") == 0) {
			$city = '%';
		}

		if(strcmp($reviewkeyword, "") == 0) {
			$reviewkeyword = '%';
		}
		$reviewinfosql = "SELECT * from review where cityID like ? and review like concat('%',?,'%')";
		$reviewinfodata = array($city, $reviewkeyword);	
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
