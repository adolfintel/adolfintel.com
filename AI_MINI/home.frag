<div>
<link rel="stylesheet" id="cssref" href="home_basic.css?20170603" />
<div class="stripe">		
	<div id="outerGradient">
		<div class="content">
			<div id="innerGradient">
				<div id="introArea" style="animation:fadeIn 0.6s linear;">
					<div>&nbsp;</div>
					<div id="bigAss">
						Lorem Ipsum
					</div>
					<div id="introText">
						<img id="basicImage" class="blockImg" src="photo_home.jpg">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam leo ligula, mollis iaculis quam sit amet, venenatis volutpat lacus. Curabitur vel tortor lorem. Curabitur libero nibh, convallis laoreet leo at, imperdiet hendrerit risus. In a mattis neque. Aliquam eget sem non massa mattis commodo. Vivamus non augue sem. Praesent semper gravida massa, quis malesuada ligula luctus eget. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam ut elementum sapien. Nullam ut libero ut sem efficitur commodo nec non enim. Sed nec enim ac tellus porttitor blandit. Cras tortor velit, elementum vitae accumsan at, pulvinar facilisis dolor. Aenean sit amet mollis leo, nec consequat nibh. Donec nec fringilla lorem.
					</div>
					<div id="sections">
						<ai_link frag="articles.php?s=1">Projects</ai_link>
						<ai_link frag="articles.php?s=2">Blog</ai_link>
						<ai_link frag="about.frag">About me</ai_link>
					</div>
				</div>
				<div id="photoArea">&nbsp;</div>
				<div class="clear"></div>
			</div>
			<div id="featArea">
				<h2>Featured article</h2>
				<div id="_featuredPost_"></div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var ua=navigator.userAgent;
		try{
			if(11 == ua.match( /(MSIE |Trident.*rv[ :])([0-9]+)/ )[ 2 ] ){
				//ie11 flexbox is broken, so we remove min-height as a workaround
				I("innerGradient").style.minHeight="auto";
			}
		}catch(e){}
		if(!isBasicMode()) I("cssref").href=I("cssref").href.replace("_basic.css",".css");
	</script>
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
