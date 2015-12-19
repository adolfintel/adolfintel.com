<?php
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
<?php
	include '_config.php';
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
<link rel="stylesheet" type="text/css" href="main.css" />
<link rel="icon" href="favicon.ico" />
<script type="text/javascript">
String.prototype.isBlank=function(){
	return !this || /^\s*$/.test(this);
}
//check browser and redirect to full mode if compatible. browser check code is a modified version of https://browser-update.org/
function gotoFull(){
	document.location.href="index.php"+(document.location.search.isBlank()?"":document.location.search);
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
	if(b.v>=10) gotoFull();
}else
if(b.n=="f"){	//FF 5+
	if(b.v>=5) gotoFull();
}else
if(b.n=="c"){	//Chrome 8+
	if(b.v>=8) gotoFull();
}else
if(b.n=="o"){	//Opera 15+
	if(b.v>=15) gotoFull();
}else
if(b.n=="s"){	//Safari 8+ (not tested)
	if(b.v>=8) gotoFull();
}else
if(window.XMLHttpRequest&&localStorage&&!!window.HTMLCanvasElement&&document.createElement("div").style.animationName!==undefined){ //unknown browser. check XHR, localStorage, Canvas and CSS Animation support
	gotoFull();
}
function isBasicMode(){
	return true;
}
function loadFragment(url,pushState){
	document.location.href="basic.php?p="+url;
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
	window.open(imgUrl,"_blank");
}
function closeLightbox(){
}
function showLoading(){
	document.getElementById("fragment").innerHTML="";
}
function showError(err){
	alert("Error "+err);
}
function setBackgroundCfg(cfg){
	alert("Operation not supported when in Basic HTML mode");
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
<style type="text/css">
.basic_hide{
	display:none;
}
</style>
<link rel="stylesheet" type="text/css" href="basic_overrides.css" />
</head>
<body>
	<div id="nav">
		<?php
			ob_start();
			include($NavFrag);
			echo ob_get_clean();
		?>
	</div>
	<img id="campaign-icon" src="<?=$socialImg?$socialImg:"campaign-icon.png" ?>" />
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
				include($phpinclude);
				echo ob_get_clean();
			?>
		</div>
	</div>
</body>
</html>
<?php 
	unlink('error_log'); //lol
?>