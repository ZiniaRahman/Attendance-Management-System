<?php

ob_start();
session_start();

if ($_SESSION['name'] != 'oasis') {
    header('location: login.php');
}
?>
<?php include('connect.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Online Attendance Management System 1.0</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="styles.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>

    <header>

        <h1>Online Attendance Management System 1.0</h1>
        <div class="navbar">
            <a href="index.php">Home</a>
            <a href="students.php">Students</a>
            <a href="teachers.php">Faculties</a>
            <a href="attendance.php">Attendance</a>
            <a href="report.php">Report</a>
            <a href="../logout.php">Logout</a>

        </div>

    </header>

    <center>

        <div class="row">

            <div class="content">
                <h3>Individual Report</h3>

                <form method="post" action="">

                    <label>Select Subject</label>
                    <select name="whichcourse">
                        <option value="algo">Analysis of Algorithms</option>
                        <option value="algolab">Analysis of Algorithms Lab</option>
                        <option value="dbms">Database Management System</option>
                        <option value="dbmslab">Database Management System Lab</option>
                        <option value="weblab">Web Programming Lab</option>
                        <option value="os">Operating System</option>
                        <option value="oslab">Operating System Lab</option>
                        <option value="obm">Object Based Modeling</option>
                        <option value="softcomp">Soft Computing</option>
                    </select>

                    <p> </p>
                    <label>Student Reg. No.</label>
                    <input type="text" name="sr_id">
                    <input type="submit" name="sr_btn" value="Go!">

                </form>

                <h3>Mass Report</h3>

                <form method="post" action="">

                    <label>Select Subject</label>
                    <select name="course">
                        <option value="algo">Analysis of Algorithms</option>
                        <option value="algolab">Analysis of Algorithms Lab</option>
                        <option value="dbms">Database Management System</option>
                        <option value="dbmslab">Database Management System Lab</option>
                        <option value="weblab">Web Programming Lab</option>
                        <option value="os">Operating System</option>
                        <option value="oslab">Operating System Lab</option>
                        <option value="obm">Object Based Modeling</option>
                        <option value="softcomp">Soft Computing</option>
                    </select>
                    <p> </p>
                    <label>Batch</label>
                    <input type="text" name="batch">
                    <input type="submit" name="sr_batch" value="Go!">
                </form>

                <br>

                <br>

                <?php

                if (isset($_POST['sr_batch'])) {

                    $batch = $_POST['batch'];
                    $course = $_POST['course'];
                    $con = mysqli_connect('localhost', 'root', '') or die('Cannot connect to server');
                    $conn = mysqli_select_db($con, 'attsystem') or die('Cannot found database');
                    $all_query = mysqli_query($con, "SELECT students.st_id, students.st_name, students.st_dept, students.st_batch, COUNT(attendance.stat_id) AS total_classes, SUM(CASE WHEN attendance.st_status = 'Present' THEN 1 ELSE 0 END) AS attended_classes FROM students LEFT JOIN attendance ON students.st_id = attendance.stat_id WHERE students.st_batch = '$batch' AND attendance.course = '$course' GROUP BY students.st_id");
                ?>

                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th scope="col">Reg. No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Batch</th>
                                <th scope="col">Total Classes</th>
                                <th scope="col">Attended Classes</th>
                                <th scope="col">Attendance Percentage</th>
                            </tr>
                        </thead>

                        <?php
                        $i = 0;
                        while ($data = mysqli_fetch_array($all_query)) {
                            $i++;
                            $attendance_percentage = ($data['attended_classes'] / $data['total_classes']) * 100;
                        ?>
                            <tbody>
                                <tr>
                                    <td><?php echo $data['st_id']; ?></td>
                                    <td><?php echo $data['st_name']; ?></td>
                                    <td><?php echo $data['st_dept']; ?></td>
                                    <td><?php echo $data['st_batch']; ?></td>
                                    <td><?php echo $data['total_classes']; ?></td>
                                    <td><?php echo $data['attended_classes']; ?></td>
                                    <td><?php echo round($attendance_percentage, 2); ?>%</td>
                                </tr>
                            </tbody>

                        <?php
                        }
                        ?>

                    </table>

                <?php
                }
                ?>

            </div>

        </div>

    </center>

</body>

</html>
