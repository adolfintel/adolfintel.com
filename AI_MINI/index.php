<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	include '_config.php';
	header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
<title><?=$Site_Title?></title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1" />
<meta name="description" content="<?=$Site_Description?>" />
<meta name="keywords" content="<?=$Site_Keywords?>" />
<meta name="author" content="<?=$Site_Author?>" />
<meta property="og:site_name" content="<?=$Site_Title?>"/>
<meta name="theme-color" content="<?=$Chrome_TabColor?>"/>
<link rel="icon" href="favicon.png" />
<script type="text/javascript">
String.prototype.isBlank=function(){
	return !this || /^\s*$/.test(this);
}
window.I=function(i){return document.getElementById(i);};
//check browser and redirect to basic mode if incompatible
function gotoBasic(){
	if(window.localStorage){
		if(localStorage.noSwitch)return;
	}
	document.location.href="basic.php"+(document.location.search.isBlank()?"":document.location.search);
}
if(!(window.XMLHttpRequest&&window.JSON&&window.localStorage&&!!window.HTMLCanvasElement&&document.createElement("div").style.animationName!==undefined)){	//any browser with XHR, JSON, localStorage, Canvas, CSS Animation
	gotoBasic();
}

function isMobile(){
	return I("resp_test").offsetWidth>0;
}
function isDesktop(){
	return I("resp_test").offsetWidth==0;
}
function isBasicMode(){
	return false;
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
	I("lbimg").src=imgUrl;
	I("lightbox").style.display='';
}
function closeLightbox(){
	I("lightbox").style.display='none';
	I("lbimg").src="";
}
function loadText(target,url,onDone){
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4&&xhr.status==200){
			target.innerHTML=xhr.responseText.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br/>').replace(/\t/g,'&emsp;&emsp;').replace(/\s/g,'&nbsp;');
			if(onDone)onDone();
		}
	}.bind(this);
	xhr.open("GET",url,true);
	xhr.send();
}
function highlight(target,lang){
	lang=lang.toLowerCase();
	if(!I("hljs_load")){
		var d=document.createElement("script");
		d.id="hljs_load";
		d.type="text/javascript";
		d.src="HLJS/highlight.min.js";
		I("fragment").appendChild(d);
		d=document.createElement("link");
		d.rel="stylesheet";
		d.href="HLJS/ai.css";
		I("fragment").appendChild(d);
	}
	target.className="code lang-"+lang;
	var applyF=function(){hljs.configure({useBR: true});hljs.highlightBlock(target);}.bind(this);
	var t=setInterval(function(){
		if(hljs){
			clearInterval(t);
			if(hljs.listLanguages().indexOf(lang)!=-1){
				applyF();
			}else{
				var xhr=new XMLHttpRequest();
				xhr.onreadystatechange=function(){
					if(xhr.readyState==4&&xhr.status==200){
						eval("window.newLang="+xhr.responseText);
						hljs.registerLanguage(lang,window.newLang);
						applyF();
					}
				}.bind(this);
				xhr.open("GET","HLJS/langs/"+lang+".js",true);
				xhr.send();
			}
		}
	}.bind(this),100);
}

setInterval(function(){
	var lb=I("lightbox"), img=I("lbimg");
	if(lb!=null&&lb.style.display.isBlank()){
		if(img.naturalWidth<=lb.clientWidth&&img.naturalHeight<=lb.clientHeight) img.className=""; else{
			var ir=img.naturalWidth/img.naturalHeight, lr=lb.clientWidth/lb.clientHeight;
			if(ir>=lr) img.className="fullWidth"; else img.className="fullHeight";
		}
	}
},20);

