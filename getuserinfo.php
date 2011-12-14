<html>
	<head>
	    <link rel="stylesheet" media="screen" type="text/css" href="css/home.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="/js/getuserinfo.js"></script>
		<style type="text/css">
			#container {
			    width: 1000px;
			    margin:0 auto;
			    position:relative;
			}
			
			#profile, #feed {
				padding:15px;
				position:relative;
				vertical-align:text-top;
			}
			
			#friendRec, #circle {
				position:relative;
				vertical-align:text-top;
			}
			
			#profile {
				width:40%;
			}
			
			#feed {
				width:60%;
			}
			
			.header {
				background: #6F7D94;
				padding: 0 10px 0 10px;
				height: 60px;
			}
			
			.profile {
				background: #A4B2CA;
			}
			
			.feed {
				background: #BAB0CC;
			}
			
			h1 {
				font-size: 24pt;
				color: #ffffff;
			}
			
			h2, h3{
				font-family: Palatino Linotype;
			}
		</style>
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
				<td colspan="2">Top Photos Here!</td>
			</tr>
			<tr>
				<td class="profile" id="profile">
					<h3>Profile:</h3>
					<? include ('php/userinfo.php'); ?>
				</td>
				<td class="feed" id="feed"><h3>Friend Updates Here!</h3>
					<? include ('php/newsFeed.php'); ?></td>
			</tr>
			<tr>
				<? include ('php/friendRec.php'); ?>
			</tr>
			<tr>
				<td class="circle" id="circle" colspan="2"><? include ('php/viewCircles.php'); ?><hr></td>
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