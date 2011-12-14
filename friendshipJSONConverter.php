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
	$user = $_COOKIE['username'];
	
	//Get user's userID and name for root element of json object.
	$result = mysql_query("SELECT U.userID, U.first_name, U.last_name FROM User U WHERE U.userName='".$user."'");
	$row = mysql_fetch_array($result);
	$userID = $row['userID'];
	$name = getName($row);
	
	$array = array();
	$array['id'] = $userID;
	$array['name'] = $name;
	//Get your photos;
	$photos = array();
	$p = mysql_query("SELECT url FROM Photo WHERE userID = '".$userID."'");
	for ($i = 0; $i < mysql_num_rows($p) && $i < 4; $i++) {
		$photo = mysql_fetch_array($p);
		array_push($photos, array("url" => $photo['url']));
	}
	$array['data'] = array("photos" => $photos);
	
	$children = array();
	
	//Check if user if professor or student.
	$check = mysql_query("SELECT * FROM Student WHERE userName = '".$user."'");
	$child = array();
	// If user is a student, get advisor and advisor's advisees.
	if (mysql_num_rows($check) > 0) {
		$student = mysql_fetch_array($check);
		$advisor = $student['advisor'];
		$a = mysql_query("SELECT userID, first_name, last_name FROM User WHERE userName = '".$advisor."'");
		$aRow = mysql_fetch_array($a);
		$advisorID = $aRow['userID'];
		$advisorName = getName($aRow);
		$child['id'] = $advisorID;
		$child['name'] = $advisorName;
		//Get professor's advisees.
		$grandchildren = array();
		$advisees = mysql_query("SELECT advisee FROM Professor WHERE userName='".$advisor."' AND advisee IS NOT NULL");
		for ($x = 0; $x < mysql_num_rows($advisees); $x++) {
			$grandchild = array();
			$row = mysql_fetch_array($advisees);
			$advisee = mysql_query("SELECT first_name, last_name, userID FROM User WHERE userName = '".$row['advisee']."' AND userID NOT IN (SELECT DISTINCT F.friendID FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '".$userID."')");
			$row2 = mysql_fetch_array($advisee);
			$grandchild['id'] = $row2['userID'];
			$grandchild['name'] = getName($row2);
			$data = array("\$type" => "square");
			$grandchild['data'] = $data;
			array_push($grandchildren, $grandchild);
		}
		//Get Photos.
		$photos = array();
		$p = mysql_query("SELECT url FROM Photo WHERE userID = '".$advisorID."' AND photoID IN (SELECT photoID FROM Photo P2 WHERE P2.Visibility = 'public' UNION SELECT photoID FROM Visible V WHERE V.viewerID = '".$userID."')");
		for ($j=0; $j < mysql_num_rows($p) && $j < 4; $j++) {
			$photo = mysql_fetch_array($p);
			array_push($photos, array("url" => $photo['url']));
		}
		$child['data'] = array("photos" => $photos, "\$type" => "square");
		$child['children'] = $grandchildren;
		array_push($children, $child);
	} 
	//If user is a professor, get advisees.
	else {
		$advisees = mysql_query("SELECT * FROM Professor WHERE userName = '".$user."'");
		for ($x = 0; $x < mysql_num_rows($advisees); $x++) {
			$advisee = mysql_fetch_array($advisees);
			$student = $advisee['advisee'];
			$a = mysql_query("SELECT userID, first_name, last_name FROM User WHERE userName = '".$student."'");
			$aRow = mysql_fetch_array($a);
			$studentID = $aRow['userID'];
			$studentName = getName($aRow);
			$child['id'] = $studentID;
			$child['name'] = $studentName;
			//Get photos.
			$photos = array();
			$p = mysql_query("SELECT url FROM Photo WHERE userID = '".$studentID."' AND photoID IN (SELECT photoID FROM Photo P2 WHERE P2.Visibility = 'public' UNION SELECT photoID FROM Visible V WHERE V.viewerID = '".$userID."')");
			for ($j=0; $j < mysql_num_rows($p) && $j < 4; $j++) {
				$photo = mysql_fetch_array($p);
				array_push($photos, array("url" => $photo['url']));
			}
			$child['data'] = array("photos" => $photos, "\$type" => "square");
			array_push($children, $child);
		}
	}

	//Select all of user's friends within one degree.
	$result = mysql_query("SELECT DISTINCT F.friendID FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '".$userID."'");
	for ($i = 0; $i < mysql_num_rows($result); $i++) {
		$child = array();
		$row = mysql_fetch_array($result);
		$friendID = $row['friendID'];
		$friend = mysql_query("SELECT first_name, last_name FROM User WHERE userID = '".$friendID."'");
		$friendName = getName(mysql_fetch_array($friend));
		$child['id'] = $friendID;
		$child['name'] = $friendName;
		
		//Get Friend's top photos that are visible to you.
		$photos = array();
		$p = mysql_query("SELECT url FROM Photo WHERE userID = '".$friendID."' AND photoID IN (SELECT photoID FROM Photo P2 WHERE P2.Visibility = 'public' UNION SELECT photoID FROM Visible V WHERE V.viewerID = '".$userID."')");
		for ($j=0; $j < mysql_num_rows($p) && $j < 4; $j++) {
			$photo = mysql_fetch_array($p);
			array_push($photos, array("url" => $photo['url']));
		}
		$child['data'] = array("photos" => $photos);
		
		//Add friend of friends.
		$grandchildren = array();
		$friendsOfFriends = mysql_query("SELECT DISTINCT F.friendID FROM Friend F, Circle C WHERE F.circleID = C.circleID AND C.userID = '".$friendID."' AND F.friendID <> '".$userID."'");
		for ($k = 0; $k < mysql_num_rows($friendsOfFriends); $k++) {
			$grandchild = array();
			$row = mysql_fetch_array($friendsOfFriends);
			$fofID = $row['friendID'];
			$fof = mysql_query("SELECT first_name, last_name FROM User WHERE userID = '".$fofID."'");
			$fofName = getName(mysql_fetch_array($fof));
			$grandchild['id'] = $fofID;
			$grandchild['name'] = $fofName;
			array_push($grandchildren, $grandchild);
		}
		$child['children'] = $grandchildren;
		array_push($children, $child);
	}
	
	$array['children'] = $children;
	print json_encode($array);
	
	function getName($queryResult) {
		return $queryResult['first_name']." ".$queryResult['last_name'];
	}
	
	mysql_close($link);
?>