<html>
	<head>
		<script src="js/gen_validatorv4.js" type="text/javascript"></script>
		<link href="css/ratephoto.css" type="text/css" rel="stylesheet" />
		<script src="js/mainPhoto.js" type="text/javascript"></script>
	</head>
	<title> Photo Rater </title>
	<body>
		<div class="container">
			<div class="header">
				<h1>Rate a photo, <? echo $_COOKIE["username"];?>!</h1>
				<br/>
			</div>
			<div class="content">
				<a href="getuserinfo.php">Home</a>
				<div id="info" ></div>
				<div id="gallery">
					<?php include('php/ratephotoselect.php')
					?>
				</div>
				
				<table width="600px" align="left" id="extra" class="hidden">
					<tr>
						<td width="20%" valign="top" bgcolor="6F7D94"><h2>Tags</h2><div id="tags"></div></td>
						<td ><div class="photo" id="mainPhoto"></div></td>
					</tr>
					<tr>
						<td ></td><td ><div id="mainPhotoInfo"></div></td>
					</tr>
					<tr>
						<td ></td><td ><div class="centered" id="photoTags"></div></td>
					</tr>
					<tr>
						<td ></td><td >
						<table>
							<td><div class="centered" id="tagPhoto"></div></td>
							<td>
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
							</form></td>
						</table></td>
					</tr>
					<tr>
						<td ></td><td ><div class="centered" id="tagResults"></div></td>
					</tr>
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