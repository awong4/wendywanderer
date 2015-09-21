<!-- navbar.php 
PHP file for navigation bar. If the user is logged in, it'll have a different
navigation bar than if the user is not.
-->
<?php
//includes functions here so that we don't have to use it on every page
include("functions.php");
//start the session
session_start();

$url = $_SERVER['PHP_SELF'];

echo '<nav class="navbar navbar-fixed-top">
  		<div class="container-fluid">';
echo '<div class="navbar-header">
  		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>';
echo '<a class="navbar-brand" rel="home" href="#"><div id="logo"> WendyWanderer</div></a>';
echo '</div>';

//If the user is logged in then show them a nav bar with all the pages
if(isset($_SESSION["userID"]) && !empty($_SESSION["userID"])){
	
	$person = getPersonInfo($_SESSION['userID']);
	$name = $person['name'];
	$email = $person['email'];
	$id = $person['id'];

	echo '<ul class="nav navbar-nav navbar-right">';
	echo "<li><a href='posttrip.php'>Post Trip</a></li>";
	echo "<li><a href='searchtrip.php'>Find Trips</a></li>";
	echo "<li><a href='postreview.php'>Post Review</a></li>";
	echo "<li><a href='searchreview.php'>Find Reviews</a></li>";
	echo "<li><a href='postphoto.php'>Post Photos</a></li>";
	echo "<li><a href='ratebuddy.php'>Rate Buddies </a></li>";
	echo '<li class="dropdown">';
	echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">';
    	echo "Welcome $name";
    	echo '<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">';
   	echo "<li><a href='profile.php'>Profile</a></li>";
	echo "<li><a href ='logout.php'>logout</a></li>";
	echo '</ul></li>';
    	echo "</ul>";

	//However, if they are not active, then don't let them go on the
	//pages other than the profile, home and search review page	
	$active = active($id);
	if (!$active && $url!="/~wendywanderer/beta/profile.php" && $url !="/~wendywanderer/beta/home.php" && $url !="/~wendywanderer/beta/searchreview.php") {
		header("Location: profile.php");
	}

} else {
	//not logged in
	if(($url == "/~wendywanderer/beta/home.php")||($url == "/~wendywanderer/beta/login.php")||($url == "/~wendywanderer/beta/searchreview.php")) {
		echo '<ul class="nav navbar-nav navbar-right">';
		echo "<li><a href='home.php'> Signup </a></li>";
		echo "<li><a href='login.php'> Login </a></li>";
		echo "<li><a href='searchreview.php'>Search Reviews</a></li>";
		echo "</ul>";
	}
	//Sends the user back to signup page if they aren't logged in
	else header("Location: home.php");
}
echo "</div></nav>";
?>
