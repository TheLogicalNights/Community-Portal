<?php
    $servername = "localhost";
    $username = "root";
    $password = "swapnil123";
    $dbname = "membersportal";
    $port = 3306;

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) 
    {
        die("Error : " . mysqli_connect_error());
    }
?>