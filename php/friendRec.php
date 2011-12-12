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
	
	//create temporary table to store queries
	$query = "CREATE TEMPORARY TABLE IF NOT EXISTS recs (friendID INT NOT NULL, score INT NOT NULL) ENGINE=MEMORY";
	$create = mysql_query($query);
	
	//select ID's of mutual friends and insert into temp table
	$query =  "SELECT friendOfFriend AS userID, COUNT(friendOfFriend) as count FROM (SELECT F2.friendID AS friendOfFriend FROM Friend F2, Circle C2, (SELECT DISTINCT F.friendID AS friend FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '".$userID."') myFriends WHERE F2.circleID = C2.circleID AND C2.userID = myFriends.friend) fof WHERE fof.friendOfFriend NOT IN (SELECT DISTINCT F3.friendID FROM Friend F3, Circle C3 WHERE F3.circleID = C3.circleID AND C3.userID = '".$userID."') AND fof.friendOfFriend <> '".$userID."' GROUP BY userID";
	$mutual = mysql_query($query);
	if (mysql_num_rows($mutual) == 0) {
		//echo "Error: unable to get friend recommendations.";
	} else {
		while ($row = mysql_fetch_array($mutual)) {
			$query = "INSERT INTO recs VALUES ('" .$row['userID']. "', '" .$row['count']. "')";
			$create = mysql_query($query);
		}
	}
	
	//select ID's of users who have rated the same photos and insert into temp table
	$query = "SELECT R3.userID AS friendID, COUNT(R3.userID) AS count FROM Rating R3, (SELECT DISTINCT R.userID AS UID2 FROM Rating R, (SELECT U.userID AS UID FROM User U WHERE U.userID NOT IN (SELECT DISTINCT F.friendID AS friend FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '" . $userID . "')) potential WHERE R.userID = UID) prated, (SELECT DISTINCT R2.photoID AS PID FROM Rating R2 WHERE userID = '" . $userID . "') photos WHERE R3.userID = prated.UID2 AND R3.photoID = photos.PID AND R3.userID <> '" . $userID . "' GROUP BY R3.userID";
	$samePhoto = mysql_query($query);
	while($row = mysql_fetch_array($samePhoto)){
		$friendID = $row['friendID'];
		$count = $row['count'];
		$query = "INSERT INTO recs VALUES ('" .$friendID. "', '" .$count. "')";
		$create = mysql_query($query);
	}
	
	//select ID's of users who attend the same school
	$query = "SELECT A2.userID AS friendID, COUNT(A2.userID) AS count FROM Attended A2, (SELECT A.institutionName AS school FROM Attended A WHERE userID = '" . $userID . "') mySchools WHERE A2.institutionName = mySchools.school AND A2.userID NOT IN (SELECT DISTINCT F.friendID AS friend FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '" . $userID . "') AND A2.userID <> '" . $userID . "' GROUP BY A2.userID";
	$sameSchool = mysql_query($query);
	while ($row = mysql_fetch_array($sameSchool)) {
		//echo $row['friendID']. "', '" .$row['count'];
		$query = "INSERT INTO recs VALUES ('" .$row['friendID']. "', '" .$row['count']. "')";
		$create = mysql_query($query);
	}
	
	//query temp table for top 3 potential friends
	$query = "SELECT U.first_name AS first, U.last_name AS last FROM User U, (SELECT friendID, SUM(score) AS score FROM recs GROUP BY friendID ORDER BY score DESC LIMIT 3) T WHERE U.userID = friendID";
	$test = mysql_query($query);
	if (mysql_num_rows($test) == 0) {
		//echo "Error: unable to get temp recommendations.";
	} else {
		echo "<td><b>Friend Recommendations</b></td>";
		echo "<table>";
	while($row = mysql_fetch_array($test)){
		echo "<tr><td><a href=\"/addFriend.php?first=".$row['first']."&last=".$row['last']."\">" .$row['first']." ".$row['last'] . "</a></td></tr>";	
	}
	echo "</table>";
	}
	
	$query = "DROP TABLE recs";
	$drop = mysql_query($query);
	
	mysql_close($link);
?>