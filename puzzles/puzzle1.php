<?php
session_start();
include("../include/checksession.php");
include("../include/functions.php");

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
    <title><?php echo setPageTitle();?></title>
    <link rel="stylesheet" href="../css/pure-min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div id="layout">
        <?php include("../include/nav.php"); ?>
        <div id="main">
            <div class="header">
                <h1>web.snt.nsi.xyz</h1>
                <h2>10 enigmes à résoudre pour découvrir le web<br>Énigme <?php echo getCurrentPuzzleID(); ?></h2>
            </div>
            <div class="content">
                <?php echo '<h2 class="content-subhead">Le mot mystère</h2> <!--Mot mystère: '.$_SESSION["magic_word_1"].' -->'; ?>
                <form method="GET" action="">
                    <label for="response">Entrez le mot mystère :</label>
                    <?php
                    if (isset($_GET['response'])) {
                        $response = $_GET['response'];
                        if ($response == $_SESSION["magic_word_1"]) {
                            echo "<p>Réponse correcte. L'énigme est validé !</p>";
                            tickPuzzle();
                        }
                    }
                    ?>
                    <input type="text" name="response" required>
                    <input type="submit" value="Valider">
                </form>
            </div>
            <script src="../js/ui.js"></script>
        </div>
        <?php include("../include/footer.php"); ?>
    </div>
</body>
</html>