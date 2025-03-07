<?php

/////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type, Authorization, x-Requested-With');
/////////////// ZONE DE CONTROLE


if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
/////////////// REPONSE API OK


/////////////// TRAITEMENT DES INFOS RECUES
	$data = json_decode(file_get_contents("php://input"), true);
	if(!empty($data['voyageID'])) {
	
	/////////////// APPEL METHODES		
		include('../cnx.php');
		spl_autoload_register(function($class) {
			include('../classes/'.$class.'.php');
		});
		
		$manager = new VoyageManager ($cnx);
		$verif = $manager->ReadVoyage($data['voyageID']);
		
		if(!empty($verif->getVoyageID())) {
			http_response_code(200);
			
			$manager->DeleteVoyage($data['voyageID']);
			
			$message = array(
				'msg'   => 'Suppression réussie. Il est à préciser que nous n\'autorisons pas la suppression des voyages 1 et 2.'
			);
			echo json_encode($message);
		} else {
			http_response_code(405);
			$message = array(
				'msgErreur'   => 'Suppression impossible !',
				'explication' => 'L\'identifiant n\'existe pas'
			);
			echo json_encode($message);
		}
	/////////////// APPEL METHODES	
	
	} else {
		http_response_code(405);
		$message = array(
			'msgErreur'   => 'Une erreur est survenue !',
			'explication' => 'L\'identifiant est obligatoire'
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
		'explication' => 'Vous devez utiliser la méthode DELETE'
	);
	echo json_encode($message);
/////////////// REPONSE API KO		
}
