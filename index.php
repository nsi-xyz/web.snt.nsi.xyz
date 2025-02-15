<?php
include "./panel/include/db.php";
include "./include/functions.php";
include "./include/checksession.php";
?>
<!DOCTYPE html> <!-- <?php echo traduction("comment_index_welcome"); ?> -->
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title><?php echo traduction("global_website_title"); ?></title>
  <link rel="stylesheet" href="css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="css/style.css">
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
        <h1><?php echo traduction("home_header_h1"); ?></h1>
        <h2><?php echo traduction("home_header_h2"); ?></h2>
        <?php include("./include/table.php"); ?>
      </div>
      <div class="content">
        <msg></msg>
        <info></info>
        <h2 class="content-subhead"><?php echo traduction("home_content_subhead1_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_subhead1_p"); ?></p>
        <h2 class="content-subhead"><?php echo traduction("home_content_subhead2_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_subhead2_p"); ?></p>
        <h2 class="content-subhead"><?php echo traduction("home_content_subhead3_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_subhead3_p"); ?></p>
        <h2 class="content-subhead"><?php echo traduction("home_content_subhead4_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_subhead4_p"); ?></p>
        <h2 class="content-subhead"><?php echo traduction("home_content_subhead5_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_subhead5_p"); ?></p>
        <h2 class="content-subhead"><?php echo traduction("home_content_subhead6_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("home_content_subhead6_p"); ?></p>
      </div>
    </div>
    <?php include("./include/footer.php"); ?>
    <?php if ((strpos(traduction("info_home"), "Missing Translation") === false) && (traduction("info_home") != "")) : ?>
      <script>
        throwInfo("<?php echo traduction("info_home"); ?>", "info");
      </script>
    <?php endif; ?>
  </div>
  <script src="./js/ui.js"></script>
  <?php include("./include/timer.php"); ?>
</body>
</html>