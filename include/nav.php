<?php
$p = basename($_SERVER['PHP_SELF']);
$currentPuzzle = ($p == "index.php" || $p == "help.php") ? NULL : filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT);
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
    $class = $i == $currentPuzzle ? "pure-menu-item menu-item-divided pure-menu-selected-".$resolved : "pure-menu-item-".$resolved;
    echo '            <li class="'.$class.'"><a href=".'.$p_i.'/puzzles/puzzle'.$i.'.php" class="pure-menu-link">'.$emoji.' Énigme web 0'.$i.'</a></li>
';
}
$d = $i != 10 ? "0" : "";
if (!isset($_SESSION["puzzle10"])) {
  $indicators = array("L'énigme 10 est cachée,", "le lien hypertexte qui pointe vers", "l'énigme 10 ne s'affiche", "que quand vous aurez résolu", "la 1ère partie de l'énigme 10.", "Pour commencer", "il faut déjà trouver", "comment accéder", "à l'énigme 😉");
  $commentary = $currentPuzzle != NULL ? $indicators[$currentPuzzle - 1] : "Rien à voir ici.";
  echo '            <li class="pure-menu-item"><a href="#" id="alert" class="pure-menu-link-hidden">&#x26AB; Énigme web 10</a><!--'.$commentary.'--></li>
';
echo '<script>
var warn = document.getElementById("alert");

warn.addEventListener("click", function() {alert("Ce lien n\'est pas cliquable...\nMais cette énigme existe ! \uD83E\uDD14");});</script>';
} else {
  $emoji = in_array($i, $_SESSION["resolvedPuzzles"]) ? "&#x1F7E2;" : "&#x1F7E0;";
  $resolved = in_array(10, $_SESSION["resolvedPuzzles"]) ? "resolved" : "unresolved";
  $class = $currentPuzzle == 10 ? "pure-menu-item menu-item-divided pure-menu-selected-".$resolved : "pure-menu-item-".$resolved;
  echo '            <li class="'.$class.'"><a href=".'.$p_i.'/puzzles/puzzle10.php" class="pure-menu-link">'.$emoji.' Énigme web 10</a></li>
';
}
$class = $p == "help.php" ? "pure-menu-item menu-item-divided pure-menu-selected-help" : "pure-menu-item-help";
echo '            <li class="'.$class.'"><a href="'.$p_h.'/help.php" class="pure-menu-link">&#x1F537; Aide & Boite à outils</a></li>
          </ul>
      </div>';
$time = isset($_SESSION["time_left"]) ? $_SESSION["time_left"] : "?";
$plural = intval($time) <= 1 ? "" : "s";
echo '            <div class="menu-bottom"><li class="pure-menu-item-timer">Il reste <timer>'.$time.'</timer> minute'.$plural.'</li>
  ';
echo '            <li class="pure-menu-item-reset"><a href="'.$p_h.'/help.php#Effacer sa progression et recommencer les énigmes" class="pure-menu-link">&#x274C; Effacer / Recommencer</a></li></div>
    </div>
';
?>