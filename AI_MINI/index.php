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
											var tfrag=xhr3.responseXML.getElementsByTagName("frag")[0].firstChild.nodeValue;
											d.innerHTML="<ai_link frag='"+tfrag+"'style='text-decoration:none'>"+xhr3.responseXML.getElementsByTagName("title")[0].firstChild.nodeValue+"</ai_link>";
											latest.appendChild(d);
											latest.innerHTML+="<div style='display:inline-block'>"+xhr3.responseXML.getElementsByTagName("description")[0].firstChild.nodeValue+"</div>";
											d=document.createElement("div");
											d.className="clear";
											latest.appendChild(d);
											d=document.createElement("ai_link");
											d.className="clickOverlay";
											d.setAttribute('frag',tfrag);
											latest.appendChild(d);
											parseLinks();
										}
									}
								}
							}
							xhr3.open("POST","fetch_recentPosts.php");
							xhr3.send("random="+Math.random());
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

function setBackgroundCfg(cfg){
	localStorage.backgroundCfg=cfg;
	new MuhTriangles("bkFrame",cfg);
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
<script src="muhTriangles.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="main.css?20160701"/>
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