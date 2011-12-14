<?php
$db_username = "yannie";
$db_password = "abcd";
$db_host = "fling.seas.upenn.edu";
$db_name = "yannie";

$link = mysql_connect($db_host, $db_username, $db_password);
if (!$link) {
	die('Could not connect: ' . mysql_error());
}

mysql_select_db($db_name, $link);
$user = $_GET["userName"];
$password = $_GET["password"];
$fname = $_GET["firstName"];
$lname = $_GET["lastName"];
$bdate = $_GET["birthDate"];
$gender = $_GET["gender"];
$email = $_GET["email"];
$address = $_GET["address"];
if(!empty($_GET["advisedBy"])){
	$advisedBy = $_GET["advisedBy"];
} else {
	$advisedBy = NULL;
}
$institution = $_GET["institution"];
$interesta = $_GET["interests"];
$interests = explode(",", $interesta);

$hashedpw = hash('md5',$password);

$check = mysql_query("SELECT * FROM User WHERE User.userName = '" . $user . "'");
$rowcheck = mysql_fetch_row($check);
echo $rowcheck;
if ($rowcheck != NULL) {
	echo "Username already exists!";
} else {
	if ($advisedBy != NULL) {
		$findProf = mysql_query("SELECT * FROM Professor WHERE userName = '" . $advisedBy . "'");
		$findProfRow = mysql_fetch_row($findProf);
		if ($findProfRow != NULL) {
			$result = mysql_query("INSERT INTO User (first_name, last_name, email, birth_date, gender, address, password, userName) VALUES ('" . $fname . "', '" . $lname . "', '" . $email . "', '" . $bdate . "', '" . $gender . "', '" . $address . "', '" . $hashedpw . "', '" . $user . "')");
			mysql_query("INSERT INTO Student (userName, advisor) VALUES ('" . $user . "', '" . $advisedBy . "')");
			mysql_query("INSERT INTO Professor (userName, advisee) VALUES ('" . $advisedBy . "', '" . $user . "')");
			$uquery = mysql_query("SELECT userID FROM User WHERE User.userName = '" . $user . "'");
			$uarr = mysql_fetch_array($uquery);
			$userID = $uarr['userID'];
			mysql_query("INSERT INTO Attended (userID, institutionName) VALUES ('" . $userID . "', '" . $institution . "')");
			foreach ($interests as $int) {
				mysql_query("INSERT INTO Interests (userID, interest) VALUES ('" . $userID . "', '" . $int . "')");
			}
			echo "Success, added " . $user . " to the database. Please return to <a href='home.html'> home to login </a>";

		} else {
			echo "Professor does not exist. Please try again." . $advisedBy;
		}
	} else {
		$result = mysql_query("INSERT INTO User (first_name, last_name, email, birth_date, gender, address, password, userName) VALUES ('" . $fname . "', '" . $lname . "', '" . $email . "', '" . $bdate . "', '" . $gender . "', '" . $address . "', '" . $hashedpw . "', '" . $user . "')");
		mysql_query("INSERT INTO Professor (userName) VALUES ('" . $user . "')");
		$uquery = mysql_query("SELECT userID FROM User WHERE User.userName = '" . $user . "'");
		$uarr = mysql_fetch_array($uquery);
		$userID = $uarr['userID'];
		mysql_query("INSERT INTO Attended (userID, institutionName) VALUES ('" . $userID . "', '" . $institution . "')");
		foreach ($interests as $int) {
			mysql_query("INSERT INTO Interests (userID, interest) VALUES ('" . $userID . "', '" . $int . "')");
		}
		echo "Success, added " . $user . " to the database. Please return to <a href='home.html'> home to login </a>";

	}

}

mysql_close($link);
?>
