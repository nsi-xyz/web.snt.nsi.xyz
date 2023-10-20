<?php
if (!isset($_SERVER["HTTPS"]) && $_SERVER["HTTP_HOST"] != "localhost") {
  header('Location: https://web.snt.nsi.xyz'.$_SERVER['PHP_SELF']);
  exit;
};
if (!isset($_SESSION["resolvedPuzzles"])) {
    $_SESSION["resolvedPuzzles"] = array();
  };
?>