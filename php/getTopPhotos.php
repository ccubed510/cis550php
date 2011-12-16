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

$query = mysql_query("SELECT DISTINCT P.photoID, P.url FROM Photo P, Visible V WHERE (P.photoID = V.photoID AND V.viewerID = \"" . $userID . "\") OR P.Visibility='public'");
$searchArray[] = Array();

while ($row = mysql_fetch_array($query)) {
	$photoID = $row['photoID'];
	$searchArray[$photoID] = getRating($photoID, $userID);
}

echo "<table><tr>";
arsort($searchArray);
$count = 0;
if (sizeof($searchArray > 0)) {
	foreach ($searchArray as $photo => $score) {
		if ($count < 6) {
			if ($photo != NULL) {
				$uquery = mysql_query("SELECT url FROM Photo WHERE Photo.photoID =\"" . $photo . "\"");
				$uArray = mysql_fetch_array($uquery);
				$url = $uArray['url'];
				echo "<td><div  style='width:125px;overflow:hidden;'><img src='" . $url . "' height=100 id = \"" . $photo . "\"/></div></td>";
			}
		} else {
			break;
		}
		$count++;
	}
}
echo "</tr></table>";

function getRating(&$photoID, &$userID) {
	//get the total number of ratings on the photo.

	$countquery = mysql_query("SELECT COUNT(*) AS Count FROM Rating R WHERE R.photoID = \"" . $photoID . "\"");
	$countarray = mysql_fetch_array($countquery);
	$ncount = $countarray['Count'];

	//get the total sum of ratings on the photo.

	$countquery = mysql_query("SELECT SUM(rating) AS Sum FROM Rating R WHERE R.photoID = \"" . $photoID . "\"");
	$countarray = mysql_fetch_array($countquery);
	$nsum = $countarray['Sum'];

	//get the total number of ratings by friends of the user.

	$friendquery = mysql_query("SELECT COUNT(*) AS Count FROM ( SELECT DISTINCT Fphoto.userID FROM Circle C, Friend F, (SELECT * FROM Rating R WHERE R.photoID = \"" . $photoID . "\") Fphoto WHERE F.circleID = C.circleID AND F.friendID = Fphoto.userID AND C.userID =  \"" . $userID . "\") Grouping");
	$friendarray = mysql_fetch_array($friendquery);
	$fcount = $friendarray['Count'];

	//get the total sum of ratings by friends of the user.

	$friendquery = mysql_query("SELECT SUM(rating) AS Sum FROM ( SELECT DISTINCT Fphoto.rating AS rating FROM Circle C, Friend F, (SELECT * FROM Rating R WHERE R.photoID = \"" . $photoID . "\") Fphoto WHERE F.circleID = C.circleID AND F.friendID = Fphoto.userID AND C.userID =  \"" . $userID . "\") Grouping");
	$friendarray = mysql_fetch_array($friendquery);
	$fsum = $friendarray['Sum'];
	if ($ncount != 0) {
		$number = log($ncount + 0.5 * $fcount);
		$sum = ($nsum + 0.5 * $fsum) / $ncount;
		$relevance = 0.2 * $number + 0.8 * $sum;
		$r = number_format($relevance, 2);
		return $r;

	} else {
		return 0;
	}
}

mysql_close($link);
?>