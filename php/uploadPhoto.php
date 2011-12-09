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
	$url = $_GET['url'];
	$visibility = $_GET['visibility'];
	$acl = $_GET['acl'];
	
	//For testing
	/*echo $user;
	echo "<br />";
	echo $url;
	echo "<br />";
	echo $visibility;
	echo "<br />";
	echo $acl;
	echo "<br />";
	$user = "brchiang";
	$url = "http://lashgirl.me/wp-content/uploads/2011/06/Nemo3.jpg";
	$visibility = "circles";
	$acl = "friends;peeps";*/
		
	//Get userID of user uploading photo.
	$result = mysql_query("SELECT U.userID FROM User U WHERE U.userName='".$user."'");
	$row = mysql_fetch_array($result);
	$userID = $row['userID'];
	
	// If user choses public, simply adds photo to Photo table specifying photo as public.
	if ($visibility == "public") {
		mysql_query("INSERT INTO Photo (userID, url, visibility) VALUES ('".$userID."', '".$url."', 'public')");
	}
	
	// Else, user specifies restricted set of people who can view photos.
	else {
		$userList = array();	
		// If user choses to specify list of users, checks whether all users specified in ACL are valid. If not, throws an error specifying which name doesn't exist
		// in the database and does not upload the photo.
		if ($visibility == "users") {
			$users = explode(";", $acl);
			foreach ($users as $value) {
				$name = explode(" ", $value);
				$check = mysql_query("SELECT * FROM User WHERE User.first_name = '".$name[0]."' AND User.last_name = '".$name[1]."'");
				if (mysql_num_rows($check)==0) {
					//echo "ERROR: " .$name[0]. " " .$name[1]. " does not exist in PennPhoto. Please specify a valid user.";
					die("ERROR: " .$name[0]. " " .$name[1]. " does not exist in PennPhoto. Please specify a valid user.");
				}
				else {
					$row = mysql_fetch_array($check);
					//echo $row['userName'];
					array_push($userList, $row['userID']);
				}
			}
		}
		// If user choses to specify a list of circles, checks whether all circle names are valid and pulls all the userID from all users in the circles.
		// If incorrect circle name provided, throws an error.
		if ($visibility == "circles") {
			$circles = explode(";", $acl);
			$circleIDs = array();
			foreach ($circles as $value) {
				$result = mysql_query("SELECT circleID FROM Circle WHERE userID='".$userID."' AND name='".$value."'");
				if (mysql_num_rows($result)==0) {
					die("ERROR: ".$value." is not a valid circle. Please enter valid circle names.");
				}
				else {
					$row = mysql_fetch_array($result);
					array_push($circleIDs, $row['circleID']);
				}
			}
			foreach ($circleIDs as $value) {
				$result = mysql_query("SELECT friendID from Friend WHERE circleID='".$value."'");
				for ($i=0; $i<mysql_num_rows($result); $i++) {
					$row = mysql_fetch_array($result);
					array_push($userList, $row['friendID']);
				}
			}
		}
		
		// Inserts the photo into the photo table.
		mysql_query("INSERT INTO Photo (userID, url, visibility) VALUES ('".$userID."', '".$url."', 'restricted')");

		// Finds the newly inserted photo's photoID
		$result = mysql_query("SELECT P.photoID FROM Photo P WHERE P.userID = '".$userID."' AND P.url = '".$url."'");
		$row = mysql_fetch_array($result);
		$photoID = $row['photoID'];
		
		// Inserts a line into the visibility table to specify all the users that can view the photo including the owner of the photo.
		mysql_query("INSERT INTO Visible VALUES ('".$photoID."', '".$userID."')");
		foreach ($userList as $value) {
			mysql_query("INSERT INTO Visible VALUES ('".$photoID."', '".$value."')");
		}
		echo "Photo successfully uploaded.";
		//print_r($userList);
	}

	mysql_close($link);
?>