function showLoading(){
	var c=document.createElement("div");
	c.className="loading";
	var stripe=document.createElement("div");
	stripe.className="stripe";
	var frag=I("fragment");
	stripe.appendChild(c);
	frag.innerHTML="";
	frag.appendChild(stripe);
}
function showError(err){
	window._err=err;
	loadFragment('error.frag',false);
	warp.TARGET_SPEED=0;
	if(warp_lowerComplexityWhileLoading){
		warp.USE_CIRCLES=warp_useCircles;
		warp.DEPTH_ALPHA=warp_depthAlpha;
	}
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
function createShareLinks(url,container){
	container.innerHTML="";
	var eurl=encodeURIComponent(url);
	var a=document.createElement("a");
	a.className="share share_fb";
	a.target="_blank";
	a.href="https://www.facebook.com/sharer/sharer.php?u="+eurl;
	container.appendChild(a);
	a=document.createElement("a");
	a.className="share share_tw";
	a.target="_blank";
	a.href="https://twitter.com/home?status="+eurl;
	container.appendChild(a);
	a=document.createElement("a");
	a.className="share share_gplus";
	a.target="_blank";
	a.href="https://plus.google.com/share?url="+eurl;
	container.appendChild(a);
	a=document.createElement("input");
	a.type="text";
	a.className="share share_link";
	a.value=url;
	a.onclick=a.select;
	container.appendChild(a);
}
function loadComments(id,container){
	container.innerHTML="";
	var d=document.createElement("d");
	d.className="loading";
	container.appendChild(d);
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4){
			if(xhr.status==200){
				container.innerHTML="";
				try{
					if(parseInt(xhr.responseText)==1){container.innerHTML="Server error"; return;}
				}catch(e){}
				try{
					var comments=JSON.parse(xhr.responseText);
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
	var xhr=new XMLHttpRequest();
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
function parseLinks(){
	var d=document.getElementsByTagName("ai_link");
	while(d.length>0){
		var n=document.createElement("a");
		for(var j=0;j<d[0].attributes.length;j++){
			try{n.setAttribute(d[0].attributes.item(j).nodeName,d[0].attributes.item(j).nodeValue);}catch(e){}
		}
		n.innerHTML=d[0].innerHTML;
		if(n.hasAttribute("frag")){
			n.onclick=function(e){e.preventDefault();loadFragment(this.getAttribute("frag"));}.bind(n);
			n.href="/?p="+d[0].getAttribute("frag");
		}else if(n.hasAttribute("ext")){
			n.href=n.getAttribute("ext");
			n.target="_blank";
			n.removeAttribute("ext");
		}
		d[0].parentNode.replaceChild(n,d[0]);
	}
	
}
function fadeCurrentFrag(onDone){
	var f=I("fragment");
	f.id=""; f.className="oldFragment";
	f.addEventListener('animationend',function(){
		f.parentElement.removeChild(f);
		var d=document.createElement("div");
		d.id="fragment";
		I("page").appendChild(d);
		if(onDone)onDone();
	}.bind(this));
	
}
function onFragUnload(){}
var loading=false;
function loadFragment(url,pushState){
	if(loading) return;
	loading=true;
	if(warp_lowerComplexityWhileLoading){
		warp.USE_CIRCLES=false;
		warp.DEPTH_ALPHA=false;
	}
	warp.TARGET_SPEED=warp_loadingSpeed;
	showNav();
	showPage();
	closeLightbox();
	onFragUnload();
	onFragUnload=function(){}
	url=unescape(url);
	if(typeof pushState == 'undefined') pushState=true;
	try{if(pushState)window.history.pushState(url, document.title, '/?p='+url);}catch(e){}
	fadeCurrentFrag(function(){
		showLoading();
		var xhr=new XMLHttpRequest();
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4){
				if(xhr.status==200){
					fadeCurrentFrag(function(){
						loading=false;
						if(warp_lowerComplexityWhileLoading){
							warp.USE_CIRCLES=warp_useCircles;
							warp.DEPTH_ALPHA=warp_depthAlpha;
						}
						warp.TARGET_SPEED=warp_normalSpeed;
						var frag=I("fragment");
						frag.innerHTML=xhr.responseText;
						var scripts=frag.getElementsByTagName("script");
						for(var i=0;i<scripts.length;i++) eval(scripts[i].innerHTML);
						parseLinks();
						document.title="<?=$Site_Title?>";
						var xhr2=new XMLHttpRequest();
						xhr2.onreadystatechange=function(){
							if(xhr2.readyState==4){
								if(xhr2.status==200){
									if(!(xhr2.responseText.isBlank())) document.title=xhr2.responseText+" - <?=$Site_Title?>";
								}
							}
						}
						xhr2.open("POST","fetch_frag_title.php?p="+url);
						xhr2.send("random="+Math.random());
						var shareArea=I("_share_");
						if(shareArea) createShareLinks(document.location.href,shareArea);
						var oldC=I("_comments_");
						if(oldC)oldC.id="article_comments";
						var commentsArea=I("article_comments");
						if(commentsArea) createCommentsForm(document.location.search.substring(3),commentsArea);
						var latest=I("_latestPost_");
						if(latest){
							var xlp=window.XMLHttpRequest?new XMLHttpRequest():new ActiveXObject("Microsoft.XMLHTTP");
							xlp.onreadystatechange=function(){
								if(xlp.readyState==4){
									if(xlp.status==200){
										var resp=JSON.parse(xlp.responseText);
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
										d.setAttribute('onclick',"loadFragment('"+resp['frag']+"');return false;");
										latest.appendChild(d);
									}
								}
							}
							xlp.open("GET","fetch_recentPosts.php?random="+Math.random());
							xlp.send();
						}
					});
					
				}else{loading=false; showError(xhr.status);}
			}
		}
		xhr.open("POST",url,true);
		xhr.send("random="+Math.random());
	});
}

window.onpopstate = function(e){
	if(loading) return;
    if(e.state){ loadFragment(e.state,false);}
};

var warp, warp_normalSpeed, warp_loadingSpeed=<?=$Background_SpeedWhileLoading ?>, warp_lowerComplexityWhileLoading=<?=$Background_LowerComplexityWhileLoading ?>, warp_useCircles, warp_depthAlpha;
function setBackgroundCfg(cfg){
	localStorage.backgroundCfg=cfg;
	warp=new WarpSpeed("bkFrame",cfg);
	warp_normalSpeed=warp.TARGET_SPEED;
	warp_useCircles=warp.USE_CIRCLES;
	warp_depthAlpha=warp.DEPTH_ALPHA;
}
	
function autoLoad(){
	parseLinks();
	closeLightbox();
	try{
		var req=window.location.search;
		if(req.isBlank()) throw("");
		loadFragment(req.substring(3),true);
	}catch(e){
		loadFragment("<?=$HomeFrag?>",true);
	}
}

function toggleNavExp(){
	//in mobile view, toggles the menu
	if(isMobile){
		var nav=I("nav");
		if(nav.className.isBlank()) nav.className='expanded'; else nav.className='';
	}
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
<script src="warpspeed.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="main.css?20160901"/>
<style type="text/css">
.basic_only{
	display:none;
}
</style>
</head>
<body onLoad="autoLoad()">
<div id="background">
	<canvas id="bkFrame" style="position:fixed; left:0; top:0; width:100%; height:100%"></canvas>
	<script type="text/javascript">
		setBackgroundCfg(localStorage.aiv5&&localStorage.backgroundCfg?localStorage.backgroundCfg:"<?=str_replace('"','\\"',$Background_DefaultConfig)?>");
		localStorage.aiv5=true;
	</script>
</div>
<div id="page">
	<div id="nav" onClick="toggleNavExp()">
		<?php
			ob_start();
			include($NavFrag);
			echo ob_get_clean();
		?>
	</div>
	<img id="campaign-icon" src="campaign-icon.png" />
	<script type="text/javascript">
		I("campaign-icon").style.display="none";
	</script>
	<div id="fragment">
	</div>
</div>
<div id="lightbox" onClick="closeLightbox()">
	<img id="lbimg" onClick="closeLightbox()" src="null.png"/>
</div>
<div id="resp_test">&nbsp;</div>
</body>
</html>