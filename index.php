<?php
include("./include/checksession.php");
include("./include/functions.php");
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
  <a href="#menu" id="menuLink" class="menu-link">
    <span></span>
  </a>
  <div id="main">
    <div class="header">
      <h1>web.snt.nsi.xyz</h1>
      <h2>10 énigmes à résoudre pour découvrir le web</h2>
    </div>
    <section class="forms">
      <div class="form">
        <form class="pure-form pure-form-stacked">
          <fieldset>
            <legend>Je suis élève</legend>
            <label for="aligned-foo">Nom d'utilisateur</label>
            <input type="text" id="aligned-foo" placeholder="Nom d'utilisateur"/><br>
            <label for="aligned-foo">Code de la session</label>
            <input type="text" id="aligned-foo" placeholder="Code de la session"/><br>
            <button type="submit" class="pure-button pure-button-primary-join">Rejoindre</button>
          </fieldset>
        </form>
      </div>
      <div class="form">
      <form class="pure-form pure-form-stacked">
          <fieldset>
            <legend>Je suis enseignant</legend>
            <label for="stacked-email">Adresse e-mail</label>
            <input type="email" id="stacked-email" placeholder="Adresse e-mail"/><br>
            <label for="stacked-password">Mot de passe</label>
            <input type="password" id="stacked-password" placeholder="Mot de passe"/><br>
            <button type="submit" class="pure-button pure-button-primary-join">Valider</button>
          </fieldset>
        </form>
      </div>
    </section>
  </div>
  <?php include("./include/footer.php"); ?>
</body>
</html>