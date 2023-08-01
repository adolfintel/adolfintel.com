window.requestAnimationFrame=window.requestAnimationFrame||(function(callback,element){setTimeout(callback,1000/60);});

function timeStamp(){
    if(window.performance.now) return window.performance.now(); else return Date.now();
}

function isVisible(el){
    var r = el.getBoundingClientRect();
    return r.top+r.height >= 0 &&r.left+r.width >= 0 &&r.bottom-r.height <= (window.innerHeight || document.documentElement.clientHeight) && r.right-r.width <= (window.innerWidth || document.documentElement.clientWidth);
}

function FD23(target,config){
    if(typeof target === "string") target=document.getElementById(target);
    if(target.tagName!="CANVAS"){
        console.error("Target must be a canvas");
        return null;
    }
    this._target=target;
    
    function assignOrDefault(val,def){
        return (typeof val!=="undefined")?val:def;
    }
    
    //Accept both js object or json string for the config. if no config is passed, defaults will be used
    if(typeof config==="string") config=JSON.parse(config); else if(typeof config==="undefined") config={};
    
    //Config variables, these can be changed directly at any time
    this.targetHue=assignOrDefault(config.targetHue,245);
    this.targetSaturation=assignOrDefault(config.targetSaturation,75);config.targetSaturation||75;
    this.targetLightness=assignOrDefault(config.targetLightness,56);
    this.targetAlpha=assignOrDefault(config.targetAlpha,40);
    this.targetHueVariance=assignOrDefault(config.targetHueVariance,43);
    this.targetSaturationVariance=assignOrDefault(config.targetSaturationVariance,0);
    this.targetLightnessVariance=assignOrDefault(config.targetLightnessVariance,0);
    this.colorAdjustmentSpeed=assignOrDefault(config.colorAdjustmentSpeed,1);
    this.hueCyclePeriod=assignOrDefault(config.hueCyclePeriod,0);
    this.compensatePerceivedBrightness=assignOrDefault(config.compensatePerceivedBrightness,false);
    this.nParticles=assignOrDefault(config.nParticles,5);
    this.ringsPerParticle=assignOrDefault(config.ringsPerParticle,2);
    this.targetGradientBias=assignOrDefault(config.targetGradientBias,0.85);
    this.targetRingDistortionIntensity=assignOrDefault(config.targetRingDistortionIntensity,1);
    this.targetSpeedNormal=assignOrDefault(config.targetSpeedNormal,1);
    this.targetSpeedLoading=assignOrDefault(config.targetSpeedLoading,25);
    this.targetSpeed=this.targetSpeedNormal;
    this.targetAnimationIntensity=assignOrDefault(config.targetAnimationIntensity,1);
    this.speedAdjustmentSpeed=assignOrDefault(config.speedAdjustmentSpeed,1);
    this.followPageScroll=assignOrDefault(config.followPageScroll,true);
    this.targetTOffset=0;
    this.tOffsetIntensity=assignOrDefault(config.tOffsetIntensity,3);
    this.tOffsetAdjustmentSpeed=assignOrDefault(config.tOffsetAdjustmentSpeed,1);
    this.resolutionScale=assignOrDefault(config.resolutionScale,1);
    this.maxFps=assignOrDefault(config.maxFps,0);
    this.paused=false;
    
    //Internal variables, do not touch
    this._hue=this.targetHue;
    this._saturation=this.targetSaturation;
    this._lightness=this.targetLightness;
    this._alpha=this.targetAlpha;
    this._hueVariance=this.targetHueVariance;
    this._saturationVariance=this.targetSaturationVariance;
    this._lightnessVariance=this.targetLightnessVariance;
    this._gradientBias=this.targetGradientBias;
    this._ringDistortionIntensity=this.targetRingDistortionIntensity;
    this._speed=this.targetSpeed;
    this._animationIntensity=this.targetAnimationIntensity;
    this._ts=timeStamp();
    this._prevTs=0;
    this._t=Date.now();
    this._tOffset=0;
    this._scrollCompensation=0;

    //Start the animation
    requestAnimationFrame(this._draw.bind(this));
    return this;
}

