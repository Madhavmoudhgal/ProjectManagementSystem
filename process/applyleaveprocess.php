<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//including the database connection file
require_once('dbh.php');

//getting id of the data from url
$id = $_GET['id'];
$reason = $_POST['reason'];
$start = $_POST['start'];
$end = $_POST['end'];

// Prepare the SQL statement using a prepared statement
$sql = "INSERT INTO `employee_leave` (`id`, `token`, `start`, `end`, `reason`, `status`) VALUES (?, 0, ?, ?, ?, 'Pending')";

// Prepare and bind the statement
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'isss', $id, $start, $end, $reason);

// Execute the statement
$result = mysqli_stmt_execute($stmt);

// Check for errors in the SQL query execution
if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit; // Stop further execution
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redirecting to the display page (eloginwel.php in our case) with the updated ID
header("Location: ../eloginwel.php?id=$id");
