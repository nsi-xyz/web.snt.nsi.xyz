<table class="table">
          <tbody>
            <tr>
              <?php
              for ($i = 1; $i <= 9; $i++) {
                $class = puzzleIsResolved($i) ? "resolved" : "unresolved";
                $p = basename($_SERVER['PHP_SELF']);
                $path = ($p == "index.php" || $p == "help.php") ? "." : "..";
                echo '<td class="td-'.$class.'" onclick="location.href=\''.$path.'/puzzles/puzzle'.$i.'.php\'">'.sprintf("%02d", $i).'</td>
              ';
              };
              if (isset($_SESSION["puzzle10"])) {
              $class = puzzleIsResolved(10) ? "resolved" : "unresolved";
              echo '<td class="td-'.$class.'" onclick="location.href=\''.$path.'/puzzles/puzzle10.php\'">10</td>
              ';
              } else {
                echo '<td class="td-hidden">10</td>
                ';
              };
              ?></tr>
          </tbody>
</table>