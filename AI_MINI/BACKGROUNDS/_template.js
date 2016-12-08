window.requestAnimationFrame=window.requestAnimationFrame||(function(callback,element){setTimeout(callback,1000/60);});

//this will be the init method. it has 2 parameters: targetId is the id of the target canvas as string; config are optional parameters (can be undefined, object or JSON string)
function MyBackground(targetId,config){
	this.canvas=document.getElementById(targetId);
	config=config||{};
	if(typeof config == "string")try{config=JSON.parse(config);}catch(e){config={}}
	//do your init here. at this point, this.canvas points to the background canvas and config is an object with 0+ attributes
	
	
	
	//end init
	this.draw();
}

MyBackground.prototype={
	constructor:MyBackground,
	loadStart:function(){
		//something to do when a new frag starts loading
	},
	loadDone:function(){
		//something to do when a new frag is finished loading
	},
	draw:function(){
		//your draw code here, refer to this.canvas
		
		
		
		
		//end draw
		requestAnimationFrame(this.draw.bind(this)); //will cause draw to be called again for the next frame
	}
}
