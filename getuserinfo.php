<html>
	<head>
	    <link rel="stylesheet" media="screen" type="text/css" href="css/home.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="/js/getuserinfo.js"></script>
	</head>
	
	<title>Profile</title>
	
	<body>
		<table id="container" width="1000px">
			<tr>
				<td colspan="2" class="header">
					<table width="100%">
						<tr>
							<td width="50%"><h1>Welcome, <script type="text/javascript">document.write(getCookie("username")); </script>!</h1></td>
							<td width="50%" align="right"><input type="button" onclick="logout()" value="Logout" /></td>
						</tr>
					</table>
				</td>
			<tr>
				<td width="100%" colspan="2" align="center"><? include ('php/getTopPhotos.php'); ?></td>
			</tr>
			<tr>
				<td class="panel" id="profile">
					<h3>Profile:</h3>
					<? include ('php/userinfo.php'); ?>
				</td>
				<td class="panel" id="feed"><h3>News Feed:</h3>
					<? include ('php/newsFeed.php'); ?></td>
			</tr>
			<tr>
				<? include ('php/friendRec.php'); ?>
			</tr>
			<tr>
				<td class="panel" id="circle" colspan="2"><? include ('php/viewCircles.php'); ?></td>
			</tr>
			<tr>
				<td colspan="2">
					<div class="optionsPanel">
						<a href="ratephoto.php">View/Rate Photos</a> | 
						<a href="uploadPhoto.html">Upload a photo!</a> | 
						<a href="addFriend.php">Add a new friend!</a> | 
						<a href="addFriend.php">Add an existing friend to a new circle!</a> | 
						<a href="addFriend.php">Create a new circle!</a> | 
						<a href="friendshipBrowser.php">Friendship Browser!</a> | 
						<a href="php/exportFile.php">Export Data!</a>
					</div>
				<p class="optionsToggle"><b>Additional Options</b></p></td>
			</tr>
		</table>
	
	</body>
		
</html>