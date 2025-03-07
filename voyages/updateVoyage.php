<?php

/////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type, Authorization, x-Requested-With');
/////////////// ZONE DE CONTROLE

if($_SERVER['REQUEST_METHOD'] == 'PUT') {
/////////////// REPONSE API OK


/////////////// TRAITEMENT DES INFOS RECUES
	$data = json_decode(file_get_contents("php://input"), true);
	if(!empty($data['voyageID']) && !empty($data['titre']) && !empty($data['description'])) {
	http_response_code(200);
	/////////////// APPEL METHODES		
		include('../cnx.php');
		spl_autoload_register(function($class) {
			include('../classes/'.$class.'.php');
		});
		
		$voyage = new Voyage();
		$voyage->setVoyageID($data['voyageID']);
		$voyage->setTitre($data['titre']);
		$voyage->setDescription($data['description']);
		
		$manager = new VoyageManager($cnx);
		$manager->UpdateVoyage($voyage);
		
		$message = array(
			'msg'   => 'Modification réussie. Il est à préciser que nous n\'autorisons pas la modification des voyages 1 et 2.'
		);
		echo json_encode($message);
	/////////////// APPEL METHODES	
	
	} else {
		http_response_code(405);
		$message = array(
			'msgErreur'   => 'Une erreur est survenue !',
			'explication' => 'Les champs titre et description sont obligatoires'
		);
		echo json_encode($message);
	}
/////////////// TRAITEMENT DES INFOS RECUES
/////////////// REPONSE API OK


	
} else {
/////////////// REPONSE API KO	
	http_response_code(405);
	$message = array(
		'msgErreur'   => 'Méthode non autorisée',
		'explication' => 'Vous devez utiliser la méthode PUT'
	);
	echo json_encode($message);
/////////////// REPONSE API KO		
}	
