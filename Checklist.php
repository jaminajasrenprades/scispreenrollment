 <?php 
   session_start();
   if (isset($_SESSION['username']) && $_SESSION['username'] == true) {
   } else {
   header("location: index.php");
   }
   function echoActiveClassIfRequestMatches($requestUri)
   {
   $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

   if ($current_file_name == $requestUri)
   echo 'class="active-menu"';
   }
            ?>
<!DOCTYPE html>
<html lang="en">
<head>
      <title>Curriculum Checklist</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/customcss.css">
      <link rel="stylesheet" href="css/checklist.css">
      <link rel="stylesheet" href="css/nav.css">
    
      <link rel="stylesheet" href="css/font-awesome.min.css"> 
    
      <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        
      <link rel="icon" href="images/logo.png">
</head>
<body>
<!--nav-->
<nav class="nav navbar-default navbar-fixed-top">
    <div class="container-fluid">
       <div class="col-md-12">
          <div class="navbar-header">
             <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mynavbar" aria-expanded="false" aria-controls="navbar">
             <span class="fa fa-bars"></span>
             </button>
                
         <div class="collapse navbar-collapse navbar-left borderXwidth" id="mynavbar">
            <ul class="nav navbar-nav">
                <li role="presentation"><a href="Pre-enrollment.php" style="font-size: 110%; font-family: Roboto">Home</a></li>
                <li role="presentation" class="active"><a href="Checklist.php" style="font-size: 110%; font-family: Roboto">Checklist</a></li>
                <li role="presentation"><a href="OfferedSubjects.php" style="font-size: 110%; font-family: Roboto">Offered Subjects</a></li>
                <li role="presentation"><a href="Petitions.php" style="font-size: 110%; font-family: Roboto">Petitions</a></li>
                <li role="presentation"><a href="Overload.php" style="font-size: 110%; font-family: Roboto">Overload</a></li>
                
         <p style = "position: absolute; right:7%; margin-top:.4%; font-size: 130%; font-family: Roboto"><b>WELCOME 
            <?php 
            echo  $_SESSION["username"];
            ?>!
             </b>
          </p>
          <p style = "position: absolute; right:6%; margin-top:3%; font-size: 110%;">Date: <?php echo date("F d, Y"); ?></p>
            <a href="logout.php" title="Logout" class="btn btn-default btn" onclick="return confirm('Are you sure you want to log out?');" style= "position: absolute; right:2%; top:.5%;"><span class="fa fa-sign-out" aria-hidden="true"></span></a>
          </ul>
          </div>
       </div>
      </div>
    </div>
