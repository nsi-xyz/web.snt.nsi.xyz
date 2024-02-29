<?php
include("./include/db.php");
include("../include/functions.php");
include("../include/checksession.php");
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

      <div>

        <?php
          if (! isset($_SESSION["modeEditOrCreateUser"])){
            $_SESSION["modeEditOrCreateUser"] = 0; //Mode création utilisateur
          }
        ?>

        <div>

          <?php
          
            if ($_SESSION["modeEditOrCreateUser"] === 0){
              echo '
              <p class="p-table">Créer un utilisateur</p>
              <form class="pure-form" method="post">
                <fieldset>
                  <input type="text" name="name" placeholder="Nom*" required="" pattern="^[^\x22]{0,255}$" title="Guillemets interdits"/>
                  <input type="text" name="surname" placeholder="Prénom*" required="" pattern="^[^\x22]{0,255}$" title="Guillemets interdits"/>
                  <input type="text" name="username" placeholder="Nom d\'utilisateur*" required="" pattern="^[^\s\xA0\x22]{0,255}$" title="Espaces et guillemets interdits"/>
                  <input type="password" name="password" placeholder="Mot de passe*" required="" pattern="^[^\s\xA0\x22]{0,255}$" title="Espaces et guillemets interdits"/>
                  <input type="checkbox" name="id_group" id="checkbox-radio-option-one" value="" /> Administrateur
                  <button type="submit" class="pure-button pure-button-primary">Créer l\'utilisateur</button>
                  <p>* Champ obligatoire</p>
                </fieldset>
              </form>';

              if (isset($_POST["name"],$_POST["surname"],$_POST["username"],$_POST["password"])){
                if (isset($_POST["id_group"])){
                  sleep(1);
                  $resultCreateUser = createUser($db,$_POST["name"],$_POST["surname"],$_POST["username"],$_POST["password"],1);
                } else {
                  sleep(1);
                  $resultCreateUser = createUser($db,$_POST["name"],$_POST["surname"],$_POST["username"],$_POST["password"],0);
                }
                if ($resultCreateUser){
                  echo '<p style="color: green; font-weight: bolder;">Utilisateur créé</p>';
                } else {
                  echo '<p style="color: red; font-weight: bolder;">Nom d\'utilisateur déjà existant !</p>';
                }
              }
            } else {
              $infosUsers = json_decode($_COOKIE["infosUsers"],true);
              echo '
              <p class="p-table">Modifier un utilisateur</p>

              <form class="pure-form" method="post">
                <fieldset>
                  <input type="text" name="name" placeholder="Nom" pattern="^[^\x22]{0,255}$" title="Guillemets interdits" value='.$infosUsers["name"].'/>
                  <input type="text" name="surname" placeholder="Prénom" pattern="^[^\x22]{0,255}$" title="Guillemets interdits" value='.$infosUsers["surname"].'/>
                  <input type="text" name="username" placeholder="Nom d\'utilisateur" pattern="^[^\s\xA0\x22]{0,255}$" title="Espaces et guillemets interdits" value='.$infosUsers["username"].'/>
                  <input type="password" name="password" placeholder="Mot de passe" pattern="^[^\s\xA0\x22]{0,255}$" title="Espaces et guillemets interdits"/>
                  ';
                  if ($infosUsers["id_group"] == 1){
                    echo '<input type="checkbox" name="id_group" id="checkbox-radio-option-one" value="" checked /> Administrateur';
                  } else {
                    echo '<input type="checkbox" name="id_group" id="checkbox-radio-option-one" value="" /> Administrateur';
                  }
                  echo '
                  <button type="submit" class="button-validate-modification pure-button">Modifier des informations de cet utilisateur</button>
                  <p>* Champ obligatoire</p>
                </fieldset>
              </form>';

              
            }
          ?>

        </div>


        <div>

          <p class="p-table">Liste des utilisateurs</p>

          <table class="pure-table">
            <thead>
              <th>#</th>
              <th>Nom</th>
              <th>Prénom</th>
              <th>Pseudonyme</th>
              <th>Actions</th>
            </thead>
            <tbody>
              <?php
                $listeUsers = getRows($db,"users","id,name,surname,username,id_group","1");

                for ($i = 0; $i < count($listeUsers); $i++) {
                  echo
                    '<tr>
                      <td>'.$listeUsers[$i]["id"].'</td>
                      <td>'.$listeUsers[$i]["name"].'</td>
                      <td>'.$listeUsers[$i]["surname"].'</td>
                      <td>'.$listeUsers[$i]["username"].'</td>
                      <td>
                        <div>
                          <button class="button-change-infos pure-button" onclick="updateInfosUser([\''.urlencode($listeUsers[$i]["name"]).'\',\''.urlencode($listeUsers[$i]["surname"]).'\',\''.urlencode($listeUsers[$i]["username"]).'\','.$listeUsers[$i]["id_group"].'])">Modifier info</button>
                          <button class="button-delete pure-button" onclick="deleteUser('.$listeUsers[$i]["id"].')">Supprimer le compte</button>
                        </div>
                      </td>
                    </tr>
                  ';
                }

                echo '<script>
                function updateInfosUser(infosUserToModificate){
                  alert("modifier")
                  jQuery.ajax({
                    type: "POST",
                    url: "users.php",
                    data: {infosUserModificate: infosUserToModificate},
                    success: function(response) {
                      window.location.replace(window.location.href);
                    }
                  });
                }

                function deleteUser(idUser){
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
              </script>';
            
              if (isset($_POST["infosUserModificate"])){
                print_r($_POST["infosUserModificate"]);
                $infosUsers = array(
                "name" => urldecode($_POST["infosUserModificate"][0]),
                "surname" => urldecode($_POST["infosUserModificate"][1]),
                "username" => urldecode($_POST["infosUserModificate"][2]),
                "id_group" => $_POST["infosUserModificate"][3]
                );
                
                setcookie("infosUsers", "test", time() + 3600);

                $_SESSION["modeEditOrCreateUser"] = 1;
              }

              if (isset($_POST["idUserToDelete"])) {
                deleteUser($db,$_POST["idUserToDelete"]);
              }
              ?>
            </tbody>

          </table>

        </div>

      </div>
    
    </div>
    <?php include("../include/footer.php"); ?>
  
  </div>
</body>
</html>