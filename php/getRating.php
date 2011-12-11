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
$photoID = $_GET["photoID"];

$avgquery = mysql_query("SELECT AVG(R.rating) AS Average FROM Rating R WHERE R.photoID = \"" . $photoID . "\"");
$avg = mysql_fetch_array($avgquery);

echo "Average score for photo ".$photoID." is : " . $avg['Average'];

mysql_close($link);
?>