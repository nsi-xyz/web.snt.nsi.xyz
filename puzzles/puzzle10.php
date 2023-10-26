<?php
include("../include/checksession.php");
include("../include/functions.php");
include("../include/dataget.php");
if (!isset($_SESSION["magic_word_10"])) {
    $_SESSION["magic_word_10"] = getMysteryColor();
};
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo setPageTitle(); ?></title>
    <link rel="stylesheet" href="../css/pure-min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div id="layout">
        <a href="#menu" id="menuLink" class="menu-link">
            <span></span>
        </a>
        <?php include("../include/nav.php"); ?>
        <div id="main">
            <?php include("../include/header.php"); ?>
            <?php include("../include/compute.php"); ?>
            <div class="content">
                <h2 class="content-subhead">Partie 1 : La modification manuelle de l'URL</h2>
                <p class="p-content">Pour accéder à cette page, vous avez dû modifier manuellement l'adresse web. En effet, l'énigme 10 n'est pas reliée initialement aux autres énigmes par un lien hypertexte, le menu ayant été désactivé.</p>
                <p class="p-back-message">Vous avez résolu la première partie de cette énigme, elle apparaît désormais dans le menu.</p>
                <h2 class="content-subhead">Tout n'est que codage / décodage / encodage</h2>
                <p class="p-content">Faire une page web, c'est encoder une information dans un langage de balisage appelé HTML. Améliorer la charte graphique de ce site, consiste à coder des choix de couleurs, de marges (...) dans un fichier de style <span class="p-code">.css</span>.<br>Les couleurs sont elles même codées, elles peuvent être au format décimale (R,G,B) ou au format hexadécimal, ainsi on s'affranchit de la barrière de de langue et on parle tous une même langue.<br>Pour accéder à cette page <q>cachée</q>, vous avez dû analyser l'URL des autres pages, comprendre la structure du site, et vous avez tenté votre chance avec succès.</p>
                <h2 class="content-subhead">Partie 2 :</h2>
                <p class="p-content">La réponse à l'énigme est <strong><?php echo $_SESSION["magic_word_10"]["hex"]; ?></strong>.</p>
                <?php
                if (!puzzleIsResolved()) {
                echo '                <form method="GET" action="" class="pure-form">';
                if (isset($_GET['response'])) {
                    $response = $_GET['response'];
                    if (strtoupper($response) == strtoupper($_SESSION["magic_word_10"]["name"])) {
                        tickPuzzle();
                    }
                }
                echo '                <input type="text" name="response" placeholder="Réponse énigme '.getCurrentPuzzleID().'" required>
                <button type="submit" class="pure-button">Valider</button>
            </form>';
                } else {
                    include("../include/table.php");
                }
                ?>
            </div>
            <?php include("../include/footer.php"); ?>
            <script>
            const currentPuzzle = <?php echo getCurrentPuzzleID(); ?>;
            </script>
            <script src="../js/ui.js"></script>
        </div>
    <?php include("../include/timer.php"); ?>
    </div>
</body>
</html>