<?php

$host = 'localhost';
$username = 'root';
$password = '';

$con = mysqli_connect($host, $username, $password);

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$dbname = 'attsystem';

$query = "CREATE DATABASE IF NOT EXISTS $dbname";

if (mysqli_query($con, $query)) {
    echo "Database created successfully or already exists.\n";
} else {
    die("Error creating database: " . mysqli_error($con));
}

$db_selected = mysqli_select_db($con, $dbname);

if (!$db_selected) {
    die("Cannot select database: " . mysqli_error($con));
}

$sql = file_get_contents('database\attsystem.sql');

if (mysqli_multi_query($con, $sql)) {
    echo "Database initialized successfully.";
} else {
    echo "Error executing SQL: " . mysqli_error($con);
}

mysqli_close($con);
