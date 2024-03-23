<?php
$timer_duration = SESSDURATION;
$current_time = time();
$elapsed_time = $current_time - $_SESSION['time_init'];
$_SESSION["time_left"] = $timer_duration - $elapsed_time <= 0 ? $timer_duration : $timer_duration - $elapsed_time;
if ($_SESSION["time_left"] <= 0) {
    // TODO
}
?>

<script>
val = <?php echo round(($_SESSION["time_left"])/60); ?>

document.querySelector("timer").textContent = val.toString().padStart(2, "0")
const timer = document.querySelector("timer");
function updateTimer() {
    let value = parseInt(timer.textContent);
    if (value > 0) {
        value--;
        timer.textContent = value.toString().padStart(2, "0");
    } else {
        window.location.replace(window.location.href);
    }
}

setInterval(updateTimer, 60000);
</script>