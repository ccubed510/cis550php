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
				xmlhttp.open("GET", "/php/newFriend.php?firstName=" + firstName + "&lastName=" + lastName + "&circleIDs=" + circleIDs + "&newCircle=" + newCircle);
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
					include ('php/newFriend.php');
					$result = getCircles();
					if ($result!=False) {
						echo "<label>Add to Existing Circle:<br /></label>";
						echo $result;
						echo "<br /><label class='indent'>OR</label><br /><br />";
					}
					?>
					Add to New Circle:<input type="text" id="circleName" /><br />
					<input type="button" onclick="formsubmit()" value="Add" />
				</fieldset>
			</form>
		</div>
		<input type="button" onclick="load('getuserinfo.php')" value="Cancel" />
	</body>
</html>