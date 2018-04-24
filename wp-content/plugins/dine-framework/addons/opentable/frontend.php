<?php
$am_options = array();
$pm_options = array();

for ( $i = 3; $i <= 5; $i++ ) {
    
    $am_options[ $i * 2 + 1 . ':00am' ] = $i * 2 + 1 . ':00 AM';
    $am_options[ $i * 2 + 1 . ':30am' ] = $i * 2 + 1 . ':30 AM';
    
//    $pm_options[ $i * 2 + 1 . ':00pm' ] = $i * 2 + 1 . ':00 PM';
//    $pm_options[ $i * 2 + 1 . ':30pm' ] = $i * 2 + 1 . ':30 PM';
    
}
for ( $i = 4; $i <= 5; $i++ ) {
    
    $am_options[ $i * 2 . ':00am' ] = $i * 2 . ':00 AM';
    $am_options[ $i * 2 . ':30am' ] = $i * 2 . ':30 AM';
    
}
for ( $i = 1; $i <= 12; $i++ ) {
    
    $pm_options[ $i . ':00pm' ] = $i . ':00 PM';
    $pm_options[ $i . ':30pm' ] = $i . ':30 PM';
    
}
asort( $am_options, SORT_NUMERIC );
asort( $pm_options, SORT_NUMERIC );

$pm_options = array( '12:00pm' => '12:00 PM', '12:30pm' => '12:30 PM' ) + $pm_options;

$time_options = $am_options + $pm_options;

$size_options = array( '1' => esc_html__( '1 person', 'dine' ) );
for ( $i = 2; $i <= 10; $i++ ) {
    $size_options[ strval( $i ) ] = sprintf( esc_html__( '%s persons', 'dine' ), $i );
}

$date_format = get_option( 'date_format' );
$options = array(
    // 'dateFormat' => $date_format,
);
?>
<div class="dine-opentable-wrapper">

    <?php if ( $title ) { ?>
    
    <div class="dine-opentable-header">
        
        <h2 class="dine-opentable-heading"><?php echo $title; ?></h2>

        <h3 class="dine-opentable-credits"><?php echo esc_html__( 'Powered by OpenTable' ); ?></h3>
        
    </div>
    
    <?php } ?>
    
    <form class="reservation-form" action="//www.opentable.com/restaurant-search.aspx" target="_blank">
        
        <div class="row">
            
            <div class="col col-1-3 col-size">
                
                <div class="dine-nice-select">
                    
                    <a href="#">2 persons</a>

                    <select name="partySize">

                        <?php foreach ( $size_options as $i => $label ) : ?>

                        <option value="<?php echo $i; ?>"<?php selected( $i, '2' ); ?>><?php echo $label; ?></option>

                        <?php endforeach; ?>

                    </select>
                    
                </div>
                
            </div>
            
            <div class="col col-1-3 col-date">
        
                <input class="dine-datepicker" type="text" value="<?php echo date( $date_format ); ?>" data-options='<?php echo json_encode( $options ); ?>' />
                
                <input type="hidden" name="startDate" value="<?php echo date( 'Y-m-d' ); ?>" />
                
            </div>
            
            <div class="col col-1-3 col-time">
                
                <div class="dine-nice-select">
                    
                    <a href="#">7:00 PM</a>
        
                    <select name="ResTime">

                        <?php foreach ( $time_options as $val => $label ) : ?>

                        <option value="<?php echo esc_attr( $val ); ?>"<?php selected( $val, '7:00pm' ); ?>><?php echo $label; ?></option>

                        <?php endforeach; ?>

                    </select>
                    
                </div>
                
            </div>
            
        </div><!-- .row -->
        
        <input type="hidden" name="RestaurantID" class="RestaurantID" value="<?php echo esc_attr( $id ); ?>">
        <input type="hidden" name="GeoID" class="GeoID" value="15">
        <input type="hidden" name="rid" value="<?php echo esc_attr( $id ); ?>" />
        <input type="hidden" name="txtDateFormat" class="txtDateFormat" value="yyyy-MM-dd">
        <input type="hidden" name="RestaurantReferralID" class="RestaurantReferralID" value="<?php echo esc_attr( $id ); ?>">
        
        <input type="submit" value="Submit" />
        
    </form>
    
</div>