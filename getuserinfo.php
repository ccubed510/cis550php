<html>
	<head>
	    <link rel="stylesheet" media="screen" type="text/css" href="css/home.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="/js/getuserinfo.js"></script>
	</head>
	
	<title>Profile</title>
	
	<body>
		<table width="1000px">
			<tr>
				<td><h1>Welcome, <script type="text/javascript">
					document.write(getCookie("username")); </script>!</h1></td>
				<td style="text-align:right;"><input type="button" onclick="logout()" value="Logout" /></td>
			<tr>
				<td colspan="2">
				<a href="ratephoto.php">View/Rate Photos</p></td>
			<tr>
				<td style="background-color:#39B7CD;width:50px;text-align:top;">
					<h3>Profile:</h2>
					<? include ('php/userinfo.php'); ?>
				</td>
				<td style="background-color:#82CFFD;height:200px;width:500px;text-align:top;">Friend Updates Here!<br>
					<? include ('php/newsFeed.php'); ?></td>
			</tr>
			<tr>
				<? include ('php/friendRec.php'); ?>
			</tr>
			<tr>
				<td colspan="2"><div class="optionsPanel">
					<table>
						<tr>
							<td><a href="uploadPhoto.html">Upload a photo!</a></td>
							<td><a href="addFriend.php">Add a new friend!</a></td>
							<td><a href="addFriend.php">Add an existing friend to a new circle!</a></td>
						</tr>
					</table>
				</div>
				<p class="optionsToggle">Additional Options</p></td>
			</tr>
		</table>
	
	</body>
		
</html>