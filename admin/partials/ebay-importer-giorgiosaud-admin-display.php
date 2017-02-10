<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link        http://giorgiosaud.com/site/ 
 * @since      1.0.0
 *
 * @package    Ebay_Importer_Giorgiosaud
 * @subpackage Ebay_Importer_Giorgiosaud/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<h1>Ebay Importer Setup</h1>
	<form method="post" action="options.php"> 
		<?php 
		wp_nonce_field('update-options');	
		settings_fields( 'ebay-importer-giorgiosaud' );
		do_settings_sections( 'ebay-importer-giorgiosaud' );?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Ebay APP ID (Client ID)') ?></th>
				<td><input type="text" name="new_option_name" value="<?php echo esc_attr( get_option('ebay_api_name') ); ?>" /></td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e('Dev ID') ?></th>
				<td><input type="text" name="some_other_option" value="<?php echo esc_attr( get_option('ebay_api_key') ); ?>" /></td>
			</tr>

			<tr valign="top">
				<th scope="row"><?php _e('Cert ID (Client Secret)') ?></th>
				<td><input type="text" name="option_etc" value="<?php echo esc_attr( get_option('ebay_api_key_secret') ); ?>" /></td>
			</tr>
		</table>
		<?php
		submit_button(); ?>
		<input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="ebay_api_name,ebay_api_key,ebay_api_key_secret" />
	</form>
</div>

