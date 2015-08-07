$(function(){
	init_clock(400,400);
	function init_clock(wi,he){
		
		var myCanvas=$("#myCanvas");
		var myImage=myCanvas[0];
		
		 var cxt = myImage.getContext("2d");
		
		var s_clock=$('#Leo_clock').css('width');
		n_clock={
					'l_width':parseInt(s_clock.substr(0,s_clock.length-2)),
					'l_height':parseInt(s_clock.substr(0,s_clock.length-2))
					}

		$('#myCanvas')[0].width=n_clock.l_width*400/wi;
		$('#myCanvas')[0].height=n_clock.l_height*400/he;

		
		
		var img1 = new Image();
			img1.src="/image/fin_h.png";
			
		var img2 = new Image();
			img2.src="/image/fin_m.png";
			
		  var img3 = new Image();
			img3.src="/image/fin.png";

		var degree_h=0;
		var degree_m=0;
		var degree_s=0;

		$('#reset').click(function(){
			 degree_h=0;
			 degree_m=0;
			 degree_s=0;
			 spfly(degree_h,degree_m,degree_s);
		});

		var t1=Math.PI/60;
		var t2=t1/60;
		var t3=t2/12;
		
		var number=0;
		if($('#myCanvas').attr('hour')){
			number+=$('#myCanvas').attr('hour')*60*60*2;
		}

		if($('#myCanvas').attr('minute')){
			number+=$('#myCanvas').attr('minute')*60*2;
		}

		if($('#myCanvas').attr('second')){
			number+=$('#myCanvas').attr('second')*2;
		}

		if(number){
			degree_h+=t3*number;
			degree_m+=t2*number;
			degree_s+=t1*number;
		}

		img3.onload=function(){
			spfly(degree_h,degree_m,degree_s);
		}
		
		$("#start").click(function(){
			
			$("#start").unbind('click');
			fly();
		});

	function fly(){
		 var flag=true;
		 temp_timeout();
		 function temp_timeout(){
			 setTimeout(function(){
				if(flag){
					spfly(degree_h+=t3,degree_m+=t2,degree_s+=t1)
				}
				temp_timeout();
				;},500);
		}

		$("#pause").click(function(){
			flag=false;
		});

		$("#start").click(function(){
			flag=true;
		});

	 //Ö´ÐÐÐý×ªµÄÌØÐ§
	}

	function dorotate(l,img){
		
		  cxt.translate($('#myCanvas')[0].width/2,$('#myCanvas')[0].height/2); 
		  cxt.rotate(l);
		  cxt.translate(-$('#myCanvas')[0].width/2,-$('#myCanvas')[0].height/2);
		  cxt.drawImage(img,n_clock.l_width*185/wi,n_clock.l_height*105/he,n_clock.l_width*30/wi,n_clock.l_height*130/he);
		  
		  cxt.translate($('#myCanvas')[0].width/2,$('#myCanvas')[0].height/2);
		  
		  cxt.rotate(-l);
		  cxt.translate(-$('#myCanvas')[0].width/2,-$('#myCanvas')[0].height/2);
	 
	 }

	function spfly(h,m,s){ 
	  cxt.clearRect(0,0,$('#myCanvas')[0].width,$('#myCanvas')[0].height);
	  dorotate(h,img1);
	  dorotate(m,img2);
	  dorotate(s,img3);
	  //clearInterval(timer);
	 }

	function getPointOnCanvas(canvas, x, y) {

		var bbox =canvas.getBoundingClientRect();

		return { x: x- bbox.left *(canvas.width / bbox.width),

				y:y  - bbox.top  * (canvas.height / bbox.height)

				};

	}
	}
});