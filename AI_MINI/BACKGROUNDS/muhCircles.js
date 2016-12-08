//LEGACY!!!
//SHIT CODE & DOES NOT LOOK GOOD IN NEW DESIGN
//ALSO, INCOMPLETE PORTING

var circles=[];
function Circle(x,y,r,l,c,animV,phase){
	this.x=x;
	this.y=y;
	this.r=r;
	this.l=l;
	this.c=c;
	this.animV=animV;
	this.phase=phase%Math.PI*2;
}

var CIRCLES_PER_STRAND=200;
var L_COLOR_H=221, L_COLOR_S=81, L_COLOR_L=50;
var R_COLOR_H=263, R_COLOR_S=81, R_COLOR_L=50;
var COLOR_H_VARIANCE=10, COLOR_S_VARIANCE=5, COLOR_L_VARIANCE=0;
var MIN_Z=0.01, MAX_Z=2;
var X_OFF_L=-0.3, X_OFF_R=0.3, Y_OFF_L=0.5, Y_OFF_R=0.51;
var X_VARIANCE=0.04, Y_VARIANCE=0.04;
var RADIUS=0.35, RADIUS_VARIANCE=0.07;
var LINE_WIDTH=0.007;
var X_ANIM_VARIANCE=0.02, Y_ANIM_VARIANCE=0.02;
var BACKGROUND1_H=0, BACKGROUND1_S=0, BACKGROUND1_L=0;
var BACKGROUND2_H=243, BACKGROUND2_S=81, BACKGROUND2_L=20;
var ANIM_SPEED_MIN=1, ANIM_SPEED_MAX=1, ANIM_FREQUENCY=0;
var CENTER_X=0.5, CENTER_Y=0;
var INTERVAL=50;


function MuhCircles(targetId,config){ //todo: port config parameters
	this.canvas=document.getElementById(targetId);
	this.prevW=-1; this.prevH=-1;
	var z=MIN_Z, zStep=(MAX_Z-MIN_Z)/CIRCLES_PER_STRAND;
	for(var i=0;i<CIRCLES_PER_STRAND;i++){
		circles.push(new Circle(CENTER_X+z*(X_OFF_L+Math.random()*X_VARIANCE-X_VARIANCE/2),CENTER_Y+z*(Y_OFF_L+Math.random()*Y_VARIANCE-Y_VARIANCE/2),z*(RADIUS+Math.random()*RADIUS_VARIANCE-RADIUS_VARIANCE/2),LINE_WIDTH*z, 'hsl('+(L_COLOR_H+Math.random()*COLOR_H_VARIANCE-COLOR_H_VARIANCE/2)+','+(L_COLOR_S+Math.random()*COLOR_S_VARIANCE-COLOR_S_VARIANCE/2)+'%,'+(z*(L_COLOR_L+Math.random()*COLOR_L_VARIANCE-COLOR_L_VARIANCE/2))+'%)',z,z*2));
		z+=zStep/2;
		circles.push(new Circle(CENTER_X+z*(X_OFF_R+Math.random()*X_VARIANCE-X_VARIANCE/2),CENTER_Y+z*(Y_OFF_R+Math.random()*Y_VARIANCE-Y_VARIANCE/2),z*(RADIUS+Math.random()*RADIUS_VARIANCE-RADIUS_VARIANCE/2),LINE_WIDTH*z, 'hsl('+(R_COLOR_H+Math.random()*COLOR_H_VARIANCE-COLOR_H_VARIANCE/2)+','+(R_COLOR_S+Math.random()*COLOR_S_VARIANCE-COLOR_S_VARIANCE/2)+'%,'+(z*(R_COLOR_L+Math.random()*COLOR_L_VARIANCE-COLOR_L_VARIANCE/2))+'%)',z,1+z*2));
		z+=zStep/2;
	}
	setInterval(function(){
		for(var i=0;i<circles.length;i++){
			var anim_speed=(Math.sin(((Date.now() / 1000.0)*Math.PI*2)*ANIM_FREQUENCY)*0.5+0.5)*(ANIM_SPEED_MAX-ANIM_SPEED_MIN)+ANIM_SPEED_MIN;
			circles[i].phase=(circles[i].phase+(0.00025*INTERVAL)*anim_speed)%(Math.PI*2);
			
		}
	}.bind(this),INTERVAL);
	setInterval(function(){this.draw();}.bind(this),INTERVAL);
}

MuhCircles.prototype={
	constructor:MuhCircles,
	loadStart:function(){},
	loadDone:function(){},
	draw:function(){
		var canvas=this.canvas;
		if(this.prevW!=canvas.clientWidth||this.prevH!=canvas.clientHeight){
			canvas.width=(canvas.clientWidth<10?10:canvas.clientWidth)*(window.devicePixelRatio||1);
			canvas.height=(canvas.clientHeight<10?10:canvas.clientHeight)*(window.devicePixelRatio||1);
		}
		var w=canvas.width, h=canvas.height;
		var ctx=canvas.getContext("2d");
		var gradient=ctx.createLinearGradient(0,0,0,canvas.height);
		gradient.addColorStop(0,"hsl("+BACKGROUND1_H+","+BACKGROUND1_S+"%,"+BACKGROUND1_L+"%)");
		gradient.addColorStop(1,"hsl("+BACKGROUND2_H+","+BACKGROUND2_S+"%,"+BACKGROUND2_L+"%)");
		ctx.fillStyle=gradient;
		ctx.fillRect(0,0,canvas.width,canvas.height);
		for(var i=0;i<circles.length;i++){
			var c=circles[i];
			ctx.beginPath();
			ctx.arc((c.x+(Math.cos(c.phase)*c.animV*X_ANIM_VARIANCE))*w,(c.y+(Math.sin(c.phase)*c.animV*Y_ANIM_VARIANCE))*(w/h>1?w:h),c.r*w,0,2*Math.PI,false);
			ctx.strokeStyle=c.c;
			ctx.lineWidth=c.l*w;
			ctx.stroke();
		}
	}
}
