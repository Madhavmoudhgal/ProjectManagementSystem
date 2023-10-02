<?php

require_once ('process/dbh.php');
//$id = (isset($_GET['id']) ? $_GET['id'] : '');
$tid = $_GET['tid'];
$id = $_GET['id'];
$date = date('Y-m-d');
//echo "$date";
$sql = "UPDATE `Task` SET `subdate`='$date',`status`='Submitted' WHERE tid = '$tid';";
$result = mysqli_query($conn , $sql);
header("Location: empTask.php?id=$id");
?>