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
                <h2 class="content-subhead">Le mot mystère</h2>
                <p class="p-content">Sur cette page, a été cachée un mot mystère. Pour résoudre cette énigme, il faut trouver le mot mystère. Ce mot mystère n'est ni "mot" ni "mystère". La légende raconte que sur une page d'un site web, on peut cacher du texte dans le code de la page HTML.</p>
                <h2 class="content-subhead">Le web</h2>
                <p class="p-content">Le World Wide Web, communément appelé le web, est un vaste réseau d'informations interconnectées accessible via Internet. Il s'agit d'une toile virtuelle qui englobe des millions de sites web, de pages, de documents, d'images et de ressources diverses, le tout relié par des hyperliens. Le web est l'un des aspects les plus visibles et largement utilisés d'Internet, permettant aux utilisateurs du monde entier de naviguer, de rechercher, de partager et d'accéder à une multitude d'informations. Il repose sur des technologies telles que le HTML (Hypertext Markup Language), le CSS (Cascading Style Sheets) et le JavaScript pour la création de pages web interactives et attrayantes. Grâce à cette structure en toile d'araignée, le web offre une plateforme riche en contenus et en possibilités, transformant la manière dont nous communiquons, travaillons, apprenons et nous divertissons.</p>
                <h2 class="content-subhead">Le HTML</h2>
                <p class="p-content">Le HTML, acronyme de "Hypertext Markup Language" (langage de balisage hypertexte), est le langage de base utilisé pour créer des pages web. Il s'agit d'un langage de balisage qui permet de structurer le contenu d'une page web en utilisant des éléments, appelés balises, pour définir la signification et la présentation du texte et des médias. Par exemple, une balise <p> est utilisée pour définir un paragraphe de texte, tandis qu'une balise <img> est employée pour insérer une image. Le HTML joue un rôle crucial en indiquant au navigateur web comment afficher le contenu, ce qui permet de présenter le texte, les images et d'autres éléments de manière structurée et cohérente. L'une des caractéristiques intéressantes du HTML est qu'il permet d'inclure des commentaires dans le code source des pages web. Ces commentaires, délimités par <!-- et -->, sont invisibles pour les visiteurs de la page, mais ils sont visibles dans le code source. Les commentaires sont souvent utilisés par les développeurs pour ajouter des notes, des explications ou des indications sur le code, ce qui peut être très utile lors de la maintenance et de la collaboration sur un site web. Ainsi, le HTML offre la possibilité d'inclure des commentaires cachés par défaut, ce qui permet de garder une trace des détails importants concernant la structure et le fonctionnement de la page.</p>
                <h2 class="content-subhead">Le mot mystère</h2>
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
    <?php include("../include/timer.php"); ?>
    </div>
</body>
</html>