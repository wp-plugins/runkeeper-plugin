$(document).ready(function(){ 
	if ($('#runkeeper').length>0) {
		url = $('#runkeeper').attr('title');
		html = '';
		html += '<iframe id="runkeeper_if" scrolling=no src="'+url+'"/>';
		url = $('#runkeeper').html(html);
	}
});