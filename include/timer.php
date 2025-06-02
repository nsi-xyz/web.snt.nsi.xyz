<script>
const sessionTimers = <?php echo json_encode($sessionsTimes); ?>;

document.querySelectorAll("timer[gamesessionid]").forEach(timer => {
    const sessionId = timer.getAttribute("gamesessionid");
    let secondsLeft = sessionTimers[sessionId];

    const formatTime = (secs) => {
        const h = String(Math.floor(secs/3600)).padStart(2, '0');
        const m = String(Math.floor((secs % 3600)/60)).padStart(2, '0');
        const s = String(secs % 60).padStart(2, '0');
        return `${h}:${m}:${s}`;
    };

    timer.textContent = formatTime(secondsLeft);

    const interval = setInterval(() => {
        if (secondsLeft <= 0) {
            clearInterval(interval);
            <?php if ($session->currentUserIsPlayer()) : ?>
                window.location.replace('./logout.php?msg=<?= urlencode($translator->getMessage('info_gamesession_finished')); ?>');
            <?php endif; ?>
        } else {
            secondsLeft--;
            timer.textContent = formatTime(secondsLeft);
        }
    }, 1000);
});
</script>