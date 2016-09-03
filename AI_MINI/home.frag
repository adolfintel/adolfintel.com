<div>
<link rel="stylesheet" href="home.css?20160822" />
<div id="greetsContainer" class="stripe" style="padding-top:0">
	<div class="content" style="padding-bottom:1em">
		<div id="bigass">Hello!</div>
		<script type="text/javascript">
			if(!isBasicMode()){
				window.greets=["Hello","Hi","Greetings","Welcome","Benvenuto","Ciao","Namaste","Hola","Salut","Hallo","God dag","Willkommen","Love"];
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
<div class="stripe" style="padding-top:0;">
	<div class="content">
		<div id="leftPanel">
			<div>
				<div id="photo_mobile">&nbsp;</div>
				<img id="photo_desktop" src="photo_small.jpg"/>
			</div>
			<div id="sections">
				<ai_link frag="articles.php?s=1">Projects</ai_link>
				<ai_link frag="articles.php?s=2">Blog</ai_link>
				<ai_link frag="about.frag">About me</ai_link>
			</div>
		</div>
		<div id="rightPanel">
			<h4 id="intro_title">Greetings, stranger!</h4>
			<p id="intro">			
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent dignissim tellus eget mauris facilisis, ut gravida leo lacinia. Fusce vel pulvinar ante. Nullam eget condimentum nisl, ut consequat ante. Integer faucibus ultricies eleifend. Vivamus laoreet id ipsum vitae viverra. Vivamus orci metus, iaculis egestas lobortis ac, tincidunt sit amet orci. Aliquam venenatis euismod aliquet. Suspendisse ornare faucibus magna, a facilisis nisi aliquet eget. Fusce sit amet fermentum ipsum. Duis sodales bibendum augue ut fringilla. In euismod turpis justo. Etiam luctus ipsum in fringilla consectetur.
			</p>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="stripe" style="padding-top:0;">
	<div class="content">
		<h2>Last post</h2>
		<div id="_latestPost_" style="font-size:0.9em;"></div>
	</div>
</div>
<div class="basic_only">
	<div class="stripe">
		<div class="content">
			<h2>Unsupported browser!</h2>
			<p>
				You are using an old or unsupported browser, so the site is in Basic mode, which provides only limited functionality and doesn't look very good.<br/>
				Consider updating it as soon as possible to something more modern like <ai_link ext="http://www.firefox.com">Mozilla Firefox</ai_link>.
			</p>
		</div>
	</div>
</div>

</div>
