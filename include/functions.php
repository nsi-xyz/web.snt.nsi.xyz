<?php
/**
 * La fonction récupère l'ID de l'énigme actuel à partir de l'URL.
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
 * @param $puzzleID Ce paramètre est un paramètre facultatif qui représente l'ID de l'énigme. Si
 * aucun puzzleID n'est fourni, il prendra par défaut la valeur renvoyée par la fonction
 * getCurrentPuzzleID().
 * 
 * @return bool
 */
function puzzleIsResolved($puzzleID = null) {
    if ($puzzleID == null) {
        $puzzleID = getCurrentPuzzleID();
    }
    return in_array($puzzleID, $_SESSION["resolvedPuzzles"]) ? true : false;
}

/**
 * La fonction renvoie une chaîne qui inclut l'ID de l'énigme actuel dans un titre de site web.
 * 
 * @return string Une chaîne qui inclut l'ID de l'énigme actuel dans le titre du site web.
 */
function setPageTitle() {
    return "Énigme ".getCurrentPuzzleID()." • web.snt.nsi.xyz";
}

/**
 * La fonction vérifie si unz énigme est résolue et si ce n'est pas le cas, ajoute l'ID de
 * l'énigme à la liste des énigmes résolues dans la session et actualise la page après 3 secondes.
 * 
 * @param $puzzleID Ce paramètre est facultatif et représente l'ID de l'énigme qui doit être
 * validée. Si aucun puzzleID n'est fourni, la fonction utilisera la fonction getCurrentPuzzleID() pour
 * obtenir l'ID de l'énigme actuel.
 */
function tickPuzzle($puzzleID = null) {
    if ($puzzleID == null) {
        $puzzleID = getCurrentPuzzleID();
    }
    if (!puzzleIsResolved($puzzleID)) {
        $_SESSION["resolvedPuzzles"][] = $puzzleID;
        include("./include/nav.php");
        echo '<script>window.location.replace(window.location.href);</script>';
    }
}

/**
 * La fonction réinitialise la session et supprime tous les cookies.
 */
function resetSession() {
    $cookies = array(COOKIE7, COOKIE8, COOKIECHOCOLAT, COOKIECHOCOLATINE, COOKIEHAZLENUT, COOKIESESSION, COOKIEPUBLICITAIRE, COOKIEGOOGLE, COOKIEFACEBOOK, COOKIEAMAZON);
    for ($i = 0; $i <= 9; $i++) {
        $cookie = $cookies[$i];
        if (isset($_COOKIE[$cookie["name"]])) {
            setcookie($cookie["name"], $cookie["value"], time() - SESSDURATION, "/");
        }
    }
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), "", time() - SESSDURATION);
    }
    session_unset();
    session_destroy();
    echo '<script>
var date = new Date();
date.setTime(date.getTime() + '.(SESSDURATION*1000).');
var expiration = "expires=" + date.toUTCString();
document.cookie = "reset=reset;" + expiration + ";path=/";
</script>';
    echo '<script>window.location.replace(window.location.href);</script>';
}


/**
 * La fonction récupère une ligne spécifique d'une table de base de données sur la base d'une requête donnée.
 * 
 * @param $database Ce paramètre est une instance d'une classe PDO indiquant dans quelle base de données agir.
 * @param $relation Ce paramètre représente le nom de la table de données où agir.
 * @param $attribut Ce paramètre représente le ou les attributs dans le ou lesquels les données doivent être
 * collectées.
 * @param $query Ce paramètre représente la condition à appliquer pour filtrer les lignes de la table de la base
 * de données.
 * @return array
 */
function getRow($database, $relation, $attribut, $query) {
    $sql = "SELECT $attribut FROM $relation WHERE $query";
    $stmp = $database->prepare($sql);
    $stmp->execute();
    $result = $stmp->fetch(PDO::FETCH_ASSOC);
    return $result;
}

/**
 * La fonction vérifie si une donnée existe dans une table de base de données donnée.
 * 
 * @param $database Ce paramètre est une instance d'une classe PDO indiquant dans quelle base de données vérifier.
 * @param $relation Ce paramètre représente le nom de la table de données où effectuer la vérification.
 * @param $query Ce paramètre représente la condition pour chercher précisemment si la donnée existe.
 * @return bool
 */
function rowExists($database, $relation, $query) {
    $sql = "SELECT * FROM $relation WHERE $query";
    $stmp = $database->prepare($sql);
    $stmp->execute();
    if ($stmp->rowCount() > 0) {
        return true;
    }
    return false;
}



/**
 * La fonction vérifie si un utilisateur avec le nom d'utilisateur et le mot de passe
 * fournis existe dans la base de données.
 * 
 * @param $username Ce paramètre est le nom d'utilisateur saisi par l'utilisateur lors de la tentative de
 * connexion.
 * @param $password Ce paramètre est le mot de passe saisi par l'utilisateur lors de la tentative de
 * connexion.
 * @param $database Ce paramètre est une instance d'une classe PDO indiquant dans quelle base de données vérifier.
 * 
 * @return bool
 */
function login_success($username, $password, $database) {
    return (rowExists($database, "users", "username = \"$username\"") && getRow($database, "users", "*", "username = \"$username\"")["password"] == $password);
}
?>