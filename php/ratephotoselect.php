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


$query = mysql_query("SELECT DISTINCT P.photoID, P.url FROM Photo P, Visible V WHERE (P.photoID = V.photoID AND V.viewerID = \"".$userID."\") OR P.Visibility='public'");

//echo "<tr>";
while($row = mysql_fetch_array($query)){
	echo "<div class='thumbnail'><img src='".$row['url']."' height=50 onclick=\"selectPhoto(this)\" id = \"".$row['photoID']."\"/></div>";
}
//echo "</tr>";
//echo "<tr>";

mysql_close($link);
?>

