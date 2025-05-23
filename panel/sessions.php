<?php
include "./include/db.php";
include "../include/functions.php";
include "../include/checksession.php";
$code = isset($_GET["code"]) && isValidString($_GET["code"], "/^[A-Z0-9]+$/") ? $_GET["code"] : "";
$host = isset($_GET["host"]) && isValidString($_GET["host"], PHPPATTERN_USERNAME) ? $_GET["host"] : "";
$host_filter = $host != "" ? "AND id_owner IN (SELECT id FROM users WHERE username LIKE \"%$host%\")" : "";
$date_max = isset($_GET["date_max"]) && isValidString($_GET["date_max"], "/^\d{4}-\d{2}-\d{2}$/") ? $_GET["date_max"] : null;
$date_min = isset($_GET["date_min"]) && isValidString($_GET["date_min"], "/^\d{4}-\d{2}-\d{2}$/") ? $_GET["date_min"] : null;
$date_max_default = $date_max == null ? date('Y-m-d', strtotime("+1 day")) : $date_max;
$date_min_default = $date_min == null ? "2006-05-02" : $date_min;
$status = isset($_GET["status"]) ? 1 : 0;
$status_filter = $status ? "AND status = 1" : "";
$data_sessions = getRows($db, "sessions", "*", "code", 1, "\"%$code%\" AND date < \"$date_max_default\" AND date > \"$date_min_default\" $status_filter $host_filter ORDER BY date DESC");
if (isset($_POST["delete_session"])) {
  $_SESSION["id_session_delete"] = $_POST["delete_session"];
  echo json_encode(["success" => true]);
  exit();
}
if (isset($_SESSION["id_session_delete"])) {
  deleteSession($db, $_SESSION["id_session_delete"]);
  unset($_SESSION["id_session_delete"]);
  $params = array_diff_key($_GET, ["viewstats" => ""]);
  $url = strtok($_SERVER["REQUEST_URI"], "?").(empty($params) ? "" : "?" . http_build_query($params));
  throwSuccess("La session a été supprimée avec succès.", $url, "msg", true, true);
}
if (isset($_POST["stop_session"])) {
  $_SESSION["id_session_stop"] = $_POST["stop_session"];
  echo json_encode(["success" => true]);
  exit();
}
if (isset($_SESSION["id_session_stop"])) {
  $id_session = $_SESSION["id_session_stop"];
  unset($_SESSION["id_session_stop"]);
  $session = getRows($db, "sessions", "*", "id = $id_session");
  $interval = (new DateTime($session["date"]))->diff(new DateTime());
  $new_duration = $interval->days*24*60*60 + $interval->h*60*60 + $interval->i*60 + $interval->s;
  updateRow($db, "sessions", array("duration" => $new_duration), "id = $id_session");
  stopSession($db, $id_session);
  throwSuccess("La session a été fermée avec succès.", null, "msg", true, true);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title><?php echo traduction("sessions_website_title"); ?></title>
  <link rel="stylesheet" href="../css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/grids-responsive-min.css">
  <script src="../js/messages.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include "./include/nav_panel.php"; ?>
    <div id="main">
      <div class="header">
        <h1><?php echo traduction("sessions_header_h1"); ?></h1>
        <h2><?php echo traduction("sessions_header_h2"); ?></h2>
      </div>
      <div class="content">
        <msg></msg>
        <?php if (isset($_GET["viewstats"])) : ?>
          <?php
            $id = $_GET["viewstats"];
            if (rowsCount($db, "sessions", "id = $id") == 1) {
              $session = getRows($db, "sessions", "*", "id = $id");
              $session_id = $session["id"];
              $session_code = $session["code"];
              $session_id_owner = $session["id_owner"];
              $session_owner = rowsCount($db, "users", "id = $session_id_owner") == 1 ? getRows($db, "users", "username", "id = \"$session_id_owner\"")["username"] : "<i>deleted_user_".$session_id_owner."</i>";
              $session_users = getRows($db, "users_session", "*", "id_session = \"$session_id\"", 1);
              include "./include/stats_viewer.php";
            }
          ?>
        <?php else : ?>
          <h2 class="content-subhead">Parcourir les sessions</h2>
          <p class="p-content">Retrouvez facilement l'intégralité des sessions créées antérieurement.</p>
          <h3 class="content-subhead">Filtres</h3>
          <form method="GET" class="pure-form pure-form-stacked">
            <div class="pure-g">
              <div class="pure-u-1 pure-u-md-1-2">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" class="pure-u-23-24" value="<?php echo $code; ?>" />
              </div>
              <div class="pure-u-1 pure-u-md-1-2">
                <label for="host">Hôte (nom d'utilisateur)</label>
                <input type="text" id="host" name="host" class="pure-u-23-24" value="<?php echo $host; ?>" />
              </div>
              <div class="pure-u-1 pure-u-md-1-2">
                <label for="date_max">Créée avant</label>
                <input type="date" id="date_max" name="date_max" class="pure-u-23-24" value="<?php echo $date_max; ?>" />
              </div>
              <div class="pure-u-1 pure-u-md-1-2">
                <label for="date_min">Créée après</label>
                <input type="date" id="date_min" name="date_min" class="pure-u-23-24" value="<?php echo $date_min; ?>" />
              </div>
            </div>
            <label for="status" class="pure-checkbox">
              <input id="status" name="status" type="checkbox" <?php echo $status == 1 ? "checked" : ""; ?> /> Uniquement les sessions en cours
            </label>
            <button type="submit" class="button-primary pure-button" style="margin-top: 12.5px;">Rechercher</button>
          </form>
          <h3 class="content-subhead">Résultats (<?php echo count($data_sessions); ?>)</h3>
          <?php if (count($data_sessions) > 0) : ?>
            <table class="pure-table">
              <thead>
                <tr>
                  <th>Code</th>
                  <th>Statut</th>
                  <th>Hôte</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="sessions-list">
                <?php
                foreach ($data_sessions as $session) {
                  $session_id_owner = $session["id_owner"];
                  $session_host = rowsCount($db, "users", "id = $session_id_owner") == 1 ? getRows($db, "users", "username", "id = $session_id_owner")["username"] : "<i>deleted_user_".$session_id_owner."</i>";
                  $session_status = $session["status"] == 1 ? "&#128994; En cours..." : "&#128308; Fermée";
                  echo '<tr id="session-'.$session["id"].'">';
                  echo '<td id="session-code-'.$session["id"].'">'.$session["code"].'</td>';
                  echo '<td id="session-status-'.$session["id"].'">'.$session_status.'</td>';
                  echo '<td id="session-host-'.$session["id"].'">'.$session_host.'</td>';
                  echo '<td id="session-date-'.$session["id"].'">'.(new DateTime($session["date"]))->format("d/m/Y (H:i:s)").'</td>';
                  echo '<td><div class="actions">';
                  echo '<button type="button" class="button-more-infos pure-button" onclick="viewStats('.$session["id"].')">Voir les statistiques</button>';
                  echo '</div></td>';
                  echo '</tr>';
                }
                ?>
              </tbody>
            </table>
          <?php else : ?>
            <p>Aucun résultat ne correspond à votre recherche. &#x1F615;</p>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
    <?php include "../include/footer.php"; ?>
  </div>
  <script>
    function viewStats(session_id) {
      localStorage.setItem("scrollPositionS", window.scrollY);
      const url = new URL(window.location.href);
      url.searchParams.set("viewstats", session_id);
      window.location.href = url.toString();
    }
    <?php if (!isset($_GET["viewstats"])) : ?>
      window.onload = function () {
        const scrollPosition = localStorage.getItem("scrollPositionS");
        const urlParams = new URLSearchParams(window.location.search);
        if (scrollPosition !== null && !urlParams.has("viewstats")) {
          window.scrollTo(0, parseInt(scrollPosition));
          localStorage.removeItem("scrollPositionS");
        }
      }
    <?php endif; ?>
  </script>
  <script src="../js/ui.js"></script>
</body>
</html>