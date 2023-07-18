<?php
if (!in_array(filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT), $_SESSION["resolvedPuzzles"])) {
    $_SESSION["resolvedPuzzles"][] = filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT);
}
?>