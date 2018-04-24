<?php
if ( ! function_exists( 'dine_word_substr' ) ) :
/**
 * Same as PHP substr but word-base
 *
 * @since 1.0
 */
function dine_word_substr( $str, $start = 0, $length = -1 ) {
    
    $chunks = explode( ' ', $str );
    $chunks = array_slice( $chunks, $start, $length );
    
    return join( ' ', $chunks );
}
endif;

if ( !function_exists('dine_allowed_html') ) :
/**
 * Allowed HTML tags for wp_kses function
 *
 * @since 1.0
 */
function dine_allowed_html(){
    return array(
        'a' => array(
            'href' => array(),
            'title' => array(),
            'target' => array(),
            'class' => array(),
            'onclick' => array(),
            'rel' => array(),
            'nofollow' => array(),
        ),
        'br' => array(),
        'em' => array(
            'class' => array(),
            'title' => array(),
        ),
        'strong' => array(
            'class' => array(),
            'title' => array(),
        ),
        'span' => array(
            'class' => array(),
            'title' => array(),
        ),
        'i' => array(
            'class' => array(),
            'title' => array(),
        ),
        'b' => array(
            'class' => array(),
            'title' => array(),
        ),
        'hr' => array(
            'class' => array(),
            'title' => array(),
        ),
        'ul' => array(
            'class' => array(),
            'title' => array(),
        ),
        'ol' => array(
            'class' => array(),
            'title' => array(),
        ),
        'li' => array(
            'class' => array(),
            'title' => array(),
        ),
        'img' => array(
            'src' => array(),
            'title' => array(),
            'class' => array(),
            'width' => array(),
            'height' => array(),
        ),
    );   
}
endif;

if ( ! function_exists( 'dine_get_instagram_photos' ) ) :
/**
 * retrieve instagram photos
 *
 * @since 1.0
 */
function dine_get_instagram_photos( $username, $number, $cache_time ) {

    /**
     * Get Instagram Photos
     */
    $username = trim( $username );
    $number = absint( $number );
    $cache_time = absint( $cache_time );

    if ( ! $username ) return;

    if ( $number < 1 || $number > 12 ) $number = 6;

    if ( false === ( $instagram = get_transient( 'dine-instagram-' . sanitize_title_with_dashes( $username . '-' . $number ) ) ) ) {

        $url = esc_url( 'http://instagram.com/' . trim( $username ) );
        
        $remote = wp_remote_get( $url, array(
            'decompress' => false,
        ) );

        if ( is_wp_error( $remote ) )
            return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'dine' ) );

        if ( 200 != wp_remote_retrieve_response_code( $remote ) )
            return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'dine' ) );

        $shards = explode( 'window._sharedData = ', $remote['body'] );
        $insta_json = explode( ';</script>', $shards[1] );
        $insta_array = json_decode( $insta_json[0], TRUE );
        
        if ( ! $insta_array )
            return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'dine' ) );

        if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
            $images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
        } else {
            return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'dine' ) );
        }

        if ( ! is_array( $images ) )
            return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'dine' ) );

        $instagram = array();

        foreach ( $images as $image ) {
            
            $image['thumbnail_src'] = preg_replace( '/^https?\:/i', '', $image['thumbnail_src'] );
            $image['display_src'] = preg_replace( '/^https?\:/i', '', $image['display_src'] );
            
            // handle both types of CDN url
            if ( ( strpos( $image['thumbnail_src'], 's640x640' ) !== false ) ) {
                $image['thumbnail'] = str_replace( 's640x640', 's160x160', $image['thumbnail_src'] );
                $image['small'] = str_replace( 's640x640', 's320x320', $image['thumbnail_src'] );
            } else {
                $urlparts = wp_parse_url( $image['thumbnail_src'] );
                $pathparts = explode( '/', $urlparts['path'] );
                array_splice( $pathparts, 3, 0, array( 's160x160' ) );
                $image['thumbnail'] = '//' . $urlparts['host'] . implode( '/', $pathparts );
                $pathparts[3] = 's320x320';
                $image['small'] = '//' . $urlparts['host'] . implode( '/', $pathparts );
            }

            $image['large'] = $image['thumbnail_src'];

            if ( $image['is_video'] == true ) {
                $type = 'video';
            } else {
                $type = 'image';
            }

            $caption = '';
            if ( ! empty( $image['caption'] ) ) {
                $caption = $image['caption'];
            }

            $return = array(
                'description'   => $caption,
                'link'		  	=> trailingslashit( '//instagram.com/p/' . $image['code'] ),
                'time'		  	=> $image['date'],
                'comments'	  	=> $image['comments']['count'],
                'likes'		 	=> $image['likes']['count'],
                'thumbnail'	 	=> $image['thumbnail'],
                'medium'        => $image['small'],
                'large'			=> $image['large'],
                'original'      => $image['display_src'],
                'type'		  	=> $type
            );
            
            $instagram[] = $return;

        }

        // do not set an empty transient - should help catch private or empty accounts
        if ( ! empty( $instagram ) ) {
            set_transient( 'dine-instagram-'.sanitize_title_with_dashes( $username . '-' . $number ), $instagram, $cache_time );
        }
    }

    if ( ! empty( $instagram ) ) {

        return array_slice( $instagram, 0, $number );

    } else {

        return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'dine' ) );

    }

}
endif;

