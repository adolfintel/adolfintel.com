<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	include '_config.php';
	$conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename);
	$q = $conn->prepare("select title from articles where frag=?");
	$q->bind_param("s",$_GET["p"]);
	$q->execute();
	$q->bind_result($title);
	$q->fetch();
	$q->close();
	echo $title;
?>
