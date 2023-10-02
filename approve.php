<?php
//including the database connection file
include("process/dbh.php");

//getting id of the data from url
$id = $_GET['id'];
$token = $_GET['token'];

//deleting the row from table
$result = mysqli_query($conn, "UPDATE `employee_leave`
SET `status` = 'Approved'
WHERE id = $id AND token = $token
AND (SELECT COUNT(*) FROM `employee_leave` WHERE id = $id AND token = $token) > 0;
");

//redirecting to the display page (index.php in our case)
header("Location:empleave.php");
?>

