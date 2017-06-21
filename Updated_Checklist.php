<?php<!DOCTYPE html>
<html lang="en">
    <head>
      <title>Updated Checklist</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/customcss.css">
    </head>
    <body>
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="Pre-enrollment.php">Home</a></li>
            <li role="presentation" class="active"><a href="Checklist.php">Checklist</a></li>
            <li role="presentation"><a href="OfferedSubjects.php">Offered Subjects</a></li>
            <li role="presentation"><a href="Petitions.php">Petitions</a></li>
            <li role="presentation"><a href="Overload.php">Overload</a></li>
            <a href="logout.php" class="btn btn-default square-btn-adjust" onclick="return confirm('Are you sure you want to log out?');" style= "position: absolute; right:2%; top:.5%;">Logout</a>
        
        </ul>
        <br>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id= "input" onkeyup="filterData()" placeholder="Search for...">
                        <span class="input-group-btn">
                            <!--<form action="newPhp.php" method="POST">-->
                                <button class="btn btn-default" type="submit" value="Enter" name="Enter">Enter</button>   
                            <!--</form>-->
                            <button class="btn btn-default" type="button" value="reset" onclick="myFunction()"><a href = "Checklist.php">Reset</a></button>
                        </span>
                    </div>
                </div>

                <div class="col-md-4 col-md-offset-1">
                    <form method="post" action="#">
                        <select style="width: 120px;" name ="sort">
                            <option value="All">Overall Term</option>
                            <option value="First">First Term</option>
                            <option value="Second">Second Term</option>
                            <option value="Short">Short Term</option>
                        </select>
                     </form>
                </div>
                
                <div class="col-md-2">
                    <input class="btn btn-default" type="submit" name="submit" value="Apply">
                    <button class="btn btn-default" type="button" onclick="myFunction()" value="reset">Reset</button>
                </div>
            </div>
            <br>
            
            <?php
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $sql = "SELECT checklist.coursenumber as 'CourseNo.', checklist.destitle as 'Descriptive Title', checklist.units as 'Units'
                    FROM checklist INNER JOIN curriculum_checklist ON checklist.checklistID = curriculum_checklist.checklistID";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT enr_stat.coursenumber as 'CourseNo.', subjects.destitle as 'Descriptive Title', enr_stat.term as 'Term', enr_stat.number_of_students as 'Number of Students' 
                    FROM enr_stat INNER JOIN subjects ON enr_stat.coursenumber = subjects.coursenumber WHERE enr_stat.number_of_students > '0' LIMIT $this_page_result, $results_per_page";
            if(isset($_POST['submit'])){
                $selected_val = $_POST['sort'];
                echo $selected_val;
                $sql = "SELECT checklist.coursenumber as 'CourseNo.', checklist.destitle as 'Descriptive Title', checklist.units as 'Units'
                    FROM checklist INNER JOIN curriculum_checklist ON checklist.checklistID = curriculum_checklist.checklistID and enr_stat.term = '$selected_val' LIMIT $this_page_result, $results_per_page";
            } else {
            $sql = "SELECT checklist.coursenumber as 'CourseNo.', checklist.destitle as 'Descriptive Title', checklist.units as 'Units'
                    FROM checklist INNER JOIN curriculum_checklist ON checklist.checklistID = curriculum_checklist.checklistID LIMIT $this_page_result, $results_per_page";
            }
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
                          </tr>

                          <?php
                            while ($row = mysqli_fetch_array($result)) {
                            include_once 'classes/subjectsWithStudents.php';
                            $courseno = $row['CourseNo.'];
                            $desctitle = $row['Descriptive Title'];
                            $units =  $row['Units'];
                                
                            echo "<td>".$courseno."</td>"; 
                            echo "<td>".$desctitle."</td>";
                            echo "<td>".$units."</td>";
                            echo "<td>
                                 <form action='updated_checklist.php' method='POST'>
                                 <span><input type='checkbox' name='checkbox'></span>
                                 </form>
                                 </td>"; 
                            echo "</tr>";
                          }
                          ?>
                      </table>
                  </div>
              </div>
                 <br>
                <div class="col-md-10 col-md-offset-10">
                 <input type='submit' name='Submit' value='Submit'>
                </div>
            
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>