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
	$firstName = $_GET['firstName'];
	$lastName = $_GET['lastName'];
	$circleIDs = $_GET['circleIDs'];
	$newCircle = $_GET['newCircle'];
	
	//Check if form submitted.
	if (strlen($firstName) > 0) {
		//Check if friend exists in PennPhoto. Returns an error if friend does not exist.
		$result = mysql_query("SELECT * FROM User WHERE first_name='".$firstName."' AND last_name='".$lastName."'");
		if (mysql_num_rows($result) == 0) {
			die("ERROR: " .$firstName. " ".$lastName." does not exist in PennPhoto. Please specify a valid person.");
		}
		$row = mysql_fetch_array($result);
		$friendID = $row['userID'];
		
		//If user specified new circle, create new circle and add friend to that circle.
		if (strlen($newCircle) > 0) {
			//Get user's userID.
			$result = mysql_query("SELECT U.userID FROM User U WHERE U.userName='".$user."'");
			$row = mysql_fetch_array($result);
			$userID = $row['userID'];
			//Check if circle name already exists.
			$result = mysql_query("SELECT * FROM Circle WHERE userID='".$userID."' AND name='".$newCircle."'");
			if (mysql_num_rows($result) != 0) {
				die("ERROR: ".$newCircle." already exists. Please choose a new circle name.");
			}
			//Create new circle.
			mysql_query("INSERT into Circle (userID, name) VALUES ('".$userID."', '".$newCircle."')");
			//Get newly created circle's circleID;
			$result = mysql_query("SELECT circleID FROM Circle WHERE userID='".$userID."' AND name='".$newCircle."'");
			$row = mysql_fetch_array($result);
			//Add new friend to newly created circle.
			mysql_query("INSERT INTO Friend VALUES ('".$friendID."', '".$row['circleID']."')");
		}
		
		//Adds new friend to all specified existing circles.
		if (strlen($circleIDs) > 0) {
			$circles = explode(";", $circleIDs);
			foreach ($circles as $value) {
				//Check if friend is already in that circle.
				$result = mysql_query("SELECT C.name FROM Friend F, Circle C WHERE F.friendID='".$friendID."' AND F.circleID='".$value."' AND F.circleID=C.circleID");
				if (mysql_num_rows($result) != 0) {
					$row = mysql_fetch_array($result);
					die("ERROR: ".$firstName. " ".$lastName." is already in your '".$row['name']."' circle!");
				}
				mysql_query("INSERT INTO Friend VALUES ('".$friendID."', '".$value."')");
			}
		}
		
		echo "Friend successfully added!";
	}

	mysql_close($link);
?>