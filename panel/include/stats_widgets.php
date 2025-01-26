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
                <li>Participants : <?php echo $session_users == null ? "0" : count($session_users); ?></li>
            </ul>
        </div>
    </div>
    <div class="widget">
        <form method="GET" action="" class="pure-form">
            <fieldset>
                <label for="sorting-type">Trier par</label>
                <select id="sorting-type" name="sort-by">
                    <option><?php echo $_SESSION["sort-by"] == "Date" ? "Date" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Pseudo (ABC)" : "Pseudo (ZYX)")?></option>
                    <option><?php echo $_SESSION["sort-by"] == "Date" ? "Pseudo (ABC)" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Pseudo (ZYX)" : "Date")?></option>
                    <option><?php echo $_SESSION["sort-by"] == "Date" ? "Pseudo (ZYX)" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Date" : "Pseudo (ABC)")?></option>
                </select>
                <button type="submit" class="pure-button pure-button-primary">Appliquer</button>
            </fieldset>
        </form>
        <table class="pure-table">
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th colspan="10">Énigmes</th>
                    <th>Heure</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="users-session-list">
                <tr>
                    <td>Prochainement...</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>