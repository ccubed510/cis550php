<html>
	<head>
		<link href="css/ratephoto.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript">
			function formsubmit() {
				var user = getCookie("username");
				if(user == null) {
					alert("Please sign in");
					return;
				}
				var tags = document.getElementById("tags").value;
				var friends = document.getElementById("friends").value;
				var circles = document.getElementById("circles").value;
				verifyFriends(friends);
				verifyCircles(circles);
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4) {
						var response = xmlhttp.responseText;
						if(response.trim() == 'error') {
							alert("Sorry, no photos found");
						} else {
							document.getElementById("results").innerHTML = xmlhttp.responseText;
						}
					}
				}

				xmlhttp.open("GET", "/php/searchAlgo.php?tags=" + tags + "&friends=" + friends + "&circles=" + circles, true);
				xmlhttp.send(null);
			}

			function selectPhoto(object) {
				var id = object.id;
				getRating(id);
			}

			function getRating(id) {
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4) {
						document.getElementById("mainPhotoInfo").innerHTML = xmlhttp.responseText;
					}
				}
				var query = "photoID=" + id;
				xmlhttp.open("GET", "/php/getRating.php?" + query, true);
				xmlhttp.send(null);
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
			
			function showCircles() {
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4) {
						if (document.getElementById("circlesInfo").innerHTML == "") {
							document.getElementById("circlesInfo").innerHTML = "<br />" + xmlhttp.responseText;
						}
					}
				}
				xmlhttp.open("GET", "/php/getCircles.php", true);
				xmlhttp.send(null);
			}

			function verifyFriends(friends) {

			}

			function verifyCircles(circles) {

			}
		</script>
	</head>
	<title>Search Photos</title>
	<body>
		<script type="text/javascript">
			function load(url) {
				location.href = url;
			}	
		</script>
		<div class="container">
			<div class="header">
				<div>
					<table width="100%"><tr>
						<td><h1>Search Your Visible Photos</h1></td>
						<td align="right"><input type="button" id="back" onclick="load('ratephoto.php')" value="Back to Photos" />
							<input type="button" id="home" onclick="load('getuserinfo.php')" value="Home" /></td>
					</tr></table>
				</div>
			</div>
			<div class="content">
				<div id="searchform" >
					<div id="logout">
					</div>
				
					Please enter the photo tags you would like to search (leave spaces between the tags)
					<form name="login">
						<fieldset>
							<label> Photo tags: </label>
							<input type="text" id="tags"/>
							<br/>
							<label> Filter by Circles (IDs): </label>
							<input type="text" id="circles" onclick="showCircles()"/>
							<label id="circlesInfo"></label>
							<br/>
							<label> Filter by Friends (User Name): </label>
							<input type="text" id="friends" />
							<input type="button" onclick="formsubmit()" value="Search" />
						</fieldset>
					</form>
				</div>
				<div class="centered">
					<div class="gallery" id = "results"></table>
					<div class="photoInfo" id="mainPhotoInfo"></div>
				</div>
			</div>
		</div>
	</body>
</html>