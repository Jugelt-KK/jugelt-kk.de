/*!
	Extended - HTML5 creative Portfolio Template
	Copyright (c) 2015, Subramanian 

	Author: Subramanian
	Profile: themeforest.net/user/FMedia/

	Version: 1.0.0
	Release Date: March 2015
	
	Built using: jQuery 		version:1.6.2	http://jquery.com/
	jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
	
 */


(function( $ ){	
	
	"use strict";
	
	function mainFm(selector, params){
		
		var defaults = $.extend({}, {
				
				// default variables				
				
				currentPage : "!home",				// Set the current page

				animationSpeed : 1000,				// Default animation speed
				
				slideshowSpeed : 5000				// Flexslider slideshow delaytime on porfolio detail page 
				
			} , params);

			
// Initialize required variables and objects
			var self = this;			
			
			self.layoutHorizontal = $("body").hasClass("horizontal_layout");			
				
			if(($("body").hasClass("high_mobile_performance") && window.innerWidth <992)){
				$("body").addClass("horizontal_layout");
			}
			
			self.onePage = $("body").hasClass("not_onepage_ver") ? false : true;	
			
			self.screenWidth =  window.innerWidth;
			
			self.alignPgHor = self.scrollHorizontal = scrollHorizontal = self.onePage ? $("body").hasClass("horizontal_layout") : false;
			
			self.homePage = defaults.currentPage === "" ? "!home" : defaults.currentPage;		
			
			self.aniDelay = 50;
			
			self.stageWidth =  window.innerWidth;
			self.stageHeight =  window.innerHeight;

			self.winWidth =  self.stageWidth;
			self.winHeight =  self.stageHeight;

			self.selEle = $(selector);
			self.IEbrowser = $.browser.msie;
			self.mobile = self.stageWidth <= 959;
			self.midMobile = self.stageWidth <= 767 && self.stageWidth > 479;
			self.minMobile = self.stageWidth <= 480;
			self.mobileDevice = self.screenWidth < 1024 && screen.height < 1024;
			ipad = (self.stageWidth === 768 || self.stageHeight === 768) && (self.stageWidth === 1024 || self.stageHeight === 1024) ;
			self.ipadPort = (self.stageWidth >= 768 &&  self.stageWidth < 1024);
			self.navTop = self.stageWidth <= 959;	
			self.StgHig = iPhoneDevice ? screen.height-60 : self.winHeight;
			
			self.setPageBorder();
			
			lowResDesktop = self.stageWidth <= 979;
						
			self.lowMobile = self.stageWidth < 769;

			self.aniSpeed = defaults.animationSpeed;
			self.flxDelay =  flxDelay = defaults.slideshowSpeed;
			
			self.headerMc = $(".header");	
			self.headMeuTyp1 = self.headerMc.hasClass("menuType1");		
			
			self.curPgChk = undefined;								
			self.isoAniFin = false;	

			
			self.miniMenu = $(".header").hasClass("mini_menu");	
			self.dottedNav = $(".dotted-nav li a");		
			self.dottedNav_added = self.dottedNav.length > 0 ? true : false;
			
			self.enableLowPerformance = isTouch || window.innerWidth < 1025;		
			self.HideUnuse = self.alignPgHor  ? false : self.enableLowPerformance ? true : false;
			
			/* Enable/Disable page content animaation*/				
			self.disableAnimation =  (isTouch || self.screenWidth < 1025) || $("body").hasClass("disableAnimation") ? true : false;			
		//	self.disableAnimation = true;
			
			self.horiAnim = false;					
			
			self.azh = undefined;
					
			if(!self.onePage){
				$('.contentWrapper').attr("data-id", self.homePage);
			}
			
			$(".itemOver").attr({"aria-haspopup":"true"});
			$(".overlay").attr({"aria-haspopup":"true"});
			$(".popup_overlay").attr({"aria-haspopup":"true"});
			
			
			self.rsSliderMc = $(".rs_slider");
			
			self.bdy = $("body");
			self.htmlBody = $("html, body");
			self.foot = $(".footer");	
			self.foter_close = $(".footer_close");
			self.navUl = $('.nav');
						
			self.pgNex = $(".nextPage");
			self.pgPre = $(".previousPage");
			self.pgNexPre = $(".pageNavigation");
			
			self.pgUp = $(".pgScrollUp");
			
			self.bdy.data("width", Number(self.stageWidth));
			self.bdy.data("height", Number(self.stageHeight));

			self.pageLoaded = false;
			
			self.pageLoadfinished = false;
			self.projFm = false;
			self.apis = [];
			self.ff = -1;
			
			self.gogo = 0;
			
			self.ContPgTopSpace = 360;
			
			self.supportScrollBar = true;
		
			self.softDrag = self.IEbrowser ? true : false;	
			
			self.singleBg = true;
			
			if(self.onePage){
				self.cM = $('.contentWrapper [data-id="'+"#"+self.homePg+'"]').parent();
				self.cM_= $('.contentWrapper [data-id="'+"#"+self.homePg+'"]');
			}else{
				self.cM = $('.contentWrapper [data-id="'+self.homePg+'"]').parent();
				self.cM_= $('.contentWrapper [data-id="'+self.homePg+'"]');
			}
			
			self.hSlider = $(".homeSlider");
			self.hSliderResp = $(".homeSlider .fullHeight.fullResponse");
			self.hSliderVid = $(".homeSlider .fullHeight.fullResponse .video_content.backGroundVideo");			
			
			self.eventHoverMc = ('ontouchstart' in document.documentElement) ? 'touchend' : 'mouseover';
			self.eventHoutMc = ('ontouchstart' in document.documentElement) ? 'mouseleave' : 'mouseleave';
			self.eventClickMc = ('ontouchstart' in document.documentElement) ? 'touchend' : 'mousedown';
			
			
			self.isTouchMove = false;
			self.isAddedHover = false;
			
			if(isTouch){	
				try {
					$("body").find(".itemOver").each(function() {				
						var mcBt = $(this);						
						this.ontouchstart = function(e) {						
							self.isTouchMove = false;
								return true;
							};
						this.ontouchend = function(e) {	
							$(".itemOver.addHover").removeClass("addHover");
							if(!self.isTouchMove){
								$(this).addClass("addHover");
							}
							self.isTouchMove = false;
							return true;
						};	
						
						this.ontouchmove = function(e) {
							self.isTouchMove = true;
							return true;
						};					
					});
					self.isAddedHover = true;	
				}catch(e){					
					self.isAddedHover = false;					
				}
			}
				
			if(!isTouch || !self.isAddedHover){
				$(".itemOver").on(self.eventHoverMc, function(event) {
					$(".itemOver.addHover").removeClass("addHover");
					$(this).addClass("addHover");
				});				
				$(".itemOver").on(self.eventHoutMc, function(event) {
					$(this).removeClass("addHover");
				});
			}	
			
			
			// create Menu fadeout layer
			self.headerFad = $(".pageFade");
			
			self.pageOpenTra = $(".pageOpenTransition");			
			
			self.contClose = $(".closeBtn");
			

			$(".header_content").data("open", false)
			
			self.bdy.prepend('<div id="dumDiv" style="position:absolute"> </div>');	
			self.dumDiv = self.bdy.children(':first-child');
			
			self.conArry = [];
			$("body").find('.contentWrapper').each(function(){
				self.conArry.push($(this));				
			});	
			
			var prId = 0;
			$("body").find('.gallery_autoThumbnail').each(function(){				
				$(this).find(".carousel_preview").attr("id", "prjId"+prId);					
				if($(this).find(".carousel_container").length == 0){
					$(this).append('<div class="carousel_container thumbItem_holder withoutThumb remove_bottomSpace"> <ul class="carousel_thumbails"> </ul></div>');
					var carThu = $(this).find(".carousel_thumbails");
					var thuNo = 0;
					$(this).find(".carousel_preview").find(".carousel_item").each(function(){
						var txt = undefined;
						var mcc = $(this);
						mcc.find(".team_name").each(function(){
							txt = $(this);
						});		
										
						mcc.attr('id', "prjId"+prId+"-"+thuNo);
						carThu.append('<li> <img src="images/0.png" alt="image01" /> </li>');
						carThu.children(":last-child").attr('data-preview', "#prjId"+prId+"-"+thuNo);
						
						if(txt !== undefined){
							carThu.children(":last-child").addClass("removeNumber");
							carThu.children(":last-child").append(txt);							
						}
						
						thuNo++;
					});
				}
				
				$(this).find(".carousel_container").attr("data-link", "#prjId"+prId);				
				
				prId++;		
			});
			
			
			$('body').find('.flexSlideshow').each(function(){
				  $(this).data("loaded", false);
			  });
					
			if(self.HideUnuse){
				for(var bb=0; bb < self.conArry.length; bb++){	
					self.conArry[bb].css({"visibility":"hidden"});
				}
			}
			
			self.navArry = [];
			for(var ab=0; ab < self.conArry.length; ab++){
				var n_spt = self.conArry[ab];
				if(n_spt.attr("data-id") !== undefined){
					self.navArry.push(self.conArry[ab]);
				}		
			}
			
			for(var ik=0; ik < self.navArry.length; ik++){
				self.navArry[ik].addClass("enablHardwareAcc");
			}
			
			$("a").each(function() {
				if($(this).attr("href") === "#" ){				
					$(this).removeAttr("href");								


				}
			});

			
			self.previewSetting();
			
			// Scroll bar added for require div			
			if(!self.alignPgHor && isTouch){
				  self.htmlBody.css({ "-webkit-overflow-scrolling": "touch"});				 
				}
			
			if(self.alignPgHor || isTouch){
			 	$(".contentWrapper").css({ "-webkit-overflow-scrolling": "touch"});
			}
			
			// Initialize niceScroll to html
				if(!isTouch && !self.IEbrowser && self.supportScrollBar){	
					self.nicScrl = $("html").niceScroll({ zindex : 92200000, styler:"fb", cursorborder : "0px", cursorminheight:100 , cursorwidth:"10px", horizrailenabled:false });
				}else{
					$("html").addClass("forceAddScr");
					$("body").addClass("forceAddScr");
				}
			
			self.bdy.css("display","block");			
	
			/* Map load navigation */
			
			$("body").find('#map_canvas').each(function(){
				var mp =$(this);
				mp.find(".openGoogleMap").data("mp", mp)
				if(mp.hasClass("autoLoadOff")){					
					mp.find(".openGoogleMap").on(self.eventClickMc, function(){ 
						$(this).data("mp").data("addMap", "yes");
						try{
							map_initialize(); 
							mapResizer();
							} catch (e) {
								$("#map_canvas").html($(this).data("mp").data("con"));			
							}
						});
				}
			});	
			
			
// Page buttons ==================================================================
			 
			
			// Cache the Window object
			self.scrollObj = $("body, html");
			self.pgAll = $(".bodyContainer");
			self.$html = $("html");
			self.$window = $("body");	
			
			// Page scrollUp button
			self.pgScrUp =  $(".move_up, .goTop");
			
			$(".pgScrollUp").on('click', function() {
				self.scrollObj.stop(false).animate({ scrollTop: "0px" }, 500, "easeInOutQuart" );
			});


			$(".contactPage .contactPage_content").css({ "min-height": self.stageHeight - self.ContPgTopSpace, "margin-top": self.ContPgTopSpace } );
			
			self.htmlScroll = isNaN($("body").scrollTop()) ? $("html") : $("body");	
			
			
			
			// Full Screen gallery thumbnail code
			for(var ab=0; ab < self.conArry.length; ab++){
				var url__ = self.conArry[ab].attr("data-id");
				self.conArry[ab].find(".fullScreenGallery_thumbnails").each(function(){
					$(this).data("url_",url__);
				});
				
				self.conArry[ab].find(".projDetailLoad").each(function(){
					$(this).data("url_",url__);
				});
			}
			
			// Portfolio project detail page - up down arrow keyboard  action
			$(".projDetailLoad").each(function(){				
				var sel = $(this);
				$('html').keydown(function(e){
					if(sel.data("url_") === self.url && sel.find(".projConWarp").length>0){
						if (e.keyCode === 39) { //up
							sel.find(".next_button_pro").trigger('click');
							return false; 
						} 
						if (e.keyCode === 37) { //down 
							sel.find(".previous_button_pro").trigger('click');
							return false; 
						} 
					}
				});
			});			
			
			
			// Fullscreen gallery - up down arrow keyboard  action
			$(".fullScreenGallery_thumbnails").each(function(){
				var me = $(this);
				var mc = $(this).find(".carousel_container").parent();
				
				me.find(".carousel_thumbails").each(function(){
					var sel = $(this);
					$('html').keydown(function(e){ 
						if(me.data("url_") === self.url){
							if (e.keyCode === 39) { //up
								var cur = sel.children().length-1 > sel.data("cur") ? sel.data("cur")+1 : 0;
								sel.data("fn")(sel.children().eq( cur ), cur,true);
								return false; 
							} 
							if (e.keyCode === 37) { //down 
								var cur = sel.data("cur") > 0 ? sel.data("cur")-1 : sel.children().length-1;
								sel.data("fn")(sel.children().eq( cur ), cur,true);
								return false; 
							} 
						}
					});
				});
				
			
				if(lowResDesktop || isTouch){
					$(".fullScreenGallery_thumbnails").removeClass("miniView");
				}				
			});
			
			$("body").find(".contentWrapper").each(function(){
				
				if($(this).find(".thumbnail_hitArea").length>0){
					var thu = $(this).find(".fullScreenGallery_thumbnails");
					var hitArea = $(this).find(".thumbnail_hitArea");
					
					hitArea.data("mcThumb",thu);
					hitArea.on(self.eventClickMc, function(event) {
					   if($(this).data("mcThumb").hasClass("miniView")){
						   $(this).data("mcThumb").removeClass("miniView");
					   }else{
						   $(this).data("mcThumb").addClass("miniView");
						   }						
					});	
				}
			});
			
			
			// Store variable to identify animate objects
			for(var ab=0; ab < self.conArry.length; ab++){
				var mcc = self.conArry[ab];				 
				 var biVid = [];
				 self.conArry[ab].find('.big_video').each(function(i){
					 biVid[i] = $(this);
				 });
				 self.conArry[ab].data("biVid", biVid);
			};
					
				
			$('.carousel_preview').each(function(){	
				$(this).find('[data-animated-in]').each(function(){
					$(this).data("caro_prev",true);
				});	
			});	  
			
			// Store variable to identify animate objects holding content animation  
			for(var ab=0; ab < self.conArry.length; ab++){				
				var main_holder = self.conArry[ab];
				main_holder.find('[data-animated-in]').each(function(){
					var aniMc = $(this);	
					aniMc.data("isAniObj", false);				
					aniMc.data("main_holder", main_holder);
											
					if(aniMc.find('.graph_container').length > 0){
						aniMc.data("isAniObj", true);						
					}
										
					if(aniMc.find('.animate_counter').length > 0){
						aniMc.data("isAniObj", true);
					}	
					
					if(aniMc.find('.big_video').length > 0){
						aniMc.data("isVidObj", true);
					}	
					
				});	
							  
				main_holder.find('[data-animated-innerContent]').each(function(){
					$(this).children().each(function(){
						$(this).data("main_holder",main_holder);
					});					  
				});
								
			};
			
			// Hide animate objects
			if(!self.disableAnimation){
				$("body").find('[data-animated-in]').css({"visibility":"hidden"});	
				
				$("body").find('[data-animated-innerContent]').each(function(){
					  $(this).children().css({"visibility":"hidden"});
				});
			}
			
			
			
			// Hide portfolio Page animate objects
			$("body").find('.portfolioPage').each(function(){
				  var main_holder = $(this);
				  main_holder.find('[data-animated-in]').each(function(){
					  $(this).data("isMasonry", true);
					  if(self.alignPgHor){
					  	$(this).css({"visibility":"visible"});	
					  }
				  });
				  
				  main_holder.find('[data-animated-innerContent]').each(function(){
					$(this).children().each(function(){
						$(this).data("isMasonry", true);
						 if(self.alignPgHor){
							$(this).css({"visibility":"visible"});
						 }
					});					  
				});
			});
			
			
			if(isTouch){
				$("body").find('.mainContent .addVideo.backGroundVideo').each(function(){
					$(this).data("inMain",true);					
				});
			}
			
			
			// Footer Open - close button
			if(isTouch){			
				$(".nav a, .footer_close, .btn-navbar").on('click', function() {					
					$("body").find('.addVideo.backGroundVideo, .video_content.fullscreenVideo').each(function(){
						var vid2 = $(this);
						vid2.data("isPlaying", false);	
						self.video_delete(vid2);
					});				
					self.videoRest();					
				});
			}
					
			
			// Set knob animation
			self.knobAni = false;
			try{		
				$("body").find('.animate_counter, .knob').each(function(i){
					var selK = $(this);	
					selK.data("val", selK.attr("data-value"));
					selK.data("display", selK.parent().parent().find(".display"));	
					selK.data("ani", selK.append($('<div><div/>')).children(":last-child"));
					selK.data("ani").css({"top":0,"position":"absolute"});
					selK.data("display").text(selK.attr("data-value"));						
					if(!selK.hasClass("animate_counter")){
						if(selK.hasClass("knob")){
						 	selK.val(selK.attr("data-value")).trigger("change");
						 }
					}						
					self.knobAni = true;
				});	
			} catch (e) { self.knobAni = false; }
			
			
			
			// Push all the preload image into a preloadImages array			
			self.preloadImages = [];
			
			$('.preload').each(function(){
				self.preloadImages.push($(this));
			});
				
			$('.preloadimages_inline img').each(function(){
				var th = $(this);
				var img;
				if(th.hasClass("cssBackground")){
					img = retinaDevice ? $(this).attr("data-src-2x") : $(this).attr("data-src");					
				}else{
					img = window.innerWidth > 767 ? $(this).attr("data-src") : ($(this).attr("data-src-small")? $(this).attr("data-src-small")  : $(this).attr("data-src"));
					}
				th.attr("data-src", img);
				th.addClass("preload");
				self.preloadImages.push(th);
			});
			
			self.imgFinished = 0;
			
			if( self.preloadImages.length>0){
				self.intImgLoad(self.preloadImages[self.imgFinished]);
			}else{
				siteStartOpen = true;
			}
			
			// Opening intro code initilize here
			self.openingIntro = false;
			self.introFinish = false;
			self.introCur = 0;
			self.introMc = $(".pageFade .openingIntro");
			self.introMc.data("lis", $(".pageFade .openingIntro li"));
			if(self.introMc.length > 0){
				setTimeout( function(){
					self.introTextAnimation(self.introMc);
				}, 700);
			}else{
				self.openingIntro = true;
			}
			
			 setTimeout( function(){	$(".pageFade .loading_2x").removeClass("out"); }, 200);
			
			// Initialize the site after the required time interval	
			var intV = setInterval(function() {					
				  if(siteStartOpen && self.openingIntro ){
					  clearInterval(intV);
					  setTimeout( function(){						 
						self.headerMc.show();
						$(".homeSlider .homepage_con").show();	
						
						self.initialize();
						
					}, 200);
				}				
			},10);
			
			
	}	
	
	
	mainFm.prototype = {		
	
	
		// Opening intro animation code
		introTextAnimation : function(mc) {
			var self = this;
			var cur = mc.data("lis").eq(self.introCur);
			var tim = Number(cur.attr("data-time")) ? Number(cur.attr("data-time")) : 1;	
			
			if(cssAnimate){
				cur.css({"display":"block"}).addClass(mc.attr("data-introTextInEffect"));
				cur.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					setTimeout( function(){
						cur.attr("class", "");
						cur.addClass(mc.attr("data-introTextOutEffect")).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
							cur.css({"display":"none"}).attr("class", "");
							self.introCur++;
							if(self.introCur < mc.data("lis").length){
								if(siteStartOpen && self.introFinish){
									self.openingIntro = true;	
									mc.remove();
								}else{
									self.introTextAnimation(self.introMc);						
								}							
							}else{								
								self.introCur=0;
								if(siteStartOpen){
									self.openingIntro = true;
									mc.remove();
								}else{								
									self.introTextAnimation(self.introMc);
								}
							}
						});
					}, tim*250);
				});
			}else{
				
				cur.css({"display":"block", "opacity":0});				
				cur.animate({"opacity": 1}, 1000 , "easeInOutQuart", function(){
					setTimeout( function(){
						cur.css({"display":"none"});
						self.introCur++;
						if(self.introCur < mc.data("lis").length){
							if(siteStartOpen && self.introFinish){
								self.openingIntro = true;	
								mc.remove();
							}else{
								self.introTextAnimation(self.introMc);						
							}							
						}else{
							self.introFinish = true;
							self.introCur=0;
							if(siteStartOpen){
								self.openingIntro = true;
								mc.remove();
							}else{								
								self.introTextAnimation(self.introMc);
							}
						}						
					}, tim*500);
				});
			}
		},
				
		// Initialize the require objects and variables 
		initialize : function(){
			
			var self = this;
			
			self.prePg = "";
			self.curPg = "";
			self.menuList = [];	
			
			
			
			// Loading object added
			self.bdy.prepend('<div id="preloadImg" style="width:150px; height:150px; visibility:hidden; position:absolute; left:0; top:0; overflow:hidden"> </div>');
			self.dumDiv.addClass('email_loading');
			self.dumDiv.removeClass('email_loading');
			
			if(isTouch){
				$("html , body").css({"overflow":"auto"});
			}

			$(".isotope_option").show();				

			$("body").find('.masonry_items').each(function(){
			//	$(this).find(".item").css({"position":"relative"});
				$(this).find(".item").addClass("enablHardwareAcc");				
			});	

			self.nexButton_detailPg = $("a.next_button");
			self.preButton_detailPg = $("a.previous_button");
			
			
// Initialize the menu navigation action
			var kk = -1;
			var qq = -1;
			self.rez = false;
			
			try {
				document.createEvent('TouchEvent');
				$(".lightStyle, .inverseStyle, .contentWrapper").on('click', function() {
				});
			} catch (e) {
				// nothing to do
			}
			
			$('html').keydown(function(e){ 
				if (e.keyCode === 38) { //up 
					self.scroll_by(300);
				return false; 
				} 
				if (e.keyCode === 40) { //down 
					self.scroll_by(-300);
					return false; 
				} 
			});
			
			
			
			$(".header .nav li").each(function() {
				var slf = $(this).children();
				qq++;
				if(slf.attr("href") === "" || slf.attr("href") === undefined){
					return;
				}
				slf.on('click', function() {		
					$(".nav li a").removeClass("active");
					$(this).addClass("active");	
				//	$(".smartMenu").removeClass("openIt");
				//	$(".smartMenu").addClass("closeIt");	
					var gg =  String($(this).attr("href")).split("#");
					if(gg[1] === self.url){
						self.page_position();
					}

					
				});
				
				slf.on('click', function() {	
					var uul = $(this).attr("href");
					var trg = $(this).attr("_target");
					if($(this).attr("href") && $(this).attr("href") !== "undefined" && uul.charAt(0) !== "#"){										
						self.headerFad.removeClass("out");						
						setTimeout( function(){	 
							if(trg !== undefined){
								window.open(uul, trg);
							}else{
								window.location.href = uul;	
							}
						}, 500);
										
						return false;
					}
				});
				
			});
			
			self.parallaxBgUpdate();
			
			setTimeout(function(){
				$("body").find('.hideForLoad').each(function(){
					$(this).css({"height":"auto", "overflow":"inhert"});
				});
			},1000);
			
			
			// Initialize the cycle slideshow
			
			$("body").find('.slideshow_cycle').each(function(){
				cycle_pluign($(this)); 
				$(this).cycle("pause");
			});
			
			
			$(".smoothPageLoad").each(function() {
				var slf = $(this);
				slf.on('click', function() {	
					var uul = $(this).attr("href");
					var trg = $(this).attr("_target");
					if($(this).attr("href") && $(this).attr("href") !== "undefined" && uul.charAt(0) !== "#"){										
						self.headerFad.removeClass("out");						
						setTimeout( function(){	 
							if(trg !== undefined){
								window.open(uul, trg);
							}else{
								window.location.href = uul;	
							}
						}, 500);					
						return false;
					}
				});
			});
			
			
			$(".menu_link").each(function() {
				var slf = $(this);
				qq++;
				if(slf.attr("href") === "" || slf.attr("href") === undefined){
					return;
				}
				slf.on('click', function() {					
					var gg =  String($(this).attr("href")).split("#");
					if(gg[1] === self.url){
						self.page_position();
					}
				});	
			});

			
			$("body").find(".homeEleFade").each(function(){													 
				self.animateObject($(this), 0);				
			})
			
			
			

			self.homePg = self.homePage === "" ? self.menuList[0].substr(1, self.menuList[0].length): self.homePage;
			self.cM = self.curP = $('.contentWrapper [data-id="'+"#"+self.menuList[0]+'"]').parent();

			$('.contentWrapper [data-id="'+"#"+self.homePg+'"]').css("visibility","visible");			
			$('.contentWrapper [data-id="'+"#"+self.homePg+'"]').hide();			

			
			self.page_dimension();
			
			if(!self.alignPgHor){			
				for(var ab=0; ab < self.conArry.length; ab++){	
					self.conArry[ab].data("loaded", true);
					self.load_plugin_Items(self.conArry[ab]);		
				};		
			}
			
			// Initialize the video	
			self.intVideoObject(self.bdy);
			
			// Enable/disable the image scale animation
			if(isTouch){
				$(".circle_large").removeClass("enableTransition");  
			}else{
				$(".circle_large").addClass("enableTransition"); 
			}
			
			self.site_display();			
			self.moveItem =  $(".mainContent");
			
			
			
			// display isotope item
			$('.isotope_items').show();
			
			if(self.headerFad){
				setTimeout( function(){	
					self.headerFad.addClass("out"); 
					setTimeout( function(){	
						self.headerFad.find(".loading_2x").remove();
					}, 1000);
				}, 1500);				
			}
			
			$(".previousPage, .nextPage").on('click', function() {
				if($(this).data("url") && $(this).data("url") !== "undefined"){
					if($(this).data("url") !== self.url){
						window.location.href = "#"+$(this).data("url");
					}else{
						self.page_position();
					}
					if($('.nav a[href$="#'+$(this).data("url")+'"]').length > 0){
						$(".nav li a").removeClass("active");
						$('.nav a[href$="#'+$(this).data("url")+'"]').addClass("active");
					}
				}
			});
			
			if(isTouch){
				$(".fadeAfterLoad").css({"display":"block"});
			}else{
				$(".fadeAfterLoad").delay(200).fadeIn(300);
			}

			
			
			
			// Initialize the window resize function
			clearInterval(self.intr);
			$(window).resize(function() {	
				clearInterval(self.intr);
				self.intr = setInterval(function(){clearInterval(self.intr); self.windowRez();},100);
			});
			
			//Initialize the mobile orientationchange function
			$(window).on( 'orientationchange', function(){
				self.windowRez();
			});
			
			
			var oTim = self.onePage ? 700 : 200;				
			var chkInt = setInterval(function() {
				clearInterval(chkInt);
				self.headHig = self.stageWidth > 991 ? (self.stageWidth < 1025 || !self.headMeuTyp1 ? pageHeaderHeight_mini : pageHeaderHeight) : self.alignPgHor ? 0 : pageHeaderHeight_mini;
				
				self.vertical_scroll();
				
				self.history();
				self.page_setup();
						
			}, oTim);
			
			$('.preloadimages_inline img').each(function(){
				$(this).remove();
			});
			$('.preloadimages_inline').remove();
			
			self.superSlider = typeof superGalleryInit !== "undefined" && typeof superGalleryInit !== undefined;
			self.rsSlider = typeof rsSliderInit !== "undefined" && typeof rsSliderInit !== undefined;						
		
			self.superSliderInt;
			
			if(self.superSlider){
				superGalleryInit();
				if(!supersizedOnBody){
					$(".supersized_gallery").show();
					$("#superNav").show();
					$(".supersized-nav").show();
					api.min_thumb();
				}else{
					if($.supersized.vars.is_paused && $.supersized.vars.options.autoplay === 1){ api.playToggle(); }
				}
				
				
				$('.palyPause_slideshow').on(self.eventHoverMc, function(event) {
					clearInterval(self.superSliderInt);
					if(!$.supersized.vars.is_paused){ api.playToggle(); }
				},function(){ 
				
					clearInterval(self.superSliderInt);
					self.superSliderInt = setInterval(function(){
						clearInterval(self.superSliderInt);
						if($.supersized.vars.is_paused && $.supersized.vars.options.autoplay === 1){ api.playToggle(); }						
					}, 1000);
										
				});
			}
			
			
			if(self.rsSlider){
				rsSliderInit();				
				apiRS.revpause();
			}
			
			
		},
		
		// Site Preload image  function
		intImgLoad : function  (img){
		
			var self = this;
				img.attr('src', img.attr("data-src"));
                 img.on("load",function(){
					if(self.imgFinished < self.preloadImages.length-1){
                      self.imgFinished = self.imgFinished+1;					  
                      self.intImgLoad(self.preloadImages[self.imgFinished]);
					  $(".site_loading_bar").stop().animate({"width":Math.round(self.imgFinished/(self.preloadImages.length)*100)+"%"});
					}else{
						$(".site_loading_bar").stop().animate({"width":"100%"});
						siteStartOpen = true;
					}
					
                  }).error(function () {

				  if(self.imgFinished < self.preloadImages.length-1){
					self.imgFinished = self.imgFinished+1;
					self.intImgLoad(self.preloadImages[self.imgFinished]);
					$(".site_loading_bar").stop().css({"width":Math.round(self.imgFinished/(self.preloadImages.length)*100)+"%"});

				  }else{
					  $(".site_loading_bar").stop().css({"width":"100%"});
				   	siteStartOpen = true;
				  }
                  
				  }).each(function() {
                    if(this.complete) { $(this).trigger('load'); }
                  });                  
          },
		  
		
		// Page vertical scroll action
		vertical_scroll : function(){
			var self = this;
			self.scrspy_curPg = self.url;
			self.sliderTimm;

			var scrpyMc = []
			for(var ab=0; ab < self.conArry.length; ab++){
				scrpyMc.push(self.conArry[ab]);
			};
			
			if(!self.onePage){
				self.curPageShow = $('.contentWrapper');
			}else{
				self.curPageShow = scrpyMc[0];
			}
			
			
			var scrIntSpd = isTouch ? 700 : 70;
			
			$(window).trigger("scroll");
			
			$("body").find(".pageContent").each(function() {	
				var scrObj = $(this);
				
				$(this).find(".move_up").each(function() {
					$(this).find("span").on(self.eventClickMc, function(event) {
						var mcP = $(this);
						var space = isNaN(parseInt($(".pageContent").css("margin-top"))) ? 0 : parseInt($(".pageContent").css("margin-top"));
						space = self.stageWidth > 991 ?  0 : self.stageWidth < 481 ? 70 : mcP.parent().hasClass("plain") ? 40 : 50-self.borderSize;
						if(!mcP.parent().hasClass("last")){	
							self.scroll_by(mcP.parent().parent().next().position().top+space, self.scrollObj);						
						}else{											
							self.scroll_by(0, self.scrollObj);
						}
					});
				});
				
				$(this).find(".move_down span").on(self.eventClickMc, function(event) {
					self.scroll_by($(this).parent().parent().prev().position().top+60, self.scrollObj);
				});
						
			});
			
			
			setTimeout(function(){
				$(window).trigger("scroll");
			}, 1500);	
			
			// Window scroll event
			$(window).scroll(function() {

													
				clearInterval(self.scrIntr);
				self.scrIntr = setInterval(function(){
					clearInterval(self.scrIntr);
					self.scrollPos = scrollPos = self.$html.scrollTop() > 0 ?  self.$html.scrollTop() :  self.$window.scrollTop();
					
					if(self.scrollPos > 240){
						self.pgUp.show();					
					}else{
						self.pgUp.hide();
					}
					
					try{			  
					
						if(!self.disableAnimation){
						  self.curP.find('[data-animated-in]').each(function(){							
							  self.animateObject($(this), self.scrollPos);
						  });
						}
						
					}	catch (e) { }
					
					try{
						self.curP.find('.big_video').each(function(){	
							var mcv = 	$(this);
							var par = 0;
							if(mcv.attr("data-anchor-to") !== undefined){
								var mcv2 = mcv; 								
								for(var io=0; io<mcv.attr("data-anchor-to").split(".").length; io++){
									mcv2 = mcv2.parent();
								}				
								par = mcv2.position().top;
								if(par-self.stageHeight < self.scrollPos && par+self.stageHeight > self.scrollPos){
									$("#big-video-vid").css({"display":"block"});
								}else{
									$("#big-video-vid").css({"display":"none"});
								}
							}					
							
						 });
					}	catch (e) { }
					
				}, 20);	
				
						
			});				
			
		},
		

		
		scroll_by: function (pixels, mc) { 
			var self = this;
			var curMc = mc !== undefined ? mc : self.curP;

			try {				
				if(!isNaN(pixels)){
					var movPos = pixels;
					
					if(lowResDesktop && ! self.midMobile && !self.minMobile){
						movPos = movPos-40;
						}
						
					if(self.midMobile){	
						movPos = movPos-40;						
						}
						
					if(self.minMobile){
						movPos = movPos-70;
						}
					
					curMc.animate({ scrollTop: movPos}, 500 , "easeInOutQuart");
				}else{
					curMc.scrollTop(0);	
				}					
			} catch (e) {} 
			
		},
		
		
		
		// Fullscreen gallery video load function
		fullScreenGallery : function(obj){
			var self = this;
			try{
				$(obj).find('.addVideo').each(function(){
					var vid_ = $(this);
					self.video_delete(vid_);
				});
			} catch (e) { }
		},		
		
		

