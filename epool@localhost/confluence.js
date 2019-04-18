var docsTag = $('#dataedo');
var docsUrl = $('#dataedo').attr('src').replace('/confluence.js', '');

docsTag.after('<iframe id="dataedo-documentation" src="'+ docsUrl +'" scrolling="no" style="border: none; width: calc(100% + 100px); margin: 0 -60px 0 -40px;"></iframe>');

$.getScript(docsUrl +'/lib/iframeResizer/host.min.js', function(){
    $("#dataedo-documentation").iFrameResize();
});