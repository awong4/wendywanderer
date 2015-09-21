<!-- 
home.php

Home page where people can sign up 
We plan to make the initial page that
people start on or go to as a place
where they can sign up also -->

<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Pacifico|Oxygen:400,300' rel='stylesheet' type='text/css'>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="jquery-1.11.2.min.js"></script>

	<title> Wendy Wanderer </title>
	<?php
		include("signup.php");
	?>
</head>
<body>
	<link rel="stylesheet" href="css/homestyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

<!-- Div to create a circle on top of the background
It will contain a login div and a div about our project
The two will alternate in showing depending on if the user
clicks the link or not  -->
<div class="circle">
	<div class="login">
	<br>
	<h2> Wendy Wanderer </h2>
	<p id="note"> Note: Your password is not your your regular wellesley domain password<br>
	It is highly unadvised to use your regular wellesley domain password for this site </p>
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<div id="box">
		<label>Name </label>
		<input type="text" name="name" required>
		<br>
		<label>Wellesley Domain Name </label>
		<input type="text" name="email" placeholder="Don't include @wellesley.edu" required>
		<br>
		<label>Password </label>
		<input type="password" name="password" required>
		<br>
		<label> Retype password </label>
		<input type="password" name="passwordcheck" required>
		<br>
		<input type="submit" name="submit">
		</div>
		</form>
	</div>

	<div class="about">
		<br>
		<br>
		<h2> Wendy Wanderer </h2>

		<p> Often times, we find ourselves wanting to travel to new and exciting countries 
		but we find ourseleves without company. Whether the company is for pleasure or security, 
		it's not always easy to find someone trusted. WendyWanderer is an application that 
		allows Wellesley students, alums and affiliates to find travel buddies within the 
		community. Our application facilitates the search of potential travel buddies and 
		provides a platform for the travelling Wellesley community to meet up!
		</p>
	</div>
	<br>
	<!-- Link to that user will click when switching between our login and about section -->
	<div id="switchlink"><a href="#" id="circlelink" class="link"> About WendyWanderer </a></div></div>
<script>

// To determine which link name should show up we just match
// the string to either "About WendyWanderer" or "Sign Up"
var txt = "About WendyWanderer";

// When the link is clicked then the two divs will toggle and
// and the text on the link will change
$(document).ready(function(){
    $('#circlelink').click(function(){
        $('.login').toggle();
	$('.about').toggle();
	if (txt == "About WendyWanderer"){	
	 	$('#circlelink').text('Sign Up');
		txt = "Sign Up";
	} else if (txt=="Sign Up"){
		$('#circlelink').text('About WendyWanderer');
		txt="About WendyWanderer";
	}   
 });
});


</script>
</body>
</html>
