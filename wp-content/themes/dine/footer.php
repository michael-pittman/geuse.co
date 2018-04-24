<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Dine
 * @since 1.0
 * @version 1.0
 */

?>

    </div><!-- #content -->

    <footer id="footer" class="site-footer">

        <?php
        get_template_part( 'parts/footer', 'widgets' );
        get_template_part( 'parts/footer', 'bottom' );
        ?>

    </footer><!-- #footer -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>