<!-- user's home page, is only viewable by user -->
<!-- need to make this private -->
<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Pacifico|Oxygen:400,300' rel='stylesheet' type='text/css'>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<title> Wendy Wanderer </title>
</head>
<body>
	<link rel="stylesheet" href="css/profile.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
<?php
include("navbar.php");
$id = $_SESSION['userID'];
$person = getPersonInfo($id);
$name = $person['name'];
$email = $person['email'];
$reliablerating = calcReliable($id);
$organizedrating = calcOrganized($id);
?>

<h1> Profile </h1>
</body>
<?php

//Check if confirmation code is correct
if(isset($_POST['confirmation'])){
	$potentialconfirm = $_POST['confirmation'];
	confirmation($id, $potentialconfirm);
}

//Check if the user is active
//If they are not active then confirmation box
//should appear.
$active = active($id);
if (!$active) {
        $address = $_SERVER['PHP_SELF'];
	echo "<br>";
	echo "You may not see trips, add trips, add reviews or post photos until your account is confirmed";	
	echo "<form action='$address' method='POST'>";
        echo "Confirmation: <input type='text' name='confirmation'>";
        echo "<input type='submit' value='submit'>";
	echo "<br><br>";
}

?>

<div id= "personinfo">
        <!--We use htmlspecialchars again because we use the 'UTF-8' argument
        which will prevent the actual characters from printing out -->
	Name: <?php echo htmlspecialchars($name, ENT_COMPAT, 'UTF-8') ?><br>
	Organized rating: <?php echo "$organizedrating" ?><br>
	Reliable rating: <?php echo "$reliablerating" ?>
</div>
<br>

<!-- print the trips you own -->
<h4>Trips you initialized:</h4>
<div id="ownedtrips">
<?php
$owntrips = getOwnedTrips($id);
displayProfileTrips($owntrips,0);
?>
</div>


<!-- print all the trips you're a buddy on -->
<h4>Trips you are a buddy on:</h4>
<div id="buddytrips">
<?php
$buddytrips = getBuddyTrips($id);
while($row = $buddytrips->fetchRow(MDB2_FETCHMODE_ASSOC)){
	$trips = getTrips($row['tripID']);
	displayProfileTrips($trips,$id);
}
?>
</div>

<!-- print all the photos -->
<h4> My Photos </h4>
<div id="myphotos">
<?php
	$allimages = getAllPhotos($id);
	while ($allimagesrow = $allimages -> fetchRow(MDB2_FETCHMODE_ASSOC)){
		//We use htmlspecialchars again because we use the 'UTF-8' argument
		//which will prevent the actual characters from printing out	
		echo "<b>title: </b>".htmlspecialchars($allimagesrow['title'], ENT_QUOTES, 'UTF-8')."<br>";
		if (isset($allimagesrow['caption']) || !is_null($allimagesrow['caption'])){
			echo "<b>caption: </b>".htmlspecialchars($allimagesrow['caption'], ENT_QUOTES, 'UTF-8')."<br>";
		}
		$image = $allimagesrow['picfile'];
		echo "<img src='$image'><br><br>";
	}
?>

</div>
</html>
