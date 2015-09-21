<!-- searchtrip.php
Searches through the trips based on criteria
or displays them all -->

<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Pacifico|Oxygen:400,300' rel='stylesheet' type='text/css'>
	<link href="css/bootstrap.min.css" rel="stylesheet">
<title> Wendy Wanderer </title>
</head>
<body>
	<link rel="stylesheet" href="css/search.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
<?php
	include("navbar.php");
?>
<table border=0 cols="2" width="100%">
<tr>
<td valign="top" width="30%" id='searchdiv'>
<h1> Find a Trip</h1>
<!-- Search function -->
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="GET">
<div> <p> If you don't have a particular time or city in mind, click submit to see all postings! </p>
<p> If you enter both an exact and a range then we will look for the a range instead of exact dates </p>
<p> Ranges will include flexible dates. You never know when someone may be up for when you want to go! </p>

<p><b>Exact Start Date </b>
to 
<b>Exact End Date</b> </p>


<input type="date" name="startdate">
to <input type="date" name="enddate">
<br> <br>
<b><u> OR </b></u>
<br><br>
<b> Trips that Start and End Between: </b>
<p> Start to End  </p>
<input type="date" name="rangestartdate">
to
<input type="date" name="rangeenddate"> 
<br><br>
<p><b>Select the city: </b></p>
<select name='cityid' id='tableselect'>
<option value='novalue'> Select a city
<?php getAllCities() ?>
</select>
<br><br>
<input type="submit" value="submit">
</div>
</form>
</td>


<!-- Get all the postings -->
<?php
	include("relevanttrip.php");
?>


</body>
</html>
