<html>
	<head>
		<script type="text/javascript">
			function getCookie(c_name) {
				var i, x, y, ARRcookies = document.cookie.split(";");
				for( i = 0; i < ARRcookies.length; i++) {
					x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
					y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
					x = x.replace(/^\s+|\s+$/g, "");
					if(x == c_name) {
						return unescape(y);
					}
				}
			}
			
			function setCookie(c_name, value, exdays) {
				var exdate = new Date();
				exdate.setDate(exdate.getDate() + exdays);
				var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
				document.cookie = c_name + "=" + c_value;
			}
			
			function logout(){
				setCookie("username", "", -1);
				history.go(0);
				load('home.php');
			}
			
			function load(url) {
				location.href = url;
			}
		</script>
	</head>
	<title>Profile</title>
<body>
	<h1>Welcome, <script type="text/javascript"> document.write(getCookie("username")); </script>!</h1>
	<h2>Profile:</h2>
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
	    $result = mysql_query("SELECT * FROM User WHERE userName = '".$user."'");
			
	    if(mysql_num_rows($result)==0) {
	    	echo "111";
	    } else {
	      echo "<table>";			
		  
	      $row = mysql_fetch_array($result) ;
	      echo "<tr>";
	      echo "<td> First Name: " . $row['first_name'] . "</td></tr>";
		  echo "<td> Last Name: " . $row['last_name'] . "</td></tr>";
		  echo "<td> Email: " . $row['email'] . "</td></tr>";
		  echo "<td> Birthday: " . $row['birth_date'] . "</td></tr>";
		  echo "<td> Gender: " . $row['gender'] . "</td></tr>";
		  echo "<td> Address: " . $row['address'] . "</td></tr>";
	      
	      echo "</table>";
	    }
	    mysql_close($link);
	?>
	<br />
	<input type="button" onclick="logout()" value="Logout" />

</body>
	
</html>