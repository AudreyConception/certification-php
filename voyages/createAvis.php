<?php

/////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type, Authorization: Bearer <token>, x-Requested-With');
/////////////// ZONE DE CONTROLE

if($_SERVER['REQUEST_METHOD'] == 'POST') {
/////////////// REPONSE API OK


/////////////// TRAITEMENT DES INFOS RECUES AVIS
    $data = json_decode(file_get_contents("php://input"), true);
    if(!empty($data['avis']) && !empty($data['voyageID']) && !empty($data['clientID'])) {
    http_response_code(201);
/////////////// APPEL METHODES		
        include('../cnx.php');
        spl_autoload_register(function($class) {
            include('../classes/'.$class.'.php');
        });
    
        $avis = new Avis();
        $avis->setAvis($data['avis']);
        $avis->setVoyageID($data['voyageID']);
        $avis->setClientID($data['clientID']);
    
        $manager = new AvisManager($cnx);
        $manager->CreateAvis($avis);
    
        $message = array(
        'msg'    => 'Insertion réussie !'
        );
        echo json_encode($message);
/////////////// APPEL METHODES	

    } else {
        http_response_code(405);
        $message = array(
            'msgErreur'   => 'Une erreur est survenue !',
            'explication' => 'Les champs avis, voyageID et clientID sont obligatoires'
        );
        echo json_encode($message);
    }
/////////////// TRAITEMENT DES INFOS RECUES AVIS
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