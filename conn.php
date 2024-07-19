<?php

$connection = new mysqli("localhost", "root", "", "course");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} else {
    // echo "Connected successfully";
}
