<?php
require_once __DIR__ . '/SessionManager.php';
require_once __DIR__ . '/Translator.php';
require_once __DIR__ . '/GameSessionRepository.php';
require_once __DIR__ . '/FlashMessenger.php';
require_once __DIR__ . '/Redirector.php';
require_once __DIR__ . '/../exceptions/MissingPermissionException.php';

class ControlAction {
    public static function ensureCanUpdateUser(User $actor, User $targetUser, array $fieldsToUpdate): void {
        // Prevent editing a user with a superior group
        if ($actor->getGroup()->getHierarchyLevel() < $targetUser->getGroup()->getHierarchyLevel()) {
            throw new MissingPermissionException();
        }
        if (array_key_exists('name', $fieldsToUpdate)) {
            if (!$actor->hasPermission(Permission::USER_UPDATE_NAME)) {
                throw new MissingPermissionException(Permission::USER_UPDATE_NAME);
            }
        }
        if (array_key_exists('surname', $fieldsToUpdate)) {
            if (!$actor->hasPermission(Permission::USER_UPDATE_SURNAME)) {
                throw new MissingPermissionException(Permission::USER_UPDATE_SURNAME);
            }
        }
        if (array_key_exists('username', $fieldsToUpdate)) {
            if (!$actor->hasPermission(Permission::USER_UPDATE_USERNAME)) {
                throw new MissingPermissionException(Permission::USER_UPDATE_USERNAME);
            }
        }
        if (array_key_exists('group_id', $fieldsToUpdate)) {
            if (!$actor->hasPermission(Permission::USER_UPDATE_GROUP)) {
                throw new MissingPermissionException(Permission::USER_UPDATE_GROUP);
            }
        }
    }
}
