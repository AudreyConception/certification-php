<?php
class ClientManager {
	private $cnx;
	
	public function __construct($cnx) {
		$this->setCnx($cnx);
	}
	
	/********************* INSERER UN CLIENT *************************/

	/**
	 *@OA\Post(
		* 	path="/createClient",
		* 	summary="Insérer un client",
		* 	tags={"Clients"},
		* 	@OA\RequestBody(
		* 		required=true,
		* 		@OA\MediaType(
		* 			mediaType="application/json",
		* 			@OA\Schema(
		* 				required={"prenom","nom","email"},
		* 				@OA\Property(
		* 					property="prenom",
		* 					type="string",
		* 					description="Prénom du client",
		* 					example="Prénom client"
		* 				),
		* 				@OA\Property(
		* 					property="nom",
		* 					type="string",
		* 					description="Nom du client",
		* 					example="Nom client"
		* 				),
		* 				@OA\Property(
		* 					property="email",
		* 					type="string",
		* 					description="email du client",
		* 					example="email@gmail.com"
		* 				)
		* 			)
		* 		)
		* 	),
		* 	@OA\Response(
		* 		response="201",
		* 		description="Insérer les datas"
		* 	),
		* 	@OA\Response(
		* 		response="405",
		* 		escription="Méthode non autorisée"
		* 	),
		* 	@OA\Response(
		* 		response="400",
		* 		description="Tous les champs sont obligatoires"
		*      )
		* )
		*/

	public function CreateClient(Client $client) {
		$sql = 'INSERT INTO client
				(prenom, nom, email, toID) VALUES
				(:prenom, :nom, :email, 1)';
		$req = $this->cnx->prepare($sql);
		$req->bindValue(':prenom', $client->getPrenom(), PDO::PARAM_STR);	
		$req->bindValue(':nom', $client->getNom(), PDO::PARAM_STR);	
		$req->bindValue(':email', $client->getEmail(), PDO::PARAM_STR);
        $req->execute();	
	}
	/********************* INSERER UN CLIENT *************************/
	/*****************/
	
	
	
	/********************* AFFICHER UN CLIENT *************************/
	/**
	 * @OA\Get(
	 * 		path="/readClient/{clientID}",
	 * 		summary="Afficher un client",
	 * 		tags={"Clients"},
	 * 		@OA\Parameter(
	 * 			name="clientID",
	 * 			in="path",
	 * 			required=true,
	 * 			description="Paramètre passé en get"
	 * 		),
	 * 		@OA\Response(
	 * 			response="200", 
	 * 			description="Affichage des résultats",
	 * 			@OA\JsonContent(
	 * 				ref="#/components/schemas/Client"
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
	public function ReadClient($id) {
		$sql = 'SELECT * FROM client
				WHERE clientID = :id AND toID = 1';
		$req = $this->cnx->prepare($sql);	
		$req->bindValue(':id', $id, PDO::PARAM_INT);	
		$req->execute();

		$count = $req->rowCount();
		
		$data = $req->fetch(PDO::FETCH_ASSOC);
		$client = new Client();

		if($count > 0) {			
			$client->setClientID($data['clientID']);
			$client->setPrenom($data['prenom']);
			$client->setNom($data['nom']);
			$client->setEmail($data['email']);
		} else {
			$client->setClientID($id);
			$client->setPrenom('Ce client n\'est pas présent dans notre base de données');
			$client->setNom('Nom du client');
			$client->setEmail('email@gmail.com');
		}
		
		return $client;
	}
	/********************* AFFICHER UN CLIENT *************************/
	/*****************/
	
	
	
	/********************* AFFICHER TOUS LES CLIENTS *************************/
	/**
	 * @OA\Get(
	 * 		path="/readAllClient",
	 * 		summary="Afficher tous les clients",
	 * 		tags={"Clients"},
	 * 		@OA\Response(
	 * 			response="200", 
	 * 			description="Affichage des résultats",
	 * 			@OA\JsonContent(
	 * 				type="array",
	 * 				@OA\Items(ref="#/components/schemas/Client")
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

	    public function ReadAllClient() {
		$sql = 'SELECT * FROM client
		        WHERE toID = 1';
		$req = $this->cnx->prepare($sql);
		$req->execute();
		
		while($data = $req->fetch(PDO::FETCH_ASSOC)) {
			$client = new Client();
			$client->setClientID($data['clientID']);
			$client->setPrenom($data['prenom']);
			$client->setNom($data['nom']);
			$client->setEmail($data['email']);
			$clients[] = $client;
		}
		return $clients;
	}
	/********************* AFFICHER TOUS LES CLIENTS *************************/
	/*****************/
		
	
	
