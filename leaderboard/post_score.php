<?php
	
	include("mysql_conn.php");
	
	
	// First add to the overall table
	$query = "	SELECT *
				FROM Scores
				WHERE Username = \"{$_POST["Username"]}\";";
	$result = mysql_query($query);
	echo "$query\n";
	if (!$result) {
		echo "ERROR!!";
		exit();
	} else if (mysql_num_rows($result) == 0) {
		$query = "	INSERT INTO Scores(Username, Score, Steps)
					VALUES (\"{$_POST["Username"]}\", \"{$_POST["Score"]}\", 1);";
		echo "$query\n";
	} else if (mysql_num_rows($result) == 1) {
		$original_score = 0;
		while ($row = mysql_fetch_assoc($result)) {
	        $original_score = $row["Score"];
			break;
	    }
		$query = "	UPDATE Scores
					SET Score = Score + \"{$_POST["Score"]}\",
						Steps = Steps + 1
					WHERE Username = \"{$_POST["Username"]}\";";
		echo "$query\n";
	} else {
		echo "ERROR!!";
		exit();
	}
	
	$result = mysql_query($query);

		
	// Then add to the score-by-picture table
    $query = "	SELECT *
              	FROM ScoresByPicture
				WHERE Username = \"{$_POST["Username"]}\"
				  AND PictureId = \"{$_POST["PictureId"]}\";";
	$result = mysql_query($query);
	
	if (!$result) {
		echo "ERROR!!";
		exit();
	} else if (mysql_num_rows($result) == 0) {
		$query = "	INSERT INTO ScoresByPicture(PictureId, Username, Score, Attempts)
					VALUES (\"{$_POST["PictureId"]}\", \"{$_POST["Username"]}\", \"{$_POST["Score"]}\", 1);";
		echo "$query\n";
	} else if (mysql_num_rows($result) == 1) {
		$original_score = 0;
		while ($row = mysql_fetch_assoc($result)) {
	        $original_score = $row["Score"];
			break;
	    }
		if ($original_score < $_POST["Score"]) {			// If there is an improvement!!
			$query = "	UPDATE ScoresByPicture
						SET Score = \"{$_POST["Score"]}\",
							Attempts = Attempts + 1
						WHERE PictureId = \"{$_POST["PictureId"]}\"
						  AND Username = \"{$_POST["Username"]}\";";
			echo "$query\n";
		} else {											// Otherwise just set attempts=Attempts+1
			$query = "	UPDATE ScoresByPicture
						SET Attempts = Attempts + 1
						WHERE PictureId = \"{$_POST["PictureId"]}\"
						  AND Username = \"{$_POST["Username"]}\";";	
			echo "$query\n";
		}
	} else {
		echo "ERROR!!";
		exit();
	}
	
	$result = mysql_query($query);
	echo "SUCCESS!!";
	exit();


?>