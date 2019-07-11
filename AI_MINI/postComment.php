<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	include '_config.php';
	$conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename) or die("1");   
	$q = $conn->prepare("insert into comment(text,email,idPage) values(?,?,?)")  or die("1");
	$q->bind_param("sss",$_POST["text"],$_POST["email"],$_POST["id"]);
	$q->execute() or die("1");
	echo "0";
	$conn->close();
?>
