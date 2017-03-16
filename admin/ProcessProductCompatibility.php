<?php 
class ProcessProductCompatibility{
	public $idEbay;
	public $details;

	public function __construct($idEbay, $details){

		$this->idEbay = $idEbay;
		$this->details = $details;
	}
	public function newOrUpdateCompatibility(){
		echo $this->details;
	}
}
