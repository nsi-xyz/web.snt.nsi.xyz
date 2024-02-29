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
        if (currentUserInSession()) {
            // mettre à jour la bdd
        }
        include("./include/nav.php");
        echo '<script>window.location.replace(window.location.href);</script>';
    }
}

/**
 * La fonction réinitialise la session et supprime tous les cookies.
 */
function resetSession($redir, $logout = 0) {
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
    if (isset($_COOKIE["LOGGEDIN"]) && $logout == 1) {
        setcookie("LOGGEDIN", "", time() - COOKIEAUTHDURATION, "/");
    }
    session_unset();
    session_destroy();
    echo '<script>
var date = new Date();
date.setTime(date.getTime() + '.(SESSDURATION*1000).');
var expiration = "expires=" + date.toUTCString();
document.cookie = "reset='.$redir.';" + expiration + ";path=/";
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
function getRows($database, $relation, $attribut, $query, $force_multiples_rows = 0) {
    $sql = "SELECT $attribut FROM $relation WHERE $query";
    $stmp = $database->prepare($sql);
    $stmp->execute();
    return rowsCount($database, $relation, $query) > 1 || $force_multiples_rows == 1 ? $stmp->fetchAll() : $stmp->fetch(PDO::FETCH_ASSOC);
}

/**
 * La fonction renvoie le nombre d'enregistrement (de ligne) dans une table de base de données indiquée en paramètre.
 *
 * @param $database Ce paramètre est une instance d'une classe PDO indiquant dans quelle base de données vérifier.
 * @param $relation Ce paramètre représente le nom de la table de données où effectuer la vérification.
 * @param $query Ce paramètre représente la condition pour chercher précisemment si la donnée existe.
 * @return bool
 */
function rowsCount($database, $relation, $query) {
    $sql = "SELECT * FROM $relation WHERE $query";
    $stmp = $database->prepare($sql);
    $stmp->execute();
    return $stmp->rowCount();
}

function getRowsInJSON($database, $relation, $attribut, $query) {
    $sql = "SELECT $attribut FROM $relation WHERE $query";
    $stmp = $database->prepare($sql);
    $stmp->execute();
    return json_encode($stmp->fetchAll());
}


/**
 * La fonction ajoute un enregistrement/ligne à une table d'une base de données indiquée.
 *
 * @param $database Ce paramètre est une instance d'une classe PDO indiquant dans quelle base de données agir.
 *
 * @param $relation Ce paramètre indique la table de la $database dans laquelle on va ajouter un enregistrement.
 * 
 * @param $values Ce paramètre indique les valeurs des attributs de la table ($relation).
 * Ils doivent être écrits sous la forme suivante : array(att_1,att_2,...,att_n) / Il ne faut pas indiquer la clé primaire.
 *
 * @return None
 */
function addRow($database, $relation, $values) {
    $attributs = getAttributs($database, $relation, 0);
    $attributs_query = "(".implode(", ", array_map(function($value) {
        return $value;
    }, $attributs)).")";
    $values_query = "(".implode(", ", array_map(function($value) {
        return "\"".$value."\"";
    }, $values)).")";
    $sql = "INSERT INTO $relation $attributs_query VALUES $values_query";
    $stmp = $database->prepare($sql);
    $stmp->execute();
}

function getAttributs($database, $relation, $withID = 1) {
    $sql = "SHOW COLUMNS FROM $relation";
    $stmp = $database->query($sql);
    $results = $stmp->fetchAll();
    $attributs = array();
    foreach ($results as $row) {
        $field = $row["Field"];
        if ($field != "id" || ($field == "id" && $withID == 1)) {
            $attributs[] = $field;
        }
    }
    return $attributs;
}

function updateLocalDB($json, $path) {
    file_put_contents($path, $json);
}

function createUser($database,$name,$surname,$username,$password,$id_group){
    $listeUsernameUsers = getRows($database,"users","username","1");
    for ($i=0; $i < count($listeUsernameUsers); $i++){
        if (in_array($username, $listeUsernameUsers[$i])){
            return False;        
        }
    }
    addRow($database,"users",array($name,$surname,$username,password_hash($password, PASSWORD_DEFAULT),$id_group));
    return True;
}

/**
 * La fonction vérifie si un utilisateur avec le nom d'utilisateur et le mot de passe
 * fournis existe dans la base de données.
 *
 * @param $username Ce paramètre est le nom d'utilisateur saisi par l'utilisateur lors de la tentative de
 * connexion.
 * 
 * @param $password Ce paramètre est le mot de passe saisi par l'utilisateur lors de la tentative de
 * connexion. Le $password doit être sous la forme du mdp brut.
 * 
 * @param $database Ce paramètre est une instance d'une classe PDO indiquant dans quelle base de données vérifier.
 *
 * @return bool
 */
function login_success($username, $password, $database) {
    return (rowsCount($database, "users", "username = \"$username\"") == 1 && password_verify($password, getRows($database, "users", "*", "username = \"$username\"")["password"]));
}

function sessionInProgress($database, $user_id) {
    $sessions = getRows($database, "sessions", "status", "id_owner = $user_id", 1);
    foreach ($sessions as $value) {
        if (in_array(1, $value)) {
            return true;
        }
    }
    return false;
}
/**
 * La fonction créé une session et l'enregistre dans la relation/table "sessions".
 *
 * @param $database Ce paramètre est une instance d'une classe PDO indiquant dans quelle base de données agir.
 * 
 * @param $id_owner L'ID du propriétaire de la session.
 *
 * @return None
 */
function createSession($database,$id_owner) {
    $codeSession = generateSessionCode($database);
    addRow($database,"sessions",array($codeSession, $id_owner, date('Y-m-d H:i:s',time()), 1));
}

function canJoinSession($pseudo, $id_session, $database) {
    $status = getRows($database, "sessions", "*", "id = $id_session")["status"];
    $sessionIsOpen = $status == 1 ? true : false;
    $pseudoAlreadyUsed = rowsCount($database, "users_session", "id_session = $id_session AND pseudo = \"$pseudo\"") == 0 ? false : true;
    $pseudoIsVerifiedUser = false; // On ne peut pas rejoindre une session avec le pseudo d'un utilisateur ayant un compte
    foreach (getRows($database, "users", "username", "1") as $row) {
        if (in_array($pseudo, $row)) {
            $pseudoIsVerifiedUser = true;
        }
    }
    return $sessionIsOpen && !$pseudoAlreadyUsed && !$pseudoIsVerifiedUser;
}

function joinSession($pseudo, $id_session, $database, $local_path) {
    addRow($database, "users_session", array($pseudo, $id_session));
    updateLocalDB(getRowsInJSON($database, "users_session", "*", "1"), $local_path);
}

function currentUserInSession() {
    return $_SESSION["user_logged_in"]["username"] != "invité";
}

/**
 * La fonction génère un code aléatoire selon certaines conditions.
 *
 * @param $lenght Indique la longueur souhaitée pour le code.
 *
 * @return string
 */
function generateRandomCode($lenght = 8) {
    // Liste des lettres et des chiffres pouvant consituer le code de session
    $charForCode = ["ACDEFGHJKMNPQRTUVWYZ","1234679"];
    $codeResult = "";
    for ($i = 0; $i < $lenght; $i++) {
        $listTypeChar = $charForCode[random_int(0,1)];
        $codeResult = $codeResult.$listTypeChar[rand(0,strlen($listTypeChar) - 1)]; // Récupère un élément de la liste de charactères indiquée dans $listTypeChar
    }
    return $codeResult;
}
/**
 * La fonction génère un code de session aléatoire et vérifie si ce code n'existe pas déjà.
 *
 * @param $database Ce paramètre est une instance d'une classe PDO indiquant dans quelle base de données agir.
 *
 * @return string
 */
function generateSessionCode($database) {
    $sessionCode = generateRandomCode(); // Génére un code aléatoire de 8 caractères
    $listeCodesSessions = getRows($database,"sessions","code","1"); //Récupère la liste de tous les caractères
    if ($listeCodesSessions){
        // Parcours de la liste des codes présents dans la BDD et comparaison avec l'actuel code session généré
        for ($i = 0; $i < count($listeCodesSessions); $i++){
            // Si code identique, nouvelle génération du code
            if (in_array($sessionCode,$listeCodesSessions[$i])) {
                $sessionCode = generateRandomCode();
                $i = -1;
            }
        }
        return $sessionCode;
    }
    return $sessionCode;
}
?>