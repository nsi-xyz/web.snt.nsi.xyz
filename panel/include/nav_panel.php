<div id="menu">
  <div class="pure-menu">
    <a class="pure-menu-heading" href="./index.php">Panel Admin</a>
    <ul>
      <li>Utilisateur : <?php echo $_SESSION["user_logged_in"]["username"]; ?></li>
    </ul>
    <ul class="pure-menu-list">
      <li class="pure-menu-item"><a href="./session.php" class="pure-menu-link">&#x1F465; Ma session</a></li>
      <li class="pure-menu-item"><a href="./stats.php" class="pure-menu-link">&#x1F4CA; Statistiques de session</a></li>
    </ul>
  </div>
  <div class="menu-bottom">
    <li class="pure-menu-item"><a href="./sessions.php" class="pure-menu-link">&#x1F5C2;&#xFE0F; Parcourir les sessions</a></li>
    <li class="pure-menu-item"><a href="./users.php" class="pure-menu-link-hidden">&#x2699;&#xFE0F; Gestion des comptes</a></li>
    <li class="pure-menu-item"><a href="./trads.php" class="pure-menu-link-hidden">&#x1F5C3;&#xFE0F; Gestion des traductions</a></li>
    <li class="pure-menu-item-reset"><a class="pure-menu-link" id="logout">&#x1F6AA; Se déconnecter</a></li>
  </div>
</div>
<?php
if (isset($_COOKIE["reset-js"])) {
  resetSession("../index.php", 1);
}
?>
<script>
  document.getElementById("logout").addEventListener("click", function() {
    let date = new Date();
    date.setTime(date.getTime() + 1000);
    let expiration = "expires=" + date.toUTCString();
    document.cookie = "reset-js=ok;" + expiration + ";path=/";
    window.location.replace((window.location.href).replace(/panel.*/, ""));
  });
</script>