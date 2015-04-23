<html>
<head>
<title> Wendy Wanderer </title>
</head>
<body>
<h1> Welcome to Wendy Wanderer - Sign Up</h1>

<?php
	include("signup.php");

?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<div class="overall">

<label>Name </label>
<input type="text" name="name" required>

<br>

<label>Email </label>
<input type="email" name="email" required>

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

<a href="home.html"> Home </a><br>
<a href="signup.html"> Signup </a> <br>
<a href="login.html"> Login </a> <br>
<a href="findatrip.html"> Find a Trip </a> <br>
<a href="recommendations.html"> Recommendations </a>


</body>

</html>
