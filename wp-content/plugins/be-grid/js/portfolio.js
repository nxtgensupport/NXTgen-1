(function ($) {

        var grid = function() {
            asyncloader.require( [ 'isotope', 'begrid' ], function() {
                var grids = jQuery( '.be-grid[data-layout="metro"],.be-grid[data-layout="masonry"]' );
                grids.each( function() {
                    new BeGrid(this);
                });
            });
        },
        detectBrowser = function () {

            // Opera 8.0+
            var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0,
                isFirefox = typeof InstallTrigger !== 'undefined',
                isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification)),
                isIE = !!document.documentMode,
                isEdge = !!window.StyleMedia,
                isChrome = !!window.chrome && !!window.chrome.webstore;
            return isOpera ? 'Opera' : isFirefox ? 'Firefox' : isSafari ? 'Safari' : isIE ? 'IE' : isEdge ? 'Edge' : isChrome ? 'Chrome' : false;

        },
        tilt = function () {

            if (jQuery('.be-portfolio-prebuilt-hover-style3').length > 0) {
                asyncloader.require('tilt', function () {
                    var targetElements = jQuery('.be-portfolio-prebuilt-hover-style3').closest('.be-portfolio-wrap').css('overflow', 'visible').find('.portfolio-thumb-wrap'),
                        targetBrowser = detectBrowser();
                    if ('string' == typeof targetBrowser && ('Edge' == targetBrowser || 'IE' == targetBrowser)) {
                        return;
                    } else if ('string' == typeof targetBrowser && 'Safari' == targetBrowser) {
                        targetElements.find('.thumb-shadow-wrapper').css('display', 'none');
                        if (jQuery('body').hasClass('be-fixed-footer')) {
                            jQuery('#be-fixed-footer-wrap').css('position', 'relative');
                            jQuery('#be-fixed-footer-placeholder').css('display', 'none');
                            jQuery('body').removeClass('be-fixed-footer');
                            jQuery('body').addClass('be-fixed-footer-disable');
                        }
                    }
                    targetElements.tilt({
                        glare: true,
                        maxGlare: 0.3,
                        perspective: 1000,
                        speed: 4000,
                        maxTilt: 10,
                        scale: 1.05
                    });

                });
            }
        },
        lightbox = function () {
            if ($('.mobx').length) {
                asyncloader.require('modulobox', function () {
                    if (typeof window.mobx !== 'object') {
                        var mobx = new ModuloBox({
                            mediaSelector: '.mobx',
                        });
                        mobx.init();
                        mobx.on('sliderSettled.modulobox', function (position) {
                            var selectedIndex = this.gallery.index,
                                selectedElement = this.gallery[selectedIndex];
                            if (selectedElement.type === "HTML") {
                                mobx.getGalleries();
                            }
                        });
                        mobx.on('afterOpen.modulobox', function (gallery, index) {
                            var selectedIndex = this.gallery.index,
                                selectedElement = this.gallery[selectedIndex];
                            if (selectedElement.type === "HTML") {
                                mobx.getGalleries();
                            }
                        });
                        window.mobx = mobx;
                    } else {
                        if (typeof window.mobx.getGalleries === 'function') {
                            window.mobx.getGalleries();
                        }
                    }

                });
            }
        },
        be_portfolio = function () {
            var dependencies = portfolioPluginConfig.dependencies || {};

            if ('undefined' != typeof dependencies) {
                for (var dependency in dependencies) {
                    if (dependencies.hasOwnProperty(dependency)) {
                        asyncloader.register(dependencies[dependency], dependency);
                    }
                }
            }
            grid();
            tilt();
            lightbox();
            // revealAllAtOnce();
        };
    $(function () {
        be_portfolio();
        $(window).on('tatsu_update', function () {
            be_portfolio();
        });
    });

}(jQuery));