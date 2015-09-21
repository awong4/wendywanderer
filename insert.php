<!-- insert.php
file used to add buddies to trips -->

<?php
require_once("MDB2.php");
require_once("/home/cs304/public_html/php/MDB2-functions.php");
require_once('wendy-dsn.inc');

$dbh = db_connect($wendy_dsn);

//Check to see if one of them is filled out
if(isset($_GET['tid']) and isset($_GET['uid']) and isset($_GET['bid'])) {

	    $sql = "INSERT INTO buddy(tripID,userID,buddyID) values (?,?,?)";
	    $tid=$_GET['tid'];
	    $uid=$_GET['uid'];
	    $bid=$_GET['bid'];
	    $values = array($tid,$uid,$bid);
	    $resultname = prepared_query($dbh,$sql,$values);
}

?>
