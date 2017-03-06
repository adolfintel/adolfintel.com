<?php
   header("Cache-Control: no-store, no-cache, must-revalidate");
   header("Cache-Control: post-check=0, pre-check=0", false);
   header("Pragma: no-cache");
   header('Content-type: text/html; charset=utf-8');
?>
<?php if(file_exists($_GET["p"])){ 
	$dir=dirname($_GET["p"]);
?>
<div>
	<link rel="stylesheet" type="text/css" href="article_md.css?20170306" />
	<div class="stripe">
		<div class="content">
		<div id="mdArticle">
		<?php	if(strpos(strtolower($_GET["p"]),"_config.php")!==false){ //attempted to attack -> easter egg ?>
					<script type="text/javascript">document.location.href="https://www.youtube.com/watch?v=HO8ctP_QNZc";</script>
		<?php	} else{
					//everything is fine, parse the md file
					include_once 'Parsedown.php';
					$pd=new ParseDown();
					echo $pd->text(file_get_contents($_GET["p"]));
				}
			?>
		</div>
		<script type="text/javascript">
			//apply hljs to code elements. assume preformatted
			try{
				var k=I("mdArticle").getElementsByTagName("code");
				for(var i=0;i<k.length;i++){
					if(!isBasicMode()){
						//in full mode, apply hljs
						//parsedown already does some escaping of html entities, but not enough
						k[i].innerHTML=k[i].innerHTML.replace(/\n/g,'<br/>').replace(/\t/g,'&emsp;&emsp;').replace(/\s/g,'&nbsp;');
						try{
							var lang=k[i].className.substring(9).toLowerCase();
							if(lang.isBlank()) continue;
							if(lang=="html")lang="xml";
							if(lang=="jsp")lang="java";
							if(lang=="c"||lang=="c++")lang="cpp";
							highlight(k[i],lang); 
						}catch(e){}	
					}else{
						//in basic mode, just apply white-space:pre (fix for old ie to keep line breaks after manipulating a <pre> element)
						k[i].style.whiteSpace="pre";
					}
				}
			}catch(e){}
			//apply lightbox to images
			if(!isBasicMode()){
				try{
					var imgs=document.querySelectorAll("#mdArticle > p > img");
					for(var i=0;i<imgs.length;i++){
						var lbFunct=function(x){return function(){openLightbox(x);}.bind(this)}.bind(this);
						imgs[i].onclick=lbFunct(imgs[i].src);
					}
				}catch(e){}
			}else{
				//in basic mode, apply blockImg class, as well as lightbox
				try{
					var d=I("mdArticle").childNodes;
					for(var i=0;i<d.length;i++){
						try{
							if(d[i].tagName.toLowerCase()=="p"){
								var p=d[i].childNodes;
								for(var j=0;j<p.length;j++){
									try{
										if(p[j].tagName.toLowerCase()=="img"){
											p[j].className+="blockImg";
											var lbFunct=function(x){return function(){openLightbox(x);}.bind(this)}.bind(this);
											p[j].onclick=lbFunct(p[j].src);
										}
									}catch(e){}
								}
							}
						}catch(e){}
					}
				}catch(e){}
			}
		</script>
		</div>
	</div>
	<div class="stripe">
		<div class="content">
			<h2>Share this article</h2>
			<div id="_share_"></div>
		</div>
	</div>
	<div class="stripe">
		<div class="content">
			<h2>Comments</h2>
			<div id="article_comments"></div>
		</div>
	</div>
</div>
<?php
}else{
	echo file_get_contents("error.frag");
}
?>