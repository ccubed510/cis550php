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
    $result = mysql_query("SELECT P.url FROM Photo P, User U, Rating R WHERE U.userName = '".$user."' AND P.userID=U.userID AND R.userID=U.userID AND R.photoID=P.photoID ORDER BY R.rating DESC");
		
	$width = 200;
	
		
    if(mysql_num_rows($result)==0) {
    	echo "error";
    } else {
      	for ($i=0; $i<3 && $row = mysql_fetch_array($result); $i++){
      		list($picw, $pich) = getimagesize($row['url']);
			$percentage = $width / $picw;
	  		echo "<img src=\"" . $row['url'] . "\" width=\"".$percentage."%\" height=\"".$percentage."%\" alt=\"img" . $i ."\" />";
		}
	}
	mysql_close($link);			
?>