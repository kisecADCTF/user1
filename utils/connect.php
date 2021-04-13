<?php
	$conn = mysql_connect('localhost', 'user', 'root') or die('Error while connecting SQL: '.mysql_error());
	mysql_select_db('YOUR DATABASE', $conn) or die('Error while selecting database: '.mysql_error());
	mysql_query('set names gb2312');
?>
