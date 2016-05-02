window.ss_raf=window.requestAnimationFrame||(function(callback,element){setTimeout(callback,1000/60);});
function smoothScroll(target,afterScroll){
	if(!target)target=window;
	target.addEventListener("mousewheel",function(e){e.preventDefault();e.stopPropagation();target.ySpd-=e.wheelDelta;}.bind(this));
	target.addEventListener("DOMMouseScroll",function(e){e.preventDefault();e.stopPropagation();target.ySpd+=e.detail*40;}.bind(this));
	target.ySpd=0;
	target.scrollTo=function(y){target.ySpd=y-target.scrollTop;}.bind(this);
	ss_frame(target,afterScroll);
}
function ss_frame(t,a){
	if(t.ySpd>0.5||t.ySpd<-0.5){
		if(t===window) t.scrollBy(0,t.ySpd*0.05); else t.scrollTop+=Math.round(t.ySpd*0.05);
		t.ySpd*=0.95;
	}
	if(a)a();
	ss_raf(function(){ss_frame(t,a)});
}
