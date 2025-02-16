<?php
include("./include/db.php");
include("../include/functions.php");
include("../include/checksession.php");
$user_id = $_SESSION["user_logged_in"]["id"];
$data_user = getRows($db, "users", "id, name, surname, username, created_at, last_update, last_connexion, id_group", "id = $user_id");
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
        <section class="forms">
          <div class="form">
            <form method="POST" action="" class="pure-form pure-form-stacked">
              <legend>Mes informations personnelles</legend>
              <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" placeholder="Nom" required pattern="^[^\xA0\x22\\]+$" value="<?php echo $data_user["name"]; ?>" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
              </div>
              <div class="form-group">
                <label for="surname">Prénom</label>
                <input type="text" id="surname" name="surname" placeholder="Prénom" required pattern="^[^\xA0\x22\\]+$" value="<?php echo $data_user["surname"]; ?>" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
              </div>
              <?php if ($data_user["username"] != "admin") : ?>
                <div class="form-group">
                  <label for="username">Nom d'utilisateur</label>
                  <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required pattern="^[^\s\xA0\x22\\]+$" value="<?php echo $data_user["username"]; ?>" minlength="<?php echo USERNAME_MIN_LENGTH; ?>" maxlength="<?php echo USERNAME_MAX_LENGTH; ?>" />
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
                <input type="password" id="password_current" name="password_current" placeholder="Mot de passe" required pattern="^[^\xA0\x22\\]+$" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
              </div>
              <div class="form-group">
                <label for="password_new">Nouveau mot de passe</label>
                <input type="password" id="passord_new" name="passord_new" placeholder="Mot de passe" required pattern="^[^\xA0\x22\\]+$" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
              </div>
              <div class="form-group">
                <label for="password_new_confirm">Confirmer le nouveau mot de passe</label>
                <input type="password" id="password_new_confirm" name="password_new_confirm" placeholder="Mot de passe" required pattern="^[^\s\xA0\x22\\]+$" minlength="<?php echo USERNAME_MIN_LENGTH; ?>" maxlength="<?php echo USERNAME_MAX_LENGTH; ?>" />
              </div>
              <button class ="button-success pure-button" name="apply_password" type="submit">Appliquer</button>
            </form>
          </div>
        </section>
        <h3 class="content-subhead">Danger Zone</h3>
        <p class="p-content">Ces actions sont irréversibles.</p>
        <button class ="button-warning pure-button" name="delete_sessions" type="submit">Supprimer toutes mes sessions</button>
        <button class ="button-error pure-button" name="delete_account" type="submit">Supprimer mon compte</button>
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