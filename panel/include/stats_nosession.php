<h2 class="content-subhead">Aucune session sélectionnée</h2>
<p class="p-content">Vous devez sélectionner la session dont vous souhaitez voir les statistiques.</p>
<h2 class="content-subhead">Mes dernières sessions</h2>
<?php
$id_user = $_SESSION["user_logged_in"]["id"];
if (rowsCount($db, "sessions", "id_owner = $id_user AND status = 0") > 0) {
    $sessions = getRows($db, "sessions", "*", "id_owner = $id_user AND status = 0 ORDER BY date DESC", 1);
} else {
    $sessions = array();
}
?>
<?php if (sizeof($sessions) == 0) : ?>
<p class="p-content">Vous n'avez pas encore créé de session. &#x1F615;</p>
<?php else : ?>
<p class="p-content">Voici ci-dessous les statistiques de vos dernières sessions :</p>
<?php endif; ?>
<ul>
<?php
if (sizeof($sessions) > 0) {
    foreach ($sessions as $session) {
        $session_date = (new DateTime())->setTimestamp(strtotime($session["date"]));
        echo '<li><a class="link" href="./stats.php?session='.$session["code"].'">Session '.$session["code"].' du '.$dateFormatter->format($session_date).'</a></li>';
    }
}
?>
</ul>