<section class="widgets">
    <div class="widget">
        <div class="widget-title">
            <h3>Informations générales de la session</h3>
        </div>
        <div class="stats-session-general-information-widget">
            <ul>
                <?php
                $session_date = (new DateTime())->setTimestamp(strtotime($session["date"]));
                $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::MEDIUM);
                ?>
                <li>Identifiant : #<?php echo $session_id; ?> (<?php echo $_GET["session"]; ?>)</li>
                <li>Hôte de la session : <?php echo $session_owner; ?></li>
                <li>Date de création : <?php echo $dateFormatter->format($session_date); ?></li>
                <li>Participants : <?php echo count($session_users); ?> [Voir la liste (fonction js qui met en surbrillance le widget)]</li>
            </ul>
        </div>
    </div>
    <div class="widget">
        <div class="widget-title">
            <h3>Participants de la session</h3>
        </div>
        <div class="stats-session-global-stats-widget">
            <ul>
                <?php
                foreach ($session_users as $user) {
                    echo "<li>".$user["pseudo"]."</li>";
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="widget">
        <div class="widget-title">
            <h3>Classement</h3>
        </div>
        <div class="stats-session-global-stats-widget">
            <ul>
                <?php
                foreach ($session_users as $user) {
                    echo "<li>".$user["pseudo"]."</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</section>