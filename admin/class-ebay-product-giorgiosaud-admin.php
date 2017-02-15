<?php
class EbayProductGiorgiosaud{
	private $xml;
	public $eBayId;
	private $id;

	public function __construct($xml)
	{
		$this->xml = $xml;
		$this->parseXML();
	}
	protected function parseXML(){
		$this->eBayId = $this->xml->ItemID->__toString;
		echo '<pre>';
		var_dump($this->xml->ItemId);
		echo '</pre>';
	}

}