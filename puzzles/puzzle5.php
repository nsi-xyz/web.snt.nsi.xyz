<?php
include("../include/checksession.php");
include("../include/functions.php");
include("../include/dataget.php");
$comments_in_js_file = array("This function retrieves HTML elements that we frequently use, such as the menu and links, based on their identifiers.", "This function adds or removes a CSS class from an element to toggle its active state.", "We iterate through the existing classes to find the class to add or remove.", "If the class exists, we remove it.", "If the class has not been found, we add it.", "We update the list of classes for the element.", "This function toggles the active state of multiple elements, such as the layout, menu, and menuLink.", "The name of the CSS class is \"active\".", "This function handles click events on the page.", "If the click occurs on the menu link, we toggle the active state.");
if (!isset($_SESSION["magic_word_5"])) {
    $_SESSION["magic_word_5"] = $comments_in_js_file[array_rand($comments_in_js_file)];
}
$pos = array_keys($comments_in_js_file, $_SESSION["magic_word_5"])[0] + 1;
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
                <h2 class="content-subhead">Le commentaire dans le script JavaScript</h2>
                <p class="p-content">Dans le script JavaScript de ce site, il y a des commentaires. Vous devez localiser le script JavaScript, lire son contenu et le commentaire demandé.</p>
                <h2 class="content-subhead">Un script JavaScript</h2>
                <p class="p-content">Le JavaScript, souvent abrégé en JS, est un langage de programmation essentiel pour le développement web. Il joue un rôle crucial en permettant aux sites web d'ajouter des fonctionnalités interactives et dynamiques. Contrairement au HTML, qui se concentre sur la structure et le contenu d'une page, le JavaScript permet de rendre les pages web réactives et vivantes.</p>
                <h2 class="content-subhead">Un commentaire JavaScript</h2>
                <p class="p-content">Un commentaire JavaScript est un texte explicatif inséré dans le code source JavaScript d'une page web. Ces commentaires ne sont pas pris en compte par le navigateur web lors de l'exécution du code, mais ils servent à fournir des explications aux développeurs ou à documenter le code. Les commentaires JavaScript sont encadrés par les symboles <span class="p-code">/*</span> pour commencer et <span class="p-code">*/</span> pour terminer, ou par <span class="p-code">//</span> pour des commentaires sur une seule ligne. Ils aident les développeurs à comprendre le fonctionnement du code, à ajouter des notes, à désactiver temporairement des parties du code, ou à collaborer plus efficacement sur un projet en partageant des informations importantes.<br><span class="p-code">// Ceci est un commentaire JavaScript</span></p>
                <h2 class="content-subhead">Le commentaire dans le script JavaScript</h2>
                <p class="p-content">Dans le script JavaScript, il y a des commentaires. Vous devez <a href="../help.php#Comment afficher le code source JavaScript d'une page web" class="link">localiser</a> le script JavaScript et le <strong><?php echo $pos == 1 ? $pos."er" : $pos."ème"; ?></strong> commentaire de ce dernier.</p>
                <?php
                if (!puzzleIsResolved()) {
                echo '                <form method="GET" action="" class="pure-form">';
                if (isset($_GET['response'])) {
                    $response_f = str_replace(' ', '', str_replace('//', '', $_GET["response"]));
                    $key_f = str_replace(' ', '', str_replace('//', '', $_SESSION["magic_word_5"]));
                    if ($response_f == $key_f) {
                        tickPuzzle();
                    }
                }
                echo '                <input type="text" name="response" placeholder="Mot mystère" required>
                <button type="submit" class="pure-button">Valider</button>
            </form>';
                } else {
                    include("../include/table.php");
                }
                ?>
            </div>
            <script>
            const currentPuzzle = <?php echo getCurrentPuzzleID(); ?>;
            </script>
            <script src="../js/ui.js"></script>
        </div>
        <?php include("../include/footer.php"); ?>
    </div>
    <script src="../js/ui.js"></script>
    <?php include("../include/timer.php"); ?>
</body>
</html>