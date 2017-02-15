<?php
class EbayProductGiorgiosaud{
	private $xml;
	private $id;

	public function __construct($xml, $id)
	{
		$this->xml = $xml;
		$this->id = $this->xml->itemId->__toString;
		dd($this->id);

	}

}