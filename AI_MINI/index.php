<?php
	include '_config.php';
	if($ForceHTTPS_full && $_SERVER["HTTPS"] != "on"){
		header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
		exit();
	}
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
<title><?=htmlspecialchars($Site_Title)?></title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, minimum-scale=1, maximum-scale=1" />
<meta name="description" content="<?=htmlspecialchars($Site_Description)?>" />
<meta name="keywords" content="<?=$Site_Keywords?>" />
<meta name="author" content="<?=htmlspecialchars($Site_Author)?>" />
<meta property="og:site_name" content="<?=htmlspecialchars($Site_Title)?>"/>
<meta name="theme-color" content="<?=$Chrome_TabColor?>"/>
<link rel="icon" href="favicon.png" />
<script type="text/javascript">
String.prototype.isBlank=function(){
	return !this || /^\s*$/.test(this);
}
function parseLocationSearchToJSON(){
	var r=[];
	if(document.location.search.isBlank()) return r;
	var parts=document.location.search.split("&");
	if(parts[0].indexOf("?")==0) parts[0]=parts[0].substring(1);
	for(var i=0;i<parts.length;i++){
		var eq=parts[i].indexOf("=");
		var p;
		if(eq==-1) p=[parts[i]]; else p=[parts[i].substr(0,eq),parts[i].substr(eq+1,parts[i].length)];
		r[p[0]]=p.length==1?null:p[1];
	}
	return r;
}
window.I=function(i){return document.getElementById(i);};
//check browser and redirect to basic mode if incompatible
function gotoBasic(){
	if(window.localStorage){
		if(localStorage.noSwitch)return;
	}
	document.location.href="basic.php"+(document.location.search.isBlank()?"":document.location.search);
}
if(!(window.XMLHttpRequest&&window.JSON&&window.localStorage&&!!window.HTMLCanvasElement&&document.createElement("div").style.animationName!==undefined&&document.createElement("div").style.flex!==undefined)){	//any browser with XHR, JSON, localStorage, Canvas, CSS Animation, Flex
	gotoBasic();
}
<?php if($Safari_ForceBasic){ ?>{var ua=navigator.userAgent;if((/Safari.(\d+)/i.test(ua))&&!(/Chrome.(\d+)/i.test(ua))){gotoBasic();}}<?php } ?>

