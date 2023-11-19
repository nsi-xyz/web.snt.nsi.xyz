<?php
$adresse="localhost:3306";
$identifiant="root";
$mdp="/";
$database="/";
$dsn = 'mysql:host='.$adresse.';dbname='.$database.';charset=UTF8';
$dbh = new PDO($dsn, $identifiant, $mdp) or die("Une erreur est survenue lors de la connexion à la base de données.");
?>