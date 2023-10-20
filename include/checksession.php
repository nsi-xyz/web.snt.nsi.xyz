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
?>