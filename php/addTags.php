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
$user = $_COOKIE["username"];
$fetchID = mysql_query("SELECT User.userID FROM User WHERE User.userName =\"" . $user . "\"");
$fetchArray = mysql_fetch_array($fetchID);
$userID = $fetchArray['userID'];

$photoID = $_GET['photoID'];
$t = $_GET['tags'];
$tags = explode(",", $t);
foreach($tags as $tag){
	$checkq = mysql_query("SELECT tag FROM PhotoTag WHERE photoID='".$photoID."' AND tag='".$tag."'");
	$check = mysql_fetch_array($checkq);
	if($check != NULL){
		echo "The tag ".$tag." already exists. </br>";
	}
	else{
		mysql_query("INSERT INTO PhotoTag (photoID, tag, tagger) VALUES ('".$photoID."', '".$tag."', '".$userID."')");
		echo "The tag ".$tag." was successfully added. </br>";
	}
}
?>

