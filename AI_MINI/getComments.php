<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-type: text/json; charset=utf-8');
	include '_config.php';
	$conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename) or die("1");   
	$q = $conn->prepare("select text from comment where idPage=?")  or die("1");
	$q->bind_param("s",$_GET["id"]);
	$q->execute() or die("1");
	$comments=array();
	$q->bind_result($text);
	while($q->fetch()){
		$comments[]=nl2br(htmlspecialchars($text,ENT_QUOTES));
	}
	echo json_encode($comments);
	$conn->close();
?>