<div>
<link rel="stylesheet" type="text/css" href="article.css" />
<div class="basic_hide">
<div class="stripe">
	<div class="content">
		<h2>MuhCircles Editor</h2>
		<form action="javascript:{setBackgroundCfg(document.getElementById('CIRCLES_PER_STRAND').value+','+document.getElementById('L_COLOR_H').value+','+document.getElementById('L_COLOR_S').value+','+document.getElementById('L_COLOR_L').value+','+document.getElementById('R_COLOR_H').value+','+document.getElementById('R_COLOR_S').value+','+document.getElementById('R_COLOR_L').value+','+document.getElementById('COLOR_H_VARIANCE').value+','+document.getElementById('COLOR_S_VARIANCE').value+','+document.getElementById('COLOR_L_VARIANCE').value+','+document.getElementById('MIN_Z').value+','+document.getElementById('MAX_Z').value+','+document.getElementById('X_OFF_L').value+','+document.getElementById('X_OFF_R').value+','+document.getElementById('Y_OFF_L').value+','+document.getElementById('Y_OFF_R').value+','+document.getElementById('X_VARIANCE').value+','+document.getElementById('Y_VARIANCE').value+','+document.getElementById('RADIUS').value+','+document.getElementById('RADIUS_VARIANCE').value+','+document.getElementById('LINE_WIDTH').value+','+document.getElementById('X_ANIM_VARIANCE').value+','+document.getElementById('Y_ANIM_VARIANCE').value+','+document.getElementById('BACKGROUND1_H').value+','+document.getElementById('BACKGROUND1_S').value+','+document.getElementById('BACKGROUND1_L').value+','+document.getElementById('BACKGROUND2_H').value+','+document.getElementById('BACKGROUND2_S').value+','+document.getElementById('BACKGROUND2_L').value+','+document.getElementById('ANIM_SPEED_MIN').value+','+document.getElementById('ANIM_SPEED_MAX').value+','+document.getElementById('ANIM_FREQUENCY').value+','+document.getElementById('CENTER_X').value+','+document.getElementById('CENTER_Y').value+','+document.getElementById('INTERVAL').value);}">
		<h4>Basic settings</h4>
		<div class="section">
		Circles per strand <input type="number" id="CIRCLES_PER_STRAND" value="200"/><br/>
		Depth <input type="number" step="any" id="MIN_Z" value="0.01"/>-<input type="number" id="MAX_Z" step="any" value="2"/><br/>
		Circle radius <input type="number" step="any" id="RADIUS" value="0.35"/>, variance <input type="number" step="any" id="RADIUS_VARIANCE" value="0.07"/><br/>
		Line thickness <input type="number" step="any" id="LINE_WIDTH" value="0.007"/><br/>
		</div>
		<h4>Strands positioning</h4>
		<div class="section">
		Strand 1 (x,y) <input type="number" step="any" id="X_OFF_L" value="-0.3"/>,<input type="number" step="any" id="Y_OFF_L" value="0.5"/><br/>
		Strand 2 (x,y) <input type="number" step="any" id="X_OFF_R" value="0.3"/>,<input type="number" step="any" id="Y_OFF_R" value="0.51"/><br/>
		Variance (x,y) <input type="number" step="any" id="X_VARIANCE" value="0.04"/>,<input type="number" step="any" id="Y_VARIANCE" value="0.04"/><br/>
		</div>
		<h4>Colors</h4>
		<div class="section">
		Strand 1 (h,s,l) <input type="number" step="any" id="L_COLOR_H" value="221"/>,<input type="number" step="any" id="L_COLOR_S" value="81"/>,<input type="number" step="any" id="L_COLOR_L" value="50"/><br/>
		Strand 2 (h,s,l) <input type="number" step="any" id="R_COLOR_H" value="263"/>,<input type="number" step="any" id="R_COLOR_S" value="81"/>,<input type="number" step="any" id="R_COLOR_L" value="50"/><br/>
		Variance (h,s,l) <input type="number" step="any" id="COLOR_H_VARIANCE" value="10"/>,<input type="number" step="any" id="COLOR_S_VARIANCE" value="5"/>,<input type="number" step="any" id="COLOR_L_VARIANCE" value="0"/><br/>
		</div>
		<h4>Background gradient</h4>
		<div class="section">
		Top (h,s,l) <input type="number" step="any" id="BACKGROUND1_H" value="0"/>,<input type="number" step="any" id="BACKGROUND1_S" value="0"/>,<input type="number" step="any" id="BACKGROUND1_L" value="0"/><br/>
		Bottom (h,s,l) <input type="number" step="any" id="BACKGROUND2_H" value="243"/>,<input type="number" step="any" id="BACKGROUND2_S" value="81"/>,<input type="number" step="any" id="BACKGROUND2_L" value="20"/><br/>
		</div>
		<h4>Animation</h4>
		<div class="section">
		Range (x,y) <input type="number" step="any" id="X_ANIM_VARIANCE" value="0.02"/>,<input type="number" step="any" id="Y_ANIM_VARIANCE" value="0.02"/><br/>
		Speed <input type="number" step="any" id="ANIM_SPEED_MIN" value="1"/>-<input type="number" step="any" id="ANIM_SPEED_MAX" value="1"/><br/>
		Speed variation frequency <input type="number" step="any" id="ANIM_FREQUENCY" value="0"/>
		</div>
		<h4>Rendering</h4>
		<div class="section">
		Center point (x,y) <input type="number" step="any" id="CENTER_X" value="0.5"/>,<input type="number" step="any" id="CENTER_Y" value="0"/><br/>
		Frame time <input type="number" step="any" id="INTERVAL" value="50"/>
		</div>
		<input type="submit" value="Apply" />
		
		</form>
	</div>
