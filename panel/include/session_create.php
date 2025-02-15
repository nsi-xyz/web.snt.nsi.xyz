<h2 class="content-subhead">Aucune session</h2>
<p class="p-content">Vous n'avez actuellement aucune session en cours.</p>
<h2 class="content-subhead">Créer une session</h2>
<p class="p-content">Vous êtes sur le point de créer une session accessible pour vos élèves. Ci-dessous, vous pouvez configurer les paramètres liés à la session.</p>
<msg></msg>
<form method="POST" action="" class="pure-form">
    <h3 class="content-subhead">Durée de la session</h3>
    <button type="button" id="toggle-duration" class="pure-button">Ma session dure plus de 3 heures</button><br/><br/>
    <div id="short-duration-fields">
        <input type="number" id="hours" name="session_duration_hours" value="1" min="0" max="2" />
        <label for="hours">heures</label>
        <input type="number" id="minutes" name="session_duration_minutes" value="0" min="0" max="59" />
        <label for="minutes">minutes</label>
        <input type="number" id="seconds" name="session_duration_seconds" value="0" min="0" max="59" />
        <label for="seconds">secondes</label>
    </div>
    <div id="long-duration-fields" style="display: none;">
        <label for="end-date">Date de fermeture :</label>
        <input type="datetime-local" id="end-date" name="session_end_date"/>
    </div>
    <button class ="create-session-button" type="submit">Créer une session</button>
</form>
<script>
    const DateTime = luxon.DateTime;
    document.getElementById("toggle-duration").addEventListener("click", function () {
        const shortFields = document.getElementById("short-duration-fields");
        const longFields = document.getElementById("long-duration-fields");
        const toggleDurationButton = document.getElementById("toggle-duration");

        if (shortFields.style.display == "none") {
            shortFields.style.display = "block";
            longFields.style.display = "none";
            toggleDurationButton.innerText = "Ma session dure plus de 3 heures"
            document.getElementById("end-date").value = "";
        } else {
            shortFields.style.display = "none";
            longFields.style.display = "block";
            toggleDurationButton.innerText = "Ma session dure moins de 3 heures";
            setDefaultDateTimes();
        }
    });

    function setDefaultDateTimes() {
        const endDateInput = document.getElementById("end-date");
        const now = DateTime.now().setZone("Europe/Paris");
        const defaultEndDate = now.plus({hours: 24});
        const minEndDate = now.plus({minutes: 5});
        const maxEndDate = now.plus({days: 21});
        endDateInput.value = defaultEndDate.toFormat("yyyy-MM-dd'T'HH:mm");
        endDateInput.min = minEndDate.toFormat("yyyy-MM-dd'T'HH:mm");
        endDateInput.max = maxEndDate.toFormat("yyyy-MM-dd'T'HH:mm");
    }
</script>
<?php
if (isset($_POST["session_duration_hours"], $_POST["session_duration_minutes"], $_POST["session_duration_seconds"]) || isset($_POST["session_end_date"])) {
    if (isset($_POST["session_end_date"]) && $_POST["session_end_date"] != "") {
        $end_date = strtotime($_POST["session_end_date"]);
        $current_time = time();
        $session_duration = $end_date - $current_time;
        if ($end_date > $current_time && $session_duration >= 300 && $session_duration <= 1900800) { // Une session dure entre 5 minutes et 22 jours
            createSession($db, $id_user, $session_duration);
            echo '<script>window.location.replace(window.location.href);</script>';
            exit();
        } else {
            throwError("Une session doit durer entre 5 minutes et 3 semaines.");
        }
    } else {
        $h = intval($_POST["session_duration_hours"]);
        $m = intval($_POST["session_duration_minutes"]);
        $s = intval($_POST["session_duration_seconds"]);
        $session_duration = $h * 3600 + $m * 60 + $s;
        if ($session_duration >= 300 && $session_duration <= 1900800) { // Une session dure entre 5 minutes et 22 jours
            createSession($db, $id_user, $session_duration);
            echo '<script>window.location.replace(window.location.href);</script>';
            exit();
        } else {
            throwError("Une session doit durer entre 5 minutes et 3 heures.");
        }
    }
}
?>
