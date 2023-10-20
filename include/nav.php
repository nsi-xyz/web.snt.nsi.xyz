<?php
$p = basename($_SERVER['PHP_SELF']) == "index.php" ? "" : ".";
echo '<div id="menu">
      <div class="pure-menu">
        <a class="pure-menu-heading" href=".'.$p.'/index.php">10 Énigmes à résoudre</a>
          <ul class="pure-menu-list">
';
for ($i = 1; $i < 10; $i++) {
    $locker = in_array($i, $_SESSION["resolvedPuzzles"]) ? "" : "lock";
    $class = $i == filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT) ? "pure-menu-item menu-item-divided pure-menu-selected" : "pure-menu-item";
    echo '            <li class="'.$class.'"><a href=".'.$p.'/puzzles/puzzle'.$i.'.php" class="pure-menu-link"><span class="material-symbols-outlined">'.$locker.'</span> Énigme web 0'.$i.'</a></li>
';
}
echo '            <li class="pure-menu-item"><a href="./help.php" class="pure-menu-link"><span class="material-symbols-outlined">help</span> Aide & Boite à outils</a></li>
          </ul>
      </div>
    </div>
';
?>