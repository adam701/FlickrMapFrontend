<?php
    $host = "localhost";
    $username = "local_agent";
    $password = "fmgftw!!";
    $dbName = "FMG";
    
    $conn = mysql_connect($host, $username, $password);
    if (!$conn) {
        echo "<p>Failed to connect" . mysql_error() . "</p>";
        exit();
    }
    
    $db = mysql_select_db($dbName, $conn);
    if (!$db) {
        echo "<p>Failed to select" . mysql_error() . "</p>";
        exit();
    }
?>
