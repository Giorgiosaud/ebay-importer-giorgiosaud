<?php 
class ProcessProductCompatibility{
	private $idEbay;
	private $details;

	public function __construct($idEbay, $details){

		$this->idEbay = $idEbay;
		$this->details = $details;
	}
	public function newOrUpdateCompatibility(){
		echo $this->details;
	}
}
