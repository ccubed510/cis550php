<?php require('./demo6.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Star Rating widget Demo6 Page</title>
	
	<!-- demo page css -->
	<link rel="stylesheet" type="text/css" media="screen" href="css/demos.css?b38"/>

	<style type="text/css">
		#container { position:relative; height:30px; }
		#container > * { position:absolute; height:30px; left:0; top:0; }

		#loader {display:none;padding-left:20px; background:url(css/crystal-arrows.gif) no-repeat center left;}
	</style>
	
	<!-- demo page js -->
	<script type="text/javascript" src="js/jquery.min.js?v=1.4.2"></script>
	<script type="text/javascript" src="js/jquery-ui.custom.min.js?v=1.8"></script>
	
	<!-- Star Rating widget stuff here... -->
	<script type="text/javascript" src="js/jquery.ui.stars.js?v=3.0.0b38"></script>
	<link rel="stylesheet" type="text/css" href="css/crystal-stars.css?b38"/>
	
	<script type="text/javascript">
		$(function(){
			$("#rat").children().not(":radio").hide();
			
			// Create stars
			$("#rat").stars({
				// starWidth: 28, // only needed in "split" mode
				cancelShow: false,
				callback: function(ui, type, value)
				{
					// Hide Stars while AJAX connection is active
					$("#rat").hide();
					$("#loader").show();
					// Send request to the server using POST method
					/* NOTE: 
						The same PHP script is used for the FORM submission when Javascript is not available.
						The only difference in script execution is the returned value. 
						For AJAX call we expect an JSON object to be returned. 
						The JSON object contains additional data we can use to update other elements on the page.
						To distinguish the AJAX request in PHP script, check if the $_SERVER['HTTP_X_REQUESTED_WITH'] header variable is set.
						(see: demo6.php)
					*/ 
					$.post("demo6.php", {rate: value}, function(db)
					{
						// Select stars to match "Average" value
						ui.select(Math.round(db.avg));
						
						// Update other text controls...
						$("#avg").text(db.avg);
						$("#votes").text(db.votes);
						
						// Show Stars
						$("#loader").hide();
						$("#rat").show();

					}, "json");
				}
			});
		});
	</script>

</head>

<body>


	<div class="pageDesc">
		<p>
			Another example of Star widget being replaced by <b>&quot;Average rating&quot;</b><br>
			Added alternate CSS file and some fancy transition effects.
		</p>
		<p>
			NOTE: The same PHP script is used to handle both AJAX and non-AJAX requests.<br>
			Check the source for more info and comments. You'll need a PHP server to run this demo.
		</p>
	</div>


	<div class="pageBody">
		<h4>Crystal (<a href="demo6a.php?b38" class="">before</a>|<a href="demo6b.php?b38" class="unlink">after1</a>|<a href="demo6c.php?b38" class="">after2</a>|<a href="demo6d.php?b38" class="">after3</a>)</h4>


		<div id="container">
			
			<form id="rat" action="" method="post">

				<?php foreach ($options as $id => $rb): ?>
					<input type="radio" name="rate" value="<?php echo $id ?>" title="<?php echo $rb['title'] ?>" <?php echo $rb['checked'].' '.$rb['disabled']  ?> />
				<?php endforeach; ?>

				<?php if (!$rb['disabled']): ?>
					<input type="submit" value="Rate it!" />
				<?php endif; ?>

			</form>

			<div id="loader"><div style="padding-top: 5px;">please wait...</div></div>

		</div>


		<?php $db = get_votes() ?>
		<div>
			Item Popularity: <span id="avg"><?php echo $db['avg'] ?></span>/<strong><?php echo count($options) ?></strong>
			(<span id="votes"><?php echo $db['votes'] ?></span> votes cast)
		</div>
	</div>


</body>
</html>
