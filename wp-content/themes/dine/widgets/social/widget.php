<?php
extract( $args );
extract( wp_parse_args( $instance, array(
    'title' => '',
    'align' => '',
) ) );
echo $before_widget;

$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
if ( !empty( $title ) ) {	
    echo $before_title . $title . $after_title;
}
?>

<div class="widget-social">

    <ul class="social-list">
        
        <?php
        foreach ( dine_social_array() as $id => $icondata ) {
        
            $url = isset( ${"$id"} ) ? ${"$id"} : '';
            $url = trim( $url );
            if ( ! $url ) continue;

            $class = 'fa fa-' . $icondata['icon'];

            if ( 'email' === $id ) {
                $url = str_replace( 'mailto:', '', $url );
                $url = "mailto:{$url}";
                $target = '_self';
            }
            ?>

            <li class="<?php esc_attr( "li-{$id}" ); ?>">
                <a href="<?php echo esc_url( $url ); ?>" target="_blank" title="<?php echo esc_attr( $icondata[ 'name' ] ); ?>">
                    <i class="<?php echo esc_attr( $class ); ?>"></i>

                </a>

            </li>

        <?php

        }
        ?>
    
    </ul>

</div><!-- .widget-social -->

<?php echo $after_widget;