<?php
$users_session_users_list = getRows($db, "users_session", "pseudo, joined_at", "id_session = $id_session");
if (!isset($_SESSION["sort-by"])) {
    $_SESSION["sort-by"] = "Date";
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
<p class="p-content">La mise à jour du tableau en temps réel peut prendre jusqu'à 10 secondes. Actualiser la page permet une mise à jour immédiate.</p>
<form method="GET" action="" class="pure-form">
    <fieldset>
        <label for="sorting-type">Trier par</label>
        <select id="sorting-type" name="sort-by">
            <option><?php echo $_SESSION["sort-by"] == "Date" ? "Date" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Pseudo (ABC)" : "Pseudo (ZYX)")?></option>
            <option><?php echo $_SESSION["sort-by"] == "Date" ? "Pseudo (ABC)" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Pseudo (ZYX)" : "Date")?></option>
            <option><?php echo $_SESSION["sort-by"] == "Date" ? "Pseudo (ZYX)" : ($_SESSION["sort-by"] == "Pseudo (ABC)" ? "Date" : "Pseudo (ABC)")?></option>
        </select>
        <button type="submit" class="pure-button pure-button-primary">Appliquer</button>
    </fieldset>
</form>
<table class="pure-table">
    <thead>
        <tr>
            <th>Pseudo</th>
            <th colspan="10">Énigmes</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="users-session-list"></tbody>
</table>
<h3 class="content-subhead">Gestion de ma session</h3>
<p class="p-content">Fin de la session dans : <timer>#ToDo</timer></p>
<button class ="stop-button" type="button" onclick="stop(<?php echo $id_session; ?>, 1)">Forcer l'arrêt de la session</button>

<script>
    let longSession = <?php echo $session["duration"] >= 86400 ? 1 : 0; ?>;

    function updateTab(id) {
        let users_list_tbody = document.getElementById("users-session-list").getElementsByTagName("tr");
        let users_in_page = [];
        for (let i = 0; i < users_list_tbody.length; i++) {
            users_in_page.push([users_list_tbody[i].textContent, []]);
        }
        fetch('./include/get_session_data.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({id_session: id})
        })
        .then(response => response.json())
        .then(json => {
            const sorting = '<?php echo $_SESSION["sort-by"]; ?>';
            switch (sorting) {
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
                let element_puzzles_resolved = element["puzzles"].map(puzzle => puzzle[0]).sort((a, b) => a - b);;
                let userAlreadyHere = false;
                let user_puzzle_in_page = [];
                for (let i = 0; i < users_in_page.length; i++) {
                    if (users_in_page[i][0].includes(element_pseudo)) {
                        userAlreadyHere = true;
                        break;
                    }
                }
                if (element_id_session == id) {
                    if (!userAlreadyHere) {
                        let new_tr = document.createElement("tr");
                        new_tr.setAttribute("id", "user-" + element_id.toString());
                        // Pseudo
                        let td_pseudo = document.createElement("td");
                        td_pseudo.setAttribute("id", "user-pseudo-" + element_id.toString());
                        td_pseudo.textContent = element["pseudo"];
                        new_tr.appendChild(td_pseudo);
                        // Énigmes
                        let td_puzzle;
                        let td_puzzle_class;
                        for (let i = 0; i < 10; i++) {
                            td_puzzle = document.createElement("td");
                            td_puzzle_class = element_puzzles_resolved.includes(i+1) ? "td-resolved" : "td-unresolved";
                            td_puzzle.setAttribute("id", "user-puzzle-" + (i + 1).toString() + "-" + element_id.toString());
                            td_puzzle.setAttribute("class", td_puzzle_class)
                            td_puzzle.textContent = (i + 1).toString().padStart(2, "0");
                            new_tr.appendChild(td_puzzle);
                        }
                        // Date
                        let td_joined_at = document.createElement("td");
                        td_joined_at.setAttribute("id", "user-joined-at-" + element_id.toString());
                        if (longSession) {
                            let isoDate = element_joined_at.replace(" ", "T");
                            let date = luxon.DateTime.fromISO(isoDate);
                            let formattedDate = date.toFormat("HH:mm:ss (dd/MM/yyyy)");
                            td_joined_at.textContent = formattedDate;
                        } else {
                            td_joined_at.textContent = (new Date(element_joined_at)).toTimeString().split(" ")[0];
                        }
                        new_tr.appendChild(td_joined_at);
                        // Actions
                        let td_kick_button = document.createElement("td");
                        let div_kick_button = document.createElement("div");
                        td_kick_button.appendChild(div_kick_button);
                        let button_kick_button = document.createElement("button");
                        div_kick_button.appendChild(button_kick_button);
                        button_kick_button.setAttribute("class", "button-kick pure-button");
                        button_kick_button.setAttribute("onclick", "kickUser(" + element_id + ", " + element_id_session +  ", \"" + element_pseudo + "\")");
                        button_kick_button.textContent = "Exclure";
                        new_tr.appendChild(td_kick_button);
                        // Insertion de la ligne
                        let users_list = document.getElementById("users-session-list");
                        let inserted = false;
                        for (let i = 0; i < users_list.rows.length; i++) {
                            let currentRow = users_list.rows[i];
                            let currentPseudo = currentRow.cells[0].textContent;
                            if ((sorting == "Pseudo (ABC)" && element_pseudo.localeCompare(currentPseudo) < 0) || (sorting == "Pseudo (ZYX)" && element_pseudo.localeCompare(currentPseudo) > 0)) {
                                users_list.insertBefore(new_tr, currentRow);
                                inserted = true;
                                break;
                            }
                        }
                        if (!inserted) {
                            users_list.appendChild(new_tr);
                        }
                    } else if (users_in_page.length > 0 && userAlreadyHere) {
                        for (let i = 0; i < 10; i++) {
                            if (document.querySelector("#user-puzzle-" + (i + 1).toString() + "-" + element_id.toString()).getAttribute("class") == "td-resolved") {
                                user_puzzle_in_page.push(i + 1);
                            }
                        }
                        if (user_puzzle_in_page.length != element_puzzles_resolved.length) {
                            for (let i = 0; i < 10; i++) {
                                td_class = (element_puzzles_resolved.includes(i + 1)) ? "td-resolved" : "td-unresolved";
                                document.querySelector("#user-puzzle-" + (i + 1).toString() + "-" + element_id.toString()).setAttribute("class", td_class);
                                document.querySelector("#user-puzzle-" + (i + 1).toString() + "-" + element_id.toString()).textContent = (i + 1).toString().padStart(2, "0");
                            }
                        }
                    }
                }
            })
        })
        .catch(error => console.error('Erreur : ', error));
    }

    function kickUser(id, id_session, pseudo) {
        if (confirm(`Êtes-vous sûr de vouloir exclure ${pseudo} ?`)) {
            jQuery.ajax({
                type: "POST",
                url: "session.php",
                data: {kick_id: id, kick_session: id_session, kick_pseudo: pseudo},
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        let row = document.getElementById("user-" + id.toString());
                        row.parentNode.removeChild(row);
                    }  else {
                        console.error(data.error);
                    }
                }
            });
        }
    }

    function sortByABC(json_content) {
        new_json = json_content.sort((a, b) => {
            const pseudoA = a.pseudo.toUpperCase();
            const pseudoB = b.pseudo.toUpperCase();
            const compar = pseudoA.localeCompare(pseudoB, "<?php echo $_SESSION["locale"]; ?>");
            if (compar < 0) {
                return -1;
            }
            if (compar > 0) {
                return 1;
            }
            return 0;
        });
        return new_json;
    }

    function sortByZYX(json_content) {
        return json_content.sort((a, b) => {
            const pseudoA = a.pseudo.toUpperCase();
            const pseudoB = b.pseudo.toUpperCase();
            const compar = pseudoA.localeCompare(pseudoB, "<?php echo $_SESSION["locale"]; ?>");
            if (compar < 0) {
                return 1;
            }
            if (compar > 0) {
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

    function stop(id, force_stop = 0) {
        jQuery.ajax({
            type: "POST",
            url: "session.php",
            data: {stop_session: id, force: force_stop},
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

    updateTab(<?php echo $id_session; ?>);
    setInterval(() => {
        updateTab(<?php echo $id_session; ?>);
    }, 5000)
</script>