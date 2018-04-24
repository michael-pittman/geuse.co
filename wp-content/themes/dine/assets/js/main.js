/**
 * @package Dine
 * @since Dine 1.0
 */
(function( window, DINE, $ ) {
    "use strict";
    
    // Define DINE
    var DINE = DINE || {};
    
    // cache element to hold reusable elements
    DINE.cache = {
        $document : {},
        $window   : {}
    }
    
    /**
     * Request Animation Frame
     *
     * Adapted from https://gist.github.com/paulirish/1579671
     *
     * @since 1.0
     */
    if(!Date.now) {
        Date.now = function () { return new Date().getTime(); };
    }
    if(!window.requestAnimationFrame) {
        (function () {

            var vendors = ['webkit', 'moz'];
            for (var i = 0; i < vendors.length && !window.requestAnimationFrame; ++i) {
                var vp = vendors[i];
                window.requestAnimationFrame = window[vp+'RequestAnimationFrame'];
                window.cancelAnimationFrame = window[vp+'CancelAnimationFrame']
                                           || window[vp+'CancelRequestAnimationFrame'];
            }
            if (/iP(ad|hone|od).*OS 6/.test(window.navigator.userAgent) // iOS6 is buggy
                || !window.requestAnimationFrame || !window.cancelAnimationFrame) {
                var lastTime = 0;
                window.requestAnimationFrame = function (callback) {
                    var now = Date.now();
                    var nextTime = Math.max(lastTime + 16, now);
                    return setTimeout(function () { callback(lastTime = nextTime); },
                                      nextTime - now);
                };
                window.cancelAnimationFrame = clearTimeout;
            }
        }());
    }
    
    /**
     * Mobile Check
     *
     * @since 1.0
     */
    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };
    
    /**
     * Debouce function
     *
     * @since 1.0
     */
    window.debounce = function(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };
    
    /**
     * Init functions
     *
     * @since 1.0
     */
    DINE.init = function() {
        
        /**
         * cache elements for faster access
         *
         * @since 1.0
         */
        DINE.cache.$document = $(document);
        DINE.cache.$window = $(window);
        
        DINE.cache.$document.ready(function() {
        
            DINE.stickyHeight();
            DINE.scrollup();
            DINE.niceselect();
            DINE.sticky();
            DINE.slider();
            DINE.lightbox();
            DINE.tipsy();
            DINE.superfish();
            DINE.headerCenter();
            DINE.scrollTo();
            DINE.offcanvas();
            DINE.fitvids();
            DINE.parallax();
            DINE.sidenavSkin();
            DINE.bookingPlaceholder();
            DINE.woocommerce_quantity();
            
        });
        
    }
    
    /**
     * Change labels to placeholders
     */
    DINE.bookingPlaceholder = function() {
        
        $( '.rtb-booking-form' ).find( '.rtb-text, .rtb-textarea' ).each(function() {
        
            var $this = $( this ),
                label = $this.find( 'label' ).text().trim();
            
            $this.find( 'input[type="text"], input[type="email"], input[type="tel"], input[type="number"], textarea' ).attr( 'placeholder', label );
            $this.find( 'label' ).remove();
        
        });
        
    }
    
    /**
     * Modify sticky header height based on screen width
     *
     * @since 1.0
     */
    DINE.stickyHeight = function() {
    
        var getHeight = function() {
            
            if ( undefined === DINE.originalStickyHeight ) {
                
                DINE.originalStickyHeight = DINE.header_sticky_height;
                
            }
                
            if ( ! window.matchMedia( '(min-width:940px)' ).matches && undefined === DINE.header_sticky_mobile ) {
                DINE.header_sticky_height = 0;
            } else {
                DINE.header_sticky_height = DINE.originalStickyHeight;
            }
            
        }
        
        getHeight();
        $( window ).resize( getHeight );
        
    }
    
    /**
     * Scroll up showing up
     *
     * @since 1.0
     */
    DINE.scrollup = function() {
        
        $( '#footer' ).bind( 'inview', function(event, isInView, visiblePartX, visiblePartY) {
                
            if (isInView ) {

                $( '#scrollup' ).addClass( 'shown' );

            } else {
            
                $( '#scrollup' ).removeClass( 'shown' );
            
            }

        });
    
    }
    
    /**
     * Nice Select
     *
     * @since 1.0
     */
    DINE.niceselect = function() {
        
        // setup nice select for other select elements
        $( 'select' ).each(function() {
            
            // ignore this of WooCommerce
            // @since 1.1
            if ( $( this ).is( '#rating, #billing_country, #billing_state' ) ) return;
            
            var select = $( this ),
                val = select.find( 'option[value="' + select.val() + '"]' ).text();
            if ( select.parent( '.dine-nice-select' ).length ) return;
            
            select
            .wrap( '<div class="dine-nice-select" />' )
            .after( '<a href="#">' + val + '</a>' )
        
        });
        
        $( '.dine-nice-select' ).each(function() {
            
            var _this = $( this )
            
            _this.find( 'select' ).on( 'change', function() {
                
                var select = $( this )
                
                _this.find( 'a' ).text( select.find( 'option[value="' + select.val() + '"]' ).text() );
            
            });

        });
        
    }
    
    /**
     * Flickity Slider
     *
     * @since 1.0
     */
    DINE.slider = function() {
    
        if ( ! $().flickity ) return;
        
        $( '.dine-slider' ).each(function() {
        
            var $this = $( this ),
                slider = $this.find( '.carousel' ),
                defaultOptions = {
                    selectedAttraction: 0.2,
                    friction: 0.8,
                    resize: true,
                },
                args = $this.data( 'options' ),
                options = $.extend( defaultOptions, args );
            
            $this.imagesLoaded(function() {
            
                slider.flickity( options );
                $this.addClass( 'loaded' );
            
            });
        
        });
        
    }
    
    /**
     * Lightbox
     *
     * @since 1.0
     */
    DINE.lightbox = function() {
        
        if ( ! $().magnificPopup ) return;
        
        $( '.dine-lightbox-link' ).magnificPopup();
        
        $( '.dine-lightbox-gallery, .gallery, .woocommerce-product-gallery__wrapper' ).each(function() {
            
            var delegate;
            if ( $( this ).is( '.dine-lightbox-gallery' ) ) {
                delegate = 'a.lightbox-link';
            } else if ( $( this ).is( '.woocommerce-product-gallery__wrapper' ) ) {
                delegate = 'a';
            } else {
                delegate = 'a[href$=".gif"], a[href$=".jpg"], a[href$=".jpeg"], a[href$=".png"], a[href$=".bmp"]';
            }
        
            // This will create a single gallery from all elements that have class "gallery-item"
            $( this ).magnificPopup({
                type: 'image',
                delegate: delegate,
                gallery:{
                    
                    enabled:true,
                    arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"><i class="fa fa-chevron-%dir%"></i></button>',
                    
                },
                // mainClass: 'mfp-zoom-in',
                removalDelay: 400,
                closeBtnInside : false,
                closeMarkup : '<button title="%title%" type="button" class="mfp-close"><span class="line1"></span><span class="line2"></span></button>',
                callbacks: {
                    
                    open: function() {
						//overwrite default prev + next function. Add timeout for css3 crossfade animation
						$.magnificPopup.instance.next = function() {
							var self = this;
							self.wrap.removeClass('mfp-image-loaded');
							setTimeout(function() { $.magnificPopup.proto.next.call(self); }, 120);
						}
						$.magnificPopup.instance.prev = function() {
							var self = this;
							self.wrap.removeClass('mfp-image-loaded');
							setTimeout(function() { $.magnificPopup.proto.prev.call(self); }, 120);
						}
						
					},
                    
                    imageLoadComplete: function() {	
						var self = this;
						setTimeout(function() { self.wrap.addClass('mfp-image-loaded'); }, 16);
					},
                    
                    beforeClose: function() {
                        var self = this;
                        setTimeout(function() { self.wrap.removeClass('mfp-image-loaded'); }, 16);
                    },
                    
				}
                
            });
        
        });
    
    }
    
    /**
     * Parallax
     *
     * @since 1.0
     */
    DINE.parallax = function() {
        
        if ( Modernizr.touch ) {
            
            $( '.dine-parallax' ).each(function() {
                
                $( this ).addClass( 'no-parallax' );
                
            });
            
            return;
            
        }
        
        $( '.dine-parallax' ).each(function() {
            
            $( this ).addClass( 'parallaxable' );
            
        });
        
        DINE.cache.$window.on( 'load', function() {
            
            // Init ScrollMagic
            var controller = new ScrollMagic.Controller();
            
            // Initial Setup
            $( '.dine-parallax' ).each(function() {

                // SETUP 1: background element
                var _this = this,
                    $this = $( this ),
                    bg = $this.css( 'background-image' );
                if ( ! bg ) return;
                
                var bgElement = $( '<div class="parallax-bg" />' )
                bgElement.css( 'background-image', bg );
                bgElement.appendTo( $this );
                
                $this.append( '<div class="dark-bg" />' );

                var bgElement = $this.find( '.parallax-bg' );
                
                // SETUP 2: wrap fade out elements
                if ( $this.hasClass( 'dine-elements-fade' ) ) {
                    
                    $this.find( '.wpb_content_element, .vc_custom_heading, .dine-button, .dine-icon-wrapper' ).each(function( i ){

                        var ele = $( this );

                        if ( ele.parent().is( '.dine-parallax-element' ) ) return;

                        ele.wrap( '<div class="dine-parallax-element" />' );

                        if ( ele.is( '.dine-button' ) && ele.parent().next().is( '.dine-button' ) ) {

                            ele.parent().next().appendTo( ele.parent() );

                        }

                    });
                    
                }

                // SCENE 1
                // move background element container when slide gets into the view
                var slideParallaxScene = new ScrollMagic.Scene({
                    triggerElement: _this,
                    triggerHook: 1,
                    duration: "200%"
                })
                .setTween(TweenMax.from( bgElement , 1, {y: '-40%', autoAlpha: 0.3, ease:Power0.easeNone}))
                .addTo(controller);
                
                // SCENE 2
                // animate elements
                $this.find( '.dine-parallax-element' ).each(function( index, ele ) {
                    
                    var $ele = $( this );
                    
                    var num = index+1;

                    // make scene
                    var headerScene = new ScrollMagic.Scene({
                        // triggerElement: ele, // trigger CSS animation when header is in the middle of the viewport 
                        // offset: -95, // offset triggers the animation 95 earlier then middle of the viewport, adjust to your liking
                        triggerElement: _this,
                        duration: "50%",
                        triggerHook: -.5,
                    })
                    .setTween(TweenMax.to( ele , 1, {y: ( ( num + 2 ) / ( num + 5 ) ) * 300 + 'px', autoAlpha: 0, ease:Power0.easeNone}))
                    .addTo(controller);
                    
                });

            });
            
        });
    
    }
    
    /**
     * Sidenav Skin Switch
     *
     * @since 1.0
     */
    DINE.sidenavSkin = function() {
        
        var nav = $( '#sidenav' );
        if ( ! nav.length ) return;
        
        var navTop = nav.position().top + nav.outerHeight();
        
        var offsetArr = [],
            offsets = [],
            lastKnownScroll = 0,
            currentSection = 0,
            currentSkin = 'dark';
        
        DINE.cache.$window.load(function() {
        
            setTimeout(function() {
                
                $( '.entry-content > .vc_row, .entry-content > .vc_section, #footer' ).each(function() {

                    offsetArr[ Math.round( $( this ).offset().top ) ] = ( 'none' === $( this ).css( 'background-image' ) && ! $( this ).is( '#footer' ) ) ? 'dark' : 'light';
                    offsets.push( Math.round( $( this ).offset().top ) );

                });
                
                lastKnownScroll = DINE.cache.$window.scrollTop();
                navTop = nav.position().top;
                for ( var i in offsets ) {
                    i = parseInt( i );
                    if ( offsets[ i ] <= lastKnownScroll + navTop && lastKnownScroll + navTop < offsets[ i + 1 ] ) {
                        currentSection = i;
                    }
                }
                var skin = offsetArr[ offsets[ currentSection ] ];
                if ( 'light' === skin ) {
                    nav.addClass( 'navlight' );
                } else {
                    nav.removeClass( 'navlight' );
                }
                
                var currentSection = null;

                DINE.cache.$window.scroll(function() {

                    lastKnownScroll = DINE.cache.$window.scrollTop();
                    for ( var i in offsets ) {
                        i = parseInt( i );
                        if ( offsets[ i ] <= lastKnownScroll + navTop && ( lastKnownScroll + navTop < offsets[ i + 1 ] || undefined === offsets[ i + 1] ) ) {
                            currentSection = i;
                        }
                    }
                    var skin = offsetArr[ offsets[ currentSection ] ];
                    
                    // save performance
                    if ( skin != currentSkin ) {
                        
                        currentSkin = skin;
                        
                        if ( 'light' === skin ) {
                            nav.addClass( 'navlight' );
                        } else {
                            nav.removeClass( 'navlight' );
                        }
                        
                    }
                    

                });
                
            }, 600 );
            
        });
        
    }

    /**
     * Responsive Videos
     *
     * @dependency: Fitvids
     *
     * @since 1.0
     */
    DINE.fitvids = function(){
        if ( !$().fitVids ) {
            return;
        }

        $('.entry-content, .media-container').fitVids();

    }; // fitvids
    
    /**
     * Tipsy Tooltip
     *
     * @since 1.0
     */
    DINE.tipsy = function() {
        
        if ( ! $().tipsy ) {
            return;
        }
        
        var run = function() {
        
            $( '#header-social a' ).tipsy({
                gravity: 'n',
                opacity: 1,
                title: function() {
                    return $( this ).find( 'span' ).text()
                }
            });

            $( '.dine-icon[title], .widget-social a' ).tipsy({
                gravity: 's',
                opacity: 1,
            });

            $( '.hastip' ).tipsy({
                gravity: 's',
                opacity: 1,
            });
            
        }
        
        if ( window.matchMedia( '(min-width:940px)' ).matches ) {
            run();
        }
    }
    
    /**
     * Centralize the header
     *
     * @since 1.0
     */
    DINE.headerCenter = function() {
        
        var header = $( '.header-center' );
        if ( ! header.length ) return;
        
        var nav = header.find( '#nav' );
        if ( ! nav.length ) return;
        
        var items = nav.find( '>li' );
        if ( ! items.length ) return;
        
        items.eq( Math.round( items.length/2 ) ).addClass( 'divided-here' );
        
        nav.addClass( 'repositioned' )
    
    }
    
    /**
     * Sticky Navigation
     *
     * @since 1.0
     */
    DINE.sticky = function() {
        
        // If header sticky not enabled
        if ( ! DINE.header_sticky ) return;
        
        var init = debounce( function() {
        
            if ( ! window.matchMedia( '(min-width:940px)' ).matches && ( undefined === DINE.header_sticky_mobile ) ) {
                return;
            }

            var header = $( '#masthead' ),
                header_height = DINE.header_height ? parseInt( DINE.header_height ) : 100,
                header_sticky_height = ! isNaN( DINE.header_sticky_height ) ? parseInt ( DINE.header_sticky_height ) : 80;
            
            if ( ! header.length ) return;
            
            function sticky() {

                var height = header_sticky_height + Math.max( header_height - header_sticky_height - DINE.cache.$window.scrollTop(), 0 );
                    
                header.find( '.container' ).css({
                    height: height + 'px',
                });
                
                if ( DINE.cache.$window.scrollTop() > 0 ) {
                    header.addClass( 'is-sticky' );
                } else {
                    header.removeClass( 'is-sticky' );
                }

            }

            sticky();
            
            DINE.cache.$window.off( 'scroll.sticky' ).on( 'scroll.sticky', function(){

                 requestAnimationFrame( sticky ) ;

            });

        }, 100 );

        DINE.cache.$window.load(function() {
            init();
        });

    }
    
    /**
     * Superfish Menu, make menu works more effective
     *
     * @dependency: superfish
     *
     * @since 1.0
     */
    DINE.superfish = function(){
        
        if ( !$().superfish ) 
            return;
        
        var runSuperfish = function() {
            
            var args = {
                delay: 0,
                speed: 0,
                speedOut: 0,
                animation: {
                    opacity : 'show',
                },							   
            };

            $( '#masthead .main-menu' ).each(function(){
                
                $( this ).superfish( args );

            });
        }
        
        var destroySuperfish = function() {
            $( '.main-menu' ).each(function(){
                $( this ).superfish( 'destroy' );
            });
        }
        
        var initSuperfish = debounce( function() {
            if ( window.matchMedia( '(min-width:1024px)' ).matches ) {
                runSuperfish();
            } else {
                destroySuperfish();   
            }
        }, 200 );
        
        initSuperfish();
        
        DINE.cache.$window.resize(initSuperfish);
        
    }
    
    /**
     * Scroll To
     *
     * @since 1.0
     */
    DINE.scrollTo = function() {
        
        var offset = 0,
            speed = 400,
            noHash = window.location.pathname,
            controller = new ScrollMagic.Controller({ container : '#page' });
        
        // change behaviour of controller to animate scroll instead of jump
        controller.scrollTo(function (newpos) {
			TweenMax.to(window, 1, {scrollTo: {y: newpos - offset}, ease:Power4.easeInOut});
		});
        
        if ( DINE.header_sticky ) {
            offset = ! isNaN( DINE.header_sticky_height ) ? parseInt ( DINE.header_sticky_height ) : 80;
        }
        if ( $( '#wpadminbar' ).length && window.matchMedia( '(min-width:768px)' ).matches ) {
            offset += $( '#wpadminbar' ).outerHeight();
        }
        
        // Scroll to section if hash exists
        DINE.cache.$window.load(function() {
						
			if( window.location.hash ) {
                
                var id = window.location.hash;
                if ( $( id ).length ) {
                
                    setTimeout ( function () {

                        controller.scrollTo( id );

                    }, 400 );
                    
                }
								
			}
			
		});
        
        // SCROLL UP EVENT
        // =========================
        $( 'a[href="#top"]' ).on( 'click' , function( e ) {
            
            e.preventDefault();
            controller.scrollTo( '#page' );
            
        });
        
        // BUTTON CLICK SCROLL EVENT
        // =========================
        $( '.dine-btn[href*="#"], .dine-icon[href*="#"], .carousel-cell-text a[href*="#"]' ).click(function( e ) {
            
            var a = $( this ),
                href = a.attr( 'href' ),
                target = '#' + href.substring(href.indexOf('#')+1);
            
            if ( target == '#' ) return;
            
            var testA = document.createElement('a');
                testA.href = href;
            
            // This is external link
            // Let it redirects
            if ( testA.pathname !== noHash && '' != testA.pathname ) {
                return;
            }
        
            e.preventDefault();
            
            controller.scrollTo( target );

            // Hash
            if ( '#top' != target ) {
                history.pushState(null, null, target );
            } else {
                history.pushState(null, null, noHash );
            }
        
        });
        
        $( '#sidenav a[href*="#"], #nav > li > a[href*="#"]' ).each( function( e ) {
            
            var a = $( this ),
                href = a.attr( 'href' ),
                target = '#' + href.substring(href.indexOf('#')+1);
            
            var testA = document.createElement('a');
                testA.href = href;
            
            // This is external link
            // Let it redirects
            if ( testA.pathname !== noHash && '' != testA.pathname ) {
                return;
            }
            
            // target doesn't exist
            if ( ! $( target ).length )
                return;
            
            // Remove Current Menu Item Class
            a
            .parent()
            .removeClass( 'current-menu-item current-menu-ancestor' );
            
            a.click(function( e ) {
                
                e.preventDefault();
                
                var timeOut = $( 'html' ).hasClass( 'nav-active' ) ? 300 : 0;
                
                // Close Mobile Nav
                $( 'html' )
                .removeClass( 'nav-active' )
                .addClass( 'nav-inactive' )
        
                setTimeout(function() {
                    
                    controller.scrollTo( target );

                    if ( '#top' != target ) {
                        history.pushState(null, null, target );
                    } else {
                        history.pushState(null, null, noHash );
                    }
                    
                }, timeOut );
                
            });
            
            if ( $( target ).length ) {
                
                // Waypoint Down
                $( target ).dine_waypoint(function( direction ) {
                    
                    if( direction === 'down' ) {
                        
                        var href = $(this.element).attr('id');
                        
                        $( '#sidenav li' ).removeClass( 'active' );
                        $( '#sidenav a[href$="#' + href + '"]' ).parent().addClass( 'active' );
                        
                    }
                
                }, { offset: offset + 1 });
                
                // Append a bottom anchor
                if ( ! $( target ).find( '.section-bottom-anchor' ).length ) {
                    $( target ).append( '<div class="section-bottom-anchor" data-target="' + target + '" />' );
                }
                var bottomAnchor = $( target ).find( '.section-bottom-anchor' );
                
                // Waypoint Up
                bottomAnchor.dine_waypoint(function( direction ) {
                    
                    var href = $(this.element).parent().attr('id');
                    
                    if( direction === 'up' ) {
                        
                        $( '#sidenav li' ).removeClass( 'active' );
                        $( '#sidenav a[href$="#' + href + '"]' ).parent().addClass( 'active' );
                        
                    }
                
                }, { offset: offset +1 });
            
            }
        
        });
    
    }
    
    DINE.offcanvas = function() {
        
        var hamburger = $( '#hamburger' ),
            offcanvas = $( '#offcanvas' );

        var offcanvas_dismiss = debounce(function( e ) {

            e.preventDefault();
            $( 'html' ).removeClass( 'offcanvas-open' );

        }, 100 );

        DINE.cache.$document.on( 'click', '#hamburger', function( e ) {

            e.preventDefault();
            $( 'html' ).toggleClass( 'offcanvas-open' );

        });

        $( '#offcanvas-overlay' ).on( 'click', offcanvas_dismiss );

        DINE.cache.$window.resize(offcanvas_dismiss);

        // Submenu Click
        $( '.offcanvas-nav li' ).click(function( e ) {

            var li = $( this ),
                a = li.find( '> a ' ),
                href = a.attr( 'href' ),
                target = $( e.target ),
                ul = li.find( '> ul' ),

                condition1 = ( ! target.is( ul ) && ! target.closest( ul ).length ),
                condition2 = ( ( ! target.is( a ) && ! target.closest( a ).length ) || ( ! href || '#' == href ) );

            if (  condition1 && condition2 ) {

                e.preventDefault();
                ul.slideToggle( 300, 'easeOutCubic' );

            }

        });
    
    }
    
    /**
     * WooCommerce Quantity Buttons
     *
     * @since 1.1
     */
    DINE.woocommerce_quantity = function() {
        
        // Quantity buttons
        $( 'div.quantity:not(.buttons-added), td.quantity:not(.buttons-added)' )
        .addClass( 'buttons-added' )
        .append( '<input type="button" value="+" class="plus" />' )
        .prepend( '<input type="button" value="-" class="minus" />' );

        // Set min value
        $( 'input.qty:not(.product-quantity input.qty)' ).each ( function() {
            var qty = $( this ),
                min = parseFloat( qty.attr( 'min' ) );
            if ( min && min > 0 && parseFloat( qty.val() ) < min ) {
                qty.val( min );
            }
        });

        // Handle click event
        DINE.cache.$document.on( 'click', '.plus, .minus', function() {

                // Get values
            var qty = $( this ).closest( '.quantity' ).find( '.qty' ),
                currentQty = parseFloat( qty.val() ),
                max = parseFloat( qty.attr( 'max' ) ),
                min = parseFloat( qty.attr( 'min' ) ),
                step = qty.attr( 'step' );

            // Format values
            if ( !currentQty || currentQty === '' || currentQty === 'NaN' ) currentQty = 0;
            if ( max === '' || max === 'NaN' ) max = '';
            if ( min === '' || min === 'NaN' ) min = 0;
            if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) step = 1;

            // Change the value
            if ( $( this ).is( '.plus' ) ) {

                if ( max && ( max == currentQty || currentQty > max ) ) {
                    qty.val( max );
                } else {
                    qty.val( currentQty + parseFloat( step ) );
                }

            } else {

                if ( min && ( min == currentQty || currentQty < min ) ) {
                    qty.val( min );
                } else if ( currentQty > 0 ) {
                    qty.val( currentQty - parseFloat( step ) );
                }

            }

            // Trigger change event
            qty.trigger( 'change' );
            
        });
        
    }
    
    /**
     * Finally, call the init
     */
    DINE.init();
    
})( window, DINE, jQuery );	// EOF