/* Resize Image */
		
		resizeImg : function (obj){
						
			var self = this;
          	if(obj.width() === 0){ return; }
			var hold;

			if(obj.parent().parent().parent().parent().hasClass("projImgs") || obj.hasClass("resize_align")){				
				if(obj.hasClass("resize_align")){
					hold =obj.parent();
				}else{
					hold =obj.parent().parent().parent().parent();
				}
			}else{
				return;
			}

			obj.css({"width":"auto", "height":"auto"});

			if(obj.data("width_") === undefined){
				var image = new Image();				
				image.onload = function() {
				  appy_resizeImg(obj, this.width, this.height);
					obj.data("width_", this.width);
					obj.data("height_", this.height);
					try {	this.remove();	} catch (e) { }
					self.scroll_update();				
					};				
				image.src = obj.attr("src");
			}else{
				appy_resizeImg(obj,obj.data("width_"), obj.data("height_"));	
				self.scroll_update();		
			}
			
			function appy_resizeImg(obj,wid, hig){				
				var	iw = wid,
					ih = hig,
					ww = hold.width(),
					wh = hold.height(),
					rw = wh / ww,
					ri = ih / iw,
					tp = 0,
					lp = 0,
					newWidth, newHeight,
					newLeft, newTop,
					properties;

					if(obj.hasClass("resize_align") && !obj.hasClass("fitInside") ){
						obj.css({ "margin-left": "0px" });
						var rezr = hold.width() < hold.height() ? rw < ri : rw > ri;
						newWidth = ww;
						newHeight = ww * ri;
						if ( rezr ) {
							lp = ( ww  -newWidth)/2;				
						} 
						obj.css({'margin-left': Math.round(lp) + "px"});
					}else{
						if (ww > wh) {	
							newWidth = ww;
							newHeight = ww * ri;
							if(ww < newWidth || wh < newHeight ){
								newWidth = wh / ri;
								newHeight = wh;
							}
						} else {							
							newWidth = ww;
							newHeight = ww * ri;
						}
						lp = ( ww  -newWidth)/2;
						obj.css({'margin-left': Math.round(lp) + "px"});
					}
					
					newWidth =  Math.round(newWidth);
					newHeight = Math.round(newHeight);
					
					tp = Math.round((wh-newHeight)/2);
					
			  		properties = {
							'width': Math.round(newWidth) + 'px',
							'height': Math.round(newHeight) + 'px',
							'margin-top': Math.round(tp) + "px",
							"left":"auto",
							"right":"auto",
							'bottom': "auto"		
						};
						
					obj.css( properties);
				}
		},


