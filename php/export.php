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
    
    $user = mysql_query("SELECT * FROM User");
	    			
	  echo "<?xml version=\"1.0\" encoding=\"UTF-8\">\n";
	  echo "<photodb xmlns=\"http://www.example.org/pennphoto\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.example.org/pennphoto CIS550Project.xsd\">
	  \n";
	  while($row = mysql_fetch_array($user)) {
	  	$temp= mysql_query("SELECT userName FROM Professor WHERE userName ='".$row['userName']."'");
		  
		if(mysql_fetch_array($temp)){
			echo "<professor>\n";
			echo "    <userID>".$row['userID']."</userID>\n";
			echo "    <firstName>".$row['first_name']."</firstName>\n";
			echo "    <lastName>".$row['last_name']."</lastName>\n";
			echo "    <email>".$row['email']."</email>\n";
			echo "    <birthdate>".$row['birth_date']."</birthdate>\n";
			echo "    <address>".$row['address']."</address>\n";
			echo "    <gender>".$row['gender']."</gender>\n";
			echo "    <userName>".$row['userName']."</userName>\n";
			echo "    <password>".$row['password']."</password>\n";
			
			echo "    <attended>";
			if($inst=mysql_fetch_array(mysql_query("SELECT institutionName FROM Attended WHERE userID ='".$row['userID']."'"))){				
				echo $inst['institutionName'];			
			}	
			
			echo "</attended>\n";
			
			$interestQ =mysql_query("SELECT * FROM Interests WHERE userID ='".$row['userID']."'");
			while($interest=mysql_fetch_array($interestQ)){
				echo "    <interest>";
				echo $interest['interest'];
				echo "</interest>\n";
			}
			
			
			$photoQ =mysql_query("SELECT * FROM Photo WHERE userID ='".$row['userID']."'");
			while($photo=mysql_fetch_array($photoQ)){
				echo "    <photo>\n";				
				echo "        <photoID>"; 
				echo $photo['photoID'];
				echo "</photoID>\n";
				
				echo "        <url>"; 
				echo $photo['url'];
				echo "</url>\n";
				
				$ratingQ =mysql_query("SELECT * FROM Rating WHERE photoID ='".$photo['photoID']."'");
				while($rating=mysql_fetch_array($ratingQ)){
					echo "        <rating>\n";
					echo "            <userID>"; 
					echo $rating['userID'];
					echo "</userID>\n";
					
					echo "            <score>"; 
					echo $rating['rating'];
					echo "</score>\n";
					echo "        </rating>\n";
				}
				$tagQ =mysql_query("SELECT * FROM PhotoTag WHERE photoID ='".$photo['photoID']."'");
				while($tag=mysql_fetch_array($tagQ)){
					echo "        <tag>\n";
					echo "            <tagger>"; 
					echo $tag['tagger'];
					echo "</tagger>\n";
					
					echo "            <comment>"; 
					echo $tag['tag'];
					echo "</comment>\n";
					echo "        </tag>\n";
				}
				
				echo "        <visibility>";
				echo $photo['Visibility'];
				echo "</visibility>\n";
				echo "        <visibleTo>\n";
				$visiQ =mysql_query("SELECT * FROM Visible WHERE photoID ='".$photo['photoID']."'");
				while($visi=mysql_fetch_array($visiQ)){
					
					echo "            <userID>"; 
					echo $visi['viewerID'];
					echo "</userID>\n";
					
				}
					echo "        </visibleTo>\n";			
				echo "    </photo>\n";
				
				
			}			
			
				$circleQ =mysql_query("SELECT * FROM Circle WHERE userID ='".$row['userID']."'");
				while($circle=mysql_fetch_array($circleQ)){
					echo "    <circle>\n";
					echo "        <name>";
					echo $circle['name'];
					echo "</name>\n";
					echo "        <circleID>";
					echo $circle['circleID'];
					echo "</circleID>\n";			
					$friendQ =mysql_query("SELECT * FROM Friend WHERE circleID ='".$circle['circleID']."'");
					while($friend=mysql_fetch_array($friendQ)){
						echo "        <containsFriend>";
						echo $friend['friendID'];
						echo "</containsFriend>\n";
					}
					echo "    </circle>\n";
				}
				$adviseQ =mysql_query("SELECT * FROM Professor WHERE userName ='".$row['userName']."'");
					while($advise=mysql_fetch_array($adviseQ)){
						echo "    <advisee>";
						echo $advise['advisee'];
						echo "</advisee>\n";	
					}
			echo "</professor>\n";
		}
		else{
			echo "<student>\n";
			echo "    <userID>".$row['userID']."</userID>\n";
			echo "    <firstName>".$row['first_name']."</firstName>\n";
			echo "    <lastName>".$row['last_name']."</lastName>\n";
			echo "    <email>".$row['email']."</email>\n";
			echo "    <birthdate>".$row['birth_date']."</birthdate>\n";
			echo "    <address>".$row['address']."</address>\n";
			echo "    <gender>".$row['gender']."</gender>\n";
			echo "    <userName>".$row['userName']."</userName>\n";
			echo "    <password>".$row['password']."</password>\n";
			
			echo "    <attended>";
			if($inst=mysql_fetch_array(mysql_query("SELECT institutionName FROM Attended WHERE userID ='".$row['userID']."'"))){
				echo $inst['institutionName'];
			}echo "</attended>\n";	
			
			$interestQ =mysql_query("SELECT * FROM Interests WHERE userID ='".$row['userID']."'");
			while($interest=mysql_fetch_array($interestQ)){
				echo "    <interest>";
				echo $interest['interest'];
				echo "</interest>\n";
			}
			
			$photoQ =mysql_query("SELECT * FROM Photo WHERE userID ='".$row['userID']."'");
			while($photo=mysql_fetch_array($photoQ)){
				echo "    <photo>\n";
					
				echo "        <photoID>"; 
				echo $photo['photoID'];
				echo "</photoID>\n";
				
				echo "        <url>"; 
				echo $photo['url'];
				echo "</url>\n";
				
				$ratingQ =mysql_query("SELECT * FROM Rating WHERE photoID ='".$photo['photoID']."'");
				while($rating=mysql_fetch_array($ratingQ)){
					echo "        <rating>\n";
					echo "            <userID>"; 
					echo $rating['userID'];
					echo "</userID>\n";
					
					echo "            <score>"; 
					echo $rating['rating'];
					echo "</score>\n";
					echo "        </rating>\n";
				}
				$tagQ =mysql_query("SELECT * FROM PhotoTag WHERE photoID ='".$photo['photoID']."'");
				while($tag=mysql_fetch_array($tagQ)){
					echo "        <tag>\n";
					echo "            <tagger>"; 
					echo $tag['tagger'];
					echo "</tagger>\n";
					
					echo "            <comment>"; 
					echo $tag['tag'];
					echo "</comment>\n";
					echo "        </tag>\n";
				}
				
				echo "        <visibility>";
				echo $photo['Visibility'];
				echo "</visibility>\n";
					
				echo "        <visibleTo>\n";
				$visiQ =mysql_query("SELECT * FROM Visible WHERE photoID ='".$photo['photoID']."'");
				while($visi=mysql_fetch_array($visiQ)){				
					echo "            <userID>"; 
					echo $visi['viewerID'];
					echo "</userID>\n";			
				}
					echo "        </visibleTo>\n";
					
				echo "    </photo>\n";
				
				
			}			
			
				$circleQ =mysql_query("SELECT * FROM Circle WHERE userID ='".$row['userID']."'");
				while($circle=mysql_fetch_array($circleQ)){
					echo "    <circle>\n";
					echo "        <name>";
					echo $circle['name'];
					echo "</name>\n";
					echo "        <circleID>";
					echo $circle['circleID'];
					echo "</circleID>\n";			
					$friendQ =mysql_query("SELECT * FROM Friend WHERE circleID ='".$circle['circleID']."'");
					while($friend=mysql_fetch_array($friendQ)){
						echo "        <containsFriend>";
						echo $friend['friendID'];
						echo "</containsFriend>\n";
					}
					echo "    </circle>\n";
				}
				$adviseQ =mysql_query("SELECT * FROM Student WHERE userName ='".$row['userName']."'");
					$advise=mysql_fetch_array($adviseQ);
					echo "    <advisedBy>";
					echo $advise['advisor'];
					echo "</advisedBy>\n";	
									
			echo "</student>\n";
		}
      echo  $row['url'];
      }
	  echo "</photodb>";

 
    
    mysql_close($link);
  ?>
