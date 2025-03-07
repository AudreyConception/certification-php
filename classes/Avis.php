<?php
class Avis{
/**
 * @OA\Schema(
 * 		schema="Avis",
 * 		type="object",
 * 		description="Représente un avis",
 * 		@OA\Property(
 * 			property="AvisID",
 * 			type="integer",
 * 			description="Clé unique de l'avis"
 * 		),
 * 		@OA\Property(
 * 			property="avis",
 * 			type="string",
 * 			description="Avis du client"
 * 		),
 * 		@OA\Property(
 * 			property="voyageID",
 * 			type="integer",
 * 			description="Identifiant du voyage"
 * 		),
 * 		@OA\Property(
 * 			property="clientID",
 * 			type="integer",
 * 			description="Identifiant du client"
 * 		)
 * ),
 *  @OA\Schema(
 * 		schema="Avis",
 * 		type="object",
 * 		description="Affichage d'un avis",
 * 		@OA\Property(
 * 			property="AvisID",
 * 			type="integer",
 * 			description="Clé unique de l'avis"
 * 		),
 * 		@OA\Property(
 * 			property="avis",
 * 			type="string",
 * 			description="Avis du client"
 * 		),
 * 		@OA\Property(
 * 			property="voyageID",
 * 			type="integer",
 * 			description="Identifiant du voyage"
 * 		),
 * 		@OA\Property(
 * 			property="clientID",
 * 			type="integer",
 * 			description="Identifiant de client"
 * 		),
 * 		@OA\Property(
 * 			property="voyage",
 * 			@OA\Property(
 * 				property="titre",
 * 				type="string",
 * 				description="Titre du voyage"
 * 			),
 * 			@OA\Property(
 * 				property="description",
 * 				type="string",
 * 				description="Description du voyage"
 * 			)			
 * 		),
 * 		@OA\Property(
 * 			property="client",
 * 			@OA\Property(
 * 				property="prenom",
 * 				type="string",
 * 				description="Prenom du client"
 * 			),
 *          @OA\Property(
 * 				property="nom",
 * 				type="string",
 * 				description="Nom du client"
 * 			),
 *          @OA\Property(
 * 				property="email",
 * 				type="string",
 * 				description="Email du client"
 * 			),
 * 		)
 * )
 */	
	private $avisID;
	private $avis;
	private $voyageID;
    private $clientID;

	private $titre;
	private $description;

	private $prenom;
	private $nom;
	private $email;
	
	public function getAvisID() {
		return $this->avisID;
	}
	public function getAvis() {
		return $this->avis;
	}
	public function getVoyageID() {
		return $this->voyageID;
	}
    public function getClientID() {
		return $this->clientID;
	}

	public function getTitre() {
		return $this->titre;
	}
	public function getDescription() {
		return $this->description;
	}

	public function getPrenom() {
		return $this->prenom;
	}
	public function getNom() {
		return $this->nom;
	}
	public function getEmail() {
		return $this->email;
	}


	
	public function setAvisID($avisID) {
		$avisID = intval($avisID);
		if(is_int($avisID)) {
			$this->avisID = $avisID;
		}
	}
	public function setAvis($avis) {
		if(is_string($avis)) {
			$this->avis = $avis;
		}
	}
    public function setVoyageID($voyageID) {
		$voyageID = intval($voyageID);
		if(is_int($voyageID)) {
			$this->voyageID = $voyageID;
		}
	}
    public function setClientID($clientID) {
		$clientID = intval($clientID);
		if(is_int($clientID)) {
			$this->clientID = $clientID;
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

	public function setPrenom($prenom) {
		if(is_string($prenom)) {
			$this->prenom = $prenom;
		}
	}
	public function setNom($nom) {
		if(is_string($nom)) {
			$this->nom = $nom;
		}
	}
	public function setEmail($email) {
		if(is_string($email)) {
			$this->email = $email;
		}
	}
	
}