<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Content-Type: application/xml");
	include '_config.php';
	$conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename);
	$q = $conn->prepare("select title, description, icon, frag from articles where id=(select max(id) from articles)");
	$q->execute();
	$q->bind_result($title,$desc,$icon,$frag);
	$q->fetch();
	$q->close();
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<article>
<title><?=$title?></title>
<description><?=$desc?></description>
<icon><?=$icon?></icon>
<frag><?=$frag?></frag>
</article>
