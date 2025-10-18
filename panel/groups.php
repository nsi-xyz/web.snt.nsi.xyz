<?php
require_once '../include/bootstrap.php';
include './groups_includes/back.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title><?= $translator->getMessage('groups_website_title') ?></title>
  <link rel="stylesheet" href="../css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include './include/nav_panel.php'; ?>
    <div id="main">
      <div class="header">
        <h1><?= $translator->getMessage("groups_header_h1") ?></h1>
        <h2><?= $translator->getMessage("groups_header_h2") ?></h2>
      </div>
      <div class="content">
        <msg></msg>
        <?php include './groups_includes/creator.php'; ?>
        <?php include './groups_includes/list.php'; ?>
      </div>
    </div>
    <?php include '../include/footer.php'; ?>
  </div>
  <script src="../js/ui.js"></script>
</body>
</html>