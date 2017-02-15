<?php
class EbayProductGiorgiosaud{
	private $xml;
	private $id;

	public function __construct($xml)
	{
		$this->xml = $xml;
		$this->parseXML();
	}
	protected function parseXML(){
		$this->ebayId = $this->xml->ItemID->__toString;
		echo '<pre>';
		var_dump($this->xml);
		echo '</pre>';
	}

}