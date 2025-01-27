<?php
$users_session_users_list = getRows($db, "users_session", "pseudo, joined_at, puzzles", "id_session = $id_session");
if (isset($_POST["kick_user"])) {
    $user_session_id = $_POST["kick_user"];
    delRow($db, "users_session", "id = $user_session_id");
    updateLocalDB(getRowsInJSON($db, "users_session", "*", "1"), "../js/db-$id_session.json");
    echo '<script>window.location.replace(window.location.href);</script>';
}
if (!isset($_SESSION["sort-by"])) {
    $_SESSION["sort-by"] = "Heure";
}
if (isset($_GET["sort-by"])) {
    $_SESSION["sort-by"] = urldecode($_GET["sort-by"]);
}
?>
<h2 class="content-subhead">Ma session</h2>
<p class="p-content">Gestion et informations sur votre session.</p>
<h3 class="content-subhead">Code de session</h3>
<p class="p-content">Code de la session à partager aux participants :</p>
<div class="session-code-controls">
    <button class="session-code-rezize-button" onclick="resizeCode('-')"><img class="session-code-zoom-icon" src="../assets/dezoom_nixxdsgn.png" title="Zoom • Réduire"></button>
    <p class="session-code-code">Zoom du code : <span id="zoom-value">100%</span></p>
    <button class="session-code-rezize-button" onclick="resizeCode('+')"><img class="session-code-zoom-icon" src="../assets/zoom_nixxdsgn.png" title="Zoom • Agrandir"></button>
</div>
<div class="session-code-div">
    <button class="session-code-button" title="Copier le code dans le presse-papier" type="button" onclick="copyToClipboard()">
            <span id="session-code-code"><?php echo $session["code"]; ?></span>
            <img id="session-code-copy-icon" src="../assets/copy_anggara.png" title="Copier le code dans le presse-papier">
    </button>
 </div>
<h3 class="content-subhead">Participants à la session</h3>
<p></p>
<p class="p-content">La mise à jour du tableau en temps réel peut prendre jusqu'à 15 secondes. Actualiser la page permet une mise à jour immédiate.</p>
<form method="GET" action="" class="pure-form">
    <fieldset>
        <label for="sorting-type">Trier par</label>
        <select id="sorting-type" name="sort-by">
            <option><?php echo $_SESSION["sort-by"] == "Heure" ? "Heure" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Pseudo (ABC)" : "Pseudo (ZYX)")?></option>
            <option><?php echo $_SESSION["sort-by"] == "Heure" ? "Pseudo (ABC)" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Pseudo (ZYX)" : "Heure")?></option>
            <option><?php echo $_SESSION["sort-by"] == "Heure" ? "Pseudo (ZYX)" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Heure" : "Pseudo (ABC)")?></option>
        </select>
        <button type="submit" class="pure-button pure-button-primary">Appliquer</button>
    </fieldset>
</form>
<table class="pure-table">
    <thead>
        <tr>
            <th>Pseudo</th>
            <th colspan="10">Énigmes</th>
            <th>Heure</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="users-session-list">
    </tbody>
</table>
<h3 class="content-subhead">Gestion de ma session</h3>
<p class="p-content">Fin de la session dans : <timer>#ToDo</timer></p>
<button class ="stop-button" type="button" onclick="stop(<?php echo $id_session; ?>)">Forcer l'arrêt de la session</button>

<script>
    function updateUsersList(id_session, path) {
        let users_list_tbody = document.getElementById("users-session-list").getElementsByTagName("tr");
        let users_in_page = [];
        for (let i = 0; i < users_list_tbody.length; i++) {
            user_puzzle_in_page = [];
            for (let j = 0; j < 10; j++) {
                user_puzzle_in_page.push(users_list_tbody[i].querySelector("#user-puzzle-" + (j + 1).toString()).getAttribute("class") == "td-resolved" ? "1" : "0");
            }
            users_in_page.push([users_list_tbody[i].querySelector("#user-pseudo").textContent, user_puzzle_in_page])
        }
        fetch(path)
            .then(response => response.json())
            .then(json => {
                let index = 0;
                switch ('<?php echo $_SESSION["sort-by"]; ?>') {
                    case "Heure":
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
                                let td_class = element_puzzle_progression[i] == "1" ? "td-resolved" : "td-unresolved";
                                new_td_puzzle.setAttribute("id", "user-puzzle-" + (i + 1).toString());
                                new_td_puzzle.setAttribute("class", td_class);
                                new_td_puzzle.textContent = (i + 1).toString().padStart(2, "0");
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
                                    td_class = element_puzzle_progression[i] == "1" ? "td-resolved" : "td-unresolved";
                                    users_list_tbody[index].querySelector("#user-puzzle-" + (i + 1).toString()).setAttribute("class", td_class);
                                    users_list_tbody[index].querySelector("#user-puzzle-" + (i + 1).toString()).textContent = (i + 1).toString().padStart(2, "0");
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
                    window.location.replace(window.location.href);;
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

    function stop(id) {
        jQuery.ajax({
            type: "POST",
            url: "session.php",
            data: { stop_session: id },
            success: function(response) {
                const data = JSON.parse(response);
                if (data.success && data.redir) {
                    window.location.href = data.redir;
                } 
            }
        });
    }


    function copyToClipboard() {
        let codeElement = document.getElementById("session-code-code");
        const code = codeElement.innerText;
        navigator.clipboard.writeText(code).then(() => {
            codeElement.innerText = "Code copié !";
            setTimeout(() => {
                codeElement.innerText = code;
            }, 1000)
        });
    }

    function resizeCode(action) {
        let codeElement = document.getElementById("session-code-code");
        let zoomValueElement = document.getElementById("zoom-value");
        const currentSize = parseInt(window.getComputedStyle(codeElement).fontSize, 10);
        let codeIconElement = document.getElementById("session-code-copy-icon")
        const currentIconSize = parseInt(window.getComputedStyle(codeIconElement).width, 10)
        console.log(currentIconSize);

        if (action === "+") {
            if (currentSize < 96) {
                codeElement.style.fontSize = (currentSize + 8) + "px";
                codeIconElement.style.width = (currentIconSize + 8) + "px";
                codeIconElement.style.height = (currentIconSize + 8) + "px";
                zoomValueElement.innerText = (((currentSize + 8)/32)*100).toString().padStart(3, "0") + "%";
            }
        } else if (action === "-") {
            if (currentSize > 0) {
                codeElement.style.fontSize = (currentSize - 8) + "px";
                codeIconElement.style.width = (currentIconSize - 8) + "px";
                codeIconElement.style.height = (currentIconSize - 8) + "px";
                zoomValueElement.innerText = (((currentSize - 8)/32)*100).toString().padStart(3, "0") + "%";
            }
        }
    }

    updateUsersList(<?php echo $id_session; ?>, "../js/db-<?php echo $id_session; ?>.json");
    setInterval(() => {
        updateUsersList(<?php echo $id_session; ?>, "../js/db-<?php echo $id_session; ?>.json");
    }, 10000)
</script>