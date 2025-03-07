<?php
$dsn  = 'mysql:host=localhost;dbname=u451881056_certifphp;charset=utf8';
$user = 'u451881056_certifphp';
$pass = 'certif24*A';

try {
	$cnx = new PDO($dsn, $user, $pass);
} catch(PDOException $e) {
	echo 'Une erreur est survenue !';
}