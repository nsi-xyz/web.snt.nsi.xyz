<table class="table">
  <?php echo getCurrentPuzzleID() != NULL ? traduction("puzzle_message_already_resolved") : "" ?>
          <tbody>
            <tr>
              <?php
              for ($i = 1; $i <= 9; $i++) {
                $class = puzzleIsResolved($i) ? "resolved" : "unresolved";
                $p = basename($_SERVER['PHP_SELF']);
                $path = ($p == "index.php" || $p == "help.php") ? "." : "..";
                echo '<td class="td-'.$class.'" onclick="location.href=\''.$path.'/puzzles/puzzle'.$i.'.php\'">'.sprintf("%02d", $i).'</td>
              ';
              }
              if (isset($_SESSION["puzzle10"])) {
              $class = puzzleIsResolved(10) ? "resolved" : "unresolved";
              echo '<td class="td-'.$class.'" onclick="location.href=\''.$path.'/puzzles/puzzle10.php\'">10</td>
              ';
              } else {
                echo '<td class="td-hidden" onclick="alert(\''.traduction("puzzle_message_hidden_puzzle10").'\')">10</td>
                ';
              }
              ?></tr>
          </tbody>
</table>
<?php echo count($_SESSION["resolvedPuzzles"]) == 10 ? traduction("puzzle_message_gg") : "" ?>