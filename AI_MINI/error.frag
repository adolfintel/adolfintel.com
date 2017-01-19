<div>
<style type="text/css">
	#bigass{
		font-size:5em;
		text-align:center;
		color:#FF9999;
		text-shadow:0 0 1em #FFAAAA,0 0 0.2em #FFAAAA;
		padding:0.5em 0;
	}
</style>
<div class="stripe">
	<div class="content" style="border:none">
		<div id="bigass">Error</div>
		<p style="text-align:center">You broke the Internet, now they're after you. Run!</p>
	</div>
	<script type="text/javascript">
		var e=window._err?window._err:Number(location.search.substring(location.search.lastIndexOf("e=")+2));
		if(isBasicMode()){
			I("bigass").innerHTML+=" "+e;
		}else{
			warp.TARGET_SPEED=0;
			window.greets=["Error "+e,"Error"," Error"];
			window.currentGreet=parseInt(Math.random()*greets.length);
			window.areaText=greets[0];
			window._home_t=setInterval(function(){
				var c=parseInt(Math.random()*Math.max(greets[currentGreet].length,areaText.length));
				var s=greets[currentGreet][c];
				if(typeof s == 'undefined') s=" ";
				while(areaText.length<c) areaText+=" ";
				areaText=(areaText.slice(0,c)+s+areaText.slice(c+1)).trim();
				I("bigass").innerHTML=areaText.isBlank()?"&nbsp;":areaText;
			},50);
			window._home_t2=setInterval(function(){
				window.currentGreet=parseInt(Math.random()*greets.length);
			},4000);
			window.onFragUnload=function(){
				clearInterval(_home_t);
				clearInterval(_home_t2);
			}
		}
	</script>
</div>
</div>