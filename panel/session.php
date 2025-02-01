<?php
include("./include/db.php");
include("../include/functions.php");
include("../include/checksession.php");
$id_user = $_SESSION["user_logged_in"]["id"];
$session_in_progress = sessionInProgress($db, $id_user);
if ($session_in_progress) {
  $session = getRows($db, "sessions", "*", "id_owner = $id_user AND status = 1");
  $id_session = $session["id"];
  $code_session = $session["code"];
}
if (isset($_POST["stop_session"])) {
    $stop_session_id = $_POST["stop_session"];
    stopSession($db, $id_session);
    echo json_encode(["success" => true, "redir" => "./stats.php?session=$code_session"]);
    exit();
}

if (isset($_POST["kick_id"], $_POST["kick_session"], $_POST["kick_pseudo"])) {
  $user_session_id = $_POST["kick_id"];
  $user_id_session = $_POST["kick_session"];
  $user_pseudo = $_POST["kick_pseudo"];
  try {
      delRow($db, "users_session", "id = $user_session_id");
      delRow($db, "users_session_logs", "id_session = $user_id_session AND pseudo = \"$user_pseudo\"");
      echo json_encode(["success" => true]);
  } catch (Exception $e) {
      echo json_encode(["success" => false, "error" => $e->getMessage()]);
  }
  exit();
}

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
      <div class="content">
        <?php
        if ($session_in_progress) {
          include("./include/session_manage.php");
        } else {
          include("./include/session_create.php");
        }
        ?>
      </div>
    </div>
    <?php include("../include/footer.php"); ?>
  </div>
  <?php include("../include/timer.php"); ?>
  <script>
    const currentPuzzle = null;
  </script>
  <script src="../js/ui.js"></script>
</body>
</html>