<?php 
class ProcessProductCompatibility{
	public $idEbay;
	public $details;

	public function __construct($idEbay, $xmlstring){

		$this->idEbay = $idEbay;
		$this->details = $this->SimpleXML2Array($xmlstring);
		
	}
	public function newOrUpdateCompatibility(){
		echo $this->details;
	}
	static public function SimpleXML2Array($xml){
		$array = (array)$xml;

    //recursive Parser
		foreach ($array as $key => $value){
			if(strpos(get_class($value),"SimpleXML")!==false){
				$array[$key] = SimpleXML2Array($value);
			}
		}

		return $array;
	}
}