</div>
<script type="text/javascript">
	try{
		var q=localStorage.backgroundCfg.split(",");
		if(q.length==35){
			document.getElementById("CIRCLES_PER_STRAND").value=q[0];
			document.getElementById("L_COLOR_H").value=q[1];
			document.getElementById("L_COLOR_S").value=q[2];
			document.getElementById("L_COLOR_L").value=q[3];
			document.getElementById("R_COLOR_H").value=q[4];
			document.getElementById("R_COLOR_S").value=q[5];
			document.getElementById("R_COLOR_L").value=q[6];
			document.getElementById("COLOR_H_VARIANCE").value=q[7];
			document.getElementById("COLOR_S_VARIANCE").value=q[8];
			document.getElementById("COLOR_L_VARIANCE").value=q[9];
			document.getElementById("MIN_Z").value=q[10];
			document.getElementById("MAX_Z").value=q[11];
			document.getElementById("X_OFF_L").value=q[12];
			document.getElementById("X_OFF_R").value=q[13];
			document.getElementById("Y_OFF_L").value=q[14];
			document.getElementById("Y_OFF_R").value=q[15];
			document.getElementById("X_VARIANCE").value=q[16];
			document.getElementById("Y_VARIANCE").value=q[17];
			document.getElementById("RADIUS").value=q[18];
			document.getElementById("RADIUS_VARIANCE").value=q[19];
			document.getElementById("LINE_WIDTH").value=q[20];
			document.getElementById("X_ANIM_VARIANCE").value=q[21];
			document.getElementById("Y_ANIM_VARIANCE").value=q[22];
			document.getElementById("BACKGROUND1_H").value=q[23];
			document.getElementById("BACKGROUND1_S").value=q[24];
			document.getElementById("BACKGROUND1_L").value=q[25];
			document.getElementById("BACKGROUND2_H").value=q[26];
			document.getElementById("BACKGROUND2_S").value=q[27];
			document.getElementById("BACKGROUND2_L").value=q[28];
			document.getElementById("ANIM_SPEED_MIN").value=q[29];
			document.getElementById("ANIM_SPEED_MAX").value=q[30];
			document.getElementById("ANIM_FREQUENCY").value=q[31];
			document.getElementById("CENTER_X").value=q[32];
			document.getElementById("CENTER_Y").value=q[33];
			document.getElementById("INTERVAL").value=q[34];
		}
	}catch(e){}
</script>
<div class="stripe">
<div class="content">
<h2>Enjoy the show</h2>
<a onClick="loadFragment('empty.frag',true)">Hide page</a> (press back to come back)<br/>
<a onClick="document.getElementById('bkFrame').contentWindow.toFile()">Download wallpaper</a>
</div>
</div>
</div>
<div class="basic_only">
<div class="stripe">
<div class="content">
<h2>Not supported in Basic HTML mode</h2>
<p>This function requires a modern browser</p>
</div>
</div>
</div>
</div>