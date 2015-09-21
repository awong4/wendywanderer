<!-- postphoto.php
Uploads photos by user -->

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
	include("imageupload.php");
?>
<table border=0 cols="2" width="100%">
<tr><td valign="top" width="30%" id='postdiv'>
<h1> Share a Photo From Your Trip </h1>
<form method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>">
<p> Your picture should be in the file extension JPEG. </p>
<p> The maximum size that your image can be is 100kb. </p>
<p> Title of picture: <input type="text" name="title" required>
<p> Caption: <input type="text" name="caption">
<p> Photo to upload: <input type="file" name="imagefile" size="50" accept="image/jpeg, image/jpg"required>

<p> <input type="submit">
</form>

<!-- Prints out all the photos that the user uploaded -->
<?php
if( $destfile ) {
    echo "Successfully uploaded. You may see your photos anytime in your profile page";
    $name = basename($name);
    print "<center><p><img src='$destfile'></center>\n";
}
?>

</td></tr></table>
</body>
</html>

