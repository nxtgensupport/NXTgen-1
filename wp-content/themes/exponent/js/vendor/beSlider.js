(function( global, factory, $ ) {
    if ( typeof define == 'function' && define.amd ) {
        // AMD - RequireJS
        define( 'beSlider', factory );
      } else if ( typeof module == 'object' && module.exports ) {
        // CommonJS - Browserify, Webpack
        module.exports = factory($);
      } else {
        // Browser globals
        global.BeSlider = factory($);
      }
})( window, function( $ ) {
    var $win = $( window ),
        //helpers
        isJson = function( string ) {
            try {
                JSON.parse( string );
            }catch(e) {
                return false;
            }
            return true;
        },
        BeSlider = function( ele ) {
            if( null != ele && !ele.hasClass( 'exp-slider-initialized' ) ) {
                if( $.fn.hasOwnProperty( 'slick' ) ) {
                    if( null != ele && ele instanceof $ ) {
                        this.ele = ele;
                        this.bindMethods();
                        this.setSlickSettings();
                        this.initLazyLoad();
                        this.initFullscreenSlider();
                        this.initVariableSlider();
                        this.initEqualHeightSlider();
                        this.initEvents();
                        this.adjustArrows();
                        this.initSlick();
                    }else {
                        console.error( 'Invalid Arg passed to BeSlider' );
                    }
                }else {
                    console.error( 'Slick is not added. BeSlider depends on slick' );
                }
            }
        };

        BeSlider.prototype.initFullscreenSlider = function() {
            if( '1' === this.ele.attr( 'data-fullscreen' ) ) {
                var fullScreenOffetSelectors = this.ele.attr( 'data-fullscreen-offset' ),
                    fullScreenHeight = $win.height(),
                    slides = this.ele.find( '.exp-image-slide-inner' ),
                    offsetHeight = 0;
                if( 'string' == typeof fullScreenOffetSelectors ) {
                    var selectorsArray = fullScreenOffetSelectors.split( ',' );
                    selectorsArray.forEach( function( curSelector ) {
                        var curEle = $( curSelector );
                        if( 0 < curSelector.length ) {
                            offsetHeight += curEle.height();
                        }
                    } );
                }
                slides.css( 'height', ( fullScreenHeight - offsetHeight ) + 'px' );
            }
        };
        BeSlider.prototype.updateFullscreenSlider = function() {
            var fullScreenOffetSelectors = this.ele.attr( 'data-fullscreen-offset' ),
                fullScreenHeight = $win.height(),
                slides = this.ele.find( '.exp-image-slide-inner' ),
                offsetHeight = 0;
            if( 'string' == typeof fullScreenOffetSelectors ) {
                var selectorsArray = fullScreenOffetSelectors.split( ',' );
                selectorsArray.forEach( function( curSelector ) {
                    var curEle = $( curSelector );
                    if( 0 < curSelector.length ) {
                        offsetHeight += curEle.height();
                    }
                } );
            }
            slides.css( 'height', ( fullScreenHeight - offsetHeight ) + 'px' );
        };
        BeSlider.prototype.adjustArrows = function() {
            if( true === this.settings.arrows && null != this.ele.attr( 'data-outer-arrows' ) ) {
                var curGutter = !isNaN( parseInt( this.ele.attr( 'data-gutter' ) ) ) ? parseInt( this.ele.attr( 'data-gutter' ) ) : 0,
                    margin = (curGutter/2) + 50;
                this.ele.css({
                    'margin'  : '0 -' + margin + 'px',
                    'padding' : '0 50px'
                });
            }
        }
        BeSlider.prototype.bindMethods = function() {
            this.lazyLoad = this.lazyLoad.bind(this);
            this.updateDoppelgangers = this.updateDoppelgangers.bind(this);
            this.updateEqualHeightSliders = this.updateEqualHeightSliders.bind(this);
            this.updateVariableSlider = this.updateVariableSlider.bind(this);
            this.updateGutter = this.updateGutter.bind(this);
            this.updateFullscreenSlider = this.updateFullscreenSlider.bind( this );
        };
        BeSlider.prototype.buildResponsiveSetting = function( options, responsiveDefaults, screen ) {
            var settings = {};
            Object.keys(responsiveDefaults).reduce( function( settings, option ) {
                if( options.hasOwnProperty( option ) ) {
                    var optionFromOptions = options[ option ];
                    if( 'number' == typeof responsiveDefaults[ option ].d ) {
                        optionFromOptions = parseInt(optionFromOptions);
                    }
                    if( 'd' == screen ) {
                        settings[option] = optionFromOptions;
                    }else {
                        if( 'boolean' == typeof optionFromOptions ) {
                            settings[option] = responsiveDefaults[option][screen];
                        }else {
                            settings[option] = parseInt( optionFromOptions ) < parseInt( responsiveDefaults[option][screen] ) ? optionFromOptions : responsiveDefaults[option][screen];
                        }
                    }
                }
                return settings;
            }, settings );
            return settings;
        };
        BeSlider.prototype.addResponsiveOptions = function( options ) {
            options.responsive = [];
            var responsiveDefaults = {
                variableWidth : {
                    d : true,
                    l : true,
                    t : true,
                    m : false
                },
                centerMode : {
                    d : true,
                    l : true,
                    t : true,
                    m : false,
                },
                //centerPad depends on centerMode which will we forcibly disable in mobile and tablet devices
                centerPadding : {
                    d : '200px',
                    l : '100px',
                    t : '50px',
                    m : '10px',
                },
                adaptiveHeight : {
                    d : false,
                    l : false,
                    t : false,
                    m : true === options.variableWidth ? true : false,
                }
            };
            if( '1' !== this.ele.attr( 'data-slides-to-show-prevent-responsive' ) ) {
                responsiveDefaults[ 'slidesToShow' ] = {
                    d : 3,
                    l : '1' === this.ele.attr( 'data-client-carousel' ) ? options.slidesToShow : ( options.centerMode ? 2 : 3 ),
                    t : '1' === this.ele.attr( 'data-client-carousel' ) ? options.slidesToShow : ( options.centerMode ? 1 : 2 ),
                    m : '1' === this.ele.attr( 'data-client-carousel' ) ? 2 : 1,
                };
            }
            //'d' should always be at the end
            [ 'l', 't', 'm', 'd' ].forEach(function(screen) {
                if( 'd' == screen ) {
                    //mutate main options
                    var settings = this.buildResponsiveSetting( options, responsiveDefaults, 'd' );
                    $.extend( options, settings );
                }else {
                    options.responsive.push({
                        breakpoint : 'l' == screen ? 1377 : ( 't' == screen ? 1024 : 768 ),
                        settings : this.buildResponsiveSetting( options, responsiveDefaults, screen )
                    });
                }                
            }.bind(this));
        };
        BeSlider.prototype.setSlickSettings = function() {
            this.settings = null;
            var slidesCount = this.ele.find( '.exp-slide' ).length,
                sliderSettingsDefaults = {
                    slidesToShow : 1,
                    centerMode : false,
                    adaptiveHeight : false,
                    dots : false,
                    arrows : false,
                    autoplay : false,
                    autoPlaySpeed : 2000,
                    swipeToSlide : false,
                    variableWidth : false
                },
                options = {};
            if( 'undefined' != typeof tatsuFrontendConfig && null != tatsuFrontendConfig.slider_icons ) {
                options.prevArrow = '<div class="exp-slick-arrow exp-prev">' + tatsuFrontendConfig.slider_icons.left + '</div>';
                options.nextArrow = '<div class="exp-slick-arrow exp-next">' + tatsuFrontendConfig.slider_icons.right + '</div>';
            }
            if( null != this.ele.attr( 'data-variable-width' ) ) {
                options.variableWidth = '1' === this.ele.attr( 'data-variable-width' );
                if( options.variableWidth ) {
                    options.adaptiveHeight = false;
                }
            }
            if(  null != this.ele.attr( 'data-slides-to-show' ) ) {
                if( !options.variableWidth ) {
                    if( '1' !== this.ele.attr( 'data-slides-to-show-retain-count' ) ) {
                        options.slidesToShow = slidesCount < this.ele.attr( 'data-slides-to-show' ) ? slidesCount : this.ele.attr( 'data-slides-to-show' );
                    }else {
                        options.slidesToShow = this.ele.attr( 'data-slides-to-show' );
                    }
                }else {
                    console.warn( 'Slides to Show and Variable Width Slider cannot coexist' );
                }
            }
            if( null != this.ele.attr( 'data-center-mode' ) ) {
                if( null != options.slidesToShow || null != options.variableWidth ) {
                    options.centerMode = true;
                    if( null != this.ele.attr( 'data-center-pad' ) ) {
                        options.centerPadding = !isNaN( parseInt( this.ele.attr( 'data-center-pad' ) ) ) ? ( this.ele.attr( 'data-center-pad' ) ) : '100px'; 
                    }
                }else {
                    console.warn( 'CenterMode needs slidesToShow or variableWidth option to work' );
                }
            }
            if( null != this.ele.attr( 'data-autoplay' ) ) {
                options.autoplay = this.ele.attr( 'data-autoplay' );
                options.autoplaySpeed = !isNaN( this.ele.attr( 'data-autoplay-speed' ) ) ? this.ele.attr( 'data-autoplay-speed' ) : 2000;
            }
            if( null != this.ele.attr( 'data-dots' ) ) {
                options.dots = '1' === this.ele.attr( 'data-dots' );
            }
            if( null != this.ele.attr( 'data-arrows' ) && 1200 > this.ele.width() ) {
                options.arrows = '1' === this.ele.attr( 'data-arrows' );
            }
            if( !options.variableWidth && ( !options.slidesToShow || 1 === options.slidesToShow ) ) {
                options.adaptiveHeight = '1' === this.ele.attr( 'data-adaptive-height' );
            }else {
                console.warn( 'Adaptive Height works only when slidesToShow and VariableHeight are not set' );
            }
            if( null != this.ele.attr( 'data-as-nav-for' ) && 0 < $( this.ele.attr( 'data-as-nav-for' ) ).length ) {
                options.asNavFor = this.ele.attr( 'data-as-nav-for' );
            }
            if( null != this.ele.attr( 'data-finite' ) ) {
                options.infinite = false;
            }
            if( null != this.ele.attr( 'data-swipe-to-slide' ) ) {
                options.swipeToSlide = '1' === this.ele.attr( 'data-swipe-to-slide' ) ? true : false ;
            }
            if( null != this.ele.attr( 'data-focus-on-select' ) ) {
                options.focusOnSelect = true;
            }
            this.addResponsiveOptions( options );
            console.log( options );
            this.settings = $.extend( sliderSettingsDefaults, options ); 
        };
        BeSlider.prototype.getMaxHeight = function() {
            var maxHeight = 0,
                slides = this.ele.find( '.exp-slide' );
            slides.each(function(){
                var curSlide = $(this);
                if( maxHeight < curSlide.height() ) {
                    maxHeight = curSlide.height();
                }
            });
            return  maxHeight;
        }
        BeSlider.prototype.initEqualHeightSlider = function() {
            if( '1' === this.ele.attr( 'data-equal-height' ) ) {
                var maxHeight = this.getMaxHeight(),
                    slides = this.ele.find( '.exp-slide' );
                slides.height( maxHeight );
                this.ele.addClass( 'exp-equal-height-slider' );
            }
        };
        BeSlider.prototype.updateEqualHeightSliders = function() {
            var maxHeight = this.getMaxHeight(),
                slides = this.ele.find( '.exp-slide' );
            slides.height( maxHeight );
            this.ele.slick( 'setPosition' );
        };
        BeSlider.prototype.initVariableSlider = function() {
            if( '1' === this.ele.attr( 'data-variable-width' ) ) {
                var slides = this.ele.find( '.exp-slide' );
                if( 768 <= $win.width() ) {
                    if( '1' === this.ele.attr( 'data-lazy-load' ) ) {
                        slides.each(function(){
                            var curSlide = $(this),
                                curSlideInner = curSlide.find( '.exp-image-slide-inner' ),
                                curAspectRatio = curSlide.find( '.exp-slider-lazy-load' ).attr( 'data-aspect-ratio' );
                            if( null != curAspectRatio ) {
                                curSlideInner.css( 'height', '' );
                                curSlideInner.width( curSlideInner.height() * curAspectRatio );
                            }
                        });
                    }else {
                        slides.find( '.exp-image-slide-inner' ).css( 'height', '' );
                    }
                }else if( 768 > $win.width() ) {
                    slides.each(function() {
                        var curSlide = $(this),
                            curSlideInner = curSlide.find( '.exp-image-slide-inner' ),
                            curAspectRatio = curSlide.find( '.exp-carousel-img' ).attr( 'data-aspect-ratio' );
                        if( null != curAspectRatio ) {
                            curSlideInner.css( 'width', '' );
                            curSlideInner.height( curSlideInner.width() / curAspectRatio );
                        }
                    });
                }
            }  
        };
        BeSlider.prototype.updateVariableSlider = function() {
            setTimeout(function() {
                var slides = this.ele.find( '.exp-slide' );
                if( 768 <= $win.width() ) {
                    if( '1' === this.ele.attr( 'data-lazy-load' ) ) {
                        slides.each(function(){
                            var curSlide = $(this),
                                curSlideInner = curSlide.find( '.exp-image-slide-inner' ),
                                curAspectRatio = curSlide.find( '.exp-slider-lazy-load' ).attr( 'data-aspect-ratio' );
                            if( null != curAspectRatio ) {
                                curSlideInner.css( 'height', '' );
                                curSlideInner.width( curSlideInner.height() * curAspectRatio );
                            }
                        });
                    }else {
                        slides.find( '.exp-image-slide-inner' ).css( 'height', '' );
                    }
                }else if( 768 > $win.width() ) {
                    slides.each(function() {
                        var curSlide = $(this),
                            curSlideInner = curSlide.find( '.exp-image-slide-inner' ),
                            curAspectRatio = curSlide.find( '.exp-carousel-img' ).attr( 'data-aspect-ratio' );
                        if( null != curAspectRatio ) {
                            curSlideInner.css( 'width', '' );
                            curSlideInner.height( curSlideInner.width() / curAspectRatio );
                        }
                    });
                }
                this.ele.slick( 'setPosition' );
            }.bind(this), 10);
        };
        BeSlider.prototype.initEvents = function() {
            this.ele.on( 'init', function() {
                if( null != this.imagesToLazyLoad ) {
                    this.addDoppelgangers();
                    this.lazyLoad();
                }
                this.ele.addClass( 'exp-slider-initialized' );
            }.bind(this));

        
            if( null != this.imagesToLazyLoad ) {
                this.ele.on( 'afterChange', this.lazyLoad );
                this.ele.on( 'breakpoint', this.updateDoppelgangers );
            }
            if( 'number' == typeof this.settings.slidesToShow && 0 < this.settings.slidesToShow ) {
                this.ele.on( 'breakpoint', this.updateGutter );
            }
            if( this.ele.hasClass( 'exp-equal-height-slider' ) ) {
                this.ele.on( 'breakpoint', this.updateEqualHeightSliders );
            }

            if( '1' === this.ele.attr( 'data-fullscreen' ) ) {
                this.ele.on( 'breakpoint', this.updateFullscreenSlider );
            }
            if( '1' === this.ele.attr('data-variable-width') ) {
                this.ele.on( 'breakpoint', this.updateVariableSlider );
            }
        };
        BeSlider.prototype.updateGutter = function(e, slick, breakpoint) {
            if( 768 == breakpoint ) {
                this.ele.find( '.exp-slide' ).css( 'padding', '' );
            }else {
                var curGutter = !isNaN( parseInt( this.ele.attr( 'data-gutter' ) ) ) ? parseInt( this.ele.attr( 'data-gutter' ) ) : 0;
                if( 0 < curGutter ) {
                    curGutter = curGutter/2;
                    this.ele.find( '.exp-slide' ).css( 'padding', '0 ' + ( curGutter + 'px' ) );
                }
            }
        };
        BeSlider.prototype.initLazyLoad = function() {
            this.imagesToLazyLoad = null;
            if( '1' === this.ele.attr( 'data-lazy-load' ) ) {
                this.imagesToLazyLoad = this.ele.find( '.exp-slider-lazy-load' );
            }
        };
        BeSlider.prototype.addDoppelgangers = function() {
            if( null != this.imagesToLazyLoad ) {
                this.imagesToLazyLoad = this.ele.find( '.exp-slider-lazy-load' );
            }
        };
        BeSlider.prototype.getDoppelgangers = function( images ) {
            var srcArray = [],
                doppelgangers = $();
            if( 0 < this.imagesToLazyLoad.length ) {
                images.each(function(){
                    srcArray.push($(this).attr('data-src'));
                });
                this.imagesToLazyLoad.each(function(){
                    var curImage = $(this);
                    if( 0 < curImage.length && null == curImage.attr( 'src' ) && -1 < srcArray.indexOf( curImage.attr( 'data-src' ) ) ) {
                        doppelgangers = doppelgangers.add(curImage);
                    }
                });
            }
            return doppelgangers;
        };
        BeSlider.prototype.updateDoppelgangers = function() {
            if( 0 < this.imagesToLazyLoad.length ) {
                var currentDoppelgangers = this.imagesToLazyLoad.filter( function() {
                    return $(this).closest( '.slick-slide' ).hasClass( 'slick-cloned' );
                });
                this.imagesToLazyLoad = this.imagesToLazyLoad.not( currentDoppelgangers );
                var newDoppelgangers = this.ele.find( '.slick-cloned .exp-slider-lazy-load' ),
                    newDoppelgangersToLazyLoad = newDoppelgangers.filter(function() {
                        return null == $(this).attr( 'src' );
                    });
                if( 0 < newDoppelgangersToLazyLoad.length ) {
                    this.imagesToLazyLoad = this.imagesToLazyLoad.add( newDoppelgangersToLazyLoad );
                }
            }
        };
        BeSlider.prototype.loadImages = function( images ) {    
            var doppelgangers = this.getDoppelgangers( images );
            if( 0 < doppelgangers.length ) {
                images = images.add(doppelgangers);
            }
            images.one( 'load', function() {
                $(this).addClass( 'exp-lazy-loaded' );
            }).each(function(){
                var curImage = $(this);
                curImage.attr( 'src', curImage.attr( 'data-src' ) )
            });
            this.imagesToLazyLoad = this.imagesToLazyLoad.not( images );
            if( 0 == this.imagesToLazyLoad.length ) {
                this.ele.off( 'afterChange', this.lazyLoad );
                this.ele.off( 'breakpoint', this.updateDoppelgangers );
            }
        };
        BeSlider.prototype.getVisibleSlides = function() {
            var draggableContainer = this.ele.find( '.slick-list' ),
                sliderLeft = draggableContainer.offset().left,
                boundaries = {
                    left : sliderLeft,
                    right : sliderLeft + draggableContainer.width()
                };
            return this.imagesToLazyLoad.filter(function() {
                var curImage = $(this),
                    imageSlide = curImage.parent(),
                    curImageLeft = imageSlide.offset().left,
                    curImageRight = imageSlide.offset().left + imageSlide.outerWidth(true);
                return ( ( curImageRight > boundaries.left && curImageRight <= boundaries.right ) || ( curImageLeft < boundaries.right && curImageLeft >= boundaries.left ) );
            });
        };
        BeSlider.prototype.lazyLoad = function() {
            if( 0 < this.imagesToLazyLoad.length ) {
                //time for slide motion to complete
                setTimeout( function() {
                    var visibleImages = this.getVisibleSlides();
                    if( null != visibleImages && 0 < visibleImages.length ) {
                        this.loadImages(visibleImages);
                    }
                }.bind(this), 0 );
            }
        };
        BeSlider.prototype.initSlick = function() {
            this.ele.slick( this.settings );
        };
        return BeSlider;
}, jQuery );