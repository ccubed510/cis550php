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
    $result = mysql_query("SELECT P.url FROM Photo P, User U, Visible V WHERE U.userName = '".$user."' AND U.userID = V.viewerID AND V.photoID = P.photoID");	
		
    if(mysql_num_rows($result)==0) {
    	echo "You can't view any photos";
    } else {
      	for ($i=0; $i<mysql_num_rows($result) && $row = mysql_fetch_array($result); $i++){
      		list($picw, $pich) = getimagesize($row['url']);
	  		//echo "<img src=\"" . $row['url'] . "\" width=\"".$percentage."%\" height=\"".$percentage."%\" alt=\"img" . $i ."\" />";
			echo "<li>
		    <h4>Isolated sandy cove</h4>
		    <div class=\"tn3 description\">Zakynthos island, Greece</div>
		    <a href=\"".$row['url']."\" width=620 height=378>
			<img src=\"".$row['url']."\" width=35 height=35 />
		    </a> </li>";

		}
	}
	mysql_close($link);			
?>