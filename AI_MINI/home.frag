<div>
<link rel="stylesheet" href="home.css?20170222" />
<div class="basic_only">
<div class="stripe">
	<div class="content">
		<!--INTRO FOR BASIC MODE-->
		<div>
			<img src="photo_home.jpg" id="basicPhoto"/>
			<h4 id="basicTitle" style="margin-top:0">Lorem Ipsum</h4>
			<span id="basicIntro">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam leo ligula, mollis iaculis quam sit amet, venenatis volutpat lacus. Curabitur vel tortor lorem. Curabitur libero nibh, convallis laoreet leo at, imperdiet hendrerit risus. In a mattis neque. Aliquam eget sem non massa mattis commodo. Vivamus non augue sem. Praesent semper gravida massa, quis malesuada ligula luctus eget. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam ut elementum sapien. Nullam ut libero ut sem efficitur commodo nec non enim. Sed nec enim ac tellus porttitor blandit. Cras tortor velit, elementum vitae accumsan at, pulvinar facilisis dolor. Aenean sit amet mollis leo, nec consequat nibh. Donec nec fringilla lorem.
			</span>
			<div class="clear"></div>
		</div>
		<div id="basicLinks">
			<span id="link1"><ai_link frag="articles.php?s=1">Projects</ai_link></span>
			<span id="link2"><ai_link frag="articles.php?s=2">My blog</ai_link></span>
			<span id="link3"><ai_link frag="about.frag">About me</ai_link></span>
		</div>
	</div>
</div>
</div>

<div class="basic_hide">
	<!--INTRO FOR FULL MODE (intro and text links are copied from the basic intro)-->
	<div id="outerGradient">
		<div id="innerGradient">
			<div id="introArea" style="animation:fadeIn 0.6s linear;">
				<div>&nbsp;</div>
				<div id="bigAss"></div>
				<div id="introText"></div>
				<div id="cubesArea">
				<div class="cubeContainer">
				  <div class="cube" style="animation-delay:-15s;">
					<div style="background-color:#3F51B5" alt="Front" ></div>
					<div style="background-color:#1A237E" alt="Back" ></div>
					<div style="background-color:#283593" alt="Right" ></div>
					<div style="background-color:#303F9F" alt="Left" ></div>
					<div style="background-color:#3949AB" alt="Top" ></div>
					<div style="background-color:#3147C0" alt="Bottom" ></div>
				  </div>
				  <div class="text">
					<div id="l1" onclick="flash('#8C9EFF')"></div>
				  </div>
				</div>

				<div class="cubeContainer">
				  <div class="cube" style="animation-delay:-5s;">
					<div style="background-color:#F44336" alt="Front" ></div>
					<div style="background-color:#B71C1C" alt="Back" ></div>
					<div style="background-color:#C62828" alt="Right" ></div>
					<div style="background-color:#D32F2F" alt="Left" ></div>
					<div style="background-color:#E53935" alt="Top" ></div>
					<div style="background-color:#EF3B38" alt="Bottom" ></div>
				  </div>
				  <div class="text">
					<div id="l2" onclick="flash('#FF8A80')"></div>
				  </div>
				</div>

				<div class="cubeContainer">
				  <div class="cube" style="animation-delay:-35s;">
					<div style="background-color:#4CAF50" alt="Front" ></div>
					<div style="background-color:#1B5E20" alt="Back" ></div>
					<div style="background-color:#2E7D32" alt="Right" ></div>
					<div style="background-color:#388E3C" alt="Left" ></div>
					<div style="background-color:#43A047" alt="Top" ></div>
					<div style="background-color:#3CBB42" alt="Bottom" ></div>
				  </div>
				  <div class="text">
					<div id="l3" onclick="flash('#B9F6CA')"></div>
				  </div>
				</div>
			</div>
			</div>
			<div id="photoArea">&nbsp;</div>
			<div class="clear"></div>
		</div>
	</div>
	
	<script type="text/javascript">
		I("introText").innerHTML=I("basicIntro").innerHTML;
		I("bigAss").innerHTML=I("basicTitle").innerHTML;
		I("l1").innerHTML=I("link1").innerHTML;
		I("l2").innerHTML=I("link2").innerHTML;
		I("l3").innerHTML=I("link3").innerHTML;
		var ua=navigator.userAgent;
		try{
			if(11 == ua.match( /(MSIE |Trident.*rv[ :])([0-9]+)/ )[ 2 ] ){
				//ie11 flexbox is broken, so we remove min-height as a workaround
				I("innerGradient").style.minHeight="auto";
			}
		}catch(e){}
		if((/Safari.(\d+)/i.test(ua))&&!(/Chrome.(\d+)/i.test(ua))){
			//safari can't into cubes, hide them
			I("cubesArea").style.display="none";
		}
	</script>
</div>

<div class="stripe" style="padding-top:0">
	<div class="content" style="border-bottom:none">
		<h2>Featured article</h2>
		<div id="_featuredPost_"></div>
	</div>
</div>

<div class="basic_only">
	<div class="stripe">
		<div class="content" style="border-bottom:none">
			<h2>Unsupported browser!</h2>
			<p>
				You are using an old or unsupported browser, so the site is in Basic mode, which provides only limited functionality and doesn't look very good.<br/>
				Consider updating it as soon as possible to something more modern like <ai_link ext="http://www.firefox.com">Mozilla Firefox</ai_link>.
			</p>
		</div>
	</div>
</div>

</div>
