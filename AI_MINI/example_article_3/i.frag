<div>
<link rel="stylesheet" type="text/css" href="article.css" />
<div class="basic_only">
<div class="stripe">
	<div class="content">
		<h2>Old browser</h2>
		<div class="section">
			This article shows off HTML5 features, don't you think it would be a good idea to read it with a browser that supports these features so you can see them?
		</div>
	</div>
</div>
</div>
<div class="basic_hide">
<div class="stripe">
	<div class="content">
		<h2>Simple Smooth Scrolling</h2>
		<div class="section">
			<p>
				Not all browsers implement smooth scrolling. In this article, we'll see how to implement this effect with a few lines of javascript using DOM Events and RequestAnimationFrame.<br/><br/>
				For obvious reasons, the effect is not visible on touch devices.
			</p>
		</div>
		<div class="section">
			<p>
				You are free to copy, modify and use this code as you wish.
			</p>
		</div>
	</div>
</div>
<div class="stripe">
	<div class="content">
		<h3>Code</h3>
		<div class="section">
			<p>
				Here's what we need to do:
				<ul>
					<li>Capture mouse wheel events</li>
					<li>Detect the amount to scroll in pixels</li>
					<li>Prevent event bubbling/propagation</li>
					<li>Scroll smoothly by gradually decreasing the speed</li>
				</ul>
				As usual, nothing is easy, because there are 2 incompatible ways to capture and manage those events: the DOMMouseScroll event works on Firefox 2+ and returns the scroll amount in ticks, the mousewheel event works on all other browsers except IE8- and returns the scroll amount in pixels.<br/>
				There is also a third way (attachEvent mousewheel), which is for old versions of IE (IE8-) and is deprecated. I did not implement this listener.
			</p>
		</div>
		<div class="section">
			But let's get to the code:
			<div class="code" id="js" style="max-height:70vh">
				Loading...
				<script type="text/javascript">
					loadText(I("js"),'example_article_3/smoothscroll.js',function(){highlight(I("js"),"javascript")});
				</script>
			</div>
			Please note that this is a very simple solution: if you need something more flexible, there are much more sophisticated plugins for jQuery that do this. However, they're not 800 bytes.
		</div>
	</div>
</div>
<div class="stripe">
	<div class="content">
		<h3>How to use it</h3>
		<div class="section">
			<p>
				To enable smooth scrolling on the entire page, simply use
				<div class="code" id="c1">
					smoothScroll();
				</div>
				<script type="text/javascript">highlight(I("c1"),"javascript");</script>
				Note that this does not spread to child elements.
			</p>
		</div>
		<div class="section">
			<p>
				To enable smooth scrolling on an element, use
				<div class="code" id="c2">
					smoothScroll(document.getElementById("id"));
				</div>
				<script type="text/javascript">highlight(I("c2"),"javascript");</script>
			</p>
		</div>
		<div class="section">
			<p>
				You can also specify a callback function that will be executed at each frame, right after scrolling. This allows things like a <ai_link frag="example_article_2/index.frag">parallax effect</ai_link> to be perfectly synchronized with the scroll.
				<div class="code" id="c3">
					smoothScroll(element,function(){...code...});
				</div>
				<script type="text/javascript">highlight(I("c3"),"javascript");</script>
			</p>
		</div>
		<div class="section">
			<p>
				Once smoothScroll is initialized on an element, the scrollTo function allows you to scroll to a specific position, such as a specific child.
				<div class="code" id="c4">
					e.scrollTo(e.childNodes[3].offsetTop); //scrolls to the third element inside e.
				</div>
				<script type="text/javascript">highlight(I("c4"),"javascript");</script>
			</p>
		</div>
	</div>
</div>

