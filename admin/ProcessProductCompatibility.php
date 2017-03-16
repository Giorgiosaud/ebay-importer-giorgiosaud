<?php 
class ProcessProductCompatibility{
	public $idEbay;
	public $details;

	public function __construct($idEbay, $details){

		$this->idEbay = $idEbay;
		$this->details = $details;
	}
	public function newOrUpdateCompatibility(){
		$args = array(
			'post_type' => 'product',
			'meta_key' => '_ebay_id',
			'meta_value' => $this->idEbay,
			);
		$query=new WP_Query($args);
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$header=array();
				die(var_dump($this->details->ItemCompatibilityList->Compatibility[0]));
				foreach($this->details->ItemCompatibilityList->Compatibility as $compatible){
					foreach($compatible[0]->NameValueList as $listElement){
						if($listElement->Name!=''){
							$column=array('c'=>$listElement->Name);
							array_push($header,$column);
						}

					}
				}
				// var_dump($this->details->ItemCompatibilityList);
				// die();
				// var_dump(get_field('compatible_table'));
				// echo 'Product Id '.$query->post->ID;
			}
		}
		else{
			echo 'not Found post with Ebay Id'.$this->idEbay;
		}
	}
}
