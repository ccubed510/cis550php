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
$tags = $_GET['tags'];
$tagarray = explode(" ", $tags);
$friends = $_GET['friends'];
$friendarray = explode(" ", $friends);
$circles = $_GET['circles'];
$circlearray = explode(" ", $circles);

$query = "SELECT DISTINCT P.photoID AS photoID FROM Visible V, Photo P, User U, Friend F WHERE ((P.photoID = V.photoID AND V.viewerID = \"" . $userID . "\") OR P.Visibility='public')";
if (strlen($friends) > 0) {
	$friend1 = $friendarray[0];
	$query = $query . " AND (U.userID = P.userID AND (U.userName = '" . $friend1 . "'";

	foreach ($friendarray as $friend) {
		if ($friend != $friend1) {
			$query = $query . " OR U.userName = '" . $friend . "'";
		}
	}
	$query = $query . "))";
}
if (strlen($circles) > 0) {
	$circle1 = $circlearray[0];
	$query = $query . " AND (P.userID = F.friendID AND (F.circleID = '" . $circle1 . "'";

	foreach ($circlearray as $circle) {
		if ($circle != $circle1) {
			$query = $query . " OR F.circleID = '" . $circle . "'";
		}
	}
	$query = $query . "))";
}
$pquery = mysql_query($query);

$searchArray[] = Array();
//search by tag
if (strlen($tags) > 0) {
	while ($p = mysql_fetch_array($pquery)) {
		$pID = $p['photoID'];
		$tagHits = 0;
		foreach ($tagarray as $tag) {
			$a = strtolower($tag);
			$sc = getMatch($pID, $a);
			if ($sc > 0) {
				$tagHits += $sc;
			}
		}
		$searchArray[$pID] = $tagHits;
	}
	arsort($searchArray);
	if (sizeof($searchArray > 0)) {
		foreach ($searchArray as $photo => $score) {
			if ($photo != null) {
				$pquery = mysql_query("SELECT url FROM Photo WHERE photoID = \"" . $photo . "\"");
				$p = mysql_fetch_array($pquery);
				$url = $p['url'];
				if ($score > -4) {
					echo "<td><img src='" . $url . "' height='100' onclick='selectPhoto(this)' id = '" . $photo . "'/></td>";
				}
			}
		}
	} else {
		echo "Images not found. Please try again.";
	}
} else {
	//search by user/circle
	$pquery = mysql_query($query);
	while ($p = mysql_fetch_array($pquery)) {
		$pID = $p['photoID'];
		$pq = mysql_query("SELECT url FROM Photo WHERE photoID = \"" . $pID . "\"");
		$p = mysql_fetch_array($pq);
		$url = $p['url'];
		echo "<td><img src='" . $url . "' height='100' onclick='selectPhoto(this)' id = '" . $pID . "'/></td>";

	}

}

//Dynamic Programming Algorithm to get Ranking for Partial String Matching
function getMatch(&$photoID, &$tag) {
	$getTags = mysql_query("SELECT tag FROM PhotoTag WHERE photoID = \"" . $photoID . "\"");
	$tcquery = mysql_query("SELECT COUNT(tag) AS count FROM PhotoTag WHERE photoID = \"" . $photoID . "\"");
	$tc = mysql_fetch_array($tcquery);
	$tagCount = $tc['count'];
	$tagArray = Array();
	$count = 0;
	while ($a = mysql_fetch_array($getTags)) {
		$t = strtolower($a['tag']);
		if (strlen($t) > 0 && strlen($t) < 10) {
			$aTag = str_split($tag, 1);
			$pTag = str_split($t, 1);
			$p1 = strlen($tag) - 1;
			$p2 = strlen($t) - 1;
			$tagArray[$count] = opt($aTag, $pTag, $p1, $p2);
			$count++;
		}
	}
	if (sizeof($tagArray) > 0) {
		return max($tagArray);
	} else {
		return 0;
	}
}

//takes as a parameter two tags with positions p1 and p2
function opt($tag1, $tag2, $p1, $p2) {
	//	echo "sr" . $p1. "sr".$p2."</br>";

	$c1 = $tag1[$p1];
	$c2 = $tag2[$p2];
	$p3 = max($p1 - 1, 0);
	$p4 = max($p2 - 1, 0);
	if ($p1 == 0 && $p2 == 0) {
		return matchCost($c1, $c2);
	}
	if ($p1 == 0 && $p2 != 0) {
		$p2 = $p2 - 1;
	}
	if ($p1 != 0 && $p2 == 0) {
		$p1 = $p1 - 1;
	}
	$v1 = opt($tag1, $tag2, $p3, $p4) + matchCost($c1, $c2);
	$v2 = opt($tag1, $tag2, $p3, $p2) - 1;
	$v3 = opt($tag1, $tag2, $p1, $p4) - 1;
	$max = max($v1, $v2, $v3);
	return $max;
	//return 0;
}

function matchCost(&$char1, &$char2) {
	if (($char1 != NULL) && ($char2 != NULL)) {
		if (strcmp($char1, $char2) == 0) {
			return 1;
		}
	}
	return -1;
}

mysql_close($link);
?>