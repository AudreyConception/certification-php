<?php
class Client {

/**
 * @OA\Schema(
 * 		schema="Clients",
 * 		type="object",
 * 		description="Représente un client",
 * 		@OA\Property(
 * 			property="clientID",
 * 			type="integer",
 * 			description="Clé unique du client"
 * 		),
 * 		@OA\Property(
 * 			property="prenom",
 * 			type="string",
 * 			description="Prénom du client"
 * 		),
 * 		@OA\Property(
 * 			property="nom",
 * 			type="string",
 * 			description="Nom du client"
 * 		),
 * 		@OA\Property(
 * 			property="email",
 * 			type="string",
 * 			description="email du client"
 * 		)
 * )
 */	

	private $clientID;
	private $prenom;
	private $nom;
    private $email;
	
	public function getClientID() {
		return $this->clientID;
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
	
	public function setClientID($clientID) {
		$clientID = intval($clientID);
		if(is_int($clientID)) {
			$this->clientID = $clientID;
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