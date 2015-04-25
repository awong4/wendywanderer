<html>
<head>
<title> Wendy Wanderer </title>
</head>
<body>
<h1> Welcome to Wendy Wanderer - Login</h1>

<?php
	include("acclogin.php");

?>

<form action="" method="POST">
<div class="overall">
<label>Wellesley domain name </label>
<input type="text" name="email" required>

<br>

<label>Password </label>
<input type="password" name="password" required>

<br>

<input type="submit" name="submit" value="submit">
</div>
</form>



<a href="home.php"> Home </a><br>
<a href="login.php"> Login </a> <br>
<a href="posttrip.php">Post a Trip </a> <br>
<a href="searchtrip.php"> Browse Trips </a> <br>
<a href="postreview.php">Post a Review </a> <br>
<a href="searchreview.php">Browse reviews </a> <br>

</body>

</html>
