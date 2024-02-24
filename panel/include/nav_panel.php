<?php
echo '<div id="menu">
      <div class="pure-menu">
        <a class="pure-menu-heading" href="./index.php">Panneau d\'administration</a>
          <ul class="pure-menu-list">
';
echo '            <li class="pure-menu-item"><a href="./session.php" class="pure-menu-link">Gestion de la session</a></li>
                  <li class="pure-menu-item"><a href="./stats.php" class="pure-menu-link">Voir les statistiques</a></li>
                  <li class="pure-menu-item"><a href="./users.php" class="pure-menu-link">Gestion des comptes</a></li>
                  <li class="pure-menu-item"><a href="./trads.php" class="pure-menu-link">Gestion des traductions</a></li>
';
echo '            </ul></div>';
echo '            <div class="menu-bottom"><li class="pure-menu-item-reset"><a class="pure-menu-link" id="logout">&#x1F6AA; Se déconnecter</a></li></div>
</div></div>
  ';
if (isset($_COOKIE["reset-js"])) {
  resetSession("../index.php");
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