// Site start display function
		
		site_display : function(){			
			var self = this;			

			if(!self.IEbrowser){
				$(".isotope_items .item a .img_text").css("visibility","visible");
			}
			
			$(".contentWrapper").find('#mapWrapper').each(function(){
				if(!self.IEbrowser){
					$(this).parent().prepend($(this).data('map'));
					$(this).parent().children(":first-child").addClass('mapStyle');
					$(this).remove();
				}
			});
			
				/* Portfolio masonry plugin initilize */
				$("body").find(".masonry_items").each(function(){
					var $container = $(this).isotope({ 
						masonry: {
						  columnWidth: '.grid-sizer',
						  gutter: '.gutter-sizer'
						},
						itemSelector : '.item',
						animationOptions: {
							duration: 750,
							easing: 'linear',
							queue: false,
						},
					});					
					 $(this).data("masonryElement", $container);
				});

			
			/*	.parallax(xPosition, speedFactor, outerHeight) options:
				xPosition - Horizontal position of the element
				inertia - speed to move relative to vertical scroll. Example: 0.1 is one tenth the speed of scrolling, 2 is twice the speed of scrolling
				outerHeight (true/false) - Whether or not jQuery should use it's outerHeight option to determine when a section is in the viewport
			*/
			
			if(!isTouch){
				$('.addParallaxEffect').each(function(){
					$(this).parallax("50%", 0.6);
				});
			}
			
			// Flex slideshow initialize
			$('body').find('.flexslider').each(function(){
				if(!$(this).hasClass("flexSlideshow_twitter")){
					try{
						
						if(!$(this).data("loaded")){
							$(this).data("loaded", true);
							var aniTyp = $(this).hasClass('slideAnimation') ? "slide" : "fade";
							var tim_ = $(this).attr('data-slidetime') ? Math.abs($(this).attr('data-slidetime')) : 5000;
							$(this).find("a.lazyload").each(function(){
								self.lazyLoadInt($(this));
							});								
							if(aniTyp === "slide"){
								$(this).find("li").each(function(i){
									$(this).find(".loading_x").remove();
									$(this).find("img").show();
								});
							}
							var laz = $(this).hasClass('flexslider');
							if(!laz){  $(this).addClass("flexslider"); }						
							var ffx = $(this);
							ffx.append('<div class="slider_loading" ></div>');
							$(this).find(" a.lazyload").each(function(){
								self.lazyLoadInt($(this));
							});
							var flexs = $(this);
							flexs.flexslider({
							slideshow: true,
							animation: aniTyp,
							slideshowSpeed: tim_,
							start: function(slider){
								flexs.data("slid",slider);
								flexs.find(".slider_loading").remove();
								slider.pause();
								}
							});	
						}
					} catch (e) { }	
				}
			});			
		},
		
		
		animateEngine : function(_obj, _xpo, _ypo, _alp){			
			var self = this;
			if(!self.softDrag){
				if(!isNaN(_xpo)){
					clearInterval(self.posDrg);
					var _sp = _obj.position().left;				
					self.posDrg = setInterval( function(){													
						_sp += (_xpo-_sp)/3;
						try { _sp = Number(_sp.toFixed(0)); }catch(e){}
						if(_xpo > _sp-5 && _xpo < _sp+5){
							clearInterval(self.posDrg);	
							_sp = _xpo;
						}
						if(Modernizr.csstransforms){
							_obj.css({ "x" : _sp+"px" });
						}else{
							_obj.css({ "left" : _sp+"px" });
						}
					}, 10);
				}	
			}else{	
				_obj.css({ "x" : _xpo+"px" });
			}
		},
		
		
		
		
		// Set page dimension
		page_dimension : function(){
			var self = this;
			var conPos = 0;
			self.numCon = 0;

			$(".mainContent").children().each(function(){
				self.numCon++;
			});	
			
			
			self.curP.find(".addPageBorder").each(function(){
				var mcc = $(this);
				mcc.css({"width": self.winWidth-(self.borderSize*2), "min-height": self.StgHig-(self.borderSize*2),	 
				"margin-top": 60+"px", "margin-left": self.borderSize+"px", "margin-right": self.borderSize+"px", "margin-bottom": "0px" });
			});	
				
		//	if(self.alignPgHor){
				
				$("body").find(".contentWrapper").each(function(){
					var mcc = $(this);
					mcc.css({"width": self.winWidth,  "min-height": self.StgHig });
				});	
								
				if(self.scrollHorizontal){
					$(".mainContent").css({"width":(self.numCon*self.winWidth)+50+"px"});					
				}else{
					$(".mainContent").css({"width": self.winWidth, "overflow-x":"hidden" });
				}				

			
			
			
			self.curP.find(".fullHeight").each(function(){
				var se2 = $(this);
				
				if(self.stageWidth > 991){
					if(se2.hasClass("fixed")){
						se2.css({"height": self.StgHig-(self.borderSize+60)});
					}else{
						se2.css({"min-height": self.StgHig-(self.borderSize+60)});
					}
				}else{
					se2.css({"height": "auto", "min-height": "auto"});
				}
				
				if(se2.hasClass("fullResponse")){
					var dumY = !self.alignPgHor || self.stageWidth < 992 ? self.headMeuTyp1 ? pageHeaderHeight : pageHeaderHeight_mini : 0;
					
					if(se2.hasClass("fullscreenVideo")){
						se2.css({"min-height": self.StgHig-dumY, "min-width": "100%"});
					}
				
					se2.find(".video_content.fullscreenVideo, .fullscreenVideo ").css({"min-height": self.StgHig-dumY, "min-width": "100%"});
				}else{
					if(self.mobile){ 
						se2.css({"min-height": "50px"});
						se2.css({"min-height": "auto"});
					}
				}				
			});		
				
			setTimeout(function(){	
			
				self.curP.find(".portion").each(function(){
					var se2 = $(this);
					if(self.stageWidth > 991){
						se2.css({"min-height": self.StgHig-(60)});
					}else{
						se2.css({"min-height": "auto"});
					}	
				});
			
			
				self.curP.find(".fitHeight").each(function(){
					var se3 = $(this);
					se3.find(".makeFit").css({"min-height": "auto", "height": "auto"});
					var hhf = 0;
					se3.find(".makeFit").each(function(){
						hhf = $(this).height() > hhf ? $(this).height() : hhf;
					});	
					
					if(se3.hasClass("fullHeight")){
						hhf = hhf < self.StgHig-(self.borderSize+60) ? self.StgHig-(self.borderSize+60) : hhf;					
						se3.find(".makeFit").css({"min-height": self.StgHig-(self.borderSize+60)});
					}
					
					se3.find(".makeFit").each(function(){	
						if(self.stageWidth <= 991 && $(this).hasClass("mobFitRemove") ){								
							$(this).css({"height": "auto", "min-height": "auto"});								
						}else{
							$(this).css({"height": hhf});
							}
							
				//		se3.find(".big_video.backGroundVideo").css({"height": $(this).height() });
							
					});
				});
				
				
				$(".fullScreenSlider").css({"min-height":self.StgHig});
				if(!isMobileChk){
					self.hSlider.css({"height":self.StgHig-(self.borderSize+60), "min-height":self.StgHig-(self.borderSize+60)});
				}else{
					self.hSlider.css({"height":self.StgHig-(self.borderSize+120), "min-height":self.StgHig-(self.borderSize+120)});
				}

				
				
				self.curP.find('.slideshow_cycle').each(function(){ 
					$(this).css({"width":"auto"});
					var cw = 0;
					var ch = 0;
					
					$(this).find(".slide").each(function(){
						$(this).css({"width":"auto", "height":"auto"})
						cw = $(this).outerWidth() > cw ? $(this).outerWidth() : cw;  
						ch = $(this).outerHeight() > ch ? $(this).outerHeight() : ch;						
						});
						
					$(this).find(".slide").css({"width":cw});   
					$(this).css({"width":cw});   
					$(this).css({"height":ch});  
				});
				
				self.curP.find('#supersized').each(function(){ 				
					api.resizeNow();
				});
				
				self.videoRest();
				
				if(BigVid !== undefined){
					self.curP.find('#big-video-wrap').each(function(){ 
						$(this).css({"height": $("#big-video-wrap").parent().parent().height()});
					});
				}
		
			},250);
			
						
			$(".fullScreenSlider").css({"min-height":self.StgHig});
			if(!isMobileChk){
				self.hSlider.css({"height":self.StgHig-(self.borderSize+60), "min-height":self.StgHig-(self.borderSize+60)});
			}else{
				self.hSlider.css({"height":self.StgHig-(self.borderSize+120), "min-height":self.StgHig-(self.borderSize+120)});
			}
			
			self.pgAll.css({"min-height":self.stageHeight});
						
		},
		
		
		// Update the page, when the page change is or resize 
		updatePage : function(ele){			
			var self = this;	
			
			self.page_dimension();
			
			if(self.rez){ return; }
			
			
			if(ele.find(".footer_holder").length>0 && self.layoutHorizontal){
				ele.find(".footer_holder").append($(".footer.prependToPage"));
			}
							
			var menuDefined = false;			
			var iid = ele.attr("data-id");			
			
			if($('.nav a[href$="#'+ ele.attr("data-id")+'"]').length > 0 || !self.onePage){
				menuDefined = true;
				$(".nav li a").removeClass("active");				  			
				$(".nav li ul li a").removeClass("active");
				
				if(self.onePage){
					if(!$('.nav a[href$="#'+iid+'"]').parent().parent().hasClass("nav")){
					  $('.nav a[href$="#'+iid+'"]').parent().parent().parent().children(":first-child").addClass("active");
					}
					$('.nav a[href$="#'+iid+'"]').addClass("active");	
				}else{
					if(!$('.nav a[href$="'+self.homePage+'"]').parent().parent().hasClass("nav")){
					  $('.nav a[href$="'+self.homePage+'"]').parent().parent().parent().children(":first-child").addClass("active");
					}					
					$('.nav a[href$="'+self.homePage+'"]').addClass("active");	
					
				}
			}
				
			if(!menuDefined){ 
			  	$(".nav li a").removeClass("active");
			  	$(".nav li ul li a").removeClass("active"); 
			}
			
			
			if(self.dottedNav_added){
				self.dottedNav.removeClass("active");
				$('.dotted-nav li a[href$="#'+ele.attr("data-id")+'"]').addClass("active");
			}
			
			
			if(!self.alignPgHor){	
				ele.css({"height":"auto", "overflow":"hidden"});
			}else{			
				$("body").find(".contentWrapper").each(function(){
					var mcc = $(this);					
					if(isTouch){
						mcc.css({ "height": self.StgHig, "overflow-y":"auto"});	
					}else{
						mcc.css({ "height": self.StgHig, "overflow":"hidden" });
					}	
				});	
				
				if(isTouch){
					ele.css({ "height": self.StgHig, "overflow-y":"auto"});	
				}else{
					ele.css({"height":"auto", "overflow":"hidden"});		
				}
			}
			
			
			for(var bb=0; bb < self.conArry.length; bb++){	
				self.conArry[bb].scrollTop(0);
			}	
			
			$("body").find('.slideshow_cycle').each(function(){
				$(this).cycle('pause');		
			});
	
				
			ele.find('.slideshow_cycle').each(function(){
				$(this).cycle('resume'); 
			});
			
			
			ele.find('.flexslider').each(function(){
				try{  
					if($(this).data("slid") !== undefined){
						$(this).data("slid").windowRez();						
						if($(this).attr("data-autoplay") === "yes" ){
							$(this).data("slid").resume();
						}
					}
				} catch (e) { }	
			});
			
			
			ele.find('.masonry_items').each(function(){	
				$(this).data("masonryElement").isotope('layout');		
			});	
					
			
			ele.find('.fullScreenGallery_thumbnails').each(function(){ 
				var sc = $(this).find('.thumbClose_btn .btn_icon');
				var mc = $(this).find(".carousel_container");
				if(mc.width()<15){
					sc.text("OPEN");
				}else{
					sc.text("CLOSE");
				}
			
			});
			
			
			if(lowResDesktop){
				ele.find('img.resize_align').each(function(){
					self.resizeImg($(this));
				});	
			}			
						
			setTimeout(function(){ 
				self.videoRest(); 
				if(!isTouch && !self.IEbrowser && self.supportScrollBar){
					self.nicScrl.resize();
				}
			
				$("#big-video-wrap").css({"display":"none"});
				
				if(BigVid !== undefined){
					BigVid.getPlayer().pause();			
				}
	
				if(ele !== undefined ){			
					ele.find('.big_video').each(function(){
						var vmc = $(this);						
						if(!self.lowMobile){
							if(vmc.attr("data-background-video") !== undefined){
								$("#big-video-vid").css({"display":"block"});
								vmc.append($("#big-video-wrap"));						
								var videoVolume = isNaN(vmc.attr("data-video-volume")) ? defaultVolume : Number(vmc.attr("data-video-volume"));
								if(bgVideopath !== vmc.attr("data-background-video"))	{
									bgVideopath = vmc.attr("data-background-video");	
									if(BigVid !== undefined){
										var vpp = bgVideopath.split(",");
										if(vpp < 2){
											BigVid.show(vpp[0] );
										}else{
											BigVid.show(vpp[0], {altSource:vpp[1]}  );
										}
									}												
								}else{	
									if(BigVid !== undefined){
										$(".vidPlyPauBtn").data("view", true);	
										$(".vidPlyPauBtn").find("i").addClass("highlight");	
										BigVid.getPlayer().play();	
									}
								}
								
								try{ 
									if(BigVid !== undefined){ 
										BigVid.getPlayer().volume(videoVolume); 
									} 
								} catch (e) { }
							}
						}else{
							if(BigVid !== undefined){
								$(".vidPlyPauBtn").data("view", false);	
								$(".vidPlyPauBtn").find("i").removeClass("highlight");	
								BigVid.getPlayer().pause();	
							}
						}
					});	
					
					if(ele.find('.big_video').length > 0){
						$("#big-video-wrap").css({"display":"block","opacity":0}).animate({"opacity":1}, 500, "easeInOutQuart");;	
					}
				}
			
			}, 1500);
			
			
		},
		
		
		load_plugin_Items : function (e){
			var self = this;
			self.curP = e;
			self.curP.find(".carousel_container a.lazyload, .elastislide-carousel a.lazyload, a.lazyload_single").each(function(){
				self.lazyLoadInt($(this));
			});
			
	
			if(self.curP.data("carouselLoad") === undefined || !self.alignPgHor){
				self.curP.data("carouselLoad", true);	
				
				// Initialize carousel Elasticslider 
				self.curP.find('.carousel').each(function(){
					
					$(this).find("img").css({"visibility":"visible"}).show();
					$(this).elastislide();
				});					
			};
			
			
			if(self.curP.data("carouseGallLoad") === undefined ){ 
				self.curP.data("carouseGallLoad", true);
				
				var fullThumbnail = self.curP.find('.fullScreenGallery_thumbnails');
				
				self.curP.find('.carousel_container').each(function(){					
					$(this).data("thu",fullThumbnail);					
					
					// Initialize carousel galler Elasticslider										
					if($(this).attr("data-link") === undefined){
				 		$(this).find(".carousel_thumbails").elastislide( { minItems : 1 });	
					}else{
						carousel_gallery_int ($(this));	
					}					
					if(self.disableAnimation){
					 	$(this).find(".carousel_thumbails").css({"visibility":"visible"});	
					}					
				});

			}
			
			
			if(self.url !== self.curPgChk){	
				if(self.alignPgHor){		
					self.htmlBody.scrollTop(0);	
				}
				try{					
					self.curP.find(".carousel_container").each(function(){
						var mc = $(this);
						if(mc.data("firstLoad") === undefined){
							mc.data("firstLoad", true);
							mc.css({"height":"auto"});	
							mc.data("hig", mc.height());
						}						
					});	
				} catch (e) { }				
			}			
			
			if(!self.alignPgHor){					
				if(self.curP.hasClass("bodyBackground")){
					  var img = !isMobileChk ? self.curP.attr("data-src") : (self.curP.attr("data-src-small")? self.curP.attr("data-src-small")  : self.curP.attr("data-src"));	
					  var imgAtt = !isTouch ? "fixed" : "scroll";
					  var vd = self.curP.hasClass('.backGroundVideo');
					  
					  if(img !== undefined){
						if(img !== "none"){
							$("body").addClass("addBackground").css({"background-image":"url("+img+")"});	
						}else{
							$("body").removeClass("addBackground").css({"background-image":"none"});
						}
					  }
				};	
						
				self.beforePageLoad(self.curP);				
			}
			
			
			if(!self.curP.data("linkBugFix")){
				self.curP.data("linkBugFix", true)
				$(".thumbItem_holder .thumbItem").find("a").on(self.eventClickMc, function(event) {
					aLink = $(this);
					if(aLink.attr("href") !== undefined && !aLink.hasClass("magnificPopup") && !aLink.hasClass("smoothPageLoad") ){						
						if(aLink.attr("_target") !== undefined){
							window.open(aLink.attr("href"), aLink.attr("target"));
						}else{
							window.location.href = aLink.attr("href");	
						}									
					}
					return false;

				});
			}
			
			
		},
		
		
		
		// Position the page
		page_position : function (e){	
			var self = this;
			
			if(self.alignPgHor){	
				if(isTouch){
					self.htmlBody.css({"overflow":"auto"});
				}
				
				for(var ik=0; ik < self.navArry.length; ik++){
					if(self.stageWidth > 1024){					
						self.navArry[ik].css({"visibility":"visible"}).show();		
					}else{					
						if(self.navArry[ik].attr("data-id") === self.url){
						  self.navArry[ik].css({"visibility":"visible"}).show();	
						}else{
						  self.navArry[ik].css({"visibility":"hidden"}).hide();
						}
					}			 
				 }
			}			
			
			self.curP = self.navArry[0];	
			
			 for(var ik=0; ik < self.navArry.length; ik++){
				if(self.navArry[ik].attr("data-id") === self.url){
					self.curP = self.navArry[ik];					
				}
			}

			var isInCont = undefined;
			for(var ab=0; ab < self.conArry.length; ab++){
				if(self.conArry[ab].attr("data-id") === self.url){
					isInCont = self.conArry[ab];
				}
			};		
			
				
			self.pgAll.stop();
			
			
			setTimeout(function(){
				if(self.scrollPos === undefined){
					self.scrollPos = scrollPos = self.$html.scrollTop() > 0 ?  self.$html.scrollTop() :  self.$window.scrollTop();
					self.scrollObj.stop(false).animate({ scrollTop: self.scrollPos-1});
				}
				
				if(isInCont !== undefined){
					isInCont.find('[data-animated-in]').each(function(){
						if(lowResDesktop){ 
							self.animateObject($(this), 1000000);
						}else{
							self.animateObject($(this), self.scrollPos);
						}
					});
				}
			},200);		
						

			if(self.superSlider && !supersizedOnBody && self.onePage){				
				if("!home" !== self.url){
					setTimeout(function(){  
						if(!$.supersized.vars.is_paused && $.supersized.vars.options.autoplay === 1){ api.playToggle();} 
						$("#supersized li").css({"visibility":"hidden", "display":"none"});
						$("#supersized li.activeslide").css({"visibility":"visible", "display":"block"});
						api.sliderAnimateEngine();
					},200);
				}else{				
					setTimeout(function(){ 
						if($.supersized.vars.is_paused && $.supersized.vars.options.autoplay === 1){ api.playToggle(); } 
						$("#supersized li").css({"visibility":"visible", "display":"block"});
					},200);
				}				
			}
			
			if(self.rsSlider){				
				if("!home" !== self.url){
					setTimeout(function(){  apiRS.revresume(); },200);					
				}else{				
					setTimeout(function(){ apiRS.revpause(); },200);					
				}				
			}
			
			if(self.alignPgHor && !isTouch){
				try{  self.curP.scrollTop(0); } catch (e) { }
			}
				  
			var posT = 0;

			var scrollPos = self.pgAll.scrollTop();			
			var sped2 = scrollPos < (posT+self.headHig)-10 && scrollPos > 0	? 0 : self.aniSpeed;	

			if(self.alignPgHor){
				self.load_plugin_Items(self.curP);
			}
			
			
			if(self.alignPgHor){				
				self.pgAll.stop();
				self.moveItem.stop();
				
				if(isInCont !== undefined){
					if(self.scrollHorizontal){	
						self.pageCurPos = -Math.round(isInCont.position().left);
					}else{
						self.pageCurPos = -Math.round(isInCont.position().top);
					}
				}				
				
				if(!lowResDesktop){									
					
					if(!self.rez && self.horiAnim){	
						self.pgAll.stop().scrollTop(posT);
												
						if(isInCont !== undefined){
							
							if(self.pageCurPos <= 0){
								
								if(self.scrollHorizontal){								
									var sped = self.moveItem.position().left >= self.pageCurPos-5 && self.moveItem.position().left <= self.pageCurPos+5	? 0 : 1000;	
									
								}else{
									var sped = self.moveItem.position().top >= self.pageCurPos-5 && self.moveItem.position().top <= self.pageCurPos+5	? 0 : 1000;
								}
								
								self.animateEngine(self.moveItem, self.pageCurPos, false, false );
								setTimeout( function(){	
									self.pageUpdate();
								},100);
							}
						}			
					}else{
						self.pgAll.stop().scrollTop(posT);						
						if(isInCont !== undefined){
							if(self.pageCurPos <= 0){
								
							   if(self.scrollHorizontal){ 
									var sped = self.moveItem.position().left >= self.pageCurPos-5 && self.moveItem.position().left <= self.pageCurPos+5	? 0 : 1000	;	
									if(Modernizr.csstransforms){					
										self.moveItem.stop().css({"x":self.pageCurPos+"px"});
									}else{
										self.moveItem.stop().css({"left":self.pageCurPos+"px"});
									}
								}else{
									var sped = self.moveItem.position().top >= self.pageCurPos-5 && self.moveItem.position().top <= self.pageCurPos+5	? 0 : 1000	;			
									self.moveItem.stop().css({"top":self.pageCurPos+"px"});	
								}						  
								self.pageUpdate();
							}
						}
					}	
								
				}else{	
							
					self.pgAll.scrollTop(posT);
					
					if(isInCont !== undefined){							
						if(self.pageCurPos <= 0){						
							if(!self.rez && self.horiAnim && (ipadDevice || !isTouch) && self.url !== self.curPgChk){										
								for(var ik=0; ik < self.navArry.length; ik++){						
									if(self.navArry[ik].attr("data-id") === self.url){
										self.curP = self.navArry[ik];
										self.ir = ik > self.dirFind ? 1 : -1;	
										self.dirFind = ik;			
									}
								}	
								if(self.scrollHorizontal){	
									
									
									if(Modernizr.csstransforms){
										self.moveItem.css({"x":self.pageCurPos+ (self.stageWidth * self.ir) +"px"});
									}else{
										self.moveItem.css({"left":self.pageCurPos+ (self.stageWidth * self.ir) +"px"});
									}
									
									self.animateEngine(self.moveItem, self.pageCurPos, false, false );
									setTimeout( function(){					
										
										self.pageUpdate();
									},100);
								}else{
									self.moveItem.css({"top":self.pageCurPos+ (self.stageWidth * self.ir) +"px"});	
									self.moveItem.stop()[animateSyntax]({"top":self.pageCurPos+"px"}, 700 ,"easeInOutQuart", function(){
										self.pageUpdate();	
									});

								}
							}else{
								if(self.scrollHorizontal){	
									if(Modernizr.csstransforms){
										self.moveItem.stop().css({"x":self.pageCurPos+"px"});
									}else{
										self.moveItem.stop().css({"left":self.pageCurPos+"px"});
									}
								}else{
									self.moveItem.stop().css({"top":self.pageCurPos+"px"});
								}
								self.pageUpdate();
							}					
						}
					}
					
					if("!home" !== self.url){
						self.headerMc.removeClass("bg_transparent");			
					}else{
						self.headerMc.addClass("bg_transparent");
					}	
				}
			}else{	
				if(self.onePage){			
					self.autoPagePos(isInCont);					
				}
				self.pageUpdate();
			}			
			
			
			if(self.pgNex.data( "url") === "undefined"){
				self.pgNex.addClass("endPage");
			}else{
				self.pgNex.removeClass("endPage");
			}
						
			if(self.pgPre.data( "url") === "undefined"){
				self.pgPre.addClass("endPage");
			}else{
				self.pgPre.removeClass("endPage");
			}
						
			self.pgNex.removeClass("autoPosition");
			self.pgPre.removeClass("autoPosition");		
			
			self.headerMc.removeClass("bg_transparent");
			
			self.curPgChk = self.url;
						
			setTimeout(function(){  self.videoRest(); }, 300);
		
		},
		
		
		// Page auto position
		autoPagePos : function(ele){
			
			
			var self = this;	
			
			self.scrollObj.stop(false);
			
			var posT = 0;
			
			posT  = ele === undefined ? 0 : Math.round((ele.position().top ) - self.headHig);

			self.scrollObj.stop(false).animate({ scrollTop: posT }, self.aniSpeed, "easeInOutQuart",function(){	
				
			});
		},
		
		
		pageUpdate : function(){
			var self = this;
			for(var ik=0; ik < self.navArry.length; ik++){
				if(self.navArry[ik].attr("data-id") === self.url){	
					self.updatePage(self.curP);
				}
			}			
			self.scroll_update();	
		},
		

