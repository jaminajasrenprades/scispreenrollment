<!DOCTYPE HTML>
<html>
<head>
    <title>pagination</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    
<body>
<?php
    $con = mysqli_connect('localhost', 'root', '');
    mysqli_select_db($con, 'pre_enrollment');
    
    $results_per_page = 20;
    
    $sql = "SELECT * FROM subjects";
    $result = mysqli_query($con,$sql);
    $number_of_results = mysqli_num_rows($result);
    echo $number_of_results."<br>";
    
    // while($row = mysqli_fetch_array($result)) {
    //     echo $row['coursenumber'] . ' ' . $row['destitle'] . ' ' . $row['units'] .  '<br>';
    // }
    
    $number_of_pages = ceil($number_of_results/$results_per_page);

    if (!isset($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $this_page_result = ($page - 1) * $results_per_page;

    $sql = "SELECT * FROM subjects LIMIT $this_page_result, $results_per_page";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($result)) {
        echo $row['coursenumber'] . ' ' . $row['destitle'] . ' ' . $row['units'] .  '<br>';
    }

    for($page=1; $page<=$number_of_pages; $page++){
        echo '<a href="test.php?page=' . $page . '">' . $page . '</a> ';
    }
?>
</body>
</html>