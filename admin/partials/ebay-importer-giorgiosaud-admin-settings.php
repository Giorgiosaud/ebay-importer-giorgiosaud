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
	<form method="post" action="options.php"> 
		<?php 
		// Muestra los campos de configuracion
		settings_fields( 'ebay-importer-giorgiosaud' );
		// ejecuta las configuraciones de las secciones
		do_settings_sections( 'ebay-importer-giorgiosaud' );
		// Muestra Boton Enviar
		submit_button(); ?>
	</form>
</div>