// Page border setup
		setPageBorder : function(){
				var self = this;
				if($("body").attr("data-removePageBorder") !== "yes"){
					self.borderSize = pageBorder_z = self.stageWidth > 1440 ? 60 : self.minMobile ? 0 : self.midMobile ? 20 : 30;
				}else{
					self.borderSize = pageBorder_z = 0;
				}
			},


// The entire page will reposition, resize and modified by page_setup function
		page_setup : function (){
			
			var self = this;

			self.stageWidth =  window.innerWidth;
			self.stageHeight =  window.innerHeight;

			self.winWidth =  self.stageWidth;
			self.winHeight =   self.stageHeight;
			
			self.ipadPort = (self.stageWidth >= 768 &&  self.stageWidth < 1024);
			self.mobile = self.stageWidth <= 959 && !self.ipadPort;
			self.midMobile = self.stageWidth <= 767 && self.stageWidth > 480;
			self.minMobile = self.stageWidth <= 480;
			isMobileChk = self.stageWidth < 768;		
			self.navTop = true;				
			
		//	$(".tst").text(self.stageWidth);
		//	$(".tst2").text(self.stageHeight);
		
			
			lowResDesktop = self.stageWidth <= 991;
			self.lowMobile = self.stageWidth < 769;
			 
			self.StgHig = iPhoneDevice ? screen.height+60 : self.winHeight;
			
			self.setPageBorder();
			
			if(($("body").hasClass("high_mobile_performance") && window.innerWidth <992)){
				$("body").addClass("horizontal_layout");
			}else{
				if(self.layoutHorizontal){
					$("body").addClass("horizontal_layout");
				}else{
					$("body").removeClass("horizontal_layout");
				}
			}
			
			self.alignPgHor = self.scrollHorizontal = scrollHorizontal = self.onePage ? $("body").hasClass("horizontal_layout") : false;
			self.enableLowPerformance = isTouch || window.innerWidth < 1025;
			self.HideUnuse = self.alignPgHor  ? false : self.enableLowPerformance ? true : false;		
			
			$("body").data("bgType",isMobileChk);
						
			
			$(".verticalAlign").each(function(){
				var vmc = $(this);
				var vpp = (self.winHeight-vmc.outerHeight())/2 > 0 ? (self.winHeight-vmc.outerHeight())/2 : 0;
				vmc.css({"top": vpp });
			});
			
			self.headHig = self.stageWidth > 991 ? (self.stageWidth < 1025 || !self.headMeuTyp1 ? pageHeaderHeight_mini : pageHeaderHeight) : self.alignPgHor ? 0 : pageHeaderHeight_mini;

			
			if(self.headHig > 0){
				$(".mobile_topSpc").removeClass("removeSpc");
			}else{
				$(".mobile_topSpc").addClass("removeSpc");
			}

			$(".header_content").data("open", false);
			$(".header_content").css({"display":"block"});
			
			if(self.scrollHorizontal || isMobileChk){
				self.pgNexPre.addClass("pageNavHorizontal");
			}else{
				self.pgNexPre.removeClass("pageNavHorizontal");
			}
		
			
			self.parallaxBgUpdate();
			
			self.page_dimension();
			
			// Change the default image in img tag, if mobile version(data-src-small) image is assign on the img tag
			self.bdy.find('img').each(function() {
				var thsImg = $(this);
				var mobVer = thsImg.hasClass("lowResSupport") ? (self.stageWidth <= 979 ? true : false) : self.mobile;
				
				if($(this).attr('data-src-small')){		
					if(!mobVer || !$(this).attr('data-src-small')){
						var img_Src = $(this).data('src').split(".");
						var iimg = $(this).attr('data-retina') === "yes" && retinaDevice ? img_Src[0]+"@2x."+ img_Src[1] : $(this).data('src');	
							if(String($(this).attr('src')) !== iimg){
								$(this).attr("src", iimg);
								$(this).data("i_src",$(this).data('src'));
							}			
					}else{
						if($(this).attr('data-src-small')){
							img_Src = $(this).attr('data-src-small').split(".");
							iimg = $(this).attr('data-retina') === "yes" && retinaDevice ? img_Src[0]+"@2x."+ img_Src[1] : $(this).attr('data-src-small');
							if(String($(this).attr('src')) !== String($(this).attr('data-src-small')) && String($(this).attr('src')) !== iimg){
								$(this).attr("src",iimg);
								$(this).data("i_src",$(this).attr('data-src-small'));
							}
						}
					}
				}
			});
			

			$("body").find('.parallax').each(function(){
				var img = !isMobileChk ? $(this).attr("data-src") : ($(this).attr("data-src-small")? $(this).attr("data-src-small")  : $(this).attr("data-src"));	
				var imgAtt = !isTouch ? "scroll" : "scroll";
				var vd = false;
				var thbg = $(this);
				thbg.find('.backGroundVideo').each(function(){
					vd = true;
				});	
				
				if(img !== undefined && !thbg.hasClass("bodyBackground") && img !== thbg.data("imgPath")){			
					if(img !== "none"){
						thbg.css({"background-image":"url("+img+")"});
						thbg.data("imgPath",img );
					}else{
						thbg.css({"background-image":"none"});
						thbg.data("imgPath","none");
					}
				}
			});
			
			
			if(self.rez){
				$(self.contClose.attr("data-content")).css({"top":"0px"});
				self.contClose.children(":first-child").children(":first-child").css({"right" : "-40px"});
			}

			$("body").find('.addVideo.backGroundVideo').each(function(){
				var vid2 = $(this);
				var img = !self.mobile ? vid2.attr("data-src") : (vid2.attr("data-src-small")? vid2.attr("data-src-small")  : vid2.attr("data-src"));	
				if(img !== "none" || img !== undefined){
					vid2.css({"background-image":"url("+img+")"});
				}else{
					vid2.css({"background-image":"none"});
				}
				
			});	

			var tppp = 0;
			
			
			$("body").find(".video_content.backGroundVideo").each(function(){
				$(this).css({"min-height": self.StgHig, "min-width": "100%"});
			});
			
			$("body").find(".carousel_preview.fullScreenGallery_items, .carousel_preview.fullScreenGallery_items .carousel_item").each(function(){
				if(self.alignPgHor){
					$(this).css({"height": self.StgHig, "width":"100%"});
				}else{
					$(this).css({"height": self.StgHig-(self.headHig), "width":"100%"});
				}
			});
			
			var dimSiz =  self.stageWidth > self.stageHeight || self.mobile ? self.winHeight : self.winWidth;
			dimSiz = !self.mobile ? self.stageWidth > 700 ? 700 : 400 : 400;


			self.ContPgTopSpace = self.stageHeight > 360 ? 360 : 150;
			$(".contactPage .contactPage_content").css({ "min-height": self.stageHeight - self.ContPgTopSpace, "margin-top": self.ContPgTopSpace } );
			
	
			$("body").find('.masonry_items').each(function(){
				$(this).data("masonryElement").isotope('layout');	
			});
			
			
			if(self.alignPgHor){
				self.page_position();
			}		
			
			
			$('body').find('img.resize_align').each(function(){
				self.resizeImg($(this));
			});		
			
			if(BigVid !== undefined){
				$("#big-video-wrap").css({"height": $("#big-video-wrap").parent().parent().height()})
			}
			
			self.curPageShow.css({"height":"auto"});			
			
		},
		
		
		beforePageLoad : function(ele){
			var self = this;			
			
			var isInCont = undefined;
			for(var ab=0; ab < self.conArry.length; ab++){
				if(self.conArry[ab].attr("data-id") === self.url){
					isInCont = self.conArry[ab];
					try{ 
						self.conArry[ab].find('.flexslider').each(function(){
							var fc = $(this);
							if(fc.data("loadInPop") === undefined && fc.data("slid") !== undefined && fc.data("autPly") ){												
								fc.data("slid").resume();
							}
						});
					} catch (e) { }					
				}else{					
					try{ 
						self.conArry[ab].find('.flexslider').each(function(){
							if($(this).data("slid") !== undefined){
								$(this).data("slid").pause();
							}
						}); 
					} catch (e) { }
				}
				
			};					
					
			if(!ele.hasClass("portfolioPage")){
				ele.find('.flexSlideshow').each(function(){
					try{
							if(!$(this).data("loaded")){
								$(this).data("loaded", true);
								var aniTyp = $(this).hasClass('slideAnimation') ? "slide" : "fade";
								var tim_ = $(this).attr('data-slidetime') ?  Math.abs($(this).attr('data-slidetime')) : 5000;
								
								$(this).find("a.lazyload").each(function(){
									self.lazyLoadInt($(this));
								});								
								if(aniTyp === "slide"){
									$(this).find("li").each(function(i){
										$(this).find(".loading_x").remove();
										$(this).find("img").show();
									});
								}
								var laz = $(this).hasClass('flexslider');
								if(!laz){  $(this).addClass("flexslider"); }				
								var ffx = $(this);
								ffx.removeClass('flexSlideshow');
								ffx.append('<div class="slider_loading" ></div>');
								var flexs = $(this);
								
								flexs.flexslider({
								slideshow: true,
								animation: aniTyp,
								slideshowSpeed: tim_,
								start: function(slider){
									flexs.data("slid",slider);
									flexs.find(".slider_loading").remove();
									slider.pause();
									}
								});	
							}
					} catch (e) { }				
				});	
			}
			
			  
			ele.find('#map_canvas').each(function(){
				if($(this).data("addMap") !== "yes" && !$(this).hasClass("autoLoadOff")){
					$(this).data("addMap", "yes");
					try{
						map_initialize(); 

					} catch (e) {
						$("#map_canvas").html($(this).data("con"));			
					}					
				}
				if($(this).data("addMap") == "yes"){
					mapResizer();
				}
			});									
		},
		
		
		parallaxBgUpdate : function(e){	
			
			var self = this;
			$("body").find('.parallax').each(function(){
				var img = !isMobileChk ? $(this).attr("data-src") : ($(this).attr("data-src-small")? $(this).attr("data-src-small")  : $(this).attr("data-src"));	
				var imgAtt = !isTouch ? "scroll" : "scroll";
				var vd = false;
				var thbg = $(this);
				thbg.find('.backGroundVideo').each(function(){
					vd = true;
				});	
				
				if(img !== undefined && !thbg.hasClass("bodyBackground") && img !== thbg.data("imgPath")){			
					if(img !== "none"){
						thbg.css({"background-image":"url("+img+")"});
						thbg.data("imgPath",img );
					}else{
						thbg.css({"background-image":"none"});
						thbg.data("imgPath","none");
					}
				}
			});			
		},
		
		
		
