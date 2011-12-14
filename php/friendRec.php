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
	
	function getCircleRecs($theirID){
		$user = $_COOKIE["username"];
		$temp = mysql_query("SELECT userID FROM User WHERE userName = '" . $user . "'");
		$row = mysql_fetch_array($temp);
		$userID = $row['userID'];
		//create temporary table to store circle recs
		$query = "CREATE TEMPORARY TABLE IF NOT EXISTS circleRecs (circleID INT NOT NULL, score FLOAT NOT NULL) ENGINE=MEMORY";
		$create = mysql_query($query);
	
		//select ID's of mutual friends and insert into circleRecs table
		$query =  "SELECT C2.circleID AS circleID, COUNT(C2.circleID) AS count FROM Circle C2, Friend F2, (SELECT DISTINCT F.friendID AS friend FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '".$theirID."') theirFriends WHERE C2.userID = '".$userID."' AND C2.circleID = F2.circleID and F2.friendID = theirFriends.friend GROUP BY C2.circleID";
		$mutual = mysql_query($query);
		$mutualWeight = 1;
		while ($row = mysql_fetch_array($mutual)) {
			$query = "INSERT INTO circleRecs VALUES ('" .$row['circleID']. "', '" .($row['count']*$mutualWeight). "')";
			$create = mysql_query($query);
		}
		
		//create temporary table to store rating differences
		$query = "CREATE TEMPORARY TABLE IF NOT EXISTS scoreDiffCircle (friendID INT NOT NULL, diff FLOAT NOT NULL) ENGINE=MEMORY";
		mysql_query($query);
		
		//create temporary table to store friends to later count circles
		$query = "CREATE TEMPORARY TABLE IF NOT EXISTS tempFriends (friendID INT NOT NULL, score FLOAT NOT NULL) ENGINE=MEMORY";
		mysql_query($query);
		
		//select ID's of users who have rated the same photos and insert into circleRecs table
		$query = "SELECT fr.friendID AS friendID, COUNT(fr.friendID) AS count FROM Circle cir, Friend fr, (SELECT R3.userID AS friendID FROM Rating R3, (SELECT DISTINCT R.userID AS UID2 FROM Rating R, User U WHERE R.userID = U.userID) prated, (SELECT DISTINCT R2.photoID AS PID FROM Rating R2 WHERE userID = '" . $theirID . "') photos WHERE R3.userID = prated.UID2 AND R3.photoID = photos.PID AND R3.userID <> '" . $theirID . "') samePhotos WHERE cir.userID = '".$userID."' AND cir.circleID = fr.circleID AND fr.friendID = samePhotos.friendID GROUP BY fr.friendID";
		$samePhoto = mysql_query($query);
		$photoWeight = 1;
		while($row = mysql_fetch_array($samePhoto)){
			$friendID = $row['friendID'];
			$count = $row['count'];
			//echo $friendID. ", " .$count;
			$query = "INSERT INTO tempFriends VALUES ('" .$friendID. "', '" .($count*$photoWeight). "')";
			$create = mysql_query($query);
			$query = "SELECT R1.userID AS friend, ABS(R1.rating - R2.rating) AS diff FROM Rating R1, Rating R2 WHERE R1.photoID = R2.photoID AND R1.userID = '".$friendID."' AND R2.userID = '".$theirID."'";
			$diff = mysql_query($query);
			while($temp = mysql_fetch_array($diff)){
				//echo $temp['friend']." ".$temp['diff']."<br>";
				mysql_query("INSERT INTO scoreDiffCircle VALUES ('".$temp['friend']."', '".$temp['diff']."')");
			}
		}
		
		$query = "SELECT C.circleID AS circleID, SUM(friends.adjDiff) AS sum FROM Circle C, Friend F, (SELECT S.friendID AS friendID, (SUM(10-S.diff))/10 AS adjDiff FROM scoreDiffCircle S GROUP BY S.friendID) friends WHERE C.userID = '".$userID."' AND C.circleID = F.circleID AND F.friendID = friends.friendID GROUP BY C.circleID";
		$diff = mysql_query($query);
		$diffWeight = 1;
		while ($row = mysql_fetch_array($diff)){
			//echo $row['circleID']. ", " .$row['sum']."<br>";
			mysql_query("INSERT INTO circleRecs VALUES ('" .$row['circleID']. "', '" .($row['sum']*$diffWeight). "')");
		}
		//echo "<br>";
		$query = "SELECT C.circleID AS circleID, SUM(T.score) AS sum FROM Circle C, Friend F, tempFriends T WHERE C.userID = '".$userID."' AND C.circleID = F.circleID AND F.friendID = T.friendID GROUP BY C.circleID";
		$photo = mysql_query($query);
		while ($row = mysql_fetch_array($photo)){
			//echo $row['circleID']. ", " .$row['sum']."<br>";
			mysql_query("INSERT INTO circleRecs VALUES ('" .$row['circleID']. "', '" .($row['sum']). "')");
		}
		
		//select circleID's of users who attend the same school
		$query = "SELECT C.circleID AS circleID, SUM(sameSchool.count) AS sum FROM Circle C, Friend F, (SELECT A2.userID AS friendID, COUNT(A2.userID) AS count FROM Attended A2, (SELECT A.institutionName AS school FROM Attended A WHERE userID = '" . $theirID . "') mySchools WHERE A2.institutionName = mySchools.school AND A2.userID <> '" . $theirID . "' GROUP BY A2.userID) sameSchool WHERE C.userID = '".$userID."' AND C.circleID = F.circleID AND F.friendID = sameSchool.friendID GROUP BY C.circleID";
		$sameSchool = mysql_query($query);
		$schoolWeight = 1;
		while ($row = mysql_fetch_array($sameSchool)) {
			//echo "school<br>";
			//echo $row['circleID']. ", " .$row['sum'];
			$query = "INSERT INTO circleRecs VALUES ('" .$row['circleID']. "', '" .($row['sum']*$schoolWeight). "')";
			$create = mysql_query($query);
		}
		
		$query = "DROP TABLE tempFriends";
		$drop = mysql_query($query);
		$query = "DROP TABLE scoreDiffCircle";
		$drop = mysql_query($query);
		
		//select circleID's of users who have the same interests
		$query = "SELECT C.circleID as circleID, SUM(friends.count) AS sum FROM Circle C, Friend F, (SELECT I1.userID AS friendID, COUNT(I1.userID) AS count FROM Interests I1, Interests I2 WHERE I2.userID = '".$theirID."' AND I1.interest = I2.interest AND I1.userID <> '" . $theirID . "' GROUP BY I1.userID) friends WHERE C.userID = '".$userID."' AND C.circleID = F.circleID AND F.friendID = friends.friendID GROUP BY C.circleID";
		$interests = mysql_query($query);
		$interestWeight = 1;
		while ($row = mysql_fetch_array($interests)) {
			//echo $row['circleID']. ", " .$row['sum']."<br>";
			$query = "INSERT INTO circleRecs VALUES ('" .$row['circleID']. "', '" .($row['sum']*$interestWeight). "')";
			mysql_query($query);
		}
		
		//query circleRec table for top circle
		$query = "SELECT circleID, SUM(score) AS score FROM circleRecs GROUP BY circleID ORDER BY score DESC LIMIT 1";
		$test = mysql_query($query);
		if (mysql_num_rows($test) == 0) {
			$query = "DROP TABLE circleRecs";
			$drop = mysql_query($query);
			return -1;
		} else {
			$row = mysql_fetch_array($test);
			//echo "<br>".$row['circleID']." ".$row['score'];
			$query = "DROP TABLE circleRecs";
			$drop = mysql_query($query);
			return $row['circleID'];
		}
	}
	
	//create temporary table to store queries
	$query = "CREATE TEMPORARY TABLE IF NOT EXISTS recs (friendID INT NOT NULL, score FLOAT NOT NULL) ENGINE=MEMORY";
	$create = mysql_query($query);
	
	//select ID's of mutual friends and insert into recs table
	$query =  "SELECT friendOfFriend AS userID, COUNT(friendOfFriend) as count FROM (SELECT F2.friendID AS friendOfFriend FROM Friend F2, Circle C2, (SELECT DISTINCT F.friendID AS friend FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '".$userID."') myFriends WHERE F2.circleID = C2.circleID AND C2.userID = myFriends.friend) fof WHERE fof.friendOfFriend NOT IN (SELECT DISTINCT F3.friendID FROM Friend F3, Circle C3 WHERE F3.circleID = C3.circleID AND C3.userID = '".$userID."') AND fof.friendOfFriend <> '".$userID."' GROUP BY userID";
	$mutual = mysql_query($query);
	$mutualWeight = 1;
	while ($row = mysql_fetch_array($mutual)) {
		$query = "INSERT INTO recs VALUES ('" .$row['userID']. "', '" .($row['count']*$mutualWeight). "')";
		$create = mysql_query($query);
	}
		
	//create temporary table to store rating differences
	$query = "CREATE TEMPORARY TABLE IF NOT EXISTS scoreDiff (friendID INT NOT NULL, diff FLOAT NOT NULL) ENGINE=MEMORY";
	mysql_query($query);
	
	//select ID's of users who have rated the same photos and insert into temp table
	$query = "SELECT R3.userID AS friendID, COUNT(R3.userID) AS count FROM Rating R3, (SELECT DISTINCT R.userID AS UID2 FROM Rating R, (SELECT U.userID AS UID FROM User U WHERE U.userID NOT IN (SELECT DISTINCT F.friendID AS friend FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '" . $userID . "')) potential WHERE R.userID = UID) prated, (SELECT DISTINCT R2.photoID AS PID FROM Rating R2 WHERE userID = '" . $userID . "') photos WHERE R3.userID = prated.UID2 AND R3.photoID = photos.PID AND R3.userID <> '" . $userID . "' GROUP BY R3.userID";
	$samePhoto = mysql_query($query);
	$photoWeight = 1;
	while($row = mysql_fetch_array($samePhoto)){
		$friendID = $row['friendID'];
		$count = $row['count'];
		//echo $friendID. ", " .$count;
		$query = "INSERT INTO recs VALUES ('" .$friendID. "', '" .($count*$photoWeight). "')";
		$create = mysql_query($query);
		$query = "SELECT R1.userID AS friend, ABS(R1.rating - R2.rating) AS diff FROM Rating R1, Rating R2 WHERE R1.photoID = R2.photoID AND R1.userID = '".$friendID."' AND R2.userID = '".$userID."'";
		$diff = mysql_query($query);
		while($temp = mysql_fetch_array($diff)){
			//echo $temp['friend']." ".$temp['diff']."<br>";
			mysql_query("INSERT INTO scoreDiff VALUES ('".$temp['friend']."', '".$temp['diff']."')");
		}
	}
	
	$query = "SELECT S.friendID AS friendID, (SUM(10-S.diff))/10 AS adjDiff FROM scoreDiff S GROUP BY S.friendID";
	//$query = "SELECT friendID, diff AS adjDiff FROM scoreDiff";
	$diff = mysql_query($query);
	
	$diffWeight = 1;
	while ($row = mysql_fetch_array($diff)){
		//echo $row['friendID']. ", " .$row['adjDiff'];
		mysql_query("INSERT INTO recs VALUES ('" .$row['friendID']. "', '" .($row['adjDiff']*$diffWeight). "')");
	}
	
	//select ID's of users who attend the same school
	$query = "SELECT A2.userID AS friendID, COUNT(A2.userID) AS count FROM Attended A2, (SELECT A.institutionName AS school FROM Attended A WHERE userID = '" . $userID . "') mySchools WHERE A2.institutionName = mySchools.school AND A2.userID NOT IN (SELECT DISTINCT F.friendID AS friend FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '" . $userID . "') AND A2.userID <> '" . $userID . "' GROUP BY A2.userID";
	$sameSchool = mysql_query($query);
	$schoolWeight = 1;
	while ($row = mysql_fetch_array($sameSchool)) {
		//	echo $row['friendID']. "', '" .$row['count'];
		$query = "INSERT INTO recs VALUES ('" .$row['friendID']. "', '" .($row['count']*$schoolWeight). "')";
		$create = mysql_query($query);
	}
	
	//select ID's of users who have the same interests
	$query = "SELECT I1.userID AS friendID, COUNT(I1.userID) AS count FROM Interests I1, Interests I2 WHERE I2.userID = '".$userID."' AND I1.interest = I2.interest AND I1.userID <> '" . $userID . "' AND I1.userID NOT IN (SELECT DISTINCT F.friendID AS friend FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '" . $userID . "') GROUP BY I1.userID";
	$interests = mysql_query($query);
	$interestWeight = 1;
	while ($row = mysql_fetch_array($interests)) {
		//echo $row['friendID']. ", " .$row['count']."<br>";
		$query = "INSERT INTO recs VALUES ('" .$row['friendID']. "', '" .($row['count']*$interestWeight). "')";
		mysql_query($query);
	}
	
	//query temp table for top 3 potential friends
	$query = "SELECT U.userID as UID, U.first_name AS first, U.last_name AS last FROM User U, (SELECT friendID, SUM(score) AS score FROM recs WHERE score>0 GROUP BY friendID ORDER BY score DESC LIMIT 3) T WHERE U.userID = friendID";
	$test = mysql_query($query);
	if (mysql_num_rows($test) == 0) {
		//echo "Error: unable to get temp recommendations.";
	} else {
		echo "<td class='friendRec' id='friendRec' colspan='2'><hr><b>Friend Recommendations</b>";
		echo "<table>";
	while($row = mysql_fetch_array($test)){
		$circleRec = getCircleRecs($row['UID']);
		echo "<tr><td><a href=\"/addFriend.php?first=".$row['first']."&last=".$row['last']."&circle=".$circleRec."\">" .$row['first']." ".$row['last'] . "</a></td></tr>";				
	}
	echo "</table><hr>";
	echo "</td>";
	}
	
	$query = "DROP TABLE recs";
	$drop = mysql_query($query);
	$query = "DROP TABLE scoreDiff";
	$drop = mysql_query($query);
	
	mysql_close($link);
?>