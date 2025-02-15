<?php
$data_session = getSessionData($db, $session_id);
usort($data_session, function ($a, $b) {
    global $collator;
    return collator_compare($collator, $a['pseudo'], $b['pseudo']);
});

$data_session_json = json_encode($data_session);
$longSession = $session["duration"] >= 86400;
$dateFormat = $longSession ? "H:i:s (d/m/Y)" : "H:i:s";
?>
<?php if (!isset($_GET["user"])) : ?>
    <h2 class="content-subhead">Informations générales de la session</h2>
    <ul>
        <?php
        $session_date = (new DateTime())->setTimestamp(strtotime($session["date"]));
        ?>
        <li>Identifiant : #<?php echo $session_id; ?> (<?php echo $_GET["session"]; ?>)</li>
        <li>Hôte de la session : <?php echo $session_owner; ?></li>
        <li>Date de création : <?php echo $dateFormatter->format($session_date); ?></li>
        <li>Date de fermeture : <?php echo $dateFormatter->format($session_date->modify("+".$session["duration"]." seconds")); ?></li>
        <li>Nombre de participants : <?php echo $session_users == null ? "0" : count($session_users); ?></li>
    </ul>
    <h2 class="content-subhead">Statistiques générales de la session</h2>
    <ul>
        <li>Énigme la mieux réussie : <span id="best"></span></li>
        <li>Énigme la moins réussie : <span id="worst"></span></li>
    </ul>
    <h3 class="content-subhead">Part des énigmes réussies</h3>
    <div>
        <canvas id="puzzle-success-stats"></canvas>
    </div>
    <h2 class="content-subhead">Progression des participants</h2>
    <p class="p-content">Le tableau de la progression des participants de votre session trié par ordre alphabétique (ABC).</p>
    <table class="pure-table">
        <thead>
            <tr>
                <th>Pseudo</th>
                <th colspan="10">Énigmes</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="users-session-list">
            <?php
            foreach ($data_session as $user_session) {
                echo '<tr id="user-'.$user_session["id"].'">';
                echo '<td id="user-pseudo-'.$user_session["id"].'">'.$user_session["pseudo"].'</td>';
                for ($i = 1; $i <= 10; $i++) {
                    $user_session_puzzle_class = in_array($i, array_column($user_session["puzzles"], 0)) ? "td-resolved" : "td-unresolved";
                    echo '<td id="user-puzzle-'.$i.'-'.$user_session["id"].'" class="'.$user_session_puzzle_class.'">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</td>';
                }
                echo '<td id="user-joined-at-'.$user_session["id"].'">'.(new DateTime($user_session["joined_at"]))->format($dateFormat).'</td>';
                echo '<td><div><button type="button" class="button-more-infos pure-button" onclick="moreInfos('.$user_session["id"].')">En savoir plus</button></div></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
<?php else : ?>
    <?php
    $filtered = array_filter($data_session, function($user) {
        return $user["id"] == $_GET["user"];
    });
    $user_session_infos = reset($filtered);
    ?>
    <button type="button" class="button-back pure-button" onclick="back()">&#x21A9;</button>
    <h2 class="content-subhead">Informations sur <?php echo $user_session_infos["pseudo"]; ?></h2>
    <h3 class="content-subhead">Progression</h3>
    <table class="pure-table">
        <thead>
            <tr>
                <th colspan="10">Énigmes</th>
            </tr>
        </thead>
        <tbody id="users-session-list">
            <tr>
            <?php
            for ($i = 1; $i <= 10; $i++) {
                $user_session_puzzle_class = in_array($i, array_column($user_session_infos["puzzles"], 0)) ? "td-resolved" : "td-unresolved";
                echo '<td class="'.$user_session_puzzle_class.'">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</td>';
            }
            ?>
            </tr>
        </tbody>
    </table>
    <h3 class="content-subhead">Progression au cours du temps</h3>
    <table class="pure-table">
        <thead>
            <tr>
                <th>Événement</th>
                <th>Date</th>
                <th>Durée depuis le dernier événément</th>
                <th>Durée depuis l'arrivée</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>A rejoint</td>
                <td><?php echo (new DateTime($user_session_infos["joined_at"]))->format($dateFormat); ?></td>
                <td>00h00m00s</td>
                <td>00h00m00s</td>
            </tr>
            <?php
            $joined_at = new DateTime($user_session_infos["joined_at"]);
            for ($i = 0; $i < count($user_session_infos["puzzles"]); $i++) {
                $resolved_at = new DateTime($user_session_infos["puzzles"][$i][1]);
                echo '<tr>';
                echo '<td>A réussi l\'énigme '.$user_session_infos["puzzles"][$i][0].'</td>';
                echo '<td>'.$resolved_at->format($dateFormat).'</td>';
                if ($i == 0) {
                    $interval = $joined_at->diff($resolved_at);
                    echo '<td>'.$interval->format("%Hh%Im%Ss").'</td>';
                    echo '<td>'.$interval->format("%Hh%Im%Ss").'</td>';
                } else {
                    $interval = (new DateTime($user_session_infos["puzzles"][$i - 1][1]))->diff($resolved_at);
                    echo '<td>'.$interval->format("%Hh%Im%Ss").'</td>';
                    $interval = $joined_at->diff($resolved_at);
                    echo '<td>'.$interval->format("%Hh%Im%Ss").'</td>';
                }
                echo '</tr>';
            }
            if ($user_session_infos["finished_at"] != null) {
                $finished_at = new DateTime($user_session_infos["finished_at"]);
                echo '<tr>';
                echo '<td>&#x1F389; A terminé</td>';
                echo '<td>'.$finished_at->format($dateFormat).'</td>';
                $interval = (new DateTime($user_session_infos["puzzles"][array_key_last($user_session_infos["puzzles"])][1]))->diff($finished_at);
                echo '<td>'.$interval->format("%Hh%Im%Ss").'</td>';
                $interval = $joined_at->diff($finished_at);
                echo '<td>'.$interval->format("%Hh%Im%Ss").'</td>';
            }
            ?>
        </tbody>
    </table>
<?php endif; ?>
<script>
function moreInfos(user_id) {
    localStorage.setItem("scrollPosition", window.scrollY);
    const url = new URL(window.location.href);
    url.searchParams.set("user", user_id);
    window.location.href = url.toString();
}

function back() {
    const url = new URL(window.location.href);
    url.searchParams.delete("user");
    window.location.href = url.toString();
}

let data_session = <?php echo $data_session_json; ?>;
const puzzle_stats = Array(10).fill(0);
data_session.forEach(user => {
    user.puzzles.forEach(puzzle => {
        const puzzle_index = puzzle[0] - 1;
        if (puzzle_index >= 0 && puzzle_index < 10) {
            puzzle_stats[puzzle_index]++;
        }
    });
});
const max = Math.max(...puzzle_stats);
const max_indices = puzzle_stats
    .map((value, index) => (value == max ? index + 1 : -1))
    .filter(index => index != -1);
const min = Math.min(...puzzle_stats);
const min_indices = puzzle_stats
    .map((value, index) => (value == min ? index + 1 : -1))
    .filter(index => index != -1);
if (max == min && max > 0) {
    document.getElementById("best").innerText = max_indices + " (réussie par " + max + " participants)";
    document.getElementById("worst").innerText = "Aucune";
} else if (max == min && max <= 0) {
    document.getElementById("best").innerText = "Aucune";
    document.getElementById("worst").innerText = min_indices + " (réussie par " + min + " participants)";
} else {
    document.getElementById("best").innerText = max_indices + " (réussie par " + max + " participants)";
    document.getElementById("worst").innerText = min_indices + " (réussie par " + min + " participants)";
}

if (!(new URLSearchParams(window.location.search)).has("user")) {
    const ctx = document.getElementById("puzzle-success-stats");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: Array.from({ length: 10 }, (v, i) => "Énigme " + (i + 1)),
            datasets: [{
                label: 'Participants ayant réussi',
                data: puzzle_stats,
                backgroundColor: "rgba(148, 113, 222, 0.2)",
                borderColor: "rgb(148, 113, 222)",
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: data_session.length
                }
            }
        }
    });
}

window.onload = function () {
      const scrollPosition = localStorage.getItem("scrollPosition");
      const urlParams = new URLSearchParams(window.location.search);
      if (scrollPosition !== null && !urlParams.has("user")) {
        window.scrollTo(0, parseInt(scrollPosition));
        localStorage.removeItem("scrollPosition");
      }
}
</script>