<?php

    $db_host = "localhost";
    $db_id = "kisec";
    $db_pwd = "kisec1234";
    $db_name = "user";
    $db_port = 32001;

	$conn = mysqli_connect($db_host, $db_id, $db_pwd, $db_name, $db_port);

	if(mysqli_connect_errno())
	    die('Connect Error : ' .mysqli_connect_errno());

	mysqli_close($conn);

?>
