/*

	Supersized - Fullscreen Slideshow jQuery Plugin
	Version : 3.2.7
	Theme 	: Shutter 1.1
	
	Site	: www.buildinternet.com/project/supersized
	Author	: Sam Dunn
	Company : One Mighty Roar (www.onemightyroar.com)
	License : MIT License / GPL License

*/

(function($){
	
	theme = {
	 	
	 	
	 	/* Initial Placement
		----------------------------*/
	 	_init : function(){
	
	 		// Center Slide Links
	 		if (api.options.slide_links) $(vars.slide_list).css('margin-left', -$(vars.slide_list).width()/2);
	 		
			// Start progressbar if autoplay enabled
    		if (api.options.autoplay){
    			if (api.options.progress_bar) theme.progressBar();
			}else{
				var iimg = !retinaDevice ? "play.png" : "play@2x.png";
				
				if ($(vars.play_button).attr('src')) $(vars.play_button).attr("src", vars.image_path + iimg);	// If pause play button is image, swap src
				if (api.options.progress_bar) $(vars.progress_bar).stop().css({left : -$(window).width()});	//  Place progress bar
			}
			
			
			/* Thumbnail Tray
			----------------------------*/
			// Hide tray off screen
			$(vars.thumb_tray).css({bottom : -$(vars.thumb_tray).height()});
			
			// Thumbnail Tray Toggle
			$(vars.tray_button).toggle(function(){
				$(vars.thumb_tray).stop()[animateSyntax]({bottom : 0, avoidTransforms : true}, 300 );
				if ($(vars.tray_arrow).attr('src')) $(vars.tray_arrow).attr("src", vars.image_path + "button-tray-down.png");
				return false;
			}, function() {
				$(vars.thumb_tray).stop()[animateSyntax]({bottom : -$(vars.thumb_tray).height(), avoidTransforms : true}, 300 );
				if ($(vars.tray_arrow).attr('src')) $(vars.tray_arrow).attr("src", vars.image_path + "button-tray-up.png");
				return false;
			});
			
			// Make thumb tray proper size
			$(vars.thumb_list).width($('> li', vars.thumb_list).length * $('> li', vars.thumb_list).outerWidth(true));	//Adjust to true width of thumb markers
			
			// Display total slides
			if ($(vars.slide_total).length){
				$(vars.slide_total).html(api.options.slides.length);
			}
			
			
			/* Thumbnail Tray Navigation
			----------------------------*/	
			if (api.options.thumb_links){
				//Hide thumb arrows if not needed
				if ($(vars.thumb_list).width() <= $(vars.thumb_tray).width()){
					$(vars.thumb_back +','+vars.thumb_forward).fadeOut(0);
				}
				
				// Thumb Intervals
        		vars.thumb_interval = Math.floor($(vars.thumb_tray).width() / $('> li', vars.thumb_list).outerWidth(true)) * $('> li', vars.thumb_list).outerWidth(true);
        		vars.thumb_page = 0;
        		
        		// Cycle thumbs forward
        		$(vars.thumb_forward).click(function(){
        			if (vars.thumb_page - vars.thumb_interval <= -$(vars.thumb_list).width()){
        				vars.thumb_page = 0;
        				$(vars.thumb_list).stop()[animateSyntax]({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
        			}else{
        				vars.thumb_page = vars.thumb_page - vars.thumb_interval;
        				$(vars.thumb_list).stop()[animateSyntax]({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
        			}
        		});
        		
        		// Cycle thumbs backwards
        		$(vars.thumb_back).click(function(){
        			if (vars.thumb_page + vars.thumb_interval > 0){
        				vars.thumb_page = Math.floor($(vars.thumb_list).width() / vars.thumb_interval) * -vars.thumb_interval;
        				if ($(vars.thumb_list).width() <= -vars.thumb_page) vars.thumb_page = vars.thumb_page + vars.thumb_interval;
        				$(vars.thumb_list).stop()[animateSyntax]({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
					}else{
        				vars.thumb_page = vars.thumb_page + vars.thumb_interval;
        				$(vars.thumb_list).stop()[animateSyntax]({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
        			}
        		});
				
			}
	
			//if(isTouch || !isMouseDrag){
				
				if($('body').find(".homeSlider #supersized").length > 0){	
				
					try{
					  $(function() {	
						  $('.homeSlider').swipe( {
							  //Generic swipe handler for all directions
							  swipe:function(event, direction, distance, duration, fingerCount) {
								  if(direction === "left"){
									  api.nextSlide();
								  }
								  if(direction === "right"){
									  api.prevSlide();
								  }							  
							  },
							  allowPageScroll : "vertical",
							  //Default is 75px, set to 0 for demo so any distance triggers swipe
							  threshold: swipeThreshold
						  });
					  });
				}catch(e){}
				}
		//	}
		
			
			var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel" //FF doesn't recognize mousewheel as of FF3.x
			$('.homeSlider').bind(mousewheelevt, function(e){			
				var evt = window.event || e //equalize event object     
				evt = evt.originalEvent ? evt.originalEvent : evt; //convert to originalEvent if possible               
				var delta = evt.detail ? evt.detail*(-40) : evt.wheelDelta //check for detail first, because it is used by Opera and FF
				if(delta > 0) { 
					api.prevSlide();
				}
				else{
					api.nextSlide();
				}   
				
			});
			

			

			
			
			/* Navigation Items
			----------------------------*/
		    $(vars.next_slide).click(function() {
		    	api.nextSlide();
		    });
		    
		    $(vars.prev_slide).click(function() {
		    	api.prevSlide();
		    });
		    
		    	// Full Opacity on Hover
		    	if(jQuery.support.opacity){
			    	$(vars.prev_slide +','+vars.next_slide).mouseover(function() {
					   $(this).stop()[animateSyntax]({opacity:1},100);
					}).mouseout(function(){
					   $(this).stop()[animateSyntax]({opacity:0.6},100);
					});
				}
			
			if (api.options.thumbnail_navigation){
				// Next thumbnail clicked
				$(vars.next_thumb).click(function() {
			    	api.nextSlide();
			    });
			    // Previous thumbnail clicked
			    $(vars.prev_thumb).click(function() {
			    	api.prevSlide();
			    });
			}
			
		    $(vars.play_button).click(function() {
				api.playToggle();						    
		    });
			
			
			/* Thumbnail Mouse Scrub
			----------------------------*/
    		if (api.options.mouse_scrub){
				$(vars.thumb_tray).mousemove(function(e) {
					var containerWidth = $(vars.thumb_tray).width(),
						listWidth = $(vars.thumb_list).width();
					if (listWidth > containerWidth){
						var mousePos = 1,
							diff = e.pageX - mousePos;
						if (diff > 10 || diff < -10) { 
						    mousePos = e.pageX; 
						    newX = (containerWidth - listWidth) * (e.pageX/containerWidth);
						    diff = parseInt(Math.abs(parseInt($(vars.thumb_list).css('left'))-newX )).toFixed(0);
						    $(vars.thumb_list).stop()[animateSyntax]({'left':newX}, {duration:diff*3, easing:'easeOutExpo'});
						}
					}
				});
			}
			
			
			/* Window Resize
			----------------------------*/
			$(window).resize(function(){
				
				// Delay progress bar on resize
				if (api.options.progress_bar && !vars.in_animation){
					if (vars.slideshow_interval) clearInterval(vars.slideshow_interval);
					if (api.options.slides.length - 1 > 0) clearInterval(vars.slideshow_interval);
					
					$(vars.progress_bar).stop().css({left : -$(window).width()});
					
					if (!vars.progressDelay && api.options.slideshow){
						// Delay slideshow from resuming so Chrome can refocus images
						vars.progressDelay = setTimeout(function() {
								if (!vars.is_paused){
									theme.progressBar();
									vars.slideshow_interval = setInterval(api.nextSlide, api.options.slide_interval);
								}
								vars.progressDelay = false;
						}, 1000);
					}
				}
				
				$("#play-button").css({"margin-right": - (($(".supersized-nav li:first-child").width() * api.options.slides.length )+40) });
				
				// Thumb Links
				if (api.options.thumb_links && vars.thumb_tray.length){
					// Update Thumb Interval & Page
					vars.thumb_page = 0;	
					vars.thumb_interval = Math.floor($(vars.thumb_tray).width() / $('> li', vars.thumb_list).outerWidth(true)) * $('> li', vars.thumb_list).outerWidth(true);
					
					// Adjust thumbnail markers
					if ($(vars.thumb_list).width() > $(vars.thumb_tray).width()){
						$(vars.thumb_back +','+vars.thumb_forward).fadeIn('fast');
						$(vars.thumb_list).stop()[animateSyntax]({'left':0}, 200);
					}else{
						$(vars.thumb_back +','+vars.thumb_forward).fadeOut('fast');
					}
					
				}
			});	
			
								
	 	},
	 	
	 	
	 	/* Go To Slide
		----------------------------*/
	 	goTo : function(){
	 		if (api.options.progress_bar && !vars.is_paused){
				$(vars.progress_bar).stop().css({left : -$(window).width()});
				theme.progressBar();
			}
		},
	 	
	 	/* Play & Pause Toggle
		----------------------------*/
	 	playToggle : function(state){
	 		var iimg = !retinaDevice ? "play.png" : "play@2x.png";
			var iimg2 = !retinaDevice ? "pause.png" : "pause@2x.png";
	 		if (state =='play'){
	 			// If image, swap to pause
	 			if ($(vars.play_button).attr('src')) $(vars.play_button).attr("src", vars.image_path + iimg2);
				if (api.options.progress_bar && !vars.is_paused) theme.progressBar();
	 		}else if (state == 'pause'){
	 			// If image, swap to play
	 			if ($(vars.play_button).attr('src')) $(vars.play_button).attr("src", vars.image_path + iimg);
        		if (api.options.progress_bar && vars.is_paused)$(vars.progress_bar).stop().css({left : -$(window).width()});
	 		}
	 		
	 	},
		
		
		
		sliderAnimateEngine : function(anim, _obj, _sca, _reset){			
			var self = this;
			if(!api.options.kenburn){ return; }
			if(_obj){  _obj.parent().data("cMc", _obj); }
			
			if(!cssAnimate || lowResDesktop || isTouch){ return; }
			
			if(!_reset){
				var _sp_s =  _obj.data("v_sca") ? _obj.data("v_sca") : 1;	
				
				var incre_s = $.browser.mozilla ? ((_sca >= 1.01) ? .0025 : -.0025) : ((_sca >= 1.01) ? .0005 : -.0005);
				clearInterval(self.scaDrg);	
				if(anim){
					self.scaDrg = setInterval( function(){													
						_sp_s += incre_s;
						try { _sp_s = Number(_sp_s.toFixed(4)); }catch(e){}						
						if(_sca > _sp_s-.001 && _sca < _sp_s+.001){
							_sp_s = _sca;
							clearInterval(self.scaDrg);	
						}						
						_obj.css({	'-webkit-transform' : 'scale('+_sp_s+')',
							  		'-moz-transform'    : 'scale('+_sp_s+')',
							  		'-ms-transform'     : 'scale('+_sp_s+')',
							  		'-o-transform'      : 'scale('+_sp_s+')',
							  		'transform'         : 'scale('+_sp_s+')'
									});
						_obj.data("v_sca", _sp_s);
					}, 10);
				}else{	
					_obj.css({	'-webkit-transform' : 'scale('+_sca+')',
								'-moz-transform'    : 'scale('+_sca+')',
								'-ms-transform'     : 'scale('+_sca+')',
								'-o-transform'      : 'scale('+_sca+')',
								'transform'         : 'scale('+_sca+')'
								});
					_obj.data("v_sca", _sca);
					clearInterval(self.scaDrg);
				}
			}else{	
				_sp_s = 1;
				if($("#supersized").data("cMc") !== undefined){
					$("#supersized").data("cMc").css({	'-webkit-transform' : 'scale('+_sp_s+')',
													'-moz-transform'    : 'scale('+_sp_s+')',
													'-ms-transform'     : 'scale('+_sp_s+')',
													'-o-transform'      : 'scale('+_sp_s+')',
													'transform'         : 'scale('+_sp_s+')'
													});
					$("#supersized").data("cMc").data("v_sca", _sca);
				}
				clearInterval(self.scaDrg);
			}			
			
		},
	 	
	 	
	 	/* Before Slide Transition
		----------------------------*/
	 	beforeAnimation : function(direction){
			
		//	$("#supersized li.prevslide").css({"visibility":"visible", "display":"block"});
		//	$("#supersized li.activeslide").css({"visibility":"visible", "display":"block"});

		    if (api.options.progress_bar && !vars.is_paused) $(vars.progress_bar).stop().css({left : -$(window).width()});
		  	
		  	/* Update Fields
		  	----------------------------*/
		  	// Update slide caption
		   	if ($(vars.slide_caption).length){
		   		(api.getField('title')) ? $(vars.slide_caption).html(api.getField('title')) : $(vars.slide_caption).html('');
		   	}
		    // Update slide number
			if (vars.slide_current.length){
			    $(vars.slide_current).html(vars.current_slide + 1);
			}
		    
		    
		    // Highlight current thumbnail and adjust row position
		    if (api.options.thumb_links){
		    
				$('.current-thumb').removeClass('current-thumb');
				$('li', vars.thumb_list).eq(vars.current_slide).addClass('current-thumb');
				
				// If thumb out of view
				if ($(vars.thumb_list).width() > $(vars.thumb_tray).width()){
					// If next slide direction
					if (direction == 'next'){
						if (vars.current_slide == 0){
							vars.thumb_page = 0;
							$(vars.thumb_list).stop()[animateSyntax]({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
						} else if ($('.current-thumb').offset().left - $(vars.thumb_tray).offset().left >= vars.thumb_interval){
	        				vars.thumb_page = vars.thumb_page - vars.thumb_interval;
	        				$(vars.thumb_list).stop()[animateSyntax]({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
						}
					// If previous slide direction
					}else if(direction == 'prev'){
						if (vars.current_slide == api.options.slides.length - 1){
							vars.thumb_page = Math.floor($(vars.thumb_list).width() / vars.thumb_interval) * -vars.thumb_interval;
							if ($(vars.thumb_list).width() <= -vars.thumb_page) vars.thumb_page = vars.thumb_page + vars.thumb_interval;
							$(vars.thumb_list).stop()[animateSyntax]({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
						} else if ($('.current-thumb').offset().left - $(vars.thumb_tray).offset().left < 0){
							if (vars.thumb_page + vars.thumb_interval > 0) return false;
	        				vars.thumb_page = vars.thumb_page + vars.thumb_interval;
	        				$(vars.thumb_list).stop()[animateSyntax]({'left': vars.thumb_page}, {duration:500, easing:'easeOutExpo'});
						}
					}
				}
				
				
			}
			//$.supersized.vars.slide_list
			

			for(var kk=0; kk< api.options.slides.length; kk++){
				if(cssAnimate){
					if($(api.options.slides[kk].main_title). hasClass("show_title")){
						$(api.options.slides[kk].main_title).removeClass("show_title")
						.addClass("hide_title").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
							 $(this).hide();
						});					
					}
				}else{ 
					$(api.options.slides[kk].main_title).fadeOut();	
				}				
			}
			
			if(api.options.kenburn){
				for(var kk3=0; kk3< api.options.slides.length; kk3++){
					if( api.options.slides[kk3].zoomIn !== "" && kk3 === vars.current_slide ){					
						var zoomInVal = api.options.slides[kk3].zoomIn === "no" ? api.options.kenburnZoomValue :  1;
						theme.sliderAnimateEngine(false, $("#supersized li").eq(kk3), zoomInVal, false);
					}
				}
			}
			
			if(!superSliderLoad){
				setTimeout(function(){
					$("#superNav #prevslide").css({"margin-right": ((api.options.slides.length-1)*20) });
					$("#superNav #nextslide").css({"margin-right": -(api.options.slides.length*20) });

					for(var kk2=0; kk2< api.options.slides.length; kk2++){
						if(!cssAnimate){
							$(api.options.slides[kk2].main_title).removeClass("hide_title");
						}else{
							$(api.options.slides[kk2].main_title).hide();
						}
					}	
					
					if(cssAnimate){
						$(api.options.slides[vars.current_slide].main_title).show()
						.removeClass("hide_title").addClass("show_title").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
							 $(this).show();
						});						
					}else{ 
						$(api.options.slides[vars.current_slide].main_title).fadeIn();	
					}
					
					if(api.options.kenburn){
						if( api.options.slides[vars.current_slide].zoomIn !== ""){
							var zoomOutVal = api.options.slides[vars.current_slide].zoomIn === "no" ? 1 :  api.options.kenburnZoomValue;
							theme.sliderAnimateEngine(true, $("#supersized li").eq(vars.current_slide), zoomOutVal, false );
						}
					}
				}, 2000);
				$("#play-button").css({"margin-right": - (($(".supersized-nav li:first-child").width() * api.options.slides.length )+40) });
			}
			
			superSliderLoad = true;
			
			$(".supersized-nav li").find("a").removeClass("active");
			$(".supersized-nav li").eq(vars.current_slide).find("a").addClass("active");
			
			$(".supersized-thumbnails li").removeClass("active");
			$(".supersized-thumbnails li").eq(vars.current_slide).addClass("active");
			
	 	},
	 	
	 	
	 	/* After Slide Transition
		----------------------------*/
	 	afterAnimation : function(){
			self = $(this);
			clearInterval(self.posDrg);
			setTimeout(function(){
			if(cssAnimate){
				$(api.options.slides[vars.current_slide].main_title).show()
				.removeClass("hide_title").addClass("show_title").one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					$(this).show();
				});					
			}else{ 
				$(api.options.slides[vars.current_slide].main_title).fadeIn();	
			}
			
	 		if (api.options.progress_bar && !vars.is_paused) theme.progressBar();	//  Start progress bar
			
		//	$("#supersized li").css({"visibility":"hidden", "display":"none"});
		//	$("#supersized li").css({"visibility":"hidden", "display":"none"});
		//	$("#supersized li.activeslide").css({"visibility":"visible", "display":"block"});
			
			if(api.options.kenburn){
				for(var kk2=0; kk2< api.options.slides.length; kk2++){
					if( api.options.slides[kk2].zoomIn !== "none" && kk2 !== vars.current_slide){					
						theme.sliderAnimateEngine(false, $("#supersized li").eq(kk2), 1, false );
					}
				}
				if( api.options.slides[vars.current_slide].zoomIn !== ""){
					var zoomOutVal = api.options.slides[vars.current_slide].zoomIn === "no" ? 1 :  api.options.kenburnZoomValue;
					theme.sliderAnimateEngine(true, $("#supersized li").eq(vars.current_slide), zoomOutVal, false );
				}			
			}
			}, 500);
	 	},
	 	
	 	
	 	/* Progress Bar
		----------------------------*/
		progressBar : function(){	
    		$(vars.progress_bar).stop().css({left : -$(window).width()})[animateSyntax]({ left:0 }, api.options.slide_interval);
    	},
		
		/* Progress Bar
		----------------------------*/
		min_thumb : function(){
    		
    	}
	 	
	 
	 };
	 
	 
	 /* Theme Specific Variables
	 ----------------------------*/
	 $.supersized.themeVars = {
	 	
	 	// Internal Variables
		progress_delay		:	false,				// Delay after resize before resuming slideshow
		thumb_page 			: 	false,				// Thumbnail page
		thumb_interval 		: 	false,				// Thumbnail interval
		image_path			:	'images/supersized/',				// Default image path
													
		// General Elements							
		play_button			:	'#pauseplay',		// Play/Pause button
		next_slide			:	'#nextslide',		// Next slide button
		prev_slide			:	'#prevslide',		// Prev slide button
		next_thumb			:	'#nextthumb',		// Next slide thumb button
		prev_thumb			:	'#prevthumb',		// Prev slide thumb button
		
		slide_caption		:	'#slidecaption',	// Slide caption
		slide_current		:	'.slidenumber',		// Current slide number
		slide_total			:	'.totalslides',		// Total Slides
		slide_list			:	'#slide-list',		// Slide jump list							
		
		thumb_tray			:	'#thumb-tray',		// Thumbnail tray
		thumb_list			:	'#thumb-list',		// Thumbnail list
		thumb_forward		:	'#thumb-forward',	// Cycles forward through thumbnail list
		thumb_back			:	'#thumb-back',		// Cycles backwards through thumbnail list
		tray_arrow			:	'#tray-arrow',		// Thumbnail tray button arrow
		tray_button			:	'#tray-button',		// Thumbnail tray button
		
		progress_bar		:	'#progress-bar'		// Progress bar
	 												
	 };												
	
	 /* Theme Specific Options
	 ----------------------------*/												
	 $.supersized.themeOptions = {					
	 						   
		progress_bar		:	1,		// Timer for each slide											
		mouse_scrub			:	0		// Thumbnails move with mouse
		
	 };
	
	
})(jQuery);
