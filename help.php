<?php
require_once './include/bootstrap.php';
include("./panel/include/db.php");
include("./include/functions.php");
?>
<!-- Ceci est un commentaire HTML. Le code que vous voyez ci-dessous est le code de la page "help" -->
<!-- Vous avez donc compris comment afficher la source d'une page HTML, vous devez cherchez les réponses aux énigmes dans  sources des pages des énigmes-->
<!-- Autrement dit, il n'y à rien à trouver dans le code source de cette page.-->
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include("./include/nav.php"); ?>
    <div id="main">
      <div class="header">
        <h1><?php echo traduction("help_header_h1"); ?></h1>
        <h2><?php echo traduction("help_header_h2"); ?></h2>
        <h3 class="h3-help"><?php echo traduction("help_header_h3"); ?></h3>
      </div>
      <div class="content">
        <h2 id="<?php echo traduction("help_content_subhead1_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead1_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead1_p"); ?></p>
        <h2 id="<?php echo traduction("help_content_subhead2_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead2_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead2_p"); ?></p>
        <h2 id="<?php echo traduction("help_content_subhead3_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead3_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead3_p"); ?></p>
        <h2 id="<?php echo traduction("help_content_subhead4_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead4_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead4_p"); ?></p>
        <h2 id="<?php echo traduction("help_content_subhead5_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead5_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead5_p"); ?></p>
        <h2 id="<?php echo traduction("help_content_subhead6_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead6_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead6_p"); ?></p>
        <h2 id="<?php echo traduction("help_content_subhead7_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead7_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead7_p"); ?></p>
        <h2 id="<?php echo traduction("help_content_subhead8_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead8_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead8_p"); ?></p>
        <h2 id="<?php echo traduction("help_content_subhead9_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead9_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead9_p"); ?></p>
        <h2 id="<?php echo traduction("help_content_subhead10_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead10_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead10_p1"); ?></p>
        <p class="p-content"><?php echo traduction("help_content_subhead10_p2"); ?></p>
        <p class="p-content"><?php echo traduction("help_content_subhead10_p3"); ?></p>
        <p class="p-content"><?php echo traduction("help_content_subhead10_p4"); ?></p>
        <p class="p-content"><?php echo traduction("help_content_subhead10_p5"); ?></p>
        <h2 id="<?php echo traduction("help_content_subhead11_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead11_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead11_p1"); ?></p>
        <table class="pure-table">
          <thead>
            <tr>
              <th><?php echo traduction("global_browser_msedge_name"); ?></th>
              <th><?php echo traduction("global_browser_mzfirefox_name"); ?></th>
              <th><?php echo traduction("global_browser_gchrome_name"); ?></th>
              <th><?php echo traduction("global_browser_asafari_name"); ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a class="link" href="<?php echo traduction("external_cookie_extension_msedge_link"); ?>" target="_blank"><?php echo traduction("external_cookie_extension_msedge_name"); ?></a></td>
              <td><a class="link" href="<?php echo traduction("external_cookie_extension_mzfirefox_link"); ?>" target="_blank"><?php echo traduction("external_cookie_extension_mzfirefox_name"); ?></a></td>
              <td><a class="link" href="<?php echo traduction("external_cookie_extension_gchrome_link"); ?>" target="_blank"><?php echo traduction("external_cookie_extension_gchrome_name"); ?></a></td>
              <td><a class="link" href="<?php echo traduction("external_cookie_extension_asafari_link"); ?>" target="_blank"><?php echo traduction("external_cookie_extension_asafari_name"); ?></a></td>
            </tr>
          </tbody>
        </table>
        <p class="p-content"><?php echo traduction("help_content_subhead11_p2"); ?></p>
        <h2 id="<?php echo traduction("help_content_subhead12_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_subhead12_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_subhead12_p"); ?></p>
        <h2 id="Bloquer les publicités" class="content-subhead"></h2>
        <p class="p-content"></p>
        <table class="pure-table">
          <thead>
            <tr>
              <th><?php echo traduction("global_browser_msedge_name"); ?></th>
              <th><?php echo traduction("global_browser_mzfirefox_name"); ?></th>
              <th><?php echo traduction("global_browser_gchrome_name"); ?></th>
              <th><?php echo traduction("global_browser_asafari_name"); ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a class="link" href="<?php echo traduction("external_adblock_extension_msedge_link"); ?>" target="_blank"><?php echo traduction("external_adblock_extension_msedge_name"); ?></a></td>
              <td><a class="link" href="<?php echo traduction("external_adblock_extension_mzfirefox_link"); ?>" target="_blank"><?php echo traduction("external_adblock_extension_mzfirefox_name"); ?></a></td>
              <td><a class="link" href="<?php echo traduction("external_adblock_extension_gchrome_link"); ?>" target="_blank"><?php echo traduction("external_adblock_extension_gchrome_name"); ?></a></td>
              <td><a class="link" href="<?php echo traduction("external_adblock_extension_asafari_link"); ?>" target="_blank"><?php echo traduction("external_adblock_extension_asafari_name"); ?></a></td>
            </tr>
          </tbody>
        </table>
        <?php if (isUserConnected()) : ?>
        <h2 id="<?php echo traduction("help_content_reset_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_logout_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_logout_p"); ?></p>
        <button class ="reset-button" type="button" onclick="location.href='./logout.php'"><?php echo traduction("help_content_button_logout"); ?></button>
        <?php elseif (currentUserInSession()) : ?>
        <h2 id="<?php echo traduction("help_content_reset_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_leavesession_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_leavesession_p"); ?></p>
        <button class ="reset-button" type="button" onclick="location.href='./logout.php?reset'"><?php echo traduction("help_content_button_leavesession"); ?></button>
        <?php else : ?>
        <h2 id="<?php echo traduction("help_content_reset_h2"); ?>" class="content-subhead"><?php echo traduction("help_content_reset_h2"); ?></h2>
        <p class="p-content"><?php echo traduction("help_content_reset_p"); ?></p>
        <button class ="reset-button" type="button" onclick="location.href='./logout.php?reset'"><?php echo traduction("help_content_button_reset"); ?></button>
        <?php endif; ?>
      </div>
    </div>
    <?php include("./include/footer.php"); ?>
  </div>
  <script>
    const currentPuzzle = null;
  </script>
  <script src="./js/ui.js"></script>
  <?php include("./include/timer.php"); ?>
</body>
</html>
