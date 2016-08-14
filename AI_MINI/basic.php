<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: text/html; charset=utf-8');
	
	function parseLinks($xml){
		$dom = new DOMDocument();
		@$dom->loadHTML(mb_convert_encoding($xml, 'HTML-ENTITIES', "UTF-8"));
		$nodes = $dom->getElementsByTagName("ai_link");
		while($nodes->length>0){
			$node=$nodes->item(0);
			$newNode = $dom->createElement("a");
			foreach ($node->attributes as $attribute){
				$newNode->setAttribute($attribute->name, $attribute->value);
			}
			if($newNode->hasAttribute("frag")){
				$newNode->setAttribute("onclick","loadFragment('".$newNode->getAttribute("frag")."');return false;");
				$newNode->setAttribute("href","/?p=".$newNode->getAttribute("frag"));
				$newNode->removeAttribute("frag");
			}else if($newNode->hasAttribute("ext")){
				$newNode->setAttribute("href",$newNode->getAttribute("ext"));
				$newNode->setAttribute("target","_blank");
				$newNode->removeAttribute("ext");
			}
			foreach ($node->childNodes as $child){
				$newNode->appendChild($node->removeChild($child));
			}
			$node->parentNode->replaceChild($newNode,$node);
		}
		return preg_replace(array("/^\<\!DOCTYPE.*?<html><body>/si","!</body></html>$!si"),"",$dom->saveHTML($dom->documentElement));
	}


?>
<!DOCTYPE html>
<html>
<head>
<?php
	include '_config.php';
	$_GET["p"]=urldecode($_GET["p"]);
	$conn = new mysqli($MySql_hostname, $MySql_username, $MySql_password, $MySql_databasename);
	$q = $conn->prepare("select description,title,kwords,campaignIcon from articles where frag=?");
	$q->bind_param("s",$_GET["p"]);
	$q->execute();
	$q->bind_result($description, $title, $kwords,$socialImg);
	$q->fetch();
	$q->close();	
?>
<title><?=$title?($title." - ".$Site_Title):$Site_Title?></title>	
<meta name="description" content="<?=$description?$description:$Site_Description?>" />
<meta name="keywords" content="<?=$kwords?$kwords:$Site_Keywords ?>" />
<meta name="author" content="<?=$Site_Author?>" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1" />
<meta property="og:site_name" content="<?=$Site_Title?>"/>
<meta property="og:image" content="<?=(($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http").'://'. $_SERVER['HTTP_HOST'].'/'.($socialImg?$socialImg:'campaign-icon.png')?>" />
<meta property="og:title" content="<?=$title?$title:$Site_Title?>" />
<meta property="og:description" content="<?=$description?$description:$Site_Description?>" />
<meta name="theme-color" content="<?=$Chrome_TabColor?>"/>
<link rel="stylesheet" type="text/css" href="main.css?20160814" />
<link rel="icon" href="favicon.ico" />
<script type="text/javascript">
String.prototype.isBlank=function(){
	return !this || /^\s*$/.test(this);
}
if(!Function.prototype.bind){
  Function.prototype.bind=function(oThis){
    if (typeof this !== "function") throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
    var aArgs=Array.prototype.slice.call(arguments,1),fToBind=this,fNOP=function(){},fBound=function(){return fToBind.apply(this instanceof fNOP && oThis? this: oThis,aArgs.concat(Array.prototype.slice.call(arguments)));};
    fNOP.prototype=this.prototype;
    fBound.prototype=new fNOP();
    return fBound;
  };
}
window.I=function(i){return document.getElementById(i);};
//check browser and redirect to full mode if compatible
function gotoFull(){
	if(localStorage.noSwitch)return;
	document.location.href="index.php"+(document.location.search.isBlank()?"":document.location.search);
}
if(window.XMLHttpRequest&&window.JSON&&window.localStorage&&!!window.HTMLCanvasElement&&document.createElement("div").style.animationName!==undefined){	//any browser with XHR, JSON, localStorage, Canvas, CSS Animation
	gotoFull();
}

