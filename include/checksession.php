<?php
if (!isset($_SERVER["HTTPS"])) {
  header('Location: https://web.snt.nsi.xyz'.$_SERVER['PHP_SELF']);
};
if (!isset($_SESSION["resolvedPuzzles"])) {
    $_SESSION["resolvedPuzzles"] = array();
  }
?>