// The page_load function is used to position the page as per current menu

		page_load : function (e){
			var self = this;
			self.pageOpenTra.addClass("open");
			var setTimVal = self.firtPgLodAni ? 360 : 0;
			
			if(self.firtPgLodAni){
				if(self.stageWidth > 991){
					self.pageOpenTra.css("height", self.StgHig);
				}else{
					self.pageOpenTra.css("height", self.stageHeight);					
				}
			}else{
				$(".pageFade .loading_2x").addClass("out");
			}
			
			
			setTimeout( function(){
				if(self.bdy.hasClass("menuAutoClose")){
					self.bdy.removeClass("menuOpenIt");
					self.bdy.addClass("menuCloseIt");
					self.bdy.removeClass("autoHideMenuEnable");
					self.bdy.addClass("autoHideMenuDisable");
					}
			}, setTimVal);
				
			setTimeout( function(){ 
				self.page_open(e); 
				setTimeout( function(){ self.pageOpenTra.css("height", 0);  }, setTimVal);
				}, setTimVal*2);			
				
			setTimeout(function(){ $(window).trigger("scroll"); }, 1500);
			
			self.firtPgLodAni = true;
					
			},
		
		page_open : function (e){
				
			var self = this;
			
			self.url = e  ? e : self.homePg;
			self.cM = $('a[href$="#'+self.url+'"]').parent();
			self.cM_= !self.onePage ? $('.contentWrapper') : $('a[href$="#'+self.url+'"]');
			self.pgViewed = false;
			
			var jjj = false; 
			
			self.pgNexPre.removeClass("hideBtn");			
			for(var ik=0; ik < self.navArry.length; ik++){				
				if(self.navArry[ik].attr("data-id") === self.url){					
					if(self.navArry[ik].hasClass("removeNexPrevBtn")){
						self.pgNexPre.addClass("hideBtn");
					}						
					if(self.navArry[ik-1]){
						self.pgPre.data( "url" , self.navArry[ik-1].attr("data-id") );
					}else{
						self.pgPre.data( "url", "undefined"); 
					}
					if(self.navArry[ik+1]){						
						self.pgNex.data( "url" , self.navArry[ik+1].attr("data-id") );
					}else{
						self.pgNex.data( "url", "undefined"); 
					}
					break;
				}				
			}	
			
			
			var isInCont = undefined;	
			var beforePg = -1;	
				
			for(var ab=0; ab < self.conArry.length; ab++){				
				  if(self.conArry[ab].attr("data-id") === self.url){
					  beforePg = ab;
					  isInCont = self.curPageShow =self.conArry[ab];
				  }
			};
			
			
			if(isInCont === undefined){
				isInCont = $(".mainContent .contentWrapper:first-child");
				self.url = $(".mainContent .contentWrapper:first-child").attr("data-id");
			}

			
			if(self.HideUnuse){
				for(var bb=0; bb < self.conArry.length; bb++){
					if(beforePg+1 !== bb && beforePg-1 !== bb && beforePg !== bb || (beforePg+1 === self.conArry.length+1)){
						if(self.conArry[bb].css("visibility") !== "hidden"){
							self.conArry[bb].css({"visibility":"hidden"});
						}
					}else{
						 if(self.conArry[bb].css("visibility") !== "visible"){
							self.conArry[bb].css({"visibility":"visible"});
						}
					}
				}	
			}
						
				
			$("body").find('.addVideo').each(function(){	
				$(this).data("isPlaying", false);
			});		
							
				
			if($("body").find('.mfp-wrap').length > 0){
				try{ $.magnificPopup.close(); } catch (e) { }
			} 
					
			try{ 
				if(BigVid !== undefined){
					BigVid.getPlayer().pause();
				}
			} catch (e) { }
			
			
			$("#big-video-vid").css({"display":"none"});
			
			try{ 
				if(isInCont !== undefined && isTouch){
					setTimeout(function(){
						isInCont.find('.masonry_items').each(function(){	
							$(this).data("masonryElement").isotope('layout');		
						});
					},20);	
				}
			}catch(e){}
			
			try{ 
				if(isInCont !== undefined ){
					
					if(isTouch){
						setTimeout(function(){
							isInCont.find('.masonry_items').each(function(){	
								$(this).data("masonryElement").isotope('layout');		
							});
						},20);		
					}
					
					$("#big-video-wrap").css({"display":"none"});
					if(BigVid !== undefined){
						BigVid.getPlayer().pause();			
					}
					
					isInCont.find('.big_video').each(function(){
						var vmc = $(this);						
						if(vmc.attr("data-background-video") !== undefined){							
							var videoVolume = isNaN(vmc.attr("data-video-volume")) ? defaultVolume : Number(vmc.attr("data-video-volume"));
							if(bgVideopath !== vmc.attr("data-background-video"))	{
								vmc.append($("#big-video-wrap"));
								$("#big-video-vid").css({"display":"block"});
								bgVideopath = vmc.attr("data-background-video");
								if(BigVid !== undefined){
									var vpp = bgVideopath.split(",");
									if(vpp < 2){
										BigVid.show(vpp[0] );
									}else{
										BigVid.show(vpp[0], {altSource:vpp[1]}  );
									}
								}							
							}else{	
								if(BigVid !== undefined){
									$("#big-video-vid").css({"display":"block"});
									$(".vidPlyPauBtn").data("view", true);	
									$(".vidPlyPauBtn").find("i").addClass("fa fa-eye-slash");				
									BigVid.getPlayer().play();
								}
							}						
							try{ 
								if(BigVid !== undefined){ 
									BigVid.getPlayer().volume(videoVolume); 
								} 
							} catch (e) { }
						}
					});	
				}
			} catch (e) { }
			
			$("body").find('.flexslider').each(function(){
				  if($(this).data("slid") !== undefined){				 
					  $(this).data("slid").pause();
				  }
			});
			
			
								
			if(isInCont !== undefined ){			
							
				if(isInCont.hasClass("bodyBackground")){
					var img = !isMobileChk ? isInCont.attr("data-src") : (isInCont.attr("data-src-small")? isInCont.attr("data-src-small")  : isInCont.attr("data-src"));	
					var imgAtt = !isTouch ? "fixed" : "scroll";
					var vd = isInCont.hasClass('.backGroundVideo');
					
					if(img !== undefined){
					  if(img !== "none"){
						  $("body").addClass("addBackground").css({"background-image":"url("+img+")"});	
					  }else{
						  $("body").removeClass("addBackground").css({"background-image":"none"});
					  }
					}
				};								
			}
					
	
			self.beforePageLoad(isInCont);					

			
			self.page_setup();				
			
			$("body").find('.portfolioPage').each(function(){
				try {
					$(this).detailPage("closeBackCon");
				} catch (e) {}
			});
					
			
		
			if(self.curPg === ""){
				self.curPg = self.prePg = self.url;	
				if(self.pgSub === undefined && self.onePage){
					window.location.href = "#"+self.url;	
				}
				self.cM = $('a[href$="#'+self.curPg+'"]').parent();
				
				if(!self.onePage){
					self.updatePage(isInCont);
				}
			
				return;
			}
			
			  
			// Check the previous and current page
			
			if(self.prePg === self.curPg){
				
				try { self.fflod.remove(); } catch (e) { }
												
				// Initialize to load the opening page as per history
				if(self.curPg === "" ){						
					self.curPg = self.prePg = self.url;	
					if(self.pgSub === undefined && self.onePage){
						window.location.href = "#"+self.url;	
					}
					self.cM = $('a[href$="#'+self.curPg+'"]').parent();
					if(self.alignPgHor){
						self.pgAll.stop()[animateSyntax]({ scrollTop: "0px" }, 0, "easeInOutQuart");
					}
				}else{	
					// Initialize to load current page, background and animate to left side			
					self.curPg = self.url;
					var pagScrl_Speed = window.pageYOffset !== 0 ? self.aniSpeed : 50;
					var con_Speed = 0;
					if(self.prePg !== self.url){
						if(self.alignPgHor){
							self.pgAll.stop()[animateSyntax]({ scrollTop: "0px" }, pagScrl_Speed, "easeInOutQuart" ,function(){ });
						}
					}else{
						
						if(isInCont !== undefined){
							self.page_position();
						}						
						if(self.alignPgHor){
							self.pgAll.stop()[animateSyntax]({ scrollTop: "0px" }, 200, "easeInOutQuart" );
						}
					}
				}
			}
			
			
			if(!self.alignPgHor){						
				self.page_position();				
			}			
			
		},	
		

		
		
		// Lazy load function
		lazyLoadInt : function(obj){
			var self = this;
			
			var imSrc = !self.mobileDevice ? obj.attr("href") : (obj.attr("data-src-small")? obj.attr("data-src-small")  :obj.attr("href"));
			var lodr = obj.parent().hasClass('large_image');
			lodr = !lodr ? obj.parent().hasClass('medium_image') : lodr;
			lodr = !lodr ? obj.parent().hasClass('fixedHeight') : lodr;
			lodr = !lodr ? obj.hasClass('lazyload_single') : lodr;
			lodr = !lodr ? obj.hasClass('lazyload_fluid') : lodr;			
			lodr = !lodr ? obj.hasClass('lazyload_gallery') : lodr;

			if(obj.parent().hasClass('imgBorder')){
				lodr = !lodr ? obj.parent().parent().hasClass('fixedHeight') : lodr;
			}			
			var cc = obj.attr('class');
			var st = obj.attr('style');
			var $img;
			if(st){
				$img = $('<img class="'+cc+' style="'+st+'" />');
			}else{
				$img = $('<img class="'+cc+'" />');
			}

			$img.removeClass('lazyload_single');
			$img.removeClass('lazyload_fluid');			
			$img.removeClass('lazyload_gallery');
			$img.removeClass('lazyload');
			obj.replaceWith($img);
			$img.hide();
			
			$(".loading_objects .loading_x").clone().appendTo($img.parent());
			
			if(lodr){
				$img.attr('src', imSrc).load(function() {
					$(this).parent().find(".loading_x").remove();
					if($(this).hasClass("resize_align")){	
						self.resizeImg($(this));						
					};

					if(!$(this).hasClass("noSelfAnimate")){
						$(this).show().addClass(aniInEff);
					}else{
						$(this).show();
					}
										
				}).error(function () { 
					$(this).parent().find(".loading_x").remove();
				}).each(function() {
                  if(this.complete) { $(this).trigger('load'); }
				});
            }else{
				
				$img.attr('src', imSrc).load(function() {
					$(this).parent().find(".loading_x").remove();
					
					if($(this).hasClass("resize_align")){
						self.resizeImg($(this));						
					};	
					$(this).fadeIn(300);
					
					var pim = $img.parent().parent().hasClass('projImgs');
					pim = pim ? pim : $img.parent().parent().parent().parent().hasClass('projImgs');
					if(pim){
						self.resizeImg($(this));
					}else{						

						var posY = $(this).hasClass("scale_fill");
						posY = !posY ? $(this).hasClass("scale_fit") : posY;
						posY = !posY ? $(this).hasClass("scale_cover") : posY;						
						if(posY){							
							if($(this).width() > $(this).parent().width()+5	){
								$(this).css({"left":-($(this).width()-$(this).parent().width())/2});
							}
							$(this).css({"top":-($(this).height()-$(this).parent().height())/2});
						}							
					}
					
				}).error(function () {
					$(this).parent().find(".loading_x").remove();
				}).each(function() {
                  if(this.complete) { $(this).trigger('load'); }
				});	
			}
			
			return $img;
			
		},
		
		
