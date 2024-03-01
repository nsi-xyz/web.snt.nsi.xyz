<?php
$id_session = getRows($db, "sessions", "*", "id_owner = $id_user AND status = 1")["id"];
$users_session_users_list = getRows($db, "users_session", "pseudo, joined_at, puzzles", "id_session = $id_session");
?>

<section class="widgets">
    <div class="widget-session-viewer">
        <table class="pure-table">
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Énigme 1</th>
                    <th>Énigme 2</th>
                    <th>Énigme 3</th>
                    <th>Énigme 4</th>
                    <th>Énigme 5</th>
                    <th>Énigme 6</th>
                    <th>Énigme 7</th>
                    <th>Énigme 8</th>
                    <th>Énigme 9</th>
                    <th>Énigme 10</th>
                    <th>A rejoint à</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="users-session-list">
            </tbody>
        </table>
    </div>
</section>


<script>
    function updateUsersList(id_session, path) {
        let users_list_tbody = document.getElementById("users-session-list").getElementsByTagName("tr");
        let users_in_page = [];
        for (let i = 0; i < users_list_tbody.length; i++) {
            users_in_page.push(users_list_tbody[i].querySelector("#user-pseudo").textContent);
        }
        fetch(path)
            .then(response => response.json())
            .then(json => {
                json.forEach((element) => {
                    let element_id_session = element["id_session"];
                    let element_pseudo = element["pseudo"];
                    let element_joined_at = element["joined_at"];
                    let element_puzzle_progression = element["puzzles"].split("");
                    if (element_id_session == id_session && !users_in_page.includes(element_pseudo)) {
                        let new_tr = document.createElement("tr");
                        let new_td_pseudo = document.createElement("td");
                        new_td_pseudo.setAttribute("id", "user-pseudo");
                        let new_all_td_puzzle = [];
                        for (let i = 0; i < 10; i++) {
                            let new_td_puzzle = document.createElement("td");
                            new_td_puzzle.textContent = element_puzzle_progression[i] == "1" ? "\u{1F7E2}" : "\u{1F7E0}";
                            new_all_td_puzzle.push(new_td_puzzle);
                        }
                        let new_td_joined_at = document.createElement("td");
                        new_td_pseudo.textContent = element_pseudo;
                        let date_joined_at = new Date(element_joined_at)
                        new_td_joined_at.textContent = date_joined_at.getHours().toString().padStart(2, "0") + ":" + date_joined_at.getMinutes().toString().padStart(2, "0") + ":" + date_joined_at.getSeconds().toString().padStart(2, "0");
                        new_tr.appendChild(new_td_pseudo);
                        for (let i = 0; i < 10; i++) {
                            new_tr.appendChild(new_all_td_puzzle[i]);
                        }
                        new_tr.appendChild(new_td_joined_at);
                        document.getElementById("users-session-list").appendChild(new_tr);
                    }
                });
            })
            .catch(error => {
                console.error(error);
            });
    }
    updateUsersList(<?php echo $id_session; ?>, "../js/db.json");
    setInterval(() => {
        updateUsersList(<?php echo $id_session; ?>, "../js/db.json");
    }, 3000)
</script>