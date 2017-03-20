<?php
/**
 * Edit account form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.7
 */

/* Note: This file has been altered by Laborator */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php # start: modified by Arlind Nushi ?>
<div class="section-title">
	<h1><?php _e( 'My Account', 'kalium' ); ?></h1>
	<p><?php _e( 'Edit your account details or change your password', 'kalium' ); ?></p>
</div>
		
<div class="bordered-block edit-account-block">
	<form action="" method="post" class="login message-form">
	
		<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
		
		<h2><?php _e( 'Personal Details', 'kalium' ); ?></h2>
	
		<div class="form-row form-row-first form-group absolute">
			<div class="placeholder"><label for="account_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label></div>
			<input type="text" class="input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
		</div>
		<div class="form-row form-row-last form-group absolute">
			<div class="placeholder"><label for="account_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label></div>
			<input type="text" class="input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
		</div>
		<div class="clear"></div>
	
		<div class="form-row form-row-wide form-group absolute">
			<div class="placeholder"><label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label></div>
			<input type="email" class="input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
		</div>
	
	
		<h2 class="change-account-password-head">
			<?php _e( 'Password Change', 'kalium' ); ?>
			<small><?php _e( '(leave blank to leave unchanged)', 'kalium' ); ?></small>
		</h2>
		<fieldset>
	
			<div class="form-row form-row-wide form-group absolute">
				<div class="placeholder"><label for="password_current"><?php _e( 'Current Password', 'kalium' ); ?></label></div>
				<input type="password" class="input-text" name="password_current" id="password_current" />
			</div>
			<div class="form-row form-row-wide form-group absolute">
				<div class="placeholder"><label for="password_1"><?php _e( 'New Password', 'kalium' ); ?></label></div>
				<input type="password" class="input-text" name="password_1" id="password_1" />
			</div>
			<div class="form-row form-row-wide form-group absolute">
				<div class="placeholder"><label for="password_2"><?php _e( 'Confirm New Password', 'woocommerce' ); ?></label></div>
				<input type="password" class="input-text" name="password_2" id="password_2" />
			</div>
		</fieldset>
		<div class="clear"></div>
	
		<?php do_action( 'woocommerce_edit_account_form' ); ?>
	
		<p>
			<?php wp_nonce_field( 'save_account_details' ); ?>
			<input type="submit" class="button btn btn-primary shop-btn" name="save_account_details" value="<?php _e( 'Save changes', 'woocommerce' ); ?>" />
			<input type="hidden" name="action" value="save_account_details" />
		</p>
	
		<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
	
	</form>
</div>
		

<a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>" class="my-account-go-back"><?php _e( '&laquo; Go back', 'kalium' ); ?></a>
<?php # end: modified by Arlind Nushi ?>