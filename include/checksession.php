<?php
$dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::MEDIUM);
$collator = collator_create('fr_FR');
// Constantes globales.
define("VERSION", "2.12.3");
define("NAME_MIN_LENGTH", 2);
define("NAME_MAX_LENGTH", 24);
define("PSEUDO_MIN_LENGTH", 3);
define("PSEUDO_MAX_LENGTH", 24);
define("USERNAME_MIN_LENGTH", 3);
define("USERNAME_MAX_LENGTH", 16);
define("PASSWORD_MIN_LENGTH", 7);
define("PASSWORD_MAX_LENGTH", 32);
define("PHPPATTERN_NAME", "/^(?![\-' ])(?!.*[\-']{3})(?!.* {2})[A-Za-zÀ-ÖØ-öø-ÿ' \-]+(?<![\-' ])$/u");
define("HTMLPATTERN_NAME", "^(?![\-' ])(?!.*[\-']{3})(?!.* {2})[A-Za-zÀ-ÖØ-öø-ÿ' \-]+(?<![\-' ])$");
define("PHPPATTERN_USERNAME", "/^[a-z][a-z0-9]*([.\-][a-z0-9]+)*$/");
define("HTMLPATTERN_USERNAME", "^[a-z][a-z0-9]*([.\-][a-z0-9]+)*$");
define("PHPPATTERN_PSEUDO", "/^(?![\-' .])(?!.*[\-'.]{3})(?!.* {2})(?!.*\.\.)(?!.*[\-']$)[A-Za-zÀ-ÖØ-öø-ÿ' .\-]+[.]?$/u");
define("HTMLPATTERN_PSEUDO", "^(?![\-' .])(?!.*[\-'.]{3})(?!.* {2})(?!.*\.\.)(?!.*[\-']$)[A-Za-zÀ-ÖØ-öø-ÿ' .\-]+[.]?$");
define("SESSDURATION", 10800);
define("COOKIEAUTHDURATION", 604800);
define("COOKIE7", array(
  "name" => "cookie_enigme_7",
  "value" => "Cookie_to_delete_to_solve_puzzle_7._PLEASE_NOTE_THAT_DELETING_ALL_COOKIES_RESETS_YOUR_PROGRESS."
));
$puzzle8_seed = str_pad(rand(0, 9999999), 7, "0", STR_PAD_LEFT);
define("COOKIE8", array(
  "name" => "cookie_enigme_8",
  "value" => $puzzle8_seed."404"
));
define("COOKIECHOCOLAT", array(
  "name" => "cookie_au_chocolat",
  "value" => "According_to_Wikipedia._A_cookie_or_chocolate_chip_cookie_is_a_small_round_traditional_biscuit_from_American_cuisine_with_chocolate_chips_or_chunks."
));
define("COOKIECHOCOLATINE", array(
  "name" => "cookie_chocolatine",
  "value" => "The_chocolatine_cookie_is_strictly_identical_to_the_chocolate_chip_cookie_but_with_a_strange_name._Very_popular_in_the_southwest_of_France._It_is_unknown_to_Parisians."
));
define("COOKIEHAZLENUT", array(
  "name" => "cookie_noisette",
  "value" => "Our_favorite"
));
define("COOKIESESSION", array(
  "name" => "cookie_session",
  "value" => "According_to_Wikipedia._Cookies_allow_websites_to_identify_internet_users_as_they_move_from_one_web_page_to_another_on_the_site_even_when_they_return_years_later._Cookies_are_commonly_used_to_identify_a_user_session_while_they_are_logged_into_their_computer_account."
));
define("COOKIEPUBLICITAIRE", array(
  "name" => "cookie_publicitaire",
  "value" => "According_to_Wikipedia._The_use_of_cookies_by_web_tracking_companies_provokes_hostility._Indeed_these_third-party_cookies_linked_to_online_advertising_banners_allow_tracking_of_internet_users_visiting_websites_that_have_no_relation_except_for_the_tracking_subcontracting_company."
));
define("COOKIEGOOGLE", array(
  "name" => "cookie_google",
  "value" => "Google._With_Google_Android_Chrome_etc._tracks_you_on_the_web._Cookies_are_used_for_this_tracking._But_this_company_has_many_other_methods_to_track_you..."
));
define("COOKIEFACEBOOK", array(
  "name" => "cookie_facebook",
  "value" => "Facebook._With_Facebook_Instagram_WhatsApp_etc._tracks_you_on_the_web._Cookies_are_used_for_this_tracking._But_this_company_has_many_other_methods_to_track_you..."
));
define("COOKIEAMAZON", array(
  "name" => "cookie_amazon",
  "value" => "Amazon_Advertising._Amazon_offers_advertising_opportunities_for_sellers_and_advertisers_on_its_e-commerce_platform._And_for_this_Amazon_tracks_you_on_the_web_with_cookies."
));
// Vérifications.
if (!isset($_COOKIE["PHPSESSID"])) {
  session_set_cookie_params(SESSDURATION);
  session_start();
  session_regenerate_id();
  $_SESSION["time_session_start"] = time();
  $cookies = array(COOKIECHOCOLAT, COOKIECHOCOLATINE, COOKIEHAZLENUT, COOKIESESSION, COOKIEPUBLICITAIRE, COOKIEGOOGLE, COOKIEFACEBOOK, COOKIEAMAZON);
  for ($i = 0; $i <= 7; $i++) {
    $cookie = $cookies[$i];
    setcookie($cookie["name"], $cookie["value"], time() + SESSDURATION, "/");
  }
} else {
  session_start();
}
if (isset($_GET["lang"])) {
  $_SESSION["locale"] = $_GET["lang"];
}
if (!isset($_SESSION["locale"])) {
$_SESSION["locale"] = "fr";
}
if ($_SESSION["locale"] != "debug") {
  $rows = getRows($db, "traductions_".$_SESSION["locale"], "*", "1");
  foreach ($rows as $row) {
    $messages[$row['trad']] = $row['value'];
  }
}
if (!isset($_SERVER["HTTPS"]) && $_SERVER["HTTP_HOST"] != "localhost") {
  header('Location: https://web.snt.nsi.xyz'.$_SERVER['PHP_SELF']);
  exit;
}
if (!isset($_SESSION["user_logged_in"]) && !isset($_COOKIE["LOGGEDIN"])) {
  $_SESSION["user_logged_in"]["username"] = "invité";
}
if (isset($_SESSION["user_logged_in"]["username"]) && $_SESSION["user_logged_in"]["username"] != "invité") {
  if (!isset($_COOKIE["LOGGEDIN"])) {
    setcookie("LOGGEDIN", $_SESSION["user_logged_in"]["username"]."_".urlencode($_SESSION["user_logged_in"]["password"]), time() + COOKIEAUTHDURATION, "/");
  }
}
if (isset($_COOKIE["LOGGEDIN"])) {
  $cookie_username = explode("_", $_COOKIE["LOGGEDIN"])[0];
  $cookie_password = explode("_", $_COOKIE["LOGGEDIN"])[1];
  if (rowsCount($db, "users", "username = \"$cookie_username\"") == 1 && getRows($db, "users", "*", "username = \"$cookie_username\"")["password"] == urldecode($cookie_password)) {
    $_SESSION["user_logged_in"] = getRows($db, "users", "*", "username = \"$cookie_username\"");
  }
}
if (in_array("panel", explode("/", $_SERVER['PHP_SELF'])) && !isUserConnected()) {
  $session_code = isset($_GET["session"]) ? $_GET["session"] : null;
  $sessionExists = rowsCount($db, "sessions", "code = \"$session_code\"") == 1;
  if (!$sessionExists || !isset($_GET["share"]) || !in_array("stats.php", explode("/", $_SERVER['PHP_SELF']))) {
    throwError(traduction("error_not_authorized_message"), "../login.php", "msg", true, true);
  }
}
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
  $expires = isset($_SESSION["time_left"]) ? $_SESSION["time_left"] : SESSDURATION;
  setcookie(COOKIE7["name"], COOKIE7["value"], time() + $expires, "/");
}
if (!in_array(8, $_SESSION["resolvedPuzzles"]) && !isset($_COOKIE[COOKIE8["name"]])) {
  $expires = isset($_SESSION["time_left"]) ? $_SESSION["time_left"] : SESSDURATION;
  setcookie(COOKIE8["name"], COOKIE8["value"], time() + $expires, "/");
}