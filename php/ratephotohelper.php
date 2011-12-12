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

$rating = $_GET['rating'];
$photoID = $_GET['photoID'];

$permission = mysql_query("SELECT * FROM Visible V, Photo P WHERE P.photoID = \"" . $photoID . "\" AND (P.photoID = V.photoID AND V.viewerID = \"" . $userID . "\") OR P.Visibility='public'");
$rated = mysql_query("SELECT * FROM Rating WHERE Rating.photoID = \"" . $photoID . "\" AND Rating.userID = \"" . $userID . "\"");
if (mysql_fetch_row($permission) != NULL) {
	if (mysql_fetch_row($rated) != NULL) {
		echo "You have already rated this.";
	} else {
		$avgquery = mysql_query("SELECT AVG(R.rating) AS Average FROM Rating R WHERE R.photoID = \"" . $photoID . "\" GROUP BY photoID");
		$avg = mysql_fetch_row($avgquery);
		$a = $avg['Average'];
		mysql_query("INSERT INTO Rating (photoID, rating, userID) VALUES (" . $photoID . ", " . $rating . ", " . $userID . ")");
		echo "You rated this photo as a " . $rating . ".";
		echo "Average score: " . $a;
	}
} else {
	echo "You cannot rate this photo.";
}
?>

