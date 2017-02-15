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
		$this->description=$this->xml->Description->__toString();
		echo '<pre>';
		var_dump($this->xml);
		echo '</pre>';
		echo '<pre>';
		var_dump($this->description);
		echo '</pre>';
	}

}