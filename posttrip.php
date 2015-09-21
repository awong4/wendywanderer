<!-- posttrip.php
Post potential trips -->

<!doctype html>
<html lang='en'>
<head>
<title> Wendy Wanderer </title>
</head>
	<link href='http://fonts.googleapis.com/css?family=Pacifico|Oxygen:400,300' rel='stylesheet' type='text/css'>
	<link href="css/bootstrap.min.css" rel="stylesheet">

<body>
	<link rel="stylesheet" href="css/post.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
<?php
	include("navbar.php");
?>
<table border=0 cols="2" width="100%">
<tr><td valign="top" width="30%" id='postdiv'>
<h1>Post a Trip</h1>
<p> This page is used to add a potential trip you would like to go on <br>
<br> Please choose a city and add a start/end date and a note
<br> It's okay if you don't know the time period for sure now, it's entirely optional and we will let people know it's flexible 

<form method='POST' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
	<!-- we want users to be able to enter
		 a start date and a finish date -->
	Start date: <input type="date" name='startdate' id='textinput'> <br>
        End date: <input type="date" name='enddate' id='textinput'> <br>
        <!-- ask the user to select a city from the list -->
        City: <select name='city' id='tableselect'>
        	<option value='novalue'> Please select a city
	        <?php
	        	getAllCities();
	        ?>
    	</select>
    	<br>
	<br>
	<!-- text box to write the description for the trip -->
	Add an optional note to describe what you want for the trip! <br>
	<textarea rows = '5' cols = '50' type="text" name='description' id='textinput'></textarea> <br>
        <input type="submit" value="submit" id='submitbutton'>
</form>
</td></tr></table>

<?php
//call the function to insert the trip into the database
insertTrip();
?>

<p>
</body>
</html>
