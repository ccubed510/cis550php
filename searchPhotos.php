<html>
	<head>
		<link href="css/ratephoto.css" type="text/css" rel="stylesheet"/>
		<script type="text/javascript">
			function formsubmit() {

				var tags = document.getElementById("tags").value;
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

				xmlhttp.open("GET", "/php/searchAlgo.php?tags=" + tags, true);
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
		</script>
	</head>
	<title>Search Photos</title>
	<body>
		<div class="container">
			<div class="header">
				<h1>Search your visible photos</h1>
			</div>
			<div class="content">
				<div id="searchform" >
					Please enter the photo tags you would like to search (leave spaces between the tags)
					<form name="login">
						<fieldset>
							<label> Photo tags: </label>
							<input type="text" id="tags"/>
							<input type="button" onclick="formsubmit()" value="Search" />
						</fieldset>
					</form>
				</div>
				<div class="centered">
					<table id = "results"></table>
					<div class="photoInfo" id="mainPhotoInfo"></div>
				</div>	
			</div>
		</div>
	</body>
</html>