
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
			url = document.getElementById('runkeeper').title;
			html = '';
			html += '<iframe id="runkeeper_if" scrolling=no src="'+url+'"/>';
			document.getElementById('runkeeper').innerHTML = html;
		}
	}
}

runkeeper.init();