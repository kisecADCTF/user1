<?php
	$conn = mysqli_connect('192.168.55.14', 'user', 'root','database', 30007) or die('Error while connecting SQL: '.mysqli_error($conn));
	//mysql_select_db('database', $conn) or die('Error while selecting database: '.mysql_error());
