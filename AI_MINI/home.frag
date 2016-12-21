<div>
<link rel="stylesheet" href="home.css?20161222" />

<div class="stripe">
	<div class="content">
	<div class="basic_only">
		<!--INTRO FOR BASIC MODE-->
		<div>
			<img src="photo_small.jpg" id="basicPhoto"/>
			<span id="basicIntro">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tincidunt porta metus, vel luctus lectus lobortis vitae. Mauris et massa a tellus venenatis facilisis sit amet id justo. Nam fringilla justo et odio sodales scelerisque. Nullam porttitor libero in ligula maximus, eget ornare urna luctus. Sed elementum erat a lorem molestie aliquam nec in arcu. Nunc nec metus rutrum, tristique nibh gravida, laoreet ligula. Praesent condimentum nulla purus, et tempus purus pellentesque dictum. Duis turpis elit, varius eget malesuada eget, malesuada vel sem. Duis eleifend, velit ut dictum vehicula, ex neque feugiat libero, vitae cursus leo enim ac purus. Vivamus blandit massa vel porttitor posuere. Sed blandit, lectus sed ultrices ornare, mauris sem aliquet libero, eget pharetra leo erat sit amet enim.
			</span>
			<div class="clear"></div>
		</div>
		<div id="basicLinks">
			<span id="link1"><ai_link frag="articles.php?s=1">Projects</ai_link></span>
			<span id="link2"><ai_link frag="articles.php?s=2">My blog</ai_link></span>
			<span id="link3"><ai_link frag="about.frag">About me</ai_link></span>
		</div>
	</div>
	<div class="basic_hide">
		<!--INTRO FOR FULL MODE-->
		<div id="photoArea">
			<div class="clear"></div>
			<div id="cubesArea">
				<div id="introText"></div>
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
			<script type="text/javascript">
				I("introText").innerHTML=I("basicIntro").innerHTML;
				I("l1").innerHTML=I("link1").innerHTML;
				I("l2").innerHTML=I("link2").innerHTML;
				I("l3").innerHTML=I("link3").innerHTML;
			</script>
			<div class="clear"></div>
		</div>
	</div>
	

	</div>
</div>
<div class="stripe" style="padding-top:0">
	<div class="content">
		<h2>Featured article</h2>
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
