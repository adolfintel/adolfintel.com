<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Content-Type: application/rss+xml; charset=utf-8");
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<rss version="2.0">
<channel>
<?php
include '_config.php';
$conn = mysqli_connect ($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename) or die ();
$pid=(int)$_GET["s"];
$qqq=mysqli_query($conn,"select title from articles where frag like 'articles.php?s=".$pid."'") or die ();
$a=mysqli_fetch_object($qqq);
$title="";
$description="";
if($a){
	$title=" - ".htmlspecialchars($a->title);
	$description=htmlspecialchars($a->description);
}
$qqq=mysqli_query($conn,"select * from articles where section=".$pid." order by date desc, relevance desc") or die();
?>
<title><?=$Site_Title.$title?></title>
<link>http://<?=$_SERVER['HTTP_HOST']?>/?p=articles.php?s=<?=$pid?></link>
<description><?=$description?></description>
<ttl>300</ttl>
<?php  
while ($a = mysqli_fetch_object ($qqq)) {
?>
<item>
	<title><?=htmlspecialchars($a->title)?></title>
	<link>http://<?=$_SERVER['HTTP_HOST']?>/?p=<?=$a->frag?></link>
	<description><?=htmlspecialchars($a->description)?></description>
	<pubDate><?=$a->date?></pubDate>
</item>
<?php
}
?>
</channel>
</rss>
