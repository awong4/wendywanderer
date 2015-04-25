<?php
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');


$dbh = db_connect($wendy_dsn);

include_once("functions.php");

if(isset($_GET['keyword']) or isset($_GET['cityid'])){
	$reviewkeyword = htmlspecialchars($_GET['keyword']);
	$city = $_GET['cityid'];
	
	$filteredreviews = getReviews($reviewkeyword, $city);

	while ($filteredreviewsrow = $filteredreviews->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$cityresultrow = getCityInfo($filteredreviewsrow['cityID']);
		$cityname = $cityresultrow['name'];

		$reviewerresult = getOwnerInfo($filteredreviewsrow['contactID']);
		$reviewername = $reviewerresult['name'];

		$reviewtext = $filteredreviewsrow['review'];
		
		echo "<div id='reviews'>";
		echo "<b>Review of $cityname by $reviewername</b> <br>";
		echo "<p> $reviewtext </p>";
		echo "</div>";
	}
}
?>
