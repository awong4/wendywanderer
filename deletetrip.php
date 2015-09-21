<!-- deletetrip.php
file used to delete trips -->

<?php
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

$dbh = db_connect($wendy_dsn);

//Check to see if tripID is filled out
if(isset($_GET['tid'])) {
	    $sql = "DELETE FROM trip WHERE id = ?";
	    $tid=$_GET['tid'];
	    $values = array($tid);
	    $resultname = prepared_query($dbh,$sql,$values);
}

?>
