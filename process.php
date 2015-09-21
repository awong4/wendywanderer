<!-- process.php
Processes the ratings
->
<?php
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

$dbh = db_connect($wendy_dsn);

//If there is a ratee, rater, a rating which rating they're rating on and a trip id then proceed
if(isset($_GET['rateeID']) and isset($_GET['raterID']) and isset($_GET['whichrating']) and isset($_GET['ratingint']) and isset($_GET['tripID'])){
	$rateeID = $_GET['rateeID'];
	$raterID = $_GET['raterID'];
	$whichrating = $_GET['whichrating'];
	$ratingint = $_GET['ratingint'];
	$tripID = $_GET['tripID'];
	
	//Query to check if there exists a rating for that user already
	$checksql = "SELECT count(*) FROM rating where rateeID = ? and raterID = ? and tripID = ?";
        $data = array($rateeID, $raterID, $tripID);
        $checksqlresult = prepared_query($dbh, $checksql, $data);
	$checksqlresultrow = $checksqlresult->fetchRow(MDB2_FETCHMODE_ASSOC);
	$checksqlcount = $checksqlresultrow['count(*)'];
	echo $checksqlresultrow['count(*)'];

	//If so then just update the rating
        if($checksqlcount > 0){
                if ($whichrating == 0){
			$updatesql = "UPDATE rating
                	              SET reliablerating = ?
                        	      WHERE rateeID = ? and raterID = ? and tripID = ?";
               } else {
			$updatesql = "UPDATE rating
					SET organizedrating = ?
					WHERE rateeID=? and raterID = ? and tripID = ?";
		}
		 $updatedata = array($ratingint, $rateeID, $raterID, $tripID);
                $result = prepared_statement($dbh, $updatesql, $updatedata);

	//Otherwise, insert the rating
        } else if ($checksqlcount == 0){
		if ($whichrating == 0) {
                	$insertsql = "INSERT INTO rating (rateeID, raterID, reliablerating, tripID)
                        	        VALUES(?, ?, ?, ?)";
                } else {
			$insertsql = "INSERT INTO rating (rateeID, raterID, organizedrating, tripID) VALUES (?, ?, ?, ?)";
		}
		$insertdata = array($rateeID, $raterID, $ratingint, $tripID);
                $result = prepared_statement($dbh, $insertsql, $insertdata);
		
		
        }
}
?>
