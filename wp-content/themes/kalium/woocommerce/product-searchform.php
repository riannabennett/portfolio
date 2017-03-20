<?php

/* Note: This file has been altered by Laborator */

?>
<form role="search" method="get" class="woocommerce-product-search search-form search-bar" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<label class="screen-reader-text" for="s"><?php _e( 'Search for:', 'woocommerce' ); ?></label>
	<input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" />
	<input type="submit" value="<?php echo esc_attr_x( 'Go', 'submit button', 'kalium' ); ?>" />
	<input type="hidden" name="post_type" value="product" />
</form>
