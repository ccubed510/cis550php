<html>
	<head>
		<title>Photo Viewer</title>
		<style type="text/css">
			body {
				margin: 50px 0px;
				padding: 0px;
				background-color: #000000;
				color: #ffffff;
			}
			#content {
				width: 620px;
				margin: 0px auto;
			}
			#desc {
				margin: 10px;
				float: left;
				font-family: Arial, sans-serif;
				font-size: 12px;
			}
		</style>
		<!-- include CSS always before including js -->
		<link type="text/css" rel="stylesheet" href="skins/tn3/tn3.css">
		</link>
		<!-- include jQuery library -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<!-- include tn3 plugin -->
		<script type="text/javascript" src="js/jquery.tn3lite.min.js"></script>
		<!--  initialize the TN3 when the DOM is ready -->
		<script type="text/javascript">
			$(document).ready(function() {
				//Thumbnailer.config.shaderOpacity = 1;
				var tn1 = $('.mygallery').tn3({
					skinDir : "skins",
					imageClick : "fullscreen",
					image : {
						maxZoom : 1.5,
						crop : true,
						clickEvent : "dblclick",
						transitions : [{
							type : "blinds"
						}, {
							type : "grid"
						}, {
							type : "grid",
							duration : 460,
							easing : "easeInQuad",
							gridX : 1,
							gridY : 8,
							// flat, diagonal, circle, random
							sort : "random",
							sortReverse : false,
							diagonalStart : "bl",
							// fade, scale
							method : "scale",
							partDuration : 360,
							partEasing : "easeOutSine",
							partDirection : "left"
						}]
					}
				});
			});

		</script>
	</head>
	<body>
		<div id="content">
			<div class="mygallery">
				<div class="tn3 album">
					<h4>Fixed Dimensions</h4>
					<div class="tn3 description">
						Images with fixed dimensions
					</div>
					<div class="tn3 thumb">
						images/35x35/1.jpg
					</div>
					<ol>
						<li>
							<h4>Hohensalzburg Castle</h4>
							<div class="tn3 description">
								Salzburg, Austria
							</div>
							<a href="images/620x378/1.jpg"> <img src="images/35x35/1.jpg" /> </a>
						</li>
						<li>
							<h4>Isolated sandy cove</h4>
							<div class="tn3 description">
								Zakynthos island, Greece
							</div>
							<a href="images/620x378/2.jpg"> <img src="images/35x35/2.jpg" /> </a>
						</li>
						<? include ('php/getphotos.php'); ?>
					</ol>
				</div>
			</div>
			<div id="desc">
				<p>
					Note that 'blinds' and 'grid' transition types work only if the images are of same size and not scaled. If you choose album with large images and because 'crop' options is turned on, you will see default transition('slide') instead of 'blinds' and 'grid' types.
				</p>
			</div>
		</div>
	</body>
</html>
