<?php
$id_session = getRows($db, "sessions", "*", "id_owner = $id_user AND status = 1")["id"];
$users_session_users_list = getRows($db, "users_session", "pseudo", "id_session = $id_session");
?>

<section class="widgets">
    <div class="widget-session-viewer">
        <ul>
            <?php
            foreach ($users_session_users_list as $name) {
                echo "<li>$name</li>";
            }
            ?>
        </ul>
    </div>
</section>
<?php
if (isset($_COOKIE["new-user"])) {
   //todo
}
?>


<script>
    function create() {
        let date = new Date();
        date.setTime(date.getTime() + 1000);
        let expiration = "expires=" + date.toUTCString();
        document.cookie = "create-session-js=ok;" + expiration + ";path=/";
        window.location.replace(window.location.href);
    }
</script>