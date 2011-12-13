<?php
    $db_username = "yannie";
    $db_password = "abcd";
    $db_host = "fling.seas.upenn.edu";
    $db_name = "yannie";
	
	$link = mysql_connect($db_host, $db_username, $db_password);
    if (!$link) {
      die('Could not connect: ' . mysql_error());
    }
	
	mysql_select_db($db_name, $link);
	$user = $_COOKIE['username'];
	$newCircle = $_GET['newCircle'];
	
	//Get user's userID.
	$result = mysql_query("SELECT U.userID FROM User U WHERE U.userName='".$user."'");
	$row = mysql_fetch_array($result);
	$userID = $row['userID'];
	//Check if circle name already exists.
	$result = mysql_query("SELECT * FROM Circle WHERE userID='".$userID."' AND name='".$newCircle."'");
	if (mysql_num_rows($result) != 0) {
		die("ERROR: circle '".$newCircle."' already exists. Please choose a new circle name.");
	}
	//Create new circle.
	mysql_query("INSERT into Circle (userID, name) VALUES ('".$userID."', '".$newCircle."')");
	echo "New circle '".$newCircle."' has been successfully added.";
?>