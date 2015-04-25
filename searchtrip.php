<html>
<head>
<title> Wendy Wanderer </title>
</head>
<body>
<h1> Welcome to Wendy Wanderer - Find A Trip</h1>
<?php
	include("functions.php");
	
?>
<!-- Search function -->
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="GET">
<div> <p> <h3> Find a Trip </h3> </p>
<p>Start Date: </p>
<input type="date" name="startdate">

<p>End Date: </p>
<input type="date" name="enddate">

<p>Select the city:</p>
<select name='cityid' id='tableselect'>
<option value='novalue'> Select a city
<?php getAllCities() ?>
</select>
<br>
<input type="submit" value="submit">
</div>
</form>

<!-- Get all the postings -->
<?php
	include("search.php");
?>


<a href="home.html"> Home </a><br>
<a href="signup.html"> Signup </a> <br>
<a href="login.html"> Login </a> <br>
<a href="findatrip.html"> Find a Trip </a> <br>
<a href="recommendations.html"> Recommendations </a>


</body>

</html>
