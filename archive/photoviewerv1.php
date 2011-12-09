<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Spacegallery</title>
    <link rel="stylesheet" media="screen" type="text/css" href="css/layout.css" />
    <link rel="stylesheet" media="screen" type="text/css" href="css/spacegallery.css" />
    <link rel="stylesheet" media="screen" type="text/css" href="css/custom.css" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/eye.js"></script>
    <script type="text/javascript" src="js/utils.js"></script>
    <script type="text/javascript" src="js/spacegallery.js"></script>
    <script type="text/javascript" src="js/layout.js"></script>
</head>
<body>
    <div class="wrapper">
        <h1>PennPhotos</h1>
        <a href="getuserinfo.php">Back to Profile</a>

        <ul class="navigationTabs">
            <li><a rel="Photos">My Photos</a></li>
        </ul>
        <div class="tabsContent">
            <div class="tab">
                <h2>Your Photos</h2>
				<div id="myGallery" class="spacegallery">
					<? include('php/getphotos.php'); ?>
				</div>
            </div>
        </div>
    </div>
</body>
</html>