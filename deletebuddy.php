<!-- deletebuddy.php
file used to delete self from trips -->

<?php
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

$dbh = db_connect($wendy_dsn);

//Check to see if one of them is filled out
if(isset($_GET['tid']) and isset($_GET['bid'])) {
	    $sql = "DELETE FROM buddy WHERE tripID = ? and buddyID = ?";
	    $tid=$_GET['tid'];
	    $bid=$_GET['bid'];
	    $values = array($tid,$bid);
	    $resultname = prepared_query($dbh,$sql,$values);
}

?>
