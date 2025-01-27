<?php
if (currentUserInSession() || (isUserConnected() && sessionInProgress($db, $_SESSION["user_logged_in"]["id"]))) {
    $id_session = currentUserInSession() ? $_SESSION["user_logged_in"]["id_session"] : $id_session;
    $time_now = new DateTime(date("Y-m-d H:i:s", time()));
    $session_date = getRows($db, "sessions", "date", "id = \"$id_session\"")["date"];
    $session_duration = getRows($db, "sessions", "duration", "id = \"$id_session\"")["duration"];
    $session_date_end = new DateTime(date("Y-m-d H:i:s", strtotime($session_date) + $session_duration));
    $session_time_left = abs($session_date_end->getTimestamp() - $time_now->getTimestamp());
    $_SESSION["time_session_left"] = $session_time_left;
}
?>
<?php if (currentUserInSession() || (isUserConnected() && sessionInProgress($db, $_SESSION["user_logged_in"]["id"])))  : ?>
<script>
val = <?php echo $_SESSION["time_session_left"]; ?>;
document.querySelector("timer").textContent = `${(Math.floor(val/3600)).toString().padStart(2, "0")}:${((Math.floor(val/60)) % 60).toString().padStart(2, "0")}:${(val % 60).toString().padStart(2, "0")}`;
const timer = document.querySelector("timer");
function updateTimer() {
    let values = timer.textContent.split(":");
    let value = parseInt(values[0]*3600) + parseInt(values[1]*60) + parseInt(values[2]);
    if (value > 0) {
        value--;
        timer.textContent = `${(Math.floor(value/3600)).toString().padStart(2, "0")}:${((Math.floor(value/60)) % 60).toString().padStart(2, "0")}:${(value % 60).toString().padStart(2, "0")}`;
    } else {
        <?php if (currentUserInSession()) : ?>
            window.location.replace("/logout.php?reset");
        <?php else : ?>
            stop(<?php echo $id_session; ?>);
        <?php endif; ?>
    }
}

setInterval(updateTimer, 1000);
</script>
<?php endif; ?>