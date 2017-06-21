<?php

// require_once("dbcon.php");
session_start();
include 'dbcon.php';

$Idnumber = ($_POST['input']);

 $stmt = $pdo->query("SELECT * FROM students WHERE id_number = '$Idnumber'");

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// print_r($result);
// $_SESSION['last_name'] = $result['last_name'];
// print_r($result[0]['last_name']);


?>