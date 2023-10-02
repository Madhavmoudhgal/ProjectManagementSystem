
<?php
require_once('process/dbh.php');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$tid = isset($_GET['tid']) ? $_GET['tid'] : '';

$sql = "SELECT task.tid, task.eid, task.tname, task.duedate, task.subdate, task.mark, rank.points, employee.firstName, employee.lastName, salary.base, salary.bonus, salary.total
        FROM task
        INNER JOIN rank ON task.eid = rank.eid
        INNER JOIN employee ON employee.id = task.eid
        INNER JOIN salary ON salary.id = task.eid
        WHERE task.eid = '$id' AND task.tid = '$tid'";

$result = mysqli_query($conn, $sql);

if (isset($_POST['update'])) {
    // Retrieve form data
    $eid = mysqli_real_escape_string($conn, $_POST['eid']);
    $tid = mysqli_real_escape_string($conn, $_POST['tid']);
    $mark = mysqli_real_escape_string($conn, $_POST['mark']);
    $points = mysqli_real_escape_string($conn, $_POST['points']);
    $base = mysqli_real_escape_string($conn, $_POST['base']);
    $bonus = mysqli_real_escape_string($conn, $_POST['bonus']);
    $total = mysqli_real_escape_string($conn, $_POST['total']);

    // Update the task mark
    $updateTaskQuery = "UPDATE task SET mark = '$mark' WHERE eid = '$eid' AND tid = '$tid'";
    mysqli_query($conn, $updateTaskQuery);

    // Update the rank points
    $upPoint = $points + $mark;
    $updateRankQuery = "UPDATE rank SET points = '$upPoint' WHERE eid = '$eid'";
    mysqli_query($conn, $updateRankQuery);

    // Update the salary bonus and total
    $upBonus = $bonus + $mark;
    $upSalary = $base + ($upBonus * $base) / 100;
    $updateSalaryQuery = "UPDATE salary SET bonus = '$upBonus', total = '$upSalary' WHERE id = '$eid'";
    mysqli_query($conn, $updateSalaryQuery);

    // Redirect to assignproject.php after updating
    header("Location: assignTask.php");
    exit();
}

?>




<html>
<head>
  <title>Task Mark | XYZ Corporation</title>
  <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
</head>
<body>
  <header>
    <nav>
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
  

    <!-- <form id = "registration" action="edit.php" method="POST"> -->
  <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Task Mark</h2>
                    <form id = "registration" action="mark.php" method="POST">

                        <?php
                        if($result && $row = mysqli_fetch_assoc($result)){
                          $tname = $row['tname'];
                          $duedate = $row['duedate'];
                          $subdate = $row['subdate'];
                          $firstName = $row['firstName'];
                          $lastName = $row['lastName'];
                          $mark = $row['mark'];
                          $points = $row['points'];
                          $base = $row['base'];
                          $bonus = $row['bonus'];
                          $total = $row['total'];
                        }
                        ?>

                        <div class="input-group">
                          <p>Task Name</p>
                            <input class="input--style-1" type="text" name="tname" value="<?php echo $tname; ?>" readonly>
                        </div>
                       
                        
                        <div class="input-group">
                          <p>Employee Name</p>
                            <input class="input--style-1" type="text" name="firstName" value="<?php echo $firstName . ' ' . $lastName; ?>" readonly>
                        </div>

                       


                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                  <p>Due Date</p>
                                     <input class="input--style-1" type="text" name="duedate" value="<?php echo $duedate; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                  <p>Submission Date</p>
                                    <input class="input--style-1" type="text" name="subdate" value="<?php echo $subdate; ?>" readonly>
                                </div>
                            </div>
                        </div>


                        <div class="input-group">
                          <p>Assign Mark</p>
                            <input class="input--style-1" type="text" name="mark" value="<?php echo $mark; ?>">
                        </div>

                       
                        <input type="hidden" name="eid" value="<?php echo $id; ?>" required="required">
                        <input type="hidden" name="tid" value="<?php echo $tid; ?>" required="required">
                        <input type="hidden" name="points" value="<?php echo $points; ?>" required="required">
                        <input type="hidden" name="base" value="<?php echo $base; ?>" required="required">
                        <input type="hidden" name="bonus" value="<?php echo $bonus; ?>" required="required">
                        <input type="hidden" name="total" value="<?php echo $total; ?>" required="required">
                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green" type="submit" name="update">Assign Mark</button>
                        </div>
                        
                    </form>
                    <br>
                    
                </div>
            </div>
        </div>
    </div>


</body>
</html>