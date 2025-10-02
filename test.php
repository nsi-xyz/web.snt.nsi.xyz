<?php
require_once __DIR__ . '/include/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title>test 3.0</title>
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
    <div id="main">
      <div class="header">
        <h1>web.snt.nsi.xyz</h1>
        <h2>10 énigmes à résoudre pour découvrir le web</h2>
      </div>
      <div class="content">
        <info></info>
        <h2 class="content-subhead">Sandbox</h2>
        <?php
        $sessionsTimes = [];
        $gameSessions = (new GameSessionRepository($db))->getOpenSessions();
        foreach ($gameSessions as $gameSession) {
          $sessionsTimes[$gameSession->getId()] = $gameSession->getTimeLeft();
        }
        ?>
        <?php foreach ($gameSessions as $gameSession): ?>
          <p>Session "<?= $gameSession->getName() ?>" de <?= $gameSession->getHost()->getFullName() ?></p>
          <timer gamesessionid="<?= $gameSession->getId(); ?>"></timer>
        <?php endforeach; ?>
        <timer></timer>
        <?php include './include/timer.php'; ?>
      </div>
    </div>
  </div>
  <script src="./js/ui.js"></script>
</body>
</html>