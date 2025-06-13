<?php
$p = Page::getCurrentPage();
$currentPuzzle = Page::getCurrentPuzzle();
$p_i = (in_array($p, array('index.php', 'help.php', 'login.php'))) ? '' : '.';
?>
<div id="menu">
  <div class="pure-menu">
    <a class="pure-menu-heading" href=".<?= $p_i ?>/index.php"><?= $translator->getMessage("global_website_description_short") ?></a>
    <ul class="pure-menu-list">
      <?php if ($session->currentUserIsGuest()) : ?>
        <li class="pure-menu-item menu-item-divided pure-menu-item-login"><a class="pure-menu-link" href=".<?= $p_i ?>/login.php"><?= $translator->getMessage('nav_login') ?></a></li>
      <?php elseif ($session->currentUserIsPlayer()) : ?>
        <div class="infos-users">
          <li><?= $translator->getMessage('nav_session') ?> <strong><?= $session->getCurrentUser()->getGameSession()->getCode() ?></strong></li>
          <li style="padding-top: 0.6em;"><?= $translator->getMessage('nav_pseudo') ?> <strong><?= $session->getCurrentUser()->getPseudo() ?></strong></li>
        </div>
      <?php elseif ($session->currentUserIsUser()) : ?>
        <div class="infos-users">
          <?php $gameSessionsOpenCount = $session->getCurrentUser()->getNumberOfOpenSessions($gameSessionRepository); ?>
          <?php if ($gameSessionsOpenCount > 0) : ?>
            <li><?= $translator->getMessage('nav_sessions') ?> <strong><?= $gameSessionsOpenCount ?></strong></li>
          <?php else : ?>
            <li><?= $translator->getMessage('nav_nosession') ?></li>
          <?php endif; ?>
          <li style="padding-top: 0.6em;"><?= $translator->getMessage('nav_user') ?> <strong><?= $session->getCurrentUser()->getUsername() ?></strong></li>
        </div>
        <li class="pure-menu-item-back"><a href=".<?= $p_i ?>/panel/" class="pure-menu-link"><?= $translator->getMessage('nav_panel') ?></a></li>
      <?php endif; ?>
      <?php for ($i = 1; $i <= PUZZLE_COUNT; $i++) : ?>
        <?php
        $menuPuzzleEmoji = $puzzleProgression->isPuzzleSolved($i) ? '&#x1F7E2;' : '&#x1F7E0;';
        $menuPuzzleStatus = $puzzleProgression->isPuzzleSolved($i) ? 'solved' : 'unsolved';
        $menuPuzzleClass = $i == $currentPuzzle ? "pure-menu-item menu-item-divided pure-menu-selected-$menuPuzzleStatus" : "pure-menu-item-$menuPuzzleStatus";
        ?>
        <?php if ($i < 10 || ($i === 10 && $puzzleProgression->isPuzzle10Unlocked())) : ?>
          <li class="<?= $menuPuzzleClass ?>"><a href=".<?= $p_i ?>/puzzles/puzzle<?= $i ?>.php" class="pure-menu-link"><?= $menuPuzzleEmoji ?> <?= $translator->getMessage('nav_puzzle') ?> <?= sprintf("%2d", $i) ?></a></li>
        <?php elseif ($i === 10 && !$puzzleProgression->isPuzzle10Unlocked()) : ?>
          <?php $menuPuzzle10Commentary = $currentPuzzle !== null ? $translator->getMessage("comment_puzzle10_clue$currentPuzzle") : $translator->getMessage('comment_puzzle10_not_clue'); ?>
          <li class="pure-menu-item"><a href="#" id="alert" class="pure-menu-link-hidden">&#x26AB; <?= $translator->getMessage('nav_puzzle') ?> <?= sprintf("%2d", $i) ?></a><!-- <?= $menuPuzzle10Commentary ?> --></li>
          <script>
          let warn = document.getElementById("alert");
          warn.addEventListener("click", function() { alert("<?= $translator->getMessage('puzzle_message_hidden_puzzle10') ?>"); });
          </script>
        <?php endif; ?>
      <?php endfor; ?>
      <?php $menuHelpClass = $p == 'help.php' ? 'pure-menu-item menu-item-divided pure-menu-selected-help' : 'pure-menu-item-help' ?>
      <li class="<?= $menuHelpClass ?>"><a href=".<?= $p_i ?>/help.php" class="pure-menu-link"><?= $translator->getMessage('nav_help') ?></a></li>
    </ul>
  </div>
  <?php
  if ((!$session->currentUserIsUser() && !$session->currentUserIsPlayer()) || ($session->currentUserIsUser() && !$session->getCurrentUser()->hasOpenSession($gameSessionRepository))) {
    $menuTime = $translator->getMessage('nav_startedat') . ' ' . ($session->getSessionStartTime() !== null ? date('H\hi', $session->getSessionStartTime()) : '?');
  } elseif ($session->currentUserIsPlayer()) {
    $menuTime = $translator->getMessage('nav_sessionendin') . '<timer gamesessionid="' . $session->getCurrentUser()->getGameSessionId() . '">/timer>';
  }
  ?>
  <div class="menu-bottom">
    <li class="pure-menu-item-timer"><?= $menuTime ?></li>
    <li class="pure-menu-item-reset"><a href="./help.php#Effacer sa progression et recommencer les énigmes" class="pure-menu-link"><?= $translator->getMessage($session->currentUserIsUser() ? 'nav_logout' : ($session->currentUserIsPlayer() ? 'nav_leave' : 'nav_restart')) ?></a></li>
  </div>
</div>