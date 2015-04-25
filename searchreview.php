<html>
<head>
<title> Wendy Wanderer </title>
</head>
<body>
<h1> Welcome to Wendy Wanderer - Find A Trip</h1>
<?php
	include_once("functions.php");
?>
<!-- Search function -->
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="GET">
<div> <p> <h3> Find a Trip </h3> </p>
<p> Enter a keyword you would like us to find! </p>
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

<!-- Get all the reviews -->

<?php
        include_once("reviewsearch.php");
?>
</body>
</html>
