<?php
include "./panel/include/db.php";
include "./include/functions.php";
include "./include/checksession.php";
if (isUserConnected()) {
  $verifiedUser = false;
  foreach (getRows($db, "users", "username", "1", 1) as $row) {
    if (in_array($_SESSION["user_logged_in"]["username"], $row)) {
      $verifiedUser = true;
    }
  }
  if ($verifiedUser) {
    header('Location: ./panel/');
    exit();
  } else {
    header('Location: ./index.php');
    exit();
  }
} else if (currentUserInSession()) {
  throwError("Vous êtes déjà dans une session. Veuillez la quitter pour accéder à la page d'identification.", "./index.php", "msg", true, true);
}
if (!isset($_SESSION["login"])){
  $_SESSION["login"] = 1;
}
if (isset($_POST["login_mode"])) {
  $_SESSION["login"] = $_POST["login_mode"];
  echo json_encode(["success" => true]);
  exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo traduction("login_website_title"); ?></title>
  <link rel="stylesheet" href="css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="./js/messages.js"></script>
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include("./include/nav.php"); ?>
    <div id="main">
      <div class="header">
        <h1><?php echo traduction("login_header_h1"); ?></h1>
        <h2><?php echo traduction("login_header_h2"); ?></h2>
        <h3 class="h3-login"><?php echo traduction("login_header_h3"); ?></h3>
      </div>
      <div class="content">
        <h2 id="S'identifier" class="content-subhead"><?php echo traduction("login_content_subhead1_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("login_content_subhead1_p1"); ?></p>
        <p class="p-content"><?php echo traduction("login_content_subhead1_p2"); ?></p>
        <h2 class="content-subhead"><?php echo traduction("login_content_subhead2_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("login_content_subhead2_p"); ?></p>
        <msg></msg>
        <section class="forms">
          <?php if ($_SESSION["login"] == 1) : ?>
            <div class="form">
              <form method="GET" action="" class="pure-form pure-form-stacked">
                <fieldset>
                  <legend>Rejoindre une session</legend>
                  <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo" required pattern="<?php echo HTMLPATTERN_PSEUDO; ?>" minlength="<?php echo PSEUDO_MIN_LENGTH; ?>" maxlength="<?php echo PSEUDO_MAX_LENGTH; ?>" />
                  </div>
                  <div class="form-group">
                    <label for="code">Code de la session</label>
                    <input type="text" id="code" name="code" placeholder="Code de la session" required minlength="1" />
                  </div>
                </fieldset>
                <button type="submit" class="pure-button pure-button-primary-join">Rejoindre la session</button>
              </form>
              <?php
              if (isset($_GET["pseudo"]) && isset($_GET["code"])) {
                $pseudo = $_GET["pseudo"];
                $code = strtoupper($_GET["code"]);
                if (isValidString($code, "/^[A-Z0-9]+$/") && rowsCount($db, "sessions", "code = \"$code\"") == 1) {
                  $id = getRows($db, "sessions", "*", "code = \"$code\"")["id"];
                  if (isValidString($pseudo, PHPPATTERN_PSEUDO) && canJoinSession($pseudo, $id, $db)) {
                    joinSession($pseudo, $id, $db);
                    $_SESSION["user_logged_in"] = getRows($db, "users_session", "*", "pseudo = \"$pseudo\" AND id_session = $id");
                    throwSuccess("Vous avez rejoint la session avec succès.<br>Bonne chance !", "./index.php", "msg", true, false);
                  } else {
                    throwError("Impossible de rejoindre la session.", null, "msg", false, false);
                  }
                } else {
                  throwError("Cette session n'existe pas.", false, "msg", false, false);
                }
              }
              ?>
            </div>
            <div class="form">
              <form method="POST" action="" class="pure-form pure-form-stacked">
                <fieldset>
                  <legend>Se connecter</legend>
                  <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required minlength="1" maxlength="<?php echo USERNAME_MAX_LENGTH; ?>" />
                  </div>
                  <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Mot de passe" required minlength="1" maxlength="<?php echo PASSWORD_MAX_LENGTH; ?>" />
                  </div>
                  <div class="form-group">
                    <label for="stay-connected" class="pure-checkbox">
                      <input id="stay-connected" name="stay-connected" type="checkbox" /> Rester connecté
                    </label>
                  </div>
                </fieldset>
                <button type="submit" class="pure-button pure-button-primary-join">Se connecter</button>
              </form>
              <p>Vous êtes professeur ? <br><a id="create-account" href="javascript:login(0)">Créez votre compte !</a></p>
              <?php
              if (isset($_POST["username"], $_POST["password"])) {
                $user_username = strtolower($_POST["username"]);
                $user_password = $_POST["password"];
                if (isValidString($user_username, PHPPATTERN_USERNAME) && login_success($user_username, $user_password, $db)) {
                  $_SESSION["user_logged_in"] = getRows($db, "users", "*", "username = \"$user_username\"");
                  if (isset($_POST["stay-connected"])) {
                    $_SESSION["stay_connected"] = true;
                  }
                  echo '<script>window.location.replace(window.location.href);</script>';
                } else {
                  unset($_POST["username"], $_POST["password"]);
                  throwError("Identifiant ou mot de passe incorrect.", null, "msg", true, false);
                }
              }
              ?>
            </div>
          <?php else : ?>
            <div class="form">
              <form method="POST" action="" class="pure-form pure-form-stacked">
                <fieldset>
                  <legend>Créer un compte</legend>
                  <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" id="name" name="name" placeholder="Nom" required pattern="<?php echo HTMLPATTERN_NAME; ?>" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
                  </div>
                  <div class="form-group">
                    <label for="surname">Prénom</label>
                    <input type="text" id="surname" name="surname" placeholder="Prénom" required pattern="<?php echo HTMLPATTERN_NAME; ?>" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
                  </div>
                  <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required pattern="<?php echo HTMLPATTERN_USERNAME; ?>" minlength="<?php echo USERNAME_MIN_LENGTH; ?>" maxlength="<?php echo USERNAME_MAX_LENGTH; ?>" />
                  </div>
                  <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Mot de passe" required title="Un bon mot de passe doit faire entre 7 et 32 caractères, contenir au moins une lettre, un chiffre, et un caractère spécial." minlength="<?php echo PASSWORD_MIN_LENGTH; ?>" maxlength="<?php echo PASSWORD_MAX_LENGTH; ?>" />
                  </div>
                </fieldset>
                <button type="submit" class="pure-button pure-button-primary-join">Créer un compte</button>
              </form>
              <p>Vous avez déjà un compte ? <br><a id="create-account" href="javascript:login(1)">Vous connectez</a></p>
            </div>
            <?php
            if (isset($_POST["name"], $_POST["surname"], $_POST["username"], $_POST["password"])) {
              $username = strtolower(trim($_POST["username"]));
              $result = createUser($db, $_POST["name"], $_POST["surname"], $username, $_POST["password"], 0);
              switch ($result) {
                case 0:
                  $_SESSION["user_logged_in"] = getRows($db, "users", "*", "username = \"$username\"");
                  echo '<script>window.location.replace(window.location.href);</script>';
                  break;
                case -1:
                  throwError("Action impossible.", null, "msg", true, false);
                  break;
                case -2:
                  throwError("Ce nom d'utilisateur est déjà utilisé.", null, "msg", true, false);
                  break;
                case -3:
                  throwError("Les champs ne respectent pas les longueurs requises", null, "msg", true, false);
                  break;
                case -4:
                  throwError("Les champs utilisent des caractères non autorisés.", null, "msg", true, false);
                  break;
              }
            }
            ?>
          <?php endif; ?>
        </section>
      </div>
    </div>
    <script>
      function login(mode) {
        jQuery.ajax({
            type: "POST",
            url: "login.php",
            data: {login_mode: mode},
            success: function(response) {
              const data = JSON.parse(response);
              if (data.success) {
                sessionStorage.setItem("scrollTo", "S'identifier");
                window.location.href = window.location.href;
              } 
            }
          });
      }

      window.onload = function() {
        const scrollTo = sessionStorage.getItem("scrollTo");
        if (scrollTo) {
          document.getElementById(scrollTo).scrollIntoView();
          sessionStorage.removeItem("scrollTo");
        }
      }
    </script>
    <?php include "./include/footer.php"; ?>
  </div>
  <script src="./js/ui.js"></script>
  <?php include "./include/timer.php"; ?>
</body>
</html>