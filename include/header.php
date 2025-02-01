<div class="header">
                <!-- La balise <h1> contient le titre principal de la page, qui est généralement la première chose que les utilisateurs voient. -->
                <h1><?php echo traduction("global_website_name"); ?></h1>
                <h2><?php echo traduction("global_website_description"); ?></h2>
                <h3 class="h3-<?php echo puzzleIsResolved() ? "resolved" : "unresolved"; ?>">Énigme <?php echo getCurrentPuzzleID(); ?></h3>
            </div>