//when going back/forward in history, do not store scroll position
if ('scrollRestoration' in history) {
  history.scrollRestoration = 'manual';
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
var inLightbox=true;
var viewport = document.querySelector("meta[name=viewport]");
function openLightbox(imgUrl){
	try{viewport.setAttribute('content','width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=3.0, user-scalable=yes');}catch(e){}
	I("lbimg").src=imgUrl;
	I("lightbox").style.display='';
	inLightbox=true;
}
function closeLightbox(){
	try{viewport.setAttribute('content','width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no');}catch(e){}
	I("lightbox").style.display='none';
	I("lbimg").src="";
	inLightbox=false;
}
function escapeCode(s){
	return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br/>').replace(/\t/g,'&emsp;&emsp;').replace(/\s/g,'&nbsp;');
}
function loadText(target,url,onDone,noEscape){
	var xhr=new XMLHttpRequest();
	xhr.onreadystatechange=function(){
		if(xhr.readyState==4&&xhr.status==200){
			target.innerHTML=noEscape?xhr.responseText:escapeCode(xhr.responseText);
			if(onDone)onDone();
		}
	}.bind(this);
	xhr.open("GET",url,true);
	xhr.send();
}
function highlight(target,lang,escape){
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
	if(escape) target.innerHTML=escapeCode(target.innerHTML);
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

var flashing=false;
function flash(color){
	if(flashing) return; else flashing=true;
	var f=document.createElement("div");
	f.className="flashFx";
	f.style.backgroundColor=color;
	f.addEventListener('animationend',function(){
		f.parentElement.removeChild(f);
		flashing=false;
	}.bind(this));
	document.body.appendChild(f);
}

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
	<?php if($Comment_System!="builtin"){ ?>
        loadComments(id,container);
	<?php } else { ?>
		var f=document.createElement("form");
		var e=document.createElement("input");
		e.name="email";
		e.type="text";
		e.setAttribute("placeholder","Email (optional, private)");
		f.appendChild(e);
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
		b.onclick=function(){sendComment(id,t,e,c);};
		loadComments(id,c);
	<?php } ?>
	
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
	<?php if($Comment_System=="disqus"){ ?>
		var d=document.createElement("div");
		d.id="disqus_thread";
		container.appendChild(d);
		try{
			//IE<10 not supported
			var ua = navigator.userAgent.toLowerCase();
			if(ua.indexOf('msie')!=-1&&parseInt(ua.split('msie')[1])<10){
				d.innerHTML="Disqus not supported on this browser";
				return;
			}
		}catch(e){}
		try{
			window.disqus_config = function () {
				this.page.url = location.href.replace("/index.php","/").replace("https://","http://");
				this.page.identifier = id;
			};
			if(typeof DISQUS !== "undefined"){ //disqus already loaded
				DISQUS.reset({reload:true,config:disqus_config});
			}else{
				(function() {
					var d = document, s = d.createElement('script');
					s.src = '//<?=$Disqus_Shortname?>.disqus.com/embed.js';
					s.setAttribute('data-timestamp', +new Date());
					(d.head || d.body).appendChild(s);
					
				})();
			}			
		}catch(e){
			d.innerHTML="Disqus failed to load";
		}
	<?php } else if($Comment_System=="builtin"){ ?>
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
	<?php } else if($Comment_System=="commentoio"){ ?>
        var d=document.createElement("iframe");
        d.src="COMMENTO/"+id+"?embed=true";
        d.style.width="100%";
        container.appendChild(d);
    <?php } ?>
}
<?php if($Comment_System=="builtin"){ ?>
var sending=false;
function punishXSS(){
    //a little surprise for people trying to XSS this site
    alert("Naughty boy, you must be punished");
    var annoy=function(){
        for(var i=0;i<10000;i++){
            var d=document.createElement("div");
            d.style.position="fixed";
            d.style.top=0; d.style.left=0;
            d.style.width="100vw"; d.style.height="100vh";
            d.style.zIndex=i;
            d.style.backgroundColor="#FFFFFF02";
            document.body.appendChild(d);
        }
        setTimeout(annoy,0);
    }
    annoy();
}
function sendComment(id,t,e,commentsArea){
	if(t.value.isBlank()||sending){ return;}
	try{
        if(t.value.length<100){
            var temp=document.createElement("div");
            temp.innerHTML=t.value;
            if(temp.getElementsByTagName("script").length>0){
                t.value="I tried to XSS this site and I was punished for it";
                setTimeout(punishXSS(),100);
            }
        }
	}catch(ex){console.log(ex);}
	sending=true;
	var text=t.value;
	var email=e.value;
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
	params+="id="+encodeURIComponent(id)+"&text="+encodeURIComponent(text)+"&email="+encodeURIComponent(email)+"&r="+Math.random();
	xhr.open("POST","postComment.php",true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader("Content-length", params.length);
	xhr.setRequestHeader("Connection", "close");
	xhr.send(params);
}
<?php } ?>
function parseLinks(){
	var d=document.getElementsByTagName("ai_link");
	while(d.length>0){
		var n=document.createElement("a");
		for(var j=0;j<d[0].attributes.length;j++){
			try{n.setAttribute(d[0].attributes.item(j).nodeName,d[0].attributes.item(j).value);}catch(e){}
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
var loading=false, currentFrag="";
var loadLater=[];
function loadFragment(url,pushState){
	if(loading){
		loadLater.push([url,pushState]);
	}
	loading=true;
	flash("rgba(255,255,255,0.5)");
	if(ai_background)ai_background.loadStart();
	showNav();
	showPage();
	closeLightbox();
	onFragUnload();
	onFragUnload=function(){}
	url=unescape(url);
	if(typeof pushState == 'undefined') pushState=true;
	try{if(pushState){currentFrag=url; window.history.pushState(url, document.title, '/?p='+url);}}catch(e){}
	if(isDesktop()){
		//prevent the page from scrolling up when a loading is triggered (because fragment is removed and page becomes 0px tall). Mobile mode uses a different layout so it's not necessary.
		I("page").style.height=I("page").scrollHeight+"px"; 
	}
	fadeCurrentFrag(function(){
		if(isDesktop()){
			//now it can scroll up
			I("page").style.height="";
			window.scrollBy(0,-9999999);
		}
		showLoading();
		var xhr=new XMLHttpRequest();
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4){
				if(xhr.status==200){
					fadeCurrentFrag(function(){
						loading=false;
						flash("rgba(255,255,255,0.5)");
						if(ai_background)ai_background.loadDone();
						var frag=I("fragment");
						frag.innerHTML=xhr.responseText;
						var footer=document.createElement("div");
						footer.id="footer";
						frag.appendChild(footer);
						loadText(footer,"<?=$FooterFrag?>",function(){parseLinks()},true);
						document.title="<?=htmlspecialchars($Site_Title)?>";
						var scripts=frag.getElementsByTagName("script");
						for(var i=0;i<scripts.length;i++) eval(scripts[i].innerHTML);
						parseLinks();
						var xhr2=new XMLHttpRequest();
						xhr2.onreadystatechange=function(){
							if(xhr2.readyState==4){
								if(xhr2.status==200){
									var fragInfo=JSON.parse(xhr2.responseText);
									if(!!fragInfo.title) document.title=fragInfo.title+" - <?=htmlspecialchars($Site_Title)?>";
									var aTitle=I("_articleTitle_");
									if(aTitle)aTitle.id="article_title";
									aTitle=I("article_title");
									if(aTitle){aTitle.innerHTML=(!!fragInfo.title)?fragInfo.title:"";}
								}
							}
						}
						xhr2.open("POST","fetch_frag_info.php?p="+url);
						xhr2.send("random="+Math.random());
						var shareArea=I("_share_");
						if(shareArea) createShareLinks(document.location.href,shareArea);
						var oldC=I("_comments_");
						if(oldC)oldC.id="article_comments";
						var commentsArea=I("article_comments");
						if(commentsArea) createCommentsForm(document.location.search.substring(3),commentsArea);
						var latest=I("_latestPost_");
						if(latest){
							var xlp=new XMLHttpRequest();
							xlp.onreadystatechange=function(){
								if(xlp.readyState==4){
									if(xlp.status==200){
										latest.innerHTML=xlp.responseText;
										parseLinks();
									}
								}
							}
							xlp.open("GET","articles.php?lastPost=true&random="+Math.random());
							xlp.send();
						}
						var featured=I("_featuredPost_");
						if(featured){
							var xlp2=new XMLHttpRequest();
							xlp2.onreadystatechange=function(){
								if(xlp2.readyState==4){
									if(xlp2.status==200){
										featured.innerHTML=xlp2.responseText;
										parseLinks();
									}
								}
							}
							xlp2.open("GET","articles.php?lastPost=featured&random="+Math.random());
							xlp2.send();
						}
					});
					
				}else{loading=false; showError(xhr.status);}
			}
		}
		xhr.open("POST",url.toLowerCase().substr(url.length-3)==".md"?("md.php?p="+url):url,true);
		xhr.send("random="+Math.random());
	});
}
setInterval(function(){
	if(loading) return;
	if(loadLater.length>0){
		var data=loadLater.shift();
		loadFragment(data[0],data[1]);
	}
},100);

window.onpopstate = function(e){
	//TODO: figure out why clearurls ff extension corrupts e.state
	if(inLightbox){closeLightbox(); window.history.pushState(currentFrag, document.title, '/?p='+currentFrag); return;}
    if(e.state) loadFragment(e.state,false);
};
	
function autoLoad(){
	parseLinks();
	closeLightbox();
	try{
		var req=parseLocationSearchToJSON();
		if(typeof req["p"] === "undefined") throw("");
		loadFragment(req["p"],true);
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

setInterval(function(){
	var articleEntries=document.getElementsByClassName("articleEntry");
	for(var i=0;i<articleEntries.length;i++){
		if(!articleEntries[i].lazyLoadDone&&isVisible(articleEntries[i])){
			articleEntries[i].lazyLoadDone=true;
			articleEntries[i].getElementsByClassName("background")[0].style.backgroundImage="url('"+articleEntries[i].getAttribute("lazyLoadBkUrl")+"')";
		}
	}
},100);

var ai_background;

</script>
<script src="<?=$Background_JS ?>?20230728" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="main.css?20230728"/>
<link rel="stylesheet" type="text/css" href="print.css?20230728" media="print"/>
<style type="text/css">
.basic_only{
	display:none;
}
</style>

</head>
<body onload="autoLoad()">
<div id="background">
	<canvas id="bkFrame"></canvas>
	<script type="text/javascript">
		ai_background=new <?=$Background_ClassName?>("bkFrame",<?=$Background_Config?>);
	</script>
</div>
<div id="nav" onClick="toggleNavExp()">
	<?php
		ob_start();
		include($NavFrag);
		echo ob_get_clean();
	?>
</div>
<div id="page">
	<img id="campaign-icon" src="campaign-icon.png" />
	<script type="text/javascript">
		I("campaign-icon").style.display="none";
	</script>
	<div id="fragment"></div>
</div>
<div id="lightbox" onClick="closeLightbox()">
	<img id="lbimg" onClick="closeLightbox()" src="null.png"/>
</div>
<div id="resp_test">&nbsp;</div>
</body>
</html>
