<?php
class EbayProductGiorgiosaud{
	private $xml;
	public $eBayId;
	public $title;

	public function __construct($xml)
	{
		$this->xml = $xml;
		$this->parseXML();
	}
	protected function parseXML(){
		$this->eBayId = $this->xml->ItemID->__toString();
		$this->title = $this->xml->Title->__toString();
		echo '<pre>';
		var_dump($this->xml);
		echo '</pre>';
		echo '<pre>';
		var_dump($this->title);
		echo '</pre>';
	}

}