function isMobile(){
	return I("resp_test").offsetWidth>0;
}
function isDesktop(){
	return I("resp_test").offsetWidth==0;
}
function isBasicMode(){
	return true;
}
function onFragUnload(){}
function loadFragment(url,pushState){
	onFragUnload();
	url=unescape(url);
	document.location.href="basic.php?p="+url;
}
function showNav(){
	I("nav").style.display='';
}
function hideNav(){
	I("nav").style.display='none';
}
function showPage(){
	I("fragment").style.display='';
}
function hidePage(){
	I("fragment").style.display='none';
}
function openLightbox(imgUrl){
	window.open(imgUrl,"_blank");
}
function closeLightbox(){}

function loadText(target,url,onDone){
	var xhr=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4&&xhr.status==200){
			target.innerHTML=xhr.responseText.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br/>').replace(/\t/g,'&emsp;&emsp;').replace(/\s/g,'&nbsp;');
			try{if(onDone)onDone();}catch(e){}
		}
	}.bind(this);
	xhr.open("GET",url,true);
	xhr.send();
}
function highlight(target,lang){
	target.className="code hljs lang-"+lang;
	if(!I("hljs_load")){
		setTimeout(function(){ //delay loading so ie6 doesn't crash
			var d=document.createElement("link");
			d.id="hljs_load"
			d.rel="stylesheet";
			d.href="HLJS/ai.css";
			I("fragment").appendChild(d);}
		,100);
	}
	//hljs not applied, just basic styling
}
function createCommentsForm(id,container){
	var f=document.createElement("form");
	var t=document.createElement("textarea");
	t.name="text";
	t.rows=4;
	t.setAttribute("placeholder","Type a comment here...");
	f.appendChild(t);
	var b=document.createElement("input");
	b.type="button";
	b.value="Post";
	f.appendChild(b);
	container.appendChild(f);
	var c=document.createElement("div");
	c.className="commentsArea";
	container.appendChild(c);
	b.onclick=function(){sendComment(id,t,c);};
	loadComments(id,c);
}
function loadComments(id,container){
	container.innerHTML="";
	var d=document.createElement("d");
	d.className="loading";
	container.appendChild(d);
	var xhr=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4){
			if(xhr.status==200){
				container.innerHTML="";
				try{
					if(parseInt(xhr.responseText)==1){container.innerHTML="Server error"; return;}
				}catch(e){}
				try{
					var comments=eval('('+xhr.responseText+')'); //JSON.parse did not exist in 2001
					for(var i=0;i<comments.length;i++){
						var d=document.createElement("div");
						d.className="comment";
						d.innerHTML=comments[i];
						container.appendChild(d);
					}
				}catch(e){
					container.innerHTML="Couldn't load comments ("+e+")";
				}
			}
		}
	}
	xhr.open("GET","getComments.php?id="+id+"&r="+Math.random(),true);
	xhr.send();
}
var sending=false;
function sendComment(id,t,commentsArea){
	if(t.value.isBlank()||sending){ return;}
	sending=true;
	var text=t.value;
	var xhr=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4){
			sending=false;
			if(xhr.status==200){
				try{
					if(parseInt(xhr.responseText)==1){return;}
				}catch(e){alert("An error occurred, please try again"); return;}
				t.value="";
				loadComments(id,commentsArea);
			}
		}
	}
	var params="";
	params+="id="+encodeURIComponent(id)+"&text="+encodeURIComponent(text)+"&r="+Math.random();
	xhr.open("POST","postComment.php",true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader("Content-length", params.length);
	xhr.setRequestHeader("Connection", "close");
	xhr.send(params);
}


