/**
 * @since 1.0
 */
( function( $, api ) {
    
    var css = {};
        
    // MULTICHECKBOX
    // ========================
	api.controlConstructor.multicheckbox = api.Control.extend({
		ready: function() {
            var control = this,
                hidden = this.container.find( '.checkbox-result' ),
				inputs = this.container.find( 'input[type="checkbox"]' ),
                values = control.setting();
            
            if ( 'string' === typeof values ) values = values.split( ',' );
            
            inputs.each(function(){
                var checked = values.indexOf( $(this).attr( 'value' ) ) > -1;
                $( this ).prop( 'checked', checked );
            });
            
            // set deafult
            if ( 'string' !== typeof values ) values = values.join( ',' );
            hidden.val( values );
            
            // input changes
            inputs.change(function(){
                
                var checkbox_values = control.container.find( 'input[type="checkbox"]:checked' ).map(
                    function(){
                        return this.value;
                    }
                ).get().join( ',' );
                
                control.setting.set( checkbox_values );
                
            });
            
		}
	});
    
    // IMAGE RADIO
    // ========================
    api.controlConstructor.image_radio = api.Control.extend( {
        
        ready: function() {
            var control = this,
                container = this.container,
                params = this.params,
                type = params.type,
                input;
            
            input = container.find( 'input[type="radio"]' );
            input.filter('[value=\'' + control.setting() + '\']').prop( 'checked', true );

            input.on( 'change', function() {
                var value = container.find( 'input[type="radio"]:checked' ).val();
                control.setting.set( value );
            });

            // when setting changes
            this.setting.bind( function ( value ) {

                input.filter('[value=\'' + value + '\']').prop( 'checked', true );

            });
		}
        
    });
    
    // SLIDE CONTROL
    // ========================
    if ( $().slider ) {
        api.controlConstructor.slide = api.Control.extend( {

            ready: function() {
                var control = this,
                    container = this.container,
                    params = this.params,
                    type = params.type,
                    input,
                    slider,
                    args;
                
                input = container.find( 'input.slide-input' );
                slider = container.find( '.slide-control' );
                
                args = {
                    value: control.setting(),
                    create: function() {
                        input.val( $( this ).slider( "value" ) );
                    },
                    slide: function( event, ui ) {
                        input.val( ui.value );
                        control.setting.set( ui.value );
                    },
                    change: function( event, ui ) {
                        input.val( ui.value );
                        control.setting.set( ui.value );
                    }
                }
                if ( params.max ) {
                    args.max = parseFloat( params.max );
                }
                if ( params.min ) {
                    args.min = parseFloat( params.min );
                }
                if ( params.step ) {
                    args.step = parseFloat( params.step );
                }

                input.on( 'change', function() {
                    
                    var val = parseFloat( input.val() );
                    if ( isNaN( val ) && params.std ) val = parseFloat( params.std );
                    
                    slider.slider( "value", val );
                    
                });
                
                slider.slider( args );

                // when setting changes
                this.setting.bind( function ( value ) {

                    slider.slider( "value", value );

                });
            }

        });
        
    }
    
    /**
     * Control Toggle shows & hides optons conditionally for better UX
     *
     * @since 1.0
     */ 
    window.control_toggle = function( id, option ) {
            
        // TOGGLE OPTIONS
        //
        // Take some examples to illustrate
        // option = dine_logo_type
        // toggle = { 'text': [ 'dine_logo_size', 'dine_logo_face'], 'image' : [ 'dine_logo_width', 'dine_logo_height' ] }
        
        api.control( id, function( control ) {
        
            // Ignore options with display none state
            // Or has no toggle
            if ( 'none' == control.container.css( 'display' ) || undefined === option.toggle )
                return;

            // id = dine_logo_type
            api( id, function( setting ) {

                // value = 'text'
                // elements = [ 'dine_logo_size', 'dine_logo_face' ]
                $.each( option.toggle, function( value, elements ) {

                    // elementID = dine_logo_size
                    // each element ID should appear only once
                    $.each( elements, function( j, elementID ) {

                        api.control( elementID, function( control ) {
                            // to = current setting
                            var visibility = function ( to ) {
                                
                                // true and 'true'
                                if ( true === to ) {
                                    to = '1';
                                } else if ( false === to ) {
                                    to = '0';
                                }

                                // Hide everything except elements in current value
                                var toggle_Bool = ( to === value || ( undefined !== option.toggle[ to ] && option.toggle[ to ].indexOf( elementID ) > -1 ) );

                                var triggerEvent = toggle_Bool ? 'control_show' : 'control_hide';
                                
                                control.container
                                .toggle( toggle_Bool )
                                .trigger( triggerEvent );

                            };

                            visibility( setting.get() );

                            setting.bind( visibility );

                        }); // control

                    }); // each elements

                }); // option.toggle

            });

        }); // control

    } // funtion control_toggle
    
    /**
     * live CSS Update
     *
     * @since 1.0
     */
    window.liveCSS = function() {
        
        var cssdata = '';
        
        $.each(css, function( selector, cssComponents ) {
            
            cssdata += selector + '{';
                
            $.each( cssComponents, function( id, pair ) {
            
                // Check if this option is visible or not
                // It's pretty tricky, may we'll need better solution
                if ( $( '#customize-control-' + id ).css( 'display' ) == 'none' ) {
                    return;
                }
                
                cssdata += pair.property + ':' + pair.value + ';';
                
            });
            
            cssdata += '}';
            
        });
        
        api.previewer.send( 'update-dine-theme-style', cssdata );
        
    }
    
    /**
     * Live Preview and Conditionalize
     *
     * @since 1.0
     */
    api.bind( 'ready', function() {
        
        // Typekit Load Event
        var settings = api.settings.settings;
        
        // Update the CSS whenever a setting is changed.
        _.each( api.settings.controls, function( option ) {
            
            var id = option.settings.default,
                transport = 'undefined' != typeof settings[id] ? settings[id].transport : '',
                selector = option.selector,
                property = option.property;
            
            // We're only interested colors
            if ( 'postMessage' == transport && 'color' == option.type && selector && property ) {
                
                if ( undefined == css[ selector ] ) {
                    css[ selector ] = {}
                }
                
                css[ selector ][ id ] = {
                    property : property,
                    value : api( id )()
                }
                
                api( id, function( value ) {
                    value.bind( function( to ) {

                        css[ selector ][ id ].value = to;
                        liveCSS();

                    });
                    
                });
                
            }
            
            /**
             * Toggle options for a better UX
             *
             * @since 1.0
             */
            api.control( id, function( control ) {
                
                if ( ! option.toggle ) return;
                
                control.container.on( 'control_show', function() {
                    control_toggle( id, option );
                }); // on show
                
                control.container.on( 'control_hide', function() {
                    
                    // value: leftright
                    // elements: left_1, left_2, right_1, right_2
                    $.each( option.toggle, function( value, elements ) {
                        
                        // elementID: // left_1
                        $.each( elements, function( j, elementID ) {
                        
                            api.control( elementID, function( control2 ) {
                                
                                control2.container
                                .hide()
                                .trigger( 'control_hide' );

                            }); // control
                            
                        });
                        
                    }); // each
                    
                }); // on show
            
            });
            
        }); // each
        
        // trigger control_toggle onload
        _.each( api.settings.controls, function( option ) {
            
            var id = option.settings.default;
            control_toggle( id, option );
            
        }); // each
    
    } );
    
} )( jQuery, wp.customize );