<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-type: application/xml; charset=utf-8');
	require_once 'HTMLPurif/HTMLPurifier.standalone.php';
	$config = HTMLPurifier_Config::createDefault();
	$purifier = new HTMLPurifier($config);
	include '_config.php';
	$conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename) or die("1");   
	$q = $conn->prepare("select text from comment where idPage=?")  or die("1");
	$q->bind_param("s",$_GET["id"]);
	$q->execute() or die("1");
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<comments>';
	$q->bind_result($text);
	while($q->fetch()){
		echo "<comment>".$purifier->purify($text)."</comment>";
	}
	echo '</comments>';
?>