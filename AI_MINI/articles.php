<?php
	/*
		alright,here's how this file works:
		we can get the full article list for a section by specifying a section id with the "s" get parameter.
		we can get the last post by using the "lastPost" get parameter (any value). this will return the most recent post in any section. the "s" paramter is ignored
		and here's where it starts to get shitty: 
			when we want the last post, we don't want a full page, but just a small block with the post itself, hence why there are so many checks for the lastPost parameter
			when we want the last post and we're in basic mode, we must preprocess the ai_link elements because the client won't be able to do it in basic mode, hence why the basic_only section contains 2 versions of the block
			when the site is in basic mode, we don't want to send the code for the full mode even if it's hidden because it will waste bandwidth downloading article covers, hence why we check if the url contains basic.php, except for when the lastPost parameter is specified, because in that case the url won't contain basic.php (it's an ajax request) and we have no way to know that we're in basic mode, so we send both (it's only used in the homepage)
		also, crappy indentation because it was edited 32113 times.
		it's a bloody mess (like most of php itself) but it works. sooner or later i'll get around to rewriting this to make it less shit.
	*/
   header("Cache-Control: no-store, no-cache, must-revalidate");
   header("Cache-Control: post-check=0, pre-check=0", false);
   header("Pragma: no-cache");
   header('Content-type: text/html; charset=utf-8');
?>
<div class="<?=(!isset($_GET["lastPost"]))?'compactList':''?>">
<?php 
include '_config.php';
	$conn = mysql_connect ($MySql_hostname, $MySql_username, $MySql_password) or die ("1");
	$db = mysql_select_db ($MySql_databasename, $conn) or die ("1");
	if(isset($_GET["lastPost"])){
		$qqq=mysql_query("select * from articles where id=(select max(id) from articles)") or die("1");  
	}else{
		$pid=(int)$_GET["s"];
		$qqq=mysql_query("select * from articles where section=".$pid." order by relevance desc, date desc") or die("1");  
	}
   
   $n=0;
   while ($a = mysql_fetch_object ($qqq)) {
	   $n++;
?>
	<?php if(!isset($_GET["lastPost"])){ ?>
	<div class="stripe">
		<div class="content">
			<?php } ?>
			<div class="basic_only">
				<div class="basicArticleEntry">
				<?php if(isset($_GET["lastPost"])){ //send already processed links instead of ai_link (for basic version)?>
					<img src="<?=$a->icon?$a->icon:"noicon.png"?>" class="articleIcon" onClick="loadFragment('<?=$a->frag?>')"/><span class="date"><?=$a->date?></span><h2><a onClick="loadFragment('<?=$a->frag?>')"><?=$a->title?></a></h2>
					<div class="description"><?=$a->description?></div>
					<div class="clear">&nbsp;</div>
					<a class="clickOverlay" onClick="loadFragment('<?=$a->frag?>')">&nbsp;</a>
				<?php } else { ?>
					<img src="<?=$a->icon?$a->icon:"noicon.png"?>" class="articleIcon" onClick="loadFragment('<?=$a->frag?>')"/><span class="date"><?=$a->date?></span><h2><ai_link frag="<?=$a->frag?>"><?=$a->title?></ai_link></h2>
					<div class="description"><?=$a->description?></div>
					<div class="clear">&nbsp;</div>
					<ai_link class="clickOverlay" frag="<?=$a->frag?>"></ai_link>
				<?php } ?>
				</div>
			</div>
			<?php if(isset($_GET["lastPost"])||!(strpos($_SERVER['PHP_SELF'],’basic.php’)!==false)){ ?>			
				<div class="basic_hide">
					<div class="articleEntry">
						<div class="background" style="background-image:url('<?=$a->cover?$a->cover:"nocover.png"?>')">
							<div class="resp_only">
								<span class="date"><?=$a->date?></span>
							</div>
						</div>
						<div class="details">
							<span class="date resp_hidden"><?=$a->date?></span><h2><ai_link frag="<?=$a->frag?>"><?=$a->title?></ai_link></h2>
							<div class="description"><?=$a->description?></div>
							<div class="clear">&nbsp;</div>
						</div>
						<ai_link class="clickOverlay" frag="<?=$a->frag?>">&nbsp;</ai_link>
					</div>
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
			<h2>Nothing here yet...</h2>
		</div>
	</div>
<?php
   }
   $conn->close();
?>
</div>