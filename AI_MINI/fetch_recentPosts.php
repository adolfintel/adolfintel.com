<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Content-Type: application/json");
	include '_config.php';
	$conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename);
	$q = $conn->prepare("select title, description, icon, frag from articles where id=(select max(id) from articles)");
	$q->execute();
	$q->bind_result($title,$desc,$icon,$frag);
	$q->fetch();
	$q->close();
	$obj=array(
		'title' => htmlspecialchars($title,ENT_QUOTES),
		'description' => htmlspecialchars($desc,ENT_QUOTES),
		'icon' => $icon,
		'frag' => $frag
	);
	echo json_encode($obj);
?>
