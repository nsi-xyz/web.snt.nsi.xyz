<?php
include("../panel/include/db.php");
include("../include/functions.php");
include("../include/checksession.php");
include("../include/dataget.php");
if (!isset($_SESSION["magic_word_6"])) {
    $_SESSION["magic_word_6"] = getMysteryLinux();
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
        <?php
        include("../include/nav.php");
        ?>
        <div id="main">
            <?php include("../include/header.php"); ?>
            <div class="content">
                <h2 class="content-subhead">Tapez un mot au clavier</h2>
                <p class="p-content">Cette page ne contient pas de formulaire de saisie mais si vous tapez <q>help</q> en pressant successivement les touches <kbd>h</kbd> <kbd>e</kbd> <kbd>l</kbd> <kbd>p</kbd> un message va s'afficher.</p>
                <h2 class="content-subhead">Un script JavaScript peut enregistrer ce que vous tapez</h2>
                <p class="p-content">Outre son rôle essentiel dans la création de fonctionnalités interactives sur les sites web, le JavaScript peut également être utilisé pour capturer les actions des utilisateurs, y compris ce qu'ils tapent sur leur clavier. Cette capacité permet de concevoir des fonctionnalités avancées telles que la saisie prédictive, la validation en temps réel des formulaires et même des applications de chat en direct.</p>
                <h2 class="content-subhead">Un script JavaScript peut vous espionner</h2>
                <p class="p-content">Des scripts JavaScript malveillants, souvent intégrés dans des sites web compromis ou dans des extensions de navigateur douteuses, peuvent potentiellement enregistrer les actions des utilisateurs, y compris les frappes au clavier, les interactions de la souris et d'autres données personnelles.</p>
                <h2 class="content-subhead">Tapez un mot au clavier</h2>
                <p class="p-content">Le code source JavaScript <a href="../help.php#Inclusion des scripts JavaScript" class="link">intégré directement dans le code HTML de cette page</a> contient le mot clé, qu'il faudra taper sur cette page, pour réussir cette énigme.</p>
                <?php
                if (isset($_COOKIE["puzzle6"])) {
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
    let index = 0;
    let magic_word = "<?php echo $_SESSION["magic_word_6"]; ?>";
    const currentPuzzle = <?php echo getCurrentPuzzleID(); ?>;
    </script>
    <script src="../js/ui.js"></script>
    <?php include("../include/timer.php"); ?>
</body>
</html>