<?php
include "./include/db.php";
include "../include/functions.php";
include "../include/checksession.php";
$user_id = $_SESSION["user_logged_in"]["id"];
$data_user = getRows($db, "users", "id, name, surname, username, created_at, last_update, last_connexion, id_group", "id = $user_id");
if (isset($_POST["apply_infos"], $_POST["name"], $_POST["surname"], $_POST["username"])) {
  $result = updateUser($db, $data_user, array("name" => $_POST["name"], "surname" => $_POST["surname"], "username" => $_POST["username"], "id_group" => $_SESSION["user_logged_in"]["id_group"]));
  switch ($result) {
    case 0:
      throwSuccess("Informations mises à jour avec succès.", null, "msg", true, true);
      break;
    case -1:
      throwError("Action impossible.", null, "msg", true, true);
      break;
    case -2:
      throwError("Ce nom d'utilisateur est déjà utilisé.", null, "msg", true, true);
      break;
    case -3:
      throwError("Les champs ne respectent pas les longueurs requises.", null, "msg", true, true);
      break;
    case -4:
      throwError("Les champs utilisent des caractères non autorisés.", null, "msg", true, true);
      break;
  }
}
if (isset($_POST["apply_password"], $_POST["password_current"], $_POST["password_new"], $_POST["password_new_confirm"])) {
  $result = updateUserPassword($db, $_SESSION["user_logged_in"]["id"], $_POST["password_current"], $_POST["password_new"], $_POST["password_new_confirm"]);
  switch ($result) {
    case 0:
      throwSuccess("Mot de passe mis à jour avec succès.", null, "msg", true, true);
      break;
    case -1:
      throwError("La confirmation du mot de passe ne correspond pas.", null, "msg", true, true);
      break;
    case -2:
      throwError("Le nouveau mot de passe ne respecte pas la longueur requise.", null, "msg", true, true);
      break;
    case -3:
      throwError("Le mot de passe actuel est incorrect.", null, "msg", true, true);
      break;
  }
}
if (isset($_POST["delete_account"])) {
  $_SESSION["delete_account"] = $_POST["delete_account"];
  echo json_encode(["success" => true]);
  exit();
}
if (isset($_POST["delete_sessions"])) {
  $_SESSION["delete_sessions"] = $_POST["delete_sessions"];
  echo json_encode(["success" => true]);
  exit();
}
if (isset($_SESSION["delete_account"])) {
  unset($_SESSION["delete_account"]);
  if ($_SESSION["user_logged_in"]["username"] == "admin") {
    throwError("Action impossible", null, "msg", true, true);
  }
  $user_id = $_SESSION["user_logged_in"]["id"];
  delRow($db, "users", "id = $user_id");
  logout("../login.php");
}
if (isset($_SESSION["delete_sessions"])) {
  unset($_SESSION["delete_sessions"]);
  $user_id = $_SESSION["user_logged_in"]["id"];
  deleteAllSessions($db, $user_id);
  throwSuccess("Toutes vos sessions ont été supprimées avec succès.", null, "msg", true, true);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title><?php echo traduction("myaccount_website_title"); ?></title>
  <link rel="stylesheet" href="../css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../js/messages.js"></script>
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include("./include/nav_panel.php"); ?>
    <div id="main">
      <div class="header">
        <h1><?php echo traduction("myaccount_header_h1"); ?></h1>
        <h2><?php echo traduction("myaccount_header_h2"); ?></h2>
      </div>
      <div class="content">
        <h2 class="content-subhead">Mon compte</h2>
        <p class="p-content">Gestion de votre compte.</p>
        <h3 class="content-subhead">Mes informations</h3>
        <msg></msg>
        <section class="forms">
          <div class="form">
            <form method="POST" action="" class="pure-form pure-form-stacked">
              <legend>Mes informations personnelles</legend>
              <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" placeholder="Nom" required pattern="<?php echo HTMLPATTERN_NAME; ?>" value="<?php echo $data_user["name"]; ?>" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
              </div>
              <div class="form-group">
                <label for="surname">Prénom</label>
                <input type="text" id="surname" name="surname" placeholder="Prénom" required pattern="<?php echo HTMLPATTERN_NAME; ?>" value="<?php echo $data_user["surname"]; ?>" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
              </div>
              <?php if ($data_user["username"] != "admin") : ?>
                <div class="form-group">
                  <label for="username">Nom d'utilisateur</label>
                  <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required pattern="<?php echo HTMLPATTERN_USERNAME; ?>" value="<?php echo $data_user["username"]; ?>" minlength="<?php echo USERNAME_MIN_LENGTH; ?>" maxlength="<?php echo USERNAME_MAX_LENGTH; ?>" />
                </div>
              <?php endif; ?>
              <button class ="button-success pure-button" name="apply_infos" type="submit">Appliquer</button>
            </form>
          </div>
          <div class="form">
            <form method="POST" action="" class="pure-form pure-form-stacked">
              <legend>Mon mot de passe</legend>
              <div class="form-group">
                <label for="password_current">Mot de passe actuel</label>
                <input type="password" id="password_current" name="password_current" placeholder="Mot de passe" required minlength="1" maxlength="<?php echo PASSWORD_MAX_LENGTH; ?>" />
              </div>
              <div class="form-group">
                <label for="password_new">Nouveau mot de passe</label>
                <input type="password" id="password_new" name="password_new" placeholder="Mot de passe" required title="Un bon mot de passe doit faire entre 7 et 32 caractères, contenir au moins une lettre, un chiffre, et un caractère spécial." minlength="<?php echo PASSWORD_MIN_LENGTH; ?>" maxlength="<?php echo PASSWORD_MAX_LENGTH; ?>" />
              </div>
              <div class="form-group">
                <label for="password_new_confirm">Confirmer le nouveau mot de passe</label>
                <input type="password" id="password_new_confirm" name="password_new_confirm" placeholder="Mot de passe" required />
              </div>
              <button class ="button-success pure-button" name="apply_password" type="submit">Appliquer</button>
            </form>
          </div>
        </section>
        <h3 class="content-subhead">Danger Zone</h3>
        <p class="p-content">Ces actions sont irréversibles.</p>
        <button class ="button-warning pure-button" onclick="delSessions()" type="button">Supprimer toutes mes sessions</button>
        <?php if ($data_user["username"] != "admin") : ?>
          <button class ="button-error pure-button" onclick="delAccount()" type="button">Supprimer mon compte</button>
        <?php endif; ?>
      </div>
    </div>
    <?php include("../include/footer.php"); ?>
  </div>
  <script>
    function delSessions() {
      if (confirm("Êtes-vous certain de vouloir supprimer toutes vos sessions ?\nCette action est irréversible.")) {
        jQuery.ajax({
          type: "POST",
          url: "myaccount.php",
          data: {delete_sessions: 0},
          success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
              window.location.href = window.location.href;
            } 
          }
        });
      }
    }

    function delAccount() {
      if (confirm("Êtes-vous certain de vouloir supprimer votre compte ? Vos sessions ne seront pas supprimées.\nCette action est irréversible.")) {
        jQuery.ajax({
          type: "POST",
          url: "myaccount.php",
          data: {delete_account: 0},
          success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
              window.location.href = window.location.href;
            } 
          }
        });
      }
    }
  </script>
  <script src="../js/ui.js"></script>
</body>
</html>