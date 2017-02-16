<?php
class EbayProductGiorgiosaud{
	private $xml;
	public $eBayId;
	public $title;
	public $description;
	public $pictures;

	public function __construct($xml)
	{
		$this->xml = $xml;
		$this->parseXML();
	}
	protected function parseXML(){
		$this->eBayId = $this->xml->ItemID->__toString();
		$this->title = $this->xml->Title->__toString();
		$this->eBayUrl=$this->xml->ViewItemURLForNaturalSearch->__toString();

		$this->pictures=$this->xml->Item->PictureURL;
		var_dump($this->pictures);
		$this->description=$text = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', strip_tags( $this->xml->Description->__toString(),'<a>'));
		echo '<pre>';
		var_dump($this->description);
		echo '</pre>';
		// echo '<pre>';
		// var_dump($this);
		// echo '</pre>';
	}

}