var runkeeper = {
	alreadyrunflag:0,
	
	init:function() {
		if (document.addEventListener)
  			document.addEventListener("DOMContentLoaded", function(){ runkeeper.alreadyrunflag=1; runkeeper.begin()}, false)			
		else if (document.all && !window.opera){
		  document.write('<script type="text/javascript" id="contentloadtag" defer="defer" src="javascript:void(0)"><\/script>')
		  var contentloadtag=document.getElementById("contentloadtag")
		  contentloadtag.onreadystatechange=function(){
			if (this.readyState=="complete"){
			  runkeeper.alreadyrunflag=1
			  runkeeper.begin()
			}
		  }
		}	
		
		window.onload=function(){
		  setTimeout("if (!runkeeper.alreadyrunflag) runkeeper.begin()", 500)
		}		
	},
	
	begin:function() {
		if (document.getElementById('runkeeper')) {
			items = $('#runkeeper').attr('title').split(',');
			url = items[0];
			x = items[1];
			y = items[2];
			width = parseInt($('#runkeeper').css('width')) + (x*-1);
			height = parseInt($('#runkeeper').css('height')) + (y*-1);

			html = '';
			html += '<iframe id="runkeeper_if" scrolling=no src="'+url+'" style="width:'+width+'px; height:'+height+'px; margin-top:'+y+'px; margin-left:'+x+'px;"/>';
			document.getElementById('runkeeper').innerHTML = html;
		}
	}
}

runkeeper.init();