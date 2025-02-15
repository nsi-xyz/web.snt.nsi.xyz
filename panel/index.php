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
  <title><?php echo traduction("panel_website_title"); ?></title>
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
        <h1><?php echo traduction("panel_header_h1"); ?></h1>
        <h2><?php echo traduction("panel_header_h2"); ?></h2>
      </div>
      <div class="content">
        <h2 class="content-subhead">Panneau d'administration</h2>
        <p class="p-content">Bienvenue sur le panneau d'administration de web.snt.nsi.xyz !</p>
        <p class="p-content">Ce panneau vous permet de créer des sessions, par exemple pour vos élèves si vous êtes enseignant, de parcourir vos anciennes sessions et d'avoir des statistiques détaillés sur ces dernières.</p>
        <h2 class="content-subhead">En quelques chiffres</h2>
        <p class="p-content"></p>
        <h2 class="content-subhead">Gestion des données</h2>
        <p class="p-content">Toutes les données enregistrées le sont de manière sécurisée. Cela concerne les données de votre compte, ou encore les données relatives à vos sessions (pseudos des participants, résultats, etc.). Vous pouvez à tout moment demander la suppression de vos données et celles de vos sessions. Pour exercer ce droit, veuillez nous contacter.</p>
        <h2 class="content-subhead">Nous contacter</h2>
        <p class="p-content">Pour contacter un administrateur du site, utilisez le formulaire de contact sur <a class="link" href="https://nsi.xyz/nous-contacter/" target="_blank">nsi.xyz</a>.</p>
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