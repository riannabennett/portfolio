<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

/* Note: This file has been altered by Laborator */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

# start: modified by Arlind Nushi
$show_add_to_cart = get_data( 'shop_add_to_cart_listing' );

$shop_catalog_layout = get_data( 'shop_catalog_layout' );
$shop_product_category = get_data( 'shop_product_category_listing' );
?>
<div class="product-loop-add-to-cart-container">
	
	<?php if( $shop_product_category && $shop_catalog_layout == 'default' ) : ?>
	<div class="product-category<?php if( $show_add_to_cart ): ?> category-hoverable<?php endif; ?>">
		<?php echo $product->get_categories(); ?>
	</div>
	<?php endif; ?>
	
	<?php if( $show_add_to_cart ) : ?>
	<div class="add-to-cart-link">
	<?php
	# end: modified by Arlind Nushi
	
		echo apply_filters( 'woocommerce_loop_add_to_cart_link',
			sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-added_to_cart_text="' . __( 'Added to cart', 'kalium' ) . '" data-product_sku="%s" data-quantity="%s" class="%s product_type_%s">%s</a>',
				esc_url( $product->add_to_cart_url() ),
				esc_attr( $product->id ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				esc_attr( $product->product_type ),
				esc_html( $product->add_to_cart_text() )
			),
		$product );
	
	# start: modified by Arlind Nushi
	?>
	</div>
	<?php endif; ?>
	
</div>
<?php
# end: modified by Arlind Nushi