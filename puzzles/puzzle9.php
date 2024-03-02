<?php
include("../panel/include/db.php");
include("../include/functions.php");
include("../include/checksession.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo setPageTitle();?></title>
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
            <div class="content">
                <h2 class="content-subhead">Installer un bloqueur de publicité</h2>
                <p class="p-content">Vous devez installer dans ce navigateur un bloqueur de publicité. Après avoir installé un tel bloqueur, il faudra rafraîchir la page.</p>
                <h2 class="content-subhead">La publicité en ligne</h2>
                <p class="p-content">La publicité en ligne, également connue sous le nom de publicité numérique, est un moyen de promotion et de communication commerciale qui se déroule sur Internet. Elle englobe une variété de formats, notamment les bannières, les vidéos, les liens sponsorisés, les publicités sur les réseaux sociaux, les publicités natives, et plus encore. Ces annonces sont diffusées sur des sites web, des réseaux sociaux, des moteurs de recherche, des applications mobiles et d'autres plateformes en ligne. La publicité en ligne permet aux annonceurs de cibler précisément leur audience en fonction de critères tels que la démographie, les centres d'intérêt et le comportement en ligne. Elle joue un rôle clé dans la génération de leads, la vente de produits et services, et la construction de la notoriété de la marque. Elle est mesurable, ce qui permet aux annonceurs d'analyser les performances de leurs campagnes et d'ajuster leur stratégie en conséquence. Cependant, elle suscite également des préoccupations en matière de respect de la vie privée et d'adéquation aux réglementations en vigueur, notamment en matière de protection des données.</p>
                <h2 class="content-subhead">Bloquer la publicité en ligne</h2>
                <p class="p-content">Il est souhaitable de bloquer la publicité en ligne pour plusieurs raisons. Tout d'abord, la publicité intrusive peut être agaçante pour les utilisateurs, perturbant leur expérience en ligne en envahissant leur navigation avec des annonces non pertinentes. De plus, la publicité peut collecter des données personnelles sans le consentement des utilisateurs, soulevant des préoccupations en matière de protection de la vie privée. Le suivi comportemental et la collecte de données pour le ciblage publicitaire soulèvent des questions sur l'utilisation responsable des informations personnelles. En bloquant les publicités, les utilisateurs peuvent mieux contrôler leur vie numérique, éviter les distractions inutiles et protéger leur vie privée. Cependant, il est important de noter que le blocage de la publicité peut également affecter la viabilité économique de nombreux sites web et services en ligne qui dépendent des revenus publicitaires pour leur modèle commercial.</p>
                <h2 class="content-subhead">Installer un bloqueur de publicité</h2>
                <p class="p-content">Vous devez <a href="../help.php#Bloquer les publicités" class="link">installer dans ce navigateur un bloqueur de publicité</a>.<br>Après avoir installé un tel bloqueur, il faudra <a href="../help.php#Comment rafraîchir / actualiser une page web" class="link">rafraîchir la page</a>.<br>Si cette énigme s'est résolue toute seule, c'est que vous utilisiez un navigateur dans lequel un bloqueur de publicité était déjà actif, probablement déjà installé par un précédent utilisateur.</p>
                <?php
                if (isset($_COOKIE["puzzle9"])) {
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
    <?php
    if (!puzzleIsResolved()) {
        echo '    <script>
        const testAd = document.createElement("div");
        testAd.innerHTML = "&nbsp;";
        testAd.className = "ad-slot";
        document.body.appendChild(testAd);
        setTimeout(() => {
            const adBlockerActive = testAd.clientHeight === 0;
            document.body.removeChild(testAd);
            if (adBlockerActive) {
                let date = new Date();
                date.setTime(date.getTime() + 1000);
                let expiration = "expires=" + date.toUTCString();
                document.cookie = "puzzle9=ok;" + expiration + ";path=/";
                window.location.replace(window.location.href);
            }
        }, 100);
    </script>
';
    }
    ?>
</body>
</html>