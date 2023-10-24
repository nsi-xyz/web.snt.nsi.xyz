<?php
include("../include/checksession.php");
include("../include/functions.php");
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
        <?php
        include("../include/nav.php");
        if (!puzzleIsResolved()) {
            setcookie("resolved", "false", time() + 2520);
        }
        ?>
        <div id="main">
            <?php include("../include/header.php"); ?>
            <?php
                if (isset($_COOKIE["resolved"]) && $_COOKIE["resolved"] == "true") {
                    tickPuzzle();
                }
                ?>
        </div>
    <?php include("../include/footer.php"); ?>
    </div>
    <script src="../js/ui.js"></script>
    <?php include("../include/timer.php"); ?>
</body>
</html>