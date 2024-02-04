(function( $ ) {
    "use strict";
    var $win = $(window),
        contactForm = function() {
        var labeledForms = jQuery( '.exp-form-border-with-underline, .exp-form-rounded-with-underline' );
            if( 0 < labeledForms.length ) {
                var allFormElements = labeledForms.find( 
                        'input[type = "text"], \
                        input[type = "email"], \
                        input[type = "number"],\
                        textarea,              \
                        select' 
                    ),
                    selectFormElements = allFormElements.filter( function() {
                        return 'select' === this.tagName.toLowerCase();
                    } ),
                    focusableFormElements = allFormElements.not( selectFormElements );
                if( 0 < allFormElements.length ) {
                    //build structure
                    allFormElements.each(function( curFormEle ) {
                        var curFormEle = $(this),
                            formFieldWrapper,
                            formFieldLabel,
                            formFieldBorder;
                        if( !curFormEle.parent().hasClass( 'exp-form-field' ) ) {
                            formFieldWrapper = $( '<div class = "exp-form-field"></div>' );
                            formFieldBorder = $( '<div class = "exp-form-border"></div>' );
                            curFormEle.wrap( formFieldWrapper );
                            if( null != curFormEle.attr( 'placeholder' ) ) {
                                formFieldLabel = $( '<label class = "exp-form-field-label">' + curFormEle.attr( 'placeholder' ) + '</label>' );
                                curFormEle.attr( 'placeholder', '' );
                                curFormEle.parent().append( formFieldLabel );
                            }
                            curFormEle.parent().append( formFieldBorder );
                        }
                    });
                    allFormElements.each(function() {
                        var curEle = jQuery( this );
                        if( '' !== curEle.val() ) {
                            curEle.closest( '.exp-form-field' ).addClass( 'exp-form-field-active' );
                        }
                    } );
                    focusableFormElements.focus( function() {
                        jQuery( this ).closest( '.exp-form-field' ).addClass( 'exp-form-field-active' );
                    } );
                    focusableFormElements.blur( function() {
                        var curEle = jQuery( this );
                        if( '' == curEle.val() ) {
                            curEle.closest( '.exp-form-field' ).removeClass( 'exp-form-field-active' );
                        }
                    } );
                    selectFormElements.on( 'change', function() {
                        var curEle = jQuery( this );
                        if( '' == curEle.val() ) {
                            curEle.closest( '.exp-form-field' ).removeClass( 'exp-form-field-active' ); 
                        }else {
                            curEle.closest( '.exp-form-field' ).addClass( 'exp-form-field-active' );
                        }
                    } );
                }
            }
        },

        mailchimp = ( function() {
            $(document).on('click', '.exp-mc-submit', function ( e ) {
                e.preventDefault();
                var $this = $(this),
                    $ajaxUrl = $( '#ajax_url' ).val(),
                    $subscription_form = $this.closest('.exp-mc-form'), 
                    $subscribe_status = $subscription_form.find(".subscribe_status"), 
                    $subscribe_loader = $subscription_form.find(".exp-subscribe-loader");
                $subscription_form.addClass( 'exp-mc-form-loading' );
                $subscribe_loader.fadeIn();
                jQuery.ajax({
                    type: "POST",
                    url: $ajaxUrl,
                    dataType: 'json',
                    data: "action=mailchimp_subscription&" + jQuery(this).closest(".exp-mc-form").serialize(),
                    success : function (msg) {
                        if (msg.status === "error") {
                            $subscribe_status.removeClass("tatsu-success").addClass("tatsu-error");
                        } else {
                            $subscribe_status.addClass("tatsu-success").removeClass("tatsu-error");
                        }
                        $subscribe_loader.fadeOut(400, 'swing', function() { 
                            $subscribe_status.html(msg.data).slideDown();
                            $subscription_form.removeClass( 'exp-mc-form-loading' );
                        });
                    },
                    error: function () {
                        $subscribe_loader.fadeOut(400, 'swing', function() {  
                            $subscribe_status.removeClass("tatsu-success").addClass("tatsu-error");
                            $subscribe_status.html("Please Try Again Later").slideDown();    
                            $subscription_form.removeClass( 'exp-mc-form-loading' ); 
                        });
                       
                    }
                });
                return false;
            });
            return function() {
                var newsletters =  jQuery( '.exp-mc' );
                if( 0 < newsletters.length ) {
                    newsletters.each( function() {
                        var curEle = $(this),
                            parentWidth = curEle.parent().width(),
                            curEleWidth = curEle.find('.exp-mc-email').outerWidth(true) + curEle.find('.exp-mc-submit').outerWidth();
                        if( curEleWidth > parentWidth ) {
                            curEle.addClass( 'exp-mc-block' );
                        }else {
                            curEle.removeClass( 'exp-mc-block' );
                        }
                    } );
                }
            } 
        } )(),

        registerDependencies = function() {
            if( null != exponentModulesConfig && null != exponentModulesConfig.dependencies ) {
                var dependencies = exponentModulesConfig.dependencies;
                for( var dependency in dependencies ) {
                    asyncloader.register( dependencies[dependency], dependency );
                }
            }
        },  

        tatsuCallbacks = function() {
            $(window).on( 'tatsu_update', function( event, data ) {
                if( null != data ) {
                    var moduleName = data.moduleName,
                        shouldUpdate = data.shouldUpdate,
                        moduleId = data.moduleId;
                    if( null != moduleName && null != moduleId ) {
                        if( 'exp_contact_form7' === moduleName ) {
                            contactForm();
                        }else if( 'exp_recent_posts' === moduleName ) {
                            slider( '.exp-recent-posts .be-slider' );
                        }else if( 'exp_featured_posts' === moduleName ) {
                            slider( '.exp-featured-posts .be-slider' );
                        }else if( 'blog' === moduleName ) {
                            grid();
                            slider( '.exp-blog .be-slider' );
                            video( '.exp-blog .be-slider' )
                        }else if( 'exp_countdown' === moduleName ) {
                            countDown();
                        }
                    }
                }
            });
        },
        video = function() {
            var vimeoVideos = $( '.be-vimeo-embed' ),
                youtubeVideos = $( '.be-youtube-embed' ),
                loadYoutubeVideos,
                videoReadyCallback;
            videoReadyCallback = function( iframeEle ) {
                asyncloader.require( ['fitvids'], function(){
                    if( null != iframeEle && 0 < iframeEle.length ) {
                        iframeEle.closest( '.be-video-embed' ).removeClass( 'be-embed-placeholder' );
                        iframeEle.parent().fitVids();
                        $(document).trigger( 'be_video_loaded', [ iframeEle ] );
                        $( '.exp-blog .be-grid' ).isotope( 'layout' );
                        
                    }  
                });        
            };
            loadYoutubeVideos = function() {
                youtubeVideos.each(function() {
                    var curVideo = $(this),
                        curPlayer = null,
                        id = null != curVideo.attr( 'data-video-id' ) ? curVideo.attr( 'data-video-id' ) : null,
                        autoplay = null != curVideo.attr( 'data-autoplay' ) ? parseInt(curVideo.attr( 'data-autoplay' )) : null,
                        loopVideo = null != curVideo.attr( 'data-loop' ) ? parseInt(curVideo.attr( 'data-loop' )) : null;

                    if( null != id ) {
                        curPlayer = new YT.Player( this, {
                            videoId : id,
                            playerVars: { 
                                'autoplay': autoplay,
                                'loop' : loopVideo,
                                'playlist' : loopVideo ? id : ''
                            },
                            width : curVideo.width(),
                            height : curVideo.width()/1.7777,
                            events: {
                                'onReady': function (e) {
                                    if( autoplay ){
                                        e.target.mute();   
                                    }
                                }
                            }
                        });
                        videoReadyCallback( $( curPlayer.getIframe() ) );
                    }
                });
            }
            //vimeo videos
            if( 0 < vimeoVideos.length ) {
                asyncloader.require( [ 'vimeonew' ], function() {
                    vimeoVideos.each( function() {
                        var curVideo = $(this),
                            curPlayer = null,
                            id = !isNaN( Number( curVideo.attr( 'data-video-id' ) ) ) ? Number( curVideo.attr( 'data-video-id' ) ) : null,
                            autoplay = null != curVideo.attr( 'data-autoplay' ) ? parseInt(curVideo.attr( 'data-autoplay' )) : false,
                            loopVideo = null != curVideo.attr( 'data-loop' ) ? parseInt(curVideo.attr( 'data-loop' )) : false;
                        if( null != id ) {
                            var curPlayer = new Vimeo.Player( this, {
                                id : id,
                                autoplay : autoplay ? true : false,
                                loop : loopVideo ? true : false,
                                muted : autoplay ? true : false,
                                width : curVideo.width(),
                                height : Math.ceil(curVideo.width()/1.7777),    
                            });
                            curPlayer.ready().then( function() {
                                videoReadyCallback( curVideo.children( 'iframe' ) );
                            });
                        }
                    } );
                } );
            }

            if( 0 < youtubeVideos.length ) {
                if( 'undefined' != typeof YT && 'function' == typeof YT.Player ) {
                    loadYoutubeVideos();
                }else {
                    $(document).on( 'YTAPIReady', loadYoutubeVideos );
                }
            }
        },
        slider = function( selector ) {
            var sliders = $( selector || '.be-slider' ),    
                initOuterArrows = function( slider ) {
                    if( slider instanceof $ && 0 < slider.length && !slider.hasClass( 'be-slider-with-margin' ) && ( 100 < ( $win.width() - slider.outerWidth() ) ) ) {
                        var gutter = !isNaN( slider.attr('data-gutter') ) ? Number( slider.attr('data-gutter') )/2 : 0;
                        slider.css({
                            padding : '0 50px',
                            margin : '0 -' + ( gutter + 50 ) + 'px'
                        });
                    }
                },
                getLazyLoadCount = function(slider){
                    var count = 1;
                    if( slider instanceof $ && 0 < slider.length ) {
                    var cols = !isNaN(Number(slider.attr('data-cols'))) ? Number(slider.attr('data-cols')) : 1;
                        if( 1 < cols ) {
                            count = cols-1;
                        }
                    }
                    return count;
                },
                hideUnneccessaryNav = function( curSlider ) {
                    var navPossible = function( slider ) {
                        var cols,
                            slidesClount;
                        if( slider instanceof $ && 0 < slider.length ) {
                            cols = !isNaN(Number(slider.attr('data-cols'))) ? Number(slider.attr('data-cols')) : 1;
                            slidesClount = slider.find('.be-slide').length;
                            if( 1024 < $win.width() ) {
                                return cols < slidesClount;
                            }else if( 767 < $win.width() ) {
                                return 2 < slidesClount;
                            }else {
                                return 1 < slidesClount;
                            }
                        }
                    };
                    if( !navPossible( curSlider ) ) {
                        curSlider.addClass('be-slider-hide-nav');
                    }
                    $win.on( 'debouncedresize', function() {
                        if( !navPossible(curSlider) ) {
                            curSlider.addClass('be-slider-hide-nav');
                        }else {
                            curSlider.removeClass('be-slider-hide-nav');
                        }
                    });
                },
                equalHeightSlider = function( slider ) {
                    if( slider instanceof $ && 0 < slider.length ) {
                        var maxHeight = 0,
                            slides = slider.find( '.be-slide' );
                        slides.each(function(){
                            var curSlide = $(this);
                            if( maxHeight < curSlide.height() ) {
                                maxHeight = curSlide.height();
                            }
                        });
                        slides.height( maxHeight );
                        slider.addClass( 'be-equal-height-slider' );
                    }
                };
            if( 0 < sliders.length ) {
                asyncloader.require( 'flickity', function() {
                    sliders.each(function() {
                        var curSlider = jQuery(this);
                        if( !curSlider.hasClass( 'flickity-enabled' ) ) {
                            if( '1' == curSlider.attr( 'data-arrows' ) || '1' == curSlider.attr( 'data-dots' ) ) {
                                hideUnneccessaryNav(curSlider);
                            }
                            if( '1' == curSlider.attr('data-arrows') && '1' == curSlider.attr('data-outer-arrows')) {
                                initOuterArrows(curSlider);
                            }
                            if( '1' == curSlider.attr( 'data-equal-height' ) ) {
                                equalHeightSlider(curSlider);
                            }
                            curSlider.flickity({
                                cellAlign : null != curSlider.attr( 'data-cell-align' ) ? curSlider.attr( 'data-cell-align' ) : 'left',
                                contain : true,
                                lazyLoad : '1' == curSlider.attr( 'data-lazy-load' ) ? getLazyLoadCount(curSlider) : false,
                                adaptiveHeight : '1' == curSlider.attr( 'data-adaptive-height' ) ? true : false,
                                pageDots : '1' == curSlider.attr('data-dots') ? true : false,
                                prevNextButtons : '1' == curSlider.attr('data-arrows') ? true : false,
                                asNavFor : null != curSlider.attr('data-as-nav-for') ? curSlider.attr('data-as-nav-for') : false,
                                autoPlay : !isNaN(Number(curSlider.attr('data-auto-play'))) ? Number(curSlider.attr('data-auto-play')) : false,
                                wrapAround : '1' == curSlider.attr('data-infinite') ? true : false,
                            });
                        }
                    });
                });
            }
        },
        grid = function() {
            asyncloader.require( [ 'isotope', 'begrid' ], function() {
                var grids = jQuery( '.be-grid[data-layout="metro"],.be-grid[data-layout="masonry"]' );
                grids.each( function() {
                    new BeGrid(this);
                });
            });
        },
        countDown = function( shouldUpdate ) {
            var countdownWrap = jQuery( '.exp-countdown' ),
                parseDate = function(dateAsString) {
                    return new Date(dateAsString.replace(/-/g, '/'))
                },
                countdownScripts = ( exponentModulesConfig.dependencies.countdownLangFile ) ? [ 'countdown', 'countdownLangFile' ] : 'countdown';
            if( !shouldUpdate ) {
                if( countdownWrap.length > 0 ) {
                    asyncloader.require( countdownScripts, function() { 
                        countdownWrap.each( function() {
                            var $this = jQuery(this);
                            var $date = parseDate( $this.attr( 'data-time' ) );   //moment( $this.data().time, 'YYYY-MM-DD HH:mm:ss').toDate();
                            $this.countdown({until: $date});
                        }); 
                    });
                } 
            } else {
                countdownWrap.each( function() {
                    var $this = jQuery(this);
                    var $date = parseDate( $this.attr( 'data-time' ) );   //moment( $this.data().time, 'YYYY-MM-DD HH:mm:ss').toDate();
                    $this.countdown( 'option','until', $date );
                });					
            }        	
        },
        modulobox = function(){
            if( $( '.mobx' ).length ){
                asyncloader.require('modulobox',function(){
                    if( typeof window.mobx !== 'object' ){
                        var mobx = new ModuloBox({
                            mediaSelector : '.mobx',
                        });
                        mobx.init();
                        mobx.on( 'sliderSettled.modulobox', function( position ) {
                            var selectedIndex = this.gallery.index,
                                selectedElement = this.gallery[selectedIndex];
                            if( selectedElement.type === "HTML" ){
                                mobx.getGalleries();
                            }
                        });
                        mobx.on( 'afterOpen.modulobox', function( gallery, index ) {
                            var selectedIndex = this.gallery.index,
                            selectedElement = this.gallery[selectedIndex];
                            if( selectedElement.type === "HTML" ){
                                mobx.getGalleries();
                            }
                        });
                        window.mobx = mobx;
                    }else{
                        if( typeof window.mobx.getGalleries === 'function' ){
                            window.mobx.getGalleries();
                        }
                    }
                    
                });
            }
        };

    registerDependencies();
    $( function() {
        if( null != asyncloader ) {
            contactForm();
            tatsuCallbacks();
            modulobox();
            slider();
            grid();
            mailchimp();
            countDown();
            //interactiveBox();
        }
    });
})( jQuery );