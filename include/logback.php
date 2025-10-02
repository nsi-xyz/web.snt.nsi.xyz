<?php
if (isset($_POST["username"], $_POST["password"])) {
    $user_username = strtolower($_POST["username"]);
    $user_password = $_POST["password"];
    if (preg_match(PHPPATTERN_USERNAME, $user_username) && $userRepository->canLogin($user_username, $user_password)) {
        $user = $userRepository->getByUsername($user_username);
        $session->setCurrentUser($user);
        if (isset($_POST["stay-connected"])) {
            $session->setStayConnected(true);
        }
        Redirector::to(null, false);
    } else {
        unset($_POST["username"], $_POST["password"]);
        FlashMessenger::error($translator->getMessage('error_wrong_login_credentials_message'));
        Redirector::to(null, false);
    }
}

if (isset($_GET["pseudo"]) && isset($_GET["code"])) {
    $pseudo = $_GET["pseudo"];
    $code = strtoupper($_GET["code"]);
    if (preg_match("/^[A-Z0-9]+$/", $code)) {
        $gameSession = $gameSessionRepository->getByCode($code);
        if ($gameSession === null) {
            FlashMessenger::error($translator->getMessage('error_gamesession_not_exists_message'));
            Redirector::to(null, false);
        }
        $id = getRows($db, "sessions", "*", "code = \"$code\"")["id"];
        if (isValidString($pseudo, PHPPATTERN_PSEUDO) && canJoinSession($pseudo, $id, $db)) {
            joinSession($pseudo, $id, $db);
            $_SESSION["user_logged_in"] = getRows($db, "users_session", "*", "pseudo = \"$pseudo\" AND id_session = $id");
            throwSuccess("Vous avez rejoint la session avec succès.<br>Bonne chance !", "./index.php", "msg", true, false);
        } else {
            throwError("Impossible de rejoindre la session.", null, "msg", false, false);
        }
    } else {
        FlashMessenger::error($translator->getMessage('error_gamesession_not_exists_message'));
        Redirector::to(null, false);
    }
}

if (isset($_POST["name"], $_POST["surname"], $_POST["username"], $_POST["password"])) {
    $username = strtolower(trim($_POST["username"]));
    $result = createUser($db, $_POST["name"], $_POST["surname"], $username, $_POST["password"], 0);
    switch ($result) {
        case 0:
            $_SESSION["user_logged_in"] = getRows($db, "users", "*", "username = \"$username\"");
            echo '<script>window.location.replace(window.location.href);</script>';
            break;
        case -1:
            throwError("Action impossible.", null, "msg", true, false);
            break;
        case -2:
            throwError("Ce nom d'utilisateur est déjà utilisé.", null, "msg", true, false);
            break;
        case -3:
            throwError("Les champs ne respectent pas les longueurs requises", null, "msg", true, false);
            break;
        case -4:
            throwError("Les champs utilisent des caractères non autorisés.", null, "msg", true, false);
            break;
    }
}