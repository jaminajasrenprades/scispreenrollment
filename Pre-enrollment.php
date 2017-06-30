<!DOCTYPE html>
<?php 
    require 'classes/UserAccount.php';
    
?>
<html lang="en">
<head>
      <title>Pre-Enrollment</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/customcss.css">
      <link rel="stylesheet" href="css/nav.css">
      <link rel="stylesheet" href="css/font-awesome.min.css">
      <link rel="stylesheet" href="css/header.css">
    
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
                            <li role="presentation">
                              <a href="Pre-enrollment.php" style="font-size: 110%; font-family: Roboto"><i class="fa fa-home"></i> Home <span class="arrow"></span></a>
                            </li>

                            <li role="presentation">
                              <a href="Checklist.php" style="font-size: 110%; font-family: Roboto"><i class="fa fa-th-list"></i> Checklist <span class="arrow"></span></a>
                            </li>


                            <li role="presentation">
                              <a href="Pre-enrollment.php" style="font-size: 110%; font-family: Roboto"><i class="fa fa-columns"></i> Offered Subjects <span class="arrow"></span></a>
                            </li>  

                            <li role="presentation">
                              <a href="Checklist.php" style="font-size: 110%; font-family: Roboto"><i class="fa fa-files-o"></i> Petitions <span class="arrow"></span></a>
                            </li>

                             <li role="presentation">
                              <a href="Checklist.php" style="font-size: 110%; font-family: Roboto"><i class="fa fa-stack-overflow"></i> Overload <span class="arrow"></span></a>
                             </li>

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


                            echo  $_SESSION['username'];
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

    <body>
        <div class="container-fluid">
            <div class="row">    <!--RED-->
                <div class="col-md-4 col-md-offset-3" style="margin-top:10%">
                    <form method="post" action="#">
                        <select style="width: 120px; padding: 5px; top:1%;" name = "sort">
                        <option value="All"><a href="#"> Overall Term </a></option>
                        <option value="First"><a href="#">First Term</a></option>
                        <option value="Second"><a href="#">Second Term</a></option>
                        <option value="Short"><a href="#">Short Term</a></option>
                    </select>
                    
                </div>
                <div class="col-md-2" style="margin-top:10%; left:30%;">
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
                
            
                    include 'dbcon.php';

                    $idnumber = $_SESSION['username'];
                    $stmt = $pdo->query("SELECT last_name, first_name, course, year FROM students WHERE id_number = '$idnumber'");
                    $countQuery = $stmt->rowCount();
                    if ($countQuery == 0){
                        echo "Student does not Exists!";
                    } else {
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $idnumber = $idnumber;
                    $last_name  = ($result[0]['last_name']);
                    $first_name = ($result[0]['first_name']);
                    $course     = ($result[0]['course']);
                    $year       = ($result[0]['year']);
                    
                    $q = $pdo->query("SELECT sum(units) AS stotal FROM subjects natural join pre_enroll WHERE id_number = '$idnumber'");
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
                    echo "<p>ID Number: ".$idnumber."</p>";                    
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
                <div class="col-md-2">
                    <h4><p>Total Units: <b>
                        <?php echo $totalunits;?></b></p></h4>
                </div>
            </div>
            <br>

            <?php
            if(isset($_POST['submit'])){
                $selected_val = $_POST['sort'];  // Storing Selected Value In Variable
              //  echo "You have selected:" .$selected_val;  // Displaying Selected Value
                include 'dbcon.php';
                if ($selected_val == "All"){
                    $stmt = $pdo->query("SELECT subjects.coursenumber as 'Course No.', subjects.destitle as 'Descriptive Title', enr_stat.term as 'Term', subjects.units as 'Units'
                                 FROM subjects INNER JOIN enr_stat ON subjects.coursenumber = enr_stat.coursenumber");
                    
                } else {
                    $stmt = $pdo->query("SELECT subjects.coursenumber as 'Course No.', subjects.destitle as 'Descriptive Title', enr_stat.term as 'Term', subjects.units as 'Units'
                                 FROM subjects INNER JOIN enr_stat ON subjects.coursenumber = enr_stat.coursenumber where term = '$selected_val'");
            
            
                }
                    
            } else {
                //$te=$selected_val;
            include 'dbcon.php';
            $stmt = $pdo->query("SELECT subjects.coursenumber as 'Course No.', subjects.destitle as 'Descriptive Title', enr_stat.term as 'Term', subjects.units as 'Units'
                                 FROM subjects INNER JOIN enr_stat ON subjects.coursenumber = enr_stat.coursenumber");
            
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
                                  echo "<input type='hidden' name='term' value='".$row['Term']."'/>";
                                  echo "<input type='hidden' name='units' value='".$row['Units']."'/>";
                                  echo "
                                  <td>
                                      <button class='btn btn-default btn-sm' onclick='addDataToLocalStorage(this)'>
                                          <span class='glyphicon glyphicon-plus' aria-hidden='true'></span>
                                      </button>
                                  </td>";   //add/insert rows at the database
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
                                 $quer = "select * from pre_enroll natural join students natural join subjects where id_number = '$idnum'";
                                 $res = mysqli_query($con, $quer);
                                 $countRes = mysqli_num_rows($res);
                                                             
                              if ($countRes != 0){
                                while ($rows = $res-> fetch_assoc()){
                                $course = $rows['coursenumber'];
                                $desctitle = $rows['destitle'];
                                $term = $rows['term'];
                                $units = $rows['units'];
                                                                
                                echo "<tr>";
                                echo "<td>".$course."</td>";
                                echo "<td>".$desctitle."</td>";
                                echo "<td>".$term."</td>";
                                echo "<td>".$units."</td>";
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

            <div class="col-md-offset-11">
                <button class="btn btn-primary" type="submit" value="Enter" name="Enter">Apply</button>   
                <br>
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
                    term: term,
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
        
        <script>
            $(function() {
              var shrinkHeader = 300;
              $(window).scroll(function() {
                var scroll = getCurrentScroll();
                if (scroll >= shrinkHeader) {
                  $(".header").addClass("shrink");
                } else {
                  $(".header").removeClass("shrink");
                }
              });
              function getCurrentScroll() {
                return window.pageYOffset || document.documentElement.scrollTop;
              }
            });
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
      </body>
</html>