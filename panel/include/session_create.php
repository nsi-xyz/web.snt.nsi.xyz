<h2 class="content-subhead">Aucune session</h2>
<p class="p-content">Vous n'avez actuellement aucune session en cours.</p>
<h2 class="content-subhead">Créer une session</h2>
<p class="p-content">Vous êtes sur le point de créer une session accessible pour vos élèves. Ci-dessous, vous pouvez configurer les paramètres liés à la session.</p>
<error></error>
<form method="POST" action="" class="pure-form">
    <h3 class="content-subhead">Durée de la session</h3>
    <input type="number" id="hours" name="session_duration_hours" value="1" min="0" max="2"/>
    <label for="hours">Heures</label>
    <input type="number" id="minutes" name="session_duration_minutes" value="0" min="0" max="59"/>
    <label for="hours">Minutes</label>
    <input type="number" id="seconds" name="session_duration_seconds" value="0" min="0" max="59"/>
    <label for="hours">Secondes</label>
    <button class ="create-session-button" type="submit">Créer une session</button>
</form>
<?php
if (isset($_POST["session_duration_hours"], $_POST["session_duration_minutes"], $_POST["session_duration_seconds"])) {
    $h = intval($_POST["session_duration_hours"]);
    $m = intval($_POST["session_duration_minutes"]);
    $s = intval($_POST["session_duration_seconds"]);
    $session_duration = $h*3600 + $m*60 + $s;
    if ($session_duration >= 300) {
        createSession($db, $id_user, $session_duration);
        echo '<script>window.location.replace(window.location.href);</script>';
    } else {
        throwError("Une session doit durer au moins 5 minutes.");
    }
}
?>