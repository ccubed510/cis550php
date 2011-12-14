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
$result = mysql_query("SELECT * FROM User WHERE userName = '" . $user . "'");

if (mysql_num_rows($result) == 0) {
	echo "Error: unable to get user info.";
} else {
	$row = mysql_fetch_array($result);
	$userID = $row['userID'];
	
	$query = "SELECT interest FROM Interests WHERE userID = '".$userID."' ORDER BY interest";
	$interests = mysql_query($query);
	$temp = mysql_fetch_array($interests);
	$interestText = $temp['interest'];
	while ($temp = mysql_fetch_array($interests)){
		$interestText = $interestText.", ".$temp['interest'];
	}
	
	$query = "SELECT institutionName FROM Attended WHERE userID = '".$userID."'";
	$schools = mysql_query($query);
	$temp = mysql_fetch_array($schools);
	$schoolText = $temp['institutionName'];
	while ($temp = mysql_fetch_array($schools)){
		$schoolText = $schoolText.", ".$temp['institutionName'];
	}
	
	echo "<table>";
	echo "<tr>";
	echo "<td> First Name: " . $row['first_name'] . "</td></tr>";
	echo "<td> Last Name: " . $row['last_name'] . "</td></tr>";
	echo "<td> Email: " . $row['email'] . "</td></tr>";
	echo "<td> Birthday: " . $row['birth_date'] . "</td></tr>";
	echo "<td> Gender: " . $row['gender'] . "</td></tr>";
	echo "<td> Address: " . $row['address'] . "</td></tr>";
	echo "<td> Academic Institution(s): " . $schoolText . "</td></tr>";
	echo "<td> Interest(s): " . $interestText . "</td></tr>";

	echo "</table>";
}
mysql_close($link);
?>