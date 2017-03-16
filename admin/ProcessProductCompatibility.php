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
				$this->updateCompatibilityTable($query->post->ID);
				wp_redirect(edit_post_link(null,null,null,$query->post->ID));
				exit;
			}
				// var_dump($this->details->ItemCompatibilityList);
				// die();

				// echo 'Product Id '.$query->post->ID;
		}
		else{
			var_dump($this->details);
			die();
			global $user_ID;
			$new_post = array(
				'post_title' => $this->details->Title->__toString(),
				'post_content' => $this->details->ConditionDescription->__toString(),
				'post_status' => 'draft',
				'post_date' => date('Y-m-d H:i:s'),
				'post_author' => $user_ID,
				'post_type' => 'product',
				'post_category' => array(0)
				);
			$post_id = wp_insert_post($new_post);
			$this->updateCompatibilityTable($post_id);
		}
	}
	public function updateCompatibilityTable($id){
		$header=array();
		$headerElement=$this->details->ItemCompatibilityList->Compatibility[0];
		foreach($headerElement->NameValueList as $listElement){
			if($listElement->Name!=''){
				$column=array('c'=>$listElement->Name->__toString());
				array_push($header,$column);
			}

		}
		$column=array(
			'c'=>'Compatibility Notes');
		array_push($header,$column);
		$table=array();

		$body=array();
				// var_dump(get_field('compatible_table'));
				// die();
		foreach($this->details->ItemCompatibilityList->Compatibility as $compatible){
			$linea=array();
			foreach($compatible->NameValueList as $listElement){
				if($listElement->Value!=''){
					$elemento=array('c'=>$listElement->Value->__toString());
					array_push($linea,$elemento);
				}
			}
			$elemento=array('c'=>$compatible->CompatibilityNotes->__toString());
			array_push($linea,$elemento);

					// var_dump($linea);
			array_push($body,$linea);					

		}	
		$table['p']['o']['uh']=1;
		$table['c']=array();
		foreach($header as $head)
		{
			array_push($table['c'],array('p'=>''));
		}				
		$table['h']=$header;
		$table['b']=$body;


		update_field('compatible_table', json_encode($table), $id);

	}
}
