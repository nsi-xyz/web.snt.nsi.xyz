<?php
if (!isset($_SERVER["HTTPS"]) && $_SERVER["HTTP_HOST"] != "localhost") {
  header('Location: https://web.snt.nsi.xyz'.$_SERVER['PHP_SELF']);
  exit;
};
if (!isset($_SESSION["resolvedPuzzles"])) {
    $_SESSION["resolvedPuzzles"] = array();
  };
if (filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT) == 10) {
  $_SESSION["puzzle10"] = TRUE;
};
if (!in_array(7, $_SESSION["resolvedPuzzles"]) && !isset($_COOKIE["Cookies_au_chocolat"])) {
  $cookie_value = "SW5ncsOpZGllbnRzIDoNCjIwMCBnIGRlIGNob2NvbGF0IG5vaXIgKG91IHDDqXBpdGVzIGRlIGNob2NvbGF0KQ0KMjI1IGcgZGUgZmFyaW5lIHRvdXQgdXNhZ2UNCjExNSBnIGRlIGJldXJyZSBtb3UNCjE1MCBnIGRlIHN1Y3JlIGJydW4NCjEgxZN1Zg0KMSBjdWlsbMOocmUgw6AgY2Fmw6kgZCdleHRyYWl0IGRlIHZhbmlsbGUNCjEvMiBjdWlsbMOocmUgw6AgY2Fmw6kgZGUgbGV2dXJlIGNoaW1pcXVlDQoxLzIgY3VpbGzDqHJlIMOgIGNhZsOpIGRlIGJpY2FyYm9uYXRlIGRlIHNvdWRlDQoxIHBpbmPDqWUgZGUgc2Vs";
  setcookie("Cookies_au_chocolat", $cookie_value, time() + 60*60*2);
}
?>