FD23.prototype={
    constructor:FD23,
    _draw:function(){
        if(!this.paused&&isVisible(this._target)&&(this.maxFps==0||timeStamp()+1>=this._prevTs+1000/this.maxFps)){
            this._ts=timeStamp();
            var canvas=this._target;
            if(this._prevW!=canvas.clientWidth||this._prevH!=canvas.clientHeight||this.resolutionScale!=this._prevResolutionScale){
                canvas.width=(canvas.clientWidth<10?10:canvas.clientWidth)*this.resolutionScale*(window.devicePixelRatio||1);
                canvas.height=(canvas.clientHeight<10?10:canvas.clientHeight)*this.resolutionScale*(window.devicePixelRatio||1);
                this._prevResolutionScale=this.resolutionScale;
            }
            if(this.followPageScroll){
                this.targetTOffset=this._scrollCompensation+(this._loading?0:window.pageYOffset);
            }
            if(this._ts-this._prevTs>1000){
                this._prevTs=this._ts-30;
            }
            this._t+=(this._ts-this._prevTs)*this._speed;
            this._tOffset-=(this._ts-this._prevTs)*0.003*this.tOffsetAdjustmentSpeed*(this._tOffset-this.targetTOffset);
            var t=(this._t+this._tOffset*this.tOffsetIntensity)*0.00003;
            this._hue-=(this._ts-this._prevTs)*0.003*this.colorAdjustmentSpeed*(this._hue-this.targetHue);
            var tempHue=this._hue;
            if(this.hueCyclePeriod>0){
                tempHue+=(Date.now()/this.hueCyclePeriod)%360;
            }
            this._saturation-=(this._ts-this._prevTs)*0.003*this.colorAdjustmentSpeed*(this._saturation-this.targetSaturation);
            this._lightness-=(this._ts-this._prevTs)*0.003*this.colorAdjustmentSpeed*(this._lightness-this.targetLightness);
            var tempLightness=this._lightness;
            if(this.compensatePerceivedBrightness){
                tempLightness*=0.6+0.4*(0.5*(Math.cos(2*Math.PI*tempHue/360+Math.PI/2)+1));
            }
            this._alpha-=(this._ts-this._prevTs)*0.003*this.colorAdjustmentSpeed*(this._alpha-this.targetAlpha);
            this._hueVariance-=(this._ts-this._prevTs)*0.002*this.colorAdjustmentSpeed*(this._hueVariance-this.targetHueVariance);
            this._saturationVariance-=(this._ts-this._prevTs)*0.002*this.colorAdjustmentSpeed*(this._saturationVariance-this.targetSaturationVariance);
            this._lightnessVariance-=(this._ts-this._prevTs)*0.002*this.colorAdjustmentSpeed*(this._lightnessVariance-this.targetLightnessVariance);
            this._speed-=(this._ts-this._prevTs)*0.0025*this.speedAdjustmentSpeed*(this._speed-this.targetSpeed);
            this._gradientBias-=(this._ts-this._prevTs)*0.0025*this.speedAdjustmentSpeed*(this._gradientBias-this.targetGradientBias);
            this._animationIntensity-=(this._ts-this._prevTs)*0.0015*this.speedAdjustmentSpeed*(this._animationIntensity-this.targetAnimationIntensity);
            this._ringDistortionIntensity-=(this._ts-this._prevTs)*0.0025*this.speedAdjustmentSpeed*(this._ringDistortionIntensity-this.targetRingDistortionIntensity);
            var context=canvas.getContext("2d");
            context.globalCompositeOperation="source-over";
            context.fillStyle="hsl("+tempHue+","+this._saturation+"%,"+tempLightness*0.25+"%)";
            context.fillRect(0,0,canvas.width,canvas.height);
            var cx=canvas.width/2, cy=canvas.height/2;
            var dist=Math.max(canvas.width,canvas.height)*0.35;
            context.globalCompositeOperation="screen";
            for(var i=0;i<this.nParticles;i++){
                var xa=cx+dist*Math.cos(t+2*Math.PI*i/this.nParticles)+0.3*dist*this._animationIntensity*(Math.sin(t*1.345864+i)+Math.sin(t*2.789721+i));
                var ya=cy+dist*Math.sin(t+2*Math.PI*i/this.nParticles)+0.3*dist*this._animationIntensity*(Math.sin(t*1.796842+i)+Math.sin(t*2.374546+i));
                var xb=xa+0.15*this._ringDistortionIntensity*dist*(Math.sin(t*4.246215+i)+Math.sin(t*5.789871+i));
                var yb=ya+0.15*this._ringDistortionIntensity*dist*(Math.sin(t*3.046215+i)+Math.sin(t*4.219871+i));
                var gradient=context.createRadialGradient(xa,ya,0,xb,yb,dist*2);
                var color="hsla(";
                color+=tempHue+(i*this._hueVariance/this.nParticles)*(i%2==0?1:-1)+",";
                color+=this._saturation+(i*this._saturationVariance/this.nParticles)*(i%2==0?1:-1)+"%,";
                color+=tempLightness+(i*this._lightnessVariance/this.nParticles)*(i%2==0?1:-1)+"%,";
                color+=this._alpha+"%)";
                for(var j=0;j<this.ringsPerParticle;j++){
                    gradient.addColorStop(Math.pow((2*j)/(this.ringsPerParticle*2),this._gradientBias),"#00000000");
                    gradient.addColorStop(Math.pow((2*j+1)/(this.ringsPerParticle*2),this._gradientBias),color);
                }
                gradient.addColorStop(1,"#00000000");
                context.fillStyle=gradient;
                context.fillRect(0,0,canvas.width,canvas.height);
            }
            context.globalCompositeOperation="source-over";
            this._prevW=canvas.clientWidth;
            this._prevH=canvas.clientHeight;
            this._prevTs=this._ts;
        }
        requestAnimationFrame(this._draw.bind(this));
    },
    loadStart:function(){
        this._scrollCompensation+=window.pageYOffset;
        this._loading=true;
		this.targetSpeed=this.targetSpeedLoading;
	},
	loadDone:function(){
        this._loading=false;
		this.targetSpeed=this.targetSpeedNormal;
	}
}
