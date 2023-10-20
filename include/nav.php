<?php
$p = basename($_SERVER['PHP_SELF']);
$p_i = ($p == "index.php" || $p == "help.php") ? "" : ".";
$p_h = ($p == "index.php" || $p == "help.php") ? "." : "..";
echo '<div id="menu">
      <div class="pure-menu">
        <a class="pure-menu-heading" href=".'.$p_i.'/index.php">10 Énigmes à résoudre</a>
          <ul class="pure-menu-list">
';
for ($i = 1; $i < 10; $i++) {
    $emoji = in_array($i, $_SESSION["resolvedPuzzles"]) ? "&#x1F7E2;" : "&#x1F7E0;";
    $resolved = in_array($i, $_SESSION["resolvedPuzzles"]) ? "resolved" : "unresolved";
    $class = $i == filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT) ? "pure-menu-item menu-item-divided pure-menu-selected-".$resolved : "pure-menu-item-".$resolved;
    echo '            <li class="'.$class.'"><a href=".'.$p_i.'/puzzles/puzzle'.$i.'.php" class="pure-menu-link">'.$emoji.' Énigme web 0'.$i.'</a></li>
';
};
$class = $p == "help.php" ? "pure-menu-item menu-item-divided pure-menu-selected-help" : "pure-menu-item-help";
echo '            <li class="'.$class.'"><a href="'.$p_h.'/help.php" class="pure-menu-link">&#x1F537; Aide & Boite à outils</a></li>
          </ul>
      </div>
    </div>
';
?>