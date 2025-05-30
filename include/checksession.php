<?php
// Vérifications.

if ((isUserConnected() && sessionInProgress($db, $_SESSION["user_logged_in"]["id"])) || (currentUserInSession())) {
  if (currentUserInSession()) {
    $id_session = $_SESSION["user_logged_in"]["id_session"];
  } else {
    $id_user = $_SESSION["user_logged_in"]["id"];
    $id_session = getRows($db, "sessions", "*", "id_owner = $id_user AND status = 1")["id"];
  }
  $time_now = new DateTime(date("Y-m-d H:i:s", time()));
  $session_date = getRows($db, "sessions", "date", "id = \"$id_session\"")["date"];
  $session_duration = getRows($db, "sessions", "duration", "id = \"$id_session\"")["duration"];
  $session_date_end = new DateTime(date("Y-m-d H:i:s", strtotime($session_date) + $session_duration));
  $session_is_expired = $time_now > $session_date_end->modify("+1 second"); // Marge de 1 seconde pour éventuellement laisser le temps à session.php de stopper la session.
  $session_is_open = getRows($db, "sessions", "*", "id = $id_session")["status"] == 1 ? true : false;
  if ($session_is_open && $session_is_expired) {
    stopSession($db, $id_session);
  }
}


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