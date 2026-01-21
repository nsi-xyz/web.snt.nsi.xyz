<?php
$groupRepositoryRestricted = new GroupRepository($db, $session->getCurrentUser());
if (isset($_POST['create'], $_POST['group_name'])) {
    $permissions = $_POST['permissions'] ?? [];
    try {
        $groupRepositoryRestricted->create($_POST['group_name'], $permissions);
    } catch (MissingPermissionException $e) {
        FlashMessenger::error($e->getMessage());
        Redirector::to(null, true);
    } catch (InvalidGroupNameException $e) {
        FlashMessenger::error($e->getMessage());
        Redirector::to(null, true); 
    }
}