// Initialize the History 
		history : function(){
			var self = this;

			(function($){
				"use strict";
				var origContent = "";			
				function loadContent(hash2) {
					window.location.href.substr(0, window.location.href.indexOf('#'));
					var splt = hash2.split("?");
					var hash = !self.onePage ? self.homePg : splt[0];
					self.pgSub = splt[1];

					if(hash !== "") {
						if(origContent === ""  && self.curPg === "") {
							origContent = $('.contentWrapper [data-id="'+"#"+self.homePg+'"]');
						}
						if(self.hisPath !== hash ){
							self.hisPath = hash;
							self.page_load(hash);
						}else{
							
							if(self.pgSub !== undefined && self.projFm){
								var p2 = self.pgSub.split("=");
								
							}
						}
					} else {

						if(origContent !== "" && self.curPg === "") {
							if(self.hisPath !== hash ){
								self.hisPath = hash;
								self.page_load(self.homePg);
							}
						}else{
							if(!self.onePage){
								if(self.pgSub !== undefined && self.projFm){
									p2 = self.pgSub.split("=");
									
									
								}
							}
						}
					}
					
					if(hash === "" && self.curPg === ""){
						self.page_load(self.homePg);
					}
				}

				$(document).ready(function() {
					$.history.init(loadContent);
					$('#navigation a').not('.external-link').on('click', function() {
						var url = $(this).attr('href');
						url = url.replace(/^.*#/, '');
						$.history.load(url);
						return false;
					});
				});
				
			})(jQuery);
			
		},
		

		// Animating the required object
		
		animateObject : function (mc, scrlPos){
			var self = this;
			
			if(self.disableAnimation){
				return;
			}
						
			var mcPos = Math.round(mc.position().top);	
			
						
			if(mc.data("isSliderObj") || (mc.data("isDisplay")) ){
				return;
			}
		
			var par = 0;
			if(mc.attr("data-anchor-to") !== undefined){
				var mc2 = mc;
				for(var io=0; io<mc.attr("data-anchor-to").split(".").length; io++){
					mc2 = mc2.parent();
				}				
				par = mc2.position().top;
			}
		
			/* The below code is used to find the animation triggering point */
			
			var mcPos = Math.round(mcPos + mc.data("main_holder").position().top+50);						
			if((mcPos+par)-(self.winHeight-(self.winHeight/4-100)) > Math.abs(scrlPos)){
				return;
			}	
			
			mc.data("isDisplay" , true);		
			
			
			if(mc.data("isAniObj")  && !isTouch){				
				self.animate_objectBeforeDisplay(mc);
			}
					
			if(mc.attr("data-animated-innerContent") === "yes"){
				var kk = 0;
				mc.css({"visibility":"visible"});
				mc.children().css({"visibility":"hidden"});
				mc.children().each(function(){										
					var mc2 = $(this);					
					mc2.stop();
					var aniTyp = mc.attr("data-animated-in") !== undefined ? mc.attr("data-animated-in") : "animated fadeIn";
					mc.data("in", aniTyp)
					kk = !isNaN(mc.attr("data-animated-time")) && mc.attr("data-animated-time") > kk ? Number(mc.attr("data-animated-time")) : kk+3;					
					var aniTim = self.aniDelay*kk;
					aniTim = cssAnimate ? aniTim : aniTim-50;				
					mc2.removeClass(aniTyp);
					
					setTimeout(function(){											
						if(cssAnimate){						
							mc2.css({"visibility":"visible"}).removeClass(aniTyp).addClass(aniTyp).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
								$(this).removeClass(mc.data("in"));								
								if(mc.data("isAniObj") && !isTouch){
									self.animate_objectAfterDisplay($(this));
								}				
							});
						}else{
							
							var posTyp = mc2.css("position");
							if(posTyp === "static"){ mc2.css({"position":"relative"}); }	
							var tp = !isNaN(parseInt(mc2.css("top"))) ? parseInt(mc2.css("top")) : mc2.css("position") == "absolute" ? "auto" : 0;
							var tp2 = tp !== "auto" ? tp2+15 : "auto";
													
							mc2.css({"visibility":"visible", "opacity":0, "top":tp2}).removeClass(aniTyp).animate({"opacity":1, "top":tp},350, "easeInOutQuad",function(){
								mc2.css({"position":posTyp});								
								$(this).removeClass(mc.data("in"));							
								if(mc.data("isAniObj") && !isTouch){
									self.animate_objectAfterDisplay($(this));
								}				
							});
						}
					}, aniTim );
				});
				
			}else{
				
				mc.stop();					
				var aniTyp = mc.attr("data-animated-in") !== undefined ? mc.attr("data-animated-in") : "animated fadeIn";
				mc.data("in", aniTyp);
				var kk = !isNaN(mc.attr("data-animated-time")) && mc.attr("data-animated-time") > kk ? Number(mc.attr("data-animated-time")) : kk+3;
				var aniTim = !isNaN(mc.attr("data-animated-time")) ? self.aniDelay*mc.attr("data-animated-time") : self.aniDelay*(kk);
				aniTim = cssAnimate ? aniTim : aniTim-50;	
				mc.removeClass(aniTyp);					
				setTimeout(function(){	
									
					if(cssAnimate){						
						mc.css({"visibility":"visible"}).removeClass(aniTyp).addClass(aniTyp).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
							$(this).removeClass($(this).data("in"));
							if(mc.data("isAniObj") && !isTouch){
								self.animate_objectAfterDisplay($(this));
							}					
						});
					}else{
						var posTyp = mc.css("position");
						if(posTyp === "static"){ mc.css({"position":"relative"}); }
						
						var tp = !isNaN(parseInt(mc.css("top"))) ? parseInt(mc.css("top")) : mc.css("position") == "absolute" ? "auto" : 0;
						var tp2 = tp !== "auto" ? tp+15 : "auto";
						
						
						
						mc.css({"visibility":"visible", "opacity":0, "top":tp2}).removeClass(aniTyp).animate({"opacity":1, "top":tp}, 350, "easeInOutQuad",function(){
							mc.css({"position":posTyp});	
							$(this).removeClass(mc.data("in"));							
							if(mc.data("isAniObj") && !isTouch){
								self.animate_objectAfterDisplay($(this));
							}				
						});
					}
				}, aniTim );
			}
			
		},
		
		animate_objectBeforeDisplay : function(obj){
			var self = this;
			obj.find('.graph_container li').each(function() {
				$(this).each(function() {
					$(this).children(':first-child').css("width","100%");
					 $(this).find(".display").text(0);
				});
			});	
			
			if(self.knobAni){
				try{					
					obj.find('.animate_counter').each(function(){
						 var selK = $(this);
						 if(selK.hasClass("knob")){
						 	selK.val(0).trigger("change");
						 }
						 selK.data("display").text(0);
					});	
				} catch (e) { }	
			 }			
		},
		
		
			
		animate_objectAfterDisplay : function(obj){
			var self = this;
			obj.find('.graph_container').each(function(){
					self.graph_display($(this));
				});
				
			if(self.knobAni){						
				try{					
					obj.find('.animate_counter').each(function(i){			
						var selK = $(this);
							selK.data("ani").css({"top":0})
							$(selK.data("ani")).animate({
								'top': selK.data("val")
							  },
							  {
								step: function(now, fx) {	
									if(selK.hasClass("knob")){
								  		selK.val(now).trigger("change");
									}
								  	if( selK.data("display")){
									 	selK.data("display").text(Math.round(now));
								  	}
								},
								duration: 2500, 
								easing: "easeInOutQuad"							 
							  });	
					});
				} catch (e) { }	
			}
			
		},
		

