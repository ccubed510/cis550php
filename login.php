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
    $user = $_GET["userName"];
    $password = $_GET["password"];
    $result = mysql_query("SELECT * FROM Login WHERE userName = '".$user."' AND password = '".$password."'");
		
    if(mysql_num_rows($result)==0) {
      echo "Incorrect username or password";
    } else {
      echo "<table>";			
	  
      $row = mysql_fetch_array($result) ;
      echo "<tr>";
      echo "<td> Hello, " . $row['userName'] . "</td></tr>";
      
      echo "</table>";
    }
    mysql_close($link);
  ?>
