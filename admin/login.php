<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title>Admin • web.snt.nsi.xyz</title>
  <link rel="stylesheet" href="css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <h1>web.snt.nsi.xyz</h1>
    <h2>Panel Admin</h2>
    <div class="log-in">
        <h2 class="content-subhead">Entrez le mot de passe :</h2>
        <?php
        echo '                <form method="POST" action="" class="pure-form">';
        if (isset($_POST['response'])) {
            $response = $_POST['response'];
            if ($response == "a") {
                echo 'Mot de passe correct.';
            } else {
                echo 'Mot de passe incorrect.';
            }
        }
        echo '                <input type="text" name="response" required>
        <button type="submit" class="pure-button">Valider</button>
        </form>';
                ?>
        <p class="p-content">Cette partie du site est réservée aux professeurs de NSI du lycée Louis Pasteur.</p>
    </div>
  </div>
  <script>
    const currentPuzzle = null;
  </script>
  <script src="./js/ui.js"></script>
  <?php include("./include/timer.php"); ?>
</body>
</html>