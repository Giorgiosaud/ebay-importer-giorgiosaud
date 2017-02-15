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
		$this->id = $this->xml->itemId->__toString;
		echo '<pre>';
		var_dump($this->xml);
		echo '</pre>';
	}

}