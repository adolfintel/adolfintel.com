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
if(b.n=="i"){	//IE 10+
	if(b.v<10) gotoBasic();
}else
if(b.n=="f"){	//FF 5+
	if(b.v<5) gotoBasic();
}else
if(b.n=="c"){	//Chrome 8+
	if(b.v<8) gotoBasic();
}else
if(b.n=="o"){	//Opera 15+
	if(b.v<15) gotoBasic();
}else
if(b.n=="s"){	//Safari 8+ (not tested)
	if(b.v<8) gotoBasic();
}else
if(!(window.XMLHttpRequest&&localStorage&&!!window.HTMLCanvasElement&&document.createElement("div").style.animationName!==undefined)){ //unknown browser. check XHR, localStorage, Canvas and CSS Animation support
	gotoBasic();
}
	
function isBasicMode(){
	return false;
}
function showNav(){
	document.getElementById("nav").style.display='';
}
function hideNav(){
	document.getElementById("nav").style.display='none';
}
function showPage(){
	document.getElementById("fragment").style.display='';
}
function hidePage(){
	document.getElementById("fragment").style.display='none';
}
function openLightbox(imgUrl){
	document.getElementById("lbimg").src=imgUrl;
	document.getElementById("lightbox").style.display='';
}
function closeLightbox(){
	document.getElementById("lightbox").style.display='none';
	document.getElementById("lbimg").src="";
}

setInterval(function(){
	var lb=document.getElementById("lightbox"), img=document.getElementById("lbimg");
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
		document.getElementById("loadStatus").innerHTML=lStatus>=loadingStatuses.length?loadingStatuses[loadingStatuses.length-1]:loadingStatuses[lStatus++];
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
		var frag=document.getElementById("fragment");
		stripe.appendChild(c);
		stripe.appendChild(d);
		frag.innerHTML="";
		frag.appendChild(stripe);
	}catch(e){
		document.getElementById("fragment").innerHTML="";
	}
}
function showError(err){
	var frag=document.getElementById("fragment");
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
var loading=false;
function loadFragment(url,pushState){
	if(loading) return;
	loading=true;
	showNav();
	showPage();
	closeLightbox();
	try{if(pushState)window.history.pushState(url, document.title, '?p='+url);}catch(e){}
	showLoading();
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4){
			if(xhr.status==200){
				var frag=document.getElementById("fragment");
				frag.innerHTML=xhr.responseText;
				var scripts=frag.getElementsByTagName("script");
				for(var i=0;i<scripts.length;i++) eval(scripts[i].innerHTML);
				try{frag.scrollIntoView({block: "start", behavior: "smooth"});}catch(e){}
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
				var commentsArea=document.getElementById("_comments_");
				if(commentsArea){
					var iframe=document.createElement("iframe");
					iframe.src="comments.html?p="+document.location.search.substring(1);
					iframe.style.width="100%";
					commentsArea.innerHTML="";
					commentsArea.appendChild(iframe);
				}
				var latest=document.getElementById("_latestPost_");
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
									latest.innerHTML+=xhr3.responseXML.getElementsByTagName("description")[0].firstChild.nodeValue;
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
	var c=document.getElementById("bkFrame");
	c.contentWindow.location.replace("<?=$Background_Page?>?"+cfg);
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

setInterval(function(){
	try{
		var iframes=document.getElementById("fragment").getElementsByTagName("iframe");
		for(var i=0;i<iframes.length;i++){
			var x=iframes[i];
			x.style.height=x.contentDocument.getElementsByTagName("body")[0].clientHeight+"px";
		}
	}catch(e){}
},50);

</script>
<link rel="stylesheet" type="text/css" href="main.css"/>
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
	<iframe id="bkFrame" src="" style="width:100%; height:100%;" scrolling="no"></iframe>
	<script type="text/javascript">
		if(localStorage.backgroundCfg){
			document.getElementById("bkFrame").src="<?=$Background_Page?>?"+localStorage.backgroundCfg;
		}else{
			setBackgroundCfg("<?=str_replace('"','\\"',$Background_DefaultConfig)?>");
		}
	</script>
</div>
<div id="page">
	<div id="nav">
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
		document.getElementById("requiresJS").style.display="none";
		document.getElementById("campaign-icon").style.display="none";
	</script>
	<div id="fragment">
	</div>
</div>
<div id="lightbox" onClick="closeLightbox()">
	<img id="lbimg" onClick="closeLightbox()" src="null.png"/>
</div>
</body>
</html>