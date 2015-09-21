<!-- relevantreview.php -->
<!-- this is the php file for searchreview.php -->
<!-- it is used to get all the reviews that match the criteria for reviews entered -->

<?php
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

$dbh = db_connect($wendy_dsn);

//check for user input
if(isset($_GET['keyword']) or isset($_GET['cityid'])){
	//make sure the user didn't enter anything that harms the database
	$reviewkeyword = htmlspecialchars($_GET['keyword'], ENT_QUOTES);
	$city = $_GET['cityid'];
	//use getReviews in functions.php to get all of the reviews for the city
	$filteredreviews = getReviews($reviewkeyword, $city);

	echo '<td valign="top" width="70%" id="resultsdiv">';
	
	//since getReviews return everything that matches
	//we need to filter through row by row and print that way
	while ($filteredreviewsrow = $filteredreviews->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$cityresultrow = getCityInfo($filteredreviewsrow['cityID']);
		$cityname = $cityresultrow['name'];
		$reviewerresult = getPersonInfo($filteredreviewsrow['contactID']);
		$reviewername = $reviewerresult['name'];
		$reviewtext = $filteredreviewsrow['review'];
		//print the information for each review
		echo "<div id='reviews'>";
		echo "<b>Review of $cityname by ".htmlspecialchars($reviewername, ENT_COMPAT, 'UTF-8')."</b> <br>";
		echo "<p> ".htmlspecialchars($reviewtext, ENT_COMPAT, 'UTF-8')."</p>";
		echo "</div> <br>";
	}
	echo '</td></tr></table>';
}
?>
