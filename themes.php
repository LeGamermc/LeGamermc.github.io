<!DOCTYPE html>
<?php include 'global.php';?>
<head>
    <title>Themes - KrnlTUBE</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/global.css">
</head>
<body>
	<?php
	include("header.php");
	?>
    <h2>Themes</h2>
    Welcome to the <strong>themes page!</strong> <br>
    Here, you can try themes <br> <h1></h1> <hr>
    <strong>Original Themes</strong> <br>
    Dark Theme <button id="tdark" name="theme">Use</button> <br>
    Light Theme <button id="tlight" name="theme">Use</button> <br>
</body>
<script src="js/themes.js"></script>
</html>
<?php $mysqli->close();?>
