<?php
    $servername = "localhost";
    $username = "root";
    $password = "swapnil123";
    $dbname = "community";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Error : " . mysqli_connect_error());
      }
?>