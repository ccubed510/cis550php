<html>
	<head>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
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
			
			function getTopPhotos() {
				xmlhttp=new XMLHttpRequest();
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4) {
						var response = xmlhttp.responseText;
						if(response.trim() == 'error'){
							alert("Picture error");
						}
						else {
							document.getElementById("topPhotos").innerHTML=xmlhttp.responseText;
						}
					}
				}
				xmlhttp.open("GET", "getTopPhotos.php", true);
				xmlhttp.send(null);
			}
		</script>
		
		<script type="text/javascript">
			$(document).ready(function() {
				$(".flip").click(function() {
					$(".panel").slideToggle("slow");
				});
			});
		</script>
		
		<script type="text/javascript">
			$(document).ready(function() {
				$(".optionsToggle").click(function() {
					$(".optionsPanel").slideToggle("slow");
				});
			});
		</script>
		
		<style type="text/css">
			div.panel, p.flip, div.optionsPanel, p.optionsToggle
			{
				margin: 0px;
				padding: 5px;
				text-align: center;
				background: #E5EECC;
				border: solid 1px #C3C3C3;
			}
			div.panel
			{
				height: 450px;
				display: none;
			}
			div.optionsPanel
			{
				display:none;
			}
		</style>
	</head>
	
	<title>Profile</title>
	
	<body>
		<table width="1000px">
			<tr>
				<td><h1>Welcome, <script type="text/javascript"> document.write(getCookie("username")); </script>!</h1></td>
				<td style="text-align:right;"><input type="button" onclick="logout()" value="Logout" /></td>
			<tr>
				<td colspan="2"><div id="topPhotos" class="panel"><script type="text/javascript"> getTopPhotos(); </script></div>
				<p class="flip">Show/Hide Pictures</p></td>
			<tr>
				<td style="background-color:#39B7CD;width:50px;text-align:top;">
					<h3>Profile:</h2>
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
					    	echo "Error: unable to get user info.";
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
				</td>
				<td style="background-color:#82CFFD;height:200px;width:500px;text-align:top;">Friend Updates Here!</td>
			</tr>
			<tr>
				<td colspan="2"><div class="optionsPanel">
					<table>
						<tr>
							<td><a href="uploadPhoto.html">Upload a photo!</a></td>
							<td>Add a new friend!</td>
						</tr>
					</table>
				</div>
				<p class="optionsToggle">Additional Options</p></td>
			</tr>
		</table>
	
	</body>
		
</html>