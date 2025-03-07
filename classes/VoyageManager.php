<?php
class VoyageManager {
	private $cnx;
	
	public function __construct($cnx) {
		$this->setCnx($cnx);
	}
	
	/********************* INSERER UN VOYAGE *************************/
	/**
	 * @OA\Post(
	 * 		path="/createVoyage",
	 * 		summary="Insérer un voyage",
	 * 		tags={"Voyages"},
	 * 		@OA\RequestBody(
	 * 			required=true,
	 * 			@OA\MediaType(
	 * 				mediaType="application/json",
	 * 				@OA\Schema(
	 * 					required={"titre","description"},
	 * 					@OA\Property(
	 * 						property="titre",
	 * 						type="string",
	 * 						description="Titre du voyage",
	 * 						example="Voyage au soleil"
	 * 					),
	 * 					@OA\Property(
	 * 						property="description",
	 * 						type="string",
	 * 						description="Description du voyage",
	 * 						example="1 semaine tout inclus"
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
	 *		)
	 *	)
	 */
	public function CreateVoyage(Voyage $voyage) {
		$sql = 'INSERT INTO voyage
				(titre, description, toID) VALUES
				(:titre, :description, 1)';
		$req = $this->cnx->prepare($sql);
		$req->bindValue(':titre', $voyage->getTitre(), PDO::PARAM_STR);	
		$req->bindValue(':description', $voyage->getDescription(), PDO::PARAM_STR);
        $req->execute();	
	}
	/********************* INSERER UN VOYAGE *************************/
	/*****************/
	
	
	
	/********************* AFFICHER UN VOYAGE *************************/
	/**
	 * @OA\Get(
	 * 		path="/readVoyage/{voyageID}",
	 * 		summary="Afficher un voyage",
	 * 		tags={"Voyage"},
	 * 		@OA\Parameter(
	 * 			name="voyageID",
	 * 			in="path",
	 * 			required=true,
	 * 			description="Paramètre passé en get"
	 * 		),
	 * 		@OA\Response(
	 * 			response="200", 
	 * 			description="Affichage des résultats",
	 * 			@OA\JsonContent(
	 * 				ref="#/components/schemas/Voyage"
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
	public function ReadVoyage($id) {
		$sql = 'SELECT * FROM voyage
				WHERE voyageID = :id AND toID = 1';
		$req = $this->cnx->prepare($sql);	
		$req->bindValue(':id', $id, PDO::PARAM_INT);	
		$req->execute();

		$count = $req->rowCount();
		
		$data = $req->fetch(PDO::FETCH_ASSOC);
		$voyage = new Voyage();

		if($count > 0) {
		    $voyage->setVoyageID($data['voyageID']);
			$voyage->setTitre($data['titre']);
			$voyage->setDescription($data['description']);
	    } else {
			$voyage->setVoyageID($id);
			$voyage->setTitre('Titre du voyage');
			$voyage->setDescription('Ce voyage n\'est pas présent dans notre base de données');
		}
		return $voyage;
	}
	/********************* AFFICHER UN VOYAGE *************************/
	/*****************/
	
	
	
	/********************* AFFICHER TOUS LES VOYAGES *************************/
	/**
	 * @OA\Get(
	 * 		path="/readAllVoyage",
	 * 		summary="Afficher tous les voyages",
	 * 		tags={"Voyages"},
	 * 		@OA\Response(
	 * 			response="200", 
	 * 			description="Affichage des résultats",
	 * 			@OA\JsonContent(
	 * 				type="array",
	 * 				@OA\Items(ref="#/components/schemas/Voyage")
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
	public function ReadAllVoyage() {
		$sql = 'SELECT * FROM voyage
		        WHERE toID = 1';
		$req = $this->cnx->prepare($sql);
		$req->execute();
		
		while($data = $req->fetch(PDO::FETCH_ASSOC)) {
			$voyage = new Voyage();
			$voyage->setVoyageID($data['voyageID']);
			$voyage->setTitre($data['titre']);
			$voyage->setDescription($data['description']);
			$voyages[] = $voyage;
		}
		return $voyages;
	}
	/********************* AFFICHER TOUS LES VOYAGES *************************/
	/*****************/
		
	
	
	/********************* COMPTER LES VOYAGES *************************/
		public function CompterVoyage() {
			$sql = 'SELECT COUNT(*) AS compter FROM voyage';
			$req = $this->cnx->prepare($sql);
			$req->execute();
			$data = $req->fetch(PDO::FETCH_ASSOC);
			return $data['compter'];
		}
	/********************* COMPTER LES CLIENTS *************************/
	/*****************/		
	
	
	/********************* MODIFIER UN VOYAGE *************************/
	/**
	 * @OA\Put(
	 * 		path="/updateVoyage",
	 * 		summary="Modifier un voyage",
	 * 		tags={"Voyages"},
	 * 		@OA\RequestBody(
	 * 			required=true,
	 * 			@OA\MediaType(
	 * 				mediaType="application/json",
	 * 				@OA\Schema(
	 * 					required={"voyageID","titre","description"},
	 * 					@OA\Property(
	 * 						property="voyageID",
	 * 						type="integer",
	 * 						description="Identifiant du voyage",
	 * 						example=3
	 * 					),
	 * 					@OA\Property(
	 * 						property="titre",
	 * 						type="string",
	 * 						description="Titre du voyage",
	 * 						example="Voyage au soleil"
	 * 					),
	 * 					@OA\Property(
	 * 						property="description",
	 * 						type="string",
	 * 						description="Description du voyage",
	 * 						example="1 semaine tout inclus"
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
		public function UpdateVoyage(Voyage $voyage) {
			if($voyage->getVoyageID() > 2) {
			$sql = 'UPDATE voyage SET
					titre = :titre, description = :description
					WHERE voyageID = :voyageID AND toID = 1';
			$req = $this->cnx->prepare($sql);
			$req->bindValue(':voyageID', $voyage->getVoyageID(), PDO::PARAM_INT);
			$req->bindValue(':titre', $voyage->getTitre(), PDO::PARAM_STR);	
			$req->bindValue(':description', $voyage->getDescription(), PDO::PARAM_STR);
            $req->execute();	
		    }
		}
	/********************* MODIFIER UN VOYAGE *************************/
	/*****************/
	
	
	
	/********************* SUPPRIMER UN VOYAGE*************************/
    /**
	 * @OA\Delete(
	 * 		path="/deleteVoyage",
	 * 		summary="Supprimer un voyage",
	 * 		tags={"Voyages"},
	 * 		@OA\RequestBody(
	 * 			required=true,
	 * 			@OA\MediaType(
	 * 				mediaType="application/json",
	 * 				@OA\Schema(
	 * 					required={"voyageID"},
	 * 					@OA\Property(
	 * 						property="voyageID",
	 * 						type="integer",
	 * 						description="Identifiant du voyage",
	 * 						example=1
	 * 					)
	 * 				)
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response="200",
	 * 			description="Voyage supprimé"
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
		public function DeleteVoyage($id) {
			if($id > 2) {
			$sql = 'DELETE FROM voyage
					WHERE voyageID = :id AND toID = 1';
			$req = $this->cnx->prepare($sql);	
			$req->bindValue(':id', $id, PDO::PARAM_INT);	
			$req->execute();
		}
	}
	/********************* SUPPRIMER UN TUTO *************************/
	/*****************/
	
	
	
	/********************* PDO *************************/
	private function setCnx($cnx) {
		$this->cnx = $cnx;
	}
	/********************* PDO *************************/
	/*****************/
}