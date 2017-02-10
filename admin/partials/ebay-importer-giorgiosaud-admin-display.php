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
	<h1>Ebay Importer Setup</h1>
	<form method="post"> 
		<?php settings_fields( 'ebay_importer_group' );
		do_settings_sections( 'ebay_importer_group' );?>
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
	</form>
</div>

