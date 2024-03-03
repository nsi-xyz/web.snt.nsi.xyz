<div id="menu">
  <div class="pure-menu">
    <a class="pure-menu-heading" href="./index.php">Panel Admin</a>
    <ul>
      <li>Utilisateur : <?php echo $_SESSION["user_logged_in"]["username"]; ?></li>
    </ul>
    <?php
    $file = basename($_SERVER['PHP_SELF']);
    ?>
    <ul class="pure-menu-list">
      <?php
      $selected_session_class = $file == "session.php" ? "pure-menu-item menu-item-divided pure-menu-selected-panel" : "pure-menu-item-unselected";
      $selected_stats_class = $file == "stats.php" ? "pure-menu-item menu-item-divided pure-menu-selected-panel" : "pure-menu-item-unselected";
      ?>
      <li class="<?php echo $selected_session_class; ?>"><a href="./session.php" class="pure-menu-link">&#x1F465; Ma session</a></li>
      <li class="<?php echo $selected_stats_class; ?>"><a href="./stats.php" class="pure-menu-link">&#x1F4CA; Statistiques de session</a></li>
    </ul>
  </div>
  <div class="menu-bottom">
    <?php
    $selected_sessions_class = $file == "sessions.php" ? "pure-menu-item menu-item-divided pure-menu-selected-panel" : "pure-menu-item-unselected";
    $selected_users_class = $file == "users.php" ? "pure-menu-item menu-item-divided pure-menu-selected-panel" : "pure-menu-item-unselected";
    $selected_trads_class = $file == "trads.php" ? "pure-menu-item menu-item-divided pure-menu-selected-panel" : "pure-menu-item-unselected";
    ?>
    <li class="<?php echo $selected_sessions_class; ?>"><a href="./sessions.php" class="pure-menu-link">&#x1F5C2;&#xFE0F; Parcourir les sessions</a></li>
    <li class="<?php echo $selected_users_class; ?>"><a href="./users.php" id="account-manager" class="pure-menu-link">&#x2699;&#xFE0F; Gestion des comptes</a></li>
    <li class="<?php echo $selected_trads_class; ?>"><a href="./trads.php" class="pure-menu-link-hidden">&#x1F5C3;&#xFE0F; Gestion des traductions</a></li>
    <li class="pure-menu-item-reset"><a class="pure-menu-link" id="logout">&#x1F6AA; Se déconnecter</a></li>
  </div>
</div>
<?php
if (isset($_COOKIE["reset-js"])) {
  resetSession("../login.php", 1);
}
?>
<script>
  document.getElementById("logout").addEventListener("click", function() {
    let date = new Date();
    date.setTime(date.getTime() + 1000);
    let expiration = "expires=" + date.toUTCString();
    document.cookie = "reset-js=ok;" + expiration + ";path=/";
    window.location.replace(window.location.href);
  });

  function isAllowed(idUser){
    // document.getElementById("account-manager").classList.
    // A FAIRE
  } 
</script>