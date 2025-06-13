<table class="table">
  <?= Page::getCurrentPuzzle() !== null ? $translator->getMessage('puzzle_message_already_solved') : '' ?>
  <tbody>
    <tr>
      <?php $p_i = (in_array(Page::getCurrentPage(), array('index.php', 'help.php', 'login.php'))) ? '' : '.'; ?>
      <?php for ($i = 1; $i <= PUZZLE_COUNT; $i++) : ?>
        <?php
        $class = $puzzleProgression->isPuzzleSolved($i) ? 'solved' : 'unsolved';
        $tdClass = "td-$class";
        ?>
        <?php if ($i < 10 || ($i === 10 && $puzzleProgression->isPuzzle10Unlocked())) : ?>
          <td class="<?= $tdClass ?>" onclick="location.href='.<?= $p_i ?>/puzzles/puzzle<?= $i ?>.php'"><?= sprintf('%02d', $i) ?></td>
        <?php elseif ($i === 10 && !$puzzleProgression->isPuzzle10Unlocked()) : ?>
          <td class="td-hidden" onclick="alert('<?= $translator->getMessage('puzzle_message_hidden_puzzle10') ?>')"><?= sprintf('%02d', $i) ?></td>
        <?php endif; ?>
      <?php endfor; ?>
    </tr>
  </tbody>
</table>
<?= $puzzleProgression->allPuzzlesSolved() ? $translator->getMessage('puzzle_message_gg') : '' ?>