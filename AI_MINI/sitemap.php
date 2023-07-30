<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-type: application/xml; charset=utf-8');
	include '_config.php';
	$conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename) or die("1"); 
	$qqq = $conn->prepare("select frag,date,updateFreq,relevance from articles order by relevance desc, date desc")  or die("1");
	$qqq->execute() or die("1");
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
	$qqq->bind_result($frag,$date,$updateFreq,$relevance);
	while ($qqq->fetch()) {
?>
		<url>
			<loc>https://<?=$_SERVER['SERVER_NAME']?>/?p=<?=$frag?></loc>
			<?php if($date){?><lastmod><?=$date?></lastmod><?php }?>
			<changefreq><?=$updateFreq?></changefreq>
			<priority><?=$relevance<0?0:$relevance>1?1:$relevance?></priority>
		</url>
<?php
	}
	$conn->close();
?>
</urlset>
