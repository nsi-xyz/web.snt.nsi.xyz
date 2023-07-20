<?php
$p = basename($_SERVER['PHP_SELF']) == "index.php" ? "" : ".";
echo '<div id="menu">
      <div class="pure-menu">
        <a class="pure-menu-heading" href=".'.$p.'/index.php">10 Énigmes à résoudre</a>
          <ul class="pure-menu-list">
';
for ($i = 1; $i < 10; $i++) {
    $locker = in_array($i, $_SESSION["resolvedPuzzles"]) ? "" : "lock";
    echo '            <li class="pure-menu-item"><a href=".'.$p.'/puzzles/puzzle'.$i.'.php" class="pure-menu-link"><span class="material-symbols-outlined">'.$locker.'</span> Énigme web 0'.$i.'</a></li>
';
}
echo '            <li class="pure-menu-item"><a href="#home" class="pure-menu-link"><span class="material-symbols-outlined">help</span> Aide & Boite à outils</a></li>
          </ul>
      </div>
    </div>
';
?>