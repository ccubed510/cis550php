<html>
	<head>
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
		</script>
	</head>
	<title>Search Photos</title>
	<body>
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
		<div id="results"></div>
	</body>
</html>