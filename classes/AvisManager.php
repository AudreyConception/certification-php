<?php
class AvisManager {
	private $cnx;
	
	public function __construct($cnx) {
		$this->setCnx($cnx);
	}
	
	/********************* INSERER UN AVIS *************************/
	/**
	 * @OA\Post(
	 * 		path="/createAvis",
	 * 		summary="Insérer un avis",
	 * 		tags={"Avis"},
	 * 		@OA\RequestBody(
	 * 			required=true,
	 * 			@OA\MediaType(
	 * 				mediaType="application/json",
	 * 				@OA\Schema(
	 * 					required={"avis","voyageID","clientID"},
	 * 					@OA\Property(
	 * 						property="avis",
	 * 						type="string",
	 * 						description="Avis du client",
	 * 						example="Avis du client"
	 * 					),
	 * 					@OA\Property(
	 * 						property="voyageID",
	 * 						type="integer",
	 * 						description="Identifiant du voyage",
	 * 						example=1
	 * 					),
	 * 					@OA\Property(
	 * 						property="clientID",
	 * 						type="integer",
	 * 						description="Identifiant du client",
	 * 						example=1
	 * 					)
	 * 				)
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response="201",
	 * 			description="Insérer les datas"
	 * 		),
	 * 		@OA\Response(
	 * 			response="405",
	 * 			description="Méthode non autorisés"
	 * 		),
	 * 		@OA\Response(
	 * 			response="400",
	 * 			description="Tous les champs sont obligatoires"
	 *      )
	 * )
	 */
	public function CreateAvis(Avis $avis) {
		$sql = 'INSERT INTO avis
				(avis, voyageID, clientID, toID) VALUES
				(:avis, :voyageID, :clientID, 1)';
		$req = $this->cnx->prepare($sql);
		$req->bindValue(':avis', $avis->getAvis(), PDO::PARAM_STR);	
		$req->bindValue(':voyageID', $avis->getVoyageID(), PDO::PARAM_INT);	
		$req->bindValue(':clientID', $avis->getClientID(), PDO::PARAM_INT);
        $req->execute();	
	}
	/********************* INSERER UN AVIS *************************/
	/*****************/

	/********************* AFFICHER UN AVIS *************************/
	/**
	 * @OA\Get(
	 * 		path="/readAvis/{avisID}",
	 * 		summary="Afficher un avis",
	 * 		tags={"Avis"},
	 * 		@OA\Parameter(
	 * 			name="avisID",
	 * 			in="path",
	 * 			required=true,
	 * 			description="Paramètre passé en get"
	 * 		),
	 * 		@OA\Response(
	 * 			response="200", 
	 * 			description="Affichage des résultats",
	 * 			@OA\JsonContent(
	 * 				ref="#/components/schemas/Avis"
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response="405", 
	 * 			description="Méthode non autorisée"
	 * 		),
	 * 		@OA\Response(
	 * 			response="404", 
	 * 			description="Non trouvée"
	 * 		)
	 * )
	 */	
	public function ReadAvis($id) {
		$sql = 'SELECT * FROM avis AS a
                JOIN voyage AS v
                ON a.voyageID = v.voyageID
                JOIN client AS c
                ON a.clientID = c.clientID
				WHERE a.avisID = :id AND a.toID = 1';
		$req = $this->cnx->prepare($sql);	
		$req->bindValue(':id', $id, PDO::PARAM_INT);	
		$req->execute();

		$count = $req->rowCount();

		$data = $req->fetch(PDO::FETCH_ASSOC);
		$avis = new Avis ();
		
		if($count > 0) {			
			$avis->setAvisID($data['avisID']);
			$avis->setAvis($data['avis']);
			$avis->setVoyageID($data['voyageID']);
			$avis->setClientID($data['clientID']);
			$avis->setTitre($data['titre']);
			$avis->setDescription($data['description']);
			$avis->setPrenom($data['prenom']);
			$avis->setNom($data['nom']);
			$avis->setEmail($data['email']);
		} else {
			$avis->setAvisID($id);
			$avis->setAvis('Exemple d\'avis');
			$avis->setVoyageID(1);
			$avis->setclientID(1);
            $avis->setTitre('Titre du voyage');
			$avis->setDescription('Description du voyage');
			$avis->setPrenom('Toto');
			$avis->setNom('Dupont');
			$avis->setEmail('email@gmail.com');
		}
		
		return $avis;
	}
	/********************* AFFICHER UN AVIS *************************/
	/*****************/
		
