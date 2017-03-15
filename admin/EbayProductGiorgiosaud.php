<?php
class EbayProductGiorgiosaud{
	/**
    * Constructor, we override the parent to pass our own arguments
    * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
    */
	public $productos;
	function __construct($productos) {
		// parent::__construct( array(
		// 	'singular'=> 'wp_ebay_products_list', //Singular label
		// 	'plural' => 'wp_ebay_products_lists', //plural label, also this well be one of the table css class
		// 	'ajax'   => false //We won't support Ajax for this table
		// 	));
		$this->productos = $productos;
	}
	function display(){
		?>
		<table class="wp-list-table widefat fixed striped posts">
			<thead>
				<tr>
					<th scope="col" id="ebay_id" class="manage-column column-primary">
						<span>Ebay ID</span>
					</th>
					<th scope="col" id="name" class="manage-column ">Name</th>
					<th scope="col" id="url" class="manage-column column-url">URL</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($this->productos as $producto){
					?>
					<tr id="<?=producto['ID']?>" class="iedit author-self level-0 type-post status-publish format-standard hentry category-sport category-workshop tag-bike tag-race tag-speed">
						<td class="id column-id" data-colname="ID"><?=producto['ID']?></td>
						<td class="id column-name" data-colname="Name"><?=producto['Name']?></td>
						<td class="id column-URL" data-colname="URL"><?=producto['URL']?></td>
					</tr>
					<?php
				}?>
			}
		</tbody>
	</table>
	<?php

}
}
?>