<html>
	<head>
		<script src="js/gen_validatorv4.js" type="text/javascript"></script>
		<link href="css/ratephoto.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript">
			function formsubmit() {
				if(document.ratePhoto.onsubmit()) {
					var rating = document.getElementById("rating").value;
					var photoID = document.getElementById("mainPhoto").getElementsByTagName("img")[0].id;
					xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if(xmlhttp.readyState == 4) {
							document.getElementById("info").innerHTML = xmlhttp.responseText;
						}
					}
					var query = "rating=" + rating + "&photoID=" + photoID;
					xmlhttp.open("GET", "/php/ratephotohelper.php?" + query, true);
					xmlhttp.send(null);
				}
			}

			function selectPhoto(object) {
				var url = object.src;
				var id = object.id;
				var img = "<img src='" + url + "' height=300 id = '" + id + "' class='centered'/>";
				var info = document.getElementById("mainPhoto").innerHTML = img;
				document.getElementById("mainPhoto").style.visibility = "visible";
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
		</script>
	</head>
	<title> Photo Rater </title>
	<body>
		<div class="container">
			<div class="header">
				<h1>Rate a photo, <? echo $_COOKIE["username"];?>!</h1>
				<br/>
			</div>
			<div class="content">
				<div id="info" ></div>
				<form name="ratePhoto" action="">
					<table>
						<tr>
							<td><label> Rating: </label></td>
							<td>
							<input type="int" id="rating" size="2"/>
							</td>
						</tr>
						<input type="button" onclick="formsubmit()" value="Rate Photo" />
					</table>
				</form>
				<table class="centered">
					<?php include('php/ratephotoselect.php')
					?>
				</table>
				<table>
				<div class="photo" id="mainPhoto"></div>
				<div class="photoInfo" id="mainPhotoInfo"></div>
				</table>
				<script type="text/javascript">
					var frmvalidator = new Validator("ratePhoto");
					frmvalidator.addValidation("rating", "num", "Please enter an integer");
					frmvalidator.addValidation("rating", "lt=11", "Please enter an integer between 1 and 10");
					frmvalidator.addValidation("rating", "gt=0", "Please enter an integer between 1 and 10");
					frmvalidator.addValidation("rating", "req", "Please enter a rating");

				</script>
			</div>
		</div>
	</body>
</html>