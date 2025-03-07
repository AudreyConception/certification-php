<?php

/////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type, Authorization, x-Requested-With');
/////////////// ZONE DE CONTROLE

if($_SERVER['REQUEST_METHOD'] == 'POST') {
/////////////// REPONSE API OK
		
/////////////// TRAITEMENT DES INFOS RECUES CLIENTS
	$data = json_decode(file_get_contents("php://input"), true);
	if(!empty($data['prenom']) && !empty($data['nom']) && !empty($data['email'])) {
	http_response_code(201);
/////////////// APPEL METHODES		
		include('../cnx.php');
		spl_autoload_register(function($class) {
			include('../classes/'.$class.'.php');
		});
		
		$client = new Client();
		$client->setPrenom($data['prenom']);
		$client->setNom($data['nom']);
		$client->setEmail($data['email']);
		
		$manager = new ClientManager($cnx);
		$manager->CreateClient($client);
		
		$message = array(
			'msg'=> 'Insertion réussie !'
		);
		echo json_encode($message);
	/////////////// APPEL METHODES	
	
	} else {
		http_response_code(405);
		$message = array(
			'msgErreur'   => 'Une erreur est survenue !',
			'explication' => 'Les champs prenom, nom et email sont obligatoires'
		);
		echo json_encode($message);
	}
/////////////// TRAITEMENT DES INFOS RECUES CLIENTS
/////////////// REPONSE API OK

	
} else {
/////////////// REPONSE API KO	
	http_response_code(405);
	$message = array(
		'msgErreur'   => 'Méthode non autorisée',
		'explication' => 'Vous devez utiliser la méthode POST'
	);
	echo json_encode($message);
/////////////// REPONSE API KO		
}	