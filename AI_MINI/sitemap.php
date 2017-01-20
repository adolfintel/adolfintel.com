<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-type: application/xml; charset=utf-8');
	include '_config.php';
	$conn = mysql_connect ($MySql_hostname, $MySql_username, $MySql_password) or die ("");
	$db = mysql_select_db ($MySql_databasename, $conn) or die ("");
	$qqq=mysql_query("select frag,date,updateFreq,relevance from articles order by relevance desc, date desc") or die("1");
	echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
	while ($a = mysql_fetch_object ($qqq)) {
?>
		<url>
			<loc>http://<?=$_SERVER['SERVER_NAME']?>/?p=<?=$a->frag?></loc>
			<?php if($a->date){?><lastmod><?=$a->date?></lastmod><?php }?>
			<changefreq><?=$a->updateFreq?></changefreq>
			<priority><?=$a->relevance<0?0:$a->relevance>1?1:$a->relevance?></priority>
		</url>
<?php
	}
?>
</urlset>