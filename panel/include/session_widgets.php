<?php
$id_session = getRows($db, "sessions", "*", "id_owner = $id_user AND status = 1")["id"];
$users_session_users_list = getRows($db, "users_session", "pseudo, joined_at, puzzles", "id_session = $id_session");
if (isset($_POST["kick_user"])) {
    $user_session_id = $_POST["kick_user"];
    delRow($db, "users_session", "id = $user_session_id");
    updateLocalDB(getRowsInJSON($db, "users_session", "*", "1"), "../js/db.json");
}
if (!isset($_SESSION["sort-by"])) {
    $_SESSION["sort-by"] = "Date";
}
if (isset($_GET["sort-by"])) {
    $_SESSION["sort-by"] = urldecode($_GET["sort-by"]);
}
?>

<section class="widgets">
    <div class="widget-session-viewer">
        <form method="GET" action="" class="pure-form">
            <fieldset>
                <label for="sorting-type">Trier par</label>
                <select id="sorting-type" name="sort-by">
                    <option><? echo $_SESSION["sort-by"] == "Date" ? "Date" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Pseudo (ABC)" : "Pseudo (ZYX)")?></option>
                    <option><? echo $_SESSION["sort-by"] == "Date" ? "Pseudo (ABC)" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Pseudo (ZYX)" : "Date")?></option>
                    <option><? echo $_SESSION["sort-by"] == "Date" ? "Pseudo (ZYX)" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Date" : "Pseudo (ABC)")?></option>
                </select>
                <button type="submit" class="pure-button pure-button-primary">Appliquer</button>
            </fieldset>
        </form>
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
            user_puzzle_in_page = [];
            for (let j = 0; j < 10; j++) {
                user_puzzle_in_page.push(users_list_tbody[i].querySelector("#user-puzzle-" + (j + 1).toString()).textContent == "\u{1F7E0}" ? "0" : "1");
            }
            users_in_page.push([users_list_tbody[i].querySelector("#user-pseudo").textContent, user_puzzle_in_page])
        }
        fetch(path)
            .then(response => response.json())
            .then(json => {
                let index = 0;
                switch ("<? echo $_SESSION["sort-by"]; ?>") {
                    case "Date":
                        sortByDate(json);
                        break;
                    case "Pseudo (ABC)":
                        sortByABC(json);
                        break;
                    case "Pseudo (ZYX)":
                        sortByZYX(json);
                        break;
                    default:
                        sortByDate(json);
                }
                json.forEach((element) => {
                    let element_id = element["id"];
                    let element_id_session = element["id_session"];
                    let element_pseudo = element["pseudo"];
                    let element_joined_at = element["joined_at"];
                    let element_puzzle_progression = element["puzzles"].split("");
                    let userAlreadyHere = false;
                    for (let i = 0; i < users_in_page.length; i++) {
                        if (users_in_page[i].includes(element_pseudo)) {
                            userAlreadyHere = true;
                        }
                    } 
                    if (element_id_session == id_session) {
                        if (users_in_page.length == 0 || !userAlreadyHere) { // Si un utilisateur dans la session n'est pas affiché, on l'ajoute
                            let new_tr = document.createElement("tr");
                            let new_td_pseudo = document.createElement("td");
                            new_td_pseudo.setAttribute("id", "user-pseudo");
                            let new_all_td_puzzle = [];
                            for (let i = 0; i < 10; i++) {
                                let new_td_puzzle = document.createElement("td");
                                new_td_puzzle.setAttribute("id", "user-puzzle-" + (i + 1).toString());
                                new_td_puzzle.textContent = element_puzzle_progression[i] == "1" ? "\u{1F7E2}" : "\u{1F7E0}";
                                new_all_td_puzzle.push(new_td_puzzle);
                            }
                            let new_td_joined_at = document.createElement("td");
                            new_td_joined_at.setAttribute("id", "user-joined-at");
                            new_td_pseudo.textContent = element_pseudo;
                            let date_joined_at = new Date(element_joined_at)
                            new_td_joined_at.textContent = date_joined_at.getHours().toString().padStart(2, "0") + ":" + date_joined_at.getMinutes().toString().padStart(2, "0") + ":" + date_joined_at.getSeconds().toString().padStart(2, "0");
                            let new_td_kick_button = document.createElement("td");
                            let new_div_kick_button = document.createElement("div");
                            let new_button_kick_button = document.createElement("button");
                            new_button_kick_button.setAttribute("class", "button-kick pure-button");
                            new_button_kick_button.setAttribute("onclick", `kickUser(${element_id}, "${element_pseudo}")`);
                            new_button_kick_button.textContent = "Exclure";
                            new_div_kick_button.appendChild(new_button_kick_button);
                            new_td_kick_button.appendChild(new_div_kick_button);
                            new_tr.appendChild(new_td_pseudo);
                            for (let i = 0; i < 10; i++) {
                                new_tr.appendChild(new_all_td_puzzle[i]);
                            }
                            new_tr.appendChild(new_td_joined_at);
                            new_tr.appendChild(new_td_kick_button);
                            document.getElementById("users-session-list").appendChild(new_tr);
                        } else if (users_in_page.length > 0 && userAlreadyHere) {
                            for (let i = 0; i < 10; i++) {
                                if (users_in_page[index][1][i] != element_puzzle_progression[i]) {
                                    new_value = element_puzzle_progression[i] == "1" ? "\u{1F7E2}" : "\u{1F7E0}";
                                    users_list_tbody[index].querySelector("#user-puzzle-" + (i + 1).toString()).textContent = new_value;
                                }
                            }
                        }
                    }
                    index++;
                });
            })
            .catch(error => {
                console.error(error);
            });
    }

    function kickUser(id, pseudo) {
        if (confirm(`Êtes-vous sûr de vouloir exclure ${pseudo} ?`)) {
            jQuery.ajax({
                type: "POST",
                url: "session.php",
                data: {kick_user: id},
                success: function(response) {
                    location.reload(true);
                }
            });
        }
    }

    function sortByABC(json_content) {
        return json_content.sort((a, b) => {
            const pseudoA = a.pseudo.toUpperCase();
            const pseudoB = b.pseudo.toUpperCase();
            if (pseudoA < pseudoB) {
                return -1;
            }
            if (pseudoA > pseudoB) {
                return 1;
            }
            return 0;
        });
    }

    function sortByZYX(json_content) {
        return json_content.sort((a, b) => {
            const pseudoA = a.pseudo.toUpperCase();
            const pseudoB = b.pseudo.toUpperCase();
            if (pseudoA < pseudoB) {
                return 1;
            }
            if (pseudoA > pseudoB) {
                return -1;
            }
            return 0;
        });
    }

    function sortByDate(json_content) {
        return json_content.sort((a, b) => {
            const joinedAtA = new Date(a.joined_at);
            const joinedAtB = new Date(b.joined_at);
            return joinedAtA - joinedAtB;
        });
    }

    updateUsersList(<?php echo $id_session; ?>, "../js/db.json");
    setInterval(() => {
        updateUsersList(<?php echo $id_session; ?>, "../js/db.json");
    }, 5000)
</script>