<?php
$groupRepositoryRestricted = new GroupRepository($db, $session->getCurrentUser());
if (isset($_POST['create'], $_POST['group_name'])) {
    $permissions = $_POST['permissions'] ?? [];
    $result = $groupRepositoryRestricted->create($_POST['group_name'], $permissions);
    switch ($result) {
        case 0:
            throwSuccess("Compte créé avec succès.", null, "msg", true, true);
            break;
        case -1:
        case -5:
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