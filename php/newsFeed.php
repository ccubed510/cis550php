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
	
	$query = "SELECT P.userID AS friendID, P.action AS action, P.objectID AS objectID, P.time AS time FROM Post P, (SELECT DISTINCT F.friendID AS friend FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '".$userID."') myFriends WHERE P.userID = myFriends.friend ORDER BY P.time DESC LIMIT 5";
	$posts = mysql_query($query);
	
	echo "<table>";
	while ($row = mysql_fetch_array($posts)) {
		echo "<tr><td>User ".$row['friendID']." ".$row['action'] . " photo ".$row['objectID']." (".$row['time'].")</td></tr>";
	}
	echo "</table>";
	
	
	mysql_close($link);
?>