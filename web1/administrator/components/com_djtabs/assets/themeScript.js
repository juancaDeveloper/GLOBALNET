window.addEvent('domready', function(){
		
		randomizeGradient();
   
	});
	
	function randomizeGradient(){
		
		var c=document.getElementById("djcanvas");
		var ctx=c.getContext("2d");
		
		var val1 = randNo(14); var val2 = randNo(14); var val3 = randNo(14); var val4 = randNo(14);
		//var grd=ctx.createLinearGradient(7,9,15,0);
		var grd=ctx.createLinearGradient(val1,val2,val3,val4);
			
		var R = randNo(255); var G = randNo(255); var B = randNo(255);
		grd.addColorStop(0,rgbToHex(R,G,B));
		
		R = randNo(255); G = randNo(255); B = randNo(255);
		grd.addColorStop(1,rgbToHex(R,G,B));
		
		ctx.fillStyle=grd;
		ctx.fillRect(0,0,14,14);
	}
	
	function randNo(no) {
	    return Math.floor((Math.random()*no)+1);
	}
	
	function rgbToHex(r, g, b) {
	    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
	}
	
	function randomize(){

		var temps = $$('.color');
		for (i=0; i<=temps.length-1; i++)
		{
			var R = randNo(255); var G = randNo(255); var B = randNo(255);
			temps[i].setStyle('background-color','rgb('+R+','+G+','+B+')');	
			var brightness = Math.floor(Math.sqrt((R*R*0.241)+(G*G*0.691)+(B*B*0.068)));
			var fore_color = (brightness < 130) ? '#FFFFFF' : '#000000';
			temps[i].setStyle('color',fore_color);
			temps[i].value = rgbToHex(R,G,B).toUpperCase();
		}

		randomizeGradient();
	}