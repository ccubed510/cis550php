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
			if(response.trim() == 'error') {
				alert("Incorrect username or password");
			} else {
				load('getuserinfo.php');
				setCookie("username", user, 1);
			}
		}
	}

	xmlhttp.open("GET", "/php/login.php?userName=" + user + "&password=" + pwd, true);
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
		load('getuserinfo.php');

	}
	/*else {
	 alert("Please sign in");
	 }*/
}

function load(url) {
	location.href = url;
}