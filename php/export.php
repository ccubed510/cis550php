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
	
	$result;
    
    $user = mysql_query("SELECT * FROM User");
	    			
	  $result .= "<?xml version=\"1.0\" encoding=\"UTF-8\">\n";
	  $result .= "<photodb xmlns=\"http://www.example.org/pennphoto\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.example.org/pennphoto CIS550Project.xsd\">
	  \n";
	  while($row = mysql_fetch_array($user)) {
	  	$temp= mysql_query("SELECT userName FROM Professor WHERE userName ='".$row['userName']."'");
		  
		if(mysql_fetch_array($temp)){
			$result .= "<professor>\n";
			$result .= "    <userID>".$row['userID']."</userID>\n";
			$result .= "    <firstName>".$row['first_name']."</firstName>\n";
			$result .= "    <lastName>".$row['last_name']."</lastName>\n";
			$result .= "    <email>".$row['email']."</email>\n";
			$result .= "    <birthdate>".$row['birth_date']."</birthdate>\n";
			$result .= "    <address>".$row['address']."</address>\n";
			$result .= "    <gender>".$row['gender']."</gender>\n";
			$result .= "    <userName>".$row['userName']."</userName>\n";
			$result .= "    <password>".$row['password']."</password>\n";
			
			$result .= "    <attended>";
			if($inst=mysql_fetch_array(mysql_query("SELECT institutionName FROM Attended WHERE userID ='".$row['userID']."'"))){
				$result .= $inst['institutionName'];
			}$result .= "</attended>\n";	
			
			
			$photoQ =mysql_query("SELECT * FROM Photo WHERE userID ='".$row['userID']."'");
			while($photo=mysql_fetch_array($photoQ)){
				$result .= "    <photo>\n";
					
				$result .= "        <photoID>"; 
				$result .= $photo['photoID'];
				$result .= "</photoID>\n";
				
				$result .= "        <url>"; 
				$result .= $photo['url'];
				$result .= "</url>\n";
				
				$ratingQ =mysql_query("SELECT * FROM Rating WHERE photoID ='".$photo['photoID']."'");
				while($rating=mysql_fetch_array($ratingQ)){
					$result .= "        <rating>\n";
					$result .= "            <userID>"; 
					$result .= $rating['userID'];
					$result .= "</userID>\n";
					
					$result .= "            <score>"; 
					$result .= $rating['rating'];
					$result .= "</score>\n";
					$result .= "        </rating>\n";
				}
				$tagQ =mysql_query("SELECT * FROM PhotoTag WHERE photoID ='".$photo['photoID']."'");
				while($tag=mysql_fetch_array($tagQ)){
					$result .= "        <tag>\n";
					$result .= "            <tagger>"; 
					$result .= $tag['tagger'];
					$result .= "</tagger>\n";
					
					$result .= "            <comment>"; 
					$result .= $tag['tag'];
					$result .= "</comment>\n";
					$result .= "        </tag>\n";
				}
				
				$result .= "        <visibility>\n";
				$visiQ =mysql_query("SELECT * FROM Visible WHERE photoID ='".$photo['photoID']."'");
				while($visi=mysql_fetch_array($visiQ)){
					
					$result .= "            <userID>"; 
					$result .= $visi['viewerID'];
					$result .= "</userID>\n";
					
				}
					$result .= "        </visibility>\n";			
				$result .= "    </photo>\n";
				
				
			}			
			
				$circleQ =mysql_query("SELECT * FROM Circle WHERE userID ='".$row['userID']."'");
				while($circle=mysql_fetch_array($circleQ)){
					$result .= "    <circle>\n";
					$result .= "        <name>";
					$result .= $circle['name'];
					$result .= "</name>\n";
					$result .= "        <circleID>";
					$result .= $circle['circleID'];
					$result .= "</circleID>\n";			
					$friendQ =mysql_query("SELECT * FROM Friend WHERE circleID ='".$circle['circleID']."'");
					while($friend=mysql_fetch_array($friendQ)){
						$result .= "        <containsFriend>";
						$result .= $friend['friendID'];
						$result .= "</containsFriend>\n";
					}
					$result .= "    </circle>\n";
				}
				$adviseQ =mysql_query("SELECT * FROM Professor WHERE userName ='".$row['userName']."'");
					while($advise=mysql_fetch_array($adviseQ)){
						$result .= "    <advisee>";
						$result .= $advise['advisee'];
						$result .= "</advisee>\n";	
					}
			$result .= "</professor>\n";
		}
		else{
			$result .= "<student>\n";
			$result .= "    <userID>".$row['userID']."</userID>\n";
			$result .= "    <firstName>".$row['first_name']."</firstName>\n";
			$result .= "    <lastName>".$row['last_name']."</lastName>\n";
			$result .= "    <email>".$row['email']."</email>\n";
			$result .= "    <birthdate>".$row['birth_date']."</birthdate>\n";
			$result .= "    <address>".$row['address']."</address>\n";
			$result .= "    <gender>".$row['gender']."</gender>\n";
			$result .= "    <userName>".$row['userName']."</userName>\n";
			$result .= "    <password>".$row['password']."</password>\n";
			
			$result .= "    <attended>";
			if($inst=mysql_fetch_array(mysql_query("SELECT institutionName FROM Attended WHERE userID ='".$row['userID']."'"))){
				$result .= $inst['institutionName'];
			}$result .= "</attended>\n";	
			
			
			$photoQ =mysql_query("SELECT * FROM Photo WHERE userID ='".$row['userID']."'");
			while($photo=mysql_fetch_array($photoQ)){
				$result .= "    <photo>\n";
					
				$result .= "        <photoID>"; 
				$result .= $photo['photoID'];
				$result .= "</photoID>\n";
				
				$result .= "        <url>"; 
				$result .= $photo['url'];
				$result .= "</url>\n";
				
				$ratingQ =mysql_query("SELECT * FROM Rating WHERE photoID ='".$photo['photoID']."'");
				while($rating=mysql_fetch_array($ratingQ)){
					$result .= "        <rating>\n";
					$result .= "            <userID>"; 
					$result .= $rating['userID'];
					$result .= "</userID>\n";
					
					$result .= "            <score>"; 
					$result .= $rating['rating'];
					$result .= "</score>\n";
					$result .= "        </rating>\n";
				}
				$tagQ =mysql_query("SELECT * FROM PhotoTag WHERE photoID ='".$photo['photoID']."'");
				while($tag=mysql_fetch_array($tagQ)){
					$result .= "        <tag>\n";
					$result .= "            <tagger>"; 
					$result .= $tag['tagger'];
					$result .= "</tagger>\n";
					
					$result .= "            <comment>"; 
					$result .= $tag['tag'];
					$result .= "</comment>\n";
					$result .= "        </tag>\n";
				}
				$result .= "        <visibility>\n";
				$visiQ =mysql_query("SELECT * FROM Visible WHERE photoID ='".$photo['photoID']."'");
				while($visi=mysql_fetch_array($visiQ)){				
					$result .= "            <userID>"; 
					$result .= $visi['viewerID'];
					$result .= "</userID>\n";			
				}
					$result .= "        </visibility>\n";
				$result .= "    </photo>\n";
				
				
			}			
			
				$circleQ =mysql_query("SELECT * FROM Circle WHERE userID ='".$row['userID']."'");
				while($circle=mysql_fetch_array($circleQ)){
					$result .= "    <circle>\n";
					$result .= "        <name>";
					$result .= $circle['name'];
					$result .= "</name>\n";
					$result .= "        <circleID>";
					$result .= $circle['circleID'];
					$result .= "</circleID>\n";			
					$friendQ =mysql_query("SELECT * FROM Friend WHERE circleID ='".$circle['circleID']."'");
					while($friend=mysql_fetch_array($friendQ)){
						$result .= "        <containsFriend>";
						$result .= $friend['friendID'];
						$result .= "</containsFriend>\n";
					}
					$result .= "    </circle>\n";
				}
				$adviseQ =mysql_query("SELECT * FROM Student WHERE userName ='".$row['userName']."'");
					$advise=mysql_fetch_array($adviseQ);
					$result .= "    <advisedBy>";
					$result .= $advise['advisor'];
					$result .= "</advisedBy>\n";	
									
			$result .= "</student>\n";
		}
      $result .=  $row['url'];
      }
	  $result .= "</photodb>";

 	/*$file = "output.xml";
	$handle = fopen($file, 'w');
	fwrite($handle, $result);
	fclose($handle);*/
	
	echo $result;
    
    mysql_close($link);
  ?>