	/********************* AFFICHER TOUS LES AVIS *************************/
	/**
	 * @OA\Get(
	 * 		path="/readAllAvis",
	 * 		summary="Afficher tous les avis",
	 * 		tags={"Avis"},
	 * 		@OA\Response(
	 * 			response="200", 
	 * 			description="Affichage des résultats",
	 * 			@OA\JsonContent(
	 * 				type="array",
	 * 				@OA\Items(ref="#/components/schemas/Avis")
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response="405", 
	 * 			description="Méthode non autorisée"
	 * 		),
	 * 		@OA\Response(
	 * 			response="404", 
	 * 			description="Non trouvée"
	 * 		)
	 * )
	 */
	public function ReadAllAvis() {
		$sql = 'SELECT * FROM avis AS a
                JOIN voyage AS v
                ON a.voyageID = v.voyageID
                JOIN client AS c
                ON a.clientID = c.clientID
				WHERE a.toID = 1';
		$req = $this->cnx->prepare($sql);
		$req->execute();
		
		while($data = $req->fetch(PDO::FETCH_ASSOC)) {
			$avis = new Avis();
			$avis->setAvisID($data['avisID']);
			$avis->setAvis($data['avis']);
			$avis->setVoyageID($data['voyageID']);
			$avis->setClientID($data['clientID']);
			$avis->setTitre($data['titre']);
			$avis->setDescription($data['description']);
			$avis->setPrenom($data['prenom']);
			$avis->setNom($data['nom']);
			$avis->setEmail($data['email']);
			$aviss[] = $avis;
		}
		return $aviss;
	}
	/********************* AFFICHER TOUS LES AVIS *************************/
	/*****************/

	
	/********************* COMPTER LES AVIS *************************/
		public function CompterAvis() {
			$sql = 'SELECT COUNT(*) AS compter FROM avis';
			$req = $this->cnx->prepare($sql);
			$req->execute();
			$data = $req->fetch(PDO::FETCH_ASSOC);
			return $data['compter'];
		}
	/********************* COMPTER LES AVIS *************************/
	/*****************/		
	
	
	/********************* MODIFIER UN AVIS *************************/
	/**
	 * @OA\Put(
	 * 		path="/updateAvis",
	 * 		summary="Modifier un avis",
	 * 		tags={"Avis"},
	 * 		@OA\RequestBody(
	 * 			required=true,
	 * 			@OA\MediaType(
	 * 				mediaType="application/json",
	 * 				@OA\Schema(
	 * 					required={"avisID","avis"},
	 * 					@OA\Property(
	 * 						property="avisID",
	 * 						type="integer",
	 * 						description="Identifiant de l'avis",
	 * 						example=2
	 * 					),
	 * 					@OA\Property(
	 * 						property="avis",
	 * 						type="string",
	 * 						description="Avis du client sur un voyage",
	 * 						example="Ceci est un avis"
	 * 					)
	 * 				)
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response="200",
	 * 			description="Modifier les datas"
	 * 		),
	 * 		@OA\Response(
	 * 			response="405",
	 * 			description="Méthode non autorisés"
	 * 		),
	 * 		@OA\Response(
	 * 			response="400",
	 * 			description="Tous les champs sont obligatoires"
	 * )
	 * )
	 */	
		public function UpdateAvis(Avis $avis) {
			if($avis->getAvisID() > 2) {
				$sql = 'UPDATE avis SET
						avis = :avis
						WHERE avisID = :avisID AND toID = 1';
				$req = $this->cnx->prepare($sql);
				$req->bindValue(':avisID', $avis->getAvisID(), PDO::PARAM_INT);
				$req->bindValue(':avis', $avis->getAvis(), PDO::PARAM_STR);	
				$req->execute();	
			}	
		}
	/********************* MODIFIER UN AVIS *************************/
	/*****************/
	
	
	
	/********************* SUPPRIMER UN AVIS *************************/
	/**
	 * @OA\Delete(
	 * 		path="/deleteAvis",
	 * 		summary="Supprimer un avis",
	 * 		tags={"Avis"},
	 * 		@OA\RequestBody(
	 * 			required=true,
	 * 			@OA\MediaType(
	 * 				mediaType="application/json",
	 * 				@OA\Schema(
	 * 					required={"avisID"},
	 * 					@OA\Property(
	 * 						property="avisID",
	 * 						type="integer",
	 * 						description="Identifiant de l'avis",
	 * 						example=1
	 * 					)
	 * 				)
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response="200",
	 * 			description="Avis supprimé"
	 * 		),
	 * 		@OA\Response(
	 * 			response="405",
	 * 			description="Méthode non autorisés"
	 * 		),
	 * 		@OA\Response(
	 * 			response="400",
	 * 			description="Tous les champs sont obligatoires"
	 * )
	 * )
	 */	
		public function DeleteAvis($id) {
			if($id > 2) {
				$sql = 'DELETE FROM avis
				WHERE avisID = :id AND toID = 1';
				$req = $this->cnx->prepare($sql);	
				$req->bindValue(':id', $id, PDO::PARAM_INT);	
				$req->execute();
			}
		}
	/********************* SUPPRIMER UN AVIS *************************/
	/*****************/
	
	
	
	/********************* PDO *************************/
	private function setCnx($cnx) {
		$this->cnx = $cnx;
	}
	/********************* PDO *************************/
	/*****************/
}