<div class="stripe">
	<div class="content">
		<h3>Example</h3>
		<div class="section">
			Element without smooth scrolling
			<div style="height:10em; overflow-y:auto; background-color:rgba(0,0,0,0.3)" id="example1">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel semper turpis. Aenean ut mi vitae sapien dapibus aliquet. Sed at tellus a ex mollis pretium. Morbi imperdiet rhoncus rhoncus. Ut non arcu sed sem malesuada rhoncus ac eget enim. Fusce elit urna, vestibulum ut nisi et, tincidunt pharetra nisl. Nullam tristique malesuada quam et condimentum. Vestibulum luctus eleifend rhoncus. Pellentesque rutrum eu lorem vitae feugiat.<br/><br/>
				Nam ut orci orci. In suscipit in massa eget imperdiet. Integer nec vestibulum felis, sed commodo odio. Aliquam in tempus elit. Cras rutrum, lacus sed tincidunt ullamcorper, quam enim varius dui, a auctor leo nulla sit amet erat. Proin elementum felis vel pellentesque consequat. Donec ullamcorper mollis sagittis. Suspendisse potenti. Sed eu dapibus metus. Cras ut ligula nunc. In quis quam ipsum. Fusce sed velit molestie, elementum dolor nec, tempor odio. Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br/><br/>
				Nulla a finibus ligula. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Etiam ante eros, congue a pellentesque a, luctus lacinia nulla. Praesent eget lectus felis. Integer consequat ex vel dignissim elementum. Mauris luctus consequat metus non eleifend. Vivamus nec aliquet quam, ullamcorper varius leo. Phasellus porttitor massa a posuere semper. Proin vitae pellentesque sapien. Curabitur ut accumsan massa, eget maximus metus. Donec commodo turpis ut aliquet consequat. Donec vestibulum magna ut posuere suscipit. Maecenas id eros ac ante rhoncus ultricies eu mattis ipsum.<br/><br/>
				Integer quis metus nisl. Nunc rhoncus nisl nec purus rutrum lobortis. Nunc tristique ipsum at aliquam sollicitudin. Donec fermentum lacus sed mauris molestie, et tempus risus venenatis. Mauris luctus ultricies quam, nec dictum dui sollicitudin quis. Fusce ullamcorper tincidunt arcu nec sodales. Pellentesque sit amet sem non odio blandit ullamcorper et sed nulla. Donec at dui malesuada, pellentesque mi eleifend, semper nisi. Nunc et placerat ante. Sed nisi magna, dictum in pellentesque accumsan, tincidunt nec diam.<br/><br/>
				Aliquam dignissim elementum elementum. Pellentesque at sapien interdum turpis commodo eleifend. Aenean dapibus sollicitudin ex, sed auctor eros scelerisque quis. Integer arcu sem, posuere ac nisi nec, fringilla volutpat diam. Fusce leo nunc, vestibulum nec ultrices sed, interdum sed turpis. Duis finibus velit vitae velit tempus commodo. Etiam sit amet tellus consequat, consequat risus a, dignissim urna. Phasellus non felis nunc. Suspendisse id dui accumsan, dapibus nisi in, congue turpis. Nullam nisi sem, mollis eu egestas ac, bibendum nec magna. Donec laoreet neque ipsum, in accumsan erat rhoncus a. Integer iaculis hendrerit quam, et bibendum nibh luctus nec. Etiam ultrices mollis sodales. Duis a accumsan arcu, a malesuada ante. Fusce faucibus eros et dolor lacinia, quis eleifend diam scelerisque. Nunc ac mauris non diam semper lacinia vel in massa.
			</div>
		</div>
		<div class="section">
			Element with smooth scrolling
			<div style="height:10em; overflow-y:auto; background-color:rgba(0,0,0,0.3)" id="example1s"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	if(!isBasicMode()){
		var d=document.createElement("script");
		d.type="text/javascript";
		d.src="html5cool/smooth/smoothscroll.js";
		I("fragment").appendChild(d);
		var interval=setInterval(function(){if(smoothScroll){
			smoothScroll(I("example1s")); 
			I("example1s").innerHTML=I("example1").innerHTML;
		clearInterval(interval);}},100);
	}
</script>
</div>
<div class="basic_hide">
<div class="stripe">
	<div class="content">
		<h3>Comments</h3>
		<div id="_comments_"></div>
	</div>
</div>
</div>
</div>