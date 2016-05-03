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
<link rel="icon" href="favicon.png" />
<script type="text/javascript">
String.prototype.isBlank=function(){
	return !this || /^\s*$/.test(this);
}
window.I=function(i){return document.getElementById(i);};
//check browser and redirect to basic mode if incompatible. browser check code is a modified version of https://browser-update.org/
function gotoBasic(){
	document.location.href="basic.php"+(document.location.search.isBlank()?"":document.location.search);
}
function getBrowser() {
    var n,v,ua=navigator.userAgent;
    if (/Trident.*rv:(\d+\.\d+)/i.test(ua)) n="i";
    else if (/Trident.(\d+\.\d+)/i.test(ua)) n="io";
    else if (/MSIE.(\d+\.\d+)/i.test(ua)) n="i";
    else if (/Edge.(\d+\.\d+)/i.test(ua)) n="i";
    else if (/OPR.(\d+\.\d+)/i.test(ua)) n="o";
    else if (/Chrome.(\d+\.\d+)/i.test(ua)) n="c";
    else if (/Firefox.(\d+\.\d+)/i.test(ua)) n="f";
    else if (/Version.(\d+.\d+).{0,10}Safari/i.test(ua))	n="s";
    else if (/Safari.(\d+)/i.test(ua)) n="so";
    else if (/Opera.*Version.(\d+\.\d+)/i.test(ua)) n="o";
    else if (/Opera.(\d+\.?\d+)/i.test(ua)) n="o";
    else return {n:"x",v:0};
    
	var v= parseFloat(RegExp.$1);
    if (n=="so") {
        v=((v<100) && 1.0) || ((v<130) && 1.2) || ((v<320) && 1.3) || ((v<520) && 2.0) || ((v<524) && 3.0) || ((v<526) && 3.2) ||4.0;
        n="s";
    }
    if (n=="i" && v==7 && window.XDomainRequest) {
        v=8;
    }
    if (n=="io") {
        n="i";
        if (v>6) v=11;
        else if (v>5) v=10;
        else if (v>4) v=9;
        else if (v>3.1) v=8;
        else if (v>3) v=7;
        else v=9;
    }	
    return {n:n,v:v};
}
var b=getBrowser();
if((b.n=="i" && b.v<10)||(b.n=="f" && b.v<12)||(b.n=="c" && b.v<30)||(b.n=="o" && b.v<17)||(b.n=="s"&&b.v<8)||(!(window.XMLHttpRequest&&localStorage&&!!window.HTMLCanvasElement&&document.createElement("div").style.animationName!==undefined&&window.XMLSerializer))){	//IE 10+; FF 12+; Chrome 30+; Opera 17+; Safari 8+; any browser with XHR, localStorage, Canvas, CSS Animation, XMLSerializer
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

var loadingStatuses=["","Loading...","Loading...","Still loading...","Loady loady...","Oh look, a butterfly :)","Back to loading...","This is taking longer than it should","Maybe you should check your connection","Still trying to load...","Looooooooooad...","How relaxing...","Relaxing...","Going astral","Going astral.","Going astral..","Going astral...","Going astral... [FAIL]","Oh well I tried","Let's try again","Going astral.","Going astral..","Going astral...","Going astral... [SUCCESS]","Wow...","I can see the page from here","It's beautiful *_*","Maybe if you reload you will see it too","Maybe if you reload you will see it too","No? Well I guess I'll just stay here and look at the world from a new perspective"];
var lStatus=0;
var lStatTimer=setInterval(function(){
	try{
		I("loadStatus").innerHTML=lStatus>=loadingStatuses.length?loadingStatuses[loadingStatuses.length-1]:loadingStatuses[lStatus++];
	}catch(e){
		lStatus=0;
	}
},2000);
function showLoading(){
	try{
		var c=document.createElement("canvas");
		c.className="loading";
		c.width=512;
		c.height=512;
		var ctx=c.getContext("2d");
		ctx.beginPath();
		ctx.arc(c.width/2,c.height/2,c.width/3,0,Math.PI/2,false);
		ctx.strokeStyle="#FFFFFF";
		ctx.lineWidth=c.width*0.02
		ctx.stroke();
		var d=document.createElement("div");
		d.id="loadStatus";
		lStatus=0;
		var stripe=document.createElement("div");
		stripe.className="stripe";
		var frag=I("fragment");
		stripe.appendChild(c);
		stripe.appendChild(d);
		frag.innerHTML="";
		frag.appendChild(stripe);
	}catch(e){
		I("fragment").innerHTML="";
	}
}
function showError(err){
	var frag=I("fragment");
	var stripe=document.createElement("div");
	stripe.className="stripe";
	var c=document.createElement("div");
	c.className="content";
	var h=document.createElement("h2");
	h.innerHTML="Oh crap...";
	c.appendChild(h);
	var p=document.createElement("p");
	p.innerHTML="An error "+err+" has occurred";
	c.appendChild(p);
	stripe.appendChild(c);
	frag.innerHTML="";
	frag.appendChild(stripe);
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
	var img=document.createElement("img");
	img.className="loading";
	img.src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAAn1BMVEUAAAD29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29vb29va4jzlsAAAANXRSTlMACwUHDyIbFPiSgEkpF+bPx3hFNuq9illRLSbw27OedWhkPzoy1cKtqKOXYVZOHt+5hXBtXcMn7YcAAAFVSURBVDjLfZHnlsIgEEaHBMimV9N7T9RY3//ZNqvHdV3B788cuPfAwMAzeDdbhhcCJ7FsJF9rejZGipEkN8FmcrLxPC/xxrMaM3lkGobXlRg4IebBMGQuBpSlh0PFAIJwr3aaplsmvxvE7FIfmIIo/lSl63r2/SJCq4Et07wCMwJCCEA1TQvz2sdYANuyfOALCHLLCniCKEkYsr5vPggSbDYbjScIuq7D8YMgUkphOB5dbpPLQkHOspAnYEJ0uGSDzRN0QiSoh2FCnB7jOMaApnFU2YKkabEAUI6TjJgHaFFE10rzKd+yBNK20W3eQZ7PzjunrtvS+3co8yzXb7xp3OjxGl+W/R16uT9y6toVH8vlJPsnuxF/MXFUx2nQnwcV/klRirAluk61Ogz3quOil7GoiqLYxflSVttrsFsFTfj/K/viKexbxBqu5gRVWQWqu4jP3W9sCxnRJWJdQQAAAABJRU5ErkJggg==";
	container.appendChild(img);
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4){
			if(xhr.status==200){
				container.innerHTML="";
				try{
					if(parseInt(xhr.responseText)==1){container.innerHTML="Server error"; return;}
				}catch(e){}
				try{
					container.innerHTML="";
					var comments=xhr.responseXML.documentElement.getElementsByTagName("comment");
					while(comments.length>0){
						var c=document.createElement("div");
						c.className="comment";
						var comment=document.adoptNode(comments[0]); //adoptNode will remove the current node from comments.childNodes
						c.innerHTML=new XMLSerializer().serializeToString(comment);
						container.appendChild(c);
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
function sendComment(id,t,commentsArea){
	if(t.value.isBlank()){ return;}
	var text=t.value;
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4){
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
function onFragUnload(){}
var loading=false;
function loadFragment(url,pushState){
	if(loading) return;
	loading=true;
	showNav();
	showPage();
	closeLightbox();
	onFragUnload();
	onFragUnload=function(){}
	url=unescape(url);
	if(typeof pushState == 'undefined') pushState=true;
	try{if(pushState)window.history.pushState(url, document.title, '?p='+url);}catch(e){}
	showLoading();
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4){
			if(xhr.status==200){
				var frag=I("fragment");
				frag.innerHTML=xhr.responseText;
				var scripts=frag.getElementsByTagName("script");
				for(var i=0;i<scripts.length;i++) eval(scripts[i].innerHTML);
				//try{frag.scrollIntoView({block: "start", behavior: "smooth"});}catch(e){}
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
				var commentsArea=I("_comments_");
				if(commentsArea) createCommentsForm(document.location.search.substring(3),commentsArea);
				var latest=I("_latestPost_");
				if(latest){
					var xhr3=new XMLHttpRequest();
					xhr3.onreadystatechange=function(){
						if(xhr3.readyState==4){
							if(xhr3.status==200){
								if(xhr3.responseXML){
									latest.innerHTML="";
									var d;
									var iconNode=xhr3.responseXML.getElementsByTagName("icon")[0].firstChild;
									if(iconNode){
										d=document.createElement("img");
										d.className="icon clickable";
										d.src=iconNode.nodeValue;
										latest.appendChild(d);
									}
									d=document.createElement("h4");
									d.innerHTML=xhr3.responseXML.getElementsByTagName("title")[0].firstChild.nodeValue;
									latest.appendChild(d);
									latest.innerHTML+="<div style='display:inline-block'>"+xhr3.responseXML.getElementsByTagName("description")[0].firstChild.nodeValue+"</div>";
									d=document.createElement("div");
									d.className="clear";
									latest.appendChild(d);
									d=document.createElement("div");
									d.className="clickOverlay";
									d.onclick=function(){
										loadFragment(xhr3.responseXML.getElementsByTagName("frag")[0].firstChild.nodeValue,true);
									}
									latest.appendChild(d);
								}
							}
						}
					}
					xhr3.open("POST","fetch_recentPosts.php");
					xhr3.send("random="+Math.random());
				}
			}else showError(xhr.status);
			loading=false;
		}
	}
	xhr.open("POST",url,true);
	xhr.send("random="+Math.random());
}

window.onpopstate = function(e){
    if(e.state){ loadFragment(e.state,false);}
};

function setBackgroundCfg(cfg){
	localStorage.backgroundCfg=cfg;
	new MuhTriangles("bkFrame",cfg);
}
	
function autoLoad(){
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
setInterval(function(){
	var d=document.getElementsByClassName("content");
	for(var i=0;i<d.length;i++){
		var r = d[i].getBoundingClientRect();
		if(r.top+r.height >= 0 &&r.left+r.width >= 0 &&r.bottom-r.height <= (window.innerHeight || document.documentElement.clientHeight) && r.right-r.width <= (window.innerWidth || document.documentElement.clientWidth)){if(d[i].className.indexOf(" slide")==-1) d[i].className+=" slide";}
	}
},100);
</script>
<script src="muhTriangles.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="main.css"/>
<link rel="stylesheet" type="text/css" href="comments.css"/>
<link rel="stylesheet" type="text/css" href="lightbox.css"/>
<style type="text/css">
.basic_only{
	display:none;
}
#loadStatus{
	display:block;
	width:100%;
	color:rgba(255,255,255,0.5);
	text-align:center;
}
</style>
</head>
<body onLoad="autoLoad()">
<div id="background">
	<canvas id="bkFrame" style="position:fixed; left:0; top:0; width:100%; height:100%"></canvas>
	<script type="text/javascript">
		setBackgroundCfg(localStorage.aiv4&&localStorage.backgroundCfg?localStorage.backgroundCfg:"<?=str_replace('"','\\"',$Background_DefaultConfig)?>");
		localStorage.aiv4=true;
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
	<div id="requiresJS" class="stripe">
		<div class="content">
			Sorry but this site requires Javascript.<br/>If you're paranoid and you're using NoScript or something, don't worry: there is no tracking, no iframes to external sites, nothing! The code is 100% open source, and you can check for yourself if you want!
		</div>
	</div>
	<script type="text/javascript">
		I("requiresJS").style.display="none";
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