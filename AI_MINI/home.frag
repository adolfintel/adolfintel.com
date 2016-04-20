<div>
<link rel="stylesheet" href="home.css" />
<div class="stripe">
	<div class="content">
		<div id="bigass">Hello!</div>
		<p id="intro">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent dignissim tellus eget mauris facilisis, ut gravida leo lacinia. Fusce vel pulvinar ante. Nullam eget condimentum nisl, ut consequat ante. Integer faucibus ultricies eleifend. Vivamus laoreet id ipsum vitae viverra. Vivamus orci metus, iaculis egestas lobortis ac, tincidunt sit amet orci. Aliquam venenatis euismod aliquet. Suspendisse ornare faucibus magna, a facilisis nisi aliquet eget. Fusce sit amet fermentum ipsum. Duis sodales bibendum augue ut fringilla. In euismod turpis justo. Etiam luctus ipsum in fringilla consectetur. 
		</p>
		<div class="basic_hide">
				<div id="buttons">
					<a onclick="loadFragment('articles.php?s=1')" class="button blue">Projects</a>
					<a onclick="loadFragment('articles.php?s=2')" class="button red">Blog</a>
					<a onclick="loadFragment('about.frag')" class="button green">About me</a>
				</div>
		</div>
		<script type="text/javascript">
			if(!isBasicMode()){
				window.greets=["Hello","Hi","Greetings","Welcome","Benvenuto","Ciao","Namaste","Hola","Salut","Hallo","God dag","Shalom","Love"];
				window.currentGreet=parseInt(Math.random()*greets.length);
				window.areaText=greets[0];
				window._home_t=setInterval(function(){
					var c=parseInt(Math.random()*Math.max(greets[currentGreet].length,areaText.length));
					var s=greets[currentGreet][c];
					if(typeof s == 'undefined') s=" ";
					while(areaText.length<c) areaText+=" ";
					areaText=areaText.slice(0,c)+s+areaText.slice(c+1);
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
<div class="basic_only">
	<div class="stripe">
		<div class="content">
			<h2>Unsupported browser!</h2>
			<p>
				You are using an old or unsupported browser, so the site is in Basic mode, which provides only limited functionality and doesn't look very good.<br/>
				Consider updating it as soon as possible to something more modern like <a href="http://www.firefox.com">Mozilla Firefox</a>.
			</p>
		</div>
	</div>
</div>
<div class="basic_hide">
	<div class="stripe">
		<div class="content">
			<h2>Last post</h2>
			<div id="_latestPost_"></div>
		</div>
	</div>
</div>
<div class="basic_hide">
	<div style="height:120vh">
		<!-- space waster so the user can admire the background -->
		&nbsp;
	</div>
	<div class="stripe">
		<div class="content">
			<h2>Enjoying the view?</h2>
			<p>
				You can <a onClick="loadFragment('empty.frag')">hide the page</a> to enjoy the background. Press back to come back.
			</p>
		</div>
	</div>
</div>

</div>
