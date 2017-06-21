
<!DOCTYPE html>
<html lang="en">
    <head>
      <title>Pre-Enrollment</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/customcss.css">
    </head>
    <body>
        <ul class="nav nav-tabs">
            <li role="presemtatoion"><a href="FromEnrollment.php">Pre-Enrollment</a></li>
            <li role="presentation" class="active"><a href="search_start2.php">Students</a></li>
            <li role="presentation"><a href="Subjects.php">Subjects</a></li>
            <a href="logout.php" class="btn btn-default square-btn-adjust" onclick="return confirm('Are you sure you want to log out?');" style= "position: absolute; right:2%; top:.5%;">Logout</a>
        
        </ul>
        <br>
        <br>
        <div class="container">
            <div class="row">
                    <div class="col-md-3">
                        <form method="post" action="test2.php">
                        <div class="input-group">
                            <span class="input-group-btn">  
                                <input type="text" placeholder="ID NUMBER" class="form-control" name="idnumber">
                                <button class="btn btn-default" name="submit" type="submit" value="Submit">Enter</button>
                                <button class="btn btn-default" type="button" onclick="resetIdNumber()" value="reset">Reset</button>                                   
                            </span>
                        </div>
                        </form>
                        <?php
                        $idnumber = "";
                        $idnumberErr = "";
                        if (isset($_POST['submit'])) {
                            if (empty($_POST['idnumber'])) {
                            $idnumberErr = "Enter Id Number";
                            echo $idnumberErr;
                            } else {
                            $idnumber = check_input($_POST['idnumber']);

                                if (!preg_match("/^[1-9][0-9]{0,7}$/", $idnumber)) {
                                $idnumberErr = "Only numbers are allowed as input";
                                echo $idnumberErr;
                                }
                            }
                        }

                        function check_input($data) {
                            $data = trim($data);
                            $data = stripcslashes($data);
                            $data = htmlspecialchars($data);
                            return $data;
                        }
                        ?>
                    </div>
                    <div class="col-md-2 col-md-offset-2">
                        <select style="width: 120px;">
                            <option value="All">BSIT</option>
                            <option value="First">BSCS</option>
                            <option value="Second">BSIS</option>
                            <option value="Short">BSMATH</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <select style="width: 120px;">
                            <option value="All">First Year</option>
                            <option value="First">Second Year</option>
                            <option value="Second">Third Year</option>
                            <option value="Short">Fourth Year</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-md-offset-1">
                        <button class="btn btn-primary" type="button">Apply</button>
                        <button class="btn btn-default" type="button" onclick="myFunction()" value="reset">Reset</button>
                    </div>
            </div>
            <br>
            <?php
            $con = mysqli_connect('localhost', 'root', '');
            mysql_set_charset("UTF8");
            mysqli_select_db($con, 'pre_enrollment');
            header('Content-type: text/html; charset=utf-8');
            $con->set_charset("utf8");
            $results_per_page = 40;
                    $sql = "SELECT id_number AS 'ID NUMBER', last_name AS 'LAST NAME', first_name AS 'FIRST NAME', course AS 'COURSE', year AS 'YEAR', 
                    IF(id_number IN (SELECT id_number FROM pre_enroll), 'PRE-ENROLLED', 'NOT PRE-ENROLLED') AS 'STATUS' 
                    FROM pre_enrollment.students";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;
            $sql = "SELECT id_number AS 'ID NUMBER', last_name AS 'LAST NAME', first_name AS 'FIRST NAME', course AS 'COURSE', year AS 'YEAR', 
                    IF(id_number IN (SELECT id_number FROM pre_enroll), 'Pre-Enrolled', 'Not Pre-Enrolled') AS 'STATUS' 
                    FROM pre_enrollment.students ORDER BY 2 LIMIT $this_page_result, $results_per_page";
            $result = mysqli_query($con, $sql);
            ?>
            
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <tr>
                            <th>ID Number</th>
                            <th>Last name</th>
                            <th>First name</th>
                            <th>Course and Year</th>
                            <th>Status</th>
                            <th></th>
                        </tr>

                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>".$row['ID NUMBER']."</td>";   
                            echo "<td>".$row['LAST NAME']."</td>";
                            echo "<td>".$row['FIRST NAME']."</td>";
                            echo "<td>".$row['COURSE'].' '.$row['YEAR']."</td>";
                            echo "<td>".$row['STATUS']."</td>";
                            echo "
                            <td>
                              <a href='SubjectList.php'
                                <button class='btn btn-primary btn-sm'>
                                    <span class='glyphicon glyphicon-user' aria-hidden='true'></span>
                                </button>
                              </a>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>

                    <?php
                    for($page=1; $page<=$number_of_pages; $page++){
                        echo '<a href="Students.php?page=' . $page . '">' . $page . '</a> ';
                    }
                    ?>
                    <br>
                </div> 
            </div>
        </div>
        
        <script>
            function myFunction(){
                document.getElementById("myForm").reset();
            }
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>