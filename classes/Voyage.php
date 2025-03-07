<?php
class Voyage {

/**
 * @OA\Schema(
 * 		schema="Voyages",
 * 		type="object",
 * 		description="Représente un voyage",
 * 		@OA\Property(
 * 			property="voyageID",
 * 			type="integer",
 * 			description="Clé unique du voyage"
 * 		),
 * 		@OA\Property(
 * 			property="titre",
 * 			type="string",
 * 			description="Titre du voyage"
 * 		),
 * 		@OA\Property(
 * 			property="description",
 * 			type="string",
 * 			description="Description du voyage"
 * 		)
 * )
 */	

	private $voyageID;
	private $titre;
	private $description;
	
	public function getVoyageID() {
		return $this->voyageID;
	}
	public function getTitre() {
		return $this->titre;
	}
	public function getDescription() {
		return $this->description;
	}
	
	public function setVoyageID($voyageID) {
		$voyageID = intval($voyageID);
		if(is_int($voyageID)) {
			$this->voyageID = $voyageID;
		}
	}
	public function setTitre($titre) {
		if(is_string($titre)) {
			$this->titre = $titre;
		}
	}
	public function setDescription($description) {
		if(is_string($description)) {
			$this->description = $description;
		}
	}
}