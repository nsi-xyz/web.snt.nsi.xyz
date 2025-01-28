<?php
include("./panel/include/db.php");
include("./include/functions.php");
include("./include/checksession.php");
if (!isset($_SESSION["modeLoginOrCreateUser"])){
  $_SESSION["modeLoginOrCreateUser"] = 1; // Mode Login
}

if (isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"]["username"] != "invité") {
  $verifiedUser = false;
  foreach (getRows($db, "users", "username", "1") as $row) {
    if (in_array($_SESSION["user_logged_in"]["username"], $row)) {
      $verifiedUser = true;
    }
  }
  if ($verifiedUser) {
    header('Location: ./panel/');
  } else {
    header('Location: ./index.php');
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accès à la session • web.snt.nsi.xyz</title>
  <link rel="stylesheet" href="css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include("./include/nav.php"); ?>
    <div id="main">
      <div class="header">
        <h1>web.snt.nsi.xyz</h1>
        <h2>10 énigmes à résoudre pour découvrir le web</h2>
      </div>
      <div class="content">
        <h2 class="content-subhead">S'identifier</h2>
        <p class="p-content">Rejoignez facilement une session avec le code fourni par votre enseignant, connectez-vous ou créez un compte en tant qu'enseignant pour gérer vos sessions et bien plus.</p>
        <p class="p-content">Le site web est également accessible sans connexion pour une exploration et une découverte rapide et facile.</p>
        <error></error>
        <section class="forms">
          <div class="form">
            <form method="GET" action="" class="pure-form pure-form-stacked">
              <fieldset>
                <legend>Rejoindre une session</legend>
                <label for="pseudo">Pseudo</label>
                <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo" pattern="^[^\x22]{0,255}$" title="Guillemets interdits" minlength="3" maxlength="16"><br>
                <label for="code">Code de la session</label>
                <input type="text" id="code" name="code" placeholder="Code de la session" pattern="^[^\x22]{0,255}$" title="Guillemets interdits"><br>
                <button type="submit" class="pure-button pure-button-primary-join">Rejoindre la session</button>
              </fieldset>
            </form>
            <?php
            if (isset($_GET["pseudo"]) && isset($_GET["code"])) {
              $pseudo = $_GET["pseudo"];
              $code = strtoupper($_GET["code"]);
              if (rowsCount($db, "sessions", "code = \"$code\"") == 1) {
                $id = getRows($db, "sessions", "*", "code = \"$code\"")["id"];
                if (canJoinSession($pseudo, $id, $db)) {
                  joinSession($pseudo, $id, $db, "./js/db-$id.json");
                  $_SESSION["user_logged_in"] = getRows($db, "users_session", "*", "pseudo = \"$pseudo\" AND id_session = $id");
                  echo '<script>window.location.replace(window.location.href);</script>';
                } else {
                  throwError("Impossible de rejoindre la session.");
                }
              } else {
                throwError("Cette session n'existe pas.");
              }
            }
            ?>
          </div>
          <?php if ($_SESSION["modeLoginOrCreateUser"] == 1){
            echo '<div class="form">
            <form method="POST" action="" class="pure-form pure-form-stacked">
              <fieldset>
                <legend>Se connecter</legend>
                <label for="username">Nom d\'utilisateur</label>
                <input type="text" id="username" name="username" placeholder="Nom d\'utilisateur" pattern="^[^\x22]{0,255}$" title="Guillemets interdits" minlength="3" maxlength="16"><br>
                <label for="stacked-password">Mot de passe</label>
                <input type="password" id="stacked-password" name="password" placeholder="Mot de passe" pattern="^[^\x22]{0,255}$"><br>
                <button type="submit" class="pure-button pure-button-primary-join">Se connecter</button>
              </fieldset>
            </form>
            <p>Vous êtes professeur ? <br><a id="create-account" href="javascript:createAccount(0)">Créez votre compte !</a></p>
            

            </div>';

            if (isset($_POST["username"], $_POST["password"])) {
              $user_username = strtolower($_POST["username"]);
              $user_password = $_POST["password"];
              if (login_success($user_username, $user_password, $db)) {
                $_SESSION["user_logged_in"] = getRows($db, "users", "*", "username = \"$user_username\"");
                echo '<script>window.location.replace(window.location.href);</script>';
              } else {
                throwError("Identifiant ou mot de passe incorrect.");
                unset($_POST["username"], $_POST["password"]);
              }
            }

          } else {
            echo '<div class="form">
            <form method="POST" action="" class="pure-form pure-form-stacked">
              <fieldset>
                <legend>Créer un compte</legend>
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" placeholder="Nom" required="" pattern="^[^\x22]{0,255}$" title="Guillemets interdits" minlength="3" maxlength="16"><br>
                <label for="surname">Prénom</label>
                <input type="text" id="surname" name="surname" placeholder="Prénom" required="" pattern="^[^\x22]{0,255}$" title="Guillemets interdits" minlength="3" maxlength="16"><br>
                <label for="username">Nom d\'utilisateur</label>
                <input type="text" id="username" name="username" placeholder="Nom d\'utilisateur" required="" pattern="^[^\s\xA0\x22]{0,255}$" title="Espaces et guillemets interdits" minlength="3" maxlength="16"><br>
                <label for="stacked-password">Mot de passe</label>
                <input type="password" id="stacked-password" name="password" placeholder="Mot de passe" required="" pattern="^[^\s\xA0\x22]{0,255}$" title="Espaces et guillemets interdits"><br>
                <button type="submit" class="pure-button pure-button-primary-join">Créer un compte</button>
              </fieldset>
            </form>
            <p>Vous avez déjà un compte ? <br><a id="create-account" href="javascript:createAccount(1)">Vous connectez</a></p>

            </div>';

            if (isset($_POST["name"], $_POST["surname"], $_POST["username"], $_POST["password"])) {
              sleep(1);
              $resultCreateUser = createUser($db, strtoupper($_POST["name"]), $_POST["surname"], $_POST["username"], $_POST["password"], 0);
              if (! $resultCreateUser){
              echo '<p style="color: red; font-weight: bolder;">Nom d\'utilisateur déjà existant !</p>';
              } else {
                $_SESSION["user_logged_in"] = getRows($db, "users", "*", "username = \"{$_POST["username"]}\"");
                $_SESSION["modeLoginOrCreateUser"] = 1;
                echo '<script>window.location.replace(window.location.href);</script>';
              }
            }
          }?>
        </section>
      </div>
    </div>
    <?php include("./include/footer.php"); ?>
    <?php
    if (isset($_SESSION["error-message"])) {
      throwError($_SESSION["error-message"]);
      unset($_SESSION["error-message"]);
    }
    ?>
  </div>
  <script>
    function createAccount(changeModeLoginOrCreate){
      jQuery.ajax({
        type: "POST",
        url: "login.php",
        data: {modeLoginOrCreateUser : changeModeLoginOrCreate},
        success: function(response) {
          window.location.replace(window.location.href);
        }
      });
    }
  </script>
    
  <?php 
    if (isset($_POST["modeLoginOrCreateUser"])){
      $_SESSION["modeLoginOrCreateUser"] = $_POST["modeLoginOrCreateUser"];
    }
  ?>

  
  <script src="./js/ui.js"></script>
  <?php include("./include/timer.php"); ?>
</body>
</html>