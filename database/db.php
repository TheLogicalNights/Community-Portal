<?php
    $servername = "febinaevents.com";
    $username = "febinaevents18_community_admin";
    $password = "Febina@123";
    $dbname = "febinaevents18_community";
    $port = 3306;

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) 
    {
        die("Error : " . mysqli_connect_error());
    }
?>