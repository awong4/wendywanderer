<!-- searchreview.php
Searches through the reviews based on criteria
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
<!-- styling -->
<table border=0 cols="2" width="100%">
<tr><td valign="top" width="30%" id='searchdiv'>
<h1> Find a Review</h1>
<!-- Search function -->
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="GET">
<div>
<p> If you don't have a particular review or city in mind, click submit to see all of them </p> 
<p> Enter a keyword or phrase you would like us to find: </p>
<input type="text" name="keyword">

<p>Select the city:</p>
<select name='cityid' id='tableselect'>
<option value='novalue'> Select a city
<?php getAllCities() ?>
</select>
<br>
<input type="submit" value="submit">
</div>
</form>
</td>


<!-- Get all the reviews -->

<?php
       include_once("relevantreviews.php");
?>
</body>
</html>
