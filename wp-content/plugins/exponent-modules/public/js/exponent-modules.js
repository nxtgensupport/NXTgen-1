;(function( $ ) {
    'use strict';

	var vendorScriptsUrl = exponentModulesConfig.vendorScriptsUrl,
		dependencies = exponentModulesConfig.dependencies || {};

	if( 'undefined' != typeof dependencies ) {
		for( var dependency in dependencies ) {
			if( dependencies.hasOwnProperty( dependency ) ) {
				asyncloader.register( dependencies[ dependency ], dependency );
			}
		}
	}


     jQuery(document).ready( function() {

		var $window = jQuery( window ),
		    body = jQuery('body');
	    var exponentModules = (function() {

	        var  tatsuCallbacks = {},
				 alreadyVisibleIndex = 0,
				 scrollInterval,
				 didScroll = false,


			/**Exp-Team**/
			team = function() {
				
				// asyncloader.require( 'anime', function() {
				// 	$('.exp-team').mouseenter(function () { 
				// 		var functionBasedDelay = anime({
				// 				targets: '.icon-shortcode',
				// 				translateY: [10, -10],
				// 				scale: [0, 1],
				// 				loop: 1,
				// 				delay: function(el, i, l) {
				// 				return i * 100;
				// 				}
				// 			});
				// 	});
				// });
				
			},

			testimonials = function(){

				asyncloader.require( 'slick', function() {
					
					$('.testimonial-outer-slider.slide-here').each( function(){

						var $this = $(this),
						dots = $this.attr('data-dots') == '1' ? true : false,
						autoPlay = $this.attr('data-auto-play') == '1' ? true : false,
						slideShowSpeed = $this.attr('data-slide-show-speed') ? parseInt( $this.attr('data-slide-show-speed') ) : 4000 ;
						//slidesPerRow = $this.attr('data-slide-per-scroll') ? parseInt( $this.attr('data-slide-per-scroll') ) : 1;
					
						$this.on('init', function(slick){
							$this.css( 'visibility', 'visible' );
						});

						$this.slick({
							dots: dots,
							infinite: true,
							autoplay: autoPlay,
							autoplaySpeed: slideShowSpeed,
							adaptiveHeight: true,
							// slidesToShow: slidesPerRow,
							// slidesToScroll: slidesPerRow,
							//arrow: true
						});
						
					});	

				
				});
			},
			svgLineAnimate = function(shouldUpdate,moduleId) {
				asyncloader.require( 'vivus', function() {
					var svgAnimateModules = jQuery( '.svg-line-animate' );
					//SVG animate front-end
					if( svgAnimateModules.length > 0 ) {
						svgAnimateModules.each(function (i, el) {
							var el = jQuery( el );
							var svgObject = el.find( 'svg' )[0],
								pathTimingFunction = el.attr( 'data-path-animation' ),
								animTimingFunction = el.attr( 'data-svg-animation' ),
								duration = el.attr( 'data-animation-duration' ),
								delay = el.attr( 'data-animation-delay' );
							new Vivus(
									svgObject, 
									{
										duration: duration,
										pathTimingFunction	: Vivus[pathTimingFunction],
										animTimingFunction	: Vivus[animTimingFunction],
										delay : delay,
										onReady: function() {
											el.css( 'visibility', 'visible' );
										}
									}, 
									function() {
										console.log('Svg Animated');	
								}); 
						});
					}
					//SVG animate in tatsu
					 var svgAnimatesInTatsu = jQuery('.exp-svg-icon span');
					  if(svgAnimatesInTatsu.length > 0){
					 	svgAnimatesInTatsu.each(function(index,element){
							var element = jQuery(element).parent();
							 if(!moduleId || element.parent().hasClass('be-pb-observer-'+moduleId)){
							 var svgObject1 = element.attr( 'data-target' ),
								 pathTimingFunction = element.attr( 'data-path-animation' ),
								 animTimingFunction = element.attr( 'data-svg-animation' ),
								 duration = element.attr( 'data-animation-duration' ),
								 delay = element.attr( 'data-animation-delay' ),
								 fileUrl = element.attr( 'data-svg-url');
					 			element.children().empty();
					 		 new Vivus(svgObject1, {
									  file:fileUrl,
									  duration: duration,
									  pathTimingFunction	: Vivus[pathTimingFunction],
									  animTimingFunction	: Vivus[animTimingFunction],
									  delay : delay,
									  onReady: function() {
										element.css( 'visibility', 'visible' );
									}
									}, 
					 			function() {
					 				console.log('Svg Animated');	
					 		}); 
							 } 
						});
					}
				
				});
			},


			registerCallbacks = function() {
			// ex: tatsuCallbacks['moduleName'] = callbackFunction;
			tatsuCallbacks[ 'exponent_team' ] = team;
			tatsuCallbacks[ 'exp_svg_icon' ] = svgLineAnimate;
			//tatsuCallbacks[ 'exp_testimonials' ] = testimonials;

			},

			ready = function() {    
				
				//contactForm();
				team();
				testimonials();
				svgLineAnimate();
				registerCallbacks();

			},
			
			run = function() {

				ready();

				jQuery(window).on( 'tatsu_update.exponent', function( e, data )  {
					console.log( 'module changed' );					
					if( data ) {
						if( 'trigger_ready' == data.moduleName ) {
							svgLineAnimate();
							ready();
						} else if( data.moduleName in tatsuCallbacks ) {
							tatsuCallbacks[data.moduleName]( data.shouldUpdate, data.moduleId );											
						}
					}
				});

				jQuery(window).on( 'scroll', function(){
					didScroll = true;
                });
                
			}

			return {
				run: run
			}

	    })();

        exponentModules.run();

     });

})( jQuery );