	/********************* COMPTER LES CLIENTS *************************/
		public function CompterClient() {
			$sql = 'SELECT COUNT(*) AS compter FROM client';
			$req = $this->cnx->prepare($sql);
			$req->execute();
			$data = $req->fetch(PDO::FETCH_ASSOC);
			return $data['compter'];
		}
	/********************* COMPTER LES CLIENTS *************************/
	/*****************/		
	
	
	/********************* MODIFIER UN CLIENT *************************/
	/**
	 * @OA\Put(
	 * 		path="/updateClient",
	 * 		summary="Modifier un client",
	 * 		tags={"Clients"},
	 * 		@OA\RequestBody(
	 * 			required=true,
	 * 			@OA\MediaType(
	 * 				mediaType="application/json",
	 * 				@OA\Schema(
	 * 					required={"clientID","prenom","nom","email"},
	 * 					@OA\Property(
	 * 						property="clientID",
	 * 						type="integer",
	 * 						description="Identifiant du client",
	 * 						example=3
	 * 					),
	 * 					@OA\Property(
	 * 						property="prenom",
	 * 						type="string",
	 * 						description="Prénom du client",
	 * 						example="Prénom client"
	 * 					),
	 * 					@OA\Property(
	 * 						property="nom",
	 * 						type="string",
	 * 						description="Nom du client",
	 * 						example="Nom client"
	 * 					),
	 * 					@OA\Property(
	 * 						property="email",
	 * 						type="string",
	 * 						description="email du client",
	 * 						example="email@gmail.com"
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
	 * 			description="Méthode non autorisée"
	 * 		),
	 * 		@OA\Response(
	 * 			response="400",
	 * 			description="Tous les champs sont obligatoires"
	 * )
	 * )
	 */	

		public function UpdateClient(Client $client) {
			if($client->getClientID() > 2) {
			$sql = 'UPDATE client SET
					prenom = :prenom, nom = :nom, email = :email
					WHERE clientID = :clientID AND toID = 1';
			$req = $this->cnx->prepare($sql);
			$req->bindValue(':clientID', $client->getClientID(), PDO::PARAM_INT);
			$req->bindValue(':prenom', $client->getPrenom(), PDO::PARAM_STR);	
			$req->bindValue(':nom', $client->getNom(), PDO::PARAM_STR);	
			$req->bindValue(':email', $client->getEmail(), PDO::PARAM_STR);
            $req->execute();	
		}
	}
		
	/********************* MODIFIER UN CLIENT *************************/
	/*****************/
	
	
	
	/********************* SUPPRIMER UN CLIENT *************************/
	/**
	 * @OA\Delete(
	 * 		path="/deleteClient",
	 * 		summary="Supprimer un client",
	 * 		tags={"Clients"},
	 * 		@OA\RequestBody(
	 * 			required=true,
	 * 			@OA\MediaType(
	 * 				mediaType="application/json",
	 * 				@OA\Schema(
	 * 					required={"clientID"},
	 * 					@OA\Property(
	 * 						property="clientID",
	 * 						type="integer",
	 * 						description="Identifiant du client",
	 * 						example=3
	 * 					)
	 * 				)
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response="200",
	 * 			description="Tuto supprimé"
	 * 		),
	 * 		@OA\Response(
	 * 			response="405",
	 * 			description="Méthode non autorisée"
	 * 		),
	 * 		@OA\Response(
	 * 			response="400",
	 * 			description="Tous les champs sont obligatoires"
	 * )
	 * )
	 */	

		public function DeleteClient($id) {
			if($id > 2) {
			$sql = 'DELETE FROM client
					WHERE clientID = :id AND toID = 1';
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
