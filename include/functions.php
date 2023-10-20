<?php
/**
 * La fonction getCurrentPuzzleID() récupère l'ID de l'énigme actuel à partir de l'URL.
 * 
 * @return int L'ID de l'énigme actuel.
 */
function getCurrentPuzzleID() {
    return filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT);
}

/**
 * La fonction vérifie si une énigme est résolue en vérifiant si son ID se trouve dans le tableau des
 * énigmes résolues stockées dans la session.
 * 
 * @param puzzleID Le paramètre puzzleID est un paramètre facultatif qui représente l'ID de l'énigme. Si
 * aucun puzzleID n'est fourni, il prendra par défaut la valeur renvoyée par la fonction
 * getCurrentPuzzleID().
 * 
 * @return bool VRAI ou FAUX.
 */
function puzzleIsResolved($puzzleID = NULL) {
    if ($puzzleID == NULL) {
        $puzzleID = getCurrentPuzzleID();
    }
    return in_array($puzzleID, $_SESSION["resolvedPuzzles"]) ? TRUE : FALSE;
}

/**
 * La fonction renvoie une chaîne qui inclut l'ID de l'énigme actuel dans un titre de site Web.
 * 
 * @return string Une chaîne qui inclut l'ID de l'énigme actuel dans le titre du site Web.
 */
function setPageTitle() {
    return "Énigme ".getCurrentPuzzleID()." • web.snt.nsi.xyz";
}

/**
 * La fonction tickPuzzle vérifie si unz énigme est résolue et si ce n'est pas le cas, ajoute l'ID de
 * l'énigme à la liste des énigmes résolues dans la session et actualise la page après 3 secondes.
 * 
 * @param puzzleID Le paramètre  est facultatif et représente l'ID de l'énigme qui doit être
 * validée. Si aucun puzzleID n'est fourni, la fonction utilisera la fonction getCurrentPuzzleID() pour
 * obtenir l'ID de l'énigme actuel.
 */
function tickPuzzle($puzzleID = NULL) {
    if ($puzzleID == NULL) {
        $puzzleID = getCurrentPuzzleID();
    }
    if (!puzzleIsResolved($puzzleID)) {
        $_SESSION["resolvedPuzzles"][] = $puzzleID;
        include("../include/nav.php");
        echo '<script>window.location.replace(window.location.href);</script>';
    }
}

/**
 * La fonction renvoie un mot mystère aléatoire.
 * 
 * @return string Un élément du tableau.
 */
function getMysteryWord() {
    $words = array("Schwob", "Vivien", "Gracq", "Follain", "Michaux", "Perec", "Giono", "Green", "Ernaux", "Sarraute", "Michon", "Godeau", "Ramuz", "Réda", "Noël", "Ollier", "Thomas", "Calaferte", "Nourissier", "Bergounioux", "Galois", "Ramanujan", "Noether", "Kovalevskaya", "Cartan", "Jacobi", "Weierstrass", "Riemann", "Serre", "Poincaré", "Pontryagin", "Chandra", "Lyapunov", "Minkowski", "Deligne", "Ahlfors", "Perelman", "Perelman", "Chern", "Vergne");
    return $words[array_rand($words)];
}
?>