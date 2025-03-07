<?php
/////////////// ZONE DE CONTROLE
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type, Authorization, x-Requested-With');
/////////////// ZONE DE CONTROLE




if($_SERVER['REQUEST_METHOD'] == 'GET') {
/////////////// REPONSE API OK
	http_response_code(200);

	
/////////////// APPEL METHODES		
	include('../cnx.php');
	spl_autoload_register(function($class) {
		include('../classes/'.$class.'.php');
	});
	$manager = new AvisManager($cnx);
	$aviss    = $manager->ReadAllAvis();
	$count   = $manager->CompterAvis();
/////////////// APPEL METHODES	

	
/////////////// ENVOI DES DONNEES EN JSON
	if($count > 0) {
		foreach($aviss as $avis) {
			$msg = array(
				'avisID'       => $avis->getAvisID(),
                'avis'         => $avis->getAvis(),
                'voyageID'     => $avis->getVoyageID(),
                'clientID'     => $avis->getClientID(),
                'voyage'       => [
                        'titre'       => $avis->getTitre(),
                        'description' => $avis->getDescription(),
                ],
                'client'       => [
                        'prenom'       => $avis->getPrenom(),
				        'nom'          => $avis->getNom(),
				        'email'        => $avis->getEmail()
                ]
			);
			$messages[] = $msg;
		}
		echo json_encode($messages);
	} else {
		$message = array(
			'msgErreur'   => 'Aucune donnée de disponible'
		);
		echo json_encode($message);
	}
/////////////// ENVOI DES DONNEES EN JSON	
/////////////// REPONSE API OK


	
} else {
/////////////// REPONSE API KO	
	http_response_code(405);
	$message = array(
		'msgErreur'   => 'Méthode non autorisée',
		'explication' => 'Vous devez utiliser la méthode GET'
	);
	echo json_encode($message);
/////////////// REPONSE API KO		
}











