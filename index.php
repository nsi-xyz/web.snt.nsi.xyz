<?php
include("./panel/include/db.php");
include("./include/functions.php");
include("./include/checksession.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title><?php echo traduction("global_website_title"); ?></title>
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
        <h1><?php echo traduction("global_website_name"); ?></h1>
        <h2><?php echo traduction("global_website_description"); ?></h2>
        <?php include("./include/table.php"); ?>
      </div>
      <div class="content">
        <h2 class="content-subhead"><?php echo traduction("home_content_web_meaning_title"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_web_meaning_message"); ?></p>
        <h2 class="content-subhead"><?php echo traduction("home_content_snt_meaning_title"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_snt_meaning_meaning_message"); ?></p>
        <h2 class="content-subhead"><?php echo traduction("home_content_nsi_meaning_title"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_nsi_meaning_message"); ?></p>
        <h2 class="content-subhead"><?php echo traduction("home_content_xyz_meaning_title"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_xyz_meaning_message"); ?></p>
        <h2 class="content-subhead"><?php echo traduction("home_content_websntnsixyz_meaning_title"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_websntnsixyz_meaning_message"); ?></p>
        <h2 class="content-subhead"><?php echo traduction("home_content_starter_title"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_starter_message"); ?></p>
      </div>
    </div>
    <?php include("./include/footer.php"); ?>
  </div>
  <script src="./js/ui.js"></script>
  <?php include("./include/timer.php"); ?>
</body>
</html>