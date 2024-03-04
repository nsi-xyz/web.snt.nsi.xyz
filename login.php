<?php
include("./panel/include/db.php");
include("./include/functions.php");
include("./include/checksession.php");

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
        <p class="p-content">Rejoignez facilement une session avec le code fourni par votre enseignant ou connectez-vous en tant qu'enseignant ou administrateur pour gérer vos sessions et bien plus.</p>
        <p class="p-content">Le site web est également accessible sans connexion pour une exploration et une découverte rapide et facile.</p>
        <section class="forms">
          <div class="form">
            <form method="GET" action="" class="pure-form pure-form-stacked">
              <fieldset>
                <legend>Rejoindre une session</legend>
                <label for="aligned-foo">Pseudo</label>
                <input type="text" id="aligned-foo" name="pseudo" placeholder="Pseudo"/><br>
                <label for="aligned-foo">Code de la session</label>
                <input type="text" id="aligned-foo" name="code" placeholder="Code de la session"/><br>
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
                  $_SESSION["user_logged_in"]["username"] = $pseudo;
                  echo '<script>window.location.replace(window.location.href);</script>';
                } else {
                  echo "Impossible de rejoindre la session.";
                }
              } else {
                echo "Cette session n'existe pas.";
              }
            }
            ?>
          </div>
          <div class="form">
            <form method="POST" action="" class="pure-form pure-form-stacked">
              <fieldset>
                <legend>Se connecter</legend>
                <label for="aligned-foo">Nom d'utilisateur</label>
                <input type="text" id="aligned-foo" name="username" placeholder="Nom d'utilisateur"/><br>
                <label for="stacked-password">Mot de passe</label>
                <input type="password" id="stacked-password" name="password" placeholder="Mot de passe"/><br>
                <button type="submit" class="pure-button pure-button-primary-join">Se connecter</button>
              </fieldset>
            </form>
            <?php
            if (isset($_POST["username"]) && isset($_POST["password"])) {
              $user_username = strtolower($_POST["username"]);
              $user_password = $_POST["password"];
              if (login_success($user_username, $user_password, $db)) {
                $_SESSION["user_logged_in"] = getRows($db, "users", "*", "username = \"$user_username\"");
                echo '<script>window.location.replace(window.location.href);</script>';
              } else {
                echo "Identifiant ou mot de passe incorrect.";
              }
            }
            ?>
          </div>
        </section>
      </div>
    </div>
    <?php include("./include/footer.php"); ?>
  </div>
  <script src="./js/ui.js"></script>
  <?php include("./include/timer.php"); ?>
</body>
</html>