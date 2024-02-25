<h2 class="content-subhead">Créer une session</h2>
<p class="p-content">Vous n'avez actuellement aucune session en cours.</p>
<button class ="create-session-button" type="button" onclick="create()">Créer une session</button>
<?php
if (isset($_COOKIE["create-session-js"])) {
    createSession();
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