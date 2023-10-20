<?php
session_start();
include("../include/checksession.php");
include("../include/functions.php");

$words = array("Schwob", "Vivien", "Gracq", "Follain", "Michaux", "Perec", "Giono", "Green", "Ernaux", "Sarraute", "Michon", "Godeau", "Ramuz", "Réda", "Noël", "Ollier", "Thomas", "Calaferte", "Nourissier", "Bergounioux", "Galois", "Ramanujan", "Noether", "Kovalevskaya", "Cartan", "Jacobi", "Weierstrass", "Riemann", "Serre", "Poincaré", "Pontryagin", "Chandra", "Lyapunov", "Minkowski", "Deligne", "Ahlfors", "Perelman", "Perelman", "Chern", "Vergne");
if (!isset($_SESSION["magic_word_3"])) {
    $_SESSION["magic_word_3"] = $words[array_rand($words)];
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
        <a href="#menu" id="menuLink" class="menu-link">
            <span></span>
        </a>
        <?php include("../include/nav.php"); ?>
        <div id="main">
            <div class="header">
                <h1>web.snt.nsi.xyz</h1>
                <h2>10 enigmes à résoudre pour découvrir le web<br>Énigme <?php echo getCurrentPuzzleID(); ?></h2>
            </div>
            <div class="content">
                <h2 class="content-subhead">Lorem Ipsum</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus.</p>
                <p>Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.</p>
                <h2 class="content-subhead">Le mot mystère</h2>
                <form method="GET" action="">
                    <label for="response">Entrez le mot mystère :</label>
                    <?php
                    if (isset($_GET['response'])) {
                        $response = $_GET['response'];
                        if ($response == $_SESSION["magic_word_3"]) {
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
        <style>
            .robert {
                color: white;
                height: 176cm;
            }

            .clemente {
                color: white;
                height: 179cm;
            }

            .nsi {
                color: rgb(42, 42, 42);
                height: 666cm;
            }

            <?php echo "/* Mot mystère : ".$_SESSION["magic_word_3"]."*/" ?>
        </style>
        <?php include("../include/footer.php"); ?>
    </div>
</body>
</html>