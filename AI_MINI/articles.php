<?php
   header("Cache-Control: no-store, no-cache, must-revalidate");
   header("Cache-Control: post-check=0, pre-check=0", false);
   header("Pragma: no-cache");
   header('Content-type: text/html; charset=utf-8');
   if(isset($_GET["forceBasicMode"])) $ai_basicMode=true;
   $pid=(int)$_GET["s"];
   include '_config.php';
	$conn = mysqli_connect ($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename) or die ("1");
?>
<div class="<?=(!isset($_GET["lastPost"]))?'compactList':''?>">
<?php if(!isset($_GET["lastPost"])){
	$qqq=mysqli_query($conn,"select title from articles where frag like 'articles.php?s=".$pid."'") or die ("1");
	$a=mysqli_fetch_object($qqq);
	if($a){
		?>
		<div class="content"><h1 style="margin-top:0.8em"><?=htmlspecialchars($a->title)?> <a href="feed://<?=$_SERVER['HTTP_HOST']?>/rss.php?s=<?=$pid?>"><img style="height:0.7em; width:auto;" src="rss.png" alt="RSS Feed" /></a></h1></div>
		<?php
	}?>	
<?php
}
?>
<?php 
	if(isset($_GET["lastPost"])){
		if($_GET["lastPost"]=="featured"){
			$qqq=mysqli_query($conn,"select * from articles order by featured desc,id desc limit 1") or die("1");
		}else{
			$qqq=mysqli_query($conn,"select * from articles where id=(select max(id) from articles)") or die("1");
		}
	}else{
		$qqq=mysqli_query($conn,"select * from articles where section=".$pid." order by relevance desc, date desc") or die("1");  
	}
   
   $n=0;
   while ($a = mysqli_fetch_object ($qqq)) {
	   $n++;
?>
	<?php if(!isset($_GET["lastPost"])){ ?>
	<div class="stripe">
		<div class="content">
			<?php } ?>
			<?php if(isset($ai_basicMode)){ ?>
				<div class="basicArticleEntry">
					<img src="<?=$a->icon?$a->icon:"noicon.png"?>" class="articleIcon" onClick="loadFragment('<?=$a->frag?>')"/><span class="date"><?=$a->date?></span><h2><a onClick="loadFragment('<?=$a->frag?>')"><?=nl2br(htmlspecialchars($a->title))?></a></h2>
					<div class="description"><?=nl2br(htmlspecialchars($a->description))?></div>
					<div class="clear">&nbsp;</div>
					<a class="clickOverlay" onClick="loadFragment('<?=$a->frag?>')">&nbsp;</a>
				</div>
			<?php } ?>
			<?php if(!isset($ai_basicMode)){ ?>			
				<div class="articleEntry" lazyLoadBkUrl="<?=$a->cover?$a->cover:"nocover.png"?>">
					<div class="background">
						<div class="resp_only">
							<span class="date"><?=$a->date?></span>
						</div>
					</div>
					<div class="details">
						<span class="date resp_hidden"><?=$a->date?></span><h2><ai_link frag="<?=$a->frag?>"><?=nl2br(htmlspecialchars($a->title))?></ai_link></h2>
						<div class="description"><?=nl2br(htmlspecialchars($a->description))?></div>
						<div class="clear">&nbsp;</div>
					</div>
					<ai_link class="clickOverlay" frag="<?=$a->frag?>">&nbsp;</ai_link>
				</div>
			<?php  } ?>
	<?php if(!isset($_GET["lastPost"])){ ?>
		</div>
	</div>
	<?php } ?>
<?php
   }
   if($n==0){  
?>
	<div class="stripe">
		<div class="content">
			Nothing here yet...
		</div>
	</div>
<?php
   }
   mysqli_close($conn);
?>
</div>