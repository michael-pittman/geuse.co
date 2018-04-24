/**
 * global DINE_ADMIN
 *
 * @since 1.0
 */
(function( window, DINE_ADMIN, $ ) {
"use strict";
    
    // cache element to hold reusable elements
    DINE_ADMIN.cache = {
        $document : {},
        $window   : {}
    }
    
    // Create cross browser requestAnimationFrame method:
    window.requestAnimationFrame = window.requestAnimationFrame
    || window.mozRequestAnimationFrame
    || window.webkitRequestAnimationFrame
    || window.msRequestAnimationFrame
    || function(f){setTimeout(f, 1000/60)}
    
    /**
     * Init functions
     *
     * @since 1.0
     */
    DINE_ADMIN.init = function() {
        
        /**
         * cache elements for faster access
         *
         * @since 1.0
         */
        DINE_ADMIN.cache.$document = $(document);
        DINE_ADMIN.cache.$window = $(window);
        
        DINE_ADMIN.cache.$document.ready(function() {
        
            DINE_ADMIN.reInit();
            
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
    DINE_ADMIN.reInit = function() {
        
        // Conditional Metabox
        DINE_ADMIN.conditionalMetabox();
        
        // File Upload
        DINE_ADMIN.fileUpload();
     
        // image Upload
        DINE_ADMIN.imageUpload();
        
        // multiple-image Upload
        DINE_ADMIN.imagesUpload();
        
        // tab
        DINE_ADMIN.tab();
        
    }
    
    // Conditional metabox
    // ========================
    DINE_ADMIN.conditionalMetabox = function() {
        
        // lib required
        if ( ! $().metabox_conditionize ) {
            return;
        }
    
        $( '.dine-metabox-field[data-cond-option]' ).metabox_conditionize();
        
    }
    
    // Thickbox File Upload
    // ========================
    DINE_ADMIN.fileUpload = function() {
        
        var mediaUploader
    
        // Append Image Action
        DINE_ADMIN.cache.$document.on( 'click', '.upload-file-button', function( e ) {
            
            e.preventDefault();
            
            var button = $( this ),
                uploadWrapper = button.closest( '.dine-upload-wrapper' ),
                type = uploadWrapper.data( 'type' ),
                holder = uploadWrapper.find( '.file-holder' ),
                input = uploadWrapper.find( '.media-result' ),
                args = {
                    title: DINE_ADMIN.l10n.choose_file,
                    button: {
                        text: DINE_ADMIN.l10n.choose_file,
                    }, 
                    multiple: false,
                }
            
            if ( type ) {
                args.library = {
                    type: type,
                }
            }
            
            // Extend the wp.media object
            mediaUploader = wp.media.frames.file_frame = wp.media(args);

            // When a file is selected, grab the URL and set it as the text field's value
            mediaUploader.on( 'select', function() {
                
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                
                // set value
                input.val(attachment.id);
                
                // show the holder
                holder.addClass( 'has-file' );
                
                // change button text
                button.val( DINE_ADMIN.l10n.change_file );
                
            });
            // Open the uploader dialog
            mediaUploader.open();
        
        });
        
        // Remove Image Action
        DINE_ADMIN.cache.$document.on( 'click', '.remove-file-button', function( e ) {
            
            e.preventDefault();
            
            var remove = $( this ),
                uploadWrapper = remove.closest( '.dine-upload-wrapper' ),
                holder = uploadWrapper.find( '.file-holder' ),
                input = uploadWrapper.find( '.media-result' ),
                button = uploadWrapper.find( '.upload-file-button' );
            
            input.val('');
            holder.removeClass( 'has-file' );
            button.val( DINE_ADMIN.l10n.upload_file );
            
        });
    
    }
    
    // Thickbox Image Upload
    // ========================
    DINE_ADMIN.imageUpload = function() {
        
        var mediaUploader
    
        // Append Image Action
        DINE_ADMIN.cache.$document.on( 'click', '.upload-image-button', function( e ) {
            
            e.preventDefault();
            
            var button = $( this ),
                uploadWrapper = button.closest( '.dine-upload-wrapper' ),
                holder = uploadWrapper.find( '.image-holder' ),
                input = uploadWrapper.find( '.media-result' );
            
            // Extend the wp.media object
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: DINE_ADMIN.l10n.choose_image,
                button: {
                    text: DINE_ADMIN.l10n.choose_image,
                }, 
                multiple: false,
                library : {
                    type : 'image',
                    // HERE IS THE MAGIC. Set your own post ID var
                    // uploadedTo : wp.media.view.settings.post.id
                },
            });

            // When a file is selected, grab the URL and set it as the text field's value
            mediaUploader.on('select', function() {
                
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                
                if ( attachment.type == 'image' ) {

                    input.val(attachment.id);
                    holder.find('img').remove();
                    if ( attachment.sizes.medium ) {
                        holder.prepend( '<img src="' + attachment.sizes.medium.url + '" />' );
                    } else {
                        holder.prepend( '<img src="' + attachment.url + '" />' );
                    }
                    
                    button.val( DINE_ADMIN.l10n.change_image );
                    
                }

            });
            // Open the uploader dialog
            mediaUploader.open();
        
        });
        
        // Remove Image Action
        DINE_ADMIN.cache.$document.on( 'click', '.remove-image-button', function( e ) {
            
            e.preventDefault();
            
            var remove = $( this ),
                uploadWrapper = remove.closest( '.dine-upload-wrapper' ),
                holder = uploadWrapper.find( '.image-holder' ),
                input = uploadWrapper.find( '.media-result' ),
                button = uploadWrapper.find( '.upload-image-button' );
            
            input.val('');
            holder.find( 'img' ).remove();
            button.val( DINE_ADMIN.l10n.upload_image );
            
        });
    
    }
    
    // Upload Multiplage Images
    // ========================
    DINE_ADMIN.imagesUpload = function() {
        
        var mediaUploader,
        
            sortableCall = function() {
            
                // sortable required
                if ( !$().sortable ) {
                    return;
                }

                $( '.images-holder' ).each(function() {

                    var $this = $( this );
                    $this.sortable({

                        placeholder: 'image-unit-placeholder', 

                        update: function(event, ui) {

                            // trigger event changed
                            var uploadWrapper = $this.closest( '.dine-upload-wrapper' );
                            uploadWrapper.trigger( 'changed' );

                        }

                    }); // sortable

                    $this.disableSelection();

                });

            },
            
            refine = function() {
            
                var uploadWrapper = $( this ),
                    holder = uploadWrapper.find( '.images-holder' ),
                    input = uploadWrapper.find( '.media-result' ),
                    id_string = [];

                // not images type
                if ( !holder.length ) {
                    return;
                }

                // otherwise, we rearrange everythings
                holder.find( '.image-unit' ).each(function() {

                    var unit = $( this ),
                        id = unit.data( 'id' );

                    id_string.push( id );

                } );

                input.val( id_string.join() );
            
            }
        
        // call sortable
        sortableCall();
        
        // refine the input the get result
        $( '.dine-upload-wrapper' ).on( 'changed', refine );
    
        // Append Image Action
        DINE_ADMIN.cache.$document.on( 'click', '.upload-images-button', function( e ) {
            
            e.preventDefault();
            
            var button = $( this ),
                uploadWrapper = button.closest( '.dine-upload-wrapper' ),
                holder = uploadWrapper.find( '.images-holder' ),
                input = uploadWrapper.find( '.media-result' );
            
            // Extend the wp.media object
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: DINE_ADMIN.l10n.choose_images,
                button: {
                    text: DINE_ADMIN.l10n.choose_images,
                }, 
                multiple: true,
                library : {
                    type : 'image',
                    // HERE IS THE MAGIC. Set your own post ID var
                    // uploadedTo : wp.media.view.settings.post.id
                },
            });

            // When a file is selected, grab the URL and set it as the text field's value
            mediaUploader.on( 'select' , function() {
                
                var attachments = mediaUploader.state().get('selection').toJSON();
                
                var remaining_attachments = [],
                    existing_ids = [];
                if ( input.val() ) {
                    existing_ids = input.val().split(',');
                }

                // remove duplicated images
                for ( var i in attachments ) {
                    var attachment = attachments[i],
                        item = '';
                    if ( existing_ids.indexOf( attachment.id.toString() ) < 0 ) {
                        
                        item += '<figure class="image-unit" data-id="' + attachment.id + '">';
                        item += '<img src="' + attachment.sizes.thumbnail.url +'" />';
                        item += '<a href="#" class="remove-image-unit" title="' + DINE_ADMIN.l10n.remove_image + '">&times;</a>';
                        item += '</figure>';
                        holder.append( item );
                        
                    }
                }
                
                uploadWrapper.trigger( 'changed' );

            });
            
            // Open the uploader dialog
            mediaUploader.open();
        
        });
        
        // Remove Image Action
        DINE_ADMIN.cache.$document.on( 'click', '.remove-image-unit', function( e ) {
            
            e.preventDefault();
            
            var remove = $( this ),
                uploadWrapper = remove.closest( '.dine-upload-wrapper' ),
                item = remove.closest( '.image-unit' );

            item.remove();
            uploadWrapper.trigger( 'changed' );
            
        });
    
    }
    
    /**
     * Metabox Tabs
     */
    DINE_ADMIN.tab = function() {
        
        $( '.metabox-tabs' ).each(function() {
        
            var $this = $( this ),
                fields = $this.next( '.metabox-fields' );
            $this.find( 'a' ).click(function( e ) {
            
                var a = $( this),
                    href= a.data( 'href' );
                
                e.preventDefault();
                
                // active class
                $this.find( 'li' ).removeClass( 'active' );
                a.parent().addClass( 'active' );
                
                // Hide all
                fields.find( '.tab-content' ).hide();
                
                // Shows fields with attr href or no tab
                fields.find( '.tab-content[data-tab="' + href + '"]' ).show();
                fields.find( '.tab-content[data-tab=""]' ).show();
            
            });
            
            // Click to the first item
            $this.find( 'li:first-child' ).find( 'a' ).trigger( 'click' );
        
        });
    
    }
    
    DINE_ADMIN.init();
    
})( window, DINE_ADMIN, jQuery );

