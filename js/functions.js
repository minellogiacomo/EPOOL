/*------------------------------------
	Theme Name: 
	Start Date :
	End Date : 
	Last change: 
	Version: 1.0
	Assigned to:
	Primary use:
---------------------------------------*/
/*	

	+ Responsive Caret*
	+ Expand Panel Resize*
	+ Sticky Menu*
	
	+ Document On Ready
		- Scrolling Navigation*
		- Set Sticky Menu*
		- Responsive Caret*
		- Expand Panel*
		- Collapse Panel*
	
	+ Window On Scroll
		- Set Sticky Menu
		
	+ Window On Resize
		- Expand Panel Resize
		
	+ Window On Load
		- Site Loader
		
*/

(function($) {

	"use strict"
	
	/* - Testimonial Slider */
	function chkActiveSlider(){
	   var slideNum = 0;
		if($( ".testi-carousel .owl-item.active.center" ).length){
			slideNum = $( ".testi-carousel .owl-item.active.center a" ).attr("data-test");
			/* alert(slideNum); */
			$( "[id*='testi-']" ).css( "display", "none" );
			$( "[id='testi-"+slideNum+"']" ).css( "display", "block" );
			$( "[id='testi-"+slideNum+"']" ).addClass("animated fadeIn");
		}
	}
	
	/* + Responsive Caret* */
	function menu_dropdown_open(){
		var width = $(window).width();
		if($(".ownavigation .navbar-nav li.ddl-active").length ) {
			if( width > 991 ) {
				$(".ownavigation .navbar-nav > li").removeClass("ddl-active");
				$(".ownavigation .navbar-nav li .dropdown-menu").removeAttr("style");
			}
		} else {
			$(".ownavigation .navbar-nav li .dropdown-menu").removeAttr("style");
		}
	}
	
	/* + Expand Panel Resize* */
	function panel_resize(){
		var width = $(window).width();
		if( width > 991 ) {
			if($(".header_s .slidepanel").length ) {
				$(".header_s .slidepanel").removeAttr("style");
			}
		}
	}

	/* + Sticky Menu* */
	function sticky_menu() {
		var menu_scroll = $("body").offset().top;
		var scroll_top = $(window).scrollTop();
		var height = $(window).height();
		var body_height = $("body").height();
		var header_height = $(".header-fix").height();
		var a = height + header_height + header_height;
		if( body_height > a  ){	
			if ( scroll_top > menu_scroll ) {
				$(".header-fix").addClass("fixed-top animated fadeInDown");
				$("body").css("padding-top",header_height);
			} else {
				$(".header-fix").removeClass("fixed-top animated fadeInDown"); 
				$("body").css("padding-top","0");
			}
		} else {
			$(".header-fix").removeClass("fixed-top animated fadeInDown"); 
			$("body").css("padding-top","0");
		}
	}
	
	/* + Google Map* */
	function initialize(obj) {
		var lat = $("#"+obj).attr("data-lat");
        var lng = $("#"+obj).attr("data-lng");
		var contentString = $("#"+obj).attr("data-string");
		var myLatlng = new google.maps.LatLng(lat,lng);
		var map, marker, infowindow;
		var image = "assets/images/pointer.png";
		var zoomLevel = parseInt($("#"+obj).attr("data-zoom") ,10);		
		var styles = [{"featureType": "administrative.province","elementType": "all","stylers": [{"visibility": "off"}]},
					  {"featureType": "landscape","elementType": "all","stylers": [{"saturation": -100},{"lightness": 65},{"visibility": "on"}]},
					  {"featureType": "poi","elementType": "all","stylers": [{"saturation": -100},{"lightness": 51},{"visibility": "simplified"}]},
					  {"featureType": "road.highway","elementType": "all","stylers": [{"saturation": -100},{"visibility": "simplified"}]},
					  {"featureType": "road.arterial","elementType": "all","stylers": [{"saturation": -100},{"lightness": 30},{"visibility": "on"}]},
					  {"featureType": "road.local","elementType": "all","stylers": [{"saturation": -100},{"lightness": 40},{"visibility": "on"}]},
					  {"featureType": "transit","elementType": "all","stylers": [{"saturation": -100},{"visibility": "simplified"}]},
					  {"featureType": "transit","elementType": "geometry.fill","stylers": [{"visibility": "on"}]}, 
					  {"featureType": "water","elementType": "geometry","stylers": [{"hue": "#ffff00"},{"lightness": -25},{"saturation": -97}]},
					  {"featureType": "water","elementType": "labels","stylers": [{"visibility": "on"},{"lightness": -25},{"saturation": -100}]}]
					  
		var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});	
		
		var mapOptions = {
			zoom: zoomLevel,
			disableDefaultUI: true,
			center: myLatlng,
            scrollwheel: false,
			mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, "map_style"]
			}
		}
		
		map = new google.maps.Map(document.getElementById(obj), mapOptions);	
		
		map.mapTypes.set("map_style", styledMap);
		map.setMapTypeId("map_style");
		
		if( contentString != "" ) {
			infowindow = new google.maps.InfoWindow({
				content: contentString
			});
		}		
	    
        marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			icon: image
		});

		google.maps.event.addListener(marker, "click", function() {
			infowindow.open(map,marker);
		});
	}
	
	/* + Document On Ready */
	$(document).on("ready", function() {

		/* - Scrolling Navigation* */
		var width	=	$(window).width();
		var height	=	$(window).height();
		
		/* - Set Sticky Menu* */
		if( $(".header-fix").length ) {
			sticky_menu();
		}
		
		$('.navbar-nav li a[href*="#"]:not([href="#"]), .site-logo a[href*="#"]:not([href="#"])').on("click", function(e) {
	
			var $anchor = $(this);
			
			$("html, body").stop().animate({ scrollTop: $($anchor.attr("href")).offset().top - 49 }, 1500, "easeInOutExpo");
			
			e.preventDefault();
		});

		/* - Responsive Caret* */
		$(".ddl-switch").on("click", function() {
			var li = $(this).parent();
			if ( li.hasClass("ddl-active") || li.find(".ddl-active").length !== 0 || li.find(".dropdown-menu").is(":visible") ) {
				li.removeClass("ddl-active");
				li.children().find(".ddl-active").removeClass("ddl-active");
				li.children(".dropdown-menu").slideUp();
			}
			else {
				li.addClass("ddl-active");
				li.children(".dropdown-menu").slideDown();
			}
		});
		
		/* - Expand Panel* */
		$( "[id*='slideit-']" ).each(function (index) { 
			index++;
			$("[id*='slideit-"+index+"']").on("click", function() {
				$("[id*='slidepanel-"+index+"']").slideDown(1000);
				$("header").animate({ scrollTop: 0 }, 1000);
			});
		});

		/* - Collapse Panel * */
		$( "[id*='closeit-']" ).each(function (index) {
			index++;			
			$("[id*='closeit-"+index+"']").on("click", function() {
				$("[id*='slidepanel-"+index+"']").slideUp("slow");			
				$("header").animate({ scrollTop: 0 }, 1000);
			});
		});
		
		/* Switch buttons from "Log In | Register" to "Close Panel" on click * */
		$( "[id*='toggle-']" ).each(function (index) { 
			index++;
			$("[id*='toggle-"+index+"'] a").on("click", function() {
				$("[id*='toggle-"+index+"'] a").toggle();
			});
		});
		
		/* - Back To Top */
		$("#back-to-top").on("click",function()
		{
			$("body,html").animate(
			{
				scrollTop : 0 // Scroll to top of body
			},2000);
		});

		/* - Slider Section */
		if($(".slider-section").length) {
			var revapi23,
			tpj=jQuery;
			if(tpj("#taxi-1").revolution == undefined){
				revslider_showDoubleJqueryError("#taxi-1");
			}else{
				revapi23 = tpj("#taxi-1").show().revolution({
					sliderType:"standard",
					sliderLayout:"fullwidth",
					dottedOverlay:"none",
					delay:9000,
					navigation: {
						keyboardNavigation:"off",
						keyboard_direction: "horizontal",
						mouseScrollNavigation:"off",
						mouseScrollReverse:"default",
						onHoverStop:"off",
						bullets: {
							enable:true,
							hide_onmobile:true,
							hide_under:640,
							style:"hesperiden",
							hide_onleave:false,
							direction:"horizontal",
							h_align:"center",
							v_align:"bottom",
							h_offset:0,
							v_offset:60,
							space:8,
							tmp:''
						}
					},
					responsiveLevels:[1920,1200,768,480],
					visibilityLevels:[1920,1200,768,480],
					gridwidth:[1920,1024,768,480],
					gridheight:[766,680,540,430],
					lazyType:"none",
					shadow:0,
					spinner:"spinner0",
					stopLoop:"off",
					stopAfterLoops:-1,
					stopAtSlide:-1,
					shuffle:"off",
					autoHeight:"off",
					disableProgressBar:"on",
					hideThumbsOnMobile:"off",
					hideSliderAtLimit:0,
					hideCaptionAtLimit:0,
					hideAllCaptionAtLilmit:0,
					debugMode:false,
					fallbacks: {
						simplifyAll:"off",
						nextSlideOnWindowFocus:"off",
						disableFocusListener:false,
					}
				});
			}
		}
		if($(".slider-section").length) {
			var revapi24,
			tpj=jQuery;
			if(tpj("#taxi-2").revolution == undefined){
				revslider_showDoubleJqueryError("#taxi-2");
			}else{
				revapi24 = tpj("#taxi-2").show().revolution({
					sliderType:"standard",
					sliderLayout:"fullwidth",
					dottedOverlay:"none",
					delay:9000,
					navigation: {
						onHoverStop:"off",
					},
					responsiveLevels:[1920,1200,768,480],
					visibilityLevels:[1920,1200,768,480],
					gridwidth:[1920,1200,991,480],
					gridheight:[893,768,660,500],
					lazyType:"none",
					shadow:0,
					spinner:"spinner0",
					stopLoop:"off",
					stopAfterLoops:-1,
					stopAtSlide:-1,
					shuffle:"off",
					autoHeight:"off",
					disableProgressBar:"on",
					hideThumbsOnMobile:"off",
					hideSliderAtLimit:0,
					hideCaptionAtLimit:0,
					hideAllCaptionAtLilmit:0,
					debugMode:false,
					fallbacks: {
						simplifyAll:"off",
						nextSlideOnWindowFocus:"off",
						disableFocusListener:false,
					}
				});
			}
		}
		
		/* - Counter */
		if($("[id*='counter_section-']").length) {
			$( "[id*='counter_section-']" ).each(function ()
			{
				var ele_id = 0;
				ele_id = $(this).attr('id').split("-")[1];
				
				var $this = $(this);
				var myVal = $(this).data("value");

				$this.appear(function()
				{		
					var statistics_item_count = 0;
					var statistics_count = 0;					
					statistics_item_count = $( "[id*='statistics_"+ ele_id +"_count-']" ).length;
					 
					for(var i=1; i<=statistics_item_count; i++)
					{
						statistics_count = $( "[id*='statistics_"+ ele_id +"_count-"+ i +"']" ).attr( "data-fact" );
						$("[id*='statistics_"+ ele_id +"_count-"+ i +"']").animateNumber({ number: statistics_count }, 4000);
					}				
				});
			});
		}
		
		/* - Testimonial Carousel */		
		if( $( ".testimonial-section" ).length ) {
			setInterval( chkActiveSlider, 1000 );
		}
		
		/* - Testimonial Image Carousel */
		if( $(".testi-carousel").length ) {
			$(".testi-carousel").owlCarousel({
				loop: true,
				center: true,
				margin: 0,
				nav: false,
				dots: false,
				autoplay: true,
				items: 3,
				responsive:{
					0:{
						items: 1
					},
					480:{
						items: 3
					}
				}
			});
			$(".testi-next").on("click", function(){
				$('.testi-carousel').trigger("next.owl.carousel");
			});
			$(".testi-prev").on("click", function(){
				$(".testi-carousel").trigger("prev.owl.carousel");
			});
			
			$(".testi-carousel").on('click', '.owl-item>div', function() {
				$(".testi-carousel").trigger('to.owl.carousel', $(this).data( 'position' ) ); 
			});
		}
		
		/* - Choose Image Carousel */
		if( $(".choose-section").length ) {
			$("[id*='choose_']").each(function (index){
				index++;
				$("#choose_"+index+" .choose-thumbnail").owlCarousel({
					loop: true,
					margin: 18,
					nav: false,
					dots: false,
					autoplay: true,
					items: 6,
					slideBy: 1,
					responsive:{
						0:{
							items: 2
						},
						480:{
							items: 3
						},
						768:{
							items: 4
						},
						992:{
							items: 5
						},
						1200:{
							items: 6
						}
					}
				});
				$("#choose_"+index+" .choose-thumbnail").on('changed.owl.carousel', function(e) {
					setTimeout ( function() {
						$(".choose-thumbnail .owl-item.active").each(function (i)
						{
							if( i === 0 ){
								$("#choose_"+index+" .choose-thumbnail .owl-item").removeClass("current");
								$("#choose_"+index+" .choose-thumbnail .owl-item.active").eq(i).addClass("current");
								return false;
							} else {
								$(".choose-thumbnail .owl-item").removeClass("current");
							}
						});
					},100);
				});
				$("#choose_"+index+" .choose-thumbnail .owl-item.active").each(function (i)
				{
					$("#choose_"+index+" .choose-thumbnail .owl-item").removeClass("current");
					if( i === 0 ){
						$(".choose-thumbnail .owl-item.active").eq(i).addClass("current");
						return false;
					} else{
						$(".choose-thumbnail .owl-item").removeClass("current");
					}
				});
				
				$("#choose_"+index+" .choose-thumbnail").on("click", ".owl-item", function(e) {
					var carousel = $('#choose_'+index+' .choose-thumbnail').data('owl.carousel');
					e.preventDefault();
					$("#choose_"+index+".choose-thumbnail .owl-item").removeClass("current");
					$(this).addClass("current");
					carousel.to(carousel.relative($(this).index()));
				});				
				setInterval( function(){
					
					var slideNum = 0;
					$( ".choose-section #choose_"+index+"" ).each(function ()
					{
						if($("#choose_"+index+" .choose-thumbnail .owl-item.active.current" ).length) {
							slideNum = $(".choose-thumbnail .owl-item.active.current .item" ).attr("data-choose");
							$( "[id*='contnet_"+index+"_dtl-']" ).css( "display", "none" );
							$( "[id='contnet_"+index+"_dtl-"+slideNum+"']" ).css( "display", "block" );
							$( "[id='contnet_"+index+"_dtl-"+slideNum+"']" ).addClass("animated fadeIn");
						}
					});
				}, 1000 );
				return false;
			});
			
			$(".choose-next").on("click", function(){
				$('.choose-thumbnail').trigger("next.owl.carousel");
			});
			$(".choose-prev").on("click", function(){
				$(".choose-thumbnail").trigger("prev.owl.carousel");
			});
			
			/* - OnTab Click */
			$("a[data-toggle='tab']").on("click", function(){
				var tab_id = $(this).attr("href").replace('#','');
				
				$(".choose-section .tab-content .tab-pane").each(function() {
					var c_id= $(this).attr("id");
					if( tab_id === c_id ) {
						if(c_id != 0){
							var div_id = $(".choose-section .tab-pane[id="+c_id+"] > div").attr("id").replace("choose_","");
							$("#choose_"+div_id+" .choose-thumbnail").owlCarousel({
								loop: true,
								margin: 18,
								nav: false,
								dots: false,
								autoplay: true,
								items: 6,
								slideBy: 1,
								responsive:{
									0:{
										items: 3
									},
									480:{
										items: 3
									},
									1200:{
										items: 6
									}
								}
							});
							$("#choose_"+div_id+" .choose-thumbnail").on('changed.owl.carousel', function(e) {
								setTimeout ( function() {
									$(".choose-thumbnail .owl-item.active").each(function (i)
									{
										if( i === 0 ){
											$("#choose_"+div_id+" .choose-thumbnail .owl-item").removeClass("current");
											$("#choose_"+div_id+" .choose-thumbnail .owl-item.active").eq(i).addClass("current");
											return false;
										} else {
											$(".choose-thumbnail .owl-item").removeClass("current");
										}
									});
								},100);
							});
							$("#choose_"+div_id+" .choose-thumbnail .owl-item.active").each(function (i)
							{
								$("#choose_"+div_id+" .choose-thumbnail .owl-item").removeClass("current");
								if( i === 0 ){
									$(".choose-thumbnail .owl-item.active").eq(i).addClass("current");
									return false;
								} else{
									$(".choose-thumbnail .owl-item").removeClass("current");
								}
							});
							
							$("#choose_"+div_id+" .choose-thumbnail").on("click", ".owl-item", function(e) {
								var carousel = $('#choose_'+div_id+' .choose-thumbnail').data('owl.carousel');
								e.preventDefault();
								$("#choose_"+div_id+".choose-thumbnail .owl-item").removeClass("current");
								$(this).addClass("current");
								carousel.to(carousel.relative($(this).index()));
							});				
							setInterval( function(){
								var slideNum = 0;
								$( ".choose-section #choose_"+div_id+"" ).each(function ()
								{
									if($("#choose_"+div_id+" .choose-thumbnail .owl-item.active.current" ).length) {
										slideNum = $("#choose_"+div_id+" .choose-thumbnail .owl-item.active.current .item" ).attr("data-choose");
										$( "[id*='contnet_"+div_id+"_dtl-']" ).css( "display", "none" );
										$( "[id='contnet_"+div_id+"_dtl-"+slideNum+"']" ).css( "display", "block" );
										$( "[id='contnet_"+div_id+"_dtl-"+slideNum+"']" ).addClass("animated fadeIn");
									}
								});
								
							}, 1000 );
						}
					}
				});
			});
		}
		
		if( $( "#contact-map-canvas").length == 1 ) {
			initialize( "contact-map-canvas" );
		}

		/* - Quick Contact Form* */
		$( "#btn_submit" ).on( "click", function(event) {
			event.preventDefault();
			var mydata = $("form").serialize();
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "contact.php",
				data: mydata,
				success: function(data) {
					if( data["type"] == "error" ){
						$("#alert-msg").html(data["msg"]);
						$("#alert-msg").removeClass("alert-msg-success");
						$("#alert-msg").addClass("alert-msg-failure");
						$("#alert-msg").show();
					} else {
						$("#alert-msg").html(data["msg"]);
						$("#alert-msg").addClass("alert-msg-success");
						$("#alert-msg").removeClass("alert-msg-failure");
						$("#input_name").val("");
						$("#input_email").val("");
						$("#input_subject").val("");
						$("#textarea_message").val("");
						$("#alert-msg").show();
					}		
				},
				error: function(xhr, textStatus, errorThrown) {
					alert(textStatus);
				}
			});
		});

	});	/* - Document On Ready /- */
	
	/* + Window On Scroll */
	$(window).on("scroll",function() {
		/* - Set Sticky Menu* */
		if( $(".header-fix").length ) {
			sticky_menu();
		}
	});
	
	/* + Window On Resize */ 
	$( window ).on("resize",function() {
		var width	=	$(window).width();
		var height	=	$(window).height();
		
		sticky_menu();
		
		/* - Expand Panel Resize */
		panel_resize();
		menu_dropdown_open();
	});
	
	/* + Window On Load */
	$(window).on("load",function() {
		/* - Site Loader* */
		if ( !$("html").is(".ie6, .ie7, .ie8") ) {
			$("#site-loader").delay(1000).fadeOut("slow");
		}
		else {
			$("#site-loader").css("display","none");
		}		
	});

})(jQuery);