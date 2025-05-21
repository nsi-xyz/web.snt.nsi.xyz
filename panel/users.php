<?php
include "./include/db.php";
include "../include/functions.php";
include "../include/checksession.php";
$data_users = getRows($db, "users", "id, name, surname, username, created_at, last_update, last_connexion, id_group", "1", 1);
if (isset($_POST["edit_user"])) {
  $_SESSION["edit_user_id"] = $_POST["edit_user"];
  echo json_encode(["success" => true]);
  exit();
}
if (isset($_POST["delete_user"])) {
  $_SESSION["delete_user_id"] = $_POST["delete_user"];
  echo json_encode(["success" => true]);
  exit();
}
if (isset($_POST["delete_sessions"])) {
  $_SESSION["delete_sessions_id"] = $_POST["delete_sessions"];
  echo json_encode(["success" => true]);
  exit();
}
if (isset($_SESSION["delete_user_id"])) {
  $filtered = array_filter($data_users, function ($user) {
    return $user["id"] == $_SESSION["delete_user_id"];
  });
  $data_user = reset($filtered);
  $result = deleteUser($db, $data_user);
  switch ($result) {
    case 0:
      unset($_SESSION["delete_user_id"]);
      throwSuccess(traduction("success_account_deleted_message"), null, "msg", true, true);
      break;
    case -1:
    case -2:
    case -3:
      unset($_SESSION["delete_user_id"]);
      throwError(traduction("error_account_cannot_be_deleted_message"), null, "msg", true, true);
      break;
  }
}
if (isset($_SESSION["delete_sessions_id"])) {
  $user_id = $_SESSION["delete_sessions_id"];
  unset($_SESSION["delete_sessions_id"]);
  deleteAllSessions($db, $user_id);
  throwSuccess(traduction("success_all_sessions_deleted_message"), null, "msg", true, true);
}
if (!isset($_SESSION["edit_user_id"])) {
  $_SESSION["edit_user_id"] = 0;
} else if ($_SESSION["edit_user_id"] > 0) {
  if ($_SESSION["edit_user_id"] == $_SESSION["user_logged_in"]["id"]) {
    $_SESSION["edit_user_id"] = 0;
    redirect("./myaccount.php", true);
  }
  $filtered = array_filter($data_users, function ($user) {
    return $user["id"] == $_SESSION["edit_user_id"];
  });
  $data_user = reset($filtered);
  $admin_status = $data_user["id_group"] == 1 ? " checked" : "";
  if ($_SESSION["user_logged_in"]["username"] != "admin" && $data_user["id_group"] == 1) {
    $_SESSION["edit_user_id"] = 0;
    throwError(traduction("error_account_cannot_be_edited_message"), null, "msg", true, true);
  }
}
if ((isset($_POST["apply"], $_POST["user_name"], $_POST["user_surname"], $_POST["user_username"]) || (isset($_POST["apply"], $_POST["user_name"], $_POST["user_surname"] ) && $_SESSION["edit_user_id"] > 0 && $data_user["username"] == "admin")) && !isset($_POST["reset_password"], $_POST["cancel"])) {
  $id_group = isset($_POST["user_id_group"]) ? 1 : 0;
  $result = updateUser($db, $data_user, array("name" => $_POST["user_name"], "surname" => $_POST["user_surname"], "username" => $_POST["user_username"], "id_group" => $id_group));
  switch ($result) {
    case 0:
      $_SESSION["edit_user_id"] = 0;
      throwSuccess("Compte mis à jour avec succès.", null, "msg", true, true);
      break;
    case -1:
      throwError(traduction("error_account_cannot_be_edited_message"), null, "msg", true, true);
      break;
    case -2:
      throwError("Ce nom d'utilisateur est déjà utilisé.", null, "msg", true, true);
      break;
    case -3:
      throwError("Les champs ne respectent pas les longueurs requises", null, "msg", true, true);
      break;
    case -4:
      throwError("Les champs utilisent des caractères non autorisés.", null, "msg", true, true);
      break;
  }
} else if (isset($_POST["reset_password"]) && !isset($_POST["cancel"])) {
  $_SESSION["edit_user_id"] = 0;
  resetPassword($db, $data_user);
} else if (isset($_POST["cancel"])) {
  $_SESSION["edit_user_id"] = 0;
  header("Location: users.php");
  exit();
}
if (isset($_POST["create"], $_POST["user_name"], $_POST["user_surname"], $_POST["user_username"], $_POST["user_password"])) {
  $id_group = isset($_POST["user_id_group"]) ? 1 : 0;
  $result = createUser($db, $_POST["user_name"], $_POST["user_surname"], $_POST["user_username"], $_POST["user_password"], $id_group);
  switch ($result) {
    case 0:
      throwSuccess("Compte créé avec succès.", null, "msg", true, true);
      break;
    case -1:
      throwError("Action impossible.", null, "msg", true, true);
      break;
    case -2:
      throwError("Ce nom d'utilisateur est déjà utilisé.", null, "msg", true, true);
      break;
    case -3:
      throwError("Les champs ne respectent pas les longueurs requises", null, "msg", true, true);
      break;
    case -4:
      throwError("Les champs utilisent des caractères non autorisés.", null, "msg", true, true);
      break;
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title><?php echo traduction("users_website_title"); ?></title>
  <link rel="stylesheet" href="../css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="../js/messages.js"></script>
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include("./include/nav_panel.php"); ?>
    <div id="main">
      <div class="header">
        <h1><?php echo traduction("users_header_h1"); ?></h1>
        <h2><?php echo traduction("users_header_h2"); ?></h2>
      </div>
      <div class="content">
        <?php if (!isset($_GET["user_id"])) : ?>
          <h2 class="content-subhead">Éditeur de compte</h2>
          <msg></msg>
          <form method="POST" action="" class="pure-form pure-form-stacked">
            <?php if ($_SESSION["edit_user_id"] == 0) : ?>
              <h3 class="content-subhead">Créer un nouveau compte</h3>
              <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="user_name" placeholder="Nom" required pattern="<?php echo HTMLPATTERN_NAME; ?>" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
              </div>
              <div class="form-group">
                <label for="surname">Prénom</label>
                <input type="text" id="surname" name="user_surname" placeholder="Prénom" required pattern="<?php echo HTMLPATTERN_NAME; ?>" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
              </div>
              <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="user_username" placeholder="Nom d'utilisateur" required pattern="<?php echo HTMLPATTERN_USERNAME; ?>" minlength="<?php echo USERNAME_MIN_LENGTH; ?>" maxlength="<?php echo USERNAME_MAX_LENGTH; ?>" />
              </div>
              <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="user_password" placeholder="Mot de passe" required title="Un bon mot de passe doit faire entre 7 et 32 caractères, contenir au moins une lettre, un chiffre, et un caractère spécial." minlength="<?php echo PASSWORD_MIN_LENGTH; ?>" maxlength="<?php echo PASSWORD_MAX_LENGTH; ?>" />
              </div>
              <?php if ($_SESSION["user_logged_in"]["username"] == "admin") : ?>
                <div class="form-group">
                  <label for="checkbox-radio-option-one">
                    <input type="checkbox" name="user_id_group" id="checkbox-radio-option-one" value="" /> Administrateur
                  </label>
                </div>
              <?php endif; ?>
              <button class ="button-success pure-button" name="create" type="submit">Créer</button>
            <?php else : ?>
              <h3 class="content-subhead">Modifier un compte</h3>
              <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="user_name" placeholder="Nom" required pattern="<?php echo HTMLPATTERN_NAME; ?>" value="<?php echo $data_user["name"]; ?>" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
              </div>
              <div class="form-group">
                <label for="surname">Prénom</label>
                <input type="text" id="surname" name="user_surname" placeholder="Prénom" required pattern="<?php echo HTMLPATTERN_NAME; ?>" value="<?php echo $data_user["surname"]; ?>" minlength="<?php echo NAME_MIN_LENGTH; ?>" maxlength="<?php echo NAME_MAX_LENGTH; ?>" />
              </div>
              <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="user_username" placeholder="Nom d'utilisateur" required pattern="<?php echo HTMLPATTERN_USERNAME; ?>" value="<?php echo $data_user["username"]; ?>" minlength="<?php echo USERNAME_MIN_LENGTH; ?>" maxlength="<?php echo USERNAME_MAX_LENGTH; ?>" />
              </div>
              <?php if ($_SESSION["user_logged_in"]["username"] == "admin") : ?>
                <div class="form-group">
                  <label for="checkbox-radio-option-one">
                    <input type="checkbox" name="user_id_group" id="checkbox-radio-option-one" value=""<?php echo $admin_status; ?> /> Administrateur
                  </label>
                </div>
              <?php endif; ?>
              <button class ="button-success pure-button" name="apply" type="submit">Appliquer</button>
              <button class ="button-warning pure-button" name="reset_password" type="submit">Réinitialiser le mot de passe</button>
              <button class ="button-error pure-button" name="cancel" type="submit">Annuler</button>
            <?php endif; ?>
          </form>
          <h2 class="content-subhead">Liste des comptes</h2>
          <p class="p-content">Liste des comptes actifs.</p>
          <table class="pure-table">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Nom d'utilisateur</th>
                <th>Administrateur</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="users-list">
              <?php
              foreach ($data_users as $user) {
                $admin_status = $user["id_group"] == 1 ? "&#x2705;" : "&#x274C;";
                $interact_moreinfos_status = $_SESSION["edit_user_id"] > 0 ? " disabled" : "";
                $interact_edit_status = $_SESSION["edit_user_id"] > 0 || ($user["id_group"] == 1 && $_SESSION["user_logged_in"]["username"] != "admin" && $_SESSION["user_logged_in"]["username"] != $user["username"]) ? " disabled" : "";
                $interact_delete_status = $_SESSION["edit_user_id"] > 0 || ($user["id_group"] == 1 && $_SESSION["user_logged_in"]["username"] != "admin" && $_SESSION["user_logged_in"]["username"] != $user["username"]) || $user["username"] == "admin" ? " disabled" : "";
                echo '<tr id="user-'.$user["id"].'">';
                echo '<td id="user-name-'.$user["id"].'">'.$user["name"].'</td>';
                echo '<td id="user-surname-'.$user["id"].'">'.$user["surname"].'</td>';
                echo '<td id="user-username-'.$user["id"].'">'.$user["username"].'</td>';
                echo '<td id="user-group-'.$user["id"].'">'.$admin_status.'</td>';
                echo '<td><div class="actions">';
                echo '<button type="button" class="button-more-infos pure-button"'.$interact_moreinfos_status.' onclick="moreInfos('.$user["id"].')">En savoir plus</button>';
                echo '<button type="button" class="button-primary pure-button"'.$interact_edit_status.' onclick="'.($_SESSION["user_logged_in"]["id"] == $user["id"] ? 'window.location.href=\'./myaccount.php\'' : 'edit('.$user['id'].')').'">Modifier</button>';
                echo '<button type="button" class="button-error pure-button"'.$interact_delete_status.' onclick="'.($_SESSION["user_logged_in"]["id"] == $user["id"] ? 'window.location.href=\'./myaccount.php\'' : 'del('.$user['id'].')').'">Supprimer</button>';
                echo '</div></td>';
                echo '</tr>';
              }
              ?>
            </tbody>
          </table>
        <?php else : ?>
          <?php
          $filtered = array_filter($data_users, function($user) {
            return $user["id"] == $_GET["user_id"];
          });
          $data_user = reset($filtered);
          ?>
          <button title="Retour" type="button" class="button-top pure-button" onclick="back()">&#x21A9;</button>
          <msg></msg>
          <h2 class="content-subhead">Informations supplémentaires sur <?php echo $data_user["username"]; ?></h2>
          <h3 class="content-subhead">Informations</h3>
          <ul>
            <?php
            $user_created_at = (new DateTime())->setTimestamp(strtotime($data_user["created_at"]));
            $user_last_update = (new DateTime())->setTimestamp(strtotime($data_user["last_update"]));
            $user_last_connexion = (new DateTime())->setTimestamp(strtotime($data_user["last_connexion"]));
            ?>
            <li>Identifiant : #<?php echo $data_user["id"]; ?></li>
            <li>Nom : <?php echo $data_user["name"]; ?></li>
            <li>Prénom : <?php echo $data_user["surname"]; ?></li>
            <li>Nom d'utilisateur : <?php echo $data_user["username"]; ?></li>
            <li>Date de création du compte : <?php echo formatRelativeTime($user_created_at); ?> (<?php echo $dateFormatter->format($user_created_at); ?>)</li>
            <li>Dernière mise à jour du compte : <?php echo formatRelativeTime($user_last_update); ?> (<?php echo $dateFormatter->format($user_last_update); ?>)</li>
            <li>Dernière connexion : <?php echo formatRelativeTime($user_last_connexion); ?> (<?php echo $dateFormatter->format($user_last_connexion); ?>)</li>
          </ul>
          <h3 class="content-subhead">Sessions</h3>
          <ul>
            <?php
            $user_id = $data_user["id"];
            $session_in_progress = sessionInProgress($db, $user_id);
            $session_id = $session_in_progress ? getRows($db, "sessions", "id", "id_owner = $user_id AND status = 1")["id"] : null;
            ?>
            <li>Session en cours : <?php echo $session_in_progress ? "&#x2705; (<a class=\"link\" target=\"_blank\" href=\"./sessions.php?viewstats=$session_id\">Y accéder &#x1F517;</a>)" : "&#x274C;" ?></li>
            <li>Nombre de sessions : <?php echo rowsCount($db, "sessions", "id_owner = $user_id"); ?></li>
          </ul>
          <a href="./sessions.php?host=<?php echo $data_user["username"]; ?>" target="_blank"><button class ="button-primary pure-button" type="button">Voir ses sessions &#x1F517;</button></a>
          <button class ="button-warning pure-button" onclick="delSessions(<?php echo $user_id; ?>)" type="button">Supprimer toutes ses sessions</button>
        <?php endif; ?>
      </div>
    </div>
    <script>
      function moreInfos(id) {
        localStorage.setItem("scrollPosition", window.scrollY);
        const url = new URL(window.location.href);
        url.searchParams.set("user_id", id);
        window.location.href = url.toString();
      }

      function edit(id) {
        jQuery.ajax({
          type: "POST",
          url: "users.php",
          data: {edit_user: id},
          success: function(response) {
            const data = JSON.parse(response);
            if (data.success) {
              window.location.href = window.location.href;
            } 
          }
        });
      }

      function del(id) {
        if (confirm("Êtes-vous certain de vouloir supprimer ce compte ?\nCette action est irréversible.")) {
          jQuery.ajax({
            type: "POST",
            url: "users.php",
            data: {delete_user: id},
            success: function(response) {
              const data = JSON.parse(response);
              if (data.success) {
                window.location.href = window.location.href;
              } 
            }
          });
        }
      }

      function back() {
        const url = new URL(window.location.href);
        url.searchParams.delete("user_id");
        window.location.href = url.toString();
      }

      function delSessions(id) {
        if (confirm("Êtes-vous certain de vouloir supprimer toutes ses sessions ?\nCette action est irréversible.")) {
          jQuery.ajax({
            type: "POST",
            url: "users.php",
            data: {delete_sessions: id},
            success: function(response) {
              const data = JSON.parse(response);
              if (data.success) {
                window.location.href = window.location.href;
              } 
            }
          });
        }
      }

      window.onload = function() {
        const scrollPosition = localStorage.getItem("scrollPosition");
        const urlParams = new URLSearchParams(window.location.search);
        if (scrollPosition !== null && !urlParams.has("user_id")) {
          window.scrollTo(0, parseInt(scrollPosition));
          localStorage.removeItem("scrollPosition");
        }
      }
    </script>
    <?php include("../include/footer.php"); ?>
  </div>
  <script src="../js/ui.js"></script>
</body>
</html>