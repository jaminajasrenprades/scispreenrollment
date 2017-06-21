<!DOCTYPE html>
<?php 
    require 'classes/UserAccount.php';
    
?>
<html lang="en">
    <head>
      <title>Overload</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/customcss.css">
      <link rel="stylesheet" href="css/nav.css">
      <link rel="stylesheet" href="css/font-awesome.min.css">
        
      <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        
      <link rel="icon" href="images/logo.png">
    </head>
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
                <li role="presentation"><a href="Checklist.php" style="font-size: 110%; font-family: Roboto">Checklist</a></li>
                <li role="presentation"><a href="OfferedSubjects.php" style="font-size: 110%; font-family: Roboto">Offered Subjects</a></li>
                <li role="presentation"><a href="Petitions.php" style="font-size: 110%; font-family: Roboto">Petitions</a></li>
                <li role="presentation" class="active"><a href="Overload.php" style="font-size: 110%; font-family: Roboto">Overload</a></li>
                
                <p style = "position: absolute; right:7%; margin-top:.4%; font-size: 130%; font-family: Roboto"><b> WELCOME <?php 
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

                    $user = $_SESSION["userAccount"];
                    $user_id = $user->getUserId();

                    echo  $_SESSION["username"];
                    ?>!
                    </b>
                </p>
                <a href="logout.php" title="Logout" class="btn btn-default btn" onclick="return confirm('Are you sure you want to log out?');" style= "position: absolute; right:2%; top:.5%;"><span class="fa fa-sign-out" aria-hidden="true"></span></a>
            </ul>
            </div>
            </div>
         </div>
     </div>
        <p style = "position: absolute; right:6%; margin-top:5%; font-size: 110%;">Date: <?php echo date("F d, Y"); ?></p>
