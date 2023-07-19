<?php
function getCurrentPuzzleID() {
    return filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT);
}

function puzzleIsResolved($puzzleID) {
    return in_array($puzzleID, $_SESSION["resolvedPuzzles"]) ? TRUE : FALSE;
}
?>