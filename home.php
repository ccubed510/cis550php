<?php   session_start();?>
<html>
	<head>
		<script type="text/javascript">
			function logout(){
				setCookie("username", "", -1);
				history.go(0);
			}
			function formsubmit() {
				var user = document.getElementById("userName").value;
				var pwd = document.getElementById("password").value;
				if(user.length == 0 || pwd.length == 0) {
					alert("you must enter a user / password.");
					return;
				}
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4) {
						var response = xmlhttp.responseText;
						if(response === '111'){
							alert("Incorrect username or password");
						}
						else{
							document.getElementById("user").innerHTML = xmlhttp.responseText;
							document.getElementById("loginform").style.visibility = "hidden";
							setCookie("username", user, 1);
						}
					}
				}

				xmlhttp.open("GET", "login.php?userName=" + user + "&password=" + pwd, true);
				xmlhttp.send(null);
			}

			function setCookie(c_name, value, exdays) {
				var exdate = new Date();
				exdate.setDate(exdate.getDate() + exdays);
				var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
				document.cookie = c_name + "=" + c_value;
			}

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

			function checkCookie() {
				var username = getCookie("username");
				if(username != null && username != "" && username.length != 0) {
					alert("Welcome again " + username);
					document.getElementById("loginform").style.visibility = "hidden";
					
				} else {
					alert("Please sign in");
				}
			}
		</script>
	</head>
	<title> CIS 550 Project </title>
	<body>
		This is our awesome project! :)
		<br/> 
		<input type="button" onclick="logout()" value="Logout" />
		<form method="LINK" action="getuserinfo.php">
			<input type="submit" value="CLICK ME!" />
		</form>
		<div id="loginform" >
			<form name="login">
				<fieldset>
					<label> Username: </label>
					<input type="text" id="userName"/>
					<label> Password: </label>
					<input type="text" id="password"/>
					<input type="button" onclick="formsubmit()" value="Login" />
				</fieldset>
			</form>
		</div>
		<div id="user">
			Person information will be listed here.
		</div>
		<script type="text/javascript"> checkCookie(); </script>
	</body>
</html>