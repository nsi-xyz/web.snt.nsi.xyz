<?php
include "./include/db.php";
include "../include/functions.php";
include "../include/checksession.php";
if (isset($_POST["delete_session"])) {
  $_SESSION["id_session_delete"] = $_POST["delete_session"];
  echo json_encode(["success" => true]);
  exit();
}
if (isset($_SESSION["id_session_delete"])) {
  deleteSession($db, $_SESSION["id_session_delete"]);
  unset($_SESSION["id_session_delete"]);
  throwSuccess("La session a été supprimée avec succès.", null, "msg", true, true);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title><?php echo traduction("stats_website_title"); ?></title>
  <link rel="stylesheet" href="../css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/messages.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div id="layout">
    <?php if (!isset($_GET["share"])) : ?>
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include "./include/nav_panel.php"; ?>
    <?php endif; ?>
    <div id="main">
      <div class="header">
        <h1><?php echo traduction("stats_header_h1"); ?></h1>
        <h2><?php echo traduction("stats_header_h2"); ?></h2>
      </div>
      <div class="content">
        <msg></msg>
        <?php
        if (isset($_GET["session"])) {
          $code = strtoupper($_GET["session"]);
          if (rowsCount($db, "sessions", "code = \"$code\"") == 1) {
            $session = getRows($db, "sessions", "*", "code = \"$code\"");
            $session_id = $session["id"];
            $session_id_owner = $session["id_owner"];
            $session_owner = getRows($db, "users", "username", "id = \"$session_id_owner\"")["username"];
            $session_users = getRows($db, "users_session", "*", "id_session = \"$session_id\"", 1);
            if (isUserConnected() && $_SESSION["user_logged_in"]["id"] != $session_id_owner && !isset($_GET["share"]) && $_SESSION["user_logged_in"]["id_group"] == 0) {
              throwError(traduction("error_not_authorized_message"), "./index.php", "msg", true, false);
            }
            include "./include/stats_viewer.php";
          }
        } else {
          include "./include/stats_nosession.php";
        }
        ?>
      </div>
    </div>
    <?php include "../include/footer.php"; ?>
  </div>
  <script>
    const urlParams = new URLSearchParams(window.location.search);
    const shared = urlParams.has("share");
    if (shared) {
      document.getElementById("layout").style.paddingLeft = 0;
      document.getElementById("footer").style.backgroundColor = "#FFF";
    }
  </script>
  <script src="../js/ui.js"></script>
</body>
</html>