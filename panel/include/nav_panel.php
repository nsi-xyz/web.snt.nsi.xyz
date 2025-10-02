<div id="menu">
  <div class="pure-menu">
    <a class="pure-menu-heading" href="./index.php"><?= $translator->getMessage('global_panel_admin_name') ?></a>
    <ul class="infos-users">
      <li><?= $translator->getMessage('nav_user') ?> <strong><?= $session->getCurrentUser()->getUsername(); ?></strong></li>
    </ul>
    <?php
    $file = Page::getCurrentPage();
    $id_user = $session->getCurrentUser()->getId();
    $session_in_progress = /*sessionInProgress($db, $id_user);*/null;
    $session_code = /*$session_in_progress ? getRows($db, "sessions", "*", "host_id = $id_user AND status = 1")["code"] : null;*/null;
    ?>
    <ul class="pure-menu-list">
      <?php
      $selected_session_class = $file == 'session.php' ? 'pure-menu-item menu-item-divided pure-menu-selected-panel' : 'pure-menu-item-unselected';
      $selected_stats_class = $file == 'stats.php' ? 'pure-menu-item menu-item-divided pure-menu-selected-panel' : 'pure-menu-item-unselected';
      $selected_myaccount_class = $file == 'myaccount.php' ? 'pure-menu-item menu-item-divided pure-menu-selected-panel' : 'pure-menu-item-unselected';
      ?>
      <li class="<?= $selected_session_class ?>"><a href="./session.php" class="pure-menu-link">&#x1F310; Ma session</a></li>
      <li class="<?= $selected_stats_class ?>"><a href="./stats.php<?php echo $session_in_progress == true ? "?session=".$session_code : "" ?>" class="pure-menu-link">&#x1F4CA; Statistiques de session</a></li>
      <li class="<?= $selected_myaccount_class ?>"><a href="./myaccount.php" class="pure-menu-link">&#x1F464; Mon compte</a></li>
    </ul>
  </div>
  <div class="menu-bottom">
    <?php
    $selected_sessions_class = $file == 'sessions.php' ? 'pure-menu-item menu-item-divided pure-menu-selected-panel' : 'pure-menu-item-unselected';
    $selected_users_class = $file == 'users.php' ? 'pure-menu-item menu-item-divided pure-menu-selected-panel' : 'pure-menu-item-unselected';
    $selected_trads_class = $file == 'trads.php' ? 'pure-menu-item menu-item-divided pure-menu-selected-panel' : 'pure-menu-item-unselected';
    $selected_groups_class = $file == 'groups.php' ? 'pure-menu-item menu-item-divided pure-menu-selected-panel' : 'pure-menu-item-unselected';
    $selected_puzzles_class = $file == 'puzzles.php' ? 'pure-menu-item menu-item-divided pure-menu-selected-panel' : 'pure-menu-item-unselected';
    $is_admin = $session->getCurrentUser()->getGroupId() == 1;
    ?>
    <?php if ($is_admin) : ?>
    <li class="<?= $selected_sessions_class ?>"><a href="./sessions.php" class="pure-menu-link">&#x1F5C2;&#xFE0F; Explorateur de sessions</a></li>
    <li class="<?= $selected_users_class ?>"><a href="./users.php" class="pure-menu-link">&#x2699;&#xFE0F; Gestion des comptes</a></li>
    <li class="<?= $selected_trads_class ?>"><a href="./trads.php" class="pure-menu-link">&#x1F5C3;&#xFE0F; Gestion des traductions</a></li>
    <li class="<?= $selected_groups_class ?>"><a href="./groups.php" class="pure-menu-link">&#x1F3AD;&#xFE0F; Gestion des rôles</a></li>
    <li class="<?= $selected_puzzles_class ?>"><a href="./puzzles.php" class="pure-menu-link">&#x1F9E9;&#xFE0F; Gestion des énigmes</a></li>
    <?php endif; ?>
    <li class="pure-menu-item-back"><a href="../index.php" class="pure-menu-link">↩️ Retour aux énigmes</a></li>
    <li class="pure-menu-item-reset"><a href="../logout.php" class="pure-menu-link">&#x1F6AA; Se déconnecter</a></li>
  </div>
</div>