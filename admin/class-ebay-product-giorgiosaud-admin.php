<?php
class EbayProductGiorgiosaud{
	private $xml;
	public $eBayId;
	public $title;
	public $description;

	public function __construct($xml)
	{
		$this->xml = $xml;
		$this->parseXML();
	}
	protected function parseXML(){
		$this->eBayId = $this->xml->ItemID->__toString();
		$this->title = $this->xml->Title->__toString();
		$this->description=$text = strip_tags( $this->xml->Description->__toString(),'<p>');
;
		$this->eBayUrl=$this->xml->ViewItemURLForNaturalSearch->__toString();
		echo '<pre>';
		var_dump($this);
		echo '</pre>';
	}

}