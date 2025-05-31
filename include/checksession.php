<?php
// Vérifications.


if (currentUserInSession()) {
  $id_session = $_SESSION["user_logged_in"]["id_session"];
  $pseudo = $_SESSION["user_logged_in"]["pseudo"];
  if (rowsCount($db, "users_session", "id_session = $id_session AND pseudo = \"$pseudo\"") == 0) {
    logout("/logout.php?reset");
  }
}


if (isUserConnected()) {
  $user_id = $_SESSION["user_logged_in"]["id"];
  $time_now = new DateTime();
  $last_connexion_saved = new DateTime(getRows($db, "users", "last_connexion", "id = $user_id")["last_connexion"]);
  $interval = $time_now->diff($last_connexion_saved);
  if ($interval->days*24*60*60 + $interval->h*60*60 + $interval->i*60 + $interval->s > 60) {
    updateRow($db, "users", array("last_connexion" => date('Y-m-d H:i:s', time())), "id = $user_id");
  }
}


if (!isset($_SESSION["time_session_start"])) {
  $_SESSION["time_session_start"] = time();
}
if (!isset($_SESSION["resolvedPuzzles"])) {
  $_SESSION["resolvedPuzzles"] = array();
}
if (filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT) == 10) {
  $_SESSION["puzzle10"] = TRUE;
}
if (!in_array(7, $_SESSION["resolvedPuzzles"]) && !isset($_COOKIE[COOKIE7["name"]])) {
  $expires = isset($_SESSION["time_left"]) ? $_SESSION["time_left"] : GAMESESSION_DURATION;
  setcookie(COOKIE7["name"], COOKIE7["value"], time() + $expires, "/");
}
if (!in_array(8, $_SESSION["resolvedPuzzles"]) && !isset($_COOKIE[COOKIE8["name"]])) {
  $expires = isset($_SESSION["time_left"]) ? $_SESSION["time_left"] : GAMESESSION_DURATION;
  setcookie(COOKIE8["name"], COOKIE8["value"], time() + $expires, "/");
}