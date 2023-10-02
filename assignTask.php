<?php

require_once('process/dbh.php');
$sql = "SELECT * FROM `task` ORDER BY subdate DESC";
$result = mysqli_query($conn, $sql);

?>

<html>

<head>
	<title>Task Status | Admin Panel | XYZ Corporation</title>
	<link rel="stylesheet" type="text/css" href="styleview.css">
</head>

<body>
	<header>
		<nav>
			<!-- Navigation links -->
			<h1>XYZ Corp.</h1>
			<ul id="navli">
				<li><a class="homeblack" href="aloginwel.php">HOME</a></li>
				<li><a class="homeblack" href="addemp.php">Add Employee</a></li>
				<li><a class="homeblack" href="viewemp.php">View Employee</a></li>
				<li><a class="homeblack" href="assign.php">Assign Task</a></li>
				<li><a class="homered" href="assignTask.php">Task Status</a></li>
				<li><a class="homeblack" href="salaryemp.php">Salary Table</a></li>
				<li><a class="homeblack" href="empleave.php">Employee Leave</a></li>
				<li><a class="homeblack" href="alogin.html">Log Out</a></li>
			</ul>
		</nav>
	</header>

	<div class="divider"></div>

	<table>
		<tr>
			<th align="center">Task ID</th>
			<th align="center">Emp. ID</th>
			<th align="center">Task Name</th>
			<th align="center">Due Date</th>
			<th align="center">Submission Date</th>
			<th align="center">Mark</th>
			<th align="center">Status</th>
			<th align="center">Option</th>
			<th align="center">Progress</th> <!-- New column for Progress -->
		</tr>

		<?php
		while ($task = mysqli_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>" . $task['tid'] . "</td>";
			echo "<td>" . $task['eid'] . "</td>";
			echo "<td>" . $task['tname'] . "</td>";
			echo "<td>" . $task['duedate'] . "</td>";
			echo "<td>" . $task['subdate'] . "</td>";
			echo "<td>" . $task['mark'] . "</td>";
			echo "<td>" . $task['status'] . "</td>";
			echo "<td><a href=\"mark.php?id=$task[eid]&tid=$task[tid]\">Mark</a></td>";

			// Fetch and display progress data for the task
			$taskId = $task['tid'];
			$progressSql = "SELECT * FROM task_progress WHERE task_id = $taskId";
			$progressResult = mysqli_query($conn, $progressSql);
			echo "<td>";
			while ($progress = mysqli_fetch_assoc($progressResult)) {
				echo "<p>" . $progress['progress_date'] . ": " . $progress['progress_description'] . "</p>";
			}
			echo "</td>";

			echo "</tr>";
		}
		?>
	</table>

</body>

</html>