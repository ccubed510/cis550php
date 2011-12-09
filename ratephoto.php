<html>
	<head>
		<script src="js/gen_validatorv4.js" type="text/javascript"></script>
		<script type="text/javascript">
			function get_photo() {
				for(var i = 0; i < document.ratePhoto.photo.length; i++) {
					if(document.ratePhoto.photo[i].checked) {
						var radio = document.ratePhoto.photo[i].value;
						return radio;
					}
				}
			}

			function formsubmit() {
				if(document.ratePhoto.onsubmit()) {
					var rating = document.getElementById("rating").value;
					var photoID = get_photo();
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
		</script>
	</head>
	<title> Photo Rater </title>
	<body>
		Rate a photo, <? echo $_COOKIE["username"];?>.
		<br/>
		<div id="info"></div>		
		<form name="ratePhoto" action="">
			<table>
				<tr>
					<td><label> Rating: </label></td>
					<td>
					<input type="int" id="rating" size="2"/>
					</td>
				</tr>
				<?php include('php/ratephotoselect.php')
				?>

				<input type="button" onclick="formsubmit()" value="Rate Photo" />
			</table>
		</form>
		<script type="text/javascript">
			var frmvalidator = new Validator("ratePhoto");
			frmvalidator.addValidation("rating", "num", "Please enter an integer");
			frmvalidator.addValidation("rating", "lt=11", "Please enter an integer between 1 and 10");
			frmvalidator.addValidation("rating", "gt=0", "Please enter an integer between 1 and 10");
			frmvalidator.addValidation("rating", "req", "Please enter a rating");

		</script>
	</body>
</html>