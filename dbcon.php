<?php

	try{
		$pdo = new PDO("mysql:host=localhost;dbname=pre_enrollment","root","");
	} catch (PDOException $e) {
		exit("Error: Could not establish connection to database.");
	}
?>