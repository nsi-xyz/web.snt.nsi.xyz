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
 * La fonction vérifie si une énigme est résolue et si ce n'est pas le cas, ajoute l'ID de
 * l'énigme à la liste des énigmes résolues dans la session et actualise la page après 3 secondes.
 *
 * @param $puzzleID Ce paramètre est facultatif et représente l'ID de l'énigme qui doit être
 * validée. Si aucun puzzleID n'est fourni, la fonction utilisera la fonction getCurrentPuzzleID() pour
 * obtenir l'ID de l'énigme actuel.
 */
function tickPuzzle($database, $puzzleID = null) {
  if ($puzzleID == null) {
    $puzzleID = getCurrentPuzzleID();
  }
  if (!puzzleIsResolved($puzzleID)) {
    $_SESSION["resolvedPuzzles"][] = $puzzleID;
    if (currentUserInSession()) {
      $session_id = $_SESSION["user_logged_in"]["id_session"];
      $pseudo = $_SESSION["user_logged_in"]["pseudo"];
      addRow($database, "users_session_logs", array($pseudo, $session_id, $puzzleID, date('Y-m-d H:i:s', time())));
    }
    include "./include/nav.php";
    echo '<script>window.location.replace(window.location.href);</script>';
  }
}

/**
 * La fonction réinitialise la session et supprime tous les cookies.
 */
function logout($redir, $reset = 0) {
  if (isset($_COOKIE["LOGGEDIN"])) {
    setcookie("LOGGEDIN", "", time() - COOKIEAUTHDURATION, "/");
  }
  if ($reset) {
    $cookies = array(COOKIE7, COOKIE8, COOKIECHOCOLAT, COOKIECHOCOLATINE, COOKIEHAZLENUT, COOKIESESSION, COOKIEPUBLICITAIRE, COOKIEGOOGLE, COOKIEFACEBOOK, COOKIEAMAZON);
    for ($i = 0; $i <= 9; $i++) {
      $cookie = $cookies[$i];
      if (isset($_COOKIE[$cookie["name"]])) {
        setcookie($cookie["name"], $cookie["value"], time() - SESSDURATION, "/");
      }
    }
    if (isset($_COOKIE["PHPSESSID"])) {
      setcookie("PHPSESSID", "", time() - SESSDURATION, "/");
    }
  }
  session_unset();
  session_destroy();
  header("Location: $redir");
  exit();
}

function throwSuccess($message, $url = null, $tag = "msg", $exit = true, $in_header = false) {
  $_SESSION["message"] = array($message, "success", $tag);
  if ($exit) {
    redirect($url, $in_header);
  }
}

