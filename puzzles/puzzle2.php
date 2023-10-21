<?php
session_start();
include("../include/checksession.php");
include("../include/functions.php");
include("../include/dataget.php");
$comments_in_css_file = array("", "", "", "", "", "", "");
if (!isset($_SESSION["magic_word_2"])) {
    $_SESSION["magic_word_2"] = getMysteryTag();
};
$slot = rand(1, 2);
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
                <h2 class="content-subhead">Le mot invisible</h2>
                <p class="p-content">Sur cette page, a été cachée un mot invisible. Pour résoudre cette énigme, il faut trouver le mot invisible. Ce mot est affiché sur cette page, il est certes également dans le code source de la page, mais en plus il est aussi affiché sur cette page, sauf que tu ne peux pas le voir. Du coup il est invisible. <?php echo $slot == 1 ? '<span class="mystere">'.$_SESSION["magic_word_2"].'</span>' : ''; ?></p>
                <h2 class="content-subhead">Le CSS</h2>
                <p class="p-content">Le CSS, ou Cascading Style Sheets (Feuilles de style en cascade), est un langage de programmation essentiel pour la conception de sites web. Il permet de contrôler l'apparence et la mise en page de vos pages web. Une de ses nombreuses fonctionnalités est la capacité de modifier la couleur du texte. En utilisant des règles CSS, vous pouvez spécifier la couleur du texte de manière précise. Par exemple, en définissant la propriété <q>color</q> (couleur) d'un élément HTML, vous pouvez changer la couleur du texte en fonction de vos préférences. Le CSS offre une flexibilité exceptionnelle pour personnaliser l'apparence de vos pages web, ce qui en fait un outil puissant pour changer rapidement le design d'un site web. <?php echo $slot == 2 ? '<span class="mystere">'.$_SESSION["magic_word_2"].'</span>' : ''; ?></p>
                <h2 class="content-subhead">Le mot invisible</h2>
                <p class="p-content">Pour résoudre l'énigme du <q>Mot invisible</q>, vous devez rechercher minutieusement dans les recoins de la page. Rappelez-vous que parfois, la vérité peut être cachée dans la clarté. Soyez attentif aux ombres et aux espaces vides. Les mots peuvent se cacher même en plein jour. Explorez, soyez curieux et observez chaque coin de la page, chaque ligne de code. La solution est là, juste sous vos yeux, mais elle attend que vous la découvriez.</p>
                <?php
                if (!puzzleIsResolved()) {
                echo '                <form method="GET" action="" class="pure-form">';
                if (isset($_GET['response'])) {
                    $response = $_GET['response'];
                    if ($response == $_SESSION["magic_word_2"]) {
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
            <script src="../js/ui.js"></script>
        </div>
        <style>
            .mystere {
                color: white;
            }
        </style>
        <?php include("../include/footer.php"); ?>
    </div>
</body>
</html>