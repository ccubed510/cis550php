  <?php
  echo"hi";
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
	
	$check = mysql_query("SELECT * FROM User WHERE User.userName = '".$user."'");
	if (!empty($check)){
		echo "Username already exists!";
	}
	else{	
	    $result = mysql_query("INSERT INTO User (first_name, last_name, email, birth_date, gender, address, password, userName) VALUES ('".$fname."', '".$lname."', '".$email."', '".$bdate."', '".$gender."', '".$address."', '".$password."', '".$user."')");	
		echo "Success, added " + $user + "to the database. Please return to <a href='home.php'> home. </a>";
	}
	
    mysql_close($link);
  ?>
