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
	$temp = mysql_query("SELECT userID FROM User WHERE userName = '" . $user . "'");
	$row = mysql_fetch_array($temp);
	$userID = $row['userID'];
	
	$query = "SELECT DISTINCT P.userID AS friendID, P.action AS action, P.objectID AS objectID, P.time AS time FROM Post P, Visible V, Photo PH, (SELECT DISTINCT F.friendID AS friend FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '".$userID."') myFriends WHERE P.userID = myFriends.friend AND ((P.objectID = V.photoID AND V.viewerID = '".$userID."') OR (P.objectID = PH.photoID AND PH.Visibility = 'public')) ORDER BY P.time DESC LIMIT 5";
	$posts = mysql_query($query);
	
	
	echo "<table>";
	while ($row = mysql_fetch_array($posts)) {
		$query = "SELECT first_name, last_name FROM User WHERE userID = '".$row['friendID']."'";
		$temp = mysql_query($query);
		$name = mysql_fetch_array($temp);
		echo "<tr><td>".$name['first_name']." ".$name['last_name']." ".$row['action'] . " photo ".$row['objectID']." (".$row['time'].")</td>";
		$photo = mysql_query("SELECT url FROM Photo WHERE photoID = '".$row['objectID']."'");
		$url = mysql_fetch_array($photo);
		echo "<td><img src='".$url['url']."' height=50 /></td></tr>";
	}
	echo "</table>";
	
	
	mysql_close($link);
?>