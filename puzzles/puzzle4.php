<?php
include("../include/checksession.php");
include("../include/functions.php");
include("../include/dataget.php");
$header_attributes = array("margin", "color", "text-align", "padding", "border-bottom");
if (!isset($_SESSION["magic_word_4"])) {
    $_SESSION["magic_word_4"] = $header_attributes[array_rand($header_attributes)];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/themes/prism.min.css">
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
                <h2 class="content-subhead">Trouver une propriété associé à une classe dans une feuille de style</h2>
                <p class="p-content">Dans la feuille de style de ce site, il y a des classes CSS qui définissent des propriétés. Vous devez localiser la feuille de style, lire son contenu, trouver une classe CSS et une propriété CSS.</p>
                <h2 class="content-subhead">Sélecteurs CSS</h2>
                <p class="p-content">Les sélecteurs CSS sont des motifs qui permettent d'identifier les éléments HTML auxquels vous souhaitez appliquer des styles. Par exemple, le sélecteur <span class="p-code">p</span> cible tous les éléments de paragraphe (balise <span class="p-code">&lt;p&gt;</span>) sur la page, tandis que le sélecteur <span class="p-code">h1</span> cible tous les titres de niveau 1 (balise <span class="p-code">&lt;h1&gt;</span>). Les sélecteurs peuvent être basés sur les balises HTML, les identifiants, les classes, les attributs, etc.</p>
                <h2 class="content-subhead">Classes CSS</h2>
                <p class="p-content">Une classe CSS est un moyen de définir un groupe d'éléments HTML qui partagent des styles similaires. Vous attribuez une classe à un élément en utilisant l'attribut class dans la balise HTML, par exemple : <span class="p-code">&lt;div class="maClasse"&gt;</span>. Ensuite, vous pouvez créer des règles de style CSS en utilisant le sélecteur de classe, qui commence par un point, par exemple <span class="p-code">.maClasse { propriété: valeur; }</span>. Cela permet de styliser tous les éléments ayant la classe <span class="p-code">maClasse</span> de la même manière.</p>
                <h2 class="content-subhead">Les propriétés CSS</h2>
                <pre><code class="language-css">.content {
    margin: 0 auto;
    padding: 0 2em;
    max-width: 800px;
    margin-bottom: 50px;
    line-height: 1.6em;
}</code></pre>
                <p class="p-content">La classe css <span class="p-code">.content</span> définie ci-dessus déclare 5 propriétés auxquelles elle attribue des valeurs selon le schéma suivant :<br><span class="p-code">.content { propriété: valeur; }</span></p>
                <h2 class="content-subhead">Trouver une propriété associé à une classe dans une feuille de style</h2>
                <p class="p-content">Dans la feuille de style de ce site, il y a des classes CSS qui définissent des propriétés. Vous devez <a href="../help.php#Localiser des fichiers externes" class="link">localiser</a> la feuille de style, lire son contenu, trouver la classe CSS <span class="p-code">.header</span> et une propriété CSS qu'elle définit. Vous disposez bien évidemment, comme pour chaque énigme, d'un nombre de tentatives non limité. Si la propriété ne fonctionne pas, testez-en une autre. &#x1F609;</p>
                <?php
                if (!puzzleIsResolved()) {
                echo '                <form method="GET" action="" class="pure-form">';
                if (isset($_GET['response'])) {
                    $response_f = str_replace(' ', '', strtolower($_GET["response"]));
                    $key_f = str_replace(' ', '', strtolower($_SESSION["magic_word_4"]));
                    if ($response_f == $key_f) {
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
            <script>
            const currentPuzzle = <?php echo getCurrentPuzzleID(); ?>;
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/prism.min.js"></script>
        </div>
        <?php include("../include/footer.php"); ?>
    </div>
    <script src="../js/ui.js"></script>
    <?php include("../include/timer.php"); ?>
</body>
</html>