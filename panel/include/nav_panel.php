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
echo '            </ul></div></div>';
?>