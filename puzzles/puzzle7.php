<?php
include("../include/checksession.php");
include("../include/functions.php");
$cookie_name = "Cookie_au_chocolat";
$cookie_value = "SW5ncsOpZGllbnRzIDoNCjIwMCBnIGRlIGNob2NvbGF0IG5vaXIgKG91IHDDqXBpdGVzIGRlIGNob2NvbGF0KQ0KMjI1IGcgZGUgZmFyaW5lIHRvdXQgdXNhZ2UNCjExNSBnIGRlIGJldXJyZSBtb3UNCjE1MCBnIGRlIHN1Y3JlIGJydW4NCjEgxZN1Zg0KMSBjdWlsbMOocmUgw6AgY2Fmw6kgZCdleHRyYWl0IGRlIHZhbmlsbGUNCjEvMiBjdWlsbMOocmUgw6AgY2Fmw6kgZGUgbGV2dXJlIGNoaW1pcXVlDQoxLzIgY3VpbGzDqHJlIMOgIGNhZsOpIGRlIGJpY2FyYm9uYXRlIGRlIHNvdWRlDQoxIHBpbmPDqWUgZGUgc2Vs";
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
            <?php
                if (!isset($_COOKIE[$cookie_name])) {
                    tickPuzzle();
                }
                ?>
        </div>
    <?php include("../include/footer.php"); ?>
    </div>
    <script src="../js/ui.js"></script>
</body>
</html>