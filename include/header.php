<div class="header">
  <!-- <?= $translator->getMessage('comment_tip_header') ?> -->
  <h1><?= $translator->getMessage('global_website_name') ?></h1>
  <h2><?= $translator->getMessage('global_website_description') ?></h2>
  <h3 class="h3-<?= $puzzleProgression->isPuzzleSolved(Page::getCurrentPuzzle()) ? 'solved' : 'unsolved' ?>"><?= $translator->getMessage('puzzle_header_h3', ['puzzleId' => Page::getCurrentPuzzle()]) ?></h3>
</div>