</nav>
<!--/ nav-->
        
        <div class="container-fluid">
            <h3 style="margin-top:15%" align="center">First Year - First Semester</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'First' and subyear = '1'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'First' and subyear = '1'";
            $result = mysqli_query($con, $sql);
            ?>
            

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                       <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[1][]' id='cb1' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb1'>Done</label>
                               </center>
                               </form></td>"; 
                            echo "<td>
                               <form name action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[2][]' id='cb2' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label>
                               </center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
        <div class="container-fluid">
            <h3 style="margin-top:5%" align="center">First Year - Second Semester</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Second' and subyear = '1'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Second' and subyear = '1'";
            $result = mysqli_query($con, $sql);
            ?>
            

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                        <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[1][]' id='cb1' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb1'>Done</label>
                               </center>
                               </form></td>"; 
                            echo "<td>
                               <form name action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[2][]' id='cb2' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label>
                               </center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
        <div class="container-fluid">
            <h3 style="margin-top:5%" align="center">First Year - Short Term</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur'  and term = 'Short' AND subyear = '1'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Short' AND subyear = '1'";
            $result = mysqli_query($con, $sql);
            ?>
            

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                        <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[1][]' id='cb1' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb1'>Done</label>
                               </center>
                               </form></td>"; 
                            echo "<td>
                               <form name action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[2][]' id='cb2' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label>
                               </center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
        <div class="container-fluid">
            <h3 style="margin-top:5%" align="center">Second Year - First Semester</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT DISTINCT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'First' AND subyear = '2'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT DISTINCT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'First' AND subyear = '2'";
            $result = mysqli_query($con, $sql);
            ?>
            

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                      <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[1][]' id='cb1' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb1'>Done</label>
                               </center>
                               </form></td>"; 
                            echo "<td>
                               <form name action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[2][]' id='cb2' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label>
                               </center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
         <div class="container-fluid">
            <h3 style="margin-top:5%" align="center">Second Year - Second Semester</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Second' AND subyear = '2'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Second' AND subyear = '2'";
            $result = mysqli_query($con, $sql);
            ?>
            

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                       <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[1][]' id='cb1' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb1'>Done</label>
                               </center>
                               </form></td>"; 
                            echo "<td>
                               <form name action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[2][]' id='cb2' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label>
                               </center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
        <div class="container-fluid">
            <h3 style="margin-top:5%" align="center">Second Year - Short Term</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Short' AND subyear = '2'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Short' AND subyear = '2'";
            $result = mysqli_query($con, $sql);
            ?>
            

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                       <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[1][]' id='cb1' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb1'>Done</label>
                               </center>
                               </form></td>"; 
                            echo "<td>
                               <form name action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[2][]' id='cb2' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label>
                               </center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
        <div class="container-fluid">
            <h3 style="margin-top:5%" align="center">Third Year - First Semester</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'First' AND subyear = '3'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'First' AND subyear = '3'";
            $result = mysqli_query($con, $sql);
            ?>
            

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                       <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                             echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[1][]' id='cb1' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb1'>Done</label>
                               </center>
                               </form></td>"; 
                            echo "<td>
                               <form name action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[2][]' id='cb2' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label>
                               </center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
        <div class="container-fluid">
            <h3 style="margin-top:5%" align="center">Third Year - Second Semester</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT DISTINCT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Second' AND subyear = '3'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT DISTINCT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Second' AND subyear = '3'";
            $result = mysqli_query($con, $sql);
            ?>
            

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                       <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[1][]' id='cb1' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb1'>Done</label>
                               </center>
                               </form></td>"; 
                            echo "<td>
                               <form name action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[2][]' id='cb2' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label>
                               </center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
        <div class="container-fluid">
            <h3 style="margin-top:5%" align="center">Third Year - Short Term</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Short' AND subyear = '3'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Short' AND subyear = '3'";
            $result = mysqli_query($con, $sql);
            ?>
            

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                       <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[1][]' id='cb1' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb1'>Done</label>
                               </center>
                               </form></td>"; 
                            echo "<td>
                               <form name action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[2][]' id='cb2' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label>
                               </center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
        <div class="container-fluid">
            <h3 style="margin-top:5%" align="center">Fourth Year - First Semester</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'First' AND subyear = '4'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'First' AND subyear = '4'";
            $result = mysqli_query($con, $sql);
            ?>
            

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                       <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[1][]' id='cb1' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb1'>Done</label>
                               </center>
                               </form></td>"; 
                            echo "<td>
                               <form name action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[2][]' id='cb2' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label>
                               </center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
        <div class="container-fluid">
            <h3 style="margin-top:5%" align="center">Fourth Year - Second Semester</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT DISTINCT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Second' AND subyear = '4'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT DISTINCT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = 'Second' AND subyear = '4'";
            $result = mysqli_query($con, $sql);
            ?>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                       <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[1][]' id='cb1' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb1'>Done</label>
                               </center>
                               </form></td>"; 
                            echo "<td>
                               <form name action='Updated_Checklist.php' method='POST'>
                               <center>
                               <input type='checkbox' name='cb[2][]' id='cb2' onclick='addClassCheck(this)' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label>
                               </center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
        <div class="container-fluid">
            <h3 style="margin-top:5%" align="center">Electives</h3>
            <?php
            $id= $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $s = "select curriculum from students where id_number='$id'";
            $sl = mysqli_query($con, $s);
            while ($rows = mysqli_fetch_array($sl)){
                $cur = $rows['curriculum'];
            }
            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = '0' AND subyear = '0'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT subjects.coursenumber as 'Course Number', subjects.destitle as 'Descriptive Title', subjects.units as 'Units' FROM checklist INNER JOIN subjects ON subjects.type = checklist.type AND subjects.coursenumber = checklist.coursenumber NATURAL JOIN curriculum_checklist NATURAL JOIN students where id_number='$id' and curriculum = '$cur' and term = '0' AND subyear = '0'";
            $result = mysqli_query($con, $sql);
            ?>
            

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <table class="table" id="myTable">
                        <tr>
                           <th>Course Number</th>
                           <th>Descriptive Title</th>
                           <th>Units</th>
                           <th></th>
                           <th></th>
                        </tr>

                     <?php
                        $con = mysqli_connect('localhost', 'root', '');
                        mysqli_select_db($con, 'pre_enrollment');
                        $id= $_SESSION['username'];
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['Course Number'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                             
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center><input type='checkbox' name='cb' id='cb1' value='$courseno'/>
                               <label for='cb1'>Done</label></center>
                               </form></td>"; 
                            echo "<td>
                               <form action='Updated_Checklist.php' method='POST'>
                               <center><input type='checkbox' name='cb' id='cb2' value='$courseno'/>
                               <label for='cb2'>Currently Enrolled</label></center>
                               </form></td>";
                            echo "</tr>";
                           }
                        ?>
                        
                      </table>
                  </div>
              </div>
        </div>
        
              <br>
            <div class="form-group">
                <div class="container-fluid">
                    <div class="row">
                        <label class="col-sm-3 control-label">&nbsp;</label>
                        <div class="col-sm-8">
                           <a href="Updated_Checklist.php" class="btn btn-sm btn-primary" style="margin-left:80%";>Update Checklist</a>
                           <a href="Checklist.php" class="btn btn-sm btn-warning">Cancel</a>
                           <?php
                            if(isset($_POST['submit'])){
                            if(!empty($_POST['checkbox'])){
                                foreach($_POST['checkbox'] as $selected){
                                    echo $selected."<br>";
                                }
                            }
                            }
                            ?>
                       </div>
                    </div>
                </div>
            </div>
    
        <script>
            $('.selectme input:checkbox').click(function() {
            $('.selectme input:checkbox').not(this).prop('checked', false);
        });   
        </script>
    
        <script>
            function myFunction(){
                document.getElementById("myForm").reset();
            }
            
           function filterData() {
                var input, filter, table, tr, td, tdtwo, tdthree, i;
                input = document.getElementById("input");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                tdtwo = tr[i].getElementsByTagName("td")[1];
                tdthree = tr[i].getElementsByTagName("td")[2];
                
                console.log(td);
                
                    if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } 
                        else if (tdtwo.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        }
                        else if (tdthree.innerHTML.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        }else {
                            tr[i].style.display = "none";
                        }
                    } 
                }
            } 
        </script>
    
        <script>   
            function addClassCheck(element){
                if(element.checked){
                    element.classList.add("marked");
                }else{
                    element.classList.remove("marked");
                }
                if(document.getElementsByClassName("marked").length>1){
                  alert("Please select only one check box");
                    element.checked=false;
                    element.classList.remove("marked");
                }
            }
        </script>
   
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>