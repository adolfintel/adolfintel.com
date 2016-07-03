<?php
   header("Cache-Control: no-store, no-cache, must-revalidate");
   header("Cache-Control: post-check=0, pre-check=0", false);
   header("Pragma: no-cache");
   header('Content-type: text/html; charset=utf-8');
?>
<div>
<link rel="stylesheet" type="text/css" href="articleList.css?20160506" />
<?php 
include '_config.php';
   
   $conn = mysql_connect ($MySql_hostname, $MySql_username, $MySql_password) or die ("1");
   $db = mysql_select_db ($MySql_databasename, $conn) or die ("1");
   $pid=(int)$_GET["s"];
   $qqq=mysql_query("select * from articles where section=".$pid." order by relevance desc, date desc") or die("1");
   
   $n=0;
   while ($a = mysql_fetch_object ($qqq)) {
	   $n++;
?>
	<div class="stripe">
		<div class="content">
			<img src="<?=$a->icon?$a->icon:"noicon.png"?>" class="icon" onClick="loadFragment('<?=$a->frag?>')"/><span class="date"><?=$a->date?></span><h2><ai_link frag="<?=$a->frag?>"><?=$a->title?></ai_link></h2>
			<div class="description"><?=$a->description?></div>
			<div class="clear">&nbsp;</div>
			<ai_link class="clickOverlay" frag="<?=$a->frag?>">&nbsp;</ai_link>
		</div>
	</div>
<?php
   }
   if($n==0){  
?>
	<div class="stripe">
		<div class="content">
			<h2>Nothing here yet...</h2>
		</div>
	</div>
<?php
   }
?>
</div>