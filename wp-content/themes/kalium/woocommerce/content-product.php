<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

/* Note: This file has been altered by Laborator */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

# start: modified by Arlind Nushi
$shop_item_layout   = get_data('shop_catalog_layout');
$shop_columns = apply_filters( 'lab_wc_shop_columns', 3 );
$shop_columns_bs    = lab_wc_get_columns_class( apply_filters( 'lab_wc_shop_columns', 3 ) );

if( is_ajax() )
{
	$classes[] = 'product';
}

if( apply_filters( 'lab_wc_product_grid_columns', true ) == false ) {
	$shop_columns_bs = '';
	$classes[] = 'col-sm-12';
}

if( $shop_columns_bs ) {
	$classes[] = $shop_columns_bs;
}

$classes[] = 'do-lazy-load-on-shown';
$classes[] = 'catalog-layout-' . $shop_item_layout;
# end: modified by Arlind Nushi
?>
<div <?php post_class( $classes ); ?> data-id="<?php the_ID(); ?>">

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' ); # Moved up
	?>

	<a href="<?php the_permalink(); ?>">

		<?php /*<h3><?php the_title(); ?></h3>*/ ?>

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	</a>

	<?php

		/**
		 * woocommerce_after_shop_loop_item hook
		 *
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' ); 

	?>

</div>

<?php
# start: modified by Arlind Nushi
if( $shop_columns_bs ) {
	include locate_template( 'tpls/wc-loop-clear.php' );
}
# end: modified by Arlind Nushi
?>