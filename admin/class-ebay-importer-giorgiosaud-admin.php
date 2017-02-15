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
	public function woo_add_custom_general_fields(){
		global $woocommerce, $post;

		echo '<div class="options_group">';

  		// Custom fields will be created here...
  		// Text Field
		woocommerce_wp_text_input( 
			array( 
				'id'          => '_ebay_id', 
				'label'       => __( 'eBay Id', 'woocommerce' ), 
				'placeholder' => 'eBay Id',
				'desc_tip'    => 'true',
				'description' => __( 'Enter the custom value here.', 'woocommerce' ) 
				)
			);

		echo '</div>';
	}
	public function woo_add_custom_general_fields_save(){
		$woocommerce_text_field = $_POST['_ebay_id'];
		if( !empty( $woocommerce_text_field ) ){
			update_post_meta( $post_id, '_ebay_id', esc_attr( $woocommerce_text_field ) );
		}

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
		if ( isset( $_GET['settings-updated'] ) ) {
			 // añadir un mensaje que diga que fueron guardados los datos con la clase "updated"
			add_settings_error( 'ebay_importer_giorgiosaud_messages', 'ebay_importer_giorgiosaud_message', __( 'Settings Saved', 'ebay-importer-giorgiosaud' ), 'updated' );
		}
		return true;
	}
	// Funccion que muestra la pagina
	public function ebay_importer_page_view(){
		if(!$this->secure_plugin_pages()){
			return;
		};
		// mostrar los mensajes de error/update
		settings_errors( 'ebay_importer_giorgiosaud_messages' );
		// cargar la plantilla que muestra los datos y la edicion de los mismos
		load_template(plugin_dir_path( __FILE__ ).'partials/ebay-importer-giorgiosaud-admin-settings.php');
	}
	private function getProductsByStore($store) {
		global $xmlrequest;
		$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  


  // Create the XML request to be POSTed
		$xmlrequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xmlrequest .= "<findItemsAdvancedRequest xmlns=\"http://www.ebay.com/marketplace/search/v1/services\">";
		$xmlrequest .= "<itemFilter>";
		$xmlrequest .="<name>Seller</name>";
		$xmlrequest .="<value>";
		$xmlrequest .=$store;
		$xmlrequest .="</value>";
		$xmlrequest .="</itemFilter>";
		$xmlrequest .="<paginationInput>";
		$xmlrequest .="<entriesPerPage>10</entriesPerPage>";
		$xmlrequest .="<pageNumber>1</pageNumber>";
		$xmlrequest .="</paginationInput>";
		$xmlrequest .="<outputSelector>SellerInfo</outputSelector>";
		$xmlrequest .="<outputSelector>GalleryInfo</outputSelector>";
		$xmlrequest .="<outputSelector>aspectHistogramContainer</outputSelector>";
		$xmlrequest .="</findItemsAdvancedRequest>";
		$api_name= get_option('ebay_api_name');
		$headers=array(
			"X-EBAY-SOA-OPERATION-NAME:findItemsAdvanced",
			"X-EBAY-SOA-SERVICE-VERSION:1.3.0",
			"X-EBAY-SOA-REQUEST-DATA-FORMAT:XML",
			"X-EBAY-SOA-GLOBAL-ID:EBAY-US",
			"X-EBAY-SOA-SECURITY-APPNAME:$api_name",
			"Content-Type: text/xml;charset=utf-8"
			);
		  $session  = curl_init($endpoint);                       // create a curl session
		  curl_setopt($session, CURLOPT_POST, true);              // POST request type
		  curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array
		  curl_setopt($session, CURLOPT_POSTFIELDS, $xmlrequest); // set the body of the POST
		  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out
		    $responsexml = curl_exec($session);                     // send the request
		    curl_close($session);                                   // close the session
		    return simplexml_load_string($responsexml);                                    // returns a string
	}  // End of constructPostToGetAllProductsFromStoreCallAndGetResponse function
	private function getItemDetail($productId) {
		global $xmlrequest;
		$endpoint = 'http://open.api.ebay.com/shopping';

  // Create the XML request to be POSTed
		$xmlrequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xmlrequest .= "<GetSingleItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">";
		// <findItemsAdvancedRequest xmlns=\"http://www.ebay.com/marketplace/search/v1/services\">";
		$xmlrequest .= "<IncludeSelector>Details,Compatibility,Description,TextDescription,ShippingCosts,ItemSpecifics,Variations</IncludeSelector>";
		$xmlrequest .="<ItemID>$productId</ItemID>";
		$xmlrequest .="</GetSingleItemRequest>";
		$api_name= get_option('ebay_api_name');
		$headers=array(
			"Content-Type: text/xml;charset=utf-8",

			"X-EBAY-API-APP-ID:$api_name",
			"X-EBAY-API-SITE-ID:0",
			"X-EBAY-API-CALL-NAME:GetSingleItem",
			"X-EBAY-API-VERSION:665",
			"X-EBAY-API-REQUEST-ENCODING:xml"
			);
		  $session  = curl_init($endpoint);                       // create a curl session
		  curl_setopt($session, CURLOPT_POST, true);              // POST request type
		  curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array
		  curl_setopt($session, CURLOPT_POSTFIELDS, $xmlrequest); // set the body of the POST
		  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out
		    $responsexml = curl_exec($session);                     // send the request
		    curl_close($session);                                   // close the session
		    return simplexml_load_string($responsexml);                                    // returns a string
	}  // End of constructPostToGetAllProductsFromStoreCallAndGetResponse function
	// Funccion que muestra la pagina
	public function ebay_importer_page_test_view(){
		if(!$this->secure_plugin_pages()){
			return;
		};
		error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging

		// API request variables
		// // URL to call
		// Supply your own query keywords as needed
		$store = 'expomiamiautoparts';                  
		$resp = $this->getProductsByStore($store);
		// Check to see if the call was successful, else print an error
		// die(var_dump($resp));
		if ($resp->ack == "Success") {
  			// Initialize the $results variable
  			foreach($resp->searchResult->item as $item) {
  				// $product=new EbayProductGiorgiosaud();
			// $item=$resp->searchResult->item[0];
			$ProductId=$item->itemId->__toString();
			$prodDetail = $this->getItemDetail($ProductId);
			?>
				<a href="<?= $prodDetail->Item->ViewItemURLForNaturalSearch?>"><h1><?= $prodDetail->Item->Title ?></h1></a>
				<p>Code: <span><?= $prodDetail->Item->ItemID ?></span></p>
				<?php foreach($prodDetail->Item->PictureURL as $PictureURL){
					?>
					<img src="<?= $PictureURL?>" alt="<?= $prodDetail->Item->Title ?>">
			<?php

			}?>
			<?php
			$ProductId=$resp->searchResult->item[0]->itemId->__toString();
			$prodDetail = $this->getItemDetail($ProductId);
			echo '<pre>';
			var_dump($prodDetail->Item);
			echo '</pre>';

			// die();
			// $results = '';  
			// $respuesta='<div>';
			// $link=$itemTest->viewItemURL;
			// $respuesta.="<a href='$link'>";
			// $respuesta.='<h1>';
			// $respuesta.=$itemTest->title;
			// $respuesta.="</h1>";
			
			// $endpoint2="http://open.api.ebay.com/shopping";
			
			// $respuesta.='</a>';
			// $respuesta.='</div>';
			// echo $respuesta;

			// die(var_dump($prodDetail));
  // Parse the desired information from the response
			// foreach($resp->searchResult->item as $item) {
				// $pic   = $item->galleryURL;
				// $link  = $item->viewItemURL;
				// $title = $item->title;

    // Build the desired HTML code for each searchResult.item node and append it to $results
				// $results .= "<tr><td><img src=\"$pic\"></td><td><a href=\"$link\">$title</a></td></tr>";
			}
		}
		// If the response does not indicate 'Success,' print an error
		// else {  
			// $results  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
			// $results .= "AppID for the Production environment.</h3>";
		// }
		// echo $results;
		// cargar la plantilla que muestra los datos y la edicion de los mismos
		// load_template(plugin_dir_path( __FILE__ ).'partials/ebay-importer-giorgiosaud-admin-test.php');
	}

}
