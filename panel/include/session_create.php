<h2 class="content-subhead">Aucune session</h2>
<p class="p-content">Vous n'avez actuellement aucune session en cours.</p>
<h2 class="content-subhead">Créer une session</h2>
<p class="p-content">Vous êtes sur le point de créer une session accessible pour vos élèves. Ci-dessous, vous pouvez configurer les paramètres liés à la session.</p>
<form method="POST" action="" class="pure-form pure-form-stacked">
    <h3 class="content-subhead">Durée de la session</h3>
    <label for="aligned-name">[WIP • NE FONCTIONNE PAS] Durée en secondes avant que la session ne se ferme</label>
    <input type="number" id="aligned-name" placeholder="Durée en secondes" name="session_duration" value="3600"/>
    <button class ="create-session-button" type="submit">Créer une session</button>
</form>
<?php
if (isset($_POST["session_duration"])) {
    createSession($db, $id_user);
    echo '<script>window.location.replace(window.location.href);</script>';
}
?>