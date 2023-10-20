<?php
session_start();
include("./include/checksession.php");
include("./include/functions.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title>Accueil • web.snt.nsi.xyz</title>
  <link rel="stylesheet" href="css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div id="layout">
    <?php include("./include/nav.php"); ?>
    <div id="main">
      <div class="header">
        <h1>web.snt.nsi.xyz</h1>
        <h2>10 enigmes à résoudre pour découvrir le web</h2>
      </div>
      <div class="content"></div>
    </div>
    <?php include("./include/footer.php"); ?>
  </div>
  <script src="./js/ui.js"></script>
</body>
</html>