<?php
session_start();
include("../include/checksession.php");
include("../include/functions.php");

$magic_word = "nsi";
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
        <?php
        include("../include/nav.php");
        ?>
        <div id="main">
            <div class="header">
                <h1>web.snt.nsi.xyz</h1>
                <h2>10 enigmes à résoudre pour découvrir le web<br>Énigme <?php echo getCurrentPuzzleID(); ?></h2>
                <
            </div>
        </div>
    </div>
    <script src="../js/ui.js"></script>
    <script>
    let index = 0;
    let magic_word = "<?php echo $magic_word; ?>";
    let found = false;
    document.onkeypress = function(e) {
        if (e.key == magic_word[index]) {
            index++;
            if (index == magic_word.length) {
                found = true;
                index = 0;
            };
        } else {
            index = 0;
        };
    };
    </script>
</body>
</html>