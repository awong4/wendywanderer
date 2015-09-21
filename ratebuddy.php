<!-- ratebuddy.php
Page to rate a buddy's reliability and organization -->
<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Pacifico|Oxygen:400,300' rel='stylesheet' type='text/css'>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<title> Wendy Wanderer </title>
</head>

<body>
	<link rel="stylesheet" href="css/post.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
<?php
	include("navbar.php");
?>

<table border=0 cols="2" width="100%">
<tr><td valign="top" width="30%" id='postdiv'>
<h1> Rate a Buddy </h1>

<?php
include_once("navbar.php");

$person = getPersonInfo($_SESSION['userID']);
$personID = $person['id'];
$allbuddies = getBuddyTrips($_SESSION['userID']);

//Get all the trips that the user is the buddy on 
//If there are any then for each buddy it prints out
//buttons that the user can use to rate the buddy
if (isset($allbuddies)){
	while ($buddyrow = $allbuddies ->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$tripownerID = $buddyrow['userID'];
		$tripowner = getPersonInfo($tripownerID);
		$tripownername = $tripowner['name'];
		$tripID = $buddyrow['tripID'];
		$tripcityinfo = getTrips($tripID);
		$tripcityresult = $tripcityinfo->fetchRow(MDB2_FETCHMODE_ASSOC);
		$tripcitynameresult = getCityInfo($tripcityresult['cityID']);
		$tripcityname = $tripcitynameresult['name'];
		echo"<b><br><br> $tripownername with you in $tripcityname </b><br>";
		echo "How reliable was $tripownername ?";
		echo "<br>";
		echo "<button onclick='rateUser($tripownerID, $personID, 0, 1, $tripID)'> 1 - Least </button>";
		echo "<button onclick='rateUser($tripownerID, $personID, 0, 2, $tripID)'> 2 </button>";
		echo "<button onclick='rateUser($tripownerID, $personID, 0, 3, $tripID)'> 3 </button>";
		echo "<button onclick='rateUser($tripownerID, $personID, 0, 4, $tripID)'> 4 </button>";
		echo "<button onclick='rateUser($tripownerID, $personID, 0, 5, $tripID)'> 5 - Most </button>";
		echo "<br> How organized was $tripownername ?";
		echo "<br>";
		echo "<button onclick='rateUser($tripownerID, $personID, -1, 1, $tripID)'> 1 - Least </button>";
		echo "<button onclick='rateUser($tripownerID, $personID, -1, 2, $tripID)'> 2 </button>";
		echo "<button onclick='rateUser($tripownerID, $personID, -1, 3, $tripID)'> 3 </button>";
		echo "<button onclick='rateUser($tripownerID, $personID, -1, 4, $tripID)'> 4 </button>";
		echo "<button onclick='rateUser($tripownerID, $personID, -1, 5, $tripID)'> 5 - Most </button>";

	}
}
//Gets all the trips that the user owns
//Allows you to rate buddies
$allownedtripbuddies = getAllOwnedTripsForRating($_SESSION['userID']);
if (isset($allownedtripbuddies)){ 
	while ($ownedbuddyrow = $allownedtripbuddies->fetchRow(MDB2_FETCHMODE_ASSOC)){
		$ownbuddyID = $ownedbuddyrow['buddyID'];
		$ownbuddyIDrow = getPersonInfo($ownbuddyID);
		$ownbuddyname = $ownbuddyIDrow['name'];
		$ownbuddytripID = $ownedbuddyrow['tripID'];
		echo "<br><b>$ownbuddyname with you in $ownbuddytripID </b><br>";
		echo "How reliable was $ownbuddyname ?";
		echo "<br>";
		echo "<button onclick='rateUser($ownbuddyID, $personID, 0, 1, $ownbuddytripID)'> 1 - Least </button> ";
		echo "<button onclick='rateUser($ownbuddyID, $personID, 0, 2, $ownbuddytripID)'> 2 </button> ";
		echo "<button onclick='rateUser($ownbuddyID, $personID, 0, 3, $ownbuddytripID)'> 3 </button> ";
		echo "<button onclick='rateUser($ownbuddyID, $personID, 0, 4, $ownbuddytripID)'> 4 </button> ";
		echo "<button onclick='rateUser($ownbuddyID, $personID, 0, 5, $ownbuddytripID)'> 5 - Most </button>";

		echo "<br>How organized was $ownbuddyname ?";
		echo "<br>";
		echo "<button onclick='rateUser($ownbuddyID, $personID, -1, 1, $ownbuddytripID)'> 1 - Least </button> ";
		echo "<button onclick='rateUser($ownbuddyID, $personID, -1, 2, $ownbuddytripID)'> 2 </button> ";
		echo "<button onclick='rateUser($ownbuddyID, $personID, -1, 3, $ownbuddytripID)'> 3 </button> ";
		echo "<button onclick='rateUser($ownbuddyID, $personID, -1, 4, $ownbuddytripID)'> 4 </button> ";
		echo "<button onclick='rateUser($ownbuddyID, $personID, -1, 5, $ownbuddytripID)'> 5 - Most </button>";

	}	
}

?>
</td></tr></table>
<br>
<script src="https://code.jquery.com/jquery.js"></script>
<script src="https://code.jquery.com/jquery.js"></script>
<script type="text/javascript">

//When the user clicks on the button, it uses ajax to update the rating dynamically
function rateUser(rateeID, raterID, whichrating, ratingint, tripID){
	$.ajax({
	url:'process.php',
	type:'get',
	data:{rateeID:rateeID, raterID:raterID, whichrating:whichrating, ratingint:ratingint, tripID:tripID},
	success: function(data){
		console.log(data);
  		alert("You have successfully rated");
 	 },
	error: function(){
		alert("failed");
	}
 
	});
	
}
</script>
</body>
</html>
