<?php
$_SESSION["resolvedPuzzles"][] = filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT);;
?>