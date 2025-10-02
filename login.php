<?php
require_once './include/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $translator->getMessage('login_website_title') ?></title>
  <link rel="stylesheet" href="css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="./js/login.js"></script>
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include './include/nav.php'; ?>
    <div id="main">
      <div class="header">
        <h1><?= $translator->getMessage('login_header_h1') ?></h1>
        <h2><?= $translator->getMessage('login_header_h2') ?></h2>
        <h3 class="h3-login"><?= $translator->getMessage('login_header_h3') ?></h3>
      </div>
      <div class="content">
        <h2 id="S'identifier" class="content-subhead"><?= $translator->getMessage('login_content_subhead1_h2') ?></h2>
        <p class="p-content"><?= $translator->getMessage('login_content_subhead1_p1') ?></p>
        <p class="p-content"><?= $translator->getMessage('login_content_subhead1_p2') ?></p>
        <h3 class="content-subhead"><?= $translator->getMessage('login_content_subhead2_h3') ?></h3>
        <p class="p-content"><?= $translator->getMessage('login_content_subhead2_p') ?></p>
        <msg></msg>
        <section class="forms">
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
          </div>
            <div id="login-form" class="form">
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
              <p>Vous êtes professeur ? <br><a class="create-account" id="switch-to-register">Créez votre compte !</a></p>

            </div>
            <div id="register-form" class="form" style="display: none;">
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
                    <input type="text" id="new-username" name="username" placeholder="Nom d'utilisateur" required pattern="<?php echo HTMLPATTERN_USERNAME; ?>" minlength="<?php echo USERNAME_MIN_LENGTH; ?>" maxlength="<?php echo USERNAME_MAX_LENGTH; ?>" />
                  </div>
                  <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="new-password" name="password" placeholder="Mot de passe" required title="Un bon mot de passe doit faire entre 7 et 32 caractères, contenir au moins une lettre, un chiffre, et un caractère spécial." minlength="<?php echo PASSWORD_MIN_LENGTH; ?>" maxlength="<?php echo PASSWORD_MAX_LENGTH; ?>" />
                  </div>
                </fieldset>
                <button type="submit" class="pure-button pure-button-primary-join">Créer un compte</button>
              </form>
              <p>Vous avez déjà un compte ? <br><a class="create-account" id="switch-to-login">Vous connectez</a></p>
            </div>
        </section>
      </div>
    </div>
    <?php require_once './include/logback.php'; ?>
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