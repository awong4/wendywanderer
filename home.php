<html>
<head>
<title> Wendy Wanderer </title>
<?php
	include("signup.php");
?>
</head>
<body>
<h1> Welcome to Wendy Wanderer - Sign Up</h1>

<p> Note: Your passowrd is not your your regular wellesley domain password</p>
<p> It is highly unadvised to use your regular wellesley domain password for this site </p>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<div class="overall">

<label>Name </label>
<input type="text" name="name" required>

<br>

<label>Wellesley Domain Name </label>
<input type="text" name="email" required>

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

<a href="home.php"> Home </a><br>
<a href="login.php"> Login </a> <br>
<a href="posttrip.php">Post a Trip </a> <br>
<a href="searchtrip.php"> Browse Trips </a> <br>
<a href="postreview.php">Post a Review </a> <br>
<a href="searchreview.php">Browse reviews </a> <br>


</body>

</html>
