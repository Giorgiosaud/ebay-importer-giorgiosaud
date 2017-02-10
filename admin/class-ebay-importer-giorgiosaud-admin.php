<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link        http://giorgiosaud.com/site/ 
 * @since      1.0.0
 *
 * @package    Ebay_Importer_Giorgiosaud
 * @subpackage Ebay_Importer_Giorgiosaud/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ebay_Importer_Giorgiosaud
 * @subpackage Ebay_Importer_Giorgiosaud/admin
 * @author     Giorgiosaud <jorgelsaud@gmail.com>
 */
class Ebay_Importer_Giorgiosaud_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ebay_Importer_Giorgiosaud_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ebay_Importer_Giorgiosaud_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ebay-importer-giorgiosaud-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ebay_Importer_Giorgiosaud_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ebay_Importer_Giorgiosaud_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ebay-importer-giorgiosaud-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function ebay_importer_menu(){
		//Se añade una pagina para poder configurar el sistema
		//el Primer argumento es el titulo de la pagina (lo que se ve en la pestaña)
		//el Primer argumento es el nombre de el menu en el lateral izquierdo
		//el tercer atributo es el nivel de permisos que debe tener el usuario para ver este menu
		//el cuarto es el slug que debe ser en minuscula sin espacio y ser unico
		//el quinto es la funccion a llamar cuando se haga click o lo que va a mostrar la pagina del lado de la configuracion
		//el sexto es el icono que puede ser el url al SVG del icono , el nombre del dashicon o pasar none para colocar div.wp-menu-image y asi añadir un icono via css
		//el septimo es la posicion es un entero que define el orden a mostrar
		add_menu_page('Ebay Importer', 'Ebay Importer', 'edit_others_posts', 'ebay-importer-giorgiosaud', array($this,'ebay_importer_page_view'),'dashicons-migrate',null);
		add_submenu_page(
			'ebay-importer-giorgiosaud',
			'Test',
			'Prueba de Funccionamiento',
			'edit_others_posts',
			'ebay-importer-giorgiosaud-test',
			array($this,'ebay_importer_page_test_view')
			);

	}
	// Registrar Configuraciones y campos
	public function register_ebay_importer_group() {
		//Registrando las configuaciones individualmente
		register_setting( 'ebay-importer-giorgiosaud', 'ebay_api_name' );
		register_setting( 'ebay-importer-giorgiosaud', 'ebay_api_key' );
		register_setting( 'ebay-importer-giorgiosaud', 'ebay_api_key_secret' );
		// Se Registra una seccion para dentro de ella llamar a los campos a configurar
		// el primer argumento es el id de la seccion
		// el segundo un titulo de la seccion que en nuestro caso es traducible con el languages/ebay-importer-giorgiosaud.pot file
		// el tercer argumento es el callback o la funccion a llamar cuando se ejecute esta seccion el el area de la pagina definida anteriormente
		add_settings_section(
			'ebay_importer_giorgiosaud_settings',
			__( 'Settings for the Ebay Importer.', 'ebay-importer-giorgiosaud' ),
			array($this,'ebay_importer_giorgiosaud_settings_cb'),
			'ebay-importer-giorgiosaud'
			);
		// Se Registran los campos que almacenaran la informacion
		// Primer Argumento el nombre que es el que registramos
		// Segundo argumento la etiqueta de el campo o el nombre representativo o Titulo
		// Tercer Argumento funccion a llamar cuando se llama el input en el formulario
		// Cuarto Argumento el slug de la pagina donde se va a mostrar
		// Quinto Argumento la seccion donde se va a ver este campo que es la anterior en este caso
		// Sexto es un array con el nombre de la etiqueta a mostrat y una clase aplicada a la fila donde se ve este campo <tr class="$class"><label for="$label_for">Title</label>.
		add_settings_field(
			'ebay_api_name',
			__('Ebay APP ID (Client ID)','ebay-importer-giorgiosaud' ),
			array($this,'ebay_api_name_cb'),
			'ebay-importer-giorgiosaud',
			'ebay_importer_giorgiosaud_settings',
			array(
				'label_for'=>'ebay_api_name',
				'class'=>'ebay_api_name'
				)
			);
		add_settings_field(
			'ebay_api_key',
			__('Dev ID','ebay-importer-giorgiosaud' ),
			array($this,'ebay_api_key_cb'),
			'ebay-importer-giorgiosaud',
			'ebay_importer_giorgiosaud_settings',
			array(
				'label_for'=>'ebay_api_key',
				'class'=>'ebay_api_key'
				)
			);
		add_settings_field(
			'ebay_api_key_secret',
			__('Cert ID (Client Secret)','ebay-importer-giorgiosaud' ),
			array($this,'ebay_api_key_secret_cb'),
			'ebay-importer-giorgiosaud',
			'ebay_importer_giorgiosaud_settings',
			array(
				'label_for'=>'ebay_api_key_secret',
				'class'=>'ebay_api_key_secret'
				)
			);

	}
	// funccion que uestra el titulo de la secion
	public function ebay_importer_giorgiosaud_settings_cb(){
		echo '<p>Settings for setup ebay dev settings.</p>';
	}
	
	// funccion que muestra como se ve el input y se obtiene los datos de la base de datos si existen
	public function ebay_api_name_cb()
	{
    // get the value of the setting we've registered with register_setting()
		$setting = get_option('ebay_api_name');
    // output the field
		?>
		<input class="regular-text" type="text" name="ebay_api_name" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
		<?php
	}
	// funccion que muestra como se ve el input y se obtiene los datos de la base de datos si existen
	public function ebay_api_key_cb()
	{
    // get the value of the setting we've registered with register_setting()
		$setting = get_option('ebay_api_key');
    // output the field
		?>
		<input class="regular-text" type="text" name="ebay_api_key" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
		<?php
	}
	// funccion que muestra como se ve el input y se obtiene los datos de la base de datos si existen
	public function ebay_api_key_secret_cb()
	{
    // get the value of the setting we've registered with register_setting()
		$setting = get_option('ebay_api_key_secret');
    // output the field
		?>
		<input class="regular-text" type="text" name="ebay_api_key_secret" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
		<?php
	}
	protected function secure_plugin_pages(){
		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}
		return true;
	}
	// Funccion que muestra la pagina
	public function ebay_importer_page_view(){
		if(!$this->secure_plugin_pages()){
			return;
		};
		// Añade un mensaje de error o actualizacion
		// Revisa si el usuario mando datos de configuracion
		// si es asi wordpress añadira un parametro $_GET llamado  "settings-updated" a la url
		if ( isset( $_GET['settings-updated'] ) ) {
			 // añadir un mensaje que diga que fueron guardados los datos con la clase "updated"
			add_settings_error( 'ebay_importer_giorgiosaud_messages', 'ebay_importer_giorgiosaud_message', __( 'Settings Saved', 'ebay-importer-giorgiosaud' ), 'updated' );
		}
		// mostrar los mensajes de error/update
		settings_errors( 'ebay_importer_giorgiosaud_messages' );
		// cargar la plantilla que muestra los datos y la edicion de los mismos
		load_template(plugin_dir_path( __FILE__ ).'partials/ebay-importer-giorgiosaud-admin-display.php');
	}

}