if ( ! function_exists( 'dine_get_video_thumbnail' ) ) :
/**
 * returns video url of youtube/vimeo video and store it by transient
 *
 * @since 1.0
 */
function dine_get_video_thumbnail( $video_url = '' ) {
    
    if ( ! $video_url ) return;
    
    if ( false === ( $video_thumbnail_url = get_transient( 'dine-video-thumbnail-' . sanitize_title_with_dashes( $video_url ) ) ) ) {
    
        // check the embed case
        if ( stripos($video_url,'<' . 'iframe') > -1) {
            preg_match('/src="([^"]+)"/', $video_url, $match);
            $video_url = $match[1];
            $video_url = preg_replace('/\?.*/', '', $video_url);
        }

        // Props to @rzen for lending his massive brain smarts to help with the regex
        $do_video_thumbnail = (
            preg_match( '/\/\/(www\.)?youtube\.com\/(watch|embed)\/?(\?v=)?([a-zA-Z0-9\-\_]+)/', $video_url, $youtube_matches ) ||
                    preg_match( '#https?://(.+\.)?vimeo\.com/.*#i', $video_url, $vimeo_matches )
        );

        if ( ! $do_video_thumbnail ) {
            return false;
        }

        $youtube_id = ! empty( $youtube_matches ) ? $youtube_matches[4] : '';
        $vimeo_id = ! empty( $vimeo_matches ) ? preg_replace( "/[^0-9]/", "", $vimeo_matches[0] ) : '';

        if ( $youtube_id ) {
            // Check to see if our max-res image exists
            $file_headers = get_headers( 'http://img.youtube.com/vi/' . $youtube_id . '/maxresdefault.jpg' );
            $video_thumbnail_url = $file_headers[0] !== 'HTTP/1.0 404 Not Found' ? 'http://img.youtube.com/vi/' . $youtube_id . '/maxresdefault.jpg' : 'http://img.youtube.com/vi/' . $youtube_id . '/hqdefault.jpg';

        } elseif ( $vimeo_id ) {

            $vimeo_data = wp_remote_get( 'http://www.vimeo.com/api/v2/video/' . intval( $vimeo_id ) . '.php' );
            if ( isset( $vimeo_data['response']['code'] ) && '200' == $vimeo_data['response']['code'] ){
                $response = unserialize( $vimeo_data['body'] );
                $video_thumbnail_url = isset( $response[0]['thumbnail_large'] ) ? $response[0]['thumbnail_large'] : false;
            }
            $video_thumbnail_url_1280 = str_replace( '_640', '_1280', $video_thumbnail_url );

            if ( $video_thumbnail_url_1280 ) {
                // Check to see if 1280px image exists
                $file_headers = get_headers( $video_thumbnail_url_1280 );
                if ( $file_headers[0] !== 'HTTP/1.0 404 Not Found' ) $video_thumbnail_url = $video_thumbnail_url_1280;
            }
        }
        
        // do not set an empty transient - should help catch private or empty accounts
        if ( ! empty( $video_thumbnail_url ) ) {
            set_transient( 'dine-video-thumbnail-'.sanitize_title_with_dashes( $video_url ), $video_thumbnail_url, WEEK_IN_SECONDS );
        }
        
    }
    
    return $video_thumbnail_url;
    
}
endif;

if ( ! function_exists( 'dine_checkbox_option' ) ) :
/**
 * Get multicheckbox options while values are separated by commas.
 *
 * @since 1.0
 */
function dine_checkbox_option( $option_id, $default = null ) {
    if ( null === $default ) {
        $return = trim( get_option( $option_id ) );
    } else {
        $return = trim( get_option( $option_id, $default ) );
    }
    $return = explode( ',' , $return );
    $return = array_map( 'trim', $return );
    return $return;
}
endif;

if ( ! function_exists( 'dine_border_style' ) ):
/**
 * Border Style
 *
 * @since 1.0
 */
function dine_border_style() {
    return array(
        'none' => esc_html__( 'None', 'dine' ),
        'solid' => esc_html__( 'Solid', 'dine' ),
        'dotted' => esc_html__( 'Dotted', 'dine' ),
        'dashed' => esc_html__( 'Dashed', 'dine' ),
        'double' => esc_html__( 'Double', 'dine' ),
    );
}
endif;

