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

$photoID = 180035;

$fetchID = mysql_query("SELECT User.userID FROM User WHERE User.userName =\"" . $user . "\"");
$fetchArray = mysql_fetch_array($fetchID);
$userID = 28541;

//get the total number of ratings on the photo.

$countquery = mysql_query("SELECT COUNT(*) AS Count FROM Rating R WHERE R.photoID = \"" . $photoID . "\""); 
$countarray = mysql_fetch_array($countquery);
$ncount = $countarray['Count'];

//get the total sum of ratings on the photo.

$countquery = mysql_query("SELECT SUM(rating) AS Sum FROM Rating R WHERE R.photoID = \"" . $photoID . "\""); 
$countarray = mysql_fetch_array($countquery);
$nsum = $countarray['Sum'];

//get the total number of ratings by friends of the user.

$friendquery = mysql_query("SELECT COUNT(*) AS Count FROM ( SELECT DISTINCT Fphoto.userID FROM Circle C, Friend F, (SELECT * FROM Rating R WHERE R.photoID = \"" . $photoID . "\") Fphoto WHERE F.circleID = C.circleID AND F.friendID = Fphoto.userID AND C.userID =  \"".$userID."\") Grouping");
$friendarray = mysql_fetch_array($friendquery);
$fcount = $friendarray['Count'];

//get the total sum of ratings by friends of the user.

$friendquery = mysql_query("SELECT SUM(rating) AS Sum FROM ( SELECT DISTINCT Fphoto.rating AS rating FROM Circle C, Friend F, (SELECT * FROM Rating R WHERE R.photoID = \"" . $photoID . "\") Fphoto WHERE F.circleID = C.circleID AND F.friendID = Fphoto.userID AND C.userID =  \"".$userID."\") Grouping");
$friendarray = mysql_fetch_array($friendquery);
$fsum = $friendarray['Sum'];

$number = $ncount + 0.5*$fcount;
$sum = ($nsum + 0.5*$fsum) / $ncount;
$relevance = 0.2*$number + 0.8*$sum;  
echo $nsum;
echo $fsum;
echo $relevance;
//echo "Average score: " . $avg['Average'];

//relevance scoring is as follows: Non Friend rating = 100% of base, Friend rating = 150% of base. 
//Relevance = 20% * Number of Ratings + 80% * Avg Rating
// Number of Ratings = # non friend ratings + 1.5 * # friend ratings
// Avg Rating = sum of non friend + friend ratings / # ratings


mysql_close($link);
?>