<?php
class EbayProductGiorgiosaud{
	private $xml;
	public $eBayId;
	public $title;
	public $description;
	public $mainPicture;

	public function __construct($xml)
	{
		$this->xml = $xml;
		$this->parseXML();
	}
	protected function parseXML(){
		$this->eBayId = $this->xml->ItemID->__toString();
		$this->title = $this->xml->Title->__toString();
		$this->eBayUrl=$this->xml->ViewItemURLForNaturalSearch->__toString();
		$picurl=$this->xml->PictureURL[0]->__toString();
		$this->mainPicture=substr($picurl,0,strpos( $picurl, 'JPG' )+3);
		// die(var_dump($this->mainPicture));
		$this->description=$text = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', strip_tags( $this->xml->Description->__toString(),'<a>'));
		echo '<pre>';
		var_dump($this);
		echo '</pre>';
		// echo '<pre>';
		// var_dump($this);
		// echo '</pre>';
	}
	/* Import media from url
 *
 * @param string $file_url URL of the existing file from the original site
 * @param int $post_id The post ID of the post to which the imported media is to be attached
 *
 * @return boolean True on success, false on failure
 */

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