if ( ! function_exists( 'dine_background_size' ) ):
/**
 * Background Size
 *
 * @since 1.0
 */
function dine_background_size() {
    return array(
        'cover' => esc_html__( 'Cover', 'dine' ),
        'contain' => esc_html__( 'Contain', 'dine' ),
        '100% auto' => esc_html__( '100% Width', 'dine' ),
        'auto 100%' => esc_html__( '100% Height', 'dine' ),
        'auto' => esc_html__( 'Auto', 'dine' ),
    );
}
endif;

if ( ! function_exists( 'dine_background_position' ) ):
/**
 * Background Position
 *
 * @since 1.0
 */
function dine_background_position() {
    return array(
        'left top' => esc_html__( 'Left Top', 'dine' ),
        'center top' => esc_html__( 'Center Top', 'dine' ),
        'right top' => esc_html__( 'Right Top', 'dine' ),
        
        'left center' => esc_html__( 'Left Middle', 'dine' ),
        'center center' => esc_html__( 'Center Middle', 'dine' ),
        'right center' => esc_html__( 'Right Middle', 'dine' ),
        
        'left bottom' => esc_html__( 'Left Bottom', 'dine' ),
        'center bottom' => esc_html__( 'Center Bottom', 'dine' ),
        'right bottom' => esc_html__( 'Right Bottom', 'dine' ),
    );
}
endif;

if ( ! function_exists( 'dine_background_repeat' ) ):
/**
 * Background Repeat
 *
 * @since 1.0
 */
function dine_background_repeat() {
    return array(
        'no-repeat' => esc_html__( 'No Repeat', 'dine' ),
        'repeat' => esc_html__( 'Repeat', 'dine' ),
        'repeat-x' => esc_html__( 'Repeat X', 'dine' ),
        'repeat-y' => esc_html__( 'Repeat Y', 'dine' ),
    );
}
endif;

if ( ! function_exists( 'dine_background_attachment' ) ):
/**
 * Background Attachment
 *
 * @since 1.0
 */
function dine_background_attachment() {
    return array(
        'scroll' => esc_html__( 'Scroll', 'dine' ),
        'fixed' => esc_html__( 'Fixed', 'dine' ),
    );
}
endif;

if ( ! function_exists( 'dine_pageid' ) ) :
/**
 * Normally get post id returns current singular id but it doesn't apply for blog posts page
 *
 * This function covers that case
 *
 * @since 1.0
 */
function dine_pageid() {
    
    if ( is_singular() ) {
    
        return get_the_ID();
        
    } elseif ( is_home() && get_option( 'show_on_front' ) == 'page' ) {
        
        return get_option( 'page_for_posts' );
    
    }
    
    return apply_filters( 'dine_pageid', false );

}
endif;

if ( ! function_exists( 'dine_heading_selector' )  ) :
/**
 *
 */
function dine_heading_selector() {
    
    return '.woocommerce ul.cart_list li a, .woocommerce ul.product_list_widget li a, .woocommerce .widget_layered_nav ul li span, .woocommerce span.onsale, .woocommerce ul.products li.product .onsale, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce a.added_to_cart, .woocommerce nav.woocommerce-pagination ul, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .woocommerce #reviews #comments ol.commentlist li .comment-text p.meta strong[itemprop="author"], .woocommerce table.shop_table th, .woocommerce table.shop_table td.product-name a, .woocommerce-MyAccount-navigation ul a, h1, h2, h3, h4, h5, h6, th, input[type="color"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="password"], input[type="search"], input[type="tel"], input[type="text"], input[type="time"], input[type="url"], input[type="week"], input:not([type]), textarea, button, input[type="button"], input[type="reset"], input[type="submit"], .dine-btn, .dine-nice-select a, .text-logo, #navbar, .header-cta a, .entry-meta, a.more-link, .entry-tags, .dine-pagination, .page-links, .comment-meta .comment-author .fn, .reply, #respond p label, .widget_archive ul a:not(.url), .widget_categories ul a:not(.url), .widget_nav_menu ul a:not(.url), .widget_meta ul a:not(.url), .widget_pages ul a:not(.url), .widget_recent_entries ul a:not(.url), .widget_recent_comments ul a:not(.url), .widget_product_categories ul a:not(.url), .widget_layered_nav ul a:not(.url), .tagcloud, #footernav, #scrollup, body .rtb-booking-form fieldset > legend, body .picker__header, body .picker__weekday, body .picker__day, body .picker__list, #offcanvas .topbar-text, .offcanvas-nav .menu > ul, .counter-number, .dine-list, .menu-item-price, #ui-datepicker-div .ui-widget-header, .testimonial-content';

}
endif;