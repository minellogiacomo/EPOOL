(function( $ ) {
    // Plugin definition.
    $.fn.popup = function(options) {
    	// Settings
	    var defaults = {
	        msg: undefined
	    };
	 
	    var settings = $.extend({}, defaults, options);
	    var popup = $('#popup');
	   	
        return this.each(function() {
	    	// Properties
		    var element = $(this);
		    var msg = undefined;

		    var initialize = function() {
		    	dispose();

		    	// Get message 
		    	msg = settings.msg || $(element).data('msg');

		    	// Bind events
		    	element.bind('mouseenter.popup', show);
		    	element.bind('mouseleave.popup', hide);
		    	element.bind('mousemove.popup', update);
		    	element.bind('click.popup', hide);
		    }

		    var toggle = function() {
		    	if(popup.is(':visible')) hide();
		    	else show();
		    }

		    var hide = function() {
		    	popup.hide();
		    }

		    var update = function(e) {
			    popup.attr('style', 'left: '+ (e.clientX + 20) +'px; top: '+ e.clientY +'px');
		    }

		    var show = function() {
		    	popup.html(msg);

		    	popup.trigger('mousemove');
		    	popup.show();
		    }

		    var dispose = function() {
		    	element.unbind('.popup');
		    }

		    initialize();
	    });
    };

    // Active all by default
	$(function() {
		$('<div id="popup"></div>').hide().appendTo('body');
		$('.popup').popup();
	});

})( jQuery );