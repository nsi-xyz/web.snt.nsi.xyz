<?php
            if (isset($_GET['response'])) {
                echo '
                <div class="compute">
                ';
                if (puzzleIsResolved()) {
                    echo '<p class="msgbox-ok">'.getOkMessage().'</p>';
                } else {
                    echo '<p class="msgbox-ko">'.getKoMessage().'</p>';
                };
                echo '
                </div>
                ';
            };