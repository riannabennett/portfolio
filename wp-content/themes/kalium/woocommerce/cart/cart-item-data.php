<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 	2.1.0
 */

/* Note: This file has been altered by Laborator */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<table class="variation">
	<?php
		foreach ( $item_data as $data ) :
			$key = sanitize_text_field( $data['key'] );
	?>
	<tr>
		<th class="variation-<?php echo sanitize_html_class( $key ); ?>"><?php echo wp_kses_post( $data['key'] ); ?>:</th>
		<td class="variation-<?php echo sanitize_html_class( $key ); ?>"><?php echo wp_kses_post( wpautop( $data['value'] ) ); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
