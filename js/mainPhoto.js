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
	var img = "<img src='" + url + "' width=100% id = '" + id + "' class='centered'/>";
	document.getElementById("mainPhoto").innerHTML = img;
	document.getElementById("mainPhoto").style.visibility = "visible";
	document.getElementById("tagResults").innerHTML = "";
	getRating(id);
	createTagQuery(id);
	getTags(id);
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

function createTagQuery(id) {
	var tagForm = "<form name=\"tagForm\">" + "<table>" + "<tr>" + "<td><label> Tags: </label></td>" + "<td>" + "<input type=\"text\" id=\"tag\"/>" + "</td>" + "</tr>" + "<input type=\"button\" onclick=\"addTag(" + id + ")\" value=\"Add Tags\" />" + "</table>" + "</form>";
	document.getElementById("tagPhoto").innerHTML = tagForm;
}

function addTag(id) {
	var tags = document.getElementById("tag").value;
	xmlhttp1 = new XMLHttpRequest();
	xmlhttp1.onreadystatechange = function() {
		if(xmlhttp1.readyState == 4) {
			document.getElementById("tagResults").innerHTML = xmlhttp1.responseText;
			getTags(id);
		}
	}
	var query = "photoID=" + id + "&tags=" + tags;
	xmlhttp1.open("GET", "/php/addTags.php?" + query, true);
	xmlhttp1.send(null);
}

function getTags(id) {
	xmlhttpt = new XMLHttpRequest();
	xmlhttpt.onreadystatechange = function() {
		if(xmlhttpt.readyState == 4) {
			document.getElementById("tags").innerHTML = xmlhttpt.responseText;
		}
	}
	var query = "photoID=" + id;
	xmlhttpt.open("GET", "/php/getTags.php?" + query, true);
	xmlhttpt.send(null);
}