<?php
/**
 * Google Map Addon for Visual Composer
 *
 * @since 1.0
 */
if ( ! class_exists( 'Dine_Gmap' ) ) :

class Dine_Gmap extends Dine_Shortcode
{
    
    public function __construct() {
        
        $this->path = DINE_FRAMEWORK_PATH . 'addons/gmap/';
        $this->args = array(
            'base'      => 'gmap',
            'name'      => esc_html__( 'Google Map', 'dine' ),
            'desc'      => esc_html__( 'Displays Google Map', 'dine' ),
            'weight'    => 190,
        );
        
    }
    
    function param_list() {
    
        return 'address, height, controls, map_type, zoom, scrollwheel, style, marker, css';
        
    }
    
    function get_lat_lng( $address = '' ) {
    
        $address = trim( $address );
        if ( ! $address ) return array();
        
        $dash = sanitize_title_with_dashes( $address );
        $try_get_transient = get_transient( 'map-' . $dash );
        if ( false !== $try_get_transient ) return $try_get_transient;
        
        $apikey = trim( get_option( 'dine_google_maps_api_key' ) );
        if ( ! $apikey ) {
            return new WP_Error( 'noapi', esc_html__( 'Google Maps API Key is required!', 'dine' ) );
        }
        
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$apikey;
        
        $remote = wp_remote_get( $url, array( 'decompress' => false ) );
        
        if ( is_wp_error( $remote ) )
            return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Google.', 'dine' ) );
        
        if ( 200 != wp_remote_retrieve_response_code( $remote ) )
            return new WP_Error( 'invalid_response', esc_html__( 'Google did not return a 200.', 'dine' ) );
        
        $json = json_decode( $remote[ 'body' ], true );
        
        if ( ! $json )
            return new WP_Error( 'bad_json', esc_html__( 'Google Map API has returned invalid data.', 'dine' ) );
        
        if ( ! $json[ 'results' ] ) return;
        
        $lat = $json['results'][0]['geometry']['location']['lat'];
        $lng = $json['results'][0]['geometry']['location']['lng'];

        $return = array ( 'lat' => $lat, 'lng' => $lng );

        if ( $lat && $lng ) {
            set_transient( 'map-' . $dash, $return, HOUR_IN_SECONDS * 2 );
        }

        return $return;
        
    }
    
}

$instance = new Dine_Gmap();
$instance->init();

endif;