</nav> 
    
    <body>
        <div class="container-fluid">
            <div class="row"> 
                <div class="col-md-4 col-md-offset-3" style="margin-top:10%">
                    <form method="post" action="#">
                        <select style="width: 120px; padding: 5px; top:1%;" name = "sort">
                        <option value="All"><a href="#"> Overall Term </a></option>
                        <option value="First"><a href="#">First Term</a></option>
                        <option value="Second"><a href="#">Second Term</a></option>
                        <option value="Short"><a href="#">Short Term</a></option>
                    </select>   
                    <div class="col-md-2" style="margin-top:10%">
                        <input class = 'btn btn-default' type='submit' name = 'submit' value='Apply'></input>
                        <button class="btn btn-default" type="button" value="reset"><a href = "Pre-enrollment.php">Reset</a></button>
                    </div>
                    </form>
                </div>
        
        <div class="row">
                <?php
                $totalunits = "";
                 
                $last_name  = "";
                $first_name = "";
                $course     = "";
                $year       = "";
                
                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                  if( isset($_POST['input']) ){
                    include 'dbcon.php';

                    $Idnumber = check_input($_POST['input']);
                    $stmt = $pdo->query("SELECT * FROM students WHERE id_number = '$idnumber'");
                    $countQuery = $stmt->rowCount();
                    if ($countQuery == 0){
                        echo "Student does not Exists!";
                    } else {
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $idnumber = $Idnumber;
                    $last_name  = ($result[0]['last_name']);
                    $first_name = ($result[0]['first_name']);
                    $course     = ($result[0]['course']);
                    $year       = ($result[0]['year']);
                    
                    include_once 'classes/studentsWithSubjects.php';
                    $studs = new studentsWithSubjects($idnumber, $first_name, $last_name, $course, $year);
                    $_SESSION['students']=$studs;
                    $_SESSION['id_number']= $idnumber;
                   // include 'dbcon.php';
                    $q = $pdo->query("SELECT sum(units) AS stotal FROM subjects natural join pre_enroll WHERE id_number = '$id'");
                    $c = $q->rowCount();
                    if($c != 0){
                    $cs = $q->fetchAll(PDO::FETCH_ASSOC);
                    $totalunits = ($cs[0]['stotal']);
                    }
                    echo "
                    <div class='col-md-6'>
                    <p>Name:  ";
                    print_r($last_name);
                    echo ", ";
                    print_r($first_name);
                    echo"</p>";
                    echo "<p> ID Number: ".$idnumber."</p>";                    
                    echo"</div>";

                    echo "
                    <div class='col-md-6'>
                    <p>Course and Year:  ";
                    print_r($course);
                    echo"-";
                    print_r($year);
                    echo"</p>
                    </div>";
                    }
                  }
                } else {
                  echo "
                  <div class='col-md-6'>
                  <p>Name: </p>
                  </div>
                  <div class='col-md-6'>
                  <p>Course and Year: </p>
                  </div>";
                  }           
                  ?>
            </div>
            
            <br>
            <div class="row">
                <div class="col-md-6">
                    <form id="Subjects" action="#">
                    <div class="input-group">
                        <input type="text" id="myInput" onkeyup="filterData()" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" value="reset"><a href = "Pre-enrollment.php">Reset</a></button>
                        </span>
                    </div>
                    </form>
                </div>
                <div class="col-md-3">
                    <p>Subjects Overload</p>
                </div>
                <div class="col-md-2">
                    <p>Total Units: <b>
                        <?php echo $totalunits;?></b></p>
                </div>
            </div>
            <br>

            <?php
            if(isset($_POST['submit'])){
                $selected_val = $_POST['sort'];  // Storing Selected Value In Variable
              //  echo "You have selected:" .$selected_val;  // Displaying Selected Value
                include 'dbcon.php';
                $stmt = $pdo->query("SELECT DISTINCT subjects.coursenumber as 'Course No.', subjects.destitle as 'Descriptive Title', checklist.term AS 'Term', subjects.units as 'Units' FROM subjects INNER JOIN checklist ON subjects.coursenumber = checklist.coursenumber where term = '$selected_val'");
            
            } else {
                //$te=$selected_val;
            include 'dbcon.php';
            $stmt = $pdo->query("SELECT DISTINCT subjects.coursenumber AS 'Course No.', subjects.destitle AS 'Descriptive Title', checklist.term AS 'Term', subjects.units AS 'Units' FROM subjects INNER JOIN checklist ON subjects.coursenumber = checklist.coursenumber INNER JOIN enr_stat ON enr_stat.coursenumber = checklist.coursenumber WHERE enr_stat.number_of_students > '0'");
            
            }
            ?>

            <div class="row">
              <div class="col-md-6" id="table-wrapper">
                  <div id="table-scroll">
                      <table class="table" id="myTable">
                          <tr>
                              <th>Course Number</th>
                              <th>Descriptive Title</th>
                              <th>Term</th>
                              <th>Units</th>
                              <th></th>
                          </tr>

                          <?php
                          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($results as $row) {
                                  echo "<tr>";
                                  echo "<td>".$row['Course No.']."</td>";
                                  echo "<td>".$row['Descriptive Title']."</td>";
                                  echo "<td>".$row['Term']."</td>";
                                  echo "<td>".$row['Units']."</td>";
                                  echo "<input type='hidden' name='CourseNo' value='".$row['Course No.']."'/>";
                                  echo "<input type='hidden' name='descrp' value='".$row['Descriptive Title']."'/>";
                                  echo "<input type='hidden' name='descrp' value='".$row['Term']."'/>";
                                  echo "<input type='hidden' name='units' value='".$row['Units']."'/>";
                                  echo "
                                  <td>
                                      <button class='btn btn-default btn-sm' onclick='addDataToLocalStorage(this)'>
                                      <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                                      </button>
                                  </td>";
                                  echo "</tr>";
                          }
                          ?>
                      </table>
                  </div>
              </div>

            <div class="col-md-6 col" id="table-wrapper">
                  <div id="table-scroll">
                      <table class="table" id="copy">
        						    <tr>
        						      <th>Course Number</th>
        							    <th>Descriptive Title</th>
        							    <th>Term</th>
        							    <th>Units</th>
                                        <th></th>
        						    </tr>
                           <?php 
                              $con =  new mysqli('localhost', 'root', '', 'pre_enrollment') or die ('Cannot connect to database');
                              //$Idnumber = check_input($_POST['input']);
                              if (isset($_SESSION['id_number']) && $_SESSION['students'] == true){
                                 $studes = $_SESSION['students'];
                                 $idnum = $_SESSION['id_number'];
                                 $quer = "select * from pre_enroll natural join students natural join subjects where id_number = '$id'";
                                 $res = mysqli_query($con, $quer);
                                 $countRes = mysqli_num_rows($res);
                                                             
                              if ($countRes != 0){
                                while ($rows = $res-> fetch_assoc()){
                                $course = $rows['coursenumber'];
                                $desctitle = $rows['destitle'];
                                $tr = $rows['term'];
                                $units = $rows['units'];
                                                                
                                echo "<tr>";
                                echo "<td><center>".$course."</center></td>";
                                echo "<td>".$desctitle."</center></td>";
                                echo "<td><center>".$term."</center></td>";
                                echo "<td><center>".$units."</center></td>";
                                echo "<td>
                                <button onclick=clearData(this);deleteRow(this); class='btn btn-default btn-sm'>
                                <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                </button>
                                </td>"; //here delete rows at the database
                                echo "</tr>";
                                }
                                }
                                else if ($countRes == 0){
                                }
                                }
                            ?>
  	                  </table>
                  </div>
              </div>
        </div>
                
            <?php
            $id = $_SESSION['username'];
            $con = mysqli_connect('localhost', 'root', '');
            mysqli_select_db($con, 'pre_enrollment');

            $results_per_page = 40;
            
            $sql = "SELECT enr_stat.coursenumber as 'CourseNo.', subjects.destitle as 'Descriptive Title', enr_stat.term as 'Term'
                    FROM enr_stat INNER JOIN subjects ON enr_stat.coursenumber = subjects.coursenumber WHERE enr_stat.number_of_students > '0'";
            $result = mysqli_query($con,$sql);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results/$results_per_page);

            if (!isset($_GET['page'])){
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $this_page_result = ($page - 1) * $results_per_page;

            $sql = "SELECT subjects.coursenumber AS 'Course Number',subjects.destitle AS 'Descriptive Title', checklist.term AS 'Term', subjects.units AS 'Units' FROM subjects NATURAL JOIN pre_enroll NATURAL JOIN overloading NATURAL JOIN students NATURAL JOIN curriculum_checklist NATURAL JOIN checklist NATURAL JOIN updated_checklist WHERE id_number = '$id' LIMIT $this_page_result, $results_per_page";
            if(isset($_POST['submit'])){
                $selected_val = $_POST['sort'];
                echo $selected_val;
                $sql = "SELECT enr_stat.coursenumber as 'CourseNo.', subjects.destitle as 'Descriptive Title', enr_stat.term as 'Term'
                    FROM enr_stat INNER JOIN subjects ON enr_stat.coursenumber = subjects.coursenumber WHERE enr_stat.number_of_students > '0' and enr_stat.term = '$selected_val' LIMIT $this_page_result, $results_per_page";
            } else {
            $sql = "SELECT subjects.coursenumber AS 'Course Number',subjects.destitle AS 'Descriptive Title', checklist.term AS 'Term', subjects.units AS 'Units' FROM subjects NATURAL JOIN pre_enroll NATURAL JOIN overloading NATURAL JOIN students NATURAL JOIN curriculum_checklist NATURAL JOIN checklist NATURAL JOIN updated_checklist WHERE id_number = '$id' LIMIT $this_page_result, $results_per_page";
            }
            $result = mysqli_query($con, $sql);
            ?>

        <div class="col-md-offset-11">
        <button class="btn btn-primary" type="submit" value="Enter" name="Enter">Apply</button>   
        <br>
        </div>
        </div>
        
        <?php
            function check_input($data) {
                $data = trim($data);
                $data = stripcslashes($data);
                $data = htmlspecialchars($data);
                return $data;
		}
		?>

        <script>
            function resetIdNumber(){
                document.getElementById("idNumber").reset();
                
            }

            function resetSubjects(){
                document.getElementById("Subjects").reset();
            }
            
            function filterData() {
                var input, filter, table, tr, td, tdtwo, tdthree, i;
                input = document.getElementById("myInput");
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

            function addDataToLocalStorage(r){
                var courseNo = r.parentNode.parentNode.childNodes[0].innerText;
                var descriptive = r.parentNode.parentNode.childNodes[1].innerText;
                var term = r.parentNode.parentNode.childNodes[2].innerText;
                var unit = r.parentNode.parentNode.childNodes[3].innerText;
                var t = "<button onclick=clearData(this);deleteRow(this); class='btn btn-default btn-sm'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>"; 

                var list = {
                    courseNumber: courseNo,
                    descriptiveTitle: descriptive,
                    units: unit,
                };

                var jsonObject = JSON.stringify(list);
                localStorage.setItem("list" + localStorage.length,jsonObject);

                var thatTable = document.getElementById("copy");
                var newRow = thatTable.insertRow(-1); //at the last position of the table

                var newCell1 = newRow.insertCell(0);
                newCell1.innerHTML = courseNo;
                var newCell2 = newRow.insertCell(-1);
                newCell2.innerHTML = descriptive;
                var newCell3 = newRow.insertCell(-1);
                newCell3.innerHTML = term;
                var newCell4 = newRow.insertCell(-1);
                newCell4.innerHTML = unit;
                var newCell5 = newRow.insertCell(-1);
                newCell5.innerHTML = t;
            }

            function clearData(r) {
                var data = r.parentNode.parentNode.rowIndex;
                var data_key = data - 1;
                localStorage.removeItem(localStorage.key(data_key));
            }

             function deleteRow(r) {
                 var i = r.parentNode.parentNode.rowIndex;
                 document.getElementById("copy").deleteRow(i);
            }
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>