// Initialize video cover image
		intVideoObject : function(obj){
			var self = this;
			obj.find('.addVideo').each(function(){		
				var addCover = false;			
										
				$(this).find('.video_hover').each(function(){
					addCover = true;
					var vv =  $(this);
					var vid = $(this).parent();
					vid.data("added", true);
					var eventMc = ('ontouchstart' in document.documentElement) ? 'touchstart' : 'click';
					vv.on(eventMc, function(event) {	
						$("body").find('.addVideo').each(function(){
							$(this).data("isPlaying", false);
							if($(this).parent().hasClass("tabVideo")){ return; }							
							if(!$(this).data("added")){
								vid.children(':first-child').removeClass("enablHardwareAcc");
							}
							$(this).find('.vid').remove();
							if(!$(this).hasClass("backGroundVideo")){
								$(this).find('img').fadeIn();
								$(this).find('.video_hover').fadeIn();
								$(this).find('.video_hover').css({"z-index":"55"});
							}
						});
			
						vid.prepend('<div class="vid" ></div>');
						vid.data("added", true);						
						vid.data("isPlaying", true);
						var autply = vid.attr("data-autoPlay") === "true" ? true : false;
						vid.data("autoplay", autply);
						vid.data("url_", self.curP.attr("data-id"));
						vid.find('.video_hover').css({"z-index":"-1"});
						vid.find('img').fadeOut(100,function(){
							var vid_ = $(this).parent();					
							vid_.children(':first-child').embedPlayer(vid_.attr('data-url'), vid_.width()+"px", vid_.height()+"px", true, vid_.children(':first-child'), false);		 
							}
						);			
					});
				});	
				
				
			});
			
		},
		
		
		


