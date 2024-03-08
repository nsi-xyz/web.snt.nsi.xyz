<?php
include("./include/db.php");
include("../include/functions.php");
include("../include/checksession.php");
if ($_SESSION["user_logged_in"]["id_group"] != 1) {
  header("location: ./index.php");
  exit;
} 
if (!isset($_SESSION["modeEditOrCreateUser"])){
  $_SESSION["modeEditOrCreateUser"] = 0; // Mode création
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title>Gestion des comptes • web.snt.nsi.xyz</title>
  <link rel="stylesheet" href="../css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
  <!-- Ici est un easter eggs : la longueur d'un stylo bille noir avec bouchon est de 141.28mm - Merci à vous. -->
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include("./include/nav_panel.php"); ?>
    <div id="main">
      <div class="header">
        <h1>web.snt.nsi.xyz</h1>
        <h2>10 énigmes à résoudre pour découvrir le web</h2>
      </div>
      <section class="widgets">
        <div class="widget">
          <?php
          if ($_SESSION["modeEditOrCreateUser"] == 0) {
            echo '
            <p class="p-table">Créer un utilisateur</p>
            <form class="pure-form" method="post">
              <fieldset>
                <input type="text" name="name" placeholder="NOM*" required="" pattern="^[^\x22]{0,255}$" title="Guillemets interdits"/>
                <input type="text" name="surname" placeholder="Prénom*" required="" pattern="^[^\x22]{0,255}$" title="Guillemets interdits"/>
                <input type="text" name="username" placeholder="Nom d\'utilisateur*" required="" pattern="^[^\s\xA0\x22]{0,255}$" title="Espaces et guillemets interdits"/>
                <input type="password" name="password" placeholder="Mot de passe*" required="" pattern="^[^\s\xA0\x22]{0,255}$" title="Espaces et guillemets interdits"/>
                <input type="checkbox" name="id_group" id="checkbox-radio-option-one" value="" /> Administrateur
                <button type="submit" class="pure-button pure-button-primary">Créer l\'utilisateur</button>
                <p>* Champ obligatoire</p>
                </fieldset>
            </form>';
            if (isset($_POST["name"], $_POST["surname"], $_POST["username"], $_POST["password"])) {
              if (isset($_POST["id_group"])){
                sleep(1);
                $resultCreateUser = createUser($db, strtoupper($_POST["name"]), $_POST["surname"], $_POST["username"], $_POST["password"], 1);
              } else {
                sleep(1);
                $resultCreateUser = createUser($db, strtoupper($_POST["name"]), $_POST["surname"], $_POST["username"], $_POST["password"], 0);
              }
              if ($resultCreateUser){
                echo '<p style="color: green; font-weight: bolder;">Utilisateur créé</p>';
              } else {
                echo '<p style="color: red; font-weight: bolder;">Nom d\'utilisateur déjà existant !</p>';
              }
            }
          } else {
            $infosUser = $_SESSION["infosUser"];
            echo '
            <p class="p-table">Modifier un utilisateur</p>
            <form class="pure-form" method="post">
              <fieldset>
                <input type="text" name="name" placeholder="Nom" pattern="^[^\x22]{0,255}$" title="Guillemets interdits" value="'.$infosUser["name"].'"/>
                <input type="text" name="surname" placeholder="Prénom" pattern="^[^\x22]{0,255}$" title="Guillemets interdits" value="'.$infosUser["surname"].'"/>
                <input type="text" name="username" placeholder="Nom d\'utilisateur" pattern="^[^\s\xA0\x22]{0,255}$" title="Espaces et guillemets interdits" value="'.$infosUser["username"].'"/>
                <input type="password" name="password" placeholder="Mot de passe" pattern="^[^\s\xA0\x22]{0,255}$" title="Espaces et guillemets interdits"/>';
            if ($infosUser["id_group"] == 1) {
              echo '<input type="checkbox" name="id_group" id="checkbox-radio-option-one" value="" checked /> Administrateur';
            } else {
              echo '<input type="checkbox" name="id_group" id="checkbox-radio-option-one" value="" /> Administrateur';
            }
            echo '
                <button type="submit" name="validate" class="button-validate-modification pure-button">Valider</button>
                <button type="submit" name="cancel" class="button-delete pure-button">Annuler</button>
                <p>* Champ obligatoire</p>
              </fieldset>
            </form>';
            if (isset($_POST["validate"])) {
              $newInfosUser = array("id" => $infosUser["id"]);
              $attributs = ["name", "surname", "username"];
              foreach ($attributs as $attribut) {
                if ($_POST[$attribut] === "" || $_POST[$attribut] === $infosUser[$attribut]) {
                  $newInfosUser[$attribut] = $infosUser[$attribut];
                } else {
                  $newInfosUser[$attribut] = $_POST[$attribut];
                }
              }
                if (! empty($_POST["password"])){
                  $newInfosUser["password"] = $_POST["password"];
                }
                if (isset($_POST["id_group"])){
                  $newInfosUser["id_group"] = 1;
                } else {
                  $newInfosUser["id_group"] = 0;
                }

                sleep(1);
                $resultUpdate = updateUser($db,$newInfosUser,$infosUser["username"]);
                
                if ($resultUpdate){
                  // Ce qui est en commentaire ne fonctionne pas, en gros actuellement ça ne met pas à jour le cookie de session si on modifie son propre compte. Ce sera une maj à faire à l'avenir.
                  // $_SESSION["user_logged_in"] = getRows($db, "users", "*", "username = \"{$_SESSION["user_logged_in"]["username"]}\"");
                  echo '<p style="color: green; font-weight: bolder;">Utilisateur modifié</p>';
                  $_SESSION["modeEditOrCreateUser"] = 0;
                  echo '<script>setTimeout(function() { window.location.replace(window.location.href); }, 1000);</script>';
                } else {
                  echo '<p style="color: red; font-weight: bolder;">Nom d\'utilisateur déjà existant !</p>';
                }

              } elseif (isset($_POST["cancel"])){
                $_SESSION["modeEditOrCreateUser"] = 0;
                echo "<script>window.location.replace(window.location.href);</script>";
              }
            }
          ?>
        </div>
        <div class="widget">
          <p class="p-table">Liste des utilisateurs</p>
          <table class="pure-table">
            <thead>
              <th>#</th>
              <th>NOM</th>
              <th>Prénom</th>
              <th>Nom d'utilisateur</th>
              <th>Administrateur</th>
              <th>Actions</th>
            </thead>
            <tbody>
              <?php
                $listeUsers = getRows($db,"users","id,name,surname,username,id_group","1");
                
                if (count(getRows($db,"users","id","1")) == 1){
                  echo
                    '<tr>
                      <td>'.$listeUsers["id"].'</td>
                      <td>'.$listeUsers["name"].'</td>
                      <td>'.$listeUsers["surname"].'</td>
                      <td>'.$listeUsers["username"].'</td>
                      <td>';
                      if ($listeUsers["id_group"] == 1){
                        echo "✅";
                      } else {
                        echo "❌";
                      }
                      echo '</td>
                      <td>
                        <div>
                          <button class="button-change-infos pure-button" onclick="updateInfosUser(['.urlencode($listeUsers["id"]).',\''.urlencode($listeUsers["name"]).'\',\''.urlencode($listeUsers["surname"]).'\',\''.urlencode($listeUsers["username"]).'\','.$listeUsers["id_group"].'])">Modifier</button>
                          <button class="button-delete pure-button" onclick="deleteUser('.$listeUsers["id"].','.$_SESSION["user_logged_in"]["id"].')">Supprimer le compte</button>
                        </div>
                      </td>
                    </tr>
                  ';
                } else {
                  for ($i = 0; $i < count($listeUsers); $i++) {
                    echo
                      '<tr>
                        <td>'.$listeUsers[$i]["id"].'</td>
                        <td>'.$listeUsers[$i]["name"].'</td>
                        <td>'.$listeUsers[$i]["surname"].'</td>
                        <td>'.$listeUsers[$i]["username"].'</td>
                        <td>';
                        if ($listeUsers[$i]["id_group"] == 1){
                          echo "✅";
                        } else {
                          echo "❌";
                        }
                        echo '</td>
                        <td>
                          <div>
                            <button class="button-change-infos pure-button" onclick="updateInfosUser(['.urlencode($listeUsers[$i]["id"]).',\''.urlencode($listeUsers[$i]["name"]).'\',\''.urlencode($listeUsers[$i]["surname"]).'\',\''.urlencode($listeUsers[$i]["username"]).'\','.$listeUsers[$i]["id_group"].'])">Modifier</button>
                            <button class="button-delete pure-button" onclick="deleteUser('.$listeUsers[$i]["id"].','.$_SESSION["user_logged_in"]["id"].')">Supprimer le compte</button>
                          </div>
                        </td>
                      </tr>
                    ';
                  }
                }

                echo '<script>
                function updateInfosUser(infosUserToModificate){
                  jQuery.ajax({
                    type: "POST",
                    url: "users.php",
                    data: {infosUserModificate: infosUserToModificate},
                    success: function(response) {
                      window.location.replace(window.location.href);
                    }
                  });
                }

                function deleteUser(idUser,idLoggedUser){
                  if (idUser == idLoggedUser){
                    alert("Vous ne pouvez pas supprimer votre propre compte.")
                  } else{
                    if (confirm("Etes-vous sûr de vouloir supprimer cet utilisateur ?")) {
                      jQuery.ajax({
                        type: "POST",
                        url: "users.php",
                        data: {idUserToDelete: idUser},
                        success: function(response) {
                          window.location.replace(window.location.href);
                        }
                      }); 
                    }
                  }
                }                
              </script>';
            
              if (isset($_POST["infosUserModificate"])){
                $_SESSION["infosUser"] = array(
                "id" => urldecode($_POST["infosUserModificate"][0]),
                "name" => urldecode($_POST["infosUserModificate"][1]),
                "surname" => urldecode($_POST["infosUserModificate"][2]),
                "username" => urldecode($_POST["infosUserModificate"][3]),
                "id_group" => $_POST["infosUserModificate"][4]
                );

                $_SESSION["modeEditOrCreateUser"] = 1;
              }

              if (isset($_POST["idUserToDelete"])) {
                deleteUser($db,$_POST["idUserToDelete"]);
              }
              ?>
            </tbody>

          </table>

        </div>
      </section>
    </div>
    <?php include("../include/footer.php"); ?>
  
  </div>
  <script src="../js/ui.js"></script>
</body>
</html>