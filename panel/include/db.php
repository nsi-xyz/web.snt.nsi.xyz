<?php
$adresse = "localhost:3306";
$user = "root";
$password = "";
$db_name = "xtjh1161_web_snt_nsi_xyz_beta";
$dsn = "mysql:host=$adresse;dbname=$db_name;charset=utf8mb4";
try {
  $db = new PDO($dsn, $user, $password);
} catch (PDOException $error) {
  echo "La connexion à la base de données a échoué.<br>Erreur : <b>".$error->getMessage()."</b><br>";
  echo "Accéder à la version hors-ligne : <a href='./old/'>web.snt.nsi.xyz/old/</a>";
  exit();
}