// Video Reset function
		videoRest : function(){
			var self = this;
			
			$("#fancybox-wrap").find('.addVideo').each(function(){	
				self.video_delete($(this));
			});
			
			try{
				$("body").find('.addVideo').each(function(){	
					if(!$(this).hasClass("backGroundVideo")  && !$(this).data("isPlaying") || ($(this).data("url_") !== self.curP.attr("data-id")) ){
						self.video_delete($(this));
					}
					
					if($(this).data("isPlaying") ){
						var vid = $(this);						
						var www = Math.round(vid.width());
						var hhh = Math.round(vid.height());
						
						vid.find("iframe").css({"width": www+"px", "height": hhh+"px"});						
						if(isTouch){ vid.find("iframe").css({"top":self.headHig }); }
					}
				});
			} catch (e) { }
 			
			try{
					
				self.curP.find('.addVideo.backGroundVideo').each(function(){ 
					var vid = $(this);
					var www = Math.round(vid.width());
					var hhh = Math.round(vid.height());					
					var vidW = !self.lowMobile ? www * 1.7 : www;
					var vidH = !self.lowMobile ? hhh * 1.7 : hhh;
					var ww = vidW;	
					var hh = vidH; 
					
					var rati = self.stageWidth/self.stageHeight;					
					var vZwid = rati < 1.77 && !self.lowMobile ? (1.78*self.stageHeight) : 0;
					vid.css({"width":vZwid});
				
					if(!vid.data("added")){	
						self.video_delete(vid);
						vid.data("url_", self.curP.attr("data-id"));
						vid.prepend('<div class="vid" ></div>');
						var dd = vid.children(':first-child');
						dd.css({ "top": -Math.round((hh-hhh)/2)});
						vid.children(':first-child').addClass("enablHardwareAcc");
						vid.find('.video_hover').css({"z-index":"55"});							
						vid.find('img').show(); 											
						vid.children(':first-child').embedPlayer(vid.attr('data-url'), vidW+"px", vidH+"px", true, vid.children(':first-child'), true);
						
					}
					vid.data("added", true);					
					if(vZwid > 0){
						vid.children(':first-child').css({ "left": -Math.round((vZwid-self.stageWidth)/2)});
					}
					
					vid.find("iframe").css({"width": ww+"px", "height": hh+"px" });
				});		

			  } catch (e) { }
		},
		
		video_delete : function(mc){
			mc.data("added", false);
			mc.find('.vid').each(function(){
				$(this).removeClass("enablHardwareAcc");
				try{ 				
					if($(this).length>0){
						jQuery("#"+$(this).children(':first-child').attr("id")).tubeplayer('destroy');
					}
				} catch (e) { }
				$(this).remove();
			});
			mc.find('img').show();
			mc.find('.video_hover').show();
			mc.find('.video_hover').css({"z-index":"55"});
		},
		


// Scrollbar update function
		scroll_update : function(rPos){		
			var self = this;
			var rePos = typeof rPos !== undefined ? rPos : 0;			
			var scrollAdded = self.curP.data("scrollAdded");
			
			try { 
				if(!isTouch && !self.IEbrowser && self.supportScrollBar){ 
					self.nicScrl.resize(); 
				} 
			}catch(e){	}
			
			if(self.stageWidth > 991){	 		
				if(self.alignPgHor){	
					if(self.stageWidth <= 991){
						self.curP.css({"height":"auto"});
					}
					self.curP.scrollTop(0);
				}else{						
					if(rPos !==  undefined){
						self.scrollObj.stop(false).animate({ scrollTop: rePos+"px" }, 500, "easeInOutQuart");
					}
				}
			}else{					
				if(!isTouch && !self.IEbrowser && self.supportScrollBar){ 				
					if(rPos !==  undefined){
						self.scrollObj.stop(false).animate({ scrollTop: rePos+"px" }, 500, "easeInOutQuart");
					}
				}			
			}		
		
		},
	

		
		
// Graph display function
		graph_display : function (e){
			e.find('li').each(function() {
				var selK = $(this).find(".display");
				selK.text("0%");
				$(this).each(function() {
					$(this).children(':first-child').css("width","100%");
					$(this).children(':first-child').stop();	
					var vall = parseInt($(this).attr('data-level')) >= 100 ? "0%" : (100 - parseInt($(this).attr('data-level')))+"%";						  
					$(this).children(':first-child').animate( { width: vall },
							  {
								step: function(now, fx) {						
								  	selK.text(Math.round(now > 100 ? "0" : (100 - parseInt(now)) ));
								},
								duration: 1500, 
								easing: "easeInOutQuad"							 
					});	
				});
			});
		},
		
		
// Window Resize function
		windowRez : function (){			
			var self = this;
			if(Number(self.bdy.data("width")) !== Number(window.innerWidth) || Number(self.bdy.data("height")) !== Number(window.innerHeight)){
				self.bdy.data("width", Number(window.innerWidth));
				self.bdy.data("height", Number(window.innerHeight));
				self.rez = true;
				self.page_setup();
				self.rez = false;
			}
		},
		
		
		previewSetting : function (){
			var self = this;
			// Preview_set
			self.curColor = "color-white";
			self.curTempColor = "";
			
			var colr = $("#set_color").attr("href");
			if( colr.split("blue").length > 1){
				self.curTempColor = "-blue";
			}else if( colr.split("red").length > 1){
				self.curTempColor = "-red";
			}
				
			
			self.setting_tool = $(".setting_tools");
			setPreviewBtn();
			
			$(".setting_tools .iButton").on('click', function() {	
				if(self.setting_tool.hasClass("hideTool")){
					self.setting_tool.removeClass("hideTool");
				}else{
					self.setting_tool.addClass("hideTool");
				}
			});
			
			$(".mUp").on('click', function() {
				$(".setting_tools").addClass("mUp");
				});
			
			$(".mDown").on('click', function() {
				$(".setting_tools").removeClass("mUp");
				});				
			
			$(".mType1").on('click', function() {		
				$(".header").addClass("menuInverse");
				setPreviewBtn();
				});	
							
			$(".mType2").on('click', function() {
				$(".header").removeClass("menuInverse");
				setPreviewBtn();
				});
				
			
			$(".borderType1").on('click', function() {
				$("body").attr("data-removePageBorder", "yes");
				self.page_setup();
				setPreviewBtn();
				});	
							
			$(".borderType2").on('click', function() {
				$("body").attr("data-removePageBorder", "no");
				self.page_setup();
				setPreviewBtn();
				});
				
			
			/* --- */
			
			$(".temHigLight1").on('click', function() {
				if(!$(this).hasClass("active")){
					$("#set_color").attr("href", "css/"+self.curColor+""+".css");
					self.curTempColor = "";
					setPreviewBtn();
				}
			});
			
			$(".temHigLight2").on('click', function() {
				if(!$(this).hasClass("active")){
					$("#set_color").attr("href", "css/"+self.curColor+"-blue"+".css");
					self.curTempColor = "-blue";
					setPreviewBtn();
				}
			});
			
			$(".temHigLight3").on('click', function() {
				if(!$(this).hasClass("active")){
					$("#set_color").attr("href", "css/"+self.curColor+"-red"+".css");
					self.curTempColor = "-red";
					setPreviewBtn();
				}
			});
			

			
			function setPreviewBtn(){
				$(".fontStyle1, .fontStyle2, .mType1, .mType2, .colWhite, .colNight, .colBlack").removeClass("active");
				$(".temHigLight1, .temHigLight2, .temHigLight3, .borderType1, .borderType2").removeClass("active");
				
				var cUrl = $("#set_color").attr("href");
				
				if( cUrl.split("white").length > 1){
					$(".colWhite").addClass("active");
					self.curColor = "color-white";
				}else if( cUrl.split("night").length > 1){
					$(".colNight").addClass("active");
					self.curColor = "color-night";
				}else{
					$(".colBlack").addClass("active");
					self.curColor = "color-black";
				}
					
				if( $(".header").hasClass("menuInverse")){
					$(".mType1").addClass("active");
				}else{
					$(".mType2").addClass("active");
				}	

				if($("body").attr("data-removePageBorder") !== "yes"){
					$(".borderType2").addClass("active");
				}else{
					$(".borderType1").addClass("active");
					}
				
				
				if($("#set_font").attr("href") == "css/font-style1.css"){
					$(".fontStyle1").addClass("active");
				}else{
					$(".fontStyle2").addClass("active");
				}	
				
				if( cUrl.split("blue").length > 1){
					$(".temHigLight2").addClass("active");
				}else if( cUrl.split("red").length > 1){
					$(".temHigLight3").addClass("active");
				}else{
					$(".temHigLight1").addClass("active");
				}
				
			}	
		}
	};

		
// Initizlize and create the main plug-in
	$.fn.mainFm = function(params) {
		var $fm = $(this);
		var instance = $fm.data('GBInstance');
		if (!instance) {
			if (typeof params === 'object' || !params){
				return $fm.data('GBInstance',  new mainFm($fm, params));	
			}
		} else {
			if (instance[params]) {					
				return instance[params].apply(instance, Array.prototype.slice.call(arguments, 1));
			}
		}
	};

	
})( jQuery );
