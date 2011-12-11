<html>
	<head>
		<title>Add a New Friend</title>
		<script type="text/javascript">
			function formsubmit() {
				var firstName = document.getElementById("firstName").value;
				if (firstName.length == 0) {
					alert("You must enter a first name.");
					return;
				}
				var lastName = document.getElementById("lastName").value;
				if (lastName.length == 0) {
					alert("You must enter a last name.");
					return;
				}
				var circleIDs = "";
				var circleIDs = getCheckedCircles();
				var newCircle = document.getElementById("circleName").value;
				if (circleIDs.length == "" && newCircle.length == 0) {
					alert("You must add your new friend to an existing circle or create a new circle.");
					return;
				}
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState==4) {
						var response = xmlhttp.responseText;
						if (response.trim() == 'error') {
							alert("Unable to add friend. Please check your information.");
						}
						else {
							alert(response);
							load('getuserinfo.php');
						}
					}
				}
				xmlhttp.open("GET", "/php/newFriend.php?firstName=" + firstName + "&lastName=" + lastName + "&circleIDs=" + circleIDs + "&newCircle=" + newCircle, true);
				xmlhttp.send();
			}
			
			function getCheckedCircles() {
				var circleIDs = "";
				for (i=0; i<document.addForm.circleName.length; i++) {
					if (document.addForm.circleName[i].checked==true) {
						circleIDs = circleIDs + ";" + document.addForm.circleName[i].value;
					}
				}
				if (circleIDs.length > 0) {
					circleIDs = circleIDs.slice(1);
				}
				return circleIDs;
			}
			
			function load(url) {
				location.href = url;
			}
		</script>
		<style type="text/css">
			.indent {
				margin-left: 2em;
			}
		</style>
	</head>
	<body>
		<h3>Add a New Friend or Add an Existing Friend to a New Circle:</h3>
		<div id="addForm">
			<form name="addForm">
				<fieldset>
					<br />
					Friend's name:<br />
					<label class="indent">First name: </label><input type="text" id="firstName" /><br />
					<label class="indent">Last name: </label><input type="text" id="lastName" /><br />
					<br />
					<?php
					//Fetches all the circle names a user owns.
					$db_username = "yannie";
				    $db_password = "abcd";
				    $db_host = "fling.seas.upenn.edu";
				    $db_name = "yannie";
					
					$link = mysql_connect($db_host, $db_username, $db_password);
				    if (!$link) {
				      die('Could not connect: ' . mysql_error());
				    }
					
					mysql_select_db($db_name, $link);
					$first = "";
					$last = "";
					if(empty($_GET)) {
    					echo "<hr>";	
					} else {
						$first = $_GET['first'];
						$last = $_GET['last'];
						echo "<script type=\"text/javascript\">document.getElementById(\"firstName\").value='".$first."';document.getElementById(\"lastName\").value='".$last."';</script>";
					}
					
					function getCircles() {
						//Get userID of user.
						$user = $_COOKIE['username'];
						$result = mysql_query("SELECT U.userID FROM User U WHERE U.userName='".$user."'");
						$row = mysql_fetch_array($result);
						$userID = $row['userID'];
						
						$strQuery = "SELECT circleID, name FROM Circle WHERE userID='".$userID."'";
						$result = mysql_query($strQuery);
						$output = "";
						for ($i=0; $i<mysql_num_rows($result); $i++) {
							$row = mysql_fetch_array($result);
							$output = $output."<input type='checkbox' class='indent' name='circleName' value='".$row['circleID']."' id='".$row['circleID']."' />".$row['name']."<br />";
						}
						if ($output == "") {
							return False;
						}
						return $output;
					}
					$result = getCircles();
					if ($result!=False) {
						echo "<label>Add to Existing Circle:<br /></label>";
						echo $result;
						echo "<br /><label class='indent'>OR</label><br /><br />";
					}
					mysql_close($link);
					?>
					Add to New Circle:<input type="text" id="circleName" /><br />
					<input type="button" onclick="formsubmit()" value="Add" />
				</fieldset>
			</form>
		</div>
		<input type="button" onclick="load('getuserinfo.php')" value="Cancel" />
	</body>
</html>