<?php
$adresse = "localhost:3306";
$user = "root";
$password = "";
$db_name = "xtjh1161_web_snt_nsi_xyz_alpha";
$dsn = "mysql:host=$adresse;dbname=$db_name";
try {
    $db = new PDO($dsn, $user, $password);
} catch (PDOException $error) {
    echo "La connexion à la base de données $db_name a échoué.<br>Erreur : <b>".$error->getMessage()."</b>";
    exit();
}