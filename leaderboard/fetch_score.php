<?php
    include("mysql_conn.php");
    $query = "SELECT *
              FROM Scores;";
              //WHERE Username = \"{$_POST["username"]}\";";
    
    $result = mysql_query($query);
	$scores = array();
    while ($row = mysql_fetch_assoc($result)) {
        $scores[ $row["Username"] ] = array("steps" => $row["Steps"], "score" => $row["Score"]);
    }
	echo json_encode($scores);

?>