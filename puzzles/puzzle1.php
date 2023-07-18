<?php
session_start();

include("../include/checksession.php");

$words = array("Schwob", "Vivien", "Gracq", "Follain", "Michaux", "Perec", "Giono", "Green", "Ernaux", "Sarraute", "Michon", "Godeau", "Ramuz", "Réda", "Noël", "Ollier", "Thomas", "Calaferte", "Nourissier", "Bergounioux", "Galois", "Ramanujan", "Noether", "Kovalevskaya", "Cartan", "Jacobi", "Weierstrass", "Riemann", "Serre", "Poincaré", "Pontryagin", "Chandra", "Lyapunov", "Minkowski", "Deligne", "Ahlfors", "Perelman", "Perelman", "Chern", "Vergne");
if (!isset($_SESSION["magic_word_1"])) {
    $_SESSION["magic_word_1"] = $words[array_rand($words)];
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Énigme 1 • web.snt.nsi.xyz</title>
    <link rel="stylesheet" href="../css/pure-min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0" />
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include("../include/nav.php"); ?>
    <div id="main">
        <div class="header">
            <h1>web.snt.nsi.xyz</h1> <!--Titre de niveau 1-->
            <h2>10 enigmes à résoudre pour découvrir le web<br>Énigme 1</h2> <!--Titre de niveau 2-->
            <?php
            if (in_array(filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT), $_SESSION["resolvedPuzzles"])) {
                echo '<b>/!\ Cette énigme a déjà été résolue /!\\</b>';
            }?>
    </div>
    <div class="content">
        <?php echo '<h2 class="content-subhead">Le mot mystère</h2> <!--Mot mystère: '.$_SESSION["magic_word_1"].' -->'; ?>
        <form method="POST" action="">
            <label for="response">Entrez le mot mystère :</label> <!--Titre de niveau 2-->
            <?php
            if (isset($_POST['submit'])) {
                $response = $_POST['response'];
                if ($response == $_SESSION["magic_word_1"]) {
                    echo "<p>Réponse correcte. L'énigme est validé !</p>";
                    include("../include/tickpuzzle.php");
                    include("../include/nav.php");
                } else {
                    echo '<script>window.location.replace(window.location.href);</script>';
                }
    }?>
            <input type="text" name="response" id="response" required>
            <input type="submit" name="submit" value="Valider">
        </form>
    </div>
    <script src="../js/ui.js"></script>
</body>
</html>