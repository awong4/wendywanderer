<!-- this file closes the user session to allow the user to logout -->
<?php
session_start(); 
session_destroy(); 
header("location: home.php"); 
?>
