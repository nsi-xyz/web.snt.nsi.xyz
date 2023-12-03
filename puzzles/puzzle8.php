<?php
include("../include/checksession.php");
include("../include/functions.php");
if (!isset($_SESSION["target_value_8"])) {
    $puzzle8_target_seed = str_pad(rand(0, 99999999), 8, "0", STR_PAD_LEFT);
    $_SESSION["target_value_8"] = $puzzle8_target_seed."42";
} elseif (isset($_COOKIE[COOKIE8["name"]])) {
    if ($_COOKIE[COOKIE8["name"]] == $_SESSION["target_value_8"]) {
        setcookie(COOKIE8["name"], "", time() - SESSDURATION, "/");
    }
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
                <h2 class="content-subhead">Modifier le cookie relatif à l'énigme 8</h2>
                <p class="p-content">Pour résoudre cette énigme, il va falloir modifier un cookie. Attention, effacer tous les cookies réinitialise le jeu, tu perds les énigmes que tu as déjà résolu, modifier le mauvais cookie peut avoir le même effet.</p>
                <h2 class="content-subhead">Modifier un cookie ? &#x1F36A;</h2>
                <p class="p-content">Il est possible de modifier un cookie, comme si vous modifiez un petit mot dans une note que vous avez laissée à vous-même. Par exemple, si un site web se souvient de votre préférence pour une couleur, vous pouvez utiliser un petit programme pour changer cette préférence. Cependant, certaines informations dans les cookies sont comme des codes secrets qui ne devraient pas être changés, car cela peut causer des problèmes de sécurité. Il est important de ne pas utiliser cette capacité pour faire des choses non autorisées, car cela peut être illégal et contraire aux règles des sites web.</p>
                <h2 class="content-subhead">Modifier le cookie relatif à l'énigme 8</h2>
                <p class="p-content">Pour résoudre cette énigme, il va falloir <a href="../help.php#Modifier / supprimer un cookie" class="link">modifier un cookie</a>. Ce cookie contient pour l'instant un nombre finissant par <span class="p-code">404</span>. Vous devez remplacer ce nombre par <span class="p-code"><?php echo $_SESSION["target_value_8"]; ?></span>. Attention, il ne faut en aucun cas modifier le cookie de session.<br>Après avoir modifier le cookie, pensez à <a href="../help.php#Comment rafraîchir / actualiser une page web" class="link">rafraîchir la page</a>.</p>
                <?php
                if (isset($_COOKIE[COOKIE8["name"]]) && $_COOKIE[COOKIE8["name"]] == $_SESSION["target_value_8"]) {
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