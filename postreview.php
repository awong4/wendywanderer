<!-- postreview.php
Allows users to post trips -->

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

<h1> Post a Review</h1>
<p> This page is used to add a review to the city you went to </p>
<p> Please fill out all the form data fields </p>

<form method='POST' enctype="multipart/form-data" action='<?php echo $_SERVER['PHP_SELF']; ?>'>
	
	<!-- ask the user to select a city from the list -->
	City: <select name='city' id='tableselect'>
    	<option value='novalue'> Please select a city
    	<?php
        	getAllCities();
	    ?>
	</select>
	<br>
	<br>
	<!-- text box to write the review -->
	<textarea rows = '5' cols = '50' type="text" name='review' id='textinput'></textarea> <br>

        <input type="submit" value="submit" id='submitbutton'>
</form>

</td></tr></table>

<?php
insertReview();
?>

<p>
</body>
</html>
