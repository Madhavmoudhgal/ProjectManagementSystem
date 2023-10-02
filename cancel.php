<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//including the database connection file
include("process/dbh.php");

//getting id of the data from url
$id = $_GET['id'];
$token = $_GET['token'];

// Update the row in the table
$result = mysqli_query($conn, "UPDATE `employee_leave`
                              SET `status` = 'Cancelled', `cancel_date` = NOW()
                              WHERE `id` = $id AND `token` = '$token' AND `status` = 'Pending'
                              LIMIT 1");

// Check if the query was successful
if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit; // Stop further execution
}

// Redirecting to the display page (empleave.php in our case)
header("Location: empleave.php");
