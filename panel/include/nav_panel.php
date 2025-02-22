<div id="menu">
  <div class="pure-menu">
    <a class="pure-menu-heading" href="./index.php"><?php echo traduction("global_panel_admin_name"); ?></a>
    <ul class="infos-users">
      <li><?php echo traduction("nav_user"); ?> <strong><?php echo $_SESSION["user_logged_in"]["username"]; ?></strong></li>
    </ul>
    <?php
    $file = basename($_SERVER['PHP_SELF']);
    $id_user = $_SESSION["user_logged_in"]["id"];
    $session_in_progress = sessionInProgress($db, $id_user);
    $session_code = $session_in_progress ? getRows($db, "sessions", "*", "id_owner = $id_user AND status = 1")["code"] : null;
    ?>
    <ul class="pure-menu-list">
      <?php
      $selected_session_class = $file == "session.php" ? "pure-menu-item menu-item-divided pure-menu-selected-panel" : "pure-menu-item-unselected";
      $selected_stats_class = $file == "stats.php" ? "pure-menu-item menu-item-divided pure-menu-selected-panel" : "pure-menu-item-unselected";
      $selected_myaccount_class = $file == "myaccount.php" ? "pure-menu-item menu-item-divided pure-menu-selected-panel" : "pure-menu-item-unselected";
      ?>
      <li class="<?php echo $selected_session_class; ?>"><a href="./session.php" class="pure-menu-link">&#x1F310; Ma session</a></li>
      <li class="<?php echo $selected_stats_class; ?>"><a href="./stats.php<?php echo $session_in_progress == true ? "?session=".$session_code : "" ?>" class="pure-menu-link">&#x1F4CA; Statistiques de session</a></li>
      <li class="<?php echo $selected_myaccount_class; ?>"><a href="./myaccount.php" class="pure-menu-link">&#x1F464; Mon compte</a></li>
    </ul>
  </div>
  <div class="menu-bottom">
    <?php
    $selected_sessions_class = $file == "sessions.php" ? "pure-menu-item menu-item-divided pure-menu-selected-panel" : "pure-menu-item-unselected";
    $selected_users_class = $file == "users.php" ? "pure-menu-item menu-item-divided pure-menu-selected-panel" : "pure-menu-item-unselected";
    $selected_trads_class = $file == "trads.php" ? "pure-menu-item menu-item-divided pure-menu-selected-panel" : "pure-menu-item-unselected";
    $is_admin = $_SESSION["user_logged_in"]["id_group"] == 1;
    ?>
    <?php if ($is_admin) : ?>
    <li class="<?php echo $selected_sessions_class; ?>"><a href="./sessions.php" class="pure-menu-link">&#x1F5C2;&#xFE0F; Explorateur de sessions</a></li>
    <li class="<?php echo $selected_users_class; ?>"><a href="./users.php" class="pure-menu-link">&#x2699;&#xFE0F; Gestion des comptes</a></li>
    <li class="<?php echo $selected_trads_class; ?>"><a href="./trads.php" class="pure-menu-link">&#x1F5C3;&#xFE0F; Gestion des traductions</a></li>
    <?php endif; ?>
    <li class="pure-menu-item-back"><a href="../index.php" class="pure-menu-link">↩️ Retour aux énigmes</a></li>
    <li class="pure-menu-item-reset"><a href="../logout.php" class="pure-menu-link">&#x1F6AA; Se déconnecter</a></li>
  </div>
</div>