<?php
class EbayProductGiorgiosaud{
	private $xml;
	public $eBayId;
	public $title;
	public $description;
	public $mainPicture;
	public $qty;
	public $price;
	public $specificationsTitles;
	public $specifications;
	public $compatibilityTitles;
	public $compatibility;
	public $conditionDescription;
	public $SKU;

	public function __construct($xml)
	{
		$this->xml = $xml;
		$this->specifications=new stdClass();
		$this->specificationsTitles=array();
		$this->compatibility=array();
		$this->parseXML();
	}
	static public function slugify($text)
	{
  // replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '', $text);

  // transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

  // trim
		$text = trim($text, '-');

  // remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

  // lowercase
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}

		return $text;
	}
	protected function parseXML(){
		$this->eBayId = $this->xml->ItemID->__toString();
		$this->title = $this->xml->Title->__toString();
		$this->eBayUrl=$this->xml->ViewItemURLForNaturalSearch->__toString();
		$this->qty=$this->xml->Quantity->__toString();
		$this->price=$this->xml->ConvertedCurrentPrice->__toString();
		$this->conditionDescription=$this->xml->ConditionDescription->__toString();
		$this->SKU=$this->xml->SKU->__toString();
		$picurl=$this->xml->PictureURL[0]->__toString();
		$this->mainPicture=substr($picurl,0,strpos( $picurl, 'JPG' )+3);
		$this->descriptiontext = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', strip_tags( $this->xml->Description->__toString(),'<a>'));
		$this->description=$this->xml->Description->__toString();
		
		// die(var_dump($this->xml->ItemSpecifics));
		foreach($this->xml->ItemSpecifics->NameValueList as $specifics){
			$fullName=$specifics->Name->__toString();
			$name=$this->slugify($fullName);
			$this->specificationsTitles[$name]=$fullName;
			$val=$specifics->Value->__toString();
			$this->specifications->{$name}=$val;
		}
		$compatibilityList = json_decode(json_encode($this->xml->ItemCompatibilityList), TRUE);

		if(isset($compatibilityList["Compatibility"])){
			foreach($compatibilityList["Compatibility"] as $compatibilityItem){
			// dd($compatibilityItem);
				$compatibleFull=new stdClass();
				if(count($compatibilityItem["CompatibilityNotes"])>0){
					$compatibleFull->notes=$compatibilityItem["CompatibilityNotes"];
				}
				foreach($compatibilityItem["NameValueList"] as $compatibleElement){

					if(count($compatibleElement)>0){

						$name=$this->slugify($compatibleElement["Name"]);	
						$val=$compatibleElement["Value"];
						$compatibleFull->{$name}=$val;
					}
				}
				array_push($this->compatibility,$compatibleFull);
			}
		// dd($this->compatibility);
			$this->compatibilityTitles=array_keys((array)$this->compatibility[0]);
		}
	}
	public function showHTMLProduct(){
		?>
		<a href="<?= $this->eBayUrl?>"><h1><?= $this->title ?></h1></a>
		<p>Code: <span><?= $this->eBayId ?></span></p>
		<img src="<?= $this->mainPicture ?>" alt="<?= $this->title ?>">
		<p>
			<?= $this->description ?>
		</p>
		<p>Qty:<span><?= $this->qty ?></span></p>
		<p>Price:<span><?= $this->price ?></span></p>
		<!-- <table> -->
		<!-- <tr> -->
		<?php
								// var_dump($this->specificationsTitles);	
		foreach ($this->specificationsTitles as $key=>$value) {
			$valor=$this->specifications->$key;
			echo "<p><strong>$value: </strong>$valor</p>";
		}
		?>
		<?php if(isset($this->compatibility))
		{
			?>
			<table>
				<caption>Compatibility Table</caption>
				<thead>
					<tr>
						<?php foreach ($this->compatibilityTitles as $title) {
							?>
							<th><?= $title?></th>

							<?php										
						}?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->compatibility as $compatibility) {
						?>
						<tr>
							<?php foreach ($this->compatibilityTitles as $title) {
								?>
								<td><?= $compatibility->$title ?></td>
								<?php
							}?>
							
						</tr>
						<?php										
					}?>
				</tbody>
			</table>
			<!-- </tr> -->
			<!-- </table> -->
			<?php	
		}
	}
	/* Import media from url
	*
	* @param string $file_url URL of the existing file from the original site
	* @param int $post_id The post ID of the post to which the imported media is to be attached
	*
	* @return boolean True on success, false on failure
	*/
	public function SaveOrUpdate(){
		return $this;
	}

	public function fetch_media_for_post($file_url, $post_id) {
		require_once(ABSPATH . 'wp-load.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		global $wpdb;

		if(!$post_id) {
			return false;
		}

		//directory to import to	
		$artDir = 'wp-content/uploads/importedmedia/';

		//if the directory doesn't exist, create it	
		if(!file_exists(ABSPATH.$artDir)) {
			mkdir(ABSPATH.$artDir);
		}

	//rename the file... alternatively, you could explode on "/" and keep the original file name
		$ext = array_pop(explode(".", $file_url));
	$new_filename = 'product-'.$post_id.".".$ext; //if your post has multiple files, you may need to add a random number to the file name to prevent overwrites

	if (@fclose(@fopen($file_url, "r"))) { //make sure the file actually exists
		copy($file_url, ABSPATH.$artDir.$new_filename);

		$siteurl = get_option('siteurl');
		$file_info = getimagesize(ABSPATH.$artDir.$new_filename);

	//create an array of attachment data to insert into wp_posts table
		$artdata = array();
		$artdata = array(
			'post_author' => 1, 
			'post_date' => current_time('mysql'),
			'post_date_gmt' => current_time('mysql'),
			'post_title' => $new_filename, 
			'post_status' => 'inherit',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_name' => sanitize_title_with_dashes(str_replace("_", "-", $new_filename)),				
			'post_modified' => current_time('mysql'),
			'post_modified_gmt' => current_time('mysql'),
			'post_parent' => $post_id,
			'post_type' => 'attachment',
			'guid' => $siteurl.'/'.$artDir.$new_filename,
			'post_mime_type' => $file_info['mime'],
			'post_excerpt' => '',
			'post_content' => ''
			);

		$uploads = wp_upload_dir();
		$save_path = $uploads['basedir'].'/importedmedia/'.$new_filename;

	//insert the database record
		$attach_id = wp_insert_attachment( $artdata, $save_path, $post_id );

	//generate metadata and thumbnails
		if ($attach_data = wp_generate_attachment_metadata( $attach_id, $save_path)) {
			wp_update_attachment_metadata($attach_id, $attach_data);
		}

//optional make it the featured image of the post it's attached to
		$rows_affected = $wpdb->insert($wpdb->prefix.'postmeta', array('post_id' => $post_id, 'meta_key' => '_thumbnail_id', 'meta_value' => $attach_id));
	}
	else {
		return false;
	}

	return true;
}
}