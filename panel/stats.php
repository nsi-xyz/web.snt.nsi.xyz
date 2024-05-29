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
  <title>Accueil • web.snt.nsi.xyz</title>
  <link rel="stylesheet" href="../css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include("./include/nav_panel.php"); ?>
    <div id="main">
      <div class="header">
        <h1>web.snt.nsi.xyz</h1>
        <h2>10 énigmes à résoudre pour découvrir le web</h2>
      </div>
      <?php
      if (isset($_GET["session"])) {
        $code = strtoupper($_GET["session"]);
        if (rowsCount($db, "sessions", "code = \"$code\"") == 1) {
          $session = getRows($db, "sessions", "*", "code = \"$code\"");
          $session_id = $session["id"];
          $session_id_owner = $session["id_owner"];
          $session_owner = getRows($db, "users", "username", "id = \"$session_id_owner\"")["username"];
          $session_users = getRows($db, "users_session", "*", "id_session = \"$session_id\"");
          include("./include/stats_widgets.php");
        }
      } else {
        echo '<div class="content">';
        include("./include/stats_nosession.php");
        echo '</div>';
      }
      ?>
      <!--<div class="content">-->
      <!--</div>-->
    </div>
    <?php include("../include/footer.php"); ?>
  </div>
  <script>
    const currentPuzzle = null;
  </script>
  <script src="../js/ui.js"></script>
</body>
</html>