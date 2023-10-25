<?php
include("../include/checksession.php");
include("../include/functions.php");
$tick = FALSE;
if (!isset($_COOKIE[COOKIE7["name"]])) {
    $tick = TRUE;
    setcookie(COOKIE7["name"], "", time() - SESSDURATION, "/");
}
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
                <h2 class="content-subhead">Effacer un cookie espion</h2>
                <p class="p-content">Pour résoudre cette énigme, il va falloir effacer un cookie. Attention, effacer tous les cookies réinitialise le jeu, tu perds les énigmes que tu as déjà résolu, donc lis attentivement les consignes.</p>
                <h2 class="content-subhead">Un cookie ? &#x1F60B;</h2>
                <p class="p-content">Un cookie est un petit morceau de données stocké sur l'ordinateur d'un utilisateur lorsqu'il visite un site web. Les cookies sont utilisés par les sites web pour stocker des informations temporaires, comme les préférences de l'utilisateur, les données de connexion, ou le suivi de l'activité sur le site. Ils permettent au site de se souvenir de l'utilisateur lors de visites ultérieures, ce qui peut améliorer l'expérience utilisateur en personnalisant le contenu ou en maintenant une session active. Dans le cadre de la sécurité et de la vie privée, les utilisateurs ont généralement le contrôle sur la gestion et la suppression des cookies sur leur navigateur.</p>
                <h2 class="content-subhead">Un cookie pour les surveiller tous !</h2>
                <p class="p-content">Les cookies, initialement conçus pour améliorer l'expérience utilisateur en permettant aux sites web de stocker des informations temporaires, ont malheureusement été détournés de leur fonction première pour le traçage des utilisateurs. Cette pratique, souvent appelée <q>traçage par cookies</q> ou <q>tracking par cookies</q>, implique l'utilisation de ces petits fichiers pour collecter des informations sur le comportement de l'utilisateur en ligne. Les annonceurs et les entreprises de suivi utilisent des cookies pour suivre les sites web que vous visitez, les produits que vous consultez, et même vos intérêts personnels. Ces données sont ensuite utilisées pour créer des profils d'utilisateurs, permettant aux annonceurs de diffuser des publicités ciblées.</p>
                <h2 class="content-subhead">Effacer un cookie espion</h2>
                <p class="p-content">Pour résoudre cette énigme, il va falloir effacer un cookie : <span class="p-code"><?php echo COOKIE7["name"]; ?></span>.<br>Après avoir supprimer le cookie, veillez rafraîchir la page en utilisant la touche <kbd>F5</kbd>.</p>
                <?php
                if ($tick === TRUE) {
                    tickPuzzle();
                }
                if (puzzleIsResolved()) {
                    include("../include/table.php");
                }
                ?>
            </div>
        </div>
    <?php include("../include/footer.php"); ?>
    </div>
    <script>
    const currentPuzzle = <?php echo getCurrentPuzzleID(); ?>;
    </script>
    <script src="../js/ui.js"></script>
    <?php include("../include/timer.php"); ?>
</body>
</html>