function throwError($message, $url = null, $tag = "msg", $exit = true, $in_header = false) {
  $_SESSION["message"] = array($message, "error", $tag);
  if ($exit) {
    redirect($url, $in_header);
  }
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
function getRows($database, $relation, $attribut, $query, $force_multiples_rows = 0, $like = null) {
  $sql =  $like == null ? "SELECT $attribut FROM $relation WHERE $query" : "SELECT $attribut FROM $relation WHERE $query LIKE $like";
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

function getRowsCustom($database, $sql, $json = 0) {
  $smtp = $database->prepare($sql);
  $smtp->execute();
  return $json == 0 ? $smtp->fetchAll() : json_encode($smtp->fetchAll());
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
 * @return null
 */
function addRow($database, $relation, $values) {
  $attributs = getAttributs($database, $relation, 0);
  $attributs_query = "(".implode(", ", array_map(function($value) {
    return $value;
  }, $attributs)).")";
  $values_query = "(".implode(", ", array_map(function($value) {
    return $value !== NULL ? "\"".$value."\"" : "NULL";
  }, $values)).")";
  $sql = "INSERT INTO $relation $attributs_query VALUES $values_query";
  $stmp = $database->prepare($sql);
  $stmp->execute();
}

function delRow($database, $relation, $query) {
  $sql = "DELETE FROM $relation WHERE $query";
  $stmp = $database->prepare($sql);
  $stmp->execute();
}

/**
 * La fonction modifie un enregistrement/ligne déjà existant d'une table d'une base de données indiquée.
 *
 * @param $database Ce paramètre est une instance d'une classe PDO indiquant dans quelle base de données agir.
 *
 * @param $relation Ce paramètre indique la table de la $database dans laquelle on va ajouter un enregistrement.
 * 
 * @param $attributs_values Ce paramètre est un tableau qui lie un attribut (clé) à une valeur (valeur).
 *
 * @param $query Le filtrage à indiquer (ce qui se situe après le WHERE d'une requête SQL).
 * 
 * @return null
 */
function updateRow($database, $relation, $attributs_values, $query){
  $setCommand = "";
  $attributs = array_keys($attributs_values);
  for ($i = 0; $i < count($attributs) - 1; $i++){
    $setCommand = $setCommand.$attributs[$i]." = \"".$attributs_values[$attributs[$i]]."\", ";
  }
  $setCommand = $setCommand.$attributs[count($attributs) - 1]." = \"".$attributs_values[$attributs[count($attributs) - 1]]."\"";
  $sql = "UPDATE $relation SET $setCommand WHERE $query";
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

function createUser($database, $name, $surname, $username, $password, $id_group) {
  $username_registered_list = getRows($database, "users", "username", "1", 1);
  $name = strtoupper(trim($name));
  $surname = trim($surname);
  $username = strtolower(trim($username));
  if ($username == "admin") {
    return -1;
  } else if (!isValidString($name, PHPPATTERN_NAME) || !isValidString($surname, PHPPATTERN_NAME) || !isValidString($username, PHPPATTERN_USERNAME)) {
    return -4;
  } else {
    for ($i = 0; $i < count($username_registered_list); $i++) {
      if (in_array($username, $username_registered_list[$i])) {
        return -2;
      }
    }
  }
  if (isValidLength($name, NAME_MIN_LENGTH, NAME_MAX_LENGTH) && isValidLength($surname, NAME_MIN_LENGTH, NAME_MAX_LENGTH) && isValidLength($username, USERNAME_MIN_LENGTH, USERNAME_MAX_LENGTH) && isValidLength($password, PASSWORD_MIN_LENGTH, PASSWORD_MAX_LENGTH)) {
    addRow($database, "users", array($name, $surname, $username, password_hash($password, PASSWORD_DEFAULT), date('Y-m-d H:i:s', time()), date('Y-m-d H:i:s', time()), null, $id_group));
    return 0;
  } else {
    return -3;
  }
}

function updateUser($database, $data_user, $new_data_user){
  $data_user_id = $data_user["id"];
  if ($data_user["username"] == "admin" && isset($new_data_user["username"]) && strtolower(trim($new_data_user["username"])) != "admin") {
    return -1;
  } else if (!isValidString($new_data_user["name"], PHPPATTERN_NAME) || !isValidString($new_data_user["surname"], PHPPATTERN_NAME) || (isset($new_data_user["username"]) && !isValidString($new_data_user["username"], PHPPATTERN_USERNAME))) {
    return -4;
  } else if ($data_user["username"] != "admin") {
    $username_registered_list = getRows($database, "users", "username", "1", 1);
    if (count($username_registered_list) >= 1) {
      for ($i = 0; $i < count($username_registered_list); $i++) {
        if (in_array(strtolower(trim($new_data_user["username"])), $username_registered_list[$i]) && $data_user["username"] != $username_registered_list[$i]["username"]) {
          return -2;        
        }
      }
    }
  }
  $new_name = strtoupper(trim($new_data_user["name"]));
  $new_surname = trim($new_data_user["surname"]);
  $new_username = $data_user["username"] == "admin" ? "admin" : strtolower(trim($new_data_user["username"]));
  if (isValidLength($new_name, NAME_MIN_LENGTH, NAME_MAX_LENGTH) && isValidLength($new_surname, NAME_MIN_LENGTH, NAME_MAX_LENGTH) && isValidLength($new_username, USERNAME_MIN_LENGTH, USERNAME_MAX_LENGTH)) {
    updateRow($database, "users", array("name" => $new_name, "surname" => $new_surname, "username" => $new_username, "last_update" => date('Y-m-d H:i:s', time()), "id_group" => $new_data_user["id_group"]), "id = $data_user_id");
    return 0;
  } else {
    return -3;
  }
}

function updateUserPassword($database, $id_user, $password, $password_new, $password_new_confirm) {
  if ($password_new != $password_new_confirm) {
    return -1;
  }
  if (!isValidLength($password_new, PASSWORD_MIN_LENGTH, PASSWORD_MAX_LENGTH)) {
    return -2;
  }
  $password_current_hash = getRows($database, "users", "password", "id = $id_user")["password"];
  if (!password_verify($password, $password_current_hash)) {
    return -3;
  }
  updateRow($database, "users", array("password" => password_hash($password_new, PASSWORD_DEFAULT), "last_update" => date('Y-m-d H:i:s', time())), "id = $id_user");
  return 0;
}

function deleteUser($database, $data_user){
  $data_user_id = $data_user["id"];
  if ($data_user_id == $_SESSION["user_logged_in"]["id"]) {
    return -1;
  } else if ($data_user["username"] == "admin") {
    return -2;
  }
  delRow($database, "users", "id = $data_user_id");
  return 0;
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
  return rowsCount($database, "users", "username = \"$username\"") == 1 && password_verify($password, getRows($database, "users", "*", "username = \"$username\"")["password"]);
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
 * @return void
 */
function createSession($database, $id_owner, $duration) {
  $codeSession = generateSessionCode($database);
  addRow($database, "sessions", array($codeSession, $id_owner, date('Y-m-d H:i:s', time()), $duration, 1));
}

/**
 * La fonction ferme une session.
 *
 * @param $database Ce paramètre est une instance d'une classe PDO indiquant dans quelle base de données agir.
 * 
 * @param $id_session L'ID de la session à fermer.
 *
 * @return void
 */
function stopSession($database, $id_session) {
  updateRow($database, "sessions", array("status" => 0), "id = $id_session");
}

function deleteSession($database, $id_session) {
  delRow($database, "users_session_logs", "id_session = $id_session");
  delRow($database, "users_session", "id_session = $id_session");
  delRow($database, "sessions", "id = $id_session");
}

function deleteAllSessions($database, $id_owner) {
  delRow($database, "users_session_logs", "id_session IN (SELECT id FROM sessions WHERE id_owner = $id_owner)");
  delRow($database, "users_session", "id_session IN (SELECT id FROM sessions WHERE id_owner = $id_owner)");
  delRow($database, "sessions", "id_owner = $id_owner");
}

function canJoinSession($pseudo, $id_session, $database) {
  $status = getRows($database, "sessions", "*", "id = $id_session")["status"];
  $sessionIsOpen = $status == 1 ? true : false;
  $pseudo = trim($pseudo);
  $pseudoToShort = strlen($pseudo) < PSEUDO_MIN_LENGTH ? true : false;
  $pseudoToLong = strlen($pseudo) > PSEUDO_MAX_LENGTH ? true : false;
  $pseudoAlreadyUsed = rowsCount($database, "users_session", "id_session = $id_session AND pseudo = \"$pseudo\"") == 0 ? false : true;
  $pseudoIsVerifiedUser = false; // On ne peut pas rejoindre une session avec le pseudo d'un utilisateur ayant un compte
  foreach (getRows($database, "users", "username", "1") as $row) {
    if (in_array(strtolower($pseudo), $row)) {
      $pseudoIsVerifiedUser = true;
    }
  }
  return $sessionIsOpen && !$pseudoAlreadyUsed && !$pseudoIsVerifiedUser && !$pseudoToShort && !$pseudoToLong;
}

function joinSession($pseudo, $id_session, $database) {
  addRow($database, "users_session", array($pseudo, $id_session, date('Y-m-d H:i:s')));
}

function currentUserInSession() {
  return isset($_SESSION["user_logged_in"]["pseudo"]);
}

function isUserConnected(){
  return isset($_SESSION["user_logged_in"]["username"]) && $_SESSION["user_logged_in"]["username"] != "invité";
}

/**
 * La fonction génère un code aléatoire selon certaines conditions.
 *
 * @param $length Indique la longueur souhaitée pour le code.
 *
 * @return string
 */
function generateRandomCode($length = 8) {
  $charForCode = ["ACDEFGHJKMNPQRTUVWYZ","1234679"];
  $codeResult = "";
  for ($i = 0; $i < $length; $i++) {
    $listTypeChar = $charForCode[random_int(0, 1)];
    $codeResult = $codeResult.$listTypeChar[rand(0, strlen($listTypeChar) - 1)];
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
  $sessionCode = generateRandomCode();
  $listeCodesSessions = getRows($database, "sessions", "code", "1", 1); //Récupère la liste de tous les caractères
  if ($listeCodesSessions) {
    if (count($listeCodesSessions) >= 1) {
      for ($i = 0; $i < count($listeCodesSessions); $i++) {
        if (in_array($sessionCode, $listeCodesSessions[$i])) {
          $sessionCode = generateRandomCode();
          $i = -1;
        }
      }
    }
    return $sessionCode;
  }
  return $sessionCode;
}

function traduction($key) {
  global $messages;
  if ($_SESSION["locale"] == "debug") {
    return $key;
  }
  if (!isset($messages[$key])) {
    return "Missing Translation (".$key.", ".strtoupper($_SESSION["locale"]).")";
  }
  $translation = $messages[$key];
  $translation = preg_replace_callback('/{{(.*?)}}/', function ($matches) {
  $subKey = $matches[1];
    return traduction($subKey);
  }, $translation);
  return $translation;
}

function getSessionData($database, $id) {
  $array = getRowsCustom($database, "SELECT us.id AS id, us.pseudo AS pseudo, us.id_session AS id_session, usl.id_puzzle AS id_puzzle, usl.finished_at AS finished_at, us.joined_at AS joined_at FROM users_session us LEFT JOIN users_session_logs usl ON us.pseudo = usl.pseudo AND us.id_session = usl.id_session WHERE us.id_session = $id;", 0);
  $data_session = [];
  foreach ($array as $row) {
    $pseudo = $row["pseudo"];
    if (!isset($data_session[$pseudo])) {
      $data_session[$pseudo] = [
        "id" => (int)$row["id"],
        "pseudo" => $row["pseudo"],
        "id_session" => (int)$row["id_session"],
        "joined_at" => $row["joined_at"],
        "puzzles" => [],
        "finished_at" => null,
      ];
    }
    if (!empty($row["id_puzzle"])) {
      $data_session[$pseudo]["puzzles"][] = [
        (int)$row["id_puzzle"], 
        $row["finished_at"]
      ];
    }
  }
  foreach ($data_session as &$player) {
    $puzzles = $player["puzzles"];
    if (count($puzzles) == 10) {
      $lastFinishedDate = max(array_column($puzzles, 1));
      $player["finished_at"] = $lastFinishedDate;
    }
  }
  return array_values($data_session);
}

function isValidLength($string, $min, $max) {
  $length = strlen($string);
  return $length >= $min && $length <= $max;
}

function redirect($url = null, $in_header = true) {
  if ($url == null) {
    $url = $_SERVER["REQUEST_URI"];
  }
  if ($in_header) {
    header("Location: ".$url);
  } else {
    echo '<script>window.location.replace("'. $url .'");</script>';
  }
  exit();
}

function generatePassword($length = 12) {
  $letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $digits = "0123456789";
  $password = "";
  $password.=$letters[random_int(0, strlen($letters) - 1)];
  $password.=$digits[random_int(0, strlen($digits) - 1)];
  $allCharacters = $letters.$digits;
  for ($i = strlen($password); $i < $length; $i++) {
    $password.=$allCharacters[random_int(0, strlen($allCharacters) - 1)];
  }
  $password = str_shuffle($password);
  return $password;
}

function resetPassword($database, $data_user) {
  $user_id = $data_user["id"];
  $user_username = $data_user["username"];
  $new_password = generatePassword();
  updateRow($database, "users", array("password" => password_hash($new_password, PASSWORD_DEFAULT), "last_update" => date('Y-m-d H:i:s', time())), "id = $user_id");
  throwSuccess("Mot de passe de <strong>".$user_username."</strong> mis à jour avec succès.<br>Le nouveau mot de passe est : <strong><code>".$new_password."</code></strong>, retenez-le bien !", null, "msg", true, true);
}

function isValidString($string, $pattern) {
  return preg_match($pattern, $string);
}

function formatRelativeTime($datetime) {
  $now = new DateTime();
  $interval = $now->diff($datetime);
  if ($interval->y > 0) {
    return "Il y a ".$interval->y." an".($interval->y > 1 ? "s" : "");
  } else if ($interval->m > 0) {
    return "Il y a ".$interval->m." mois";
  } else if ($interval->d > 0) {
    return "Il y a ".$interval->d." jour".($interval->d > 1 ? "s" : "");
  } else if ($interval->h > 0) {
    return "Il y a ".$interval->h." heure".($interval->h > 1 ? "s" : "");
  } else if ($interval->i > 0) {
    return "Il y a ".$interval->i." minute".($interval->i > 1 ? "s" : "");
  } else {
    return "Il y a ".$interval->s." seconde".($interval->s > 1 ? "s" : "");
  }
}