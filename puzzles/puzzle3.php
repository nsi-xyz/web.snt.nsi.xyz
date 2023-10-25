<?php
include("../include/checksession.php");
include("../include/functions.php");
include("../include/dataget.php");
$comments_in_css_file = array("Ceci est le premier commentaire de cette feuille de style CSS", "Le sélecteur \"body\" est utilisé pour appliquer des styles à l'ensemble du contenu de la page", "Ceci est un sélecteur de classe", "L'image à laquelle cette classe est appliquée ne dépassera pas de la page", "Il y aura un class=\"content\" dans le fichier html", "Pas de marge mais un alignement au centre automatique", "Pas de marge en haut et en bas mais une marge à gauche et à droite", "Même sur un écran 4k on sera limité à 800 pixels", "Une marge externe inférieure pour augmenter l'espacement du contenu", "La distance entre les lignes de texte est égale à 1,6 fois la taille de la police courante de l'élément");
if (!isset($_SESSION["magic_word_3"])) {
    $_SESSION["magic_word_3"] = $comments_in_css_file[array_rand($comments_in_css_file)];
}
$pos = array_keys($comments_in_css_file, $_SESSION["magic_word_3"])[0] + 1;
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
                <h2 class="content-subhead">Le commentaire dans la feuille de style</h2>
                <p class="p-content">Dans la feuille de style de ce site, il y a des commentaires. Vous devez localiser la feuille de style, lire son contenu et le commentaire demandé.</p>
                <h2 class="content-subhead">Une feuille de style CSS</h2>
                <p class="p-content">Le CSS, ou Cascading Style Sheets, est un langage informatique essentiel utilisé dans le développement de sites web. Son rôle principal est de définir la présentation et l'apparence visuelle des éléments sur une page web. En d'autres termes, il permet de contrôler la façon dont les textes, images, boutons, et autres éléments sont affichés à l'écran.<br>Imaginez le CSS comme un ensemble de règles ou d'instructions qui indiquent au navigateur web comment formater et styliser chaque élément d'une page. Grâce au CSS, les concepteurs et développeurs web peuvent définir la taille, la couleur, la police de caractères, la position, les marges, et bien d'autres aspects de la mise en page. Cela permet de créer des sites web attrayants, cohérents et esthétiques.</p>
                <h2 class="content-subhead">Un commentaire CSS</h2>
                <p class="p-content">Un commentaire CSS est un texte explicatif inséré dans le code CSS d'une page web, mais qui n'a aucun impact sur l'apparence ou le fonctionnement du site. Il sert principalement à ajouter des notes pour les développeurs ou à désactiver temporairement certaines parties du code, permettant ainsi de rendre le code plus lisible et maintenable. Les commentaires CSS commencent par <span class="p-code">/*</span> et se terminent par <span class="p-code">*/</span> et sont invisibles pour les visiteurs du site, ne servant qu'à la documentation et à l'organisation du code pour les développeurs.<br><span class="p-code">/* Ceci est un commentaire CSS */</span></p>
                <h2 class="content-subhead">Le commentaire dans la feuille de style</h2>
                <p class="p-content">Dans la feuille de style de ce site, il y a des commentaires. Vous devez <a href="../help.php#Comment afficher le code source CSS d'une page web" class="link">localiser</a> la feuille de style et le <strong><?php echo $pos == 1 ? $pos."er" : $pos."ème"; ?></strong> commentaire de cette dernière.</p>
                <?php
                if (!puzzleIsResolved()) {
                echo '                <form method="GET" action="" class="pure-form">';
                if (isset($_GET['response'])) {
                    $response_f = str_replace(' ', '', str_replace('/*', '', str_replace('*/', '', $_GET["response"])));
                    $key_f = str_replace(' ', '', str_replace('/*', '', str_replace('*/', '', $_SESSION["magic_word_3"])));
                    if ($response_f == $key_f) {
                        tickPuzzle();
                    };
                };
                echo '                <input type="text" name="response" placeholder="Mot mystère" required>
                <button type="submit" class="pure-button">Valider</button>
            </form>';
                } else {
                    include("../include/table.php");
                };
                ?>
            </div>
            <script>
            const currentPuzzle = <?php echo getCurrentPuzzleID(); ?>;
            </script>
            <script src="../js/ui.js"></script>
        </div>
        <?php include("../include/footer.php"); ?>
    </div>
    <?php include("../include/timer.php"); ?>
</body>
</html>