function showLoading(){
	I("fragment").innerHTML="";
}
function showError(err){
	loadFragment("error.frag?e="+err);
}
function setBackgroundCfg(cfg){}
function toggleNavExp(){
	//in mobile view, toggles the menu
	var nav=I("nav");
	if(nav.className.isBlank()) nav.className='expanded'; else nav.className='';
}
setInterval(function(){
	try{
		var iframes=I("fragment").getElementsByTagName("iframe");
		for(var i=0;i<iframes.length;i++){
			var x=iframes[i];
			x.style.height=x.contentDocument.getElementsByTagName("body")[0].clientHeight+"px";
		}
	}catch(e){}
},50);
</script>
<!--[if lt IE 8]>
<script type="text/javascript">
setInterval(function(){
//this apparently useless piece of code fixes image stretching on IE6/7
	try{
		var imgs=I("fragment").getElementsByTagName("img");
		for(var i=0;i<imgs.length;i++){
			var x=imgs[i];
			if(!x.complete) continue;
			var p=x.parentNode;
			var d=document.createElement("div");
			p.replaceChild(d,x);
			p.replaceChild(x,d);
		}
	}catch(e){}
},1000);
</script>
<![endif]-->
<style type="text/css">
.basic_hide{
	display:none;
}
</style>
<link rel="stylesheet" type="text/css" href="basic_overrides.css?20160705" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="basic_overrides_ie.css?20160705" />
<![endif]-->
</head>
<body>
	<div id="nav" onClick="toggleNavExp()">
		<?php
			ob_start();
			include($NavFrag);
			echo parseLinks(ob_get_clean());
		?>
	</div>
	<img id="campaign-icon" src="<?=$socialImg?$socialImg:"campaign-icon.png" ?>" />
	<script type="text/javascript">
		I("campaign-icon").style.display="none";
	</script>
	<div id="fragment">
		<div class="basic">
			<?php 
				$phpinclude=($_GET["p"])?$_GET["p"]:$HomeFrag;
				ob_start();
				$pos_incl = strpos($phpinclude, '?');
				if ($pos_incl !== FALSE)
				{
					$qry_string = substr($phpinclude, $pos_incl+1);
					$phpinclude = substr($phpinclude, 0, $pos_incl);
					$arr_qstr = explode('&',$qry_string);
					foreach ($arr_qstr as $param_value) {
						list($qstr_name, $qstr_value) = explode('=', $param_value);
						$$qstr_name = $qstr_value;
						$_GET[$qstr_name]=$qstr_value;
					}
				}
				if(file_exists($phpinclude)) include($phpinclude); else { ?><script type="text/javascript">setTimeout(function(){showError(404);},100);</script><?php }
				echo parseLinks(ob_get_clean());
			?>
		</div>
	</div>
	<script type="text/javascript">
		var oldC=I("_comments_");
		if(oldC)oldC.id="article_comments";
		var c=I("article_comments");
		if(c)createCommentsForm('<?=$_GET["p"]?>',c);
		var s=I("_share_");
		if(s){
			url=document.location.href;
			s.innerHTML="";
			var eurl=encodeURIComponent(url);
			var a=document.createElement("a");
			a.className="share share_fb";
			a.target="_blank";
			a.href="https://www.facebook.com/sharer/sharer.php?u="+eurl;
			s.appendChild(a);
			a=document.createElement("a");
			a.className="share share_tw";
			a.target="_blank";
			a.href="https://twitter.com/home?status="+eurl;
			s.appendChild(a);
			a=document.createElement("a");
			a.className="share share_gplus";
			a.target="_blank";
			a.href="https://plus.google.com/share?url="+eurl;
			s.appendChild(a);
			a=document.createElement("input");
			a.type="text";
			a.className="share share_link";
			a.value=url;
			a.onclick=a.select;
			s.appendChild(a);
		}
		var latest=I("_latestPost_");
		if(latest){
			var xlp=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");
			xlp.onreadystatechange=function(){
				if(xlp.readyState==4){
					if(xlp.status==200){
						var resp=eval('('+xlp.responseText+')');
						var d;
						if(resp['icon']){
							d=document.createElement("img");
							d.className="icon clickable";
							d.src=resp['icon'];
							latest.appendChild(d);
						}
						d=document.createElement("h4");
						d.innerHTML="<a href='/?p="+resp['frag']+"' style='text-decoration:none'>"+resp['title']+"</a>";
						latest.appendChild(d);
						latest.innerHTML+="<div style='display:inline-block'>"+resp['description']+"</div>";
						d=document.createElement("div");
						d.className="clear";
						latest.appendChild(d);
						d=document.createElement("a");
						d.className="clickOverlay";
						d.setAttribute('href',"/?p="+resp['frag']);
						latest.appendChild(d);
					}
				}
			}
			xlp.open("GET","fetch_recentPosts.php?random="+Math.random());
			xlp.send();
		}
	</script>
	<div id="resp_test">&nbsp;</div>
</body>
</html>
<?php 
	unlink('error_log'); //lol
?>