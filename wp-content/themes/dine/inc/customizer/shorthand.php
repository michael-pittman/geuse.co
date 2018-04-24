<?php
/**
 * Shorthands
 * 
 * @since 1.0
 */

// font weights
if ( ! isset( $font_weights ) ) {
    for ( $i = 1; $i<=9; $i++ ) {
        $font_weights[ (string) ($i*100) ] = $i*100;
    }
}

// font list
if ( ! isset( $fontlist ) ) {
    $all_fonts = dine_google_fonts();
    foreach ( $all_fonts as $font => $fontdata ) {
        $fontlist[ $font ] = $font;
    }
}

if ( ! isset( $option[ 'shorthand' ] ) )
    return;
    
$shorthand = $option[ 'shorthand' ];

switch ( $shorthand ) {
    
    case 'truefalse' :
        $append = array(
            'type'      => 'select',
            'options'   => array(
                'true'  => esc_html__( 'Yes', 'dine' ),
                'false' => esc_html__( 'No', 'dine' ),
            ),
        );
    break;
    
    case 'enable' :
        $append = array(
            'type'      => 'radio',
            'options'   => array(
                'true'  => esc_html__( 'Enable', 'dine' ),
                'false' => esc_html__( 'Disable', 'dine' ),
            ),
            'std'       => 'true',
        );
    break;
    
    case 'target' :
        $append = array(
            'type'      => 'radio',
            'options'   => array(
                '_self'  => esc_html__( 'Same Tab', 'dine' ),
                '_blank' => esc_html__( 'New Tab', 'dine' ),
            ),
            'std' => '_self',
        );
    break;

    case 'color' :
        $append = array(
            'name'      => esc_html__( 'Color', 'dine' ),
            'type'      => 'color',
            'css'       => 'color',
            'transport' => 'postMessage',
        );
    break;

    /**
     * Background Color
     */
    case 'background-color' :
        $append = array(
            'name'      => esc_html__( 'Background', 'dine' ),
            'type'      => 'color',
            'css'   => 'background-color',
            'transport' => 'postMessage',
        );
    break;
    
    /**
     * Background Image
     */
    case 'background-image' :
        $append = array(
            'name'      => esc_html__( 'Background Image', 'dine' ),
            'type'      => 'image',
            'css'   => 'background-image',
        );
    break;
    
    /**
     * Background Size
     */
    case 'background-size' :
        $append = array(
            'name'      => esc_html__( 'Background Size', 'dine' ),
            'type'      => 'select',
            'options'   => dine_background_size(),
            'std'       => 'cover',
            'css'       => 'background-size',
        );
    break;
    
    /**
     * Background Position
     */
    case 'background-position' :
        $append = array(
            'name'      => esc_html__( 'Background Position', 'dine' ),
            'type'      => 'select',
            'options'   => dine_background_position(),
            'std'       => 'center center',
            'css'       => 'background-position',
        );
    break;
    
    /**
     * Background Repeat
     */
    case 'background-repeat' :
        $append = array(
            'name'      => esc_html__( 'Background Repeat', 'dine' ),
            'type'      => 'select',
            'options'   => dine_background_repeat(),
            'std'       => 'no-repeat',
            'css'       => 'background-repeat',
        );
    break;
    
    /**
     * Background Attachment
     */
    case 'background-attachment' :
        $append = array(
            'name'      => esc_html__( 'Background Attachment', 'dine' ),
            'type'      => 'select',
            'options'   => dine_background_attachment(),
            'std'       => 'scroll',
            'css'       => 'background-attachment',
        );
    break;
    
    /**
     * Border
     */
    case 'border' :
        $append = array(
            'name'      => esc_html__( 'Border', 'dine' ),
            'type'      => 'radio',
            'options'   => array(
                '0' => esc_html__( 'None', 'dine' ),
                '1px 0' => esc_html__( 'Top & Bottom', 'dine' ),
                '1px 0 0' => esc_html__( 'Only Top', 'dine' ),
                '0 0 1px' => esc_html__( 'Only Bottom', 'dine' ),
            ),
            'std'       => '0',
            'css'       => 'border-width',
        );
    break;
    
    /**
     * Border Color
     */
    case 'border-color' :
        $append = array(
            'name'      => esc_html__( 'Border Color', 'dine' ),
            'type'      => 'color',
            'css'   => 'border-color',
            'transport' => 'postMessage',
        );
    break;
    
    /**
     * Border Style
     */
    case 'border-style' :
        $append = array(
            'name'      => esc_html__( 'Border Style', 'dine' ),
            'type'      => 'select',
            'options'   => dine_border_style(),
            'std'       => 'none',
            'css'       => 'border-style',
        );
    break;
    
    /**
     * Border Width
     */
    case 'border-width' :
        $append = array(
            'name'      => esc_html__( 'Border Width', 'dine' ),
            'type'      => 'dine_text',
            'placeholder'=> 'Eg. 5px 0 0',
            'css'       => 'border-width',
        );
    break;
    
    /**
     * Border Width Slide Form
     */
    case 'border-width-slide' :
        $append = array(
            'name'      => esc_html__( 'Border Thickness', 'dine' ),
            'type'      => 'slide',
            'min'       => '0',
            'max'       => '10',
            'step'      => '1',
            'unit'      => 'px',
            'std'       => '1',
            'css'       => 'border-width',
        );
    break;
    
    /**
     * Border Radius
     */
    case 'border-radius' :
        $append = array(
            'name'      => esc_html__( 'Border Radius', 'dine' ),
            'type'      => 'dine_text',
            'placeholder'=> 'Eg. 3px',
            'css'       => 'border-radius',
        );
    break;
    
    /**
     * Border Radius Slide
     */
    case 'border-radius-slide' :
        $append = array(
            'name'      => esc_html__( 'Border Radius', 'dine' ),
            'type'      => 'slide',
            'std'       => '0',
            'min'       => '0',
            'max'       => '30',
            'step'      => '1',
            'unit'      => 'px',
            'css'       => 'border-radius',
        );
    break;
    
    /**
     * Border Radius Select
     */
    case 'border-radius-select' :
        $append = array(
            'name'      => esc_html__( 'Border Radius', 'dine' ),
            'type'      => 'select',
            'options'   => array(
                '0' => esc_html__( 'None', 'dine' ),
                '1px' => '1px',
                '2px' => '2px',
                '3px' => '3px',
                '4px' => '4px',
                '5px' => '5px',
                '6px' => '6px',
                '7px' => '7px',
                '8px' => '8px',
                '50%' => esc_html__( 'Round', 'dine' ),
            ),
            'std'       => '0',
            'css'       => 'border-radius',
        );
    break;

    /**
     * Alignment
     */
    case 'align' :
        $append = array(
            'name'      => esc_html__( 'Align', 'dine' ),
            'type'      => 'select',
            'options'   => array(
                'left'  => esc_html__( 'Left', 'dine' ),
                'center'  => esc_html__( 'Center', 'dine' ),
                'right'  => esc_html__( 'Right', 'dine' ),
            ),
            'std'       => 'center',
            'css'   => 'text-align',
        );
    break;

    /**
     * Box Shadow
     */
    case 'box-shadow' :
        $append = array (
            'name'      => esc_html__( 'Box Shadow', 'dine' ),
            'desc'      => esc_html__( 'You need CSS Knowledge to change this.', 'dine' ),
            'type'      => 'text',
            'placeholder'=> 'Eg. 1px 2px 6px rgba(0,0,0,.3)',
            'css'   => 'box-shadow',
        );
    break;

    /**
     * Transition
     */
    case 'transition' :

        $transition_arr = array (
            '0ms' => esc_html__( 'None', 'dine' ),
        );
        for ( $i = 1; $i <= 10; $i++ ) {
            $transition_arr[ (50*$i) . 'ms' ] = (50*$i) . 'ms';
        }

        $append = array (
            'type'      => 'select',
            'options'   => $transition_arr,
            'std'       => '0ms',
            'name'      => esc_html__( 'Transition', 'dine' ),
            'css'   => 'transition',
        );
    break;

    /**
     * PADDING
     */
    case 'padding' :
        $append = array (
            'name'      => esc_html__( 'Padding', 'dine' ),
            'type'      => 'slide',
            'std'       => '0',
            'min'       => '0',
            'max'       => '20',
            'step'      => '1',
            'type'      => 'slide',
            'css'       => 'padding',
            'unit'      => 'px',
        );
    break;
    
    /**
     * PADDING TOP
     */
    case 'padding-top' :
        $append = array (
            'name'      => esc_html__( 'Padding Top', 'dine' ),
            'type'      => 'slide',
            'css'       => 'padding-top',
            'unit'      => 'px',
            'min'       => '0',
            'max'       => '200',
            'step'      => '1',
        );
    break;
    
    /**
     * PADDING BOTTOM
     */
    case 'padding-bottom' :
        $append = array (
            'name'      => esc_html__( 'Padding Bottom', 'dine' ),
            'type'      => 'slide',
            'css'       => 'padding-bottom',
            'unit'      => 'px',
            'unit'      => 'px',
            'min'       => '0',
            'max'       => '200',
            'step'      => '1',
        );
    break;

    /**
     * MARGIN
     */
    case 'margin' :
        $append = array (
            'name'      => esc_html__( 'Margin', 'dine' ),
            'placeholder'=> '10px 20px',
            'type'      => 'dine_text',
            'css'   => 'margin',
        );
    break;
    
    /**
     * MARGIN EM
     */
    case 'margin-em' :
        $append = array (
            'name'      => esc_html__( 'Margin', 'dine' ),
            'type'      => 'slide',
            'css'       => 'margin',
            'min'       => '0',
            'max'       => '10',
            'step'      => '0.1',
            'std'       => '1',
            'unit'      => 'em',
        );
    break;
    
    /**
     * MARGIN TOP
     */
    case 'margin-top' :
        $append = array (
            'name'      => esc_html__( 'Margin Top', 'dine' ),
            'type'      => 'slide',
            'css'       => 'margin-top',
            'unit'      => 'px',
            'min'       => '0',
            'max'       => '100',
        );
    break;
    
    /**
     * MARGIN TOP EM
     */
    case 'margin-top-em' :
        $append = array (
            'name'      => esc_html__( 'Margin Top', 'dine' ),
            'type'      => 'slide',
            'css'       => 'margin-top',
            'min'       => '0',
            'max'       => '10',
            'step'      => '0.1',
            'std'       => '1',
            'unit'      => 'em',
        );
    break;
    
    /**
     * MARGIN BOTTOM
     */
    case 'margin-bottom' :
        $append = array (
            'name'      => esc_html__( 'Margin Bottom', 'dine' ),
            'type'      => 'slide',
            'css'       => 'margin-bottom',
            'unit'      => 'px',
            'min'       => '0',
            'max'       => '100',
        );
    break;
    
    /**
     * MARGIN LEFT
     */
    case 'margin-left' :
        $append = array (
            'name'      => esc_html__( 'Margin Left', 'dine' ),
            'type'      => 'slide',
            'css'       => 'margin-left',
            'unit'      => 'px',
            'min'       => '0',
            'max'       => '100',
        );
    break;

    /**
     * WIDTH
     */
    case 'width' :
        $append = array (
            'name'      => esc_html__( 'Width', 'dine' ),
            'type'      => 'slide',
            'css'       => 'width',
            'min'       => '0',
            'max'       => '100',
            'step'      => '1',
            'unit'      => 'px',
        );
    break;
    
    /**
     * HEIGHT
     */
    case 'height' :
        $append = array (
            'name'      => esc_html__( 'Height', 'dine' ),
            'type'      => 'slide',
            'min'       => '1',
            'max'       => '100',
            'step'      => '1',
            'unit'      => 'px',
            'css'       => 'height',
        );
    break;

    /**
     * Opacity
     */
    case 'opacity' :
        $append = array (
            'name'      => esc_html__( 'Opacity', 'dine' ),
            'type'      => 'slide',
            'min'       => '0',
            'max'       => '1',
            'std'       => '1',
            'step'      => '0.05',
            'css'       => 'opacity',
        );
    break;
    
    /**
     * Font Size
     */
    case 'font-size' :
        $append = array (
            'name'      => esc_html__( 'Font Size', 'dine' ),
            'type'      => 'slide',
            'unit'  => 'px',
            'step'  => '1',
            'min'   => '8',
            'max'   => '100',
            'css'   => 'font-size',
        );
    break;
    
    /**
     * Font Size
     */
    case 'font-size-em' :
        $append = array (
            'name'      => esc_html__( 'Font Size', 'dine' ),
            'type'      => 'slide',
            'unit'  => 'em',
            'step'  => '0.05',
            'min'   => '0.65',
            'max'   => '2.2',
            'std'   => '1',
            'css'   => 'font-size',
        );
    break;
    
    /**
     * Font Weigth
     */
    case 'font-weight' :
        $append = array (
            'name'      => esc_html__( 'Font Weight', 'dine' ),
            'type'      => 'select',
            'options'   => $font_weights,
            'css'   => 'font-weight',
            'std'       => '400',
        );
    break;
    
    /**
     * Font Weigth with default blank option
     */
    case 'font-weight-default' :
        $append = array (
            'name'      => esc_html__( 'Font Weight', 'dine' ),
            'type'      => 'select',
            'options'   => array( '' => esc_html__( 'Default', 'dine' ) ) + $font_weights,
            'css'   => 'font-weight',
            'std'       => '',
        );
    break;
    
    /**
     * Line Height
     */
    case 'line-height' :
        $append = array (
            'name'      => esc_html__( 'Line Height', 'dine' ),
            'type'      => 'slide',
            'min'       => '1',
            'max'       => '2',
            'step'      => '0.01',
            'std'       => '1.3',
            'css'       => 'line-height',
            'unit'      => 'em',
        );
    break;
    
    /**
     * Line Height px
     */
    case 'line-height-px' :
        $append = array (
            'name'      => esc_html__( 'Line Height', 'dine' ),
            'type'      => 'slide',
            'min'       => '20',
            'max'       => '60',
            'step'      => '1',
            'std'       => '40',
            'css'       => 'line-height',
            'unit'      => 'px',
        );
    break;
    
    /**
     * Letter Spacing
     */
    case 'letter-spacing' :
        $append = array (
            'name'      => esc_html__( 'Letter Spacing', 'dine' ),
            'type'      => 'slide',
            'css'       => 'letter-spacing',
            'std'       => '0',
            'unit'      => 'px',
            'min'       => '0',
            'max'       => '10',
            'step'      => '0.5',
            'unit'      => 'px',
        );
    break;
    
    /**
     * Text Transform
     */
    case 'text-transform' :
        $append = array (
            'name'      => esc_html__( 'Text Transform', 'dine' ),
            'type'      => 'select',
            'options'   => array(
                'none'  => esc_html__( 'None', 'dine' ),
                'uppercase'  => esc_html__( 'UPPERCASE', 'dine' ),
                'lowercase'  => esc_html__( 'lowercase', 'dine' ),
                'capitalize'  => esc_html__( 'Capitalize', 'dine' ),
            ),
            'std'       => 'none',
            'css'   => 'text-transform',
        );
    break;
    
    /**
     * Text Transform with blank option
     */
    case 'text-transform-default' :
        $append = array (
            'name'      => esc_html__( 'Text Transform', 'dine' ),
            'type'      => 'select',
            'options'   => array(
                ''  => esc_html__( 'Default', 'dine' ),
                'none'  => esc_html__( 'None', 'dine' ),
                'uppercase'  => esc_html__( 'UPPERCASE', 'dine' ),
                'lowercase'  => esc_html__( 'lowercase', 'dine' ),
                'capitalize'  => esc_html__( 'Capitalize', 'dine' ),
            ),
            'std'       => '',
            'css'   => 'text-transform',
        );
    break;
    
    /**
     * Font Style
     */
    case 'font-style' :
        $append = array (
            'name'      => esc_html__( 'Font Style', 'dine' ),
            'type'      => 'select',
            'options'   => array(
                'normal'  => esc_html__( 'Normal', 'dine' ),
                'italic'  => esc_html__( 'Italic', 'dine' ),
            ),
            'std'       => 'normal',
            'css'   => 'font-style',
        );
    break;
    
    /**
     * Font Style with blank option
     */
    case 'font-style-default' :
        $append = array (
            'name'      => esc_html__( 'Font Style', 'dine' ),
            'type'      => 'select',
            'options'   => array(
                ''  => esc_html__( 'Default', 'dine' ),
                'normal'  => esc_html__( 'Normal', 'dine' ),
                'italic'  => esc_html__( 'Italic', 'dine' ),
            ),
            'std'       => '',
            'css'   => 'font-style',
        );
    break;
    
    /**
     * Select Font
     */
    case 'font-family' :
        $append = array (
            'name'      => esc_html__( 'Font Face', 'dine' ),
            'type'      => 'select',
            'options'   => $fontlist,
            'css'       => 'font-family',
        );
    break;

    default :

    break;

} // switch $shorthand

$option = array_merge( $append, $option );