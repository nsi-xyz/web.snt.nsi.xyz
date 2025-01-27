<?php
if (isUserConnected() && sessionInProgress($db, $_SESSION["user_logged_in"]["id"])) {
  $id_user = $_SESSION["user_logged_in"]["id"];
  $id_session = getRows($db, "sessions", "*", "id_owner = $id_user AND status = 1")["id"];
}
$p = basename($_SERVER['PHP_SELF']);
$currentPuzzle = (in_array($p, array("index.php", "help.php", "login.php"))) ? null : filter_var(basename($_SERVER['PHP_SELF']), FILTER_SANITIZE_NUMBER_INT);
$p_i = (in_array($p, array("index.php", "help.php", "login.php"))) ? "" : ".";
$p_h = (in_array($p, array("index.php", "help.php", "login.php"))) ? "." : "..";
?>
<div id="menu">
  <div class="pure-menu">
    <a class="pure-menu-heading" href=".<?php echo $p_i; ?>/index.php"><?php echo traduction("global_website_description_short"); ?></a>
    <ul class="pure-menu-list">
      <?php
        if (!currentUserInSession() && !isUserConnected()) {
          echo '<li class="pure-menu-item menu-item-divided pure-menu-item-login"><a class="pure-menu-link" href=".'.$p_i.'/login.php">'.traduction("nav_login").'</a></li>';
        } elseif (currentUserInSession()) {
          echo '
          <div class="infos-users">
            <li>🕒 Session : <strong>'.getRows($db,"sessions","code","id={$_SESSION["user_logged_in"]["id_session"]}")["code"].'</strong></li>
            <li style="padding-top: 0.6em;">🚹 Pseudo : <strong>'.$_SESSION["user_logged_in"]["pseudo"].'</strong></li>
          </div>
            ';
        } elseif (isUserConnected()) {
          echo '
          <div class="infos-users">';
          $codeSession = getRows($db, "sessions", "code", "id_owner = {$_SESSION["user_logged_in"]["id"]} AND status = 1");
            if (isset($codeSession) && $codeSession != null) {
              echo '<li>🕒 Session : <strong>'.$codeSession["code"].'</strong></li>';
            } else {
              echo '<li>🕒 Aucune session existante</li>';
            }
            
            echo '<li style="padding-top: 0.6em;">🚹 Utilisateur : <strong>'.$_SESSION["user_logged_in"]["username"].'</strong></li>
          </div>';
          if ($_SESSION["user_logged_in"]["id_group"] == 1){
            echo '<li class="pure-menu-item-back"><a href="'.$p_h.'/panel/" class="pure-menu-link">➡️ Panneau d\'administration</a></li>';
          } else {
            echo '<li class="pure-menu-item-back"><a href="'.$p_h.'/panel/session.php" class="pure-menu-link">➡️ Gérer la session</a></li>';
          }
        }
        ?>
<?php           
for ($i = 1; $i < 10; $i++) {
    $emoji = in_array($i, $_SESSION["resolvedPuzzles"]) ? "&#x1F7E2;" : "&#x1F7E0;";
    $resolved = in_array($i, $_SESSION["resolvedPuzzles"]) ? "resolved" : "unresolved";
    $class = $i == $currentPuzzle ? "pure-menu-item menu-item-divided pure-menu-selected-".$resolved : "pure-menu-item-".$resolved;
    echo '            <li class="'.$class.'"><a href=".'.$p_i.'/puzzles/puzzle'.$i.'.php" class="pure-menu-link">'.$emoji.' '.traduction("nav_puzzle").' 0'.$i.'</a></li>
';
}
$d = $i != 10 ? "0" : "";
if (!isset($_SESSION["puzzle10"])) {
  $indicators = array("L'énigme 10 est cachée,", "le lien hypertexte qui pointe vers", "l'énigme 10 ne s'affiche", "que quand vous aurez résolu", "la 1ère partie de l'énigme 10.", "Pour commencer", "il faut déjà trouver", "comment accéder", "à l'énigme 😉");
  $commentary = $currentPuzzle != NULL ? $indicators[$currentPuzzle - 1] : "Rien à voir ici.";
  echo '            <li class="pure-menu-item"><a href="#" id="alert" class="pure-menu-link-hidden">&#x26AB; '.traduction("nav_puzzle").' 10</a><!--'.$commentary.'--></li>
';
echo '<script>
var warn = document.getElementById("alert");

warn.addEventListener("click", function() {alert("'.HIDDEN_PUZZLE10_MESSAGE.'");});</script>';
} else {
  $emoji = in_array($i, $_SESSION["resolvedPuzzles"]) ? "&#x1F7E2;" : "&#x1F7E0;";
  $resolved = in_array(10, $_SESSION["resolvedPuzzles"]) ? "resolved" : "unresolved";
  $class = $currentPuzzle == 10 ? "pure-menu-item menu-item-divided pure-menu-selected-".$resolved : "pure-menu-item-".$resolved;
  echo '            <li class="'.$class.'"><a href=".'.$p_i.'/puzzles/puzzle10.php" class="pure-menu-link">'.$emoji.' Énigme web 10</a></li>
';
}
$class = $p == "help.php" ? "pure-menu-item menu-item-divided pure-menu-selected-help" : "pure-menu-item-help";
echo '            <li class="'.$class.'"><a href="'.$p_h.'/help.php" class="pure-menu-link">'.traduction("nav_help").'</a></li>
          </ul>
      </div>';
if ((!currentUserInSession() && !isUserConnected()) || (isUserConnected() && !sessionInProgress($db, $_SESSION["user_logged_in"]["id"]))) {
  $time = isset($_SESSION["time_session_start"]) ? traduction("nav_startedat")." <timer>".date("H\hi", $_SESSION["time_session_start"])."</timer>" : traduction("nav_startedat")." <timer>?</timer>";
} else {
  $time = "Fin de la session : <timer></timer>";
}
echo '            <div class="menu-bottom"><li class="pure-menu-item-timer">'.$time.'</li>
  ';

if (isUserConnected()){
  echo '            <li class="pure-menu-item-reset"><a href="'.$p_h.'/help.php#Effacer sa progression et recommencer les énigmes" class="pure-menu-link">&#x274C; Déconnexion</a></li></div>
    </div>
';
} elseif (currentUserInSession()) {
  echo '            <li class="pure-menu-item-reset"><a href="'.$p_h.'/help.php#Effacer sa progression et recommencer les énigmes" class="pure-menu-link">&#x274C; Quitter la session</a></li></div>
    </div>
';
} else {
  echo '            <li class="pure-menu-item-reset"><a href="'.$p_h.'/help.php#Effacer sa progression et recommencer les énigmes" class="pure-menu-link">'.traduction("nav_restart").'</a></li></div>
      </div>
  ';
}