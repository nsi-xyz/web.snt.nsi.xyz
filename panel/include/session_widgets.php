<?php
$id_session = getRows($db, "sessions", "*", "id_owner = $id_user AND status = 1")["id"];
$users_session_users_list = getRows($db, "users_session", "pseudo", "id_session = $id_session");
?>

<section class="widgets">
    <div class="widget-session-viewer">
        <ul id="users_list">
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

    function updateUsersList(id_session, path) {
        let users_list_ul = document.getElementById("users_list").getElementsByTagName("li");
        let users_in_page = [];
        for (let i = 0; i < users_list_ul.length; i++) {
            users_in_page.push(users_list_ul[i].textContent);
        }
        fetch(path)
            .then(response => response.json())
            .then(json => {
    
                json.forEach((element) => {
                    let element_id_session = element["id_session"];
                    let element_pseudo = element["pseudo"];
                    if (element_id_session == id_session && !users_in_page.includes(element_pseudo)) {
                        let newLi = document.createElement("li");
                        newLi.textContent = element_pseudo;
                        document.getElementById("users_list").appendChild(newLi);
                    }
                });
            })
            .catch(error => {});
    }
    updateUsersList(<?php echo $id_session; ?>, "../js/db.json");
    setInterval(() => {
        updateUsersList(<?php echo $id_session; ?>, "../js/db.json");
    }, 3000)
</script>