// Library Show Hide Conditional
// =================================================================

(function($) {
  $.fn.metabox_conditionize = function(options) {

    var settings = $.extend({
        hideJS : true,
        repeat : true,
    }, options );

    $.fn.eval = function(valueIs, valueShould, operator) {
      switch(operator) {
        case '==':
            return valueIs == valueShould;
            break;
        case '!=':
            return valueIs != valueShould;
            break;  
        case '<=':
            return valueIs <= valueShould;
            break;  
        case '<':
            return valueIs < valueShould;
            break;  
        case '>=':
            return valueIs >= valueShould;
            break;  
        case '>':
            return valueIs > valueShould;
            break;  
        case 'in':
            valueShould = valueShould.split( ',' );
            return ( typeof( valueShould ) == 'object' && $.inArray( valueIs, valueShould ) >= 0 ) ;
            break;
      }
    }
    
    $.fn.showOrHide = function(listenTo, listenFor, operator, $section) {
        
      if ($(listenTo).is('select, input[type=text]') && $.fn.eval($(listenTo).val(), listenFor, operator)) {
        $section.show(0,function(){$section.trigger('field_show');});
      }
      else if ($(listenTo + ":checked").filter(function(idx, elem){return $.fn.eval(elem.value, listenFor, operator);}).length > 0) {
          $section.show(0,function(){$section.trigger('field_show');});
      }
      else {
          $section.hide(0,function(){$(this).trigger('field_hide');});
      }
    }
    
    return this.each( function() {
      var listenTo = "[data-id=" + $(this).data('cond-option').replace( /(:|\.|\[|\]|,)/g, "\\$1" ) + "] .input-ele";
      var listenFor = $(this).data('cond-value');
      var operator = $(this).data('cond-operator') ? $(this).data('cond-operator') : '==';
      var $section = $(this);

      //Set up event listener
      $(listenTo).on('change', function() {
        $.fn.showOrHide(listenTo, listenFor, operator, $section);
      });
        
        // if process repeated
        if ( settings.repeat ) {
            $(listenTo).closest('.dine-metabox-field').on('field_show', function() {
                $section.show(0,function(){$section.trigger('field_show');});
                $.fn.showOrHide(listenTo, listenFor, operator, $section);
          });
            $(listenTo).closest('.dine-metabox-field').on('field_hide', function() {
            $section.hide(0,function(){$section.trigger('field_hide');});
          });
        }
        
      //If setting was chosen, hide everything first...
      if (settings.hideJS) {
        $(this).hide();
      }
      //Show based on current value on page load
      $.fn.showOrHide(listenTo, listenFor, operator, $section);
    });
  }
}(jQuery));