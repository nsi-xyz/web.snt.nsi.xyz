<section class="widgets">
    <div class="widget">
        <div class="stats-session-general-information-widget">
            <ul>
                <?php
                $session_date = (new DateTime())->setTimestamp(strtotime($session["date"]));
                $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::MEDIUM);
                ?>
                <li>Hôte de la session : <?php echo $session_owner; ?></li>
                <li>Date de création : <?php echo $dateFormatter->format($session_date); ?></li>
            </ul>
        </div>
    </div>
    <div class="widget">
        <div class="stats-session-global-stats-widget">
            <ul>
                <li></li>
            </ul>
        </div>
    </div>
</section>