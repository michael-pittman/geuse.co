/**
 * global var DINE
 *
 * @packageDine
 * @since 1.0
 */

(function( window, $ ) {
"use strict";
    
    var DINE = DINE || {}
    
    function debounce(func, wait, immediate) {
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
     * Functions list
     *
     * @since 1.0
     */
    DINE.coreInit = function() {
        
        $(document).ready(function() {
        
            DINE.addonsReInit();
            
        });
        
    }
    
    /**
     * Initialize functions
     *
     * And can be used as a callback function for ajax events to reInit
     *
     * This can be used as a table of contents as well
     *
     * @since 1.0
     */
    DINE.addonsReInit = function() {
        
        DINE.gmap();
        
        DINE.gallery_reposition();
        
        DINE.counter();
        
        DINE.text_slider();
        
        DINE.animation();
        
        DINE.arctext();
        
        DINE.datepicker();
        
        DINE.text_resize();
        
        // for testimonial
        DINE.flexslider();
    
    }
    
    /**
     * flexslider for testimonials
     *
     * @since 2.0
     */
    DINE.flexslider = function() {
        
        if ( ! $().flexslider ) return;
        $( '.dine-flexslider' ).each(function() {
            
            var slider = $( this ),
                defaultOptions = {
                    smoothHeight : false,
                    directionNav: false,
                    controlNav : true,
                    pauseOnHover: true,
                    prevText: '<i class="fa fa-angle-left"></i>',
                    nextText: '<i class="fa fa-angle-right"></i>',
                },
                args = $( this ).data( 'options' ),
                options = $.extend( defaultOptions, args );
            
            slider.append( '<span class="loader" />' );

            slider.imagesLoaded(function(){
                
                slider
                .find( '.flexslider' )
                .flexslider( options );
                
                setTimeout( function() {
                    
                    slider.addClass( 'loaded' );
                    
                }, 200 );
                
            });
            
        });
    
    }
    
    /**
     * Text Resize
     */
    DINE.text_resize = function() {
        
        var resize = function() {
            
            $( '.cd-headline, .carousel-cell-caption h3' ).each(function() {

                var $this = $( this ),
                    size = $this.data( 'size' );

                if ( ! $this.data( 'size' ) ) {
                    
                    size = $this.css( 'font-size' ).replace( 'px', '' );
                    size = parseInt( size );
                    $this.data( 'size', size );
                    
                }

                // resize according to screen width
                if ( window.matchMedia( '(min-width:940px)' ).matches ) {
                    $this.css( 'font-size', size + 'px' );
                } else if ( window.matchMedia( '(min-width:768px)' ).matches ) {
                    $this.css( 'font-size',  ( size * 3/4 ) + 'px' );
                } else if ( window.matchMedia( '(min-width:480px)' ).matches ) {
                    $this.css( 'font-size',  ( size * 2/3 ) + 'px' );
                } else {
                    $this.css( 'font-size',  ( size * 5/12 ) + 'px' );
                }

            })
            
        }
        
        resize();
        $( window ).resize( resize );
    
    }
    
    /**
     * Date Picker
     *
     * @since 1.0
     */
    DINE.datepicker = function() {
        
        if ( ! $().datepicker ) return;
        
        $( '.dine-datepicker' ).each(function() {
            
            var defaultOptions = {
                    beforeShow : false,
                    inline: true,
                    showOtherMonths: true,
                    dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    hideIfNoPrevNext : true,
                    minDate : 0,
                    onSelect : function( dateText, obj ) {
                        var val = obj.selectedYear.toString() + '-' + ( '0' + ( obj.selectedMonth + 1 ).toString() ).slice(-2) + '-' + ( '0' + obj.selectedDay.toString() ).slice(-2);
                        $( this ).next( 'input[name="startDate"]' ).val( val )
                    }
                },
                args = $( this ).data( 'options' ),
                options = $.extend( defaultOptions, args );

            $( this ).datepicker( options );
        
        });
    
    }
    
    /**
     * Arctext
     *
     * @since 1.0
     */
    DINE.arctext = function() {
        
        $( '.imagebox-subtitle' ).each(function() {
            
            $( this )
            .arctext({radius: 150})
            
        
        });
        
        $( '.dine-arctext' ).each(function() {
        
            $( this ).find( '> span' )
            .arctext({radius: 32})
            .end()
            .addClass( 'arctext-done' );
            
        })
    
    }
    
    /**
     * Animation
     *
     * @since 1.0
     */
    DINE.animation = function() {
        
        $( '.dine-divider.has-animation, .dine-imagebox.has-animation, .dine-gallery-item, .dine-instagram-item, .dine-animation-element' ).each(function() {
            
            var $this = $( this ),
                delay = parseInt( $this.data( 'delay' ) );
            
            if ( isNaN( delay ) ) delay = 0;
            
            $this.bind( 'inview', function(event, isInView, visiblePartX, visiblePartY) {
                
                if (isInView && ! $this.hasClass( 'running' ) ) {
                    
                    setTimeout(function() {
                        
                        $this.addClass( 'running' );

                    }, delay );
                    
                } // inview
                
            });
        
        });
    
    }
    
    /**
     * Text Slider
     *
     * @since 1.0
     */
    DINE.text_slider = function() {
        
        // license
        // https://codyhouse.co/terms/
        
        var animationDelay = 2500,
            //loading bar effect
            barAnimationDelay = 3800,
            barWaiting = barAnimationDelay - 3000, //3000 is the duration of the transition on the loading bar - set in the scss/css file
            //letters effect
            lettersDelay = 50,
            //type effect
            typeLettersDelay = 150,
            selectionDuration = 500,
            typeAnimationDelay = selectionDuration + 800,
            //clip effect 
            revealDuration = 600,
            revealAnimationDelay = 1500;

        $(window).load(function() {
            
            initHeadline();
            
        });


        function initHeadline() {
            //insert <i> element for each letter of a changing word
            singleLetters($('.cd-headline.letters').find('b'));
            //initialise headline animation
            animateHeadline($('.cd-headline'));
        }

        function singleLetters($words) {
            $words.each(function(){
                var word = $(this),
                    letters = word.text().split(''),
                    selected = word.hasClass('is-visible');
                for (var i in letters) {
                    if ( ' ' == letters[i] ) letters[i] = '&nbsp;';
                    if(word.parents('.rotate-2').length > 0) letters[i] = '<em>' + letters[i] + '</em>';
                    letters[i] = (selected) ? '<i class="in">' + letters[i] + '</i>': '<i>' + letters[i] + '</i>';
                }
                var newLetters = letters.join('');
                word.html(newLetters).css('opacity', 1);
            });
        }

        function animateHeadline($headlines) {
            $headlines.each(function(){
                var headline = $(this),
                    duration = parseInt( headline.data( 'timer' ) );
                
                if ( isNaN( duration ) ) duration = 3000;

                if(headline.hasClass('loading-bar')) {
                    duration = barAnimationDelay;
                    setTimeout(function(){ headline.find('.cd-words-wrapper').addClass('is-loading') }, barWaiting);
                } else if (headline.hasClass('clip')){
                    var spanWrapper = headline.find('.cd-words-wrapper'),
                        newWidth = spanWrapper.width() + 10
                    spanWrapper.css('width', newWidth);
                } else if (!headline.hasClass('type') ) {
                    //assign to .cd-words-wrapper the width of its longest word
                    var words = headline.find('.cd-words-wrapper b'),
                        width = 0;
                    words.each(function(){
                        var wordWidth = $(this).width();
                        if (wordWidth > width) width = wordWidth;
                    });
                    
                    var diff = width - $( headline ).closest( '.wpb_wrapper' ).outerWidth(),
                        cssToApply = {
                            width: width
                        };
                    
                    if ( diff > 0 ) {
                        cssToApply.transform = 'translate( ' + ( -diff/2 ) + 'px)';
                        cssToApply[ 'letter-spacing' ] = '-2px';
                    }
                    
                    headline.find('.cd-words-wrapper').css( cssToApply );
                    
                };

                //trigger animation
                setTimeout(function(){ hideWord( headline.find('.is-visible').eq(0) ) }, duration);
            });
        }

        function hideWord($word) {
            var nextWord = takeNext($word);

            if($word.parents('.cd-headline').hasClass('type')) {
                var parentSpan = $word.parent('.cd-words-wrapper');
                parentSpan.addClass('selected').removeClass('waiting');	
                setTimeout(function(){ 
                    parentSpan.removeClass('selected'); 
                    $word.removeClass('is-visible').addClass('is-hidden').children('i').removeClass('in').addClass('out');
                }, selectionDuration);
                setTimeout(function(){ showWord(nextWord, typeLettersDelay) }, typeAnimationDelay);

            } else if($word.parents('.cd-headline').hasClass('letters')) {
                var bool = ($word.children('i').length >= nextWord.children('i').length) ? true : false;
                hideLetter($word.find('i').eq(0), $word, bool, lettersDelay);
                showLetter(nextWord.find('i').eq(0), nextWord, bool, lettersDelay);

            }  else if($word.parents('.cd-headline').hasClass('clip')) {
                $word.parents('.cd-words-wrapper').animate({ width : '2px' }, revealDuration, function(){
                    switchWord($word, nextWord);
                    showWord(nextWord);
                });

            } else if ($word.parents('.cd-headline').hasClass('loading-bar')){
                $word.parents('.cd-words-wrapper').removeClass('is-loading');
                switchWord($word, nextWord);
                setTimeout(function(){ hideWord(nextWord) }, barAnimationDelay);
                setTimeout(function(){ $word.parents('.cd-words-wrapper').addClass('is-loading') }, barWaiting);

            } else {
                switchWord($word, nextWord);
                setTimeout(function(){ hideWord(nextWord) }, animationDelay);
            }
        }

        function showWord($word, $duration) {
            if($word.parents('.cd-headline').hasClass('type')) {
                showLetter($word.find('i').eq(0), $word, false, $duration);
                $word.addClass('is-visible').removeClass('is-hidden');

            }  else if($word.parents('.cd-headline').hasClass('clip')) {
                $word.parents('.cd-words-wrapper').animate({ 'width' : $word.width() + 10 }, revealDuration, function(){ 
                    setTimeout(function(){ hideWord($word) }, revealAnimationDelay); 
                });
            }
        }

        function hideLetter($letter, $word, $bool, $duration) {
            $letter.removeClass('in').addClass('out');

            if(!$letter.is(':last-child')) {
                setTimeout(function(){ hideLetter($letter.next(), $word, $bool, $duration); }, $duration);  
            } else if($bool) { 
                setTimeout(function(){ hideWord(takeNext($word)) }, animationDelay);
            }

            if($letter.is(':last-child') && $('html').hasClass('no-csstransitions')) {
                var nextWord = takeNext($word);
                switchWord($word, nextWord);
            } 
        }

        function showLetter($letter, $word, $bool, $duration) {
            $letter.addClass('in').removeClass('out');

            if(!$letter.is(':last-child')) { 
                setTimeout(function(){ showLetter($letter.next(), $word, $bool, $duration); }, $duration); 
            } else { 
                if($word.parents('.cd-headline').hasClass('type')) { setTimeout(function(){ $word.parents('.cd-words-wrapper').addClass('waiting'); }, 200);}
                if(!$bool) { setTimeout(function(){ hideWord($word) }, animationDelay) }
            }
        }

        function takeNext($word) {
            return (!$word.is(':last-child')) ? $word.next() : $word.parent().children().eq(0);
        }

        function takePrev($word) {
            return (!$word.is(':first-child')) ? $word.prev() : $word.parent().children().last();
        }

        function switchWord($oldWord, $newWord) {
            $oldWord.removeClass('is-visible').addClass('is-hidden');
            $newWord.removeClass('is-hidden').addClass('is-visible');
        }
    
    }
    
    /**
     * Resize heading text based on screen size
     *
     * @since 1.0
     */
    DINE.gallery_heading_resize = function() {
    
        var run = debounce( function() {
            $( '.vc_custom_heading' ).each(function() {

                var heading = $( this ),
                    size = parseInt( heading.css( 'font-size' ) );
                heading.data( 'size', size );

                if ( window.matchMedia( "(max-width:767px)" ).matches && size > 22 ) {

                    heading.css({
                        fontSize: size * .6 + 'px'
                    });

                } else {

                    heading.css({
                        fontSize: size + 'px'
                    });

                }

            });
        }, 100 );
        
        $(window).load(run);
        $(window).resize(run);
        
    }
    
    /**
     * Gallery Reposition
     *
     * @since 1.0
     */
    DINE.gallery_reposition = function() {
        
        $( '.dine-gallery' ).each(function() {
        
            var gallery = $( this ),
                w, 
                h;
            
            if ( gallery.hasClass( 'gallery-landscape' ) ) {
                w = 4; h = 3;
            } else if ( gallery.hasClass( 'gallery-square' ) || gallery.hasClass( 'gallery-metro' ) ) {
                w = 1; h = 1;
            } else if ( gallery.hasClass( 'gallery-portrait' ) ) {
                w = 4; h = 5;
            }
            
            gallery.find( '.dine-gallery-item' ).each(function() {

                var item = $( this ),
                    img = item.find( 'img' );
                
                item.imagesLoaded(function() {
                    
                    var imgW = img.outerWidth(),
                        imgH = img.outerHeight();
                    
                    if ( imgW > imgH * w/h ) {
                        img.css({
                            height: '100%',
                            width: 'auto',
                            maxWidth: 'none',
                            left: '50%',
                            '-webkit-transform': 'translateX(-50%)',
                            transform: 'translateX(-50%)',
                        });
                    } else if ( imgW < imgH * w/h ) {
                    
                        img.css({
                            top: '50%',
                            '-webkit-transform': 'translateY(-50%)',
                            transform: 'translateY(-50%)',
                        });
                    
                    }
                    
                    item.addClass( 'repositioned' );
                    
                });
                
            });
        
        });
        
    }
    
    /**
     * Google Map
     *
     * @dependency Google API
     *
     * @since 1.0
     */
    DINE.gmap = function() {
        
        var load_map = function( ele ) {
            
            // check if google exists
            if ( typeof( google ) ==='undefined' ) {
                console.error( 'Google API is not available.' );
                return;
            }
            
            var $this = ele;
            // check the ID
            var id = $this.attr('id');
            if ( ! id ) {
                id = 'gmap-' + Math.floor((Math.random() * 100) + 1);
                $this.attr('id',id);
            }
            
            var defaultOptions = {
                map_type: 'ROADMAP',
                lat: '40.678178',
                lng: '-73.944158',
                zoom: 16,
                scrollwheel: false,
                marker_image : null,
                style : 'subtle-grayscale',
            },
                args = $this.data( 'options' ),
                options = $.extend( defaultOptions, args );
            
            if ( ! options.lat || ! options.lng )
                return;
            
            if ( options.zoom ) options.zoom = parseInt( options.zoom );
            
            if ( 'SATELLITE' != options.map_type && 'HYBRID' != options.map_type && 'TERRAIN' != options.map_type ) {
                options.map_type = 'ROADMAP';
            }
            
            // variables
            var map_pos = new google.maps.LatLng( options.lat, options.lng ),
                map_args = $this.data( 'map_args' );
            
            map_args = $.extend({
                mapTypeId	:	google.maps.MapTypeId[options.map_type],
                center		:	map_pos,
                zoom		:	options.zoom,
                scrollwheel	:	options.scrollwheel,
                
                zoomControl : false,
                mapTypeControl : false,
                scaleControl : false,
                streetViewControl : false,
                rotateControl : false,
                fullscreenControl : false,
            }, map_args ); // map_args

            // map styles
            var map_styles = {};
			//http://snazzymaps.com/style/15/subtle-grayscale
			map_styles['light'] = [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}];
            
            map_styles[ 'dark' ] = [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]
			
            map_styles[ 'light-grey-blue' ] = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#dde6e8"},{"visibility":"on"}]}]
			
            if ( 'none' != options.style ) {
                if ( 'undefined' !== typeof map_styles[ options.style ] ) {
                    map_args['styles'] = map_styles[ options.style ];
                }
            }

            var gmap = new google.maps.Map(document.getElementById(id), map_args);
            
            google.maps.event.addListenerOnce( gmap, 'tilesloaded', function() {
                
                // set marker
                var marker_args = {
                    position: map_pos,
                    map: gmap,
                    visible: false,
                    infoWindowIndex : 1,
                    optimized: false,
                    };
                
                if ( options.marker_image ) {
                    var marker_img = new google.maps.MarkerImage( 
                        options.marker_image, 
                        null,
                        null,
                        null,
                        null
                    );
                    marker_args[ 'icon' ] = options.marker_image;
                }
                
                var marker = new google.maps.Marker( marker_args );

                setTimeout(function(){
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    marker.setOptions({ visible: true });
                    setTimeout(function(){marker.setAnimation(null);},500);
                }, 200 );
                
            }); // tilesLoaded

        } // load_map function
        
        $( '.dine-gmap' ).each(function() {
            
            var $this = $( this );
            
            $this.bind( 'inview', function(event, isInView, visiblePartX, visiblePartY) {

                if (isInView) {

                    setTimeout(function() {

                        if ( !$this.data( 'loaded' ) ) {

                            $this.data( 'loaded',true );
                            load_map( $this );

                        }

                    }, 300 );

                } // inview

            });
            
        });
    
    }
    
    /**
     * Counter JS
     *
     * @since 1.0
     */
    DINE.counter = function() {
        
        function counter( ele, number ) {

            if ( typeof(ele)!='object' ) return;

            ele.find('.counter-number')
            .empty()
            .css({
                opacity: 1,
            });

            if ( !number ) number = 0;
            var number = number.toString();
            var numArray = number.split("");

            for(var i=0; i<numArray.length; i++) { 
                numArray[i] = parseInt(numArray[i], 10);
                ele.find('.counter-number').append('<span class="digit-con"><span class="digit'+i+'">0<br>1<br>2<br>3<br>4<br>5<br>6<br>7<br>8<br>9<br></span></span>');	
            }

            var increment = ele.find('.digit-con').outerHeight();
            var speed = 1200;

            for(var i=0; i<numArray.length; i++) {
                ele.find('.digit'+i).animate({top: -(increment * numArray[i])}, speed, 'easeOutQuint' );
            }

            ele.find(".digit-con:nth-last-child(3n+4)").after("<span class='comma'>,</a>");
            
            ele.data( 'counter-trigger', true );

            $(window).resize(function(){
                
                counter( ele, number );
                
            });

        }
        
        $( '.dine-counters' ).each(function() {
        
            var $this = $( this );
            
            $this.find( '.dine-counter' ).each(function( i ) {
                
                var ele = $( this ),
                    delay = i * 150,
                    number = parseInt ( ele.data( 'number' ) );
            
                if ( ! isNaN( number ) ) {

                    ele.dine_waypoint(function() {

                        if ( ! ele.data( 'counter-trigger' ) ) {

                            setTimeout(function() {
                                counter( ele, number );
                            }, delay );

                        }

                    }, { offset: '85%' } );

                } // isNaN(number)
                
            }); // .dine-counter
        
        });
    
    }
    
    /**
     * Init Core
     */
    DINE.coreInit();
    
})( window, jQuery );