<!-- login.php
A page where users can login to their accounts -->

<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Pacifico|Oxygen:400,300' rel='stylesheet' type='text/css'>
	<link href="css/bootstrap.min.css" rel="stylesheet">
<title> Wendy Wanderer </title>
<?php
	include("acclogin.php");
?>
</head>

<body>
	<link rel="stylesheet" href="css/homestyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


<div class="circle">
	<div class="login">
		<br><br><br><br><br>
	<h2> Wendy Wanderer</h2>
		<form action="" method="POST">
			<div id="box">
			<label>Wellesley domain name </label>
			<input type="text" name="email" required>
			<br>
			<label>Password </label>
			<input type="password" name="password" required>
			<br>
			<input type='submit' name='submit' value='submit'><br/>
			</div>
		</form>
	</div>
</div>
</body>

</html>
