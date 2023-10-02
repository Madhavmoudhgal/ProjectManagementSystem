<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('dbh.php');

$tname = $_POST['tname'];
$eid = $_POST['eid'];
$subdate = $_POST['duedate'];

$sql = "INSERT INTO `task` (`eid`, `tname`, `duedate`, `status`, `mark`) VALUES ('$eid', '$tname', '$subdate', 'Due', 0)";

$result = mysqli_query($conn, $sql);

if ($result == 1) {
    header("Location: ../assignTask.php");
} else {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Failed to Assign')
        window.location.href='javascript:history.go(-1)';
        </SCRIPT>");
}
