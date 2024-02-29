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

          <div style="margin: 0 auto;">

            <p class="p-table">Créer un utilisateur</p>

            <?php
            
              echo '


              <form class="pure-form" method="post">
                <fieldset>
                  <input type="text" name="name" placeholder="Nom*" required="" pattern="^[^\s\xA0]{0,255}$" title="Espaces interdits"/>
                  <input type="text" name="surname" placeholder="Prénom*" required="" pattern="^[^\s\xA0]{0,255}$" title="Espaces interdits"/>
                  <input type="text" name="username" placeholder="Pseudonyme*" required="" pattern="^[^\s\xA0]{0,255}$" title="Espaces interdits"/>
                  <input type="password" name="password" placeholder="Password*" required="" pattern="^[^\s\xA0]{0,255}$" title="Espaces interdits"/>
                  <input type="checkbox" name="id_group" id="checkbox-radio-option-one" value="" /> Administrateur
                  <button type="submit" class="pure-button pure-button-primary">Sign in</button>
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
                  <!-- A faire -->
                  <!-- PHP à intégrer -->
              </tbody>

            </table>

          </div>

    </div>
    <?php include("../include/footer.php"); ?>
  </div>
  <script>
    const currentPuzzle = null;
  </script>
  <script src="../js/ui.js"></script>
</body>
</html>