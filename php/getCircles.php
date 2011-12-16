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
	
	echo "<b>My Circles: </b><br />";
	
	//Get user's userID.
	$result = mysql_query("SELECT U.userID FROM User U WHERE U.userName='".$user."'");
	$row = mysql_fetch_array($result);
	$userID = $row['userID'];
	
	//Get user's circles.
	$result = mysql_query("SELECT * FROM Circle WHERE userID = '".$userID."'");
	if (mysql_num_rows($result) == 0) {
		echo "You have no circles. :( <br /><br />";
		echo "<a href='addFriend.php'>Click here to create one now!</a>";
	}
	else {
		for ($i = 0; $i < mysql_num_rows($result); $i++) {
			$row = mysql_fetch_array($result);
			echo "<li>".$row['name']."</li>";
		}
	}
	mysql_close($link);
?>