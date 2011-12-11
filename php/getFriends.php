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

$fquery = mysql_query("SELECT DISTINCT F.friendID, F.circleID FROM Friend F, Circle C WHERE C.userID ='".$userID."' AND C.circleID = F.circleID");

	echo "<tr>
			<h3><td>UserName </td>
			<td>First Name </td>
			<td>Last Name </td></h3>
		  </tr>	";


while($farray = mysql_fetch_array($fquery)){
	$friend = $farray['friendID'];
	$nquery = mysql_query("SELECT first_name, last_name, userName FROM User WHERE userID ='".$friend."'");
	$narray = mysql_fetch_array($nquery);
	$fname = $narray['first_name'];
	$lname = $narray['last_name'];
	$uname = $narray['userName'];
	echo "<tr>";
	echo "<td> ".$uname. "</td> <td> ".$fname." </td><td> ".$lname." </td> <td>";
	echo "</tr>";
}

mysql_close($link);
?>