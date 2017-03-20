<?php

/* Note: This file has been altered by Laborator */

?>
<?php global $product; ?>
<li>
	<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" class="product-img" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo $product->get_image(); ?>
	</a>
	
	
	<div class="product-details">
		<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>"><?php echo $product->get_title(); ?></a>
		
		<?php # start: modified by Arlind Nushi ?>
		<div class="product-meta">
			<?php echo $product->get_price_html(); ?>
			<?php if ( ! empty( $show_rating ) ) : $rating = $product->get_average_rating(); ?>
				<span class="product-rating">
					<em>–</em>
					<?php echo number_format($rating, 1); ?>
					<i class="icon icon-basic-star"></i>
				</span>
			<?php endif; ?>
		</div>
		<?php # end: modified by Arlind Nushi ?>
	</div>
</li>